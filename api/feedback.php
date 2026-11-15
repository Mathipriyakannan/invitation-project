<?php
// Receives like / unlike / message / contact from the website and saves them for the admin.
require __DIR__.'/../includes/data.php';
header('Content-Type: application/json; charset=utf-8');
$in=json_decode(file_get_contents('php://input'),true)?:[];
$a=$in['action']??'';$key=(string)($in['key']??'');$item=find_item($key);
function out($a){echo json_encode($a,JSON_UNESCAPED_UNICODE);exit;}
function clean($s,$n){return mb_substr(trim(strip_tags((string)$s)),0,$n);}
function ev(&$d,$e){array_unshift($d['events'],$e+['id'=>bin2hex(random_bytes(6)),'time'=>date('c'),'read'=>false]);$d['events']=array_slice($d['events'],0,500);}
if($a==='like'||$a==='unlike'){
 if(!$item)out(['ok'=>false]);$n=0;
 store_update(function(&$d)use($a,$key,$item,&$n){$c=(int)($d['likes'][$key]??0);
  if($a==='like'){$c++;ev($d,['type'=>'like','key'=>$key,'item'=>$item['name']]);}else $c=max(0,$c-1);
  $d['likes'][$key]=$c;$n=$c;});
 out(['ok'=>true,'count'=>$n]);}
if($a==='message'||$a==='contact'){
 $msg=clean($in['message']??'',600);$name=clean($in['name']??'',60);$ph=clean($in['phone']??'',20);
 if(mb_strlen($msg)<2&&$a==='message')out(['ok'=>false,'error'=>'empty']);
 if($a==='message'&&!$item)out(['ok'=>false]);
 store_update(function(&$d)use($a,$key,$item,$msg,$name,$ph){ev($d,['type'=>'message','key'=>$a==='contact'?'':$key,'item'=>$a==='contact'?'தொடர்பு படிவம் (Contact)':$item['name'],'name'=>$name,'phone'=>$ph,'message'=>$msg]);});
 out(['ok'=>true]);}
out(['ok'=>false]);
