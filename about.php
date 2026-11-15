<?php
$page = 'about';
$nonav = true; // இந்தப் பக்கத்தில் பொதுவான நாவ்பாருக்குப் பதிலாக கீழே உள்ள சொந்த நாவ்பார்
include 'includes/header.php'; require_once __DIR__.'/includes/navbar.php';

/* ---------- ஐகான்கள் ---------- */
$ic = [
 'pen'=>'<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/>',
 'img'=>'<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/>',
 'card'=>'<rect x="2" y="5" width="20" height="14" rx="2"/><path d="M6 10h6M6 14h12"/>',
 'color'=>'<path d="M12 3a9 9 0 100 18c1.7 0 2.5-1 2.5-2.2 0-1.3-1-1.6-1-2.8 0-1 .8-1.5 1.8-1.5H18a3 3 0 003-3C21 7 17 3 12 3z"/><circle cx="7.5" cy="11" r="1"/><circle cx="10" cy="7" r="1"/><circle cx="15" cy="7" r="1"/>',
 'text'=>'<path d="M14 3H6a2 2 0 00-2 2v14a2 2 0 002 2h12a2 2 0 002-2V9z"/><path d="M14 3v6h6M8 13h8M8 17h5"/>',
 'truck'=>'<path d="M1 6h13v11H1z"/><path d="M14 10h5l3 3v4h-8z"/><circle cx="6" cy="18" r="2"/><circle cx="18" cy="18" r="2"/>',
 'coin'=>'<circle cx="12" cy="12" r="9"/><path d="M9 9.5c0-1 1.3-1.8 3-1.8s3 .8 3 1.8-1.3 1.6-3 2.2-3 1.2-3 2.3 1.3 1.8 3 1.8 3-.8 3-1.8M12 6v1.7M12 16.3V18"/>',
 'box'=>'<path d="M21 8l-9-5-9 5v8l9 5 9-5z"/><path d="M3 8l9 5 9-5M12 13v8"/>',
 'eye'=>'<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/>',
 'heart'=>'<path d="M20.8 5.6a5.5 5.5 0 00-7.8 0L12 6.7l-1-1.1a5.5 5.5 0 00-7.8 7.8L12 22l8.8-8.6a5.5 5.5 0 000-7.8z"/>',
 'star'=>'<path d="M12 2l3 6.5 7 .8-5.2 4.8 1.5 7L12 17.5 5.7 21.1l1.5-7L2 9.3l7-.8z"/>',
 'gift'=>'<rect x="3" y="8" width="18" height="4"/><path d="M12 8v13M5 12v9h14v-9"/><path d="M7.5 8a2.5 2.5 0 110-5C10 3 12 8 12 8s2-5 4.5-5a2.5 2.5 0 110 5"/>',
 'home'=>'<path d="M3 11l9-8 9 8"/><path d="M5 10v11h14V10M10 21v-6h4v6"/>',
 'cake'=>'<path d="M4 20h16v-7H4z"/><path d="M4 16c2 1.5 4 1.5 6 0s4-1.5 6 0 3 1 4 0M12 13V9"/>',
 'church'=>'<path d="M12 2v5M10 4.5h4"/><path d="M12 7l6 5v9H6v-9z"/><path d="M10 21v-5h4v5"/>',
 'ring'=>'<circle cx="12" cy="15" r="6"/><path d="M9 4l3 3 3-3-1.5-2h-3z"/>',
 'dove'=>'<path d="M3 13c3 1 6 0 8-3 1-1.5 3-2 5-1l5-4-1 6c-1 5-5 8-10 8-3 0-5-2-7-6z"/>',
];
function ed_icon($ic,$k){return '<svg viewBox="0 0 24 24" aria-hidden="true">'.$ic[$k].'</svg>';}

