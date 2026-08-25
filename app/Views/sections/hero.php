<?php
use App\Core\Settings;
$x = isset($section['extra']) ? $section['extra'] : [];
$cta = $section['cta_url'] === 'whatsapp' ? Settings::whatsappLink() : $section['cta_url'];
?>
<section class="hero band--dark">
  <span class="hero__glow" aria-hidden="true"></span>
  <div class="wrap hero__in">
    <div class="hero__grid">
      <div>
        <?php if ($section['eyebrow']): ?>
        <p class="tag" data-num="00"><?php echo e($section['eyebrow']); ?></p>
        <?php endif; ?>
        <h1 class="hero__title">
          <?php echo e($section['heading']); ?><?php if (!empty($x['accent'])): ?>
          <span class="sig"><?php echo e($x['accent']); ?></span>
          <?php endif; ?>
        </h1>
        <p class="lede hero__lede"><?php echo e($section['subheading']); ?></p>
        <div class="hero__actions">
          <?php if ($section['cta_text']): ?>
          <a class="btn btn--signal" href="<?php echo e($cta); ?>"<?php echo $section['cta_url'] === 'whatsapp' ? ' rel="noopener"' : ''; ?>>
            <?php echo partial('partials/icon', ['name' => 'whatsapp', 'size' => 15]); ?>
            <?php echo e($section['cta_text']); ?>
          </a>
          <?php endif; ?>
          <?php if (!empty($x['cta2_text'])): ?>
          <a class="btn btn--line" href="<?php echo e($x['cta2_url']); ?>"><?php echo e($x['cta2_text']); ?></a>
          <?php endif; ?>
        </div>
      </div>

      <?php if ($section['image']): ?>
      <figure class="hero__figure marks" style="margin:0">
        <img src="<?php echo e($section['image']); ?>" alt="<?php echo e($section['image_alt']); ?>"
             width="760" height="570" fetchpriority="high" decoding="async">
        <figcaption class="hero__stamp">
          <b><?php echo e(Settings::get('years_experience', '18')); ?>+</b>
          <span>años de oficio en Guatemala</span>
        </figcaption>
      </figure>
      <?php endif; ?>
    </div>
  </div>
</section>
