<?php
$root = dirname(__DIR__);
require_once $root . '/app/license.php';

$local = is_file($root . '/.env.php') ? require $root . '/.env.php' : [];
$get = static function(string $key, $default = '') use ($local) {
    $env = getenv($key);
    if ($env !== false && $env !== '') return $env;
    return $local[$key] ?? $default;
};
$getAny = static function(array $keys, $default = '') use ($get) {
    foreach ($keys as $key) {
        $value = $get($key, '');
        if ($value !== '' && $value !== null) return $value;
    }
    return $default;
};

$appKey = (string)$get('APP_KEY', '');
$encryptedLicenseKey = (string)$getAny(['LICENSE_KEY','DIGIKEY_LICENSE_KEY','DIGIKEY_KEY'], '');
$licenseKey = $encryptedLicenseKey !== '' ? netvera_decrypt_secret($encryptedLicenseKey, $appKey) : '';
$graceHours = (int)$get('LICENSE_GRACE_HOURS', 0);
if ($graceHours <= 0) {
    $graceHours = max(0, (int)$getAny(['DIGIKEY_GRACE_DAYS','LICENSE_GRACE_DAYS'], 7)) * 24;
}

return [
    'app' => [
        'name' => $get('APP_NAME', 'NetVera İnşaat Firması Web Sitesi Pro'),
        'url' => rtrim((string)$get('APP_URL', ''), '/'),
        'timezone' => $get('APP_TIMEZONE', 'Europe/Istanbul'),
        'key' => $appKey,
        'version' => $get('APP_VERSION', '1.0.0'),
    ],
    'db' => [
        'host' => $get('DB_HOST', '127.0.0.1'),
        'port' => $get('DB_PORT', '3306'),
        'name' => $get('DB_DATABASE', 'netvera_insaat'),
        'user' => $get('DB_USERNAME', 'root'),
        'pass' => $get('DB_PASSWORD', ''),
    ],
    'upload' => [
        'dir' => $root . '/uploads',
        'max_bytes' => 5 * 1024 * 1024,
    ],
    'license' => [
        'enabled' => filter_var((string)$getAny(['LICENSE_ENABLED','DIGIKEY_ENABLED'], 'true'), FILTER_VALIDATE_BOOLEAN),
        'server_url' => rtrim((string)$getAny(['LICENSE_SERVER_URL','DIGIKEY_BASE_URL'], 'https://lisans.netvera.tr'), '/'),
        'product_slug' => (string)$getAny(['LICENSE_PRODUCT_SLUG','DIGIKEY_PRODUCT_SLUG'], 'netvera-insaat-pro'),
        'key' => $licenseKey,
        'install_id' => (string)$getAny(['LICENSE_INSTALL_ID','DIGIKEY_INSTALL_ID'], ''),
        'site_url' => rtrim((string)$get('APP_URL', ''), '/'),
        'app_version' => (string)$get('APP_VERSION', '1.0.0'),
        'verify_interval_hours' => max(1, (int)$getAny(['LICENSE_VERIFY_INTERVAL_HOURS','DIGIKEY_VERIFY_INTERVAL_HOURS'], 24)),
        'grace_hours' => $graceHours ?: 168,
        'timeout_seconds' => max(3, (int)$get('LICENSE_TIMEOUT_SECONDS', 8)),
    ],
];
