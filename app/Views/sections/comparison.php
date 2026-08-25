<?php $x = isset($section['extra']) ? $section['extra'] : []; ?>
<section class="section reveal">
  <div class="wrap">
    <div class="section-head">
      <?php if ($section['eyebrow']): ?><p class="eyebrow"><?php echo e($section['eyebrow']); ?></p><?php endif; ?>
      <h2><?php echo e($section['heading']); ?></h2>
      <?php if ($section['subheading']): ?><p class="sub"><?php echo e($section['subheading']); ?></p><?php endif; ?>
    </div>
    <div class="compare">
      <div class="compare__col compare__col--yes">
        <h3><?php echo e(isset($x['yes_title']) ? $x['yes_title'] : 'Lo que sí hacemos'); ?></h3>
        <ul><?php foreach ($x['yes'] as $item): ?><li><?php echo e($item); ?></li><?php endforeach; ?></ul>
      </div>
      <div class="compare__col compare__col--no">
        <h3><?php echo e(isset($x['no_title']) ? $x['no_title'] : 'Lo que no'); ?></h3>
        <ul><?php foreach ($x['no'] as $item): ?><li><?php echo e($item); ?></li><?php endforeach; ?></ul>
      </div>
    </div>
  </div>
</section>
