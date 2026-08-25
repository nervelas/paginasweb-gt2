<?php
use App\Core\Settings;

$seo       = isset($seo) ? $seo : [];
$title     = isset($seo['title']) ? $seo['title'] : Settings::get('site_name');
$desc      = isset($seo['description']) ? $seo['description'] : Settings::get('site_tagline');
$canonical = isset($seo['canonical']) ? $seo['canonical'] : null;
$robots    = isset($seo['robots']) ? $seo['robots'] : 'index, follow, max-image-preview:large';
$ogImage   = isset($seo['og_image']) ? $seo['og_image'] : url('/assets/img/og/og-inicio.webp');
$ogType    = isset($seo['og_type']) ? $seo['og_type'] : 'website';
if (Settings::get('site_noindex', '0') === '1') {
    $robots = 'noindex, nofollow';
}
$criticalCss = @file_get_contents(PUBLIC_PATH . '/assets/css/critical.min.css');
$ga4    = Settings::get('ga4_id');
$pixel  = Settings::get('meta_pixel_id');
$gsc    = Settings::get('search_console_verify');
?><!DOCTYPE html>
<html lang="es-GT">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo e($title); ?></title>
<meta name="description" content="<?php echo e($desc); ?>">
<meta name="robots" content="<?php echo e($robots); ?>">
<?php if ($canonical): ?>
<link rel="canonical" href="<?php echo e($canonical); ?>">
<link rel="alternate" hreflang="es-gt" href="<?php echo e($canonical); ?>">
<link rel="alternate" hreflang="x-default" href="<?php echo e($canonical); ?>">
<?php endif; ?>
<?php if ($gsc): ?>
<meta name="google-site-verification" content="<?php echo e($gsc); ?>">
<?php endif; ?>

<meta property="og:type" content="<?php echo e($ogType); ?>">
<meta property="og:site_name" content="<?php echo e(Settings::get('site_name')); ?>">
<meta property="og:locale" content="es_GT">
<meta property="og:title" content="<?php echo e($title); ?>">
<meta property="og:description" content="<?php echo e($desc); ?>">
<?php if ($canonical): ?><meta property="og:url" content="<?php echo e($canonical); ?>"><?php endif; ?>
<meta property="og:image" content="<?php echo e($ogImage); ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo e($title); ?>">
<meta name="twitter:description" content="<?php echo e($desc); ?>">
<meta name="twitter:image" content="<?php echo e($ogImage); ?>">
<meta name="theme-color" content="<?php echo e(Settings::get('color_ink', '#0A1F2C')); ?>">

<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="icon" href="/favicon.ico" sizes="32x32">
<link rel="apple-touch-icon" href="/assets/img/icons/icono-180.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="preload" href="/assets/fonts/manrope-latin-wght.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="/assets/fonts/fraunces-latin-wght.woff2" as="font" type="font/woff2" crossorigin>

<script>document.documentElement.className+=' js';</script>
<style><?php echo $criticalCss; ?></style>
<?php
$brandVars = [
    '--ink'    => Settings::get('color_ink'),
    '--brand'  => Settings::get('color_brand'),
    '--accent' => Settings::get('color_accent'),
    '--paper'  => Settings::get('color_paper'),
    '--gold'   => Settings::get('color_gold'),
];
$css = '';
foreach ($brandVars as $var => $value) {
    if ($value && preg_match('/^#[0-9A-Fa-f]{3,8}$/', $value)) {
        $css .= $var . ':' . $value . ';';
    }
}
if ($css !== '') { echo '<style>:root{' . $css . '}</style>'; }
?>
<link rel="preload" href="<?php echo asset('css/site.min.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="<?php echo asset('css/site.min.css'); ?>"></noscript>

<?php if ($jsonld): ?>
<script type="application/ld+json"><?php echo $jsonld; ?></script>
<?php endif; ?>

<?php if ($ga4): ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e($ga4); ?>"></script>
<script>
window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments)}
gtag('js',new Date());gtag('config','<?php echo e($ga4); ?>');
</script>
<?php endif; ?>
<?php if ($pixel): ?>
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init','<?php echo e($pixel); ?>');fbq('track','PageView');
</script>
<?php endif; ?>
</head>
<body class="<?php echo e(isset($bodyClass) ? $bodyClass : ''); ?>">
<a class="skip-link" href="#contenido">Saltar al contenido</a>
<?php echo partial('partials/header'); ?>
<main id="contenido">
<?php echo $content; ?>
</main>
<?php echo partial('partials/footer'); ?>
<?php echo partial('partials/floating'); ?>
<script src="<?php echo asset('js/site.min.js'); ?>" defer></script>
</body>
</html>
