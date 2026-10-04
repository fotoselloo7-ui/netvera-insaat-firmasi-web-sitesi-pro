<?php
declare(strict_types=1);

function db(): PDO {
    return $GLOBALS['pdo'];
}

function e(?string $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function app_url(string $path = ''): string {
    $base = $GLOBALS['app_config']['app']['url'] ?? '';
    if ($base === '') {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $script = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
        $script = preg_replace('#/admin$#', '', rtrim($script, '/'));
        $base = $scheme . '://' . $host . ($script === '' ? '' : $script);
    }
    return rtrim($base, '/') . '/' . ltrim($path, '/');
}

function media_url(?string $value): string {
    $value = trim((string)$value);
    if ($value === '') return '';
    if (preg_match('#^https?://#i', $value)) return $value;
    return app_url($value);
}

function setting(string $key, string $default = ''): string {
    static $cache = null;
    if ($cache === null) {
        $cache = [];
        foreach (db()->query('SELECT setting_key, setting_value FROM settings')->fetchAll() as $row) {
            $cache[$row['setting_key']] = $row['setting_value'];
        }
    }
    return array_key_exists($key, $cache) ? (string)$cache[$key] : $default;
}

function section(string $key): array {
    $stmt = db()->prepare('SELECT * FROM home_sections WHERE section_key = ? LIMIT 1');
    $stmt->execute([$key]);
    return $stmt->fetch() ?: ['section_key'=>$key,'eyebrow'=>'','title'=>'','body'=>'','is_active'=>0,'sort_order'=>0];
}

function rows(string $table, string $where = 'is_active = 1', array $params = [], string $order = 'sort_order ASC, id ASC'): array {
    $allowed = ['sliders','home_stats','services','projects','home_features','testimonials','service_areas','faqs','posts','pages'];
    if (!in_array($table, $allowed, true)) return [];
    $sql = "SELECT * FROM {$table}" . ($where ? " WHERE {$where}" : '') . ($order ? " ORDER BY {$order}" : '');
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function one_by_slug(string $table, string $slug): ?array {
    $allowed = ['services','projects','posts','pages'];
    if (!in_array($table, $allowed, true)) return null;
    $stmt = db()->prepare("SELECT * FROM {$table} WHERE slug = ? AND is_active = 1 LIMIT 1");
    $stmt->execute([$slug]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function feature_group(string $group): array {
    $stmt = db()->prepare('SELECT * FROM home_features WHERE group_key = ? AND is_active = 1 ORDER BY sort_order ASC, id ASC');
    $stmt->execute([$group]);
    return $stmt->fetchAll();
}

function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(24));
    return $_SESSION['csrf'];
}

function verify_csrf(): void {
    $token = $_POST['csrf'] ?? '';
    if (!is_string($token) || !hash_equals($_SESSION['csrf'] ?? '', $token)) {
        http_response_code(419);
        exit('Oturum doğrulaması başarısız. Sayfayı yenileyip tekrar deneyin.');
    }
}

function is_admin(): bool {
    return !empty($_SESSION['admin_id']);
}

function require_admin(): void {
    if (!is_admin()) {
        header('Location: ' . app_url('admin/login.php'));
        exit;
    }
}

function slugify(string $text): string {
    $map = ['ş'=>'s','Ş'=>'s','ı'=>'i','İ'=>'i','ğ'=>'g','Ğ'=>'g','ü'=>'u','Ü'=>'u','ö'=>'o','Ö'=>'o','ç'=>'c','Ç'=>'c'];
    $text = strtr($text, $map);
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

function upload_image(string $field): ?string {
    if (empty($_FILES[$field]['name']) || ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) return null;
    $file = $_FILES[$field];
    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) throw new RuntimeException('Dosya yükleme hatası.');
    if (($file['size'] ?? 0) > ($GLOBALS['app_config']['upload']['max_bytes'] ?? 5242880)) throw new RuntimeException('Görsel 5 MB sınırını aşıyor.');
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    $exts = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp','image/avif'=>'avif'];
    if (!isset($exts[$mime])) throw new RuntimeException('Yalnız JPG, PNG, WebP veya AVIF yüklenebilir.');
    $dir = $GLOBALS['app_config']['upload']['dir'];
    if (!is_dir($dir)) mkdir($dir, 0775, true);
    $name = date('YmdHis') . '-' . bin2hex(random_bytes(5)) . '.' . $exts[$mime];
    if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $name)) throw new RuntimeException('Görsel kaydedilemedi.');
    return 'uploads/' . $name;
}
