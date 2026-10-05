<?php
require_once dirname(__DIR__) . '/app/bootstrap.php';
require_admin();

$seoFields = [
    'meta_title'=>['label'=>'SEO Başlık (Title)','type'=>'text','help'=>'Sayfayı ve arama niyetini net anlatan benzersiz başlık.'],
    'meta_description'=>['label'=>'Meta Açıklama','type'=>'textarea','help'=>'Sayfayı doğru özetleyen, tıklama niyetini destekleyen açıklama.'],
    'focus_keyword'=>['label'=>'Odak Anahtar Kelime','type'=>'text','help'=>'İçeriğin ana arama niyeti. Meta keywords olarak yayınlanmaz; editoryal rehberdir.'],
    'secondary_keywords'=>['label'=>'Yardımcı Anahtar Kelimeler','type'=>'textarea','help'=>'Virgülle ayırın. Yakın anlamlı, alt konu ve yerel sorguları ekleyin.'],
    'canonical_url'=>['label'=>'Canonical URL','type'=>'text','help'=>'Boş bırakılırsa sistem sayfanın kendi temiz URL’sini kullanır.'],
    'og_title'=>['label'=>'Open Graph Başlık','type'=>'text','help'=>'Sosyal paylaşım ve bazı önizleme yüzeyleri için.'],
    'og_description'=>['label'=>'Open Graph Açıklama','type'=>'textarea'],
    'og_image'=>['label'=>'Open Graph / Preferred Image','type'=>'image','help'=>'Google görsel önizlemeleri için de güçlü bir tercih sinyalidir.'],
    'image_alt'=>['label'=>'Ana Görsel Alt Metni','type'=>'text','help'=>'Görselin içeriğini doğal ve erişilebilir biçimde açıklayın. Anahtar kelime doldurmayın.'],
    'image_title'=>['label'=>'Ana Görsel Başlığı','type'=>'text','help'=>'İsteğe bağlı görsel title bilgisi.'],
    'robots'=>['label'=>'Robots Direktifi','type'=>'select','options'=>[
        'index,follow,max-image-preview:large'=>'Index + Follow + Büyük Görsel Önizleme',
        'index,follow'=>'Index + Follow',
        'noindex,follow'=>'Noindex + Follow',
        'noindex,nofollow'=>'Noindex + Nofollow',
    ]],
    'schema_type'=>['label'=>'Schema.org Türü','type'=>'text','help'=>'Örn: Service, BlogPosting, AboutPage, ContactPage, CreativeWork.'],
    'geo_target'=>['label'=>'GEO / Hedef Konum','type'=>'text','help'=>'Örn: Alanya, Antalya veya hizmet verilen semt/bölge.'],
    'aio_summary'=>['label'=>'AIO / AI Kısa Özeti','type'=>'textarea','help'=>'İçeriğin doğrulanabilir, kısa ve net uzmanlık özeti. Schema description/abstract içinde kullanılır.'],
];

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
        'image_alt'=>['label'=>'Görsel Alt Metni','type'=>'text','help'=>'Görseli doğal biçimde tarif edin.'],
        'image_title'=>['label'=>'Görsel Başlığı','type'=>'text'],
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
        'title'=>['label'=>'Başlık','type'=>'text'],'slug'=>['label'=>'SEO Slug','type'=>'text','help'=>'Kısa, okunabilir, tireli URL yolu.'],
        'summary'=>['label'=>'Hizmet Özeti','type'=>'textarea','maxlength'=>140,'help'=>'Ana sayfa hizmet kartında gösterilir. En fazla 140 karakter; kısa, net ve hizmeti anlatan tek bir özet yazın.'],'body'=>['label'=>'Detay İçerik','type'=>'textarea'],
        'cover_image'=>['label'=>'Kapak Görseli','type'=>'image'],
        ...$seoFields,
        'schema_type'=>['label'=>'Schema.org Türü','type'=>'text','help'=>'Hizmet sayfalarında önerilen temel tür: Service'],
        'is_featured'=>['label'=>'Ana Sayfada Göster','type'=>'checkbox'],'is_active'=>['label'=>'Aktif','type'=>'checkbox'],'sort_order'=>['label'=>'Sıra','type'=>'number']
    ]],
    'projects'=>['label'=>'Projeler','table'=>'projects','title'=>'title','fields'=>[
        'title'=>['label'=>'Başlık','type'=>'text'],'slug'=>['label'=>'SEO Slug','type'=>'text'],'category'=>['label'=>'Kategori','type'=>'text'],
        'location'=>['label'=>'Konum','type'=>'text'],'status'=>['label'=>'Durum','type'=>'text'],'area'=>['label'=>'Alan','type'=>'text'],'project_year'=>['label'=>'Yıl','type'=>'text'],
        'summary'=>['label'=>'Kısa Açıklama','type'=>'textarea'],'body'=>['label'=>'Detay İçerik','type'=>'textarea'],
        'cover_image'=>['label'=>'Kapak Görseli','type'=>'image'],'gallery_json'=>['label'=>'Proje Galerisi','type'=>'gallery','help'=>'Bilgisayardan birden fazla görsel seçebilirsiniz. Mevcut görseller korunur; yeni seçilenler galeriye eklenir.'],
        ...$seoFields,
        'schema_type'=>['label'=>'Schema.org Türü','type'=>'text','help'=>'Proje sayfalarında CreativeWork kullanılabilir.'],
        'is_featured'=>['label'=>'Ana Sayfada Göster','type'=>'checkbox'],'is_active'=>['label'=>'Aktif','type'=>'checkbox'],'sort_order'=>['label'=>'Sıra','type'=>'number']
    ]],
    'home_features'=>['label'=>'İçerik Maddeleri','table'=>'home_features','title'=>'title','fields'=>[
        'group_key'=>['label'=>'Grup','type'=>'select','options'=>[
            'why'=>'Ana Sayfa · Neden Biz',
            'process'=>'Ana Sayfa · Süreç',
            'trust'=>'Ana Sayfa · Güven',
            'service_flow'=>'Hizmetler · 4 Aşama',
            'service_method'=>'Hizmetler · Çalışma Modeli',
            'contact_process'=>'İletişim · Sonraki Adım',
            'service_scope'=>'Hizmet Detay · Kapsam Maddeleri'
        ]],
        'title'=>['label'=>'Başlık','type'=>'text'],
        'body'=>['label'=>'Açıklama','type'=>'textarea'],
        'icon'=>['label'=>'Numara / İkon','type'=>'text'],
        'link_label'=>['label'=>'Bağlantı Yazısı','type'=>'text','help'=>'Kart bağlantısı gerekmiyorsa boş bırakın.'],
        'link_url'=>['label'=>'Bağlantı Adresi','type'=>'text','help'=>'Örn: hizmet/konut-projeleri veya iletisim'],
        'is_active'=>['label'=>'Aktif','type'=>'checkbox'],'sort_order'=>['label'=>'Sıra','type'=>'number']
    ]],
    'testimonials'=>['label'=>'Müşteri Yorumları','table'=>'testimonials','title'=>'name','fields'=>[
        'name'=>['label'=>'Ad Soyad','type'=>'text'],
        'role'=>['label'=>'Proje / Konum','type'=>'text'],
        'profile_image'=>['label'=>'Profil Fotoğrafı','type'=>'image','help'=>'JPG, PNG, WebP veya AVIF yükleyin. Boş bırakırsanız isim baş harfinden premium avatar oluşturulur.'],
        'quote_text'=>['label'=>'Yorum','type'=>'textarea','maxlength'=>420],
        'rating'=>['label'=>'Yıldız Sayısı','type'=>'number','min'=>1,'max'=>5,'step'=>1,'help'=>'1 ile 5 arasında yıldız sayısı.'],
        'star_color'=>['label'=>'Yıldız Rengi','type'=>'color','default'=>'#FABB05','help'=>'Varsayılan Google yorum sarısı: #FABB05'],
        'is_active'=>['label'=>'Aktif','type'=>'checkbox'],
        'sort_order'=>['label'=>'Sıra','type'=>'number']
    ]],
    'service_areas'=>['label'=>'Hizmet Bölgeleri','table'=>'service_areas','title'=>'title','fields'=>[
        'title'=>['label'=>'Bölge / Semt','type'=>'text'],
        'slug'=>['label'=>'SEO Slug','type'=>'text','help'=>'Örn: oba, mahmutlar, alanya-merkez'],
        'services_text'=>['label'=>'Öne Çıkan Hizmetler','type'=>'text'],
        'summary'=>['label'=>'Bölge Kısa Açıklaması','type'=>'textarea'],
        'body'=>['label'=>'Bölge Detay İçeriği','type'=>'textarea','help'=>'Kopya şehir sayfası değil; bölgeye özel gerçek saha, yapı tipi ve hizmet bilgisini yazın.'],
        'cover_image'=>['label'=>'Bölge Görseli','type'=>'image'],
        ...$seoFields,
        'schema_type'=>['label'=>'Schema.org Türü','type'=>'text','help'=>'Yerel landing sayfası için WebPage veya Place kullanılabilir.'],
        'latitude'=>['label'=>'Enlem','type'=>'text','help'=>'Opsiyonel. Örn: 36.54375'],
        'longitude'=>['label'=>'Boylam','type'=>'text','help'=>'Opsiyonel. Örn: 31.99982'],
        'is_active'=>['label'=>'Aktif','type'=>'checkbox'],'sort_order'=>['label'=>'Sıra','type'=>'number']
    ]],
    'faqs'=>['label'=>'SSS','table'=>'faqs','title'=>'question','fields'=>[
        'question'=>['label'=>'Soru','type'=>'text'],'answer'=>['label'=>'Cevap','type'=>'textarea'],
        'is_active'=>['label'=>'Aktif','type'=>'checkbox'],'sort_order'=>['label'=>'Sıra','type'=>'number']
    ]],
    'posts'=>['label'=>'Blog','table'=>'posts','title'=>'title','fields'=>[
        'title'=>['label'=>'Başlık','type'=>'text'],'slug'=>['label'=>'SEO Slug','type'=>'text'],'excerpt'=>['label'=>'Özet','type'=>'textarea'],'body'=>['label'=>'İçerik','type'=>'textarea'],
        'cover_image'=>['label'=>'Kapak Görseli','type'=>'image'],
        'author_name'=>['label'=>'Yazar / Uzman','type'=>'text','help'=>'E-E-A-T ve makale kimliği için gerçek yazar/uzman adı.'],
        ...$seoFields,
        'schema_type'=>['label'=>'Schema.org Türü','type'=>'text','help'=>'Blog içerikleri için BlogPosting veya Article.'],
        'published_at'=>['label'=>'Yayın Tarihi','type'=>'datetime-local'],'is_active'=>['label'=>'Aktif','type'=>'checkbox'],'sort_order'=>['label'=>'Sıra','type'=>'number']
    ]],
    'page_sections'=>['label'=>'Sayfa Bölümleri','table'=>'page_sections','title'=>'title','fields'=>[
        'page_key'=>['label'=>'Sayfa / Şablon','type'=>'select','options'=>[
            'hakkimizda'=>'Hakkımızda',
            'hizmetler'=>'Hizmetler',
            'projeler'=>'Projeler',
            'blog'=>'Blog',
            'iletisim'=>'İletişim',
            'bolgeler'=>'Hizmet Bölgeleri',
            'hizmet-detay'=>'Hizmet Detay Şablonu',
            'proje-detay'=>'Proje Detay Şablonu',
            'yazi-detay'=>'Blog Detay Şablonu',
            'bolge-detay'=>'Bölge Detay Şablonu'
        ]],
        'section_key'=>['label'=>'Bölüm Anahtarı','type'=>'text','help'=>'Teknik kimliktir; mevcut kayıtlarda değiştirmeyin.'],
        'eyebrow'=>['label'=>'Üst Başlık','type'=>'text'],
        'title'=>['label'=>'Bölüm Başlığı','type'=>'text'],
        'body'=>['label'=>'Açıklama / İçerik','type'=>'textarea'],
        'secondary_text'=>['label'=>'İkincil Metin / Lead','type'=>'textarea'],
        'image'=>['label'=>'Bölüm Görseli','type'=>'image'],
        'button_label'=>['label'=>'Buton Yazısı','type'=>'text'],
        'button_url'=>['label'=>'Buton Linki','type'=>'text'],
        'is_active'=>['label'=>'Aktif','type'=>'checkbox'],
        'sort_order'=>['label'=>'Sıra','type'=>'number']
    ]],
    'pages'=>['label'=>'Sayfalar / Landing','table'=>'pages','title'=>'title','fields'=>[
        'slug'=>['label'=>'SEO Slug','type'=>'text'],'eyebrow'=>['label'=>'Üst Başlık','type'=>'text'],'title'=>['label'=>'Başlık','type'=>'text'],'intro'=>['label'=>'Giriş','type'=>'textarea'],
        'body'=>['label'=>'İçerik','type'=>'textarea'],'hero_image'=>['label'=>'Hero Görseli','type'=>'image'],
        ...$seoFields,
        'schema_type'=>['label'=>'Schema.org Türü','type'=>'text','help'=>'Örn: AboutPage, ContactPage, WebPage.'],
        'is_active'=>['label'=>'Aktif','type'=>'checkbox']
    ]],
];

