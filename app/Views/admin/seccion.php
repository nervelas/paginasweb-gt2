<?php use App\Core\Csrf; ?>
<div class="ad-encabezado">
  <div>
    <p class="ad-migas"><a href="/admin/paginas/">Páginas</a> · <a href="/admin/paginas/<?php echo (int) $pagina['id']; ?>/"><?php echo e($pagina['name']); ?></a></p>
    <h1>Bloque <code><?php echo e($seccion['block_type']); ?></code></h1>
  </div>
  <a class="ad-btn ad-btn--fantasma" href="/<?php echo e($pagina['slug']); ?><?php echo $pagina['slug'] === '' ? '' : '/'; ?>" target="_blank" rel="noopener">Ver la página</a>
</div>

<form method="post" class="ad-formulario">
  <?php echo Csrf::field(); ?>
  <div class="ad-columnas">
    <div class="ad-columna-principal">
      <div class="ad-tarjeta">
        <div class="ad-campo">
          <label for="eyebrow">Texto pequeño superior</label>
          <input type="text" name="eyebrow" id="eyebrow" value="<?php echo e($seccion['eyebrow']); ?>">
        </div>
        <div class="ad-campo">
          <label for="heading">Encabezado</label>
          <input type="text" name="heading" id="heading" value="<?php echo e($seccion['heading']); ?>">
        </div>
        <div class="ad-campo">
          <label for="subheading">Bajada</label>
          <textarea name="subheading" id="subheading" rows="3"><?php echo e($seccion['subheading']); ?></textarea>
        </div>
        <div class="ad-campo">
          <label for="body">Contenido</label>
          <textarea name="body" id="body" rows="16" class="ad-html"><?php echo e($seccion['body']); ?></textarea>
          <p class="ad-ayuda">Se admite HTML básico: párrafos, listas, negritas, subtítulos h2 y h3, y enlaces. Los scripts y los marcos se eliminan al guardar.</p>
        </div>
      </div>
      <div class="ad-tarjeta">
        <h2>Imagen y botón</h2>
        <div class="ad-campo">
          <label for="image">Imagen</label>
          <input type="text" name="image" id="image" value="<?php echo e($seccion['image']); ?>">
        </div>
        <div class="ad-campo">
          <label for="image_alt">Texto alternativo</label>
          <input type="text" name="image_alt" id="image_alt" value="<?php echo e($seccion['image_alt']); ?>">
        </div>
        <div class="ad-campo">
          <label for="cta_text">Texto del botón</label>
          <input type="text" name="cta_text" id="cta_text" value="<?php echo e($seccion['cta_text']); ?>">
        </div>
        <div class="ad-campo">
          <label for="cta_url">Enlace del botón</label>
          <input type="text" name="cta_url" id="cta_url" value="<?php echo e($seccion['cta_url']); ?>">
          <p class="ad-ayuda">Escribí <code>whatsapp</code> para que abra el chat con el mensaje configurado.</p>
        </div>
      </div>
      <div class="ad-tarjeta">
        <h2>Datos adicionales</h2>
        <p class="ad-ayuda">Este bloque guarda en formato JSON los elementos repetidos: pasos del proceso, listas de ventajas, enlaces relacionados. Si no sabés qué es, no lo toqués.</p>
        <div class="ad-campo">
          <label for="extra">Contenido en JSON</label>
          <textarea name="extra" id="extra" rows="14" class="ad-mono" spellcheck="false"><?php
            echo e($seccion['extra'] ? json_encode(json_decode($seccion['extra'], true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : '');
          ?></textarea>
        </div>
      </div>
    </div>
    <aside class="ad-columna-lateral">
      <div class="ad-tarjeta ad-tarjeta--pegajosa">
        <div class="ad-campo">
          <label for="sort_order">Orden</label>
          <input type="number" name="sort_order" id="sort_order" value="<?php echo (int) $seccion['sort_order']; ?>">
        </div>
        <div class="ad-campo">
          <label class="ad-casilla">
            <input type="checkbox" name="visible" value="1"<?php echo $seccion['visible'] ? ' checked' : ''; ?>>
            <span>Mostrar esta sección</span>
          </label>
        </div>
        <button class="ad-btn ad-btn--bloque" type="submit">Guardar sección</button>
        <a class="ad-btn ad-btn--fantasma ad-btn--bloque" href="/admin/paginas/<?php echo (int) $pagina['id']; ?>/">Volver</a>
      </div>
    </aside>
  </div>
</form>
