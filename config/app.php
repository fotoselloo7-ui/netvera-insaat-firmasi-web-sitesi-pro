<?php
return [
    'app' => [
        'name' => getenv('APP_NAME') ?: 'NetVera İnşaat Firması Web Sitesi Pro',
        'url' => rtrim(getenv('APP_URL') ?: '', '/'),
        'timezone' => getenv('APP_TIMEZONE') ?: 'Europe/Istanbul',
    ],
    'db' => [
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => getenv('DB_PORT') ?: '3306',
        'name' => getenv('DB_DATABASE') ?: 'netvera_insaat',
        'user' => getenv('DB_USERNAME') ?: 'root',
        'pass' => getenv('DB_PASSWORD') ?: '',
    ],
    'upload' => [
        'dir' => dirname(__DIR__) . '/uploads',
        'max_bytes' => 5 * 1024 * 1024,
    ],
];