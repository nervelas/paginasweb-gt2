<?php
/**
 * Encabezado de sección: número + etiqueta, titular y bajada.
 * Espera $section, $n y opcionalmente $split (bajada a la derecha).
 */
$titulo = isset($section['heading']) ? $section['heading'] : '';
$bajada = isset($section['subheading']) ? $section['subheading'] : '';
$etiqueta = isset($section['eyebrow']) ? $section['eyebrow'] : '';
$split = !empty($split) && $bajada !== '';
?>
<div class="head<?php echo $split ? ' head--split' : ''; ?> rise">
  <div>
    <?php if ($etiqueta !== ''): ?>
      <p class="tag" data-num="<?php echo e($n); ?>"><?php echo e($etiqueta); ?></p>
    <?php endif; ?>
    <?php if ($titulo !== ''): ?>
      <h2 class="head__title"><?php echo e($titulo); ?></h2>
    <?php endif; ?>
    <?php if (!$split && $bajada !== ''): ?>
      <p class="lede"><?php echo e($bajada); ?></p>
    <?php endif; ?>
  </div>
  <?php if ($split): ?>
  <div class="head__aside"><p class="lede"><?php echo e($bajada); ?></p></div>
  <?php endif; ?>
</div>
