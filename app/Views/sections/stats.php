<?php $items = isset($section['extra']['items']) ? $section['extra']['items'] : []; ?>
<?php if ($items): ?>
<section class="band--dark" style="padding:clamp(52px,7vw,96px) 0 clamp(56px,7vw,96px)">
  <div class="wrap">
    <div class="spec rise">
      <div class="spec__row">
        <?php foreach ($items as $n => $i): ?>
        <div class="spec__cell">
          <?php // Etiqueta corta: la que venga del panel o, si no hay, el número de orden. ?>
          <span class="spec__k"><?php echo e(isset($i['key']) && $i['key'] !== '' ? $i['key'] : sprintf('%02d', $n + 1)); ?></span>
          <span class="spec__v"><?php echo e($i['value']); ?></span>
          <span class="spec__d"><?php echo e($i['label']); ?></span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>
