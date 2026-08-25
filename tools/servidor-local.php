<?php
/**
 * Router para el servidor de pruebas de PHP. Imita lo que hace .htaccess en
 * producción: sirve los archivos que existen y manda todo lo demás al
 * controlador que corresponda.
 *
 * Uso: php -S 127.0.0.1:8080 -t public tools/servidor-local.php
 */

$ruta = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$archivo = __DIR__ . '/../public' . $ruta;

// Archivo real (css, js, imágenes, install.php): que lo sirva el servidor.
if ($ruta !== '/' && is_file($archivo)) {
    return false;
}

if (strpos($ruta, '/admin') === 0) {
    require __DIR__ . '/../public/admin/index.php';
    return true;
}

require __DIR__ . '/../public/index.php';
return true;
