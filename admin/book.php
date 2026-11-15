<?php require __DIR__.'/_lay.php';
/* ===== Booklet (book) manager — opened from the "Book" button next to Save on the dashboard =====
   For one invitation type (Ear Piercing, Wedding ...) the admin uploads MANY pages.
   Every page = front image (main card, right side of the book) + optional back image
   + optional heading / subtitle / content (left side of the book, under the small images). */
$_SESSION['csrf']=$_SESSION['csrf']??bin2hex(random_bytes(16));
$p=db();if($p)ensure_booklet_table($p);
$sel=(string)($_GET['type']??($_POST['type']??''));if(!isset($types[$sel]))$sel=(string)array_key_first($types);
$me='book.php?type='.urlencode($sel);
function bgo($u){header('Location: '.$u);exit;}
/* one uploaded file out of an array-style input (photo[] / photo2[]) in the format save_image() expects */
function file_at($key,$i){if(!isset($_FILES[$key]['name'][$i]))return null;$f=$_FILES[$key];
 return ['name'=>$f['name'][$i],'tmp_name'=>$f['tmp_name'][$i]??'','error'=>$f['error'][$i]??UPLOAD_ERR_NO_FILE,'size'=>$f['size'][$i]??0];}
function cut($s,$n){return trim(mb_substr((string)$s,0,$n));}
function renumber($p,$type){$q=$p->prepare('SELECT id FROM booklet_pages WHERE type=? ORDER BY sort_no,id');$q->execute([$type]);$n=0;
 $u=$p->prepare('UPDATE booklet_pages SET sort_no=? WHERE id=?');foreach($q->fetchAll(PDO::FETCH_COLUMN) as $id)$u->execute([++$n,$id]);}

