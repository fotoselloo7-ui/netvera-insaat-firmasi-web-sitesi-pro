<?php
require_once __DIR__.'/app/bootstrap.php';
$active='projects';
$metaTitle='Projeler | '.setting('site_name','Vera Yapı');
$metaDescription='Tamamlanan ve devam eden konut, villa ve ticari yapı projelerimizi inceleyin.';
$canonical=app_url('projeler');
$breadcrumbs=[['name'=>'Ana Sayfa','url'=>app_url()],['name'=>'Projeler','url'=>$canonical]];
$pageSchema=['@type'=>'CollectionPage','@id'=>$canonical.'#webpage','url'=>$canonical,'name'=>$metaTitle,'description'=>$metaDescription,'about'=>['@id'=>rtrim(app_url(),'/').'#business']];
$items=rows('projects');
include __DIR__.'/partials/header.php';
?>
<main id="icerik"><section class="page-hero-modern"><div class="container"><div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><span>Projeler</span></div><div class="home-kicker">Proje Portföyü</div><h1>Yaptığımız işi tamamlanmış projelerimiz anlatsın.</h1><p>Konut, villa ve ticari yapılardan seçili uygulamalar.</p></div></section><section class="page-section"><div class="container"><div class="page-grid-3"><?php foreach($items as $p): ?><article class="list-card"><a href="<?= e(app_url('proje/'.$p['slug'])) ?>"><img src="<?= e(media_url($p['cover_image'])) ?>" alt="<?= e($p['image_alt'] ?: $p['title']) ?>"<?php if(!empty($p['image_title'])): ?> title="<?= e($p['image_title']) ?>"<?php endif; ?> loading="lazy"></a><small><?= e($p['status']) ?></small><h2><a class="title-link" href="<?= e(app_url('proje/'.$p['slug'])) ?>"><?= e($p['title']) ?></a></h2><p><?= e($p['summary']) ?></p><div class="list-meta"><span><?= e($p['location']) ?></span><span><?= e($p['category']) ?></span><span><?= e($p['area']) ?></span></div></article><?php endforeach; ?></div></div></section><section class="page-section" style="padding-top:0"><div class="container"><div class="page-cta"><div><div class="home-kicker">Projenizi Konuşalım</div><h2>Doğru kapsamı birlikte netleştirelim.</h2><p>Proje türünü, konumu ve hedefinizi paylaşın; ilk değerlendirmede hangi hizmete ihtiyacınız olduğunu birlikte belirleyelim.</p></div><div class="page-cta-actions"><a class="home-btn home-btn-primary" href="<?= e(app_url('#teklif')) ?>">Ücretsiz Keşif Talebi</a><a class="home-btn home-btn-secondary" href="https://wa.me/<?= e(preg_replace('/\D+/','',setting('whatsapp',setting('phone')))) ?>?text=<?= rawurlencode('Merhaba Vera Yapı, projem hakkında detaylı bilgi almak istiyorum.') ?>" target="_blank" rel="noopener">WhatsApp'tan Yaz</a></div></div></div></section></main>
<?php include __DIR__.'/partials/footer.php'; ?>
