<?php
/**
 * Punto de entrada del sitio público.
 */

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Controllers\SiteController;
use App\Core\Database;
use App\Core\Router;
use App\Core\Settings;
use App\Core\View;
use App\Models\Content;

$path = parse_url(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/', PHP_URL_PATH);
$path = '/' . ltrim(rawurldecode($path), '/');
$GLOBALS['__current_path'] = $path;

// Barra final obligatoria (excepto archivos con extensión)
if ($path !== '/' && substr($path, -1) !== '/' && strpos(basename($path), '.') === false) {
    header('Location: ' . $path . '/', true, 301);
    exit;
}

// Redirecciones 301 administradas desde el panel
$redirect = Content::redirect($path);
if ($redirect) {
    Database::run('UPDATE redirects SET hits = hits + 1 WHERE id = ?', [$redirect['id']]);
    header('Location: ' . $redirect['destination'], true, (int) $redirect['status_code']);
    exit;
}

// Variables compartidas con todas las vistas
View::share('menuHeader', Content::menu('header'));
View::share('menuServicios', Content::menu('footer_servicios'));
View::share('menuEmpresa', Content::menu('footer_empresa'));
View::share('menuLegal', Content::menu('footer_legal'));
View::share('settings', Settings::all());
View::share('currentPath', $path);

$controller = new SiteController();
$router     = new Router();

$router->get('/', function () use ($controller) {
    return $controller->page('');
});
$router->get('/blog/', function () use ($controller) {
    return $controller->blogIndex();
});
$router->get('/blog/categoria/{slug}/', function ($p) use ($controller) {
    return $controller->category($p['slug']);
});
$router->get('/blog/{slug}/', function ($p) use ($controller) {
    return $controller->post($p['slug']);
});
$router->get('/sitemap.xml', function () use ($controller) {
    return $controller->sitemap();
});
$router->get('/robots.txt', function () use ($controller) {
    return $controller->robots();
});
$router->post('/contacto/', function () use ($controller) {
    return $controller->contactSubmit();
});
$router->get('/{slug}/', function ($p) use ($controller) {
    return $controller->page($p['slug']);
});
$router->fallback(function () use ($controller) {
    return $controller->notFound();
});

$output = $router->dispatch(isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET', $path);
if ($output !== null) {
    echo $output;
}
