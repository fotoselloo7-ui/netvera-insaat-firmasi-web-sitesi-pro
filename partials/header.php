<?php
$active = $active ?? '';
$siteName = setting('site_name', 'Vera Yapı');
$phone = setting('phone', '+90 500 000 00 00');
$email = setting('email', 'info@example.com');
$address = setting('address', 'Alanya / Antalya');
$hours = setting('working_hours', 'Pzt–Cmt 08:30–18:30');
?>
<!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($metaTitle ?? $siteName) ?></title>
<meta name="description" content="<?= e($metaDescription ?? setting('meta_description','Alanya ve Antalya’da inşaat ve taahhüt hizmetleri.')) ?>">
<meta name="robots" content="<?= e($robots ?? 'index,follow,max-image-preview:large') ?>">
<link rel="canonical" href="<?= e($canonical ?? app_url(ltrim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/'))) ?>">
<meta property="og:type" content="website">
<meta property="og:locale" content="tr_TR">
<meta property="og:title" content="<?= e($metaTitle ?? $siteName) ?>">
<meta property="og:description" content="<?= e($metaDescription ?? setting('meta_description','Alanya ve Antalya’da inşaat ve taahhüt hizmetleri.')) ?>">
<meta property="og:url" content="<?= e($canonical ?? app_url(ltrim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/'))) ?>">
<?php if(!empty($ogImage)): ?><meta property="og:image" content="<?= e(media_url($ogImage)) ?>"><?php endif; ?>
<meta name="theme-color" content="#102c40">
<link rel="stylesheet" href="<?= e(app_url('assets/css/corporate.css')) ?>">
<link rel="stylesheet" href="<?= e(app_url('assets/css/pages.css')) ?>">
<?= $extraHead ?? '' ?>
</head>
<body>
<a class="skip-link" href="#icerik">İçeriğe geç</a>
<div class="home-topbar"><div class="container"><div class="home-topbar-left"><a href="tel:<?= e(preg_replace('/\D+/', '', $phone)) ?>"><?= e($phone) ?></a><span><?= e($address) ?></span><span><?= e($hours) ?></span></div><div class="home-topbar-right"><a href="mailto:<?= e($email) ?>"><?= e($email) ?></a></div></div></div>
<header class="home-header"><div class="container home-nav">
<a class="home-logo" href="<?= e(app_url()) ?>"><span class="home-logo-mark"><?= e(setting('logo_mark','VY')) ?></span><span><?= e($siteName) ?><small><?= e(setting('tagline','İNŞAAT & TAAHHÜT')) ?></small></span></a>
<nav class="home-menu" aria-label="Ana menü">
<a href="<?= e(app_url()) ?>"<?= $active==='home'?' aria-current="page"':'' ?>>Ana Sayfa</a>
<a href="<?= e(app_url('hakkimizda')) ?>"<?= $active==='about'?' aria-current="page"':'' ?>>Kurumsal</a>
<a href="<?= e(app_url('hizmetler')) ?>"<?= $active==='services'?' aria-current="page"':'' ?>>Hizmetler</a>
<a href="<?= e(app_url('projeler')) ?>"<?= $active==='projects'?' aria-current="page"':'' ?>>Projeler</a>
<a href="<?= e(app_url('blog')) ?>"<?= $active==='blog'?' aria-current="page"':'' ?>>Blog</a>
<a href="<?= e(app_url('iletisim')) ?>"<?= $active==='contact'?' aria-current="page"':'' ?>>İletişim</a>
<a class="home-nav-cta" href="<?= e(app_url('#teklif')) ?>">Ücretsiz Keşif Talebi</a>
</nav>
<button class="home-menu-btn" type="button" aria-label="Menüyü aç" aria-expanded="false">☰</button>
</div></header>
