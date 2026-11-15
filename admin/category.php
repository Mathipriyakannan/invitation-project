<?php require __DIR__.'/_lay.php';
$sel=$_GET['type']??'';if($sel!==''&&!isset($types[$sel]))$sel='';
$list=array_reverse(array_values(array_filter($cards,fn($c)=>$sel===''||$c['type']===$sel)));
$back='category.php'.($sel!==''?'?type='.$sel:'');
$title=$sel===''?'All Invitation Cards':$types[$sel][0].' Invitations';
adm_top('Cards','cards'); ?>
<div class="pills"><a class="<?=$sel===''?'on':''?>" href="category.php">All</a>
<?php foreach($types as $k=>$t): ?><a class="<?=$sel===$k?'on':''?>" href="category.php?type=<?=$k?>"><?=h($t[0])?></a><?php endforeach; ?><a href="dashboard.php?view=bags"><?=h($bagType[0])?></a></div>
<div class="uh"><h2><?=ico('list',24)?><?=h($title)?> (<?=count($list)?>)</h2>
<div style="display:flex;gap:18px;align-items:center"><a class="l" href="dashboard.php?view=cards"><?=ico('arrow',16)?> Back to dashboard</a><a class="ad" href="dashboard.php?view=cards<?=$sel!==''?'&type='.$sel:''?>#form">+ Add new card</a></div></div>
<?php if(!$list): ?><div class="nil">No cards in this category yet. Use <b>Add new card</b> to upload the first one.</div>
<?php else: ?><div class="cg cgb"><?php foreach($list as $c) echo adm_card($c,'cards',$back); ?></div><?php endif; ?>
<script>var q=new URLSearchParams(location.search);if(q.get('saved'))toast('Saved successfully');if(q.get('deleted'))toast('Deleted successfully');</script>
<?php adm_bot(); ?>