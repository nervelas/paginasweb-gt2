<?php
/**
 * Arma una copia estática y navegable del sitio en un solo archivo HTML,
 * para revisarlo desde el celular sin necesidad de servidor.
 *
 * Uso: php tools/exportar-vista-previa.php http://127.0.0.1:8080 destino.html
 *
 * No sustituye al sitio: los formularios quedan inertes y el contenido es el
 * que había al momento de exportar.
 */

$base    = isset($argv[1]) ? rtrim($argv[1], '/') : 'http://127.0.0.1:8080';
$destino = isset($argv[2]) ? $argv[2] : dirname(__DIR__) . '/vista-previa.html';
$root    = dirname(__DIR__);

$rutas = [
    '/', '/diseno-de-paginas-web-guatemala/', '/tiendas-virtuales-guatemala/',
    '/precios/', '/cuentas-de-correo-corporativo/', '/portafolio/', '/nosotros/',
    '/preguntas-frecuentes/', '/contacto/', '/blog/',
    '/terminos-y-condiciones/', '/politica-de-privacidad/',
    '/blog/cuanto-cuesta-una-pagina-web-en-guatemala/',
    '/blog/como-crear-tienda-en-linea-guatemala/',
    '/blog/woocommerce-vs-shopify-guatemala/',
    '/blog/como-cobrar-con-tarjeta-sitio-web-guatemala/',
    '/blog/dominio-gt-como-registrarlo/',
    '/blog/errores-al-contratar-diseno-web-guatemala/',
    '/blog/categoria/precios/', '/blog/categoria/tiendas-en-linea/',
    '/blog/categoria/pagos/', '/blog/categoria/dominios-y-hosting/',
    '/blog/categoria/guias/',
];

function traer($url)
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 25]);
    $b = curl_exec($ch);
    $c = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $c === 200 ? (string) $b : null;
}

