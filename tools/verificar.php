<?php
/**
 * Verificación del sitio: SEO en página, estructura, schema y anti-penalización.
 * Uso: php tools/verificar.php [http://127.0.0.1:8080]
 */

$base = isset($argv[1]) ? rtrim($argv[1], '/') : 'http://127.0.0.1:8080';
$root = dirname(__DIR__);

$rutas = [
    '/', '/diseno-de-paginas-web-guatemala/', '/tiendas-virtuales-guatemala/', '/precios/',
    '/cuentas-de-correo-corporativo/', '/portafolio/', '/nosotros/', '/preguntas-frecuentes/',
    '/contacto/', '/blog/', '/terminos-y-condiciones/', '/politica-de-privacidad/',
    '/blog/cuanto-cuesta-una-pagina-web-en-guatemala/',
    '/blog/como-crear-tienda-en-linea-guatemala/',
    '/blog/woocommerce-vs-shopify-guatemala/',
    '/blog/como-cobrar-con-tarjeta-sitio-web-guatemala/',
    '/blog/dominio-gt-como-registrarlo/',
    '/blog/errores-al-contratar-diseno-web-guatemala/',
];

$minPalabras = [
    '/' => 1000,
    '/diseno-de-paginas-web-guatemala/' => 900,
    '/tiendas-virtuales-guatemala/' => 900,
];

$fallas = 0;
$avisos = 0;
$titulosVistos = [];
$descVistas = [];
$imagenesFaltantes = [];

function fetch($url)
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_TIMEOUT        => 20,
        CURLOPT_USERAGENT      => 'verificador-paginasweb.gt',
    ]);
    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$code, (string) $body];
}

function texto_visible($html)
{
    $html = preg_replace('#<(script|style|template)[^>]*>.*?</\1>#is', ' ', $html);
    $html = preg_replace('#<!--.*?-->#s', ' ', $html);
    return trim(preg_replace('/\s+/u', ' ', strip_tags($html)));
}

function contar_palabras($texto)
{
    return count(preg_split('/[^\p{L}\p{N}\'’\-]+/u', $texto, -1, PREG_SPLIT_NO_EMPTY));
}

function densidad($texto, $frase)
{
    $total = contar_palabras($texto);
    if ($total === 0) {
        return 0.0;
    }
    $palabrasFrase = contar_palabras($frase);
    $n = preg_match_all('/' . preg_quote($frase, '/') . '/iu', $texto);
    return $total > 0 ? ($n * $palabrasFrase / $total) * 100 : 0.0;
}

function linea($estado, $texto)
{
    $etiquetas = ['ok' => '  OK   ', 'fail' => '  FALLA', 'warn' => '  AVISO'];
    echo $etiquetas[$estado] . '  ' . $texto . "\n";
}

echo "\n=== VERIFICACIÓN DE paginasweb.gt ===\n";
echo "Base: {$base}\n\n";

// ------------------------------------------------------------ 1. Rutas y SEO
echo "-- 1. Rutas, metadatos y estructura --\n";
$paginas = [];

