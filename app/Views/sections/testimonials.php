<?php
use App\Models\Content;
$items = Content::testimonials();
?>
<section class="section section--white reveal">
  <div class="wrap">
    <div class="section-head section-head--center">
      <?php if ($section['eyebrow']): ?><p class="eyebrow"><?php echo e($section['eyebrow']); ?></p><?php endif; ?>
      <h2><?php echo e($section['heading']); ?></h2>
      <?php if ($section['subheading']): ?><p class="sub"><?php echo e($section['subheading']); ?></p><?php endif; ?>
    </div>
    <?php if ($items): ?>
    <div class="grid grid--3">
      <?php foreach ($items as $t): ?>
      <figure class="card testimonial">
        <blockquote>&laquo;<?php echo e($t['quote']); ?>&raquo;</blockquote>
        <figcaption>
          <strong><?php echo e($t['name']); ?></strong>
          <?php echo e(trim($t['role'] . ($t['role'] && $t['company'] ? ' · ' : '') . $t['company'])); ?>
        </figcaption>
      </figure>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="testimonials-empty">
      <p>Estamos recogiendo testimonios de clientes dispuestos a firmarlos con su nombre y empresa.
      Preferimos publicar esta sección vacía antes que llenarla con opiniones que nadie pueda verificar.</p>
    </div>
    <?php endif; ?>
  </div>
</section>