/* ---------- உள்ளடக்கம் ---------- */
$strip = [
 ['star','தரம்','தரமான காகிதம், தெளிவான அச்சு'],
 ['heart','நேர்த்தி','சிறு விவரங்களிலும் கவனம்'],
 ['coin','நியாயமான விலை','அனைவரும் வாங்கக்கூடிய விலை'],
];
$features = [
 ['pen','அழகான வடிவமைப்பு','உங்கள் மனதிற்குப் பிடித்த ஸ்டைலில் தனித்துவமான அழைப்பிதழ் வடிவமைப்பு.'],
 ['img','உயர்தர அச்சு','தெளிவான, கவர்ச்சியான படங்களுடன் துல்லியமான அச்சுப்பணி.'],
 ['card','பல்வேறு கார்டு வகைகள்','பாரம்பரியம், மாடர்ன், எலிகண்ட், பிரீமியம் ஸ்டைல்களில் கார்டுகள்.'],
 ['color','நிறங்களின் தனித்துவம்','உங்கள் விருப்பத்திற்கேற்ற வண்ணங்களில் அழகிய அழைப்பிதழ்கள்.'],
 ['text','சுய விருப்ப உரை','உங்கள் வாசகங்கள், பெயர்கள், நிகழ்வு விவரங்களை விரும்பியபடி அமைத்துத் தருகிறோம்.'],
 ['truck','குறித்த நேரத்தில் டெலிவரி','சொன்ன நேரத்தில் உங்கள் அழைப்பிதழ்களைப் பாதுகாப்பாக வழங்குகிறோம்.'],
 ['coin','மலிவான, நியாயமான விலை','எல்லாத் தரப்பினருக்கும் ஏற்ற விலையில் அழைப்பிதழ்களும் பரிசுப் பொருட்களும்.'],
 ['box','ஒரே இடத்தில் அனைத்தும்','அழைப்பிதழ் முதல் கிஃப்ட் பேக் வரை, எல்லாத் தேவைகளும் ஒரே இடத்தில்.'],
 ['eye','மாதிரி பார்த்து ஒப்புதல்','அச்சுக்கு முன் மாதிரியைப் பார்த்து, திருத்தங்கள் செய்து உறுதி செய்யலாம்.'],
];
$occasions = ['திருமணம்','நிச்சயதார்த்தம்','ஞானஸ்நானம்','புதுமனை புகுவிழா','பிறந்தநாள்','வளைகாப்பு','திருமண நாள்','ஆலயப் பிரதிஷ்டை'];
$products = [
 ['ring','திருமண அழைப்பிதழ்கள்','வாழ்வின் முக்கிய நாளுக்குப் பொருத்தமான கம்பீரமான அழைப்பிதழ்கள்.'],
 ['dove','நிச்சயதார்த்த அழைப்பிதழ்கள்','இரு குடும்பங்களின் மகிழ்ச்சியைச் சொல்லும் நேர்த்தியான வடிவமைப்புகள்.'],
 ['church','ஞானஸ்நானம் & ஆலய விழாக்கள்','ஞானஸ்நானம், ஆராதனை, ஆலயப் பிரதிஷ்டை போன்ற விழாக்களுக்கு.'],
 ['home','புதுமனை புகுவிழா','புதிய இல்லத்தின் ஆசீர்வாத விழாவை அழகாக அறிவிக்கும் அழைப்பிதழ்கள்.'],
 ['cake','பிறந்தநாள் & குடும்ப விழாக்கள்','பிறந்தநாள், திருமண நாள், வளைகாப்பு போன்ற விழாக்களுக்கு.'],
 ['gift','கிஃப்ட் பேக் & நினைவுப் பரிசுகள்','விருந்தினர்களுக்கு அன்புடன் வழங்க அழகிய பரிசுப் பைகள்.'],
];
$promises = [
 'தரமான காகிதம், தெளிவான அச்சு',
 'நியாயமான, வெளிப்படையான விலை',
 'குறித்த நேரத்தில் டெலிவரி',
 'மாதிரி பார்த்து ஒப்புதல்',
 'உங்கள் விருப்பப்படி வடிவமைப்பு',
 'அன்பான, மரியாதையான சேவை',
];
$steps = [
 ['வடிவமைப்பைத் தேர்ந்தெடுங்கள்','எங்களிடம் உள்ள கார்டு மாதிரிகளில் உங்களுக்குப் பிடித்ததைத் தேர்வு செய்யுங்கள்.'],
 ['விவரங்களை அளியுங்கள்','பெயர்கள், தேதி, இடம், வாசகங்களை எங்களிடம் தெரிவியுங்கள்.'],
 ['மாதிரியை உறுதி செய்யுங்கள்','தயாரான மாதிரியைப் பார்த்து, தேவையான திருத்தங்களைச் சொல்லுங்கள்.'],
 ['அச்சு & டெலிவரி','உறுதிக்குப் பின் தரமாக அச்சிட்டு, குறித்த நேரத்தில் சேர்க்கிறோம்.'],
];
$faq = [
 ['அச்சிடுவதற்கு முன் மாதிரியைப் பார்க்க முடியுமா?','முடியும். மாதிரியைப் பார்த்து, தேவையான திருத்தங்களைச் சொன்ன பிறகே அச்சுக்கு அனுப்புகிறோம்.'],
 ['எங்கள் வாசகங்களை நாங்களே கொடுக்கலாமா?','நிச்சயமாக. உங்கள் வாசகங்கள், பெயர்கள், விழா விவரங்களை நீங்கள் விரும்பியபடியே அமைத்துத் தருகிறோம்.'],
 ['கிஃப்ட் பேக்குகளையும் ஆர்டர் செய்யலாமா?','செய்யலாம். அழைப்பிதழுடன் சேர்த்து ஒரே இடத்தில் கிஃப்ட் பேக்குகளையும் நினைவுப் பரிசுகளையும் பெறலாம்.'],
 ['விலை எவ்வளவு இருக்கும்?','கார்டு வகை, வடிவமைப்பு, எண்ணிக்கையைப் பொறுத்து மாறும். நியாயமான விலையில் வழங்குகிறோம்; விவரங்களுக்குத் தொடர்புகொள்ளுங்கள்.'],
];
$cards = [
 ['card-1.jpg','அழைப்பிதழ் & பரிசுப் பை'],
 ['card-2.jpg','நினைவுப் பரிசுகள்'],
 ['card-3.jpg','மலர் வடிவமைப்பு அழைப்பிதழ்'],
 ['card-4.jpg','ராயல் கோல்டு அழைப்பிதழ்'],
];
/* ---------- 7 அழைப்பிதழ் கார்டுகள் (ஒன்றன் மேல் ஒன்றாக அடுக்கு) ----------
   முதலில் admin-ல் சேர்த்த கார்டுகள் (DB), பின் குறைந்தால் uploads படங்கள்; மொத்தம் 7 */
$deck = []; $deckSeen = [];
$deckAdd = function($img,$name) use (&$deck,&$deckSeen){
  if(count($deck)>=7 || !$img) return;
  $f = __DIR__.'/'.$img; if(!is_file($f)) return;
  $hash = md5_file($f); if(isset($deckSeen[$hash])) return;
  $deckSeen[$hash] = 1; $deck[] = [$img,$name];
};
try{ foreach(db_cards() as $dc) $deckAdd($dc['image'] ?? '', $dc['name'] ?? ''); }catch(Throwable $e){}
foreach([
  ['uploads/24fe72f0cb352908.jpg','எலிகண்ட் அழைப்பிதழ்'],
  ['uploads/7a2a7b1d115040a8.jpg','சேவ் தி டேட் அழைப்பிதழ்'],
  ['uploads/91bbb236bae40532.jpg','மலர் வடிவமைப்பு அழைப்பிதழ்'],
  ['uploads/cda3116012c6816d.jpg','பிறந்தநாள் அழைப்பிதழ்'],
  ['uploads/c994627bbb44abac.jpg','வளைகாப்பு அழைப்பிதழ்'],
  ['uploads/d0448fb66bd9efb4.jpg','வளைகாப்பு மலர் அழைப்பிதழ்'],
  ['uploads/da838beb708bb5b7.jpg','காதணி விழா அழைப்பிதழ்'],
] as $df) $deckAdd($df[0],$df[1]);
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=Mukta+Malar:wght@400;500;600;700;800&family=Noto+Serif+Tamil:wght@600;700;800&display=swap" rel="stylesheet">
<style>
/* எல்லா class-களும் "ed-" என்று தொடங்கும் — header CSS உடன் மோதாது */
.ed-page{--olive:#5B5F1C;--olive2:#3E4210;--olive3:#3E4210;--olive4:#5B5F1C;--maroon:#8F1456;--maroond:#6E0D43;--gold:#E2B44F;--goldl:#F3D995;
  --cream:#F8F0D9;--cream2:#FBEED0;--ivory:#FFF8E6;--beige:#F1E4BC;--blush:#F4E6C8;
  display:block;position:relative;width:100%;background:var(--cream);color:var(--olive2);
  font-family:'Mukta Malar','Noto Sans Tamil',sans-serif;font-size:17px;line-height:1.7;overflow:hidden}
