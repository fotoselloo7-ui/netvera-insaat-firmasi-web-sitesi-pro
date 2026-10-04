<?php
require_once __DIR__.'/app/bootstrap.php';
header('Content-Type: text/plain; charset=UTF-8');
echo "User-agent: *\n";
echo "Allow: /\n";
echo "Disallow: /admin/\n";
echo "Disallow: /install.php\n\n";
echo "Sitemap: ".app_url('sitemap.xml')."\n";
