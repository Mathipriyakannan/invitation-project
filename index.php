<?php
$cake='<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#fbfbf0" d="M12 2.2c1 1.2 1.7 2.1.1 3.5-1.7-1.4-1.1-2.3-.1-3.5z"/><rect x="11.1" y="6" width="1.8" height="3.2" rx=".6" fill="#fbfbf0"/><path fill="#fbfbf0" d="M6.5 10.2h11a1.5 1.5 0 011.5 1.5V14H5v-2.3a1.5 1.5 0 011.5-1.5z"/><path fill="#fbfbf0" d="M4 14.8h16v4.2a1.5 1.5 0 01-1.5 1.5h-13A1.5 1.5 0 014 19v-4.2z"/><path fill="none" stroke="#5a5806" stroke-width="1.2" stroke-linecap="round" d="M5.2 14.4c1.2 1.4 2.4 1.4 3.6 0s2.4-1.4 3.6 0 2.4 1.4 3.6 0 2.4-1.4 2.8 0"/></svg>';
$shop='ஏதேன் அழைப்பிதழ்';
// மொபைல் ஃபுட்டர் பின்னணி: டெஸ்க்டாப் படத்தில் உள்ள அதே பச்சை நிறத்தை படத்திலிருந்தே எடுக்கிறோம் (ஒரே green)
$fc='#51500a';
$fp=__DIR__.'/assets/img/s5.jpg';
if(is_file($fp)&&function_exists('imagecreatefromstring')){
 $im=@imagecreatefromstring(@file_get_contents($fp));
 if($im){$iw=imagesx($im);$ih=imagesy($im);$r=$g=$b=$n=0;
  for($x=(int)($iw*.34);$x<=(int)($iw*.41);$x+=3){for($y=(int)($ih*.12);$y<=(int)($ih*.88);$y+=3){$c=imagecolorat($im,$x,$y);$r+=($c>>16)&255;$g+=($c>>8)&255;$b+=$c&255;$n++;}}
  if($n){$fc=sprintf('#%02x%02x%02x',round($r/$n),round($g/$n),round($b/$n));}
  imagedestroy($im);}
}

// டெஸ்க்டாப்: பச்சை ரவுண்ட் ஐகான் பகுதியை நீக்க, s2 படத்தின் மேல் இத்தனை px (1024px டிசைன் அளவில்) வெட்டப்படும்.
// இடைவெளி/வெட்டு சரியாக இல்லையென்றால் இந்த எண்ணை மட்டும் மாற்றவும் (பெரிய எண் = அதிகம் வெட்டும்)
$cut=268;
// டெஸ்க்டாப்: s2 படத்தின் மேல் அலங்கார பட்டை (மூலை கொடிகள்) உயரம் — கார்டுகளுக்கு மேலே
$strip=64;

require_once __DIR__.'/includes/db.php'; // (பேனரில் இனி அழைப்பிதழ் ஸ்லைடு இல்லை; ஆனால் நாவ்பார் / மற்ற பகுதிகளுக்காக இந்த கோப்பு அப்படியே இருக்கிறது)
require_once __DIR__.'/includes/navbar.php'; // பொதுவான நாவ்பார் (products / about / contact பக்கங்களில் உள்ள அதே நாவ்பார்)
// position helpers: x,y are pixel coordinates of the 1024px-wide design; $o = section top, $H = section height
function P($x,$y,$o,$H){return 'left:'.round($x/10.24,3).'%;top:'.round(($y-$o)/$H*100,3).'%';}
function T($x,$y,$o,$H,$cls,$html,$href=''){$s=P($x,$y,$o,$H);return $href?'<a class="t '.$cls.'" style="'.$s.'" href="'.$href.'">'.$html.'</a>':'<span class="t '.$cls.'" style="'.$s.'">'.$html.'</span>';}
function A($x,$y,$o,$H,$cls,$href,$title=''){return '<a class="'.$cls.'" style="'.P($x,$y,$o,$H).'" href="'.$href.'" title="'.$title.'"></a>';}

// படத்திலிருந்து நிறம் எடுக்கும் உதவி செயல்கள் (GD இல்லையென்றால் இயல்பு நிறம் பயன்படும்)
function im_load($f){if(!is_file($f)||!function_exists('imagecreatefromstring'))return null;$d=@file_get_contents($f);$im=$d?@imagecreatefromstring($d):false;return $im?:null;}
function im_avg($im,$dw,$dh,$x1,$y1,$x2,$y2,$fb){
 if(!$im)return $fb;$iw=imagesx($im);$ih=imagesy($im);
 $X1=max(0,(int)($x1/$dw*$iw));$X2=min($iw-1,(int)($x2/$dw*$iw));$Y1=max(0,(int)($y1/$dh*$ih));$Y2=min($ih-1,(int)($y2/$dh*$ih));
 $sx=max(1,(int)(($X2-$X1)/40));$sy=max(1,(int)(($Y2-$Y1)/8));$r=$g=$b=$n=0;
 for($x=$X1;$x<=$X2;$x+=$sx){for($y=$Y1;$y<=$Y2;$y+=$sy){$c=imagecolorat($im,$x,$y);$r+=($c>>16)&255;$g+=($c>>8)&255;$b+=$c&255;$n++;}}
 return $n?sprintf('#%02x%02x%02x',round($r/$n),round($g/$n),round($b/$n)):$fb;
}
$im2=im_load(__DIR__.'/assets/img/s2.jpg');
$dcTop=im_avg($im2,1024,618,150,$cut+$strip-4,440,$cut+$strip-1,'#fdf8ea'); // கார்டுகள் பகுதியின் மேல் நிறம்
$dcBot=im_avg($im2,1024,618,150,614,440,617,'#f8f0d9');                      // கார்டுகள் பகுதியின் கீழ் நிறம்
if($im2)imagedestroy($im2);

/* ===== பேனர் லோகோ (டெஸ்க்டாப் + மொபைல் இரண்டிலும் ஒரே லோகோ) ===== */
function hl_logo($cls=''){
 return '<div class="hl '.$cls.'"><div class="hl-art" role="img" aria-label="ஏதேன் அழைப்பிதழ் லோகோ">'
 .'<i class="hl-glow"></i><i class="hl-r1"></i><i class="hl-r2"></i>'
 .'<i class="hl-g gt"></i><i class="hl-g gb"></i><i class="hl-g gl"></i><i class="hl-g gr"></i>'
 .'<i class="hl-sp sa"></i><i class="hl-sp sb"></i><i class="hl-sp sc"></i><i class="hl-sp sd"></i>'
 .'<div class="hl-logo"></div></div>'
 .'<div class="hl-orn" aria-hidden="true"><i></i></div>'
 .'<p class="hl-c1">அன்பின் அழைப்பு, அழகிய வடிவில்</p>'
 .'<p class="hl-c2">உங்கள் விழாவின் முதல் வரவேற்பு</p></div>';
}