foreach ($rutas as $ruta) {
    list($code, $html) = fetch($base . $ruta);
    if ($code !== 200) {
        linea('fail', "{$ruta} devolvió HTTP {$code}");
        $fallas++;
        continue;
    }
    $paginas[$ruta] = $html;

    preg_match('#<title>(.*?)</title>#si', $html, $mt);
    $titulo = isset($mt[1]) ? html_entity_decode(trim($mt[1]), ENT_QUOTES, 'UTF-8') : '';
    preg_match('#<meta name="description" content="(.*?)"#si', $html, $md);
    $desc = isset($md[1]) ? html_entity_decode($md[1], ENT_QUOTES, 'UTF-8') : '';
    preg_match_all('#<h1[\s>]#i', $html, $mh1);
    $n_h1 = count($mh1[0]);
    $texto = texto_visible($html);
    $palabras = contar_palabras($texto);

    $problemas = [];
    if ($titulo === '')                 { $problemas[] = 'sin title'; }
    if (mb_strlen($titulo) > 60)        { $problemas[] = 'title de ' . mb_strlen($titulo) . ' caracteres (máx 60)'; }
    if ($desc === '')                   { $problemas[] = 'sin meta description'; }
    if (mb_strlen($desc) > 155)         { $problemas[] = 'description de ' . mb_strlen($desc) . ' caracteres (máx 155)'; }
    if ($n_h1 !== 1)                    { $problemas[] = "{$n_h1} etiquetas H1"; }
    if (!preg_match('#rel="canonical"#i', $html)) { $problemas[] = 'sin canonical'; }
    if (!preg_match('#property="og:image"#i', $html)) { $problemas[] = 'sin og:image'; }
    if (!preg_match('#hreflang="es-gt"#i', $html)) { $problemas[] = 'sin hreflang es-GT'; }

    if (isset($titulosVistos[$titulo])) { $problemas[] = 'title duplicado con ' . $titulosVistos[$titulo]; }
    $titulosVistos[$titulo] = $ruta;
    if (isset($descVistas[$desc]))      { $problemas[] = 'description duplicada con ' . $descVistas[$desc]; }
    $descVistas[$desc] = $ruta;

    if (isset($minPalabras[$ruta]) && $palabras < $minPalabras[$ruta]) {
        $problemas[] = "solo {$palabras} palabras (mínimo {$minPalabras[$ruta]})";
    }
    if (strpos($ruta, '/blog/') === 0 && $ruta !== '/blog/' && $palabras < 1200) {
        $problemas[] = "artículo con {$palabras} palabras (mínimo 1200)";
    }

    // Imágenes sin alt o sin dimensiones
    preg_match_all('#<img\b[^>]*>#i', $html, $imgs);
    foreach ($imgs[0] as $img) {
        if (!preg_match('#\balt\s*=#i', $img))    { $problemas[] = 'imagen sin alt'; break; }
    }
    foreach ($imgs[0] as $img) {
        if (!preg_match('#\bwidth\s*=#i', $img) || !preg_match('#\bheight\s*=#i', $img)) {
            $problemas[] = 'imagen sin width/height (riesgo de CLS)'; break;
        }
    }
    // Archivos de imagen existentes
    preg_match_all('#<img\b[^>]*src="([^"]+)"#i', $html, $srcs);
    foreach ($srcs[1] as $src) {
        if (strpos($src, 'data:') === 0 || strpos($src, 'http') === 0) { continue; }
        $archivo = $root . '/public' . preg_replace('/\?.*$/', '', $src);
        if (!is_file($archivo)) { $imagenesFaltantes[$src] = true; }
    }

    if ($problemas) {
        linea('fail', $ruta . ' → ' . implode('; ', $problemas));
        $fallas++;
    } else {
        linea('ok', sprintf('%-52s %5d palabras · title %2d · desc %3d', $ruta, $palabras, mb_strlen($titulo), mb_strlen($desc)));
    }
}

if ($imagenesFaltantes) {
    foreach (array_keys($imagenesFaltantes) as $img) {
        linea('fail', 'Falta el archivo de imagen: ' . $img);
        $fallas++;
    }
}

