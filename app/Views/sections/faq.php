<?php if (!empty($faqs)): ?>
<section class="section section--brand-soft reveal" id="preguntas">
  <div class="wrap wrap-narrow">
    <div class="section-head">
      <?php if ($section['eyebrow']): ?><p class="eyebrow"><?php echo e($section['eyebrow']); ?></p><?php endif; ?>
      <h2><?php echo e($section['heading']); ?></h2>
      <?php if ($section['subheading']): ?><p class="sub"><?php echo e($section['subheading']); ?></p><?php endif; ?>
    </div>
    <div class="faq-list" data-faq-group>
      <?php foreach ($faqs as $faq): ?>
      <details class="faq-item">
        <summary><?php echo e($faq['question']); ?></summary>
        <div class="faq-answer"><?php echo $faq['answer']; ?></div>
      </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
