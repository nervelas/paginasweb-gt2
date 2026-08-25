<?php
/**
 * Láminas técnicas en SVG para las páginas de servicio y el blog.
 * Geometría de trazo fino sobre lienzo oscuro, con un solo elemento en el
 * color de señal. Escalan a cualquier tamaño y pesan menos de 3 KB.
 */

$root = dirname(dirname(__DIR__));
$img  = $root . '/public/assets/img';
@mkdir($img . '/blog', 0755, true);

$OBS = '#0A0C0F';
$Q   = '#11E39A';
$R   = 'rgba(243,240,233,.20)';   // regla capilar
$R2  = 'rgba(243,240,233,.10)';   // regla secundaria
$T   = 'rgba(243,240,233,.55)';   // relleno tenue

function lamina($w, $h, $cuerpo, $titulo, $obs, $r, $q)
{
    // Marco, marcas de esquina y retícula base compartidos por todas las láminas
    $m = 22;
    $marco = '<rect x="' . $m . '" y="' . $m . '" width="' . ($w - 2 * $m) . '" height="' . ($h - 2 * $m) . '" fill="none" stroke="' . $r . '"/>'
        . '<path d="M' . $m . ' ' . ($m + 12) . 'V' . $m . 'h12" stroke="' . $q . '" fill="none"/>'
        . '<path d="M' . ($w - $m) . ' ' . ($h - $m - 12) . 'V' . ($h - $m) . 'h-12" stroke="' . $q . '" fill="none"/>';

    return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ' . $w . ' ' . $h . '" width="' . $w . '" height="' . $h . '" role="img" aria-label="' . htmlspecialchars($titulo, ENT_QUOTES) . '">'
        . '<title>' . htmlspecialchars($titulo, ENT_QUOTES) . '</title>'
        . '<rect width="' . $w . '" height="' . $h . '" fill="' . $obs . '"/>'
        . '<g stroke-width="1" shape-rendering="geometricPrecision">' . $marco . '</g>'
        . '<g stroke-width="1.2" fill="none" stroke-linecap="square">' . $cuerpo . '</g>'
        . '</svg>' . "\n";
}

/** Renglones de texto simulados. */
function reng($x, $y, $anchos, $color, $sep = 11, $alto = 3)
{
    $o = '';
    foreach ($anchos as $i => $w) {
        $o .= '<rect x="' . $x . '" y="' . ($y + $i * $sep) . '" width="' . $w . '" height="' . $alto . '" fill="' . $color . '" stroke="none"/>';
    }
    return $o;
}

$archivos = [];

