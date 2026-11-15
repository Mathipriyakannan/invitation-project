<?php require __DIR__.'/_lay.php';
$_SESSION['csrf']=$_SESSION['csrf']??bin2hex(random_bytes(16));
function go($u){header('Location: '.$u);exit;}
if(empty($_SESSION['schema_ok3'])&&($p0=db())){ensure_schema($p0);$_SESSION['schema_ok3']=1;$cards=db_cards();$bags=db_bags();}
function save_extras($p,$cid,$list,$kind='cards'){if(!$list)return;$T=$kind==='bags'?'bag_images':'card_images';$K=$kind==='bags'?'bag_id':'card_id';$q=$p->prepare("SELECT COALESCE(MAX(sort_no),0) FROM $T WHERE $K=?");$q->execute([$cid]);$n=(int)$q->fetchColumn();$i=$p->prepare("INSERT INTO $T($K,image,sort_no) VALUES(?,?,?)");foreach($list as $x)$i->execute([$cid,$x,++$n]);}
function safe_back($b,$d){return preg_match('/^(dashboard|category)\.php(\?[\w=&%-]*)?$/',(string)$b)?$b:$d;}
/* ---------- BACKEND: save / update / delete (MySQL) ---------- */
if($_SERVER['REQUEST_METHOD']==='POST'){
 $kind=(($_POST['kind']??'')==='bags')?'bags':'cards';$a=$_POST['a']??'';$id=(int)($_POST['id']??0);$dv='dashboard.php?view='.$kind;
 if(empty($_POST)&&(int)($_SERVER['CONTENT_LENGTH']??0)>0)go($dv.'&err='.urlencode('Upload too large for the server. Upload fewer / smaller photos at a time (php.ini: post_max_size, upload_max_filesize, max_file_uploads).'));
 if(!hash_equals($_SESSION['csrf'],(string)($_POST['csrf']??'')))go($dv.'&err='.urlencode('Session expired, please try again'));
 $p=db();if(!$p)go($dv.'&err='.urlencode('Database not connected. Start MySQL in XAMPP.'));
 ensure_schema($p);
 if($a==='del'&&$id){$r=$p->prepare("SELECT image,image_back FROM $kind WHERE id=?");$r->execute([$id]);[$im,$im2]=$r->fetch(PDO::FETCH_NUM)?:[null,null];
  $p->prepare("DELETE FROM $kind WHERE id=?")->execute([$id]);drop_image($im);drop_image($im2);
  {$XT=$kind==='bags'?'bag_images':'card_images';$XK=$kind==='bags'?'bag_id':'card_id';try{$q=$p->prepare("SELECT image FROM $XT WHERE $XK=?");$q->execute([$id]);foreach($q->fetchAll(PDO::FETCH_COLUMN) as $x)drop_image($x);$p->prepare("DELETE FROM $XT WHERE $XK=?")->execute([$id]);}catch(Throwable $e){}}
  $b=safe_back($_POST['back']??'',$dv);go($b.(strpos($b,'?')?'&':'?').'deleted=1');}
 if($a==='save'){
  $name=trim(mb_substr((string)($_POST['name']??''),0,200));$desc=trim(mb_substr((string)($_POST['desc']??''),0,2000));$price=max(0,(float)($_POST['price']??0)); /* cards and bags save only name (+type for cards), ID, front photo and back photo */
  $type=(string)($_POST['type']??'');$back=$dv.($kind==='cards'&&$type!==''?'&type='.urlencode($type):'').($id?'&edit='.$id:'');
  if($name==='')go($back.'&err='.urlencode('Please enter a name'));
  if($kind==='cards'&&!isset($types[$type]))go($back.'&err='.urlencode('Please choose an invitation type'));
  $mode=(($_POST['idmode']??'')==='manual')?'manual':'auto';$mcode=strtoupper(trim((string)($_POST['code']??'')));
  if($mode==='manual'){
   if(!preg_match('/^[A-Z0-9-]{1,10}$/',$mcode))go($back.'&err='.urlencode('ID can have only letters, numbers and - (max 10 characters)'));
   $q=$p->prepare("SELECT COUNT(*) FROM $kind WHERE code=? AND id<>?");$q->execute([$mcode,$id]);
   if($q->fetchColumn())go($back.'&err='.urlencode('The ID '.$mcode.' is already used by another '.($kind==='bags'?'bag':'card').'. Please type a different ID'));}
  [$img,$e]=save_image($_FILES['photo']??null);if($e)go($back.'&err='.urlencode($e));
  [$img2,$e2]=save_image($_FILES['photo2']??null);if($e2){drop_image($img);go($back.'&err='.urlencode($e2));}
  $hd=trim(mb_substr((string)($_POST['heading']??''),0,200));$sb=trim(mb_substr((string)($_POST['subtitle']??''),0,255));$ct=trim(mb_substr((string)($_POST['content']??''),0,4000)); /* optional book text (cards and bags) */
  $nx=[];$xe=null; /* extra book photos (cards and bags): any number of photos[] */
  if(!empty($_FILES['photos']['name'])&&is_array($_FILES['photos']['name'])){$F=$_FILES['photos'];
   foreach($F['name'] as $i=>$_n){[$xp,$xe]=save_image(['name'=>$_n,'tmp_name'=>$F['tmp_name'][$i]??'','error'=>$F['error'][$i]??UPLOAD_ERR_NO_FILE,'size'=>$F['size'][$i]??0]);if($xe)break;if($xp)$nx[]=$xp;}
   if($xe){drop_image($img);drop_image($img2);foreach($nx as $x)drop_image($x);go($back.'&err='.urlencode($xe));}}
  if($id){$r=$p->prepare("SELECT image,image_back,".($kind==='cards'?'type':'NULL').",code FROM $kind WHERE id=?");$r->execute([$id]);[$old,$old2,$oldt,$oldc]=$r->fetch(PDO::FETCH_NUM)?:[null,null,null,null];
   if($kind==='cards')$p->prepare('UPDATE cards SET code=?,type=?,name=?,heading=?,subtitle=?,content=?,image=COALESCE(?,image),image_back=COALESCE(?,image_back) WHERE id=?')->execute([$mode==='manual'?$mcode:(($oldc&&$oldt===$type)?$oldc:next_code($p,'cards',$type)),$type,$name,$hd?:null,$sb?:null,$ct?:null,$img,$img2,$id]);
   else $p->prepare('UPDATE bags SET code=?,name=?,heading=?,subtitle=?,content=?,image=COALESCE(?,image),image_back=COALESCE(?,image_back) WHERE id=?')->execute([$mode==='manual'?$mcode:($oldc?:next_code($p,'bags')),$name,$hd?:null,$sb?:null,$ct?:null,$img,$img2,$id]);
   if($img)drop_image($old);if($img2)drop_image($old2);
   {$XT=$kind==='bags'?'bag_images':'card_images';$XK=$kind==='bags'?'bag_id':'card_id';foreach((array)($_POST['rmx']??[]) as $rx){$rx=(int)$rx;if(!$rx)continue;$q=$p->prepare("SELECT image FROM $XT WHERE id=? AND $XK=?");$q->execute([$rx,$id]);$ri=$q->fetchColumn();if($ri){$p->prepare("DELETE FROM $XT WHERE id=?")->execute([$rx]);drop_image($ri);}}save_extras($p,$id,$nx,$kind);}
   go($kind==='cards'?'category.php?type='.urlencode($type).'&saved=1':$dv.'&saved=1');}
  if($kind==='cards'){$p->prepare('INSERT INTO cards(code,type,name,heading,subtitle,content,image,image_back) VALUES(?,?,?,?,?,?,?,?)')->execute([$mode==='manual'?$mcode:next_code($p,'cards',$type),$type,$name,$hd?:null,$sb?:null,$ct?:null,$img,$img2]);save_extras($p,(int)$p->lastInsertId(),$nx);}
  else{$p->prepare('INSERT INTO bags(code,name,heading,subtitle,content,image,image_back) VALUES(?,?,?,?,?,?,?)')->execute([$mode==='manual'?$mcode:next_code($p,'bags'),$name,$hd?:null,$sb?:null,$ct?:null,$img,$img2]);save_extras($p,(int)$p->lastInsertId(),$nx,'bags');}
  go($dv.'&saved=1');}
 go($dv);}
