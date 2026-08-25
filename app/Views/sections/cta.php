<?php
use App\Core\Settings;
$extra = isset($section['extra']) ? $section['extra'] : [];
$cta1  = $section['cta_url'] === 'whatsapp' ? Settings::whatsappLink() : $section['cta_url'];
?>
<section class="section reveal">
  <div class="wrap">
    <div class="cta-band">
      <div class="cta-band__inner">
        <h2><?php echo e($section['heading']); ?></h2>
        <?php if ($section['subheading']): ?><p><?php echo e($section['subheading']); ?></p><?php endif; ?>
        <div class="cta-band__actions">
          <a class="btn btn--primary" href="<?php echo e($cta1); ?>"<?php echo $section['cta_url'] === 'whatsapp' ? ' rel="noopener"' : ''; ?>>
            <?php echo partial('partials/icon', ['name' => 'whatsapp', 'size' => 18]); ?>
            <?php echo e($section['cta_text']); ?>
          </a>
          <?php if (!empty($extra['cta2_text'])): ?>
          <a class="btn btn--on-ink" href="<?php echo e($extra['cta2_url']); ?>"><?php echo e($extra['cta2_text']); ?></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
