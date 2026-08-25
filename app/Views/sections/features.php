<?php $items = isset($section['extra']['items']) ? $section['extra']['items'] : []; ?>
<section class="section reveal">
  <div class="wrap">
    <div class="section-head">
      <?php if ($section['eyebrow']): ?><p class="eyebrow"><?php echo e($section['eyebrow']); ?></p><?php endif; ?>
      <?php if ($section['heading']): ?><h2><?php echo e($section['heading']); ?></h2><?php endif; ?>
      <?php if ($section['body']): ?><div class="sub"><?php echo $section['body']; ?></div><?php endif; ?>
    </div>
    <div class="grid grid--<?php echo count($items) % 4 === 0 ? '4' : '3'; ?>">
      <?php foreach ($items as $item): ?>
      <div class="feature">
        <span class="feature__icon"><?php echo partial('partials/icon', ['name' => $item['icon'], 'size' => 20]); ?></span>
        <div>
          <h3><?php echo e($item['title']); ?></h3>
          <p><?php echo e($item['text']); ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
