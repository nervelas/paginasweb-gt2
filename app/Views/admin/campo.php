<?php
/**
 * Dibuja un campo del formulario según su tipo.
 * Espera: $nombre, $campo, $valor, $error, $crud (opcional)
 */
$id    = 'campo-' . $nombre;
$error = isset($error) ? $error : null;
$valor = $valor === null ? '' : $valor;
if ($campo['tipo'] === 'oculto') {
    echo '<input type="hidden" name="' . e($nombre) . '" value="' . e($valor) . '">';
    return;
}
$filas = isset($campo['filas']) ? (int) $campo['filas'] : 4;
?>
<div class="ad-campo<?php echo $error ? ' con-error' : ''; ?>">
  <?php if ($campo['tipo'] === 'casilla'): ?>
    <label class="ad-casilla">
      <input type="checkbox" name="<?php echo e($nombre); ?>" id="<?php echo e($id); ?>" value="1"<?php echo $valor ? ' checked' : ''; ?>>
      <span><?php echo e($campo['etiqueta']); ?></span>
    </label>
  <?php else: ?>
    <label for="<?php echo e($id); ?>">
      <?php echo e($campo['etiqueta']); ?>
      <?php if (!empty($campo['requerido'])): ?><i>obligatorio</i><?php endif; ?>
    </label>

    <?php if ($campo['tipo'] === 'area' || $campo['tipo'] === 'html' || $campo['tipo'] === 'lista'): ?>
      <textarea name="<?php echo e($nombre); ?>" id="<?php echo e($id); ?>" rows="<?php echo $filas; ?>"
        <?php echo isset($campo['contador']) ? 'data-contador="' . (int) $campo['contador'] . '"' : ''; ?>
        <?php echo $campo['tipo'] === 'html' ? 'class="ad-html" spellcheck="true"' : ''; ?>><?php echo e($valor); ?></textarea>

    <?php elseif ($campo['tipo'] === 'seleccion'): ?>
      <select name="<?php echo e($nombre); ?>" id="<?php echo e($id); ?>">
        <option value="">— Elegir —</option>
        <?php foreach ($crud->opciones($campo) as $v => $t): ?>
        <option value="<?php echo e((string) $v); ?>"<?php echo ((string) $valor === (string) $v) ? ' selected' : ''; ?>><?php echo e($t); ?></option>
        <?php endforeach; ?>
      </select>

    <?php elseif ($campo['tipo'] === 'imagen'): ?>
      <div class="ad-imagen">
        <input type="text" name="<?php echo e($nombre); ?>" id="<?php echo e($id); ?>" value="<?php echo e($valor); ?>"
               placeholder="/uploads/2026/01/imagen.webp" data-vista-previa>
        <?php if ($valor): ?><img src="<?php echo e($valor); ?>" alt="" loading="lazy"><?php endif; ?>
      </div>
      <p class="ad-ayuda">Subí la imagen en <a href="/admin/medios/" target="_blank">Medios</a> y pegá acá la ruta que te dé.</p>

    <?php elseif ($campo['tipo'] === 'color'): ?>
      <span class="ad-color">
        <input type="color" value="<?php echo e($valor ? $valor : '#000000'); ?>" aria-label="Selector de color" data-color-para="<?php echo e($id); ?>">
        <input type="text" name="<?php echo e($nombre); ?>" id="<?php echo e($id); ?>" value="<?php echo e($valor); ?>" placeholder="#123456">
      </span>

    <?php elseif ($campo['tipo'] === 'fecha'): ?>
      <input type="datetime-local" name="<?php echo e($nombre); ?>" id="<?php echo e($id); ?>"
             value="<?php echo e($valor ? date('Y-m-d\TH:i', strtotime($valor)) : ''); ?>">

    <?php elseif ($campo['tipo'] === 'numero'): ?>
      <input type="number" name="<?php echo e($nombre); ?>" id="<?php echo e($id); ?>" value="<?php echo e((string) $valor); ?>" step="1">

    <?php elseif ($campo['tipo'] === 'precio'): ?>
      <input type="number" name="<?php echo e($nombre); ?>" id="<?php echo e($id); ?>" value="<?php echo e($valor === '' || $valor === null ? '' : (string) (float) $valor); ?>" step="0.01" min="0">

    <?php else: ?>
      <input type="text" name="<?php echo e($nombre); ?>" id="<?php echo e($id); ?>" value="<?php echo e($valor); ?>"
        <?php echo isset($campo['contador']) ? 'data-contador="' . (int) $campo['contador'] . '"' : ''; ?>
        <?php echo isset($campo['max']) ? 'maxlength="' . ((int) $campo['max'] + 20) . '"' : ''; ?>>
    <?php endif; ?>
  <?php endif; ?>

  <?php if (!empty($campo['ayuda'])): ?><p class="ad-ayuda"><?php echo $campo['ayuda']; ?></p><?php endif; ?>
  <?php if ($error): ?><p class="ad-error"><?php echo e($error); ?></p><?php endif; ?>
</div>
