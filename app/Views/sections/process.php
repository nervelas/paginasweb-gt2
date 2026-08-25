<?php $steps = isset($section['extra']['steps']) ? $section['extra']['steps'] : []; ?>
<section class="section section--brand-soft reveal">
  <div class="wrap">
    <div class="section-head">
      <?php if ($section['eyebrow']): ?><p class="eyebrow"><?php echo e($section['eyebrow']); ?></p><?php endif; ?>
      <h2><?php echo e($section['heading']); ?></h2>
      <?php if ($section['subheading']): ?><p class="sub"><?php echo e($section['subheading']); ?></p><?php endif; ?>
    </div>
    <div class="process<?php echo count($steps) >= 4 ? ' process--cols' : ''; ?>">
      <?php foreach ($steps as $step): ?>
      <div class="process__step">
        <div>
          <h3><?php echo e($step['title']); ?></h3>
          <p><?php echo e($step['text']); ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
