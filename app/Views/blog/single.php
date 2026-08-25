<?php use App\Core\Settings; ?>
<?php echo partial('partials/crumbs', ['crumbs' => $crumbs]); ?>
<article>
  <header class="article__head band--dark">
    <span class="hero__glow" aria-hidden="true" style="right:-28%;top:-64%"></span>
    <div class="wrap article__head-in">
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
      <p class="lede"><?php echo e($post['excerpt']); ?></p>
      <?php if ($post['image']): ?>
      <div class="article__cover">
        <img src="<?php echo e($post['image']); ?>" alt="<?php echo e($post['image_alt']); ?>"
             width="1280" height="720" fetchpriority="high" decoding="async">
      </div>
      <?php endif; ?>
    </div>
  </header>

  <div class="band band--bone band--tight">
    <div class="wrap">
      <div class="prose"><?php echo $post['body']; ?></div>
      <p class="byline">
        Escrito por el equipo de <?php echo e(Settings::get('site_name')); ?>,
        <?php echo e(Settings::get('years_experience', '18')); ?> años diseñando sitios web
        para empresas de Guatemala.
      </p>
    </div>
  </div>

  <?php if ($related): ?>
  <section class="band band--bone-2 band--tight">
    <div class="wrap">
      <div class="head rise"><div>
        <p class="tag" data-num="+">Seguir leyendo</p>
        <h2 class="head__title" style="font-size:clamp(1.6rem,2.6vw,2.2rem)">Guías relacionadas</h2>
      </div></div>
      <div class="posts rise">
        <?php foreach ($related as $post) { echo partial('partials/post-card', ['post' => $post]); } ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <section class="call">
    <span class="call__glow" aria-hidden="true"></span>
    <div class="wrap call__in rise">
      <h2>¿Querés que revisemos tu caso?</h2>
      <p>Contanos a qué te dedicás y te decimos qué tipo de sitio te conviene, con precio y tiempo de entrega.</p>
      <div class="call__actions">
        <a class="btn btn--signal" href="<?php echo e(Settings::whatsappLink()); ?>" rel="noopener">
          <?php echo partial('partials/icon', ['name' => 'whatsapp', 'size' => 15]); ?> Escribir por WhatsApp
        </a>
        <a class="btn btn--line" href="/precios/">Ver precios</a>
      </div>
    </div>
  </section>
</article>
