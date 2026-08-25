<?php
/**
 * Genera database/seed.sql a partir del contenido inicial, para quien prefiera
 * importar todo desde phpMyAdmin en lugar de usar el instalador.
 *
 * Uso: php tools/exportar-seed.php
 * Requiere que exista una instalación local (php tools/instalar-local.php).
 */

$root = dirname(__DIR__);
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

$configFile = $root . '/config/config.php';
if (!is_file($configFile)) {
    fwrite(STDERR, "Falta config/config.php. Ejecutá antes: php tools/instalar-local.php\n");
    exit(1);
}
$config = require $configFile;
$GLOBALS['__app_config'] = $config;

use App\Core\Database;

Database::connect($config['db']);

$tablas = [
    'settings', 'menu_items', 'services', 'plans', 'portfolio',
    'categories', 'pages', 'page_sections', 'faqs', 'posts',
];

/**
 * Escapado para MySQL. No se usa PDO::quote porque depende del controlador:
 * el de SQLite no escapa la barra invertida y MySQL sí la interpreta, lo que
 * rompería el JSON guardado en las secciones.
 */
function comillas_mysql($texto)
{
    $texto = str_replace(
        ['\\', "\0", "\n", "\r", "\x1a", "'", '"'],
        ['\\\\', '\\0', '\\n', '\\r', '\\Z', "\\'", '\\"'],
        $texto
    );
    return "'" . $texto . "'";
}

$salida = [];
$salida[] = '-- ---------------------------------------------------------------------------';
$salida[] = '-- paginasweb.gt — Contenido inicial';
$salida[] = '-- Generado por tools/exportar-seed.php';
$salida[] = '--';
$salida[] = '-- Importá primero database/schema.sql y después este archivo.';
$salida[] = '-- No incluye usuarios: el administrador se crea desde public/install.php.';
$salida[] = '-- ---------------------------------------------------------------------------';
$salida[] = '';
$salida[] = 'SET NAMES utf8mb4;';
$salida[] = 'SET FOREIGN_KEY_CHECKS = 0;';
$salida[] = '';

$total = 0;
foreach ($tablas as $tabla) {
    $filas = Database::all('SELECT * FROM ' . $tabla . ' ORDER BY id');
    if (!$filas) {
        continue;
    }
    $salida[] = '-- ' . str_pad(strtoupper($tabla) . ' ', 74, '-');
    $salida[] = 'DELETE FROM ' . $tabla . ';';

    $columnas = array_keys($filas[0]);
    foreach (array_chunk($filas, 25) as $grupo) {
        $valores = [];
        foreach ($grupo as $fila) {
            $celdas = [];
            foreach ($columnas as $col) {
                $v = $fila[$col];
                if ($v === null) {
                    $celdas[] = 'NULL';
                } elseif (is_int($v) || is_float($v)) {
                    $celdas[] = (string) $v;
                } elseif (is_numeric($v) && (string) (float) $v === (string) $v) {
                    $celdas[] = (string) $v;
                } else {
                    $celdas[] = comillas_mysql((string) $v);
                }
            }
            $valores[] = '  (' . implode(', ', $celdas) . ')';
        }
        $salida[] = 'INSERT INTO ' . $tabla . ' (' . implode(', ', $columnas) . ') VALUES';
        $salida[] = implode(",\n", $valores) . ';';
    }
    $salida[] = '';
    $total += count($filas);
    printf("  %-16s %4d registros\n", $tabla, count($filas));
}

$salida[] = 'SET FOREIGN_KEY_CHECKS = 1;';
$salida[] = '';

file_put_contents($root . '/database/seed.sql', implode("\n", $salida));
echo "Generado database/seed.sql con {$total} registros (" . round(filesize($root . '/database/seed.sql') / 1024) . " KB)\n";
