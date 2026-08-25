<?php
/**
 * Genera las imágenes del sitio: mockups del portafolio, imagen del hero
 * e imágenes para redes sociales (Open Graph).
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
@mkdir($root . '/public/assets/img/portafolio', 0755, true);
@mkdir($root . '/public/assets/img/og', 0755, true);
@mkdir($root . '/public/assets/img/icons', 0755, true);

$FUENTE_M = 'file://' . $root . '/public/assets/fonts/manrope-latin-wght.woff2';
$FUENTE_F = 'file://' . $root . '/public/assets/fonts/fraunces-latin-wght.woff2';
$LOGO     = 'file://' . $root . '/public/assets/img/logo-paginasweb-gt.svg';
$LOGO_B   = 'file://' . $root . '/public/assets/img/logo-paginasweb-gt-blanco.svg';

/** Paleta derivada del dominio: cada proyecto tiene su propio matiz, estable. */
function paleta($semilla)
{
    $h = abs(crc32($semilla)) % 360;
    return [
        'h'   => $h,
        'bg'  => "hsl({$h}, 34%, 22%)",
        'bg2' => "hsl(" . (($h + 34) % 360) . ", 40%, 34%)",
        'ac'  => "hsl(" . (($h + 26) % 360) . ", 78%, 58%)",
        'sf'  => "hsl({$h}, 26%, 96%)",
    ];
}

function base_css($fm, $ff)
{
    return "
    @font-face{font-family:M;src:url('{$fm}') format('woff2-variations');font-weight:200 800}
    @font-face{font-family:F;src:url('{$ff}') format('woff2-variations');font-weight:300 900}
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:M,sans-serif;-webkit-font-smoothing:antialiased}
    ";
}

