<?php
use App\Core\Settings;
$wa = Settings::whatsappDigits();
?>
<div class="floating">
  <?php if ($wa): ?>
  <a class="floating__wa" href="<?php echo e(Settings::whatsappLink()); ?>" rel="noopener"
     aria-label="Escribir por WhatsApp">
    <?php echo partial('partials/icon', ['name' => 'whatsapp', 'size' => 27]); ?>
  </a>
  <?php endif; ?>
  <a class="floating__call" href="<?php echo e(Settings::telLink()); ?>" aria-label="Llamar por teléfono">
    <?php echo partial('partials/icon', ['name' => 'phone', 'size' => 25]); ?>
  </a>
</div>
