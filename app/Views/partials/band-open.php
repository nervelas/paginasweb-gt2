<?php
/**
 * Abre una sección con su lienzo y, si hace falta, la regla que la separa
 * de la sección anterior del mismo color.
 */
$clases = 'band band--' . (isset($lienzo) ? $lienzo : 'bone');
if (!empty($tight)) { $clases .= ' band--tight'; }
?>
<section class="<?php echo e($clases); ?>"<?php echo isset($id) ? ' id="' . e($id) . '"' : ''; ?>>
  <div class="wrap<?php echo !empty($narrow) ? ' wrap--text' : ''; ?>">
    <?php if (!empty($regla)): ?><hr class="rule" style="margin-bottom:clamp(48px,6vw,88px)"><?php endif; ?>
