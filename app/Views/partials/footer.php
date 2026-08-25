<?php
use App\Core\Settings;
$redes = array_filter([
    'facebook'  => Settings::get('social_facebook'),
    'instagram' => Settings::get('social_instagram'),
    'linkedin'  => Settings::get('social_linkedin'),
    'youtube'   => Settings::get('social_youtube'),
]);
?>
<footer class="foot band--dark">
  <div class="wrap foot__in">
    <div class="foot__grid">
      <div>
        <img class="foot__logo" src="<?php echo e(Settings::get('logo_white', '/assets/img/marca.svg')); ?>"
             alt="<?php echo e(Settings::get('site_name')); ?>" width="188" height="24" loading="lazy">
        <p class="foot__about">
          <?php echo e(Settings::get('footer_about')); ?>
          <?php if (Settings::get('parent_site_url')): ?>
            Conocé también <a href="<?php echo e(Settings::get('parent_site_url')); ?>">servicom.gt</a>.
          <?php endif; ?>
        </p>
        <?php if ($redes): ?>
        <div class="foot__social">
          <?php foreach ($redes as $red => $enlace): ?>
          <a href="<?php echo e($enlace); ?>" rel="noopener" aria-label="<?php echo e(ucfirst($red)); ?>">
            <?php echo partial('partials/icon', ['name' => $red, 'size' => 16]); ?>
          </a>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

      <div class="foot__col">
        <h2>Servicios</h2>
        <ul>
          <?php foreach ($menuServicios as $i): ?>
          <li><a href="<?php echo e($i['url']); ?>"><?php echo e($i['label']); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="foot__col">
        <h2>Estudio</h2>
        <ul>
          <?php foreach ($menuEmpresa as $i): ?>
          <li><a href="<?php echo e($i['url']); ?>"><?php echo e($i['label']); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="foot__col">
        <h2>Contacto</h2>
        <div class="foot__data">
          <div>
            <b>Teléfono y WhatsApp</b>
            <a href="<?php echo e(Settings::telLink()); ?>"><?php echo telefono_html(Settings::get('phone_display')); ?></a>
          </div>
          <div>
            <b>Correo</b>
            <a href="mailto:<?php echo e(Settings::get('email')); ?>"><?php echo e(Settings::get('email')); ?></a>
          </div>
          <div>
            <b>Dónde estamos</b>
            <span><?php echo e(Settings::get('city')); ?>, <?php echo e(Settings::get('region')); ?></span>
          </div>
          <?php if (Settings::get('opening_hours')): ?>
          <div>
            <b>Horario</b>
            <span><?php echo e(Settings::get('opening_hours')); ?></span>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="foot__mark" aria-hidden="true">
      <?php echo @file_get_contents(PUBLIC_PATH . '/assets/img/marca-grande.svg'); ?>
    </div>

    <div class="foot__legal">
      <span>&copy; <?php echo date('Y'); ?> <?php echo e(Settings::get('footer_legal')); ?></span>
      <ul>
        <?php foreach ($menuLegal as $i): ?>
        <li><a href="<?php echo e($i['url']); ?>"><?php echo e($i['label']); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</footer>
