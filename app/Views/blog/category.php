<?php echo partial('partials/breadcrumbs', ['crumbs' => $crumbs]); ?>
<section class="page-hero page-hero--plain">
  <div class="wrap page-hero__grid">
    <div>
      <p class="eyebrow">Categoría del blog</p>
      <h1><?php echo e($category['name']); ?></h1>
      <?php if ($category['description']): ?><p class="lead"><?php echo e($category['description']); ?></p><?php endif; ?>
    </div>
  </div>
</section>
<section class="section section--tight">
  <div class="wrap">
    <?php if ($posts): ?>
    <div class="grid grid--3">
      <?php foreach ($posts as $post) { echo partial('partials/post-card', ['post' => $post]); } ?>
    </div>
    <?php else: ?>
    <p class="lead">Todavía no hay publicaciones en esta categoría.</p>
    <?php endif; ?>
    <p style="margin-top:2.4rem"><a class="btn btn--ghost" href="/blog/">Ver todas las guías</a></p>
  </div>
</section>
