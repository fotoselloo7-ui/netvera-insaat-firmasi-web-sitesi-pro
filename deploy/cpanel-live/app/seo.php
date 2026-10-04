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

    $targetVersion='2026.10-editorial-v3';
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

    $editorialUpdates=[
      ['posts','insaat-firmasi-secerken-nelere-dikkat-edilmeli',
       'İnşaat firması seçiminde yalnız fiyat değil; teknik yeterlilik, sözleşme kapsamı, referanslar, saha yönetimi ve iletişim düzeni birlikte değerlendirilmelidir.',
       "## İlk elemede bakılması gereken 4 konu\nBir inşaat firmasını değerlendirirken yalnız metrekare fiyatı veya sosyal medya görüntüsü üzerinden karar vermek sağlıklı değildir. Teknik ekip, benzer iş deneyimi, sözleşme disiplini ve saha iletişimi birlikte incelenmelidir.\n\n- Benzer ölçek ve tipte tamamlanmış projeler\n- İş kapsamını açık anlatan teklif ve teknik şartname\n- Saha sorumluluğu ve karar mekanizması\n- Değişiklik ve ek işlerin nasıl yönetileceği\n\n## Teklifleri neden yalnız toplam rakamla karşılaştırmamalısınız?\nİki teklif aynı toplam bedele yakın görünse bile malzeme standardı, dahil olmayan işler, teslim kriterleri ve ödeme takvimi farklı olabilir. Sağlıklı karşılaştırma aynı kapsam üzerinden yapılır.\n\n## Sözleşmede net olması gerekenler\nKapsam, süre, ödeme planı, malzeme standardı, değişiklik yönetimi, gecikme koşulları ve teslim kriterleri yazılı olmalıdır. Belirsiz başlıklar sahada maliyet ve zaman baskısına dönüşür.\n\n## Referans incelerken ne sorun?\nYalnız bitmiş fotoğrafa bakmayın. İletişimin nasıl yürüdüğünü, bütçe değişikliklerinin nasıl bildirildiğini ve teslim sonrası yaklaşımı da sorun."],
      ['posts','alanyada-villa-yaptirmadan-once-7-kontrol',
       'Villa projesi öncesinde arsa koşulları, ruhsat süreci, ihtiyaç programı, bütçe, malzeme standardı, uygulama takvimi ve sözleşme kapsamı netleştirilmelidir.',
       "## 1. Arsa ve imar durumunu doğrulayın\nTasarım kararından önce arsanın imar koşulları, kotları, yaklaşma mesafeleri ve altyapı durumu netleşmelidir.\n\n## 2. İhtiyaç programını yazılı hale getirin\nOda sayısı, açık alan kullanımı, otopark, depo, havuz ve teknik hacimler baştan tanımlanırsa proje revizyonları azalır.\n\n## 3. Bütçeyi yalnız kaba inşaat üzerinden kurmayın\nCephe, mekanik-elektrik sistemler, sabit mobilyalar, peyzaj ve çevre düzeni toplam yatırım bütçesinin önemli bölümünü oluşturabilir.\n\n## 4. Malzeme standardını teklif öncesinde tanımlayın\n'Premium malzeme' gibi genel ifadeler yerine marka, seri veya performans kriteri belirlemek karşılaştırmayı kolaylaştırır.\n\n## 5. Takvimi kritik kararlarla birlikte planlayın\nUzun terminli ürünler, belediye süreçleri ve özel imalatlar takvimin başında görülmelidir.\n\n## 6. Saha kontrol modelini sorun\nKimin sahada karar verdiği, kalite kontrolün nasıl kaydedildiği ve müşteriye hangi sıklıkta bilgi verildiği net olmalıdır.\n\n## 7. Teslim tanımını sözleşmeye koyun\nTestler, eksik listesi, temizlik, dokümantasyon ve anahtar teslim kriterleri baştan konuşulmalıdır."],
      ['posts','anahtar-teslim-insaat-sozlesmesi',
       'Anahtar teslim sözleşmede iş kapsamı, teknik şartname, ödeme takvimi, süre, değişiklik yönetimi, kalite kriterleri ve teslim koşulları açıkça tanımlanmalıdır.',
       "## İş kapsamı ve hariç tutulan işler\nSözleşme yalnız yapılacak işleri değil, kapsam dışında kalan işleri de açıkça göstermelidir. Bu ayrım sonradan çıkan anlaşmazlıkları ciddi ölçüde azaltır.\n\n## Teknik şartname\nMalzeme sınıfı, uygulama standardı ve kritik ürün grupları tanımlanmalıdır. Tek başına 'anahtar teslim' ifadesi teknik kapsamı açıklamaz.\n\n## Ödeme takvimi\nÖdemelerin tarih yerine ölçülebilir imalat aşamalarına bağlanması ilerlemeyi takip etmeyi kolaylaştırır.\n\n## Süre ve gecikme koşulları\nBaşlangıç, hedef teslim, mücbir sebep ve işveren kaynaklı beklemelerin nasıl ele alınacağı yazılmalıdır.\n\n## Değişiklik yönetimi\nProje sırasında çıkan ilave veya eksilen işler yazılı onay, fiyat ve süre etkisiyle kayıt altına alınmalıdır.\n\n## Teslim kriterleri\nKontrol listesi, testler, eksiklerin kapatılması ve teslim dokümanları sözleşmenin kapanış bölümünde tanımlanmalıdır."],
      ['services','konut-projeleri',
       'Konut projelerinde ihtiyaç analizi, keşif, uygulama planlaması, saha koordinasyonu, kalite kontrolleri ve teslim süreçlerini tek ekip altında yönetiyoruz.',
       "## Konut projesine nasıl başlıyoruz?\nArsa veya mevcut proje dokümanlarını, hedef kullanıcı profilini, yaklaşık alanı ve yatırım çerçevesini birlikte değerlendiriyoruz. İlk hedef, tasarım ve uygulama kararlarının aynı bütçe gerçekliği içinde ilerlemesini sağlamaktır.\n\n## Uygulama kapsamı\n- Keşif ve mevcut durum analizi\n- Uygulama planı ve yaklaşık bütçe\n- Tedarik ve saha koordinasyonu\n- Teknik kalite kontrolleri\n- Teslim öncesi eksik listesi ve kapanış\n\n## Kimler için uygun?\nApartman, rezidans, butik konut veya çoklu bağımsız bölüm projesinde tek koordinasyon yapısıyla ilerlemek isteyen yatırımcı ve arsa sahipleri için uygundur."],
      ['services','villa-yapimi',
       'Arsanın özelliklerinden yaşam senaryosuna kadar her detayı değerlendirerek villa projelerini planlıyor ve uyguluyoruz.',
       "## Villa projesinde ilk kararlar\nArsanın yönü, eğimi, manzara ilişkisi, mahremiyet, açık alan kullanımı ve yaşam senaryosu tasarım kararlarının başlangıç noktasıdır.\n\n## Uygulama yaklaşımı\n- Arsa ve ihtiyaç programı değerlendirmesi\n- Proje ve bütçe uyumunun kontrolü\n- Kaba ve ince imalat koordinasyonu\n- Cephe, mekanik-elektrik ve sabit donatı entegrasyonu\n- Peyzaj ve teslim kontrolleri\n\n## Neden tek koordinasyon?\nVilla projelerinde çok sayıda özel imalat aynı anda kesişir. Kararların tek takvim ve kalite standardı üzerinden yönetilmesi, sonradan yapılan pahalı revizyonları azaltır."],
      ['services','anahtar-teslim-taahhut',
       'Anahtar teslim taahhüt modelinde bütçe, tedarik, uygulama, saha koordinasyonu ve son kontroller tek sorumluluk altında yürütülür.',
       "## Anahtar teslim model ne sağlar?\nMüşterinin farklı ekip ve tedarikçiler arasında koordinasyon yükünü azaltır. İş kapsamı, satın alma, saha planı ve teslim tek sorumluluk yapısında takip edilir.\n\n## Başlangıçta netleştirdiğimiz başlıklar\n- Teknik kapsam ve hariç işler\n- Malzeme standardı\n- Uygulama takvimi\n- Ödeme ve değişiklik yönetimi\n- Teslim kriterleri\n\n## En kritik konu: kapsam disiplini\nAnahtar teslim işlerde fiyat kadar hangi işin hangi standartla dahil olduğunun netliği önemlidir. Bu nedenle teklif öncesi kapsamı mümkün olduğunca detaylandırırız."],
      ['projects','marina-villa',
       'Marina Villa projesinde iç-dış yaşam ilişkisi, doğal ışık ve uzun ömürlü malzeme seçimleri öne çıkarıldı.',
       "## Proje hedefi\nİç mekân ile açık yaşam alanları arasında güçlü bir bağlantı kurarken cephe dilini sade ve zamansız tutmak projenin ana hedefiydi.\n\n## Tasarım kararları\nGün ışığı, mahremiyet ve dolaşım birlikte ele alındı. Cephe malzemeleri yüksek bakım gerektirmeyecek ve kıyı iklimine uyum sağlayacak şekilde değerlendirildi.\n\n## Uygulama yaklaşımı\nKritik birleşim detayları kaba imalat tamamlanmadan netleştirildi; mekanik-elektrik geçişleri ile sabit donatı kararları saha programına erken dahil edildi."],
      ['projects','park-residence',
       'Park Residence, ortak yaşam alanları ve çağdaş cephe karakteriyle çok katlı konut projesi olarak planlandı.',
       "## Proje hedefi\nÇok katlı konut yapısında bağımsız bölümlerin kullanım verimini korurken ortak alan ve cephe karakterinde bütünlük sağlamak hedeflendi.\n\n## Koordinasyon\nTekrarlayan imalatlarda kalite standardının korunması için numune uygulamalar ve kontrol noktaları tanımlandı.\n\n## Teslim yaklaşımı\nBağımsız bölümler ve ortak alanlar ayrı kontrol listeleriyle takip edilerek eksik kapanış süreci planlandı."],
      ['projects','kestel-house',
       'Kestel House projesinde doğal malzemeler, koyu cephe detayları ve sade peyzaj dili birlikte kullanıldı.',
       "## Proje fikri\nDoğal doku ile çağdaş koyu detayları dengeli biçimde bir araya getiren sakin bir konut karakteri hedeflendi.\n\n## Malzeme dili\nCephede kullanılan yüzeylerin bakım ihtiyacı, güneş etkisi ve çevreyle uyumu birlikte değerlendirildi.\n\n## Uygulama\nPeyzaj, dış cephe ve iç mekân bitişleri birbirinden bağımsız değil, tek renk ve malzeme paleti üzerinden koordine edildi."],
    ];
    foreach($editorialUpdates as [$table,$slug,$oldBody,$newBody]){
        $check=db()->prepare("SELECT body FROM `{$table}` WHERE slug=? LIMIT 1");
        $check->execute([$slug]);
        $current=$check->fetchColumn();
        if(is_string($current) && trim($current)===trim($oldBody)){
            $up=db()->prepare("UPDATE `{$table}` SET body=? WHERE slug=?");
            $up->execute([$newBody,$slug]);
        }
    }
    db()->exec("UPDATE posts SET author_name='Vera Yapı Teknik Ekibi' WHERE (author_name IS NULL OR author_name='') AND slug IN ('insaat-firmasi-secerken-nelere-dikkat-edilmeli','alanyada-villa-yaptirmadan-once-7-kontrol','anahtar-teslim-insaat-sozlesmesi')");

    db()->prepare("INSERT INTO settings (setting_key,setting_value) VALUES ('schema_version',?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)")->execute([$targetVersion]);
    clear_settings_cache();
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