$settingsGroups = [
    'Marka & İletişim'=>[
        'site_name'=>'Site / Firma Adı','logo_mark'=>'Logo Kısaltması','logo_image'=>'Yatay Logo · Açık Zemin','footer_logo_image'=>'Yatay Logo · Koyu Zemin','favicon_image'=>'Favicon / Tarayıcı İkonu','tagline'=>'Alt Slogan',
        'phone'=>'Telefon','whatsapp'=>'WhatsApp (905...)','email'=>'E-posta','address'=>'Adres / Konum',
        'instagram_url'=>'Instagram URL','facebook_url'=>'Facebook URL',
        'twitter_url'=>'X / Twitter URL','youtube_url'=>'YouTube URL',
        'google_maps_url'=>'Google Harita Linki / Embed URL / Konum',
        'working_hours'=>'Çalışma Saatleri','footer_text'=>'Footer Açıklaması',
        'about_image'=>'Hakkımızda Görseli','about_image_alt'=>'Hakkımızda Görsel Alt Metni','about_image_title'=>'Hakkımızda Görsel Başlığı',
        'why_image'=>'Neden Biz Görseli','why_image_alt'=>'Neden Biz Görsel Alt Metni','why_image_title'=>'Neden Biz Görsel Başlığı',
    ],
    'Navigasyon & Footer'=>[
        'nav_home_label'=>'Menü · Ana Sayfa',
        'nav_about_label'=>'Menü · Kurumsal',
        'nav_services_label'=>'Menü · Hizmetler',
        'nav_projects_label'=>'Menü · Projeler',
        'nav_blog_label'=>'Menü · Blog',
        'nav_contact_label'=>'Menü · İletişim',
        'nav_cta_label'=>'Menü · Ana CTA',
        'mobile_quick_label'=>'Mobil Menü · Hızlı İletişim Başlığı',
        'mobile_social_label'=>'Mobil Menü · Sosyal Medya Başlığı',
        'footer_corporate_title'=>'Footer · Kurumsal Başlığı',
        'footer_services_title'=>'Footer · Hizmetler Başlığı',
        'footer_contact_title'=>'Footer · İletişim Başlığı',
    ],
    'Ana Sayfa SEO'=>[
        'seo_home_title'=>'Ana Sayfa SEO Başlığı',
        'meta_description'=>'Ana Sayfa Meta Açıklaması',
        'seo_focus_keyword'=>'Ana Sayfa Odak Anahtar Kelime',
        'seo_secondary_keywords'=>'Ana Sayfa Yardımcı Anahtar Kelimeler',
        'seo_home_canonical'=>'Ana Sayfa Canonical URL',
        'seo_robots'=>'Ana Sayfa Robots Direktifi',
        'seo_default_og_image'=>'Varsayılan OG / Preferred Image',
        'seo_default_image_alt'=>'Varsayılan Görsel Alt Metni',
    ],
    'Local SEO / GEO'=>[
        'business_legal_name'=>'Resmî İşletme Adı',
        'business_type'=>'Schema İşletme Türü',
        'business_description'=>'İşletme Açıklaması',
        'business_logo'=>'Schema / İşletme Logo Görseli',
        'street_address'=>'Açık Adres',
        'address_locality'=>'İlçe / Şehir',
        'address_region'=>'İl / Bölge',
        'postal_code'=>'Posta Kodu',
        'address_country'=>'Ülke Kodu',
        'latitude'=>'Enlem',
        'longitude'=>'Boylam',
        'service_area'=>'Hizmet Verilen Bölgeler',
        'price_range'=>'Fiyat Aralığı',
        'same_as'=>'Sosyal / Kurumsal Profil URL’leri',
        'founding_date'=>'Kuruluş Tarihi',
    ],
    'AIO / AI Görünürlüğü'=>[
        'aio_brand_summary'=>'Marka Kısa Özeti',
        'aio_expertise'=>'Uzmanlık Alanları',
        'indexnow_key'=>'IndexNow Anahtarı',
    ],
    'Doğrulama'=>[
        'google_site_verification'=>'Google Site Verification',
        'bing_site_verification'=>'Bing Site Verification',
    ],
    'Ana Sayfa Görünümü'=>[
        'home_testimonials_limit'=>'Ana Sayfada Gösterilecek Yorum Sayısı',
    ],
    'Dönüşüm Alanları'=>[
        'contact_title'=>'Ana Sayfa Teklif Kutusu Başlığı','contact_body'=>'Ana Sayfa Teklif Kutusu Açıklaması',
        'quick_cta_1_title'=>'Hızlı CTA 1 Başlık','quick_cta_1_body'=>'Hızlı CTA 1 Açıklama',
        'quick_cta_1_primary_label'=>'Hızlı CTA 1 Ana Buton','quick_cta_1_primary_url'=>'Hızlı CTA 1 Ana Link',
        'quick_cta_1_secondary_label'=>'Hızlı CTA 1 İkinci Buton','quick_cta_1_whatsapp_text'=>'Hızlı CTA 1 WhatsApp Mesajı',
        'quick_cta_2_title'=>'Hızlı CTA 2 Başlık','quick_cta_2_body'=>'Hızlı CTA 2 Açıklama',
        'quick_cta_2_primary_label'=>'Hızlı CTA 2 Ana Buton','quick_cta_2_secondary_label'=>'Hızlı CTA 2 İkinci Buton',
    ],
];
$settingsFields=[];
foreach($settingsGroups as $groupFields) $settingsFields=array_merge($settingsFields,$groupFields);
$settingsImageFields = [
    'logo_image'=>'Yatay Logo · Açık Zemin',
    'footer_logo_image'=>'Yatay Logo · Koyu Zemin',
    'favicon_image'=>'Favicon / Tarayıcı İkonu',
    'about_image'=>'Hakkımızda Görseli',
    'why_image'=>'Neden Biz Görseli',
    'seo_default_og_image'=>'Varsayılan OG / Paylaşım Görseli',
    'business_logo'=>'Schema / İşletme Logo Görseli',
];

