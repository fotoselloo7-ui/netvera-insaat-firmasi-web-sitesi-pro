<?php
require_once __DIR__.'/app/bootstrap.php';
$slug=trim((string)($_GET['slug']??''));
$item=one_by_slug('service_areas',$slug);
if(!$item){http_response_code(404);$robots='noindex,follow';$metaTitle='Bölge Bulunamadı';include __DIR__.'/partials/header.php';echo '<main id="icerik"><section class="page-hero-modern"><div class="container"><h1>Bölge bulunamadı.</h1></div></section></main>';include __DIR__.'/partials/footer.php';exit;}

$active='services';
$metaTitle=$item['meta_title'] ?: $item['title'].' İnşaat Hizmetleri | '.setting('site_name','Vera Yapı');
$metaDescription=$item['meta_description'] ?: ($item['summary'] ?: $item['title'].' bölgesinde inşaat, villa, taahhüt ve renovasyon hizmetleri.');
$canonical=seo_absolute_url($item['canonical_url']??'',app_url('bolge/'.$item['slug']));
$robots=$item['robots'] ?: 'index,follow,max-image-preview:large';
$ogTitle=$item['og_title'] ?: $metaTitle;
$ogDescription=$item['og_description'] ?: $metaDescription;
$ogImage=$item['og_image'] ?: $item['cover_image'];
$ogImageAlt=$item['image_alt'] ?: ($item['title'].' inşaat hizmetleri');
$breadcrumbs=[
  ['name'=>'Ana Sayfa','url'=>app_url()],
  ['name'=>'Hizmet Bölgeleri','url'=>app_url('bolgeler')],
  ['name'=>$item['title'],'url'=>$canonical],
];
$place=['@type'=>'Place','name'=>$item['title']];
if($item['latitude'] && $item['longitude']) $place['geo']=['@type'=>'GeoCoordinates','latitude'=>$item['latitude'],'longitude'=>$item['longitude']];
$pageSchema=[
  '@type'=>seo_clean_schema_type($item['schema_type']??'','WebPage'),
  '@id'=>$canonical.'#webpage',
  'url'=>$canonical,
  'name'=>$item['title'].' İnşaat Hizmetleri',
  'description'=>$item['aio_summary'] ?: $metaDescription,
  'about'=>$place,
  'provider'=>['@id'=>rtrim(app_url(),'/').'#business'],
  'inLanguage'=>'tr-TR',
];
if($ogImage!=='') $pageSchema['primaryImageOfPage']=media_url($ogImage);
include __DIR__.'/partials/header.php';
?>
<main id="icerik">
<section class="detail-hero"><div class="container detail-hero-grid"><div><div class="home-kicker">Hizmet Bölgesi</div><h1><?= e($item['title']) ?> inşaat ve taahhüt hizmetleri</h1><p><?= e($item['summary'] ?: $metaDescription) ?></p><div class="detail-meta"><span><b>Bölge</b><?= e($item['geo_target'] ?: $item['title']) ?></span><span><b>Hizmetler</b><?= e($item['services_text']) ?></span></div></div><?php if($item['cover_image']): ?><img src="<?= e(media_url($item['cover_image'])) ?>" alt="<?= e($item['image_alt'] ?: ($item['title'].' inşaat hizmetleri')) ?>"<?php if($item['image_title']): ?> title="<?= e($item['image_title']) ?>"<?php endif; ?>><?php endif; ?></div></section>
<section class="page-section"><div class="container content-layout"><article class="content-prose"><p class="lead"><?= e($item['summary'] ?: $metaDescription) ?></p><?php foreach(preg_split('/\R{2,}/',(string)$item['body']) as $p): ?><?php if(trim($p)!==''): ?><p><?= nl2br(e($p)) ?></p><?php endif; ?><?php endforeach; ?><h2><?= e($item['title']) ?> bölgesinde hangi hizmetleri sunuyoruz?</h2><p><?= e($item['services_text']) ?></p></article><aside class="detail-aside"><h3><?= e($item['title']) ?> için proje mi planlıyorsunuz?</h3><p>Konumu ve proje türünü paylaşın; ilk değerlendirmeyi birlikte yapalım.</p><a class="home-btn home-btn-primary" href="<?= e(app_url('#teklif')) ?>">Ücretsiz Keşif Talebi</a><a class="home-btn home-btn-secondary" href="<?= e(app_url('hizmetler')) ?>">Hizmetleri İncele</a></aside></div></section>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>
