<?php
require_once dirname(__DIR__) . '/app/bootstrap.php';
require_admin();

$modules = [
    'home_sections'=>['label'=>'Ana Sayfa Bölümleri','table'=>'home_sections','title'=>'title','fields'=>[
        'section_key'=>['label'=>'Bölüm Anahtarı','type'=>'text'],
        'eyebrow'=>['label'=>'Üst Başlık','type'=>'text'],
        'title'=>['label'=>'Başlık','type'=>'text'],
        'body'=>['label'=>'Açıklama','type'=>'textarea'],
        'is_active'=>['label'=>'Aktif','type'=>'checkbox'],
        'sort_order'=>['label'=>'Sıra','type'=>'number'],
    ]],
    'sliders'=>['label'=>'Slider','table'=>'sliders','title'=>'title','fields'=>[
        'eyebrow'=>['label'=>'Üst Başlık','type'=>'text'],
        'title'=>['label'=>'Başlık','type'=>'text'],
        'body'=>['label'=>'Açıklama','type'=>'textarea'],
        'image'=>['label'=>'Görsel','type'=>'image'],
        'primary_label'=>['label'=>'1. Buton Yazısı','type'=>'text'],
        'primary_url'=>['label'=>'1. Buton Linki','type'=>'text'],
        'secondary_label'=>['label'=>'2. Buton Yazısı','type'=>'text'],
        'secondary_url'=>['label'=>'2. Buton Linki','type'=>'text'],
        'is_active'=>['label'=>'Aktif','type'=>'checkbox'],
        'sort_order'=>['label'=>'Sıra','type'=>'number'],
    ]],
    'home_stats'=>['label'=>'İstatistikler','table'=>'home_stats','title'=>'label','fields'=>[
        'stat_value'=>['label'=>'Değer','type'=>'text'],'label'=>['label'=>'Açıklama','type'=>'text'],
        'is_active'=>['label'=>'Aktif','type'=>'checkbox'],'sort_order'=>['label'=>'Sıra','type'=>'number']
    ]],
    'services'=>['label'=>'Hizmetler','table'=>'services','title'=>'title','fields'=>[
        'title'=>['label'=>'Başlık','type'=>'text'],'slug'=>['label'=>'Slug','type'=>'text'],
        'summary'=>['label'=>'Kısa Açıklama','type'=>'textarea'],'body'=>['label'=>'Detay İçerik','type'=>'textarea'],
        'cover_image'=>['label'=>'Kapak Görseli','type'=>'image'],
        'meta_title'=>['label'=>'SEO Başlık','type'=>'text'],'meta_description'=>['label'=>'Meta Açıklama','type'=>'textarea'],
        'is_featured'=>['label'=>'Ana Sayfada Göster','type'=>'checkbox'],'is_active'=>['label'=>'Aktif','type'=>'checkbox'],'sort_order'=>['label'=>'Sıra','type'=>'number']
    ]],
    'projects'=>['label'=>'Projeler','table'=>'projects','title'=>'title','fields'=>[
        'title'=>['label'=>'Başlık','type'=>'text'],'slug'=>['label'=>'Slug','type'=>'text'],'category'=>['label'=>'Kategori','type'=>'text'],
        'location'=>['label'=>'Konum','type'=>'text'],'status'=>['label'=>'Durum','type'=>'text'],'area'=>['label'=>'Alan','type'=>'text'],'project_year'=>['label'=>'Yıl','type'=>'text'],
        'summary'=>['label'=>'Kısa Açıklama','type'=>'textarea'],'body'=>['label'=>'Detay İçerik','type'=>'textarea'],
        'cover_image'=>['label'=>'Kapak Görseli','type'=>'image'],'gallery_json'=>['label'=>'Galeri JSON (URL listesi)','type'=>'textarea'],
        'meta_title'=>['label'=>'SEO Başlık','type'=>'text'],'meta_description'=>['label'=>'Meta Açıklama','type'=>'textarea'],
        'is_featured'=>['label'=>'Ana Sayfada Göster','type'=>'checkbox'],'is_active'=>['label'=>'Aktif','type'=>'checkbox'],'sort_order'=>['label'=>'Sıra','type'=>'number']
    ]],
    'home_features'=>['label'=>'Ana Sayfa Özellikleri','table'=>'home_features','title'=>'title','fields'=>[
        'group_key'=>['label'=>'Grup','type'=>'select','options'=>['why'=>'Neden Biz','process'=>'Süreç','trust'=>'Güven']],
        'title'=>['label'=>'Başlık','type'=>'text'],'body'=>['label'=>'Açıklama','type'=>'textarea'],'icon'=>['label'=>'Numara / İkon','type'=>'text'],
        'is_active'=>['label'=>'Aktif','type'=>'checkbox'],'sort_order'=>['label'=>'Sıra','type'=>'number']
    ]],
    'testimonials'=>['label'=>'Müşteri Yorumları','table'=>'testimonials','title'=>'name','fields'=>[
        'name'=>['label'=>'Ad Soyad','type'=>'text'],'role'=>['label'=>'Proje / Konum','type'=>'text'],'quote_text'=>['label'=>'Yorum','type'=>'textarea'],
        'rating'=>['label'=>'Puan','type'=>'number'],'is_active'=>['label'=>'Aktif','type'=>'checkbox'],'sort_order'=>['label'=>'Sıra','type'=>'number']
    ]],
    'service_areas'=>['label'=>'Hizmet Bölgeleri','table'=>'service_areas','title'=>'title','fields'=>[
        'title'=>['label'=>'Bölge','type'=>'text'],'services_text'=>['label'=>'Hizmetler','type'=>'text'],
        'is_active'=>['label'=>'Aktif','type'=>'checkbox'],'sort_order'=>['label'=>'Sıra','type'=>'number']
    ]],
    'faqs'=>['label'=>'SSS','table'=>'faqs','title'=>'question','fields'=>[
        'question'=>['label'=>'Soru','type'=>'text'],'answer'=>['label'=>'Cevap','type'=>'textarea'],
        'is_active'=>['label'=>'Aktif','type'=>'checkbox'],'sort_order'=>['label'=>'Sıra','type'=>'number']
    ]],
    'posts'=>['label'=>'Blog','table'=>'posts','title'=>'title','fields'=>[
        'title'=>['label'=>'Başlık','type'=>'text'],'slug'=>['label'=>'Slug','type'=>'text'],'excerpt'=>['label'=>'Özet','type'=>'textarea'],'body'=>['label'=>'İçerik','type'=>'textarea'],
        'cover_image'=>['label'=>'Kapak Görseli','type'=>'image'],'meta_title'=>['label'=>'SEO Başlık','type'=>'text'],'meta_description'=>['label'=>'Meta Açıklama','type'=>'textarea'],
        'published_at'=>['label'=>'Yayın Tarihi','type'=>'datetime-local'],'is_active'=>['label'=>'Aktif','type'=>'checkbox'],'sort_order'=>['label'=>'Sıra','type'=>'number']
    ]],
    'pages'=>['label'=>'Kurumsal Sayfalar','table'=>'pages','title'=>'title','fields'=>[
        'slug'=>['label'=>'Slug','type'=>'text'],'eyebrow'=>['label'=>'Üst Başlık','type'=>'text'],'title'=>['label'=>'Başlık','type'=>'text'],'intro'=>['label'=>'Giriş','type'=>'textarea'],
        'body'=>['label'=>'İçerik','type'=>'textarea'],'hero_image'=>['label'=>'Hero Görseli','type'=>'image'],'meta_title'=>['label'=>'SEO Başlık','type'=>'text'],
        'meta_description'=>['label'=>'Meta Açıklama','type'=>'textarea'],'is_active'=>['label'=>'Aktif','type'=>'checkbox']
    ]],
];

