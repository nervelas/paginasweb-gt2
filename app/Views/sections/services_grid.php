<?php
use App\Models\Content;
$servicios = Content::services();
?>
<section class="section section--white reveal">
  <div class="wrap">
    <div class="section-head">
      <?php if ($section['eyebrow']): ?><p class="eyebrow"><?php echo e($section['eyebrow']); ?></p><?php endif; ?>
      <h2><?php echo e($section['heading']); ?></h2>
      <?php if ($section['subheading']): ?><p class="sub"><?php echo e($section['subheading']); ?></p><?php endif; ?>
    </div>
    <div class="grid grid--3">
      <?php foreach ($servicios as $servicio):
        $planes = Content::plans($servicio['id']);
        $primero = isset($planes[0]) ? $planes[0] : null;
      ?>
      <a class="card card--link service-card" href="/<?php echo e($servicio['page_slug']); ?>/">
        <span class="service-card__icon"><?php echo partial('partials/icon', ['name' => $servicio['icon'], 'size' => 26]); ?></span>
        <h3><?php echo e($servicio['name']); ?></h3>
        <p><?php echo e($servicio['tagline']); ?></p>
        <span class="service-card__more">
          Ver el servicio <?php echo partial('partials/icon', ['name' => 'arrow', 'size' => 15]); ?>
        </span>
        <?php if ($primero): ?>
        <span class="service-card__price">
          Desde <strong><?php echo $primero['price'] !== null ? e(money($primero['price'])) : e($primero['price_text']); ?></strong>
          <?php echo e($primero['period']); ?>
        </span>
        <?php endif; ?>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
