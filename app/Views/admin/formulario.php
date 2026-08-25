<?php use App\Core\Csrf; $def = $crud->def(); ?>
<div class="ad-encabezado">
  <div>
    <p class="ad-migas"><a href="/admin/<?php echo e($crud->clave()); ?>/"><?php echo e($def['titulo']); ?></a></p>
    <h1><?php echo e($titulo); ?></h1>
  </div>
  <?php if ($registro && $crud->clave() === 'paginas'): ?>
    <a class="ad-btn ad-btn--fantasma" href="/<?php echo e($registro['slug']); ?><?php echo $registro['slug'] === '' ? '' : '/'; ?>" target="_blank" rel="noopener">Ver la página</a>
  <?php elseif ($registro && $crud->clave() === 'blog'): ?>
    <a class="ad-btn ad-btn--fantasma" href="/blog/<?php echo e($registro['slug']); ?>/" target="_blank" rel="noopener">Ver el artículo</a>
  <?php endif; ?>
</div>

<form method="post" class="ad-formulario">
  <?php echo Csrf::field(); ?>
  <div class="ad-columnas">
    <div class="ad-columna-principal">
      <div class="ad-tarjeta">
        <?php
        $seo = ['meta_title', 'meta_description', 'canonical', 'og_image', 'robots_index'];
        $lateral = ['sort_order', 'visible', 'featured', 'published_at', 'category_id', 'service_id', 'location', 'status_code', 'icon'];
        foreach ($def['campos'] as $nombre => $campo) {
            if (in_array($nombre, $seo, true) || in_array($nombre, $lateral, true)) {
                continue;
            }
            echo partial('admin/campo', [
                'nombre' => $nombre,
                'campo'  => $campo,
                'valor'  => isset($valores[$nombre]) ? $valores[$nombre] : '',
                'error'  => isset($errores[$nombre]) ? $errores[$nombre] : null,
                'crud'   => $crud,
            ]);
        }
        ?>
      </div>

      <?php
      $tieneSeo = false;
      foreach ($seo as $nombre) { if (isset($def['campos'][$nombre])) { $tieneSeo = true; } }
      if ($tieneSeo): ?>
      <div class="ad-tarjeta">
        <h2>Posicionamiento en buscadores</h2>
        <p class="ad-ayuda">El título y la descripción son lo que Google muestra en los resultados. Escribilos para una persona, no para el buscador: si suenan a lista de palabras clave, pierden clics y pueden traer problemas.</p>
        <?php foreach ($seo as $nombre) {
            if (!isset($def['campos'][$nombre])) { continue; }
            echo partial('admin/campo', [
                'nombre' => $nombre,
                'campo'  => $def['campos'][$nombre],
                'valor'  => isset($valores[$nombre]) ? $valores[$nombre] : '',
                'error'  => isset($errores[$nombre]) ? $errores[$nombre] : null,
                'crud'   => $crud,
            ]);
        } ?>
      </div>
      <?php endif; ?>
    </div>

    <aside class="ad-columna-lateral">
      <div class="ad-tarjeta ad-tarjeta--pegajosa">
        <?php foreach ($lateral as $nombre) {
            if (!isset($def['campos'][$nombre])) { continue; }
            echo partial('admin/campo', [
                'nombre' => $nombre,
                'campo'  => $def['campos'][$nombre],
                'valor'  => isset($valores[$nombre]) ? $valores[$nombre] : '',
                'error'  => isset($errores[$nombre]) ? $errores[$nombre] : null,
                'crud'   => $crud,
            ]);
        } ?>
        <button class="ad-btn ad-btn--bloque" type="submit">Guardar cambios</button>
        <a class="ad-btn ad-btn--fantasma ad-btn--bloque" href="/admin/<?php echo e($crud->clave()); ?>/">Cancelar</a>
      </div>
    </aside>
  </div>
</form>

<?php if (!empty($secciones)): ?>
<div class="ad-tarjeta" style="margin-top:22px">
  <h2>Secciones de esta página</h2>
  <p class="ad-ayuda">Cada bloque de la página se edita por separado. El orden determina cómo se muestran.</p>
  <div class="ad-tabla-caja">
    <table class="ad-tabla">
      <thead><tr><th scope="col">Orden</th><th scope="col">Bloque</th><th scope="col">Encabezado</th><th scope="col">Visible</th><th scope="col"><span class="visually-hidden">Acción</span></th></tr></thead>
      <tbody>
        <?php foreach ($secciones as $s): ?>
        <tr>
          <td data-etiqueta="Orden"><?php echo (int) $s['sort_order']; ?></td>
          <td data-etiqueta="Bloque"><code><?php echo e($s['block_type']); ?></code></td>
          <td data-etiqueta="Encabezado"><?php echo e($s['heading'] ? $s['heading'] : '(sin encabezado)'); ?></td>
          <td data-etiqueta="Visible"><span class="ad-pastilla <?php echo $s['visible'] ? 'si' : 'no'; ?>"><?php echo $s['visible'] ? 'Sí' : 'No'; ?></span></td>
          <td class="ad-acciones"><a class="ad-btn ad-btn--chico ad-btn--fantasma" href="/admin/secciones/<?php echo (int) $s['id']; ?>/">Editar</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif; ?>