/** Captura una página HTML y devuelve la ruta del PNG. */
function capturar($chrome, $html, $destino, $w, $h, $escala = 1)
{
    $tmpFile = tempnam(sys_get_temp_dir(), 'pwgt') . '.html';
    file_put_contents($tmpFile, $html);
    $cmd = escapeshellcmd($chrome) . ' --headless --no-sandbox --disable-gpu --hide-scrollbars'
        . ' --force-device-scale-factor=' . $escala
        . ' --screenshot=' . escapeshellarg($destino)
        . ' --window-size=' . (int) $w . ',' . (int) $h
        . ' ' . escapeshellarg('file://' . $tmpFile) . ' 2>/dev/null';
    exec($cmd, $out, $ret);
    @unlink($tmpFile);
    return is_file($destino);
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

// ------------------------------------------------------------------------
// 1. Mockups del portafolio
// ------------------------------------------------------------------------
$proyectos = require $root . '/database/content/portfolio.php';
echo "Mockups del portafolio (" . count($proyectos) . "):\n";

foreach ($proyectos as $p) {
    $slug = str_replace('.', '-', $p['domain']);
    $c = paleta($p['domain']);
    $inicial = mb_strtoupper(mb_substr($p['name'], 0, 1));
    $nombre = htmlspecialchars($p['name'], ENT_QUOTES);
    $dominio = htmlspecialchars($p['domain'], ENT_QUOTES);
    $sector = htmlspecialchars($p['sector'], ENT_QUOTES);
    $css = base_css($FUENTE_M, $FUENTE_F);

    $html = <<<HTML
<!doctype html><html><head><meta charset="utf-8"><style>
{$css}
body{width:640px;height:400px;background:linear-gradient(145deg,{$c['bg']},{$c['bg2']});
  display:grid;place-items:center;overflow:hidden}
.win{width:530px;background:#fff;border-radius:11px;overflow:hidden;
  box-shadow:0 26px 60px rgba(0,0,0,.34),0 4px 12px rgba(0,0,0,.2);transform:translateY(14px)}
.bar{height:31px;background:#EDECE9;display:flex;align-items:center;gap:6px;padding:0 12px;border-bottom:1px solid #DEDCD7}
.dot{width:8px;height:8px;border-radius:50%}
.url{flex:1;margin-left:8px;height:17px;background:#fff;border-radius:9px;display:flex;align-items:center;
  padding:0 9px;font-size:9px;color:#6B7F87;font-weight:600;letter-spacing:.01em}
.lock{width:6px;height:7px;border:1.4px solid #12796B;border-bottom:none;border-radius:2px 2px 0 0;margin-right:5px}
.page{height:262px;background:#fff;position:relative;overflow:hidden}
.nav{height:34px;display:flex;align-items:center;padding:0 18px;gap:7px;border-bottom:1px solid #F0EEEA}
.mark{width:17px;height:17px;border-radius:5px;background:{$c['bg']};color:#fff;font-size:9px;font-weight:800;
  display:grid;place-items:center}
.brand{font-size:9.5px;font-weight:800;color:#1B2A33;letter-spacing:-.01em}
.links{margin-left:auto;display:flex;gap:9px}
.links i{display:block;width:23px;height:4px;border-radius:2px;background:#DDE3E6}
.btn{width:38px;height:12px;border-radius:6px;background:{$c['ac']}}
.hero{padding:20px 18px 0;display:grid;grid-template-columns:1fr 106px;gap:14px;align-items:center}
.h1{font-size:15px;font-weight:800;line-height:1.18;color:#12202A;letter-spacing:-.02em}
.h1 em{font-style:normal;color:{$c['bg']}}
.p{margin-top:6px;display:grid;gap:3.5px}
.p i{display:block;height:4px;border-radius:2px;background:#E4E9EC}
.p i:nth-child(2){width:88%}.p i:nth-child(3){width:64%}
.cta{margin-top:10px;display:flex;gap:6px}
.cta b{display:block;width:56px;height:15px;border-radius:8px;background:{$c['ac']}}
.cta s{display:block;width:44px;height:15px;border-radius:8px;border:1.3px solid #D8DEE1}
.shape{height:82px;border-radius:9px;background:linear-gradient(150deg,{$c['bg']},{$c['bg2']});
  display:grid;place-items:center;color:#fff;font-family:F;font-size:30px;font-weight:600}
.cards{margin-top:16px;padding:0 18px;display:grid;grid-template-columns:repeat(3,1fr);gap:9px}
.card{background:{$c['sf']};border-radius:7px;padding:9px}
.card u{display:block;width:15px;height:15px;border-radius:4px;background:{$c['bg']};opacity:.85;margin-bottom:6px}
.card i{display:block;height:3.5px;border-radius:2px;background:#D9E0E4;margin-bottom:3.5px}
.card i:last-child{width:62%}
.tag{position:absolute;left:0;right:0;bottom:0;padding:6px 18px;background:{$c['bg']};color:#fff;
  font-size:7.5px;letter-spacing:.14em;text-transform:uppercase;font-weight:700;opacity:.95}
</style></head><body>
<div class="win">
  <div class="bar">
    <span class="dot" style="background:#FF5F57"></span>
    <span class="dot" style="background:#FEBC2E"></span>
    <span class="dot" style="background:#28C840"></span>
    <span class="url"><span class="lock"></span>{$dominio}</span>
  </div>
  <div class="page">
    <div class="nav">
      <span class="mark">{$inicial}</span>
      <span class="brand">{$nombre}</span>
      <span class="links"><i></i><i></i><i></i></span>
      <span class="btn"></span>
    </div>
    <div class="hero">
      <div>
        <div class="h1">{$nombre}<br><em>{$sector}</em></div>
        <div class="p"><i></i><i></i><i></i></div>
        <div class="cta"><b></b><s></s></div>
      </div>
      <div class="shape">{$inicial}</div>
    </div>
    <div class="cards">
      <div class="card"><u></u><i></i><i></i></div>
      <div class="card"><u></u><i></i><i></i></div>
      <div class="card"><u></u><i></i><i></i></div>
    </div>
    <div class="tag">{$sector}</div>
  </div>
</div>
</body></html>
HTML;

    $png  = $tmp . '/' . $slug . '.png';
    $webp = $root . '/public/assets/img/portafolio/' . $slug . '.webp';
    if (capturar($chrome, $html, $png, 640, 400, 1) && a_webp($png, $webp, 80)) {
        echo '  ' . str_pad($slug, 34) . ' ' . round(filesize($webp) / 1024) . " KB\n";
    } else {
        echo "  FALLÓ: {$slug}\n";
    }
}

echo "Listo.\n";

// ------------------------------------------------------------------------
// 2. Imagen del hero: laptop y celular con un sitio de nuestro estilo
// ------------------------------------------------------------------------
echo "\nImagen del hero:\n";
$css = base_css($FUENTE_M, $FUENTE_F);
$heroHtml = <<<HTML
<!doctype html><html><head><meta charset="utf-8"><style>
{$css}
html{zoom:2}
body{width:720px;height:540px;background:linear-gradient(150deg,#EAF2F0 0%,#F7F3EC 52%,#FDEEE6 100%);
  position:relative;overflow:hidden}
body::before{content:'';position:absolute;width:420px;height:420px;border-radius:50%;
  background:radial-gradient(circle,rgba(18,121,107,.16),transparent 68%);top:-120px;right:-90px}
body::after{content:'';position:absolute;width:340px;height:340px;border-radius:50%;
  background:radial-gradient(circle,rgba(255,122,69,.18),transparent 66%);bottom:-110px;left:-80px}
.escena{position:absolute;inset:0;display:grid;place-items:center}
.laptop{position:relative;width:540px;transform:translate(-18px,-16px)}
.pantalla{background:#0A1F2C;border-radius:14px 14px 5px 5px;padding:11px 11px 15px;
  box-shadow:0 30px 60px rgba(10,31,44,.26),0 8px 20px rgba(10,31,44,.16)}
.viewport{background:#F7F3EC;border-radius:6px;height:312px;overflow:hidden;position:relative}
.base{height:11px;background:linear-gradient(#CFD6D9,#A8B5BA);border-radius:0 0 12px 12px;
  width:640px;margin:0 auto;position:relative;left:-50px}
.base::after{content:'';position:absolute;left:50%;top:0;transform:translateX(-50%);
  width:78px;height:4px;background:#8E9DA4;border-radius:0 0 5px 5px}
.top{height:34px;display:flex;align-items:center;padding:0 18px;gap:8px;background:#F7F3EC;
  border-bottom:1px solid #E7E0D4}
.logo{height:15px}
.menu{margin-left:auto;display:flex;gap:10px;align-items:center}
.menu i{display:block;width:28px;height:4.5px;border-radius:3px;background:#CBD4D8}
.menu b{display:block;width:56px;height:16px;border-radius:9px;background:#FF7A45}
.contenido{padding:20px 20px 0;display:grid;grid-template-columns:1fr 150px;gap:16px;align-items:center}
.titulo{font-family:F;font-size:22px;font-weight:600;line-height:1.13;color:#0A1F2C;letter-spacing:-.025em}
.titulo em{font-style:italic;color:#0B5347;display:block}
.parrafo{margin-top:9px;display:grid;gap:4.5px}
.parrafo i{display:block;height:5px;border-radius:3px;background:#DCE3E1}
.parrafo i:nth-child(2){width:86%}.parrafo i:nth-child(3){width:58%}
.acciones{margin-top:13px;display:flex;gap:8px}
.acciones b{display:block;width:86px;height:21px;border-radius:11px;background:#FF7A45}
.acciones s{display:block;width:64px;height:21px;border-radius:11px;border:1.6px solid #DFD8CC}
.grafico{height:120px;border-radius:11px;background:linear-gradient(150deg,#12796B,#0B5347);
  display:grid;place-items:center;box-shadow:0 12px 24px rgba(11,83,71,.28)}
.grafico span{width:56px;height:56px;border-radius:16px;background:rgba(255,255,255,.94)}
.tarjetas{margin-top:18px;padding:0 20px;display:grid;grid-template-columns:repeat(3,1fr);gap:10px}
.t{background:#fff;border:1px solid #EDE7DC;border-radius:9px;padding:11px}
.t u{display:block;width:20px;height:20px;border-radius:6px;background:#E6F1EE;margin-bottom:8px}
.t i{display:block;height:4.5px;border-radius:3px;background:#E4E9EC;margin-bottom:4px}
.t i:last-child{width:60%}
.celular{position:absolute;right:20px;bottom:26px;width:154px;background:#0A1F2C;border-radius:20px;
  padding:7px;box-shadow:0 26px 50px rgba(10,31,44,.30)}
.cel-view{background:#fff;border-radius:14px;height:280px;overflow:hidden;position:relative}
.cel-notch{position:absolute;left:50%;transform:translateX(-50%);top:5px;width:44px;height:5px;
  background:#0A1F2C;border-radius:4px;z-index:2}
.cel-top{height:30px;background:#F7F3EC;border-bottom:1px solid #EDE7DC;display:flex;align-items:center;
  justify-content:center;padding-top:6px}
.cel-top img{height:11px}
.cel-hero{padding:12px 11px 0}
.cel-h1{font-family:F;font-size:13px;font-weight:600;line-height:1.15;color:#0A1F2C;letter-spacing:-.02em}
.cel-p{margin-top:6px;display:grid;gap:3.5px}
.cel-p i{display:block;height:4px;border-radius:2px;background:#DFE5E4}
.cel-p i:nth-child(2){width:76%}
.cel-btn{margin-top:9px;height:20px;border-radius:11px;background:#FF7A45}
.cel-img{margin:10px 11px 0;height:62px;border-radius:9px;background:linear-gradient(150deg,#12796B,#0B5347)}
.cel-lista{margin:9px 11px 0;display:grid;gap:5px}
.cel-lista i{display:block;height:16px;border-radius:6px;background:#F1EEE7}
.wa{position:absolute;right:8px;bottom:8px;width:26px;height:26px;border-radius:50%;background:#25D366;
  display:grid;place-items:center;box-shadow:0 5px 12px rgba(37,211,102,.45)}
.wa svg{width:15px;height:15px}
</style></head><body>
<div class="escena">
  <div class="laptop">
    <div class="pantalla">
      <div class="viewport">
        <div class="top">
          <img class="logo" src="{$LOGO}" alt="">
          <span class="menu"><i></i><i></i><i></i><b></b></span>
        </div>
        <div class="contenido">
          <div>
            <div class="titulo">Páginas web<em>para tu negocio</em></div>
            <div class="parrafo"><i></i><i></i><i></i></div>
            <div class="acciones"><b></b><s></s></div>
          </div>
          <div class="grafico"><span></span></div>
        </div>
        <div class="tarjetas">
          <div class="t"><u></u><i></i><i></i></div>
          <div class="t"><u></u><i></i><i></i></div>
          <div class="t"><u></u><i></i><i></i></div>
        </div>
      </div>
    </div>
    <div class="base"></div>
  </div>
  <div class="celular">
    <div class="cel-view">
      <span class="cel-notch"></span>
      <div class="cel-top"><img src="{$LOGO}" alt=""></div>
      <div class="cel-hero">
        <div class="cel-h1">Tu sitio, listo para el celular</div>
        <div class="cel-p"><i></i><i></i></div>
        <div class="cel-btn"></div>
      </div>
      <div class="cel-img"></div>
      <div class="cel-lista"><i></i><i></i><i></i></div>
      <span class="wa"><svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.8a9.1 9.1 0 0 0-7.8 13.8L2.8 21.2l4.7-1.3A9.1 9.1 0 1 0 12 2.8z"/></svg></span>
    </div>
  </div>
</div>
</body></html>
HTML;
$png = $tmp . '/hero.png';
if (capturar($chrome, $heroHtml, $png, 1440, 1080, 1) && a_webp($png, $root . '/public/assets/img/hero-sitio-en-celular-y-laptop.webp', 84)) {
    echo '  hero-sitio-en-celular-y-laptop.webp  ' . round(filesize($root . '/public/assets/img/hero-sitio-en-celular-y-laptop.webp') / 1024) . " KB\n";
} else {
    echo "  FALLÓ el hero\n";
}

// ------------------------------------------------------------------------
// 3. Imágenes Open Graph (1200x630)
// ------------------------------------------------------------------------
echo "\nImágenes para redes sociales:\n";
$ogs = [
    'og-inicio'               => ['Páginas web en Guatemala', 'Diseño a la medida con dominio, hosting y soporte incluidos', 'Desde Q1,250 al año'],
    'og-diseno-paginas-web'   => ['Diseño de páginas web', 'Estructura, textos y configuración técnica para tu negocio', 'Q1,250 al año'],
    'og-tiendas-virtuales'    => ['Tiendas virtuales', 'WooCommerce, envíos y cobro con tarjeta para Guatemala', 'Q1,750 al año'],
    'og-precios'              => ['Precios 2026', 'Lo que cuesta cada servicio, en quetzales y sin letra chiquita', 'Página web · Tienda · Correo'],
    'og-correo-corporativo'   => ['Correo corporativo', 'Cuentas con tu propio dominio, configuradas y sin spam', 'Consultá el precio'],
    'og-portafolio'           => ['Portafolio', 'Sitios de clientes guatemaltecos que están en línea hoy', '24 proyectos'],
    'og-nosotros'             => ['Quiénes somos', 'Una marca de Servicom, diseñando sitios desde 2007', '18+ años'],
    'og-preguntas-frecuentes' => ['Preguntas frecuentes', 'Dominios, hosting, tiempos, pagos y renovaciones', 'Respuestas claras'],
    'og-contacto'             => ['Contacto y cotización', 'Contanos qué necesitás y te respondemos con una propuesta', 'WhatsApp y formulario'],
    'og-blog'                 => ['Guías y artículos', 'Precios, tiendas en línea, pasarelas de pago y dominios .gt', 'Blog'],
];

foreach ($ogs as $slug => $t) {
    $titulo = htmlspecialchars($t[0], ENT_QUOTES);
    $bajada = htmlspecialchars($t[1], ENT_QUOTES);
    $pastilla = htmlspecialchars($t[2], ENT_QUOTES);
    $css = base_css($FUENTE_M, $FUENTE_F);
    $html = <<<HTML
<!doctype html><html><head><meta charset="utf-8"><style>
{$css}
body{width:1200px;height:630px;background:#0A1F2C;color:#fff;position:relative;overflow:hidden;
  padding:76px 84px;display:flex;flex-direction:column;justify-content:space-between}
body::before{content:'';position:absolute;width:760px;height:760px;border-radius:50%;right:-240px;top:-300px;
  background:radial-gradient(circle,rgba(18,121,107,.62),transparent 66%)}
body::after{content:'';position:absolute;width:560px;height:560px;border-radius:50%;left:-200px;bottom:-260px;
  background:radial-gradient(circle,rgba(255,122,69,.34),transparent 66%)}
.c{position:relative;z-index:2}
.logo{height:44px}
h1{font-family:F;font-size:70px;font-weight:600;line-height:1.05;letter-spacing:-.03em;max-width:19ch}
p{font-size:27px;color:#B7CBD3;margin-top:22px;max-width:30ch;line-height:1.4}
.pill{display:inline-block;margin-top:0;background:#FF7A45;color:#fff;font-size:22px;font-weight:800;
  padding:13px 26px;border-radius:999px;letter-spacing:-.01em}
.pie{display:flex;align-items:center;justify-content:space-between;gap:20px}
.dom{font-size:23px;font-weight:700;color:#8FA9B4;letter-spacing:.02em}
.linea{position:absolute;left:0;right:0;bottom:0;height:9px;
  background:linear-gradient(90deg,#12796B 0%,#12796B 46%,#E4B85B 46%,#E4B85B 62%,#FF7A45 62%)}
</style></head><body>
<div class="c"><img class="logo" src="{$LOGO_B}" alt=""></div>
<div class="c">
  <h1>{$titulo}</h1>
  <p>{$bajada}</p>
</div>
<div class="c pie">
  <span class="pill">{$pastilla}</span>
  <span class="dom">paginasweb.gt</span>
</div>
<span class="linea"></span>
</body></html>
HTML;
    $png  = $tmp . '/' . $slug . '.png';
    $webp = $root . '/public/assets/img/og/' . $slug . '.webp';
    if (capturar($chrome, $html, $png, 1200, 630, 1) && a_webp($png, $webp, 86)) {
        echo '  ' . str_pad($slug, 28) . ' ' . round(filesize($webp) / 1024) . " KB\n";
    } else {
        echo "  FALLÓ: {$slug}\n";
    }
}

// ------------------------------------------------------------------------
// 4. Iconos PNG para PWA y dispositivos Apple
// ------------------------------------------------------------------------
echo "\nIconos de la aplicación:\n";
$iconoSvg = 'file://' . $root . '/public/assets/img/icons/marca-cuadrada.svg';
foreach ([180, 192, 512] as $tam) {
    $html = '<!doctype html><html><head><style>*{margin:0;padding:0}body{width:' . $tam . 'px;height:' . $tam . 'px;overflow:hidden}img{width:' . $tam . 'px;height:' . $tam . 'px;display:block}</style></head><body><img src="' . $iconoSvg . '" alt=""></body></html>';
    $destino = $root . '/public/assets/img/icons/icono-' . $tam . '.png';
    if (capturar($chrome, $html, $destino, $tam, $tam, 1)) {
        echo '  icono-' . $tam . ".png\n";
    }
}
echo "\nTodo listo.\n";
