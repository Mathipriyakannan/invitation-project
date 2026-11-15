<?php $page='contact'; $nonav=true; include 'includes/header.php'; require_once __DIR__.'/includes/navbar.php'; ?>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=Noto+Serif+Tamil:wght@600;800&family=Noto+Sans+Tamil:wght@400;500;700&display=swap" rel="stylesheet">
<style>
body{background:#F8F0D9!important;margin:0}
/* ===== தொடர்புக்கு பக்கம் — index.php கலர்கள்: ப்ளம் (#6E0D43 · #8F1456 · #A3185F) · ஆலிவ் (#5B5F1C · #3E4210) · கிரீம் (#F8F0D9 · #FBEED0 · #FFF8E6) · தங்கம் (#F3D995 · #E2B44F · #B8862C) ===== */
.cp{--pl:#8F1456;--pl-d:#6E0D43;--pl-l:#A3185F;--ol:#5B5F1C;--ol-d:#3E4210;--cr:#F8F0D9;--cr2:#FBEED0;--cr3:#FFF8E6;--gd:#E2B44F;--gd-l:#F3D995;--gd-d:#B8862C;--ink:#33232B;
 font-family:'Noto Sans Tamil','Latha',system-ui,sans-serif;color:var(--ink);
 background:var(--cr)}
.cp *{box-sizing:border-box}
/* ---------- banner ---------- */
/* பேனர்: படம் / விளக்கு / மலர் / இலை எதுவுமில்லை — அடர் மெரூன் நிறம் மட்டும், தங்கக் கோடுகளுடன் */
.chero{position:relative;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;overflow:hidden;color:var(--cr2);
 aspect-ratio:2170/496;min-height:230px;padding:clamp(26px,3.6vw,52px) clamp(60px,14vw,300px) clamp(44px,6vw,86px);
 border-top:3px solid var(--gd);border-bottom:3px solid var(--gd);
 box-shadow:inset 0 5px 0 #3A041D,inset 0 7px 0 var(--gd-l),inset 0 -5px 0 #3A041D,inset 0 -7px 0 var(--gd-l);
 background:radial-gradient(ellipse 80% 60% at 50% 30%,rgba(255,150,120,.16),transparent 70%),linear-gradient(#52011F,#52011F)}
.chero>*{position:relative;z-index:1}
.eyebrow{display:flex;align-items:center;justify-content:center;gap:12px;font:700 clamp(11px,1.2vw,14px)/1 'Cinzel','Times New Roman',serif;letter-spacing:.34em;color:#F1CF74;text-shadow:0 1px 3px rgba(40,0,20,.6)}
.eyebrow:before,.eyebrow:after{content:"";width:clamp(30px,8vw,110px);height:1px;background:linear-gradient(90deg,transparent,var(--gd-l))}.eyebrow:after{transform:scaleX(-1)}
.chero h1{margin:8px 0 6px;font:800 clamp(34px,5vw,60px)/1.25 'Noto Serif Tamil',serif;background:linear-gradient(#FFEDA8,#EDBC55 55%,#C9962F);-webkit-background-clip:text;background-clip:text;color:transparent;-webkit-text-fill-color:transparent;filter:drop-shadow(0 3px 4px rgba(40,0,20,.45))}
.chero p{margin:0 auto;max-width:560px;font-size:clamp(14.5px,1.5vw,17px);line-height:1.7;color:#FFF1CC;font-weight:500;text-shadow:0 1px 3px rgba(40,0,20,.5)}
/* ---------- layout ---------- */
.cwrap{max-width:1080px;margin:0 auto;padding:clamp(38px,5.4vw,64px) clamp(14px,3vw,24px) clamp(38px,5vw,64px);display:grid;grid-template-columns:minmax(0,.85fr) minmax(0,1.15fr);gap:clamp(20px,3vw,36px);align-items:start}
.sec-t{display:flex;align-items:center;gap:12px;margin:0 0 16px;font:800 clamp(19px,2vw,23px)/1.3 'Noto Serif Tamil',serif;color:var(--pl)}
.sec-t:after{content:"";flex:1;height:1.5px;background:linear-gradient(90deg,var(--gd),transparent)}
.side{display:flex;flex-direction:column;gap:14px}
.ic-card{display:flex;align-items:center;gap:16px;padding:16px 18px;border-radius:20px;text-decoration:none;color:var(--ink);background:linear-gradient(180deg,var(--cr3),var(--cr2));border:1.5px solid var(--gd);box-shadow:0 8px 20px rgba(110,13,67,.12),inset 0 0 0 3px var(--cr3),inset 0 0 0 4.5px rgba(226,180,79,.45);transition:.25s}
a.ic-card:hover{transform:translateY(-2px);box-shadow:0 12px 26px rgba(110,13,67,.2),inset 0 0 0 3px var(--cr3),inset 0 0 0 4.5px rgba(226,180,79,.45);border-color:var(--pl)}
.badge{flex:none;display:grid;place-items:center;width:54px;height:54px;border-radius:50%;color:var(--gd-l);background:radial-gradient(circle at 35% 28%,var(--ol),var(--ol-d));border:2px solid var(--gd);box-shadow:0 0 0 3px var(--cr3),0 0 0 4.5px var(--gd-l),0 6px 12px rgba(62,66,16,.35)}
.badge svg{width:25px;height:25px}
.ic-card small{display:block;font-size:13px;font-weight:700;letter-spacing:.02em;color:var(--ol)}
.ic-card b{display:block;margin-top:2px;font:700 clamp(16px,1.6vw,18px)/1.35 system-ui,'Noto Sans Tamil',sans-serif;color:var(--pl-d);overflow-wrap:anywhere}
/* ---------- form card (index-ன் வளைவு அட்டை போல) ---------- */
.fc{position:relative;padding:clamp(30px,4vw,44px) clamp(18px,3.4vw,38px) clamp(26px,3.4vw,36px);border-radius:clamp(70px,10vw,120px) clamp(70px,10vw,120px) 24px 24px;background:linear-gradient(180deg,var(--cr3),var(--cr2));border:1.5px solid var(--gd);box-shadow:0 16px 34px rgba(110,13,67,.16),inset 0 0 0 4px var(--cr3),inset 0 0 0 5.5px var(--gd-l)}
.fc:before,.fc:after{content:"";position:absolute;bottom:13px;width:9px;height:9px;transform:rotate(45deg);background:linear-gradient(135deg,var(--gd-l),var(--gd-d))}
.fc:before{left:14px}.fc:after{right:14px}
.fc .cr{display:grid;place-items:center;width:50px;height:50px;margin:0 auto 6px;border-radius:50%;color:var(--gd-l);font-size:26px;line-height:1;background:radial-gradient(circle at 35% 28%,var(--pl-l),var(--pl-d));border:2px solid var(--gd);box-shadow:0 0 0 3px var(--cr3),0 0 0 4.5px var(--gd-l),0 6px 12px rgba(110,13,67,.35)}
.fc h2{margin:0;text-align:center;font:800 clamp(21px,2.6vw,28px)/1.35 'Noto Serif Tamil',serif;color:var(--pl)}
.fc .sub{margin:4px 0 20px;text-align:center;font-size:clamp(13.5px,1.4vw,15px);line-height:1.6;font-weight:500;color:var(--ol)}
form{margin:0}
.fld{display:flex;align-items:center;gap:12px;margin-bottom:14px;padding:5px 8px;border-radius:40px;background:#FFFDF5;border:1.5px solid var(--gd);box-shadow:inset 0 2px 4px rgba(110,13,67,.05);transition:.2s}
.fld:focus-within{border-color:var(--pl);box-shadow:0 0 0 3px rgba(143,20,86,.15)}
.fld .ic{flex:none;display:grid;place-items:center;width:40px;height:40px;border-radius:50%;color:var(--gd-l);background:linear-gradient(var(--ol),var(--ol-d))}
.fld .ic svg{width:20px;height:20px}
.fld input,.fld textarea{flex:1;min-width:0;border:0;outline:0;background:none;color:var(--ink);font:500 clamp(16px,1.6vw,17.5px) 'Noto Sans Tamil','Latha',sans-serif}
.fld input{height:42px}.fld input::placeholder,.fld textarea::placeholder{color:#6b5560;opacity:1}
.fld.ta{align-items:flex-start;border-radius:26px}.fld.ta .ic{margin-top:4px}
.fld textarea{height:clamp(110px,13vw,130px);padding:10px 10px 10px 2px;resize:none;line-height:1.5}
.act{display:flex;align-items:center;flex-wrap:wrap;gap:12px 16px;margin-top:4px}
.send{display:inline-flex;align-items:center;gap:10px;padding:0 30px;height:50px;border-radius:40px;cursor:pointer;color:#FFF8E6;font:700 17px 'Noto Sans Tamil',sans-serif;border:1.5px solid var(--gd-l);background:linear-gradient(var(--pl-l),var(--pl-d));box-shadow:0 8px 16px rgba(110,13,67,.35),inset 0 1px 0 rgba(255,255,255,.3);transition:.25s}
.send:hover{transform:translateY(-2px);filter:brightness(1.08)}
.send:disabled{opacity:.6;cursor:wait;transform:none}
.send svg{width:19px;height:19px}
.st{flex:1;min-width:180px;font:700 14.5px/1.4 'Noto Sans Tamil',sans-serif;color:var(--ol)}.st.er{color:var(--pl)}
.note{margin:16px 0 0;text-align:center;font-size:13px;font-weight:500;color:var(--ol)}
/* ---------- footer (index போல ஆலிவ்) ---------- */
.ft{position:relative;text-align:center;color:var(--cr2);padding:clamp(32px,4vw,46px) 16px clamp(22px,3vw,30px);border-top:4px solid var(--gd);
 background:radial-gradient(ellipse 60% 100% at 50% 0,rgba(243,217,149,.14),transparent 70%),linear-gradient(180deg,var(--ol),var(--ol-d))}
.ft:before{content:"";position:absolute;left:0;right:0;top:5px;height:1.5px;background:linear-gradient(90deg,transparent,var(--gd-l),transparent)}
.ft .cx{display:block;margin:0 auto 4px;width:28px;height:auto;color:var(--gd-l)}
.ft .at{font:700 clamp(22px,3vw,32px)/1.2 'Cinzel','Times New Roman',serif;letter-spacing:.42em;margin-right:-.42em;color:var(--gd-l)}
.ft .tn{font:800 clamp(17px,2.2vw,23px)/1.5 'Noto Serif Tamil',serif;color:var(--cr3)}
.ft .ex{display:flex;align-items:center;justify-content:center;gap:12px;margin:2px 0 14px;font:500 clamp(10px,1.2vw,12.5px)/1.2 'Cinzel',serif;letter-spacing:.24em;color:var(--gd-l)}
.ft .ex:before,.ft .ex:after{content:"";width:clamp(24px,6vw,70px);height:1px;background:linear-gradient(90deg,transparent,var(--gd-l))}.ft .ex:after{transform:scaleX(-1)}
.fi{display:flex;flex-wrap:wrap;align-items:center;justify-content:center;gap:10px clamp(12px,2vw,24px);margin:0 0 12px}
.fi a{display:inline-flex;align-items:center;gap:8px;color:var(--cr2);text-decoration:none;font:500 clamp(13px,1.3vw,14.5px)/1.3 system-ui,'Noto Sans Tamil',sans-serif}
.fi a:hover{color:#fff}.fi svg{flex:none;width:17px;height:17px;color:var(--gd-l)}.fi .sp{width:1px;height:18px;background:rgba(243,217,149,.5)}
.ft small{display:block;color:var(--gd-l);font-size:12px}
/* ---------- responsive ---------- */
/* டேப்லெட் / லேண்ட்ஸ்கேப்: பேனர் aspect-ratio + min-height சேர்ந்து அகலத்தை விரிக்காமல், திரைக்குள் எழுத்து முழுதாகத் தெரியும் */
@media(max-width:1100px){
 .chero{aspect-ratio:auto;width:100%;max-width:100%;min-height:clamp(230px,30vw,300px);padding:clamp(30px,4vw,44px) clamp(20px,5vw,60px) clamp(34px,5vw,50px)}
 .chero p{max-width:min(560px,100%)}
}
@media(max-width:860px){
 .cwrap{grid-template-columns:1fr}
 .fi{flex-direction:column;gap:10px}.fi .sp{display:none}
}
/* மொபைல் பேனர்: அடர் மெரூன் #52011F + மெல்லிய ஜாலி · விளக்கு & மலர்கள் மூலைகளில் */
@media(max-width:700px){
 .chero{aspect-ratio:auto;min-height:0;justify-content:flex-start;padding:40px 20px 44px;
  border-top:3px solid var(--gd);border-bottom:3px solid var(--gd);
  box-shadow:inset 0 5px 0 #3A041D,inset 0 7px 0 var(--gd-l),inset 0 -5px 0 #3A041D,inset 0 -7px 0 var(--gd-l);
  background:radial-gradient(ellipse 80% 60% at 50% 30%,rgba(255,150,120,.16),transparent 70%),linear-gradient(#52011F,#52011F)}
 .chero h1{font-size:clamp(32px,9.6vw,44px)}
 .chero p{font-size:15px;max-width:300px}
}
@media(max-width:560px){
 .ic-card{padding:14px}.badge{width:48px;height:48px}.badge svg{width:22px;height:22px}
 .fc{border-radius:70px 70px 22px 22px}
 .send{width:100%;justify-content:center}.st{text-align:center;flex-basis:100%}
}
@media(max-width:400px){.chero{padding:34px 16px 40px}}
</style>
<?php echo an_navbar('contact'); ?>

<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
<linearGradient id="gg" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#FFF1B8"/><stop offset="1" stop-color="#E2B44F"/></linearGradient>
<symbol id="cross" viewBox="0 0 24 24"><path d="M10 1.5h4v6.5h6.5v4H14V22.5h-4V12H3.5V8H10z" fill="url(#gg)"/></symbol>
</defs></svg>

<main class="cp">
<section class="chero">
 <div class="eyebrow">CONTACT</div>
 <h1>தொடர்புக்கு</h1>
 <p>உங்கள் விழாவுக்கான அழைப்பிதழ் பற்றி எப்போது வேண்டுமானாலும் எங்களிடம் கேளுங்கள்</p>
</section>

<section class="cwrap">
 <div>
  <h3 class="sec-t">எங்கள் விவரங்கள்</h3>
  <div class="side">
   <a class="ic-card" href="tel:+919677479227"><span class="badge"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8a15 15 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11 11 0 0 0 3.6.6 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.6 3.6a1 1 0 0 1-.25 1z"/></svg></span><span><small>தொலைபேசி</small><b>96774 79227</b></span></a>
   <div class="ic-card"><span class="badge"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a7 7 0 0 0-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/></svg></span><span><small>முகவரி</small><b style="display:block;font-size:1.12em;line-height:1.45">26/1, ஸ்ரீனிவாசகம் வளாகம், பாளையங்கோட்டை, திருநெல்வேலி.</b><b style="display:block;margin-top:3px;font-size:.82em;font-weight:600;opacity:.9">26/1, Srinivasagam Complex, Palayamkottai, Tirunelveli.</b></span></div>
  </div>
 </div>

 <div class="fc">
  <div class="cr" aria-hidden="true">✝</div>
  <h2>எங்களை தொடர்பு கொள்ளுங்கள்</h2>
  <p class="sub">உங்கள் செய்தியை எழுதுங்கள், விரைவில் தொடர்புகொள்வோம்</p>
  <form id="cform" novalidate autocomplete="off">
   <label class="fld"><span class="ic"><svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="8" r="4.2"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7z"/></svg></span><input name="name" type="text" maxlength="60" placeholder="உங்கள் பெயர்*" aria-label="உங்கள் பெயர்"></label>
   <label class="fld"><span class="ic"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8a15 15 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11 11 0 0 0 3.6.6 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.6 3.6a1 1 0 0 1-.25 1z"/></svg></span><input name="phone" type="tel" maxlength="20" placeholder="தொலைபேசி எண்*" aria-label="தொலைபேசி எண்"></label>
   <label class="fld ta"><span class="ic"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H9l-5 4v-4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/></svg></span><textarea name="message" maxlength="600" placeholder="செய்தி*" aria-label="செய்தி"></textarea></label>
   <div class="act"><button class="send go" type="submit"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M2.5 11.3 21 3l-4.2 18-5-6.2-3.4 3.3.2-5.2zM9 12.5l6.6-5.2-8.2 6.5z"/></svg>அனுப்பவும்</button><div class="st" id="cst" role="status"></div></div>
  </form>
  <p class="note">* குறியிட்ட கட்டங்கள் அவசியம் நிரப்பப்பட வேண்டும்</p>
 </div>
</section>

<?php include __DIR__.'/includes/site-footer.php'; ?>
</main>
<script>
(function(){
var f=document.getElementById('cform'),st=document.getElementById('cst'),b=f.querySelector('.send'),E=f.elements;
function say(t,e){st.textContent=t;st.className='st'+(e?' er':'')}
f.addEventListener('submit',function(ev){ev.preventDefault();
 var n=E.name.value.trim(),p=E.phone.value.trim(),m=E.message.value.trim();
 if(!n){say('உங்கள் பெயரை எழுதவும்',1);E.name.focus();return}
 if(p.replace(/\D/g,'').length<7){say('சரியான தொலைபேசி எண்ணை எழுதவும்',1);E.phone.focus();return}
 if(m.length<2){say('செய்தியை எழுதவும்',1);E.message.focus();return}
 b.disabled=true;say('அனுப்பப்படுகிறது...');
 fetch('api/feedback.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({action:'contact',name:n,phone:p,message:m})})
 .then(function(r){return r.json()}).then(function(r){b.disabled=false;if(r&&r.ok){f.reset();say('✔ நன்றி! உங்கள் செய்தி அனுப்பப்பட்டது.')}else say('அனுப்ப முடியவில்லை, மீண்டும் முயலவும்',1)})
 .catch(function(){b.disabled=false;say('இணைப்பு பிழை, மீண்டும் முயலவும்',1)})});
})();
</script>
</body></html>