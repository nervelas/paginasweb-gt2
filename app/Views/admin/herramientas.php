<?php use App\Core\Csrf; ?>
<div class="ad-encabezado">
  <div>
    <h1>Herramientas</h1>
    <p class="ad-sub">Comprobaciones rápidas del servidor.</p>
  </div>
</div>

<?php if ($resultado): ?>
<div class="ad-aviso ad-aviso--nota"><?php echo e($resultado); ?></div>
<?php endif; ?>

<div class="ad-columnas">
  <div class="ad-columna-principal">
    <div class="ad-tarjeta">
      <h2>Estado del servidor</h2>
      <dl class="ad-datos">
        <?php foreach ($entorno as $clave => $valor): ?>
        <dt><?php echo e($clave); ?></dt><dd><?php echo e($valor); ?></dd>
        <?php endforeach; ?>
      </dl>
    </div>
    <div class="ad-tarjeta">
      <h2>Probar el envío de correo</h2>
      <p class="ad-ayuda">Envía un mensaje de prueba a la dirección configurada para los formularios. Si no llega, revisá la carpeta de spam y la configuración de correo del hosting.</p>
      <form method="post">
        <?php echo Csrf::field(); ?>
        <button class="ad-btn" type="submit" name="probar_correo" value="1">Enviar correo de prueba</button>
      </form>
    </div>
  </div>
  <aside class="ad-columna-lateral">
    <div class="ad-tarjeta">
      <h2>Enlaces útiles</h2>
      <ul class="ad-lista ad-lista--enlaces">
        <li><a href="/sitemap.xml" target="_blank" rel="noopener">sitemap.xml</a></li>
        <li><a href="/robots.txt" target="_blank" rel="noopener">robots.txt</a></li>
        <li><a href="https://search.google.com/search-console" target="_blank" rel="noopener">Google Search Console</a></li>
        <li><a href="https://pagespeed.web.dev/" target="_blank" rel="noopener">PageSpeed Insights</a></li>
        <li><a href="https://search.google.com/test/rich-results" target="_blank" rel="noopener">Prueba de resultados enriquecidos</a></li>
      </ul>
    </div>
  </aside>
</div>
