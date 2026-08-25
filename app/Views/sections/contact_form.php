<?php
use App\Core\Csrf;
use App\Core\Settings;
use App\Models\Content;

$errors = isset($_SESSION['_form_errors']) ? $_SESSION['_form_errors'] : [];
$old    = isset($_SESSION['_old']) ? $_SESSION['_old'] : [];
$msg    = flash();
unset($_SESSION['_form_errors'], $_SESSION['_old']);
$val = function ($key) use ($old) { return isset($old[$key]) ? $old[$key] : ''; };
$servicios = Content::services();
?>
<section class="section section--tight" id="formulario">
  <div class="wrap">
    <div class="grid grid--2" style="gap:34px;align-items:start">
      <div class="form-card">
        <h2 style="font-size:clamp(1.35rem,2.6vw,1.75rem)"><?php echo e($section['heading']); ?></h2>
        <?php if ($section['subheading']): ?><p class="sub" style="margin-bottom:1.5rem"><?php echo e($section['subheading']); ?></p><?php endif; ?>

        <?php if ($msg): ?>
        <div class="alert alert--<?php echo $msg['type'] === 'error' ? 'error' : 'ok'; ?>" role="status">
          <?php echo e($msg['message']); ?>
        </div>
        <?php endif; ?>

        <form method="post" action="/contacto/" novalidate>
          <?php echo Csrf::field(); ?>
          <input type="hidden" name="page" value="<?php echo e(isset($currentPath) ? $currentPath : '/contacto/'); ?>">
          <div class="hp-field" aria-hidden="true">
            <label for="website">No llenar este campo</label>
            <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
          </div>

          <div class="field-row">
            <div class="field<?php echo isset($errors['name']) ? ' has-error' : ''; ?>">
              <label for="campo-nombre">Nombre <span class="hint">(obligatorio)</span></label>
              <input type="text" name="name" id="campo-nombre" value="<?php echo e($val('name')); ?>"
                     required autocomplete="name"
                     <?php echo isset($errors['name']) ? 'aria-describedby="err-nombre" aria-invalid="true"' : ''; ?>>
              <?php if (isset($errors['name'])): ?><span class="error" id="err-nombre"><?php echo e($errors['name']); ?></span><?php endif; ?>
            </div>
            <div class="field<?php echo isset($errors['email']) ? ' has-error' : ''; ?>">
              <label for="campo-correo">Correo <span class="hint">(obligatorio)</span></label>
              <input type="email" name="email" id="campo-correo" value="<?php echo e($val('email')); ?>"
                     required autocomplete="email"
                     <?php echo isset($errors['email']) ? 'aria-describedby="err-correo" aria-invalid="true"' : ''; ?>>
              <?php if (isset($errors['email'])): ?><span class="error" id="err-correo"><?php echo e($errors['email']); ?></span><?php endif; ?>
            </div>
          </div>

          <div class="field-row">
            <div class="field<?php echo isset($errors['phone']) ? ' has-error' : ''; ?>">
              <label for="campo-telefono">Teléfono o WhatsApp <span class="hint">(opcional)</span></label>
              <input type="tel" name="phone" id="campo-telefono" value="<?php echo e($val('phone')); ?>" autocomplete="tel">
              <?php if (isset($errors['phone'])): ?><span class="error"><?php echo e($errors['phone']); ?></span><?php endif; ?>
            </div>
            <div class="field">
              <label for="campo-servicio">¿Qué necesitás?</label>
              <select name="service" id="campo-servicio">
                <option value="">Elegí una opción</option>
                <?php foreach ($servicios as $s): ?>
                <option value="<?php echo e($s['slug']); ?>"<?php echo $val('service') === $s['slug'] ? ' selected' : ''; ?>>
                  <?php echo e($s['name']); ?>
                </option>
                <?php endforeach; ?>
                <option value="otro"<?php echo $val('service') === 'otro' ? ' selected' : ''; ?>>Otra consulta</option>
              </select>
            </div>
          </div>

          <div class="field<?php echo isset($errors['message']) ? ' has-error' : ''; ?>">
            <label for="campo-mensaje">Contanos de tu negocio <span class="hint">(obligatorio)</span></label>
            <textarea name="message" id="campo-mensaje" required
                      placeholder="A qué te dedicás, qué querés lograr con el sitio y si ya tenés dominio o material."
                      <?php echo isset($errors['message']) ? 'aria-describedby="err-mensaje" aria-invalid="true"' : ''; ?>><?php echo e($val('message')); ?></textarea>
            <?php if (isset($errors['message'])): ?><span class="error" id="err-mensaje"><?php echo e($errors['message']); ?></span><?php endif; ?>
          </div>

          <button type="submit" class="btn btn--primary btn--block">Enviar solicitud</button>
          <p class="form-legal">
            Usamos tus datos únicamente para responderte. Podés leer nuestra
            <a href="/politica-de-privacidad/">política de privacidad</a>.
          </p>
        </form>
      </div>

      <div>
        <h2 style="font-size:clamp(1.35rem,2.6vw,1.75rem)">O escribinos directo</h2>
        <p class="sub" style="margin-bottom:1.6rem">Si preferís hablarlo, WhatsApp es lo más rápido.</p>
        <ul class="contact-list">
          <li>
            <span class="ic"><?php echo partial('partials/icon', ['name' => 'whatsapp', 'size' => 18]); ?></span>
            <div>
              <strong>WhatsApp</strong>
              <a href="<?php echo e(Settings::whatsappLink()); ?>" rel="noopener"><?php echo telefono_html(Settings::get('phone_display')); ?></a>
            </div>
          </li>
          <li>
            <span class="ic"><?php echo partial('partials/icon', ['name' => 'phone', 'size' => 18]); ?></span>
            <div>
              <strong>Teléfono</strong>
              <a href="<?php echo e(Settings::telLink()); ?>"><?php echo telefono_html(Settings::get('phone_display')); ?></a>
            </div>
          </li>
          <li>
            <span class="ic"><?php echo partial('partials/icon', ['name' => 'mail', 'size' => 18]); ?></span>
            <div>
              <strong>Correo</strong>
              <a href="mailto:<?php echo e(Settings::get('email')); ?>"><?php echo e(Settings::get('email')); ?></a>
            </div>
          </li>
          <li>
            <span class="ic"><?php echo partial('partials/icon', ['name' => 'clock', 'size' => 18]); ?></span>
            <div>
              <strong>Horario</strong>
              <span style="font-weight:600"><?php echo e(Settings::get('opening_hours')); ?></span>
            </div>
          </li>
          <li>
            <span class="ic"><?php echo partial('partials/icon', ['name' => 'pin', 'size' => 18]); ?></span>
            <div>
              <strong>Cobertura</strong>
              <span style="font-weight:600">Toda Guatemala, 100% en línea</span>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>
