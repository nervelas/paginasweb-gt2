<?php
/**
 * Rastrea el sitio y comprueba que ningún enlace interno esté roto,
 * que no queden páginas huérfanas y que los enlaces externos tengan rel.
 * Uso: php tools/revisar-enlaces.php http://127.0.0.1:8080
 */
$base = isset($argv[1]) ? rtrim($argv[1], '/') : 'http://127.0.0.1:8080';
$host = parse_url($base, PHP_URL_HOST);

// El enlace a la marca madre es deliberadamente un enlace normal, sin rel:
// así se declara la relación entre los dos dominios. No se avisa por él.
$permitidosSinRel = ['servicom.gt', 'www.servicom.gt'];

function pedir($url, $soloCabecera = false)
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_NOBODY         => $soloCabecera,
        CURLOPT_TIMEOUT        => 20,
        CURLOPT_USERAGENT      => 'revisor-enlaces-paginasweb.gt',
    ]);
    $cuerpo = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$code, (string) $cuerpo];
}

$porVisitar = ['/'];
$vistas     = [];
$enlaces    = [];   // destino => [orígenes]
$fallas     = 0;
$avisos     = 0;

while ($porVisitar) {
    $ruta = array_shift($porVisitar);
    if (isset($vistas[$ruta])) {
        continue;
    }
    list($code, $html) = pedir($base . $ruta);
    $vistas[$ruta] = $code;
    if ($code !== 200) {
        continue;
    }
    preg_match_all('#<a\b[^>]*href="([^"]+)"[^>]*>#i', $html, $m, PREG_SET_ORDER);
    foreach ($m as $a) {
        $href = html_entity_decode($a[1], ENT_QUOTES, 'UTF-8');
        if ($href === '' || $href[0] === '#' || strpos($href, 'mailto:') === 0
            || strpos($href, 'tel:') === 0 || strpos($href, 'javascript:') === 0) {
            continue;
        }
        if (preg_match('#^https?://#i', $href)) {
            $h = parse_url($href, PHP_URL_HOST);
            if ($h !== $host) {
                // Enlace externo: conviene el rel para no abrir sin control.
                // La excepción declarada es la marca madre.
                if (stripos($a[0], 'rel=') === false && !in_array($h, $permitidosSinRel, true)) {
                    echo "  AVISO  enlace externo sin rel en {$ruta}: {$href}\n";
                    $avisos++;
                }
                continue;
            }
            $href = parse_url($href, PHP_URL_PATH);
        }
        $href = strtok($href, '?#');
        if ($href === false || $href === '' || $href[0] !== '/') {
            continue;
        }
        $enlaces[$href][] = $ruta;
        if (!isset($vistas[$href]) && !in_array($href, $porVisitar, true)) {
            $porVisitar[] = $href;
        }
    }
}

echo "\n=== ENLACES INTERNOS ===\n";
echo "Páginas rastreadas: " . count($vistas) . "\n\n";

foreach ($vistas as $ruta => $code) {
    if ($code !== 200) {
        $desde = isset($enlaces[$ruta]) ? implode(', ', array_unique($enlaces[$ruta])) : '(raíz)';
        echo "  FALLA  {$ruta} devuelve {$code} · enlazado desde: {$desde}\n";
        $fallas++;
    }
}

// Páginas del sitemap que nadie enlaza
list($c, $xml) = pedir($base . '/sitemap.xml');
$doc = @simplexml_load_string($xml);
$huerfanas = [];
if ($doc) {
    foreach ($doc->url as $u) {
        $p = parse_url((string) $u->loc, PHP_URL_PATH);
        if (!isset($enlaces[$p]) && $p !== '/') {
            $huerfanas[] = $p;
        }
    }
}
foreach ($huerfanas as $p) {
    echo "  FALLA  {$p} está en el sitemap pero ninguna página la enlaza\n";
    $fallas++;
}

if ($fallas === 0) {
    echo "  OK     Ningún enlace interno roto y ninguna página huérfana\n";
}
echo "\nFallas: {$fallas}   Avisos: {$avisos}\n";
exit($fallas > 0 ? 1 : 0);