$settingsFields = [
    'site_name'=>'Site / Firma Adı','logo_mark'=>'Logo Kısaltması','tagline'=>'Alt Slogan',
    'phone'=>'Telefon','whatsapp'=>'WhatsApp (905...)','email'=>'E-posta','address'=>'Adres / Konum',
    'working_hours'=>'Çalışma Saatleri','meta_description'=>'Genel Meta Açıklama','footer_text'=>'Footer Açıklaması',
    'about_image'=>'Hakkımızda Görsel URL','why_image'=>'Neden Biz Görsel URL',
    'contact_title'=>'Ana Sayfa Teklif Kutusu Başlığı','contact_body'=>'Ana Sayfa Teklif Kutusu Açıklaması',
    'quick_cta_1_title'=>'Hızlı CTA 1 Başlık','quick_cta_1_body'=>'Hızlı CTA 1 Açıklama',
    'quick_cta_1_primary_label'=>'Hızlı CTA 1 Ana Buton','quick_cta_1_primary_url'=>'Hızlı CTA 1 Ana Link',
    'quick_cta_1_secondary_label'=>'Hızlı CTA 1 İkinci Buton','quick_cta_1_whatsapp_text'=>'Hızlı CTA 1 WhatsApp Mesajı',
    'quick_cta_2_title'=>'Hızlı CTA 2 Başlık','quick_cta_2_body'=>'Hızlı CTA 2 Açıklama',
    'quick_cta_2_primary_label'=>'Hızlı CTA 2 Ana Buton','quick_cta_2_secondary_label'=>'Hızlı CTA 2 İkinci Buton'
];

