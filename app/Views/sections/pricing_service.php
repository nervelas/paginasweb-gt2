<?php
use App\Models\Content;
$servicio = null;
foreach (Content::services() as $s) {
    if ($s['page_slug'] === $page['slug']) { $servicio = $s; }
}
$planes = $servicio ? Content::plans($servicio['id']) : [];
?>
<?php if ($planes): ?>
<section class="section section--white reveal" id="precios">
  <div class="wrap">
    <div class="section-head section-head--center">
      <?php if ($section['eyebrow']): ?><p class="eyebrow"><?php echo e($section['eyebrow']); ?></p><?php endif; ?>
      <h2><?php echo e($section['heading']); ?></h2>
      <?php if ($section['subheading']): ?><p class="sub"><?php echo e($section['subheading']); ?></p><?php endif; ?>
    </div>
    <div class="plans" style="max-width:<?php echo count($planes) === 1 ? '520px' : 'none'; ?>;margin-inline:auto">
      <?php foreach ($planes as $plan) { echo partial('partials/plan-card', ['plan' => $plan]); } ?>
    </div>
  </div>
</section>
<?php endif; ?>
