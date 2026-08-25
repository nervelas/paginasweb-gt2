<?php
use App\Models\Content;
$servicios = Content::services();
?>
<?php echo partial('partials/band-open', ['lienzo' => $lienzo, 'regla' => $regla]); ?>
  <?php echo partial('partials/head-block', ['section' => $section, 'n' => $n, 'split' => true]); ?>
  <div class="rows rise">
    <?php foreach ($servicios as $i => $s):
      $planes = Content::plans($s['id']);
      $p = isset($planes[0]) ? $planes[0] : null; ?>
    <article class="row">
      <span class="row__n"><?php echo str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT); ?></span>
      <h3 class="row__title">
        <a class="row__link" href="/<?php echo e($s['page_slug']); ?>/"><?php echo e($s['name']); ?></a>
      </h3>
      <p class="row__text"><?php echo e($s['tagline']); ?></p>
      <div class="row__meta">
        <?php if ($p): ?>
        <span class="row__price">
          <?php echo $p['price'] !== null ? e(money($p['price'])) : e($p['price_text']); ?>
          <small><?php echo e($p['period']); ?></small>
        </span>
        <?php endif; ?>
      </div>
      <span class="row__go" aria-hidden="true"><?php echo partial('partials/icon', ['name' => 'flecha', 'size' => 22]); ?></span>
    </article>
    <?php endforeach; ?>
  </div>
<?php echo partial('partials/band-close'); ?>