// 14 கார்டுகள் (ஆர்டர் 1–14). கார்டு: [படத்தில் மையம் x, தலைப்பு, விளக்கம், type, English பொருள், (விருப்பம்) படம்]
// 5-ஆவது index-க்குப் பிறகு 6-ஆவதாக படம் கொடுத்தால், அந்த படம் arch-க்குள் நிரம்பும் (தாம்பூலம் பை கார்டு போலவே)
$cards=[
 [705,'சுயவிருப்ப ','உங்கள் விருப்பப்படி<br>தனியாக வடிவமைக்கும்<br>அழைப்பிதழ்கள்.','personalized','Personalized Invitation','assets/img/cat-personalized.jpg'], // 1
 [513,'புதுமனை புகுவிழா','புதிய இல்லத்தின்<br>புகுவிழாவிற்கான<br>அழைப்பிதழ்கள்.','housewarming','Housewarming Invitation'], // 2
 [705,'நிச்சயதார்த்தம்','இனிய நிச்சயதார்த்த<br>விழாவிற்கான<br>அழைப்பிதழ்கள்.','betrothal','Betrothal Invitation','assets/img/cat-betrothal.jpg'], // 3
 [705,'திருமணம்','இனிய வாழ்க்கைக்கான<br>திருமண அழைப்பிதழ்கள்.','wedding','Wedding Invitation'], // 4
 [132,'வளைகாப்பு','அன்பும் நலனும்<br>நிறைந்த வளைகாப்பு<br>அழைப்பிதழ்கள்.','babyshower','Baby Shower Invitation'], // 5
 [322,'காதணி விழா','குழந்தைகளின்<br>காதணி விழாவிற்கான<br>அழைப்பிதழ்கள்.','earpiercing','Ear Piercing Invitation'], // 6
 [705,'ஞானஸ்நானம்','குழந்தையின்<br>ஞானஸ்நான விழாவிற்கான<br>அழைப்பிதழ்கள்.','baptism','Baptism Invitation','assets/img/cat-baptism.jpg'], // 7
 [895,'பிறந்தநாள்','குழந்தைகளின் இனிய<br>பிறந்தநாள் விழாவிற்கான<br>அழைப்பிதழ்கள்.','birthday','Birthday Invitation'], // 8
 [705,'புதுநன்மை','முதல் நற்கருணை<br>விழாவிற்கான<br>அழகிய அழைப்பிதழ்கள்.','communion','Holy Communion Invitation','assets/img/cat-communion.jpg'], // 9
 [705,'பூப்புனித விழா','பூப்புனித நீராட்டு<br>விழாவிற்கான<br>அழகிய அழைப்பிதழ்கள்.','puberty','Puberty Invitation','assets/img/cat-puberty.jpg'], // 10
 [705,'திறப்பு விழா','புதிய தொடக்கத்தின்<br>திறப்பு விழாவிற்கான<br>அழைப்பிதழ்கள்.','opening','Opening Invitation','assets/img/cat-opening.jpg'], // 11
 [705,'நன்றி','அன்பான நன்றியை<br>தெரிவிக்கும்<br>அழகிய அழைப்பிதழ்கள்.','thanks','Thank You Invitation','assets/img/cat-thanks.jpg'], // 12
 [705,'சுருள்','அழகிய சுருள் வடிவ<br>அழைப்பிதழ்களின்<br>சிறப்புத் தொகுப்பு.','scroll','Scroll Invitation','assets/img/cat-scroll.jpg'], // 13
 [0,'தாம்பூலம் பை','விழா விருந்தினர்களுக்கான<br>அழகிய தாம்பூலப் பைகள்.','bags','Thamboolam Bag'] // 14
];

/* ===== தாம்பூலம் பை கார்டுக்கான படம் (மற்ற கார்டுகளின் அதே பாணி: கிரீம் + மெரூன் + ரோஜா பூக்கள்) — தனி கோப்பு தேவையில்லை ===== */
$tbSvg='<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 280 224"><defs>'
.'<linearGradient id="bg" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#fff8ec"/><stop offset=".6" stop-color="#fbe4dc"/><stop offset="1" stop-color="#f2cfc3"/></linearGradient>'
.'<radialGradient id="gl" cx=".5" cy=".42" r=".55"><stop offset="0" stop-color="#fffdf5" stop-opacity=".95"/><stop offset="1" stop-color="#fffdf5" stop-opacity="0"/></radialGradient>'
.'<radialGradient id="bag" cx=".36" cy=".28" r=".85"><stop offset="0" stop-color="#d63a83"/><stop offset=".55" stop-color="#9a1458"/><stop offset="1" stop-color="#560a31"/></radialGradient>'
.'<linearGradient id="lf" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#8fbd54"/><stop offset="1" stop-color="#3d7028"/></linearGradient>'
.'<linearGradient id="gd" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#fbe7a1"/><stop offset=".5" stop-color="#d9a93f"/><stop offset="1" stop-color="#a87820"/></linearGradient>'
.'<radialGradient id="rs" cx=".4" cy=".35" r=".75"><stop offset="0" stop-color="#fbc9dc"/><stop offset=".6" stop-color="#ea8fb5"/><stop offset="1" stop-color="#c34a82"/></radialGradient>'
.'<linearGradient id="tb" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#f4dcc0"/><stop offset="1" stop-color="#e5bf94"/></linearGradient>'
.'<filter id="sh" x="-30%" y="-100%" width="160%" height="300%"><feGaussianBlur stdDeviation="3.5"/></filter>'
.'<g id="rose"><circle r="20" fill="url(#rs)"/><circle r="14" fill="none" stroke="#c4467e" stroke-width="1.6" opacity=".65"/><circle r="8" fill="none" stroke="#b8386f" stroke-width="1.5" opacity=".7"/><path d="M-5 0C-5-7 5-7 5 0C5 5-3 5-3 1" fill="none" stroke="#a82e66" stroke-width="1.5"/><path d="M-18-8C-8-20 10-20 18-8" fill="none" stroke="#fff" stroke-width="2" opacity=".35" stroke-linecap="round"/></g>'
.'<g id="lv"><path d="M0 0C6-10 18-10 26 0C18 10 6 10 0 0Z" fill="url(#lf)"/><path d="M2 0H22" stroke="#cfe8a4" stroke-width="1"/></g>'
.'</defs>'
.'<rect width="280" height="224" fill="url(#bg)"/><rect width="280" height="224" fill="url(#gl)"/>'
.'<g fill="#fff" opacity=".4"><circle cx="30" cy="48" r="15"/><circle cx="252" cy="52" r="11"/><circle cx="236" cy="104" r="17"/><circle cx="46" cy="112" r="9"/><circle cx="200" cy="30" r="7"/></g>'
.'<path d="M0 158Q140 138 280 158V224H0Z" fill="url(#tb)"/><path d="M0 170Q140 152 280 170V224H0Z" fill="#d9b080" opacity=".35"/>'
.'<path d="M18 12Q140 46 262 12" fill="none" stroke="#fff" stroke-width="5.5" stroke-linecap="round" stroke-dasharray="0 9.5"/>'
.'<path d="M18 12Q140 46 262 12" fill="none" stroke="#e6b94f" stroke-width="1.2" stroke-linecap="round" stroke-dasharray="0 9.5" stroke-dashoffset="-.1"/>'
.'<ellipse cx="140" cy="178" rx="56" ry="9" fill="#4a0828" opacity=".3" filter="url(#sh)"/>'
.'<g transform="translate(86 172) rotate(-18)"><path d="M0 0C14-24 42-28 60 0C42 26 14 24 0 0Z" fill="url(#lf)"/><path d="M3 0H56" stroke="#cfe8a4" stroke-width="1.3"/></g>'
.'<g transform="translate(194 172) rotate(-162)"><path d="M0 0C14-24 42-28 60 0C42 26 14 24 0 0Z" fill="url(#lf)"/><path d="M3 0H56" stroke="#cfe8a4" stroke-width="1.3"/></g>'
.'<g transform="translate(92 168) rotate(-52)"><path d="M0 0C10-18 32-20 46 0C32 20 10 18 0 0Z" fill="#4f8730"/><path d="M3 0H42" stroke="#b9dc8a" stroke-width="1.1"/></g>'
.'<g transform="translate(188 168) rotate(-128)"><path d="M0 0C10-18 32-20 46 0C32 20 10 18 0 0Z" fill="#4f8730"/><path d="M3 0H42" stroke="#b9dc8a" stroke-width="1.1"/></g>'
.'<circle cx="88" cy="184" r="13" fill="#8a5a33"/><circle cx="84" cy="180" r="5" fill="#b98957" opacity=".7"/><circle cx="86" cy="187" r="1.6" fill="#4b2c14"/><circle cx="91" cy="187" r="1.6" fill="#4b2c14"/><circle cx="88.5" cy="191" r="1.6" fill="#4b2c14"/>'
.'<ellipse cx="194" cy="188" rx="16" ry="6" fill="url(#gd)"/><ellipse cx="194" cy="185" rx="12" ry="4.2" fill="#d6252e"/><ellipse cx="194" cy="184" rx="7" ry="2" fill="#f0a31a" opacity=".8"/>'
.'<path d="M118 86C96 106 84 140 92 162C98 178 120 182 140 182C160 182 182 178 188 162C196 140 184 106 162 86C154 92 126 92 118 86Z" fill="url(#bag)"/>'
.'<path d="M126 92C116 122 110 152 106 174M140 94C140 126 140 154 140 180M154 92C164 122 170 152 174 174" fill="none" stroke="#fff" stroke-width="1.4" opacity=".14"/>'
.'<ellipse cx="116" cy="128" rx="7" ry="28" fill="#fff" opacity=".16" transform="rotate(8 116 128)"/>'
.'<path d="M114 86C118 70 132 64 140 70C148 64 162 70 166 86C156 95 124 95 114 86Z" fill="#b82170"/><path d="M122 84C128 92 152 92 158 84" fill="none" stroke="#7a0f45" stroke-width="1.5" opacity=".6"/>'
.'<path d="M118 90C130 99 150 99 162 90" fill="none" stroke="url(#gd)" stroke-width="3.2" stroke-linecap="round"/>'
.'<path d="M140 94C116 72 108 96 134 97M140 94C164 72 172 96 146 97" fill="none" stroke="url(#gd)" stroke-width="3" stroke-linecap="round"/>'
.'<circle cx="140" cy="95" r="4.2" fill="url(#gd)"/>'
.'<path d="M138 99C132 112 128 120 126 130M142 99C148 112 152 120 154 130" fill="none" stroke="url(#gd)" stroke-width="2.4" stroke-linecap="round"/><circle cx="126" cy="132" r="3.2" fill="url(#gd)"/><circle cx="154" cy="132" r="3.2" fill="url(#gd)"/>'
.'<circle cx="140" cy="150" r="19" fill="none" stroke="url(#gd)" stroke-width="2.2"/><circle cx="140" cy="150" r="15" fill="none" stroke="url(#gd)" stroke-width=".9" stroke-dasharray="1.5 2.6"/>'
.'<g fill="url(#gd)"><ellipse cx="140" cy="141" rx="3.2" ry="6"/><ellipse cx="140" cy="159" rx="3.2" ry="6"/><ellipse cx="131" cy="150" rx="6" ry="3.2"/><ellipse cx="149" cy="150" rx="6" ry="3.2"/><circle cx="140" cy="150" r="3.4"/></g>'
.'<use href="#lv" transform="translate(66 156) rotate(-30)"/><use href="#lv" transform="translate(48 178) rotate(20) scale(.8)"/><use href="#lv" transform="translate(214 156) rotate(-150)"/><use href="#lv" transform="translate(232 178) rotate(160) scale(.8)"/>'
.'<use href="#rose" transform="translate(52 168)"/><use href="#rose" transform="translate(30 142) scale(.7)"/><use href="#rose" transform="translate(228 168)"/><use href="#rose" transform="translate(250 142) scale(.7)"/>'
.'<use href="#rose" transform="translate(26 28) scale(.55)"/><use href="#rose" transform="translate(254 28) scale(.55)"/>'
.'<g fill="#e9bf55"><path d="M60 96l2.2 5.8 5.8 2.2-5.8 2.2L60 112l-2.2-5.8-5.8-2.2 5.8-2.2z"/><path d="M222 78l1.8 4.6 4.6 1.8-4.6 1.8L222 91l-1.8-4.8-4.6-1.8 4.6-1.8z"/><path d="M196 112l1.4 3.6 3.6 1.4-3.6 1.4-1.4 3.6-1.4-3.6-3.6-1.4 3.6-1.4z"/></g>'
.'</svg>';
$tbUri='data:image/svg+xml;base64,'.base64_encode($tbSvg);
// தாம்பூலம் பை கார்டில் உண்மையான AI படம் வேண்டுமென்றால்: assets/img/thambulam.jpg என்ற பெயரில் படத்தை போடவும் (தானாக எடுத்துக்கொள்ளும்)
$tbPhoto=is_file(__DIR__.'/assets/img/thambulam.jpg');
function nc_card($c){
 global $tbPhoto;
 $bag=($c[3]==='bags');
 $img=isset($c[5])?$c[5]:'';
 $ph=($bag||$img!=='');
 $u=$bag?'products.php#bags':'products.php?type='.$c[3];
 $ox=$ph?round((705-86)/172,4):round(($c[0]-86)/172,4); // படம் உள்ள கார்டுகள்: அதே கார்டு சட்டம் (படம் மட்டும் மாற்றப்படும்)
 $sm=mb_strlen($c[1],'UTF-8')>11?' sm':'';
 $title=$bag?$c[1]:$c[1].'<br>அழைப்பிதழ்';
 $h='<a class="nc'.($ph?' nc-bag':'').'" href="'.$u.'" style="--ox:'.$ox.'"><span class="nc-a"></span><span class="nc-f"></span><span class="nc-b"></span>';
 if($bag){$h.=$tbPhoto?'<span class="nc-ph ph-img" style="background-image:url(assets/img/thambulam.jpg)"></span>':'<span class="nc-ph ph-art"></span>';}
 elseif($img!==''){$h.='<span class="nc-ph ph-img" style="background-image:url('.$img.')"></span>';}
 $h.='<b class="nc-t'.$sm.'"><span>'.$title.'</span></b><span class="nc-e">('.$c[4].')</span><span class="nc-d">'.str_replace('<br>',' ',$c[2]).'</span><span class="nc-btn">மேலும் காண்க &nbsp;→</span></a>';
 return $h;
}

