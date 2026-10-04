<?php
require_once __DIR__ . '/app/bootstrap.php';
$active='home';
$metaTitle=setting('seo_home_title',setting('site_name','Vera Yapı').' | Alanya İnşaat Firması');
$metaDescription=setting('meta_description');
$canonical=seo_absolute_url(setting('seo_home_canonical',''),app_url());
$robots=setting('seo_robots','index,follow,max-image-preview:large');
$ogImage=setting('seo_default_og_image','');
$ogImageAlt=setting('seo_default_image_alt',$metaTitle);
$pageSchema=[
  '@type'=>'WebPage',
  '@id'=>rtrim($canonical,'/').'#webpage',
  'url'=>$canonical,
  'name'=>$metaTitle,
  'description'=>$metaDescription,
  'isPartOf'=>['@id'=>rtrim(app_url(),'/').'#website'],
  'about'=>['@id'=>rtrim(app_url(),'/').'#business'],
  'inLanguage'=>'tr-TR',
];
if($ogImage!=='') $pageSchema['primaryImageOfPage']=media_url($ogImage);
$sliders=rows('sliders');
$stats=rows('home_stats');
$services=rows('services','is_active=1 AND is_featured=1',[],'sort_order ASC,id ASC');
$projects=rows('projects','is_active=1 AND is_featured=1',[],'sort_order ASC,id ASC');
$testimonials=rows('testimonials');
$areas=rows('service_areas');
$faqs=rows('faqs');
$posts=rows('posts','is_active=1',[],'COALESCE(published_at,created_at) DESC,id DESC');
$why=feature_group('why'); $process=feature_group('process'); $trust=feature_group('trust');
$wa=preg_replace('/\D+/','',setting('whatsapp',setting('phone')));
include __DIR__.'/partials/header.php';
?>
<main id="icerik">
<?php if($sliders): ?>
<section class="home-slider" aria-label="Öne çıkan içerikler"><div class="home-slides" data-slider>
<?php foreach($sliders as $i=>$s): ?><article class="home-slide<?= $i===0?' is-active':'' ?>"><img src="<?= e(media_url($s['image'])) ?>" alt="<?= e($s['image_alt'] ?: $s['title']) ?>"<?php if(!empty($s['image_title'])): ?> title="<?= e($s['image_title']) ?>"<?php endif; ?> <?= $i===0?'fetchpriority="high"':'loading="lazy"' ?>><div class="home-slide-overlay"></div><div class="container home-slide-content"><div class="home-slide-copy"><div class="home-eyebrow"><?= e($s['eyebrow']) ?></div><<?= $i===0?'h1':'h2' ?>><?= e($s['title']) ?></<?= $i===0?'h1':'h2' ?>><p><?= e($s['body']) ?></p><div class="home-hero-actions"><?php if($s['primary_label']): ?><a class="home-btn home-btn-primary" href="<?= e(str_starts_with((string)$s['primary_url'],'#')?$s['primary_url']:app_url((string)$s['primary_url'])) ?>"><?= e($s['primary_label']) ?></a><?php endif; ?><?php if($s['secondary_label']): ?><a class="home-btn home-btn-secondary" href="<?= e(str_starts_with((string)$s['secondary_url'],'#')?$s['secondary_url']:app_url((string)$s['secondary_url'])) ?>"><?= e($s['secondary_label']) ?></a><?php endif; ?></div></div></div></article><?php endforeach; ?>
</div><div class="container home-slider-ui"><div class="home-slider-dots"><?php foreach($sliders as $i=>$s): ?><button class="<?= $i===0?'is-active':'' ?>" type="button" aria-label="<?= $i+1 ?>. slayt" data-slide-to="<?= $i ?>"></button><?php endforeach; ?></div><div class="home-slider-arrows"><button type="button" data-slide-prev aria-label="Önceki">←</button><button type="button" data-slide-next aria-label="Sonraki">→</button></div></div></section>
<?php endif; ?>

<?php $sec=section('proof'); if($sec['is_active']): ?><section class="home-proof"><div class="container home-proof-grid"><div class="home-proof-item home-proof-intro"><strong><?= e($sec['title']) ?></strong><p><?= e($sec['body']) ?></p></div><?php foreach(array_slice($stats,0,3) as $st): ?><div class="home-proof-item"><strong><?= e($st['stat_value']) ?></strong><span><?= e($st['label']) ?></span></div><?php endforeach; ?></div></section><?php endif; ?>

