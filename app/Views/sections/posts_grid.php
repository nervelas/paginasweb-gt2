<?php
use App\Models\Content;
$limite = isset($section['extra']['limit']) ? (int) $section['extra']['limit'] : 3;
$posts = Content::posts($limite);
?>
<?php if ($posts): ?>
<?php echo partial('partials/band-open', ['lienzo' => $lienzo, 'regla' => $regla]); ?>
  <?php echo partial('partials/head-block', ['section' => $section, 'n' => $n, 'split' => true]); ?>
  <div class="posts rise">
    <?php foreach ($posts as $post) { echo partial('partials/post-card', ['post' => $post]); } ?>
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
<?php endif; ?>
