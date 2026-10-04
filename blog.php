<?php
require_once __DIR__.'/app/bootstrap.php';
$active='blog';
$page=one_by_slug('pages','blog') ?: ['eyebrow'=>'Bilgi Merkezi','title'=>'İnşaat ve yatırım rehberleri','intro'=>'Proje planlama, taahhüt, villa yapımı ve yapı yatırımları hakkında uzman içerikler.','meta_title'=>'','meta_description'=>'','canonical_url'=>'','robots'=>'','og_title'=>'','og_description'=>'','og_image'=>'','image_alt'=>'','schema_type'=>'','aio_summary'=>''];
$metaTitle=$page['meta_title'] ?: 'Blog | '.setting('site_name','Vera Yapı');$metaDescription=$page['meta_description'] ?: $page['intro'];
$canonical=seo_absolute_url($page['canonical_url']??'',app_url('blog'));$robots=$page['robots'] ?: 'index,follow,max-image-preview:large';
$ogTitle=$page['og_title'] ?: $metaTitle;$ogDescription=$page['og_description'] ?: $metaDescription;$ogImage=$page['og_image'] ?? '';$ogImageAlt=$page['image_alt'] ?: $page['title'];
$breadcrumbs=[['name'=>'Ana Sayfa','url'=>app_url()],['name'=>'Blog','url'=>$canonical]];
$pageSchema=['@type'=>seo_clean_schema_type($page['schema_type']??'','Blog'),'@id'=>$canonical.'#blog','url'=>$canonical,'name'=>$page['title'],'description'=>$page['aio_summary'] ?: $metaDescription,'publisher'=>['@id'=>rtrim(app_url(),'/').'#business']];
$items=rows('posts','is_active=1',[],'COALESCE(published_at,created_at) DESC,id DESC');
$fallbacks=['https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&q=82&w=1200','https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&q=82&w=900','https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&q=82&w=900'];
$lead=$items[0]??null;$side=array_slice($items,1,2);$rest=array_slice($items,3);
include __DIR__.'/partials/header.php';
?>
<main id="icerik">
<section class="page-hero-modern"><div class="container">
  <div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><span>Blog</span></div>
  <div class="home-kicker"><?= e($page['eyebrow']) ?></div><h1><?= e($page['title']) ?></h1><p><?= e($page['intro']) ?></p>
</div></section>

<section class="page-section"><div class="container">
<?php if($lead): ?><div class="blog-editorial-grid">
  <a class="blog-lead-card" href="<?= e(app_url('blog/'.$lead['slug'])) ?>"><img src="<?= e(media_url($lead['cover_image'] ?: $fallbacks[0])) ?>" alt="<?= e($lead['image_alt'] ?: $lead['title']) ?>"><div class="blog-lead-copy"><small><?= e($lead['published_at']?date('d.m.Y',strtotime($lead['published_at'])):'Rehber') ?> · <?= estimated_reading_minutes((string)$lead['body']) ?> dk okuma</small><h2><?= e($lead['title']) ?></h2><p><?= e($lead['excerpt']) ?></p></div></a>
  <div class="blog-side-stack"><?php foreach($side as $i=>$p): ?><a class="blog-side-card" href="<?= e(app_url('blog/'.$p['slug'])) ?>"><figure><img src="<?= e(media_url($p['cover_image'] ?: $fallbacks[$i+1])) ?>" alt="<?= e($p['image_alt'] ?: $p['title']) ?>"></figure><div class="blog-side-copy"><small><?= e($p['published_at']?date('d.m.Y',strtotime($p['published_at'])):'Rehber') ?></small><h3><?= e($p['title']) ?></h3><span><?= estimated_reading_minutes((string)$p['body']) ?> dk okuma →</span></div></a><?php endforeach; ?></div>
</div><?php endif; ?>

<?php if($rest): ?><div class="page-title-row"><div><div class="home-kicker">Diğer Yazılar</div><h2>Karar vermeden önce bilmeniz gerekenler.</h2></div></div><div class="page-grid-3"><?php foreach($rest as $i=>$p): ?><article class="list-card"><a href="<?= e(app_url('blog/'.$p['slug'])) ?>"><img src="<?= e(media_url($p['cover_image'] ?: $fallbacks[$i%3])) ?>" alt="<?= e($p['image_alt'] ?: $p['title']) ?>" loading="lazy"></a><small><?= e($p['published_at']?date('d.m.Y',strtotime($p['published_at'])):'Rehber') ?></small><h2><a class="title-link" href="<?= e(app_url('blog/'.$p['slug'])) ?>"><?= e($p['title']) ?></a></h2><p><?= e($p['excerpt']) ?></p></article><?php endforeach; ?></div><?php endif; ?>
</div></section>

<section class="page-section soft"><div class="container"><div class="inline-editorial-cta"><div><div class="home-kicker">Sorunuz Yazıda Yoksa</div><h3>Projenize özel soruyu doğrudan sorun.</h3><p>Genel bilgi yerine kendi proje koşullarınıza göre kısa bir ön değerlendirme alın.</p></div><a class="home-btn home-btn-primary" href="<?= e(app_url('iletisim')) ?>">Uzmanla Görüşün</a></div></div></section>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>