<?php
$siteName = setting('site_name','Vera Yapı');
$phone = setting('phone','+90 500 000 00 00');
$email = setting('email','info@example.com');
$wa = preg_replace('/\D+/', '', setting('whatsapp',$phone));
?>
<footer class="home-footer"><div class="container">
<div class="home-footer-grid">
<div><a class="home-logo" href="<?= e(app_url()) ?>" style="color:#fff"><span class="home-logo-mark" style="background:#fff;color:#102c40"><?= e(setting('logo_mark','VY')) ?></span><span><?= e($siteName) ?><small style="color:#8ea1ad"><?= e(setting('tagline','İNŞAAT & TAAHHÜT')) ?></small></span></a><p style="max-width:340px;margin-top:17px"><?= e(setting('footer_text','Konut, villa, ticari yapı, renovasyon ve anahtar teslim taahhüt projelerinde planlı ve güvenilir uygulama.')) ?></p></div>
<div><h4>Kurumsal</h4><a href="<?= e(app_url('hakkimizda')) ?>">Hakkımızda</a><a href="<?= e(app_url('projeler')) ?>">Projeler</a><a href="<?= e(app_url('blog')) ?>">Blog</a><a href="<?= e(app_url('iletisim')) ?>">İletişim</a></div>
<div><h4>Hizmetler</h4><?php foreach(array_slice(rows('services'),0,4) as $s): ?><a href="<?= e(app_url('hizmet/'.$s['slug'])) ?>"><?= e($s['title']) ?></a><?php endforeach; ?></div>
<div><h4>İletişim</h4><p><?= e(setting('address','Alanya / Antalya')) ?></p><a href="tel:<?= e(preg_replace('/\D+/', '', $phone)) ?>"><?= e($phone) ?></a><a href="mailto:<?= e($email) ?>"><?= e($email) ?></a><a href="https://wa.me/<?= e($wa) ?>" target="_blank" rel="noopener">WhatsApp</a></div>
</div>
<div class="home-footer-bottom"><span>© <span data-year></span> <?= e($siteName) ?>. Tüm hakları saklıdır.</span><span>KVKK • Gizlilik • Çerez Politikası</span></div>
</div></footer>
<div class="home-float-actions" aria-label="Hızlı iletişim"><a class="home-float home-float-phone" href="tel:<?= e(preg_replace('/\D+/', '', $phone)) ?>" aria-label="Telefonla ara">☎</a><a class="home-float home-float-wa" href="https://wa.me/<?= e($wa) ?>" target="_blank" rel="noopener" aria-label="WhatsApp ile iletişim">W</a></div>
<script src="<?= e(app_url('assets/js/home.js')) ?>" defer></script>
</body></html>
