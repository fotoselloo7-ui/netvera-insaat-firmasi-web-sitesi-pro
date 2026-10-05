<?php
/**
 * NetVera İnşaat Pro — cPanel manuel ortam ayarları
 * Bu dosyayı sunucuda .env.php adıyla kopyalayın ve değerleri değiştirin.
 * Gerçek şifre/lisans anahtarını GitHub'a commit etmeyin.
 */
return [
    'APP_NAME' => 'NetVera İnşaat Firması Web Sitesi Pro',
    'APP_URL' => 'https://alanadiniz.com',
    'APP_TIMEZONE' => 'Europe/Istanbul',
    'APP_VERSION' => '1.0.0',

    'DB_HOST' => 'localhost',
    'DB_PORT' => '3306',
    'DB_DATABASE' => 'cpanel_veritabani',
    'DB_USERNAME' => 'cpanel_kullanici',
    'DB_PASSWORD' => 'VERITABANI_SIFRENIZ',

    // NetVera lisans sistemi
    'LICENSE_ENABLED' => 'true',
    'LICENSE_SERVER_URL' => 'https://lisans.netvera.tr',
    'LICENSE_PRODUCT_SLUG' => 'netvera-insaat-pro',
    // Düz anahtar desteklenir. Örn: DIGI-XXXX-XXXX-XXXX
    'LICENSE_KEY' => 'LISANS_ANAHTARINIZ',
    // İsterseniz kurulum başına sabit benzersiz bir değer yazın.
    'LICENSE_INSTALL_ID' => '',
    'LICENSE_VERIFY_INTERVAL_HOURS' => '24',
    'LICENSE_GRACE_HOURS' => '168',
    'LICENSE_TIMEOUT_SECONDS' => '8',
];
