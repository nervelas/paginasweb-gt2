<?php
echo partial('partials/crumbs', ['crumbs' => $crumbs]);
$n = 0;
foreach ($sections as $s) {
    $tipo = $s['block_type'];
    if (!is_file(APP_PATH . '/Views/sections/' . $tipo . '.php')) { continue; }
    if ($tipo !== 'page_hero') { $n++; }
    echo partial('sections/' . $tipo, [
        'section' => $s, 'page' => $page, 'faqs' => [],
        'lienzo' => $tipo === 'features' ? 'dark' : 'bone',
        'regla' => false, 'n' => str_pad((string) $n, 2, '0', STR_PAD_LEFT),
    ]);
}
$primero = isset($posts[0]) ? $posts[0] : null;
$resto = array_slice($posts, 1);
?>
<section class="band band--bone-2">
  <div class="wrap">
    <div class="head rise"><div>
      <p class="tag" data-num="<?php echo str_pad((string) ($n + 1), 2, '0', STR_PAD_LEFT); ?>">Publicaciones</p>
      <h2 class="head__title">Todas las guías</h2>
    </div></div>

    <?php if ($primero): ?>
    <a class="lead-post rise" href="/blog/<?php echo e($primero['slug']); ?>/">
      <div class="lead-post__shot">
        <img src="<?php echo e($primero['image']); ?>" alt="<?php echo e($primero['image_alt']); ?>"
             width="800" height="500" decoding="async">
      </div>
      <div class="lead-post__body">
        <span class="post-card__cat">Lo más reciente<?php echo $primero['category_name'] ? ' · ' . e($primero['category_name']) : ''; ?></span>
        <h2><?php echo e($primero['title']); ?></h2>
        <p><?php echo e($primero['excerpt']); ?></p>
        <span class="post-card__date"><?php echo e(fecha_es($primero['published_at'])); ?></span>
      </div>
    </a>
    <?php endif; ?>

    <div class="posts rise">
      <?php foreach ($resto as $post) { echo partial('partials/post-card', ['post' => $post]); } ?>
    </div>
  </div>
</section>

<section class="call band--dark">
  <span class="call__glow" aria-hidden="true"></span>
  <div class="wrap call__in rise">
    <h2>¿Tu duda no está resuelta acá?</h2>
    <p>Escribinos. Si la pregunta se repite lo suficiente, termina convertida en la próxima guía.</p>
    <div class="call__actions">
      <a class="btn btn--signal" href="/contacto/">Escribir al estudio</a>
    </div>
  </div>
</section>
