<?php
use App\Models\Content;
$grupos = isset($section['extra']['groups']) ? $section['extra']['groups'] : [];
$i = 0;
?>
<?php echo partial('partials/band-open', ['lienzo' => 'bone', 'tight' => true]); ?>
  <?php foreach ($grupos as $g):
    $items = Content::faqs($g['slug']);
    if (!$items) { continue; }
    $i++; ?>
  <div class="qa__group rise">
    <p class="tag" data-num="<?php echo str_pad((string) $i, 2, '0', STR_PAD_LEFT); ?>">Bloque</p>
    <h2><?php echo e($g['title']); ?></h2>
    <div class="qa" data-accordion>
      <?php foreach ($items as $f): ?>
      <details class="qa__item">
        <summary><?php echo e($f['question']); ?></summary>
        <div class="qa__answer"><?php echo $f['answer']; ?></div>
      </details>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endforeach; ?>
<?php echo partial('partials/band-close'); ?>
