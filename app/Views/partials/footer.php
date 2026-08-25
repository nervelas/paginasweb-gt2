<?php
use App\Core\Settings;
$redes = [
    'facebook'  => Settings::get('social_facebook'),
    'instagram' => Settings::get('social_instagram'),
    'linkedin'  => Settings::get('social_linkedin'),
    'youtube'   => Settings::get('social_youtube'),
];
$redes = array_filter($redes);
?>
<footer class="site-footer">
  <div class="wrap">
    <div class="footer__grid">
      <div class="footer__brand">
        <img src="<?php echo e(Settings::get('logo_white', '/assets/img/logo-paginasweb-gt-blanco.svg')); ?>"
             alt="<?php echo e(Settings::get('site_name')); ?>" width="184" height="32" loading="lazy">
        <p class="footer__about">
          <?php echo e(Settings::get('footer_about')); ?>
          <?php if (Settings::get('parent_site_url')): ?>
            Conocé también <a href="<?php echo e(Settings::get('parent_site_url')); ?>">servicom.gt</a>.
          <?php endif; ?>
        </p>
      </div>

      <div>
        <h2 class="footer__titulo">Servicios</h2>
        <ul>
          <?php foreach ($menuServicios as $item): ?>
          <li><a href="<?php echo e($item['url']); ?>"><?php echo e($item['label']); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div>
        <h2 class="footer__titulo">Empresa</h2>
        <ul>
          <?php foreach ($menuEmpresa as $item): ?>
          <li><a href="<?php echo e($item['url']); ?>"><?php echo e($item['label']); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div>
        <h2 class="footer__titulo">Contacto</h2>
        <div class="footer__contact">
          <div>
            <strong>Teléfono y WhatsApp</strong>
            <a href="<?php echo e(Settings::telLink()); ?>"><?php echo telefono_html(Settings::get('phone_display')); ?></a>
          </div>
          <div>
            <strong>Correo</strong>
            <a href="mailto:<?php echo e(Settings::get('email')); ?>"><?php echo e(Settings::get('email')); ?></a>
          </div>
          <div>
            <strong>Dónde estamos</strong>
            <span><?php echo e(Settings::get('city')); ?>, <?php echo e(Settings::get('region')); ?></span>
          </div>
          <?php if (Settings::get('opening_hours')): ?>
          <div>
            <strong>Horario</strong>
            <span><?php echo e(Settings::get('opening_hours')); ?></span>
          </div>
          <?php endif; ?>
        </div>
        <?php if ($redes): ?>
        <div class="footer__social" style="margin-top:16px">
          <?php foreach ($redes as $red => $enlace): ?>
          <a href="<?php echo e($enlace); ?>" rel="noopener" aria-label="<?php echo e(ucfirst($red)); ?>">
            <?php echo partial('partials/icon', ['name' => $red, 'size' => 17]); ?>
          </a>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="footer__bottom">
      <span>&copy; <?php echo date('Y'); ?> <?php echo e(Settings::get('footer_legal')); ?></span>
      <ul>
        <?php foreach ($menuLegal as $item): ?>
        <li><a href="<?php echo e($item['url']); ?>"><?php echo e($item['label']); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</footer>
