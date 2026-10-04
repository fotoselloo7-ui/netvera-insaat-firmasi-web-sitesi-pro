<?php
require_once dirname(__DIR__) . '/app/bootstrap.php';
if (is_admin()) { header('Location: ' . app_url('admin/')); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = trim($_POST['email'] ?? '');
    $password = (string)($_POST['password'] ?? '');
    $stmt = db()->prepare('SELECT * FROM admins WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($password, $admin['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int)$admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        header('Location: ' . app_url('admin/'));
        exit;
    }
    $error = 'E-posta veya şifre hatalı.';
}
?><!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="theme-color" content="#0c2232">
<title>Yönetim Paneli · NetVera</title>
<link rel="stylesheet" href="admin.css">
</head>
<body class="admin-login-body">
<div class="login-shell">
  <section class="login-brand-panel">
    <div class="login-brand-top"><div class="admin-brand-mark">NV</div><div><strong>NetVera</strong><span>Construction CMS</span></div></div>
    <div class="login-brand-content">
      <span class="admin-eyebrow">PREMIUM YÖNETİM</span>
      <h1>İçeriği yönetin.<br>Markayı büyütün.</h1>
      <p>Projelerden slider'a, hizmetlerden SEO alanlarına kadar sitenizin tamamını tek panelden kontrol edin.</p>
      <div class="login-points">
        <div><span>01</span><p>Proje & hizmet yönetimi</p></div>
        <div><span>02</span><p>Slider & dönüşüm alanları</p></div>
        <div><span>03</span><p>SEO & kurumsal içerikler</p></div>
      </div>
    </div>
    <div class="login-brand-foot">NetVera Teknoloji · Pro CMS</div>
  </section>

  <main class="admin-login">
    <div class="admin-login-head">
      <span class="admin-eyebrow">YÖNETİCİ GİRİŞİ</span>
      <h2>Tekrar hoş geldiniz.</h2>
      <p>Yönetim paneline devam etmek için hesabınızla giriş yapın.</p>
    </div>
    <?php if($error): ?><div class="admin-alert"><span><?= e($error) ?></span></div><?php endif; ?>
    <form method="post">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <label class="admin-field"><span>E-posta</span><input type="email" name="email" required autocomplete="username" placeholder="admin@firma.com"></label>
      <label class="admin-field"><span>Şifre</span><div class="password-wrap"><input id="admin-password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••"><button type="button" class="password-toggle" data-password-toggle aria-label="Şifreyi göster">Göster</button></div></label>
      <button class="admin-btn admin-login-submit" type="submit">Giriş Yap <span>→</span></button>
    </form>
    <div class="login-security"><span class="login-security-dot"></span><span>Güvenli yönetici oturumu</span></div>
  </main>
</div>
<script src="admin.js" defer></script>
</body>
</html>