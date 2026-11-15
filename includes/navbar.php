<?php
// ONE shared navbar for: தயாரிப்புகள் (products.php), எங்களைப் பற்றி (about.php), தொடர்புக்கு (contact.php)
// மூன்று நிறங்கள் சம அளவில்: மெரூன் #89194E · தங்கம் #AC8456 · கிரீம் #FCF5E4
// பயன்பாடு: echo an_navbar('products'|'about'|'contact');  — மாற்ற வேண்டுமானால் இந்த ஒரு ஃபைலில் மட்டும் மாற்றினால் போதும்
function an_navbar($active){
  $items=[['index','முகப்பு','index.php','Home'],['products','தயாரிப்புகள்','products.php','Products'],['about','எங்களைப் பற்றி','about.php','About'],['contact','தொடர்புக்கு','contact.php','Contact']];
  $menu='';
  foreach($items as $i){ $menu.='<a class="an-link'.($i[0]===$active?' on" aria-current="page':'').'" href="'.$i[2].'"><span class="an-ta">'.$i[1].'</span><small class="an-en">('.$i[3].')</small></a>'."\n";

      if($i[0]==='products') $menu.='<a class="an-link an-subl" href="products.php?v=cards"><span class="an-ta">அழைப்பிதழ்கள்</span><small class="an-en">(Invitation)</small></a>'."\n".'<a class="an-link an-subl" href="products.php?v=gifts"><span class="an-ta">பரிசுகள்</span><small class="an-en">(Gift)</small></a>'."\n"; }
  return <<<HTML
<style>
/* ===== பொதுவான நாவ்பார் — கிராண்ட் பாரம்பரிய வடிவமைப்பு (3 பக்கங்களுக்கும் ஒன்றே) ===== */
html:has(.an-nav),html:has(.an-nav) body{overflow-x:clip!important}
.an-nav{position:sticky;top:0;z-index:9999;width:100%;
  background:
   radial-gradient(ellipse 50% 160% at 50% -40%,rgba(172,132,86,.22),transparent 70%),
   linear-gradient(180deg,#FFFBF3,#F8ECD3);
  border-bottom:3px solid #AC8456;
  box-shadow:inset 0 5px 0 #89194E,inset 0 7px 0 #D8B787,0 8px 26px rgba(96,6,36,.26);
  font-family:'Baloo Thambi 2','Mukta Malar','Noto Sans Tamil','Latha',sans-serif}
.an-nav *{box-sizing:border-box}
.an-nav::after{content:"";position:absolute;left:0;right:0;bottom:-8px;height:4px;background:linear-gradient(90deg,#89194E,#D8B787 25%,#AC8456 50%,#D8B787 75%,#89194E)}
.an-nav::before{content:"";position:absolute;left:50%;bottom:-15px;width:14px;height:14px;transform:translateX(-50%) rotate(45deg);z-index:3;background:linear-gradient(135deg,#a3185f,#600624);border:2px solid #FCF5E4;box-shadow:0 0 0 2px #AC8456}
.an-in{max-width:1280px;margin:0 auto;padding:14px 28px 12px;display:flex;align-items:center;justify-content:space-between;gap:20px;position:relative}
.an-brand{display:flex;align-items:center;gap:15px;text-decoration:none;color:#89194E}
/* லோகோ படம் (logo.jpeg) */
.an-crest{position:relative;display:grid;place-items:center;flex:none;width:60px;height:60px;border-radius:50%;background:url('assets/img/logo.jpeg') center/cover no-repeat;color:transparent;font-size:0;line-height:1;box-shadow:inset 0 0 0 2px rgba(252,245,228,.35),0 0 0 3px #FEF8F1,0 0 0 5px #AC8456,0 0 0 8px rgba(216,183,135,.35),0 8px 16px rgba(96,6,36,.35)}
.an-crest::after{content:"";position:absolute;inset:6px;border-radius:50%;border:1.5px dashed rgba(246,226,168,.65);pointer-events:none}
.an-name{display:flex;flex-direction:column;line-height:1.05}
.an-name b{font-weight:800;font-size:27px;color:#89194E;text-shadow:0 1px 0 #FFF}.an-name b+b{color:#4d0620;font-size:23px}
.an-tag{display:flex;align-items:center;gap:7px;margin-top:4px;font:600 8.5px/1 'Times New Roman',Georgia,serif;letter-spacing:.24em;color:#8a6538;white-space:nowrap}
.an-tag::before{content:"";width:22px;height:1.5px;background:linear-gradient(90deg,transparent,#AC8456)}
.an-nav .an-menu{flex-wrap:nowrap;flex:0 1 auto;min-width:0}
.an-menu{display:flex;align-items:center;gap:16px;padding:5px 10px;border-radius:50px;background:rgba(252,245,228,.75);border:1.5px solid #D8B787;box-shadow:inset 0 0 0 3px rgba(255,251,243,.9),0 3px 10px rgba(96,6,36,.12)}
.an-nav .an-link{position:relative;padding:8px 20px;border-radius:50px;text-decoration:none;font-weight:700;font-size:19px;line-height:1.35;color:#4a0c2b;white-space:nowrap;border:1.5px solid transparent;background:transparent;transition:color .25s}
.an-nav .an-link+.an-link::before{content:"";position:absolute;left:-10px;top:50%;width:5px;height:5px;margin-top:-2.5px;transform:rotate(45deg);background:#AC8456}
.an-nav .an-link.on::before,.an-nav .an-link.on+.an-link::before{display:none}
.an-link::after{content:"";position:absolute;left:20px;right:20px;bottom:3px;height:2px;border-radius:2px;background:linear-gradient(90deg,transparent,#AC8456,#D8B787,#AC8456,transparent);transform:scaleX(0);transition:transform .3s}
.an-nav .an-link:not(.on):hover{color:#89194E;background:transparent}.an-link:hover::after{transform:scaleX(1)}
.an-nav .an-link.on{color:#FCF5E4;background:linear-gradient(#a3185f,#6e0d43);border:1.5px solid #D8B787;box-shadow:0 0 0 3px rgba(172,132,86,.32),0 6px 14px rgba(110,13,67,.4),inset 0 1px 0 rgba(255,255,255,.3)}
.an-link.on::after{display:none}
.an-burger{display:none;flex:none;width:48px;height:48px;border-radius:14px;border:1.5px solid #AC8456;background:linear-gradient(#FFFBF3,#F3E4C6);box-shadow:0 0 0 3px rgba(172,132,86,.2);cursor:pointer;padding:0;flex-direction:column;align-items:center;justify-content:center;gap:5px}
.an-burger i{display:block;width:22px;height:2.5px;border-radius:2px;background:#89194E;transition:transform .3s,opacity .2s}
.an-burger[aria-expanded="true"] i:nth-child(1){transform:translateY(7.5px) rotate(45deg)}
.an-burger[aria-expanded="true"] i:nth-child(2){opacity:0}
.an-burger[aria-expanded="true"] i:nth-child(3){transform:translateY(-7.5px) rotate(-45deg)}
.an-link{display:flex;flex-direction:column;align-items:center;justify-content:center}
.an-link .an-ta{display:block;line-height:1.25}
.an-link .an-en{display:block;margin-top:1px;font:600 10.5px/1 'Poppins','Segoe UI',Arial,sans-serif;letter-spacing:.06em;color:#8a6538;text-transform:none}
.an-nav .an-link.on .an-en{color:#F6E2A8}
.an-nav .an-link{padding:6px 20px}
.an-subl{display:none!important}
.an-pd{position:fixed;z-index:10000;display:none;min-width:230px;padding:8px;background:#FEF8F1;border:1px solid #F0DFC5;border-top:3px solid #AC8456;border-radius:14px;box-shadow:0 18px 40px rgba(59,18,36,.28);font-family:'Baloo Thambi 2','Mukta Malar','Noto Sans Tamil','Latha',sans-serif}
.an-pd.on{display:block}
.an-pd a{display:flex;flex-direction:column;gap:2px;padding:10px 16px;border-radius:9px;color:#3b1224;font-size:16px;font-weight:700;text-decoration:none;line-height:1.25;transition:.2s}
.an-pd a small{font:600 10.5px/1 'Poppins','Segoe UI',Arial,sans-serif;letter-spacing:.06em;color:#8a6538}
.an-pd a:hover{background:#89194E;color:#fff}.an-pd a:hover small{color:#F6E2A8}
@media(max-width:1180px){.an-in{padding-left:18px;padding-right:18px;gap:12px}.an-menu{gap:6px;padding:5px 8px}.an-nav .an-link{padding:8px 13px;font-size:17px}.an-nav .an-link+.an-link::before{left:-5px}.an-name b{font-size:24px}.an-name b+b{font-size:20px}}
@media(max-width:1000px){
 .an-in{padding:12px 16px 10px}.an-burger{display:flex}
 .an-crest{width:50px;height:50px}.an-name b{font-size:23px}.an-name b+b{font-size:19px}.an-brand{gap:12px}.an-tag{font-size:7.5px;letter-spacing:.2em}
 .an-menu{position:absolute;left:0;right:0;top:100%;display:none;flex-wrap:nowrap;max-height:calc(100vh - 80px);overflow-y:auto;flex-direction:column;align-items:stretch;gap:6px;padding:14px 16px 18px;border-radius:0;border:0;border-bottom:3px solid #AC8456;background:linear-gradient(180deg,#FFFBF3,#F8ECD3);box-shadow:0 18px 30px rgba(96,6,36,.28)}
 .an-menu.open{display:flex}
 .an-subl{display:flex!important;margin-left:22px;padding:8px 14px!important;border-left:3px solid #D8B787!important;border-radius:0 12px 12px 0!important}
 .an-pd{display:none!important}
 .an-nav .an-link{text-align:center;padding:12px 18px;border-color:rgba(172,132,86,.35);background:rgba(252,245,228,.7)}
 .an-nav .an-link.on{border-color:#D8B787;background:linear-gradient(#a3185f,#6e0d43)}
 .an-nav .an-link+.an-link::before{display:none}.an-link::after{left:30%;right:30%}
}
@media(max-width:420px){.an-tag{display:none}}
</style>
<header class="an-nav"><div class="an-in">
<a class="an-brand" href="index.php" aria-label="ஏதேன் அழைப்பிதழ் - முகப்பு"><span class="an-crest" aria-hidden="true">✝</span><span class="an-name"><b>ஏதேன்</b><b>அழைப்பிதழ்</b><small class="an-tag">EXCLUSIVE CHRISTIAN INVITATION</small></span></a>
<button class="an-burger" type="button" aria-label="மெனு" aria-expanded="false" aria-controls="anMenu"><i></i><i></i><i></i></button>
<nav class="an-menu" id="anMenu" aria-label="முதன்மை மெனு">
{$menu}</nav></div></header>
<script>(function(){var b=document.querySelector('.an-burger'),m=document.getElementById('anMenu');b.addEventListener('click',function(){var o=m.classList.toggle('open');b.setAttribute('aria-expanded',o?'true':'false')});
var pl=m.querySelector('a[href="products.php"]');if(pl){var d=document.createElement('div');d.className='an-pd';d.innerHTML='<a href="products.php?v=cards"><span>அழைப்பிதழ்கள்</span><small>(Invitation)</small></a><a href="products.php?v=gifts"><span>பரிசுகள்</span><small>(Gift)</small></a>';document.body.appendChild(d);var t;
function open(){var r=pl.getBoundingClientRect(),w=d.offsetWidth||230;d.style.top=(r.bottom+6)+'px';d.style.left=Math.max(8,Math.min(innerWidth-w-8,r.left+r.width/2-w/2))+'px';d.classList.add('on')}
function shut(){d.classList.remove('on')}
function big(){return innerWidth>1000}
pl.addEventListener('mouseenter',function(){if(big()){clearTimeout(t);open()}});
pl.addEventListener('mouseleave',function(){t=setTimeout(shut,250)});
d.addEventListener('mouseenter',function(){clearTimeout(t)});d.addEventListener('mouseleave',function(){t=setTimeout(shut,250)});
pl.addEventListener('click',function(e){if(big()){e.preventDefault();d.classList.contains('on')?shut():open()}});
document.addEventListener('click',function(e){if(!e.target.closest('.an-pd')&&e.target!==pl&&!pl.contains(e.target))shut()});
addEventListener('scroll',shut,{passive:true});addEventListener('resize',shut);document.addEventListener('keydown',function(e){if(e.key==='Escape')shut()})}})();</script>
HTML;
}