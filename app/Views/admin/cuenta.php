<?php use App\Core\Csrf; ?>
<div class="ad-encabezado">
  <div>
    <h1>Mi cuenta</h1>
    <p class="ad-sub"><?php echo e($perfil['email']); ?></p>
  </div>
</div>

<?php if (!empty($_SESSION['must_change_password'])): ?>
<div class="ad-aviso ad-aviso--error">
  Por seguridad, tenés que cambiar la contraseña inicial antes de usar el panel.
</div>
<?php endif; ?>

<form method="post" class="ad-formulario" autocomplete="off">
  <?php echo Csrf::field(); ?>
  <div class="ad-tarjeta" style="max-width:560px">
    <div class="ad-campo<?php echo isset($errores['nombre']) ? ' con-error' : ''; ?>">
      <label for="nombre">Nombre</label>
      <input type="text" name="nombre" id="nombre" value="<?php echo e($perfil['name']); ?>" required>
      <?php if (isset($errores['nombre'])): ?><p class="ad-error"><?php echo e($errores['nombre']); ?></p><?php endif; ?>
    </div>

    <h2>Cambiar contraseña</h2>
    <div class="ad-campo<?php echo isset($errores['actual']) ? ' con-error' : ''; ?>">
      <label for="actual">Contraseña actual</label>
      <input type="password" name="actual" id="actual" autocomplete="current-password">
      <?php if (isset($errores['actual'])): ?><p class="ad-error"><?php echo e($errores['actual']); ?></p><?php endif; ?>
    </div>
    <div class="ad-campo<?php echo isset($errores['nueva']) ? ' con-error' : ''; ?>">
      <label for="nueva">Contraseña nueva</label>
      <input type="password" name="nueva" id="nueva" autocomplete="new-password">
      <p class="ad-ayuda">Al menos 10 caracteres. Usá una frase larga que solo vos recordés.</p>
      <?php if (isset($errores['nueva'])): ?><p class="ad-error"><?php echo e($errores['nueva']); ?></p><?php endif; ?>
    </div>
    <div class="ad-campo<?php echo isset($errores['repetir']) ? ' con-error' : ''; ?>">
      <label for="repetir">Repetir contraseña nueva</label>
      <input type="password" name="repetir" id="repetir" autocomplete="new-password">
      <?php if (isset($errores['repetir'])): ?><p class="ad-error"><?php echo e($errores['repetir']); ?></p><?php endif; ?>
    </div>
    <button class="ad-btn" type="submit">Guardar</button>
  </div>
</form>
