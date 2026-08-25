<?php echo partial('partials/band-open', ['lienzo' => 'bone', 'tight' => true]); ?>
  <div class="prose"><?php echo $section['body']; ?></div>
  <p class="mono" style="margin-top:3rem;color:var(--on-bone-faint)">
    Última actualización: <?php echo e(fecha_es($page['updated_at'])); ?>
  </p>
<?php echo partial('partials/band-close'); ?>
