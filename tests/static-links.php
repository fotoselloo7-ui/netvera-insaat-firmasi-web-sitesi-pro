<?php
declare(strict_types=1);

$root=dirname(__DIR__);
$files=glob($root.'/*.html') ?: [];
$errors=[];

foreach($files as $file){
    $html=file_get_contents($file) ?: '';
    preg_match_all('/(?:href|src)="([^"]+)"/i',$html,$matches);
    foreach($matches[1] as $url){
        $url=html_entity_decode($url,ENT_QUOTES|ENT_HTML5,'UTF-8');
        if($url==='' || str_starts_with($url,'#') || preg_match('#^(https?:|mailto:|tel:|data:|javascript:)#i',$url)) continue;
        $path=(string)(parse_url($url,PHP_URL_PATH)??'');
        if($path==='') continue;
        $target=$root.'/'.ltrim($path,'/');
        if(str_ends_with($path,'.html') && !is_file($target)){
            $errors[]=basename($file).' -> '.$path;
        }
        if(str_starts_with($path,'assets/') && !is_file($target)){
            $errors[]=basename($file).' -> '.$path;
        }
    }
}

if($errors){
    fwrite(STDERR,"Broken static links:\n".implode("\n",$errors)."\n");
    exit(1);
}
echo "Static link check passed for ".count($files)." HTML files.\n";
