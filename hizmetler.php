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
include __DIR__.'/partials/header.php';
?>
<main id="icerik">
<section class="page-hero-modern"><div class="container">
  <div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><span>Hizmetler</span></div>
  <div class="home-kicker"><?= e($page['eyebrow']) ?></div><h1><?= e($page['title']) ?></h1><p><?= e($page['intro']) ?></p>
</div></section>

<section class="page-section"><div class="container">
  <div class="page-title-row"><div><div class="home-kicker">Kapsamı Netleştirin</div><h2>Hizmet seçmekten önce ihtiyacı doğru tanımlayın.</h2></div><p>Her proje aynı değildir. Yapı tipi, mevcut proje durumu, hedef takvim ve uygulama kapsamına göre doğru çalışma modeli değişir.</p></div>
  <div class="service-directory">
    <?php foreach($items as $i=>$s): ?><a class="service-directory-row" href="<?= e(app_url('hizmet/'.$s['slug'])) ?>">
      <span class="service-no"><?= str_pad((string)($i+1),2,'0',STR_PAD_LEFT) ?></span>
      <div class="service-directory-copy"><h2><?= e($s['title']) ?></h2><p><?= e($s['summary']) ?></p></div>
      <figure><?php if($s['cover_image']): ?><img src="<?= e(media_url($s['cover_image'])) ?>" alt="<?= e($s['image_alt'] ?: $s['title']) ?>" loading="lazy"><?php endif; ?></figure>
      <span class="service-arrow" aria-hidden="true"><svg viewBox="0 0 20 20"><path d="M6 10h8M11 7l3 3-3 3"/></svg></span>
    </a><?php endforeach; ?>
  </div>
</div></section>

<section class="page-section soft"><div class="container">
  <div class="fact-ribbon">
    <div><strong>01</strong><span>İhtiyaç & keşif</span></div>
    <div><strong>02</strong><span>Kapsam & bütçe</span></div>
    <div><strong>03</strong><span>Uygulama & kontrol</span></div>
    <div><strong>04</strong><span>Teslim & kapanış</span></div>
  </div>
</div></section>

<section class="page-section"><div class="container"><div class="inline-editorial-cta">
  <div><div class="home-kicker">Kararsız mısınız?</div><h3>Hangi hizmetin projenize uyduğunu birlikte belirleyelim.</h3><p>Kısa proje bilgisini gönderin; doğru hizmet modelini ve sonraki adımı netleştirelim.</p></div>
  <a class="home-btn home-btn-primary" href="<?= e(app_url('iletisim')) ?>">Detaylı Bilgi Al</a>
</div></div></section>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>