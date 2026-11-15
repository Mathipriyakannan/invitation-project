<?php $page='products'; include 'includes/header.php'; $sel=$_GET['type']??'';
$grp=['others'=>['welcome','thanks']];
if($sel!==''&&!isset($types[$sel])&&!isset($grp[$sel]))$sel='';
$list=array_filter($cards,fn($c)=>$sel===''||(isset($grp[$sel])?in_array($c['type'],$grp[$sel]):$c['type']===$sel)); ?>
<style>
.card.cv .b{padding:34px 20px 24px}
.card.cv .ev{position:absolute;left:calc(50% + 42px);top:251px;width:32px;height:32px;border-radius:50%;display:grid;place-items:center;padding:0;background:#fff;color:var(--ol);border:1.5px solid rgba(107,107,43,.3);opacity:.8;cursor:pointer;z-index:3;transition:.2s}
.card.cv .ev:hover{opacity:1;background:var(--ol-l);transform:scale(1.1)}
.cvw{position:fixed;inset:0;z-index:60;display:none;place-items:center;padding:18px;background:rgba(40,4,28,.88);backdrop-filter:blur(5px);overflow:auto}
.cvw.on{display:grid}
.cvb{position:relative;max-width:min(1000px,100%);text-align:center}
.cvx{position:absolute;top:-8px;right:-8px;width:38px;height:38px;border-radius:50%;border:2px solid #fff;background:var(--fu);color:#fff;font-size:17px;cursor:pointer;z-index:2}
.cvb h3{margin:0 0 14px;color:#fff;font-family:'Noto Serif Tamil',serif;font-size:20px}
.cvi{display:flex;gap:18px;justify-content:center;flex-wrap:wrap}
.cvi figure{margin:0}
.cvi img{display:block;max-width:100%;max-height:74vh;width:auto;border-radius:14px;border:4px solid #fff;box-shadow:0 18px 44px rgba(0,0,0,.45)}
.cvi figcaption{margin-top:8px;color:#f3dcea;font-size:13px;font-weight:600;letter-spacing:.06em}
/* சிறிய திரை: தலைப்பு வெளியே போகாது */
.phead h1{overflow-wrap:anywhere;max-width:100%}.phead{max-width:100%;overflow-x:clip}
@media(max-width:640px){.cvi img{max-height:none;width:100%}.cvi figure{width:100%}}
</style>
<div class="phead"><small>உங்கள் விழாவுக்கு ஏற்ற</small><h1>அழைப்பிதழ்கள்</h1></div>
<div class="wrap">
<div class="sec"><div class="chips"><a class="<?=$sel===''?'on':''?>" href="invitation.php">அனைத்தும்</a>
<?php foreach($types as $k=>$t): ?><a class="<?=$sel===$k?'on':''?>" href="invitation.php?type=<?=$k?>"><?=$t[2]?> <?=h($t[1])?></a><?php endforeach; ?></div>
<div class="grid"><?php foreach($list as $c) echo card_html($c,'c'); ?></div>
<?php if(!$list): ?><p class="empty">இந்த வகையில் அழைப்பிதழ்கள் இன்னும் சேர்க்கப்படவில்லை.</p><?php endif; ?></div>
</div><div class="cvw" id="cvw"><div class="cvb"><button class="cvx" type="button" aria-label="Close">✕</button><h3 id="cvn"></h3><div class="cvi" id="cvi"></div></div></div>
<script>
(function(){var w=document.getElementById('cvw'),box=document.getElementById('cvi'),nm=document.getElementById('cvn');
function esc(t){var d=document.createElement('div');d.textContent=t;return d.innerHTML}
function op(c){var a=c.dataset.img1,b=c.dataset.img2,n=c.dataset.name,h='';
 if(a)h+='<figure><img src="'+esc(a)+'" alt="'+esc(n)+'">'+(b?'<figcaption>முன்பக்கம்</figcaption>':'')+'</figure>';
 if(b)h+='<figure><img src="'+esc(b)+'" alt="'+esc(n)+'"><figcaption>பின்பக்கம்</figcaption></figure>';
 nm.textContent=n;box.innerHTML=h;w.classList.add('on');document.body.style.overflow='hidden'}
function cl(){w.classList.remove('on');box.innerHTML='';document.body.style.overflow=''}
document.addEventListener('click',function(e){var t=e.target;
 if(t.closest('#cvw')){if(t.id==='cvw'||t.closest('.cvx'))cl();return}
 if(t.closest('.lk'))return;
 var c=t.closest('.card.cv');if(!c)return;
 e.stopImmediatePropagation();if(t.closest('.ev'))op(c)},true);
document.addEventListener('keydown',function(e){if(e.key==='Escape')cl()});
})();
</script>
<?php include 'includes/footer.php'; ?>