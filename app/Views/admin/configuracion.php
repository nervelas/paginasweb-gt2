<?php use App\Core\Csrf; use App\Core\Settings; ?>
<div class="ad-encabezado">
  <div>
    <h1>Configuración</h1>
    <p class="ad-sub">Datos que se usan en todo el sitio.</p>
  </div>
</div>

<form method="post" class="ad-formulario">
  <?php echo Csrf::field(); ?>
  <?php foreach ($grupos as $clave => $grupo): ?>
  <div class="ad-tarjeta">
    <h2><?php echo e($grupo['titulo']); ?></h2>
    <?php if (!empty($grupo['nota'])): ?><p class="ad-ayuda"><?php echo e($grupo['nota']); ?></p><?php endif; ?>
    <div class="ad-rejilla">
      <?php foreach ($grupo['campos'] as $nombre => $campo):
        $valor = Settings::get($nombre, '');
        $ancho = in_array($campo['tipo'], ['area'], true) ? ' ad-ancho' : '';
      ?>
      <div class="ad-campo<?php echo $ancho; ?>">
        <?php if ($campo['tipo'] === 'casilla'): ?>
          <label class="ad-casilla">
            <input type="checkbox" name="<?php echo e($nombre); ?>" value="1"<?php echo $valor === '1' ? ' checked' : ''; ?>>
            <span><?php echo e($campo['etiqueta']); ?></span>
          </label>
        <?php else: ?>
          <label for="c-<?php echo e($nombre); ?>"><?php echo e($campo['etiqueta']); ?></label>
          <?php if ($campo['tipo'] === 'area'): ?>
            <textarea name="<?php echo e($nombre); ?>" id="c-<?php echo e($nombre); ?>" rows="3"><?php echo e($valor); ?></textarea>
          <?php elseif ($campo['tipo'] === 'color'): ?>
            <span class="ad-color">
              <input type="color" value="<?php echo e($valor ? $valor : '#000000'); ?>" aria-label="Selector" data-color-para="c-<?php echo e($nombre); ?>">
              <input type="text" name="<?php echo e($nombre); ?>" id="c-<?php echo e($nombre); ?>" value="<?php echo e($valor); ?>">
            </span>
          <?php else: ?>
            <input type="text" name="<?php echo e($nombre); ?>" id="c-<?php echo e($nombre); ?>" value="<?php echo e($valor); ?>">
          <?php endif; ?>
        <?php endif; ?>
        <?php if (!empty($campo['ayuda'])): ?><p class="ad-ayuda"><?php echo e($campo['ayuda']); ?></p><?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endforeach; ?>
  <div class="ad-barra-guardar">
    <button class="ad-btn" type="submit">Guardar configuración</button>
  </div>
</form>
