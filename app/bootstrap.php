<?php
/**
 * Arranque de la aplicación: autoload, configuración, base de datos y vistas.
 */

define('APP_ROOT', dirname(__DIR__));
define('APP_PATH', APP_ROOT . '/app');
define('PUBLIC_PATH', APP_ROOT . '/public');

require APP_PATH . '/polyfill.php';

spl_autoload_register(static function ($class) {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    $file = APP_PATH . '/' . str_replace('\\', '/', $relative) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

require APP_PATH . '/helpers.php';

$configFile = APP_ROOT . '/config/config.php';
if (!is_file($configFile)) {
    if (is_file(PUBLIC_PATH . '/install.php')) {
        header('Location: /install.php');
        exit;
    }
    http_response_code(500);
    exit('Falta config/config.php. Copiá config/config.sample.php y ajustá los datos.');
}

$config = require $configFile;
$GLOBALS['__app_config'] = $config;

if (!empty($config['debug'])) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
}

date_default_timezone_set('America/Guatemala');
mb_internal_encoding('UTF-8');

use App\Core\Database;
use App\Core\Settings;
use App\Core\View;
use App\Core\Auth;

try {
    Database::connect($config['db']);
} catch (Throwable $e) {
    if (is_file(PUBLIC_PATH . '/install.php')) {
        header('Location: /install.php?error=db');
        exit;
    }
    http_response_code(503);
    exit('No se pudo conectar a la base de datos.');
}

if (!Database::tableExists('settings')) {
    if (is_file(PUBLIC_PATH . '/install.php')) {
        header('Location: /install.php');
        exit;
    }
    http_response_code(503);
    exit('La base de datos no está instalada.');
}

View::setBasePath(APP_PATH . '/Views');
Settings::load();
Auth::startSession($config);
