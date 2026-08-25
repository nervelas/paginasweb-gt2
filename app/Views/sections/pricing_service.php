<?php
use App\Models\Content;
$servicio = null;
foreach (Content::services() as $s) {
    if ($s['page_slug'] === $page['slug']) { $servicio = $s; }
}
$planes = $servicio ? Content::plans($servicio['id']) : [];
?>
<?php if ($planes): ?>
<?php echo partial('partials/band-open', ['lienzo' => $lienzo, 'regla' => $regla, 'id' => 'precios']); ?>
  <?php echo partial('partials/head-block', ['section' => $section, 'n' => $n, 'split' => true]); ?>
  <div class="plans rise"<?php echo count($planes) === 1 ? ' style="max-width:560px"' : ''; ?>>
    <?php foreach ($planes as $p) { echo partial('partials/plan', ['plan' => $p]); } ?>
  </div>
<?php echo partial('partials/band-close'); ?>
<?php endif; ?>
