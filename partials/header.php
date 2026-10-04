<?php
$active = $active ?? '';
$siteName = setting('site_name', 'Vera Yapı');
$phone = setting('phone', '+90 500 000 00 00');
$email = setting('email', 'info@example.com');
$address = setting('address', 'Alanya / Antalya');
$hours = setting('working_hours', 'Pzt–Cmt 08:30–18:30');
$waMenu = preg_replace('/\D+/', '', setting('whatsapp', $phone));
$menuSocials = [
    ['label'=>'Instagram','short'=>'IG','class'=>'instagram','url'=>trim(setting('instagram_url',''))],
    ['label'=>'Facebook','short'=>'f','class'=>'facebook','url'=>trim(setting('facebook_url',''))],
    ['label'=>'X / Twitter','short'=>'X','class'=>'twitter','url'=>trim(setting('twitter_url',''))],
    ['label'=>'YouTube','short'=>'▶','class'=>'youtube','url'=>trim(setting('youtube_url',''))],
];
$hasMenuSocials = count(array_filter($menuSocials, fn($s)=>$s['url']!=='')) > 0;

$resolvedTitle = trim((string)($metaTitle ?? setting('seo_home_title',$siteName)));
$resolvedDescription = trim((string)($metaDescription ?? setting('meta_description','Alanya ve Antalya’da inşaat ve taahhüt hizmetleri.')));
$resolvedRobots = trim((string)($robots ?? setting('seo_robots','index,follow,max-image-preview:large')));
$currentPath = ltrim((string)(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? ''), '/');
$resolvedCanonical = seo_absolute_url($canonical ?? '', app_url($currentPath));
$resolvedOgTitle = trim((string)($ogTitle ?? $resolvedTitle));
$resolvedOgDescription = trim((string)($ogDescription ?? $resolvedDescription));
$resolvedOgImage = trim((string)($ogImage ?? setting('seo_default_og_image','')));
$resolvedOgImageUrl = $resolvedOgImage !== '' ? media_url($resolvedOgImage) : '';
$resolvedOgImageAlt = trim((string)($ogImageAlt ?? setting('seo_default_image_alt',$resolvedTitle)));
$resolvedOgType = trim((string)($ogType ?? 'website'));

$graph = seo_global_graph();
if(!empty($pageSchema) && is_array($pageSchema)) $graph[]=$pageSchema;
if(!empty($breadcrumbs) && is_array($breadcrumbs)) $graph[]=seo_breadcrumb_schema($breadcrumbs);
$schemaJson = json_encode(['@context'=>'https://schema.org','@graph'=>$graph], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT);
?>
<!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($resolvedTitle) ?></title>
<meta name="description" content="<?= e($resolvedDescription) ?>">
<meta name="robots" content="<?= e($resolvedRobots) ?>">
<link rel="canonical" href="<?= e($resolvedCanonical) ?>">
<meta property="og:type" content="<?= e($resolvedOgType) ?>">
<meta property="og:locale" content="tr_TR">
<meta property="og:site_name" content="<?= e($siteName) ?>">
<meta property="og:title" content="<?= e($resolvedOgTitle) ?>">
<meta property="og:description" content="<?= e($resolvedOgDescription) ?>">
<meta property="og:url" content="<?= e($resolvedCanonical) ?>">
<?php if($resolvedOgImageUrl!==''): ?>
<meta property="og:image" content="<?= e($resolvedOgImageUrl) ?>">
<meta property="og:image:alt" content="<?= e($resolvedOgImageAlt) ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="<?= e($resolvedOgImageUrl) ?>">
<?php else: ?>
<meta name="twitter:card" content="summary">
<?php endif; ?>
<meta name="twitter:title" content="<?= e($resolvedOgTitle) ?>">
<meta name="twitter:description" content="<?= e($resolvedOgDescription) ?>">
<?php if(!empty($authorName)): ?><meta name="author" content="<?= e($authorName) ?>"><?php endif; ?>
<?php if(setting('google_site_verification','')!==''): ?><meta name="google-site-verification" content="<?= e(setting('google_site_verification')) ?>"><?php endif; ?>
<?php if(setting('bing_site_verification','')!==''): ?><meta name="msvalidate.01" content="<?= e(setting('bing_site_verification')) ?>"><?php endif; ?>
<?php if(!empty($articlePublished)): ?><meta property="article:published_time" content="<?= e($articlePublished) ?>"><?php endif; ?>
<?php if(!empty($articleModified)): ?><meta property="article:modified_time" content="<?= e($articleModified) ?>"><?php endif; ?>
<meta name="theme-color" content="#102c40">
<?php if($schemaJson): ?><script type="application/ld+json"><?= $schemaJson ?></script><?php endif; ?>
<link rel="stylesheet" href="<?= e(app_url('assets/css/corporate.css')) ?>?v=19">
<link rel="stylesheet" href="<?= e(app_url('assets/css/pages.css')) ?>?v=19">
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
<div class="home-menu-mobile-extra" aria-label="Mobil hızlı erişim">
  <div class="home-menu-mobile-label">Hızlı İletişim</div>
  <div class="home-menu-mobile-contact">
    <a href="tel:<?= e(preg_replace('/\D+/', '', $phone)) ?>"><span>☎</span>Ara</a>
    <a class="is-wa" href="https://wa.me/<?= e($waMenu) ?>" target="_blank" rel="noopener"><span>◉</span>WhatsApp</a>
  </div>
  <?php if($hasMenuSocials): ?>
  <div class="home-menu-mobile-label">Sosyal Medya</div>
  <div class="home-menu-mobile-socials">
    <?php foreach($menuSocials as $social): if($social['url']==='') continue; ?>
      <a class="is-<?= e($social['class']) ?>" href="<?= e($social['url']) ?>" target="_blank" rel="noopener" aria-label="<?= e($social['label']) ?>"><b><?= e($social['short']) ?></b><span><?= e($social['label']) ?></span></a>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>
</nav>
<button class="home-menu-btn" type="button" aria-label="Menüyü aç" aria-expanded="false">☰</button>
</div></header>
