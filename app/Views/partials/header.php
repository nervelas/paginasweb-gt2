<?php
use App\Core\Settings;
$menu = isset($menuHeader) ? $menuHeader : [];
$path = isset($currentPath) ? $currentPath : '/';
?>
<header class="site-header">
  <div class="wrap site-header__inner">
    <a class="brand" href="/" aria-label="<?php echo e(Settings::get('site_name')); ?> — inicio">
      <img src="<?php echo e(Settings::get('logo', '/assets/img/logo-paginasweb-gt.svg')); ?>"
           alt="<?php echo e(Settings::get('site_name')); ?>" width="196" height="34" fetchpriority="high">
    </a>

    <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="nav-principal" aria-label="Abrir menú">
      <span></span>
    </button>

    <nav class="nav" id="nav-principal" aria-label="Menú principal">
      <ul>
        <?php foreach ($menu as $item):
            $isCurrent = rtrim($item['url'], '/') !== '' && rtrim($path, '/') === rtrim($item['url'], '/');
        ?>
        <li><a href="<?php echo e($item['url']); ?>"<?php echo $isCurrent ? ' aria-current="page"' : ''; ?>><?php echo e($item['label']); ?></a></li>
        <?php endforeach; ?>
        <li class="nav-cta"><a class="btn btn--primary btn--sm btn--block" href="/contacto/">Pedir cotización</a></li>
      </ul>
    </nav>

    <div class="header-cta">
      <a class="btn btn--primary btn--sm" href="/contacto/">Pedir cotización</a>
    </div>
  </div>
</header>
