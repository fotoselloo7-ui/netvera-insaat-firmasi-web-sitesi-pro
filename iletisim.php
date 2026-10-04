<?php
require_once __DIR__.'/app/bootstrap.php';
$page=one_by_slug('pages','iletisim') ?: ['eyebrow'=>'İletişim','title'=>'Projenizi birlikte değerlendirelim.','intro'=>'','body'=>'','meta_title'=>'İletişim','meta_description'=>''];
$active='contact';
$metaTitle=$page['meta_title'] ?: $page['title'];
$metaDescription=$page['meta_description'] ?: $page['intro'];
$canonical=seo_absolute_url($page['canonical_url']??'',app_url('iletisim'));
$robots=$page['robots'] ?: 'index,follow,max-image-preview:large';
$ogTitle=$page['og_title'] ?: $metaTitle;
$ogDescription=$page['og_description'] ?: $metaDescription;
$ogImage=$page['og_image'] ?: ($page['hero_image'] ?? '');
$ogImageAlt=$page['image_alt'] ?: $page['title'];
$breadcrumbs=[['name'=>'Ana Sayfa','url'=>app_url()],['name'=>'İletişim','url'=>$canonical]];
$pageSchema=[
  '@type'=>seo_clean_schema_type($page['schema_type']??'','ContactPage'),
  '@id'=>$canonical.'#webpage',
  'url'=>$canonical,
  'name'=>$page['title'],
  'description'=>$page['aio_summary'] ?: $metaDescription,
  'about'=>['@id'=>rtrim(app_url(),'/').'#business'],
  'inLanguage'=>'tr-TR',
];
$wa=preg_replace('/\D+/','',setting('whatsapp',setting('phone')));
include __DIR__.'/partials/header.php';
?>
<main id="icerik"><section class="page-hero-modern"><div class="container"><div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><span>İletişim</span></div><div class="home-kicker"><?= e($page['eyebrow']) ?></div><h1><?= e($page['title']) ?></h1><p><?= e($page['intro']) ?></p></div></section><section class="page-section" id="teklif"><div class="container contact-layout"><div class="contact-info"><div class="contact-info-row"><small>Telefon</small><strong><?= e(setting('phone')) ?></strong></div><div class="contact-info-row"><small>E-posta</small><strong><?= e(setting('email')) ?></strong></div><div class="contact-info-row"><small>Konum</small><strong><?= e(setting('address')) ?></strong></div><div class="contact-info-row"><small>Çalışma Saatleri</small><strong><?= e(setting('working_hours')) ?></strong></div></div><form class="contact-form-light" data-home-form data-whatsapp="<?= e($wa) ?>"><label>Ad Soyad<input name="name" required></label><label>Telefon<input name="phone" required></label><label>Proje Türü<select name="type"><option>Konut / Villa</option><option>Ticari Yapı</option><option>Anahtar Teslim</option><option>Renovasyon</option></select></label><label>Konum<input name="location"></label><label class="full">Proje Bilgisi<textarea name="message"></textarea></label><div class="full"><button class="home-btn home-btn-primary" type="submit">WhatsApp'tan Teklif İste</button><p class="home-form-note" data-form-note></p></div></form></div></section></main>
<?php include __DIR__.'/partials/footer.php'; ?>
