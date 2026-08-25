<?php $items = isset($section['extra']['items']) ? $section['extra']['items'] : []; ?>
<?php if ($items): ?>
<section class="section--tight reveal" style="padding-block:0 var(--step)">
  <div class="wrap">
    <div class="stats">
      <?php foreach ($items as $item): ?>
      <div class="stats__item">
        <span class="stats__value"><?php echo e($item['value']); ?></span>
        <span class="stats__label"><?php echo e($item['label']); ?></span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
