<div class="ad-encabezado">
  <div>
    <h1>Escritorio</h1>
    <p class="ad-sub">Hola<?php echo isset($usuario['name']) ? ', ' . e(explode(' ', $usuario['name'])[0]) : ''; ?>. Acá está el estado del sitio.</p>
  </div>
</div>

<?php foreach ($avisos as $aviso): ?>
<div class="ad-aviso ad-aviso--<?php echo $aviso['tipo'] === 'error' ? 'error' : 'nota'; ?>"><?php echo e($aviso['texto']); ?></div>
<?php endforeach; ?>

<div class="ad-metricas">
  <?php foreach ($resumen as $m): ?>
  <a class="ad-metrica" href="<?php echo e($m['url']); ?>">
    <strong><?php echo (int) $m['valor']; ?></strong>
    <span><?php echo e($m['etiqueta']); ?></span>
  </a>
  <?php endforeach; ?>
</div>

<div class="ad-columnas">
  <div class="ad-columna-principal">
    <div class="ad-tarjeta">
      <h2>Últimas solicitudes</h2>
      <?php if (!$ultimos): ?>
        <p class="ad-ayuda">Todavía no hay mensajes del formulario.</p>
      <?php else: ?>
      <div class="ad-tabla-caja">
        <table class="ad-tabla">
          <thead><tr><th scope="col">Persona</th><th scope="col">Servicio</th><th scope="col">Fecha</th><th scope="col">Estado</th></tr></thead>
          <tbody>
            <?php foreach ($ultimos as $m): ?>
            <tr>
              <td data-etiqueta="Persona"><a class="ad-enlace-fuerte" href="/admin/mensajes/<?php echo (int) $m['id']; ?>/"><?php echo e($m['name']); ?></a></td>
              <td data-etiqueta="Servicio"><?php echo e($m['service'] ? $m['service'] : '—'); ?></td>
              <td data-etiqueta="Fecha"><?php echo e(fecha_es($m['created_at'])); ?></td>
              <td data-etiqueta="Estado"><span class="ad-pastilla <?php echo $m['status'] === 'nuevo' ? 'no' : 'si'; ?>"><?php echo e($m['status']); ?></span></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>

    <div class="ad-tarjeta">
      <h2>Antes de tocar el contenido</h2>
      <p class="ad-ayuda">Tres reglas que mantienen el sitio fuera de problemas con Google:</p>
      <ul class="ad-lista">
        <li><strong>No copiés textos de otros sitios</strong>, ni siquiera de servicom.gt. Si dos dominios publican lo mismo, Google elige uno y descarta el otro.</li>
        <li><strong>No repitás la palabra clave</strong> a la fuerza. Si al leer en voz alta suena raro, está de más.</li>
        <li><strong>No inventés testimonios ni cifras.</strong> Es la forma más rápida de perder credibilidad y, si alguien reclama, de tener un problema legal.</li>
      </ul>
    </div>
  </div>

  <aside class="ad-columna-lateral">
    <div class="ad-tarjeta">
      <h2>Accesos rápidos</h2>
      <ul class="ad-lista ad-lista--enlaces">
        <li><a href="/admin/blog/nuevo/">Escribir un artículo</a></li>
        <li><a href="/admin/portafolio/nuevo/">Agregar un proyecto</a></li>
        <li><a href="/admin/faq/nuevo/">Agregar una pregunta frecuente</a></li>
        <li><a href="/admin/planes/">Actualizar precios</a></li>
        <li><a href="/admin/configuracion/">Teléfono, WhatsApp y correo</a></li>
        <li><a href="/sitemap.xml" target="_blank" rel="noopener">Ver el sitemap</a></li>
      </ul>
    </div>
  </aside>
</div>
