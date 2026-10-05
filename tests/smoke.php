<?php
declare(strict_types=1);
require dirname(__DIR__) . '/app/bootstrap.php';

$checks = [];
$checks['settings'] = (int)db()->query("SELECT COUNT(*) FROM settings")->fetchColumn() >= 10;
$checks['services'] = (int)db()->query("SELECT COUNT(*) FROM services WHERE is_active=1")->fetchColumn() >= 6;
$checks['projects'] = (int)db()->query("SELECT COUNT(*) FROM projects WHERE is_active=1")->fetchColumn() >= 3;
$checks['sliders'] = (int)db()->query("SELECT COUNT(*) FROM sliders WHERE is_active=1")->fetchColumn() >= 3;
$checks['admin'] = (int)db()->query("SELECT COUNT(*) FROM admins")->fetchColumn() >= 1;
$checks['seo_services_column'] = seo_column_exists('services','focus_keyword');
$checks['seo_region_slug'] = seo_column_exists('service_areas','slug');
$checks['seo_home_setting'] = setting('seo_home_title','') !== '';
$checks['seo_listing_pages'] = (int)db()->query("SELECT COUNT(*) FROM pages WHERE slug IN ('hizmetler','projeler','blog','bolgeler')")->fetchColumn() >= 4;
$checks['license_client'] = class_exists('NetveraLicenseService') && function_exists('netvera_license_status');
$checks['license_server'] = (($GLOBALS['app_config']['license']['server_url'] ?? '') === 'https://lisans.netvera.tr');
$checks['social_linkedin_setting'] = setting('linkedin_url','__missing__') !== '__missing__';

$admin = db()->query("SELECT * FROM admins ORDER BY id ASC LIMIT 1")->fetch();
$checks['seed_password'] = $admin && password_verify('ChangeMe123!', $admin['password_hash']);

foreach ($checks as $name => $ok) {
    echo ($ok ? '[OK] ' : '[FAIL] ') . $name . PHP_EOL;
}
if (in_array(false, $checks, true)) exit(1);
echo "Database smoke test passed." . PHP_EOL;
