<?php
require_once __DIR__.'/app/bootstrap.php';
$slug=trim((string)($_GET['slug']??''));$item=one_by_slug('projects',$slug);
if(!$item){http_response_code(404);$robots='noindex';$metaTitle='Proje Bulunamadı';include __DIR__.'/partials/header.php';echo '<main id="icerik"><section class="page-hero-modern"><div class="container"><h1>Proje bulunamadı.</h1></div></section></main>';include __DIR__.'/partials/footer.php';exit;}
$active='projects';
$metaTitle=$item['meta_title'] ?: $item['title'].' | '.setting('site_name','Vera Yapı');$metaDescription=$item['meta_description'] ?: $item['summary'];
$canonical=seo_absolute_url($item['canonical_url']??'',app_url('proje/'.$item['slug']));$robots=$item['robots'] ?: 'index,follow,max-image-preview:large';
$ogTitle=$item['og_title'] ?: $metaTitle;$ogDescription=$item['og_description'] ?: $metaDescription;$ogImage=$item['og_image'] ?: $item['cover_image'];$ogImageAlt=$item['image_alt'] ?: $item['title'];
$breadcrumbs=[['name'=>'Ana Sayfa','url'=>app_url()],['name'=>'Projeler','url'=>app_url('projeler')],['name'=>$item['title'],'url'=>$canonical]];
$pageSchema=['@type'=>seo_clean_schema_type($item['schema_type']??'','CreativeWork'),'@id'=>$canonical.'#project','url'=>$canonical,'name'=>$item['title'],'description'=>$item['aio_summary'] ?: $metaDescription,'creator'=>['@id'=>rtrim(app_url(),'/').'#business'],'locationCreated'=>$item['geo_target'] ?: $item['location'],'mainEntityOfPage'=>$canonical];
if($ogImage!=='') $pageSchema['image']=media_url($ogImage);
$gallery=json_decode((string)$item['gallery_json'],true);if(!is_array($gallery))$gallery=[];
$related=array_values(array_filter(rows('projects'),fn($p)=>(int)$p['id']!==(int)$item['id']));$related=array_slice($related,0,2);
$secStory=page_section('proje-detay','story');
$secApproach=page_section('proje-detay','approach');
$secQuality=page_section('proje-detay','quality');
$secRelated=page_section('proje-detay','related');
include __DIR__.'/partials/header.php';
?>
<main id="icerik">
<section class="project-detail-hero"><div class="container">
  <div class="page-breadcrumb" style="color:#90a4b1"><a style="color:#c2cdd4" href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><a style="color:#c2cdd4" href="<?= e(app_url('projeler')) ?>">Projeler</a><span>/</span><span><?= e($item['title']) ?></span></div>
  <div class="project-detail-head"><div><div class="home-kicker"><?= e($item['status']) ?> · <?= e($item['location']) ?></div><h1><?= e($item['title']) ?></h1><p><?= e($item['summary']) ?></p></div><a class="home-btn home-btn-primary" href="<?= e(app_url('iletisim')) ?>">Benzer Proje Konuşalım</a></div>
  <div class="project-detail-cover"><img src="<?= e(media_url($item['cover_image'])) ?>" alt="<?= e($item['image_alt'] ?: $item['title']) ?>"<?php if(!empty($item['image_title'])): ?> title="<?= e($item['image_title']) ?>"<?php endif; ?>></div>
</div></section>

<section class="page-section"><div class="container">
  <div class="project-facts"><div><small>Konum</small><strong><?= e($item['location']) ?></strong></div><div><small>Proje Türü</small><strong><?= e($item['category']) ?></strong></div><div><small>Uygulama Alanı</small><strong><?= e($item['area']) ?></strong></div><div><small>Yıl</small><strong><?= e($item['project_year']) ?></strong></div></div>
  <div class="case-story">
    <aside class="case-story-nav"><span><?= e($secStory['eyebrow']) ?></span><h2><?= e($secStory['title']) ?></h2></aside>
    <article class="case-story-copy"><p class="lead"><?= e($item['aio_summary'] ?: $item['summary']) ?></p><?= render_content_blocks((string)$item['body']) ?>
      <h2><?= e($secApproach['title']) ?></h2><p><?= e($secApproach['body']) ?></p>
      <h2><?= e($secQuality['title']) ?></h2><p><?= e($secQuality['body']) ?></p>
      <?php if($gallery): ?><div class="project-gallery-wide"><?php foreach($gallery as $img): ?><img src="<?= e(media_url((string)$img)) ?>" alt="<?= e($item['image_alt'] ?: ($item['title'].' proje görseli')) ?>" loading="lazy"><?php endforeach; ?></div><?php endif; ?>
    </article>
  </div>
</div></section>

<?php if($related): ?><section class="page-section soft"><div class="container">
  <div class="page-title-row"><div><div class="home-kicker"><?= e($secRelated['eyebrow']) ?></div><h2><?= e($secRelated['title']) ?></h2></div><a class="home-btn home-btn-secondary" href="<?= e(app_url($secRelated['button_url'] ?: 'projeler')) ?>"><?= e($secRelated['button_label'] ?: 'Tüm Portföy') ?></a></div>
  <div class="project-case-grid"><?php foreach($related as $p): ?><a class="project-case-card" href="<?= e(app_url('proje/'.$p['slug'])) ?>"><figure><img src="<?= e(media_url($p['cover_image'])) ?>" alt="<?= e($p['image_alt'] ?: $p['title']) ?>" loading="lazy"></figure><small class="home-kicker"><?= e($p['location']) ?> · <?= e($p['category']) ?></small><h2><?= e($p['title']) ?></h2><p><?= e($p['summary']) ?></p></a><?php endforeach; ?></div>
</div></section><?php endif; ?>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>