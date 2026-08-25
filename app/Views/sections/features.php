<?php $items = isset($section['extra']['items']) ? $section['extra']['items'] : [];
$iconos = [
  'phone' => 'celular', 'bolt' => 'rayo', 'shield' => 'escudo', 'search' => 'lupa',
  'chat' => 'chat', 'edit' => 'lapiz', 'layout' => 'retícula', 'image' => 'imagen',
  'mail' => 'sobre', 'chart' => 'grafica', 'cart' => 'carrito', 'truck' => 'camion',
  'card' => 'tarjeta', 'box' => 'caja', 'file' => 'archivo', 'browser' => 'navegador',
];
?>
<?php echo partial('partials/band-open', ['lienzo' => $lienzo, 'regla' => $regla]); ?>
  <?php echo partial('partials/head-block', ['section' => $section, 'n' => $n, 'split' => true]); ?>
  <?php if ($section['body']): ?>
  <div class="lede rise" style="max-width:60ch;margin-bottom:clamp(30px,4vw,48px)"><?php echo $section['body']; ?></div>
  <?php endif; ?>
  <div class="specs rise">
    <?php foreach ($items as $i => $item): ?>
    <div class="specs__item">
      <span class="specs__n">
        <?php echo str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT); ?>
      </span>
      <h3><?php echo e($item['title']); ?></h3>
      <p><?php echo e($item['text']); ?></p>
    </div>
    <?php endforeach; ?>
  </div>
<?php echo partial('partials/band-close'); ?>
