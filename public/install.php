<?php
/**
 * Instalador de paginasweb.gt
 * 1. Verifica versión de PHP y extensiones.
 * 2. Crea las tablas y el contenido inicial.
 * 3. Crea el usuario administrador.
 * 4. Genera config/config.php y se autodeshabilita.
 */

define('APP_ROOT', dirname(__DIR__));
define('APP_PATH', APP_ROOT . '/app');
define('PUBLIC_PATH', __DIR__);

require APP_PATH . '/polyfill.php';

spl_autoload_register(function ($class) {
    if (strpos($class, 'App\\') !== 0) {
        return;
    }
    $file = APP_PATH . '/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (is_file($file)) {
        require $file;
    }
});
require APP_PATH . '/helpers.php';

use App\Core\Database;

$lockFile   = APP_ROOT . '/storage/instalado.lock';
$configFile = APP_ROOT . '/config/config.php';

// El instalador solo puede correr una vez. Se bloquea con el candado y también
// con la sola existencia de config/config.php, para que nadie pueda reinstalar
// el sitio (y quedarse con el usuario administrador) borrando un archivo.
if (is_file($lockFile) || is_file($configFile)) {
    http_response_code(403);
    exit('El sitio ya está instalado. Borrá public/install.php del servidor. Si de verdad necesitás reinstalar, eliminá storage/instalado.lock y config/config.php desde el administrador de archivos de cPanel.');
}

// --------------------------------------------------------------- requisitos
function requisitos()
{
    $gd = extension_loaded('gd') || extension_loaded('imagick');
    return [
        ['nombre' => 'PHP 7.4 o superior', 'ok' => PHP_VERSION_ID >= 70400, 'detalle' => 'Detectado: ' . PHP_VERSION, 'critico' => true],
        ['nombre' => 'Extensión pdo', 'ok' => extension_loaded('pdo'), 'detalle' => 'Acceso a la base de datos', 'critico' => true],
        ['nombre' => 'Extensión pdo_mysql', 'ok' => extension_loaded('pdo_mysql'), 'detalle' => 'Necesaria para MySQL (opcional si usás SQLite)', 'critico' => false],
        ['nombre' => 'Extensión pdo_sqlite', 'ok' => extension_loaded('pdo_sqlite'), 'detalle' => 'Solo si vas a usar SQLite', 'critico' => false],
        ['nombre' => 'Extensión mbstring', 'ok' => extension_loaded('mbstring'), 'detalle' => 'Manejo de tildes y caracteres especiales', 'critico' => true],
        ['nombre' => 'Extensión json', 'ok' => extension_loaded('json'), 'detalle' => 'Datos estructurados y configuración', 'critico' => true],
        ['nombre' => 'GD o Imagick', 'ok' => $gd, 'detalle' => 'Redimensionar imágenes y generar WebP', 'critico' => false],
        ['nombre' => 'Soporte WebP', 'ok' => function_exists('imagewebp'), 'detalle' => 'Si falta, las imágenes se guardan en JPG', 'critico' => false],
        ['nombre' => 'config/ con permiso de escritura', 'ok' => is_writable(APP_ROOT . '/config'), 'detalle' => APP_ROOT . '/config', 'critico' => true],
        ['nombre' => 'storage/ con permiso de escritura', 'ok' => is_dir(APP_ROOT . '/storage') && is_writable(APP_ROOT . '/storage'), 'detalle' => APP_ROOT . '/storage', 'critico' => true],
        ['nombre' => 'public/uploads/ con permiso de escritura', 'ok' => is_dir(PUBLIC_PATH . '/uploads') && is_writable(PUBLIC_PATH . '/uploads'), 'detalle' => PUBLIC_PATH . '/uploads', 'critico' => true],
    ];
}

$reqs = requisitos();
$bloqueado = false;
foreach ($reqs as $r) {
    if ($r['critico'] && !$r['ok']) {
        $bloqueado = true;
    }
}

