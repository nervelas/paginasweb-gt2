<?php
use App\Core\Settings;
$wa = Settings::whatsappDigits();
?>
<div class="dock">
  <?php if ($wa): ?>
  <a href="<?php echo e(Settings::whatsappLink()); ?>" rel="noopener" aria-label="Escribir por WhatsApp">
    <?php echo partial('partials/icon', ['name' => 'whatsapp', 'size' => 17]); ?>
    <span>WhatsApp</span>
  </a>
  <?php endif; ?>
  <a class="dock__call" href="<?php echo e(Settings::telLink()); ?>" aria-label="Llamar por teléfono">
    <?php echo partial('partials/icon', ['name' => 'celular', 'size' => 17]); ?>
    <span>Llamar</span>
  </a>
</div>
