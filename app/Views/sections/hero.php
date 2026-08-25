<?php
use App\Core\Settings;
$extra = isset($section['extra']) ? $section['extra'] : [];
$cta1  = $section['cta_url'] === 'whatsapp' ? Settings::whatsappLink() : $section['cta_url'];
?>
<section class="hero">
  <div class="wrap hero__grid">
    <div class="hero__content">
      <?php if ($section['eyebrow']): ?><p class="eyebrow"><?php echo e($section['eyebrow']); ?></p><?php endif; ?>
      <h1 class="hero__title"><?php echo e($section['heading']); ?><?php
        if (!empty($extra['accent'])): ?>
        <span class="accent"><?php echo e($extra['accent']); ?></span>
      <?php endif; ?></h1>
      <p class="hero__text"><?php echo e($section['subheading']); ?></p>
      <div class="hero__actions">
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
      <?php if (!empty($extra['notes'])): ?>
      <ul class="hero__notes">
        <?php foreach ($extra['notes'] as $note): ?><li><?php echo e($note); ?></li><?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </div>

    <?php if ($section['image']): ?>
    <div class="hero__media">
      <img src="<?php echo e($section['image']); ?>" alt="<?php echo e($section['image_alt']); ?>"
           width="720" height="540" fetchpriority="high" decoding="async">
      <div class="hero__badge">
        <strong><?php echo e(Settings::get('years_experience', '18')); ?>+ años</strong>
        <span>diseñando sitios para empresas guatemaltecas</span>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>
