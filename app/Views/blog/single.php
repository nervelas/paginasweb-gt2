<?php use App\Core\Settings; ?>
<?php echo partial('partials/breadcrumbs', ['crumbs' => $crumbs]); ?>
<article class="article">
  <header class="article__header">
    <div class="wrap wrap-narrow">
      <div class="article__meta">
        <?php if ($post['category_name']): ?>
        <a class="cat" href="/blog/categoria/<?php echo e($post['category_slug']); ?>/"><?php echo e($post['category_name']); ?></a>
        <?php endif; ?>
        <time datetime="<?php echo e(date('Y-m-d', strtotime($post['published_at']))); ?>">
          <?php echo e(fecha_es($post['published_at'])); ?>
        </time>
        <span><?php echo max(1, (int) round(word_count_html($post['body']) / 200)); ?> min de lectura</span>
      </div>
      <h1><?php echo e($post['title']); ?></h1>
      <p class="lead"><?php echo e($post['excerpt']); ?></p>
    </div>
    <?php if ($post['image']): ?>
    <div class="wrap wrap-narrow">
      <div class="article__cover">
        <img src="<?php echo e($post['image']); ?>" alt="<?php echo e($post['image_alt']); ?>"
             width="760" height="428" fetchpriority="high" decoding="async">
      </div>
    </div>
    <?php endif; ?>
  </header>

  <div class="section section--tight">
    <div class="wrap wrap-narrow">
      <div class="prose"><?php echo $post['body']; ?></div>

      <div style="margin-top:3rem;padding-top:1.6rem;border-top:1px solid var(--line-soft);font-size:.9rem;color:var(--ink-50)">
        Escrito por el equipo de <?php echo e(Settings::get('site_name')); ?>,
        que lleva <?php echo e(Settings::get('years_experience', '18')); ?> años diseñando sitios web
        para empresas de Guatemala.
      </div>
    </div>
  </div>

  <section class="section section--tight">
    <div class="wrap">
      <div class="cta-band">
        <div class="cta-band__inner">
          <h2>¿Querés que revisemos tu caso?</h2>
          <p>Contanos a qué te dedicás y te decimos qué tipo de sitio te conviene, con precio y tiempo de entrega.</p>
          <div class="cta-band__actions">
            <a class="btn btn--primary" href="<?php echo e(Settings::whatsappLink()); ?>" rel="noopener">
              <?php echo partial('partials/icon', ['name' => 'whatsapp', 'size' => 18]); ?> Escribir por WhatsApp
            </a>
            <a class="btn btn--on-ink" href="/precios/">Ver precios</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php if ($related): ?>
  <section class="section section--tight">
    <div class="wrap">
      <div class="section-head"><h2 style="font-size:clamp(1.35rem,2.6vw,1.7rem)">Seguí leyendo</h2></div>
      <div class="grid grid--3">
        <?php foreach ($related as $post) { echo partial('partials/post-card', ['post' => $post]); } ?>
      </div>
    </div>
  </section>
  <?php endif; ?>
</article>