// -------------------------------------------------------------- 2. JSON-LD
echo "\n-- 2. Datos estructurados (JSON-LD) --\n";
$tiposEsperados = [
    '/' => ['Organization', 'WebSite', 'FAQPage'],
    '/precios/' => ['BreadcrumbList', 'FAQPage', 'Service'],
    '/tiendas-virtuales-guatemala/' => ['Service', 'FAQPage'],
    '/blog/cuanto-cuesta-una-pagina-web-en-guatemala/' => ['Article', 'BreadcrumbList'],
];
foreach ($paginas as $ruta => $html) {
    preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);
    if (!$m[1]) {
        linea('fail', $ruta . ' sin JSON-LD');
        $fallas++;
        continue;
    }
    $tipos = [];
    foreach ($m[1] as $json) {
        $data = json_decode($json, true);
        if ($data === null) {
            linea('fail', $ruta . ' tiene JSON-LD inválido: ' . json_last_error_msg());
            $fallas++;
            continue 2;
        }
        $nodos = isset($data['@graph']) ? $data['@graph'] : [$data];
        foreach ($nodos as $nodo) {
            if (isset($nodo['@type'])) { $tipos[] = $nodo['@type']; }
        }
    }
    // Regla del proyecto: nada de reseñas inventadas
    foreach ($m[1] as $json) {
        if (stripos($json, 'aggregateRating') !== false || stripos($json, '"review"') !== false) {
            linea('fail', $ruta . ' declara reseñas o calificaciones sin respaldo verificable');
            $fallas++;
        }
    }
    // Revisión de calidad del schema: sin valores vacíos ni URLs relativas
    foreach ($m[1] as $json) {
        $data = json_decode($json, true);
        $nodos = isset($data['@graph']) ? $data['@graph'] : [$data];
        $revisar = function ($valor, $camino) use (&$revisar, $ruta, &$fallas) {
            if (is_array($valor)) {
                foreach ($valor as $k => $v) {
                    $revisar($v, $camino . '.' . $k);
                }
                return;
            }
            if ($valor === null || $valor === '') {
                linea('fail', $ruta . ' tiene un valor vacío en el schema: ' . $camino);
                $fallas++;
            }
            if (is_string($valor) && preg_match('#^/[a-z]#i', $valor) && strpos($camino, 'url') !== false) {
                linea('fail', $ruta . ' usa una URL relativa en el schema: ' . $camino);
                $fallas++;
            }
        };
        foreach ($nodos as $i => $nodo) {
            if (!isset($nodo['@type'])) {
                linea('fail', $ruta . ' tiene un nodo de schema sin @type');
                $fallas++;
            }
            $revisar($nodo, 'nodo' . $i);
        }
    }

    $faltantes = [];
    if (isset($tiposEsperados[$ruta])) {
        foreach ($tiposEsperados[$ruta] as $t) {
            if (!in_array($t, $tipos, true)) { $faltantes[] = $t; }
        }
    }
    if ($faltantes) {
        linea('fail', $ruta . ' le faltan tipos: ' . implode(', ', $faltantes));
        $fallas++;
    } else {
        linea('ok', sprintf('%-52s %s', $ruta, implode(', ', array_unique($tipos))));
    }
}

// ------------------------------------------------- 3. Densidad de keywords
echo "\n-- 3. Densidad de palabras clave (máximo 1.5%) --\n";
$frases = ['páginas web', 'diseño de páginas web', 'tiendas virtuales', 'páginas web guatemala', 'guatemala'];
foreach ($paginas as $ruta => $html) {
    $texto = texto_visible($html);
    $altas = [];
    foreach ($frases as $frase) {
        $d = densidad($texto, $frase);
        if ($d > 1.5) { $altas[] = sprintf('%s %.2f%%', $frase, $d); }
    }
    if ($altas) {
        linea('fail', $ruta . ' → ' . implode(', ', $altas));
        $fallas++;
    }
}
if ($fallas === 0) { linea('ok', 'Ninguna página supera 1.5% en las frases revisadas'); }

// ----------------------------------------- 4. Texto oculto y enlaces ocultos
echo "\n-- 4. Texto oculto, enlaces ocultos y cloaking --\n";
$patronesOcultos = [
    'display\s*:\s*none' => 'display:none en atributo style',
    'visibility\s*:\s*hidden' => 'visibility:hidden en atributo style',
    'text-indent\s*:\s*-\d{4}' => 'text-indent negativo',
    'font-size\s*:\s*0' => 'font-size:0',
];
$hallazgos = 0;
foreach ($paginas as $ruta => $html) {
    preg_match_all('#style="([^"]*)"#i', $html, $m);
    foreach ($m[1] as $style) {
        foreach ($patronesOcultos as $patron => $descripcion) {
            if (preg_match('/' . $patron . '/i', $style)) {
                linea('fail', $ruta . ' → ' . $descripcion);
                $fallas++;
                $hallazgos++;
            }
        }
    }
}
if ($hallazgos === 0) { linea('ok', 'Sin texto ni enlaces ocultos en los atributos de estilo'); }

