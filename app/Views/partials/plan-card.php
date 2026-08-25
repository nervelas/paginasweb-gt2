<?php
use App\Core\Settings;
$mostrarServicio = isset($mostrarServicio) ? $mostrarServicio : false;
$cta = $plan['cta_url'] === 'whatsapp' ? Settings::whatsappLink() : $plan['cta_url'];
$features = array_filter(array_map('trim', explode("\n", (string) $plan['features'])));
?>
<div class="card plan<?php echo $plan['featured'] ? ' plan--featured' : ''; ?>">
  <?php if ($plan['badge']): ?><span class="plan__badge"><?php echo e($plan['badge']); ?></span><?php endif; ?>
  <?php if ($mostrarServicio && !empty($servicioNombre)): ?>
    <p class="plan__service"><?php echo e($servicioNombre); ?></p>
  <?php endif; ?>
  <h3><?php echo e($plan['name']); ?></h3>
  <div class="plan__price">
    <span class="plan__amount"><?php echo $plan['price'] !== null ? e(money($plan['price'])) : e($plan['price_text']); ?></span>
    <span class="plan__period"><?php echo e($plan['period']); ?></span>
    <?php if ($plan['price_strike'] !== null): ?>
      <span class="plan__strike">antes <?php echo e(money($plan['price_strike'])); ?></span>
    <?php endif; ?>
  </div>
  <?php if ($plan['price_note']): ?><p class="plan__note"><?php echo e($plan['price_note']); ?></p><?php endif; ?>
  <ul class="plan__features">
    <?php foreach ($features as $feature): ?><li><?php echo e($feature); ?></li><?php endforeach; ?>
  </ul>
  <a class="btn <?php echo $plan['featured'] ? 'btn--primary' : 'btn--ghost'; ?> btn--block" href="<?php echo e($cta); ?>">
    <?php echo e($plan['cta_text']); ?>
  </a>
</div>
