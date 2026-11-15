<?php
// Shared navigation bar - ONE source for every user page (index, products, about, contact, invitation, gift).
// x,y are pixel coordinates of the 1024px-wide design; $o = section top, $H = section height.
if(!function_exists('P')){function P($x,$y,$o,$H){return 'left:'.round($x/10.24,3).'%;top:'.round(($y-$o)/$H*100,3).'%';}}
if(!function_exists('T')){function T($x,$y,$o,$H,$cls,$html,$href=''){$s=P($x,$y,$o,$H);return $href?'<a class="t '.$cls.'" style="'.$s.'" href="'.$href.'">'.$html.'</a>':'<span class="t '.$cls.'" style="'.$s.'">'.$html.'</span>';}}

// logo text + 4 Tamil menu links (the active page is shown as the maroon pill)
// லேப்டாப்: 4 மெனுவும் ஒரே வரிசையில், சமமான இடைவெளியுடன் (flex) — ஒட்டாது
// மொபைல்: பொத்தானை அழுத்தினால் மெனு கார்டு திறக்கும்
function nav_items($page,$o,$H){
  $items=[['index','முகப்பு','index.php','Home'],['products','தயாரிப்புகள்','products.php','Products'],['about','எங்களைப் பற்றி','about.php','About'],['contact','தொடர்புக்கு','contact.php','Contact']];
  $out=T(204,22,$o,$H,'logo1','ஏதேன்','index.php').T(221,47,$o,$H,'logo2','அழைப்பிதழ்','index.php');
  $out.='<nav class="nvm" aria-label="முதன்மை மெனு" style="'.P(374,32,$o,$H).';width:55.5%;transform:translateY(-50%)">';
  foreach($items as $i){
    if($page===$i[0]) $out.='<a class="pill home" href="'.$i[2].'" aria-current="page"><span class="ta">'.$i[1].'</span><small class="en">('.$i[3].')</small></a>';
    else $out.='<a class="t nav" href="'.$i[2].'"><span class="ta">'.$i[1].'</span><small class="en">('.$i[3].')</small></a>';
  }
  $out.='</nav>';
  return $out.nav_dropdown().nav_mobile($items,$page);
}

// stand-alone bar for pages that do not have the big hero image
function nav_bar($page){return '<div class="nvw"><div class="sx nv">'.nav_items($page,0,69).'</div></div>';}

// மொபைல் மெனு பொத்தான் + கார்டு (body-ல் நேரடியாக சேர்க்கப்படும்; ஒரு பக்கத்தில் ஒருமுறை மட்டும்)
function nav_mobile($items,$page){static $done=false;if($done)return '';$done=true;
  $data=[];foreach($items as $i)$data[]=[$i[1],$i[2],$page===$i[0]?1:0,$i[3]];
  return '<script>window.NAVI='.json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).';</script>'.<<<'HTML'
<script>(function(){var I=window.NAVI||[];if(!I.length)return;
var b=document.createElement('button');b.type='button';b.className='mnb';b.setAttribute('aria-label','மெனு');b.setAttribute('aria-expanded','false');b.innerHTML='<i></i><i></i><i></i>';
var c=document.createElement('nav');c.className='mnc';c.setAttribute('aria-label','முதன்மை மெனு');
var h='';I.forEach(function(x){h+='<a class="mn-i'+(x[2]?' on':'')+'" href="'+x[1]+'">'+x[0]+' <small>('+x[3]+')</small></a>';
 if(x[1]==='products.php')h+='<a class="mn-i sub" href="products.php?v=cards">அழைப்பிதழ்கள் <small>(Invitation)</small></a><a class="mn-i sub" href="products.php?v=gifts">பரிசுகள் <small>(Gift)</small></a>'});
c.innerHTML=h;document.body.appendChild(b);document.body.appendChild(c);
function set(o){c.classList.toggle('on',o);b.setAttribute('aria-expanded',o?'true':'false')}
b.addEventListener('click',function(e){e.stopPropagation();set(!c.classList.contains('on'))});
document.addEventListener('click',function(e){if(!e.target.closest('.mnc'))set(false)});
document.addEventListener('keydown',function(e){if(e.key==='Escape')set(false)});
addEventListener('scroll',function(){set(false)},{passive:true});addEventListener('resize',function(){set(false)});
})();</script>
HTML;}

