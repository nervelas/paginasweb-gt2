<?php
use App\Core\Csrf;
use App\Core\Settings;
use App\Models\Content;

$errores = isset($_SESSION['_form_errors']) ? $_SESSION['_form_errors'] : [];
$viejo   = isset($_SESSION['_old']) ? $_SESSION['_old'] : [];
$aviso   = flash();
unset($_SESSION['_form_errors'], $_SESSION['_old']);
$v = function ($k) use ($viejo) { return isset($viejo[$k]) ? $viejo[$k] : ''; };
$servicios = Content::services();
?>
<?php echo partial('partials/band-open', ['lienzo' => 'bone', 'id' => 'formulario']); ?>
  <div class="form-grid">
    <div class="rise">
      <p class="tag" data-num="<?php echo e($n); ?>">Cotización</p>
      <h2 style="font-size:clamp(1.8rem,3.4vw,2.7rem)"><?php echo e($section['heading']); ?></h2>
      <?php if ($section['subheading']): ?>
      <p class="lede" style="margin-bottom:clamp(30px,4vw,46px)"><?php echo e($section['subheading']); ?></p>
      <?php endif; ?>

      <?php if ($aviso): ?>
      <div class="note note--<?php echo $aviso['type'] === 'error' ? 'bad' : 'ok'; ?>" role="status">
        <?php echo e($aviso['message']); ?>
      </div>
      <?php endif; ?>

      <form method="post" action="/contacto/" novalidate>
        <?php echo Csrf::field(); ?>
        <input type="hidden" name="page" value="<?php echo e(isset($currentPath) ? $currentPath : '/contacto/'); ?>">
        <div class="hp" aria-hidden="true">
          <label for="website">No llenar este campo</label>
          <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
        </div>

        <div class="field-pair">
          <div class="field<?php echo isset($errores['name']) ? ' bad' : ''; ?>">
            <label for="f-nombre">Nombre <i>· obligatorio</i></label>
            <input type="text" name="name" id="f-nombre" value="<?php echo e($v('name')); ?>" required autocomplete="name"
              <?php echo isset($errores['name']) ? 'aria-describedby="e-nombre" aria-invalid="true"' : ''; ?>>
            <?php if (isset($errores['name'])): ?><span class="err" id="e-nombre"><?php echo e($errores['name']); ?></span><?php endif; ?>
          </div>
          <div class="field<?php echo isset($errores['email']) ? ' bad' : ''; ?>">
            <label for="f-correo">Correo <i>· obligatorio</i></label>
            <input type="email" name="email" id="f-correo" value="<?php echo e($v('email')); ?>" required autocomplete="email"
              <?php echo isset($errores['email']) ? 'aria-describedby="e-correo" aria-invalid="true"' : ''; ?>>
            <?php if (isset($errores['email'])): ?><span class="err" id="e-correo"><?php echo e($errores['email']); ?></span><?php endif; ?>
          </div>
        </div>

        <div class="field-pair">
          <div class="field<?php echo isset($errores['phone']) ? ' bad' : ''; ?>">
            <label for="f-telefono">Teléfono o WhatsApp <i>· opcional</i></label>
            <input type="tel" name="phone" id="f-telefono" value="<?php echo e($v('phone')); ?>" autocomplete="tel">
            <?php if (isset($errores['phone'])): ?><span class="err"><?php echo e($errores['phone']); ?></span><?php endif; ?>
          </div>
          <div class="field">
            <label for="f-servicio">Qué necesitás</label>
            <select name="service" id="f-servicio">
              <option value="">Elegí una opción</option>
              <?php foreach ($servicios as $s): ?>
              <option value="<?php echo e($s['slug']); ?>"<?php echo $v('service') === $s['slug'] ? ' selected' : ''; ?>>
                <?php echo e($s['name']); ?>
              </option>
              <?php endforeach; ?>
              <option value="otro"<?php echo $v('service') === 'otro' ? ' selected' : ''; ?>>Otra consulta</option>
            </select>
          </div>
        </div>

        <div class="field<?php echo isset($errores['message']) ? ' bad' : ''; ?>">
          <label for="f-mensaje">Contanos de tu negocio <i>· obligatorio</i></label>
          <textarea name="message" id="f-mensaje" required
            placeholder="A qué te dedicás, qué querés lograr con el sitio y si ya tenés dominio o material."
            <?php echo isset($errores['message']) ? 'aria-describedby="e-mensaje" aria-invalid="true"' : ''; ?>><?php echo e($v('message')); ?></textarea>
          <?php if (isset($errores['message'])): ?><span class="err" id="e-mensaje"><?php echo e($errores['message']); ?></span><?php endif; ?>
        </div>

        <button type="submit" class="btn btn--block">
          Enviar solicitud
          <?php echo partial('partials/icon', ['name' => 'flecha', 'size' => 15]); ?>
        </button>
        <p class="form-note">
          Usamos tus datos únicamente para responderte. Podés leer nuestra
          <a class="link" href="/politica-de-privacidad/">política de privacidad</a>.
        </p>
      </form>
    </div>

    <aside class="rise rise-d1">
      <p class="tag tag--plain">Directo</p>
      <ul class="contact-list">
        <li>
          <span class="k">WhatsApp</span>
          <a class="v" href="<?php echo e(Settings::whatsappLink()); ?>" rel="noopener"><?php echo telefono_html(Settings::get('phone_display')); ?></a>
        </li>
        <li>
          <span class="k">Teléfono</span>
          <a class="v" href="<?php echo e(Settings::telLink()); ?>"><?php echo telefono_html(Settings::get('phone_display')); ?></a>
        </li>
        <li>
          <span class="k">Correo</span>
          <a class="v" href="mailto:<?php echo e(Settings::get('email')); ?>"><?php echo e(Settings::get('email')); ?></a>
        </li>
        <li>
          <span class="k">Horario</span>
          <span class="v"><?php echo e(Settings::get('opening_hours')); ?></span>
        </li>
        <li>
          <span class="k">Cobertura</span>
          <span class="v">Toda Guatemala, 100% en línea</span>
        </li>
      </ul>
    </aside>
  </div>
<?php echo partial('partials/band-close'); ?>
