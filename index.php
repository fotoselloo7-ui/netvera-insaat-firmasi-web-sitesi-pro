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

<?php $sec=section('proof'); if($sec['is_active']): ?>
<section class="home-proof-v5">
  <div class="container proof-v5-grid">
    <div class="proof-v5-copy"><strong><?= e($sec['title']) ?></strong><p><?= e($sec['body']) ?></p></div>
    <?php foreach(array_slice($stats,0,3) as $st): ?>
      <div class="proof-v5-stat"><strong><?= e($st['stat_value']) ?></strong><span><?= e($st['label']) ?></span></div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php $sec=section('about'); if($sec['is_active']): ?>
<section class="home-section about-editorial-v5">
  <div class="container about-editorial-grid">
    <figure class="about-editorial-media">
      <img src="<?= e(media_url(setting('about_image','https://images.unsplash.com/photo-1759863468387-374e0362050a?auto=format&fit=crop&q=80&w=1400'))) ?>" alt="<?= e(setting('about_image_alt',setting('seo_default_image_alt',$sec['title']))) ?>" title="<?= e(setting('about_image_title',$sec['title'])) ?>" loading="lazy">
      <figcaption>Planlama · Uygulama · Teslim</figcaption>
    </figure>
    <div class="about-editorial-copy">
      <div class="home-kicker"><?= e($sec['eyebrow']) ?></div>
      <h2><?= e($sec['title']) ?></h2>
      <p class="about-lead"><?= e($sec['body']) ?></p>
      <div class="about-principles">
        <?php foreach(array_slice($why,0,4) as $i=>$f): ?>
          <div class="about-principle">
            <span><?= str_pad((string)($i+1),2,'0',STR_PAD_LEFT) ?></span>
            <div><strong><?= e($f['title']) ?></strong><p><?= e($f['body']) ?></p></div>
          </div>
        <?php endforeach; ?>
      </div>
      <a class="text-link-v5" href="<?= e(app_url('hakkimizda')) ?>">Firmamızı tanıyın
        <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M5 10h9M10.5 6.5 14 10l-3.5 3.5"/></svg>
      </a>
    </div>
  </div>
</section>
<?php endif; ?>

<?php $sec=section('services'); if($sec['is_active']): ?>
<section class="home-section services-editorial-v6">
  <div class="container">
    <div class="services-head-v6">
      <div>
        <div class="home-kicker"><?= e($sec['eyebrow']) ?></div>
        <h2><?= e($sec['title']) ?></h2>
      </div>
      <p><?= e($sec['body']) ?></p>
    </div>
    <div class="services-list-v6">
      <?php foreach(array_slice($services,0,6) as $i=>$s): ?>
        <a class="service-row-v6" href="<?= e(app_url('hizmet/'.$s['slug'])) ?>">
          <span class="service-row-number"><?= str_pad((string)($i+1),2,'0',STR_PAD_LEFT) ?></span>
          <div class="service-row-copy"><h3><?= e($s['title']) ?></h3><p><?= e($s['summary']) ?></p></div>
          <span class="service-row-action" aria-hidden="true">
            <svg viewBox="0 0 20 20"><path d="M6 10h7M10.5 7.5 13 10l-2.5 2.5"/></svg>
          </span>
        </a>
      <?php endforeach; ?>
    </div>
    <div class="services-foot-v6"><a class="micro-link-v6" href="<?= e(app_url('hizmetler')) ?>">Tüm hizmetler <span aria-hidden="true">›</span></a></div>
  </div>
</section>
<?php endif; ?>

<section class="home-cta-line-v5"><div class="container home-cta-line-inner">
  <div><strong><?= e(setting('quick_cta_1_title','Projeniz için doğru hizmeti birlikte belirleyelim.')) ?></strong><span><?= e(setting('quick_cta_1_body','Kapsamı netleştirelim, sonra teklif konuşalım.')) ?></span></div>
  <div class="home-cta-line-actions">
    <a class="home-btn home-btn-primary" href="<?= e(app_url(setting('quick_cta_1_primary_url','iletisim'))) ?>"><?= e(setting('quick_cta_1_primary_label','Detaylı Bilgi Al')) ?></a>
    <a class="text-link-v5" href="https://wa.me/<?= e($wa) ?>?text=<?= rawurlencode(setting('quick_cta_1_whatsapp_text','Merhaba Vera Yapı, projem hakkında bilgi almak istiyorum.')) ?>" target="_blank" rel="noopener"><?= e(setting('quick_cta_1_secondary_label',"WhatsApp'tan Sor")) ?>
      <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M5 10h9M10.5 6.5 14 10l-3.5 3.5"/></svg>
    </a>
  </div>
