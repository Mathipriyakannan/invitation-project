<?php
/* ATHEN Admin — பொதுவான ஃபுட்டர் (Cards / Bags / Messages / Book அனைத்து admin பக்கங்களுக்கும் ஒரே ஃபுட்டர்)
   admin/_lay.php-ல் உள்ள adm_bot() இதை தானாக சேர்க்கிறது.
   நிறங்கள்: admin தீம் — டீல் (#0a4a53 / #0d5a5f) + டெரகோட்டா (#c4572e) + தங்கம் (#f0cf8e) */
$afAddr0='26/1, ஸ்ரீனிவாசகம் வளாகம், பாளையங்கோட்டை, திருநெல்வேலி.';
$afAddr1='26/1, Srinivasagam Complex,';
$afAddr2='Palayamkottai, Tirunelveli.';
$afPhone='+91 96774 79227';$afTel='+919677479227';
?>
<style>
/* பக்கம் குறைவாக இருந்தாலும் ஃபுட்டர் கீழேயே இருக்கும் */
.wrap{display:flex;flex-direction:column}
.wrap>main{flex:1 0 auto}
.af{position:relative;flex:none;overflow:hidden;color:#fff;font-family:'Poppins','Segoe UI',sans-serif;
 border-top:4px solid #c4572e;
 background:linear-gradient(90deg,#0a4a53,#0d5a5f 55%,#0a4a53);box-shadow:0 -6px 20px rgba(5,46,54,.18)}
.af:before{content:'';position:absolute;left:-50px;bottom:-80px;width:220px;height:120px;border-radius:50%;background:linear-gradient(135deg,#c4572e,#8e3a1c);opacity:.9;pointer-events:none}
.af *{box-sizing:border-box}
.af-in{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1fr;align-items:center;gap:20px 40px;max-width:1100px;margin:0 auto;padding:26px 34px 20px}
.af-brand{display:flex;align-items:center;gap:12px}
.af-brand svg{flex:none}
.af-brand b{display:block;font-family:'Cinzel',serif;font-weight:600;font-size:24px;letter-spacing:.06em;line-height:1.05}
.af-brand small{display:block;margin-top:3px;font-size:11.5px;color:#e9efef;opacity:.9}
.af-ct{display:grid;gap:12px;justify-self:end}
.af-ct a,.af-ct div{display:flex;align-items:center;gap:12px;color:#fff;text-decoration:none;font-size:13.5px;font-weight:500;line-height:1.5}
.af-ic{flex:none;display:grid;place-items:center;width:36px;height:36px;border-radius:50%;color:#f0cf8e;background:rgba(255,255,255,.08);border:1.5px solid #f0cf8e;transition:.2s}
.af-ic svg{width:17px;height:17px}
.af-ct a:hover .af-ic{background:#c4572e;border-color:#c4572e;color:#fff}
.af-cp{position:relative;z-index:1;text-align:center;padding:12px 16px 14px;border-top:1px solid rgba(240,207,142,.35);font-size:12px;color:#e9efef;opacity:.9}
@media(max-width:760px){
 .af-in{grid-template-columns:1fr;justify-items:center;text-align:center;gap:18px;padding:22px 16px 16px}
 .af-brand b{font-size:22px}
 .af-brand{justify-content:center}
 .af-ct{justify-self:center;gap:10px}
 .af-ct a,.af-ct div{justify-content:center;font-size:13px;text-align:left}
 .af-cp{font-size:11.5px;padding:10px 12px 12px}
}
</style>
<footer class="af">
 <div class="af-in">
  <div class="af-brand">
   <svg width="42" height="36" viewBox="0 0 46 40" fill="none" stroke="#f0cf8e" stroke-width="1.6" stroke-linejoin="round" aria-hidden="true"><path d="M15 10 18 4l5 4 5-4 3 6"/><rect x="6" y="14" width="34" height="23" rx="3" fill="#fff" fill-opacity=".1"/><path d="m6 16 17 12L40 16"/></svg>
   <div><b>ATHEN</b><small>Invitation Admin Panel</small></div>
  </div>
  <div class="af-ct">
   <div><span class="af-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.6"/></svg></span><span><b style="display:block;font-size:15px;font-weight:600"><?=$afAddr0?></b><?=$afAddr1?> <?=$afAddr2?></span></div>
   <a href="tel:<?=$afTel?>"><span class="af-ic"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8a15 15 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11 11 0 0 0 3.6.6 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.6 3.6a1 1 0 0 1-.25 1z"/></svg></span><span><?=$afPhone?></span></a>
  </div>
 </div>
 <div class="af-cp">© <?=date('Y')?> ATHEN Invitation · Admin Panel</div>
</footer>