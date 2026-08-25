<?php use App\Core\Csrf; $def = $crud->def(); ?>
<div class="ad-encabezado">
  <div>
    <h1><?php echo e($def['titulo']); ?></h1>
    <p class="ad-sub"><?php echo count($filas); ?> registro<?php echo count($filas) === 1 ? '' : 's'; ?></p>
  </div>
  <?php if ($crud->permiteCrear()): ?>
  <a class="ad-btn" href="/admin/<?php echo e($crud->clave()); ?>/nuevo/">Agregar <?php echo e($def['singular']); ?></a>
  <?php endif; ?>
</div>

<?php if (!empty($def['aviso'])): ?>
<div class="ad-aviso ad-aviso--nota"><?php echo e($def['aviso']); ?></div>
<?php endif; ?>

<?php if (!$filas): ?>
  <div class="ad-vacio">
    <p>Todavía no hay registros en este módulo.</p>
  </div>
<?php else: ?>
<div class="ad-tabla-caja">
  <table class="ad-tabla">
    <thead>
      <tr>
        <?php foreach ($def['columnas'] as $col => $etiqueta): ?>
        <th scope="col"><?php echo e($etiqueta); ?></th>
        <?php endforeach; ?>
        <th scope="col"><span class="visually-hidden">Acciones</span></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($filas as $fila): ?>
      <tr>
        <?php $primera = true; foreach ($def['columnas'] as $col => $etiqueta):
          $valor = isset($fila[$col]) ? $fila[$col] : ''; ?>
        <td data-etiqueta="<?php echo e($etiqueta); ?>">
          <?php if ($primera): ?>
            <a class="ad-enlace-fuerte" href="/admin/<?php echo e($crud->clave()); ?>/<?php echo (int) $fila['id']; ?>/">
              <?php echo e($valor === '' ? '(sin nombre)' : $valor); ?>
            </a>
          <?php elseif (in_array($col, ['visible', 'featured', 'robots_index'], true)): ?>
            <span class="ad-pastilla <?php echo $valor ? 'si' : 'no'; ?>"><?php echo $valor ? 'Sí' : 'No'; ?></span>
          <?php elseif ($col === 'price'): ?>
            <?php echo $valor === null || $valor === '' ? '—' : e(money($valor)); ?>
          <?php elseif ($col === 'published_at'): ?>
            <?php echo e($valor ? fecha_es($valor) : '—'); ?>
          <?php elseif ($col === 'slug'): ?>
            <code>/<?php echo e($valor); ?><?php echo $valor === '' ? '' : '/'; ?></code>
          <?php else: ?>
            <?php echo e(excerpt((string) $valor, 90)); ?>
          <?php endif; ?>
        </td>
        <?php $primera = false; endforeach; ?>
        <td class="ad-acciones">
          <a class="ad-btn ad-btn--chico ad-btn--fantasma" href="/admin/<?php echo e($crud->clave()); ?>/<?php echo (int) $fila['id']; ?>/">Editar</a>
          <?php if ($crud->permiteBorrar()): ?>
          <form method="post" action="/admin/<?php echo e($crud->clave()); ?>/<?php echo (int) $fila['id']; ?>/borrar/"
                onsubmit="return confirm('¿Seguro que querés eliminar este registro? No se puede deshacer.')">
            <?php echo Csrf::field(); ?>
            <button class="ad-btn ad-btn--chico ad-btn--peligro" type="submit">Borrar</button>
          </form>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php endif; ?>