// பரிசு வகைகள்: [பழைய படத்தில் இடம் x, படத்தில் ஐகான் x, தமிழ், English]  (தாம்பூலம் பை நீக்கப்பட்டது)
$gifts=[
 [486,547,'பரிசு பெட்டி','Gift Box'],
 [605,667,'முறுக்கு பை','Murukku Bag'],
 [725,786,'மிட்டாய் பை','Sweet Bag'],
 [844,906,'நன்றி பரிசு','Thank You Gift']
];
?><!doctype html><html lang="ta"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=$shop?></title>
<link href="https://fonts.googleapis.com/css2?family=Baloo+Thambi+2:wght@500;600;700;800&family=Cinzel:wght@600&family=Cormorant+Garamond:ital,wght@1,500&family=Mukta+Malar:wght@400;500;700&family=Poppins:wght@500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/home.css">
<style>
/* ===== லேப்டாப் டிசைன் அப்படியே — மொபைலில் விகிதம் மாறாமல் சுருங்கும் ===== */
html{-webkit-text-size-adjust:100%;text-size-adjust:100%}
body{overflow-x:hidden!important}
.pg{min-width:0!important;width:100%}
/* பேனர்: விளக்கு / இலை / பூக்கள் நீக்கப்பட்ட புதிய படம் (நாவ்பார் இல்லாமல்) */
.pg .s1{aspect-ratio:1024/352;background-image:url(assets/img/home-hero.jpg)}
/* தலைப்பு எழுத்து வெட்டுப்படாமல் முழுதாகத் தெரிய */
.gold{line-height:1.55;padding:.12em .1em .16em;overflow:visible}
/* டெஸ்க்டாப்: "புதுமனை புகுவிழா" போன்ற நீண்ட தலைப்பு கார்டுக்குள்ளேயே அடங்கும் */
.sx .ct.sm{font-size:1.5cqw!important;letter-spacing:0!important;white-space:nowrap!important;line-height:1.25}
.archfix{position:absolute;display:grid;place-items:center;background:linear-gradient(90deg,#fbf3dd,#fdf8e5 12%,#fef9eb 25%,#fbf8ec 38%,#fcf9f2 50%,#fdf9ed 62%,#fdf7e6 75%,#fbf4e1 88%,#faefd4)}
.archfix b{font-family:Cinzel,serif;font-weight:600;color:#741041;font-size:2.7cqw;letter-spacing:.1em;white-space:nowrap;line-height:1}
.bfix{position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);display:grid;place-items:center;border-radius:50%;pointer-events:none;background:radial-gradient(circle,#5f5d08 0,#595709 58%,rgba(78,76,5,.0) 100%)}
.bfix svg{display:block;width:58%;height:auto}
.md .bfix{width:60%;aspect-ratio:1}
.m2,.m3,.m4,.mh{display:none}

/* ===== பேனர் லோகோ (அழைப்பிதழ் ஸ்லைடுக்கு பதிலாக) ===== */
.hl{display:flex;flex-direction:column;align-items:center;text-align:center;--art:66%}
.hl *{box-sizing:border-box}
.hl p{margin:0;padding:0}
.hl-art{position:relative;width:var(--art);aspect-ratio:1;flex:none}
.hl-glow{position:absolute;inset:-28%;border-radius:50%;background:radial-gradient(circle,rgba(250,214,120,.5) 0,rgba(214,90,140,.28) 38%,transparent 68%);animation:hlpulse 4.4s ease-in-out infinite}
.hl-r1{position:absolute;inset:-9%;border-radius:50%;border:2px dashed rgba(243,217,149,.75);animation:hlspin 48s linear infinite}
.hl-r2{position:absolute;inset:-4%;border-radius:50%;border:2px solid #e2b44f;box-shadow:0 0 14px rgba(243,217,149,.45),inset 0 0 10px rgba(226,180,79,.35)}
.hl-g{position:absolute;width:5.5%;aspect-ratio:1;transform:translate(-50%,-50%) rotate(45deg);background:linear-gradient(135deg,#f3d995,#b8862c);box-shadow:0 0 0 2px #5a0a2e,0 0 0 3px #e2b44f}
.hl-g.gt{left:50%;top:-4%}.hl-g.gb{left:50%;top:104%}.hl-g.gl{left:-4%;top:50%}.hl-g.gr{left:104%;top:50%}
.hl-logo{position:absolute;inset:0;border-radius:50%;overflow:hidden;background:#6b0000 url(assets/img/logo.jpeg) no-repeat 48.98% 33.3%/180.7% auto;border:3px solid #f3d995;box-shadow:0 0 0 4px rgba(233,196,106,.3),0 14px 34px rgba(0,0,0,.55),0 0 38px rgba(255,214,120,.35)}
.hl-logo::after{content:"";position:absolute;inset:0;border-radius:50%;background:linear-gradient(115deg,transparent 36%,rgba(255,255,255,.38) 48%,transparent 60%);background-size:260% 100%;background-position:130% 0;animation:hlshine 5.6s ease-in-out infinite}
.hl-sp{position:absolute;width:7%;aspect-ratio:1;background:#fff1b8;clip-path:polygon(50% 0,60% 40%,100% 50%,60% 60%,50% 100%,40% 60%,0 50%,40% 40%);animation:hltw 2.9s ease-in-out infinite}
.hl-sp.sa{left:-6%;top:6%}.hl-sp.sb{right:-8%;top:20%;animation-delay:.9s;width:5.5%}.hl-sp.sc{left:-10%;bottom:14%;animation-delay:1.7s;width:5%}.hl-sp.sd{right:-4%;bottom:2%;animation-delay:.4s}
.hl-orn{display:flex;align-items:center;justify-content:center;gap:10px;width:70%;max-width:300px}
.hl-orn::before,.hl-orn::after{content:"";flex:1;height:1.5px;background:linear-gradient(90deg,transparent,#E2B44F)}.hl-orn::after{transform:scaleX(-1)}
.hl-orn i{width:9px;height:9px;transform:rotate(45deg);background:linear-gradient(135deg,#F3D995,#B8862C);box-shadow:0 0 0 2px #4a0524,0 0 0 3px #E2B44F}
.hl-c1,.hl-c2{font-family:'Baloo Thambi 2','Mukta Malar',sans-serif;line-height:1.45;white-space:nowrap;text-shadow:0 2px 6px rgba(20,0,10,.6)}
.hl-c1{font-weight:700;color:#f3d995}
.hl-c2{font-weight:600;color:#fbeed0}
@keyframes hlspin{to{transform:rotate(360deg)}}
@keyframes hlpulse{0%,100%{opacity:.75;transform:scale(.96)}50%{opacity:1;transform:scale(1.04)}}
@keyframes hlshine{0%,55%{background-position:130% 0}100%{background-position:-30% 0}}
@keyframes hltw{0%,100%{opacity:.15;transform:scale(.55)}50%{opacity:1;transform:scale(1)}}
@media(prefers-reduced-motion:reduce){.hl-glow,.hl-r1,.hl-logo::after,.hl-sp{animation:none}}
/* டெஸ்க்டாப்: பேனரின் வலது பக்கத்தில் */
.s1 .hl{position:absolute;left:68.7%;top:50%;width:25.5%;transform:translate(-50%,-50%);z-index:3}
.s1 .hl-orn{margin:3.1cqw 0 .6cqw}
.s1 .hl-c1{font-size:2cqw}.s1 .hl-c2{font-size:1.75cqw}
/* மொபைல் பேனர் (.mh) */
.mh{position:relative;overflow:hidden;text-align:center;padding:26px 16px 34px;color:#FBEED0;
 background:radial-gradient(ellipse 70% 38% at 50% 8%,rgba(176,38,92,.5),transparent 70%),radial-gradient(ellipse 80% 40% at 50% 100%,rgba(176,38,92,.38),transparent 70%),linear-gradient(#5a0a2e,#4a0524 55%,#5a0a2e);
 border-bottom:3px solid #E2B44F;box-shadow:inset 0 0 0 1px rgba(226,180,79,.35)}
.mh *{box-sizing:border-box}
.mh h1,.mh p{margin:0;padding:0}
.mh-g1,.mh-g2{display:block;font-family:'Baloo Thambi 2','Mukta Malar',sans-serif;font-weight:800;line-height:1.35;background:linear-gradient(#fff1b8,#e2b44f 55%,#b8862c);-webkit-background-clip:text;background-clip:text;color:transparent;-webkit-text-fill-color:transparent;filter:drop-shadow(0 3px 4px rgba(20,0,10,.55))}
.mh-g1{font-size:min(15vw,78px)}.mh-g2{font-size:min(13.4vw,70px);margin-top:-.08em}
.mh-ath{margin-top:10px;font-family:Cinzel,serif;font-weight:600;color:#f3d995;letter-spacing:.2em;font-size:min(6.4vw,30px);text-shadow:0 2px 4px rgba(0,0,0,.5)}
.mh-inv{font-family:Cinzel,serif;font-weight:600;color:#f3d995;letter-spacing:.34em;font-size:min(4.2vw,21px);margin-top:2px;padding-left:.34em}
.mh-orn{display:flex;align-items:center;justify-content:center;gap:10px;margin:10px auto 8px;max-width:300px}
.mh-orn::before,.mh-orn::after{content:"";flex:1;height:1.5px;background:linear-gradient(90deg,transparent,#E2B44F)}.mh-orn::after{transform:scaleX(-1)}
.mh-orn i{width:9px;height:9px;transform:rotate(45deg);background:linear-gradient(135deg,#F3D995,#B8862C);box-shadow:0 0 0 2px #4a0524,0 0 0 3px #E2B44F}
.mh-exc{font-family:'Cormorant Garamond',serif;font-style:italic;font-weight:500;color:#fbeed0;font-size:min(5.2vw,26px);letter-spacing:.02em}
.hl-m{width:100%;margin-top:40px;--art:min(48vw,200px)}
.hl-m .hl-orn{margin:30px 0 8px;width:60%}
.hl-m .hl-c1{font-size:min(4.7vw,19px);white-space:normal;text-wrap:balance}
.hl-m .hl-c2{font-size:min(4.2vw,17px);white-space:normal;text-wrap:balance}
/* ஃபுட்டர் லோகோ — கிளிக் செய்தால் admin பக்கத்திற்கு செல்லும் (டெஸ்க்டாப் + மொபைல்) */
.logo-link{position:absolute;display:block;width:10.5%;aspect-ratio:1;transform:translate(-50%,-50%);border-radius:50%;z-index:6;cursor:pointer;-webkit-tap-highlight-color:transparent}

/* ===== அழைப்பிதழ் கார்டுகள் (10 கார்டு) — டெஸ்க்டாப் + மொபைல் இரண்டுக்கும் ஒரே கார்டு அமைப்பு ===== */
.nc{position:relative;display:block;container-type:inline-size;aspect-ratio:172/295;width:100%;--u:calc(100cqw/172);border-radius:14px;background:#fbf3dd;text-decoration:none;color:inherit;-webkit-tap-highlight-color:transparent;filter:drop-shadow(0 6px 10px rgba(110,13,63,.16));transition:transform .2s}
.nc>*{position:absolute}
.nc-a,.nc-f,.nc-b{left:0;width:100%;background-image:url(assets/img/s2.jpg);background-repeat:no-repeat;background-size:calc(100cqw*5.9535) auto;background-position-x:calc(100cqw*var(--ox)*-1)}
.nc-a{top:0;height:calc(var(--u)*141);border-radius:14px 14px 0 0;background-position-y:calc(var(--u)*-335)}
.nc-f{top:calc(var(--u)*139);height:calc(var(--u)*19);background-size:calc(100cqw*5.9535) calc(var(--u)*1050.6);background-position-y:calc(var(--u)*-816)}
.nc-b{top:calc(var(--u)*157);height:calc(var(--u)*138);border-radius:0 0 14px 14px;background-position-y:calc(var(--u)*-475)}
.nc-t{left:3%;width:94%;top:calc(var(--u)*126);height:calc(var(--u)*43);display:flex;align-items:center;justify-content:center;text-align:center;font-family:'Baloo Thambi 2','Mukta Malar',sans-serif;font-weight:800;font-size:calc(var(--u)*17.5);line-height:1.12;color:#8f1456}
.nc-t.sm{font-size:calc(var(--u)*13.6)}
.nc-e{left:0;width:100%;top:calc(var(--u)*169);height:calc(var(--u)*14);text-align:center;font-family:'Mukta Malar','Poppins',sans-serif;font-weight:700;font-size:calc(var(--u)*10.8);line-height:calc(var(--u)*14);color:#8f1456;white-space:nowrap}
.nc-d{left:8%;width:84%;top:calc(var(--u)*193);height:calc(var(--u)*50);display:flex;align-items:center;justify-content:center;text-align:center;font-family:'Mukta Malar','Noto Sans Tamil',sans-serif;font-weight:700;font-size:calc(var(--u)*11.9);line-height:1.28;color:#2b1a22;text-wrap:balance}
.nc-btn{left:11%;width:78%;top:calc(var(--u)*254);height:calc(var(--u)*26);display:grid;place-items:center;border-radius:99px;color:#fff;font-family:'Baloo Thambi 2','Mukta Malar',sans-serif;font-weight:800;font-size:calc(var(--u)*12.4);white-space:nowrap;background:linear-gradient(#b21d68,#6a0d3f);border:1px solid #e3c27a;box-shadow:0 3px 8px rgba(110,13,63,.4),inset 0 1px 0 rgba(255,255,255,.25)}
/* படம் உள்ள கார்டுகளின் படப்பகுதி (தாம்பூலம் பை + புதுநன்மை / ஞானஸ்நானம் / நிச்சயதார்த்தம் / சுருள்) — படம் நேரடியாக arch வடிவத்துக்குள் நிரம்பும் */
.nc-ph{left:calc(var(--u)*13);width:calc(var(--u)*146);top:calc(var(--u)*11);height:calc(var(--u)*114);border-radius:50% 50% calc(var(--u)*9) calc(var(--u)*9) / 62% 62% calc(var(--u)*9) calc(var(--u)*9);background:none;border:0;box-shadow:none;display:block;overflow:hidden}
.nc-ph.ph-art{background-size:cover;background-position:center;background-repeat:no-repeat}
.nc-ph.ph-img{background-color:transparent;background-size:cover;background-position:50% 52%;background-repeat:no-repeat}
.nc-ph.ph-art{background-image:url("<?=$tbUri?>")}

/* டெஸ்க்டாப் கார்டு வரிசை */
.dc{position:relative;width:100%;container-type:inline-size}
.dc-top{height:<?=round($strip/10.24,3)?>cqw;background-image:url(assets/img/s2.jpg);background-repeat:no-repeat;background-size:100% auto;background-position:0 <?=round(-$cut/10.24,3)?>cqw}
.dc-row{display:grid;grid-template-columns:repeat(10,minmax(0,1fr));gap:1.9cqw 1.4cqw;padding:.4cqw 2.6cqw 2.4cqw;background:linear-gradient(<?=$dcTop?>,<?=$dcBot?>)}
/* டெஸ்க்டாப்: 14 கார்டுகள் = 5 + 5 + 4 (கடைசி வரிசை நடுவில்) */
.dc-row .nc{width:auto;min-width:0;grid-column:span 2}
@media(hover:hover){.dc-row .nc:hover{transform:translateY(-4px)}}

/* ===== பரிசு வகைகள் (டெஸ்க்டாப்) ===== */
.sx .gen{position:absolute;transform:translate(-50%,-50%);white-space:nowrap;margin:0;font-family:'Mukta Malar',Poppins,sans-serif;font-weight:700;font-size:1.4cqw;letter-spacing:.04em;color:#8f1456}
.sx .gi{position:absolute;width:9.375cqw;aspect-ratio:1;transform:translate(-50%,-50%);border-radius:50%;background:url(assets/img/s3.jpg) no-repeat;background-size:100cqw auto;clip-path:circle(45%);pointer-events:none;z-index:1}
/* பழைய 5 ஐகான் + பழைய கோடு இருந்த பகுதியை, அதே படத்தின் வெற்று பட்டையை நீட்டி மூடுகிறது */
.sx .gband{position:absolute;left:34.96%;top:31.09%;width:59.18%;height:11.914cqw;background:url(assets/img/s3.jpg) no-repeat;background-size:100cqw 202.54cqw;background-position:-34.96cqw -170.2cqw;pointer-events:none;z-index:0;
 -webkit-mask-image:linear-gradient(to right,transparent,#000 2%,#000 98%,transparent),linear-gradient(to bottom,transparent,#000 7%,#000 93%,transparent);-webkit-mask-composite:source-in;
 mask-image:linear-gradient(to right,transparent,#000 2%,#000 98%,transparent),linear-gradient(to bottom,transparent,#000 7%,#000 93%,transparent);mask-composite:intersect}
.sx .gdiv{position:absolute;transform:translate(-50%,-50%);width:25cqw;display:flex;align-items:center;gap:.8cqw;pointer-events:none}
.sx .gdiv::before,.sx .gdiv::after{content:"";flex:1;height:1.5px;background:linear-gradient(90deg,transparent,#c9a56b)}.sx .gdiv::after{transform:scaleX(-1)}
.sx .gdiv i{width:.9cqw;height:.9cqw;transform:rotate(45deg);background:#a3185f;border:2px solid #f6e6c8;box-shadow:0 0 0 1px #c9a56b}
.sx .lab{text-align:center}
.sx .lab .en{display:block;margin-top:.12em;font-family:'Mukta Malar',Poppins,sans-serif;font-weight:700;font-size:.64em;line-height:1.2;color:inherit;opacity:.88;letter-spacing:.02em}

/* ஒரே சதுர அனிமேஷன் இனி இல்லை */

/* ===== ஃபுட்டர் (லேப்டாப் / டேப்ளெட் / மொபைல்) ===== */
.ft>*,.ft::after{--sh:max(2.588cqw,22px)}
.ft{position:relative;container-type:inline-size;width:100%;overflow:hidden;box-sizing:border-box;
 background:radial-gradient(ellipse 60% 120% at 50% 40%,rgba(120,118,20,.35),transparent 70%),<?=$fc?>;
 border-top:2px solid #c9a24b}
.ft *{box-sizing:border-box}
.ft::after{content:"";position:absolute;left:0;right:0;bottom:0;height:var(--sh);pointer-events:none;background:url(assets/img/s5.jpg) no-repeat 50% 100%;background-size:calc(var(--sh)*38.64) auto;mix-blend-mode:lighten}
.ft-c{display:none;position:absolute;top:0;width:calc(var(--sh)*1.887);height:calc(var(--sh)*4.25);pointer-events:none;background:url(assets/img/s5.jpg) no-repeat;background-size:calc(var(--sh)*38.64) auto;z-index:1;mix-blend-mode:lighten}
.ft-c.l{left:0;background-position:0 0}.ft-c.r{right:0;background-position:100% 0}
.ft-in{padding:clamp(22px,3.2cqw,38px) clamp(34px,5.5cqw,90px) calc(var(--sh) + clamp(18px,2.6cqw,34px));position:relative;z-index:2;display:grid;grid-template-columns:1.15fr 1fr 1fr;align-items:center;max-width:1180px;margin:0 auto;box-sizing:content-box}
.ft-col{position:relative;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:0 clamp(10px,2cqw,28px);min-width:0}
.ft-col+.ft-col::before{content:"";position:absolute;left:0;top:6%;bottom:6%;width:1px;background:linear-gradient(transparent,#c9a24b 20%,#c9a24b 80%,transparent)}
.ft-brand{flex-direction:row;gap:clamp(10px,1.8cqw,22px)}
.ft-logo{display:block;flex:none;width:clamp(66px,9.6cqw,124px);aspect-ratio:1;border-radius:50%;cursor:pointer;-webkit-tap-highlight-color:transparent;
 background:#6b0000 url(assets/img/logo.jpeg) no-repeat 48.98% 33.3%;background-size:180.7% auto;
 border:2px solid #e9c46a;box-shadow:0 0 0 3px rgba(233,196,106,.28),0 4px 14px rgba(0,0,0,.4);transition:transform .2s,box-shadow .2s}
.ft-logo:hover{transform:scale(1.05);box-shadow:0 0 0 3px rgba(233,196,106,.5),0 0 16px rgba(246,226,168,.8)}
.ft-bt{display:flex;flex-direction:column;align-items:flex-start;text-align:left;line-height:1.15}
.ft-n1{font-family:'Baloo Thambi 2','Mukta Malar',sans-serif;font-weight:800;color:#fff8e6;font-size:clamp(19px,2.35cqw,32px);line-height:1.2}
.ft-n2{font-family:Cinzel,serif;color:#f3e6bd;font-size:clamp(8.5px,.95cqw,12.5px);letter-spacing:.17em;margin-top:5px;white-space:nowrap}
.ft-addr{font-style:normal;font-family:Poppins,'Mukta Malar',sans-serif;font-weight:500;color:#fff8e6;font-size:clamp(13px,1.5cqw,19px);line-height:1.6}
.ft-ta{display:block;font-family:'Baloo Thambi 2','Mukta Malar',sans-serif;font-weight:700;font-size:clamp(14px,1.6cqw,21px);line-height:1.4;color:#fff8e6}
.ft-en{display:block;margin-top:3px;font-size:.84em;opacity:.92}
.ft-tel{font-family:Poppins,sans-serif;font-weight:600;color:#fff8e6;font-size:clamp(14px,1.7cqw,22px);margin-top:8px;text-decoration:none;letter-spacing:.02em}
.ft-tel:hover{color:#f3d995}
.ft-faith{font-family:'Cormorant Garamond',serif;font-style:italic;font-weight:500;color:#f3e6bd;font-size:clamp(17px,1.95cqw,26px);letter-spacing:.06em;white-space:nowrap}
.ft-div{display:flex;align-items:center;gap:8px;width:clamp(120px,17cqw,210px);margin:9px 0 12px}
.ft-div i{flex:1;height:1px;background:linear-gradient(90deg,transparent,#d9b45a)}.ft-div i:last-child{transform:scaleX(-1)}
.ft-div em{width:9px;height:9px;transform:rotate(45deg);background:#c2185b;border:1.5px solid #f3d995}
.ft-wa{display:block;width:clamp(40px,4.6cqw,58px);aspect-ratio:1;border-radius:50%;transition:.25s;-webkit-tap-highlight-color:transparent}
.ft-wa svg{display:block;width:100%;height:100%}
.ft-wa:hover{transform:scale(1.12);box-shadow:0 0 18px rgba(246,226,168,.9)}
@media(max-width:760px){
 .ft>*,.ft::after{--sh:14px}
 .ft-c{display:block}
 .ft-in{padding:14px 30px calc(var(--sh) + 10px);grid-template-columns:1fr;gap:0}
 .ft-col{padding:9px 4px}
 .ft-col:first-child{padding-top:4px}
 .ft-col+.ft-col::before{left:10%;right:10%;top:0;bottom:auto;width:auto;height:1px;background:linear-gradient(90deg,transparent,#c9a56b 20%,#c9a56b 80%,transparent)}
 .ft-brand{gap:9px}
 .ft-logo{width:clamp(46px,15vw,60px);border-width:1.5px;box-shadow:0 0 0 2px rgba(233,196,106,.28),0 2px 8px rgba(0,0,0,.4)}
 .ft-n1{font-size:clamp(14px,4.3vw,17px);line-height:1.15}.ft-n2{font-size:7.5px;margin-top:3px;letter-spacing:.14em}
 .ft-addr{font-size:12px;line-height:1.5}.ft-ta{font-size:15px;line-height:1.35}.ft-en{font-size:11.5px}.ft-tel{font-size:13.5px;margin-top:4px}
 .ft-faith{font-size:15px;white-space:normal;line-height:1.25}
 .ft-div{width:120px;margin:5px 0 8px}
 .ft-wa{width:34px}
}
/* ===== மொபைல் (760px-க்குக் கீழே) ===== */
@media(max-width:760px){
 body{background:#fbf5e4 radial-gradient(circle at 20% 0,rgba(201,165,107,.16),transparent 40%),radial-gradient(circle at 90% 60%,rgba(163,24,95,.06),transparent 45%)}
 .pg .s1,.pg .s3,.dc{display:none}
 .mh{display:block}
 .m2,.m3{display:block}
 .pg .s4{aspect-ratio:1024/198}
 .gold{font-weight:800}
 .ath{font-size:3.5cqw;font-weight:800}.inv{font-size:2.6cqw;font-weight:700}.exc{font-size:2.7cqw;font-weight:700}
 .b1{font-size:2.9cqw;font-weight:800}.b2{font-size:3.6cqw;font-weight:800}.b3{font-size:2.7cqw;font-weight:700}
 .f1{font-size:2.7cqw;font-weight:800}.f2{font-size:1.15cqw;letter-spacing:.1em;font-weight:700}
 .fc{font-size:2.15cqw;font-weight:700}.faith{font-size:1.75cqw;font-weight:700}
 /* மொபைல்: பழைய ஃபுட்டர் படம் மறைந்து, தெளிவான புதிய ஃபுட்டர் (.m4) வரும் */
 /* ஐகான்கள் + கார்டுகள் */
 .m2{background:linear-gradient(#fdf8ea,#f8f0d9);padding:22px 0 6px;font-family:'Baloo Thambi 2','Mukta Malar',sans-serif}
 .m2 *,.m3 *{box-sizing:border-box}
 .m2 a,.m3 a{text-decoration:none;color:inherit;-webkit-tap-highlight-color:transparent}
 .mi,.mg{display:flex;flex-direction:column;align-items:center;gap:8px;text-align:center;transition:transform .15s}
 .mi:active,.mg:active,.nc:active{transform:scale(.96)}
 .mi-w{display:block;width:var(--is);aspect-ratio:1;border-radius:50%;box-shadow:0 6px 12px rgba(80,10,45,.32)}
 .mi-i,.mg-i{position:relative;display:block;width:var(--is,min(18vw,84px));aspect-ratio:1;clip-path:circle(50%);background:url(assets/img/s2.jpg) no-repeat;background-size:calc(var(--is,min(18vw,84px))*10.6667) auto;background-position:calc(var(--is,min(18vw,84px))*var(--ox)*-1) calc(var(--is,min(18vw,84px))*var(--oy)*-1);filter:saturate(1.55) contrast(1.18) brightness(.97)}
 .mi-i .bfix{width:64%;aspect-ratio:1}.mi-i .bfix svg{width:80%}
 .mi-l{font-weight:800;font-size:13.5px;line-height:1.25;min-height:2.5em;display:flex;align-items:flex-start;justify-content:center;color:#8f1456;letter-spacing:.005em;word-break:keep-all}
 .m-sep span,.m-orn span{position:absolute;left:50%;top:50%;width:9px;height:9px;transform:translate(-50%,-50%) rotate(45deg);background:#a3185f;border:2px solid #f6e6c8;box-shadow:0 0 0 1px #c9a56b}
 .m-h{margin:24px 16px 0;text-align:center;font-weight:800;font-size:25px;line-height:1.5;color:#8f1456;letter-spacing:.01em;text-shadow:0 1px 0 #fff,0 2px 6px rgba(201,165,107,.45)}
 .m-hen{text-align:center;font-family:'Mukta Malar',sans-serif;font-weight:700;font-size:13px;line-height:1.2;color:#8f1456;letter-spacing:.04em;margin:-4px 0 4px}
 .m-orn{position:relative;margin:6px auto 20px;width:170px;height:1px;background:linear-gradient(90deg,transparent,#c9a56b 20%,#c9a56b 80%,transparent)}
 /* மொபைல்: 7 வரிசை x 2 = 14 கார்டுகள் (ஒரு வரிசையில் 2 கார்டு) */
 .m-cards{display:grid;grid-template-columns:1fr 1fr;gap:18px 14px;max-width:520px;margin:0 auto;padding:0 14px 26px}
 .nc{filter:drop-shadow(0 8px 12px rgba(110,13,63,.22))}
 .nc::after{content:"";position:absolute;inset:0;border-radius:14px;border:1.5px solid rgba(201,165,107,.75);pointer-events:none}
 .nc-a,.nc-f,.nc-b{filter:saturate(1.2) brightness(1.04) contrast(1.05)}
 /* பரிசு வகைகள் — கிராண்டு லுக் */
 .m3{background:linear-gradient(#f8f0d9,#fbf5e4);padding:14px 14px 34px;font-family:'Baloo Thambi 2','Mukta Malar',sans-serif}
 .m-box{position:relative;max-width:520px;margin:0 auto;padding:6px 14px 26px;border:2px solid #c9a56b;border-radius:26px;background:linear-gradient(#fffbf1,#fdf6e3);box-shadow:0 12px 26px rgba(110,13,63,.18),inset 0 0 0 5px #fffaf0,inset 0 0 0 6.5px #e6cf9a}
 .m-box::before{display:none}
 .m-box{background:radial-gradient(circle at 1px 1px,rgba(201,165,107,.28) 1px,transparent 1.6px) 0 0/15px 15px,radial-gradient(ellipse at 50% 0,rgba(255,255,255,.9),transparent 60%),linear-gradient(#fffbf1,#fdf3da)}
 .fsym{position:absolute;width:0;height:0;overflow:hidden}
 .fc{position:absolute;width:66px;height:66px;pointer-events:none;overflow:visible;z-index:2;filter:drop-shadow(0 2px 3px rgba(110,13,63,.25))}
 .fc.tl{top:-13px;left:-13px}.fc.tr{top:-13px;right:-13px;transform:scaleX(-1)}.fc.bl{bottom:-13px;left:-13px;transform:scaleY(-1)}.fc.br{bottom:-13px;right:-13px;transform:scale(-1,-1)}
 .m-top{position:absolute;top:-21px;left:50%;width:150px;height:42px;transform:translateX(-50%);pointer-events:none;z-index:3;filter:drop-shadow(0 2px 3px rgba(110,13,63,.25))}
 .m-fdiv{display:block;width:210px;height:26px;margin:2px auto 14px}
 .mg{position:relative}
 .mg::before{content:"";position:absolute;top:-5px;left:50%;width:9px;height:9px;transform:translateX(-50%) rotate(45deg);background:#a3185f;border:1.5px solid #f6e6c8;box-shadow:0 0 0 1px #c9a56b}
 .mg::after{content:"";position:absolute;inset:0;border-radius:18px;background:radial-gradient(circle at 100% 100%,rgba(201,165,107,.22),transparent 45%),radial-gradient(circle at 0 100%,rgba(163,24,95,.08),transparent 45%);pointer-events:none}
 .m-box .m-h{margin-top:24px;font-size:27px}
 .m-art{width:calc(100% - 10px);aspect-ratio:294/190;border-radius:14px;border:2px solid #d6b878;background:url(assets/img/s3.jpg) no-repeat;background-size:calc(100% * 1024/294) auto;background-position:8.493% 66.667%;margin:6px auto 26px;filter:saturate(1.2) brightness(1.04) contrast(1.04);box-shadow:0 0 0 4px #fffaf0,0 0 0 5.5px #d6b878,0 10px 20px rgba(110,13,63,.22)}
 /* 4 பரிசு ஐகான்கள் — 2 x 2 */
 .m-gifts{display:grid;grid-template-columns:repeat(2,1fr);gap:16px 12px;padding:0 6px}
 .mg{--is:min(22vw,88px);padding:14px 3px 10px;gap:9px;background:linear-gradient(#fffdf6,#fbf1d8);border:1.5px solid #dcbf82;border-radius:18px;box-shadow:0 6px 12px rgba(110,13,63,.15),inset 0 0 0 3px #fffaf0}
 .mg-i{background-image:url(assets/img/s3.jpg);background-position:calc(var(--is)*var(--ox)*-1) calc(var(--is)*-0.9792);clip-path:circle(50%)}
 .mg .mi-l{display:block;font-size:13px;font-weight:800;white-space:normal;min-height:0;text-align:center}
 .mi-l .en{display:block;margin-top:2px;font-family:'Mukta Malar',sans-serif;font-weight:700;font-size:10.5px;line-height:1.2;color:#8f1456;opacity:.88}
 .m3 .m-more{display:grid;place-items:center;width:64%;max-width:260px;height:44px;margin:24px auto 0;border-radius:99px;color:#fff;font-weight:800;font-size:15px;white-space:nowrap;background:linear-gradient(#b21d68,#6a0d3f);border:1px solid #e3c27a;box-shadow:0 4px 10px rgba(110,13,63,.4),inset 0 1px 0 rgba(255,255,255,.25)}
 .m3 .m-more:active{transform:scale(.97)}
}
</style>
</head><body>
<?=an_navbar('index')?>
<main class="pg">

<section class="sx s1"><?php $o=70;$H=352;
echo T(290,109,$o,$H,'gold g1','ஏதேன்'),T(300,184,$o,$H,'gold g2','அழைப்பிதழ்'),T(298,263,$o,$H,'ath','A-T-H-E-N'),T(298,292,$o,$H,'inv','INVITATION'),T(298,344,$o,$H,'exc','Exclusive Christian Invitation');
// அழைப்பிதழ் ஸ்லைடு நீக்கப்பட்டது; அதற்கு பதிலாக பெரிய லோகோ + 2 வரி தமிழ் வாசகம்
echo hl_logo();
?></section>

<?php /* ===== மொபைல் பேனர்: எழுத்துகள் + பெரிய லோகோ + 2 வரி வாசகம் (760px-க்குக் கீழே மட்டும்) ===== */ ?>
<section class="mh" aria-label="ஏதேன் அழைப்பிதழ்">
 <h1><span class="mh-g1">ஏதேன்</span><span class="mh-g2">அழைப்பிதழ்</span></h1>
 <div class="mh-ath">A-T-H-E-N</div><div class="mh-inv">INVITATION</div>
 <div class="mh-orn" aria-hidden="true"><i></i></div>
 <p class="mh-exc">Exclusive Christian Invitation</p>
 <?=hl_logo('hl-m')?>
</section>

<?php /* ===== டெஸ்க்டாப்: 14 கார்டுகள் (மேலே அலங்காரப் பட்டை + 5 + 5 + 4) ===== */ ?>
<section class="dc" aria-label="அழைப்பிதழ் வகைகள்">
 <div class="dc-top"></div>
 <div class="dc-row"><?php $rem=count($cards)%5;foreach($cards as $i=>$c){$h=nc_card($c);if($rem&&$i===count($cards)-$rem)$h=str_replace('style="--ox:','style="grid-column:'.(1+(5-$rem)).' / span 2;--ox:',$h);echo $h;} ?></div>
</section>

<section class="sx s3"><?php $o=1040;$H=238;
echo '<span class="gband"></span>';
// பகுதியின் நடுவில் (x=665): தலைப்பு + English + கோடு + 4 ஐகான்கள்
echo T(665,1093,$o,$H,'h2','பரிசு வகைகள்'),T(665,1118,$o,$H,'gen','(Gifted Items)'),'<span class="gdiv" style="'.P(665,1133,$o,$H).'"><i></i></span>';
foreach($gifts as $g){
 echo '<span class="gi" style="'.P($g[0],1182,$o,$H).';background-position:'.round(-($g[1]-48)/10.24,3).'cqw -9.18cqw"></span>';
 echo A($g[0],1182,$o,$H,'md','products.php#bags',$g[2]),T($g[0],1246,$o,$H,'lab',$g[2].'<small class="en">('.$g[3].')</small>','products.php#bags');
} ?></section>

<?php /* ===== மொபைல்: அதே டிசைன் படங்களின் துண்டுகளால் இடைவெளியுடன் அமைப்பு (760px-க்குக் கீழே மட்டும்) ===== */ ?>
<section class="m2">
 <?php /* மொபைல்: ரவுண்ட் ஐகான் பேனல் + "எங்கள் அழைப்பிதழ்கள்" தலைப்பு நீக்கப்பட்டது */ ?>
 <div class="m-orn"><span></span></div>
 <div class="m-cards"><?php foreach($cards as $c)echo nc_card($c); ?></div>
</section>
<section class="m3">
<svg class="fsym" aria-hidden="true" focusable="false"><defs>
 <g id="fw"><g fill="#c2307a"><ellipse cx="0" cy="-9" rx="5.2" ry="9"/><ellipse cx="0" cy="-9" rx="5.2" ry="9" transform="rotate(72)"/><ellipse cx="0" cy="-9" rx="5.2" ry="9" transform="rotate(144)"/><ellipse cx="0" cy="-9" rx="5.2" ry="9" transform="rotate(216)"/><ellipse cx="0" cy="-9" rx="5.2" ry="9" transform="rotate(288)"/></g><g fill="#ee86b4"><ellipse cx="0" cy="-7.5" rx="2.8" ry="6" /><ellipse cx="0" cy="-7.5" rx="2.8" ry="6" transform="rotate(72)"/><ellipse cx="0" cy="-7.5" rx="2.8" ry="6" transform="rotate(144)"/><ellipse cx="0" cy="-7.5" rx="2.8" ry="6" transform="rotate(216)"/><ellipse cx="0" cy="-7.5" rx="2.8" ry="6" transform="rotate(288)"/></g><circle r="4.2" fill="#e8b84a" stroke="#b98d3e" stroke-width=".8"/><circle r="1.6" fill="#fff3c4"/></g>
 <g id="fl"><path d="M0 0C7-7 18-7 25 0C18 7 7 7 0 0Z" fill="#5f8a35"/><path d="M2 0H22" stroke="#9cc05a" stroke-width="1" fill="none"/></g>
 <g id="fcorner"><path d="M4 70C6 40 30 14 70 6" fill="none" stroke="#c9a56b" stroke-width="2" stroke-linecap="round"/><use href="#fl" transform="translate(30 34) rotate(35) scale(1.1)"/><use href="#fl" transform="translate(44 22) rotate(-10) scale(.95)"/><use href="#fl" transform="translate(20 52) rotate(75) scale(.95)"/><use href="#fl" transform="translate(10 66) rotate(100) scale(.7)"/><use href="#fl" transform="translate(66 10) rotate(-40) scale(.7)"/><use href="#fw" transform="translate(27 27) scale(1.35)"/><use href="#fw" transform="translate(58 12) scale(.8)"/><use href="#fw" transform="translate(12 58) scale(.8)"/><circle cx="44" cy="40" r="2.6" fill="#e8b84a"/><circle cx="36" cy="50" r="2" fill="#e8b84a"/><circle cx="50" cy="30" r="2" fill="#e8b84a"/></g>
</defs></svg>
 <div class="m-box">
  <svg class="m-top" viewBox="0 0 150 42" aria-hidden="true"><path d="M8 24Q40 36 75 24T142 24" fill="none" stroke="#c9a56b" stroke-width="1.6" stroke-linecap="round"/><use href="#fl" transform="translate(44 24) rotate(-160) scale(.9)"/><use href="#fl" transform="translate(106 24) rotate(-20) scale(.9)"/><use href="#fl" transform="translate(52 28) rotate(160) scale(.65)"/><use href="#fl" transform="translate(98 28) rotate(20) scale(.65)"/><use href="#fw" transform="translate(40 24) scale(.8)"/><use href="#fw" transform="translate(110 24) scale(.8)"/><use href="#fw" transform="translate(75 20) scale(1.25)"/><circle cx="22" cy="27" r="2" fill="#e8b84a"/><circle cx="128" cy="27" r="2" fill="#e8b84a"/></svg><svg class="fc tl" viewBox="0 0 80 80" aria-hidden="true"><use href="#fcorner"/></svg><svg class="fc tr" viewBox="0 0 80 80" aria-hidden="true"><use href="#fcorner"/></svg><svg class="fc bl" viewBox="0 0 80 80" aria-hidden="true"><use href="#fcorner"/></svg><svg class="fc br" viewBox="0 0 80 80" aria-hidden="true"><use href="#fcorner"/></svg>
  <h2 class="m-h">பரிசு வகைகள்</h2><div class="m-hen">(Gifted Items)</div><svg class="m-fdiv" viewBox="0 0 210 26" aria-hidden="true"><path d="M6 13H84M126 13H204" stroke="#c9a56b" stroke-width="1.5" stroke-linecap="round"/><use href="#fl" transform="translate(86 13) rotate(180) scale(.55)"/><use href="#fl" transform="translate(124 13) scale(.55)"/><use href="#fw" transform="translate(105 13) scale(.9)"/><use href="#fw" transform="translate(70 13) scale(.45)"/><use href="#fw" transform="translate(140 13) scale(.45)"/><circle cx="14" cy="13" r="2.2" fill="#a3185f"/><circle cx="196" cy="13" r="2.2" fill="#a3185f"/></svg>
  <div class="m-art"></div>
  <div class="m-gifts"><?php foreach($gifts as $g): ?>
   <a class="mg" href="products.php#bags"><span class="mi-w"><span class="mg-i" style="--ox:<?=round(($g[1]-48)/96,4)?>"></span></span><span class="mi-l"><?=$g[2]?><span class="en">(<?=$g[3]?>)</span></span></a>
  <?php endforeach; ?></div>
  <a class="m-more" href="products.php#bags">மேலும் காண்க &nbsp;→</a>
 </div>
</section>

<section class="sx s4"><?php $o=1278;$H=124;
echo T(512,1302,$o,$H,'b1','உங்கள் இனிய விழாக்களுக்கு'),T(512,1327,$o,$H,'b2','அழகிய அழைப்பிதழ்கள்...'),T(508,1380,$o,$H,'b3','அன்புடன் வடிவமைத்து வழங்குகிறோம்...'); ?></section>

<?php /* ===== ஃபுட்டர் (டெஸ்க்டாப் + டேப்ளெட் + மொபைல் — ஒரே ஃபுட்டர்) =====
 லோகோ மட்டும் கிளிக் செய்தால் admin/index.php-க்கு செல்லும் | முகவரி + போன் எண் | WhatsApp ஐகான் மட்டும் -> 9677479227 */
$ftTel='9677479227';$ftTelShow='+91 96774 79227'; ?>
<footer class="ft" id="siteFooter">
 <i class="ft-c l" aria-hidden="true"></i><i class="ft-c r" aria-hidden="true"></i>
 <div class="ft-in">
  <div class="ft-col ft-brand">
   <a class="ft-logo" href="admin/index.php" title="Admin Login" aria-label="Admin Login"></a>
   <div class="ft-bt"><b class="ft-n1">ஏதேன்</b><b class="ft-n1">அழைப்பிதழ்</b><span class="ft-n2">A-T-H-E-N INVITATION</span></div>
  </div>
  <div class="ft-col ft-contact">
   <address class="ft-addr"><span class="ft-ta">26/1, ஸ்ரீனிவாசகம் வளாகம்,<br>பாளையங்கோட்டை, திருநெல்வேலி.</span><span class="ft-en">26/1, Srinivasagam Complex,<br>Palayamkottai, Tirunelveli.</span></address>
   <a class="ft-tel" href="tel:+91<?=$ftTel?>"><?=$ftTelShow?></a>
  </div>
  <div class="ft-col ft-social">
   <div class="ft-faith">Faith &nbsp;•&nbsp; Family &nbsp;•&nbsp; Celebration</div>
   <div class="ft-div" aria-hidden="true"><i></i><em></em><i></i></div>
   <a class="ft-wa" href="https://wa.me/91<?=$ftTel?>" target="_blank" rel="noopener" title="WhatsApp" aria-label="WhatsApp"><svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="24" r="22.6" fill="#25D366" stroke="#fff" stroke-width="1.6"/><g transform="translate(9.6 9.6) scale(1.2)"><path fill="#fff" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></g></svg></a>
  </div>
 </div>
</footer>
</main>

</body></html>