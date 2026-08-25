<?php
use App\Models\Content;
$grupos = Content::plansByService();
?>
<section class="section reveal">
  <div class="wrap">
    <div class="section-head section-head--center">
      <?php if ($section['eyebrow']): ?><p class="eyebrow"><?php echo e($section['eyebrow']); ?></p><?php endif; ?>
      <h2><?php echo e($section['heading']); ?></h2>
      <?php if ($section['subheading']): ?><p class="sub"><?php echo e($section['subheading']); ?></p><?php endif; ?>
    </div>
    <div class="plans">
      <?php foreach ($grupos as $grupo):
        $destacado = null;
        foreach ($grupo['plans'] as $p) { if (!$destacado || $p['featured']) { $destacado = $p; } }
        if (!$destacado) { continue; }
        echo partial('partials/plan-card', [
          'plan' => $destacado,
          'mostrarServicio' => true,
          'servicioNombre' => $grupo['service']['short_name'],
        ]);
      endforeach; ?>
    </div>
    <?php if ($section['cta_text']): ?>
    <p style="margin-top:2.4rem;text-align:center">
      <a class="btn btn--dark" href="<?php echo e($section['cta_url']); ?>"><?php echo e($section['cta_text']); ?></a>
    </p>
    <?php endif; ?>
  </div>
</section>
