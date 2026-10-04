<?php
require_once __DIR__.'/app/bootstrap.php';
$slug=trim((string)($_GET['slug']??''));
$item=one_by_slug('services',$slug);
if(!$item){http_response_code(404);$robots='noindex';$metaTitle='Hizmet Bulunamadı';include __DIR__.'/partials/header.php';echo '<main id="icerik"><section class="page-hero-modern"><div class="container"><h1>Hizmet bulunamadı.</h1></div></section></main>';include __DIR__.'/partials/footer.php';exit;}
$active='services';
$metaTitle=$item['meta_title'] ?: $item['title'].' | '.setting('site_name','Vera Yapı');
$metaDescription=$item['meta_description'] ?: $item['summary'];
$canonical=seo_absolute_url($item['canonical_url']??'',app_url('hizmet/'.$item['slug']));
$robots=$item['robots'] ?: 'index,follow,max-image-preview:large';
$ogTitle=$item['og_title'] ?: $metaTitle;$ogDescription=$item['og_description'] ?: $metaDescription;
$ogImage=$item['og_image'] ?: $item['cover_image'];$ogImageAlt=$item['image_alt'] ?: $item['title'];
$breadcrumbs=[['name'=>'Ana Sayfa','url'=>app_url()],['name'=>'Hizmetler','url'=>app_url('hizmetler')],['name'=>$item['title'],'url'=>$canonical]];
$pageSchema=['@type'=>seo_clean_schema_type($item['schema_type']??'','Service'),'@id'=>$canonical.'#service','url'=>$canonical,'name'=>$item['title'],'description'=>$item['aio_summary'] ?: $metaDescription,'provider'=>['@id'=>rtrim(app_url(),'/').'#business'],'areaServed'=>$item['geo_target'] ?: setting('service_area',''),'mainEntityOfPage'=>$canonical];
if($ogImage!=='') $pageSchema['image']=media_url($ogImage);
$process=feature_group('process');
$projects=array_slice(rows('projects'),0,3);
$scope=feature_group('service_scope');
$secScope=page_section('hizmet-detay','scope');
$secProof=page_section('hizmet-detay','proof');
$secProcess=page_section('hizmet-detay','process');
$secProjects=page_section('hizmet-detay','projects');
$secAside=page_section('hizmet-detay','aside');
include __DIR__.'/partials/header.php';
?>
<main id="icerik">
<section class="detail-hero is-service"><div class="container detail-hero-grid">
  <div>
    <div class="detail-eyebrow-line">Hizmet / <?= e($item['geo_target'] ?: setting('address','Alanya / Antalya')) ?></div>
    <h1><?= e($item['title']) ?></h1><p><?= e($item['summary']) ?></p>
    <div class="detail-meta"><span><b>Hizmet Bölgesi</b><?= e($item['geo_target'] ?: setting('service_area',setting('address','Alanya / Antalya'))) ?></span><span><b>Çalışma Modeli</b>Proje bazlı</span></div>
  </div>
  <?php if($item['cover_image']): ?><img src="<?= e(media_url($item['cover_image'])) ?>" alt="<?= e($item['image_alt'] ?: $item['title']) ?>"<?php if(!empty($item['image_title'])): ?> title="<?= e($item['image_title']) ?>"<?php endif; ?>><?php endif; ?>
</div></section>

<section class="page-section"><div class="container content-layout">
  <article class="content-prose">
    <p class="lead"><?= e($item['aio_summary'] ?: $item['summary']) ?></p>
    <?= render_content_blocks((string)$item['body']) ?>
    <h2><?= e($secScope['title']) ?></h2>
    <div class="scope-grid"><?php foreach($scope as $s): ?><div class="scope-card"><span><?= e($s['icon']) ?></span><strong><?= e($s['title']) ?></strong><p><?= e($s['body']) ?></p></div><?php endforeach; ?></div>
    <div class="service-proof"><div class="home-kicker"><?= e($secProof['eyebrow']) ?></div><h3><?= e($secProof['title']) ?></h3><p><?= e($secProof['body']) ?></p></div>
  </article>
  <aside class="detail-aside"><h3><?= e($item['title'].' '.$secAside['title']) ?></h3><p><?= e($secAside['body']) ?></p><a class="home-btn home-btn-primary" href="<?= e(app_url($secAside['button_url'] ?: 'iletisim')) ?>"><?= e($secAside['button_label'] ?: 'Detaylı Bilgi Al') ?></a><a class="home-btn home-btn-secondary" href="https://wa.me/<?= e(preg_replace('/\D+/','',setting('whatsapp',setting('phone')))) ?>?text=<?= rawurlencode('Merhaba Vera Yapı, '.$item['title'].' hizmeti hakkında bilgi almak istiyorum.') ?>" target="_blank" rel="noopener">WhatsApp'tan Sor</a></aside>
</div></section>

<section class="page-section soft"><div class="container">
  <div class="page-title-row"><div><div class="home-kicker"><?= e($secProcess['eyebrow']) ?></div><h2><?= e($secProcess['title']) ?></h2></div><p><?= e($secProcess['body']) ?></p></div>
  <div class="process-line"><?php foreach($process as $p): ?><div class="process-step"><small><?= e($p['icon']) ?></small><h3><?= e($p['title']) ?></h3><p><?= e($p['body']) ?></p></div><?php endforeach; ?></div>
</div></section>

<?php if($projects): ?><section class="page-section"><div class="container">
  <div class="page-title-row"><div><div class="home-kicker"><?= e($secProjects['eyebrow']) ?></div><h2><?= e($secProjects['title']) ?></h2></div><a class="home-btn home-btn-secondary" href="<?= e(app_url($secProjects['button_url'] ?: 'projeler')) ?>"><?= e($secProjects['button_label'] ?: 'Tüm Projeler') ?></a></div>
  <div class="related-projects"><?php foreach($projects as $p): ?><a class="related-project-card" href="<?= e(app_url('proje/'.$p['slug'])) ?>"><figure><img src="<?= e(media_url($p['cover_image'])) ?>" alt="<?= e($p['image_alt'] ?: $p['title']) ?>" loading="lazy"></figure><small><?= e($p['location']) ?> · <?= e($p['category']) ?></small><strong><?= e($p['title']) ?></strong></a><?php endforeach; ?></div>
</div></section><?php endif; ?>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>