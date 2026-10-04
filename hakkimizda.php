<?php
require_once __DIR__.'/app/bootstrap.php';
$page=one_by_slug('pages','hakkimizda') ?: ['eyebrow'=>'Kurumsal','title'=>'Hakkımızda','intro'=>'','body'=>'','hero_image'=>'','meta_title'=>'Hakkımızda','meta_description'=>''];
$active='about';$metaTitle=$page['meta_title'] ?: $page['title'];$metaDescription=$page['meta_description'] ?: $page['intro'];$ogImage=$page['hero_image'];
include __DIR__.'/partials/header.php';
?>
<main id="icerik"><section class="page-hero-modern"><div class="container"><div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><span>Hakkımızda</span></div><div class="home-kicker"><?= e($page['eyebrow']) ?></div><h1><?= e($page['title']) ?></h1><p><?= e($page['intro']) ?></p></div></section>
<section class="page-section"><div class="container content-layout"><article class="content-prose"><p class="lead"><?= e($page['intro']) ?></p><?php foreach(preg_split('/\R{2,}/',(string)$page['body']) as $p): ?><p><?= nl2br(e($p)) ?></p><?php endforeach; ?><h2>Çalışma yaklaşımımız</h2><div class="process-line"><?php foreach(feature_group('why') as $f): ?><div class="process-step"><small><?= e($f['icon']) ?></small><h3><?= e($f['title']) ?></h3><p><?= e($f['body']) ?></p></div><?php endforeach; ?></div></article><aside class="detail-aside"><h3>Bir proje mi planlıyorsunuz?</h3><p>İhtiyacınızı, konumu ve hedef takvimi paylaşın. İlk değerlendirmeyi birlikte yapalım.</p><a class="home-btn home-btn-primary" href="<?= e(app_url('iletisim')) ?>">İletişime Geçin</a></aside></div></section></main>
<?php include __DIR__.'/partials/footer.php'; ?>
