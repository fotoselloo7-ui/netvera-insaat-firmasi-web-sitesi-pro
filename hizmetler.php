<?php
require_once __DIR__.'/app/bootstrap.php';
$active='services';
$page=one_by_slug('pages','hizmetler') ?: ['eyebrow'=>'Uzmanlık Alanlarımız','title'=>'İnşaat hizmetlerimiz','intro'=>'Konut, villa, ticari yapı, anahtar teslim, renovasyon ve proje uygulama hizmetlerimizi inceleyin.','meta_title'=>'','meta_description'=>'','canonical_url'=>'','robots'=>'','og_title'=>'','og_description'=>'','og_image'=>'','image_alt'=>'','schema_type'=>'','aio_summary'=>''];
$metaTitle=$page['meta_title'] ?: 'Hizmetler | '.setting('site_name','Vera Yapı');
$metaDescription=$page['meta_description'] ?: $page['intro'];
$canonical=seo_absolute_url($page['canonical_url']??'',app_url('hizmetler'));
$robots=$page['robots'] ?: 'index,follow,max-image-preview:large';
$ogTitle=$page['og_title'] ?: $metaTitle;$ogDescription=$page['og_description'] ?: $metaDescription;
$ogImage=$page['og_image'] ?? '';$ogImageAlt=$page['image_alt'] ?: $page['title'];
$breadcrumbs=[['name'=>'Ana Sayfa','url'=>app_url()],['name'=>'Hizmetler','url'=>$canonical]];
$pageSchema=['@type'=>seo_clean_schema_type($page['schema_type']??'','CollectionPage'),'@id'=>$canonical.'#webpage','url'=>$canonical,'name'=>$page['title'],'description'=>$page['aio_summary'] ?: $metaDescription,'about'=>['@id'=>rtrim(app_url(),'/').'#business']];
$items=rows('services');
$secDirectory=page_section('hizmetler','directory');
$secMethod=page_section('hizmetler','method');
$secCta=page_section('hizmetler','cta');
$serviceFlow=feature_group('service_flow');
$serviceMethods=feature_group('service_method');
include __DIR__.'/partials/header.php';
?>
<main id="icerik">
<section class="page-hero-modern"><div class="container">
  <div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><span>Hizmetler</span></div>
  <div class="home-kicker"><?= e($page['eyebrow']) ?></div><h1><?= e($page['title']) ?></h1><p><?= e($page['intro']) ?></p>
</div></section>

<?php if((int)$secDirectory['is_active']===1): ?><section class="page-section"><div class="container">
  <div class="page-title-row"><div><div class="home-kicker"><?= e($secDirectory['eyebrow']) ?></div><h2><?= e($secDirectory['title']) ?></h2></div><p><?= e($secDirectory['body']) ?></p></div>
  <div class="service-directory">
    <?php foreach($items as $i=>$s): ?><a class="service-directory-row" href="<?= e(app_url('hizmet/'.$s['slug'])) ?>">
      <span class="service-no"><?= str_pad((string)($i+1),2,'0',STR_PAD_LEFT) ?></span>
      <div class="service-directory-copy"><h2><?= e($s['title']) ?></h2><p><?= e($s['summary']) ?></p></div>
      <figure><?php if($s['cover_image']): ?><img src="<?= e(media_url($s['cover_image'])) ?>" alt="<?= e($s['image_alt'] ?: $s['title']) ?>" loading="lazy"><?php endif; ?></figure>
      <span class="service-arrow" aria-hidden="true"><svg viewBox="0 0 20 20"><path d="M6 10h8M11 7l3 3-3 3"/></svg></span>
    </a><?php endforeach; ?>
  </div>
</div></section><?php endif; ?>

<?php if($serviceFlow): ?><section class="page-section soft"><div class="container">
  <div class="fact-ribbon">
    <?php foreach(array_slice($serviceFlow,0,4) as $f): ?><div><strong><?= e($f['icon']) ?></strong><span><?= e($f['title']) ?></span></div><?php endforeach; ?>
  </div>
</div></section><?php endif; ?>

<?php if((int)$secMethod['is_active']===1 && $serviceMethods): ?><section class="page-section service-method-section"><div class="container">
  <div class="page-title-row"><div><div class="home-kicker"><?= e($secMethod['eyebrow']) ?></div><h2><?= e($secMethod['title']) ?></h2></div><p><?= e($secMethod['body']) ?></p></div>
  <div class="service-method-grid">
    <?php foreach($serviceMethods as $f): ?><article class="service-method-card"><span><?= e($f['icon']) ?></span><div><h3><?= e($f['title']) ?></h3><p><?= e($f['body']) ?></p></div><?php if(!empty($f['link_url'])): ?><a href="<?= e(app_url($f['link_url'])) ?>"><?= e($f['link_label'] ?: 'İncele') ?> <b>›</b></a><?php endif; ?></article><?php endforeach; ?>
  </div>
</div></section><?php endif; ?>

<?php if((int)$secCta['is_active']===1): ?><section class="page-section"><div class="container"><div class="inline-editorial-cta">
  <div><div class="home-kicker"><?= e($secCta['eyebrow']) ?></div><h3><?= e($secCta['title']) ?></h3><p><?= e($secCta['body']) ?></p></div>
  <a class="home-btn home-btn-primary" href="<?= e(app_url($secCta['button_url'] ?: 'iletisim')) ?>"><?= e($secCta['button_label'] ?: 'Detaylı Bilgi Al') ?></a>
</div></div></section><?php endif; ?>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>