// ---------------------------------------------- 5. Enlace a la marca madre
echo "\n-- 5. Identidad de marca --\n";
$enlacesServicom = 0;
foreach ($paginas as $ruta => $html) {
    $enlacesServicom += preg_match_all('#href="https?://(www\.)?servicom\.gt#i', $html);
}
if ($enlacesServicom === 0) {
    linea('fail', 'No hay ningún enlace a servicom.gt; la relación de marca debe quedar explícita');
    $fallas++;
} else {
    linea('ok', "Se declara la relación con Servicom ({$enlacesServicom} enlaces naturales en total)");
}
$homeFooter = isset($paginas['/']) ? $paginas['/'] : '';
if ($homeFooter && preg_match_all('#href="https?://(www\.)?servicom\.gt#i', $homeFooter) > 2) {
    linea('warn', 'Hay más de dos enlaces a servicom.gt en una misma página');
    $avisos++;
}

// ---------------------------------------------------- 6. robots y sitemap
echo "\n-- 6. robots.txt y sitemap.xml --\n";
list($code, $robots) = fetch($base . '/robots.txt');
if ($code === 200 && strpos($robots, 'Sitemap:') !== false && strpos($robots, 'Disallow: /admin/') !== false) {
    linea('ok', 'robots.txt con Sitemap y /admin/ bloqueado');
} else {
    linea('fail', 'robots.txt incompleto');
    $fallas++;
}
list($code, $sitemap) = fetch($base . '/sitemap.xml');
$xml = @simplexml_load_string($sitemap);
if ($code === 200 && $xml !== false) {
    $n = count($xml->url);
    linea('ok', "sitemap.xml válido con {$n} direcciones");
    $enSitemap = [];
    foreach ($xml->url as $u) { $enSitemap[] = parse_url((string) $u->loc, PHP_URL_PATH); }
    foreach ($rutas as $ruta) {
        if (strpos($ruta, '/blog/categoria/') === 0) { continue; }
        if (!in_array($ruta, $enSitemap, true)) {
            linea('fail', "{$ruta} no aparece en el sitemap");
            $fallas++;
        }
    }
} else {
    linea('fail', 'sitemap.xml inválido');
    $fallas++;
}

// -------------------------------------------------------------- 7. 404
echo "\n-- 7. Página 404 --\n";
list($code, $html404) = fetch($base . '/esta-pagina-no-existe-123/');
if ($code === 404 && stripos($html404, 'noindex') !== false) {
    linea('ok', 'La 404 responde con código 404 y meta robots noindex');
} else {
    linea('fail', "La 404 respondió HTTP {$code}");
    $fallas++;
}

// -------------------------------------------- 8. Contenido duplicado interno
echo "\n-- 8. Contenido duplicado entre páginas propias --\n";
$dupes = 0;
$rutasArr = array_keys($paginas);
for ($i = 0; $i < count($rutasArr); $i++) {
    for ($j = $i + 1; $j < count($rutasArr); $j++) {
        $a = texto_visible($paginas[$rutasArr[$i]]);
        $b = texto_visible($paginas[$rutasArr[$j]]);
        similar_text(mb_substr($a, 0, 6000), mb_substr($b, 0, 6000), $pct);
        if ($pct > 80) {
            linea('fail', sprintf('%s y %s se parecen %.0f%%', $rutasArr[$i], $rutasArr[$j], $pct));
            $fallas++;
            $dupes++;
        }
    }
}
if ($dupes === 0) { linea('ok', 'Ninguna pareja de páginas supera 80% de similitud'); }

