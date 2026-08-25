<?php
/**
 * Prueba automática del panel y de los formularios públicos.
 * Uso: php tools/probar-panel.php http://127.0.0.1:8080 correo contraseña
 */
$base  = isset($argv[1]) ? rtrim($argv[1], '/') : 'http://127.0.0.1:8080';
$email = isset($argv[2]) ? $argv[2] : 'admin@paginasweb.gt';
$clave = isset($argv[3]) ? $argv[3] : 'ClaveNuevaSegura2026';
$cookie = tempnam(sys_get_temp_dir(), 'pwgt');

$fallas = 0;

function http($url, $post = null, $cookie = null, $seguir = false)
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => $seguir,
        CURLOPT_COOKIEJAR      => $cookie,
        CURLOPT_COOKIEFILE     => $cookie,
        CURLOPT_TIMEOUT        => 25,
    ]);
    if ($post !== null) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    }
    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['code' => $code, 'body' => (string) $body];
}

function token($html)
{
    return preg_match('/name="_token" value="([^"]+)"/', $html, $m) ? $m[1] : '';
}

function comprobar($condicion, $texto, &$fallas)
{
    echo ($condicion ? '  OK    ' : '  FALLA ') . $texto . "\n";
    if (!$condicion) { $fallas++; }
}

echo "\n=== PRUEBA DEL PANEL ===\n\n-- Acceso --\n";

// Sesión aparte para probar el rechazo, sin ensuciar la sesión buena.
$cookieMalo = tempnam(sys_get_temp_dir(), 'pwgtx');
$r = http($base . '/admin/entrar/', null, $cookieMalo);
$r2 = http($base . '/admin/entrar/', ['_token' => token($r['body']), 'email' => $email, 'password' => 'clave-incorrecta'], $cookieMalo);
comprobar($r2['code'] === 200 && stripos($r2['body'], 'incorrectos') !== false, 'Rechaza credenciales incorrectas', $fallas);
$r2 = http($base . '/admin/', null, $cookieMalo);
comprobar($r2['code'] === 302, 'Sin sesión válida no se entra al panel', $fallas);
@unlink($cookieMalo);

$r = http($base . '/admin/entrar/', null, $cookie);
$r = http($base . '/admin/entrar/', ['_token' => token($r['body']), 'email' => $email, 'password' => $clave], $cookie);
comprobar($r['code'] === 302, 'Ingreso con credenciales correctas', $fallas);

$r = http($base . '/admin/', null, $cookie);
comprobar($r['code'] === 200 && strpos($r['body'], 'Escritorio') !== false, 'Escritorio accesible', $fallas);

echo "\n-- CSRF --\n";
$r = http($base . '/admin/configuracion/', ['site_name' => 'Intento sin token'], $cookie);
comprobar($r['code'] === 419, 'Un envío sin token CSRF se rechaza con 419', $fallas);

echo "\n-- Crear, editar y borrar un artículo --\n";
$r = http($base . '/admin/blog/nuevo/', null, $cookie);
$datos = [
    '_token' => token($r['body']),
    'title' => 'Artículo de prueba automática',
    'slug' => 'articulo-de-prueba-automatica',
    'excerpt' => 'Resumen de prueba.',
    'body' => '<p>Contenido de prueba.</p><script>alert(1)</script>',
    'image' => '', 'image_alt' => '', 'author' => 'Pruebas',
    'published_at' => date('Y-m-d\TH:i'),
    'meta_title' => 'Artículo de prueba',
    'meta_description' => 'Descripción de prueba.',
    'category_id' => '', 'robots_index' => '1', 'visible' => '1',
];
$r = http($base . '/admin/blog/nuevo/', $datos, $cookie);
comprobar($r['code'] === 302, 'Se crea el artículo', $fallas);

$r = http($base . '/blog/articulo-de-prueba-automatica/', null, $cookie);
comprobar($r['code'] === 200, 'El artículo se ve en el sitio', $fallas);
comprobar(strpos($r['body'], 'alert(1)') === false, 'El script inyectado fue eliminado al guardar', $fallas);

// Buscar su id en el listado
$r = http($base . '/admin/blog/', null, $cookie);
preg_match('#/admin/blog/(\d+)/"[^>]*>\s*Artículo de prueba#u', $r['body'], $m);
$id = isset($m[1]) ? (int) $m[1] : 0;
comprobar($id > 0, 'El artículo aparece en el listado', $fallas);

if ($id) {
    $r = http($base . '/admin/blog/' . $id . '/', null, $cookie);
    $datos['_token'] = token($r['body']);
    $datos['title'] = 'Artículo editado por la prueba';
    $r = http($base . '/admin/blog/' . $id . '/', $datos, $cookie);
    comprobar($r['code'] === 302, 'Se edita el artículo', $fallas);

    $r = http($base . '/admin/blog/', null, $cookie);
    $r = http($base . '/admin/blog/' . $id . '/borrar/', ['_token' => token($r['body'])], $cookie);
    comprobar($r['code'] === 302, 'Se borra el artículo', $fallas);
    $r = http($base . '/blog/articulo-de-prueba-automatica/', null, $cookie);
    comprobar($r['code'] === 404, 'El artículo borrado devuelve 404', $fallas);
}