/* ---------- BACKEND ---------- */
if($_SERVER['REQUEST_METHOD']==='POST'){
 if(empty($_POST)&&(int)($_SERVER['CONTENT_LENGTH']??0)>0)bgo($me.'&err='.urlencode('Upload too large for the server. Upload fewer / smaller images at a time (see php.ini: post_max_size, upload_max_filesize).'));
 if(!hash_equals($_SESSION['csrf'],(string)($_POST['csrf']??'')))bgo($me.'&err='.urlencode('Session expired, please try again'));
 if(!$p)bgo($me.'&err='.urlencode('Database not connected. Start MySQL in XAMPP.'));
 $a=(string)($_POST['a']??'');$id=(int)($_POST['id']??0);

 if($a==='add'){
  $H=$_POST['h']??[];$S=$_POST['s']??[];$C=$_POST['c']??[];$rows=max(count($H),count($S),count($C));
  $mx=$p->prepare('SELECT COALESCE(MAX(sort_no),0) FROM booklet_pages WHERE type=?');$mx->execute([$sel]);$no=(int)$mx->fetchColumn();
  $ins=$p->prepare('INSERT INTO booklet_pages(type,sort_no,image,image_back,heading,subtitle,content) VALUES(?,?,?,?,?,?,?)');
  $ok=0;$skip=0;$errs=[];
  for($i=0;$i<$rows;$i++){
   $f1=file_at('photo',$i);$f2=file_at('photo2',$i);
   $has1=$f1&&$f1['error']!==UPLOAD_ERR_NO_FILE;$has2=$f2&&$f2['error']!==UPLOAD_ERR_NO_FILE;
   $txt=cut($H[$i]??'',200).cut($S[$i]??'',255).cut($C[$i]??'',4000);
   if(!$has1){if($has2||$txt!=='')$skip++;continue;} /* front image is a must */
   [$im,$e]=save_image($f1);if($e){$errs[]='Page '.($i+1).': '.$e;continue;}
   [$im2,$e2]=save_image($f2);if($e2){$errs[]='Page '.($i+1).' back: '.$e2;$im2=null;}
   $ins->execute([$sel,++$no,$im,$im2,cut($H[$i]??'',200)?:null,cut($S[$i]??'',255)?:null,cut($C[$i]??'',4000)?:null]);$ok++;}
  $q='&saved='.$ok;if($skip)$q.='&skip='.$skip;if($errs)$q.='&err='.urlencode(implode(' | ',$errs));
  bgo($me.$q);}

 if($a==='upd'&&$id){
  $r=$p->prepare('SELECT image,image_back FROM booklet_pages WHERE id=? AND type=?');$r->execute([$id,$sel]);$old=$r->fetch(PDO::FETCH_NUM);if(!$old)bgo($me);
  [$im,$e]=save_image($_FILES['photo']??null);if($e)bgo($me.'&err='.urlencode($e));
  [$im2,$e2]=save_image($_FILES['photo2']??null);if($e2){drop_image($im);bgo($me.'&err='.urlencode($e2));}
  $rm=!empty($_POST['rmback'])&&!$im2;
  $p->prepare('UPDATE booklet_pages SET heading=?,subtitle=?,content=?,image=COALESCE(?,image),image_back='.($rm?'NULL':'COALESCE(?,image_back)').' WHERE id=?')
    ->execute($rm?[cut($_POST['h']??'',200)?:null,cut($_POST['s']??'',255)?:null,cut($_POST['c']??'',4000)?:null,$im,$id]:[cut($_POST['h']??'',200)?:null,cut($_POST['s']??'',255)?:null,cut($_POST['c']??'',4000)?:null,$im,$im2,$id]);
  if($im)drop_image($old[0]);if($im2||$rm)drop_image($old[1]);
  bgo($me.'&updated=1');}

 if($a==='del'&&$id){
  $r=$p->prepare('SELECT image,image_back FROM booklet_pages WHERE id=? AND type=?');$r->execute([$id,$sel]);[$o1,$o2]=$r->fetch(PDO::FETCH_NUM)?:[null,null];
  $p->prepare('DELETE FROM booklet_pages WHERE id=? AND type=?')->execute([$id,$sel]);drop_image($o1);drop_image($o2);renumber($p,$sel);
  bgo($me.'&deleted=1');}

 if(($a==='up'||$a==='down')&&$id){
  renumber($p,$sel);$q=$p->prepare('SELECT id,sort_no FROM booklet_pages WHERE type=? ORDER BY sort_no');$q->execute([$sel]);$L=$q->fetchAll(PDO::FETCH_ASSOC);
  foreach($L as $k=>$r)if((int)$r['id']===$id){$j=$a==='up'?$k-1:$k+1;
   if(isset($L[$j])){$u=$p->prepare('UPDATE booklet_pages SET sort_no=? WHERE id=?');$u->execute([$L[$j]['sort_no'],$L[$k]['id']]);$u->execute([$L[$k]['sort_no'],$L[$j]['id']]);}break;}
  bgo($me.'&moved=1#pg'.$id);}
 bgo($me);}

