<?php
use App\Models\Content;
$limite = isset($section['extra']['limit']) ? (int) $section['extra']['limit'] : 0;
$items  = Content::portfolio($limite);
$rejilla = !empty($section['extra']['grid']);
?>
<?php echo partial('partials/band-open', ['lienzo' => $lienzo, 'regla' => $regla]); ?>
  <?php echo partial('partials/head-block', ['section' => $section, 'n' => $n, 'split' => true]); ?>

  <?php if ($rejilla): ?>
  <div class="works rise">
    <?php foreach ($items as $i => $p): ?>
    <a class="work" href="<?php echo e($p['url']); ?>" rel="noopener">
      <div class="work__shot">
        <img src="<?php echo e($p['image']); ?>" alt="<?php echo e($p['image_alt']); ?>"
             width="640" height="400" loading="<?php echo $i < 3 ? 'eager' : 'lazy'; ?>" decoding="async">
      </div>
      <div class="work__body">
        <span class="work__sector"><?php echo e($p['sector']); ?></span>
        <h3><?php echo e($p['name']); ?></h3>
        <p><?php echo e($p['description']); ?></p>
        <span class="work__dom"><?php echo e($p['domain']); ?> <?php echo partial('partials/icon', ['name' => 'externo', 'size' => 11]); ?></span>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
  <?php else: ?>
  <div class="index rise" data-preview-index>
    <?php foreach ($items as $i => $p): ?>
    <article class="index__row" data-shot="<?php echo e($p['image']); ?>">
      <span class="index__n"><?php echo str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT); ?></span>
      <h3 class="index__name"><a href="<?php echo e($p['url']); ?>" rel="noopener"><?php echo e($p['name']); ?></a></h3>
      <span class="index__sector"><?php echo e($p['sector']); ?></span>
      <p class="index__desc"><?php echo e(excerpt($p['description'], 76)); ?></p>
      <span class="index__go"><?php echo e($p['domain']); ?> <?php echo partial('partials/icon', ['name' => 'diagonal', 'size' => 12]); ?></span>
    </article>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <?php if ($section['cta_text']): ?>
  <p style="margin-top:clamp(32px,4vw,52px)">
    <a class="btn btn--line" href="<?php echo e($section['cta_url']); ?>">
      <?php echo e($section['cta_text']); ?>
      <?php echo partial('partials/icon', ['name' => 'flecha', 'size' => 15]); ?>
    </a>
  </p>
  <?php endif; ?>
<?php echo partial('partials/band-close'); ?>
