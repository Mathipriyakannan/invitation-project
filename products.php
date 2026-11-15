<?php $page='products'; include 'includes/header.php';
$sel=(string)($_GET['type']??'');if(!isset($types[$sel]))$sel='';
$v=($sel===''&&($_GET['v']??'')==='gifts')?'gifts':'cards';
$cnt=[];foreach($cards as $c)$cnt[$c['type']]=($cnt[$c['type']]??0)+1;
/* line icons (no emoji) */
function pk_i($k,$s=18){static $P=[
 'all'=>'<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>',
 'mail'=>'<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
 'gift'=>'<rect x="3" y="8" width="18" height="4" rx="1"/><path d="M12 8v13M5 12v8h14v-8M12 8C10 8 7.5 7.5 7.5 5.5S10.5 3 12 8c1.5-5 4.5-4.5 4.5-2.5S14 8 12 8Z"/>',
 'bag'=>'<path d="M5 8h14l1 12H4L5 8ZM9 8V6a3 3 0 0 1 6 0v2"/>',
 'birthday'=>'<path d="M4 21h16M5 21v-6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v6M12 13v-3M12 10c-1 0-1.6-.8-1.6-1.6S12 6.6 12 5c0 1.6 1.6 2.4 1.6 3.4S13 10 12 10ZM5 17c2 1.4 3 1.4 4.5 0s3-1.4 4.5 0 3 1.4 5 0"/>',
 'earpiercing'=>'<path d="M12 3l1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8L12 3ZM19 16l.8 2.2L22 19l-2.2.8L19 22l-.8-2.2L16 19l2.2-.8L19 16Z"/>',
 'housewarming'=>'<path d="M3 11l9-8 9 8M5 10v10h14V10M10 20v-6h4v6"/>',
 'wedding'=>'<circle cx="9" cy="15" r="5"/><circle cx="15" cy="15" r="5"/><path d="M8 6l1-3h2l1 3"/>',
 'babyshower'=>'<path d="M10 3h4v3h-4zM9 6h6l1 3v11a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1V9l1-3ZM8 12h8M8 16h8"/>',
 'opening'=>'<path d="M12 11C9 6 5 6 5 8.5S8.5 13 12 11Zm0 0c3-5 7-5 7-2.5S15.5 13 12 11ZM12 11l-3 9M12 11l3 9"/>',
 'welcome'=>'<circle cx="12" cy="12" r="9"/><path d="M8 14s1.5 2.5 4 2.5S16 14 16 14M9 9.5h.01M15 9.5h.01"/>',
 'thanks'=>'<path d="M12 21V11M12 11c0-3-2-5-5-5 0 3 2 5 5 5Zm0 0c0-3 2-5 5-5 0 3-2 5-5 5ZM8 21h8"/>',
 'personalized'=>'<path d="M4 20h4L19 9l-4-4L4 16v4Z"/><path d="m13 7 4 4"/>',
 'betrothal'=>'<circle cx="12" cy="15" r="5"/><path d="M8.5 8 12 3l3.5 5-3.5 2.5Z"/>',
 'baptism'=>'<path d="M12 3c-3 4-6 6.6-6 10a6 6 0 0 0 12 0c0-3.4-3-6-6-10Z"/>',
 'communion'=>'<path d="M12 3v18M6 9h12"/>',
 'puberty'=>'<path d="M12 11C9 6 5 6 5 8.5S8.5 13 12 11Zm0 0c3-5 7-5 7-2.5S15.5 13 12 11ZM12 11v9M8 20h8"/>',
 'scroll'=>'<path d="M7 4h11a2 2 0 0 1 2 2v1H9V6a2 2 0 0 0-2-2ZM7 4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-1H9V7"/>',
 'back'=>'<path d="M19 12H5M11 6l-6 6 6 6"/>',
 'bk'=>'<path d="M20 12H7.5"/><path d="M12.5 6.2 6.7 12l5.8 5.8"/><path d="M4.2 12 3 10.8 1.8 12 3 13.2Z" fill="currentColor" stroke-width="1"/>',
 'search'=>'<circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>',
 'prev'=>'<path d="m15 18-6-6 6-6"/>',
 'next'=>'<path d="m9 18 6-6-6-6"/>',
 'image'=>'<rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="1.8"/><path d="m21 16-5-5-9 9"/>'];
 return '<svg viewBox="0 0 24 24" width="'.$s.'" height="'.$s.'" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.($P[$k]??$P['image']).'</svg>';}
function pk_card($c,$kind){global $st,$types;$key=$kind.$c['id'];$n=(int)($st['likes'][$key]??0);
 $f=$kind==='b'?(string)$c['id']:$c['type'];$lab=$kind==='b'?'':($types[$c['type']][1]??'');
 /* text the search box looks in: name, ID, type (key + English + Tamil), bag details */
 $srch=mb_strtolower(trim(($c['name']??'').' '.($c['code']??'').' '.($kind==='b'?'gift bag பரிசுப் பை '.($c['desc']??''):($c['type'].' '.($types[$c['type']][0]??'').' '.($types[$c['type']][1]??'')))),'UTF-8');
 ob_start(); ?>
<article class="pk-c" data-f="<?=h($f)?>" data-s="<?=h($srch)?>" data-key="<?=$key?>" data-name="<?=h($c['name'])?>" data-code="<?=h($c['code']??'')?>" data-type="<?=h($kind==='b'?'':($c['type']??''))?>" data-lab="<?=h($lab)?>" data-desc="<?=h($kind==='b'?($c['desc']??''):'')?>" data-img1="<?=h($c['image']??'')?>" data-img2="<?=h($c['image2']??'')?>" data-imgs="<?=h(json_encode(array_values(array_filter([$c['image']??'',$c['image2']??''])),JSON_UNESCAPED_SLASHES))?>" data-pages="<?=h(json_encode(array_values(array_filter(array_merge([$c['image']??'',$c['image2']??''],array_column($c['extras']??[],'image')))),JSON_UNESCAPED_SLASHES))?>" data-bh="<?=h($c['heading']??'')?>" data-bs="<?=h($c['subtitle']??'')?>" data-bc="<?=h($c['content']??'')?>">
<div class="pk-img"><?php if(!empty($c['image'])): ?><img src="<?=h($c['image'])?>" alt="<?=h($c['name'])?>" loading="lazy"><?php else: ?><span class="pk-no"><?=pk_i($kind==='b'?'bag':($c['type']??'image'),44)?></span><?php endif; ?><?php if($lab): ?><span class="pk-tag"><?=h($lab)?></span><?php endif; ?></div>
<div class="pk-bd"><b class="pk-nm"><?=h($c['name'])?></b>
<div class="pk-row"><?php if(!empty($c['code'])): ?><span class="pk-id"><span class="pk-idl">ID : </span><?=h($c['code'])?></span><?php else: ?><span></span><?php endif; ?>
<div class="pk-act"><button class="pk-lk" type="button" data-key="<?=$key?>" title="லைக்" aria-label="லைக்"><span>♡</span><em><?=$n?></em></button><button class="pk-vw" type="button" title="பார்க்க" aria-label="பார்க்க"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1.5 12S5.5 5 12 5s10.5 7 10.5 7-4 7-10.5 7S1.5 12 1.5 12Z"/><circle cx="12" cy="12" r="3"/></svg></button><?=wa_btn($c,$kind)?></div></div><button class="pk-mr" type="button">மேலும் காண்க &nbsp;→</button></div></article>
<?php return ob_get_clean();}
function pk_btn($href,$ico,$label){return '<a class="pk-ab" href="'.$href.'">'.pk_i($ico,17).'<span class="tx">'.h($label).'</span></a>';}
/* மெனு பொத்தான் + dropdown */
function pk_mnu($curLabel,$menu){return '<div class="pk-mn"><button class="pk-mb" type="button" aria-haspopup="true"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg><span class="pk-cur">'.h($curLabel).'</span><svg class="pk-ch" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg></button><div class="pk-dd">'.$menu.'</div></div>';}
/* தேடல் வரி: [பின்செல் வில்லை] [தேடல் பெட்டி] [பின்செல்] [பரிசுகள்/அழைப்பிதழ்கள்] [மெனு] */
function pk_sr($hint,$rt=''){return '<div class="pk-sr"><button type="button" class="pk-bk" aria-label="அனைத்து அழைப்பிதழ்களையும் காண்க" title="அனைத்தும்">'.pk_i('bk',22).'</button><div class="pk-sb"><span class="pk-si">'.pk_i('search',19).'</span><input type="text" class="pk-q" placeholder="தேடுக…" autocomplete="off" aria-label="தேடுக"><button type="button" class="pk-qx" aria-label="அழி">✕</button></div><div class="pk-rt">'.$rt.'</div></div>';}
/* தலைப்பு: தேடல் வரிக்கு மேலே மட்டும் (மெரூன் பேனர் இல்லை) — அழைப்பிதழ்: "ஏதேன் அழைப்பிதழ்" · பரிசுகள்: "ஏதேன் பரிசுப் பைகள்" */
function pk_bar($ico,$title,$sub){ob_start(); ?>
<div class="pk-hd"><h2 class="pk-hn"><?=h($title)?></h2><span class="pk-rule" aria-hidden="true"><i></i></span></div>
<?php return ob_get_clean();} ?>
<style>
/* ===== View Book (book model: left page = content, right page = photo) ===== */
.fb{position:fixed;inset:0;z-index:95;display:none;flex-direction:column;background:radial-gradient(ellipse at 50% 40%,#5a0a30 0,#2c0517 70%,#1d030f 100%);color:#fff;font-family:'Noto Sans Tamil',sans-serif;overflow:hidden;-webkit-tap-highlight-color:transparent;user-select:none;-webkit-user-select:none}
.fb.on{display:flex}
.fb-top{flex:none;display:flex;align-items:center;justify-content:space-between;gap:12px;padding:12px clamp(14px,3vw,34px);border-bottom:1px solid rgba(243,217,149,.35)}
.fb-ttl{min-width:0;display:flex;align-items:center;gap:12px;flex-wrap:wrap}
.fb-ttl b{font:800 clamp(15px,2.4vw,20px)/1.3 'Noto Serif Tamil',serif;color:#F3D995;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:60vw}
.fb-ttl span{display:inline-flex;align-items:center;height:26px;padding:0 12px;border-radius:20px;border:1.5px dashed #E2B44F;color:#F3D995;font:700 12px 'Noto Sans Tamil',sans-serif;letter-spacing:.05em;white-space:nowrap}
.fb-ttl span:empty{display:none}
.fb-x{flex:none;width:40px;height:40px;border-radius:50%;border:2px solid #fff;background:#89194E;color:#fff;font-size:16px;cursor:pointer;padding:0}
.fb-x:hover{background:#a3185f}
.fb-stage{position:relative;flex:1 1 auto;min-height:0;display:flex;align-items:center;justify-content:center;padding:10px 0}
.fb-sl{transition:transform .9s cubic-bezier(.45,.05,.25,1);will-change:transform}
/* the book: cream cover frame, stacked page edges, spine, ribbon */
.fb-cv{position:relative;box-sizing:content-box;background:linear-gradient(180deg,#fbf0d8,#f3e3bf);border:2px solid #d6b878;border-radius:12px;box-shadow:0 2px 0 #eadba9,0 5px 0 #d9c28b,0 7px 0 #f1e4c0,0 9px 0 #cfb57c,0 26px 44px rgba(0,0,0,.55)}
.fb-bk{position:relative;perspective:2600px}
.fb-sp{position:absolute;z-index:1500;left:50%;top:0;bottom:0;width:4px;margin-left:-2px;background:linear-gradient(90deg,#b98349,#8a5a2b 50%,#b98349);box-shadow:0 0 12px 2px rgba(90,50,10,.28);pointer-events:none}
.fb-rb{position:absolute;z-index:1600;left:50%;top:-3px;width:20px;height:clamp(40px,9vh,70px);margin-left:-10px;background:linear-gradient(90deg,#a3185f,#7a0f45 55%,#8d1650);clip-path:polygon(0 0,100% 0,100% 100%,50% 84%,0 100%);filter:drop-shadow(0 3px 3px rgba(0,0,0,.35));pointer-events:none}
.fb-cv.one .fb-sp,.fb-cv.one .fb-rb{display:none}
/* a sheet = 2 faces (front + back); it turns around the spine (its left edge) */
.fb-sh{position:absolute;top:0;left:50%;width:50%;height:100%;transform-origin:left center;transform-style:preserve-3d;transition:transform .9s cubic-bezier(.45,.05,.25,1)}
.fb-sh.fl{transform:rotateY(-180deg)}
.fb-f,.fb-lb{box-sizing:border-box;overflow:hidden;background:#fdf6e6;border:1.5px solid #d9bd80}
.fb-f{position:absolute;inset:0;backface-visibility:hidden;-webkit-backface-visibility:hidden}
.fb-f.b{transform:rotateY(180deg)}
.fb-lb{position:absolute;left:0;top:0;width:50%;height:100%;border-radius:8px 0 0 8px}
.fb-f::after,.fb-lb::after{content:"";position:absolute;inset:0;pointer-events:none;background:linear-gradient(90deg,rgba(0,0,0,.30),rgba(0,0,0,.07) 5%,transparent 14%)}
.fb-f.b::after,.fb-lb::after{background:linear-gradient(270deg,rgba(0,0,0,.30),rgba(0,0,0,.07) 5%,transparent 14%)}
.fb-f:not(.b){border-radius:0 8px 8px 0}.fb-f.b{border-radius:8px 0 0 8px}
/* turning page: darkens toward the fold */
.fb-f::before{content:"";position:absolute;inset:0;z-index:3;pointer-events:none;opacity:0;background:linear-gradient(90deg,rgba(0,0,0,.04),rgba(0,0,0,.34))}
.fb-f.b::before{background:linear-gradient(270deg,rgba(0,0,0,.04),rgba(0,0,0,.34))}
.fb-sh.tn .fb-f::before{animation:fbcurl .9s ease-in-out}
@keyframes fbcurl{0%{opacity:0}45%{opacity:1}100%{opacity:0}}
.fb-sh.tn{filter:drop-shadow(-10px 0 16px rgba(0,0,0,.28))}
/* page contents */
.fb-pg{position:absolute;inset:0;container-type:inline-size;background:#fdf6e6}
.fb-pg img{display:block;width:100%;height:100%;object-fit:contain;pointer-events:none;-webkit-user-drag:none}
.fb-tx{background:linear-gradient(180deg,#fffaf0,#f8ecd6);overflow:hidden}
.fb-in{position:absolute;inset:0;box-sizing:border-box;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:9cqw 8cqw 12cqw}
.fb-tx small{display:block;margin:0 0 2.4cqw;color:#a3185f;font:800 clamp(10px,3.2cqw,14px)/1.3 'Noto Sans Tamil',sans-serif;letter-spacing:.14em}
.fb-dv{display:flex;align-items:center;gap:8px;width:46%;margin:1.6cqw auto 3cqw;flex:none}
.fb-dv::before,.fb-dv::after{content:"";flex:1;height:1.5px}.fb-dv::before{background:linear-gradient(90deg,transparent,#c9a56b)}.fb-dv::after{background:linear-gradient(90deg,#c9a56b,transparent)}
.fb-dv i{flex:none;width:8px;height:8px;transform:rotate(45deg);background:linear-gradient(135deg,#a3185f,#6b0b3e);box-shadow:0 0 0 1.5px #c9a56b}
.fb-tx h3{margin:0;width:100%;color:#89194E;font:800 clamp(18px,8cqw,38px)/1.3 'Noto Serif Tamil',serif}
.fb-tx h4{margin:2.4cqw 0 0;width:100%;color:#a3185f;font:800 clamp(14px,5cqw,22px)/1.5 'Noto Sans Tamil',sans-serif}
.fb-w{display:inline-block;white-space:nowrap}
.fb-l .fb-w,.fb-w.fb-l{display:block}
.fb-ct{margin:3.4cqw 0 0;width:100%;flex:0 1 auto;min-height:0;max-height:48%;overflow-y:auto;color:#3b1224;font:500 clamp(12px,4cqw,17px)/1.75 'Noto Sans Tamil',sans-serif;white-space:pre-line;overflow-wrap:break-word;word-break:normal;scrollbar-width:thin;scrollbar-color:#c9a56b transparent;user-select:text;-webkit-user-select:text}
.fb-pf{position:absolute;left:0;right:0;bottom:4cqw;text-align:center;font:700 clamp(9px,3cqw,13px) 'Noto Sans Tamil',sans-serif;font-style:normal;letter-spacing:.08em;color:#7a5a2a}
.fb-br{display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;gap:2.2cqw;background:radial-gradient(ellipse at 50% 30%,rgba(255,150,120,.18),transparent 70%),#52011F}
.fb-br i{font-style:normal;color:#F3D995;font-size:clamp(26px,12cqw,56px);line-height:1}
.fb-br b{color:#F3D995;font:800 clamp(18px,8cqw,34px)/1.35 'Noto Serif Tamil',serif}
.fb-br em{font:700 clamp(9px,3.4cqw,14px) 'Cinzel','Cormorant Garamond',Georgia,serif;font-style:normal;letter-spacing:.24em;color:#fbeed0}
.fb-br .fb-dv{width:40%;margin:1cqw auto}
/* arrows */
.fb-nv{position:absolute;top:50%;transform:translateY(-50%);z-index:5;display:grid;place-items:center;width:50px;height:50px;padding:0;border-radius:50%;border:2px solid #fff;background:linear-gradient(135deg,#a3185f,#6b0b3e);color:#fff;cursor:pointer;box-shadow:0 8px 18px rgba(0,0,0,.45);transition:.2s}
.fb-nv.prev{left:clamp(8px,2vw,28px)}.fb-nv.next{right:clamp(8px,2vw,28px)}
.fb-nv:hover{transform:translateY(-50%) scale(1.08);filter:brightness(1.15)}
.fb-nv[disabled]{opacity:.3;cursor:default;pointer-events:none}
/* dots + counter */
.fb-bot{flex:none;display:flex;align-items:center;justify-content:center;gap:14px;padding:8px 14px 14px;color:#F3D995;font:700 14px 'Noto Sans Tamil',sans-serif;letter-spacing:.04em}
.fb-dots{display:flex;align-items:center;gap:8px}
.fb-dots button{width:11px;height:11px;padding:0;border:0;border-radius:50%;background:rgba(243,217,149,.4);cursor:pointer;transition:.25s}
.fb-dots button.on{background:#F3D995;transform:scale(1.35)}
/* single-page mode (mobile): the turned page folds away to the left and is hidden */
.fb-sh.one{left:0;width:100%;transition:transform .8s cubic-bezier(.45,.05,.25,1),visibility 0s}
.fb-sh.one.fl{visibility:hidden;transition:transform .8s cubic-bezier(.45,.05,.25,1),visibility 0s linear .8s}
.fb-sh.one .fb-f{border-radius:8px}
.fb-sh.one .fb-f::after{background:linear-gradient(90deg,rgba(0,0,0,.24),transparent 8%)}
.fb-sh.one.tn{filter:none}
@media(max-width:820px){
 .fb-nv{width:42px;height:42px;top:auto;bottom:6px;transform:none}.fb-nv:hover{transform:scale(1.06)}
 .fb-nv.prev{left:14px}.fb-nv.next{right:14px}
 .fb-bot{flex-direction:column;gap:6px;padding:8px 66px 12px;min-height:44px}
 .fb-ttl b{max-width:52vw}
}
@media(prefers-reduced-motion:reduce){.fb-sh,.fb-sl{transition-duration:.01s!important}.fb-sh.tn .fb-f::before{animation:none}}
</style>
<style>
:root{--mr:#89194E;--mr-d:#600624;--gd:#AC8456;--gd-d:#8a6538;--cr:#FCF5E4;--cr-l:#FAF3DE;--iv:#FEF8F1;--bg2:#F0DFC5;--bl:#F8ECE5;--ink:#3b1224;--ol:#504D08}
html{scroll-behavior:smooth}
body{background:radial-gradient(circle at 100% 30%,rgba(80,77,8,.07),transparent 40%),radial-gradient(circle at 0 70%,rgba(80,77,8,.06),transparent 38%),linear-gradient(180deg,#FFFDF9,var(--iv) 45%,var(--cr-l))!important}
/* ---- design scale: 1 unit = 1px of the 1840px-wide mock ---- */
:root{--u:calc(min(100vw,1840px)/1840)}
body{background:linear-gradient(180deg,#fdf4e9 0,#f9eddb 330px,#f6e8d3 100%)!important}
/* ---- full-screen page shell: always full width + full height, footer sticks to the bottom ---- */
html{background:#f6e8d3;overflow-x:hidden}
body{margin:0!important;padding:0!important;overflow-x:hidden;min-height:100vh;min-height:100dvh}
.pk-page{position:relative;box-sizing:border-box;width:100vw;max-width:100vw;margin-left:calc(50% - 50vw);min-height:100vh;min-height:100dvh;display:flex;flex-direction:column;overflow-x:clip}
.pk-page .pk-wrap{flex:1 0 auto;width:100%}
.pk-page .pk-ft{flex:none;margin-top:auto;width:100%}
.pk-wrap{position:relative;isolation:isolate;max-width:1840px;margin:0 auto;padding:0 0 calc(var(--u)*44)}
.pk-sec{position:relative;z-index:2;margin:0}
/* decorative flowers / lantern / church (images only - everything else is live code) */
.dc{position:absolute;z-index:0;height:auto;pointer-events:none;user-select:none}
.dc.l1{left:0;top:calc(var(--u)*45);width:calc(var(--u)*175)}
.dc.l2{left:0;bottom:0;width:calc(var(--u)*175)}
.dc.r1{right:0;top:calc(var(--u)*38);width:calc(var(--u)*150)}
.dc.r2{right:0;bottom:0;width:calc(var(--u)*215)}
/* ---------- heading (search வரிக்கு மேலே) ---------- */
.pk-hd{position:relative;z-index:4;display:flex;flex-direction:column;align-items:center;text-align:center;padding:clamp(18px,calc(var(--u)*36),36px) 16px 0}
.pk-hd .pk-hn{margin:0;font:800 clamp(24px,calc(var(--u)*44),44px)/1.3 'Noto Serif Tamil',serif;color:#6b1236;text-shadow:0 1px 0 rgba(255,255,255,.6),0 2px 6px rgba(96,6,36,.14)}
.pk-hd .pk-rule{margin:8px auto 0}
@media(max-width:640px){.pk-hd{padding-top:18px}.pk-hd .pk-hn{font-size:clamp(20px,6vw,26px)}}
.pk-ttl{display:flex;align-items:center;min-width:0}
.pk-rule{display:flex;align-items:center;gap:8px;width:clamp(110px,calc(var(--u)*200),190px);margin:6px 0 5px}.pk-rule:before,.pk-rule:after{content:"";flex:1;height:1.5px}.pk-rule:before{background:linear-gradient(90deg,transparent,#c9a56b)}.pk-rule:after{background:linear-gradient(90deg,#c9a56b,transparent)}.pk-rule i{flex:none;width:7px;height:7px;transform:rotate(45deg);background:linear-gradient(135deg,#a3185f,#6b0b3e);box-shadow:0 0 0 1.5px #c9a56b}
/* ---------- back / switch buttons + menu ---------- */
.pk-rt{display:flex;align-items:center;gap:clamp(8px,calc(var(--u)*16),16px);flex:none}
.pk-ab,.pk-mb{display:inline-flex;align-items:center;gap:9px;padding:clamp(8px,calc(var(--u)*17),14px) clamp(12px,calc(var(--u)*24),22px);border-radius:12px;font:600 clamp(13px,calc(var(--u)*21),16px) 'Noto Sans Tamil',sans-serif;cursor:pointer;transition:.2s;white-space:nowrap}
.pk-ab{border:1.5px solid #d8bf94;background:#fffaf0;color:#6b1236;text-decoration:none;box-shadow:0 4px 10px rgba(96,6,36,.08)}
.pk-ab:hover{background:#89194E;border-color:#89194E;color:#fff;transform:translateY(-1px)}
.pk-mn{position:relative;flex:none}
.pk-mb{border:1.5px solid #89194E;background:linear-gradient(135deg,#9a1a5c,#6b0b3e);color:#fff;box-shadow:0 6px 14px rgba(96,6,36,.3)}
.pk-mb:hover,.pk-mn.open .pk-mb{background:#fff;color:#89194E;box-shadow:0 6px 14px rgba(96,6,36,.18)}
.pk-cur{max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.pk-ch{transition:transform .2s}.pk-mn.open .pk-ch{transform:rotate(180deg)}
.pk-dd{position:absolute;right:0;top:calc(100% + 10px);z-index:30;min-width:260px;max-width:86vw;max-height:min(70vh,440px);overflow:auto;padding:8px;background:var(--iv);border:1px solid var(--bg2);border-top:3px solid var(--mr);border-radius:14px;box-shadow:0 18px 40px rgba(59,18,36,.26);display:none}
.pk-mn.open .pk-dd{display:block}
.pk-dd button{display:flex;align-items:center;gap:12px;width:100%;padding:10px 12px;border:0;border-radius:9px;background:none;color:var(--ink);font:500 14.5px 'Noto Sans Tamil',sans-serif;text-align:left;cursor:pointer;transition:.15s}
.pk-dd button:hover{background:var(--bg2)}
.pk-dd button.on{background:var(--mr);color:#fff}
.pk-dd .e{flex:none;display:grid;place-items:center;width:30px;height:30px;border-radius:9px;background:var(--cr);color:var(--mr)}
.pk-dd button.on .e{background:rgba(255,255,255,.18);color:#fff}
.pk-dd .n{margin-left:auto;padding-left:8px;font-size:12px;opacity:.7}
/* ---------- search bar ---------- */
.pk-sr{position:relative;z-index:4;display:flex;justify-content:center;padding:0 16px;margin-top:calc(var(--u)*34)}
.pk-sr{align-items:center;gap:clamp(12px,calc(var(--u)*20),20px)}
.pk-sb{position:relative;width:min(640px,100%);min-width:0}
/* பின்செல் பொத்தான்: "மேலும் காண்க" அழுத்திய பிறகு மட்டும் தெரியும் — தங்க வளைய மரபு வில்லை */
.pk-bk{display:none;flex:none;position:relative;place-items:center;width:clamp(44px,calc(var(--u)*58),56px);height:clamp(44px,calc(var(--u)*58),56px);padding:0;border-radius:50%;border:2px solid #E2B44F;background:radial-gradient(circle at 35% 28%,#b3216c,#6b0b3e 72%);color:#F3D995;cursor:pointer;
 box-shadow:0 0 0 3px #fbf1df,0 0 0 4.5px #c9a56b,0 8px 16px rgba(96,6,36,.32),inset 0 1px 0 rgba(255,255,255,.28);transition:transform .25s,box-shadow .25s,filter .25s;-webkit-tap-highlight-color:transparent}
.pk-bk::after{content:"";position:absolute;inset:4px;border-radius:50%;border:1px dashed rgba(243,217,149,.6);pointer-events:none}
.pk-bk svg{position:relative;z-index:1;stroke-width:2.2;filter:drop-shadow(0 1px 1px rgba(0,0,0,.35));transition:transform .25s}
.pk-bk.on{display:grid;animation:pkBkIn .35s ease both}
.pk-bk:hover{transform:scale(1.07);filter:brightness(1.12);box-shadow:0 0 0 3px #fbf1df,0 0 0 5px #E2B44F,0 12px 22px rgba(96,6,36,.4),inset 0 1px 0 rgba(255,255,255,.35)}
.pk-bk:hover svg{transform:translateX(-3px)}
.pk-bk:active{transform:scale(.93)}
.pk-bk:focus-visible{outline:3px solid #E2B44F;outline-offset:5px}
@keyframes pkBkIn{from{opacity:0;transform:translateX(14px) scale(.8)}to{opacity:1;transform:none}}
@media(prefers-reduced-motion:reduce){.pk-bk.on{animation:none}.pk-bk,.pk-bk svg{transition:none}}
.pk-si{position:absolute;left:18px;top:50%;transform:translateY(-50%);display:grid;color:#89194E;pointer-events:none}
.pk-q{display:block;width:100%;box-sizing:border-box;height:clamp(44px,calc(var(--u)*56),54px);padding:0 48px 0 50px;border-radius:30px;border:1.5px solid #d8bf94;background:#fffaf0;color:var(--ink);font:500 15px 'Noto Sans Tamil',sans-serif;box-shadow:0 6px 16px rgba(96,6,36,.10);outline:none;transition:.2s}
.pk-q::placeholder{color:#8d7a3a;opacity:.85}
.pk-q:focus{border-color:#89194E;box-shadow:0 0 0 3px rgba(137,25,78,.15),0 6px 16px rgba(96,6,36,.12)}
.pk-qx{position:absolute;right:10px;top:50%;transform:translateY(-50%);display:none;width:28px;height:28px;border:0;border-radius:50%;background:#efe0c6;color:#6b1236;font-size:13px;cursor:pointer;padding:0}
.pk-qx:hover{background:#89194E;color:#fff}
.pk-sb.has .pk-qx{display:block}
/* ---------- one row of cards: scroll sideways, any number of cards ---------- */
.pk-slw{position:relative;z-index:2;padding:0 12.6%;margin-top:calc(var(--u)*26)}
.pk-grid{--g:clamp(12px,calc(var(--u)*26),30px);display:flex;flex-wrap:nowrap;gap:var(--g);overflow-x:auto;overflow-y:hidden;scroll-snap-type:x mandatory;scroll-padding:0 4px;padding:10px 4px 24px;margin:0 -4px;-webkit-overflow-scrolling:touch;overscroll-behavior-x:contain;scrollbar-width:thin;scrollbar-color:#c9a56b transparent}
.pk-grid::-webkit-scrollbar{height:7px}.pk-grid::-webkit-scrollbar-track{background:transparent}.pk-grid::-webkit-scrollbar-thumb{background:#c9a56b;border-radius:10px}
.pk-c{flex:0 0 calc((100% - var(--g)*3)/4);scroll-snap-align:start;display:flex;flex-direction:column;min-width:0;container-type:inline-size;background:#fcf6ea;border:1.5px solid #dcc59b;border-radius:16px;overflow:hidden;box-shadow:0 8px 20px rgba(96,6,36,.10),inset 0 0 0 3px rgba(255,255,255,.55);transition:box-shadow .28s,border-color .28s,transform .28s}
.pk-c:hover{transform:translateY(-5px);box-shadow:0 18px 36px rgba(96,6,36,.18);border-color:#b8935a}
.pk-c.hide{display:none}
.pk-nv{position:absolute;top:calc(50% - 8px);transform:translateY(-50%);z-index:4;display:grid;place-items:center;width:46px;height:46px;padding:0;border-radius:50%;border:2px solid #fff;background:linear-gradient(135deg,#9a1a5c,#6b0b3e);color:#fff;cursor:pointer;box-shadow:0 8px 18px rgba(96,6,36,.35);transition:.2s}
.pk-nv.prev{left:calc(12.6% - 24px)}.pk-nv.next{right:calc(12.6% - 24px)}
.pk-nv:hover{transform:translateY(-50%) scale(1.08)}
.pk-nv[disabled]{opacity:.3;cursor:default;pointer-events:none}
.pk-slw.nov .pk-nv{display:none}
.pk-img{position:relative;aspect-ratio:1/1;background:linear-gradient(135deg,var(--bl),var(--bg2));cursor:pointer;overflow:hidden}
.pk-img img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .45s}.pk-c:hover .pk-img img{transform:scale(1.05)}
.pk-no{position:absolute;inset:0;display:grid;place-items:center;color:var(--gd)}
.pk-tag{position:absolute;left:clamp(7px,4cqw,10px);top:clamp(7px,4cqw,10px);max-width:calc(100% - 20px);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;padding:4px 14px;border-radius:20px;background:linear-gradient(135deg,#a3185f,#6b0b3e);color:#fff;font:700 12px 'Noto Sans Tamil',sans-serif;box-shadow:0 3px 8px rgba(0,0,0,.22)}
.pk-bd{display:flex;flex-direction:column;gap:clamp(8px,4.5cqw,12px);padding:clamp(10px,5.6cqw,15px);flex:1}
.pk-nm{display:block;font:700 clamp(14px,calc(var(--u)*23),19px)/1.4 'Noto Serif Tamil',serif;color:#6b1236;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;word-break:break-word}
.pk-row{display:flex;align-items:center;justify-content:space-between;gap:clamp(3px,2.4cqw,8px);flex-wrap:nowrap;margin-top:auto}
.pk-id{flex:0 1 auto;min-width:0;display:inline-flex;align-items:center;height:clamp(26px,12.6cqw,32px);padding:0 clamp(7px,4.6cqw,13px);border-radius:20px;background:transparent;color:#6b5a24;border:1.5px dashed #8d7a3a;font:700 clamp(10px,4.9cqw,12.5px) 'Noto Sans Tamil',sans-serif;letter-spacing:.03em;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.pk-act{display:flex;align-items:center;gap:clamp(3px,2.4cqw,7px);flex:none}
.pk-lk,.pk-vw,.pk-bd .wa{display:inline-flex;align-items:center;justify-content:center;box-sizing:border-box;height:clamp(26px,12.6cqw,32px);margin:0;border-radius:20px;border:1.5px solid #dcc59b;background:#fff;color:#8a6538;cursor:pointer;transition:.2s;text-decoration:none;position:static;transform:none}
.pk-lk{gap:4px;padding:0 clamp(7px,4.4cqw,12px);color:#89194E;border-color:#e3c2d2;font:700 clamp(11px,5.3cqw,13px) 'Noto Sans Tamil',sans-serif}.pk-lk span{font-size:clamp(13px,6.4cqw,16px);line-height:1}.pk-lk em{font-style:normal}
.pk-lk:hover,.pk-lk.on{background:#89194E;color:#fff;border-color:#89194E}
.pk-vw,.pk-bd .wa{width:clamp(26px,12.6cqw,32px);padding:0}
.pk-vw:hover{background:#8a6538;color:#fff;border-color:#8a6538}
.pk-bd .wa{color:#1ea952}.pk-bd .wa:hover{background:#25D366;color:#fff;border-color:#25D366}
/* ---------- every card: "மேலும் காண்க" button at the bottom ---------- */
.pk-mr{display:grid;place-items:center;box-sizing:border-box;width:100%;height:clamp(34px,16cqw,42px);margin:2px 0 0;padding:0 10px;border-radius:99px;border:1px solid #e3c27a;color:#fff6dc;font:700 clamp(12px,5.8cqw,15px) 'Noto Sans Tamil',sans-serif;white-space:nowrap;cursor:pointer;background:linear-gradient(#b21d68,#6a0d3f);box-shadow:0 4px 10px rgba(110,13,63,.32),inset 0 1px 0 rgba(255,255,255,.25);transition:.2s}
.pk-mr:hover{transform:translateY(-1px);filter:brightness(1.1)}
.pk-mr:active{transform:scale(.97)}
/* "மேலும் காண்க" அழுத்தி வகை மட்டும் திறந்த பக்கத்தில் இந்த பொத்தான் தெரியாது (முதல் பக்கத்தில் மட்டும்) */
.pk-sec.flt .pk-mr{display:none}
.pk-empty{display:none;margin:28px 12.6% 6px;padding:28px;text-align:center;border:1.5px dashed #c9a56b;border-radius:14px;color:#6b5a24;background:rgba(255,250,240,.8);font-weight:600;position:relative;z-index:2}
.pk-empty.on{display:block}
/* ---------- page numbers (1 2 3 ... >) ---------- */
.pk-pg{position:relative;z-index:3;display:none;align-items:center;justify-content:center;flex-wrap:wrap;gap:clamp(4px,1vw,12px);margin:4px 16px 0}
.pk-pg.on{display:flex}
.pk-pg button{display:grid;place-items:center;min-width:46px;height:46px;padding:0 8px;border-radius:30px;border:1.5px solid transparent;background:none;color:var(--ink);font:600 15px 'Noto Sans Tamil',sans-serif;cursor:pointer;transition:.2s}
.pk-pg button:hover{background:rgba(137,25,78,.09)}
.pk-pg button.cur{border-color:#c9b48a;background:#fffaf0;color:#6b1236;cursor:default;box-shadow:0 4px 10px rgba(96,6,36,.08)}
.pk-pg .dots{min-width:30px;text-align:center;color:#8d7a3a;font-weight:700;letter-spacing:.12em}
.pk-pg .arr{width:46px;padding:0;border-radius:50%;background:linear-gradient(135deg,#9a1a5c,#6b0b3e);color:#fff;box-shadow:0 6px 14px rgba(96,6,36,.3)}
.pk-pg .arr:hover{background:#89194E;transform:scale(1.07)}
.pk-pg .arr.pv{background:#fffaf0;color:#6b1236;border-color:#d8bf94;box-shadow:none}
.pk-pg .arr.pv:hover{background:#89194E;color:#fff}
/* ---------- footer (wave image + live text) ---------- */
.pk-ft{position:relative;z-index:3}
.pk-ft img{display:block;width:100%;height:auto;min-height:92px;object-fit:cover;object-position:center top;pointer-events:none;user-select:none}
.pk-fc{position:absolute;left:50%;top:45.7%;transform:translate(-50%,-50%);width:90%;text-align:center;color:#f8e9f0;font:500 clamp(11px,calc(var(--u)*19),17px)/1.5 'Noto Sans Tamil',sans-serif;letter-spacing:.01em}
.pk-fc a{color:#F3D995;font-weight:700;text-decoration:none;border-bottom:1px solid rgba(243,217,149,.7)}.pk-fc a:hover{color:#fff;border-color:#fff}.pk-sl{margin:0 .7em;color:#E2B44F;font-weight:700}
/* ---------- view popup: cream frame · thumbnails left · big card (no background behind it) · details right ---------- */
.pk-pop{position:fixed;inset:0;z-index:80;display:none;place-items:center;padding:clamp(10px,2vw,22px);background:rgba(40,4,20,.9);backdrop-filter:blur(5px);overflow:auto}
.pk-pop.on{display:grid}
.pk-pb{position:relative;box-sizing:border-box;width:fit-content;max-width:100%;margin:0 auto;display:grid;grid-template-columns:auto auto minmax(240px,310px);gap:clamp(14px,2.6vw,34px);align-items:center;padding:clamp(14px,2vw,22px) clamp(16px,2.4vw,30px);border-radius:20px;background:linear-gradient(180deg,#fffaf0,#f8ecd6);border:2px solid #c9a56b;box-shadow:0 0 0 5px rgba(255,250,240,.16),0 28px 70px rgba(0,0,0,.55),inset 0 0 0 4px #fffaf0,inset 0 0 0 5.5px #e3c9a0;text-align:left}
.pk-x{position:absolute;top:-14px;right:-14px;width:40px;height:40px;border-radius:50%;border:2px solid #fff;background:var(--mr);color:#fff;font-size:16px;cursor:pointer;z-index:3}
.pv-th{display:flex;flex-direction:column;gap:10px;max-height:86vh;overflow-y:auto;padding:3px}
.pv-th button{display:block;width:66px;height:82px;padding:0;border-radius:8px;border:2px solid #dcc59b;background:none;overflow:hidden;cursor:pointer;opacity:.65;transition:.2s}
.pv-th button:hover{opacity:1}
.pv-th button.on{opacity:1;border-color:#89194E;box-shadow:0 0 0 3px rgba(137,25,78,.22)}
.pv-th img{display:block;width:100%;height:100%;object-fit:cover}
.pv-main{display:flex;align-items:center;justify-content:center;min-width:0;background:none}
.pv-main img{display:block;max-width:100%;max-height:calc(100vh - 90px);width:auto;height:auto;object-fit:contain;border-radius:8px;box-shadow:0 14px 34px rgba(96,6,36,.35)}
.pv-no{padding:40px 10px;color:#8a6538;font:600 14px 'Noto Sans Tamil',sans-serif}
.pv-in{min-width:0;align-self:center;padding-left:clamp(14px,2.2vw,28px);border-left:2px solid #e3c9a0}
.pv-br{display:flex;align-items:center;gap:8px;margin:0 0 10px;color:#a3185f;font:800 13px/1.3 'Noto Sans Tamil',sans-serif;letter-spacing:.08em}
.pv-br:before{content:"";flex:none;width:8px;height:8px;transform:rotate(45deg);background:linear-gradient(135deg,#a3185f,#6b0b3e);box-shadow:0 0 0 1.5px #c9a56b}
.pv-in h3{margin:0;color:#6b1236;font:800 clamp(22px,2.6vw,30px)/1.35 'Noto Serif Tamil',serif;overflow-wrap:anywhere}
.pv-nm{margin:6px 0 0;color:#6b5a24;font:600 15px/1.5 'Noto Sans Tamil',sans-serif;overflow-wrap:anywhere}
.pv-row{display:flex;align-items:center;gap:12px;margin:18px 0 0}
.pv-id{display:inline-flex;align-items:center;height:38px;padding:0 18px;border-radius:20px;background:linear-gradient(135deg,#a3185f,#6b0b3e);color:#F3D995;font:700 14px 'Noto Sans Tamil',sans-serif;letter-spacing:.04em;white-space:nowrap;box-shadow:0 4px 10px rgba(96,6,36,.3)}
.pv-wa{display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:50%;background:#25D366;color:#fff;text-decoration:none;box-shadow:0 4px 10px rgba(37,211,102,.4);transition:.2s}
.pv-wa:hover{transform:scale(1.08)}
.pv-wa svg{width:23px;height:23px}
.pv-ds{margin:14px 0 0;color:#3b1224;font:500 14px/1.7 'Noto Sans Tamil',sans-serif;overflow-wrap:anywhere}
.pv-ct{display:flex;align-items:center;justify-content:center;box-sizing:border-box;width:100%;height:48px;margin-top:20px;padding:0 18px;border-radius:12px;border:1.5px solid #c9a56b;background:#fffaf0;color:#6b1236;font:700 15px 'Noto Sans Tamil',sans-serif;text-decoration:none;box-shadow:0 4px 10px rgba(96,6,36,.1);transition:.2s}
.pv-ct:hover{background:#89194E;border-color:#89194E;color:#fff}
.pv-bk{display:flex;align-items:center;justify-content:center;gap:10px;box-sizing:border-box;width:100%;height:48px;margin-top:12px;padding:0 18px;border-radius:12px;border:1.5px solid #E2B44F;background:linear-gradient(135deg,#9a1a5c,#6b0b3e);color:#F3D995;font:700 15px 'Noto Sans Tamil',sans-serif;cursor:pointer;box-shadow:0 6px 14px rgba(96,6,36,.3);transition:.2s}
.pv-bk:hover{filter:brightness(1.12);transform:translateY(-1px)}
.pv-bk svg{flex:none}
@media(max-width:900px){.pk-pb{grid-template-columns:auto minmax(0,1fr);width:min(560px,100%);align-items:start}.pv-in{grid-column:1/-1;border-left:0;padding-left:0;border-top:2px solid #e3c9a0;padding-top:16px}.pv-main img{max-height:70vh}.pv-th{max-height:70vh}}
/* ---------- responsive ---------- */
@media(max-width:1180px){
 /* டேப்லெட் / லேண்ட்ஸ்கேப்: பக்கவாட்டு ஸ்க்ரோல் இல்லை — பக்கத்தின் எல்லா கார்டுகளும் ஒரே நேரத்தில் தெரியும் */
 .pk-slw{padding:0 clamp(14px,3vw,28px)}
 .pk-grid{flex-wrap:wrap;overflow:visible;scroll-snap-type:none;row-gap:clamp(14px,2.4vw,22px);padding:8px 4px 20px}
 .pk-c{flex:0 0 calc((100% - var(--g)*2)/3);scroll-snap-align:none}
 .pk-nv{display:none!important}
 .pk-empty{margin-left:clamp(14px,3vw,28px);margin-right:clamp(14px,3vw,28px)}
}
@media(min-width:561px) and (max-width:760px){
 .pk-c{flex-basis:calc((100% - var(--g))/2)}
}
@media(max-width:1000px){
 /* flowers + wreath stay visible on mobile (smaller) */
 .dc{display:block}
 .dc.l1{width:54px;top:128px}.dc.l2{width:70px}.dc.r1{width:50px;top:128px}.dc.r2{width:92px}
 .pk-sr{margin-top:18px}
 .pk-slw{padding:0 16px;margin-top:14px}.pk-grid{--g:16px}.pk-nv{width:38px;height:38px}.pk-nv.prev{left:4px}.pk-nv.next{right:4px}
 .pk-empty{margin:24px 16px 6px}.pk-wrap{padding-bottom:30px}}
@media(max-width:700px){.pk-grid{--g:12px;flex-wrap:wrap;overflow:visible;scroll-snap-type:none;padding:6px 4px 18px;row-gap:16px}.pk-c{flex:0 0 calc((100% - var(--g))/2);scroll-snap-align:none}}
@media(max-width:640px){
 .pk-pg button{min-width:38px;height:38px;font-size:14px}.pk-pg .arr{width:38px}
 .pk-nm{font-size:14px}
 .pk-nv{display:none}
 .pk-tag{left:8px;top:8px;font-size:10.5px;padding:2px 10px}
 .pk-fc{font-size:11px;top:42%}.pk-fc .pk-lc{display:block}.pk-sl{display:none}
 .pk-dd{position:fixed;left:14px;right:14px;top:auto;min-width:0;max-width:none;margin-top:10px}
 .pk-pb{grid-template-columns:minmax(0,1fr);width:100%;gap:12px;padding:14px 14px 18px}.pk-x{top:-10px;right:-6px}
 .pv-main{grid-row:1}.pv-th{grid-row:2;flex-direction:row;max-height:none;overflow-x:auto;overflow-y:hidden;justify-content:center}.pv-th button{flex:none;width:54px;height:68px}.pv-in{grid-row:3;grid-column:auto}
 .pv-main img{max-height:64vh}
 /* மொபைல்: பின்செல் வில்லை + தேடல் பெட்டி ஒரே வரியில் நேர்த்தியாக */
 .pk-sr{padding:0 14px;gap:14px}.pk-bk{width:44px;height:44px;box-shadow:0 0 0 2.5px #fbf1df,0 0 0 4px #c9a56b,0 6px 12px rgba(96,6,36,.3),inset 0 1px 0 rgba(255,255,255,.28)}.pk-bk svg{width:20px;height:20px}.pk-bk:hover{transform:none}.pk-bk:hover svg{transform:none}}
@container (max-width:215px){.pk-idl{display:none}}
@media(max-width:340px){.pk-c{flex-basis:100%}}

/* ===== தேடல் வரி: தேடல் பெட்டி + பின்செல் + பரிசுகள்/அழைப்பிதழ்கள் + மெனு (ஒரே வரி, ஒரே உயரம், சிறிய அளவு) ===== */
.pk-sr{max-width:1100px;margin-left:auto;margin-right:auto;box-sizing:border-box}
.pk-sr .pk-sb{flex:1 1 auto;width:auto;max-width:560px}
.pk-sr .pk-rt{flex:none;gap:8px;width:auto;display:flex}
.pk-sr .pk-ab,.pk-sr .pk-mb{box-sizing:border-box;height:clamp(44px,calc(var(--u)*56),54px);padding:0 clamp(12px,1.1vw,18px);gap:7px;border-radius:30px;font-size:clamp(13px,.95vw,15px);justify-content:center}
.pk-sr .pk-cur{max-width:96px}
.pk-sr .pk-dd{right:0;left:auto}
@media(max-width:900px){
 .pk-sr{flex-wrap:wrap;justify-content:center;row-gap:10px}
 .pk-sr .pk-sb{flex:1 1 100%;max-width:none;order:1}
 .pk-sr .pk-bk{order:0}
 .pk-sr .pk-rt{order:2;flex:1 1 100%;display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:8px}
 .pk-sr .pk-rt>.pk-ab,.pk-sr .pk-rt .pk-mn{width:100%;min-width:0}
 .pk-sr .pk-rt .pk-mn{display:block}
 .pk-sr .pk-ab,.pk-sr .pk-mb{width:100%;height:44px;padding:0 8px;font-size:13px}
 .pk-sr .pk-ab .tx{display:inline;overflow:hidden;text-overflow:ellipsis}
 .pk-sr .pk-cur{max-width:none;flex:0 1 auto}
}
@media(max-width:640px){.pk-sr .pk-ab .tx{display:inline}.pk-sr .pk-ab,.pk-sr .pk-mb{padding:0 6px;gap:5px;font-size:12.5px}}
</style>
<div class="pk-page">
<div class="pk-wrap">
<?php if($v==='cards'): ?>
<section class="pk-sec" id="invitations">
<?php $m='<button type="button" data-f="" data-l="மெனு" class="'.($sel===''?'on':'').'"><span class="e">'.pk_i('all').'</span>அனைத்தும்<span class="n">'.count($cards).'</span></button>';
foreach($types as $k=>$t)$m.='<button type="button" data-f="'.h($k).'" data-l="'.h($t[1]).'" class="'.($sel===$k?'on':'').'"><span class="e">'.pk_i($k).'</span>'.h($t[1]).'<span class="n">'.(int)($cnt[$k]??0).'</span></button>';
echo pk_bar('mail','ஏதேன் அழைப்பிதழ்','உங்கள் விழாவுக்கு ஏற்ற அழகான அழைப்பிதழ்கள்');
echo pk_sr('ஐடி / பெயர் / வகை (எ.கா. B1, birthday)',pk_btn('index.php','back','பின்செல்').pk_btn('gift.php','gift','பரிசுகள்').pk_mnu($sel!==''?$types[$sel][1]:'மெனு',$m)); ?>
<div class="pk-slw"><button class="pk-nv prev" type="button" aria-label="முந்தையவை"><?=pk_i('prev',22)?></button>
<div class="pk-grid"><?php foreach($cards as $c) echo pk_card($c,'c'); ?></div>
<button class="pk-nv next" type="button" aria-label="அடுத்தவை"><?=pk_i('next',22)?></button></div>
<div class="pk-pg" role="navigation" aria-label="பக்கங்கள்"></div>
<p class="pk-empty<?=$cards?'':' on'?>" data-d="இந்த வகையில் அழைப்பிதழ்கள் இன்னும் சேர்க்கப்படவில்லை.">இந்த வகையில் அழைப்பிதழ்கள் இன்னும் சேர்க்கப்படவில்லை.</p>
</section>
<?php else: ?>
<section class="pk-sec" id="bags">
<?php $m='<button type="button" data-f="" data-l="மெனு" class="on"><span class="e">'.pk_i('all').'</span>அனைத்தும்<span class="n">'.count($bags).'</span></button>';
foreach($bags as $c)$m.='<button type="button" data-f="'.(int)$c['id'].'" data-l="'.h($c['name']).'"><span class="e">'.pk_i('bag').'</span>'.h($c['name']).(!empty($c['code'])?'<span class="n">'.h($c['code']).'</span>':'').'</button>';
echo pk_bar('gift','ஏதேன் பரிசுப் பைகள்','விழாவுக்கு அழகு சேர்க்கும் பரிசுப் பைகள்');
echo pk_sr('ஐடி / பெயர் (எ.கா. T1)',pk_btn('index.php','back','பின்செல்').pk_btn('products.php?v=cards','mail','அழைப்பிதழ்கள்').pk_mnu('மெனு',$m)); ?>
<div class="pk-slw"><button class="pk-nv prev" type="button" aria-label="முந்தையவை"><?=pk_i('prev',22)?></button>
<div class="pk-grid"><?php foreach($bags as $c) echo pk_card($c,'b'); ?></div>
<button class="pk-nv next" type="button" aria-label="அடுத்தவை"><?=pk_i('next',22)?></button></div>
<div class="pk-pg" role="navigation" aria-label="பக்கங்கள்"></div>
<p class="pk-empty<?=$bags?'':' on'?>" data-d="பரிசுப் பைகள் இன்னும் சேர்க்கப்படவில்லை.">பரிசுப் பைகள் இன்னும் சேர்க்கப்படவில்லை.</p>
</section>
<?php endif; ?>
</div>
<div class="pk-ft"><img src="assets/img/deco/footer.png" alt=""><div class="pk-fc"><span class="pk-lc">© ஏதேன் அழைப்பிதழ் </span><span class="pk-sl">//</span><span class="pk-lc">© <a href="https://instagram.com/lifechangersind" target="_blank" rel="noopener">LifeChangersInd</a>. All Rights Reserved.</span></div></div>
</div>
<div class="pk-pop" id="pkp"><div class="pk-pb" role="dialog" aria-modal="true"><button class="pk-x" type="button" aria-label="Close">✕</button>
<div class="pv-th" id="pkth"></div>
<div class="pv-main" id="pkmain"></div>
<div class="pv-in"><small class="pv-br">ஏதேன் அழைப்பிதழ்</small><h3 id="pkn"></h3><p class="pv-nm" id="pknm"></p>
<div class="pv-row"><span class="pv-id" id="pkid"></span><a class="pv-wa" id="pkwa" href="#" target="_blank" rel="noopener" title="WhatsApp" aria-label="WhatsApp"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg></a></div>
<p class="pv-ds" id="pkd"></p>
<a class="pv-ct" href="contact.php">தொடர்பு கொள்ளுங்கள்</a>
<button class="pv-bk" id="pkbk" type="button"><svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 5.5C6.5 4 9.5 4 12 5.5c2.5-1.5 5.5-1.5 8 0V19c-2.5-1.5-5.5-1.5-8 0-2.5-1.5-5.5-1.5-8 0V5.5Z"/><path d="M12 5.5V19"/></svg>View Book</button></div></div></div>
<script>
/* ===== View Book (book model) - window.AthenBook.open({title,code,pages:[photo urls],h,s,c}) =====
   Desktop / tablet: open book - LEFT page = content only, RIGHT page = one photo; every click turns the page (next photo).
   Mobile (<= 820px): one page at a time (front photo, content, next photos...). Swipe / arrows / dots / keyboard. */
(function(){
var el,bk,cv,sl,ttl,cid,pn,dt,pvB,nxB,D=null,mode='two',s=0,MAX=0,N=0,sheets=[],busy=false,pw=0,ph=0,ratio=.62,DUR=900,tok=0,tmr=0,imgs=[],txt=null,oldOv='',PD=12;
var AL='<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>',
    AR='<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>';
function esc(t){var d=document.createElement('div');d.textContent=t==null?'':String(t);return d.innerHTML}
function make(){if(el)return;
 el=document.createElement('div');el.className='fb';el.setAttribute('role','dialog');el.setAttribute('aria-modal','true');el.setAttribute('aria-label','View Book');
 el.innerHTML='<div class="fb-top"><div class="fb-ttl"><b></b><span></span></div><button type="button" class="fb-x" aria-label="Close">✕</button></div>'+
  '<div class="fb-stage"><div class="fb-sl"><div class="fb-cv"><div class="fb-bk"></div><i class="fb-sp"></i><i class="fb-rb"></i></div></div></div>'+
  '<button type="button" class="fb-nv prev" aria-label="முந்தைய பக்கம்">'+AL+'</button><button type="button" class="fb-nv next" aria-label="அடுத்த பக்கம்">'+AR+'</button>'+
  '<div class="fb-bot"><div class="fb-dots"></div><span class="fb-pn"></span></div>';
 document.body.appendChild(el);
 bk=el.querySelector('.fb-bk');cv=el.querySelector('.fb-cv');sl=el.querySelector('.fb-sl');ttl=el.querySelector('.fb-ttl b');cid=el.querySelector('.fb-ttl span');pn=el.querySelector('.fb-pn');dt=el.querySelector('.fb-dots');pvB=el.querySelector('.fb-nv.prev');nxB=el.querySelector('.fb-nv.next');
 el.querySelector('.fb-x').addEventListener('click',close);
 pvB.addEventListener('click',function(e){e.stopPropagation();go(-1)});nxB.addEventListener('click',function(e){e.stopPropagation();go(1)});
 dt.addEventListener('click',function(e){var b=e.target.closest('button');if(!b||busy)return;build(+b.dataset.i)});
 bk.addEventListener('click',function(e){if(e.target.closest('.fb-ct'))return;var r=bk.getBoundingClientRect();go(e.clientX-r.left>r.width/2?1:-1)});
 var x0=null,y0=0;
 el.addEventListener('touchstart',function(e){var t=e.touches[0];x0=t.clientX;y0=t.clientY},{passive:true});
 el.addEventListener('touchend',function(e){if(x0===null)return;var t=e.changedTouches[0],dx=t.clientX-x0,dy=t.clientY-y0;x0=null;if(Math.abs(dx)>50&&Math.abs(dx)>Math.abs(dy)*1.3){e.preventDefault();go(dx<0?1:-1)}});
 document.addEventListener('keydown',function(e){if(!el.classList.contains('on'))return;
  if(e.key==='Escape'){e.stopImmediatePropagation();e.preventDefault();close()}
  else if(e.key==='ArrowRight'){e.stopImmediatePropagation();go(1)}
  else if(e.key==='ArrowLeft'){e.stopImmediatePropagation();go(-1)}},true);
 window.addEventListener('resize',function(){if(!el.classList.contains('on')||!D)return;clearTimeout(tmr);tmr=setTimeout(refit,160)});
 window.addEventListener('orientationchange',function(){if(el.classList.contains('on')&&D){clearTimeout(tmr);tmr=setTimeout(refit,300)}})}
/* ---- pages ---- */
function pageHtml(p){
 if(!p)return '';
 if(p.t==='i')return '<div class="fb-pg"><img src="'+esc(p.src)+'" alt="" draggable="false"></div>';
 if(p.t==='t')return '<div class="fb-pg fb-tx"><div class="fb-in"><small>ஏதேன் அழைப்பிதழ்</small>'+(p.h?'<h3>'+WD(p.h,true)+'</h3>':'')+'<div class="fb-dv"><i></i></div>'+(p.s?'<h4>'+WD(p.s,false)+'</h4>':'')+(p.c?'<div class="fb-ct">'+esc(p.c)+'</div>':'')+'</div><em class="fb-pf">ஏதேன் அழைப்பிதழ் · '+p.n+' / '+imgs.length+'</em></div>';
 return '<div class="fb-pg fb-br"><i>✝</i><b>ஏதேன்<br>அழைப்பிதழ்</b><div class="fb-dv"><i></i></div><em>ATHEN INVITATION</em></div>'}
/* every word stays whole: short titles (up to 3 words) put each word on its own line, e.g. Baby / shower / invitation */
function WD(t,stack){var w=String(t).trim().split(/\s+/).filter(Boolean),c=stack&&w.length<=3?'fb-w fb-l':'fb-w';return w.map(function(x){return '<span class="'+c+'">'+esc(x)+'</span>'}).join(' ')}
/* shrink a heading until its longest word fits the page width (a word is never cut) */
function fit(){if(!bk)return;[].forEach.call(bk.querySelectorAll('.fb-tx h3,.fb-tx h4'),function(h){
 h.style.fontSize='';var fs=parseFloat(getComputedStyle(h).fontSize)||16,ws=h.querySelectorAll('.fb-w'),i,mx,g=0;
 function wide(){mx=0;for(i=0;i<ws.length;i++)mx=Math.max(mx,ws[i].scrollWidth);return mx>h.clientWidth+.5}
 while(fs>9&&g++<60&&wide()){fs-=1;h.style.fontSize=fs+'px'}})}
function TXT(n){return{t:'t',h:txt.h,s:txt.s,c:txt.c,n:n}}
/* ---- size: every page has the same shape as the front photo ---- */
function layout(){var st=el.querySelector('.fb-stage'),aw=st.clientWidth,ah=st.clientHeight-8,m=el.clientWidth>820?'two':'one',r=ratio;
 PD=m==='two'?12:8;
 if(m==='two'){var mw=(aw-2*84-2*PD-4)/2;ph=Math.max(120,Math.min(ah-2*PD-16,mw/r));pw=ph*r}
 else{var mw1=aw-28-2*PD-4;ph=Math.max(120,Math.min(ah-2*PD-8,mw1/r));pw=ph*r}
 cv.style.padding=PD+'px';cv.classList.toggle('one',m==='one');
 bk.style.width=(m==='two'?2*pw:pw)+'px';bk.style.height=ph+'px';return m}
/* ---- build ----
   two-page book: base left page = content; sheet k = front: photo k (right page) / back: content (left page of the next spread)
   so every spread = [content | photo k] */
function build(ii){
 var m=layout();mode=m;var n=imgs.length,h='',k;
 if(m==='two'){
  N=n;MAX=n-1;
  h='<div class="fb-lb">'+pageHtml(TXT(1))+'</div>';
  for(k=0;k<N;k++)h+='<div class="fb-sh" data-k="'+k+'"><div class="fb-f">'+pageHtml({t:'i',src:imgs[k]})+'</div><div class="fb-f b">'+pageHtml(k<n-1?TXT(k+2):{t:'e'})+'</div></div>';
  s=Math.min(MAX,Math.max(0,ii))}
 else{
  var list=[{t:'i',src:imgs[0]},TXT(1)];for(k=1;k<n;k++)list.push({t:'i',src:imgs[k]});
  N=list.length;MAX=N-1;
  for(k=0;k<N;k++)h+='<div class="fb-sh one" data-k="'+k+'"><div class="fb-f">'+pageHtml(list[k])+'</div></div>';
  s=ii<=0?0:Math.min(MAX,ii+1)}
 bk.innerHTML=h;sheets=[].slice.call(bk.querySelectorAll('.fb-sh'));
 sl.style.transition='none';
 sheets.forEach(function(sh,k){sh.style.transition='none';sh.classList.toggle('fl',k<s)});
 zfix();
 void bk.offsetWidth;
 requestAnimationFrame(function(){sl.style.transition='';sheets.forEach(function(sh){sh.style.transition=''})});
 fit();if(document.fonts&&document.fonts.ready)document.fonts.ready.then(function(){if(el&&el.classList.contains('on'))fit()});
 info()}
function zfix(){sheets.forEach(function(sh,k){sh.style.zIndex=k<s?k+1:N-k})}
function curImg(){var n=imgs.length;if(mode==='two')return Math.min(s,n-1);return s<=1?0:s-1}
function info(){var c=curImg();pn.textContent=(c+1)+' / '+imgs.length;pvB.disabled=s<=0;nxB.disabled=s>=MAX;
 [].forEach.call(dt.children,function(b,i){b.classList.toggle('on',i===c)})}
function go(d){if(busy||!D)return;var ns=s+d;if(ns<0||ns>MAX)return;busy=true;
 var sh=sheets[d>0?s:s-1];if(sh){sh.style.zIndex=1000;sh.classList.add('tn');setTimeout(function(){sh.classList.remove('tn')},DUR)}
 s=ns;sheets.forEach(function(x,k){x.classList.toggle('fl',k<s)});info();
 setTimeout(function(){zfix();busy=false},DUR)}
function refit(){var ii=curImg(),old=mode,m=layout();
 if(m!==old){busy=false;build(ii);return}
 build(ii)}
/* ---- open / close ---- */
function open(o){make();D=o;imgs=(o.pages||[]).filter(Boolean);txt={h:o.h||o.title||'',s:o.s||'',c:o.c||''};if(!imgs.length)return;
 ttl.textContent=o.title||'';cid.textContent=o.code?'ID : '+o.code:'';
 oldOv=document.body.style.overflow;document.body.style.overflow='hidden';
 bk.innerHTML='';pn.textContent='';pvB.disabled=true;nxB.disabled=true;busy=false;
 dt.innerHTML=imgs.map(function(u,i){return '<button type="button" data-i="'+i+'" aria-label="'+(i+1)+'"></button>'}).join('');
 el.classList.add('on');
 imgs.forEach(function(u,i){if(i>0){var p=new Image();p.src=u}});
 var my=++tok,done=false,im=new Image();
 function fin(){if(done||my!==tok)return;done=true;if(im.naturalWidth&&im.naturalHeight)ratio=Math.min(1.3,Math.max(.45,im.naturalWidth/im.naturalHeight));else ratio=.62;build(0)}
 im.onload=fin;im.onerror=fin;setTimeout(fin,2500);im.src=imgs[0]}
function close(){if(!el)return;tok++;D=null;el.classList.remove('on');bk.innerHTML='';sheets=[];document.body.style.overflow=oldOv}
window.AthenBook={open:open,close:close};
})();
</script>
<script>
(function(){
var $=function(s,r){return(r||document).querySelector(s)},$$=function(s,r){return[].slice.call((r||document).querySelectorAll(s))};
if(location.hash==='#bags'&&!/[?&](v|type)=/.test(location.search)){location.replace('products.php?v=gifts');return}
/* ---- full-screen fit: page always spans the whole screen width, whatever wraps it ---- */
function fit(){var p=$('.pk-page');if(!p)return;p.style.marginLeft='0';p.style.width=document.documentElement.clientWidth+'px';p.style.maxWidth='none';
 var l=p.getBoundingClientRect().left;if(Math.abs(l)>0.5)p.style.marginLeft=(-l)+'px'}
fit();window.addEventListener('resize',fit);window.addEventListener('orientationchange',fit);window.addEventListener('load',fit);
var L=[];try{L=JSON.parse(localStorage.getItem('athen_liked')||'[]')}catch(e){}
/* ---- menu + search + filter ---- */
function closeMenus(){$$('.pk-mn.open').forEach(function(m){m.classList.remove('open')})}
function setMenu(sec,f,label){$$('.pk-dd button',sec).forEach(function(b){b.classList.toggle('on',b.dataset.f===f)});$('.pk-cur',sec).textContent=label}
/* arrows: enable / disable / hide when everything fits */
function upd(sec){var g=$('.pk-grid',sec),w=$('.pk-slw',sec),p=$('.pk-nv.prev',sec),n=$('.pk-nv.next',sec);
 w.classList.toggle('nov',g.scrollWidth<=g.clientWidth+6);p.disabled=g.scrollLeft<=3;n.disabled=g.scrollLeft+g.clientWidth>=g.scrollWidth-3}
/* show only the cards that match the menu choice AND the search text */
var PER=8;/* cards on one page - change this number to show more / fewer */
var IP='<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>',IN=IP.replace('m15 18-6-6 6-6','m9 18 6-6-6-6');
function pager(sec,pg){var el=$('.pk-pg',sec),cur=sec._st.p,h='';el.classList.toggle('on',pg>1);if(pg<2){el.innerHTML='';return}
 var s={};[1,pg,cur-1,cur,cur+1].concat(cur<3?[2,3]:[]).forEach(function(x){if(x>=1&&x<=pg)s[x]=1});
 var a=Object.keys(s).map(Number).sort(function(x,y){return x-y}),last=0;
 if(cur>1)h+='<button type="button" class="arr pv" data-p="'+(cur-1)+'" aria-label="முந்தைய பக்கம்">'+IP+'</button>';
 a.forEach(function(x){if(x-last>1)h+='<span class="dots">…</span>';h+='<button type="button" '+(x===cur?'class="cur" aria-current="page"':'data-p="'+x+'"')+' aria-label="பக்கம் '+x+'">'+x+'</button>';last=x});
 if(cur<pg)h+='<button type="button" class="arr" data-p="'+(cur+1)+'" aria-label="அடுத்த பக்கம்">'+IN+'</button>';
 el.innerHTML=h}
function apply(sec){var st=sec._st,g=$('.pk-grid',sec),em=$('.pk-empty',sec),n=0,m=[],
 q=(st.q||'').toLowerCase().replace(/\bid\b|[:]/g,' ').replace(/\s+/g,' ').trim(),qs=q.replace(/[\s\-]+/g,''),tk=q?q.split(' '):[],ex=!!q&&$$('.pk-c',sec).some(function(c){return(c.dataset.code||'').toLowerCase()===qs});/* an exact ID (B1) shows only that card */
 $$('.pk-c',sec).forEach(function(c){var ok=st.f===''||c.dataset.f===st.f;
  if(ok&&q){if(ex)ok=(c.dataset.code||'').toLowerCase()===qs;else{var s=c.dataset.s||'',sq=s.replace(/[\s\-]+/g,'');ok=tk.every(function(t){return s.indexOf(t)>-1})||sq.indexOf(qs)>-1}}
  c.classList.add('hide');if(ok)m.push(c)});
 n=m.length;var pg=Math.max(1,Math.ceil(n/PER));st.p=Math.min(Math.max(st.p||1,1),pg);
 m.slice((st.p-1)*PER,st.p*PER).forEach(function(c){c.classList.remove('hide')});pager(sec,pg);
 em.textContent=q?('"'+st.q.trim()+'" — பொருத்தமானவை எதுவும் கிடைக்கவில்லை.'):em.dataset.d;em.classList.toggle('on',n===0);
 g.scrollLeft=0;upd(sec)}
/* பின்செல் வில்லை + "மேலும் காண்க" மறைப்பு: இரண்டும் ஒரே நேரத்தில் (வகை திறந்த பக்கத்தில் மட்டும்) */
function showBk(sec,on){var b=$('.pk-bk',sec);if(b)b.classList.toggle('on',!!on);sec.classList.toggle('flt',!!on)}
function filt(sec,f,label){var q=$('.pk-q',sec);sec._st={f:f,q:'',p:1};q.value='';$('.pk-sb',sec).classList.remove('has');setMenu(sec,f,label);showBk(sec,false);apply(sec)}
$$('.pk-sec').forEach(function(sec){
 sec._st={f:'',q:'',p:1};
 var q=$('.pk-q',sec),sb=$('.pk-sb',sec),g=$('.pk-grid',sec);
 $('.pk-mb',sec).addEventListener('click',function(e){e.stopPropagation();var m=this.parentNode,o=m.classList.contains('open');closeMenus();if(!o)m.classList.add('open')});
 $$('.pk-dd button',sec).forEach(function(b){b.addEventListener('click',function(){filt(sec,b.dataset.f,b.dataset.l);closeMenus()})});
 /* typing a search looks through every card (menu goes back to "all") */
 q.addEventListener('input',function(){showBk(sec,false);sec._st={f:'',q:q.value,p:1};sb.classList.toggle('has',!!q.value);setMenu(sec,'','மெனு');apply(sec)});
 $('.pk-bk',sec).addEventListener('click',function(){filt(sec,'','மெனு');try{history.replaceState(null,'',sec.id==='bags'?'products.php?v=gifts':'products.php?v=cards')}catch(x){}var top=sec.getBoundingClientRect().top+window.pageYOffset-8;window.scrollTo({top:Math.max(0,top),behavior:'smooth'})});
 $('.pk-qx',sec).addEventListener('click',function(){q.value='';q.dispatchEvent(new Event('input'));q.focus()});
 $('.pk-nv.prev',sec).addEventListener('click',function(){g.scrollBy({left:-g.clientWidth,behavior:'smooth'})});
 $('.pk-nv.next',sec).addEventListener('click',function(){g.scrollBy({left:g.clientWidth,behavior:'smooth'})});
 $('.pk-pg',sec).addEventListener('click',function(e){var b=e.target.closest('button[data-p]');if(!b)return;sec._st.p=+b.dataset.p;apply(sec)});
 g.addEventListener('scroll',function(){upd(sec)},{passive:true});
 apply(sec);
});
function updAll(){$$('.pk-sec').forEach(upd)}
window.addEventListener('resize',updAll);window.addEventListener('load',updAll);
document.addEventListener('click',function(e){if(!e.target.closest('.pk-mn'))closeMenus()});
(function(){var f=<?=json_encode($sel)?>;if(f){var s=$('#invitations'),b=s&&$('.pk-dd button[data-f="'+f+'"]',s);if(b){filt(s,f,b.dataset.l);showBk(s,true)}}})();
/* ---- likes ---- */
function toast(m){var t=$('#pkt');if(!t){t=document.createElement('div');t.id='pkt';t.style.cssText='position:fixed;left:50%;bottom:26px;transform:translateX(-50%);z-index:90;padding:10px 20px;border-radius:30px;background:#600624;color:#fff;font:600 13px "Noto Sans Tamil",sans-serif;box-shadow:0 8px 20px rgba(0,0,0,.3);transition:.3s;opacity:0;pointer-events:none';document.body.appendChild(t)}
 t.textContent=m;t.style.opacity=1;clearTimeout(toast.t);toast.t=setTimeout(function(){t.style.opacity=0},2400)}
function paint(){$$('.pk-lk').forEach(function(b){var on=L.indexOf(b.dataset.key)>-1;b.classList.toggle('on',on);$('span',b).textContent=on?'♥':'♡'})}
function like(k){var on=L.indexOf(k)<0;if(on)L.push(k);else L.splice(L.indexOf(k),1);try{localStorage.setItem('athen_liked',JSON.stringify(L))}catch(e){}paint();
 fetch('api/feedback.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({action:on?'like':'unlike',key:k})}).then(function(r){return r.json()}).then(function(r){if(r.ok)$$('.pk-lk[data-key="'+k+'"] em').forEach(function(e){e.textContent=r.count});if(on)toast('❤ லைக் செய்தீர்கள்!')}).catch(function(){toast('இணைப்பு பிழை')})}
paint();
/* ---- view popup ---- */
var w=$('#pkp'),thb=$('#pkth'),mainb=$('#pkmain');
function esc(t){var d=document.createElement('div');d.textContent=t;return d.innerHTML}
function showImg(src,n){mainb.innerHTML='<img src="'+esc(src)+'" alt="'+esc(n)+'">';$$('button',thb).forEach(function(b){b.classList.toggle('on',b.dataset.src===src)})}
var curCard=null;
function openBook(){var c=curCard;if(!c||!window.AthenBook)return;var pg=[];try{pg=JSON.parse(c.dataset.pages||'[]')}catch(x){}
 AthenBook.open({title:c.dataset.name||'',code:c.dataset.code||'',pages:pg,h:c.dataset.bh||'',s:c.dataset.bs||'',c:c.dataset.bc||''})}
function openV(c){curCard=c;var n=c.dataset.name,imgs=[],h='';
 try{imgs=JSON.parse(c.dataset.imgs||'[]')}catch(x){}
 if(!imgs.length)[c.dataset.img1,c.dataset.img2].forEach(function(s){if(s)imgs.push(s)});
 imgs.forEach(function(s){h+='<button type="button" data-src="'+esc(s)+'" aria-label="படம்"><img src="'+esc(s)+'" alt=""></button>'});
 thb.innerHTML=h;thb.style.display=imgs.length?'':'none';
 if(imgs.length)showImg(imgs[0],n);else mainb.innerHTML='<div class="pv-no">படம் இல்லை</div>';
 $('#pkn').textContent=c.dataset.type?(c.dataset.lab||'')+' அழைப்பு':'பரிசுப் பை';
 $('#pknm').textContent=n||'';
 var idb=$('#pkid');idb.textContent=c.dataset.code?'ID : '+c.dataset.code:'';idb.style.display=c.dataset.code?'':'none';
 var wa=$('.wa',c),wl=$('#pkwa');if(wa){wl.href=wa.href;wl.style.display=''}else wl.style.display='none';
 $('#pkd').textContent=c.dataset.desc||'';
 var bb=$('#pkbk');if(bb)bb.style.display=imgs.length?'':'none';
 w.classList.add('on');document.body.style.overflow='hidden'}
function closeV(){if(window.AthenBook)AthenBook.close();w.classList.remove('on');thb.innerHTML='';mainb.innerHTML='';document.body.style.overflow=''}
thb.addEventListener('click',function(e){var b=e.target.closest('button[data-src]');if(b)showImg(b.dataset.src,$('#pknm').textContent)});
document.addEventListener('click',function(e){var t=e.target;
 if(t.closest('.pk-pop')){if(t.closest('#pkbk')){openBook();return}if(t===w||t.closest('.pk-x'))closeV();return}
 var lk=t.closest('.pk-lk');if(lk){like(lk.dataset.key);return}
 /* card-கு கீழே உள்ள "மேலும் காண்க": அந்த வகை (பிறந்தநாள் / திருமணம் …) மட்டும் காட்டு */
 var mr=t.closest('.pk-mr');
 if(mr){var cd=mr.closest('.pk-c'),sec=mr.closest('.pk-sec');
  if(cd&&sec){var ty=cd.dataset.type;
   if(ty){filt(sec,ty,cd.dataset.lab||ty);try{history.replaceState(null,'','products.php?type='+encodeURIComponent(ty))}catch(x){}}
   else{/* பரிசுப் பைகள்: அதே பெயருள்ள பைகள் மட்டும் */
    var qi=$('.pk-q',sec);qi.value=cd.dataset.name||'';sec._st={f:'',q:qi.value,p:1};$('.pk-sb',sec).classList.toggle('has',!!qi.value);setMenu(sec,'','மெனு');apply(sec)}
   showBk(sec,true);var top=sec.getBoundingClientRect().top+window.pageYOffset-8;window.scrollTo({top:Math.max(0,top),behavior:'smooth'})}
  return}
 var c=t.closest('.pk-c');if(c&&(t.closest('.pk-vw')||t.closest('.pk-img')))openV(c)});
document.addEventListener('keydown',function(e){if(e.key==='Escape'){closeV();closeMenus()}});
})();
</script>
</body></html>