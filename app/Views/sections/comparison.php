<?php $x = isset($section['extra']) ? $section['extra'] : []; ?>
<?php echo partial('partials/band-open', ['lienzo' => $lienzo, 'regla' => $regla]); ?>
  <?php echo partial('partials/head-block', ['section' => $section, 'n' => $n, 'split' => true]); ?>
  <div class="versus rise">
    <div class="versus__col versus__col--yes">
      <h3><?php echo e(isset($x['yes_title']) ? $x['yes_title'] : 'Lo que sí hacemos'); ?></h3>
      <ul><?php foreach ($x['yes'] as $i): ?><li><?php echo e($i); ?></li><?php endforeach; ?></ul>
    </div>
    <div class="versus__col versus__col--no">
      <h3><?php echo e(isset($x['no_title']) ? $x['no_title'] : 'Lo que no'); ?></h3>
      <ul><?php foreach ($x['no'] as $i): ?><li><?php echo e($i); ?></li><?php endforeach; ?></ul>
    </div>
  </div>
<?php echo partial('partials/band-close'); ?>