<?php $sec=section('about'); if($sec['is_active']): ?><section class="home-section"><div class="container home-about-grid"><div class="home-about-photo"><img src="<?= e(media_url(setting('about_image','https://images.unsplash.com/photo-1759863468387-374e0362050a?auto=format&fit=crop&q=80&w=1400'))) ?>" alt="<?= e(setting('about_image_alt',setting('seo_default_image_alt',$sec['title']))) ?>" title="<?= e(setting('about_image_title',$sec['title'])) ?>" loading="lazy"></div><div class="home-about-copy"><div class="home-kicker"><?= e($sec['eyebrow']) ?></div><h2><?= e($sec['title']) ?></h2><p><?= e($sec['body']) ?></p><div class="home-checks"><?php foreach(array_slice($why,0,4) as $f): ?><div class="home-check"><i>✓</i><span><?= e($f['title']) ?></span></div><?php endforeach; ?></div><a class="home-btn home-btn-secondary" href="<?= e(app_url('hakkimizda')) ?>">Firmamızı Tanıyın</a></div></div></section><?php endif; ?>

<?php $sec=section('services'); if($sec['is_active']): ?><section class="home-section home-section-soft"><div class="container"><div class="home-section-head"><div><div class="home-kicker"><?= e($sec['eyebrow']) ?></div><h2><?= e($sec['title']) ?></h2></div><p><?= e($sec['body']) ?></p></div><div class="service-clean"><?php foreach(array_slice($services,0,6) as $i=>$s): ?><article><div class="service-clean-icon"><?= str_pad((string)($i+1),2,'0',STR_PAD_LEFT) ?></div><h3><a href="<?= e(app_url('hizmet/'.$s['slug'])) ?>"><?= e($s['title']) ?></a></h3><p><?= e($s['summary']) ?></p><a href="<?= e(app_url('hizmet/'.$s['slug'])) ?>">Detayları incele →</a></article><?php endforeach; ?></div></div></section><?php endif; ?>

<section class="quick-cta-wrap"><div class="container"><div class="quick-cta"><div class="quick-cta-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path fill="currentColor" d="M12 3a8 8 0 0 0-8 8c0 1.8.6 3.5 1.6 4.9L4 21l5.2-1.5A8 8 0 1 0 12 3Zm-3.4 7.2h6.8v1.6H8.6v-1.6Zm0 3h4.8v1.6H8.6v-1.6Z"/></svg></div><div class="quick-cta-copy"><h3><?= e(setting('quick_cta_1_title','Hangi hizmetin projenize uygun olduğundan emin değil misiniz?')) ?></h3><p><?= e(setting('quick_cta_1_body','Projenizi kısaca anlatın; kapsam, süreç ve doğru hizmet seçeneği hakkında hızlı bilgi verelim.')) ?></p></div><div class="quick-cta-actions"><a class="home-btn home-btn-primary" href="<?= e(app_url(setting('quick_cta_1_primary_url','iletisim'))) ?>"><?= e(setting('quick_cta_1_primary_label','Detaylı Bilgi Al')) ?></a><a class="home-btn home-btn-secondary" href="https://wa.me/<?= e($wa) ?>?text=<?= rawurlencode(setting('quick_cta_1_whatsapp_text','Merhaba Vera Yapı, projem için hangi hizmetin uygun olduğu hakkında bilgi almak istiyorum.')) ?>" target="_blank" rel="noopener"><?= e(setting('quick_cta_1_secondary_label',"WhatsApp'tan Sor")) ?></a></div></div></div></section>

<?php $sec=section('projects'); if($sec['is_active']): ?><section class="home-section"><div class="container"><div class="home-section-head"><div><div class="home-kicker"><?= e($sec['eyebrow']) ?></div><h2><?= e($sec['title']) ?></h2></div><p><?= e($sec['body']) ?></p></div><div class="projects-clean"><?php foreach(array_slice($projects,0,3) as $p): ?><article class="project-clean"><a href="<?= e(app_url('proje/'.$p['slug'])) ?>"><img src="<?= e(media_url($p['cover_image'])) ?>" alt="<?= e($p['image_alt'] ?: $p['title']) ?>"<?php if(!empty($p['image_title'])): ?> title="<?= e($p['image_title']) ?>"<?php endif; ?> loading="lazy"></a><div class="project-clean-top"><span><?= e($p['status']) ?></span><span><?= e($p['location']) ?></span></div><h3><a href="<?= e(app_url('proje/'.$p['slug'])) ?>"><?= e($p['title']) ?></a></h3><p><?= e($p['summary']) ?></p><div class="project-clean-meta"><span><?= e($p['category']) ?></span><span><?= e($p['area']) ?></span><span><?= e($p['project_year']) ?></span></div></article><?php endforeach; ?></div><div style="margin-top:24px"><a class="home-btn home-btn-secondary" href="<?= e(app_url('projeler')) ?>">Tüm Projeleri İncele</a></div></div></section><?php endif; ?>

