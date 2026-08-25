<?php
use App\Models\Content;
$groups = isset($section['extra']['groups']) ? $section['extra']['groups'] : [];
?>
<section class="section section--tight">
  <div class="wrap wrap-narrow">
    <?php foreach ($groups as $group):
      $items = Content::faqs($group['slug']);
      if (!$items) { continue; } ?>
    <div class="faq-group reveal">
      <h2><?php echo e($group['title']); ?></h2>
      <div class="faq-list" data-faq-group>
        <?php foreach ($items as $faq): ?>
        <details class="faq-item">
          <summary><?php echo e($faq['question']); ?></summary>
          <div class="faq-answer"><?php echo $faq['answer']; ?></div>
        </details>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>
