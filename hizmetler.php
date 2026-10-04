<?php
require_once __DIR__.'/app/bootstrap.php';
$active='services';$metaTitle='Hizmetler | '.setting('site_name','Vera Yapı');$metaDescription='Konut, villa, ticari yapı, anahtar teslim taahhüt, renovasyon ve proje uygulama hizmetleri.';
$items=rows('services');
include __DIR__.'/partials/header.php';
?>
<main id="icerik"><section class="page-hero-modern"><div class="container"><div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><span>Hizmetler</span></div><div class="home-kicker">Uzmanlık Alanlarımız</div><h1>İnşaatın farklı ihtiyaçları için net kapsamlı hizmetler.</h1><p>Her hizmetin kapsamını, sürecini ve proje tipine göre sunduğumuz yaklaşımı inceleyin.</p></div></section><section class="page-section"><div class="container"><div class="page-grid-3"><?php foreach($items as $s): ?><article class="list-card"><?php if($s['cover_image']): ?><a href="<?= e(app_url('hizmet/'.$s['slug'])) ?>"><img src="<?= e(media_url($s['cover_image'])) ?>" alt="<?= e($s['title']) ?>" loading="lazy"></a><?php endif; ?><small>Hizmet</small><h2><a class="title-link" href="<?= e(app_url('hizmet/'.$s['slug'])) ?>"><?= e($s['title']) ?></a></h2><p><?= e($s['summary']) ?></p><a class="home-kicker" style="display:inline-block;margin-top:12px" href="<?= e(app_url('hizmet/'.$s['slug'])) ?>">Detayları incele →</a></article><?php endforeach; ?></div></div></section></main>
<?php include __DIR__.'/partials/footer.php'; ?>
