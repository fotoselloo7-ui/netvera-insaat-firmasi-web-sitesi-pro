<?php
require_once __DIR__.'/app/bootstrap.php';
$active='services';
$metaTitle='Hizmet Bölgeleri | '.setting('site_name','Vera Yapı');
$metaDescription='Alanya ve Antalya çevresinde hizmet verdiğimiz bölgeleri ve inşaat hizmetlerini inceleyin.';
$canonical=app_url('bolgeler');
$breadcrumbs=[['name'=>'Ana Sayfa','url'=>app_url()],['name'=>'Hizmet Bölgeleri','url'=>$canonical]];
$pageSchema=['@type'=>'CollectionPage','@id'=>$canonical.'#webpage','url'=>$canonical,'name'=>$metaTitle,'description'=>$metaDescription,'about'=>['@id'=>rtrim(app_url(),'/').'#business']];
$items=rows('service_areas');
include __DIR__.'/partials/header.php';
?>
<main id="icerik"><section class="page-hero-modern"><div class="container"><div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><span>Hizmet Bölgeleri</span></div><div class="home-kicker">Yerel Saha Deneyimi</div><h1>Hizmet verdiğimiz bölgeler.</h1><p>Her bölge için hizmet kapsamı, yerel yapı ihtiyaçları ve proje yaklaşımını ayrı sayfada inceleyin.</p></div></section>
<section class="page-section"><div class="container"><div class="page-grid-3"><?php foreach($items as $a): ?><article class="list-card"><?php if($a['cover_image']): ?><a href="<?= e(app_url('bolge/'.$a['slug'])) ?>"><img src="<?= e(media_url($a['cover_image'])) ?>" alt="<?= e($a['image_alt'] ?: ($a['title'].' inşaat hizmetleri')) ?>" loading="lazy"></a><?php endif; ?><small>Hizmet Bölgesi</small><h2><a class="title-link" href="<?= e(app_url('bolge/'.$a['slug'])) ?>"><?= e($a['title']) ?></a></h2><p><?= e($a['summary'] ?: $a['services_text']) ?></p><div class="list-meta"><span><?= e($a['services_text']) ?></span></div></article><?php endforeach; ?></div></div></section></main>
<?php include __DIR__.'/partials/footer.php'; ?>
