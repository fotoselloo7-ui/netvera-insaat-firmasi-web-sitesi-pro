<?php
declare(strict_types=1);

function db(): PDO {
    return $GLOBALS['pdo'];
}

function ensure_testimonial_schema(): void {
    $pdo = db();
    $tableExists = $pdo->query("SHOW TABLES LIKE 'testimonials'")->fetchColumn();
    if (!$tableExists) return;

    $columns = [];
    foreach ($pdo->query("SHOW COLUMNS FROM testimonials")->fetchAll() as $column) {
        $columns[(string)$column['Field']] = true;
    }

    if (!isset($columns['profile_image'])) {
        $pdo->exec("ALTER TABLE testimonials ADD COLUMN profile_image VARCHAR(500) NULL AFTER role");
    }
    if (!isset($columns['star_color'])) {
        $pdo->exec("ALTER TABLE testimonials ADD COLUMN star_color VARCHAR(16) NOT NULL DEFAULT '#FABB05' AFTER rating");
    }
}


function e(?string $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function app_url(string $path = ''): string {
    $configured = trim((string)($GLOBALS['app_config']['app']['url'] ?? ''));

    $forwardedHost = trim(explode(',', (string)($_SERVER['HTTP_X_FORWARDED_HOST'] ?? ''))[0] ?? '');
    $requestHost = $forwardedHost !== '' ? $forwardedHost : (string)($_SERVER['HTTP_HOST'] ?? 'localhost');
    $requestHost = preg_replace('/[^A-Za-z0-9.:-]/', '', $requestHost) ?: 'localhost';

    $forwardedProto = trim(explode(',', (string)($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? ''))[0] ?? '');
    if (in_array($forwardedProto, ['http','https'], true)) {
        $scheme = $forwardedProto;
    } elseif (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        $scheme = 'https';
    } elseif (str_ends_with($requestHost, '.app.github.dev')) {
        $scheme = 'https';
    } else {
        $scheme = 'http';
    }

    $configuredHost = $configured !== '' ? (string)(parse_url($configured, PHP_URL_HOST) ?? '') : '';
    $configuredIsLocal = in_array($configuredHost, ['localhost','127.0.0.1','0.0.0.0'], true);
    $requestIsLocal = preg_match('/^(localhost|127\.0\.0\.1|0\.0\.0\.0)(:\d+)?$/', $requestHost) === 1;

    if ($configured === '' || ($configuredIsLocal && !$requestIsLocal)) {
        $script = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
        $script = preg_replace('#/admin$#', '', rtrim($script, '/'));
        $base = $scheme . '://' . $requestHost . ($script === '' || $script === '.' ? '' : $script);
    } else {
        $base = rtrim($configured, '/');
    }

    return rtrim($base, '/') . '/' . ltrim($path, '/');
}

function media_url(?string $value): string {
    $value = trim((string)$value);
    if ($value === '') return '';
    if (preg_match('#^https?://#i', $value)) return $value;
    return app_url($value);
}

function ensure_v17_content_seed(): void {
    try {
        $marker = db()->prepare('SELECT setting_value FROM settings WHERE setting_key=? LIMIT 1');
        $marker->execute(['content_seed_v17']);
        if ($marker->fetchColumn()) return;

        $check = db()->prepare('SELECT id FROM projects WHERE slug=? LIMIT 1');
        $check->execute(['oba-courtyard']);
        if (!$check->fetchColumn()) {
            $stmt = db()->prepare('INSERT INTO projects (title,slug,category,location,status,area,project_year,summary,body,cover_image,gallery_json,meta_title,meta_description,is_featured,is_active,sort_order) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
            $stmt->execute([
                'Oba Courtyard','oba-courtyard','Villa','Oba','Tamamlandı','1.180 m²','2026',
                'Avlu, gölge ve iç-dış yaşam ilişkisini merkeze alan çağdaş konut projesi.',
                'Oba Courtyard projesinde mahremiyet, doğal ışık, gölgelendirme ve açık yaşam alanları tek mimari kurgu içinde ele alındı.',
                'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&q=80&w=1400',
                '[]','Oba Courtyard | Vera Yapı','Alanya Oba bölgesinde çağdaş villa ve avlulu konut proje detayı.',
                0,1,40
            ]);
        }

        $save = db()->prepare('INSERT INTO settings (setting_key,setting_value) VALUES (?,?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)');
        $save->execute(['content_seed_v17','1']);
        clear_settings_cache();
    } catch (Throwable $e) {
        // İçerik migrationı sayfayı asla bloke etmemeli.
    }
}

function google_maps_embed_url(?string $value, string $fallbackAddress = ''): string {
    $value = trim((string)$value);
    $fallbackAddress = trim($fallbackAddress);

    if ($value === '') {
        return $fallbackAddress !== ''
            ? 'https://www.google.com/maps?q='.rawurlencode($fallbackAddress).'&output=embed'
            : '';
    }

    if (!preg_match('#^https?://#i', $value)) {
        return 'https://www.google.com/maps?q='.rawurlencode($value).'&output=embed';
    }

    $parts = parse_url($value);
    $host = strtolower((string)($parts['host'] ?? ''));
    if (!preg_match('/(^|\.)google\.[a-z.]+$|(^|\.)googleusercontent\.com$|(^|\.)maps\.google\.[a-z.]+$/i', $host)) {
        return $fallbackAddress !== ''
            ? 'https://www.google.com/maps?q='.rawurlencode($fallbackAddress).'&output=embed'
            : '';
    }

    $path = (string)($parts['path'] ?? '');
    if (str_contains($path, '/maps/embed')) return $value;

    parse_str((string)($parts['query'] ?? ''), $query);
    $q = trim((string)($query['q'] ?? $query['query'] ?? ''));
    if ($q !== '') return 'https://www.google.com/maps?q='.rawurlencode($q).'&output=embed';

    if (preg_match('#/maps/place/([^/]+)#i', $path, $m)) {
        $place = trim(rawurldecode(str_replace('+', ' ', $m[1])));
        if ($place !== '') return 'https://www.google.com/maps?q='.rawurlencode($place).'&output=embed';
    }

    if (preg_match('/@(-?\d+(?:\.\d+)?),(-?\d+(?:\.\d+)?)/', $value, $m)) {
        return 'https://www.google.com/maps?q='.rawurlencode($m[1].','.$m[2]).'&output=embed';
    }

    return $fallbackAddress !== ''
        ? 'https://www.google.com/maps?q='.rawurlencode($fallbackAddress).'&output=embed'
        : '';
}

function setting(string $key, string $default = ''): string {
    if (!array_key_exists('settings_cache', $GLOBALS) || $GLOBALS['settings_cache'] === null) {
        $GLOBALS['settings_cache'] = [];
        foreach (db()->query('SELECT setting_key, setting_value FROM settings')->fetchAll() as $row) {
            $GLOBALS['settings_cache'][$row['setting_key']] = $row['setting_value'];
        }
    }
    $cache = $GLOBALS['settings_cache'];
    return array_key_exists($key, $cache) ? (string)$cache[$key] : $default;
}

function clear_settings_cache(): void {
    $GLOBALS['settings_cache'] = null;
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
    $allowed = ['services','projects','posts','pages','service_areas'];
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


function render_content_blocks(string $text): string {
    $lines=preg_split('/\R/',trim($text)) ?: [];
    $html='';
    $paragraph=[];
    $list=[];

    $flushParagraph=function() use (&$html,&$paragraph){
        if(!$paragraph) return;
        $value=trim(implode(' ',array_map('trim',$paragraph)));
        if($value!=='') $html.='<p>'.nl2br(e($value)).'</p>';
        $paragraph=[];
    };
    $flushList=function() use (&$html,&$list){
        if(!$list) return;
        $html.='<ul class="content-list">';
        foreach($list as $item) $html.='<li>'.e($item).'</li>';
        $html.='</ul>';
        $list=[];
    };

    foreach($lines as $line){
        $trim=trim($line);
        if($trim===''){
            $flushParagraph();$flushList();continue;
        }
        if(str_starts_with($trim,'### ')){
            $flushParagraph();$flushList();
            $html.='<h3>'.e(trim(substr($trim,4))).'</h3>';continue;
        }
        if(str_starts_with($trim,'## ')){
            $flushParagraph();$flushList();
            $html.='<h2>'.e(trim(substr($trim,3))).'</h2>';continue;
        }
        if(str_starts_with($trim,'- ')){
            $flushParagraph();
            $list[]=trim(substr($trim,2));continue;
        }
        $flushList();
        $paragraph[]=$trim;
    }
    $flushParagraph();$flushList();
    return $html;
}

function estimated_reading_minutes(string $text): int {
    $words=preg_split('/\s+/u',trim(strip_tags($text))) ?: [];
    return max(1,(int)ceil(count(array_filter($words))/190));
}
