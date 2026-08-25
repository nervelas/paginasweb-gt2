<?php
use App\Models\Content;
$limit = isset($section['extra']['limit']) ? (int) $section['extra']['limit'] : 0;
$items = Content::portfolio($limit);
?>
<section class="section section--white reveal">
  <div class="wrap">
    <div class="section-head">
      <?php if ($section['eyebrow']): ?><p class="eyebrow"><?php echo e($section['eyebrow']); ?></p><?php endif; ?>
      <?php if ($section['heading']): ?><h2><?php echo e($section['heading']); ?></h2><?php endif; ?>
      <?php if ($section['subheading']): ?><p class="sub"><?php echo e($section['subheading']); ?></p><?php endif; ?>
    </div>
    <div class="portfolio-grid">
      <?php foreach ($items as $i => $item): ?>
      <a class="card card--link portfolio-card" href="<?php echo e($item['url']); ?>" rel="noopener">
        <div class="portfolio-card__shot">
          <img src="<?php echo e($item['image']); ?>" alt="<?php echo e($item['image_alt']); ?>"
               width="640" height="400" loading="<?php echo $i < 4 ? 'eager' : 'lazy'; ?>" decoding="async">
        </div>
        <div class="portfolio-card__body">
          <span class="portfolio-card__sector"><?php echo e($item['sector']); ?></span>
          <h3><?php echo e($item['name']); ?></h3>
          <p><?php echo e($item['description']); ?></p>
          <span class="portfolio-card__domain">
            <?php echo e($item['domain']); ?> <?php echo partial('partials/icon', ['name' => 'external', 'size' => 13]); ?>
          </span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <?php if ($section['cta_text']): ?>
    <p style="margin-top:2.4rem;text-align:center">
      <a class="btn btn--ghost" href="<?php echo e($section['cta_url']); ?>"><?php echo e($section['cta_text']); ?></a>
    </p>
    <?php endif; ?>
  </div>
</section>
