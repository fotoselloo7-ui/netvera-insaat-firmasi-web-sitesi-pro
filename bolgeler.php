<?php
require_once __DIR__.'/app/bootstrap.php';
$active='services';
$page=one_by_slug('pages','bolgeler') ?: ['eyebrow'=>'Yerel Saha Deneyimi','title'=>'Hizmet verdiğimiz bölgeler','intro'=>'Alanya ve Antalya çevresinde hizmet verdiğimiz bölgeleri inceleyin.','meta_title'=>'','meta_description'=>'','canonical_url'=>'','robots'=>'','og_title'=>'','og_description'=>'','og_image'=>'','image_alt'=>'','schema_type'=>'','aio_summary'=>''];
$metaTitle=$page['meta_title'] ?: 'Hizmet Bölgeleri | '.setting('site_name','Vera Yapı');
$metaDescription=$page['meta_description'] ?: $page['intro'];
$canonical=seo_absolute_url($page['canonical_url']??'',app_url('bolgeler'));
$robots=$page['robots'] ?: 'index,follow,max-image-preview:large';
$ogTitle=$page['og_title'] ?: $metaTitle;
$ogDescription=$page['og_description'] ?: $metaDescription;
$ogImage=$page['og_image'] ?? '';
$ogImageAlt=$page['image_alt'] ?: $page['title'];
$breadcrumbs=[['name'=>'Ana Sayfa','url'=>app_url()],['name'=>'Hizmet Bölgeleri','url'=>$canonical]];
$pageSchema=['@type'=>seo_clean_schema_type($page['schema_type']??'','CollectionPage'),'@id'=>$canonical.'#webpage','url'=>$canonical,'name'=>$page['title'],'description'=>$page['aio_summary'] ?: $metaDescription,'about'=>['@id'=>rtrim(app_url(),'/').'#business']];
$items=rows('service_areas');
include __DIR__.'/partials/header.php';
?>
<main id="icerik"><section class="page-hero-modern"><div class="container"><div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><span>Hizmet Bölgeleri</span></div><div class="home-kicker"><?= e($page['eyebrow']) ?></div><h1><?= e($page['title']) ?></h1><p><?= e($page['intro']) ?></p></div></section>
<section class="page-section"><div class="container"><div class="page-grid-3"><?php foreach($items as $a): ?><article class="list-card"><?php if($a['cover_image']): ?><a href="<?= e(app_url('bolge/'.$a['slug'])) ?>"><img src="<?= e(media_url($a['cover_image'])) ?>" alt="<?= e($a['image_alt'] ?: ($a['title'].' inşaat hizmetleri')) ?>" loading="lazy"></a><?php endif; ?><small>Hizmet Bölgesi</small><h2><a class="title-link" href="<?= e(app_url('bolge/'.$a['slug'])) ?>"><?= e($a['title']) ?></a></h2><p><?= e($a['summary'] ?: $a['services_text']) ?></p><div class="list-meta"><span><?= e($a['services_text']) ?></span></div></article><?php endforeach; ?></div></div></section></main>
<?php include __DIR__.'/partials/footer.php'; ?>