$module = $_GET['module'] ?? 'dashboard';
$notice = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = $_POST['action'] ?? '';

    if ($action === 'save_settings') {
        foreach ($settingsFields as $key => $label) {
            $value = trim((string)($_POST[$key] ?? ''));
            $stmt = db()->prepare('INSERT INTO settings (setting_key,setting_value) VALUES (?,?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)');
            $stmt->execute([$key,$value]);
        }
        header('Location: ?module=settings&saved=1'); exit;
    }

    if ($action === 'change_password') {
        $password = (string)($_POST['new_password'] ?? '');
        if (strlen($password) < 8) {
            $notice = 'Şifre en az 8 karakter olmalı.';
        } else {
            $stmt = db()->prepare('UPDATE admins SET password_hash=? WHERE id=?');
            $stmt->execute([password_hash($password,PASSWORD_DEFAULT),$_SESSION['admin_id']]);
            $notice = 'Şifre güncellendi.';
        }
    }

    if (isset($modules[$module]) && $action === 'save_item') {
        $cfg = $modules[$module];
        $data = [];
        foreach ($cfg['fields'] as $field => $meta) {
            $type = $meta['type'] ?? 'text';
            if ($type === 'checkbox') {
                $data[$field] = isset($_POST[$field]) ? 1 : 0;
            } elseif ($type === 'image') {
                $uploaded = upload_image($field.'_upload');
                $data[$field] = $uploaded ?: trim((string)($_POST[$field] ?? ''));
            } elseif ($type === 'number') {
                $data[$field] = (int)($_POST[$field] ?? 0);
            } elseif ($type === 'datetime-local') {
                $v = trim((string)($_POST[$field] ?? ''));
                $data[$field] = $v === '' ? null : str_replace('T',' ',$v).':00';
            } else {
                $data[$field] = trim((string)($_POST[$field] ?? ''));
            }
        }
        if (array_key_exists('slug',$data) && $data['slug']==='' && !empty($data['title'])) $data['slug']=slugify($data['title']);
        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            $sets=[];$vals=[];
            foreach($data as $k=>$v){$sets[]="{$k}=?";$vals[]=$v;}
            $vals[]=$id;
            db()->prepare("UPDATE {$cfg['table']} SET ".implode(',',$sets)." WHERE id=?")->execute($vals);
        } else {
            $cols=array_keys($data);
            $marks=array_fill(0,count($cols),'?');
            db()->prepare("INSERT INTO {$cfg['table']} (".implode(',',$cols).") VALUES (".implode(',',$marks).")")->execute(array_values($data));
        }
        header('Location: ?module='.urlencode($module).'&saved=1'); exit;
    }

    if (isset($modules[$module]) && $action === 'delete_item') {
        $id=(int)($_POST['id'] ?? 0);
        if($id) db()->prepare("DELETE FROM {$modules[$module]['table']} WHERE id=?")->execute([$id]);
        header('Location: ?module='.urlencode($module).'&deleted=1'); exit;
    }
}