.ed-page *,.ed-page *::before,.ed-page *::after{box-sizing:border-box}
.ed-page h1,.ed-page h2,.ed-page h3,.ed-page p,.ed-page ul{margin:0;padding:0}
.ed-page ul{list-style:none}
.ed-page h1,.ed-page h2,.ed-page h3{font-family:'Noto Serif Tamil','Mukta Malar',serif;line-height:1.4;font-weight:700}
.ed-in{display:block;max-width:1160px;margin:0 auto;padding:0 20px}
.ed-sec{display:block;position:relative;padding:clamp(48px,7vw,88px) 0}
.ed-page a{text-decoration:none}

/* தலைப்பு */
.ed-head{text-align:center;margin-bottom:clamp(28px,4vw,46px)}
.ed-head h2{font-size:clamp(26px,4.4vw,40px);color:var(--maroon)}
.ed-head p{max-width:640px;margin:10px auto 0;font-size:clamp(15px,2.2vw,18px)}
.ed-line{display:flex;align-items:center;justify-content:center;gap:12px;margin-top:12px;color:var(--gold);line-height:1;font-size:18px}
.ed-line::before,.ed-line::after{content:"";height:2px;width:clamp(44px,12vw,110px);background:linear-gradient(90deg,transparent,var(--gold))}
.ed-line::after{transform:scaleX(-1)}
.ed-dark .ed-head h2{color:var(--cream)}.ed-dark .ed-head p{color:var(--beige)}

/* ஐகான் */
.ed-ico{display:flex;align-items:center;justify-content:center;width:58px;height:58px;flex:0 0 58px;border-radius:50%;
  background:radial-gradient(circle at 35% 30%,var(--olive4),var(--olive3));border:3px solid var(--gold);box-shadow:0 0 0 4px var(--cream),0 8px 16px rgba(62,66,16,.38)}
.ed-ico svg{width:27px;height:27px;stroke:var(--cream);fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}

