<?php
require_once __DIR__.'/app/bootstrap.php';
$page=one_by_slug('pages','hakkimizda') ?: ['eyebrow'=>'Kurumsal','title'=>'Güvenilir yapılar, şeffaf süreçler.','intro'=>'Planlama, teknik uygulama ve teslim süreçlerini tek sorumluluk altında yürüten disiplinli bir yapı yaklaşımı.','body'=>'','hero_image'=>'','meta_title'=>'Hakkımızda','meta_description'=>''];
$active='about';
$metaTitle=$page['meta_title'] ?: $page['title'];
$metaDescription=$page['meta_description'] ?: $page['intro'];
$canonical=seo_absolute_url($page['canonical_url']??'',app_url('hakkimizda'));
$robots=$page['robots'] ?: 'index,follow,max-image-preview:large';
$ogTitle=$page['og_title'] ?: $metaTitle;
$ogDescription=$page['og_description'] ?: $metaDescription;
$ogImage=$page['og_image'] ?: ($page['hero_image'] ?: setting('about_image',''));
$ogImageAlt=$page['image_alt'] ?: $page['title'];
$breadcrumbs=[['name'=>'Ana Sayfa','url'=>app_url()],['name'=>'Hakkımızda','url'=>$canonical]];
$pageSchema=[
  '@type'=>seo_clean_schema_type($page['schema_type']??'','AboutPage'),
  '@id'=>$canonical.'#webpage','url'=>$canonical,'name'=>$page['title'],
  'description'=>$page['aio_summary'] ?: $metaDescription,
  'about'=>['@id'=>rtrim(app_url(),'/').'#business'],
  'mainEntity'=>['@id'=>rtrim(app_url(),'/').'#business'],'inLanguage'=>'tr-TR',
];
if($ogImage!=='') $pageSchema['primaryImageOfPage']=media_url($ogImage);
$stats=rows('home_stats');
$principles=feature_group('why');
$process=feature_group('process');
$aboutImage=$page['hero_image'] ?: setting('about_image','https://images.unsplash.com/photo-1759863468387-374e0362050a?auto=format&fit=crop&q=80&w=1400');
include __DIR__.'/partials/header.php';
?>
<main id="icerik">
<section class="page-hero-modern"><div class="container">
  <div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><span>Hakkımızda</span></div>
  <div class="home-kicker"><?= e($page['eyebrow']) ?></div>
  <h1><?= e($page['title']) ?></h1>
  <p><?= e($page['intro']) ?></p>
</div></section>

<section class="page-section"><div class="container editorial-intro">
  <div class="editorial-visual">
    <img src="<?= e(media_url($aboutImage)) ?>" alt="<?= e($page['image_alt'] ?: setting('about_image_alt','Vera Yapı inşaat projeleri')) ?>"<?php if(setting('about_image_title','')!==''): ?> title="<?= e(setting('about_image_title')) ?>"<?php endif; ?>>
    <div class="editorial-visual-caption"><span>Alanya / Antalya</span><span>Planlama · Uygulama · Teslim</span></div>
  </div>
  <article class="editorial-copy">
    <div class="home-kicker">Nasıl Çalışıyoruz?</div>
    <p class="lead">İyi bir yapı yalnızca malzeme ve işçilikten değil; doğru kararların doğru sırayla alınmasından oluşur.</p>
    <?php $paragraphs=array_values(array_filter(array_map('trim',preg_split('/\R{2,}/',(string)$page['body'])))); ?>
    <?php if($paragraphs): foreach($paragraphs as $p): ?><p><?= nl2br(e($p)) ?></p><?php endforeach; else: ?>
      <p>Vera Yapı olarak keşif, bütçe, teknik çözüm, tedarik, saha uygulaması ve teslim süreçlerini tek koordinasyon yapısında ele alıyoruz. Böylece müşterinin yalnızca bitmiş yapıya değil, projenin nasıl ilerlediğine de güvenebilmesini hedefliyoruz.</p>
      <p>Her projede kapsamı mümkün olduğunca erken netleştiriyor, kritik kararları sahaya taşımadan önce çözüyor ve uygulama boyunca düzenli bilgi akışını koruyoruz.</p>
    <?php endif; ?>
    <h2>Gösterişten önce düzen, vaatten önce süreç.</h2>
    <p>Bizim için premium hizmet; daha fazla söz vermek değil, daha az belirsizlik üretmektir. Bütçe, takvim, malzeme ve uygulama kararlarının izlenebilir olması bu yüzden çalışma modelimizin merkezindedir.</p>
  </article>
</div></section>

<?php if($stats): ?><section class="page-section soft"><div class="container"><div class="fact-ribbon">
  <?php foreach(array_slice($stats,0,4) as $s): ?><div><strong><?= e($s['stat_value']) ?></strong><span><?= e($s['label']) ?></span></div><?php endforeach; ?>
</div></div></section><?php endif; ?>

<section class="page-section"><div class="container">
  <div class="page-title-row"><div><div class="home-kicker">Çalışma Prensipleri</div><h2>Projeyi güçlü kılan görünmeyen disiplin.</h2></div><p>İnşaat sürecinde güven; yalnızca sonuçtan değil, kararların nasıl alındığından doğar.</p></div>
  <div class="principle-grid">
    <?php foreach($principles as $p): ?><article class="principle-card"><small><?= e($p['icon']) ?></small><h3><?= e($p['title']) ?></h3><p><?= e($p['body']) ?></p></article><?php endforeach; ?>
  </div>
</div></section>

<section class="page-section navy"><div class="container">
  <div class="page-title-row"><div><div class="home-kicker">Proje Akışı</div><h2 style="color:#fff">İlk görüşmeden teslim anına kadar tek ritim.</h2></div><p style="color:#afbdc6">Müşteri hangi aşamada olduğumuzu, sıradaki kararın ne olduğunu ve kimden sorumlu olduğunu bilir.</p></div>
  <div class="process-line"><?php foreach($process as $p): ?><div class="process-step"><small><?= e($p['icon']) ?></small><h3><?= e($p['title']) ?></h3><p><?= e($p['body']) ?></p></div><?php endforeach; ?></div>
</div></section>

<section class="page-section"><div class="container"><div class="inline-editorial-cta">
  <div><div class="home-kicker">İlk Değerlendirme</div><h3>Projenizi masaya yatırmadan fiyat konuşmayalım.</h3><p>Konumu, yaklaşık alanı ve hedefinizi paylaşın; önce doğru kapsamı birlikte netleştirelim.</p></div>
  <a class="home-btn home-btn-primary" href="<?= e(app_url('iletisim')) ?>">Projeyi Konuşalım</a>
</div></div></section>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>