$errores = [];
$listo   = false;
$datos   = [
    'driver'     => 'mysql',
    'host'       => 'localhost',
    'port'       => '3306',
    'database'   => '',
    'username'   => '',
    'password'   => '',
    'base_url'   => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'paginasweb.gt'),
    'admin_name'  => '',
    'admin_email' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$bloqueado) {
    foreach (array_keys($datos) as $k) {
        if (isset($_POST[$k])) {
            $datos[$k] = trim($_POST[$k]);
        }
    }
    $adminPass  = isset($_POST['admin_password']) ? $_POST['admin_password'] : '';
    $adminPass2 = isset($_POST['admin_password2']) ? $_POST['admin_password2'] : '';

    if ($datos['driver'] === 'mysql' && $datos['database'] === '') {
        $errores[] = 'Indicá el nombre de la base de datos.';
    }
    if ($datos['base_url'] === '' || strpos($datos['base_url'], 'http') !== 0) {
        $errores[] = 'La dirección del sitio debe empezar con http:// o https://';
    }
    if (!filter_var($datos['admin_email'], FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'El correo del administrador no es válido.';
    }
    if ($datos['admin_name'] === '') {
        $errores[] = 'Indicá el nombre del administrador.';
    }
    if (strlen($adminPass) < 10) {
        $errores[] = 'La contraseña debe tener al menos 10 caracteres.';
    }
    if ($adminPass !== $adminPass2) {
        $errores[] = 'Las dos contraseñas no coinciden.';
    }

    if (!$errores) {
        $dbConfig = [
            'driver'      => $datos['driver'],
            'host'        => $datos['host'],
            'port'        => (int) $datos['port'],
            'database'    => $datos['database'],
            'username'    => $datos['username'],
            'password'    => $datos['password'],
            'charset'     => 'utf8mb4',
            'sqlite_path' => APP_ROOT . '/storage/paginasweb.sqlite',
        ];
        try {
            Database::connect($dbConfig);

            $schemaFile = $datos['driver'] === 'sqlite'
                ? APP_ROOT . '/database/schema.sqlite.sql'
                : APP_ROOT . '/database/schema.sql';
            Database::runSchema(file_get_contents($schemaFile));

            require APP_ROOT . '/database/seed.php';
            $seeder = new Seeder(APP_ROOT . '/database/content');
            $resumen = $seeder->run();

            // Usuario administrador
            $existe = Database::value('SELECT COUNT(*) FROM users WHERE email = ?', [mb_strtolower($datos['admin_email'])]);
            if (!$existe) {
                Database::insert('users', [
                    'name'                 => $datos['admin_name'],
                    'email'                => mb_strtolower($datos['admin_email']),
                    'password_hash'        => password_hash($adminPass, PASSWORD_DEFAULT),
                    'role'                 => 'admin',
                    'active'               => 1,
                    'must_change_password' => 0,
                    'created_at'           => date('Y-m-d H:i:s'),
                ]);
            }

            // Ajustes que dependen de la instalación
            \App\Core\Settings::set('email', $datos['admin_email'] === '' ? 'info@servicom.gt' : \App\Core\Settings::get('email', 'info@servicom.gt'));

            // Archivo de configuración
            $config = "<?php\n// Generado por el instalador el " . date('Y-m-d H:i') . "\nreturn " . var_export([
                'db'       => $dbConfig,
                'base_url' => rtrim($datos['base_url'], '/'),
                'env'      => 'production',
                'debug'    => false,
                'app_key'  => bin2hex(random_bytes(24)),
                'mail'     => [
                    'driver'      => 'mail',
                    'from_email'  => 'info@' . preg_replace('#^https?://(www\.)?#', '', rtrim($datos['base_url'], '/')),
                    'from_name'   => 'paginasweb.gt',
                    'smtp_host'   => '',
                    'smtp_port'   => 587,
                    'smtp_user'   => '',
                    'smtp_pass'   => '',
                    'smtp_secure' => 'tls',
                ],
            ], true) . ";\n";

            if (@file_put_contents($configFile, $config) === false) {
                throw new RuntimeException('No se pudo escribir config/config.php. Revisá los permisos de la carpeta config/.');
            }

            @file_put_contents($lockFile, date('c') . " instalado\n");
            @chmod($configFile, 0640);
            $listo = true;
        } catch (Throwable $e) {
            $errores[] = 'Error durante la instalación: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es-GT">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Instalador · paginasweb.gt</title>
<style>
  :root{--ink:#0A1F2C;--brand:#12796B;--accent:#FF7A45;--paper:#F7F3EC;--line:#DDD6CA}
  *{box-sizing:border-box}
  body{margin:0;background:var(--paper);color:var(--ink);font:16px/1.6 system-ui,-apple-system,"Segoe UI",Roboto,sans-serif}
  .wrap{max-width:720px;margin:0 auto;padding:32px 20px 64px}
  h1{font-size:1.6rem;margin:0 0 4px}
  .sub{color:#5b6b74;margin:0 0 28px}
  .card{background:#fff;border:1px solid var(--line);border-radius:14px;padding:24px;margin-bottom:20px}
  h2{font-size:1.05rem;margin:0 0 14px}
  table{width:100%;border-collapse:collapse;font-size:.92rem}
  td{padding:7px 0;border-bottom:1px solid #eee;vertical-align:top}
  td:last-child{text-align:right;white-space:nowrap}
  .ok{color:#12796B;font-weight:600}
  .no{color:#C0392B;font-weight:600}
  .warn{color:#B8860B;font-weight:600}
  .det{display:block;color:#7a8891;font-size:.82rem}
  label{display:block;font-weight:600;font-size:.88rem;margin:14px 0 5px}
  input,select{width:100%;padding:11px 12px;border:1px solid var(--line);border-radius:9px;font:inherit;background:#fff}
  input:focus,select:focus{outline:2px solid var(--brand);outline-offset:1px}
  .grid{display:grid;grid-template-columns:1fr 1fr;gap:0 16px}
  button{margin-top:22px;width:100%;padding:14px;border:0;border-radius:10px;background:var(--accent);color:#fff;font:600 1rem/1 inherit;cursor:pointer}
  button:hover{filter:brightness(.94)}
  .err{background:#FDECEA;border:1px solid #F5C6C0;color:#8B2018;padding:14px 16px;border-radius:10px;margin-bottom:18px}
  .err ul{margin:6px 0 0;padding-left:20px}
  .done{background:#E8F5F1;border:1px solid #A9D9CE;padding:18px;border-radius:10px}
  code{background:#F0EDE6;padding:2px 6px;border-radius:5px;font-size:.88em}
  ol{padding-left:20px}
  @media(max-width:560px){.grid{grid-template-columns:1fr}}
</style>
</head>
<body>
<div class="wrap">
  <h1>Instalador de paginasweb.gt</h1>
  <p class="sub">Tres minutos y el sitio queda funcionando con todo su contenido.</p>

<?php if ($listo): ?>
  <div class="card">
    <h2>Instalación terminada</h2>
    <div class="done">
      <p><strong>Listo.</strong> Se creó la base de datos, se cargó el contenido inicial y se generó <code>config/config.php</code>.</p>
      <ul>
        <?php foreach ($resumen as $linea): ?><li><?php echo e($linea); ?></li><?php endforeach; ?>
      </ul>
    </div>
    <h2 style="margin-top:22px">Lo que falta hacer ahora</h2>
    <ol>
      <li><strong>Borrá el archivo <code>public/install.php</code></strong> del servidor. Ya quedó bloqueado, pero es mejor eliminarlo.</li>
      <li>Entrá al panel en <a href="/admin/">/admin/</a> con el correo y la contraseña que acabás de definir.</li>
      <li>Revisá <em>Configuración</em>: teléfono, WhatsApp, correo, horario y códigos de analítica.</li>
      <li>Verificá que el sitio abra con HTTPS.</li>
    </ol>
    <p style="margin-top:18px"><a href="/">Ver el sitio</a> · <a href="/admin/">Ir al panel</a></p>
  </div>
<?php else: ?>

  <div class="card">
    <h2>1. Requisitos del servidor</h2>
    <table>
      <?php foreach ($reqs as $r): ?>
      <tr>
        <td><?php echo e($r['nombre']); ?><span class="det"><?php echo e($r['detalle']); ?></span></td>
        <td class="<?php echo $r['ok'] ? 'ok' : ($r['critico'] ? 'no' : 'warn'); ?>">
          <?php echo $r['ok'] ? 'OK' : ($r['critico'] ? 'Falta' : 'Opcional'); ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>
    <?php if ($bloqueado): ?>
      <p class="err" style="margin-top:16px">Faltan requisitos obligatorios. En cPanel podés cambiar la versión de PHP y activar extensiones desde <em>Select PHP Version</em>.</p>
    <?php endif; ?>
  </div>

  <?php if (!$bloqueado): ?>
  <form method="post" class="card" autocomplete="off">
    <h2>2. Base de datos y administrador</h2>
    <?php if ($errores): ?>
      <div class="err"><strong>Revisá esto:</strong><ul><?php foreach ($errores as $err): ?><li><?php echo e($err); ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>

    <label for="driver">Motor de base de datos</label>
    <select name="driver" id="driver">
      <option value="mysql" <?php echo $datos['driver'] === 'mysql' ? 'selected' : ''; ?>>MySQL / MariaDB (recomendado en cPanel)</option>
      <option value="sqlite" <?php echo $datos['driver'] === 'sqlite' ? 'selected' : ''; ?>>SQLite (solo para pruebas)</option>
    </select>

    <div class="grid">
      <div><label for="host">Servidor</label><input type="text" name="host" id="host" value="<?php echo e($datos['host']); ?>"></div>
      <div><label for="port">Puerto</label><input type="text" name="port" id="port" value="<?php echo e($datos['port']); ?>"></div>
    </div>
    <label for="database">Nombre de la base de datos</label>
    <input type="text" name="database" id="database" value="<?php echo e($datos['database']); ?>" placeholder="usuario_paginasweb">
    <div class="grid">
      <div><label for="username">Usuario</label><input type="text" name="username" id="username" value="<?php echo e($datos['username']); ?>"></div>
      <div><label for="password">Contraseña</label><input type="password" name="password" id="password" value=""></div>
    </div>

    <label for="base_url">Dirección del sitio</label>
    <input type="text" name="base_url" id="base_url" value="<?php echo e($datos['base_url']); ?>" placeholder="https://paginasweb.gt">

    <label for="admin_name">Tu nombre</label>
    <input type="text" name="admin_name" id="admin_name" value="<?php echo e($datos['admin_name']); ?>">
    <label for="admin_email">Tu correo (será tu usuario)</label>
    <input type="email" name="admin_email" id="admin_email" value="<?php echo e($datos['admin_email']); ?>">
    <div class="grid">
      <div><label for="admin_password">Contraseña (mínimo 10 caracteres)</label><input type="password" name="admin_password" id="admin_password"></div>
      <div><label for="admin_password2">Repetir contraseña</label><input type="password" name="admin_password2" id="admin_password2"></div>
    </div>

    <button type="submit">Instalar el sitio</button>
  </form>
  <?php endif; ?>
<?php endif; ?>
</div>
</body>
</html>
