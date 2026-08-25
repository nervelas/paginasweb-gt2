<?php $links = isset($section['extra']['links']) ? $section['extra']['links'] : []; ?>
<?php if ($links): ?>
<?php echo partial('partials/band-open', ['lienzo' => $lienzo, 'regla' => $regla, 'tight' => true]); ?>
  <?php if ($section['heading']): ?>
  <div class="head rise"><div>
    <p class="tag" data-num="<?php echo e($n); ?>">Seguir</p>
    <h2 style="font-size:clamp(1.6rem,2.6vw,2.2rem)"><?php echo e($section['heading']); ?></h2>
  </div></div>
  <?php endif; ?>
  <div class="jump rise">
    <?php foreach ($links as $l): ?>
    <a class="jump__item" href="<?php echo e($l['url']); ?>">
      <i>Ir</i>
      <b><?php echo e($l['title']); ?></b>
      <span><?php echo e($l['text']); ?></span>
    </a>
    <?php endforeach; ?>
  </div>
<?php echo partial('partials/band-close'); ?>
<?php endif; ?>
