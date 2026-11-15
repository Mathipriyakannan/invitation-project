<?php require __DIR__.'/_lay.php';
if($_SERVER['REQUEST_METHOD']==='POST'){$a=$_POST['a']??'';$id=$_POST['id']??'';
 store_update(function(&$d)use($a,$id){if($a==='del')$d['events']=array_values(array_filter($d['events'],fn($e)=>$e['id']!==$id));
  else foreach($d['events'] as &$e){if($a==='readall'||$e['id']===$id)$e['read']=true;}});
 header('Location: messages.php?f='.urlencode($_GET['f']??''));exit;}
$f=$_GET['f']??'';$ev=array_values(array_filter($st['events'],fn($e)=>$f===''||$e['type']===$f));
$top=$st['likes'];arsort($top);$top=array_slice($top,0,5,true);
adm_top('Messages','msg'); ?>
<div class="top"><h1>Likes &amp; Messages</h1><form method="post"><input type="hidden" name="a" value="readall"><button class="btn o s">Mark all as read</button></form></div>
<div class="two"><div>
<div class="chips"><a class="<?=$f===''?'on':''?>" href="messages.php">All</a><a class="<?=$f==='message'?'on':''?>" href="?f=message">💌 Messages</a><a class="<?=$f==='like'?'on':''?>" href="?f=like">❤ Likes</a></div>
<?php if(!$ev): ?><div class="panel empty">No entries yet. When customers like a card or send a message from the website, it will appear here.</div><?php endif; ?>
<?php foreach($ev as $e): $new=empty($e['read']);$tel=preg_replace('/\D/','',$e['phone']??'');if(strlen($tel)===10)$tel='91'.$tel; ?>
<div class="msg <?=$new?'new':''?>"><div class="mh"><span class="tag"><?=$e['type']==='like'?'❤ Liked':'💌 Message'?></span><b><?=h($e['item'])?></b><time><?=h(date('d M Y, h:i A',strtotime($e['time'])))?></time></div>
<?php if($e['type']==='message'): ?><p class="q">“<?=nl2br(h($e['message']))?>”</p><div class="who">— <?=h($e['name']?:'Guest')?><?php if(!empty($e['phone'])): ?> · 📞 <?=h($e['phone'])?><?php endif; ?></div><?php else: ?><div class="who">A visitor liked this item.</div><?php endif; ?>
<div class="mb"><?php if($tel): ?><a class="btn t s" target="_blank" href="https://wa.me/<?=h($tel)?>">WhatsApp</a> <a class="btn o s" href="tel:<?=h($tel)?>">Call</a> <?php endif; ?>
<?php if($new): ?><form method="post"><input type="hidden" name="a" value="read"><input type="hidden" name="id" value="<?=h($e['id'])?>"><button class="btn o s">Mark read</button></form><?php endif; ?>
<form method="post" onsubmit="return confirm('Delete this entry?')"><input type="hidden" name="a" value="del"><input type="hidden" name="id" value="<?=h($e['id'])?>"><button class="btn s">Delete</button></form></div></div>
<?php endforeach; ?></div>
<aside class="panel rank"><h2>🏆 Most liked</h2><?php if(!$top): ?><p class="mut">No likes yet</p><?php endif; foreach($top as $k=>$n): $it=find_item($k); if(!$it)continue; ?><div class="rk"><span><?=$it['icon']?> <?=h($it['name'])?></span><b>❤ <?=$n?></b></div><?php endforeach; ?></aside></div>
<?php adm_bot(); ?>
