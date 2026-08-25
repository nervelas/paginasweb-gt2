<section class="section section--tight reveal">
  <div class="wrap wrap-narrow">
    <?php if ($section['eyebrow']): ?><p class="eyebrow"><?php echo e($section['eyebrow']); ?></p><?php endif; ?>
    <?php if ($section['heading']): ?><h2><?php echo e($section['heading']); ?></h2><?php endif; ?>
    <?php if ($section['subheading']): ?><p class="lead"><?php echo e($section['subheading']); ?></p><?php endif; ?>
    <div class="prose"><?php echo $section['body']; ?></div>
  </div>
</section>
