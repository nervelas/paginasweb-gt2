<?php echo partial('partials/band-open', ['lienzo' => $lienzo, 'regla' => $regla, 'tight' => true]); ?>
  <div class="essay rise">
    <div class="essay__aside">
      <?php if ($section['eyebrow']): ?>
      <p class="tag" data-num="<?php echo e($n); ?>"><?php echo e($section['eyebrow']); ?></p>
      <?php endif; ?>
      <?php if ($section['heading']): ?><h2><?php echo e($section['heading']); ?></h2><?php endif; ?>
      <?php if ($section['subheading']): ?><p class="lede"><?php echo e($section['subheading']); ?></p><?php endif; ?>
    </div>
    <div class="essay__body">
      <div class="prose"><?php echo $section['body']; ?></div>
    </div>
  </div>
<?php echo partial('partials/band-close'); ?>