</div></section>

<?php $sec=section('projects'); if($sec['is_active']): ?>
<section class="home-section projects-editorial-v5">
  <div class="container">
    <div class="home-section-head-v5">
      <div><div class="home-kicker"><?= e($sec['eyebrow']) ?></div><h2><?= e($sec['title']) ?></h2></div>
      <p><?= e($sec['body']) ?></p>
    </div>
    <?php $homeProjects=array_slice($projects,0,3); $fp=$homeProjects[0]??null; ?>
    <?php if($fp): ?>
    <div class="projects-layout-v5">
      <a class="project-featured-v5" href="<?= e(app_url('proje/'.$fp['slug'])) ?>">
        <img src="<?= e(media_url($fp['cover_image'])) ?>" alt="<?= e($fp['image_alt'] ?: $fp['title']) ?>" loading="lazy">
        <div class="project-caption-v5">
          <div><span><?= e($fp['status']) ?> · <?= e($fp['location']) ?></span><h3><?= e($fp['title']) ?></h3></div>
          <small><?= e($fp['category']) ?> · <?= e($fp['area']) ?> · <?= e($fp['project_year']) ?></small>
        </div>
      </a>
      <div class="project-side-stack-v5">
        <?php foreach(array_slice($homeProjects,1,2) as $p): ?>
          <a class="project-side-v5" href="<?= e(app_url('proje/'.$p['slug'])) ?>">
            <img src="<?= e(media_url($p['cover_image'])) ?>" alt="<?= e($p['image_alt'] ?: $p['title']) ?>" loading="lazy">
            <div><span><?= e($p['status']) ?> · <?= e($p['location']) ?></span><h3><?= e($p['title']) ?></h3><small><?= e($p['category']) ?> · <?= e($p['area']) ?></small></div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
    <div class="projects-footer-v5"><a class="text-link-v5" href="<?= e(app_url('projeler')) ?>">Tüm projeleri inceleyin
      <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M5 10h9M10.5 6.5 14 10l-3.5 3.5"/></svg>
    </a></div>
  </div>
</section>
<?php endif; ?>

<section class="home-cta-line-v5 is-dark"><div class="container home-cta-line-inner">
  <div><strong><?= e(setting('quick_cta_2_title','Arsanız veya hazır bir projeniz mi var?')) ?></strong><span><?= e(setting('quick_cta_2_body','İlk değerlendirmeyi birlikte yapalım.')) ?></span></div>
  <div class="home-cta-line-actions">
    <a class="home-btn home-btn-primary" href="#teklif"><?= e(setting('quick_cta_2_primary_label','Ücretsiz Keşif Planla')) ?></a>
    <a class="text-link-v5 is-light" href="tel:<?= e(preg_replace('/\D+/','',setting('phone'))) ?>"><?= e(setting('quick_cta_2_secondary_label','Hemen Ara')) ?>
      <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M5 10h9M10.5 6.5 14 10l-3.5 3.5"/></svg>
    </a>
  </div>
</div></section>

<?php $sec=section('why'); if($sec['is_active']): ?>
<section class="home-section home-section-dark why-editorial-v5">
  <div class="container why-editorial-grid">
    <figure class="why-editorial-media"><img src="<?= e(media_url(setting('why_image','https://images.unsplash.com/photo-1780145769345-de98a1a6a982?auto=format&fit=crop&q=80&w=1400'))) ?>" alt="<?= e(setting('why_image_alt',setting('seo_default_image_alt',$sec['title']))) ?>" title="<?= e(setting('why_image_title',$sec['title'])) ?>" loading="lazy"></figure>
    <div class="why-editorial-copy">
      <div class="home-kicker"><?= e($sec['eyebrow']) ?></div>
      <h2><?= e($sec['title']) ?></h2>
      <p><?= e($sec['body']) ?></p>
      <div class="why-list-v5">
        <?php foreach($why as $i=>$f): ?>
          <div class="why-row-v5"><span><?= str_pad((string)($i+1),2,'0',STR_PAD_LEFT) ?></span><div><strong><?= e($f['title']) ?></strong><p><?= e($f['body']) ?></p></div></div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php $sec=section('process'); if($sec['is_active']): ?>
