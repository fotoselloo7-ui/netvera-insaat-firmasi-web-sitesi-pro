<?php
declare(strict_types=1);

$config = require dirname(__DIR__) . '/config/app.php';
date_default_timezone_set($config['app']['timezone']);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name('netvera_insaat_admin');
    session_start();
}

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/seo.php';

try {
    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        $config['db']['host'],
        $config['db']['port'],
        $config['db']['name']
    );
    $pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo '<!doctype html><meta charset="utf-8"><style>body{font-family:Arial;padding:40px;max-width:800px;margin:auto}code{background:#f4f4f4;padding:3px 6px}</style>';
    echo '<h1>Veritabanı bağlantısı kurulamadı</h1><p><code>config/app.php</code> veya ortam değişkenlerindeki MySQL bilgilerini kontrol edin ve <code>database.sql</code> dosyasını içe aktarın.</p>';
    exit;
}

$GLOBALS['pdo'] = $pdo;
$GLOBALS['app_config'] = $config;

ensure_seo_schema();
