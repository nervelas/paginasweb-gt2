<?php use App\Core\Csrf; ?>
<div class="ad-encabezado">
  <div>
    <h1>Bandeja de mensajes</h1>
    <p class="ad-sub"><?php echo count($mensajes); ?> mensaje<?php echo count($mensajes) === 1 ? '' : 's'; ?></p>
  </div>
</div>

<?php if (!$mensajes): ?>
  <div class="ad-vacio"><p>Todavía no llegó ningún mensaje del formulario de contacto.</p></div>
<?php else: ?>
<div class="ad-tabla-caja">
  <table class="ad-tabla">
    <thead><tr><th scope="col">Persona</th><th scope="col">Contacto</th><th scope="col">Servicio</th><th scope="col">Fecha</th><th scope="col">Estado</th><th scope="col"><span class="visually-hidden">Acciones</span></th></tr></thead>
    <tbody>
      <?php foreach ($mensajes as $m): ?>
      <tr>
        <td data-etiqueta="Persona"><a class="ad-enlace-fuerte" href="/admin/mensajes/<?php echo (int) $m['id']; ?>/"><?php echo e($m['name']); ?></a></td>
        <td data-etiqueta="Contacto">
          <a href="mailto:<?php echo e($m['email']); ?>"><?php echo e($m['email']); ?></a>
          <?php if ($m['phone']): ?><br><span class="ad-ayuda"><?php echo e($m['phone']); ?></span><?php endif; ?>
        </td>
        <td data-etiqueta="Servicio"><?php echo e($m['service'] ? $m['service'] : '—'); ?></td>
        <td data-etiqueta="Fecha"><?php echo e(fecha_es($m['created_at'])); ?></td>
        <td data-etiqueta="Estado"><span class="ad-pastilla <?php echo $m['status'] === 'nuevo' ? 'no' : 'si'; ?>"><?php echo e($m['status']); ?></span></td>
        <td class="ad-acciones">
          <a class="ad-btn ad-btn--chico ad-btn--fantasma" href="/admin/mensajes/<?php echo (int) $m['id']; ?>/">Abrir</a>
          <form method="post" onsubmit="return confirm('¿Eliminar este mensaje?')">
            <?php echo Csrf::field(); ?>
            <input type="hidden" name="eliminar" value="<?php echo (int) $m['id']; ?>">
            <button class="ad-btn ad-btn--chico ad-btn--peligro" type="submit">Borrar</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php endif; ?>
