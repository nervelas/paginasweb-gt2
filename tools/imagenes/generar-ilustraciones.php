<?php
/**
 * Ilustraciones SVG originales para las páginas de servicio y el blog.
 * Formas planas con la paleta de la marca. Sin texto, para que se vean
 * igual en cualquier navegador sin depender de tipografías externas.
 */

$root = dirname(dirname(__DIR__));
$img  = $root . '/public/assets/img';
@mkdir($img . '/blog', 0755, true);

$JADE = '#12796B'; $DEEP = '#0B5347'; $CORAL = '#FF7A45'; $INK = '#0A1F2C';
$PAPER = '#F7F3EC'; $GOLD = '#E4B85B'; $SOFT = '#E6F1EE'; $LINE = '#DFD8CC';

function svg($w, $h, $cuerpo, $titulo)
{
    return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ' . $w . ' ' . $h . '" width="' . $w . '" height="' . $h . '" role="img" aria-label="' . htmlspecialchars($titulo, ENT_QUOTES) . '">'
        . '<title>' . htmlspecialchars($titulo, ENT_QUOTES) . '</title>'
        . $cuerpo . '</svg>' . "\n";
}

function lineas($x, $y, $anchos, $color, $alto = 7, $sep = 12)
{
    $out = '';
    foreach ($anchos as $i => $w) {
        $out .= '<rect x="' . $x . '" y="' . ($y + $i * ($alto + $sep)) . '" width="' . $w . '" height="' . $alto . '" rx="' . ($alto / 2) . '" fill="' . $color . '"/>';
    }
    return $out;
}

$archivos = [];

