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
?><!doctype html><html lang="tr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Girişi</title><link rel="stylesheet" href="admin.css"></head><body class="admin-login-body"><main class="admin-login"><div class="admin-brand">NV</div><h1>NetVera Yönetim Paneli</h1><p>İnşaat sitesi içerik yönetimi</p><?php if($error): ?><div class="admin-alert"><?= e($error) ?></div><?php endif; ?><form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><label>E-posta<input type="email" name="email" required autocomplete="username"></label><label>Şifre<input type="password" name="password" required autocomplete="current-password"></label><button type="submit">Giriş Yap</button></form><small>İlk kurulum: admin@netvera.local / ChangeMe123! — girişten sonra değiştirin.</small></main></body></html>
