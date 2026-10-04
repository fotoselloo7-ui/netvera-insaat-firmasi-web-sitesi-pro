<?php
declare(strict_types=1);

$path=(string)(parse_url($_SERVER['REQUEST_URI']??'/',PHP_URL_PATH)??'/');
$path='/'.ltrim($path,'/');
$full=__DIR__.$path;

if($path!=='/' && is_file($full)) return false;

if($path==='/' || $path==='/index.php'){
    require __DIR__.'/index.php';
    return true;
}

$routes=[
    '#^/hakkimizda/?$#'=>['hakkimizda.php',null],
    '#^/hizmetler/?$#'=>['hizmetler.php',null],
    '#^/hizmet/([a-z0-9-]+)/?$#'=>['hizmet.php','slug'],
    '#^/projeler/?$#'=>['projeler.php',null],
    '#^/proje/([a-z0-9-]+)/?$#'=>['proje.php','slug'],
    '#^/blog/?$#'=>['blog.php',null],
    '#^/blog/([a-z0-9-]+)/?$#'=>['yazi.php','slug'],
    '#^/bolgeler/?$#'=>['bolgeler.php',null],
    '#^/bolge/([a-z0-9-]+)/?$#'=>['bolge.php','slug'],
    '#^/iletisim/?$#'=>['iletisim.php',null],
    '#^/sitemap\.xml$#'=>['sitemap.php',null],
    '#^/robots\.txt$#'=>['robots.php',null],
    '#^/([A-Fa-f0-9-]{8,128})\.txt$#'=>['indexnow-key.php','key'],
];

foreach($routes as $pattern=>$route){
    if(preg_match($pattern,$path,$m)){
        if($route[1]!==null) $_GET[$route[1]]=$m[1]??'';
        require __DIR__.'/'.$route[0];
        return true;
    }
}

if(is_dir($full)){
    $index=rtrim($full,'/').'/index.php';
    if(is_file($index)){require $index;return true;}
}

http_response_code(404);
require __DIR__.'/404.html';
return true;
