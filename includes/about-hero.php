<?php /* எங்களைப் பற்றி — பேனர் (தனித்து இயங்கும் கோப்பு: CSS உள்ளேயே உள்ளது) */
global $pdo,$conn,$db,$mysqli;
require_once __DIR__.'/db.php';

/* ===== வலது பக்க ஸ்லைடு: admin பக்கம் upload செய்த அழைப்பிதழ்களின் FRONT படம் மட்டும் (back படம் வராது) =====
   எத்தனை அழைப்பிதழ் வந்தாலும் அவற்றின் front படங்கள் அடுத்தடுத்து வந்துகொண்டே இருக்கும்.
   உங்கள் DB-யில் பெயர்கள் வேறு என்றால் கீழே $ab_tables / $ab_front_cols பட்டியலில் மட்டும் மாற்றவும். */
$ab_tables=['cards','invitations','invitation_cards','products'];                       // அழைப்பிதழ் அட்டவணை (முதலில் கிடைப்பது எடுக்கப்படும்)
$ab_front_cols=['front_image','front_img','front_photo','front','image','photo','img','picture']; // FRONT படம் உள்ள column (back column இங்கே இல்லை)

if(!function_exists('ab_rows')){
 function ab_rows($h,$sql){
  if($h instanceof PDO){$s=@$h->query($sql);return $s?$s->fetchAll(PDO::FETCH_ASSOC):[];}
  if($h instanceof mysqli){$r=@$h->query($sql);return $r?$r->fetch_all(MYSQLI_ASSOC):[];}
  return [];
 }
}
$ab_h=null;foreach([$pdo??null,$conn??null,$db??null,$mysqli??null] as $x){if($x instanceof PDO||$x instanceof mysqli){$ab_h=$x;break;}}

$ab_cards=[];
if($ab_h){
 foreach($ab_tables as $t){
  $cols=[];foreach(ab_rows($ab_h,"SHOW COLUMNS FROM `$t`") as $r){$cols[]=$r['Field'];}
  if(!$cols)continue;
  $fc='';foreach($ab_front_cols as $c){if(in_array($c,$cols,true)){$fc=$c;break;}}
  if($fc==='')continue;
  $ord=in_array('id',$cols,true)?' ORDER BY `id` DESC':'';
  foreach(ab_rows($ab_h,"SELECT `$fc` AS f FROM `$t` WHERE `$fc` IS NOT NULL AND `$fc`<>''".$ord." LIMIT 40") as $r){
   $v=ltrim(str_replace('\\','/',(string)$r['f']),'/');
   foreach([$v,'uploads/'.$v] as $try){
    if(is_file(__DIR__.'/../'.$try)){$ab_cards[$try]=$try;break;}
   }
  }
  if($ab_cards)break;
 }
}
$ab_cards=array_values($ab_cards);

$ab_pil=[
 ['<path d="M12 2v5M10 4.5h4"/><path d="M12 7l6 5v9H6v-9z"/><path d="M10 21v-5h4v5"/>','தமிழ் பண்பாட்டின்<br>அழகு'],
 ['<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/>','சுய விருப்ப<br>வடிவமைப்பு'],
 ['<path d="M12 2l3 6.5 7 .8-5.2 4.8 1.5 7L12 17.5 5.7 21.1l1.5-7L2 9.3l7-.8z"/>','நம்பிக்கை மற்றும்<br>திறமையான சேவை'],
];
?>
<link href="https://fonts.googleapis.com/css2?family=Baloo+Thambi+2:wght@600;800&family=Mukta+Malar:wght@500;600;700;800&display=swap" rel="stylesheet">
<?php
/* வலது பக்கம் வந்து போகும் படங்கள்: admin upload செய்த அழைப்பிதழ்களின் front படங்கள் மட்டும்
   (ஒரு அழைப்பிதழும் இல்லையென்றால் மட்டும் banner1, banner2 காட்டும்) */
