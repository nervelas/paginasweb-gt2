<?php
/**
 * Minificador propio de CSS y JS. No requiere Node.
 * Uso:  php tools/build-assets.php
 */

function minify_css($css)
{
    $css = preg_replace('#/\*(?!!).*?\*/#s', '', $css);          // comentarios
    $css = preg_replace('/\s+/', ' ', $css);                      // espacios
    $css = preg_replace('/\s*([{}:;,>~])\s*/', '$1', $css);
    $css = str_replace(';}', '}', $css);
    $css = preg_replace('/(:|,)\s+/', '$1', $css);
    $css = preg_replace('/\s+(and|or)\s+/', ' $1 ', $css);
    $css = str_replace('@media(', '@media (', $css);
    return trim($css);
}

function minify_js($js)
{
    $out = '';
    $len = strlen($js);
    $i = 0;
    while ($i < $len) {
        $c = $js[$i];
        $next = $i + 1 < $len ? $js[$i + 1] : '';
        // Cadenas: se copian tal cual
        if ($c === '"' || $c === "'") {
            $quote = $c;
            $out .= $c;
            $i++;
            while ($i < $len) {
                $out .= $js[$i];
                if ($js[$i] === '\\') {
                    $i++;
                    if ($i < $len) { $out .= $js[$i]; }
                    $i++;
                    continue;
                }
                if ($js[$i] === $quote) { $i++; break; }
                $i++;
            }
            continue;
        }
        // Comentario de línea
        if ($c === '/' && $next === '/') {
            while ($i < $len && $js[$i] !== "\n") { $i++; }
            continue;
        }
        // Comentario de bloque
        if ($c === '/' && $next === '*') {
            $i += 2;
            while ($i + 1 < $len && !($js[$i] === '*' && $js[$i + 1] === '/')) { $i++; }
            $i += 2;
            continue;
        }
        $out .= $c;
        $i++;
    }
    // Solo se quitan comentarios y sangría. No se tocan los tokens, para no
    // romper cadenas ni expresiones; el resto lo resuelve gzip en el servidor.
    $lines = array_map('trim', explode("\n", $out));
    $lines = array_filter($lines, function ($l) { return $l !== ''; });
    return trim(implode("\n", $lines));
}

$root = dirname(__DIR__);
$jobs = [
    ['in' => '/public/assets/css/site.css',     'out' => '/public/assets/css/site.min.css',     'type' => 'css'],
    ['in' => '/public/assets/css/critical.css', 'out' => '/public/assets/css/critical.min.css', 'type' => 'css'],
    ['in' => '/public/assets/css/admin.css',    'out' => '/public/assets/css/admin.min.css',    'type' => 'css'],
    ['in' => '/public/assets/js/site.js',       'out' => '/public/assets/js/site.min.js',       'type' => 'js'],
    ['in' => '/public/assets/js/admin.js',      'out' => '/public/assets/js/admin.min.js',      'type' => 'js'],
];

foreach ($jobs as $job) {
    $in = $root . $job['in'];
    if (!is_file($in)) {
        echo "  omitido (no existe): {$job['in']}\n";
        continue;
    }
    $source = file_get_contents($in);
    $min = $job['type'] === 'css' ? minify_css($source) : minify_js($source);
    file_put_contents($root . $job['out'], $min);
    printf("  %-42s %6d B  ->  %6d B  (-%d%%)\n", basename($job['out']), strlen($source), strlen($min), round((1 - strlen($min) / max(1, strlen($source))) * 100));
}
echo "Listo.\n";
