<a class="post-card" href="/blog/<?php echo e($post['slug']); ?>/">
  <?php if ($post['image']): ?>
  <div class="post-card__shot">
    <img src="<?php echo e($post['image']); ?>" alt="<?php echo e($post['image_alt']); ?>"
         width="640" height="360" loading="lazy" decoding="async">
  </div>
  <?php endif; ?>
  <div class="post-card__body">
    <?php if (!empty($post['category_name'])): ?>
    <span class="post-card__cat"><?php echo e($post['category_name']); ?></span>
    <?php endif; ?>
    <h3><?php echo e($post['title']); ?></h3>
    <p><?php echo e($post['excerpt']); ?></p>
    <span class="post-card__date"><?php echo e(fecha_es($post['published_at'])); ?></span>
  </div>
</a>
