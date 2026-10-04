<?php
require_once __DIR__.'/app/bootstrap.php';
$slug=trim((string)($_GET['slug']??''));
$item=one_by_slug('service_areas',$slug);
if(!$item){http_response_code(404);$robots='noindex,follow';$metaTitle='Bölge Bulunamadı';include __DIR__.'/partials/header.php';echo '<main id="icerik"><section class="page-hero-modern"><div class="container"><h1>Bölge bulunamadı.</h1></div></section></main>';include __DIR__.'/partials/footer.php';exit;}
$active='services';
$metaTitle=$item['meta_title'] ?: $item['title'].' İnşaat Hizmetleri | '.setting('site_name','Vera Yapı');
$metaDescription=$item['meta_description'] ?: ($item['summary'] ?: $item['title'].' bölgesinde inşaat, villa, taahhüt ve renovasyon hizmetleri.');
$canonical=seo_absolute_url($item['canonical_url']??'',app_url('bolge/'.$item['slug']));$robots=$item['robots'] ?: 'index,follow,max-image-preview:large';
$ogTitle=$item['og_title'] ?: $metaTitle;$ogDescription=$item['og_description'] ?: $metaDescription;$ogImage=$item['og_image'] ?: $item['cover_image'];$ogImageAlt=$item['image_alt'] ?: ($item['title'].' inşaat hizmetleri');
$breadcrumbs=[['name'=>'Ana Sayfa','url'=>app_url()],['name'=>'Hizmet Bölgeleri','url'=>app_url('bolgeler')],['name'=>$item['title'],'url'=>$canonical]];
$place=['@type'=>'Place','name'=>$item['title']];if($item['latitude'] && $item['longitude']) $place['geo']=['@type'=>'GeoCoordinates','latitude'=>$item['latitude'],'longitude'=>$item['longitude']];
$pageSchema=['@type'=>seo_clean_schema_type($item['schema_type']??'','WebPage'),'@id'=>$canonical.'#webpage','url'=>$canonical,'name'=>$item['title'].' İnşaat Hizmetleri','description'=>$item['aio_summary'] ?: $metaDescription,'about'=>$place,'provider'=>['@id'=>rtrim(app_url(),'/').'#business'],'inLanguage'=>'tr-TR'];
if($ogImage!=='') $pageSchema['primaryImageOfPage']=media_url($ogImage);
$services=array_slice(rows('services'),0,4);
$secApproach=page_section('bolge-detay','approach');
$secServices=page_section('bolge-detay','services');
$secAside=page_section('bolge-detay','aside');
$regionText=fn(string $text)=>str_replace('{BOLGE}',$item['title'],$text);
include __DIR__.'/partials/header.php';
?>
<main id="icerik">
<section class="detail-hero is-service"><div class="container detail-hero-grid"><div><div class="detail-eyebrow-line">Hizmet Bölgesi</div><h1><?= e($item['title']) ?> inşaat ve taahhüt hizmetleri</h1><p><?= e($item['summary'] ?: $metaDescription) ?></p><div class="detail-meta"><span><b>Bölge</b><?= e($item['geo_target'] ?: $item['title']) ?></span><span><b>Öne Çıkan Hizmetler</b><?= e($item['services_text']) ?></span></div></div><?php if($item['cover_image']): ?><img src="<?= e(media_url($item['cover_image'])) ?>" alt="<?= e($item['image_alt'] ?: ($item['title'].' inşaat hizmetleri')) ?>"<?php if($item['image_title']): ?> title="<?= e($item['image_title']) ?>"<?php endif; ?>><?php endif; ?></div></section>
<section class="page-section"><div class="container content-layout<?= (int)$secAside['is_active']===1 ? '' : ' no-aside' ?>"><article class="content-prose"><p class="lead"><?= e($item['aio_summary'] ?: ($item['summary'] ?: $metaDescription)) ?></p><?= render_content_blocks((string)$item['body']) ?><?php if((int)$secApproach['is_active']===1): ?><h2><?= e($regionText($secApproach['title'])) ?></h2><p><?= e($secApproach['body']) ?></p><?php endif; ?><?php if((int)$secServices['is_active']===1): ?><h2><?= e($secServices['title']) ?></h2><div class="scope-grid"><?php foreach($services as $i=>$s): ?><a class="scope-card" href="<?= e(app_url('hizmet/'.$s['slug'])) ?>"><span><?= str_pad((string)($i+1),2,'0',STR_PAD_LEFT) ?></span><strong><?= e($s['title']) ?></strong><p><?= e($s['summary']) ?></p></a><?php endforeach; ?></div><?php endif; ?></article><?php if((int)$secAside['is_active']===1): ?><aside class="detail-aside"><h3><?= e($regionText($secAside['title'])) ?></h3><p><?= e($secAside['body']) ?></p><a class="home-btn home-btn-primary" href="<?= e(app_url($secAside['button_url'] ?: 'iletisim')) ?>"><?= e($secAside['button_label'] ?: 'Ücretsiz Ön Değerlendirme') ?></a><a class="home-btn home-btn-secondary" href="<?= e(app_url('bolgeler')) ?>">Tüm Bölgeler</a></aside><?php endif; ?></div></section>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>