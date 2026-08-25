<?php
echo partial('partials/breadcrumbs', ['crumbs' => $crumbs]);
foreach ($sections as $section) {
    echo partial('sections/' . $section['block_type'], ['section' => $section, 'page' => $page, 'faqs' => []]);
}
$destacado = isset($posts[0]) ? $posts[0] : null;
$resto = array_slice($posts, 1);
?>
<section class="section section--tight">
  <div class="wrap">
    <?php if ($destacado): ?>
    <a class="card card--link reveal" href="/blog/<?php echo e($destacado['slug']); ?>/"
       style="display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:0;padding:0;overflow:hidden;text-decoration:none;color:inherit;margin-bottom:34px">
      <div style="aspect-ratio:16/10;overflow:hidden;background:var(--brand-soft)">
        <img src="<?php echo e($destacado['image']); ?>" alt="<?php echo e($destacado['image_alt']); ?>"
             width="720" height="450" style="width:100%;height:100%;object-fit:cover" decoding="async">
      </div>
      <div style="padding:clamp(24px,3.4vw,40px);display:flex;flex-direction:column;gap:10px;justify-content:center">
        <span class="post-card__meta">Lo más reciente<?php echo $destacado['category_name'] ? ' · ' . e($destacado['category_name']) : ''; ?></span>
        <h2 style="font-size:clamp(1.4rem,2.8vw,2rem);margin:0"><?php echo e($destacado['title']); ?></h2>
        <p style="color:var(--ink-70);margin:0"><?php echo e($destacado['excerpt']); ?></p>
        <span class="post-card__date"><?php echo e(fecha_es($destacado['published_at'])); ?></span>
      </div>
    </a>
    <?php endif; ?>

    <div class="grid grid--3 reveal">
      <?php foreach ($resto as $post) { echo partial('partials/post-card', ['post' => $post]); } ?>
    </div>
  </div>
</section>

<section class="section section--tight">
  <div class="wrap">
    <div class="cta-band">
      <div class="cta-band__inner">
        <h2>¿Tenés una duda que no cubrimos acá?</h2>
        <p>Escribinos y, si la pregunta se repite, la convertimos en la próxima guía.</p>
        <div class="cta-band__actions">
          <a class="btn btn--primary" href="/contacto/">Escribir al equipo</a>
        </div>
      </div>
    </div>
  </div>
</section>
<style>@media(max-width:820px){.tpl-blog .card--link[href^="/blog/"]{grid-template-columns:1fr !important}}</style>
