<?php
require_once __DIR__.'/app/bootstrap.php';
header('Content-Type: application/xml; charset=UTF-8');

$urls=[];
$add=function(string $url, ?string $lastmod=null, string $priority='0.7') use (&$urls){
    $urls[]=['url'=>$url,'lastmod'=>$lastmod,'priority'=>$priority];
};
$add(app_url(),null,'1.0');
foreach(['hakkimizda','hizmetler','projeler','blog','bolgeler','iletisim'] as $path) $add(app_url($path),null,'0.8');

$sets=[
    ['table'=>'services','prefix'=>'hizmet/'],
    ['table'=>'projects','prefix'=>'proje/'],
    ['table'=>'posts','prefix'=>'blog/'],
    ['table'=>'service_areas','prefix'=>'bolge/'],
];
foreach($sets as $set){
    $rows=db()->query("SELECT * FROM {$set['table']} WHERE is_active=1 ORDER BY id ASC")->fetchAll();
    foreach($rows as $row){
        if(str_contains((string)($row['robots']??''),'noindex')) continue;
        $slug=trim((string)($row['slug']??''));
        if($slug==='') continue;
        $canonical=seo_absolute_url($row['canonical_url']??'',app_url($set['prefix'].$slug));
        $lastmod=$row['updated_at']??($row['published_at']??($row['created_at']??null));
        $add($canonical,$lastmod?date('c',strtotime((string)$lastmod)):null,'0.7');
    }
}
$pages=db()->query("SELECT * FROM pages WHERE is_active=1 ORDER BY id ASC")->fetchAll();
foreach($pages as $row){
    if(str_contains((string)($row['robots']??''),'noindex')) continue;
    $slug=trim((string)$row['slug']);
    if(in_array($slug,['hakkimizda','iletisim'],true)) continue;
    $add(seo_absolute_url($row['canonical_url']??'',app_url($slug)),$row['updated_at']?date('c',strtotime($row['updated_at'])):null,'0.7');
}

echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;
foreach($urls as $row){
    echo '<url><loc>'.htmlspecialchars($row['url'],ENT_XML1,'UTF-8').'</loc>';
    if($row['lastmod']) echo '<lastmod>'.htmlspecialchars($row['lastmod'],ENT_XML1,'UTF-8').'</lastmod>';
    echo '<priority>'.$row['priority'].'</priority></url>'.PHP_EOL;
}
echo '</urlset>';