if (isset($_GET['saved'])) $notice='Değişiklikler kaydedildi.';
if (isset($_GET['deleted'])) $notice='Kayıt silindi.';

function admin_icon(string $name): string {
    $icons = [
        'dashboard'=>'<path d="M4 13h6V4H4v9Zm0 7h6v-5H4v5Zm10 0h6v-9h-6v9Zm0-16v5h6V4h-6Z"/>',
        'settings'=>'<path d="M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm8.9 4a7 7 0 0 0-.1-1l2-1.6-2-3.4-2.5 1a8 8 0 0 0-1.7-1L16.2 3h-4l-.4 3a8 8 0 0 0-1.7 1L7.6 6 5.6 9.4l2 1.6a7 7 0 0 0 0 2L5.6 14.6 7.6 18l2.5-1a8 8 0 0 0 1.7 1l.4 3h4l.4-3a8 8 0 0 0 1.7-1l2.5 1 2-3.4-2-1.6c.1-.3.1-.7.1-1Z"/>',
        'layout'=>'<path d="M4 5h16v14H4V5Zm2 2v3h12V7H6Zm0 5v5h5v-5H6Zm7 0v5h5v-5h-5Z"/>',
        'image'=>'<path d="M4 5h16v14H4V5Zm2 2v8.5l3.5-3.5 2.5 2.5 2.5-2.5 3.5 3.5V7H6Zm3 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z"/>',
        'chart'=>'<path d="M5 20V10h3v10H5Zm5 0V4h3v16h-3Zm5 0v-7h3v7h-3Z"/>',
        'briefcase'=>'<path d="M9 5V3h6v2h5v14H4V5h5Zm2 0h2V4h-2v1Zm-5 2v3h12V7H6Zm0 5v5h12v-5H6Z"/>',
        'building'=>'<path d="M5 21V4h10v4h4v13H5Zm2-2h2v-2H7v2Zm0-4h2v-2H7v2Zm0-4h2V9H7v2Zm4 8h2v-2h-2v2Zm0-4h2v-2h-2v2Zm0-4h2V9h-2v2Zm4 8h2v-2h-2v2Zm0-4h2v-2h-2v2Z"/>',
        'star'=>'<path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9L12 3Z"/>',
        'message'=>'<path d="M4 5h16v12H8l-4 4V5Zm3 4h10V7H7v2Zm0 4h7v-2H7v2Z"/>',
        'map'=>'<path d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3V6Zm6-.8L5 7.2v10.6l4-2V5.2Zm2 .1v10.6l3 1.5V6.8l-3-1.5Zm5 1.5v10.6l3-1.5V5.3l-3 1.5Z"/>',
        'help'=>'<path d="M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18Zm0 16a7 7 0 1 1 0-14 7 7 0 0 1 0 14Zm-1-4h2v2h-2v-2Zm1-9c2 0 3.5 1.2 3.5 3 0 1.5-.8 2.3-2 3.1-.8.5-1.1.8-1.1 1.9h-1.9c0-1.7.5-2.4 1.7-3.2.9-.6 1.3-1 1.3-1.7 0-.8-.6-1.3-1.5-1.3s-1.5.5-1.7 1.5l-1.8-.5C8.9 7 10.2 6 12 6Z"/>',
        'edit'=>'<path d="M4 17.5V21h3.5L18.8 9.7l-3.5-3.5L4 17.5ZM20.7 7.8a1 1 0 0 0 0-1.4l-3.1-3.1a1 1 0 0 0-1.4 0l-1.7 1.7 3.5 3.5 1.7-1.7Z"/>',
        'pages'=>'<path d="M6 3h9l4 4v14H6V3Zm8 2v3h3l-3-3ZM8 11h8v2H8v-2Zm0 4h8v2H8v-2Z"/>',
        'lock'=>'<path d="M7 10V8a5 5 0 0 1 10 0v2h2v11H5V10h2Zm2 0h6V8a3 3 0 0 0-6 0v2Zm3 4a2 2 0 0 0-1 3.7V19h2v-1.3A2 2 0 0 0 12 14Z"/>',
        'external'=>'<path d="M13 4h7v7h-2V7.4l-8.3 8.3-1.4-1.4L16.6 6H13V4ZM5 6h6v2H7v9h9v-4h2v6H5V6Z"/>',
        'logout'=>'<path d="M10 4H4v16h6v-2H6V6h4V4Zm4.6 4.6L13.2 10H9v2h4.2l1.4 1.4L16 12l-3-3-1.4 1.4 3 3L16 12l-1.4-1.4Z"/>',
        'plus'=>'<path d="M11 5h2v6h6v2h-6v6h-2v-6H5v-2h6V5Z"/>',
        'check'=>'<path d="m9.2 16.2-4.1-4.1 1.4-1.4 2.7 2.7 8.3-8.3 1.4 1.4-9.7 9.7Z"/>',
    ];
    $path = $icons[$name] ?? $icons['layout'];
    return '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">'.$path.'</svg>';
}

