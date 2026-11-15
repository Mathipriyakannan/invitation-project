<?php
// WhatsApp share page: the link in the WhatsApp message points here.
// Preview = the card's own image only (no blur, no extra background). Opened page = only that image.
require_once __DIR__.'/includes/data.php';
$key=(string)($_GET['k']??'');
$c=preg_match('/^[cb]\d+$/',$key)?find_item($key):null;
$base=((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')?'https':'http').'://'.($_SERVER['HTTP_HOST']??'localhost').rtrim(str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME']??'')),'/').'/';
if(!$c){http_response_code(404);}
$file=($c&&!empty($c['image']))?realpath(__DIR__.'/'.$c['image']):false;
if($file&&strpos($file,realpath(__DIR__))!==0){$file=false;}
// ?img=1 -> the card's own picture, same picture (not cropped, no bars), only compressed under ~300KB because WhatsApp ignores bigger preview images
if($file&&isset($_GET['img'])&&is_file($file)){
 $raw=file_get_contents($file);$out=null;$mime=function_exists('mime_content_type')?mime_content_type($file):'image/jpeg';
 if(strlen($raw)>280000&&function_exists('imagecreatefromstring')&&($im=@imagecreatefromstring($raw))){
  $w=imagesx($im);$h=imagesy($im);
  foreach([[1000,82],[1000,70],[800,70],[640,65],[500,60]] as $try){
   $sc=min(1,$try[0]/max($w,$h));$nw=max(1,(int)round($w*$sc));$nh=max(1,(int)round($h*$sc));
   $dst=imagecreatetruecolor($nw,$nh);imagefill($dst,0,0,imagecolorallocate($dst,255,255,255));
   imagecopyresampled($dst,$im,0,0,0,0,$nw,$nh,$w,$h);
   ob_start();imagejpeg($dst,null,$try[1]);$out=ob_get_clean();imagedestroy($dst);$mime='image/jpeg';
   if(strlen($out)<=280000)break;
  }
  imagedestroy($im);
 }
 if($out===null){$out=$raw;}
 header('Content-Type: '.$mime);header('Cache-Control: public, max-age=86400');header('Content-Length: '.strlen($out));
 echo $out;exit;
}
$img=$file?$base.'share.php?k='.rawurlencode($key).'&img=1':'';
$full=$file?$base.implode('/',array_map('rawurlencode',explode('/',$c['image']))):'';
$url=$base.'share.php?k='.rawurlencode($key);
$ttl=$c?(!empty($c['code'])?'ID : '.$c['code']:$c['name']):$shop;
// page background = the image's own edge colour, so nothing but the picture is visible around it
$bg='transparent';
if($file&&function_exists('imagecreatefromstring')&&($im=@imagecreatefromstring(file_get_contents($file)))){
 $t=imagecreatetruecolor(8,8);imagecopyresampled($t,$im,0,0,0,0,8,8,imagesx($im),imagesy($im));$r=$g=$b=$n=0;
 for($i=0;$i<8;$i++)for($j=0;$j<8;$j++)if($i==0||$j==0||$i==7||$j==7){$p=imagecolorat($t,$i,$j);$r+=($p>>16)&255;$g+=($p>>8)&255;$b+=$p&255;$n++;}
 imagedestroy($t);imagedestroy($im);$bg=sprintf("#%02x%02x%02x",(int)($r/$n),(int)($g/$n),(int)($b/$n));
}
?><!doctype html><html lang="ta"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=h($ttl)?></title>
<meta property="og:type" content="website"><meta property="og:title" content="<?=h($ttl)?>"><meta property="og:url" content="<?=h($url)?>">
<?php if($img): ?><meta property="og:image" content="<?=h($img)?>"><meta property="og:image:secure_url" content="<?=h($img)?>"><meta name="twitter:card" content="summary_large_image"><meta name="twitter:image" content="<?=h($img)?>">
<?php endif; ?>
<style>html,body{margin:0;height:100%;background:<?=h($bg)?>}img{display:block;width:100vw;height:100vh;object-fit:contain}</style></head><body>
<?php if($full): ?><img src="<?=h($full)?>" alt=""><?php endif; ?></body></html>