$module = $_GET['module'] ?? 'dashboard';
$notice = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = $_POST['action'] ?? '';

    if ($action === 'save_settings') {
        foreach ($settingsFields as $key => $label) {
            $value = trim((string)($_POST[$key] ?? ''));
            if (isset($settingsImageFields[$key])) {
                $uploaded = upload_image($key.'_upload');
                if ($uploaded) $value = $uploaded;
            }
            if ($key === 'home_testimonials_limit') {
                $value = (string)max(1, (int)$value);
            }
            $stmt = db()->prepare('INSERT INTO settings (setting_key,setting_value) VALUES (?,?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)');
            $stmt->execute([$key,$value]);
        }
        seo_indexnow_submit([app_url()]);
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
            } elseif ($type === 'gallery') {
                $existingRaw=trim((string)($_POST[$field] ?? '[]'));
                $existing=json_decode($existingRaw,true);
                if(!is_array($existing)){
                    $existing=array_values(array_filter(array_map('trim',preg_split('/\R|,/', $existingRaw) ?: [])));
                }
                $newImages=upload_images($field.'_upload',16);
                $data[$field]=json_encode(array_values(array_unique(array_merge($existing,$newImages))),JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
            } elseif ($type === 'number') {
                $number = (int)($_POST[$field] ?? 0);
                if (isset($meta['min'])) $number = max((int)$meta['min'], $number);
                if (isset($meta['max'])) $number = min((int)$meta['max'], $number);
                $data[$field] = $number;
            } elseif ($type === 'color') {
                $color = trim((string)($_POST[$field] ?? ($meta['default'] ?? '#FABB05')));
                $data[$field] = preg_match('/^#[0-9A-Fa-f]{6}$/', $color) ? strtoupper($color) : (string)($meta['default'] ?? '#FABB05');
            } elseif ($type === 'datetime-local') {
                $v = trim((string)($_POST[$field] ?? ''));
                $data[$field] = $v === '' ? null : str_replace('T',' ',$v).':00';
            } else {
                $value = trim((string)($_POST[$field] ?? ''));
                $maxLength = (int)($meta['maxlength'] ?? 0);
                if ($maxLength > 0 && mb_strlen($value) > $maxLength) {
                    $value = mb_substr($value, 0, $maxLength);
                }
                $data[$field] = $value;
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

        if(!empty($data['slug'])){
            $prefix=match($module){
                'services'=>'hizmet/',
                'projects'=>'proje/',
                'posts'=>'blog/',
                'service_areas'=>'bolge/',
                'pages'=>'',
                default=>'',
            };
            if(in_array($module,['services','projects','posts','service_areas','pages'],true)){
                $changedUrl=seo_absolute_url($data['canonical_url']??'',app_url($prefix.$data['slug']));
                seo_indexnow_submit([$changedUrl]);
            }
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
        'page_sections' => 'layout',
        default => 'layout',
    };
}

function admin_field(array $meta, string $name, $value): string {
    $label = e($meta['label'] ?? $name);
    $type = $meta['type'] ?? 'text';
    $v = e((string)$value);
    $help = trim((string)($meta['help'] ?? ''));
    $helpHtml = $help !== '' ? '<small>'.e($help).'</small>' : '';
    $seoNames=['meta_title','meta_description','focus_keyword','secondary_keywords','canonical_url','og_title','og_description','og_image','image_alt','image_title','robots','schema_type','geo_target','aio_summary','author_name','latitude','longitude'];
    $seoClass=in_array($name,$seoNames,true)?' seo-field':'';

    if ($type === 'textarea') {
        $maxLength = (int)($meta['maxlength'] ?? 0);
        $maxAttr = $maxLength > 0 ? ' maxlength="'.$maxLength.'" data-char-limit="'.$maxLength.'"' : '';
        $counterHtml = $maxLength > 0
            ? '<span class="admin-char-counter"><b data-char-count>'.mb_strlen((string)$value).'</b> / '.$maxLength.' karakter</span>'
            : '';
        return '<label class="admin-field full'.$seoClass.'"><span>'.$label.'</span><textarea name="'.e($name).'"'.$maxAttr.'>'.$v.'</textarea>'.$counterHtml.$helpHtml.'</label>';
    }

    if ($type === 'checkbox') {
        return '<label class="admin-toggle'.$seoClass.'"><input type="checkbox" name="'.e($name).'" value="1" '.($value ? 'checked' : '').'><span class="admin-toggle-ui"></span><span>'.$label.'</span>'.$helpHtml.'</label>';
    }

    if ($type === 'select') {
        $out = '<label class="admin-field'.$seoClass.'"><span>'.$label.'</span><select name="'.e($name).'">';
        foreach (($meta['options'] ?? []) as $k => $txt) {
            $sel = ((string)$value === (string)$k) ? ' selected' : '';
            $out .= '<option value="'.e((string)$k).'"'.$sel.'>'.e((string)$txt).'</option>';
        }
        return $out.'</select>'.$helpHtml.'</label>';
    }

    if ($type === 'image') {
        return '<label class="admin-field full'.$seoClass.'"><span>'.$label.'</span><input type="text" name="'.e($name).'" value="'.$v.'" placeholder="https://... veya uploads/...">'.$helpHtml.'<input class="admin-file" type="file" name="'.e($name).'_upload" accept="image/jpeg,image/png,image/webp,image/avif,image/x-icon,image/vnd.microsoft.icon"></label>';
    }

    if ($type === 'gallery') {
        return '<label class="admin-field full'.$seoClass.'"><span>'.$label.'</span><textarea name="'.e($name).'" rows="4" placeholder=\'["uploads/proje-1.jpg","uploads/proje-2.jpg"]\'>'.$v.'</textarea>'.$helpHtml.'<input class="admin-file" type="file" name="'.e($name).'_upload[]" accept="image/jpeg,image/png,image/webp,image/avif" multiple><small>En fazla 16 yeni görsel tek seferde seçilebilir. Mevcut JSON listesinden istemediğiniz yolu silerek galeriden kaldırabilirsiniz.</small></label>';
    }

    $htmlType = in_array($type,['datetime-local','number','url','email','color'],true) ? $type : 'text';
    if ($type === 'datetime-local' && $value) {
        $v = e(str_replace(' ', 'T', substr((string)$value, 0, 16)));
    }
    if ($type === 'color' && trim((string)$value) === '') {
        $v = e((string)($meta['default'] ?? '#FABB05'));
    }
    $extra = '';
    if ($type === 'number') {
        if (isset($meta['min'])) $extra .= ' min="'.(int)$meta['min'].'"';
        if (isset($meta['max'])) $extra .= ' max="'.(int)$meta['max'].'"';
        if (isset($meta['step'])) $extra .= ' step="'.e((string)$meta['step']).'"';
    }
    if ($type === 'color') $extra .= ' class="admin-color-input"';

    return '<label class="admin-field'.$seoClass.'"><span>'.$label.'</span><input type="'.$htmlType.'" name="'.e($name).'" value="'.$v.'"'.$extra.'>'.$helpHtml.'</label>';
}

$counts=[];
foreach(['services','projects','sliders','posts'] as $t){$counts[$t]=(int)db()->query("SELECT COUNT(*) FROM {$t}")->fetchColumn();}

$activeCounts=[];
foreach(['services','projects','sliders','posts'] as $t){$activeCounts[$t]=(int)db()->query("SELECT COUNT(*) FROM {$t} WHERE is_active=1")->fetchColumn();}

$pageTitle = $module==='dashboard' ? 'Dashboard' : ($module==='seo_center' ? 'SEO & AIO Merkezi' : ($module==='settings' ? 'Genel Ayarlar' : ($module==='account' ? 'Hesap & Güvenlik' : ($modules[$module]['label'] ?? 'Yönetim'))));
$navGroups = [
    'Site Yönetimi' => ['settings','seo_center','home_sections','page_sections','sliders','home_stats'],
    'İçerik' => ['services','projects','posts','pages'],
    'Güven & Dönüşüm' => ['home_features','testimonials','service_areas','faqs'],
];
$legalAdminPages=[];
try{
    $legalSlugs=['kvkk-aydinlatma-metni','gizlilik-politikasi','cerez-politikasi'];
    $legalStmt=db()->prepare("SELECT id,slug,title FROM pages WHERE slug IN (?,?,?) ORDER BY FIELD(slug,?,?,?)");
    $legalStmt->execute(array_merge($legalSlugs,$legalSlugs));
    $legalAdminPages=$legalStmt->fetchAll();
}catch(Throwable $e){ $legalAdminPages=[]; }
?><!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="theme-color" content="#0c2232">
<title><?= e($pageTitle) ?> · NetVera Admin</title>
<link rel="stylesheet" href="admin.css?v=5">
</head>
<body>
<div class="admin-shell">
<aside class="admin-sidebar" data-sidebar>
  <div class="admin-brand-wrap">
    <a class="admin-brand-horizontal" href="<?= e(app_url()) ?>" target="_blank" rel="noopener" aria-label="<?= e(setting('site_name','Vera Yapı')) ?> sitesini aç">
      <img class="admin-brand-horizontal-logo" src="<?= e(media_url(trim(setting('footer_logo_image','')) ?: 'assets/brand/vera-yapi-horizontal-light.svg')) ?>" alt="<?= e(setting('site_name','Vera Yapı')) ?>" width="178" height="44">
    </a>
    <button class="admin-mobile-close" type="button" data-sidebar-close aria-label="Menüyü kapat">×</button>
  </div>

  <nav class="admin-nav" aria-label="Yönetim menüsü">
    <a href="?module=dashboard" class="admin-nav-link <?= $module==='dashboard'?'active':'' ?>"><?= admin_icon('dashboard') ?><span>Dashboard</span></a>
    <?php foreach($navGroups as $groupLabel=>$keys): ?>
      <div class="admin-nav-group-title"><?= e($groupLabel) ?></div>
      <?php foreach($keys as $key): ?>
        <?php if($key==='settings'): ?>
          <a href="?module=settings" class="admin-nav-link <?= $module==='settings'?'active':'' ?>"><?= admin_icon('settings') ?><span>Genel Ayarlar</span></a>
        <?php elseif($key==='seo_center'): ?>
          <a href="?module=seo_center" class="admin-nav-link <?= $module==='seo_center'?'active':'' ?>"><?= admin_icon('chart') ?><span>SEO & AIO Merkezi</span></a>
        <?php elseif(isset($modules[$key])): ?>
          <a href="?module=<?= e($key) ?>" class="admin-nav-link <?= $module===$key?'active':'' ?>"><?= admin_icon(module_icon($key)) ?><span><?= e($modules[$key]['label']) ?></span></a>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endforeach; ?>
    <?php if($legalAdminPages): ?>
      <div class="admin-nav-group-title">Yasal Sayfalar</div>
      <?php foreach($legalAdminPages as $legalPage): ?>
        <a href="?module=pages&edit=<?= (int)$legalPage['id'] ?>" class="admin-nav-link"><?= admin_icon('pages') ?><span><?= e($legalPage['title']) ?></span></a>
      <?php endforeach; ?>
    <?php endif; ?>
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

    <?php elseif($module==='seo_center'):
      $seoTables=[
        'services'=>['label'=>'Hizmetler','module'=>'services'],
        'projects'=>['label'=>'Projeler','module'=>'projects'],
        'posts'=>['label'=>'Blog','module'=>'posts'],
        'pages'=>['label'=>'Kurumsal Sayfalar','module'=>'pages'],
        'service_areas'=>['label'=>'Hizmet Bölgeleri','module'=>'service_areas'],
      ];
      $seoOverview=[];$scoreSum=0;$scoreCount=0;
      foreach($seoTables as $table=>$meta){
        $records=db()->query("SELECT * FROM {$table} ORDER BY id DESC")->fetchAll();
        $sum=0;
        foreach($records as $record){$r=seo_readiness($record);$sum+=$r['score'];$scoreSum+=$r['score'];$scoreCount++;}
        $seoOverview[$table]=['count'=>count($records),'avg'=>count($records)?(int)round($sum/count($records)):0]+$meta;
      }
      $globalSeo=(int)round((
        (setting('seo_home_title')!==''?1:0)+
        (setting('meta_description')!==''?1:0)+
        (setting('seo_focus_keyword')!==''?1:0)+
        (setting('seo_home_canonical')!==''?1:0)+
        (setting('seo_default_og_image')!==''?1:0)+
        (setting('business_legal_name')!==''?1:0)+
        (setting('service_area')!==''?1:0)+
        (setting('aio_brand_summary')!==''?1:0)
      )/8*100);
      $contentAvg=$scoreCount?(int)round($scoreSum/$scoreCount):0;
    ?>
      <section class="admin-seo-hero">
        <div>
          <span class="admin-eyebrow">SEO · LOCAL SEO · GEO · AIO</span>
          <h2>Arama ve AI görünürlüğünü tek merkezden yönetin.</h2>
          <p>Bu puan bir Google sıralama garantisi değildir; teknik ve editoryal SEO alanlarının ne kadar eksiksiz doldurulduğunu gösterir.</p>
        </div>
        <a class="admin-btn" href="?module=settings">Site SEO Ayarları</a>
      </section>

      <section class="admin-seo-kpis">
        <div class="admin-seo-score"><span>Site Geneli</span><strong><?= $globalSeo ?>%</strong><div class="seo-progress"><i style="width:<?= $globalSeo ?>%"></i></div><small>Ana sayfa + işletme verileri</small></div>
        <div class="admin-seo-score"><span>İçerik Ortalaması</span><strong><?= $contentAvg ?>%</strong><div class="seo-progress"><i style="width:<?= $contentAvg ?>%"></i></div><small>Hizmet, proje, blog, sayfa, bölge</small></div>
        <div class="admin-seo-score"><span>Local SEO</span><strong><?= setting('latitude')!=='' && setting('longitude')!=='' ? 'Hazır' : 'Eksik' ?></strong><small>Adres + koordinat + hizmet bölgesi</small></div>
        <div class="admin-seo-score"><span>AI / AIO</span><strong><?= setting('aio_brand_summary')!=='' ? 'Aktif' : 'Eksik' ?></strong><small>Net marka ve uzmanlık özeti</small></div>
      </section>

      <section class="admin-dashboard-grid seo-dashboard-grid">
        <div class="admin-card admin-card-large">
          <div class="admin-card-head"><div><span class="admin-card-kicker">İÇERİK HAZIRLIĞI</span><h3>Modül bazlı SEO durumu</h3><p>Eksik alanı olan içeriklere doğrudan geçebilirsiniz.</p></div></div>
          <div class="seo-module-list">
          <?php foreach($seoOverview as $row): ?>
            <a href="?module=<?= e($row['module']) ?>" class="seo-module-row">
              <div><strong><?= e($row['label']) ?></strong><span><?= (int)$row['count'] ?> kayıt</span></div>
              <div class="seo-row-progress"><i style="width:<?= (int)$row['avg'] ?>%"></i></div>
              <b><?= (int)$row['avg'] ?>%</b>
            </a>
          <?php endforeach; ?>
          </div>
        </div>

        <div class="admin-card">
          <div class="admin-card-head"><div><span class="admin-card-kicker">KRİTİK KONTROLLER</span><h3>Site seviyesi</h3></div></div>
          <div class="admin-status-list seo-check-list">
            <div><span>Ana SEO başlığı</span><b class="<?= setting('seo_home_title')!==''?'ok':'missing' ?>"><?= setting('seo_home_title')!==''?'Hazır':'Eksik' ?></b></div>
            <div><span>Canonical</span><b class="<?= setting('seo_home_canonical')!==''?'ok':'missing' ?>"><?= setting('seo_home_canonical')!==''?'Hazır':'Otomatik' ?></b></div>
            <div><span>Preferred image</span><b class="<?= setting('seo_default_og_image')!==''?'ok':'missing' ?>"><?= setting('seo_default_og_image')!==''?'Hazır':'Eksik' ?></b></div>
            <div><span>LocalBusiness verisi</span><b class="<?= setting('business_legal_name')!==''?'ok':'missing' ?>"><?= setting('business_legal_name')!==''?'Hazır':'Eksik' ?></b></div>
            <div><span>Google doğrulama</span><b class="<?= setting('google_site_verification')!==''?'ok':'missing' ?>"><?= setting('google_site_verification')!==''?'Ekli':'Opsiyonel' ?></b></div>
            <div><span>Bing doğrulama</span><b class="<?= setting('bing_site_verification')!==''?'ok':'missing' ?>"><?= setting('bing_site_verification')!==''?'Ekli':'Opsiyonel' ?></b></div>
          </div>
        </div>
      </section>

      <section class="admin-card seo-guidance">
        <div class="admin-card-head"><div><span class="admin-card-kicker">UYGULAMA PRENSİBİ</span><h3>SEO alanlarını nasıl kullanacağız?</h3></div></div>
        <div class="seo-guidance-grid">
          <div><b>01</b><strong>Odak kelime</strong><p>İçeriğin ana arama niyetini belirler; meta keywords etiketi olarak yayınlanmaz.</p></div>
          <div><b>02</b><strong>Canonical</strong><p>Aynı içeriğin tercih edilen temiz URL’sini arama motorlarına bildirir.</p></div>
          <div><b>03</b><strong>Görsel SEO</strong><p>Alt metin, OG görseli ve schema image alanları görsel keşfedilebilirliğini güçlendirir.</p></div>
          <div><b>04</b><strong>AIO özeti</strong><p>Kısa, net ve doğrulanabilir uzmanlık özeti AI sistemlerinin içeriği anlamasını kolaylaştırır.</p></div>
        </div>
      </section>

    <?php elseif($module==='settings'): ?>
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="action" value="save_settings">
        <?php
          $longSettings=['meta_description','footer_text','business_description','same_as','aio_brand_summary','aio_expertise','contact_body','quick_cta_1_body','quick_cta_1_whatsapp_text','quick_cta_2_body','seo_secondary_keywords'];
          $groupHelp=[
            'Marka & İletişim'=>'Firma kimliği ve sitede gösterilen temel iletişim bilgileri.',
            'Ana Sayfa SEO'=>'Ana sayfanın title, description, canonical, robots ve preferred image sinyalleri.',
            'Local SEO / GEO'=>'Organization / LocalBusiness yapılandırılmış verileri ve coğrafi hedefleme.',
            'AIO / AI Görünürlüğü'=>'AI cevaplarında kullanılabilecek net marka/uzmanlık bağlamı ve IndexNow entegrasyonu.',
            'Doğrulama'=>'Search Console ve Bing Webmaster Tools doğrulama kodları.',
            'Ana Sayfa Görünümü'=>'Ana sayfada dinamik olarak gösterilecek içerik miktarlarını yönetin.',
            'Dönüşüm Alanları'=>'Ana sayfadaki teklif ve hızlı iletişim CTA içerikleri.',
          ];
        ?>
        <?php foreach($settingsGroups as $groupName=>$fields): ?>
          <section class="admin-card settings-group-card">
            <div class="admin-card-head"><div><span class="admin-card-kicker"><?= e(mb_strtoupper($groupName)) ?></span><h3><?= e($groupName) ?></h3><p><?= e($groupHelp[$groupName]??'') ?></p></div></div>
            <div class="admin-form">
              <?php foreach($fields as $key=>$label): ?>
                <label class="admin-field <?= in_array($key,$longSettings,true)?'full':'' ?>">
                  <span><?= e($label) ?></span>
                  <?php if($key==='home_testimonials_limit'): ?>
                    <input type="number" name="<?= e($key) ?>" min="1" step="1" value="<?= e(setting($key,'8')) ?>">
                    <small>Toplam yorum kaydı sınırsızdır. Buradaki sayı yalnızca ana sayfada kayan şeritte kaç aktif yorum kullanılacağını belirler.</small>
                  <?php elseif(isset($settingsImageFields[$key])): ?>
                    <?php $currentImage=setting($key); ?>
                    <?php if($currentImage!==''): ?><div class="admin-setting-image-preview"><img src="<?= e(media_url($currentImage)) ?>" alt=""></div><?php endif; ?>
                    <input name="<?= e($key) ?>" value="<?= e($currentImage) ?>" placeholder="uploads/... veya https://...">
                    <input class="admin-file" type="file" name="<?= e($key) ?>_upload" accept="image/jpeg,image/png,image/webp,image/avif,image/x-icon,image/vnd.microsoft.icon,.ico">
                    <small>URL girebilir veya bilgisayardan JPG, PNG, WebP, AVIF yükleyebilirsiniz.</small>
                  <?php elseif(in_array($key,$longSettings,true)): ?>
                    <textarea name="<?= e($key) ?>"><?= e(setting($key)) ?></textarea>
                  <?php else: ?>
                    <input name="<?= e($key) ?>" value="<?= e(setting($key)) ?>">
                  <?php endif; ?>
                  <?php if($key==='seo_focus_keyword'): ?><small>Yalnız içerik planlama için; Google meta keywords kullanmaz.</small><?php endif; ?>
                  <?php if($key==='seo_home_canonical'): ?><small>Boşsa sistem temiz ana sayfa URL’sini otomatik kullanır.</small><?php endif; ?>
                  <?php if($key==='same_as'): ?><small>Her satıra bir sosyal/kurumsal profil URL’si yazabilirsiniz.</small><?php endif; ?>
                  <?php if($key==='latitude'||$key==='longitude'): ?><small>LocalBusiness schema için mümkünse kesin işletme koordinatı.</small><?php endif; ?>
                </label>
              <?php endforeach; ?>
            </div>
          </section>
        <?php endforeach; ?>
        <div class="admin-sticky-save"><button class="admin-btn" type="submit"><?= admin_icon('check') ?> Tüm Ayarları Kaydet</button></div>
      </form>

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
      $listSql="SELECT * FROM {$cfg['table']} ORDER BY ".(array_key_exists('sort_order',$cfg['fields'])?'sort_order ASC, ':'')."id DESC";
      if($module!=='testimonials') $listSql.=" LIMIT 200";
      $list=db()->query($listSql)->fetchAll();
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
          <?php
            $seoFieldNames=['meta_title','meta_description','focus_keyword','secondary_keywords','canonical_url','og_title','og_description','og_image','image_alt','image_title','robots','schema_type','geo_target','aio_summary','author_name','latitude','longitude'];
            $hasSeoFields=count(array_intersect(array_keys($cfg['fields']),$seoFieldNames))>0;
            foreach($cfg['fields'] as $name=>$meta){
              if(!in_array($name,$seoFieldNames,true)) echo admin_field($meta,$name,$edit[$name]??'');
            }
          ?>
          <?php if($hasSeoFields): ?>
            <div class="seo-fieldset full">
              <?php
                $readiness=$edit?seo_readiness($edit):['score'=>0];
                $previewPrefix=match($module){'services'=>'hizmet/','projects'=>'proje/','posts'=>'blog/','service_areas'=>'bolge/','pages'=>'',default=>''};
                $previewSlug=(string)($edit['slug']??'ornek-sayfa');
                $previewUrl=trim((string)($edit['canonical_url']??'')) ?: app_url($previewPrefix.$previewSlug);
                $previewTitle=(string)($edit['meta_title']??($edit[$cfg['title']]??'SEO başlığınız burada görünecek'));
                $previewDescription=(string)($edit['meta_description']??'Meta açıklamanız burada önizlenir.');
              ?>
              <div class="seo-fieldset-head">
                <div><span class="admin-card-kicker">SEO · GEO · AIO</span><h4>Arama görünürlüğü ayarları</h4><p>Canonical, görsel metadata, yapılandırılmış veri ve AI bağlamını burada yönetin.</p></div>
                <div class="seo-edit-score" data-seo-live-score><strong><?= $readiness['score'] ?>%</strong><span>hazırlık</span></div>
              </div>
              <div class="admin-form seo-inner-form">
                <?php foreach($cfg['fields'] as $name=>$meta){ if(in_array($name,$seoFieldNames,true)) echo admin_field($meta,$name,$edit[$name]??''); } ?>
              </div>
              <div class="seo-serp-preview" data-seo-preview data-preview-base="<?= e(app_url($previewPrefix)) ?>">
                <div class="seo-preview-label">Arama sonucu önizlemesi <small>temsili görünüm</small></div>
                <div class="seo-preview-url" data-preview-url><?= e($previewUrl) ?></div>
                <div class="seo-preview-title" data-preview-title><?= e($previewTitle) ?></div>
                <p data-preview-description><?= e($previewDescription) ?></p>
              </div>
            </div>
          <?php endif; ?>
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
            <thead><tr><th>#</th><th>Başlık</th><?php if(array_key_exists('focus_keyword',$cfg['fields'])): ?><th>SEO Hazırlık</th><?php endif; ?><th>Durum</th><th class="admin-table-actions-head">İşlem</th></tr></thead>
            <tbody>
            <?php foreach($list as $row): ?>
              <tr>
                <td class="admin-id-cell"><?= (int)$row['id'] ?></td>
                <td><strong class="admin-row-title"><?= e((string)($row[$cfg['title']]??'')) ?></strong><?php if(!empty($row['focus_keyword'])): ?><small class="admin-row-keyword"><?= e((string)$row['focus_keyword']) ?></small><?php endif; ?></td>
                <?php if(array_key_exists('focus_keyword',$cfg['fields'])): $rowSeo=seo_readiness($row); ?><td><div class="seo-table-score"><div><i style="width:<?= $rowSeo['score'] ?>%"></i></div><b><?= $rowSeo['score'] ?>%</b></div></td><?php endif; ?>
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
<script src="admin.js?v=3" defer></script>

<script>
document.querySelectorAll('[data-char-limit]').forEach(function(field){
  var counter = field.parentElement.querySelector('[data-char-count]');
  if(!counter) return;
  var sync = function(){ counter.textContent = String(field.value.length); };
  field.addEventListener('input', sync);
  sync();
});
</script>
</body>
</html>