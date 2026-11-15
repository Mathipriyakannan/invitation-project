<?php
// Simple JSON storage for likes & messages (data/store.json). Later you can move this to MySQL.
const STORE=__DIR__.'/../data/store.json';
function store_load(){$d=is_file(STORE)?json_decode(file_get_contents(STORE),true):null;$d=is_array($d)?$d:[];return $d+['likes'=>[],'events'=>[]];}
function store_update(callable $fn){
 if(!is_dir(dirname(STORE)))@mkdir(dirname(STORE),0755,true);
 $f=fopen(STORE,'c+');flock($f,LOCK_EX);$d=json_decode(stream_get_contents($f),true);$d=is_array($d)?$d:[];$d+=['likes'=>[],'events'=>[]];
 $fn($d);ftruncate($f,0);rewind($f);fwrite($f,json_encode($d,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));fflush($f);flock($f,LOCK_UN);fclose($f);return $d;}
