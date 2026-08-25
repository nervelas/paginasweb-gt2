<?php
use App\Models\Content;
$limit = isset($section['extra']['limit']) ? (int) $section['extra']['limit'] : 3;
$posts = Content::posts($limit);
?>
<?php if ($posts): ?>
<section class="section reveal">
  <div class="wrap">
    <div class="section-head">
      <?php if ($section['eyebrow']): ?><p class="eyebrow"><?php echo e($section['eyebrow']); ?></p><?php endif; ?>
      <h2><?php echo e($section['heading']); ?></h2>
      <?php if ($section['subheading']): ?><p class="sub"><?php echo e($section['subheading']); ?></p><?php endif; ?>
    </div>
    <div class="grid grid--3">
      <?php foreach ($posts as $post) { echo partial('partials/post-card', ['post' => $post]); } ?>
    </div>
    <?php if ($section['cta_text']): ?>
    <p style="margin-top:2.4rem;text-align:center">
      <a class="btn btn--ghost" href="<?php echo e($section['cta_url']); ?>"><?php echo e($section['cta_text']); ?></a>
    </p>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>
