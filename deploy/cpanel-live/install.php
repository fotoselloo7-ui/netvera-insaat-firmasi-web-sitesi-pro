<?php
declare(strict_types=1);

$root = __DIR__;
require_once $root . '/app/license.php';

$done = false;
$error = '';
$licenseResult = null;
$licenseService = null;
$activated = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = trim((string)($_POST['db_host'] ?? '127.0.0.1'));
    $port = trim((string)($_POST['db_port'] ?? '3306'));
    $name = trim((string)($_POST['db_name'] ?? ''));
    $user = trim((string)($_POST['db_user'] ?? ''));
    $pass = (string)($_POST['db_pass'] ?? '');
    $appUrl = rtrim(trim((string)($_POST['app_url'] ?? '')), '/');
    $adminEmail = trim((string)($_POST['admin_email'] ?? 'admin@example.com'));
    $adminPassword = (string)($_POST['admin_password'] ?? '');
    $licenseKey = trim((string)($_POST['license_key'] ?? ''));
    $productSlug = trim((string)($_POST['product_slug'] ?? 'netvera-insaat-pro'));

    try {
        if ($name === '' || $user === '') throw new RuntimeException('Veritabanı adı ve kullanıcı adı zorunludur.');
        if ($appUrl === '' || !filter_var($appUrl, FILTER_VALIDATE_URL)) throw new RuntimeException('Geçerli site URL zorunludur.');
        if (strlen($adminPassword) < 8) throw new RuntimeException('Admin şifresi en az 8 karakter olmalıdır.');
        if ($licenseKey === '') throw new RuntimeException('NetVera lisans anahtarı zorunludur.');
        if ($productSlug === '') throw new RuntimeException('Lisans ürün slug bilgisi zorunludur.');

        $pdo = new PDO(
            "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4",
            $user,
            $pass,
            [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>false]
        );

        $appKey = 'base64:' . base64_encode(random_bytes(32));
        $installId = bin2hex(random_bytes(16));
        $licenseService = new NetveraLicenseService([
            'enabled'=>true,
            'server_url'=>'https://lisans.netvera.tr',
            'product_slug'=>$productSlug,
            'key'=>$licenseKey,
            'install_id'=>$installId,
            'site_url'=>$appUrl,
            'app_version'=>'1.0.0',
            'verify_interval_hours'=>24,
            'grace_hours'=>168,
            'timeout_seconds'=>10,
        ]);
        $licenseResult = $licenseService->activate($licenseKey, $productSlug, $appUrl, $installId);
        if (!(($licenseResult['success'] ?? false) === true && in_array((string)($licenseResult['status'] ?? ''), ['active','trial'], true))) {
            $reason = trim((string)($licenseResult['message'] ?? $licenseResult['reason'] ?? 'Lisans doğrulanamadı.'));
            throw new RuntimeException('Lisans aktivasyonu başarısız: ' . $reason);
        }
        $activated = true;

        $sql = file_get_contents($root . '/database.sql');
        if ($sql === false) throw new RuntimeException('database.sql okunamadı.');

        $statements = preg_split('/;\s*(?:\r?\n|$)/', $sql);
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if ($statement !== '') $pdo->exec($statement);
        }

        foreach ([$root . '/uploads', $root . '/storage'] as $dir) {
            if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
                throw new RuntimeException(basename($dir) . ' klasörü oluşturulamadı.');
            }
            if (!is_writable($dir)) {
                throw new RuntimeException(basename($dir) . ' klasörü yazılabilir değil. cPanel File Manager üzerinden izinleri 775/755 olarak kontrol edin.');
            }
        }

        $stmt = $pdo->prepare('UPDATE admins SET email=?, password_hash=?, name=? WHERE id=1');
        $stmt->execute([$adminEmail,password_hash($adminPassword,PASSWORD_DEFAULT),'NetVera Admin']);

        $env = "<?php\nreturn " . var_export([
            'APP_NAME'=>'NetVera İnşaat Firması Web Sitesi Pro',
            'APP_URL'=>$appUrl,
            'APP_TIMEZONE'=>'Europe/Istanbul',
            'APP_VERSION'=>'1.0.0',
            'APP_KEY'=>$appKey,
            'DB_HOST'=>$host,
            'DB_PORT'=>$port,
            'DB_DATABASE'=>$name,
            'DB_USERNAME'=>$user,
            'DB_PASSWORD'=>$pass,
            'LICENSE_ENABLED'=>'true',
            'LICENSE_SERVER_URL'=>'https://lisans.netvera.tr',
            'LICENSE_PRODUCT_SLUG'=>$productSlug,
            'LICENSE_KEY'=>netvera_encrypt_secret($licenseKey, $appKey),
            'LICENSE_INSTALL_ID'=>$installId,
            'LICENSE_VERIFY_INTERVAL_HOURS'=>'24',
            'LICENSE_GRACE_HOURS'=>'168',
            'LICENSE_TIMEOUT_SECONDS'=>'8',
        ], true) . ";\n";
        if (file_put_contents($root . '/.env.php', $env, LOCK_EX) === false) {
            throw new RuntimeException('.env.php yazılamadı. Kök klasör yazma iznini kontrol edin.');
        }

        $done = true;
    } catch (Throwable $e) {
        if ($activated && $licenseService instanceof NetveraLicenseService) {
            try { $licenseService->deactivate($licenseKey ?? null, $productSlug ?? null); } catch (Throwable $ignored) {}
        }
        $error = $e->getMessage();
    }
}
?><!doctype html><html lang="tr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,nofollow"><title>NetVera Kurulum</title><style>
body{margin:0;font-family:Arial,sans-serif;background:#f2f5f7;color:#17232c}.box{width:min(760px,calc(100% - 32px));margin:50px auto;background:#fff;border:1px solid #dce4e8;border-radius:14px;padding:28px;box-shadow:0 18px 55px rgba(16,44,64,.07)}.grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}label{display:grid;gap:6px;font-size:12px;font-weight:700}input{padding:11px 12px;border:1px solid #cbd6dc;border-radius:7px}.full{grid-column:1/-1}button{min-height:46px;border:0;border-radius:7px;padding:0 18px;background:#c9793b;color:#fff;font-weight:700;cursor:pointer}.ok{padding:16px;background:#eaf7f0;color:#17633f;border-radius:8px}.err{padding:12px;background:#fff0ed;color:#a13f2e;border-radius:8px}.license-box{grid-column:1/-1;padding:18px;border:1px solid #d8e1e6;border-radius:10px;background:#f8fafb}.license-box h2{margin:0 0 6px;font-size:17px}.license-box p{margin:0 0 14px;color:#657680;font-size:12px;line-height:1.6}.license-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}@media(max-width:620px){.grid,.license-grid{grid-template-columns:1fr}.full{grid-column:auto}}
</style></head><body><main class="box"><h1>NetVera İnşaat Pro Kurulumu</h1><?php if($done): ?><div class="ok"><strong>Kurulum ve lisans aktivasyonu tamamlandı.</strong><p><a href="admin/">Admin paneline git</a> veya <a href="./">siteyi aç</a>.</p><p>Güvenlik için kurulumdan sonra <code>install.php</code> dosyasını silin veya yeniden adlandırın.</p></div><?php else: ?><?php if($error): ?><div class="err"><?= htmlspecialchars($error,ENT_QUOTES,'UTF-8') ?></div><?php endif; ?><p>Önce hosting panelinizden boş bir MySQL veritabanı ve kullanıcı oluşturun. Kurulum başlamadan lisans anahtarı <strong>lisans.netvera.tr</strong> üzerinden doğrulanır.</p><form method="post" class="grid"><div class="license-box"><h2>NetVera Lisansı</h2><p>Ürün slug değeri lisans merkezindeki ürün kaydıyla birebir aynı olmalıdır. Bu ürün için varsayılan değer <code>netvera-insaat-pro</code> olarak hazırlanmıştır.</p><div class="license-grid"><label>Lisans Anahtarı<input name="license_key" required autocomplete="off" placeholder="DIGI-...." value="<?= htmlspecialchars($_POST['license_key']??'') ?>"></label><label>Ürün Slug<input name="product_slug" required value="<?= htmlspecialchars($_POST['product_slug']??'netvera-insaat-pro') ?>"></label></div></div><label>DB Host<input name="db_host" value="<?= htmlspecialchars($_POST['db_host']??'127.0.0.1') ?>"></label><label>DB Port<input name="db_port" value="<?= htmlspecialchars($_POST['db_port']??'3306') ?>"></label><label>DB Adı<input name="db_name" required value="<?= htmlspecialchars($_POST['db_name']??'') ?>"></label><label>DB Kullanıcı<input name="db_user" required value="<?= htmlspecialchars($_POST['db_user']??'') ?>"></label><label class="full">DB Şifre<input type="password" name="db_pass"></label><label class="full">Site URL<input type="url" name="app_url" required placeholder="https://firma.com" value="<?= htmlspecialchars($_POST['app_url']??'') ?>"></label><label>Admin E-posta<input type="email" name="admin_email" required value="<?= htmlspecialchars($_POST['admin_email']??'admin@example.com') ?>"></label><label>Admin Şifre<input type="password" name="admin_password" minlength="8" required></label><div class="full"><button type="submit">Lisansı Doğrula ve Kurulumu Başlat</button></div></form><?php endif; ?></main></body></html>