// ---------------------------------------------------- Servicio: páginas web
$archivos['servicio-paginas-web.svg'] = lamina(520, 420, '
<rect x="62" y="76" width="396" height="268" stroke="' . $R . '"/>
<path d="M62 112h396" stroke="' . $R . '"/>
<circle cx="82" cy="94" r="3.2" fill="' . $Q . '" stroke="none"/>
<circle cx="96" cy="94" r="3.2" fill="' . $R . '" stroke="none"/>
<circle cx="110" cy="94" r="3.2" fill="' . $R . '" stroke="none"/>
<rect x="132" y="88" width="180" height="12" stroke="' . $R2 . '"/>
' . reng(90, 148, [150, 118], 'rgba(243,240,233,.55)', 16, 5) . '
' . reng(90, 196, [230, 198, 152], 'rgba(243,240,233,.16)', 12, 3) . '
<rect x="90" y="248" width="86" height="26" fill="' . $Q . '" stroke="none"/>
<rect x="186" y="248" width="66" height="26" stroke="' . $R . '"/>
<rect x="330" y="146" width="108" height="106" stroke="' . $R . '"/>
<path d="M330 252l108-106M330 146l108 106" stroke="' . $R2 . '"/>
<rect x="90" y="300" width="104" height="24" stroke="' . $R2 . '"/>
<rect x="206" y="300" width="104" height="24" stroke="' . $R2 . '"/>
<rect x="322" y="300" width="104" height="24" stroke="' . $R2 . '"/>
', 'Lámina técnica de una página web con sus secciones', $OBS, $R, $Q);

// ------------------------------------------------ Servicio: tiendas virtuales
$archivos['servicio-tiendas-virtuales.svg'] = lamina(520, 420, '
<rect x="62" y="76" width="240" height="150" stroke="' . $R . '"/>
<path d="M62 76l240 150M302 76L62 226" stroke="' . $R2 . '"/>
<rect x="62" y="244" width="240" height="100" stroke="' . $R . '"/>
' . reng(84, 268, [130, 96], 'rgba(243,240,233,.4)', 14, 4) . '
<rect x="84" y="308" width="72" height="20" fill="' . $Q . '" stroke="none"/>
<rect x="330" y="76" width="128" height="180" stroke="' . $R . '"/>
<path d="M330 112h128" stroke="' . $R . '"/>
' . reng(348, 132, [92, 74, 58], 'rgba(243,240,233,.18)', 12, 3) . '
<rect x="348" y="188" width="92" height="22" fill="' . $Q . '" stroke="none"/>
<path d="M344 300h14l8 34h68l7-24h-72" stroke="' . $Q . '" stroke-width="1.6"/>
<circle cx="368" cy="346" r="4" stroke="' . $Q . '"/>
<circle cx="410" cy="346" r="4" stroke="' . $Q . '"/>
', 'Lámina técnica de una tienda en línea', $OBS, $R, $Q);

// ------------------------------------------- Servicio: correo corporativo
$archivos['servicio-correo-corporativo.svg'] = lamina(520, 420, '
<rect x="72" y="112" width="376" height="212" stroke="' . $R . '"/>
<path d="M72 112l188 132 188-132" stroke="' . $R . '"/>
<path d="M72 324l142-100M448 324L306 224" stroke="' . $R2 . '"/>
<circle cx="404" cy="128" r="34" stroke="' . $Q . '" stroke-width="1.6"/>
<circle cx="404" cy="128" r="11" stroke="' . $Q . '" stroke-width="1.6"/>
<path d="M415 128v9c0 6 10 6 10-4a21 21 0 1 0-8 17" stroke="' . $Q . '" stroke-width="1.6"/>
' . reng(102, 282, [120, 88], 'rgba(243,240,233,.22)', 13, 3) . '
<rect x="330" y="276" width="96" height="30" stroke="' . $R . '"/>
<path d="M346 292h10l5 8 6-16 5 8h12" stroke="' . $Q . '" stroke-width="1.4"/>
', 'Lámina técnica de correo con dominio propio', $OBS, $R, $Q);

// ---------------------------------------------------------- Blog: precios
$archivos['blog/precios-pagina-web-guatemala.svg'] = lamina(1200, 675, '
<rect x="120" y="140" width="420" height="380" stroke="' . $R . '"/>
<path d="M120 200h420" stroke="' . $R . '"/>
' . reng(156, 168, [160], 'rgba(243,240,233,.35)', 12, 5) . '
' . reng(156, 240, [300, 250, 190], 'rgba(243,240,233,.16)', 20, 4) . '
<rect x="156" y="356" width="180" height="40" fill="' . $Q . '" stroke="none"/>
' . reng(156, 430, [340, 280], 'rgba(243,240,233,.1)', 20, 4) . '
<g>
  <path d="M660 520h420" stroke="' . $R . '"/>
  <rect x="676" y="410" width="62" height="110" stroke="' . $R . '"/>
  <rect x="768" y="330" width="62" height="190" stroke="' . $R . '"/>
  <rect x="860" y="250" width="62" height="270" stroke="' . $R . '"/>
  <rect x="952" y="160" width="62" height="360" fill="' . $Q . '" stroke="none"/>
</g>
<path d="M660 160h40M680 140v40" stroke="' . $R2 . '"/>
', 'Lámina sobre precios de páginas web en Guatemala', $OBS, $R, $Q);

// ----------------------------------------------------- Blog: crear tienda
$archivos['blog/crear-tienda-en-linea-guatemala.svg'] = lamina(1200, 675, '
<g>
  <circle cx="180" cy="200" r="22" stroke="' . $Q . '"/><path d="M170 200l7 8 14-16" stroke="' . $Q . '"/>
  <circle cx="180" cy="338" r="22" stroke="' . $Q . '"/><path d="M170 338l7 8 14-16" stroke="' . $Q . '"/>
  <circle cx="180" cy="476" r="22" stroke="' . $R . '"/>
  <path d="M180 222v94M180 360v94" stroke="' . $R2 . '"/>
  ' . reng(232, 192, [260, 190], 'rgba(243,240,233,.22)', 15, 4) . '
  ' . reng(232, 330, [230, 170], 'rgba(243,240,233,.22)', 15, 4) . '
  ' . reng(232, 468, [200, 150], 'rgba(243,240,233,.1)', 15, 4) . '
</g>
<rect x="600" y="140" width="440" height="380" stroke="' . $R . '"/>
<path d="M600 210h440M820 210v310" stroke="' . $R . '"/>
<path d="M600 140l90-56h260l90 56" stroke="' . $Q . '" stroke-width="1.6"/>
<rect x="640" y="250" width="140" height="100" stroke="' . $R2 . '"/>
<rect x="860" y="250" width="140" height="100" stroke="' . $R2 . '"/>
' . reng(640, 386, [140, 96], 'rgba(243,240,233,.16)', 14, 4) . '
' . reng(860, 386, [140, 96], 'rgba(243,240,233,.16)', 14, 4) . '
<rect x="640" y="452" width="110" height="30" fill="' . $Q . '" stroke="none"/>
', 'Lámina sobre los pasos para montar una tienda en línea', $OBS, $R, $Q);

// -------------------------------------------- Blog: WooCommerce o Shopify
$archivos['blog/woocommerce-vs-shopify-guatemala.svg'] = lamina(1200, 675, '
<rect x="110" y="130" width="420" height="400" stroke="' . $Q . '"/>
<rect x="154" y="176" width="86" height="86" stroke="' . $Q . '"/>
<path d="M170 219l14 16 26-32" stroke="' . $Q . '" stroke-width="1.6"/>
' . reng(154, 306, [330, 270, 210, 290], 'rgba(243,240,233,.26)', 24, 4) . '
<rect x="154" y="452" width="170" height="34" fill="' . $Q . '" stroke="none"/>
<rect x="670" y="130" width="420" height="400" stroke="' . $R . '"/>
<rect x="714" y="176" width="86" height="86" stroke="' . $R . '"/>
<circle cx="757" cy="219" r="20" stroke="' . $R . '"/>
' . reng(714, 306, [330, 210, 270, 180], 'rgba(243,240,233,.12)', 24, 4) . '
<rect x="714" y="452" width="170" height="34" stroke="' . $R . '"/>
<path d="M578 310l44 44M622 310l-44 44" stroke="' . $Q . '" stroke-width="1.6"/>
', 'Lámina comparativa entre dos plataformas de comercio', $OBS, $R, $Q);

// ------------------------------------------------ Blog: cobro con tarjeta
$archivos['blog/cobrar-con-tarjeta-guatemala.svg'] = lamina(1200, 675, '
<rect x="130" y="180" width="380" height="238" stroke="' . $R . '"/>
<path d="M130 246h380" stroke="' . $R . '"/>
<rect x="164" y="300" width="96" height="16" fill="' . $T . '" stroke="none"/>
<rect x="280" y="300" width="96" height="16" fill="' . $T . '" stroke="none"/>
<rect x="164" y="348" width="150" height="12" fill="rgba(243,240,233,.18)" stroke="none"/>
<rect x="404" y="336" width="72" height="50" stroke="' . $Q . '"/>
<path d="M404 358h72M440 336v50" stroke="' . $Q . '"/>
<rect x="330" y="256" width="380" height="238" fill="' . $OBS . '" stroke="' . $Q . '"/>
<path d="M330 322h380" stroke="' . $Q . '"/>
<rect x="364" y="376" width="96" height="16" fill="rgba(243,240,233,.4)" stroke="none"/>
<rect x="480" y="376" width="96" height="16" fill="rgba(243,240,233,.4)" stroke="none"/>
<rect x="604" y="412" width="72" height="50" fill="' . $Q . '" stroke="none"/>
<g>
  <rect x="810" y="230" width="270" height="200" stroke="' . $R . '"/>
  <rect x="850" y="266" width="190" height="52" stroke="' . $R2 . '"/>
  <rect x="850" y="342" width="54" height="42" stroke="' . $R2 . '"/>
  <rect x="918" y="342" width="54" height="42" stroke="' . $R2 . '"/>
  <rect x="986" y="342" width="54" height="42" fill="' . $Q . '" stroke="none"/>
</g>
', 'Lámina sobre el cobro con tarjeta en una tienda en línea', $OBS, $R, $Q);

// ---------------------------------------------------------- Blog: dominio
$archivos['blog/dominio-gt-guatemala.svg'] = lamina(1200, 675, '
<circle cx="600" cy="338" r="196" stroke="' . $R . '"/>
<path d="M404 338h392" stroke="' . $R2 . '"/>
<path d="M600 142c62 62 62 330 0 392M600 142c-62 62-62 330 0 392" stroke="' . $R2 . '"/>
<path d="M446 216c92 40 216 40 308 0M446 460c92-40 216-40 308 0" stroke="' . $R2 . '"/>
<rect x="330" y="296" width="540" height="84" fill="' . $OBS . '" stroke="' . $Q . '"/>
<path d="M378 338v-13a13 13 0 0 1 26 0v13" stroke="' . $Q . '"/>
<rect x="372" y="338" width="38" height="26" fill="' . $Q . '" stroke="none"/>
<rect x="440" y="326" width="180" height="14" fill="rgba(243,240,233,.6)" stroke="none"/>
<rect x="440" y="350" width="104" height="10" fill="rgba(243,240,233,.2)" stroke="none"/>
<rect x="700" y="316" width="130" height="44" fill="' . $Q . '" stroke="none"/>
', 'Lámina sobre el dominio .gt de Guatemala', $OBS, $R, $Q);

// -------------------------------------------------------- Blog: 7 errores
$archivos['blog/errores-contratar-diseno-web.svg'] = lamina(1200, 675, '
<rect x="120" y="140" width="520" height="400" stroke="' . $R . '"/>
<path d="M120 208h520" stroke="' . $R . '"/>
' . reng(160, 168, [200], 'rgba(243,240,233,.35)', 12, 5) . '
<g>
  <path d="M164 258l10 11 20-24" stroke="' . $Q . '" stroke-width="1.6"/>
  <rect x="222" y="256" width="360" height="10" fill="rgba(243,240,233,.16)" stroke="none"/>
  <path d="M164 326l10 11 20-24" stroke="' . $Q . '" stroke-width="1.6"/>
  <rect x="222" y="324" width="300" height="10" fill="rgba(243,240,233,.16)" stroke="none"/>
  <path d="M162 388l24 24M186 388l-24 24" stroke="rgba(243,240,233,.5)" stroke-width="1.6"/>
  <rect x="222" y="392" width="330" height="10" fill="rgba(243,240,233,.3)" stroke="none"/>
  <path d="M164 462l10 11 20-24" stroke="' . $Q . '" stroke-width="1.6"/>
  <rect x="222" y="460" width="260" height="10" fill="rgba(243,240,233,.16)" stroke="none"/>
</g>
<path d="M880 180l160 292H720z" stroke="' . $Q . '" stroke-width="1.6"/>
<path d="M880 282v78" stroke="' . $Q . '" stroke-width="3"/>
<rect x="874" y="396" width="12" height="12" fill="' . $Q . '" stroke="none"/>
', 'Lámina sobre errores al contratar diseño web', $OBS, $R, $Q);

foreach ($archivos as $nombre => $contenido) {
    file_put_contents($img . '/' . $nombre, $contenido);
    echo '  ' . str_pad($nombre, 46) . round(strlen($contenido) / 1024, 1) . " KB\n";
}
echo "Láminas generadas.\n";
