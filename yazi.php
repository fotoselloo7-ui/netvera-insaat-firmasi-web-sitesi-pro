<?php
require_once __DIR__.'/app/bootstrap.php';
$slug=trim((string)($_GET['slug']??''));$item=one_by_slug('posts',$slug);
if(!$item){http_response_code(404);$robots='noindex';$metaTitle='Yazı Bulunamadı';include __DIR__.'/partials/header.php';echo '<main id="icerik"><section class="page-hero-modern"><div class="container"><h1>Yazı bulunamadı.</h1></div></section></main>';include __DIR__.'/partials/footer.php';exit;}
$active='blog';
$metaTitle=$item['meta_title'] ?: $item['title'];
$metaDescription=$item['meta_description'] ?: $item['excerpt'];
$canonical=seo_absolute_url($item['canonical_url']??'',app_url('blog/'.$item['slug']));
$robots=$item['robots'] ?: 'index,follow,max-image-preview:large';
$ogTitle=$item['og_title'] ?: $metaTitle;
$ogDescription=$item['og_description'] ?: $metaDescription;
$ogImage=$item['og_image'] ?: $item['cover_image'];
$ogImageAlt=$item['image_alt'] ?: $item['title'];
$ogType='article';
$authorName=$item['author_name'] ?: setting('business_legal_name',setting('site_name','Vera Yapı'));
$articlePublished=!empty($item['published_at'])?date(DATE_ATOM,strtotime($item['published_at'])):null;
$articleModified=!empty($item['updated_at'])?date(DATE_ATOM,strtotime($item['updated_at'])):$articlePublished;
$breadcrumbs=[
  ['name'=>'Ana Sayfa','url'=>app_url()],
  ['name'=>'Blog','url'=>app_url('blog')],
  ['name'=>$item['title'],'url'=>$canonical],
];
$pageSchema=[
  '@type'=>seo_clean_schema_type($item['schema_type']??'','BlogPosting'),
  '@id'=>$canonical.'#article',
  'url'=>$canonical,
  'headline'=>$item['title'],
  'description'=>$item['aio_summary'] ?: $metaDescription,
  'datePublished'=>$articlePublished,
  'dateModified'=>$articleModified,
  'author'=>['@type'=>'Person','name'=>$authorName],
  'publisher'=>['@id'=>rtrim(app_url(),'/').'#business'],
  'mainEntityOfPage'=>$canonical,
  'inLanguage'=>'tr-TR',
];
if($ogImage!=='') $pageSchema['image']=media_url($ogImage);
include __DIR__.'/partials/header.php';
?>
<main id="icerik"><section class="page-hero-modern"><div class="container"><div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><a href="<?= e(app_url('blog')) ?>">Blog</a><span>/</span><span><?= e($item['title']) ?></span></div><div class="home-kicker"><?= e($item['published_at']?date('d.m.Y',strtotime($item['published_at'])):'Rehber') ?></div><h1><?= e($item['title']) ?></h1><p><?= e($item['excerpt']) ?></p></div></section><section class="page-section"><div class="container content-layout"><article class="content-prose"><?php if($item['cover_image']): ?><img src="<?= e(media_url($item['cover_image'])) ?>" alt="<?= e($item['image_alt'] ?: $item['title']) ?>"<?php if(!empty($item['image_title'])): ?> title="<?= e($item['image_title']) ?>"<?php endif; ?> style="width:100%;aspect-ratio:16/8;object-fit:cover;border-radius:9px;margin-bottom:28px"><?php endif; ?><?php foreach(preg_split('/\R{2,}/',(string)$item['body']) as $p): ?><p><?= nl2br(e($p)) ?></p><?php endforeach; ?></article><aside class="detail-aside"><h3>Bir proje mi planlıyorsunuz?</h3><p>İhtiyacınızı paylaşın, ücretsiz ilk değerlendirme yapalım.</p><a class="home-btn home-btn-primary" href="<?= e(app_url('#teklif')) ?>">Teklif Alın</a></aside></div></section></main>
<?php include __DIR__.'/partials/footer.php'; ?>
