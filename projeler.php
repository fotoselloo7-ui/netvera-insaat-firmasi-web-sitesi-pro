<?php
require_once __DIR__.'/app/bootstrap.php';
$active='projects';
$page=one_by_slug('pages','projeler') ?: ['eyebrow'=>'Proje Portföyü','title'=>'Tamamlanan ve devam eden projelerimiz','intro'=>'Konut, villa ve ticari yapılardan seçili uygulamalarımızı inceleyin.','meta_title'=>'','meta_description'=>'','canonical_url'=>'','robots'=>'','og_title'=>'','og_description'=>'','og_image'=>'','image_alt'=>'','schema_type'=>'','aio_summary'=>''];
$metaTitle=$page['meta_title'] ?: 'Projeler | '.setting('site_name','Vera Yapı');$metaDescription=$page['meta_description'] ?: $page['intro'];
$canonical=seo_absolute_url($page['canonical_url']??'',app_url('projeler'));$robots=$page['robots'] ?: 'index,follow,max-image-preview:large';
$ogTitle=$page['og_title'] ?: $metaTitle;$ogDescription=$page['og_description'] ?: $metaDescription;$ogImage=$page['og_image'] ?? '';$ogImageAlt=$page['image_alt'] ?: $page['title'];
$breadcrumbs=[['name'=>'Ana Sayfa','url'=>app_url()],['name'=>'Projeler','url'=>$canonical]];
$pageSchema=['@type'=>seo_clean_schema_type($page['schema_type']??'','CollectionPage'),'@id'=>$canonical.'#webpage','url'=>$canonical,'name'=>$page['title'],'description'=>$page['aio_summary'] ?: $metaDescription,'about'=>['@id'=>rtrim(app_url(),'/').'#business']];
$items=rows('projects');$featured=$items[0]??null;$rest=array_slice($items,1);
$secCta=page_section('projeler','cta');
include __DIR__.'/partials/header.php';
?>
<main id="icerik">
<section class="page-hero-modern"><div class="container">
  <div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><span>Projeler</span></div>
  <div class="home-kicker"><?= e($page['eyebrow']) ?></div><h1><?= e($page['title']) ?></h1><p><?= e($page['intro']) ?></p>
</div></section>

<section class="page-section"><div class="container">
<?php if($featured): ?><a class="project-featured-card" href="<?= e(app_url('proje/'.$featured['slug'])) ?>">
  <figure><img src="<?= e(media_url($featured['cover_image'])) ?>" alt="<?= e($featured['image_alt'] ?: $featured['title']) ?>"></figure>
  <div class="project-featured-copy"><small><?= e($featured['status']) ?> · <?= e($featured['location']) ?></small><h2><?= e($featured['title']) ?></h2><p><?= e($featured['summary']) ?></p><div class="project-featured-meta"><span><?= e($featured['category']) ?></span><span><?= e($featured['area']) ?></span><span><?= e($featured['project_year']) ?></span></div><span class="home-btn home-btn-primary">Projeyi İncele</span></div>
</a><?php endif; ?>
<div class="project-case-grid"><?php foreach($rest as $p): ?><a class="project-case-card" href="<?= e(app_url('proje/'.$p['slug'])) ?>">
  <figure><img src="<?= e(media_url($p['cover_image'])) ?>" alt="<?= e($p['image_alt'] ?: $p['title']) ?>" loading="lazy"></figure>
  <small class="home-kicker"><?= e($p['status']) ?> · <?= e($p['location']) ?></small><h2><?= e($p['title']) ?></h2><p><?= e($p['summary']) ?></p>
  <div class="list-meta"><span><?= e($p['category']) ?></span><span><?= e($p['area']) ?></span><span><?= e($p['project_year']) ?></span></div>
</a><?php endforeach; ?></div>
</div></section>

<?php if((int)$secCta['is_active']===1): ?><section class="page-section soft"><div class="container"><div class="inline-editorial-cta">
  <div><div class="home-kicker"><?= e($secCta['eyebrow']) ?></div><h3><?= e($secCta['title']) ?></h3><p><?= e($secCta['body']) ?></p></div>
  <a class="home-btn home-btn-primary" href="<?= e(app_url($secCta['button_url'] ?: 'iletisim')) ?>"><?= e($secCta['button_label'] ?: 'Projeyi Değerlendir') ?></a>
</div></div></section><?php endif; ?>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>