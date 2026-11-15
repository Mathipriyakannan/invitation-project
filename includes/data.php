<?php
// UI sample data. Later replace these arrays with database queries.
require_once __DIR__.'/config.php';require_once __DIR__.'/store.php';
function h($s){return htmlspecialchars((string)$s,ENT_QUOTES,'UTF-8');}
$shop='ஏதேன் அழைப்பிதழ்';
/* ===== 14 வகைகள் — கையால் எழுதிய ஆர்டர் பட்டியலின்படி (1 முதல் 14) =====
   1 சுய விருப்ப · 2 புதுமனை புகுவிழா · 3 நிச்சயதார்த்தம் · 4 திருமணம் · 5 வளைகாப்பு · 6 காதணி விழா · 7 ஞானஸ்நானம்
   8 பிறந்தநாள் · 9 புதுநன்மை · 10 பூப்புனித விழா · 11 திறப்பு விழா · 12 நன்றி · 13 சுருள் · 14 தாம்பூலம் பை (bags அட்டவணை) */
$types=['personalized'=>['Personalized','சுய விருப்ப','💌'],'housewarming'=>['House Warming','புதுமனை புகுவிழா','🏠'],'betrothal'=>['Betrothal','நிச்சயதார்த்தம்','💍'],'wedding'=>['Wedding','திருமணம்','💒'],'babyshower'=>['Baby Shower','வளைகாப்பு','🍼'],'earpiercing'=>['Ear Piercing','காதணி விழா','✨'],'baptism'=>['Baptism','ஞானஸ்நானம்','🕊️'],'birthday'=>['Birthday','பிறந்தநாள்','🎂'],'communion'=>['Holy Communion','புதுநன்மை','✝️'],'puberty'=>['Puberty Ceremony','பூப்புனித விழா','🌸'],'opening'=>['Opening Ceremony','திறப்பு விழா','🎀'],'thanks'=>['Thank You','நன்றி','💐'],'scroll'=>['Scroll','சுருள்','📜']];
/* 14-ஆவது வகை: தாம்பூலம் பை (அட்மினில் Bags பகுதி) */
$bagType=['Thamboolam Bag','தாம்பூலம் பை','🛍️'];
$themes=['wedding'=>['#6E0D4A','#A31670'],'birthday'=>['#A31670','#c24a95'],'housewarming'=>['#4d4d1a','#6B6B2B'],'babyshower'=>['#c24a95','#e08cbf'],'opening'=>['#6B6B2B','#9a9a4a'],'thanks'=>['#6E0D4A','#6B6B2B'],'earpiercing'=>['#A31670','#6B6B2B'],'personalized'=>['#8c2a66','#c24a95'],'betrothal'=>['#6E0D4A','#c24a95'],'baptism'=>['#8a6a1f','#c9a24b'],'communion'=>['#8a6a1f','#b8862c'],'puberty'=>['#a3185f','#e08cbf'],'scroll'=>['#6B6B2B','#b8862c']];
require_once __DIR__.'/db.php';
// cards & bags now come from MySQL (see includes/db.php)
$cards=db_cards();$bags=db_bags();
$st=store_load();
// key = c1 (card id 1) or b1 (bag id 1)
function find_item($key){global $cards,$bags;$k=$key[0]??'';$id=(int)substr($key,1);foreach($k==='b'?$bags:($k==='c'?$cards:[]) as $c)if($c['id']===$id)return $c;return null;}
// WhatsApp "I want this" button (opens chat with 9677479227 with the picture link + ID)
const WA_NUMBER='919677479227';
function wa_btn($c,$kind='c'){
 $base=((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')?'https':'http').'://'.($_SERVER['HTTP_HOST']??'localhost').rtrim(str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME']??'')),'/').'/';
 $what=$kind==='b'?'இந்த பரிசுப் பை':'இந்த அழைப்பிதழ்';
 $link=!empty($c['image'])?$base.'share.php?k='.$kind.$c['id']:''; /* share.php shows the original photo + ID as the WhatsApp link preview */
 $msg="வணக்கம்!\n".($kind==='b'?'இந்தப் பரிசுப் பை எங்களுக்குப் பொருத்தமாக உள்ளது.':'இந்த அழைப்பிதழ் எங்களுக்குப் பொருத்தமாக உள்ளது.')."\nஇதைப் பற்றி மேலும் அறிந்துகொள்ள விரும்புகிறேன்.\nவிவரங்களை அனுப்பவும்.\n".$c['name'].(!empty($c['code'])?' · ID : '.$c['code']:'').($link?"\n".$link:'');
 return '<a class="wa" href="https://wa.me/'.WA_NUMBER.'?text='.rawurlencode($msg).'" target="_blank" rel="noopener" title="WhatsApp" aria-label="WhatsApp"><svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg></a>';}
function card_html($c,$kind='c'){global $st,$types,$themes;
 $key=$kind.$c['id'];$n=(int)($st['likes'][$key]??0);
 $t=$kind==='b'?['#4d4d1a','#8c8c3d']:($themes[$c['type']]??['#6E0D4A','#A31670']);
 $lab=$kind==='b'?'பரிசுப் பை':$types[$c['type']][1];
 $idp=!empty($c['code'])?'<span style="display:inline-block;margin-top:6px;padding:2px 12px;border-radius:20px;background:var(--ol-l);color:var(--ol);border:1px dashed var(--ol);font-size:12px;font-weight:700;letter-spacing:.06em">ID : '.h($c['code']).'</span>':'';ob_start();if($kind==='c'){?>
<article class="card cv rv" data-key="<?=$key?>" data-name="<?=h($c['name'])?>" data-img1="<?=h($c['image']??'')?>" data-img2="<?=h($c['image2']??'')?>" style="--c1:<?=$t[0]?>;--c2:<?=$t[1]?>">
<div class="ph"><?php if(!empty($c['image'])): ?><img src="<?=h($c['image'])?>" alt="<?=h($c['name'])?>" style="width:100%;height:100%;object-fit:cover;display:block;border-radius:inherit"><?php else: ?><div class="fr"><i><?=$c['icon']?></i><span><?=h($c['name'])?></span></div><?php endif; ?></div>
<button class="lk seal" type="button" data-key="<?=$key?>" title="லைக்"><span>♡</span><em><?=$n?></em></button><?=wa_btn($c,$kind)?>
<?php if(!empty($c['image'])): ?><button class="ev" type="button" title="பார்க்க" aria-label="பார்க்க"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1.5 12S5.5 5 12 5s10.5 7 10.5 7-4 7-10.5 7S1.5 12 1.5 12Z"/><circle cx="12" cy="12" r="3"/></svg></button><?php endif; ?>
<div class="b"><small><?=h($lab)?></small><b><?=h($c['name'])?></b><?=$idp?></div></article>
<?php return ob_get_clean();}?>
<article class="card rv" data-key="<?=$key?>" data-name="<?=h($c['name'])?>" data-desc="<?=h($c['desc'])?>" data-price="<?=h($c['price'])?>" style="--c1:<?=$t[0]?>;--c2:<?=$t[1]?>">
<div class="ph"><?php if(!empty($c['image'])): ?><img src="<?=h($c['image'])?>" alt="<?=h($c['name'])?>" style="width:100%;height:100%;object-fit:cover;display:block;border-radius:inherit"><?php else: ?><div class="fr"><i><?=$c['icon']?></i><span><?=h($c['name'])?></span></div><?php endif; ?></div>
<button class="lk seal" type="button" data-key="<?=$key?>" title="லைக்"><span>♡</span><em><?=$n?></em></button><?=wa_btn($c,$kind)?>
<div class="b"><small><?=h($lab)?></small><b><?=h($c['name'])?></b><?=$idp?><p><?=h($c['desc'])?></p>
<div class="act"><em class="pr"><?=h($c['price'])?></em><button class="op" type="button">பார்க்க · செய்தி ➤</button></div></div></article>
<?php return ob_get_clean();}