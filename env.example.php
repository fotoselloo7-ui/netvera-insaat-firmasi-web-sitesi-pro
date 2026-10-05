<?php
/**
 * NetVera İnşaat Pro — cPanel manuel ortam ayarları
 *
 * 1) Bu dosyayı sunucuda .env.php adıyla kopyalayın.
 * 2) DB ve APP_URL değerlerini doldurun.
 * 3) APP_KEY için uzun ve benzersiz bir değer kullanın.
 * 4) Lisans anahtarını BURAYA yazmayın; Admin > NetVera Lisansı ekranından DIGI-... anahtarını girin.
 *
 * Gerçek veritabanı şifresini veya APP_KEY değerini GitHub'a commit etmeyin.
 */
return [
    'APP_NAME' => 'NetVera İnşaat Firması Web Sitesi Pro',
    'APP_URL' => 'https://alanadiniz.com',
    'APP_TIMEZONE' => 'Europe/Istanbul',
    'APP_VERSION' => '1.0.0',
    'APP_KEY' => 'BURAYA_UZUN_BENZERSIZ_APP_KEY',

    'DB_HOST' => 'localhost',
    'DB_PORT' => '3306',
    'DB_DATABASE' => 'cpanel_veritabani',
    'DB_USERNAME' => 'cpanel_kullanici',
    'DB_PASSWORD' => 'VERITABANI_SIFRENIZ',

    // NetVera lisans altyapısı — gerçek DIGI anahtarı admin panelden girilir.
    'LICENSE_ENABLED' => 'true',
    'LICENSE_SERVER_URL' => 'https://lisans.netvera.tr',
    'LICENSE_PRODUCT_SLUG' => 'netvera-insaat-pro',
    'LICENSE_VERIFY_INTERVAL_HOURS' => '24',
    'LICENSE_GRACE_HOURS' => '168',
    'LICENSE_TIMEOUT_SECONDS' => '10',
];