// ------------------------------------------------------------- 9. Sintaxis PHP
echo "\n-- 9. Sintaxis PHP y compatibilidad 7.4 --\n";
$archivos = [];
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS));
foreach ($it as $f) {
    if ($f->getExtension() === 'php' && strpos($f->getPathname(), '/.git/') === false) {
        $archivos[] = $f->getPathname();
    }
}
$erroresPhp = 0;
foreach ($archivos as $archivo) {
    exec('php -l ' . escapeshellarg($archivo) . ' 2>&1', $out, $ret);
    if ($ret !== 0) { linea('fail', 'Error de sintaxis en ' . str_replace($root . '/', '', $archivo)); $erroresPhp++; $fallas++; }
    $out = [];
}
$php8 = [];
foreach ($archivos as $archivo) {
    // El propio verificador contiene esos patrones como texto de búsqueda.
    if (basename($archivo) === 'verificar.php') {
        continue;
    }
    $src = file_get_contents($archivo);
    $src = preg_replace('#/\*.*?\*/#s', '', $src);
    if (preg_match('/\?->/', $src))                                  { $php8[] = $archivo . ': operador nullsafe'; }
    if (preg_match('/\bmatch\s*\(/', $src))                          { $php8[] = $archivo . ': expresión match'; }
    if (preg_match('/\benum\s+[A-Z]/', $src))                        { $php8[] = $archivo . ': enum'; }
    if (preg_match('/\breadonly\s+/', $src))                         { $php8[] = $archivo . ': propiedad readonly'; }
    if (preg_match('/__construct\s*\(\s*(public|private|protected)/', $src)) { $php8[] = $archivo . ': promoción de propiedades'; }
    if (preg_match('/function\s+\w+\s*\([^)]*\)\s*:\s*(static|mixed|never)\b/', $src)) { $php8[] = $archivo . ': tipo de retorno de PHP 8'; }
}
if ($php8) {
    foreach ($php8 as $p) { linea('fail', 'Sintaxis de PHP 8: ' . str_replace($root . '/', '', $p)); $fallas++; }
} elseif ($erroresPhp === 0) {
    linea('ok', count($archivos) . ' archivos PHP sin errores y sin sintaxis exclusiva de PHP 8');
}

// --------------------------------------------------------- 10. Seguridad
echo "\n-- 10. Seguridad --\n";

// 10.1 Cabeceras de protección: deben salir aunque Apache no tenga mod_headers.
$cabecerasEsperadas = [
    'x-content-type-options'   => 'nosniff',
    'x-frame-options'          => 'sameorigin',
    'referrer-policy'          => 'strict-origin-when-cross-origin',
    'permissions-policy'       => 'camera=()',
];
$brutas = '';
$ch = curl_init($base . '/precios/');
curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_HEADER => true, CURLOPT_NOBODY => true, CURLOPT_TIMEOUT => 15]);
$brutas = strtolower((string) curl_exec($ch));
curl_close($ch);
$faltan = [];
foreach ($cabecerasEsperadas as $nombre => $valor) {
    if (strpos($brutas, $nombre . ': ') === false || strpos($brutas, $valor) === false) {
        $faltan[] = $nombre;
    }
}
if ($faltan) {
    linea('fail', 'Faltan cabeceras de seguridad: ' . implode(', ', $faltan));
    $fallas++;
} else {
    linea('ok', 'Cabeceras de seguridad presentes sin depender de mod_headers');
}

// 10.2 El panel nunca debe ser indexable ni quedar en caché.
$ch = curl_init($base . '/admin/entrar/');
curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_HEADER => true, CURLOPT_NOBODY => true, CURLOPT_TIMEOUT => 15]);
$hAdmin = strtolower((string) curl_exec($ch));
curl_close($ch);
if (strpos($hAdmin, 'x-robots-tag: noindex') !== false && strpos($hAdmin, 'no-store') !== false) {
    linea('ok', 'El panel se sirve con noindex y sin caché');
} else {
    linea('fail', 'El panel debería mandar X-Robots-Tag noindex y Cache-Control no-store');
    $fallas++;
}

