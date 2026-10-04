<?php
require_once __DIR__.'/app/bootstrap.php';
$slug=trim((string)($_GET['slug']??''));$item=one_by_slug('posts',$slug);
if(!$item){http_response_code(404);$robots='noindex';$metaTitle='Yazı Bulunamadı';include __DIR__.'/partials/header.php';echo '<main id="icerik"><section class="page-hero-modern"><div class="container"><h1>Yazı bulunamadı.</h1></div></section></main>';include __DIR__.'/partials/footer.php';exit;}
$active='blog';$metaTitle=$item['meta_title'] ?: $item['title'];$metaDescription=$item['meta_description'] ?: $item['excerpt'];
$canonical=seo_absolute_url($item['canonical_url']??'',app_url('blog/'.$item['slug']));$robots=$item['robots'] ?: 'index,follow,max-image-preview:large';
$ogTitle=$item['og_title'] ?: $metaTitle;$ogDescription=$item['og_description'] ?: $metaDescription;$ogImage=$item['og_image'] ?: $item['cover_image'];$ogImageAlt=$item['image_alt'] ?: $item['title'];$ogType='article';
$authorName=$item['author_name'] ?: setting('business_legal_name',setting('site_name','Vera Yapı'));
$articlePublished=!empty($item['published_at'])?date(DATE_ATOM,strtotime($item['published_at'])):null;$articleModified=!empty($item['updated_at'])?date(DATE_ATOM,strtotime($item['updated_at'])):$articlePublished;
$breadcrumbs=[['name'=>'Ana Sayfa','url'=>app_url()],['name'=>'Blog','url'=>app_url('blog')],['name'=>$item['title'],'url'=>$canonical]];
$pageSchema=['@type'=>seo_clean_schema_type($item['schema_type']??'','BlogPosting'),'@id'=>$canonical.'#article','url'=>$canonical,'headline'=>$item['title'],'description'=>$item['aio_summary'] ?: $metaDescription,'datePublished'=>$articlePublished,'dateModified'=>$articleModified,'author'=>['@type'=>'Person','name'=>$authorName],'publisher'=>['@id'=>rtrim(app_url(),'/').'#business'],'mainEntityOfPage'=>$canonical,'inLanguage'=>'tr-TR'];
if($ogImage!=='') $pageSchema['image']=media_url($ogImage);
$reading=estimated_reading_minutes((string)$item['body']);
$related=array_values(array_filter(rows('posts','is_active=1',[],'COALESCE(published_at,created_at) DESC,id DESC'),fn($p)=>(int)$p['id']!==(int)$item['id']));$related=array_slice($related,0,3);
$headingMatches=[];preg_match_all('/^##\s+(.+)$/m',(string)$item['body'],$headingMatches);
$secDecision=page_section('yazi-detay','decision');
$secRelated=page_section('yazi-detay','related');
include __DIR__.'/partials/header.php';
?>
<main id="icerik">
<section class="article-hero"><div class="container article-hero-inner">
  <div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><a href="<?= e(app_url('blog')) ?>">Blog</a><span>/</span><span>Rehber</span></div>
  <div class="home-kicker">Bilgi Merkezi</div><h1><?= e($item['title']) ?></h1><p class="article-deck"><?= e($item['excerpt']) ?></p>
  <div class="article-meta"><strong><?= e($authorName) ?></strong><span>•</span><span><?= e($item['published_at']?date('d.m.Y',strtotime($item['published_at'])):'Güncel') ?></span><span>•</span><span><?= $reading ?> dk okuma</span><?php if($item['geo_target']): ?><span>•</span><span><?= e($item['geo_target']) ?></span><?php endif; ?></div>
</div></section>

<?php if($item['cover_image']): ?><div class="article-cover"><img src="<?= e(media_url($item['cover_image'])) ?>" alt="<?= e($item['image_alt'] ?: $item['title']) ?>"<?php if(!empty($item['image_title'])): ?> title="<?= e($item['image_title']) ?>"<?php endif; ?>></div><?php endif; ?>

<section class="page-section"><div class="container article-shell">
  <nav class="article-rail" aria-label="Yazı içeriği"><div class="article-rail-title">Bu yazıda</div><?php if($headingMatches && !empty($headingMatches[1])): foreach($headingMatches[1] as $h): ?><span><?= e($h) ?></span><?php endforeach; else: ?><span>Temel değerlendirme</span><span>Kontrol noktaları</span><span>Son karar</span><?php endif; ?></nav>
  <article class="article-body"><p class="article-lead"><?= e($item['aio_summary'] ?: $item['excerpt']) ?></p><div class="article-callout"><strong>Kısa cevap</strong><?= e($item['excerpt']) ?></div><?= render_content_blocks((string)$item['body']) ?>
    <?php if((int)$secDecision['is_active']===1): ?><h2><?= e($secDecision['title']) ?></h2><p><?= e($secDecision['body']) ?></p><?php endif; ?>
  </article>
  <aside class="article-aside"><div class="article-author"><div class="avatar"><?= e(mb_strtoupper(mb_substr($authorName,0,1))) ?></div><strong><?= e($authorName) ?></strong><p>İnşaat, taahhüt ve proje uygulama deneyiminden derlenen pratik rehber.</p></div><a class="home-btn home-btn-primary" href="<?= e(app_url('iletisim')) ?>">Projenizi Sorun</a></aside>
</div></section>

<?php if($related && (int)$secRelated['is_active']===1): ?><section class="page-section soft"><div class="container"><div class="page-title-row"><div><div class="home-kicker"><?= e($secRelated['eyebrow']) ?></div><h2><?= e($secRelated['title']) ?></h2></div></div><div class="article-related"><?php foreach($related as $p): ?><a class="list-card" href="<?= e(app_url('blog/'.$p['slug'])) ?>"><small><?= e($p['published_at']?date('d.m.Y',strtotime($p['published_at'])):'Rehber') ?></small><h3><?= e($p['title']) ?></h3><p><?= e($p['excerpt']) ?></p></a><?php endforeach; ?></div></div></section><?php endif; ?>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>