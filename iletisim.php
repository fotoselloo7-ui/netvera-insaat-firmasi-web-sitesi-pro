<?php
require_once __DIR__.'/app/bootstrap.php';
$page=one_by_slug('pages','iletisim') ?: ['eyebrow'=>'İletişim','title'=>'Projenizi birlikte değerlendirelim.','intro'=>'Konut, villa, ticari yapı, taahhüt veya renovasyon ihtiyacınız için bize ulaşın.','body'=>'','meta_title'=>'İletişim','meta_description'=>''];
$active='contact';$metaTitle=$page['meta_title'] ?: $page['title'];$metaDescription=$page['meta_description'] ?: $page['intro'];
$canonical=seo_absolute_url($page['canonical_url']??'',app_url('iletisim'));$robots=$page['robots'] ?: 'index,follow,max-image-preview:large';
$ogTitle=$page['og_title'] ?: $metaTitle;$ogDescription=$page['og_description'] ?: $metaDescription;$ogImage=$page['og_image'] ?: ($page['hero_image'] ?? '');$ogImageAlt=$page['image_alt'] ?: $page['title'];
$breadcrumbs=[['name'=>'Ana Sayfa','url'=>app_url()],['name'=>'İletişim','url'=>$canonical]];
$pageSchema=['@type'=>seo_clean_schema_type($page['schema_type']??'','ContactPage'),'@id'=>$canonical.'#webpage','url'=>$canonical,'name'=>$page['title'],'description'=>$page['aio_summary'] ?: $metaDescription,'about'=>['@id'=>rtrim(app_url(),'/').'#business'],'inLanguage'=>'tr-TR'];
$wa=preg_replace('/\D+/','',setting('whatsapp',setting('phone')));
$mapEmbed=google_maps_embed_url(setting('google_maps_url',''),setting('address','Alanya / Antalya'));
$socials=[
  ['key'=>'instagram_url','label'=>'Instagram','class'=>'instagram'],
  ['key'=>'facebook_url','label'=>'Facebook','class'=>'facebook'],
  ['key'=>'twitter_url','label'=>'X / Twitter','class'=>'twitter'],
  ['key'=>'youtube_url','label'=>'YouTube','class'=>'youtube'],
];
include __DIR__.'/partials/header.php';
?>
<main id="icerik">
<section class="page-hero-modern"><div class="container">
  <div class="page-breadcrumb"><a href="<?= e(app_url()) ?>">Ana Sayfa</a><span>/</span><span>İletişim</span></div>
  <div class="home-kicker"><?= e($page['eyebrow']) ?></div><h1><?= e($page['title']) ?></h1><p><?= e($page['intro']) ?></p>
</div></section>

<section class="page-section" id="teklif"><div class="container contact-premium-grid">
  <aside class="contact-panel">
    <div class="home-kicker">Doğrudan İletişim</div><h2>Doğru bilgiyle başlayalım.</h2><p>İlk görüşme satış konuşması değil; proje kapsamını anlamak için kısa bir ön değerlendirmedir.</p>
    <a class="contact-channel" href="tel:<?= e(preg_replace('/\D+/','',setting('phone'))) ?>"><i>01</i><span><small>Telefon</small><strong><?= e(setting('phone')) ?></strong></span></a>
    <a class="contact-channel" href="https://wa.me/<?= e($wa) ?>" target="_blank" rel="noopener"><i>02</i><span><small>WhatsApp</small><strong>Hızlı proje bilgisi gönderin</strong></span></a>
    <a class="contact-channel" href="mailto:<?= e(setting('email')) ?>"><i>03</i><span><small>E-posta</small><strong><?= e(setting('email')) ?></strong></span></a>
    <div class="contact-channel"><i>04</i><span><small>Konum</small><strong><?= e(setting('address')) ?></strong></span></div>
    <div class="contact-social-block">
      <span class="contact-social-label">Sosyal Medya</span>
      <div class="contact-socials">
        <?php foreach($socials as $social): $url=trim(setting($social['key'],'')); ?>
          <?php if($url!==''): ?><a class="contact-social-btn is-<?= e($social['class']) ?>" href="<?= e($url) ?>" target="_blank" rel="noopener" aria-label="<?= e($social['label']) ?>">
            <span><?= e($social['label']) ?></span>
          </a><?php else: ?><span class="contact-social-btn is-<?= e($social['class']) ?> is-disabled" aria-label="<?= e($social['label']) ?> bağlantısı admin panelden eklenebilir"><span><?= e($social['label']) ?></span></span><?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </aside>
  <div class="contact-form-shell">
    <div class="home-kicker">Proje Formu</div><h2>Bize birkaç net bilgi verin.</h2><p>Form, bilgilerinizi hazır bir WhatsApp mesajına dönüştürür; gereksiz kayıt süreci yok.</p>
    <form class="contact-form-light" data-home-form data-whatsapp="<?= e($wa) ?>">
      <label>Ad Soyad<input name="name" required autocomplete="name"></label>
      <label>Telefon<input name="phone" required autocomplete="tel"></label>
      <label>Proje Türü<select name="type"><option>Konut / Villa</option><option>Ticari Yapı</option><option>Anahtar Teslim</option><option>Renovasyon</option><option>Proje Uygulama</option></select></label>
      <label>Konum<input name="location" placeholder="Alanya, Oba, Mahmutlar..."></label>
      <label class="full">Proje Bilgisi<textarea name="message" placeholder="Yaklaşık alan, mevcut proje durumu, hedef tarih veya özellikle konuşmak istediğiniz konu..."></textarea></label>
      <div class="full"><button class="home-btn home-btn-primary" type="submit">WhatsApp'tan Talep Gönder</button><p class="home-form-note" data-form-note></p></div>
    </form>
  </div>
</div></section>

<?php if($mapEmbed!==''): ?>
<section class="contact-map-section">
  <div class="container">
    <div class="contact-map-head">
      <div><div class="home-kicker">Konum</div><h2>Bizi haritada görün.</h2></div>
      <p>Ofis veya proje görüşmesi öncesinde konumumuzu haritadan inceleyebilirsiniz.</p>
    </div>
    <div class="contact-map-frame">
      <iframe src="<?= e($mapEmbed) ?>" title="<?= e(setting('site_name','Vera Yapı')) ?> Google Harita konumu" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="page-section soft"><div class="container">
  <div class="page-title-row"><div><div class="home-kicker">Sonraki Adım</div><h2>İlk temastan sonra ne olur?</h2></div><p>Süreci mümkün olduğunca kısa, açık ve karar vermeyi kolaylaştıran bir akışta tutuyoruz.</p></div>
  <div class="contact-expectation">
    <div><small>01</small><strong>Ön değerlendirme</strong><p>Proje türü, konum ve ihtiyaç çerçevesi netleşir.</p></div>
    <div><small>02</small><strong>Keşif / teknik görüşme</strong><p>Gerekliyse saha veya proje dokümanı üzerinden detaylandırılır.</p></div>
    <div><small>03</small><strong>Kapsam & teklif</strong><p>İş kalemleri, yaklaşım ve sonraki adımlar anlaşılır biçimde sunulur.</p></div>
  </div>
</div></section>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>