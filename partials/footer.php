<?php
$siteName = setting('site_name','Vera Yapı');
$footerLogoImage = trim(setting('logo_image',''));
$phone = setting('phone','+90 500 000 00 00');
$email = setting('email','info@example.com');
$wa = preg_replace('/\D+/', '', setting('whatsapp',$phone));
?>
<footer class="home-footer"><div class="container">
<div class="home-footer-grid">
<div><a class="home-logo home-footer-logo" href="<?= e(app_url()) ?>" style="color:#fff"><?php if($footerLogoImage!==''): ?><span class="home-logo-image"><img src="<?= e(media_url($footerLogoImage)) ?>" alt="<?= e($siteName) ?> logo"></span><?php else: ?><span class="home-logo-mark" style="background:#fff;color:#102c40"><?= e(setting('logo_mark','VY')) ?></span><?php endif; ?><span><?= e($siteName) ?><small style="color:#8ea1ad"><?= e(setting('tagline','İNŞAAT & TAAHHÜT')) ?></small></span></a><p style="max-width:340px;margin-top:17px"><?= e(setting('footer_text','Konut, villa, ticari yapı, renovasyon ve anahtar teslim taahhüt projelerinde planlı ve güvenilir uygulama.')) ?></p></div>
<div><h4><?= e(setting('footer_corporate_title','Kurumsal')) ?></h4><a href="<?= e(app_url('hakkimizda')) ?>">Hakkımızda</a><a href="<?= e(app_url('projeler')) ?>">Projeler</a><a href="<?= e(app_url('blog')) ?>">Blog</a><a href="<?= e(app_url('iletisim')) ?>">İletişim</a></div>
<div><h4><?= e(setting('footer_services_title','Hizmetler')) ?></h4><?php foreach(array_slice(rows('services'),0,4) as $s): ?><a href="<?= e(app_url('hizmet/'.$s['slug'])) ?>"><?= e($s['title']) ?></a><?php endforeach; ?></div>
<div><h4><?= e(setting('footer_contact_title','İletişim')) ?></h4><p><?= e(setting('address','Alanya / Antalya')) ?></p><a href="tel:<?= e(preg_replace('/\D+/', '', $phone)) ?>"><?= e($phone) ?></a><a href="mailto:<?= e($email) ?>"><?= e($email) ?></a><a href="https://wa.me/<?= e($wa) ?>" target="_blank" rel="noopener">WhatsApp</a></div>
</div>
<div class="home-footer-bottom"><span>© <span data-year></span> <?= e($siteName) ?>. Tüm hakları saklıdır.</span><span class="home-footer-legal"><a href="<?= e(app_url('kvkk-aydinlatma-metni')) ?>">KVKK</a><a href="<?= e(app_url('gizlilik-politikasi')) ?>">Gizlilik</a><a href="<?= e(app_url('cerez-politikasi')) ?>">Çerez Politikası</a></span></div>
</div></footer>
<div class="home-float-actions" aria-label="Hızlı iletişim">
<a class="home-float home-float-phone" href="tel:<?= e(preg_replace('/\D+/', '', $phone)) ?>" aria-label="Telefonla ara"><svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.3 1.2.4 2.4.6 3.7.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.7 21 3 13.3 3 3.8c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.7.1.4 0 .8-.3 1.1l-2.2 2.2Z"/></svg></a>
<a class="home-float home-float-wa" href="https://wa.me/<?= e($wa) ?>" target="_blank" rel="noopener" aria-label="WhatsApp ile iletişim"><svg viewBox="0 0 32 32" aria-hidden="true"><path fill="currentColor" d="M16 3A13 13 0 0 0 5 22.9L3.6 29 9.8 27.6A13 13 0 1 0 16 3Zm0 23.6c-2 0-3.9-.5-5.5-1.5l-.4-.2-3.7.9.9-3.6-.2-.4A10.6 10.6 0 1 1 16 26.6Zm5.8-7.9c-.3-.2-1.9-.9-2.2-1-.3-.1-.5-.2-.7.2-.2.3-.8 1-.9 1.2-.2.2-.3.2-.7.1-1.9-.9-3.2-1.7-4.5-3.8-.3-.6.3-.6.9-1.8.1-.2.1-.4 0-.6l-1-2.4c-.3-.6-.5-.6-.7-.6h-.6c-.2 0-.6.1-.9.4-.3.3-1.2 1.2-1.2 3 0 1.8 1.3 3.5 1.5 3.8.2.2 2.6 4 6.4 5.6 3 1.3 4.2 1.4 5.7 1.2.9-.1 1.9-.8 2.2-1.5.3-.7.3-1.3.2-1.5-.1-.2-.3-.3-.6-.5Z"/></svg></a>
</div>
<div class="home-mobile-actions" aria-label="Mobil hızlı iletişim">
<a class="home-mobile-phone" href="tel:<?= e(preg_replace('/\D+/', '', $phone)) ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.3 1.2.4 2.4.6 3.7.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.7 21 3 13.3 3 3.8c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.7.1.4 0 .8-.3 1.1l-2.2 2.2Z"/></svg>Ara</a>
<a class="home-mobile-wa" href="https://wa.me/<?= e($wa) ?>" target="_blank" rel="noopener"><svg viewBox="0 0 32 32" aria-hidden="true"><path fill="currentColor" d="M16 3A13 13 0 0 0 5 22.9L3.6 29 9.8 27.6A13 13 0 1 0 16 3Zm0 23.6c-2 0-3.9-.5-5.5-1.5l-.4-.2-3.7.9.9-3.6-.2-.4A10.6 10.6 0 1 1 16 26.6Zm5.8-7.9c-.3-.2-1.9-.9-2.2-1-.3-.1-.5-.2-.7.2-.2.3-.8 1-.9 1.2-.2.2-.3.2-.7.1-1.9-.9-3.2-1.7-4.5-3.8-.3-.6.3-.6.9-1.8.1-.2.1-.4 0-.6l-1-2.4c-.3-.6-.5-.6-.7-.6h-.6c-.2 0-.6.1-.9.4-.3.3-1.2 1.2-1.2 3 0 1.8 1.3 3.5 1.5 3.8.2.2 2.6 4 6.4 5.6 3 1.3 4.2 1.4 5.7 1.2.9-.1 1.9-.8 2.2-1.5.3-.7.3-1.3.2-1.5-.1-.2-.3-.3-.6-.5Z"/></svg>WhatsApp</a>
</div>
<script src="<?= e(app_url('assets/js/home.js')) ?>?v=19" defer></script>
</body></html>