function module_icon(string $key): string {
    return match($key) {
        'home_sections' => 'layout',
        'sliders' => 'image',
        'home_stats' => 'chart',
        'services' => 'briefcase',
        'projects' => 'building',
        'home_features' => 'star',
        'testimonials' => 'message',
        'service_areas' => 'map',
        'faqs' => 'help',
        'posts' => 'edit',
        'pages' => 'pages',
        default => 'layout',
    };
}

function admin_field(array $meta, string $name, $value): string {
    $label=e($meta['label'] ?? $name);
    $type=$meta['type'] ?? 'text';
    $v=e((string)$value);
    if($type==='textarea') return "<label class="admin-field full"><span>{$label}</span><textarea name="{$name}">{$v}</textarea></label>";
    if($type==='checkbox') return "<label class="admin-toggle"><input type="checkbox" name="{$name}" value="1" ".($value?'checked':'')."><span class="admin-toggle-ui"></span><span>{$label}</span></label>";
    if($type==='select'){
        $out="<label class="admin-field"><span>{$label}</span><select name="{$name}">";
        foreach(($meta['options']??[]) as $k=>$txt){$sel=((string)$value===(string)$k)?' selected':'';$out.="<option value="".e($k).""{$sel}>".e($txt)."</option>";}
        return $out."</select></label>";
    }
    if($type==='image') return "<label class="admin-field full"><span>{$label}</span><input type="text" name="{$name}" value="{$v}" placeholder="https://... veya uploads/..."><small>URL kullanabilir veya aşağıdan dosya yükleyebilirsiniz.</small><input class="admin-file" type="file" name="{$name}_upload" accept="image/jpeg,image/png,image/webp,image/avif"></label>";
    $htmlType=$type==='datetime-local'?'datetime-local':($type==='number'?'number':'text');
    if($type==='datetime-local' && $value) $v=e(str_replace(' ','T',substr((string)$value,0,16)));
    return "<label class="admin-field"><span>{$label}</span><input type="{$htmlType}" name="{$name}" value="{$v}"></label>";
}

$counts=[];
foreach(['services','projects','sliders','posts'] as $t){$counts[$t]=(int)db()->query("SELECT COUNT(*) FROM {$t}")->fetchColumn();}

$activeCounts=[];
foreach(['services','projects','sliders','posts'] as $t){$activeCounts[$t]=(int)db()->query("SELECT COUNT(*) FROM {$t} WHERE is_active=1")->fetchColumn();}

