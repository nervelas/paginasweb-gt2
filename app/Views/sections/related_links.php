<?php $links = isset($section['extra']['links']) ? $section['extra']['links'] : []; ?>
<?php if ($links): ?>
<section class="section section--tight reveal">
  <div class="wrap">
    <?php if ($section['heading']): ?>
    <div class="section-head"><h2 style="font-size:clamp(1.35rem,2.6vw,1.7rem)"><?php echo e($section['heading']); ?></h2></div>
    <?php endif; ?>
    <div class="related-links">
      <?php foreach ($links as $link): ?>
      <a class="related-link" href="<?php echo e($link['url']); ?>">
        <strong><?php echo e($link['title']); ?></strong>
        <span><?php echo e($link['text']); ?></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
