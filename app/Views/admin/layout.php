<?php
use App\Core\Settings;
$menu = [
    ['url' => '/admin/',               'label' => 'Escritorio',   'icono' => 'retícula'],
    ['url' => '/admin/paginas/',       'label' => 'Páginas',      'icono' => 'navegador'],
    ['url' => '/admin/servicios/',     'label' => 'Servicios',    'icono' => 'caja'],
    ['url' => '/admin/planes/',        'label' => 'Precios',      'icono' => 'grafica'],
    ['url' => '/admin/portafolio/',    'label' => 'Portafolio',   'icono' => 'imagen'],
    ['url' => '/admin/blog/',          'label' => 'Blog',         'icono' => 'lapiz'],
    ['url' => '/admin/categorias/',    'label' => 'Categorías',   'icono' => 'archivo'],
    ['url' => '/admin/faq/',           'label' => 'Preguntas',    'icono' => 'chat'],
    ['url' => '/admin/testimonios/',   'label' => 'Testimonios',  'icono' => 'escudo'],
    ['url' => '/admin/medios/',        'label' => 'Medios',       'icono' => 'imagen'],
    ['url' => '/admin/menus/',         'label' => 'Menús',        'icono' => 'retícula'],
    ['url' => '/admin/mensajes/',      'label' => 'Mensajes',     'icono' => 'sobre', 'contador' => $pendientes],
    ['url' => '/admin/redirecciones/', 'label' => 'Redirecciones','icono' => 'flecha'],
    ['url' => '/admin/configuracion/', 'label' => 'Configuración','icono' => 'escudo'],
    ['url' => '/admin/herramientas/',  'label' => 'Herramientas', 'icono' => 'rayo'],
];
$actual = isset($currentPath) ? $currentPath : '/admin/';
$aviso  = flash();
?><!DOCTYPE html>
<html lang="es-GT">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?php echo e($titulo); ?> · Panel de <?php echo e(Settings::get('site_name')); ?></title>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="<?php echo asset('css/admin.min.css'); ?>">
</head>
<body>
<a class="skip" href="#panel">Saltar al contenido</a>
<header class="ad-top">
  <button class="ad-burger" type="button" aria-expanded="false" aria-controls="ad-nav" aria-label="Abrir menú">
    <span></span>
  </button>
  <a class="ad-marca" href="/admin/">
    <img src="/assets/img/marca.svg" alt="" width="174" height="24">
    <span>Panel</span>
  </a>
  <div class="ad-top__acciones">
    <a class="ad-btn ad-btn--fantasma" href="/" target="_blank" rel="noopener">Ver el sitio</a>
    <a class="ad-btn ad-btn--fantasma" href="/admin/cuenta/"><?php echo e(isset($usuario['name']) ? $usuario['name'] : 'Mi cuenta'); ?></a>
    <a class="ad-btn" href="/admin/salir/">Salir</a>
  </div>
</header>

<div class="ad-shell">
  <nav class="ad-nav" id="ad-nav" aria-label="Secciones del panel">
    <ul>
      <?php foreach ($menu as $item):
        $on = $item['url'] === '/admin/' ? $actual === '/admin/' : strpos($actual, $item['url']) === 0; ?>
      <li>
        <a href="<?php echo e($item['url']); ?>"<?php echo $on ? ' aria-current="page"' : ''; ?>>
          <?php echo partial('partials/icon', ['name' => $item['icono'], 'size' => 18]); ?>
          <span><?php echo e($item['label']); ?></span>
          <?php if (!empty($item['contador'])): ?><em><?php echo (int) $item['contador']; ?></em><?php endif; ?>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
  </nav>

  <main class="ad-main" id="panel">
    <?php if ($aviso): ?>
    <div class="ad-aviso ad-aviso--<?php echo $aviso['type'] === 'error' ? 'error' : 'ok'; ?>" role="status">
      <?php echo e($aviso['message']); ?>
    </div>
    <?php endif; ?>
    <?php echo $content; ?>
  </main>
</div>
<script src="<?php echo asset('js/admin.min.js'); ?>" defer></script>
</body>
</html>