$pageTitle = $module==='dashboard' ? 'Dashboard' : ($module==='settings' ? 'Genel Ayarlar' : ($module==='account' ? 'Hesap & Güvenlik' : ($modules[$module]['label'] ?? 'Yönetim')));
$navGroups = [
    'Site Yönetimi' => ['settings','home_sections','sliders','home_stats'],
    'İçerik' => ['services','projects','posts','pages'],
    'Güven & Dönüşüm' => ['home_features','testimonials','service_areas','faqs'],
];
?><!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="theme-color" content="#0c2232">
<title><?= e($pageTitle) ?> · NetVera Admin</title>
<link rel="stylesheet" href="admin.css">
</head>
<body>
<div class="admin-shell">
<aside class="admin-sidebar" data-sidebar>
  <div class="admin-brand-wrap">
    <div class="admin-brand-mark">NV</div>
    <div class="admin-brand-copy"><strong>NetVera</strong><span>Construction CMS</span></div>
    <button class="admin-mobile-close" type="button" data-sidebar-close aria-label="Menüyü kapat">×</button>
  </div>

  <nav class="admin-nav" aria-label="Yönetim menüsü">
    <a href="?module=dashboard" class="admin-nav-link <?= $module==='dashboard'?'active':'' ?>"><?= admin_icon('dashboard') ?><span>Dashboard</span></a>
    <?php foreach($navGroups as $groupLabel=>$keys): ?>
      <div class="admin-nav-group-title"><?= e($groupLabel) ?></div>
      <?php foreach($keys as $key): ?>
        <?php if($key==='settings'): ?>
          <a href="?module=settings" class="admin-nav-link <?= $module==='settings'?'active':'' ?>"><?= admin_icon('settings') ?><span>Genel Ayarlar</span></a>
        <?php elseif(isset($modules[$key])): ?>
          <a href="?module=<?= e($key) ?>" class="admin-nav-link <?= $module===$key?'active':'' ?>"><?= admin_icon(module_icon($key)) ?><span><?= e($modules[$key]['label']) ?></span></a>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </nav>

  <div class="admin-sidebar-footer">
    <a href="?module=account" class="admin-nav-link <?= $module==='account'?'active':'' ?>"><?= admin_icon('lock') ?><span>Hesap & Şifre</span></a>
    <a href="<?= e(app_url()) ?>" target="_blank" rel="noopener" class="admin-nav-link"><?= admin_icon('external') ?><span>Siteyi Gör</span></a>
    <a href="<?= e(app_url('admin/logout.php')) ?>" class="admin-nav-link admin-nav-danger"><?= admin_icon('logout') ?><span>Çıkış Yap</span></a>
    <div class="admin-version">NetVera Pro · v1.0</div>
  </div>
</aside>

<div class="admin-sidebar-backdrop" data-sidebar-backdrop></div>

