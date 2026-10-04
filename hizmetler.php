<?php
require_once __DIR__.'/app/bootstrap.php';
$active='services';
$page=one_by_slug('pages','hizmetler') ?: ['eyebrow'=>'Uzmanlık Alanlarımız','title'=>'İnşaat hizmetlerimiz','intro'=>'Konut, villa, ticari yapı, anahtar teslim, renovasyon ve proje uygulama hizmetlerimizi inceleyin.','meta_title'=>'','meta_description'=>'','canonical_url'=>'','robots'=>'','og_title'=>'','og_description'=>'','og_image'=>'','image_alt'=>'','schema_type'=>'','aio_summary'=>''];
$metaTitle=$page['meta_title'] ?: 'Hizmetler | '.setting('site_name','Vera Yapı');
$metaDescription=$page['meta_description'] ?: $page['intro'];
$canonical=seo_absolute_url($page['canonical_url']??'',app_url('hizmetler'));
$robots=$page['robots'] ?: 'index,follow,max-image-preview:large';
$ogTitle=$page['og_title'] ?: $metaTitle;
$ogDescription=$page['og_description'] ?: $metaDescription;
$ogImage=$page['og_image'] ?? '';
$ogImageAlt=$page['image_alt'] ?: $page['title'];
$breadcrumbs=[['name'=>'Ana Sayfa','url'=>app_url()],['name'=>'Hizmetler','url'=>$canonical]];
$pageSchema=['@type'=>seo_clean_schema_type($page['schema_type']??'','CollectionPage'),'@id'=>$canonical.'#webpage','url'=>$canonical,'name'=>$page['title'],'description'=>$page['aio_summary'] ?: $metaDescription,'about'=>['@id'=>rtrim(app_url(),'/').'#business']];
$items=rows('services');
include __DIR__.'/partials/header.php';
?>
<main id="icerik"><section class="page-hero-modern"><div class="container"><div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><span>Hizmetler</span></div><div class="home-kicker"><?= e($page['eyebrow']) ?></div><h1><?= e($page['title']) ?></h1><p><?= e($page['intro']) ?></p></div></section><section class="page-section"><div class="container"><div class="page-grid-3"><?php foreach($items as $s): ?><article class="list-card"><?php if($s['cover_image']): ?><a href="<?= e(app_url('hizmet/'.$s['slug'])) ?>"><img src="<?= e(media_url($s['cover_image'])) ?>" alt="<?= e($s['image_alt'] ?: $s['title']) ?>"<?php if(!empty($s['image_title'])): ?> title="<?= e($s['image_title']) ?>"<?php endif; ?> loading="lazy"></a><?php endif; ?><small>Hizmet</small><h2><a class="title-link" href="<?= e(app_url('hizmet/'.$s['slug'])) ?>"><?= e($s['title']) ?></a></h2><p><?= e($s['summary']) ?></p><a class="home-kicker" style="display:inline-block;margin-top:12px" href="<?= e(app_url('hizmet/'.$s['slug'])) ?>">Detayları incele →</a></article><?php endforeach; ?></div></div></section><section class="page-section" style="padding-top:0"><div class="container"><div class="page-cta"><div><div class="home-kicker">Projenizi Konuşalım</div><h2>Doğru kapsamı birlikte netleştirelim.</h2><p>Proje türünü, konumu ve hedefinizi paylaşın; ilk değerlendirmede hangi hizmete ihtiyacınız olduğunu birlikte belirleyelim.</p></div><div class="page-cta-actions"><a class="home-btn home-btn-primary" href="<?= e(app_url('#teklif')) ?>">Ücretsiz Keşif Talebi</a><a class="home-btn home-btn-secondary" href="https://wa.me/<?= e(preg_replace('/\D+/','',setting('whatsapp',setting('phone')))) ?>?text=<?= rawurlencode('Merhaba Vera Yapı, projem hakkında detaylı bilgi almak istiyorum.') ?>" target="_blank" rel="noopener">WhatsApp'tan Yaz</a></div></div></div></section></main>
<?php include __DIR__.'/partials/footer.php'; ?>
