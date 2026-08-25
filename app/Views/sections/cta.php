<?php
use App\Core\Settings;
$x = isset($section['extra']) ? $section['extra'] : [];
$cta = $section['cta_url'] === 'whatsapp' ? Settings::whatsappLink() : $section['cta_url'];
?>
<section class="call band--dark">
  <span class="call__glow" aria-hidden="true"></span>
  <div class="wrap call__in rise">
    <h2><?php echo e($section['heading']); ?></h2>
    <?php if ($section['subheading']): ?><p><?php echo e($section['subheading']); ?></p><?php endif; ?>
    <div class="call__actions">
      <a class="btn btn--signal" href="<?php echo e($cta); ?>"<?php echo $section['cta_url'] === 'whatsapp' ? ' rel="noopener"' : ''; ?>>
        <?php echo partial('partials/icon', ['name' => 'whatsapp', 'size' => 15]); ?>
        <?php echo e($section['cta_text']); ?>
      </a>
      <?php if (!empty($x['cta2_text'])): ?>
      <a class="btn btn--line" href="<?php echo e($x['cta2_url']); ?>"><?php echo e($x['cta2_text']); ?></a>
      <?php endif; ?>
    </div>
  </div>
</section>
