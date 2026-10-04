<?php
$root = dirname(__DIR__);
$local = is_file($root . '/.env.php') ? require $root . '/.env.php' : [];
$get = static function(string $key, $default = '') use ($local) {
    $env = getenv($key);
    if ($env !== false && $env !== '') return $env;
    return $local[$key] ?? $default;
};
return [
    'app' => [
        'name' => $get('APP_NAME', 'NetVera İnşaat Firması Web Sitesi Pro'),
        'url' => rtrim((string)$get('APP_URL', ''), '/'),
        'timezone' => $get('APP_TIMEZONE', 'Europe/Istanbul'),
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
];