// ------------------------------------------------- Servicio: páginas web
$archivos['servicio-paginas-web.svg'] = svg(440, 360, '
<rect x="30" y="34" width="330" height="248" rx="18" fill="' . $SOFT . '"/>
<rect x="58" y="60" width="330" height="248" rx="18" fill="#FFFFFF" stroke="' . $LINE . '" stroke-width="2"/>
<path d="M58 78a18 18 0 0 1 18-18h294a18 18 0 0 1 18 18v20H58z" fill="' . $INK . '"/>
<circle cx="80" cy="79" r="5" fill="' . $CORAL . '"/><circle cx="98" cy="79" r="5" fill="' . $GOLD . '"/><circle cx="116" cy="79" r="5" fill="' . $JADE . '"/>
<rect x="140" y="72" width="230" height="14" rx="7" fill="#FFFFFF" opacity=".16"/>
<rect x="82" y="120" width="150" height="16" rx="8" fill="' . $INK . '"/>
' . lineas(82, 152, [190, 160, 110], '#E4E9EC', 8, 11) . '
<rect x="82" y="212" width="96" height="30" rx="15" fill="' . $CORAL . '"/>
<rect x="190" y="212" width="72" height="30" rx="15" fill="none" stroke="' . $LINE . '" stroke-width="2"/>
<rect x="256" y="118" width="108" height="96" rx="14" fill="' . $JADE . '"/>
<rect x="286" y="146" width="48" height="40" rx="10" fill="#FFFFFF" opacity=".92"/>
<rect x="82" y="262" width="80" height="30" rx="10" fill="' . $SOFT . '"/>
<rect x="172" y="262" width="80" height="30" rx="10" fill="' . $SOFT . '"/>
<rect x="262" y="262" width="80" height="30" rx="10" fill="' . $SOFT . '"/>
<circle cx="374" cy="296" r="30" fill="' . $DEEP . '"/>
<path d="M362 296l8 8 16-17" stroke="#FFFFFF" stroke-width="4.4" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
', 'Ilustración de una página web con secciones ordenadas');

// -------------------------------------------- Servicio: tiendas virtuales
$archivos['servicio-tiendas-virtuales.svg'] = svg(440, 360, '
<rect x="34" y="60" width="300" height="230" rx="18" fill="#FFFFFF" stroke="' . $LINE . '" stroke-width="2"/>
<path d="M34 78a18 18 0 0 1 18-18h264a18 18 0 0 1 18 18v16H34z" fill="' . $SOFT . '"/>
<rect x="58" y="112" width="120" height="88" rx="12" fill="' . $SOFT . '"/>
<circle cx="118" cy="150" r="24" fill="' . $JADE . '"/>
<rect x="58" y="212" width="80" height="9" rx="4.5" fill="#DDE3E6"/>
<rect x="58" y="230" width="52" height="12" rx="6" fill="' . $INK . '"/>
<rect x="194" y="112" width="120" height="88" rx="12" fill="' . $SOFT . '"/>
<rect x="228" y="134" width="52" height="44" rx="10" fill="' . $GOLD . '"/>
<rect x="194" y="212" width="80" height="9" rx="4.5" fill="#DDE3E6"/>
<rect x="194" y="230" width="52" height="12" rx="6" fill="' . $INK . '"/>
<rect x="58" y="258" width="256" height="14" rx="7" fill="#EDF1F0"/>
<path d="M296 176h84a22 22 0 0 1 22 22v92a22 22 0 0 1-22 22h-84a22 22 0 0 1-22-22v-92a22 22 0 0 1 22-22z" fill="' . $INK . '"/>
<path d="M296 210h58" stroke="#FFFFFF" stroke-width="5" stroke-linecap="round" opacity=".35"/>
<path d="M300 250h76" stroke="' . $CORAL . '" stroke-width="9" stroke-linecap="round"/>
<path d="M300 274h50" stroke="#FFFFFF" stroke-width="6" stroke-linecap="round" opacity=".3"/>
<circle cx="146" cy="304" r="34" fill="' . $CORAL . '"/>
<path d="M132 292h5l4 20h18l4-14h-24" stroke="#FFFFFF" stroke-width="3.4" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
<circle cx="144" cy="318" r="2.6" fill="#FFFFFF"/><circle cx="155" cy="318" r="2.6" fill="#FFFFFF"/>
', 'Ilustración de una tienda en línea con carrito de compras');

// -------------------------------------------- Servicio: correo corporativo
$archivos['servicio-correo-corporativo.svg'] = svg(440, 360, '
<rect x="42" y="76" width="290" height="196" rx="18" fill="' . $SOFT . '"/>
<rect x="72" y="104" width="290" height="196" rx="18" fill="#FFFFFF" stroke="' . $LINE . '" stroke-width="2"/>
<path d="M74 122l143 100 143-100" stroke="' . $JADE . '" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M72 122a18 18 0 0 1 18-18h254a18 18 0 0 1 18 18" stroke="' . $LINE . '" stroke-width="2" fill="none"/>
<circle cx="356" cy="106" r="34" fill="' . $CORAL . '"/>
<path d="M366 100a13 13 0 1 0-4 20c4 2 9 1 12-1" stroke="#FFFFFF" stroke-width="3.4" fill="none" stroke-linecap="round"/>
<circle cx="356" cy="108" r="6.5" fill="none" stroke="#FFFFFF" stroke-width="3.2"/>
<rect x="110" y="246" width="150" height="9" rx="4.5" fill="#E4E9EC"/>
<rect x="110" y="266" width="96" height="9" rx="4.5" fill="#E4E9EC"/>
<rect x="86" y="308" width="180" height="34" rx="12" fill="' . $DEEP . '"/>
<path d="M104 325h8l4 6 6-14 5 8h10" stroke="#FFFFFF" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
<rect x="150" y="320" width="94" height="8" rx="4" fill="#FFFFFF" opacity=".3"/>
<rect x="292" y="286" width="86" height="60" rx="12" fill="' . $JADE . '"/>
<path d="M308 306h54M308 322h34" stroke="#FFFFFF" stroke-width="5" stroke-linecap="round" opacity=".82"/>
', 'Ilustración de bandeja de correo con dominio propio');

// --------------------------------------------------------- Blog: precios
$archivos['blog/precios-pagina-web-guatemala.svg'] = svg(800, 450, '
<rect width="800" height="450" fill="' . $PAPER . '"/>
<circle cx="672" cy="72" r="180" fill="' . $SOFT . '"/>
<rect x="80" y="112" width="300" height="230" rx="20" fill="#FFFFFF" stroke="' . $LINE . '" stroke-width="2"/>
<rect x="80" y="112" width="300" height="56" rx="20" fill="' . $INK . '"/>
<rect x="80" y="148" width="300" height="20" fill="' . $INK . '"/>
<rect x="112" y="132" width="120" height="16" rx="8" fill="#FFFFFF" opacity=".55"/>
<rect x="112" y="200" width="160" height="26" rx="13" fill="' . $JADE . '"/>
' . lineas(112, 248, [200, 170, 130], '#E4E9EC', 8, 12) . '
<rect x="112" y="304" width="120" height="18" rx="9" fill="' . $CORAL . '"/>
<g transform="translate(430 130)">
  <rect x="0" y="150" width="52" height="70" rx="10" fill="' . $SOFT . '"/>
  <rect x="70" y="104" width="52" height="116" rx="10" fill="' . $JADE . '"/>
  <rect x="140" y="56" width="52" height="164" rx="10" fill="' . $DEEP . '"/>
  <rect x="210" y="16" width="52" height="204" rx="10" fill="' . $CORAL . '"/>
</g>
<path d="M430 372h262" stroke="' . $LINE . '" stroke-width="3" stroke-linecap="round"/>
<circle cx="642" cy="112" r="42" fill="' . $GOLD . '"/>
<path d="M642 90v44M632 100h16a8 8 0 0 1 0 16h-14a8 8 0 0 0 0 16h18" stroke="#FFFFFF" stroke-width="4.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
', 'Ilustración sobre precios de páginas web en Guatemala');

// ----------------------------------------------------- Blog: crear tienda
$archivos['blog/crear-tienda-en-linea-guatemala.svg'] = svg(800, 450, '
<rect width="800" height="450" fill="' . $PAPER . '"/>
<circle cx="124" cy="392" r="170" fill="' . $SOFT . '"/>
<path d="M232 128h336l26 62H206z" fill="' . $CORAL . '"/>
<rect x="232" y="190" width="336" height="184" rx="14" fill="#FFFFFF" stroke="' . $LINE . '" stroke-width="2"/>
<rect x="262" y="222" width="126" height="90" rx="12" fill="' . $SOFT . '"/>
<circle cx="325" cy="262" r="26" fill="' . $JADE . '"/>
<rect x="412" y="222" width="126" height="90" rx="12" fill="' . $SOFT . '"/>
<rect x="446" y="246" width="58" height="46" rx="10" fill="' . $GOLD . '"/>
<rect x="262" y="330" width="126" height="14" rx="7" fill="#E4E9EC"/>
<rect x="412" y="330" width="86" height="14" rx="7" fill="#E4E9EC"/>
<g>
  <circle cx="140" cy="150" r="30" fill="' . $DEEP . '"/><path d="M128 150l8 9 16-18" stroke="#FFFFFF" stroke-width="4.4" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
  <circle cx="140" cy="228" r="30" fill="' . $JADE . '"/><path d="M128 228l8 9 16-18" stroke="#FFFFFF" stroke-width="4.4" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
  <circle cx="140" cy="306" r="30" fill="#FFFFFF" stroke="' . $LINE . '" stroke-width="2.6"/><circle cx="140" cy="306" r="8" fill="' . $CORAL . '"/>
  <path d="M140 180v18M140 258v18" stroke="' . $JADE . '" stroke-width="3.4" stroke-linecap="round" opacity=".5"/>
</g>
<rect x="612" y="240" width="112" height="150" rx="18" fill="' . $INK . '"/>
<rect x="626" y="262" width="84" height="106" rx="8" fill="#FFFFFF"/>
<rect x="638" y="276" width="60" height="34" rx="7" fill="' . $SOFT . '"/>
<rect x="638" y="320" width="60" height="9" rx="4.5" fill="#E4E9EC"/>
<rect x="638" y="338" width="40" height="14" rx="7" fill="' . $CORAL . '"/>
', 'Ilustración de los pasos para montar una tienda en línea');

// ---------------------------------------------- Blog: WooCommerce o Shopify
$archivos['blog/woocommerce-vs-shopify-guatemala.svg'] = svg(800, 450, '
<rect width="800" height="450" fill="' . $PAPER . '"/>
<rect x="70" y="88" width="290" height="274" rx="20" fill="#FFFFFF" stroke="' . $JADE . '" stroke-width="2.6"/>
<rect x="102" y="122" width="72" height="72" rx="18" fill="' . $JADE . '"/>
<path d="M120 158l10 11 20-22" stroke="#FFFFFF" stroke-width="5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
' . lineas(102, 222, [226, 190, 150, 200], '#E4E9EC', 9, 14) . '
<rect x="102" y="316" width="120" height="20" rx="10" fill="' . $DEEP . '"/>
<rect x="440" y="88" width="290" height="274" rx="20" fill="#FFFFFF" stroke="' . $LINE . '" stroke-width="2.6"/>
<rect x="472" y="122" width="72" height="72" rx="18" fill="' . $SOFT . '"/>
<circle cx="508" cy="158" r="17" fill="' . $GOLD . '"/>
' . lineas(472, 222, [226, 150, 190, 130], '#EAEEF0', 9, 14) . '
<rect x="472" y="316" width="120" height="20" rx="10" fill="' . $LINE . '"/>
<circle cx="400" cy="225" r="46" fill="' . $CORAL . '"/>
<path d="M384 208l32 34M416 208l-32 34" stroke="#FFFFFF" stroke-width="6" stroke-linecap="round"/>
', 'Comparación entre dos plataformas de comercio electrónico');

// --------------------------------------------------- Blog: cobro con tarjeta
$archivos['blog/cobrar-con-tarjeta-guatemala.svg'] = svg(800, 450, '
<rect width="800" height="450" fill="' . $PAPER . '"/>
<circle cx="668" cy="360" r="176" fill="' . $SOFT . '"/>
<rect x="96" y="128" width="330" height="204" rx="22" fill="' . $INK . '"/>
<rect x="96" y="180" width="330" height="36" fill="' . $DEEP . '"/>
<rect x="128" y="248" width="80" height="14" rx="7" fill="#FFFFFF" opacity=".5"/>
<rect x="224" y="248" width="80" height="14" rx="7" fill="#FFFFFF" opacity=".5"/>
<rect x="128" y="286" width="120" height="12" rx="6" fill="#FFFFFF" opacity=".3"/>
<circle cx="360" cy="292" r="24" fill="' . $CORAL . '"/><circle cx="392" cy="292" r="24" fill="' . $GOLD . '" opacity=".92"/>
<rect x="330" y="90" width="330" height="204" rx="22" fill="#FFFFFF" stroke="' . $LINE . '" stroke-width="2.6"/>
<rect x="330" y="142" width="330" height="36" fill="' . $JADE . '"/>
<rect x="362" y="210" width="80" height="14" rx="7" fill="#E4E9EC"/>
<rect x="458" y="210" width="80" height="14" rx="7" fill="#E4E9EC"/>
<rect x="362" y="248" width="130" height="12" rx="6" fill="#EDF1F2"/>
<rect x="576" y="228" width="56" height="40" rx="8" fill="' . $GOLD . '"/>
<path d="M576 242h56M594 228v40" stroke="#FFFFFF" stroke-width="2.6" opacity=".6"/>
<g transform="translate(556 300)">
  <rect width="176" height="118" rx="18" fill="' . $DEEP . '"/>
  <rect x="24" y="20" width="128" height="34" rx="8" fill="#FFFFFF" opacity=".9"/>
  <rect x="24" y="68" width="34" height="26" rx="6" fill="#FFFFFF" opacity=".28"/>
  <rect x="70" y="68" width="34" height="26" rx="6" fill="#FFFFFF" opacity=".28"/>
  <rect x="116" y="68" width="36" height="26" rx="6" fill="' . $CORAL . '"/>
</g>
', 'Ilustración de un pago con tarjeta en una tienda en línea');

// ------------------------------------------------------- Blog: dominio .gt
$archivos['blog/dominio-gt-guatemala.svg'] = svg(800, 450, '
<rect width="800" height="450" fill="' . $PAPER . '"/>
<circle cx="400" cy="228" r="146" fill="' . $SOFT . '"/>
<circle cx="400" cy="228" r="146" fill="none" stroke="' . $JADE . '" stroke-width="2.6" opacity=".5"/>
<path d="M254 228h292M400 82c46 46 46 246 0 292M400 82c-46 46-46 246 0 292" stroke="' . $JADE . '" stroke-width="2.6" fill="none" opacity=".45"/>
<path d="M286 148c68 30 160 30 228 0M286 308c68-30 160-30 228 0" stroke="' . $JADE . '" stroke-width="2.6" fill="none" opacity=".45"/>
<rect x="176" y="188" width="448" height="82" rx="41" fill="#FFFFFF" stroke="' . $LINE . '" stroke-width="2.6"/>
<path d="M222 224v-10a14 14 0 0 1 28 0v10" stroke="' . $JADE . '" stroke-width="4.4" fill="none" stroke-linecap="round"/>
<rect x="216" y="224" width="40" height="28" rx="7" fill="' . $JADE . '"/>
<rect x="282" y="216" width="164" height="18" rx="9" fill="' . $INK . '"/>
<rect x="282" y="242" width="98" height="10" rx="5" fill="#E4E9EC"/>
<rect x="464" y="210" width="120" height="40" rx="20" fill="' . $CORAL . '"/>
<path d="M496 230h56M534 216l18 14-18 14" stroke="#FFFFFF" stroke-width="4.4" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
<circle cx="180" cy="106" r="34" fill="' . $DEEP . '"/><path d="M168 106l8 9 16-18" stroke="#FFFFFF" stroke-width="4.4" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
<circle cx="626" cy="352" r="34" fill="' . $GOLD . '"/><path d="M626 336v22M626 368v.01" stroke="#FFFFFF" stroke-width="5" stroke-linecap="round"/>
', 'Ilustración de un dominio con extensión punto gt');

// ------------------------------------------------------- Blog: 7 errores
$archivos['blog/errores-contratar-diseno-web.svg'] = svg(800, 450, '
<rect width="800" height="450" fill="' . $PAPER . '"/>
<circle cx="700" cy="96" r="150" fill="' . $SOFT . '"/>
<rect x="140" y="76" width="380" height="308" rx="22" fill="#FFFFFF" stroke="' . $LINE . '" stroke-width="2.6"/>
<rect x="176" y="112" width="180" height="18" rx="9" fill="' . $INK . '"/>
<g>
  <circle cx="192" cy="176" r="17" fill="' . $DEEP . '"/><path d="M184 176l6 7 12-14" stroke="#FFFFFF" stroke-width="3.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
  <rect x="224" y="168" width="220" height="14" rx="7" fill="#E4E9EC"/>
  <circle cx="192" cy="228" r="17" fill="' . $DEEP . '"/><path d="M184 228l6 7 12-14" stroke="#FFFFFF" stroke-width="3.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
  <rect x="224" y="220" width="180" height="14" rx="7" fill="#E4E9EC"/>
  <circle cx="192" cy="280" r="17" fill="#F3E7E2"/><path d="M186 274l12 12M198 274l-12 12" stroke="#B4543A" stroke-width="3.6" stroke-linecap="round"/>
  <rect x="224" y="272" width="200" height="14" rx="7" fill="#F2DED8"/>
  <circle cx="192" cy="332" r="17" fill="' . $DEEP . '"/><path d="M184 332l6 7 12-14" stroke="#FFFFFF" stroke-width="3.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
  <rect x="224" y="324" width="150" height="14" rx="7" fill="#E4E9EC"/>
</g>
<g transform="translate(560 150)">
  <path d="M84 0l84 150H0z" fill="' . $CORAL . '"/>
  <path d="M84 52v52M84 122v.01" stroke="#FFFFFF" stroke-width="9" stroke-linecap="round"/>
</g>
<rect x="560" y="332" width="168" height="20" rx="10" fill="' . $LINE . '"/>
<rect x="560" y="366" width="112" height="20" rx="10" fill="' . $LINE . '" opacity=".6"/>
', 'Ilustración de una lista de verificación antes de contratar diseño web');

foreach ($archivos as $nombre => $contenido) {
    file_put_contents($img . '/' . $nombre, $contenido);
    echo '  ' . str_pad($nombre, 48) . round(strlen($contenido) / 1024, 1) . " KB\n";
}
echo "Ilustraciones generadas.\n";
