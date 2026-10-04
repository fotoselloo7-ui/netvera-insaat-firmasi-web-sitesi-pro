<?php
require_once __DIR__.'/app/bootstrap.php';

$slug=trim((string)($_GET['slug'] ?? ''));
$page=$slug!=='' ? one_by_slug('pages',$slug) : null;
if(!$page){
  http_response_code(404);
  include __DIR__.'/404.html';
  exit;
}

$active='';
$metaTitle=$page['meta_title'] ?: $page['title'];
$metaDescription=$page['meta_description'] ?: ($page['intro'] ?: $page['title']);
$canonical=seo_absolute_url($page['canonical_url']??'',app_url($page['slug']));
$robots=$page['robots'] ?: 'index,follow,max-image-preview:large';
$ogTitle=$page['og_title'] ?: $metaTitle;
$ogDescription=$page['og_description'] ?: $metaDescription;
$ogImage=$page['og_image'] ?: ($page['hero_image'] ?: setting('seo_default_og_image',''));
$ogImageAlt=$page['image_alt'] ?: $page['title'];
$breadcrumbs=[
  ['name'=>'Ana Sayfa','url'=>app_url()],
  ['name'=>$page['title'],'url'=>$canonical]
];
$pageSchema=[
  '@type'=>seo_clean_schema_type($page['schema_type']??'','WebPage'),
  '@id'=>$canonical.'#webpage',
  'url'=>$canonical,
  'name'=>$page['title'],
  'description'=>$page['aio_summary'] ?: $metaDescription,
  'about'=>['@id'=>rtrim(app_url(),'/').'#business'],
  'inLanguage'=>'tr-TR',
];
if($ogImage!=='') $pageSchema['primaryImageOfPage']=media_url($ogImage);
include __DIR__.'/partials/header.php';
?>
<main id="icerik">
<section class="page-hero-modern legal-hero">
  <div class="container">
    <div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><span><?= e($page['title']) ?></span></div>
    <div class="home-kicker"><?= e($page['eyebrow'] ?: 'Yasal Bilgilendirme') ?></div>
    <h1><?= e($page['title']) ?></h1>
    <?php if(!empty($page['intro'])): ?><p><?= e($page['intro']) ?></p><?php endif; ?>
  </div>
</section>

<section class="page-section">
  <div class="container legal-layout">
    <aside class="legal-aside">
      <span>VERA YAPI</span>
      <h2>Şeffaflık ve veri güvenliği.</h2>
      <p>Bu sayfadaki metinler yönetim panelindeki <strong>Sayfalar / Landing</strong> modülünden güncellenebilir.</p>
      <div class="legal-meta">
        <small>İletişim</small>
        <a href="mailto:<?= e(setting('email','info@example.com')) ?>"><?= e(setting('email','info@example.com')) ?></a>
        <small>Adres</small>
        <span><?= e(setting('address','Alanya / Antalya')) ?></span>
      </div>
    </aside>

    <article class="legal-content">
      <?= render_content_blocks((string)$page['body']) ?>
    </article>
  </div>
</section>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>
