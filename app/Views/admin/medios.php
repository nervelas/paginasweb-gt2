<?php use App\Core\Csrf; use App\Core\Uploader; ?>
<div class="ad-encabezado">
  <div>
    <h1>Medios</h1>
    <p class="ad-sub">Las imágenes se redimensionan a 1920 píxeles de ancho y se convierten a <?php echo Uploader::soportaWebp() ? 'WebP' : 'JPG (este servidor no soporta WebP)'; ?>.</p>
  </div>
</div>

<div class="ad-tarjeta">
  <h2>Subir una imagen</h2>
  <form method="post" enctype="multipart/form-data" class="ad-subida">
    <?php echo Csrf::field(); ?>
    <div class="ad-campo">
      <label for="archivo">Archivo (JPG, PNG, WebP o GIF, hasta 8 MB)</label>
      <input type="file" name="archivo" id="archivo" accept="image/jpeg,image/png,image/webp,image/gif" required>
    </div>
    <div class="ad-campo">
      <label for="alt">Texto alternativo</label>
      <input type="text" name="alt" id="alt" placeholder="Describí la imagen para quien no puede verla">
    </div>
    <button class="ad-btn" type="submit">Subir</button>
  </form>
</div>

<?php if (!$items): ?>
  <div class="ad-vacio"><p>Todavía no subiste ninguna imagen.</p></div>
<?php else: ?>
<div class="ad-galeria">
  <?php foreach ($items as $m): ?>
  <figure class="ad-medio">
    <img src="<?php echo e($m['path']); ?>" alt="<?php echo e($m['alt']); ?>" loading="lazy" width="<?php echo (int) $m['width']; ?>" height="<?php echo (int) $m['height']; ?>">
    <figcaption>
      <code data-copiar="<?php echo e($m['path']); ?>" title="Clic para copiar la ruta"><?php echo e($m['path']); ?></code>
      <span><?php echo (int) $m['width']; ?>×<?php echo (int) $m['height']; ?> · <?php echo round($m['filesize'] / 1024); ?> KB</span>
      <form method="post" onsubmit="return confirm('¿Eliminar esta imagen? Si está en uso, quedará rota en el sitio.')">
        <?php echo Csrf::field(); ?>
        <input type="hidden" name="eliminar" value="<?php echo (int) $m['id']; ?>">
        <button class="ad-btn ad-btn--chico ad-btn--peligro" type="submit">Borrar</button>
      </form>
    </figcaption>
  </figure>
  <?php endforeach; ?>
</div>
<?php endif; ?>
