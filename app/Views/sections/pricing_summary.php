<?php
use App\Models\Content;
$grupos = Content::plansByService();
?>
<?php echo partial('partials/band-open', ['lienzo' => $lienzo, 'regla' => $regla]); ?>
  <?php echo partial('partials/head-block', ['section' => $section, 'n' => $n, 'split' => true]); ?>
  <div class="plans rise">
    <?php foreach ($grupos as $g):
      $destacado = null;
      foreach ($g['plans'] as $p) { if (!$destacado || $p['featured']) { $destacado = $p; } }
      if (!$destacado) { continue; }
      echo partial('partials/plan', ['plan' => $destacado, 'servicioNombre' => $g['service']['short_name']]);
    endforeach; ?>
  </div>
  <?php if ($section['cta_text']): ?>
  <p style="margin-top:clamp(32px,4vw,52px)">
    <a class="btn btn--line" href="<?php echo e($section['cta_url']); ?>">
      <?php echo e($section['cta_text']); ?>
      <?php echo partial('partials/icon', ['name' => 'flecha', 'size' => 15]); ?>
    </a>
  </p>
  <?php endif; ?>
<?php echo partial('partials/band-close'); ?>
