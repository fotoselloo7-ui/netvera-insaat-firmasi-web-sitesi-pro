<?php
require_once __DIR__.'/app/bootstrap.php';
$active='blog';
$page=one_by_slug('pages','blog') ?: ['eyebrow'=>'Bilgi Merkezi','title'=>'İnşaat ve yatırım rehberleri','intro'=>'Proje planlama, taahhüt, villa yapımı ve yapı yatırımları hakkında uzman içerikler.','meta_title'=>'','meta_description'=>'','canonical_url'=>'','robots'=>'','og_title'=>'','og_description'=>'','og_image'=>'','image_alt'=>'','schema_type'=>'','aio_summary'=>''];
$metaTitle=$page['meta_title'] ?: 'Blog | '.setting('site_name','Vera Yapı');
$metaDescription=$page['meta_description'] ?: $page['intro'];
$canonical=seo_absolute_url($page['canonical_url']??'',app_url('blog'));
$robots=$page['robots'] ?: 'index,follow,max-image-preview:large';
$ogTitle=$page['og_title'] ?: $metaTitle;
$ogDescription=$page['og_description'] ?: $metaDescription;
$ogImage=$page['og_image'] ?? '';
$ogImageAlt=$page['image_alt'] ?: $page['title'];
$breadcrumbs=[['name'=>'Ana Sayfa','url'=>app_url()],['name'=>'Blog','url'=>$canonical]];
$pageSchema=['@type'=>seo_clean_schema_type($page['schema_type']??'','Blog'),'@id'=>$canonical.'#blog','url'=>$canonical,'name'=>$page['title'],'description'=>$page['aio_summary'] ?: $metaDescription,'publisher'=>['@id'=>rtrim(app_url(),'/').'#business']];
$items=rows('posts','is_active=1',[],'COALESCE(published_at,created_at) DESC,id DESC');
include __DIR__.'/partials/header.php';
?>
<main id="icerik"><section class="page-hero-modern"><div class="container"><div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><span>Blog</span></div><div class="home-kicker"><?= e($page['eyebrow']) ?></div><h1><?= e($page['title']) ?></h1><p><?= e($page['intro']) ?></p></div></section><section class="page-section"><div class="container"><?php $fallbacks=['https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&q=82&w=1000','https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&q=82&w=1000','https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&q=82&w=1000']; ?><div class="page-grid-3"><?php foreach($items as $i=>$p): ?><article class="list-card"><a href="<?= e(app_url('blog/'.$p['slug'])) ?>"><img src="<?= e(media_url($p['cover_image'] ?: $fallbacks[$i%3])) ?>" alt="<?= e($p['image_alt'] ?: $p['title']) ?>"<?php if(!empty($p['image_title'])): ?> title="<?= e($p['image_title']) ?>"<?php endif; ?> loading="lazy"></a><small><?= e($p['published_at']?date('d.m.Y',strtotime($p['published_at'])):'Rehber') ?></small><h2><a class="title-link" href="<?= e(app_url('blog/'.$p['slug'])) ?>"><?= e($p['title']) ?></a></h2><p><?= e($p['excerpt']) ?></p></article><?php endforeach; ?></div></div></section><section class="page-section" style="padding-top:0"><div class="container"><div class="page-cta"><div><div class="home-kicker">Projenizi Konuşalım</div><h2>Doğru kapsamı birlikte netleştirelim.</h2><p>Proje türünü, konumu ve hedefinizi paylaşın; ilk değerlendirmede hangi hizmete ihtiyacınız olduğunu birlikte belirleyelim.</p></div><div class="page-cta-actions"><a class="home-btn home-btn-primary" href="<?= e(app_url('#teklif')) ?>">Ücretsiz Keşif Talebi</a><a class="home-btn home-btn-secondary" href="https://wa.me/<?= e(preg_replace('/\D+/','',setting('whatsapp',setting('phone')))) ?>?text=<?= rawurlencode('Merhaba Vera Yapı, projem hakkında detaylı bilgi almak istiyorum.') ?>" target="_blank" rel="noopener">WhatsApp'tan Yaz</a></div></div></div></section></main>
<?php include __DIR__.'/partials/footer.php'; ?>