<section class="home-section process-editorial-v6">
  <div class="container">
    <div class="home-section-head-v6">
      <div><div class="home-kicker"><?= e($sec['eyebrow']) ?></div><h2><?= e($sec['title']) ?></h2></div>
      <p><?= e($sec['body']) ?></p>
    </div>
    <div class="process-grid-v6">
      <?php foreach($process as $i=>$f): ?>
        <article class="process-card-v6">
          <span class="process-no-v6"><?= str_pad((string)($i+1),2,'0',STR_PAD_LEFT) ?></span>
          <h3><?= e($f['title']) ?></h3>
          <p><?= e($f['body']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php $testimonialSec=section('testimonials'); $trustSec=section('trust'); $areasSec=section('areas'); if($testimonialSec['is_active'] || ($trustSec['is_active'] && $trust) || $areasSec['is_active']): ?>
<section class="home-section reputation-v6">
  <div class="container">
    <?php if($testimonialSec['is_active']): ?>
      <div class="home-section-head-v6">
        <div><div class="home-kicker"><?= e($testimonialSec['eyebrow']) ?></div><h2><?= e($testimonialSec['title']) ?></h2></div>
        <p><?= e($testimonialSec['body']) ?></p>
      </div>
      <?php $tts=array_slice($testimonials,0,3); $mainT=$tts[0]??null; ?>
      <?php if($mainT): ?>
      <div class="testimonials-grid-v6">
        <blockquote class="testimonial-main-v6">
          <span class="quote-v6">“</span>
          <p><?= e($mainT['quote_text']) ?></p>
          <footer><strong><?= e($mainT['name']) ?></strong><span><?= e($mainT['role']) ?></span></footer>
        </blockquote>
        <div class="testimonial-side-v6">
          <?php foreach(array_slice($tts,1,2) as $t): ?>
            <blockquote><p>“<?= e($t['quote_text']) ?>”</p><footer><strong><?= e($t['name']) ?></strong><span><?= e($t['role']) ?></span></footer></blockquote>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>
    <?php endif; ?>

    <div class="trust-region-v6">
      <?php if($trustSec['is_active'] && $trust): ?>
      <article class="trust-panel-v6">
        <div class="home-kicker"><?= e($trustSec['eyebrow']) ?></div>
        <h3><?= e($trustSec['title']) ?></h3>
        <p><?= e($trustSec['body']) ?></p>
        <div class="trust-list-v6">
          <?php foreach(array_slice($trust,0,3) as $i=>$f): ?>
            <div><span><?= str_pad((string)($i+1),2,'0',STR_PAD_LEFT) ?></span><p><strong><?= e($f['title']) ?></strong><small><?= e($f['body']) ?></small></p></div>
          <?php endforeach; ?>
        </div>
      </article>
      <?php endif; ?>

      <?php if($areasSec['is_active']): ?>
      <article class="region-panel-v6">
        <div class="home-kicker"><?= e($areasSec['eyebrow']) ?></div>
        <h3><?= e($areasSec['title']) ?></h3>
        <p><?= e($areasSec['body']) ?></p>
        <div class="region-links-v6">
          <?php foreach($areas as $a): ?>
            <a href="<?= e(app_url('bolge/'.($a['slug'] ?: slugify($a['title'])))) ?>"><span><strong><?= e($a['title']) ?></strong><small><?= e($a['services_text']) ?></small></span><b>›</b></a>
          <?php endforeach; ?>
        </div>
      </article>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

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
<div class="home-section-head blog-section-head"><div><div class="home-kicker"><?= e($sec['eyebrow']) ?></div><h2><?= e($sec['title']) ?></h2></div><a class="micro-link-v6" href="<?= e(app_url('blog')) ?>">Tüm Yazılar <span aria-hidden="true">›</span></a></div>
<?php if($blogItems): $featured=$blogItems[0]; ?>
<div class="insights-premium">
<article class="insight-featured"><a href="<?= e(app_url('blog/'.$featured['slug'])) ?>" aria-label="<?= e($featured['title']) ?>"><img src="<?= e(media_url($featured['cover_image'] ?: $blogFallbacks[0])) ?>" alt="<?= e($featured['image_alt'] ?: $featured['title']) ?>"<?php if(!empty($featured['image_title'])): ?> title="<?= e($featured['image_title']) ?>"<?php endif; ?> loading="lazy"><div class="insight-featured-content"><time><?= e($featured['published_at']?date('d.m.Y',strtotime($featured['published_at'])):'Rehber') ?></time><h3><?= e($featured['title']) ?></h3><p><?= e($featured['excerpt']) ?></p></div></a></article>
<div class="insight-side-list">
<?php foreach(array_slice($blogItems,1,2) as $i=>$p): ?>
<article class="insight-side"><a class="insight-side-image" href="<?= e(app_url('blog/'.$p['slug'])) ?>"><img src="<?= e(media_url($p['cover_image'] ?: $blogFallbacks[$i+1])) ?>" alt="<?= e($p['image_alt'] ?: $p['title']) ?>"<?php if(!empty($p['image_title'])): ?> title="<?= e($p['image_title']) ?>"<?php endif; ?> loading="lazy"></a><div class="insight-side-content"><time><?= e($p['published_at']?date('d.m.Y',strtotime($p['published_at'])):'Rehber') ?></time><h3><a href="<?= e(app_url('blog/'.$p['slug'])) ?>"><?= e($p['title']) ?></a></h3><a class="micro-link-v6 read-more-v6" href="<?= e(app_url('blog/'.$p['slug'])) ?>">Yazıyı oku <span aria-hidden="true">›</span></a></div></article>
<?php endforeach; ?>
</div></div>
<?php endif; ?>
</div></section>
<?php endif; ?>

<?php $sec=section('faq'); if($sec['is_active']): ?>
<section class="home-section home-section-soft faq-contact-v5" id="teklif">
  <div class="container faq-contact-grid-v5">
    <div class="faq-column-v5">
      <div class="home-kicker"><?= e($sec['eyebrow']) ?></div>
      <h2><?= e($sec['title']) ?></h2>
      <div class="home-faq faq-v5"><?php foreach($faqs as $i=>$f): ?><details<?= $i===0?' open':'' ?>><summary><?= e($f['question']) ?></summary><p><?= e($f['answer']) ?></p></details><?php endforeach; ?></div>
    </div>
    <aside class="contact-panel-v5">
      <div class="home-kicker is-light">Proje Görüşmesi</div>
      <h3><?= e(setting('contact_title','Projenizi bize anlatın.')) ?></h3>
      <p><?= e(setting('contact_body','Kısa bilgileri paylaşın; form sizi doğrudan WhatsApp görüşmesine yönlendirsin.')) ?></p>
      <form class="home-form form-v5" data-home-form data-whatsapp="<?= e($wa) ?>">
        <div class="home-field"><label>Ad Soyad<input name="name" required></label></div>
        <div class="home-field"><label>Telefon<input name="phone" required inputmode="tel"></label></div>
        <div class="home-field"><label>Proje Türü<select name="type"><option>Konut / Villa</option><option>Ticari Yapı</option><option>Anahtar Teslim</option><option>Renovasyon</option></select></label></div>
        <div class="home-field"><label>Konum<input name="location"></label></div>
        <div class="home-field full"><label>Kısa Proje Bilgisi<textarea name="message"></textarea></label></div>
        <div class="home-field full"><button class="home-btn home-btn-primary" type="submit">WhatsApp'tan Teklif İste</button></div>
        <div class="home-field full"><p class="home-form-note" data-form-note>Gönder butonu WhatsApp mesajını hazırlar.</p></div>
      </form>
      <div class="social-contact-v6">
        <a class="social-btn-v6 is-call" href="tel:<?= e(preg_replace('/\D+/','',setting('phone'))) ?>">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.3 1.2.4 2.4.6 3.7.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.7 21 3 13.3 3 3.8c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.7.1.4 0 .8-.3 1.1l-2.2 2.2Z"/></svg>
          Hemen ara
        </a>
        <a class="social-btn-v6 is-whatsapp" href="https://wa.me/<?= e($wa) ?>?text=<?= rawurlencode('Merhaba Vera Yapı, projem hakkında bilgi almak istiyorum.') ?>" target="_blank" rel="noopener">
          <svg viewBox="0 0 32 32" aria-hidden="true"><path d="M16 3A13 13 0 0 0 5 22.9L3.6 29 9.8 27.6A13 13 0 1 0 16 3Zm0 23.6c-2 0-3.9-.5-5.5-1.5l-.4-.2-3.7.9.9-3.6-.2-.4A10.6 10.6 0 1 1 16 26.6Z"/></svg>
          WhatsApp
        </a>
        <?php if($instagram!==''): ?><a class="social-btn-v6 is-instagram" href="<?= e($instagram) ?>" target="_blank" rel="noopener">
          <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg>
          Instagram
        </a><?php endif; ?>
        <?php if($facebook!==''): ?><a class="social-btn-v6 is-facebook" href="<?= e($facebook) ?>" target="_blank" rel="noopener">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 8h3V4h-3c-3 0-5 2-5 5v3H6v4h3v5h4v-5h3l1-4h-4V9c0-.7.3-1 1-1Z"/></svg>
          Facebook
        </a><?php endif; ?>
      </div>
    </aside>
  </div>
</section>
<?php endif; ?>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>
