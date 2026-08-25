<?php $pasos = isset($section['extra']['steps']) ? $section['extra']['steps'] : []; ?>
<?php echo partial('partials/band-open', ['lienzo' => $lienzo, 'regla' => $regla]); ?>
  <?php echo partial('partials/head-block', ['section' => $section, 'n' => $n, 'split' => true]); ?>
  <div class="steps rise">
    <?php foreach ($pasos as $i => $paso): ?>
    <div class="step">
      <span class="step__n"><?php echo str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT); ?></span>
      <div class="step__body">
        <h3><?php echo e($paso['title']); ?></h3>
        <p><?php echo e($paso['text']); ?></p>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
<?php echo partial('partials/band-close'); ?>
