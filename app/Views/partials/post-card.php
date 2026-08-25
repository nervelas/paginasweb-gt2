<a class="card card--link post-card" href="/blog/<?php echo e($post['slug']); ?>/">
  <?php if ($post['image']): ?>
  <div class="post-card__media">
    <img src="<?php echo e($post['image']); ?>" alt="<?php echo e($post['image_alt']); ?>"
         width="560" height="315" loading="lazy" decoding="async">
  </div>
  <?php endif; ?>
  <div class="post-card__body">
    <?php if (!empty($post['category_name'])): ?>
    <span class="post-card__meta"><?php echo e($post['category_name']); ?></span>
    <?php endif; ?>
    <h3><?php echo e($post['title']); ?></h3>
    <p><?php echo e($post['excerpt']); ?></p>
    <span class="post-card__date"><?php echo e(fecha_es($post['published_at'])); ?></span>
  </div>
</a>
