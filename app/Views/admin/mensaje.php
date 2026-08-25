<div class="ad-encabezado">
  <div>
    <p class="ad-migas"><a href="/admin/mensajes/">Bandeja de mensajes</a></p>
    <h1><?php echo e($mensaje['name']); ?></h1>
    <p class="ad-sub">Recibido el <?php echo e(fecha_es($mensaje['created_at'])); ?> a las <?php echo e(date('H:i', strtotime($mensaje['created_at']))); ?></p>
  </div>
  <a class="ad-btn" href="mailto:<?php echo e($mensaje['email']); ?>?subject=<?php echo rawurlencode('Tu consulta en paginasweb.gt'); ?>">Responder por correo</a>
</div>

<div class="ad-columnas">
  <div class="ad-columna-principal">
    <div class="ad-tarjeta">
      <h2>Mensaje</h2>
      <p style="white-space:pre-wrap"><?php echo e($mensaje['message']); ?></p>
    </div>
  </div>
  <aside class="ad-columna-lateral">
    <div class="ad-tarjeta">
      <h2>Datos</h2>
      <dl class="ad-datos">
        <dt>Correo</dt><dd><a href="mailto:<?php echo e($mensaje['email']); ?>"><?php echo e($mensaje['email']); ?></a></dd>
        <dt>Teléfono</dt><dd><?php echo $mensaje['phone'] ? '<a href="tel:' . e($mensaje['phone']) . '">' . e($mensaje['phone']) . '</a>' : '—'; ?></dd>
        <dt>Servicio</dt><dd><?php echo e($mensaje['service'] ? $mensaje['service'] : '—'); ?></dd>
        <dt>Página de origen</dt><dd><code><?php echo e($mensaje['page']); ?></code></dd>
        <dt>Dirección IP</dt><dd><?php echo e($mensaje['ip']); ?></dd>
      </dl>
    </div>
  </aside>
</div>