function seo_indexnow_submit(array $urls): void {
    $key=trim(setting('indexnow_key',''));
    if($key==='' || !preg_match('/^[A-Fa-f0-9-]{8,128}$/',$key)) return;

    $urls=array_values(array_unique(array_filter($urls,fn($u)=>preg_match('#^https?://#i',(string)$u))));
    if(!$urls) return;

    $host=(string)(parse_url(app_url(),PHP_URL_HOST)??'');
    if($host==='') return;

    $payload=json_encode([
        'host'=>$host,
        'key'=>$key,
        'keyLocation'=>app_url($key.'.txt'),
        'urlList'=>$urls,
    ],JSON_UNESCAPED_SLASHES);
    if(!$payload) return;

    try{
        if(function_exists('curl_init')){
            $ch=curl_init('https://api.indexnow.org/indexnow');
            curl_setopt_array($ch,[
                CURLOPT_POST=>true,
                CURLOPT_POSTFIELDS=>$payload,
                CURLOPT_HTTPHEADER=>['Content-Type: application/json; charset=utf-8'],
                CURLOPT_RETURNTRANSFER=>true,
                CURLOPT_CONNECTTIMEOUT=>2,
                CURLOPT_TIMEOUT=>4,
            ]);
            curl_exec($ch);
            curl_close($ch);
        }
    }catch(Throwable $e){
        // Search notification failures must never block CMS saves.
    }
}