<main class="admin-main">
  <header class="admin-topbar">
    <div class="admin-topbar-left">
      <button class="admin-menu-button" type="button" data-sidebar-open aria-label="Menüyü aç"><?= admin_icon('layout') ?></button>
      <div>
        <div class="admin-breadcrumb">NetVera / <?= e($pageTitle) ?></div>
        <h1><?= e($pageTitle) ?></h1>
      </div>
    </div>
    <div class="admin-topbar-actions">
      <a class="admin-ghost-btn" href="<?= e(app_url()) ?>" target="_blank" rel="noopener"><?= admin_icon('external') ?><span>Siteyi Gör</span></a>
      <div class="admin-user">
        <div class="admin-user-avatar"><?= e(mb_strtoupper(mb_substr($_SESSION['admin_name'] ?? 'A',0,1))) ?></div>
        <div class="admin-user-copy"><strong><?= e($_SESSION['admin_name'] ?? 'Admin') ?></strong><span>Yönetici</span></div>
      </div>
    </div>
  </header>

  <div class="admin-content">
    <?php if($notice): ?><div class="admin-alert admin-alert-success"><?= admin_icon('check') ?><span><?= e($notice) ?></span></div><?php endif; ?>

    <?php if($module==='dashboard'): ?>
      <section class="admin-hero">
        <div>
          <span class="admin-eyebrow">YÖNETİM MERKEZİ</span>
          <h2>Siteyi tek panelden yönetin.</h2>
          <p>İçerik, projeler, slider, dönüşüm alanları ve SEO ayarlarını kodla uğraşmadan güncelleyin.</p>
        </div>
        <div class="admin-hero-actions">
          <a class="admin-btn" href="?module=projects"><?= admin_icon('plus') ?> Yeni Proje</a>
          <a class="admin-btn admin-btn-light" href="?module=sliders">Slider Yönetimi</a>
        </div>
      </section>

      <section class="admin-grid">
        <a class="admin-kpi" href="?module=services"><div class="admin-kpi-icon"><?= admin_icon('briefcase') ?></div><div><span>Hizmetler</span><strong><?= $counts['services'] ?></strong><small><?= $activeCounts['services'] ?> yayında</small></div></a>
        <a class="admin-kpi" href="?module=projects"><div class="admin-kpi-icon"><?= admin_icon('building') ?></div><div><span>Projeler</span><strong><?= $counts['projects'] ?></strong><small><?= $activeCounts['projects'] ?> yayında</small></div></a>
        <a class="admin-kpi" href="?module=sliders"><div class="admin-kpi-icon"><?= admin_icon('image') ?></div><div><span>Slider</span><strong><?= $counts['sliders'] ?></strong><small><?= $activeCounts['sliders'] ?> aktif</small></div></a>
        <a class="admin-kpi" href="?module=posts"><div class="admin-kpi-icon"><?= admin_icon('edit') ?></div><div><span>Blog</span><strong><?= $counts['posts'] ?></strong><small><?= $activeCounts['posts'] ?> yayında</small></div></a>
      </section>

      <section class="admin-dashboard-grid">
        <div class="admin-card admin-card-large">
          <div class="admin-card-head"><div><span class="admin-card-kicker">HIZLI İŞLEMLER</span><h3>Sık kullanılan yönetim alanları</h3></div></div>
          <div class="admin-quick-grid">
            <a href="?module=projects" class="admin-quick-item"><?= admin_icon('building') ?><div><strong>Projeleri yönet</strong><span>Proje ekle, düzenle ve vitrine çıkar.</span></div><b>→</b></a>
            <a href="?module=sliders" class="admin-quick-item"><?= admin_icon('image') ?><div><strong>Sliderı güncelle</strong><span>Hero görselleri, metinleri ve CTA'ları değiştir.</span></div><b>→</b></a>
            <a href="?module=services" class="admin-quick-item"><?= admin_icon('briefcase') ?><div><strong>Hizmetleri düzenle</strong><span>Hizmet detaylarını ve SEO alanlarını yönet.</span></div><b>→</b></a>
            <a href="?module=settings" class="admin-quick-item"><?= admin_icon('settings') ?><div><strong>Genel ayarlar</strong><span>İletişim, marka ve ana CTA ayarlarını değiştir.</span></div><b>→</b></a>
          </div>
        </div>

        <div class="admin-card">
          <div class="admin-card-head"><div><span class="admin-card-kicker">SİSTEM</span><h3>Yayın durumu</h3></div><span class="admin-live-dot">Canlı</span></div>
          <div class="admin-status-list">
            <div><span>Ana sayfa</span><b>Aktif</b></div>
            <div><span>PHP / MySQL</span><b>Bağlı</b></div>
            <div><span>Admin oturumu</span><b>Güvenli</b></div>
            <div><span>İçerik yönetimi</span><b>Hazır</b></div>
          </div>
          <a class="admin-text-link" href="<?= e(app_url()) ?>" target="_blank">Canlı siteyi aç →</a>
        </div>
      </section>

    <?php elseif($module==='settings'): ?>
      <section class="admin-card">
        <div class="admin-card-head"><div><span class="admin-card-kicker">GENEL AYARLAR</span><h3>Marka, iletişim ve dönüşüm alanları</h3><p>Bu alanlar sitenin genelinde ve ana sayfadaki CTA'larda kullanılır.</p></div></div>
        <form class="admin-form" method="post">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <input type="hidden" name="action" value="save_settings">
          <?php $longSettings=['meta_description','footer_text','contact_body','quick_cta_1_body','quick_cta_1_whatsapp_text','quick_cta_2_body']; ?>
          <?php foreach($settingsFields as $key=>$label): ?>
            <label class="admin-field <?= in_array($key,$longSettings,true)?'full':'' ?>">
              <span><?= e($label) ?></span>
              <?php if(in_array($key,$longSettings,true)): ?>
                <textarea name="<?= e($key) ?>"><?= e(setting($key)) ?></textarea>
              <?php else: ?>
                <input name="<?= e($key) ?>" value="<?= e(setting($key)) ?>">
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
          <div class="admin-form-actions full"><button class="admin-btn" type="submit"><?= admin_icon('check') ?> Ayarları Kaydet</button></div>
        </form>
      </section>

    <?php elseif($module==='account'): ?>
      <section class="admin-card admin-card-narrow">
        <div class="admin-card-head"><div><span class="admin-card-kicker">GÜVENLİK</span><h3>Yönetici şifresi</h3><p>En az 8 karakterden oluşan güçlü bir şifre kullanın.</p></div></div>
        <form class="admin-form" method="post">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <input type="hidden" name="action" value="change_password">
          <label class="admin-field full"><span>Yeni Şifre</span><input type="password" name="new_password" minlength="8" required autocomplete="new-password"></label>
          <div class="admin-form-actions full"><button class="admin-btn" type="submit"><?= admin_icon('lock') ?> Şifreyi Güncelle</button></div>
        </form>
      </section>

    <?php elseif(isset($modules[$module])):
      $cfg=$modules[$module]; $editId=(int)($_GET['edit'] ?? 0); $edit=null;
      if($editId){$st=db()->prepare("SELECT * FROM {$cfg['table']} WHERE id=?");$st->execute([$editId]);$edit=$st->fetch() ?: null;}
      $list=db()->query("SELECT * FROM {$cfg['table']} ORDER BY ".(array_key_exists('sort_order',$cfg['fields'])?'sort_order ASC, ':'')."id DESC LIMIT 200")->fetchAll();
    ?>
      <section class="admin-card">
        <div class="admin-card-head">
          <div><span class="admin-card-kicker"><?= $edit?'KAYIT DÜZENLE':'YENİ KAYIT' ?></span><h3><?= $edit?e((string)($edit[$cfg['title']]??'Kaydı Düzenle')):'Yeni '.$cfg['label'].' kaydı' ?></h3><p>Alanları doldurun ve değişiklikleri kaydedin.</p></div>
          <?php if($edit): ?><a class="admin-ghost-btn" href="?module=<?= e($module) ?>">Düzenlemeyi Kapat</a><?php endif; ?>
        </div>
        <form class="admin-form" method="post" enctype="multipart/form-data">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <input type="hidden" name="action" value="save_item">
          <input type="hidden" name="id" value="<?= (int)($edit['id']??0) ?>">
          <?php foreach($cfg['fields'] as $name=>$meta) echo admin_field($meta,$name,$edit[$name]??''); ?>
          <div class="admin-form-actions full">
            <button class="admin-btn" type="submit"><?= admin_icon('check') ?> <?= $edit?'Değişiklikleri Kaydet':'Kaydı Ekle' ?></button>
            <?php if($edit): ?><a class="admin-btn admin-btn-light" href="?module=<?= e($module) ?>">İptal</a><?php endif; ?>
          </div>
        </form>
      </section>

      <section class="admin-card">
        <div class="admin-card-head">
          <div><span class="admin-card-kicker">KAYITLAR</span><h3><?= e($cfg['label']) ?></h3><p><?= count($list) ?> kayıt listeleniyor.</p></div>
          <span class="admin-count-badge"><?= count($list) ?></span>
        </div>
        <div class="admin-table-wrap">
          <table class="admin-table">
            <thead><tr><th>#</th><th>Başlık</th><th>Durum</th><th class="admin-table-actions-head">İşlem</th></tr></thead>
            <tbody>
            <?php foreach($list as $row): ?>
              <tr>
                <td class="admin-id-cell"><?= (int)$row['id'] ?></td>
                <td><strong class="admin-row-title"><?= e((string)($row[$cfg['title']]??'')) ?></strong></td>
                <td><?php if(array_key_exists('is_active',$row)): ?><span class="admin-status <?= $row['is_active']?'is-active':'is-passive' ?>"><?= $row['is_active']?'Aktif':'Pasif' ?></span><?php else: ?><span class="admin-status">—</span><?php endif; ?></td>
                <td><div class="admin-actions"><a class="admin-link" href="?module=<?= e($module) ?>&edit=<?= (int)$row['id'] ?>">Düzenle</a><form method="post" onsubmit="return confirm('Bu kayıt silinsin mi?')"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="delete_item"><input type="hidden" name="id" value="<?= (int)$row['id'] ?>"><button class="admin-link danger" type="submit">Sil</button></form></div></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>
    <?php endif; ?>
  </div>
</main>
</div>
<script src="admin.js" defer></script>
</body>
</html>