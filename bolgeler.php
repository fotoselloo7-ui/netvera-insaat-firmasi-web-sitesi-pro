<?php
require_once __DIR__.'/app/bootstrap.php';
$active='services';
$page=one_by_slug('pages','bolgeler') ?: ['eyebrow'=>'Yerel Saha Deneyimi','title'=>'Hizmet verdiğimiz bölgeler','intro'=>'Alanya ve Antalya çevresinde hizmet verdiğimiz bölgeleri inceleyin.','meta_title'=>'','meta_description'=>'','canonical_url'=>'','robots'=>'','og_title'=>'','og_description'=>'','og_image'=>'','image_alt'=>'','schema_type'=>'','aio_summary'=>''];
$metaTitle=$page['meta_title'] ?: 'Hizmet Bölgeleri | '.setting('site_name','Vera Yapı');$metaDescription=$page['meta_description'] ?: $page['intro'];
$canonical=seo_absolute_url($page['canonical_url']??'',app_url('bolgeler'));$robots=$page['robots'] ?: 'index,follow,max-image-preview:large';
$ogTitle=$page['og_title'] ?: $metaTitle;$ogDescription=$page['og_description'] ?: $metaDescription;$ogImage=$page['og_image'] ?? '';$ogImageAlt=$page['image_alt'] ?: $page['title'];
$breadcrumbs=[['name'=>'Ana Sayfa','url'=>app_url()],['name'=>'Hizmet Bölgeleri','url'=>$canonical]];
$pageSchema=['@type'=>seo_clean_schema_type($page['schema_type']??'','CollectionPage'),'@id'=>$canonical.'#webpage','url'=>$canonical,'name'=>$page['title'],'description'=>$page['aio_summary'] ?: $metaDescription,'about'=>['@id'=>rtrim(app_url(),'/').'#business']];
$items=rows('service_areas');
$secLocal=page_section('bolgeler','local');
$secCta=page_section('bolgeler','cta');
include __DIR__.'/partials/header.php';
?>
<main id="icerik">
<section class="page-hero-modern"><div class="container"><div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><span>Hizmet Bölgeleri</span></div><div class="home-kicker"><?= e($page['eyebrow']) ?></div><h1><?= e($page['title']) ?></h1><p><?= e($page['intro']) ?></p></div></section>
<?php if((int)$secLocal['is_active']===1): ?><section class="page-section"><div class="container">
  <div class="page-title-row"><div><div class="home-kicker"><?= e($secLocal['eyebrow']) ?></div><h2><?= e($secLocal['title']) ?></h2></div><p><?= e($secLocal['body']) ?></p></div>
  <div class="region-list"><?php foreach($items as $a): ?><a class="region-card" href="<?= e(app_url('bolge/'.$a['slug'])) ?>"><small>Hizmet Bölgesi</small><h2><?= e($a['title']) ?></h2><p><?= e($a['summary'] ?: ($a['title'].' bölgesinde '.$a['services_text'].' hizmetleri.')) ?></p><div class="list-meta"><span><?= e($a['services_text']) ?></span><span class="micro-action">Detay</span></div></a><?php endforeach; ?></div>
</div></section><?php endif; ?>
<?php if((int)$secCta['is_active']===1): ?><section class="page-section soft"><div class="container"><div class="inline-editorial-cta"><div><div class="home-kicker"><?= e($secCta['eyebrow']) ?></div><h3><?= e($secCta['title']) ?></h3><p><?= e($secCta['body']) ?></p></div><a class="home-btn home-btn-primary" href="<?= e(app_url($secCta['button_url'] ?: 'iletisim')) ?>"><?= e($secCta['button_label'] ?: 'Konumu Sorun') ?></a></div></div></section><?php endif; ?>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>