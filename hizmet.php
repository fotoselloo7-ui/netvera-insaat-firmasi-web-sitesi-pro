<?php
require_once __DIR__.'/app/bootstrap.php';
$slug=trim((string)($_GET['slug']??''));
$item=one_by_slug('services',$slug);
if(!$item){http_response_code(404);$robots='noindex';$metaTitle='Hizmet Bulunamadı';include __DIR__.'/partials/header.php';echo '<main id="icerik"><section class="page-hero-modern"><div class="container"><h1>Hizmet bulunamadı.</h1></div></section></main>';include __DIR__.'/partials/footer.php';exit;}
$active='services';
$metaTitle=$item['meta_title'] ?: $item['title'].' | '.setting('site_name','Vera Yapı');
$metaDescription=$item['meta_description'] ?: $item['summary'];
$canonical=seo_absolute_url($item['canonical_url']??'',app_url('hizmet/'.$item['slug']));
$robots=$item['robots'] ?: 'index,follow,max-image-preview:large';
$ogTitle=$item['og_title'] ?: $metaTitle;
$ogDescription=$item['og_description'] ?: $metaDescription;
$ogImage=$item['og_image'] ?: $item['cover_image'];
$ogImageAlt=$item['image_alt'] ?: $item['title'];
$breadcrumbs=[
  ['name'=>'Ana Sayfa','url'=>app_url()],
  ['name'=>'Hizmetler','url'=>app_url('hizmetler')],
  ['name'=>$item['title'],'url'=>$canonical],
];
$pageSchema=[
  '@type'=>seo_clean_schema_type($item['schema_type']??'','Service'),
  '@id'=>$canonical.'#service',
  'url'=>$canonical,
  'name'=>$item['title'],
  'description'=>$item['aio_summary'] ?: $metaDescription,
  'provider'=>['@id'=>rtrim(app_url(),'/').'#business'],
  'areaServed'=>$item['geo_target'] ?: setting('service_area',''),
  'mainEntityOfPage'=>$canonical,
];
if($ogImage!=='') $pageSchema['image']=media_url($ogImage);
include __DIR__.'/partials/header.php';
?>
<main id="icerik"><section class="detail-hero"><div class="container detail-hero-grid"><div><div class="home-kicker">Hizmet</div><h1><?= e($item['title']) ?></h1><p><?= e($item['summary']) ?></p><div class="detail-meta"><span><b>Hizmet Bölgesi</b><?= e(setting('address','Alanya / Antalya')) ?></span><span><b>Çalışma Modeli</b>Proje bazlı</span></div></div><?php if($item['cover_image']): ?><img src="<?= e(media_url($item['cover_image'])) ?>" alt="<?= e($item['image_alt'] ?: $item['title']) ?>"<?php if(!empty($item['image_title'])): ?> title="<?= e($item['image_title']) ?>"<?php endif; ?>><?php endif; ?></div></section><section class="page-section"><div class="container content-layout"><article class="content-prose"><p class="lead"><?= e($item['summary']) ?></p><?php foreach(preg_split('/\R{2,}/',(string)$item['body']) as $p): ?><p><?= nl2br(e($p)) ?></p><?php endforeach; ?><h2>Süreç nasıl ilerler?</h2><div class="process-line"><?php foreach(feature_group('process') as $f): ?><div class="process-step"><small><?= e($f['icon']) ?></small><h3><?= e($f['title']) ?></h3><p><?= e($f['body']) ?></p></div><?php endforeach; ?></div></article><aside class="detail-aside"><h3><?= e($item['title']) ?> için teklif alın</h3><p>Konum, yaklaşık alan ve proje durumunu paylaşın. İlk değerlendirmeyi birlikte yapalım.</p><a class="home-btn home-btn-primary" href="<?= e(app_url('#teklif')) ?>">Ücretsiz Keşif Talebi</a></aside></div></section></main>
<?php include __DIR__.'/partials/footer.php'; ?>
