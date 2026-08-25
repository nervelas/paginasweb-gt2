<?php
use App\Core\Settings;
$extra = isset($section['extra']) ? $section['extra'] : [];
$cta1  = $section['cta_url'] === 'whatsapp' ? Settings::whatsappLink() : $section['cta_url'];
$plain = empty($section['image']);
?>
<section class="page-hero<?php echo $plain ? ' page-hero--plain' : ''; ?>">
  <div class="wrap page-hero__grid">
    <div>
      <?php if ($section['eyebrow']): ?><p class="eyebrow"><?php echo e($section['eyebrow']); ?></p><?php endif; ?>
      <h1><?php echo e($section['heading']); ?></h1>
      <?php if ($section['subheading']): ?><p class="lead"><?php echo e($section['subheading']); ?></p><?php endif; ?>
      <?php if ($section['cta_text'] || !empty($extra['cta2_text'])): ?>
      <div class="hero__actions" style="margin-top:1.6rem;margin-bottom:0">
        <?php if ($section['cta_text']): ?>
        <a class="btn btn--primary" href="<?php echo e($cta1); ?>"<?php echo $section['cta_url'] === 'whatsapp' ? ' rel="noopener"' : ''; ?>>
          <?php echo partial('partials/icon', ['name' => 'whatsapp', 'size' => 18]); ?>
          <?php echo e($section['cta_text']); ?>
        </a>
        <?php endif; ?>
        <?php if (!empty($extra['cta2_text'])): ?>
        <a class="btn btn--ghost" href="<?php echo e($extra['cta2_url']); ?>"><?php echo e($extra['cta2_text']); ?></a>
        <?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
    <?php if (!$plain): ?>
    <div class="page-hero__media">
      <img src="<?php echo e($section['image']); ?>" alt="<?php echo e($section['image_alt']); ?>"
           width="440" height="360" decoding="async">
    </div>
    <?php endif; ?>
  </div>
</section>
