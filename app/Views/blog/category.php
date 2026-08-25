<?php echo partial('partials/crumbs', ['crumbs' => $crumbs]); ?>
<section class="page-head band--dark page-head--solo">
  <span class="hero__glow" aria-hidden="true" style="right:-30%;top:-70%"></span>
  <div class="wrap page-head__in">
    <div class="page-head__grid">
      <div>
        <p class="tag" data-num="00">Categoría</p>
        <h1><?php echo e($category['name']); ?></h1>
      </div>
    </div>
    <?php if ($category['description']): ?>
    <p class="lede" style="margin-top:clamp(24px,3vw,40px);max-width:56ch"><?php echo e($category['description']); ?></p>
    <?php endif; ?>
  </div>
</section>

<section class="band band--bone band--tight">
  <div class="wrap">
    <?php if ($posts): ?>
    <div class="posts rise">
      <?php foreach ($posts as $post) { echo partial('partials/post-card', ['post' => $post]); } ?>
    </div>
    <?php else: ?>
    <p class="lede">Todavía no hay publicaciones en esta categoría.</p>
    <?php endif; ?>
    <p style="margin-top:clamp(32px,4vw,52px)">
      <a class="btn btn--line" href="/blog/">
        Ver todas las guías <?php echo partial('partials/icon', ['name' => 'flecha', 'size' => 15]); ?>
      </a>
    </p>
  </div>
</section>
