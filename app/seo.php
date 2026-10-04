<?php
declare(strict_types=1);

function seo_column_exists(string $table, string $column): bool {
    $stmt = db()->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?");
    $stmt->execute([$table,$column]);
    return (int)$stmt->fetchColumn() > 0;
}

function seo_add_column(string $table, string $column, string $definition): void {
    $allowedTables=['sliders','services','projects','posts','pages','service_areas'];
    if(!in_array($table,$allowedTables,true)) return;
    if(!seo_column_exists($table,$column)) {
        db()->exec("ALTER TABLE `{$table}` ADD COLUMN `{$column}` {$definition}");
    }
}

function ensure_seo_schema(): void {
    static $done=false;
    if($done) return;
    $done=true;

    $targetVersion='2026.10-seo-aio-2';
    $versionStmt=db()->prepare("SELECT setting_value FROM settings WHERE setting_key='schema_version' LIMIT 1");
    $versionStmt->execute();
    if((string)$versionStmt->fetchColumn()===$targetVersion) return;

    $common=[
        'focus_keyword'=>"VARCHAR(190) NULL",
        'secondary_keywords'=>"TEXT NULL",
        'canonical_url'=>"VARCHAR(500) NULL",
        'og_title'=>"VARCHAR(255) NULL",
        'og_description'=>"VARCHAR(320) NULL",
        'og_image'=>"VARCHAR(500) NULL",
        'image_alt'=>"VARCHAR(255) NULL",
        'image_title'=>"VARCHAR(255) NULL",
        'robots'=>"VARCHAR(120) NOT NULL DEFAULT 'index,follow,max-image-preview:large'",
        'schema_type'=>"VARCHAR(80) NULL",
        'geo_target'=>"VARCHAR(255) NULL",
        'aio_summary'=>"TEXT NULL",
    ];

    foreach(['services','projects','posts','pages'] as $table){
        foreach($common as $col=>$def) seo_add_column($table,$col,$def);
        seo_add_column($table,'updated_at',"TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
    }

    seo_add_column('posts','author_name',"VARCHAR(160) NULL");
    seo_add_column('sliders','image_alt',"VARCHAR(255) NULL");
    seo_add_column('sliders','image_title',"VARCHAR(255) NULL");

    $areaCols=[
        'slug'=>"VARCHAR(190) NULL",
        'summary'=>"TEXT NULL",
        'body'=>"LONGTEXT NULL",
        'cover_image'=>"VARCHAR(500) NULL",
        'meta_title'=>"VARCHAR(255) NULL",
        'meta_description'=>"VARCHAR(320) NULL",
        'focus_keyword'=>"VARCHAR(190) NULL",
        'secondary_keywords'=>"TEXT NULL",
        'canonical_url'=>"VARCHAR(500) NULL",
        'og_title'=>"VARCHAR(255) NULL",
        'og_description'=>"VARCHAR(320) NULL",
        'og_image'=>"VARCHAR(500) NULL",
        'image_alt'=>"VARCHAR(255) NULL",
        'image_title'=>"VARCHAR(255) NULL",
        'robots'=>"VARCHAR(120) NOT NULL DEFAULT 'index,follow,max-image-preview:large'",
        'schema_type'=>"VARCHAR(80) NULL",
        'geo_target'=>"VARCHAR(255) NULL",
        'latitude'=>"VARCHAR(40) NULL",
        'longitude'=>"VARCHAR(40) NULL",
        'aio_summary'=>"TEXT NULL",
        'updated_at'=>"TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
    ];
    foreach($areaCols as $col=>$def) seo_add_column('service_areas',$col,$def);

    $areas=db()->query("SELECT id,title,slug FROM service_areas")->fetchAll();
    foreach($areas as $area){
        if(trim((string)($area['slug']??''))===''){
            $slug=slugify((string)$area['title']);
            db()->prepare("UPDATE service_areas SET slug=? WHERE id=?")->execute([$slug,(int)$area['id']]);
        }
    }

    $defaults=[
        'seo_home_title'=>setting('site_name','Vera Yapı').' | Alanya İnşaat Firması',
        'seo_focus_keyword'=>'alanya inşaat firması',
        'seo_secondary_keywords'=>'alanya müteahhit, villa yapımı, anahtar teslim inşaat, inşaat taahhüt',
        'seo_home_canonical'=>'',
        'seo_robots'=>'index,follow,max-image-preview:large',
        'seo_default_og_image'=>setting('about_image',''),
        'seo_default_image_alt'=>'Alanya inşaat ve taahhüt firması',
        'about_image_alt'=>'Vera Yapı inşaat projeleri',
        'about_image_title'=>'Vera Yapı hakkında',
        'why_image_alt'=>'İnşaat sahası ve yapı uygulaması',
        'why_image_title'=>'Vera Yapı saha uygulaması',
        'business_legal_name'=>setting('site_name','Vera Yapı'),
        'business_type'=>'GeneralContractor',
        'business_description'=>setting('meta_description',''),
        'business_logo'=>'',
        'street_address'=>'',
        'address_locality'=>'Alanya',
        'address_region'=>'Antalya',
        'postal_code'=>'',
        'address_country'=>'TR',
        'latitude'=>'',
        'longitude'=>'',
        'service_area'=>'Alanya, Antalya',
        'price_range'=>'₺₺₺',
        'same_as'=>'',
        'founding_date'=>'',
        'google_site_verification'=>'',
        'bing_site_verification'=>'',
        'indexnow_key'=>'',
        'aio_brand_summary'=>'Alanya ve Antalya’da konut, villa, ticari yapı, renovasyon ve anahtar teslim taahhüt projeleri yürüten inşaat firması.',
        'aio_expertise'=>'Konut projeleri, villa yapımı, ticari yapılar, anahtar teslim taahhüt, renovasyon, proje uygulama',
    ];
    $stmt=db()->prepare("INSERT IGNORE INTO settings (setting_key,setting_value) VALUES (?,?)");
    foreach($defaults as $key=>$value) $stmt->execute([$key,$value]);

    $pageStmt=db()->prepare("INSERT IGNORE INTO pages (slug,eyebrow,title,intro,body,meta_title,meta_description,is_active) VALUES (?,?,?,?,?,?,?,1)");
    $defaultPages=[
        ['hizmetler','Uzmanlık Alanlarımız','İnşaat hizmetlerimiz','Konut, villa, ticari yapı, anahtar teslim, renovasyon ve proje uygulama hizmetlerimizi inceleyin.','','Hizmetler | '.setting('site_name','Vera Yapı'),'Alanya ve Antalya’da konut, villa, ticari yapı, anahtar teslim ve renovasyon hizmetleri.'],
        ['projeler','Proje Portföyü','Tamamlanan ve devam eden projelerimiz','Konut, villa ve ticari yapılardan seçili uygulamalarımızı inceleyin.','','Projeler | '.setting('site_name','Vera Yapı'),'Tamamlanan ve devam eden konut, villa ve ticari yapı projeleri.'],
        ['blog','Bilgi Merkezi','İnşaat ve yatırım rehberleri','Proje planlama, taahhüt, villa yapımı ve yapı yatırımları hakkında uzman içerikler.','','Blog | '.setting('site_name','Vera Yapı'),'İnşaat, konut yatırımı, anahtar teslim ve proje yönetimi hakkında rehber içerikler.'],
        ['bolgeler','Yerel Saha Deneyimi','Hizmet verdiğimiz bölgeler','Alanya ve Antalya çevresinde hizmet verdiğimiz bölgeleri inceleyin.','','Hizmet Bölgeleri | '.setting('site_name','Vera Yapı'),'Alanya ve Antalya çevresinde hizmet verilen bölgeler ve yerel inşaat hizmetleri.'],
    ];
    foreach($defaultPages as $page) $pageStmt->execute($page);

    db()->prepare("INSERT INTO settings (setting_key,setting_value) VALUES ('schema_version',?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)")->execute([$targetVersion]);
}

function seo_clean_schema_type(?string $type, string $fallback='WebPage'): string {
    $type=trim((string)$type);
    return preg_match('/^[A-Za-z][A-Za-z0-9]*$/',$type) ? $type : $fallback;
}

function seo_absolute_url(?string $value, string $fallback=''): string {
    $value=trim((string)$value);
    if($value==='') return $fallback;
    if(preg_match('#^https?://#i',$value)) return $value;
    return app_url(ltrim($value,'/'));
}

function seo_same_as(): array {
    $raw=preg_split('/[\r\n,]+/',setting('same_as','')) ?: [];
    return array_values(array_filter(array_map('trim',$raw),fn($v)=>preg_match('#^https?://#i',$v)));
}

function seo_global_graph(): array {
    $businessId=rtrim(app_url(),'/').'#business';
    $websiteId=rtrim(app_url(),'/').'#website';
    $business=[
        '@type'=>seo_clean_schema_type(setting('business_type','GeneralContractor'),'Organization'),
        '@id'=>$businessId,
        'name'=>setting('business_legal_name',setting('site_name','Vera Yapı')),
        'alternateName'=>setting('site_name','Vera Yapı'),
        'url'=>rtrim(app_url(),'/').'/',
        'description'=>setting('business_description',setting('meta_description','')),
        'telephone'=>setting('phone',''),
        'email'=>setting('email',''),
        'priceRange'=>setting('price_range',''),
        'areaServed'=>setting('service_area',''),
        'sameAs'=>seo_same_as(),
    ];
    $logo=setting('business_logo','');
    if($logo!=='') $business['logo']=media_url($logo);
    $address=array_filter([
        '@type'=>'PostalAddress',
        'streetAddress'=>setting('street_address',''),
        'addressLocality'=>setting('address_locality',''),
        'addressRegion'=>setting('address_region',''),
        'postalCode'=>setting('postal_code',''),
        'addressCountry'=>setting('address_country','TR'),
    ],fn($v)=>$v!=='' && $v!==null);
    if(count($address)>1) $business['address']=$address;
    if(setting('latitude','')!=='' && setting('longitude','')!==''){
        $business['geo']=['@type'=>'GeoCoordinates','latitude'=>setting('latitude'),'longitude'=>setting('longitude')];
    }
    if(setting('founding_date','')!=='') $business['foundingDate']=setting('founding_date');

    $website=[
        '@type'=>'WebSite',
        '@id'=>$websiteId,
        'url'=>rtrim(app_url(),'/').'/',
        'name'=>setting('site_name','Vera Yapı'),
        'publisher'=>['@id'=>$businessId],
        'inLanguage'=>'tr-TR',
    ];

    return [$business,$website];
}

function seo_breadcrumb_schema(array $items): array {
    $list=[];
    foreach(array_values($items) as $i=>$item){
        $list[]=[
            '@type'=>'ListItem',
            'position'=>$i+1,
            'name'=>$item['name']??'',
            'item'=>$item['url']??'',
        ];
    }
    return ['@type'=>'BreadcrumbList','itemListElement'=>$list];
}

function seo_readiness(array $row): array {
    $checks=[
        'Meta başlık'=>trim((string)($row['meta_title']??''))!=='',
        'Meta açıklama'=>trim((string)($row['meta_description']??''))!=='',
        'Odak anahtar kelime'=>trim((string)($row['focus_keyword']??''))!=='',
        'Yardımcı kelimeler'=>trim((string)($row['secondary_keywords']??''))!=='',
        'Slug'=>trim((string)($row['slug']??''))!=='',
        'Canonical'=>trim((string)($row['canonical_url']??''))!=='' || trim((string)($row['slug']??''))!=='',
        'Görsel alt metni'=>trim((string)($row['image_alt']??''))!=='',
        'Open Graph görseli'=>trim((string)($row['og_image']??$row['cover_image']??''))!=='',
        'AIO özeti'=>trim((string)($row['aio_summary']??''))!=='',
        'Robots'=>trim((string)($row['robots']??''))!=='',
    ];
    $passed=count(array_filter($checks));
    return ['score'=>(int)round(($passed/count($checks))*100),'checks'=>$checks];
}