$ab_slides=$ab_cards?$ab_cards:['assets/img/banner1.png','assets/img/banner2.png'];
?>
<style>
/* ===== எங்களைப் பற்றி பேனர் (விருப்பம் B): இடது = எழுத்துகள், வலது = மெரூன் பின்னணியில் படங்கள் வந்து போகும் ===== */
.ab{position:relative;isolation:isolate;overflow:hidden;color:#FBEED0;padding:clamp(48px,6vw,90px) clamp(14px,3vw,40px);
 border-bottom:3px solid #E2B44F;box-shadow:inset 0 5px 0 #3A041D,inset 0 7px 0 #F3D995,inset 0 -5px 0 #3A041D,inset 0 -7px 0 #F3D995;
 background:radial-gradient(ellipse 50% 70% at 78% 50%,rgba(176,38,92,.45),transparent 72%),#52011F;
 font-family:'Mukta Malar','Noto Sans Tamil',sans-serif}
.ab *{box-sizing:border-box}
.ab h1,.ab p{margin:0;padding:0}
.ab a{text-decoration:none}
.ab-in{position:relative;z-index:2;max-width:1160px;margin:0 auto;display:grid;grid-template-columns:1.1fr .9fr;gap:clamp(24px,4vw,56px);align-items:center}
.ab-txt{text-align:left}
.ab-k{display:inline-flex;align-items:center;gap:12px;font:700 clamp(14px,1.5vw,20px)/1.4 'Mukta Malar',sans-serif;color:#F3D995;letter-spacing:.04em}
.ab-k::before,.ab-k::after{content:"";width:clamp(22px,4vw,56px);height:2px;background:linear-gradient(90deg,transparent,#E2B44F)}.ab-k::after{transform:scaleX(-1)}
.ab h1{margin-top:6px;font:800 clamp(36px,4.8vw,68px)/1.3 'Baloo Thambi 2','Mukta Malar',sans-serif;background:linear-gradient(#fff1b8,#e2b44f 55%,#b8862c);-webkit-background-clip:text;background-clip:text;color:transparent;-webkit-text-fill-color:transparent;filter:drop-shadow(0 4px 5px rgba(30,0,14,.55))}
.ab-orn{display:flex;align-items:center;justify-content:center;gap:12px;margin:6px auto 14px;max-width:420px}
.ab-orn::before,.ab-orn::after{content:"";flex:1;height:2px;background:linear-gradient(90deg,transparent,#E2B44F)}.ab-orn::after{transform:scaleX(-1)}
.ab-orn i{width:12px;height:12px;transform:rotate(45deg);background:linear-gradient(135deg,#F3D995,#B8862C);box-shadow:0 0 0 3px #52011F,0 0 0 4px #E2B44F}
.ab-lead{max-width:600px;font:600 clamp(16px,1.6vw,21px)/1.75 'Mukta Malar',sans-serif;color:#FFF3D6;text-shadow:0 2px 6px rgba(0,0,0,.55)}
.ab-pil{display:grid;grid-template-columns:repeat(3,1fr);gap:0;max-width:760px;margin:clamp(22px,3vw,34px) auto 0;padding-top:20px;border-top:1px solid rgba(243,217,149,.4)}
.ab-pil>div{display:flex;flex-direction:column;align-items:center;gap:9px;padding:0 10px}
.ab-pil>div+div{border-left:1px solid rgba(243,217,149,.35)}
.ab-pil .ic{display:flex;align-items:center;justify-content:center;width:50px;height:50px;border-radius:50%;background:radial-gradient(circle at 35% 30%,#8E9A3E,#4E5416);border:2px solid #E2B44F;box-shadow:0 0 0 3px rgba(226,180,79,.25)}
.ab-pil svg{width:24px;height:24px;stroke:#FFF3D6;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
.ab-pil .t{font:700 clamp(14px,1.3vw,17px)/1.45 'Mukta Malar',sans-serif;color:#FFF3D6;text-shadow:0 1px 4px rgba(0,0,0,.5)}
.ab-btns{display:flex;flex-wrap:wrap;justify-content:center;gap:14px;margin-top:clamp(22px,3vw,32px)}
.ab-btns a{padding:12px 30px;border-radius:99px;font:800 clamp(15px,1.4vw,18px)/1.4 'Mukta Malar',sans-serif;transition:transform .2s}
.ab-btns a:hover{transform:translateY(-2px)}
.ab-btns .g{background:linear-gradient(135deg,#FFE9A6,#E2B44F);color:#4a0a2a;box-shadow:0 10px 22px rgba(0,0,0,.3)}
.ab-btns .o{border:2px solid #E2B44F;color:#FFF3D6;background:rgba(58,4,29,.5)}
.ab-k::before{display:none}
.ab-orn{margin:6px 0 14px;max-width:320px}.ab-orn::before{display:none}
.ab-lead{margin:0!important}
.ab-pil{max-width:620px;margin-left:0;margin-right:0}
.ab-btns{justify-content:flex-start}
/* வலது: படம் வந்து போகும் சட்டம் */
.ab-vis{display:flex;justify-content:center}
.ab-frame{position:relative;width:min(100%,330px);aspect-ratio:3/4.1;padding:8px;border:3px solid #E2B44F;border-radius:8px;background:#3A041D;box-shadow:0 0 0 5px rgba(226,180,79,.25),0 22px 44px rgba(0,0,0,.45)}
.ab-show{position:relative;width:100%;height:100%;overflow:hidden;border-radius:4px;background:#3a0518}
.ab-sl{position:absolute;inset:0;margin:0;opacity:0;transform:translateX(40px) scale(1.04);transition:opacity .9s ease,transform 1.1s cubic-bezier(.2,.8,.2,1)}
.ab-sl.on{opacity:1;transform:none}
.ab-sl.out{opacity:0;transform:translateX(-40px) scale(.98)}
.ab-sl img{display:block;width:100%;height:100%;object-fit:cover}
@media(max-width:860px){
 .ab-in{grid-template-columns:1fr}
 .ab-vis{order:2}
 .ab-frame{width:min(300px,78vw)}
}
@media(max-width:700px){
 .ab-pil{grid-template-columns:1fr;gap:16px}.ab-pil>div+div{border-left:0;border-top:1px solid rgba(243,217,149,.3);padding-top:14px}
 .ab-pil>div{align-items:center;text-align:center}
 .ab-btns{justify-content:center}
}
@media(prefers-reduced-motion:reduce){.ab-sl{transition:none}}
</style>
<section class="ab" aria-label="எங்களைப் பற்றி">
 <div class="ab-in">
  <div class="ab-txt">
  <div class="ab-k">எங்களைப் பற்றி</div>
  <h1>எங்கள் சிறப்பு அம்சங்கள்</h1>
  <div class="ab-orn" aria-hidden="true"><i></i></div>
  <p class="ab-lead">உங்கள் வாழ்க்கையில் சிறப்பான தருணங்களை மறக்க முடியாத வகையில் அழகாக வடிவமைத்து எங்கள் அழைப்பிதழ்கள். உங்கள் நிகழ்வை மேலும் அர்த்தமுள்ளதாக மாற்ற எங்கள் சேவைகள் உங்களுடன்.</p>
  <div class="ab-pil">
   <?php foreach($ab_pil as $p): ?><div><span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><?= $p[0] ?></svg></span><span class="t"><?= $p[1] ?></span></div><?php endforeach; ?>
  </div>
  <div class="ab-btns"><a class="g" href="contact.php">இப்போது பதிவு செய்யவும்</a><a class="o" href="products.php">மேலும் விவரங்களுக்கு</a></div>
  </div>
  <div class="ab-vis" aria-hidden="true">
   <div class="ab-frame"><div class="ab-show">
    <?php foreach($ab_slides as $i=>$sl): ?><figure class="ab-sl<?= $i===0?' on':'' ?>"><img src="<?= htmlspecialchars($sl,ENT_QUOTES,'UTF-8') ?>" alt="" loading="lazy"></figure><?php endforeach; ?>
   </div></div>
  </div>
 </div>
</section>
<script>
(function(){var s=document.querySelectorAll('.ab .ab-sl');if(s.length<2)return;var n=0;
setInterval(function(){if(document.hidden)return;var o=s[n];o.classList.remove('on');o.classList.add('out');
setTimeout(function(){o.classList.remove('out');},1200);n=(n+1)%s.length;s[n].classList.add('on');},3200);})();
</script>