<?php
use App\Models\Content;
$items = Content::testimonials();
?>
<?php echo partial('partials/band-open', ['lienzo' => $lienzo, 'regla' => $regla, 'tight' => true]); ?>
  <?php echo partial('partials/head-block', ['section' => $section, 'n' => $n, 'split' => true]); ?>
  <?php if ($items): ?>
  <div class="voices rise">
    <?php foreach ($items as $t): ?>
    <figure class="voice">
      <blockquote>&laquo;<?php echo e($t['quote']); ?>&raquo;</blockquote>
      <figcaption>
        <b><?php echo e($t['name']); ?></b>
        <?php echo e(trim($t['role'] . ($t['role'] && $t['company'] ? ' · ' : '') . $t['company'])); ?>
      </figcaption>
    </figure>
    <?php endforeach; ?>
  </div>
  <?php else: ?>
  <div class="voices-empty rise">
    <p>Estamos recogiendo testimonios de clientes dispuestos a firmarlos con su nombre y empresa.
    Preferimos dejar esta sección vacía antes que llenarla con opiniones que nadie pueda comprobar.</p>
  </div>
  <?php endif; ?>
<?php echo partial('partials/band-close'); ?>
