<?php use App\Core\Csrf; use App\Core\Settings; ?><!DOCTYPE html>
<html lang="es-GT">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Entrar al panel · <?php echo e(Settings::get('site_name')); ?></title>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="<?php echo asset('css/admin.min.css'); ?>">
</head>
<body class="ad-login">
<main class="ad-login__caja">
  <img src="/assets/img/logo-paginasweb-gt.svg" alt="<?php echo e(Settings::get('site_name')); ?>" width="200" height="35">
  <h1>Entrar al panel</h1>
  <?php if ($error): ?><div class="ad-aviso ad-aviso--error" role="alert"><?php echo e($error); ?></div><?php endif; ?>
  <form method="post" autocomplete="off">
    <?php echo Csrf::field(); ?>
    <div class="ad-campo">
      <label for="email">Correo</label>
      <input type="email" name="email" id="email" required autocomplete="username" autofocus>
    </div>
    <div class="ad-campo">
      <label for="password">Contraseña</label>
      <input type="password" name="password" id="password" required autocomplete="current-password">
    </div>
    <button class="ad-btn ad-btn--bloque" type="submit">Entrar</button>
  </form>
  <p class="ad-login__pie">Después de cinco intentos fallidos el acceso queda bloqueado 15 minutos.</p>
</main>
</body>
</html>