// "தயாரிப்புகள்" button -> small drop-down (அழைப்பிதழ்கள் / பரிசுகள்). Printed once per page.
// (இதே இடத்தில் மெனு எழுத்துக்களின் ஸ்டைலும் உள்ளது — எல்லாப் பக்கங்களுக்கும் பொருந்தும்)
function nav_dropdown(){static $done=false;if($done)return '';$done=true;return <<<'HTML'
<style>
/* ===== மெனு ஸ்டைல்: தமிழ் எழுத்துருவுடன், தங்க நிற அடிக்கோடு ===== */
.sx .t.nav,.nv .t.nav{font-family:'Baloo Thambi 2','Mukta Malar','Noto Sans Tamil','Latha',sans-serif;font-weight:700;font-size:clamp(13px,1.5cqw,22px);color:#4a0c2b;letter-spacing:.01em;line-height:1.2;padding:.35cqw .25cqw;transition:color .25s}
.sx .t.nav::after,.nv .t.nav::after{content:"";position:absolute;left:0;right:0;bottom:-.05cqw;height:2px;border-radius:2px;background:linear-gradient(90deg,transparent,#AC8456 20%,#D8B787 50%,#AC8456 80%,transparent);transform:scaleX(0);transition:transform .3s}
.sx .t.nav:hover,.nv .t.nav:hover{color:#89194E}
.sx .t.nav:hover::after,.nv .t.nav:hover::after{transform:scaleX(1)}
.sx .pill.home,.nv .pill.home{font-family:'Baloo Thambi 2','Mukta Malar','Noto Sans Tamil','Latha',sans-serif;font-weight:700;font-size:clamp(13px,1.5cqw,22px);letter-spacing:.01em;color:#FCF5E4;border:1.5px solid #D8B787;background:linear-gradient(#a3185f,#6e0d43);box-shadow:0 0 0 .22cqw rgba(172,132,86,.35),0 .3cqw .9cqw rgba(110,13,67,.45),inset 0 1px 0 rgba(255,255,255,.28)}
/* ===== தமிழ் தலைப்புக்குக் கீழே சிறிய ஆங்கிலம் ===== */
.sx .nvm .t.nav,.nv .nvm .t.nav,.sx .nvm .pill.home,.nv .nvm .pill.home{flex-direction:column;gap:.1cqw}
.nvm .ta{display:block;line-height:1.15}
.nvm .en{display:block;font:600 clamp(8px,.78cqw,11px)/1 'Poppins','Segoe UI',Arial,sans-serif;letter-spacing:.05em;color:#8a6538;opacity:.95}
.nvm .pill .en{color:#F6E2A8}
.mn-i small,.pdn a small{font:600 .68em 'Poppins','Segoe UI',Arial,sans-serif;letter-spacing:.04em;opacity:.8}
.pdn a b{font-weight:600;line-height:1.3}
.mn-i.on small{color:#F6E2A8;opacity:1}
/* ===== மெனு வரிசை: சமமான இடைவெளி ===== */
.nvm{position:absolute;z-index:6;display:flex;align-items:center;justify-content:space-between;gap:1.4cqw;white-space:nowrap}
.sx .nvm .t,.sx .nvm .pill,.nv .nvm .t,.nv .nvm .pill{position:relative!important;left:auto!important;top:auto!important;transform:none!important;width:auto!important;height:auto!important;margin:0!important;display:inline-flex;align-items:center;justify-content:center;white-space:nowrap;text-decoration:none}
.sx .nvm .t.nav,.nv .nvm .t.nav{padding:.7cqw 1.1cqw!important}
.sx .nvm .pill.home,.nv .nvm .pill.home{padding:.55cqw 2.4cqw!important;min-height:2.95cqw;border-radius:99px}
/* ===== மொபைல் மெனு பொத்தான் + கார்டு ===== */
.mnb,.mnc{display:none}
@media(max-width:760px){
 .nvm{display:none!important}
 .mnb{display:flex;position:fixed;top:10px;right:10px;z-index:9997;width:46px;height:46px;padding:0;border-radius:14px;border:1.5px solid #D8B787;background:linear-gradient(#a3185f,#6e0d43);box-shadow:0 0 0 3px rgba(172,132,86,.3),0 8px 18px rgba(60,6,35,.45);flex-direction:column;align-items:center;justify-content:center;gap:5px;cursor:pointer;-webkit-tap-highlight-color:transparent}
 .mnb i{display:block;width:21px;height:2.5px;border-radius:2px;background:#FCF5E4;transition:transform .3s,opacity .2s}
 .mnb[aria-expanded="true"] i:nth-child(1){transform:translateY(7.5px) rotate(45deg)}
 .mnb[aria-expanded="true"] i:nth-child(2){opacity:0}
 .mnb[aria-expanded="true"] i:nth-child(3){transform:translateY(-7.5px) rotate(-45deg)}
 .mnc{position:fixed;top:66px;right:10px;z-index:9998;width:min(270px,calc(100vw - 20px));flex-direction:column;gap:5px;padding:10px;background:#FEF8F1;border:1px solid #F0DFC5;border-top:3px solid #AC8456;border-radius:16px;box-shadow:0 18px 40px rgba(59,18,36,.32);font-family:'Baloo Thambi 2','Mukta Malar','Noto Sans Tamil','Latha',sans-serif}
 .mnc.on{display:flex}
 .mn-i{display:block;padding:12px 16px;border-radius:12px;color:#3b1224;font-size:17px;font-weight:700;line-height:1.35;text-decoration:none;transition:.2s}
 .mn-i:hover,.mn-i:active{background:#F0DFC5}
 .mn-i.on{color:#FCF5E4;background:linear-gradient(#a3185f,#6e0d43);box-shadow:0 4px 10px rgba(110,13,67,.35)}
 .mn-i.sub{margin-left:18px;padding:9px 14px;font-size:15px;font-weight:600;color:#6b5a24;border-left:2px solid #D8B787;border-radius:0 10px 10px 0}
}
/* ===== தயாரிப்புகள் drop-down ===== */
.pdn{position:fixed;z-index:9999;display:none;min-width:210px;padding:8px;background:#FEF8F1;border:1px solid #F0DFC5;border-top:3px solid #AC8456;border-radius:14px;box-shadow:0 18px 40px rgba(59,18,36,.28);font-family:'Noto Sans Tamil','Latha',sans-serif}
.pdn.on{display:block}.pdn a{display:flex;align-items:center;gap:10px;padding:11px 14px;border-radius:9px;color:#3b1224;font-size:15px;font-weight:600;text-decoration:none;transition:.2s}
.pdn a:hover{background:#89194E;color:#fff}.pdn a span{display:grid;place-items:center;width:32px;height:32px;border-radius:9px;background:#FCF5E4;color:#89194E;transition:.2s}.pdn a:hover span{background:rgba(255,255,255,.18);color:#fff}</style>
<script>(function(){var d=document.createElement('div');d.className='pdn';d.innerHTML='<a href="products.php?v=cards"><span><svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg></span><b>அழைப்பிதழ்கள் <small>(Invitation)</small></b></a><a href="products.php?v=gifts"><span><svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="8" width="18" height="4" rx="1"/><path d="M12 8v13M5 12v8h14v-8M12 8C10 8 7.5 7.5 7.5 5.5S10.5 3 12 8c1.5-5 4.5-4.5 4.5-2.5S14 8 12 8Z"/></svg></span><b>பரிசுகள் <small>(Gift)</small></b></a>';document.body.appendChild(d);
function shut(){d.classList.remove('on')}
document.addEventListener('click',function(e){var a=e.target.closest('a.pill[href="products.php"],a.t.nav[href="products.php"]');
 if(a){e.preventDefault();if(d.classList.contains('on')){shut();return}var r=a.getBoundingClientRect(),w=d.offsetWidth||210;d.style.top=(r.bottom+8)+'px';d.style.left=Math.max(8,Math.min(innerWidth-w-8,r.left+r.width/2-w/2))+'px';d.classList.add('on');return}
 if(!e.target.closest('.pdn'))shut()});
document.addEventListener('keydown',function(e){if(e.key==='Escape')shut()});addEventListener('scroll',shut,{passive:true});addEventListener('resize',shut)})();</script>
HTML;}