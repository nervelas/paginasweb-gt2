<?php
use App\Core\Settings;
$cta = $plan['cta_url'] === 'whatsapp' ? Settings::whatsappLink() : $plan['cta_url'];
$feats = array_filter(array_map('trim', explode("\n", (string) $plan['features'])));
$lead = !empty($plan['featured']);
?>
<div class="plan<?php echo $lead ? ' plan--lead' : ''; ?>">
  <?php if (!empty($plan['badge'])): ?><span class="plan__badge"><?php echo e($plan['badge']); ?></span><?php endif; ?>
  <?php if (!empty($servicioNombre)): ?><p class="plan__svc"><?php echo e($servicioNombre); ?></p><?php endif; ?>
  <h3><?php echo e($plan['name']); ?></h3>
  <div class="plan__price">
    <span class="plan__amount"><?php echo $plan['price'] !== null ? e(money($plan['price'])) : e($plan['price_text']); ?></span>
    <span class="plan__per"><?php echo e($plan['period']); ?></span>
  </div>
  <?php if ($plan['price_strike'] !== null): ?>
  <span class="plan__was">antes <?php echo e(money($plan['price_strike'])); ?></span>
  <?php endif; ?>
  <?php if ($plan['price_note']): ?><p class="plan__note"><?php echo e($plan['price_note']); ?></p><?php endif; ?>
  <ul class="plan__feats">
    <?php foreach ($feats as $f): ?><li><?php echo e($f); ?></li><?php endforeach; ?>
  </ul>
  <a class="btn <?php echo $lead ? 'btn--signal' : 'btn--line'; ?> btn--block" href="<?php echo e($cta); ?>">
    <?php echo e($plan['cta_text']); ?>
  </a>
</div>
