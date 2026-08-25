<?php
/**
 * Genera las imágenes del sitio en la dirección "Taller editorial":
 * láminas tipográficas para el portafolio, la composición del hero y las
 * portadas para redes sociales.
 *
 * Composición en HTML → captura con Chromium → conversión a WebP con GD.
 * Todo el material es original; no se usan fotografías ni capturas de terceros.
 *
 * Uso: php tools/imagenes/generar-imagenes.php [ruta-de-chromium]
 */

$root   = dirname(dirname(__DIR__));
$chrome = isset($argv[1]) ? $argv[1] : getenv('CHROME_BIN');
if (!$chrome) {
    foreach ([
        '/opt/pw-browsers/chromium-1194/chrome-linux/chrome',
        '/usr/bin/chromium', '/usr/bin/chromium-browser', '/usr/bin/google-chrome',
    ] as $c) {
        if (is_file($c)) { $chrome = $c; break; }
    }
}
if (!$chrome || !is_file($chrome)) {
    fwrite(STDERR, "No se encontró Chromium. Pasá la ruta como argumento.\n");
    exit(1);
}

$tmp = sys_get_temp_dir() . '/pwgt-img';
@mkdir($tmp, 0777, true);
foreach (['portafolio', 'og', 'icons', 'blog'] as $d) {
    @mkdir($root . '/public/assets/img/' . $d, 0755, true);
}

$SERIF = 'file://' . $root . '/public/assets/fonts/instrument-serif-400.woff2';
$SANS  = 'file://' . $root . '/public/assets/fonts/geist-wght.woff2';
$MONO  = 'file://' . $root . '/public/assets/fonts/geist-mono-wght.woff2';
$MARCA = 'file://' . $root . '/public/assets/img/marca-blanca.svg';

const OBSIDIAN = '#0A0C0F';
const BONE     = '#F3F0E9';
const QUETZAL  = '#11E39A';

function base_css($serif, $sans, $mono)
{
    return "
    @font-face{font-family:S;src:url('{$serif}') format('woff2')}
    @font-face{font-family:G;src:url('{$sans}') format('woff2-variations');font-weight:100 900}
    @font-face{font-family:M;src:url('{$mono}') format('woff2-variations');font-weight:100 900}
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:G,sans-serif;-webkit-font-smoothing:antialiased;background:" . OBSIDIAN . ";color:" . BONE . "}
    .grano{position:absolute;inset:0;pointer-events:none;opacity:.5;mix-blend-mode:overlay;
      background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='140' height='140'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='3'/%3E%3C/filter%3E%3Crect width='140' height='140' filter='url(%23n)' opacity='.16'/%3E%3C/svg%3E\")}
    ";
}

/** Captura una página HTML y devuelve true si escribió el PNG. */
function capturar($chrome, $html, $destino, $w, $h)
{
    $tmpFile = tempnam(sys_get_temp_dir(), 'pwgt') . '.html';
    file_put_contents($tmpFile, $html);
    $cmd = escapeshellcmd($chrome) . ' --headless --no-sandbox --disable-gpu --hide-scrollbars'
        . ' --screenshot=' . escapeshellarg($destino)
        . ' --window-size=' . (int) $w . ',' . (int) $h
        . ' ' . escapeshellarg('file://' . $tmpFile) . ' 2>/dev/null';
    exec($cmd, $out, $ret);
    @unlink($tmpFile);
    return is_file($destino);
}

/**
 * Captura con altura de sobra y recorta al tamaño exacto.
 * Chromium headless entrega un viewport algo más corto que el pedido, así que
 * se le da margen y luego se recorta: así ningún elemento queda cortado.
 */
function capturar_exacto($chrome, $html, $destino, $w, $h)
{
    $bruto = $destino . '.bruto.png';
    if (!capturar($chrome, $html, $bruto, $w, (int) ceil($h * 1.35) + 60)) {
        return false;
    }
    $img = @imagecreatefrompng($bruto);
    if (!$img) { @unlink($bruto); return false; }
    $rec = imagecreatetruecolor($w, $h);
    imagecopy($rec, $img, 0, 0, 0, 0, $w, $h);
    imagepng($rec, $destino);
    imagedestroy($img);
    imagedestroy($rec);
    @unlink($bruto);
    return true;
}

