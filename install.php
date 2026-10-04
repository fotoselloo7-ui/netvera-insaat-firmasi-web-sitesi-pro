<?php
declare(strict_types=1);

$root = __DIR__;
$done = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = trim((string)($_POST['db_host'] ?? '127.0.0.1'));
    $port = trim((string)($_POST['db_port'] ?? '3306'));
    $name = trim((string)($_POST['db_name'] ?? ''));
    $user = trim((string)($_POST['db_user'] ?? ''));
    $pass = (string)($_POST['db_pass'] ?? '');
    $appUrl = rtrim(trim((string)($_POST['app_url'] ?? '')), '/');
    $adminEmail = trim((string)($_POST['admin_email'] ?? 'admin@example.com'));
    $adminPassword = (string)($_POST['admin_password'] ?? '');

    try {
        if ($name === '' || $user === '') throw new RuntimeException('Veritabanı adı ve kullanıcı adı zorunludur.');
        if (strlen($adminPassword) < 8) throw new RuntimeException('Admin şifresi en az 8 karakter olmalıdır.');

        $pdo = new PDO(
            "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4",
            $user,
            $pass,
            [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>false]
        );

        $sql = file_get_contents($root . '/database.sql');
        if ($sql === false) throw new RuntimeException('database.sql okunamadı.');

        $statements = preg_split('/;\s*(?:\r?\n|$)/', $sql);
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if ($statement !== '') $pdo->exec($statement);
        }

        $uploadDir=$root.'/uploads';
        if(!is_dir($uploadDir) && !mkdir($uploadDir,0775,true) && !is_dir($uploadDir)){
            throw new RuntimeException('uploads klasörü oluşturulamadı. Kök klasör yazma iznini kontrol edin.');
        }
        if(!is_writable($uploadDir)){
            @chmod($uploadDir,0775);
        }
        if(!is_writable($uploadDir)){
            throw new RuntimeException('uploads klasörü yazılabilir değil. cPanel File Manager üzerinden izinleri 775/755 olarak kontrol edin.');
        }

        $stmt = $pdo->prepare('UPDATE admins SET email=?, password_hash=?, name=? WHERE id=1');
        $stmt->execute([$adminEmail,password_hash($adminPassword,PASSWORD_DEFAULT),'NetVera Admin']);

        $env = "<?php\nreturn " . var_export([
            'APP_URL'=>$appUrl,
            'DB_HOST'=>$host,
            'DB_PORT'=>$port,
            'DB_DATABASE'=>$name,
            'DB_USERNAME'=>$user,
            'DB_PASSWORD'=>$pass,
        ], true) . ";\n";
        if (file_put_contents($root . '/.env.php', $env, LOCK_EX) === false) {
            throw new RuntimeException('.env.php yazılamadı. Kök klasör yazma iznini kontrol edin.');
        }

        $done = true;
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}
?><!doctype html><html lang="tr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>NetVera Kurulum</title><style>body{margin:0;font-family:Arial,sans-serif;background:#f2f5f7;color:#17232c}.box{width:min(720px,calc(100% - 32px));margin:50px auto;background:#fff;border:1px solid #dce4e8;border-radius:14px;padding:28px}.grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}label{display:grid;gap:6px;font-size:12px;font-weight:700}input{padding:11px 12px;border:1px solid #cbd6dc;border-radius:7px}.full{grid-column:1/-1}button{min-height:46px;border:0;border-radius:7px;padding:0 18px;background:#c9793b;color:#fff;font-weight:700;cursor:pointer}.ok{padding:16px;background:#eaf7f0;color:#17633f;border-radius:8px}.err{padding:12px;background:#fff0ed;color:#a13f2e;border-radius:8px}@media(max-width:620px){.grid{grid-template-columns:1fr}.full{grid-column:auto}}</style></head><body><main class="box"><h1>NetVera İnşaat Pro Kurulumu</h1><?php if($done): ?><div class="ok"><strong>Kurulum tamamlandı.</strong><p><a href="admin/">Admin paneline git</a> veya <a href="./">siteyi aç</a>.</p><p>Güvenlik için kurulumdan sonra <code>install.php</code> dosyasını silin veya yeniden adlandırın.</p></div><?php else: ?><?php if($error): ?><div class="err"><?= htmlspecialchars($error,ENT_QUOTES,'UTF-8') ?></div><?php endif; ?><p>Önce hosting panelinizden boş bir MySQL veritabanı ve kullanıcı oluşturun.</p><form method="post" class="grid"><label>DB Host<input name="db_host" value="<?= htmlspecialchars($_POST['db_host']??'127.0.0.1') ?>"></label><label>DB Port<input name="db_port" value="<?= htmlspecialchars($_POST['db_port']??'3306') ?>"></label><label>DB Adı<input name="db_name" required value="<?= htmlspecialchars($_POST['db_name']??'') ?>"></label><label>DB Kullanıcı<input name="db_user" required value="<?= htmlspecialchars($_POST['db_user']??'') ?>"></label><label class="full">DB Şifre<input type="password" name="db_pass"></label><label class="full">Site URL<input type="url" name="app_url" placeholder="https://firma.com" value="<?= htmlspecialchars($_POST['app_url']??'') ?>"></label><label>Admin E-posta<input type="email" name="admin_email" required value="<?= htmlspecialchars($_POST['admin_email']??'admin@example.com') ?>"></label><label>Admin Şifre<input type="password" name="admin_password" minlength="8" required></label><div class="full"><button type="submit">Kurulumu Başlat</button></div></form><?php endif; ?></main></body></html>