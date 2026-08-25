<?php
/**
 * Punto de entrada del panel de administración.
 */

require dirname(dirname(__DIR__)) . '/app/bootstrap.php';

use App\Controllers\AdminController;
use App\Core\Auth;
use App\Core\Router;
use App\Core\View;

header('X-Robots-Tag: noindex, nofollow', true);

$path = parse_url(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/admin/', PHP_URL_PATH);
$path = '/' . ltrim(rawurldecode($path), '/');
if (substr($path, -1) !== '/') {
    header('Location: ' . $path . '/', true, 301);
    exit;
}
$GLOBALS['__current_path'] = $path;
View::share('currentPath', $path);

$admin  = new AdminController();
$router = new Router();

$router->any('/admin/entrar/', function () use ($admin) {
    return $admin->login();
});

$publicas = ['/admin/entrar/'];
if (!in_array($path, $publicas, true)) {
    Auth::requireLogin('/admin/entrar/');
    // Mientras no cambie la contraseña inicial, solo puede usar su cuenta.
    if (!empty($_SESSION['must_change_password']) && $path !== '/admin/cuenta/' && $path !== '/admin/salir/') {
        \redirect('/admin/cuenta/');
    }
}

$router->get('/admin/', function () use ($admin) {
    return $admin->dashboard();
});
$router->get('/admin/salir/', function () use ($admin) {
    return $admin->logout();
});
$router->any('/admin/cuenta/', function () use ($admin) {
    return $admin->cuenta();
});
$router->any('/admin/configuracion/', function () use ($admin) {
    return $admin->configuracion();
});
$router->any('/admin/medios/', function () use ($admin) {
    return $admin->medios();
});
$router->any('/admin/mensajes/', function () use ($admin) {
    return $admin->mensajes();
});
$router->get('/admin/mensajes/{id}/', function ($p) use ($admin) {
    return $admin->mensajes((int) $p['id']);
});
$router->any('/admin/herramientas/', function () use ($admin) {
    return $admin->herramientas();
});
$router->any('/admin/secciones/{id}/', function ($p) use ($admin) {
    return $admin->seccion((int) $p['id']);
});
$router->post('/admin/{recurso}/{id}/borrar/', function ($p) use ($admin) {
    return $admin->borrar($p['recurso'], (int) $p['id']);
});
$router->any('/admin/{recurso}/nuevo/', function ($p) use ($admin) {
    return $admin->editar($p['recurso'], null);
});
$router->any('/admin/{recurso}/{id}/', function ($p) use ($admin) {
    return $admin->editar($p['recurso'], (int) $p['id']);
});
$router->get('/admin/{recurso}/', function ($p) use ($admin) {
    return $admin->lista($p['recurso']);
});
$router->fallback(function () {
    http_response_code(404);
    echo '<p style="font:16px system-ui;padding:40px">Pantalla no encontrada. <a href="/admin/">Volver al panel</a></p>';
    return null;
});

$salida = $router->dispatch(isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET', $path);
if ($salida !== null) {
    echo $salida;
}
