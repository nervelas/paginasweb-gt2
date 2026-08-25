<?php $items = isset($section['extra']['items']) ? $section['extra']['items'] : []; ?>
<?php if ($items): ?>
<section class="band--dark" style="padding:clamp(52px,7vw,96px) 0 clamp(56px,7vw,96px)">
  <div class="wrap">
    <div class="spec rise">
      <div class="spec__row">
        <?php foreach ($items as $i): ?>
        <div class="spec__cell">
          <span class="spec__k">Dato</span>
          <span class="spec__v"><?php echo e($i['value']); ?></span>
          <span class="spec__d"><?php echo e($i['label']); ?></span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>
