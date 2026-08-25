<?php echo partial('partials/band-open', ['lienzo' => $lienzo, 'regla' => $regla, 'tight' => true]); ?>
  <div class="answer rise" style="max-width:76ch">
    <h2><?php echo e($section['heading']); ?></h2>
    <?php echo $section['body']; ?>
  </div>
<?php echo partial('partials/band-close'); ?>
