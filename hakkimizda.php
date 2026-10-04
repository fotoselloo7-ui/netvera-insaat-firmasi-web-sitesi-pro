<?php
require_once __DIR__.'/app/bootstrap.php';
$page=one_by_slug('pages','hakkimizda') ?: ['eyebrow'=>'Kurumsal','title'=>'Hakkımızda','intro'=>'','body'=>'','hero_image'=>'','meta_title'=>'Hakkımızda','meta_description'=>''];
$active='about';
$metaTitle=$page['meta_title'] ?: $page['title'];
$metaDescription=$page['meta_description'] ?: $page['intro'];
$canonical=seo_absolute_url($page['canonical_url']??'',app_url('hakkimizda'));
$robots=$page['robots'] ?: 'index,follow,max-image-preview:large';
$ogTitle=$page['og_title'] ?: $metaTitle;
$ogDescription=$page['og_description'] ?: $metaDescription;
$ogImage=$page['og_image'] ?: $page['hero_image'];
$ogImageAlt=$page['image_alt'] ?: $page['title'];
$breadcrumbs=[['name'=>'Ana Sayfa','url'=>app_url()],['name'=>'Hakkımızda','url'=>$canonical]];
$pageSchema=[
  '@type'=>seo_clean_schema_type($page['schema_type']??'','AboutPage'),
  '@id'=>$canonical.'#webpage',
  'url'=>$canonical,
  'name'=>$page['title'],
  'description'=>$page['aio_summary'] ?: $metaDescription,
  'about'=>['@id'=>rtrim(app_url(),'/').'#business'],
  'mainEntity'=>['@id'=>rtrim(app_url(),'/').'#business'],
  'inLanguage'=>'tr-TR',
];
if($ogImage!=='') $pageSchema['primaryImageOfPage']=media_url($ogImage);
include __DIR__.'/partials/header.php';
?>
<main id="icerik"><section class="page-hero-modern"><div class="container"><div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><span>Hakkımızda</span></div><div class="home-kicker"><?= e($page['eyebrow']) ?></div><h1><?= e($page['title']) ?></h1><p><?= e($page['intro']) ?></p></div></section>
<section class="page-section"><div class="container content-layout"><article class="content-prose"><p class="lead"><?= e($page['intro']) ?></p><?php foreach(preg_split('/\R{2,}/',(string)$page['body']) as $p): ?><p><?= nl2br(e($p)) ?></p><?php endforeach; ?><h2>Çalışma yaklaşımımız</h2><div class="process-line"><?php foreach(feature_group('why') as $f): ?><div class="process-step"><small><?= e($f['icon']) ?></small><h3><?= e($f['title']) ?></h3><p><?= e($f['body']) ?></p></div><?php endforeach; ?></div></article><aside class="detail-aside"><h3>Bir proje mi planlıyorsunuz?</h3><p>İhtiyacınızı, konumu ve hedef takvimi paylaşın. İlk değerlendirmeyi birlikte yapalım.</p><a class="home-btn home-btn-primary" href="<?= e(app_url('iletisim')) ?>">İletişime Geçin</a></aside></div></section><section class="page-section" style="padding-top:0"><div class="container"><div class="page-cta"><div><div class="home-kicker">Projenizi Konuşalım</div><h2>Doğru kapsamı birlikte netleştirelim.</h2><p>Proje türünü, konumu ve hedefinizi paylaşın; ilk değerlendirmede hangi hizmete ihtiyacınız olduğunu birlikte belirleyelim.</p></div><div class="page-cta-actions"><a class="home-btn home-btn-primary" href="<?= e(app_url('#teklif')) ?>">Ücretsiz Keşif Talebi</a><a class="home-btn home-btn-secondary" href="https://wa.me/<?= e(preg_replace('/\D+/','',setting('whatsapp',setting('phone')))) ?>?text=<?= rawurlencode('Merhaba Vera Yapı, projem hakkında detaylı bilgi almak istiyorum.') ?>" target="_blank" rel="noopener">WhatsApp'tan Yaz</a></div></div></div></section></main>
<?php include __DIR__.'/partials/footer.php'; ?>
