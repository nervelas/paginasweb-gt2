<?php
/**
 * Instalación desatendida para pruebas locales con SQLite.
 * Uso: php tools/instalar-local.php [url-base]
 * NO usar en producción: para producción está public/install.php
 */
$root = dirname(__DIR__);
$baseUrl = isset($argv[1]) ? rtrim($argv[1], '/') : 'http://localhost:8080';

$config = [
    'db' => [
        'driver'      => 'sqlite',
        'host'        => 'localhost',
        'port'        => 3306,
        'database'    => '',
        'username'    => '',
        'password'    => '',
        'charset'     => 'utf8mb4',
        'sqlite_path' => $root . '/storage/paginasweb.sqlite',
    ],
    'base_url' => $baseUrl,
    'env'      => 'development',
    'debug'    => true,
    'app_key'  => bin2hex(random_bytes(24)),
    'mail'     => [
        'driver' => 'mail', 'from_email' => 'info@paginasweb.gt', 'from_name' => 'paginasweb.gt',
        'smtp_host' => '', 'smtp_port' => 587, 'smtp_user' => '', 'smtp_pass' => '', 'smtp_secure' => 'tls',
    ],
];

@mkdir($root . '/storage', 0755, true);
@unlink($config['db']['sqlite_path']);
file_put_contents($root . '/config/config.php', "<?php\nreturn " . var_export($config, true) . ";\n");

define('APP_ROOT', $root);
define('APP_PATH', $root . '/app');
define('PUBLIC_PATH', $root . '/public');
require APP_PATH . '/polyfill.php';
spl_autoload_register(function ($class) {
    if (strpos($class, 'App\\') !== 0) { return; }
    $file = APP_PATH . '/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (is_file($file)) { require $file; }
});
require APP_PATH . '/helpers.php';
$GLOBALS['__app_config'] = $config;

use App\Core\Database;

Database::connect($config['db']);
Database::runSchema(file_get_contents($root . '/database/schema.sqlite.sql'));
require $root . '/database/seed.php';
$seeder = new Seeder($root . '/database/content');
foreach ($seeder->run() as $line) { echo "  - $line\n"; }

Database::insert('users', [
    'name' => 'Administrador', 'email' => 'admin@paginasweb.gt',
    'password_hash' => password_hash('PruebaLocal2026!', PASSWORD_DEFAULT),
    'role' => 'admin', 'active' => 1, 'must_change_password' => 1,
    'created_at' => date('Y-m-d H:i:s'),
]);
@file_put_contents($root . '/storage/instalado.lock', date('c'));
echo "Instalación local lista. Usuario: admin@paginasweb.gt / PruebaLocal2026!\n";