// 10.3 El instalador no puede volver a correr una vez instalado el sitio.
$ch = curl_init($base . '/install.php');
curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 15]);
curl_exec($ch);
$codInstalador = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
if (!is_file($root . '/public/install.php')) {
    linea('ok', 'install.php ya no está en el servidor');
} elseif ($codInstalador === 403 || $codInstalador === 404) {
    linea('ok', 'El instalador está bloqueado (HTTP ' . $codInstalador . ')');
} else {
    linea('fail', 'El instalador respondió HTTP ' . $codInstalador . ': debería estar bloqueado');
    $fallas++;
}

// 10.4 Carpetas privadas y de subidas con su .htaccess puesto.
$protegidas = [
    'config/.htaccess'         => 'Require all denied',
    'storage/.htaccess'        => 'Require all denied',
    'public/uploads/.htaccess' => 'FilesMatch',
];
$sinProteger = [];
foreach ($protegidas as $rel => $debeContener) {
    $abs = $root . '/' . $rel;
    if (!is_file($abs) || strpos(file_get_contents($abs), $debeContener) === false) {
        $sinProteger[] = $rel;
    }
}
if ($sinProteger) {
    linea('fail', 'Sin protección: ' . implode(', ', $sinProteger));
    $fallas++;
} else {
    linea('ok', 'config/, storage/ y public/uploads/ protegidos por .htaccess');
}

// 10.5 Toda consulta a la base debe ir preparada, nunca armada con variables.
$sospechosas = [];
foreach ($archivos as $archivo) {
    if (basename($archivo) === 'verificar.php') {
        continue;
    }
    foreach (file($archivo) as $numero => $linea) {
        if (!preg_match('/\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|SHOW COLUMNS|PRAGMA table_info)\b/i', $linea)) {
            continue;
        }
        // Interpolar un nombre de tabla o de columna solo se acepta si pasa
        // antes por el validador de identificadores.
        $sinValidados = preg_replace('/Database::(ident|orden)\([^)]*\)/', 'IDENT', $linea);
        $sinValidados = preg_replace("/array_map\\(array\\('App\\\\\\\\Core\\\\\\\\Database', 'ident'\\)[^)]*\\)/", 'IDENT', $sinValidados);
        if (preg_match('/[\'"]\s*\.\s*\$/', $sinValidados) || preg_match('/\{\$/', $sinValidados)) {
            $sospechosas[] = str_replace($root . '/', '', $archivo) . ':' . ($numero + 1);
        }
    }
}
if ($sospechosas) {
    linea('fail', 'Posible SQL armado con variables en: ' . implode(', ', $sospechosas));
    $fallas++;
} else {
    linea('ok', 'Ninguna consulta arma SQL concatenando variables');
}

// 10.6 El limpiador de HTML tiene que dejar fuera lo que pueda ejecutar código.
require_once $root . '/app/helpers.php';
$ataques = [
    '<script>alert(1)</script>'                  => 'script',
    '<img src=x onerror=alert(1)>'               => 'onerror',
    '<a href="javascript:alert(1)">x</a>'        => 'javascript:',
    '<a href=javascript:alert(1)>x</a>'          => 'javascript:',
    '<iframe src="//mal.example"></iframe>'      => 'iframe',
    '<svg onload=alert(1)></svg>'                => 'svg',
    '<p style="display:none">oculto</p>'         => 'display:none',
];
$colados = [];
foreach ($ataques as $entrada => $rastro) {
    if (stripos(clean_html($entrada), $rastro) !== false) {
        $colados[] = $rastro;
    }
}
if ($colados) {
    linea('fail', 'El limpiador de HTML dejó pasar: ' . implode(', ', $colados));
    $fallas++;
} else {
    linea('ok', 'El limpiador de HTML bloquea script, eventos, javascript:, iframe y texto oculto');
}

// -------------------------------------------------------------- Resumen
echo "\n=== RESUMEN ===\n";
echo "Fallas: {$fallas}   Avisos: {$avisos}\n\n";
exit($fallas > 0 ? 1 : 0);
