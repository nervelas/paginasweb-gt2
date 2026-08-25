<?php
use App\Core\Settings;
$x = isset($section['extra']) ? $section['extra'] : [];
$cta = $section['cta_url'] === 'whatsapp' ? Settings::whatsappLink() : $section['cta_url'];
$solo = empty($section['image']);
?>
<section class="page-head band--dark<?php echo $solo ? ' page-head--solo' : ''; ?>">
  <span class="hero__glow" aria-hidden="true" style="right:-30%;top:-70%"></span>
  <div class="wrap page-head__in">
    <div class="page-head__grid">
      <div>
        <?php if ($section['eyebrow']): ?>
        <p class="tag" data-num="00"><?php echo e($section['eyebrow']); ?></p>
        <?php endif; ?>
        <h1><?php echo e($section['heading']); ?></h1>
      </div>
      <div class="page-head__side">
        <?php if (!$solo): ?>
        <img src="<?php echo e($section['image']); ?>" alt="<?php echo e($section['image_alt']); ?>"
             width="520" height="420" decoding="async">
        <?php endif; ?>
      </div>
    </div>

    <?php if ($section['subheading'] || $section['cta_text']): ?>
    <div style="margin-top:clamp(28px,4vw,52px);max-width:64ch">
      <?php if ($section['subheading']): ?>
      <p class="lede" style="max-width:none"><?php echo e($section['subheading']); ?></p>
      <?php endif; ?>
      <?php if ($section['cta_text'] || !empty($x['cta2_text'])): ?>
      <div class="hero__actions" style="margin-top:2rem">
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
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
