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
    'about_image'=>'Hakkımızda Görsel URL'
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

function admin_field(array $meta, string $name, $value): string {
    $label=e($meta['label'] ?? $name); $type=$meta['type'] ?? 'text'; $v=e((string)$value);
    if($type==='textarea') return "<label class=\"full\">{$label}<textarea name=\"{$name}\">{$v}</textarea></label>";
    if($type==='checkbox') return "<label class=\"admin-checkbox\"><input type=\"checkbox\" name=\"{$name}\" value=\"1\" ".($value?'checked':'')."> {$label}</label>";
    if($type==='select'){
        $out="<label>{$label}<select name=\"{$name}\">";
        foreach(($meta['options']??[]) as $k=>$txt){$sel=((string)$value===(string)$k)?' selected':'';$out.="<option value=\"".e($k)."\"{$sel}>".e($txt)."</option>";}
        return $out."</select></label>";
    }
    if($type==='image') return "<label class=\"full\">{$label}<input type=\"text\" name=\"{$name}\" value=\"{$v}\" placeholder=\"https://... veya uploads/...\"><span class=\"admin-muted\">veya dosya yükleyin</span><input type=\"file\" name=\"{$name}_upload\" accept=\"image/jpeg,image/png,image/webp,image/avif\"></label>";
    $htmlType=$type==='datetime-local'?'datetime-local':($type==='number'?'number':'text');
    if($type==='datetime-local' && $value) $v=e(str_replace(' ','T',substr((string)$value,0,16)));
    return "<label>{$label}<input type=\"{$htmlType}\" name=\"{$name}\" value=\"{$v}\"></label>";
}

$counts=[];
foreach(['services','projects','sliders','posts'] as $t){$counts[$t]=(int)db()->query("SELECT COUNT(*) FROM {$t}")->fetchColumn();}
?><!doctype html><html lang="tr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>NetVera Admin</title><link rel="stylesheet" href="<?= e(app_url('admin/admin.css')) ?>"></head><body>
<div class="admin-shell">
<aside class="admin-sidebar"><h2>NetVera İnşaat Pro</h2>
<a href="?module=dashboard" class="<?= $module==='dashboard'?'active':'' ?>">Dashboard</a>
<a href="?module=settings" class="<?= $module==='settings'?'active':'' ?>">Genel Ayarlar</a>
<?php foreach($modules as $key=>$cfg): ?><a href="?module=<?= e($key) ?>" class="<?= $module===$key?'active':'' ?>"><?= e($cfg['label']) ?></a><?php endforeach; ?>
<a href="?module=account" class="<?= $module==='account'?'active':'' ?>">Hesap / Şifre</a>
<a href="<?= e(app_url()) ?>" target="_blank">Siteyi Gör ↗</a>
<a href="<?= e(app_url('admin/logout.php')) ?>">Çıkış</a>
</aside>
<main class="admin-main">
<div class="admin-top"><div><h1><?= e($module==='dashboard'?'Dashboard':($module==='settings'?'Genel Ayarlar':($module==='account'?'Hesap / Şifre':($modules[$module]['label']??'Yönetim')))) ?></h1><div class="admin-muted">Hoş geldin, <?= e($_SESSION['admin_name'] ?? 'Admin') ?></div></div></div>
<?php if($notice): ?><div class="admin-alert"><?= e($notice) ?></div><?php endif; ?>

<?php if($module==='dashboard'): ?>
<div class="admin-grid"><div class="admin-kpi"><strong><?= $counts['services'] ?></strong><span>Hizmet</span></div><div class="admin-kpi"><strong><?= $counts['projects'] ?></strong><span>Proje</span></div><div class="admin-kpi"><strong><?= $counts['sliders'] ?></strong><span>Slider</span></div><div class="admin-kpi"><strong><?= $counts['posts'] ?></strong><span>Blog Yazısı</span></div></div>
<div class="admin-card"><h3>Yönetilebilir Yapı</h3><p class="admin-muted">Slider, ana sayfa bölüm başlıkları, hizmetler, projeler, yorumlar, süreç, güven alanları, bölgeler, SSS, blog, kurumsal sayfalar ve site iletişim bilgileri bu panelden yönetilir.</p></div>

<?php elseif($module==='settings'): ?>
<div class="admin-card"><form class="admin-form" method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="save_settings">
<?php foreach($settingsFields as $key=>$label): ?><label class="<?= in_array($key,['meta_description','footer_text'])?'full':'' ?>"><?= e($label) ?><?php if(in_array($key,['meta_description','footer_text'])): ?><textarea name="<?= e($key) ?>"><?= e(setting($key)) ?></textarea><?php else: ?><input name="<?= e($key) ?>" value="<?= e(setting($key)) ?>"><?php endif; ?></label><?php endforeach; ?>
<div class="full"><button class="admin-btn" type="submit">Ayarları Kaydet</button></div></form></div>

<?php elseif($module==='account'): ?>
<div class="admin-card"><form class="admin-form" method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="change_password"><label>Yeni Şifre<input type="password" name="new_password" minlength="8" required></label><div style="align-self:end"><button class="admin-btn" type="submit">Şifreyi Güncelle</button></div></form></div>

<?php elseif(isset($modules[$module])):
$cfg=$modules[$module]; $editId=(int)($_GET['edit'] ?? 0); $edit=null;
if($editId){$st=db()->prepare("SELECT * FROM {$cfg['table']} WHERE id=?");$st->execute([$editId]);$edit=$st->fetch() ?: null;}
$list=db()->query("SELECT * FROM {$cfg['table']} ORDER BY ".(array_key_exists('sort_order',$cfg['fields'])?'sort_order ASC, ':'')."id DESC LIMIT 200")->fetchAll();
?>
<div class="admin-card"><h3><?= $edit?'Kaydı Düzenle':'Yeni Kayıt' ?></h3><form class="admin-form" method="post" enctype="multipart/form-data"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="save_item"><input type="hidden" name="id" value="<?= (int)($edit['id']??0) ?>">
<?php foreach($cfg['fields'] as $name=>$meta) echo admin_field($meta,$name,$edit[$name]??''); ?>
<div class="full"><button class="admin-btn" type="submit"><?= $edit?'Güncelle':'Ekle' ?></button><?php if($edit): ?> <a class="admin-link" href="?module=<?= e($module) ?>">İptal</a><?php endif; ?></div></form></div>
<div class="admin-card"><h3>Kayıtlar</h3><div style="overflow:auto"><table class="admin-table"><thead><tr><th>ID</th><th>Başlık</th><th>Durum</th><th>İşlem</th></tr></thead><tbody>
<?php foreach($list as $row): ?><tr><td><?= (int)$row['id'] ?></td><td><?= e((string)($row[$cfg['title']]??'')) ?></td><td><?= array_key_exists('is_active',$row)?($row['is_active']?'Aktif':'Pasif'):'—' ?></td><td><div class="admin-actions"><a class="admin-link" href="?module=<?= e($module) ?>&edit=<?= (int)$row['id'] ?>">Düzenle</a><form method="post" onsubmit="return confirm('Bu kayıt silinsin mi?')"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="delete_item"><input type="hidden" name="id" value="<?= (int)$row['id'] ?>"><button class="admin-link danger" type="submit">Sil</button></form></div></td></tr><?php endforeach; ?>
</tbody></table></div></div>
<?php endif; ?>
</main></div></body></html>