echo "\n-- Validación de campos --\n";
$r = http($base . '/admin/blog/nuevo/', null, $cookie);
$r = http($base . '/admin/blog/nuevo/', ['_token' => token($r['body']), 'title' => '', 'slug' => ''], $cookie);
comprobar($r['code'] === 200 && strpos($r['body'], 'obligatorio') !== false, 'Un campo obligatorio vacío muestra el error', $fallas);

echo "\n-- Configuración --\n";
$r = http($base . '/admin/configuracion/', null, $cookie);
$r = http($base . '/admin/configuracion/', ['_token' => token($r['body']), 'site_tagline' => 'Frase de prueba automática'], $cookie);
comprobar($r['code'] === 302, 'Se guarda la configuración', $fallas);

echo "\n-- Redirecciones 301 --\n";
$r = http($base . '/admin/redirecciones/nuevo/', null, $cookie);
$r = http($base . '/admin/redirecciones/nuevo/', [
    '_token' => token($r['body']), 'source' => '/pagina-vieja-de-prueba/',
    'destination' => '/precios/', 'status_code' => '301',
], $cookie);
comprobar($r['code'] === 302, 'Se crea la redirección', $fallas);
$r = http($base . '/pagina-vieja-de-prueba/', null, $cookie);
comprobar($r['code'] === 301, 'La redirección responde 301', $fallas);

echo "\n-- Sección de una página --\n";
$r = http($base . '/admin/secciones/1/', null, $cookie);
comprobar($r['code'] === 200, 'La pantalla de sección carga', $fallas);
$r = http($base . '/admin/secciones/1/', [
    '_token' => token($r['body']), 'eyebrow' => 'Prueba', 'heading' => 'Encabezado de prueba',
    'subheading' => '', 'body' => '', 'image' => '', 'image_alt' => '', 'cta_text' => '', 'cta_url' => '',
    'extra' => '{ esto no es json }', 'sort_order' => '1', 'visible' => '1',
], $cookie);
comprobar(strpos($r['body'], 'JSON válido') !== false, 'Rechaza un JSON mal formado sin romper la página', $fallas);

echo "\n-- Formulario público de contacto --\n";
$r = http($base . '/contacto/', null, $cookie);
$tk = token($r['body']);
$r = http($base . '/contacto/', [
    '_token' => $tk, 'name' => 'Prueba Automática', 'email' => 'prueba@ejemplo.com',
    'phone' => '5555-5555', 'service' => 'paginas-web',
    'message' => 'Este es un mensaje de prueba enviado por el verificador.',
    'website' => '', 'page' => '/contacto/',
], $cookie);
comprobar($r['code'] === 302, 'El formulario acepta un envío válido', $fallas);

$r = http($base . '/contacto/', null, $cookie);
$r = http($base . '/contacto/', ['_token' => token($r['body']), 'name' => 'X', 'email' => 'no-es-correo', 'message' => 'corto'], $cookie);
comprobar($r['code'] === 302, 'El formulario rechaza datos inválidos y regresa', $fallas);
$r = http($base . '/contacto/', null, $cookie);
comprobar(strpos($r['body'], 'Revisá tu correo electrónico') !== false, 'Muestra los errores de validación', $fallas);

$r = http($base . '/contacto/', null, $cookie);
$r = http($base . '/contacto/', [
    '_token' => token($r['body']), 'name' => 'Robot', 'email' => 'robot@ejemplo.com',
    'message' => 'Mensaje de un robot automatizado.', 'website' => 'http://spam.example',
], $cookie);
comprobar($r['code'] === 302, 'La trampa para robots descarta el envío en silencio', $fallas);

$r = http($base . '/contacto/', ['name' => 'Sin token', 'email' => 'x@y.com', 'message' => 'Mensaje sin token de seguridad.'], $cookie);
comprobar($r['code'] === 419, 'El formulario sin token CSRF se rechaza', $fallas);

echo "\n-- Bandeja de mensajes --\n";
$r = http($base . '/admin/mensajes/', null, $cookie);
comprobar(strpos($r['body'], 'Prueba Automática') !== false, 'El mensaje llegó a la bandeja', $fallas);
comprobar(strpos($r['body'], 'Robot') === false, 'El mensaje del robot no se guardó', $fallas);

echo "\n-- Cierre de sesión --\n";
$r = http($base . '/admin/salir/', null, $cookie);
$r = http($base . '/admin/paginas/', null, $cookie);
comprobar($r['code'] === 302, 'Tras salir, el panel exige volver a entrar', $fallas);

@unlink($cookie);
echo "\n=== RESUMEN DEL PANEL ===\nFallas: {$fallas}\n\n";
exit($fallas > 0 ? 1 : 0);