/** Convierte un PNG a WebP (o a JPG si el servidor no soporta WebP). */
function a_webp($png, $webp, $calidad = 82)
{
    $img = @imagecreatefrompng($png);
    if (!$img) { return false; }
    imagepalettetotruecolor($img);
    $ok = function_exists('imagewebp') ? imagewebp($img, $webp, $calidad) : false;
    if (!$ok) {
        $ok = imagejpeg($img, preg_replace('/\.webp$/', '.jpg', $webp), $calidad);
    }
    imagedestroy($img);
    @unlink($png);
    return $ok;
}

/** Matiz estable derivado del dominio: cada proyecto tiene su tono propio. */
function matiz($semilla)
{
    return abs(crc32($semilla)) % 360;
}

// ------------------------------------------------------------------------
// 1. Láminas del portafolio
// ------------------------------------------------------------------------
$proyectos = require $root . '/database/content/portfolio.php';
echo "Láminas del portafolio (" . count($proyectos) . "):\n";
$css = base_css($SERIF, $SANS, $MONO);

foreach ($proyectos as $i => $p) {
    $slug   = str_replace('.', '-', $p['domain']);
    $h      = matiz($p['domain']);
    $nombre = htmlspecialchars($p['name'], ENT_QUOTES);
    $dom    = htmlspecialchars($p['domain'], ENT_QUOTES);
    $sector = htmlspecialchars(mb_strtoupper($p['sector']), ENT_QUOTES);
    $num    = str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT);
    $largo  = mb_strlen($p['name']);
    $tam    = $largo > 20 ? 46 : ($largo > 14 ? 58 : 72);

    $html = <<<HTML
<!doctype html><html><head><meta charset="utf-8"><style>
{$css}
body{width:640px;height:400px;position:relative;overflow:hidden}
.tinte{position:absolute;inset:0;background:
  radial-gradient(120% 90% at 82% 8%, hsla({$h},62%,42%,.30) 0%, transparent 58%),
  radial-gradient(80% 70% at 10% 100%, hsla(160,70%,45%,.10) 0%, transparent 60%)}
.marco{position:absolute;inset:22px;border:1px solid rgba(243,240,233,.16)}
.esq{position:absolute;width:11px;height:11px;border:0 solid rgba(17,227,154,.85)}
.e1{top:22px;left:22px;border-top-width:1px;border-left-width:1px}
.e2{bottom:22px;right:22px;border-bottom-width:1px;border-right-width:1px}
.in{position:absolute;inset:22px;padding:26px 30px;display:flex;flex-direction:column;justify-content:space-between}
.top{display:flex;justify-content:space-between;align-items:baseline;
  font-family:M;font-size:9.5px;letter-spacing:.19em;color:rgba(243,240,233,.5)}
.top .n{color:{QUETZAL}}
.nombre{font-family:S;font-size:{$tam}px;line-height:.98;letter-spacing:-.03em;max-width:11ch}
.linea{height:1px;background:rgba(243,240,233,.16);margin:16px 0 14px}
.pie{display:flex;justify-content:space-between;align-items:flex-end;gap:16px}
.dom{font-family:M;font-size:11px;letter-spacing:.1em;color:rgba(243,240,233,.72)}
.barras{display:flex;gap:4px;align-items:flex-end;height:26px}
.barras i{display:block;width:4px;background:rgba(17,227,154,.55)}
</style></head><body>
<span class="tinte"></span><span class="grano"></span>
<span class="marco"></span><span class="esq e1"></span><span class="esq e2"></span>
<div class="in">
  <div class="top"><span class="n">{$num}</span><span>{$sector}</span></div>
  <div>
    <div class="nombre">{$nombre}</div>
    <div class="linea"></div>
    <div class="pie">
      <span class="dom">{$dom}</span>
      <span class="barras"><i style="height:9px"></i><i style="height:17px"></i><i style="height:12px"></i><i style="height:24px"></i></span>
    </div>
  </div>