/* ---------- PAGE ---------- */
$pages=$p?booklet_pages($sel):[];
$cnt=[];if($p){foreach($p->query('SELECT type,COUNT(*) n FROM booklet_pages GROUP BY type')->fetchAll() as $r)$cnt[$r['type']]=(int)$r['n'];}
$newc=count(array_filter($st['events'],fn($e)=>empty($e['read'])));
adm_top('Book','cards'); ?>
<style>
.bkp{position:relative;overflow:hidden;background:#fbf8f3;border-radius:18px;padding:26px 28px 30px;box-shadow:0 6px 22px rgba(10,79,87,.08);margin-bottom:28px}
.bkp:after{content:'';position:absolute;right:-50px;bottom:-60px;width:210px;height:170px;border-radius:50%;background:linear-gradient(135deg,#d46a3a,#b44a22);pointer-events:none}
.bkp .hd{display:flex;align-items:center;gap:14px;margin-bottom:6px}.bkp .hd i{width:34px;height:34px;border-radius:9px;background:#0b6a6c;color:#fff;display:grid;place-items:center;flex:none}
.bkp h2{margin:0;font-size:20px;font-weight:600;color:#0b3f47}.bkp .hd small{display:block;color:#6f8a8d;font-size:12px;margin-top:2px}
.bkp label,.bkp .sl,.pg label,.pg .sl{display:block;font-size:12.5px;font-weight:600;color:#0b3f47;margin:0 0 6px}.bkp .opt{font-weight:400;color:#6f8a8d}
.bkp input[type=text],.bkp textarea,.pg input[type=text],.pg textarea{width:100%;border:1px solid #e3dccf;background:#fcfaf6;border-radius:10px;padding:11px 13px;font:inherit;font-size:13px;color:#1d3a3e}
.bkp textarea,.pg textarea{min-height:74px;resize:vertical}
.bkp input:focus,.bkp textarea:focus,.pg input:focus,.pg textarea:focus{outline:0;border-color:#0e7c86;box-shadow:0 0 0 3px rgba(14,124,134,.14)}
.rw{position:relative;z-index:1;display:grid;grid-template-columns:auto 1fr;gap:18px 22px;background:#fff;border:1px solid #ebe3d3;border-radius:14px;padding:18px;margin-top:16px;box-shadow:0 3px 10px rgba(10,79,87,.06)}
.rw .no{position:absolute;left:-1px;top:-1px;background:#c4572e;color:#fff;font-weight:700;font-size:12px;padding:3px 12px;border-radius:14px 0 12px 0}
.rw .rm{position:absolute;right:10px;top:10px;width:28px;height:28px;border:0;border-radius:8px;background:#fbe3d9;color:#9e431f;font-size:16px;line-height:1;cursor:pointer}.rw .rm:hover{background:#c4572e;color:#fff}
.ups{display:flex;gap:14px;padding-top:12px}
.upb{width:150px}
.bkp label.pvb,.pg label.pvb,.pvb{position:relative;display:grid;margin:0;font-weight:400;place-content:center;justify-items:center;gap:4px;width:150px;height:190px;border:1.5px dashed #0e7c86;border-radius:12px;background:#fcfaf6;color:#5f7a7d;font-size:11px;overflow:hidden;text-align:center;cursor:pointer}
.pvb img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}.pvb .ic{color:#0b6a6c}
.upb input[type=file]{display:block;width:100%;margin-top:8px;font-size:11.5px}
.upb input[type=file]::file-selector-button{border:1px solid #d6d0c4;background:#efebe3;border-radius:5px;padding:5px 9px;margin-right:6px;font:inherit;font-size:12px;cursor:pointer}
.tx{display:grid;gap:12px;padding-top:12px;align-content:start}
.bar{position:relative;z-index:1;display:flex;flex-wrap:wrap;align-items:center;gap:12px;margin-top:20px}
.bb{display:inline-flex;align-items:center;gap:8px;padding:12px 24px;border-radius:10px;border:0;font:inherit;font-weight:600;font-size:14px;cursor:pointer;transition:.2s;text-decoration:none}
.bb.pr{background:#c4572e;color:#fff;box-shadow:0 8px 18px rgba(196,87,46,.3)}.bb.pr:hover{background:#9e431f}
.bb.dk{background:#0b4f58;color:#fff}.bb.dk:hover{background:#083a42}
.bb.ln{background:#fff;color:#0b4f58;border:1.5px solid #0e7c86}.bb.ln:hover{background:#e6f4f5}
.cn{font-size:12.5px;color:#5f7a7d}.cn.bad{color:#c4572e;font-weight:600}
.note{position:relative;z-index:1;margin:12px 0 0;color:#5f7a7d;font-size:12.5px;line-height:1.6}.note b{color:#0a4f57}
.msgbar{margin:0 0 16px;padding:12px 16px;border-radius:12px;background:#fde8e1;color:#9e431f;border:1px solid #f1bba6;font-size:13.5px}
.okbar{margin:0 0 16px;padding:12px 16px;border-radius:12px;background:#e3f3ee;color:#0b5a4a;border:1px solid #a8d8c9;font-size:13.5px}
.pl{display:grid;gap:18px}
.pg{display:grid;grid-template-columns:auto 1fr;gap:16px 22px;background:#fff;border-radius:16px;padding:16px;box-shadow:0 6px 20px rgba(10,79,87,.1);scroll-margin-top:90px}
.pg .no{align-self:start;background:#0b4f58;color:#fff;font-weight:700;font-size:12px;padding:3px 12px;border-radius:20px;grid-column:1/-1;justify-self:start}
.pg .pvb{width:120px;height:150px;cursor:default}.pg .upb{width:120px}
.pg .row2{display:flex;gap:14px}
.pg .acts{display:flex;flex-wrap:wrap;gap:8px;margin-top:4px;align-items:center}
.pg .acts button{border:0;border-radius:8px;padding:9px 16px;font:inherit;font-size:13px;font-weight:600;cursor:pointer;color:#fff}
.pg .acts .u{background:#0e7c86}.pg .acts .u:hover{background:#0a4f57}.pg .acts .d{background:#c4572e}.pg .acts .d:hover{background:#9e431f}
.pg .acts .m{background:#efebe3;color:#0b4f58;padding:9px 13px}.pg .acts .m:hover{background:#e0dacb}
.pg .chk{display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:500;margin:6px 0 0;color:#9e431f;cursor:pointer}
@media(max-width:900px){.rw,.pg{grid-template-columns:1fr}.ups,.pg .row2{flex-wrap:wrap}}
@media(max-width:700px){.bkp{padding:20px 16px 24px}.rw{padding:16px 12px}.pvb{width:128px;height:165px}.upb{width:128px}.bb{flex:1 1 140px;justify-content:center}}
</style>

<div class="uh"><h2><?=ico('cards',24)?>Booklet · <?=h($types[$sel][0])?> <span style="font-weight:400;color:#6f8a8d">(<?=h($types[$sel][1])?>)</span></h2>
<div style="display:flex;gap:18px;align-items:center;flex-wrap:wrap"><a class="l" href="dashboard.php?view=cards&type=<?=h($sel)?>"><?=ico('arrow',16)?> Back to dashboard</a><a class="l" href="../index.php" target="_blank">View website <?=ico('ext',15)?></a></div></div>

<div class="pills"><?php foreach($types as $k=>$t): ?><a class="<?=$sel===$k?'on':''?>" href="book.php?type=<?=h($k)?>"><?=h($t[0])?> (<?=(int)($cnt[$k]??0)?>)</a><?php endforeach; ?></div>

<?php if(!empty($_GET['err'])): ?><div class="msgbar"><?=h($_GET['err'])?></div><?php endif; ?>
<?php if(isset($_GET['skip'])&&(int)$_GET['skip']>0): ?><div class="msgbar"><?=(int)$_GET['skip']?> page(s) were skipped because they had no front image. (PHP also accepts only 20 files per save by default, so upload about 10 pages — front + back — at a time.)</div><?php endif; ?>
<?php if(isset($_GET['saved'])&&(int)$_GET['saved']>0): ?><div class="okbar"><?=(int)$_GET['saved']?> page(s) added to the <?=h($types[$sel][0])?> booklet.</div><?php endif; ?>

<form class="bkp" id="addf" method="post" enctype="multipart/form-data" action="<?=h($me)?>"><input type="hidden" name="a" value="add"><input type="hidden" name="type" value="<?=h($sel)?>"><input type="hidden" name="csrf" value="<?=h($_SESSION['csrf'])?>">
<div class="hd"><i><?=ico('up',20)?></i><div><h2>Add booklet pages</h2><small>Upload as many invitation images as you need for <?=h($types[$sel][0])?>. Each page has a front image, an optional back image and optional text.</small></div></div>
<div id="rows"></div>
<div class="bar"><button class="bb dk" type="button" id="addrow">+ Add page</button><button class="bb ln" type="button" id="many"><?=ico('cards',17)?>Select many images at once</button><input type="file" id="manyf" accept="image/*" multiple hidden>
<span class="cn" id="cn"></span></div>
<div class="bar" style="margin-top:14px"><button class="bb pr" type="submit"><?=ico('save',17)?>Save pages</button><button class="bb ln" type="button" id="clr"><?=ico('refresh',17)?>Clear</button></div>
<p class="note"><b>Front image</b> – required; it is the main card on the <b>right</b> side of the booklet.<br><b>Back image</b> – optional; shown beside it on the <b>left</b> page as a small image.<br><b>Heading / Subtitle / Content</b> – all optional; they appear below the small images on the left page.<br>Tip: use <b>Select many images at once</b> to pick all fronts together; one page is created for each picture. Each image must be under 5 MB.</p>
</form>

<div class="uh"><h2><?=ico('list',24)?>Booklet pages (<?=count($pages)?>)</h2></div>
<?php if(!$pages): ?><div class="nil">No pages yet for <?=h($types[$sel][0])?>. Until you add pages here, the website shows the default designed cards in the booklet.</div>
<?php else: ?><div class="pl"><?php foreach($pages as $k=>$g): ?>
<form class="pg" id="pg<?=$g['id']?>" method="post" enctype="multipart/form-data" action="<?=h($me)?>"><input type="hidden" name="type" value="<?=h($sel)?>"><input type="hidden" name="id" value="<?=$g['id']?>"><input type="hidden" name="csrf" value="<?=h($_SESSION['csrf'])?>">
<span class="no">Page <?=$k+1?></span>
<div class="row2"><div class="upb"><small class="sl">Front page</small><label class="pvb"><img src="../<?=h($g['image'])?>" alt=""></label><input type="file" name="photo" accept="image/*" data-pv></div>
<div class="upb"><small class="sl">Back page <span class="opt">(optional)</span></small><label class="pvb"><?php if(!empty($g['image_back'])): ?><img src="../<?=h($g['image_back'])?>" alt=""><?php else: ?><?=ico('up',24)?>No image<?php endif; ?></label><input type="file" name="photo2" accept="image/*" data-pv>
<?php if(!empty($g['image_back'])): ?><label class="chk"><input type="checkbox" name="rmback" value="1"> Remove back image</label><?php endif; ?></div></div>
<div class="tx">
<div><label>Heading <span class="opt">(optional)</span></label><input type="text" name="h" maxlength="200" value="<?=h($g['heading']??'')?>"></div>
<div><label>Subtitle <span class="opt">(optional)</span></label><input type="text" name="s" maxlength="255" value="<?=h($g['subtitle']??'')?>"></div>
<div><label>Content <span class="opt">(optional)</span></label><textarea name="c" maxlength="4000"><?=h($g['content']??'')?></textarea></div>
<div class="acts"><button class="u" type="submit" name="a" value="upd">Update</button><button class="m" type="submit" name="a" value="up" title="Move earlier" <?=$k===0?'disabled':''?>>↑</button><button class="m" type="submit" name="a" value="down" title="Move later" <?=$k===count($pages)-1?'disabled':''?>>↓</button><button class="d" type="submit" name="a" value="del" onclick="return confirm('Delete this page?')">Delete</button></div></div>
</form><?php endforeach; ?></div><?php endif; ?>

<script>
(function(){
var rows=document.getElementById('rows'),cn=document.getElementById('cn'),f=document.getElementById('addf'),MAXF=20;
var UP='<?=str_replace(["\r","\n","'"],["","","\\'"],ico('up',26))?>';
function row(){var d=document.createElement('div');d.className='rw';
 d.innerHTML='<span class="no"></span><button class="rm" type="button" title="Remove this page">×</button>'+
 '<div class="ups"><div class="upb"><small class="sl">Front page *</small><label class="pvb">'+UP+'No image</label><input type="file" name="photo[]" accept="image/*"></div>'+
 '<div class="upb"><small class="sl">Back page <span class="opt">(optional)</span></small><label class="pvb">'+UP+'No image</label><input type="file" name="photo2[]" accept="image/*"></div></div>'+
 '<div class="tx"><div><label>Heading <span class="opt">(optional)</span></label><input type="text" name="h[]" maxlength="200"></div>'+
 '<div><label>Subtitle <span class="opt">(optional)</span></label><input type="text" name="s[]" maxlength="255"></div>'+
 '<div><label>Content <span class="opt">(optional)</span></label><textarea name="c[]" maxlength="4000"></textarea></div></div>';
 rows.appendChild(d);return d}
function prev(inp){var pv=inp.parentNode.querySelector('.pvb'),fl=inp.files&&inp.files[0];
 if(!fl){pv.innerHTML=UP+'No image';return}
 var r=new FileReader();r.onload=function(e){pv.innerHTML='<img alt="">';pv.firstChild.src=e.target.result};r.readAsDataURL(fl)}
function count(){var rs=rows.querySelectorAll('.rw'),n=0,fl=0;
 [].forEach.call(rs,function(r,i){r.querySelector('.no').textContent='Page '+(i+1);
  [].forEach.call(r.querySelectorAll('input[type=file]'),function(x){if(x.files&&x.files.length)fl++})});
 n=rs.length;cn.textContent=n+' page(s) · '+fl+' file(s) selected (max '+MAXF+' per save)';cn.className='cn'+(fl>MAXF?' bad':'')}
function empty(r){var ok=true;[].forEach.call(r.querySelectorAll('input,textarea'),function(x){if(x.type==='file'?(x.files&&x.files.length):x.value)ok=false});return ok}
rows.addEventListener('change',function(e){if(e.target.type==='file')prev(e.target);count()});
rows.addEventListener('input',count);
rows.addEventListener('click',function(e){var b=e.target.closest('.rm');if(!b)return;b.parentNode.remove();if(!rows.children.length)row();count()});
document.getElementById('addrow').onclick=function(){row();count();rows.lastChild.scrollIntoView({behavior:'smooth',block:'center'})};
document.getElementById('clr').onclick=function(){rows.innerHTML='';row();count()};
/* many images at once: one page per picture (front image) */
var mf=document.getElementById('manyf');document.getElementById('many').onclick=function(){mf.click()};
mf.onchange=function(){var fl=[].slice.call(mf.files);if(!fl.length)return;
 var okdt=true;try{new DataTransfer()}catch(e){okdt=false}
 if(!okdt){alert('Your browser cannot add many images at once. Please use + Add page.');return}
 fl.forEach(function(file){var r=rows.lastElementChild;if(!r||!empty(r))r=row();
  var inp=r.querySelector('input[name="photo[]"]'),dt=new DataTransfer();dt.items.add(file);inp.files=dt.files;prev(inp)});
 mf.value='';count()};
/* previews for the existing pages (replace picture) */
[].forEach.call(document.querySelectorAll('input[data-pv]'),function(inp){inp.addEventListener('change',function(){prev(inp)})});
f.addEventListener('submit',function(e){var any=false;[].forEach.call(rows.querySelectorAll('input[name="photo[]"]'),function(x){if(x.files&&x.files.length)any=true});
 if(!any){e.preventDefault();alert('Please choose at least one front image.')}});
row();count();
var q=new URLSearchParams(location.search);if(q.get('updated'))toast('Page updated');if(q.get('deleted'))toast('Page deleted');if(q.get('moved'))toast('Order changed');
})();
</script>
<?php adm_bot(); ?>
