<?php if (!empty($faqs)): ?>
<?php echo partial('partials/band-open', ['lienzo' => $lienzo, 'regla' => $regla, 'id' => 'preguntas']); ?>
  <?php echo partial('partials/head-block', ['section' => $section, 'n' => $n, 'split' => true]); ?>
  <div class="qa rise" data-accordion>
    <?php foreach ($faqs as $f): ?>
    <details class="qa__item">
      <summary><?php echo e($f['question']); ?></summary>
      <div class="qa__answer"><?php echo $f['answer']; ?></div>
    </details>
    <?php endforeach; ?>
  </div>
<?php echo partial('partials/band-close'); ?>
<?php endif; ?>