</div>
</body></html>
HTML;
    $html = str_replace('{QUETZAL}', QUETZAL, $html);

    $png  = $tmp . '/' . $slug . '.png';
    $webp = $root . '/public/assets/img/portafolio/' . $slug . '.webp';
    if (capturar_exacto($chrome, $html, $png, 640, 400) && a_webp($png, $webp, 80)) {
        echo '  ' . str_pad($slug, 34) . ' ' . round(filesize($webp) / 1024) . " KB\n";
    } else {
        echo "  FALLÓ: {$slug}\n";
    }
}

// ------------------------------------------------------------------------
// 2. Composición del hero
// ------------------------------------------------------------------------
echo "\nComposición del hero:\n";
$css = base_css($SERIF, $SANS, $MONO);
$heroHtml = <<<HTML
<!doctype html><html><head><meta charset="utf-8"><style>
{$css}
html{zoom:2}
body{width:760px;height:570px;position:relative;overflow:hidden;background:#0D1116}
.aura{position:absolute;width:640px;height:640px;border-radius:50%;right:-180px;top:-260px;
  background:radial-gradient(circle,rgba(17,227,154,.20),transparent 62%)}
.esc{position:absolute;inset:0;display:grid;place-items:center}
/* pantalla grande */
.mac{position:relative;width:576px;transform:translate(-28px,-12px)}
.chasis{background:#05070A;border:1px solid rgba(243,240,233,.18);padding:9px 9px 12px}
.pantalla{background:#0A0C0F;height:292px;overflow:hidden;position:relative}
.barra{height:26px;border-bottom:1px solid rgba(243,240,233,.12);display:flex;align-items:center;gap:8px;padding:0 12px}
.logo{height:9px}
.mini{margin-left:auto;display:flex;gap:8px}
.mini i{display:block;width:20px;height:3px;background:rgba(243,240,233,.22)}
.mini b{display:block;width:44px;height:11px;background:{QUETZAL}}
.cuerpo{padding:22px 20px 0;display:grid;grid-template-columns:1fr 128px;gap:16px;align-items:center}
.h{font-family:S;font-size:30px;line-height:.98;letter-spacing:-.032em}
.h span{display:block;color:{QUETZAL}}
.p{margin-top:10px;display:grid;gap:5px}
.p i{display:block;height:4px;background:rgba(243,240,233,.16)}
.p i:nth-child(2){width:84%}.p i:nth-child(3){width:56%}
.acc{margin-top:15px;display:flex;gap:7px}
.acc b{display:block;width:74px;height:20px;background:{QUETZAL}}
.acc s{display:block;width:56px;height:20px;border:1px solid rgba(243,240,233,.24)}
.bloque{height:118px;border:1px solid rgba(243,240,233,.18);position:relative}
.bloque::after{content:'';position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);
  width:44px;height:44px;background:{QUETZAL};opacity:.9}
.fichas{margin-top:20px;border-top:1px solid rgba(243,240,233,.12);display:grid;grid-template-columns:repeat(3,1fr)}
.fichas div{padding:14px 12px 0;border-right:1px solid rgba(243,240,233,.12)}
.fichas div:last-child{border-right:0}
.fichas u{display:block;font-family:M;font-size:7px;letter-spacing:.16em;color:rgba(243,240,233,.36);text-decoration:none;margin-bottom:6px}
.fichas b{display:block;font-family:S;font-size:19px;line-height:1;letter-spacing:-.03em}
.pie-mac{height:7px;background:linear-gradient(#20262E,#11151A);width:660px;margin:0 auto;position:relative;left:-50px}
/* celular */
.cel{position:absolute;right:4px;bottom:16px;width:162px;background:#05070A;border:1px solid rgba(243,240,233,.2);padding:7px}
.cel-p{background:#0A0C0F;height:292px;overflow:hidden;position:relative}
.cel-b{height:22px;border-bottom:1px solid rgba(243,240,233,.12);display:flex;align-items:center;justify-content:center}
.cel-b img{height:8px}
.cel-c{padding:14px 12px 0}
.cel-h{font-family:S;font-size:17px;line-height:1;letter-spacing:-.03em}
.cel-h span{color:{QUETZAL}}
.cel-l{margin-top:9px;display:grid;gap:4px}
.cel-l i{display:block;height:3.5px;background:rgba(243,240,233,.16)}
.cel-l i:nth-child(2){width:72%}
.cel-btn{margin-top:12px;height:19px;background:{QUETZAL}}
.cel-img{margin:12px 12px 0;height:64px;border:1px solid rgba(243,240,233,.18)}
.cel-fil{margin:10px 12px 0;display:grid;gap:6px}
.cel-fil i{display:block;height:1px;background:rgba(243,240,233,.14)}
</style></head><body>
<span class="aura"></span><span class="grano"></span>
<div class="esc">
  <div class="mac">
    <div class="chasis">
      <div class="pantalla">
        <div class="barra">
          <img class="logo" src="{$MARCA}" alt="">
          <span class="mini"><i></i><i></i><i></i><b></b></span>
        </div>
        <div class="cuerpo">
          <div>
            <div class="h">Páginas web<span>con oficio</span></div>
            <div class="p"><i></i><i></i><i></i></div>
            <div class="acc"><b></b><s></s></div>
          </div>
          <div class="bloque"></div>
        </div>
        <div class="fichas">
          <div><u>AÑOS</u><b>18</b></div>
          <div><u>SITIOS</u><b>24</b></div>
          <div><u>DESDE</u><b>Q250</b></div>
        </div>
      </div>
    </div>
    <div class="pie-mac"></div>
  </div>
  <div class="cel">
    <div class="cel-p">
      <div class="cel-b"><img src="{$MARCA}" alt=""></div>
      <div class="cel-c">
        <div class="cel-h">Listo para<span>el celular</span></div>
        <div class="cel-l"><i></i><i></i></div>
        <div class="cel-btn"></div>
      </div>
      <div class="cel-img"></div>
      <div class="cel-fil"><i></i><i></i><i></i><i></i></div>
    </div>
  </div>
</div>
</body></html>
HTML;
$heroHtml = str_replace('{QUETZAL}', QUETZAL, $heroHtml);
$png = $tmp . '/hero.png';
$destinoHero = $root . '/public/assets/img/hero-estudio.webp';
if (capturar_exacto($chrome, $heroHtml, $png, 1520, 1140) && a_webp($png, $destinoHero, 84)) {
    echo '  hero-estudio.webp  ' . round(filesize($destinoHero) / 1024) . " KB\n";
} else {
    echo "  FALLÓ el hero\n";
}

// ------------------------------------------------------------------------
// 3. Portadas para redes sociales (1200x630)
// ------------------------------------------------------------------------
echo "\nPortadas para redes sociales:\n";
$ogs = [
    'og-inicio'               => ['00', 'Estudio web · Guatemala', 'Páginas web con oficio', 'Dominio, alojamiento y soporte incluidos', 'Desde Q1,250 al año'],
    'og-diseno-paginas-web'   => ['01', 'Servicio', 'Diseño de páginas web', 'Estructura, textos y configuración técnica', 'Q1,250 al año'],
    'og-tiendas-virtuales'    => ['02', 'Servicio', 'Tiendas virtuales', 'WooCommerce, envíos y cobro con tarjeta', 'Q1,750 al año'],
    'og-precios'              => ['03', 'Precios 2026', 'En quetzales, sin letra chiquita', 'Página web · Tienda en línea · Correo', 'Ver la tabla completa'],
    'og-correo-corporativo'   => ['04', 'Servicio', 'Correo con tu dominio', 'Configurado, sin spam y en todos tus equipos', 'Consultar precio'],
    'og-portafolio'           => ['05', 'Trabajos', 'Portafolio', 'Sitios de clientes guatemaltecos, en línea hoy', '24 proyectos'],
    'og-nosotros'             => ['06', 'Estudio', 'Quiénes somos', 'Una marca de Servicom, diseñando desde 2007', '18+ años'],
    'og-preguntas-frecuentes' => ['07', 'Ayuda', 'Preguntas frecuentes', 'Dominios, hosting, tiempos y renovaciones', 'Respuestas claras'],
    'og-contacto'             => ['08', 'Hablemos', 'Contacto y cotización', 'Contanos qué necesitás y te respondemos', 'WhatsApp y formulario'],
    'og-blog'                 => ['09', 'Blog', 'Guías para decidir', 'Precios, pasarelas de pago y dominios .gt', 'Seis guías publicadas'],
];

foreach ($ogs as $slug => $t) {
    list($num, $etiqueta, $titulo, $bajada, $pastilla) = array_map(function ($v) {
        return htmlspecialchars($v, ENT_QUOTES);
    }, $t);
    $css = base_css($SERIF, $SANS, $MONO);
    $html = <<<HTML
<!doctype html><html><head><meta charset="utf-8"><style>
{$css}
body{width:1200px;height:630px;position:relative;overflow:hidden;padding:70px 80px 0;
  display:flex;flex-direction:column;justify-content:space-between}
.aura{position:absolute;width:900px;height:900px;border-radius:50%;right:-280px;top:-380px;
  background:radial-gradient(circle,rgba(17,227,154,.24),transparent 62%)}
.c{position:relative;z-index:2}
.tope{display:flex;justify-content:space-between;align-items:center}
.tope img{height:30px}
.et{font-family:M;font-size:14px;letter-spacing:.22em;text-transform:uppercase;color:rgba(243,240,233,.5)}
.et b{color:{QUETZAL};margin-right:14px}
h1{font-family:S;font-weight:400;font-size:96px;line-height:.94;letter-spacing:-.035em;max-width:15ch;margin-bottom:24px}
p{font-size:27px;color:rgba(243,240,233,.62);max-width:34ch;letter-spacing:-.012em}
.pie{display:flex;justify-content:space-between;align-items:flex-end;padding-bottom:56px}
.pill{display:inline-block;background:{QUETZAL};color:#0A0C0F;font-family:M;font-size:17px;font-weight:500;
  letter-spacing:.1em;text-transform:uppercase;padding:14px 24px}
.dom{font-family:M;font-size:17px;letter-spacing:.14em;color:rgba(243,240,233,.42)}
.regla{position:absolute;left:0;right:0;bottom:0;height:8px;background:{QUETZAL}}
.marcas{position:absolute;inset:34px;border:1px solid rgba(243,240,233,.1)}
</style></head><body>
<span class="aura"></span><span class="grano"></span><span class="marcas"></span>
<div class="c tope">
  <img src="{$MARCA}" alt="">
  <span class="et"><b>{$num}</b>{$etiqueta}</span>
</div>
<div class="c">
  <h1>{$titulo}</h1>
  <p>{$bajada}</p>
</div>
<div class="c pie">
  <span class="pill">{$pastilla}</span>
  <span class="dom">paginasweb.gt</span>
</div>
<span class="regla"></span>
</body></html>
HTML;
    $html = str_replace('{QUETZAL}', QUETZAL, $html);
    $png  = $tmp . '/' . $slug . '.png';
    $webp = $root . '/public/assets/img/og/' . $slug . '.webp';
    if (capturar_exacto($chrome, $html, $png, 1200, 630) && a_webp($png, $webp, 86)) {
        echo '  ' . str_pad($slug, 28) . ' ' . round(filesize($webp) / 1024) . " KB\n";
    } else {
        echo "  FALLÓ: {$slug}\n";
    }
}

// ------------------------------------------------------------------------
// 4. Iconos de aplicación
// ------------------------------------------------------------------------
echo "\nIconos de la aplicación:\n";
$icono = 'file://' . $root . '/public/assets/img/icons/marca-cuadrada.svg';
foreach ([180, 192, 512] as $tam) {
    $html = '<!doctype html><html><head><style>*{margin:0;padding:0}body{width:' . $tam . 'px;height:' . $tam . 'px;overflow:hidden}img{width:' . $tam . 'px;height:' . $tam . 'px;display:block}</style></head><body><img src="' . $icono . '" alt=""></body></html>';
    $destino = $root . '/public/assets/img/icons/icono-' . $tam . '.png';
    if (capturar($chrome, $html, $destino, $tam, $tam)) {
        echo '  icono-' . $tam . ".png\n";
    }
}
echo "\nTodo listo.\n";
