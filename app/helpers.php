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



function ensure_content_management_schema(): void {
    static $done=false;
    if($done) return;
    $done=true;

    try {
        $pdo=db();
        $pdo->exec("CREATE TABLE IF NOT EXISTS page_sections (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            page_key VARCHAR(80) NOT NULL,
            section_key VARCHAR(80) NOT NULL,
            eyebrow VARCHAR(190) NULL,
            title VARCHAR(255) NULL,
            body TEXT NULL,
            secondary_text TEXT NULL,
            image VARCHAR(500) NULL,
            button_label VARCHAR(120) NULL,
            button_url VARCHAR(500) NULL,
            is_active TINYINT(1) NOT NULL DEFAULT 1,
            sort_order INT NOT NULL DEFAULT 0,
            UNIQUE KEY uq_page_section (page_key,section_key)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $featureExists=$pdo->query("SHOW TABLES LIKE 'home_features'")->fetchColumn();
        if($featureExists){
            $featureCols=[];
            foreach($pdo->query("SHOW COLUMNS FROM home_features")->fetchAll() as $col) $featureCols[(string)$col['Field']]=true;
            if(!isset($featureCols['link_label'])) $pdo->exec("ALTER TABLE home_features ADD COLUMN link_label VARCHAR(120) NULL AFTER icon");
            if(!isset($featureCols['link_url'])) $pdo->exec("ALTER TABLE home_features ADD COLUMN link_url VARCHAR(500) NULL AFTER link_label");
        }

        $uiDefaults=[
            'nav_home_label'=>'Ana Sayfa',
            'nav_about_label'=>'Kurumsal',
            'nav_services_label'=>'Hizmetler',
            'nav_projects_label'=>'Projeler',
            'nav_blog_label'=>'Blog',
            'nav_contact_label'=>'İletişim',
            'nav_cta_label'=>'Ücretsiz Keşif Talebi',
            'footer_corporate_title'=>'Kurumsal',
            'footer_services_title'=>'Hizmetler',
            'footer_contact_title'=>'İletişim',
            'mobile_quick_label'=>'Hızlı İletişim',
            'mobile_social_label'=>'Sosyal Medya',
        ];
        $settingInsert=$pdo->prepare("INSERT IGNORE INTO settings (setting_key,setting_value) VALUES (?,?)");
        foreach($uiDefaults as $key=>$value) $settingInsert->execute([$key,$value]);

        $sections=[
            ['hakkimizda','editorial','Nasıl Çalışıyoruz?','Gösterişten önce düzen, vaatten önce süreç.','Bizim için premium hizmet; daha fazla söz vermek değil, daha az belirsizlik üretmektir. Bütçe, takvim, malzeme ve uygulama kararlarının izlenebilir olması bu yüzden çalışma modelimizin merkezindedir.','İyi bir yapı yalnızca malzeme ve işçilikten değil; doğru kararların doğru sırayla alınmasından oluşur.','','',10],
            ['hakkimizda','principles','Çalışma Prensipleri','Projeyi güçlü kılan görünmeyen disiplin.','İnşaat sürecinde güven; yalnızca sonuçtan değil, kararların nasıl alındığından doğar.','','','',20],
            ['hakkimizda','process','Proje Akışı','İlk görüşmeden teslim anına kadar tek ritim.','Müşteri hangi aşamada olduğumuzu, sıradaki kararın ne olduğunu ve kimden sorumlu olduğunu bilir.','','','',30],
            ['hakkimizda','cta','İlk Değerlendirme','Projenizi masaya yatırmadan fiyat konuşmayalım.','Konumu, yaklaşık alanı ve hedefinizi paylaşın; önce doğru kapsamı birlikte netleştirelim.','','','Projeyi Konuşalım','iletisim',40],

            ['hizmetler','directory','Kapsamı Netleştirin','Hizmet seçmekten önce ihtiyacı doğru tanımlayın.','Her proje aynı değildir. Yapı tipi, mevcut proje durumu, hedef takvim ve uygulama kapsamına göre doğru çalışma modeli değişir.','','','',10],
            ['hizmetler','method','Çalışma Modeli','Projenin bulunduğu aşamaya göre doğru yerden başlarız.','Hazır projeniz olabilir, yalnızca arsanız olabilir veya mevcut yapınızı yenilemek isteyebilirsiniz. Süreci ihtiyaçtan başlatırız.','','','',20],
            ['hizmetler','cta','Kararsız mısınız?','Hangi hizmetin projenize uyduğunu birlikte belirleyelim.','Kısa proje bilgisini gönderin; doğru hizmet modelini ve sonraki adımı netleştirelim.','','','Detaylı Bilgi Al','iletisim',30],

            ['projeler','cta','Yeni Proje','Portföyde görmek istediğiniz bir sonraki yapı sizin projeniz olabilir.','İlk görüşmede kapsam, konum, hedef takvim ve uygulama modelini birlikte değerlendirelim.','','','Projeyi Değerlendir','iletisim',10],

            ['blog','more','Diğer Yazılar','Karar vermeden önce bilmeniz gerekenler.','','','','',10],
            ['blog','cta','Sorunuz Yazıda Yoksa','Projenize özel soruyu doğrudan sorun.','Genel bilgi yerine kendi proje koşullarınıza göre kısa bir ön değerlendirme alın.','','','Uzmanla Görüşün','iletisim',20],

            ['iletisim','panel','Doğrudan İletişim','Doğru bilgiyle başlayalım.','İlk görüşme satış konuşması değil; proje kapsamını anlamak için kısa bir ön değerlendirmedir.','','','',10],
            ['iletisim','form','Proje Formu','Bize birkaç net bilgi verin.','Form, bilgilerinizi hazır bir WhatsApp mesajına dönüştürür; gereksiz kayıt süreci yok.','','','WhatsApp’tan Talep Gönder','',20],
            ['iletisim','map','Konum','Bizi haritada görün.','Ofis veya proje görüşmesi öncesinde konumumuzu haritadan inceleyebilirsiniz.','','','',30],
            ['iletisim','process','Sonraki Adım','İlk temastan sonra ne olur?','Süreci mümkün olduğunca kısa, açık ve karar vermeyi kolaylaştıran bir akışta tutuyoruz.','','','',40],

            ['bolgeler','local','Yerel Uygulama','Aynı hizmet, her bölgede aynı saha koşulu demek değildir.','Ulaşım, iklim, arsa yapısı ve proje tipi uygulama kararlarını etkiler. Bölge sayfalarında kapsamı yerel bağlamıyla anlatıyoruz.','','','',10],
            ['bolgeler','cta','Bölgeniz Listede Yoksa','Proje kapsamına göre çevre bölgeleri de değerlendirebiliriz.','Konumu paylaşın; ulaşım, saha şartları ve proje ölçeğine göre birlikte bakalım.','','','Konumu Sorun','iletisim',20],

            ['hizmet-detay','scope','','Bu hizmette neyi birlikte yönetiyoruz?','','','','',10],
            ['hizmet-detay','proof','Karar Prensibi','Önce kapsam, sonra fiyat.','Sağlıklı teklif; yapı tipi, proje durumu, konum, hedef kalite ve uygulama kapsamı netleştiğinde anlamlı hale gelir.','','','',20],
            ['hizmet-detay','process','Uygulama Akışı','Sürecin her aşamasında sıradaki adım belli.','Hizmet türü değişse de çalışma disiplinini aynı tutuyoruz.','','','',30],
            ['hizmet-detay','projects','Proje Kanıtı','Uygulama yaklaşımını projelerde görün.','','','','Tüm Projeler','projeler',40],
            ['hizmet-detay','aside','','İlk değerlendirme','Konum, yaklaşık alan ve mevcut proje durumunu paylaşın; doğru çalışma modelini birlikte belirleyelim.','','','Detaylı Bilgi Al','iletisim',50],

            ['proje-detay','story','Case Study','Projeyi yalnız göstermiyoruz; nasıl düşündüğümüzü de anlatıyoruz.','','','','',10],
            ['proje-detay','approach','','Uygulama yaklaşımı','Planlama kararları, malzeme seçimi, saha koordinasyonu ve bitiş detaylarını birbirinden kopuk iş kalemleri olarak değil, aynı sonucun parçaları olarak ele aldık.','','','',20],
            ['proje-detay','quality','','Kaliteyi nerede koruduk?','Proje boyunca kritik imalat noktalarını, malzeme geçişlerini ve teslim öncesi kontrolleri görünür bir kontrol listesiyle takip etmek; estetik kadar uzun ömürlü kullanım için de belirleyiciydi.','','','',30],
            ['proje-detay','related','Sonraki Projeler','Farklı ölçeklerde aynı uygulama disiplini.','','','','Tüm Portföy','projeler',40],

            ['yazi-detay','decision','','Karar verirken neyi ölçün?','Tek bir fiyat veya tek bir görsel yerine; kapsamın açıklığına, sorumlulukların netliğine, saha iletişimine ve teslim kriterlerinin baştan konuşulmasına bakın. İyi proje yönetimi belirsizliği azaltır.','','','',10],
            ['yazi-detay','related','Devamını Okuyun','Bir sonraki karar için ilgili rehberler.','','','','',20],

            ['bolge-detay','approach','','{BOLGE} için yaklaşımımız','Proje türünü ve saha koşullarını birlikte değerlendiriyoruz. Yerel bağlamı SEO metni olsun diye değil; keşif, lojistik, malzeme seçimi ve uygulama takvimi açısından gerçek karar girdisi olarak ele alıyoruz.','','','',10],
            ['bolge-detay','services','','Bu bölgede hangi hizmetlerle ilerleyebiliriz?','','','','',20],
            ['bolge-detay','aside','','{BOLGE} için proje mi planlıyorsunuz?','Konum, yaklaşık alan ve proje türünü paylaşın; saha koşullarına göre ilk değerlendirmeyi yapalım.','','','Ücretsiz Ön Değerlendirme','iletisim',30],
        ];
        $check=$pdo->prepare("SELECT id FROM page_sections WHERE page_key=? AND section_key=? LIMIT 1");
        $insert=$pdo->prepare("INSERT INTO page_sections (page_key,section_key,eyebrow,title,body,secondary_text,image,button_label,button_url,is_active,sort_order) VALUES (?,?,?,?,?,?,?,?,?,1,?)");
        foreach($sections as $s){
            $check->execute([$s[0],$s[1]]);
            if(!$check->fetchColumn()) $insert->execute($s);
        }

        if($featureExists){
            $featureSeeds=[
              ['service_flow','İhtiyaç & keşif','İhtiyaç, mevcut durum ve ilk hedefler netleşir.','01','','',10],
              ['service_flow','Kapsam & bütçe','İş kalemleri ve bütçe çerçevesi görünür hale gelir.','02','','',20],
              ['service_flow','Uygulama & kontrol','Saha koordinasyonu ve teknik kontrol birlikte yürür.','03','','',30],
              ['service_flow','Teslim & kapanış','Son kontroller ve teslim kriterleri tamamlanır.','04','','',40],
              ['service_method','Fikir / Arsa Aşaması','İhtiyaç programı, yapı tipi, yaklaşık kapsam ve ilk teknik kararlar birlikte netleştirilir.','01','Kapsamı incele','hizmet/konut-projeleri',10],
              ['service_method','Hazır Proje Aşaması','Mimari ve mühendislik projeleri saha uygulanabilirliği, takvim ve koordinasyon açısından değerlendirilir.','02','Uygulamayı incele','hizmet/proje-uygulama',20],
              ['service_method','Mevcut Yapı Aşaması','Teknik durum, kullanım hedefi ve yenileme kapsamı üzerinden kontrollü renovasyon planı oluşturulur.','03','Renovasyonu incele','hizmet/renovasyon',30],
              ['contact_process','Ön değerlendirme','Proje türü, konum ve ihtiyaç çerçevesi netleşir.','01','','',10],
              ['contact_process','Keşif / teknik görüşme','Gerekliyse saha veya proje dokümanı üzerinden detaylandırılır.','02','','',20],
              ['contact_process','Kapsam & teklif','İş kalemleri, yaklaşım ve sonraki adımlar anlaşılır biçimde sunulur.','03','','',30],
              ['service_scope','Keşif & ihtiyaç','Mevcut durumu, hedefleri ve karar verilmesi gereken kritik başlıkları netleştiririz.','01','','',10],
              ['service_scope','Kapsam & bütçe','İş kalemlerini, sorumlulukları ve maliyet çerçevesini mümkün olduğunca görünür hale getiririz.','02','','',20],
              ['service_scope','Saha & koordinasyon','Uygulama sırasını, ekipleri ve teknik kontrolleri tek koordinasyon altında yürütürüz.','03','','',30],
              ['service_scope','Kalite & teslim','İmalat kontrolleri, eksiklerin kapanışı ve teslim kriterleri planın parçasıdır.','04','','',40],
            ];
            $groupCount=$pdo->prepare("SELECT COUNT(*) FROM home_features WHERE group_key=?");
            $featureInsert=$pdo->prepare("INSERT INTO home_features (group_key,title,body,icon,link_label,link_url,is_active,sort_order) VALUES (?,?,?,?,?,?,1,?)");
            $byGroup=[];
            foreach($featureSeeds as $seed) $byGroup[$seed[0]][]=$seed;
            foreach($byGroup as $group=>$seeds){
                $groupCount->execute([$group]);
                if((int)$groupCount->fetchColumn()===0){
                    foreach($seeds as $seed) $featureInsert->execute($seed);
                }
            }
        }
    } catch(Throwable $e) {
        // CMS schema migration must never block the public site.
    }
}

function page_section(string $pageKey, string $sectionKey, array $fallback=[]): array {
    $defaults=[
        'page_key'=>$pageKey,'section_key'=>$sectionKey,'eyebrow'=>'','title'=>'','body'=>'',
        'secondary_text'=>'','image'=>'','button_label'=>'','button_url'=>'','is_active'=>1,'sort_order'=>0
    ];
    try {
        $stmt=db()->prepare("SELECT * FROM page_sections WHERE page_key=? AND section_key=? LIMIT 1");
        $stmt->execute([$pageKey,$sectionKey]);
        $row=$stmt->fetch();
        return array_merge($defaults,$fallback,$row ?: []);
    } catch(Throwable $e) {
        return array_merge($defaults,$fallback);
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
    $allowed = ['sliders','home_stats','services','projects','home_features','testimonials','service_areas','faqs','posts','pages','page_sections'];
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