function tipoMime($archivo)
{
    $ext = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
    $map = ['webp' => 'image/webp', 'svg' => 'image/svg+xml', 'png' => 'image/png',
            'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'woff2' => 'font/woff2'];
    return isset($map[$ext]) ? $map[$ext] : 'application/octet-stream';
}

/** Convierte una ruta de /assets/... en un data URI. */
function incrustar($ruta, $root, &$pesos)
{
    $archivo = $root . '/public' . preg_replace('/\?.*$/', '', $ruta);
    if (!is_file($archivo)) {
        return null;
    }
    $datos = file_get_contents($archivo);
    $pesos[$ruta] = strlen($datos);
    return 'data:' . tipoMime($archivo) . ';base64,' . base64_encode($datos);
}

echo "Descargando páginas...\n";
$paginas = [];
foreach ($rutas as $r) {
    $html = traer($base . $r);
    if ($html === null) {
        echo "  omitida (no responde): {$r}\n";
        continue;
    }
    if (!preg_match('#<main id="contenido">(.*)</main>#s', $html, $m)) {
        echo "  omitida (sin contenido): {$r}\n";
        continue;
    }
    $paginas[$r] = trim($m[1]);
    // El título de cada página, para actualizar el de la pestaña al navegar
    preg_match('#<title>(.*?)</title>#s', $html, $t);
    $titulos[$r] = isset($t[1]) ? html_entity_decode(trim($t[1]), ENT_QUOTES, 'UTF-8') : 'paginasweb.gt';
}
echo '  ' . count($paginas) . " páginas\n";

// Cabecera, pie y acciones flotantes se toman una sola vez
$inicio = traer($base . '/');
preg_match('#(<header class="site-head">.*?</header>)#s', $inicio, $mh);
preg_match('#(<footer class="foot.*?</footer>)#s', $inicio, $mf);
preg_match('#(<div class="dock">.*?</div>\s*<script)#s', $inicio, $md);
$cabecera = $mh[1];
$pie      = $mf[1];
$dock     = str_replace('<script', '', $md[1]);

// -------------------------------------------------------------- Hoja de estilos
$css = file_get_contents($root . '/public/assets/css/site.min.css');
$pesos = [];
$css = preg_replace_callback("#url\('(/assets/fonts/[^']+)'\)#", function ($m) use ($root, &$pesos) {
    $uri = incrustar($m[1], $root, $pesos);
    return $uri ? "url('{$uri}')" : $m[0];
}, $css);

// ------------------------------------------------------------------ Documento
$cuerpo = '';
foreach ($paginas as $ruta => $html) {
    $cuerpo .= '<div class="pv-pagina" data-ruta="' . htmlspecialchars($ruta, ENT_QUOTES) . '" hidden>'
        . $html . '</div>' . "\n";
}

$doc = $cabecera . "\n" . '<main id="contenido">' . "\n" . $cuerpo . '</main>' . "\n" . $pie . "\n" . $dock;

// Imágenes a data URI
$doc = preg_replace_callback('#(src=")(/assets/[^"]+)(")#', function ($m) use ($root, &$pesos) {
    $uri = incrustar($m[2], $root, $pesos);
    return $uri ? $m[1] . $uri . $m[3] : $m[0];
}, $doc);
// La vista previa del portafolio también usa rutas de imagen
$doc = preg_replace_callback('#(data-shot=")(/assets/[^"]+)(")#', function ($m) use ($root, &$pesos) {
    $uri = incrustar($m[2], $root, $pesos);
    return $uri ? $m[1] . $uri . $m[3] : $m[0];
}, $doc);

// Enlaces internos a rutas con almohadilla
$doc = preg_replace_callback('~href="(/[^"\#]*)"~', function ($m) {
    $r = $m[1];
    if (strpos($r, '/assets/') === 0 || strpos($r, '/admin') === 0) {
        return 'href="#/"';
    }
    return 'href="#' . $r . '"';
}, $doc);

// El formulario no envía nada en la copia
$doc = str_replace('<form method="post" action="/contacto/" novalidate>',
                   '<form novalidate data-pv-inerte>', $doc);

$titulosJson = json_encode($titulos, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

$salida = <<<HTML
<title>paginasweb.gt</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
{$css}

/* ---------------------------------------- Barra propia de la vista previa */
.pv-barra {
  background: var(--obsidian); color: var(--on-dark-mute);
  border-bottom: 1px solid var(--rule-dark);
  font-family: var(--mono); font-size: .66rem; letter-spacing: .13em; text-transform: uppercase;
  padding: 11px 0;
}
.pv-barra .wrap { display: flex; flex-wrap: wrap; gap: 8px 22px; align-items: center; }
.pv-barra b { color: var(--quetzal); font-weight: 500; display: inline-flex; align-items: center; gap: .6em; }
.pv-barra b::before { content: ''; width: 6px; height: 6px; background: var(--quetzal); flex: none; }
.pv-barra span { color: var(--on-dark-faint); }
.pv-nota {
  margin-top: 14px; padding: 12px 16px;
  border-left: 2px solid var(--quetzal-ink); background: var(--quetzal-haze);
  font-family: var(--mono); font-size: .68rem; letter-spacing: .06em; line-height: 1.6;
  color: var(--on-bone-mute);
}
.pv-pagina[hidden] { display: none; }
@media (max-width: 620px) {
  .pv-barra { font-size: .6rem; letter-spacing: .09em; padding: 9px 0; }
  .pv-barra .wrap { gap: 6px 14px; }
  .pv-barra span:last-child { display: none; }
}
</style>

<div class="pv-barra">
  <div class="wrap">
    <b>Vista previa</b>
    <span>Copia estática · los formularios no envían</span>
    <span>El sitio real corre en PHP</span>
  </div>
</div>

{$doc}

<script>
(function () {
  'use strict';
  var titulos = {$titulosJson};
  var paginas = document.querySelectorAll('.pv-pagina');
  var enlacesNav = document.querySelectorAll('.nav__link');

  function ruta() {
    var h = location.hash.replace(/^#/, '');
    return h && h.charAt(0) === '/' ? h : '/';
  }

  function mostrar(r) {
    var encontrada = false;
    for (var i = 0; i < paginas.length; i++) {
      var coincide = paginas[i].getAttribute('data-ruta') === r;
      paginas[i].hidden = !coincide;
      if (coincide) { encontrada = true; }
    }
    if (!encontrada) {
      for (var j = 0; j < paginas.length; j++) {
        paginas[j].hidden = paginas[j].getAttribute('data-ruta') !== '/';
      }
      r = '/';
    }
    document.title = titulos[r] || 'paginasweb.gt';
    for (var k = 0; k < enlacesNav.length; k++) {
      var destino = (enlacesNav[k].getAttribute('href') || '').replace(/^#/, '');
      if (destino === r) { enlacesNav[k].setAttribute('aria-current', 'page'); }
      else { enlacesNav[k].removeAttribute('aria-current'); }
    }
    window.scrollTo(0, 0);
  }

  window.addEventListener('hashchange', function () { mostrar(ruta()); });
  mostrar(ruta());

  /* Menú en celular */
  var burger = document.querySelector('.burger');
  var nav = document.getElementById('nav');
  if (burger && nav) {
    var cerrar = function () {
      burger.setAttribute('aria-expanded', 'false');
      nav.classList.remove('open');
      document.documentElement.style.overflow = '';
    };
    burger.addEventListener('click', function () {
      if (burger.getAttribute('aria-expanded') === 'true') { cerrar(); return; }
      burger.setAttribute('aria-expanded', 'true');
      nav.classList.add('open');
      document.documentElement.style.overflow = 'hidden';
    });
    nav.addEventListener('click', function (e) { if (e.target.closest('a')) { cerrar(); } });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && nav.classList.contains('open')) { cerrar(); burger.focus(); }
    });
  }

  /* Acordeón: al abrir uno se cierran los otros de su grupo */
  var grupos = document.querySelectorAll('[data-accordion]');
  for (var g = 0; g < grupos.length; g++) {
    (function (grupo) {
      var items = grupo.querySelectorAll('details.qa__item');
      for (var d = 0; d < items.length; d++) {
        items[d].addEventListener('toggle', function () {
          if (!this.open) { return; }
          for (var o = 0; o < items.length; o++) { if (items[o] !== this) { items[o].open = false; } }
        });
      }
    })(grupos[g]);
  }

  /* El formulario avisa en lugar de enviar */
  var forms = document.querySelectorAll('[data-pv-inerte]');
  for (var f = 0; f < forms.length; f++) {
    (function (form) {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (form.querySelector('.pv-nota')) { return; }
        var nota = document.createElement('p');
        nota.className = 'pv-nota';
        nota.setAttribute('role', 'status');
        nota.textContent = 'Esta es una copia de vista previa: el formulario no envía. En el sitio publicado, este mensaje llega al correo configurado en el panel.';
        form.appendChild(nota);
      });
    })(forms[f]);
  }
})();
</script>
HTML;

file_put_contents($destino, $salida);

arsort($pesos);
$totalActivos = array_sum($pesos);
printf("\nArchivo: %s\n", $destino);
printf("Peso total: %s KB (recursos incrustados: %s KB, %d archivos)\n",
    number_format(filesize($destino) / 1024), number_format($totalActivos / 1024), count($pesos));