/* ---------- PAGE ---------- */
$view=(($_GET['view']??'')==='bags')?'bags':'cards';$sel=$_GET['type']??'';if($sel!==''&&!isset($types[$sel]))$sel='';
$edit=null;if(isset($_GET['edit'])){foreach($view==='bags'?$bags:$cards as $c)if($c['id']===(int)$_GET['edit'])$edit=$c;}
if($edit&&$view==='cards')$sel=$edit['type'];
$perType=[];foreach($cards as $c)$perType[$c['type']]=($perType[$c['type']]??0)+1;
$newc=count(array_filter($st['events'],fn($e)=>empty($e['read'])));
adm_top(ucfirst($view),$view); $nm=$view==='bags'?'bag':'card';
$nextc=[];if($pp=db()){if($view==='bags')$nextc['_']=next_code($pp,'bags');else foreach($types as $k=>$t)$nextc[$k]=next_code($pp,'cards',$k);} ?>
<style>
.bn{position:relative;overflow:hidden;border-radius:20px;padding:30px 36px;min-height:150px;color:#fff;margin-bottom:22px;background:radial-gradient(circle at 88% 100%,rgba(196,87,46,.85) 0,transparent 34%),linear-gradient(110deg,#0b5159 0,#0a4a53 60%,#0b5a5d);box-shadow:0 12px 30px rgba(10,79,87,.22)}
.bn small{display:block;letter-spacing:.18em;font-size:12.5px;font-weight:500;color:#f0cf8e}
.bn h1{margin:8px 0 12px;font-family:'Cormorant Garamond',serif;font-weight:600;font-size:34px;line-height:1.1}
.bn p{margin:0;max-width:340px;font-size:13.5px;line-height:1.6;opacity:.92}
.bn .vw{position:absolute;right:34px;top:26px;z-index:2;display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border:1px solid rgba(255,255,255,.55);border-radius:8px;color:#fff;font-size:13px;background:rgba(255,255,255,.08)}
.bn svg.art{position:absolute;right:20px;bottom:0;height:100%;width:340px;pointer-events:none}
.st{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:24px}
.sc{position:relative;overflow:hidden;display:block;background:#fbf8f3;border-radius:16px;padding:18px 20px 16px;box-shadow:0 6px 20px rgba(10,79,87,.1);transition:.2s;min-height:128px}
.sc:hover{transform:translateY(-4px)}
.sc:before{content:'';position:absolute;right:-30px;top:-30px;width:150px;height:130px;border-radius:50%;background:#e1efec}.sc.o:before{background:#f9e6dc}
.sc .ci{position:relative;width:44px;height:44px;border-radius:50%;background:#0b6a6c;color:#fff;display:grid;place-items:center}.sc.o .ci{background:#c4572e}
.sc b{position:relative;display:block;font-family:'Cormorant Garamond',serif;font-size:36px;line-height:1.1;margin-top:8px;color:#0b5159}.sc.o b{color:#c4572e}
.sc span{position:relative;font-size:13px;color:#5f7a7d}
.sc .go{position:absolute;right:16px;bottom:16px;width:30px;height:30px;border-radius:50%;background:#0b6a6c;color:#fff;display:grid;place-items:center}.sc.o .go{background:#c4572e}
.pn{position:relative;overflow:hidden;background:#fbf8f3;border-radius:18px;padding:26px 28px 30px;box-shadow:0 6px 22px rgba(10,79,87,.08);margin-bottom:28px}
.pn:after{content:'';position:absolute;right:-50px;bottom:-60px;width:210px;height:170px;border-radius:50%;background:linear-gradient(135deg,#d46a3a,#b44a22);pointer-events:none}
.pn .hd{display:flex;align-items:center;gap:14px;margin-bottom:18px}.pn .hd i{width:34px;height:34px;border-radius:9px;background:#0b6a6c;color:#fff;display:grid;place-items:center}
.pn h2{margin:0;font-size:20px;font-weight:600;color:#0b3f47}.pn .hd small{display:block;color:#6f8a8d;font-size:12px;margin-top:2px}
.pn .fg{display:grid;grid-template-columns:1fr 1fr;gap:16px 24px;position:relative;z-index:1}.pn .fg .w{grid-column:1/-1}
.pn label{display:block;font-size:12.5px;font-weight:600;color:#0b3f47;margin:0 0 7px}
.fi{position:relative}.fi>.ic{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#c4572e;pointer-events:none}.fi.ta>.ic{top:20px;transform:none}
.pn input[type=text],.pn input[type=number],.pn select,.pn textarea{width:100%;border:1px solid #e3dccf;background:#fcfaf6;border-radius:10px;padding:12px 14px;font:inherit;font-size:13px;color:#1d3a3e}
.fi input,.fi textarea{padding-left:42px!important}
.pn input:focus,.pn select:focus,.pn textarea:focus{outline:0;border-color:#0e7c86;box-shadow:0 0 0 3px rgba(14,124,134,.14)}
.pn textarea{min-height:76px}
.idm{display:flex;gap:20px;margin:0 0 8px}.idm label{display:inline-flex;align-items:center;gap:6px;margin:0;font-weight:500;cursor:pointer}.idm input{accent-color:#c4572e}#code{text-transform:uppercase;letter-spacing:.04em}#code.auto{background:#f1efe9;color:#0a4f57;font-weight:600;cursor:default}
.two2{display:grid;grid-template-columns:1fr 1fr;gap:18px}.two2 .up input[type=file]{min-width:0}.sl{display:block;margin:0 0 6px;color:#0a4f57;font-weight:600;font-size:12.5px}.hint{margin:10px 0 0;color:#5f7a7d;font-size:12.5px;line-height:1.6}.hint b{color:#0a4f57}@media(max-width:900px){.two2{grid-template-columns:1fr}}
.xl{display:flex;flex-wrap:wrap;gap:12px;margin:0 0 14px}.xi{position:relative;width:84px;text-align:center}.xi img{display:block;width:84px;height:100px;object-fit:cover;border-radius:10px;border:1.5px solid #e3dccf}
.xi label{display:flex;align-items:center;justify-content:center;gap:5px;margin:6px 0 0;font-size:11.5px;font-weight:500;color:#9e431f;cursor:pointer}.xi input{accent-color:#c4572e;width:auto;margin:0;padding:0}
.xp{display:flex;flex-wrap:wrap;gap:10px;margin:12px 0 0}.xp img{width:64px;height:78px;object-fit:cover;border-radius:8px;border:1.5px dashed #0e7c86}
.up{display:flex;gap:14px;align-items:stretch}.pv{width:88px;height:100px;border:1.5px dashed #0e7c86;border-radius:12px;display:grid;place-content:center;justify-items:center;gap:4px;color:#5f7a7d;font-size:11px;overflow:hidden;flex:none;text-align:center;background:#fcfaf6}.pv img{width:88px;height:100px;object-fit:cover}.pv .ic{color:#0b6a6c}
.up input[type=file]{flex:1;align-self:center;border:1px solid #e3dccf;background:#fcfaf6;border-radius:10px;padding:10px 12px;font-size:13px;color:#1d3a3e}
.up input[type=file]::file-selector-button{border:1px solid #d6d0c4;background:#efebe3;border-radius:5px;padding:6px 12px;margin-right:10px;font:inherit;font-size:13px;cursor:pointer}
.ac{position:relative;z-index:1;margin-top:20px;display:flex;gap:12px}
.ac .b1,.ac .b2{display:inline-flex;align-items:center;gap:8px;padding:12px 26px;border-radius:10px;font:inherit;font-weight:600;font-size:14px;cursor:pointer;transition:.2s}
.ac .b1{border:0;background:#c4572e;color:#fff;box-shadow:0 8px 18px rgba(196,87,46,.3)}.ac .b1:hover{background:#9e431f}
.ac .b2{background:#fff;color:#0b4f58;border:1.5px solid #0e7c86}.ac .b2:hover{background:#e6f4f5}
.tl{display:flex;flex-wrap:wrap;justify-content:center;gap:22px}
.tile{position:relative;display:block;width:calc(20% - 18px);min-width:200px;background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 10px 26px rgba(10,79,87,.14);transition:.25s}.tile:hover{transform:translateY(-6px);box-shadow:0 18px 38px rgba(10,79,87,.24)}
/* picture area: uses the illustrated artwork from ../assets/img/types/<type>.jpg */
.tile .im{position:relative;height:165px;display:grid;place-items:center;overflow:hidden;background:linear-gradient(135deg,#0b5a5d,#1b7c78 65%,#2b8c85) center/cover no-repeat}
.tile.o .im{background:linear-gradient(135deg,#c4572e,#a8461f 70%,#8e3a1c) center/cover no-repeat}
.tile .im.pic{background-size:cover;background-position:center top}
.tile .im:after{content:'';position:absolute;left:-12%;right:-12%;bottom:-34px;height:56px;background:#fff;border-radius:50% 50% 0 0/100% 100% 0 0}
.tile .im.nopic:before{content:'';position:absolute;left:50%;top:48%;width:150px;height:150px;transform:translate(-50%,-50%);border-radius:50%;background:radial-gradient(circle,rgba(255,226,170,.55) 0,transparent 68%)}
.tile .em{position:relative;z-index:1;font-size:66px;line-height:1;margin-bottom:12px;filter:drop-shadow(0 6px 8px rgba(0,0,0,.28))}
.tile .lk{position:absolute;z-index:2;top:12px;right:12px;display:inline-flex;align-items:center;justify-content:center;gap:6px;min-width:56px;height:32px;background:#fff;border-radius:20px;padding:0 14px;font-size:13px;font-weight:700;color:#1d3a3e;box-shadow:0 3px 8px rgba(0,0,0,.15)}.tile .lk svg{position:static;width:14px;height:14px;fill:#f08a5d;stroke:none}
.tile .bd3{padding:0 18px 18px;position:relative}
.tile .bd3:before{content:'';position:absolute;left:0;bottom:0;width:46px;height:46px;background:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M2 22C2 12 8 4 20 2c0 12-6 19-18 20Z' fill='%232f8f8c'/%3E%3C/svg%3E") no-repeat left bottom/contain;opacity:.9;pointer-events:none}
.tile.o .bd3:before{background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M2 22C2 12 8 4 20 2c0 12-6 19-18 20Z' fill='%23d4673a'/%3E%3C/svg%3E")}
.tile .tg3{display:inline-block;background:#2f8f8c;color:#fff;font-size:11px;font-weight:600;padding:3px 12px;border-radius:20px;margin-bottom:8px}.tile.o .tg3{background:#e0814f}
.tile b{display:block;font-family:'Cormorant Garamond',serif;font-size:25px;line-height:1.15;font-weight:600;color:#0b3f47}
.tile small{display:block;font-size:14px;color:#6f8a8d;margin:2px 0 8px;font-weight:400}
.tile p{margin:0 0 14px;font-size:12.5px;line-height:1.5;color:#5f7a7d;min-height:38px}
.tile .ft{position:relative;display:flex;align-items:center;justify-content:space-between;gap:8px}
.tile .ft em{white-space:nowrap;font-style:normal;background:#2f7f73;color:#fff;font-weight:700;font-size:12.5px;padding:5px 12px;border-radius:20px}.tile.o .ft em{background:#d4673a}
.tile .vb{white-space:nowrap;display:inline-flex;align-items:center;gap:8px;background:#0b3f47;color:#fff;font-size:13px;font-weight:600;padding:8px 14px;border-radius:20px}
.lh{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:6px 10px;margin:0 0 7px}.pn .lh label{margin:0}
.lg{display:inline-flex;gap:6px}.lg button{border:1px solid #e3dccf;background:#fcfaf6;color:#0b4f58;font:inherit;font-size:11.5px;font-weight:600;line-height:1.4;padding:3px 12px;border-radius:20px;cursor:pointer;transition:.2s}.lg button:hover{border-color:#0e7c86}.lg button.on{background:#c4572e;border-color:#c4572e;color:#fff}
.msgbar{margin:0 0 16px;padding:12px 16px;border-radius:12px;background:#fde8e1;color:#9e431f;border:1px solid #f1bba6;font-size:13.5px}
@media(max-width:1100px){.st{grid-template-columns:repeat(2,1fr)}.bn svg.art{opacity:.4}}
@media(max-width:700px){.pn .fg{grid-template-columns:1fr}.bn .vw{position:static;margin-top:14px}.bn svg.art{display:none}.st{grid-template-columns:1fr 1fr}}
/* ===== MOBILE ONLY (phones) - desktop / laptop untouched ===== */
@media(max-width:700px){
.bn{padding:22px 20px;min-height:0;margin-bottom:16px;border-radius:16px}.bn h1{font-size:28px;margin:6px 0 10px}.bn p{max-width:none;font-size:13px}.bn .vw{padding:8px 16px}
.st{gap:12px;margin-bottom:18px}
.sc{padding:14px 14px 12px;min-height:112px;border-radius:14px}.sc .ci{width:38px;height:38px}.sc b{font-size:30px;margin-top:6px}
.sc span{display:block;font-size:12px;padding-right:34px;line-height:1.35}.sc .go{width:26px;height:26px;right:12px;bottom:12px}
.pn{padding:20px 16px 24px;margin-bottom:22px;border-radius:16px}.pn .hd{gap:12px;margin-bottom:16px}.pn h2{font-size:18px}
.idm{flex-wrap:wrap;gap:8px 18px}.pn .idm input{width:auto;flex:none;padding:0;margin:0}.idm label{white-space:nowrap}
.up{flex-direction:column;align-items:flex-start;gap:10px}.up input[type=file]{flex:none;align-self:stretch;width:100%;min-width:0}
.ac{flex-wrap:wrap}.ac .b1,.ac .b2{flex:1 1 130px;justify-content:center;padding:12px 16px}
.tl{gap:12px}.tile{width:calc(50% - 6px);min-width:0;border-radius:16px}
.tile .im{height:120px}.tile .em{font-size:48px}.tile .lk{top:8px;right:8px;height:26px;min-width:0;padding:0 10px;font-size:12px}
.tile .bd3{padding:0 12px 14px}.tile b{font-size:19px}.tile small{font-size:12px;margin:2px 0 10px}.tile p{display:none}
.tile .tg3{font-size:10px;padding:2px 10px;max-width:100%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.tile .ft{flex-direction:column;align-items:stretch;gap:8px}.tile .ft em{text-align:center}.tile .vb{justify-content:center;padding:7px 10px;font-size:12.5px}
}
</style>
<section class="bn"><small>WELCOME BACK 👋</small><h1>Manage Your <?=$view==='bags'?'Gift Bags':'Invitation Cards'?></h1><p>Create, edit and manage your invitation cards, gift bags and customer messages — all in one place.</p>
<a class="vw" href="../index.php" target="_blank">View Website <?=ico('ext',15)?></a>
<svg class="art" viewBox="0 0 340 160" fill="none"><g transform="rotate(-14 200 90)"><rect x="140" y="52" width="130" height="86" rx="8" fill="#fbeedd"/><path d="m140 58 65 46 65-46" stroke="#e2b772" stroke-width="2"/><path d="m140 138 48-40M270 138l-48-40" stroke="#ead9c0" stroke-width="2"/></g><path d="M207 96c-9-9-4-20 5-17 4 1 6 4 7 6 1-2 4-5 8-6 9-3 14 8 5 17l-13 12Z" fill="#c4572e"/>
<path d="M90 150C86 110 100 70 125 40" stroke="#126a6d" stroke-width="2"/><g fill="#12706f"><path d="M125 40c-18 12-22 34-10 52 20-10 24-32 10-52Z"/><path d="M104 96c-20 0-34 14-38 34 22 0 36-12 38-34Z"/></g><g fill="#c4572e"><path d="M300 40c-18-6-34 4-38 22 20 2 34-6 38-22Z"/><path d="M96 84c14-14 30-14 42-4-12 16-30 18-42 4Z" fill="#a8461f"/></g><path d="M300 150c4-30-6-60-26-80" stroke="#126a6d" stroke-width="2"/><path d="M274 70c-14-10-12-30 2-40 12 12 12 30-2 40Z" fill="#0f6064"/></svg></section>
<div class="st"><a class="sc" href="?view=cards"><div class="ci"><?=ico('cards',22)?></div><b><?=count($cards)?></b><span>Invitation cards</span><i class="go"><?=ico('arrow',16)?></i></a>
<a class="sc o" href="?view=bags"><div class="ci"><?=ico('gift',22)?></div><b><?=count($bags)?></b><span>Gift bags</span><i class="go"><?=ico('arrow',16)?></i></a>
<div class="sc"><div class="ci"><?=ico('heart',22)?></div><b><?=array_sum($st['likes'])?></b><span>Total likes</span><i class="go"><?=ico('arrow',16)?></i></div>
<a class="sc o" href="messages.php"><div class="ci"><?=ico('mail',22)?></div><b><?=$newc?></b><span>New messages</span><i class="go"><?=ico('arrow',16)?></i></a></div>
<?php if($view==='cards'): ?><div class="pills"><a class="on" href="category.php">All</a>
<?php foreach($types as $k=>$t): ?><a href="category.php?type=<?=$k?>"><?=h($t[0])?></a><?php endforeach; ?><a href="dashboard.php?view=bags"><?=h($bagType[0])?></a></div><?php endif; ?>
<?php if(!empty($_GET['err'])): ?><div class="msgbar"><?=h($_GET['err'])?></div><?php endif; ?>
<form class="pn" id="form" method="post" enctype="multipart/form-data" action="dashboard.php?view=<?=$view?>"><input type="hidden" name="a" value="save"><input type="hidden" name="kind" value="<?=$view?>"><input type="hidden" name="id" value="<?=$edit?$edit['id']:0?>"><input type="hidden" name="csrf" value="<?=h($_SESSION['csrf'])?>">
<div class="hd"><i><?=ico('cards',20)?></i><div><h2><?=$edit?'Edit':'Add new'?> <?=$nm?><?=($edit&&!empty($edit['code']))?' · ID '.h($edit['code']):''?></h2><small><?=$edit?($view==='bags'?'Update the name, photos and book details, then save':'Update the type, title and photo, then save'):'Create a new '.($view==='bags'?'gift bag with name and photos':'invitation card with type, title and photo')?></small></div></div><div class="fg">
<?php if($view==='cards'): ?><div><label>Invitation type</label><select name="type" required><?php foreach($types as $k=>$t): ?><option value="<?=$k?>" <?=$sel===$k?'selected':''?>><?=h($t[0])?> (<?=h($t[1])?>)</option><?php endforeach; ?><option value="__bag"><?=h($bagType[0])?> (<?=h($bagType[1])?>) - Gift bag</option></select></div><?php endif; ?>
<div><div class="lh"><label for="nm"><?=$view==='bags'?'Bag name':'Card title'?></label><span class="lg" role="group" aria-label="Language"><button type="button" data-l="en">English</button><button type="button" data-l="ta">தமிழ்</button></span></div><div class="fi"><?=ico('cards',17)?><input type="text" name="name" id="nm" maxlength="200" placeholder="Enter name" value="<?=h($edit['name']??'')?>" required></div></div>
<div><label><?=$view==='bags'?'Bag ID':'Card ID'?></label>
<div class="idm"><label><input type="radio" name="idmode" value="auto" checked> Auto generate</label><label><input type="radio" name="idmode" value="manual"> Type manually</label></div>
<div class="fi"><?=ico('doc',17)?><input type="text" name="code" id="code" maxlength="10" placeholder="Type your own ID, e.g. B25" value="<?=h($edit['code']??'')?>" readonly class="auto"></div>
<p class="hint">Auto = the next free ID for the chosen type. Manual = your own ID (letters, numbers, -).</p></div>
<div class="w"><label><?=$view==='bags'?'Bag photos':'Card photos'?></label><div class="two2">
<div><small class="sl"><?=$view==='bags'?'Front photo':'Front page'?></small><div class="up"><div class="pv" id="pv"><?php if(!empty($edit['image'])): ?><img src="../<?=h($edit['image'])?>" alt=""><?php else: ?><?=ico('up',26)?>No image<?php endif; ?></div><input type="file" name="photo" accept="image/*" id="img"></div></div>
<div><small class="sl"><?=$view==='bags'?'Back photo (optional)':'Back page (optional)'?></small><div class="up"><div class="pv" id="pv2"><?php if(!empty($edit['image2'])): ?><img src="../<?=h($edit['image2'])?>" alt=""><?php else: ?><?=ico('up',26)?>No image<?php endif; ?></div><input type="file" name="photo2" accept="image/*" id="img2"></div></div></div>
<p class="hint"><b><?=$view==='bags'?'Front photo':'Front page'?></b> – the main picture; it is the one shown on the website <?=$nm?>.<br><b><?=$view==='bags'?'Back photo':'Back page'?></b> – optional second picture; it is shown together with the front when the visitor taps the view icon.</p></div>
<div class="w"><label>More photos for the View Book (optional)</label>
<?php if(!empty($edit['extras'])): ?><div class="xl"><?php foreach($edit['extras'] as $x): ?><div class="xi"><img src="../<?=h($x['image'])?>" alt=""><label><input type="checkbox" name="rmx[]" value="<?=(int)$x['id']?>"> Remove</label></div><?php endforeach; ?></div><?php endif; ?>
<div class="up"><div class="pv" id="pvx"><?=ico('up',26)?>Add photos</div><input type="file" name="photos[]" accept="image/*" id="imgx" multiple></div><div class="xp" id="xp"></div>
<p class="hint"><b>Any number of photos</b> for this <?=$nm==='bag'?'gift bag':'invitation'?> – select many at once (hold Ctrl / Shift) or save again later to add more. Visitors see the <?=$view==='bags'?'front photo, back photo':'front page, back page'?> and all these photos as pages of a book when they tap <b>View Book</b>.</p></div>
<div class="w"><label>Text for the View Book (all optional)</label></div>
<div><label for="hd">Heading</label><div class="fi"><?=ico('doc',17)?><input type="text" name="heading" id="hd" maxlength="200" placeholder="<?=$view==='bags'?'e.g. Thambula bag':'e.g. Marriage invitation'?>" value="<?=h($edit['heading']??'')?>"></div></div>
<div><label for="sb">Subtitle</label><div class="fi"><?=ico('doc',17)?><input type="text" name="subtitle" id="sb" maxlength="255" placeholder="<?=$view==='bags'?'e.g. A lovely return gift for your guests':'e.g. Join us to bless the couple'?>" value="<?=h($edit['subtitle']??'')?>"></div></div>
<div class="w"><label for="ct">Content</label><div class="fi ta"><?=ico('doc',17)?><textarea name="content" id="ct" maxlength="4000" placeholder="<?=$view==='bags'?'Size, material, colour, any message ...':'Date, time, venue, any message ...'?>"><?=h($edit['content']??'')?></textarea></div>
<p class="hint">If you fill any of these, the book shows one extra text page right after the front page. Leave them empty and only the photos are shown.</p></div>
</div>
<div class="ac"><button class="b1" type="submit"><?=ico('save',17)?>Save</button><?php if($edit): ?><a class="b2" href="dashboard.php?view=<?=$view?>"><?=ico('refresh',17)?>Cancel</a><?php else: ?><button class="b2" type="reset" onclick="pv.innerHTML=emp;if(window.pv2)pv2.innerHTML=emp2"><?=ico('refresh',17)?>Clear</button><?php endif; ?>
</div></form>
<?php if($view==='cards'): ?>
<div class="uh"><h2><?=ico('list',24)?>Uploaded cards (<?=count($cards)?>)</h2><a class="l" href="category.php">View all <?=ico('arrow',16)?></a></div>
<?php $dsc=['birthday'=>'Celebrate your special day with a beautiful invitation card.','earpiercing'=>'Make your little one shine with a traditional ear piercing ceremony.','housewarming'=>'Blessings for a new home and a new beginning.','wedding'=>'A beautiful invitation for your special day.','babyshower'=>'Celebrate the little one on the way with love.','opening'=>'Mark the beginning of a new journey.','welcome'=>'A warm welcome for your special guests.','thanks'=>'A little note of gratitude for your love and support.','personalized'=>'Invitations designed just the way you imagine them.','betrothal'=>'A graceful invitation for the betrothal ceremony.','baptism'=>'Welcome your little one with a blessed baptism invitation.','communion'=>'A beautiful invitation for the Holy Communion celebration.','puberty'=>'Traditional invitations for the puberty ceremony.','scroll'=>'Elegant scroll-style invitations, a special collection.'];
$lk=[];$minp=[];foreach($cards as $c){$lk[$c['type']]=($lk[$c['type']]??0)+(int)($st['likes']['c'.$c['id']]??0);$pv_=(float)($c['priceval']??0);if(!isset($minp[$c['type']])||$pv_<$minp[$c['type']])$minp[$c['type']]=$pv_;}$n=0; ?>
<div class="tl"><?php foreach($types as $k=>$t): $n++;$cnt=(int)($perType[$k]??0);
 $ps=in_array($k,['personalized','puberty'],true)&&is_file(__DIR__.'/../assets/img/cat-'.$k.'.jpg')?'cat-'.$k.'.jpg':'types/'.$k.'.jpg'; /* Personalized & Puberty use the same pictures as the website home page */
 $pic=file_exists(__DIR__.'/../assets/img/'.$ps); ?><a class="tile <?=$n%2?'':'o'?>" href="category.php?type=<?=$k?>"><div class="im <?=$pic?'pic':'nopic'?>"<?=$pic?' style="background-image:url(\'../assets/img/'.h($ps).'\')"':''?>><span class="lk"><?=ico('heart',14)?><?=(int)($lk[$k]??0)?></span><?php if(!$pic): ?><span class="em"><?=$t[2]?></span><?php endif; ?></div>
<div class="bd3"><span class="tg3"><?=h($t[0])?></span><b><?=h($t[0])?></b><small><?=h($t[1])?></small><p><?=h($dsc[$k]??'')?></p><div class="ft"><em><?=$cnt?> <?=$cnt===1?'card':'cards'?></em><span class="vb">View <?=ico('arrow',15)?></span></div></div></a><?php endforeach; $n++;$bl=0;foreach($bags as $bb)$bl+=(int)($st['likes']['b'.$bb['id']]??0); ?>
<a class="tile <?=$n%2?'':'o'?>" href="dashboard.php?view=bags"><div class="im pic" style="background-image:url('../assets/img/types/thamboolam.jpg')"><span class="lk"><?=ico('heart',14)?><?=$bl?></span></div>
<div class="bd3"><span class="tg3"><?=h($bagType[0])?></span><b><?=h($bagType[0])?></b><small><?=h($bagType[1])?></small><p>Beautiful return-gift bags for your guests.</p><div class="ft"><em><?=count($bags)?> <?=count($bags)===1?'bag':'bags'?></em><span class="vb">View <?=ico('arrow',15)?></span></div></div></a></div>
<?php else: ?>
<div class="uh"><h2><?=ico('list',24)?>Uploaded bags (<?=count($bags)?>)</h2></div>
<?php if(!$bags): ?><div class="nil">No bags yet. Use <b>Add new bag</b> to upload the first one.</div><?php else: ?><div class="cg cgb"><?php foreach(array_reverse($bags) as $c) echo adm_card($c,'bags','dashboard.php?view=bags'); ?></div><?php endif; ?>
<?php endif; ?>
<script>(function(){var NX=<?=json_encode($nextc)?>,cur=<?=json_encode($edit['code']??'')?>,ot=<?=json_encode($edit['type']??'')?>,c=document.getElementById('code'),f=document.getElementById('form'),ty=f.querySelector('select[name=type]');
function mode(){return f.querySelector('input[name=idmode]:checked').value}
function prev(){if(mode()!=='auto')return;var t=ty?ty.value:'_';c.value=(cur&&(!ty||t===ot))?cur:(NX[t]||'')}
function sync(){var m=mode()==='manual';c.readOnly=!m;c.classList.toggle('auto',!m);if(m){c.focus();c.select()}else prev()}
[].forEach.call(f.querySelectorAll('input[name=idmode]'),function(r){r.onchange=sync});
if(ty)ty.addEventListener('change',function(){if(ty.value==='__bag'){location.href='dashboard.php?view=bags#form';return}prev()});f.addEventListener('reset',function(){setTimeout(function(){c.readOnly=true;c.classList.add('auto');prev()},0)});prev();})();</script>
<script>var pv=document.getElementById('pv'),emp=pv.innerHTML;
document.getElementById('img').onchange=function(){var f=this.files[0];if(!f)return;var r=new FileReader();r.onload=function(e){pv.innerHTML='<img src="'+e.target.result+'">'};r.readAsDataURL(f)};
var pv2=document.getElementById('pv2'),emp2=pv2?pv2.innerHTML:'',i2=document.getElementById('img2');
if(i2)i2.onchange=function(){var f=this.files[0];if(!f)return;var r=new FileReader();r.onload=function(e){pv2.innerHTML='<img src="'+e.target.result+'">'};r.readAsDataURL(f)};
/* More photos: every pick is ADDED to the list (one by one or many at once), big photos are shrunk in the browser, each photo can be removed with the x */
var ix=document.getElementById('imgx'),xp=document.getElementById('xp');
if(ix&&window.DataTransfer){var dtx=new DataTransfer(),ks=[],pend=0,LIM=18,xc=document.createElement('div');xc.className='xc';xp.parentNode.insertBefore(xc,xp.nextSibling);
 var st=document.createElement('style');st.textContent='.xq{position:relative}.xq button{position:absolute;top:-7px;right:-7px;width:22px;height:22px;border-radius:50%;border:2px solid #fff;background:#c4572e;color:#fff;font-size:11px;line-height:1;padding:0;cursor:pointer}.xc{font-size:12.5px;font-weight:600;color:#0e7c86;margin:8px 0 0}.xc.w{color:#c4572e}';document.head.appendChild(st);
 function fk(f){return f.name+'|'+f.size+'|'+f.lastModified}
 function shrink(f){return new Promise(function(ok){if(f.size<1200000||!/^image\/(jpeg|png|webp)$/.test(f.type)){ok(f);return}var u=URL.createObjectURL(f),im=new Image();
  im.onload=function(){var w=im.naturalWidth,h=im.naturalHeight,k=Math.min(1,2000/Math.max(w,h)),c=document.createElement('canvas');c.width=Math.round(w*k);c.height=Math.round(h*k);var g=c.getContext('2d');g.fillStyle='#fff';g.fillRect(0,0,c.width,c.height);g.drawImage(im,0,0,c.width,c.height);URL.revokeObjectURL(u);
   c.toBlob(function(b){ok(!b||b.size>=f.size?f:new File([b],f.name.replace(/\.[^.]+$/,'')+'.jpg',{type:'image/jpeg',lastModified:f.lastModified}))},'image/jpeg',.88)};
  im.onerror=function(){URL.revokeObjectURL(u);ok(f)};im.src=u})}
 function draw(){xp.innerHTML='';[].forEach.call(dtx.files,function(f,i){var w=document.createElement('div'),im=document.createElement('img'),r=new FileReader(),b=document.createElement('button');w.className='xq';r.onload=function(e){im.src=e.target.result};r.readAsDataURL(f);
   b.type='button';b.textContent='\u2715';b.title='Remove';b.onclick=function(){var n=new DataTransfer();[].forEach.call(dtx.files,function(g,j){if(j!==i)n.items.add(g)});ks.splice(i,1);dtx=n;ix.files=dtx.files;draw()};w.appendChild(im);w.appendChild(b);xp.appendChild(w)});
  var n=dtx.files.length;xc.className='xc'+(n>LIM?' w':'');xc.textContent=n?(n+' photo'+(n>1?'s':'')+' selected - tap "Add photos" again to add more'+(n>LIM?'. The server takes about '+LIM+' photos per save: the first '+LIM+' will be saved now, add the rest by saving again.':'')):''}
 ix.onchange=function(){var fs=[].slice.call(ix.files);pend++;Promise.all(fs.map(shrink)).then(function(out){out.forEach(function(f,i){var k=fk(fs[i]);if(ks.indexOf(k)<0){ks.push(k);dtx.items.add(f)}});ix.files=dtx.files;draw();pend--})};
 var fm=document.getElementById('form');
 fm.addEventListener('submit',function(e){if(pend>0){e.preventDefault();toast('Photos are getting ready, please wait a moment');return}if(dtx.files.length>LIM){var n=new DataTransfer();[].slice.call(dtx.files,0,LIM).forEach(function(f){n.items.add(f)});ix.files=n.files}});
 fm.addEventListener('reset',function(){dtx=new DataTransfer();ks=[];pend=0;xp.innerHTML='';xc.textContent=''})}
var q=new URLSearchParams(location.search);if(q.get('saved'))toast('Saved successfully');if(q.get('deleted'))toast('Deleted successfully');</script>
<script>(function(){
var f=document.getElementById('form'),nm=document.getElementById('nm');if(!f||!nm)return;
var bs=[].slice.call(f.querySelectorAll('.lg button')),mode='',cur=null;
/* Tamil -> English (letters written the way they sound) */
var TC={'க':'k','ங':'ng','ச':'ch','ஞ':'nj','ட':'t','ண':'n','த':'th','ந':'n','ப':'p','ம':'m','ய':'y','ர':'r','ல':'l','வ':'v','ழ':'zh','ள':'l','ற':'r','ன':'n','ஜ':'j','ஷ':'sh','ஸ':'s','ஹ':'h'};
var TV={'ா':'aa','ி':'i','ீ':'ee','ு':'u','ூ':'oo','ெ':'e','ே':'e','ை':'ai','ொ':'o','ோ':'o','ௌ':'au'};
var TI={'அ':'a','ஆ':'aa','இ':'i','ஈ':'ee','உ':'u','ஊ':'oo','எ':'e','ஏ':'e','ஐ':'ai','ஒ':'o','ஓ':'o','ஔ':'au','ஃ':'h'};
function t2e(s){var o='',i=0,c,n,v;
 while(i<s.length){c=s.charAt(i);n=s.charAt(i+1);
  if(c==='க'&&n==='்'&&s.charAt(i+2)==='ஷ'){v=s.charAt(i+3);if(TV[v]){o+='ksh'+TV[v];i+=4}else if(v==='்'){o+='ksh';i+=4}else{o+='ksha';i+=3}continue}
  if(TC[c]){if(n==='்'){o+=TC[c];i+=2}else if(TV[n]){o+=TC[c]+TV[n];i+=2}else{o+=TC[c]+'a';i++}}
  else if(TI[c]){o+=TI[c];i++}
  else if(c>='௦'&&c<='௯'){o+=String(c.charCodeAt(0)-0xBE6);i++}
  else i++}
 return o}
/* English -> Tamil: Google transliteration first, built-in rules if offline */
var EC=[['zh','ழ'],['th','த'],['dh','த'],['ch','ச'],['sh','ஷ'],['ng','ங'],['nj','ஞ'],['kh','க'],['gh','க'],['bh','ப'],['ph','ப'],['k','க'],['g','க'],['c','க'],['s','ச'],['j','ஜ'],['t','ட'],['d','ட'],['n','ன'],['p','ப'],['b','ப'],['m','ம'],['y','ய'],['r','ர'],['l','ல'],['v','வ'],['w','வ'],['f','ப'],['h','ஹ'],['z','ழ'],['q','க'],['x','க்ஸ']];
var EV=[['aa','ா','ஆ'],['ee','ீ','ஈ'],['ii','ீ','ஈ'],['oo','ூ','ஊ'],['ai','ை','ஐ'],['au','ௌ','ஔ'],['ae','ே','ஏ'],['oa','ோ','ஓ'],['a','','அ'],['e','ெ','எ'],['i','ி','இ'],['o','ொ','ஒ'],['u','ு','உ']];
function pick(w,i,L){for(var k=0;k<L.length;k++)if(w.substr(i,L[k][0].length)===L[k][0])return L[k];return null}
function e2t(w){w=w.toLowerCase();var o='',i=0,c,v;
 while(i<w.length){v=pick(w,i,EV);
  if(v){o+=v[2];i+=v[0].length;continue}
  c=pick(w,i,EC);if(!c){i++;continue}if(i===0&&c[0]==='n')c=['n','ந'];
  i+=c[0].length;v=pick(w,i,EV);
  if(v){o+=c[1]+(v[0]==='a'&&i+1>=w.length?'ா':v[1]);i+=v[0].length}else o+=c[1]+'்'}
 return o}
function gt(w){var ctl=window.AbortController?new AbortController():null,t=setTimeout(function(){if(ctl)ctl.abort()},4000);
 return fetch('https://inputtools.google.com/request?text='+encodeURIComponent(w)+'&itc=ta-t-i0-und&num=1&cp=0&cs=1&ie=utf-8&oe=utf-8&app=test',ctl?{signal:ctl.signal}:{})
  .then(function(r){return r.json()}).then(function(j){clearTimeout(t);return(j&&j[0]==='SUCCESS'&&j[1][0][1][0])||e2t(w)})
  .catch(function(){clearTimeout(t);return e2t(w)})}
function conv(s,m){
 if(m==='en')return Promise.resolve(s.replace(/[\u0B80-\u0BFF]+/g,function(r){var o=t2e(r);return o.charAt(0).toUpperCase()+o.slice(1)}));
 var ws=s.match(/[A-Za-z]+/g);if(!ws)return Promise.resolve(s);
 var u=ws.filter(function(x,i){return ws.indexOf(x)===i});
 return Promise.all(u.map(gt)).then(function(r){var mp={};u.forEach(function(x,i){mp[x]=r[i]});return s.replace(/[A-Za-z]+/g,function(x){return mp[x]})})}
function wrong(s,m){return m==='ta'?/[A-Za-z]/.test(s):/[\u0B80-\u0BFF]/.test(s)}
function done(){cur=null;nm.style.opacity=''}
function run(m){if(cur)return cur;var s=nm.value;if(!s.trim()||!wrong(s,m))return Promise.resolve();
 nm.style.opacity='.6';
 cur=conv(s,m).then(function(o){if(nm.value===s)nm.value=o;done()},done);return cur}
bs.forEach(function(b){b.addEventListener('click',function(){mode=b.dataset.l;bs.forEach(function(x){x.classList.toggle('on',x===b)});run(mode)})});
nm.addEventListener('blur',function(){if(mode)run(mode)});
f.addEventListener('submit',function(e){if(mode&&wrong(nm.value,mode)){e.preventDefault();run(mode).then(function(){f.submit()})}});
f.addEventListener('reset',function(){mode='';bs.forEach(function(x){x.classList.remove('on')})});
})();</script>
<?php adm_bot(); ?>