<?php
session_start();require __DIR__.'/../includes/data.php';
if(empty($_SESSION['adm'])){header('Location: index.php');exit;}
function ico($n,$s=20){$p=[
'cards'=>'<rect x="3" y="5" width="18" height="14" rx="2.5"/><circle cx="8.5" cy="10" r="1.6"/><path d="m21 16-5-4.5L8 19"/>',
'bag'=>'<path d="M5 8h14l-1 12H6L5 8Z"/><path d="M9 8V6a3 3 0 0 1 6 0v2"/>',
'msg'=>'<path d="M4 5h16a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-8l-5 4v-4H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/><path d="M8 10h8M8 13h5"/>',
'out'=>'<path d="M10 4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h5"/><path d="M9 12h11M16 8l4 4-4 4"/>',
'bell'=>'<path d="M6 17V11a6 6 0 0 1 12 0v6l1.5 2h-15L6 17Z"/><path d="M10 21h4"/>',
'down'=>'<path d="m6 9 6 6 6-6"/>',
'arrow'=>'<path d="M5 12h14M13 6l6 6-6 6"/>',
'gift'=>'<rect x="3" y="8" width="18" height="4" rx="1"/><path d="M5 12v8h14v-8M12 8v12"/><path d="M12 8C10 3 6 4 7.5 6.5 8.5 8 12 8 12 8Zm0 0c2-5 6-4 4.5-1.5C15.5 8 12 8 12 8Z"/>',
'heart'=>'<path d="M12 20s-8-5-8-11a4.5 4.5 0 0 1 8-2.8A4.5 4.5 0 0 1 20 9c0 6-8 11-8 11Z"/>',
'mail'=>'<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 7 8.5 6 8.5-6"/>',
'edit'=>'<path d="M4 20h4L19 9l-4-4L4 16v4Z"/><path d="m13 7 4 4"/>',
'trash'=>'<path d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7V4h6v3"/>',
'refresh'=>'<path d="M20 11a8 8 0 0 0-14-4M4 13a8 8 0 0 0 14 4"/><path d="M5 3v4h4M19 21v-4h-4"/>',
'save'=>'<rect x="4" y="4" width="16" height="16" rx="2.5"/><path d="M4 10h16M10 4v16"/>',
'up'=>'<path d="M7 18a4.5 4.5 0 0 1-.5-9A6 6 0 0 1 18 9.5 4 4 0 0 1 17 18"/><path d="M12 12v7M9 14.5l3-3 3 3"/>',
'rupee'=>'<circle cx="12" cy="12" r="9"/><path d="M9 8h6M9 11h6M9.5 8c3.5 0 3.5 5 0 5H9l5 3.5"/>',
'doc'=>'<path d="M7 3h7l4 4v14H7V3Z"/><path d="M14 3v4h4M9.5 12h5M9.5 16h5"/>',
'ext'=>'<path d="M14 4h6v6M20 4l-9 9"/><path d="M18 14v5H5V6h5"/>',
'list'=>'<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4v3h6V4M9 12h6M9 16h6"/>'];
return '<svg class="ic" width="'.$s.'" height="'.$s.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">'.($p[$n]??'').'</svg>';}

/** One admin card (used on category.php and the bags list). $kind = 'cards' | 'bags' */
function adm_card($c,$kind,$back){global $st,$types;$bag=$kind==='bags';$k=($bag?'b':'c').$c['id'];$tok=$_SESSION['csrf']??'';
 ob_start();
 if(true){ ?><div class="cd big"><div class="im"><?php if(!empty($c['image'])): ?><img src="../<?=h($c['image'])?>" alt=""><?php else: ?><?=$c['icon']?><?php endif; ?></div><div class="bd2">
<span class="tg2"><?=$bag?'Gift bag':h($types[$c['type']][0]??$c['type'])?><?=!empty($c['code'])?' · '.h($c['code']):''?></span><h3><?=h($c['name'])?></h3>
<div class="ft"><span class="lkc" title="Likes"><?=ico('heart',13)?><?=(int)($st['likes'][$k]??0)?></span>
<div class="ib2"><a class="ib e2" href="dashboard.php?view=<?=$kind?>&edit=<?=$c['id']?>#form" title="Edit"><?=ico('edit',14)?></a>
<form method="post" action="dashboard.php" onsubmit="return confirm('Delete this <?=$bag?'bag':'card'?>?')"><input type="hidden" name="a" value="del"><input type="hidden" name="kind" value="<?=$kind?>"><input type="hidden" name="id" value="<?=$c['id']?>"><input type="hidden" name="back" value="<?=h($back)?>"><input type="hidden" name="csrf" value="<?=h($tok)?>"><button class="ib d2" type="submit" title="Delete"><?=ico('trash',14)?></button></form></div></div></div></div><?php return ob_get_clean();}
 ?><div class="cd"><div class="im"><?php if(!empty($c['image'])): ?><img src="../<?=h($c['image'])?>" alt=""><?php else: ?><?=$c['icon']?><?php endif; ?><span class="lk"><?=ico('heart',13)?><?=(int)($st['likes'][$k]??0)?></span></div><div class="bd2">
<?php if(!$bag): ?><span class="tg2"><?=h($types[$c['type']][0]??$c['type'])?></span><?php elseif(!empty($c['code'])): ?><span class="tg2"><?=h($c['code'])?></span><?php endif; ?>
<h3><?=h($c['name'])?></h3><?php if($bag): ?><p><?=h($c['desc'])?></p><div class="pr"><?=h($c['price'])?></div><?php else: ?><p></p><?php endif; ?>
<div class="bt"><a class="e" href="dashboard.php?view=<?=$kind?>&edit=<?=$c['id']?>#form"><?=ico('edit',15)?>Edit</a>
<form method="post" action="dashboard.php" onsubmit="return confirm('Delete this <?=$bag?'bag':'card'?>?')"><input type="hidden" name="a" value="del"><input type="hidden" name="kind" value="<?=$kind?>"><input type="hidden" name="id" value="<?=$c['id']?>"><input type="hidden" name="back" value="<?=h($back)?>"><input type="hidden" name="csrf" value="<?=h($tok)?>"><button class="d" type="submit"><?=ico('trash',15)?>Delete</button></form></div></div></div><?php return ob_get_clean();}
function adm_top($title,$on){global $st;$new=count(array_filter($st['events'],fn($e)=>empty($e['read']))); ?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=h($title)?> - ATHEN Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600&family=Cormorant+Garamond:ital,wght@0,500;0,600;1,500&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="assets/admin.css">
<style>
body{background:#f5f0e8;font-family:'Poppins','Segoe UI',sans-serif}
/* top navigation bar (replaces the old sidebar) */
.wrap{min-height:100vh;position:relative}
.tb{position:relative;display:flex;align-items:center;gap:26px;flex-wrap:wrap;padding:12px 34px;background:linear-gradient(90deg,#0a4a53,#0d5a5f 55%,#0a4a53);overflow:hidden;box-shadow:0 6px 20px rgba(5,46,54,.25)}
.tb:after{content:'';position:absolute;right:-40px;bottom:-70px;width:200px;height:110px;border-radius:50%;background:linear-gradient(135deg,#c4572e,#8e3a1c);opacity:.9;pointer-events:none}
.tb .logo{position:relative;z-index:1;display:flex;align-items:center;gap:12px;color:#fff}
.tb .logo svg{flex:none}
.tb .logo b{display:block;font-family:'Cinzel',serif;font-weight:600;font-size:26px;letter-spacing:.06em;line-height:1.05}
.tb .logo small{display:block;font-size:11.5px;color:#e9efef;opacity:.9;margin-top:2px}
.tb nav{position:relative;z-index:1;display:flex;align-items:center;gap:8px;flex-wrap:wrap}
.tb nav a{display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:10px;color:#fff;font-size:14.5px;font-weight:500;transition:.2s}
.tb nav a:hover{background:rgba(255,255,255,.12)}
.tb nav a.on{background:#c4572e;box-shadow:0 8px 18px rgba(196,87,46,.4)}
.tb nav a .bd{background:#c4572e;color:#fff;min-width:20px;height:20px;padding:0 5px;display:grid;place-items:center;border-radius:20px;font-size:11.5px}
.tb nav a.on .bd{background:#fff;color:#c4572e}
.tb .tg{position:relative;z-index:1;margin-left:auto;font-family:'Cormorant Garamond',serif;font-style:italic;font-size:21px;line-height:1.2;color:#fff;padding-left:18px;border-left:2px solid #f0cf8e;white-space:nowrap}
.tb .rt{position:relative;z-index:1;display:flex;align-items:center;gap:22px}
@media(max-width:1180px){.tb .tg{display:none}.tb .rt{margin-left:auto}}
@media(max-width:760px){.tb{padding:12px 16px;gap:12px}.tb nav{width:100%}.tb .rt{position:absolute;right:16px;top:14px}}
.tb .bl{position:relative;color:#fff;display:grid}.tb .bl i{position:absolute;right:-1px;top:-1px;width:9px;height:9px;border-radius:50%;background:#e8452c;border:2px solid #0b5159}
.tb .us{position:relative;display:flex;align-items:center;gap:12px;color:#fff}
.tb .av{width:38px;height:38px;border-radius:50%;background:#f3ece0;color:#0a4a53;display:grid;place-items:center;font-weight:600;font-size:17px}
.tb .us b{display:block;font-size:14px;font-weight:600;line-height:1.1}.tb .us small{font-size:11px;opacity:.8}
main{margin:0;padding:22px 32px 48px}
.btn{border-radius:10px}
.pills{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:22px}
.pills a{padding:8px 18px;border-radius:22px;background:#fbf8f3;border:1px solid #e6dfd3;font-size:12.5px;font-weight:500;color:#1d3a3e;box-shadow:0 2px 6px rgba(10,79,87,.06)}.pills a.on{background:#0b4f58;color:#fff;border-color:#0b4f58}
.uh{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;gap:12px;flex-wrap:wrap}.uh h2{margin:0;display:flex;align-items:center;gap:12px;font-size:21px;font-weight:600;color:#0b3f47}.uh h2 .ic{color:#0b6a6c}
.uh a.l{display:inline-flex;align-items:center;gap:8px;font-size:13px;color:#0b4f58;font-weight:500}
.uh a.ad{display:inline-flex;align-items:center;gap:8px;background:#c4572e;color:#fff;border-radius:10px;padding:10px 20px;font-size:13.5px;font-weight:600;box-shadow:0 8px 18px rgba(196,87,46,.3)}
.cg{display:grid;grid-template-columns:repeat(auto-fill,minmax(210px,1fr));gap:20px}
.cd{background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 4px 16px rgba(10,79,87,.1);transition:.25s;display:flex;flex-direction:column}.cd:hover{transform:translateY(-5px);box-shadow:0 14px 30px rgba(10,79,87,.2)}
.cd .im{position:relative;height:104px;display:grid;place-items:center;font-size:54px;overflow:hidden;background:linear-gradient(115deg,#0b5a5d 35%,#b9501f)}.cd .im img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
.cd .lk{position:absolute;top:10px;right:10px;display:inline-flex;align-items:center;gap:5px;background:#fff;border-radius:20px;padding:2px 10px;font-size:12px;font-weight:600;color:#1d3a3e}.cd .lk svg{color:#d9382a;fill:#d9382a}
.cd .bd2{padding:12px 14px 16px;display:flex;flex-direction:column;flex:1}
.cd .tg2{align-self:flex-start;background:#fbe3d9;color:#9e431f;font-size:11px;font-weight:500;padding:2px 10px;border-radius:20px;margin-bottom:8px}
.cd h3{margin:0 0 4px;font-size:15px;font-weight:600;line-height:1.45;color:#16363b}.cd p{margin:0;font-size:12px;color:#6f8a8d;line-height:1.5;flex:1}
.cd .pr{margin:8px 0 12px;font-size:18px;font-weight:700;color:#c4572e}
.cd .bt{display:flex;gap:8px}.cd .bt form{flex:1;margin:0;display:flex}.cd .bt>a,.cd .bt button{flex:1;display:inline-flex;align-items:center;justify-content:center;gap:6px;border:0;border-radius:8px;padding:9px 6px;font:inherit;font-size:13px;font-weight:500;color:#fff;cursor:pointer;transition:.2s}
.cd .e{background:#0e7c86}.cd .e:hover{background:#0a4f57}.cd .d{background:#c4572e}.cd .d:hover{background:#9e431f}
.cg.cgb{grid-template-columns:repeat(5,minmax(0,1fr));gap:20px;align-items:start}
@media(max-width:1100px){.cg.cgb{grid-template-columns:repeat(4,minmax(0,1fr))}}
@media(max-width:860px){.cg.cgb{grid-template-columns:repeat(3,minmax(0,1fr));gap:14px}}
@media(max-width:600px){.cg.cgb{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:400px){.cg.cgb{grid-template-columns:1fr}}
.cd.big{border-radius:18px;box-shadow:0 8px 24px rgba(10,79,87,.14)}.cd.big:hover{box-shadow:0 18px 38px rgba(10,79,87,.24)}
.cd.big .im{height:auto;aspect-ratio:4/5;display:block;background:linear-gradient(135deg,#0b5a5d 35%,#b9501f);font-size:80px;text-align:center;line-height:1}
.cd.big .im img{transition:transform .5s}.cd.big:hover .im img{transform:scale(1.04)}
.cd.big .bd2{padding:14px 16px 12px}
.cd.big h3{font-size:16px;margin:0 0 12px}
.cd.big .ft{display:flex;align-items:center;justify-content:space-between;margin-top:auto}
.lkc{display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:400;color:#8aa0a3}.lkc svg{color:#e3897c}
.ib2{display:flex;gap:6px}.ib2 form{margin:0}
.ib{width:28px;height:28px;border:0;border-radius:8px;display:grid;place-items:center;color:#fff;cursor:pointer;padding:0;transition:.2s}
.ib.e2{background:#0e7c86}.ib.e2:hover{background:#0a4f57}.ib.d2{background:#c4572e}.ib.d2:hover{background:#9e431f}
.nil{background:#fbf8f3;border-radius:16px;padding:34px;text-align:center;color:#6f8a8d;box-shadow:0 4px 16px rgba(10,79,87,.06)}
/* ===== MOBILE ONLY (phones) - desktop / laptop untouched ===== */
@media(max-width:700px){
.tb{padding:10px 14px 12px;gap:10px 12px}
.tb .logo{gap:10px}.tb .logo svg{width:38px;height:34px}.tb .logo b{font-size:22px}.tb .logo small{font-size:11px}
.tb .rt{top:12px;right:14px;gap:14px}.tb .us>div,.tb .us>svg{display:none}.tb .av{width:34px;height:34px;font-size:15px}
.tb nav{order:3;width:100%;display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:6px}
.tb nav a{position:relative;flex-direction:column;justify-content:center;gap:4px;padding:8px 2px;font-size:12px;line-height:1.2;text-align:center}
.tb nav a svg{width:20px;height:20px}
.tb nav a .bd{position:absolute;top:2px;right:6px;min-width:17px;height:17px;font-size:10px;border:1.5px solid #0b5159}
main{padding:16px 14px 36px}
.pills{gap:8px;margin-bottom:16px}.pills a{padding:7px 14px;font-size:12px}
.uh{margin-bottom:14px}.uh h2{font-size:18px;gap:10px}.uh h2 .ic{width:20px;height:20px;flex:none}
.uh>div{width:100%;flex-wrap:wrap;justify-content:space-between;gap:10px 14px}
.uh a.ad{padding:9px 16px;font-size:13px}
.cg.cgb{grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
.cd.big{border-radius:14px}
.cd.big .bd2{padding:10px 10px 10px}.cd.big h3{font-size:13.5px;margin:0 0 10px;word-break:break-word}
.cd.big .tg2{font-size:10px;padding:2px 8px;margin-bottom:6px;max-width:100%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.cd .lk{top:8px;right:8px;font-size:11px;padding:1px 8px}
.top{flex-wrap:wrap;gap:10px}.top h1{font-size:22px}
.chips{gap:8px;margin-bottom:14px}.chips a{padding:6px 13px;font-size:12px}
.msg{padding:14px;margin-bottom:12px}
.mh{gap:6px 10px}.mh b{font-size:14px;min-width:0;overflow-wrap:anywhere}.mh time{margin-left:0;width:100%;order:3;font-size:11.5px}
.q{font-size:15px;overflow-wrap:anywhere}
.mb{gap:8px}.mb .btn.s{padding:8px 14px}
.panel{padding:18px 16px}.rank .rk{font-size:13.5px}
.toast{left:14px;right:14px;bottom:14px;font-size:13px}
}
</style></head><body>
<div class="wrap"><header class="tb"><div class="logo"><svg width="46" height="40" viewBox="0 0 46 40" fill="none" stroke="#f0cf8e" stroke-width="1.6" stroke-linejoin="round"><path d="M15 10 18 4l5 4 5-4 3 6" /><rect x="6" y="14" width="34" height="23" rx="3" fill="#fff" fill-opacity=".1"/><path d="m6 16 17 12L40 16"/></svg><div><b>ATHEN</b><small>Invitation Admin Panel</small></div></div>
<nav><a class="<?=$on==='cards'?'on':''?>" href="dashboard.php?view=cards"><?=ico('cards')?>Cards</a><a class="<?=$on==='bags'?'on':''?>" href="dashboard.php?view=bags"><?=ico('bag')?>Bags</a>
<a class="<?=$on==='msg'?'on':''?>" href="messages.php"><?=ico('msg')?>Messages<?php if($new): ?><span class="bd"><?=$new?></span><?php endif; ?></a><a href="logout.php"><?=ico('out')?>Logout</a></nav>
<div class="tg">Every Invitation Tells a Story</div>
<div class="rt"><span class="bl"><?=ico('bell',24)?><i></i></span><div class="us"><span class="av">A</span><div><b>Admin</b><small>Manager</small></div><?=ico('down',18)?></div></div></header>
<main>
<?php }
function adm_bot(){ ?></main><?php include __DIR__.'/footer.php'; ?></div><div class="toast" id="toast"></div><script>function toast(m){var t=document.getElementById('toast');t.textContent=m;t.style.display='block';setTimeout(function(){t.style.display='none'},2200)}</script></body></html><?php }