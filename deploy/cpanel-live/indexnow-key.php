<?php
require_once __DIR__.'/app/bootstrap.php';
header('Content-Type: text/plain; charset=UTF-8');
$key=trim(setting('indexnow_key',''));
$requested=trim((string)($_GET['key']??''));
if($key==='' || !hash_equals($key,$requested)){http_response_code(404);exit;}
echo $key;
