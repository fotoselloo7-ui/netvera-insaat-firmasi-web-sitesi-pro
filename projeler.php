<?php
require_once __DIR__.'/app/bootstrap.php';
$active='projects';$metaTitle='Projeler | '.setting('site_name','Vera Yapı');$metaDescription='Tamamlanan ve devam eden konut, villa ve ticari yapı projelerimizi inceleyin.';$items=rows('projects');
include __DIR__.'/partials/header.php';
?>
<main id="icerik"><section class="page-hero-modern"><div class="container"><div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><span>Projeler</span></div><div class="home-kicker">Proje Portföyü</div><h1>Yaptığımız işi tamamlanmış projelerimiz anlatsın.</h1><p>Konut, villa ve ticari yapılardan seçili uygulamalar.</p></div></section><section class="page-section"><div class="container"><div class="page-grid-3"><?php foreach($items as $p): ?><article class="list-card"><a href="<?= e(app_url('proje/'.$p['slug'])) ?>"><img src="<?= e(media_url($p['cover_image'])) ?>" alt="<?= e($p['title']) ?>" loading="lazy"></a><small><?= e($p['status']) ?></small><h2><a class="title-link" href="<?= e(app_url('proje/'.$p['slug'])) ?>"><?= e($p['title']) ?></a></h2><p><?= e($p['summary']) ?></p><div class="list-meta"><span><?= e($p['location']) ?></span><span><?= e($p['category']) ?></span><span><?= e($p['area']) ?></span></div></article><?php endforeach; ?></div></div></section></main>
<?php include __DIR__.'/partials/footer.php'; ?>