<section class="quick-cta-wrap white"><div class="container"><div class="quick-cta quick-cta-dark"><div class="quick-cta-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path fill="currentColor" d="M7 3h10a2 2 0 0 1 2 2v14l-7-3-7 3V5a2 2 0 0 1 2-2Zm1.5 4v2H15V7H8.5Zm0 4v2H15v-2H8.5Z"/></svg></div><div class="quick-cta-copy"><h3><?= e(setting('quick_cta_2_title','Arsanız veya hazır bir projeniz mi var?')) ?></h3><p><?= e(setting('quick_cta_2_body','İlk değerlendirmeyi birlikte yapalım; yaklaşık kapsamı, uygulama modelini ve keşif sürecini netleştirelim.')) ?></p></div><div class="quick-cta-actions"><a class="home-btn home-btn-primary" href="#teklif"><?= e(setting('quick_cta_2_primary_label','Ücretsiz Keşif Planla')) ?></a><a class="home-btn home-btn-secondary" href="tel:<?= e(preg_replace('/\D+/','',setting('phone'))) ?>"><?= e(setting('quick_cta_2_secondary_label','Hemen Ara')) ?></a></div></div></div></section>

<?php $sec=section('why'); if($sec['is_active']): ?><section class="home-section home-section-dark"><div class="container why-clean"><div class="why-clean-photo"><img src="<?= e(media_url(setting('why_image','https://images.unsplash.com/photo-1780145769345-de98a1a6a982?auto=format&fit=crop&q=80&w=1400'))) ?>" alt="<?= e(setting('why_image_alt',setting('seo_default_image_alt',$sec['title']))) ?>" title="<?= e(setting('why_image_title',$sec['title'])) ?>" loading="lazy"></div><div class="why-clean-copy"><div class="home-kicker"><?= e($sec['eyebrow']) ?></div><h2><?= e($sec['title']) ?></h2><p><?= e($sec['body']) ?></p><div class="why-clean-list"><?php foreach($why as $f): ?><div class="why-clean-row"><b><?= e($f['icon']) ?></b><div><strong><?= e($f['title']) ?></strong><span><?= e($f['body']) ?></span></div></div><?php endforeach; ?></div></div></div></section><?php endif; ?>

<?php $sec=section('process'); if($sec['is_active']): ?><section class="home-section home-section-soft"><div class="container"><div class="home-section-head"><div><div class="home-kicker"><?= e($sec['eyebrow']) ?></div><h2><?= e($sec['title']) ?></h2></div><p><?= e($sec['body']) ?></p></div><div class="process-line"><?php foreach($process as $f): ?><div class="process-step"><small><?= e($f['icon']) ?></small><h3><?= e($f['title']) ?></h3><p><?= e($f['body']) ?></p></div><?php endforeach; ?></div></div></section><?php endif; ?>

<?php $sec=section('testimonials'); if($sec['is_active']): ?><section class="home-section"><div class="container"><div class="home-section-head"><div><div class="home-kicker"><?= e($sec['eyebrow']) ?></div><h2><?= e($sec['title']) ?></h2></div><p><?= e($sec['body']) ?></p></div><div class="testimonials-clean"><?php foreach(array_slice($testimonials,0,3) as $t): ?><article class="testimonial-clean"><div class="stars"><?= str_repeat('★',(int)$t['rating']) ?></div><blockquote>“<?= e($t['quote_text']) ?>”</blockquote><footer><div class="avatar"><?= e(mb_substr($t['name'],0,1)) ?></div><div><strong><?= e($t['name']) ?></strong><span><?= e($t['role']) ?></span></div></footer></article><?php endforeach; ?></div></div></section><?php endif; ?>

<?php $sec=section('trust'); if($sec['is_active'] && $trust): ?><section class="home-section home-section-soft"><div class="container"><div class="trust-strip"><div class="trust-strip-intro"><strong><?= e($sec['title']) ?></strong><span><?= e($sec['body']) ?></span></div><?php foreach(array_slice($trust,0,3) as $f): ?><div><strong><?= e($f['title']) ?></strong><span><?= e($f['body']) ?></span></div><?php endforeach; ?></div></div></section><?php endif; ?>

<?php $sec=section('areas'); if($sec['is_active']): ?><section class="home-section area-clean"><div class="container area-clean-grid"><div class="area-clean-copy"><div class="home-kicker"><?= e($sec['eyebrow']) ?></div><h2><?= e($sec['title']) ?></h2><p><?= e($sec['body']) ?></p></div><div class="area-list"><?php foreach($areas as $a): ?><a href="<?= e(app_url('bolge/'.($a['slug'] ?: slugify($a['title'])))) ?>"><strong><?= e($a['title']) ?></strong><span><?= e($a['services_text']) ?></span></a><?php endforeach; ?></div></div></section><?php endif; ?>