/* ===== 1. கிராண்ட் ஹீரோ ===== */
/* பின்னணி = அடர் மெரூன் #500921 + மெல்லிய ஜாலி/மண்டலா பேட்டர்ன் (நிறம் அதே) */
.ed-hero{display:block;position:relative;color:var(--cream);padding:clamp(48px,7vw,92px) 0 0;
  background:
   url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 48 48' fill='none' stroke='%23F3D995' stroke-opacity='.16' stroke-width='.8'%3E%3Ccircle cx='24' cy='24' r='24'/%3E%3Ccircle cx='0' cy='0' r='24'/%3E%3Ccircle cx='48' cy='0' r='24'/%3E%3Ccircle cx='0' cy='48' r='24'/%3E%3Ccircle cx='48' cy='48' r='24'/%3E%3Ccircle cx='24' cy='24' r='12'/%3E%3Ccircle cx='0' cy='0' r='12'/%3E%3Ccircle cx='48' cy='0' r='12'/%3E%3Ccircle cx='0' cy='48' r='12'/%3E%3Ccircle cx='48' cy='48' r='12'/%3E%3Cpath d='M24 0L48 24L24 48L0 24z'/%3E%3Ccircle cx='24' cy='24' r='3'/%3E%3C/svg%3E"),
   linear-gradient(#500921,#500921)}
.ed-hero::before{content:"";position:absolute;left:50%;bottom:-9px;width:15px;height:15px;transform:translateX(-50%) rotate(45deg);z-index:3;background:linear-gradient(135deg,var(--goldl),#B8862C);border:2px solid var(--maroond);box-shadow:0 0 0 1.5px var(--gold)}
.ed-hero::after{content:"";display:block;height:6px;margin-top:clamp(36px,5vw,60px);background:linear-gradient(90deg,var(--gold),var(--goldl),var(--gold))}
.ed-hgrid{display:grid;grid-template-columns:1.15fr .85fr;gap:clamp(24px,5vw,64px);align-items:center}
.ed-hero h1{font-size:clamp(34px,6.2vw,64px);font-weight:800;background:linear-gradient(180deg,#F9E39B,#E2B450 55%,#B8862C);-webkit-background-clip:text;background-clip:text;color:transparent;-webkit-text-fill-color:transparent;filter:drop-shadow(0 4px 6px rgba(30,0,14,.55))}
.ed-hsub{display:flex;align-items:center;gap:14px;margin-top:14px;color:#EBC864;font:600 clamp(16px,2.6vw,23px)/1.5 'Mukta Malar',sans-serif}
.ed-hsub::before{content:"";flex:0 0 clamp(26px,6vw,60px);height:2px;background:var(--gold)}
.ed-lead{margin-top:18px;max-width:600px;font-size:clamp(16px,2.3vw,19px);color:var(--cream2)}
.ed-btns{display:flex;flex-wrap:wrap;gap:14px;margin-top:28px}
.ed-btn{display:inline-block;padding:13px 32px;border-radius:50px;font-weight:700;font-size:17px;line-height:1.4;transition:transform .2s,box-shadow .2s}
.ed-btn:hover{transform:translateY(-2px)}
.ed-btn.g{background:linear-gradient(135deg,var(--goldl),var(--gold));color:var(--maroond);box-shadow:0 10px 22px rgba(0,0,0,.25)}
.ed-btn.o{border:2px solid var(--gold);color:var(--cream)}
.ed-btn.o:hover{background:rgba(251,238,208,.1)}

/* அழைப்பிதழ் ஸ்லைடு (ஒவ்வொன்றும் 2 வினாடி, தொடர் சுழற்சி) */
.ed-vis{display:block;width:100%;max-width:380px;margin:0 auto;padding:10px 7px}
.ed-show{position:relative;width:100%;aspect-ratio:4/5;border-radius:18px;overflow:hidden;background:var(--maroond);border:3px solid var(--gold);
  box-shadow:0 0 0 5px var(--maroond),0 0 0 7px var(--goldl),0 28px 50px rgba(0,0,0,.4)}
.ed-show::after{content:"";position:absolute;inset:9px;border:1px solid rgba(243,217,149,.75);border-radius:10px;pointer-events:none;z-index:5}
.ed-slide{position:absolute;inset:0;margin:0;opacity:0;animation:edFade 8s infinite}
.ed-slide img{position:absolute;left:0;top:0;width:100%;height:100%;display:block}
.ed-bg{object-fit:cover;filter:blur(16px) brightness(.85);transform:scale(1.15)}
.ed-fg{object-fit:contain;padding:22px 18px 54px;animation:edZoom 8s infinite;animation-delay:inherit}
.ed-slide figcaption{position:absolute;left:50%;bottom:20px;transform:translateX(-50%);z-index:4;white-space:normal;text-align:center;width:max-content;max-width:88%;overflow:visible;text-overflow:clip;overflow-wrap:anywhere;
  padding:6px 20px;border-radius:30px;background:linear-gradient(135deg,var(--maroon),var(--maroond));border:1.5px solid var(--goldl);color:var(--cream);font:700 15px/1.5 'Mukta Malar',sans-serif;box-shadow:0 6px 14px rgba(0,0,0,.35)}
.ed-dots{display:flex;justify-content:center;gap:8px;margin-top:22px}
.ed-dots span{display:block;width:10px;height:10px;border-radius:10px;background:rgba(243,217,149,.35);animation:edDot 8s infinite}
@keyframes edFade{0%{opacity:0}5%{opacity:1}25%{opacity:1}30%{opacity:0}100%{opacity:0}}
@keyframes edZoom{0%{transform:scale(1.05)}30%{transform:scale(1)}100%{transform:scale(1)}}
@keyframes edDot{0%,25%{width:30px;background:var(--goldl)}30%,100%{width:10px;background:rgba(243,217,149,.35)}}
@media(prefers-reduced-motion:reduce){
  .ed-slide,.ed-fg,.ed-dots span{animation:none}
  .ed-slide:first-child{opacity:1}
}

/* தூண் பட்டை */
.ed-strip{display:grid;grid-template-columns:repeat(3,1fr);margin-top:clamp(40px,6vw,70px);border-top:1px solid rgba(243,217,149,.45)}
.ed-strip>div{display:flex;gap:14px;align-items:center;padding:24px 18px}
.ed-strip>div+div{border-left:1px solid rgba(243,217,149,.45)}
.ed-strip .ed-ico{width:50px;height:50px;flex-basis:50px;background:radial-gradient(circle at 35% 30%,#7C8636,#3E4210);box-shadow:0 0 0 3px rgba(226,180,79,.28)}
.ed-strip h3{font-size:19px;color:#F1D27A}
.ed-strip p{font-size:15px;line-height:1.5;color:var(--beige)}

/* ===== 2. அம்சங்கள் ===== */
.ed-feat{background:linear-gradient(180deg,var(--ivory),var(--cream2))}
.ed-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.ed-card{display:block;position:relative;text-align:center;background:linear-gradient(180deg,#FFFCF0,var(--ivory));border:1.5px solid rgba(226,180,79,.7);border-radius:22px;
  padding:38px 24px 34px;box-shadow:0 12px 28px rgba(184,134,44,.20),inset 0 0 0 4px #FFFCF0,inset 0 0 0 5.5px rgba(226,180,79,.35);transition:transform .25s,box-shadow .25s,border-color .25s}
.ed-card::before{content:"";position:absolute;left:50%;top:-1.5px;width:96px;height:5px;transform:translateX(-50%);border-radius:0 0 8px 8px;background:linear-gradient(90deg,var(--gold),var(--goldl),var(--gold))}
.ed-card::after{content:"";position:absolute;left:50%;bottom:13px;width:7px;height:7px;transform:translateX(-50%) rotate(45deg);background:var(--gold);opacity:.85}
.ed-card:hover{transform:translateY(-6px);border-color:var(--gold);box-shadow:0 20px 40px rgba(110,13,67,.20),inset 0 0 0 4px #FFFCF0,inset 0 0 0 5.5px rgba(226,180,79,.55)}
.ed-card .ed-ico{width:68px;height:68px;flex-basis:68px;margin:0 auto 20px;transition:transform .25s;box-shadow:0 0 0 4px #FFF8E6,0 0 0 6px rgba(226,180,79,.6),0 10px 18px rgba(62,66,16,.32)}
.ed-card .ed-ico svg{width:30px;height:30px}
.ed-card:hover .ed-ico{transform:translateY(-2px) scale(1.07)}
.ed-card h3{font-size:20px;color:var(--maroon);margin-bottom:14px}
.ed-card h3::after{content:"";display:block;width:54px;height:2px;margin:10px auto 0;background:linear-gradient(90deg,transparent,var(--gold),transparent)}
.ed-card p{font-size:16px;line-height:1.75;margin-bottom:6px}

/* ===== 3. தயாரிப்புகள் ===== */
.ed-dark{background:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 48 48' fill='none' stroke='%23F3D995' stroke-opacity='.10' stroke-width='.8'%3E%3Ccircle cx='24' cy='24' r='24'/%3E%3Ccircle cx='0' cy='0' r='24'/%3E%3Ccircle cx='48' cy='0' r='24'/%3E%3Ccircle cx='0' cy='48' r='24'/%3E%3Ccircle cx='48' cy='48' r='24'/%3E%3Ccircle cx='24' cy='24' r='12'/%3E%3Ccircle cx='0' cy='0' r='12'/%3E%3Ccircle cx='48' cy='0' r='12'/%3E%3Ccircle cx='0' cy='48' r='12'/%3E%3Ccircle cx='48' cy='48' r='12'/%3E%3Cpath d='M24 0L48 24L24 48L0 24z'/%3E%3Ccircle cx='24' cy='24' r='3'/%3E%3C/svg%3E"),radial-gradient(circle at 12% 0,var(--olive4),transparent 55%),linear-gradient(160deg,var(--olive),var(--olive3));color:var(--cream)}
.ed-page .ed-chips{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;width:100%;max-width:920px;margin:0 auto 48px;padding:0}
.ed-chips li{display:flex;align-items:center;justify-content:center;text-align:center;min-height:48px;padding:8px 14px;border-radius:40px;border:1.5px solid var(--gold);
  background:rgba(251,238,208,.08);color:var(--beige);font-size:16px;font-weight:600;line-height:1.4}
.ed-tile{position:relative;display:flex;flex-direction:column;align-items:center;text-align:center;gap:18px;height:100%;padding:38px 24px 32px;border-radius:22px;
  background:linear-gradient(180deg,rgba(255,248,230,.11),rgba(255,248,230,.04));border:1.5px solid rgba(226,180,79,.75);box-shadow:0 14px 28px rgba(0,0,0,.22),inset 0 0 0 4px rgba(62,66,16,.35),inset 0 0 0 5.5px rgba(226,180,79,.22);transition:transform .25s,background .25s,border-color .25s}
.ed-tile::before{content:"";position:absolute;left:50%;top:-1.5px;width:96px;height:5px;transform:translateX(-50%);border-radius:0 0 8px 8px;background:linear-gradient(90deg,var(--gold),var(--goldl),var(--gold))}
.ed-tile:hover{transform:translateY(-6px);background:linear-gradient(180deg,rgba(255,248,230,.17),rgba(255,248,230,.07));border-color:var(--goldl)}
.ed-tile .ed-ico{width:66px;height:66px;flex-basis:66px;margin:0 auto;border-radius:19px;background:linear-gradient(135deg,var(--maroon),var(--maroond));box-shadow:0 0 0 4px rgba(251,238,208,.14),0 10px 18px rgba(0,0,0,.3)}
.ed-tile .ed-ico svg{width:29px;height:29px}
.ed-tile h3{font-size:20px;color:#F1D27A;margin-bottom:12px}
.ed-tile h3::after{content:"";display:block;width:54px;height:2px;margin:10px auto 0;background:linear-gradient(90deg,transparent,var(--gold),transparent)}
.ed-tile p{font-size:15.5px;line-height:1.75;color:var(--beige)}
.ed-note{display:block;margin:34px auto 0;max-width:860px;text-align:center;padding:20px 24px;border-radius:16px;background:#52011F;
  border:2px solid var(--gold);color:var(--cream);font-size:17px}
.ed-note b{color:var(--goldl)}

/* ----- அழைப்பிதழ் அடுக்கு (ஒன்றன் மேல் ஒன்றாக, தானாக மாறும்) ----- */
.ed-deckwrap{display:block;margin:0 auto 46px;padding-top:34px;text-align:center}
.ed-deck{position:relative;width:min(340px,80vw);aspect-ratio:4/5;margin:0 auto;cursor:pointer;touch-action:pan-y;-webkit-tap-highlight-color:transparent;outline-offset:10px}
.ed-dk{position:absolute;inset:0;margin:0;border-radius:18px;overflow:hidden;background:var(--maroond);border:3px solid var(--gold);
  box-shadow:0 0 0 4px var(--maroond),0 0 0 6px var(--goldl),0 22px 40px rgba(0,0,0,.4);transform-origin:50% 0;opacity:0;pointer-events:none;
  transition:transform .75s cubic-bezier(.22,.8,.3,1),opacity .75s ease;will-change:transform,opacity}
.ed-dk::before{content:"";position:absolute;inset:0;z-index:6;background:rgba(40,0,15,.38);opacity:1;transition:opacity .75s;pointer-events:none}
.ed-dk::after{content:"";position:absolute;inset:9px;border:1px solid rgba(243,217,149,.75);border-radius:10px;pointer-events:none;z-index:5}
.ed-dk img{position:absolute;left:0;top:0;width:100%;height:100%;display:block}
.ed-dkbg{object-fit:cover;filter:blur(16px) brightness(.85);transform:scale(1.15)}
.ed-dkfg{object-fit:contain;padding:22px 18px 54px}
.ed-dk figcaption{position:absolute;left:50%;bottom:20px;transform:translateX(-50%);z-index:4;white-space:normal;text-align:center;width:max-content;max-width:88%;overflow:visible;text-overflow:clip;overflow-wrap:anywhere;
  padding:6px 20px;border-radius:30px;background:linear-gradient(135deg,var(--maroon),var(--maroond));border:1.5px solid var(--goldl);color:var(--cream);font:700 15px/1.5 'Mukta Malar',sans-serif;box-shadow:0 6px 14px rgba(0,0,0,.35)}
.ed-dk[data-p="0"]{opacity:1;transform:none;z-index:9}
.ed-dk[data-p="0"]::before{opacity:0}
.ed-dk[data-p="1"]{opacity:1;transform:translateY(-14px) scale(.95);z-index:8}
.ed-dk[data-p="2"]{opacity:1;transform:translateY(-28px) scale(.90);z-index:7}
.ed-dk[data-p="3"]{opacity:.9;transform:translateY(-41px) scale(.85);z-index:6}
.ed-dk[data-p="4"],.ed-dk[data-p="5"],.ed-dk[data-p="6"]{opacity:0;transform:translateY(-41px) scale(.85);z-index:5}
.ed-dk.out{transform-origin:50% 100%;transform:translate(112%,-4%) rotate(12deg);opacity:0;z-index:10}
.ed-dk.nt{transition:none}
.ed-dkdots{display:flex;justify-content:center;gap:8px;margin-top:28px}
.ed-dkdots span{display:block;width:10px;height:10px;border-radius:10px;background:rgba(243,217,149,.35);transition:width .35s,background .35s}
.ed-dkdots span.on{width:30px;background:var(--goldl)}
.ed-dkhint{margin-top:12px;font-size:14px;color:var(--beige);opacity:.85}

/* ===== 4. வாக்குறுதி ===== */
.ed-prom{background:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 48 48' fill='none' stroke='%23B8862C' stroke-opacity='.14' stroke-width='.8'%3E%3Ccircle cx='24' cy='24' r='24'/%3E%3Ccircle cx='0' cy='0' r='24'/%3E%3Ccircle cx='48' cy='0' r='24'/%3E%3Ccircle cx='0' cy='48' r='24'/%3E%3Ccircle cx='48' cy='48' r='24'/%3E%3Ccircle cx='24' cy='24' r='12'/%3E%3Ccircle cx='0' cy='0' r='12'/%3E%3Ccircle cx='48' cy='0' r='12'/%3E%3Ccircle cx='0' cy='48' r='12'/%3E%3Ccircle cx='48' cy='48' r='12'/%3E%3Cpath d='M24 0L48 24L24 48L0 24z'/%3E%3Ccircle cx='24' cy='24' r='3'/%3E%3C/svg%3E"),var(--blush)}
.ed-pgrid{display:grid;grid-template-columns:.9fr 1.1fr;gap:clamp(24px,4vw,48px);align-items:stretch}
.ed-quote{display:flex;flex-direction:column;justify-content:center;padding:clamp(28px,4vw,48px);border-radius:24px;color:var(--cream);text-align:center;
  background:#52011F;border:2px solid var(--gold);box-shadow:0 0 0 6px var(--blush),0 0 0 8px var(--gold)}
.ed-quote b{display:block;font:800 60px/0.8 'Noto Serif Tamil',serif;color:var(--goldl)}
.ed-quote h2{font-size:clamp(24px,3.6vw,34px);color:var(--cream);margin:14px 0 10px}
.ed-quote p{color:var(--beige);font-size:17px}
.ed-list{display:grid;grid-template-columns:1fr;gap:12px;align-content:center}
.ed-list li{display:flex;gap:14px;align-items:center;padding:15px 20px;border-radius:14px;background:var(--ivory);border:1px solid var(--beige);font-weight:600;font-size:17.5px;color:var(--olive)}
.ed-list li::before{content:"✓";display:flex;align-items:center;justify-content:center;flex:0 0 32px;height:32px;border-radius:50%;background:var(--maroon);color:var(--cream);font-size:16px;border:2px solid var(--gold)}

/* ===== 5. படிகள் ===== */
.ed-steps{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
.ed-step{position:relative;text-align:center;padding:0 6px}
.ed-num{display:flex;align-items:center;justify-content:center;width:56px;height:56px;margin:0 auto 16px;border-radius:50%;position:relative;z-index:1;
  background:#52011F;color:var(--cream);border:3px solid var(--gold);box-shadow:0 0 0 5px var(--ivory);font:800 23px 'Noto Serif Tamil',serif}
.ed-step:not(:last-child)::after{content:"";position:absolute;top:28px;left:calc(50% + 36px);width:calc(100% - 72px + 20px);height:2px;background:repeating-linear-gradient(90deg,var(--gold) 0 8px,transparent 8px 14px)}
.ed-step h3{font-size:18px;color:var(--maroon);margin-bottom:6px}
.ed-step p{font-size:15.5px}

/* ===== 6. கேள்வி-பதில் ===== */
.ed-faq{background:var(--cream2)}
.ed-qa{max-width:860px;margin:0 auto;display:grid;gap:14px}
.ed-qa details{background:var(--ivory);border:1.5px solid var(--gold);border-radius:16px;overflow:hidden}
.ed-qa summary{cursor:pointer;list-style:none;display:flex;justify-content:space-between;align-items:center;gap:14px;padding:18px 22px;font:700 18px/1.5 'Noto Serif Tamil',serif;color:var(--maroon)}
.ed-qa summary::-webkit-details-marker{display:none}
.ed-qa summary::after{content:"+";flex:0 0 32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:var(--maroon);color:var(--cream);font:400 22px/1 sans-serif;border:2px solid var(--gold)}
.ed-qa details[open] summary::after{content:"−"}
.ed-qa details p{padding:0 22px 20px;font-size:16.5px}

/* ===== 7. அழைப்பு ===== */
.ed-cta{display:block;text-align:center;color:var(--cream);padding:clamp(52px,7vw,88px) 0;
  background:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 48 48' fill='none' stroke='%23F3D995' stroke-opacity='.16' stroke-width='.8'%3E%3Ccircle cx='24' cy='24' r='24'/%3E%3Ccircle cx='0' cy='0' r='24'/%3E%3Ccircle cx='48' cy='0' r='24'/%3E%3Ccircle cx='0' cy='48' r='24'/%3E%3Ccircle cx='48' cy='48' r='24'/%3E%3Ccircle cx='24' cy='24' r='12'/%3E%3Ccircle cx='0' cy='0' r='12'/%3E%3Ccircle cx='48' cy='0' r='12'/%3E%3Ccircle cx='0' cy='48' r='12'/%3E%3Ccircle cx='48' cy='48' r='12'/%3E%3Cpath d='M24 0L48 24L24 48L0 24z'/%3E%3Ccircle cx='24' cy='24' r='3'/%3E%3C/svg%3E"),
   linear-gradient(#500921,#500921)}
.ed-cta h2{font-size:clamp(25px,4.6vw,42px);background:linear-gradient(180deg,#F9E39B,#E2B450 55%,#B8862C);-webkit-background-clip:text;background-clip:text;color:transparent;-webkit-text-fill-color:transparent;filter:drop-shadow(0 3px 5px rgba(30,0,14,.5))}
.ed-cta h2::after{content:"";display:block;width:120px;height:2px;margin:14px auto 0;background:linear-gradient(90deg,transparent,#E2B450,transparent)}
.ed-cta p{max-width:660px;margin:14px auto 0;color:#F3E2B0;font-size:clamp(15px,2.2vw,18px)}
.ed-cta .ed-btns{justify-content:center}
.ed-bless{margin-top:30px;font:700 clamp(17px,2.8vw,23px)/1.5 'Noto Serif Tamil',serif;color:#EBC864}

/* ===== டேப்லெட் / மொபைல் ===== */
@media(max-width:960px){
  .ed-hgrid{grid-template-columns:1fr;text-align:center}
  .ed-hsub{justify-content:center}.ed-hsub::before{display:none}
  .ed-lead{margin-left:auto;margin-right:auto}
  .ed-hero .ed-btns{justify-content:center}
  .ed-vis{max-width:330px}
  .ed-grid{grid-template-columns:repeat(2,1fr)}
  .ed-pgrid{grid-template-columns:1fr}
  .ed-steps{grid-template-columns:repeat(2,1fr);row-gap:34px}
  .ed-step::after{display:none!important}
}
@media(max-width:860px){.ed-page .ed-chips{grid-template-columns:repeat(2,minmax(0,1fr));max-width:560px;margin-bottom:36px}.ed-chips li{min-width:0;overflow-wrap:anywhere}}
@media(max-width:400px){.ed-page .ed-chips{gap:10px}.ed-chips li{padding:8px 8px;font-size:14.5px;border-radius:26px}}
@media(max-width:700px){
  .ed-strip{grid-template-columns:1fr}
  .ed-strip>div+div{border-left:0;border-top:1px solid rgba(243,217,149,.45)}
}
@media(max-width:620px){
  .ed-grid,.ed-steps{grid-template-columns:1fr}
  .ed-card{padding:34px 20px 30px}
  .ed-tile{padding:34px 20px 28px}
  .ed-btn{width:100%;text-align:center}
  .ed-qa summary{font-size:16.5px;padding:16px 18px}
  .ed-qa details p{padding:0 18px 18px}
}
@media(prefers-reduced-motion:reduce){.ed-card,.ed-tile,.ed-btn{transition:none}}
/* ===== கூடுதல் டேப்லெட் / சிறிய மொபைல் திருத்தங்கள் ===== */
@media(min-width:621px) and (max-width:960px){
  .ed-feat .ed-grid>.ed-card:last-child:nth-child(odd){grid-column:1/-1;width:calc(50% - 12px);justify-self:center}
}
@media(max-width:620px){
  .ed-deckwrap{margin-bottom:36px;padding-top:30px}
  .ed-deck{width:min(300px,78vw)}
}
@media(max-width:380px){
  .ed-in{padding:0 16px}
  .ed-hero h1{font-size:30px}
  .ed-card,.ed-tile{padding:32px 18px 28px}
  .ed-note{padding:18px 16px;font-size:16px}
  .ed-quote{padding:26px 20px}
  .ed-list li{padding:13px 14px;font-size:16.5px}
  .ed-dk figcaption{font-size:14px;padding:5px 14px}
}
@media(prefers-reduced-motion:reduce){.ed-dk,.ed-dk::before,.ed-dkdots span{transition:none}}


</style>

<?php echo an_navbar('about'); ?>

<div class="ed-page">

<?php include __DIR__.'/includes/about-hero.php'; ?>

  <!-- 2. அம்சங்கள் -->
  <section class="ed-sec ed-feat">
    <div class="ed-in">
      <div class="ed-head">
        <h2>ஏன் எங்களைத் தேர்ந்தெடுக்க வேண்டும்?</h2>
        <div class="ed-line">✦</div>
        <p>உங்கள் விழா சிறக்க, ஒவ்வொரு படியிலும் நாங்கள் உங்களுடன் இருக்கிறோம்.</p>
      </div>
      <div class="ed-grid">
        <?php foreach($features as $f): ?>
        <article class="ed-card">
          <div class="ed-ico"><?= ed_icon($ic,$f[0]) ?></div>
          <h3><?= $f[1] ?></h3>
          <p><?= $f[2] ?></p>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- 3. தயாரிப்புகள் -->
  <section class="ed-sec ed-dark">
    <div class="ed-in">
      <div class="ed-head">
        <h2>எங்களிடம் கிடைப்பவை</h2>
        <div class="ed-line">✦</div>
        <p>அனைத்து விழாக்களுக்கும் ஏற்ற அழைப்பிதழ்கள் மற்றும் பரிசுப் பொருட்கள்.</p>
      </div>
      <?php if(count($deck)): ?>
      <div class="ed-deckwrap">
        <div class="ed-deck" id="edDeck" tabindex="0" role="group" aria-roledescription="carousel" aria-label="எங்கள் அழைப்பிதழ் மாதிரிகள்">
          <?php foreach($deck as $i=>$d): ?>
          <figure class="ed-dk" data-p="<?= $i ?>">
            <img class="ed-dkbg" src="<?= h($d[0]) ?>" alt="" aria-hidden="true" loading="lazy" draggable="false">
            <img class="ed-dkfg" src="<?= h($d[0]) ?>" alt="<?= h($d[1]) ?>" loading="lazy" draggable="false">
            <figcaption><?= h($d[1]) ?></figcaption>
          </figure>
          <?php endforeach; ?>
        </div>
        <div class="ed-dkdots" id="edDots" aria-hidden="true">
          <?php foreach($deck as $i=>$d): ?><span<?= $i===0?' class="on"':'' ?>></span><?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>
      <ul class="ed-chips">
        <?php foreach($occasions as $o): ?><li><?= $o ?></li><?php endforeach; ?>
      </ul>
      <div class="ed-grid">
        <?php foreach($products as $p): ?>
        <article class="ed-tile">
          <div class="ed-ico"><?= ed_icon($ic,$p[0]) ?></div>
          <div><h3><?= $p[1] ?></h3><p><?= $p[2] ?></p></div>
        </article>
        <?php endforeach; ?>
      </div>
      <div class="ed-note"><b>தரமான பொருட்கள், மலிவான விலை.</b> நிறைய அழைப்பிதழ் மாதிரிகளும் அழகிய கிஃப்ட் பேக்குகளும் எங்களிடம் உள்ளன. மொத்த ஆர்டருக்குச் சிறப்புச் சலுகைகள் உண்டு.</div>
    </div>
  </section>

  <!-- 4. வாக்குறுதி -->
  <section class="ed-sec ed-prom">
    <div class="ed-in">
      <div class="ed-pgrid">
        <div class="ed-quote">
          <b>“</b>
          <h2>ஒவ்வொரு அழைப்பிதழும் ஓர் அன்பின் அழைப்பு</h2>
          <p>உங்கள் உறவுகளை மகிழ்ச்சியுடன் அழைக்கும் அந்த முதல் அழைப்பை, அழகாகவும் நம்பிக்கையுடனும் உங்களிடம் சேர்ப்பதே எங்கள் வாக்குறுதி.</p>
        </div>
        <ul class="ed-list">
          <?php foreach($promises as $p): ?><li><?= $p ?></li><?php endforeach; ?>
        </ul>
      </div>
    </div>
  </section>

  <!-- 5. படிகள் -->
  <section class="ed-sec" style="background:var(--ivory)">
    <div class="ed-in">
      <div class="ed-head">
        <h2>ஆர்டர் செய்வது எளிது</h2>
        <div class="ed-line">✦</div>
        <p>நான்கே படிகளில் உங்கள் அழைப்பிதழ் தயார்.</p>
      </div>
      <div class="ed-steps">
        <?php foreach($steps as $i=>$s): ?>
        <div class="ed-step"><div class="ed-num"><?= $i+1 ?></div><h3><?= $s[0] ?></h3><p><?= $s[1] ?></p></div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- 6. கேள்வி-பதில் -->
  <section class="ed-sec ed-faq">
    <div class="ed-in">
      <div class="ed-head">
        <h2>அடிக்கடி கேட்கப்படும் கேள்விகள்</h2>
        <div class="ed-line">✦</div>
      </div>
      <div class="ed-qa">
        <?php foreach($faq as $q): ?>
        <details><summary><?= $q[0] ?></summary><p><?= $q[1] ?></p></details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- 7. அழைப்பு -->
  <section class="ed-cta">
    <div class="ed-in">
      <h2>உங்கள் விழாவை அழகாக்கத் தயாரா?</h2>
      <p>உங்கள் தேவையைச் சொல்லுங்கள். உங்களுக்குப் பொருத்தமான அழைப்பிதழையும் பரிசுப் பொருட்களையும் அன்புடன் தேர்ந்தெடுத்துத் தருகிறோம்.</p>
      <div class="ed-btns">
        <a class="ed-btn g" href="contact.php">தொடர்புகொள்ளுங்கள்</a>
        <a class="ed-btn o" href="products.php">தயாரிப்புகளைப் பாருங்கள்</a>
      </div>
      <div class="ed-bless">அன்புடன் உங்களை அழைக்கிறோம்...</div>
    </div>
  </section>

</div>
<?php include __DIR__.'/includes/site-footer.php'; ?>
<script>
(function(){
  var deck=document.getElementById('edDeck'); if(!deck) return;
  var cards=[].slice.call(deck.querySelectorAll('.ed-dk')),
      dots=[].slice.call(document.querySelectorAll('#edDots span')),
      n=cards.length, order=cards.slice(), busy=false, timer=null, visible=false, hover=false, startX=null,
      reduce=window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
  function paint(){
    order.forEach(function(c,i){c.setAttribute('data-p',i)});
    var cur=cards.indexOf(order[0]); dots.forEach(function(d,i){d.classList.toggle('on',i===cur)});
  }
  function next(){
    if(busy||n<2) return; busy=true;
    var top=order[0]; top.classList.add('out');
    order.push(order.shift()); paint();
    setTimeout(function(){
      top.classList.add('nt'); top.classList.remove('out');
      void top.offsetWidth; top.classList.remove('nt'); busy=false;
    }, reduce?0:760);
  }
  function stop(){ if(timer){clearInterval(timer);timer=null} }
  function play(){ stop(); if(reduce||n<2||!visible||hover||document.hidden) return; timer=setInterval(next,2800); }
  deck.addEventListener('pointerdown',function(e){startX=e.clientX});
  deck.addEventListener('pointerup',function(e){
    if(startX===null) return; startX=null; next(); play();
  });
  deck.addEventListener('pointercancel',function(){startX=null});
  deck.addEventListener('keydown',function(e){ if(e.key==='Enter'||e.key===' '||e.key==='ArrowRight'){e.preventDefault();next();play()} });
  /* mouse மட்டும் pause செய்யும் — மொபைலில் தொட்ட பிறகு autoplay நிற்காது */
  deck.addEventListener('pointerenter',function(e){ if(e.pointerType==='mouse'){hover=true;stop()} });
  deck.addEventListener('pointerleave',function(e){ if(e.pointerType==='mouse'){hover=false;play()} });
  document.addEventListener('visibilitychange',play);
  if('IntersectionObserver' in window){
    new IntersectionObserver(function(en){visible=en[0].isIntersecting;play()},{threshold:.35}).observe(deck);
  } else { visible=true; play(); }
  paint();
})();
</script>
</body></html>