<?php
use App\Core\Settings;
$menu = isset($menuHeader) ? $menuHeader : [];
$path = isset($currentPath) ? $currentPath : '/';
?>
<header class="site-head">
  <div class="wrap site-head__in">
    <a class="brand" href="/" aria-label="<?php echo e(Settings::get('site_name')); ?> — ir al inicio">
      <img src="<?php echo e(Settings::get('logo_white', '/assets/img/marca.svg')); ?>"
           alt="<?php echo e(Settings::get('site_name')); ?>" width="188" height="26" fetchpriority="high">
    </a>

    <button class="burger" type="button" aria-expanded="false" aria-controls="nav" aria-label="Abrir el menú">
      <i></i>
    </button>

    <nav class="nav" id="nav" aria-label="Menú principal">
      <ul class="nav__list">
        <?php foreach ($menu as $item):
            $actual = rtrim($item['url'], '/') !== '' && rtrim($path, '/') === rtrim($item['url'], '/'); ?>
        <li>
          <a class="nav__link" href="<?php echo e($item['url']); ?>"<?php echo $actual ? ' aria-current="page"' : ''; ?>>
            <?php echo e($item['label']); ?>
          </a>
        </li>
        <?php endforeach; ?>
        <li class="nav__cta"><a class="btn btn--signal btn--block" href="/contacto/">Pedir cotización</a></li>
      </ul>
    </nav>

    <div class="head-cta">
      <a class="btn btn--signal btn--sm" href="/contacto/">Pedir cotización</a>
    </div>
  </div>
</header>