<?php $sec=section('blog'); if($sec['is_active']): ?>
<?php
$blogItems=array_slice($posts,0,3);
$blogFallbacks=[
  'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&q=82&w=1400',
  'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&q=80&w=700',
  'https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&q=80&w=700'
];
?>
<section class="home-section"><div class="container">
<div class="home-section-head blog-section-head"><div><div class="home-kicker"><?= e($sec['eyebrow']) ?></div><h2><?= e($sec['title']) ?></h2></div><a class="home-btn home-btn-secondary" href="<?= e(app_url('blog')) ?>">Tüm Yazılar</a></div>
<?php if($blogItems): $featured=$blogItems[0]; ?>
<div class="insights-premium">
<article class="insight-featured"><a href="<?= e(app_url('blog/'.$featured['slug'])) ?>" aria-label="<?= e($featured['title']) ?>"><img src="<?= e(media_url($featured['cover_image'] ?: $blogFallbacks[0])) ?>" alt="<?= e($featured['image_alt'] ?: $featured['title']) ?>"<?php if(!empty($featured['image_title'])): ?> title="<?= e($featured['image_title']) ?>"<?php endif; ?> loading="lazy"><div class="insight-featured-content"><time><?= e($featured['published_at']?date('d.m.Y',strtotime($featured['published_at'])):'Rehber') ?></time><h3><?= e($featured['title']) ?></h3><p><?= e($featured['excerpt']) ?></p></div></a></article>
<div class="insight-side-list">
<?php foreach(array_slice($blogItems,1,2) as $i=>$p): ?>
<article class="insight-side"><a class="insight-side-image" href="<?= e(app_url('blog/'.$p['slug'])) ?>"><img src="<?= e(media_url($p['cover_image'] ?: $blogFallbacks[$i+1])) ?>" alt="<?= e($p['image_alt'] ?: $p['title']) ?>"<?php if(!empty($p['image_title'])): ?> title="<?= e($p['image_title']) ?>"<?php endif; ?> loading="lazy"></a><div class="insight-side-content"><time><?= e($p['published_at']?date('d.m.Y',strtotime($p['published_at'])):'Rehber') ?></time><h3><a href="<?= e(app_url('blog/'.$p['slug'])) ?>"><?= e($p['title']) ?></a></h3><a class="read-more" href="<?= e(app_url('blog/'.$p['slug'])) ?>">Yazıyı oku →</a></div></article>
<?php endforeach; ?>
</div></div>
<?php endif; ?>
</div></section>
<?php endif; ?>

<?php $sec=section('faq'); if($sec['is_active']): ?><section class="home-section home-section-soft" id="teklif"><div class="container home-faq-contact"><div><div class="home-kicker"><?= e($sec['eyebrow']) ?></div><h2 style="color:var(--navy);font-size:34px;line-height:1.2;margin:7px 0 22px"><?= e($sec['title']) ?></h2><div class="home-faq"><?php foreach($faqs as $i=>$f): ?><details<?= $i===0?' open':'' ?>><summary><?= e($f['question']) ?></summary><p><?= e($f['answer']) ?></p></details><?php endforeach; ?></div></div><aside class="home-contact-card"><h3><?= e(setting('contact_title','Projenizi bize anlatın.')) ?></h3><p><?= e(setting('contact_body','Kısa bilgileri paylaşın; form sizi doğrudan WhatsApp görüşmesine yönlendirsin.')) ?></p><form class="home-form" data-home-form data-whatsapp="<?= e($wa) ?>"><div class="home-field"><label>Ad Soyad<input name="name" required></label></div><div class="home-field"><label>Telefon<input name="phone" required inputmode="tel"></label></div><div class="home-field"><label>Proje Türü<select name="type"><option>Konut / Villa</option><option>Ticari Yapı</option><option>Anahtar Teslim</option><option>Renovasyon</option></select></label></div><div class="home-field"><label>Konum<input name="location"></label></div><div class="home-field full"><label>Kısa Proje Bilgisi<textarea name="message"></textarea></label></div><div class="home-field full"><button class="home-btn home-btn-primary" type="submit">WhatsApp'tan Teklif İste</button></div><div class="home-field full"><p class="home-form-note" data-form-note>Gönder butonu WhatsApp mesajını hazırlar.</p></div></form></aside></div></section><?php endif; ?>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>
