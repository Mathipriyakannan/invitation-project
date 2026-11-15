<?php
/* ஏதேன் அழைப்பிதழ் — பொதுவான ஃபுட்டர் (முழு அகலம், முழுக்க கோடில் மட்டும்)
   நிறங்கள்: ஆலிவ் பச்சை + அடர் மெரூன் + தங்கம்
   பயன்பாடு:  <?php include __DIR__.'/includes/site-footer.php'; ?> */
$sfPhone = '+91 96774 79227'; $sfTel = '+919677479227';
$sfMail  = 'athenad@gmail.com';
$sfWeb   = 'www.athenad.in';  $sfWebUrl = 'https://www.athenad.in';
$sfInsta = 'https://instagram.com/lifechangersind';
$sfYt    = 'https://youtube.com/@lifechangersind';
$sfTg    = 'https://t.me/'.$sfTel;
$sfLcUrl = 'https://instagram.com/lifechangersind'; // Life Changers Ind இணையதள முகவரியை இங்கே மாற்றுங்கள்
?>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=Dancing+Script:wght@600&family=Noto+Serif+Tamil:wght@500;700;800&family=Noto+Sans+Tamil:wght@400;500;600&display=swap" rel="stylesheet">
<style>
footer.sf{--m:#5B0A25;--md:#3A0517;--g:#E2B44F;--gl:#F6DE9B;--gd:#B8862C;--o:#5B5F1C;--od:#454913;
 position:relative!important;display:block!important;
 /* முழு அகலம்: தீமின் பொதுவான footer padding/margin/width ஐ ரத்து செய்கிறது */
 width:100%!important;max-width:none!important;padding:0!important;margin:-30px 0 0!important;float:none!important;left:auto!important;right:auto!important;transform:none!important;border-radius:0!important;box-shadow:none!important;
 overflow:hidden;color:#F6E9C4;font-family:'Noto Sans Tamil','Latha',system-ui,sans-serif;font-size:14px;line-height:1.6;text-align:left;
 border-top:2px solid var(--g);
 background-color:var(--o);
 background-image:radial-gradient(ellipse 50% 40% at 50% 0,rgba(243,217,149,.12),transparent 70%),linear-gradient(180deg,var(--o),var(--od) 88%)!important;
 -webkit-mask:none!important;mask:none!important;clip-path:none!important}
/* கர்கர் / scallop பேட்டர்ன் முழுமையாக ரத்து */
footer.sf::before,footer.sf::after{content:none!important;display:none!important;background:none!important}
.sf *,.sf *::before,.sf *::after{box-sizing:border-box}
.sf a,.sf a:hover,.sf a:focus,.sf a:active{text-decoration:none;color:inherit}
.sf ul,.sf li{list-style:none;margin:0;padding:0}
:where(.sf h3,.sf p){margin:0}
.sf svg{display:block}
.sf-defs{position:absolute;width:0;height:0;overflow:hidden}

/* பின்னணி இலைகள் */
.sf-bgleaf{position:absolute;top:-6px;width:clamp(90px,11vw,180px);height:clamp(90px,11vw,180px);color:var(--gl);opacity:.13;pointer-events:none}
.sf-bgleaf.l{left:-8px}.sf-bgleaf.r{right:-8px;transform:scaleX(-1)}

/* மேல் அழைப்பு அட்டை */
.sf-top{position:relative;padding:24px clamp(16px,4vw,56px);border-bottom:1px solid rgba(226,180,79,.5)}
.sf-card{position:relative;max-width:1180px;margin:0 auto;display:flex;align-items:center;gap:24px;
 padding:16px clamp(24px,3.6vw,52px);border-radius:46px;
 background:linear-gradient(180deg,#5E0B27,#3F0719);border:2px solid var(--g);
 box-shadow:0 0 0 3px rgba(226,180,79,.12),0 0 22px rgba(226,180,79,.32),0 12px 26px rgba(0,0,0,.4),inset 0 0 30px rgba(0,0,0,.35)}
.sf-card::before{content:"";position:absolute;left:12%;right:12%;top:-2px;height:2px;background:linear-gradient(90deg,transparent,#fff3c4,transparent)}
.sf-card::after{content:"";position:absolute;left:12%;right:12%;bottom:-2px;height:2px;background:linear-gradient(90deg,transparent,#fff3c4,transparent)}
.sf-orn{position:absolute;top:50%;width:54px;height:54px;color:var(--g);transform:translateY(-50%)}
.sf-orn.l{left:-30px}
.sf-orn.r{right:-30px;transform:translateY(-50%) scaleX(-1)}
.sf-lot{flex:none;width:28px;height:28px;color:var(--g)}
.sf-ctext{flex:1;min-width:0}
.sf-ctext h3{font:700 clamp(16px,1.55vw,20px)/1.4 'Noto Serif Tamil',serif;color:var(--gl);text-shadow:0 2px 5px rgba(0,0,0,.4)}
.sf-ctext p{margin-top:6px;font-size:12.5px;line-height:1.7;color:#F3E2B0;max-width:520px}
.sf-vsep{flex:none;align-self:stretch;width:1px;background:linear-gradient(180deg,transparent,rgba(226,180,79,.7),transparent)}
.sf-btns{display:flex;flex-wrap:wrap;gap:12px;flex:none}
.sf-btn,.sf-btn:hover{display:inline-flex;align-items:center;gap:8px;padding:9px 20px;border-radius:50px;font-weight:600;font-size:13.5px;line-height:1.2;white-space:nowrap;transition:transform .25s,box-shadow .25s,background .25s}
.sf-btn svg{width:17px;height:17px;flex:none}
.sf-btn .ar{width:13px;height:13px}
.sf-btn:hover{transform:translateY(-2px)}
.sf-btn.g,.sf-btn.g:hover{color:var(--md);background:linear-gradient(180deg,#F3D58C,#D3A246);box-shadow:0 6px 16px rgba(0,0,0,.4),inset 0 1px 0 rgba(255,255,255,.5);font-weight:700}
.sf-btn.o,.sf-btn.o:hover{color:var(--gl);border:1.5px solid var(--g);background:transparent;box-shadow:none}
.sf-btn.o:hover{background:rgba(226,180,79,.14)}

/* முக்கியப் பகுதி */
.sf-main{position:relative;display:grid;grid-template-columns:1.4fr 1.3fr 1.1fr;max-width:1240px;margin:0 auto;padding:28px clamp(16px,4vw,56px) 24px}
.sf-col{position:relative;padding:0 clamp(14px,2vw,28px)}
footer.sf nav.sf-col,footer.sf div.sf-col{display:block!important;flex-direction:column!important;align-items:stretch!important}
.sf-col:first-child{padding-left:0}.sf-col:last-child{padding-right:0}
.sf-col+.sf-col::before{content:"";position:absolute;left:0;top:0;bottom:0;width:1px;background:linear-gradient(180deg,rgba(226,180,79,.9),rgba(226,180,79,.35))}
.sf-col+.sf-col::after{content:"";position:absolute;left:-3px;bottom:-3px;width:7px;height:7px;transform:rotate(45deg);background:var(--g)}
.sf-logo{display:flex;align-items:center;gap:12px}
.sf-seal{flex:none;position:relative;display:grid;place-items:center;width:62px;height:62px;border-radius:50%;border:1.5px solid var(--g);color:var(--g);background:radial-gradient(circle,rgba(58,5,23,.55),rgba(58,5,23,.15) 70%)}
.sf-seal::before{content:"";position:absolute;inset:5px;border-radius:50%;border:1px solid rgba(226,180,79,.7)}
.sf-seal i{position:absolute;width:6px;height:6px;background:var(--g);transform:rotate(45deg)}
.sf-seal i:nth-child(1){top:-3px;left:calc(50% - 3px)}.sf-seal i:nth-child(2){bottom:-3px;left:calc(50% - 3px)}
.sf-seal i:nth-child(3){left:-3px;top:calc(50% - 3px)}.sf-seal i:nth-child(4){right:-3px;top:calc(50% - 3px)}
.sf-seal svg{width:56%;height:56%}
/* ஏதேன் லோகோ (assets/img/logo.jpeg) — வட்டமாக வெட்டி (கிளிக் இல்லை) */
.sf-seal.sf-logoimg{display:block;width:68px;height:68px;border:2px solid #E9C46A;cursor:default;pointer-events:none;
 background:#6b0000 url(assets/img/logo.jpeg) no-repeat 48.98% 33.3%;background-size:180.7% auto;
 box-shadow:0 0 0 3px rgba(233,196,106,.28),0 3px 10px rgba(0,0,0,.4)}
.sf-seal.sf-logoimg::before{display:none}
.sf-brand{min-width:0}
.sf-tn{font:700 clamp(18px,1.8vw,24px)/1.3 'Noto Serif Tamil',serif;color:var(--gl);padding-bottom:4px;border-bottom:1px solid rgba(226,180,79,.7);text-shadow:0 2px 5px rgba(0,0,0,.4);white-space:nowrap}
.sf-en{margin-top:6px;font:500 10.5px/1.4 'Cinzel',serif;letter-spacing:.34em;color:var(--g);display:flex;align-items:center;gap:.8em;white-space:nowrap}
.sf-en b{font-weight:500;color:var(--gl)}
.sf-en em{width:5px;height:5px;transform:rotate(45deg);background:var(--g);display:inline-block}
.sf-tag{margin:12px 0 0;font-size:12.5px;line-height:1.8;color:#F3E6C2;max-width:330px}
.sf .sf-h{display:flex;align-items:center;gap:10px;margin:0 0 26px;padding-bottom:10px;font:600 14.5px/1.4 'Noto Sans Tamil',sans-serif;color:var(--gl);position:relative}
.sf-h svg{width:20px;height:20px;flex:none;color:var(--g)}
.sf-h::after{content:"";position:absolute;left:0;right:0;bottom:0;height:1px;background:linear-gradient(90deg,var(--g),rgba(226,180,79,.2))}
.sf-ct{display:grid;gap:13px}
.sf-ct a,.sf-ct a:hover,.sf-ct div{display:flex;align-items:center;gap:11px;min-width:0;padding:0;background:none;border:0;box-shadow:none;font:500 13px/1.4 system-ui,'Noto Sans Tamil',sans-serif;color:#F6EBCB}
.sf-ic{flex:none;display:flex;align-items:center;justify-content:center;width:36px;height:36px;line-height:0;border-radius:50%;color:var(--gl);background:var(--md);border:1.5px solid var(--g);transition:.25s}
.sf-ic svg{width:16px;height:16px;margin:0;flex:none}
.sf-ct span.t{overflow-wrap:anywhere}
.sf-ct span.t.addr{white-space:normal;line-height:1.55}
.sf-ct .a-ta{display:block;font:700 16px/1.45 'Baloo Thambi 2','Mukta Malar','Noto Sans Tamil',sans-serif;color:#FFF6DC}
.sf-ct .a-en{display:block;margin-top:2px;font-size:12.5px;opacity:.9}
.sf-ct a:hover .sf-ic{background:var(--g);color:var(--md)}
.sf-soc{display:flex;flex-wrap:wrap;gap:12px}
.sf-soc a,.sf-soc a:hover{display:flex;align-items:center;justify-content:center;width:42px;height:42px;line-height:0;padding:0;border-radius:50%;color:var(--gl);background:linear-gradient(180deg,#4B0A20,#2D0412);border:1.5px solid var(--g);box-shadow:inset 0 0 10px rgba(0,0,0,.5),0 3px 8px rgba(0,0,0,.35);transition:.25s}
.sf-soc a:hover{background:var(--g);color:var(--md);transform:translateY(-3px)}
.sf-soc svg{width:19px;height:19px;margin:0;flex:none}
.sf-soc.sm{margin-top:16px}
.sf-slogan{position:relative;margin-top:16px;padding-left:4px;transform:rotate(-7deg);transform-origin:left center;font:600 clamp(17px,1.7vw,22px)/1.25 'Dancing Script','Brush Script MT',cursive;color:var(--gl);text-shadow:0 2px 5px rgba(0,0,0,.4);white-space:nowrap}
.sf-slogan span{display:block;padding-left:1.3em}
.sf-slogan::after{content:"";display:block;height:2px;margin-top:5px;width:86%;margin-left:12%;background:linear-gradient(90deg,transparent,var(--g));border-radius:2px;transform:rotate(-2deg)}

/* கீழ்ப் பகுதி */
.sf-bot{position:relative;width:100%;padding:0 0 20px}
.sf-orline{position:relative;max-width:1240px;margin:0 auto;height:18px;display:flex;align-items:center;justify-content:center;gap:8px;padding:0 clamp(16px,4vw,56px)}
.sf-orline::before,.sf-orline::after{content:"";flex:1;height:1px;background:linear-gradient(90deg,transparent,rgba(226,180,79,.75))}
.sf-orline::after{transform:scaleX(-1)}
.sf-orline svg{width:28px;height:28px;color:var(--g)}
.sf-orline i{width:5px;height:5px;transform:rotate(45deg);background:var(--g)}
.sf-copy{position:relative;z-index:2;display:flex;align-items:center;justify-content:center;margin-top:12px;padding:0 16px}
.sf-copy::before,.sf-copy::after{content:"";flex:1;max-width:30%;height:1px;background:linear-gradient(90deg,transparent,var(--g))}
.sf-copy::after{transform:scaleX(-1)}
.sf-pill{display:inline-flex;align-items:center;gap:10px;margin:0 12px;padding:8px 24px;border-radius:50px;border:1.5px solid var(--g);background:linear-gradient(180deg,#4A0A20,#2E0412);font:500 12.5px/1.5 system-ui,'Noto Sans Tamil',sans-serif;color:var(--gl);text-align:center;flex-wrap:wrap;justify-content:center;box-shadow:0 5px 14px rgba(0,0,0,.4)}
.sf-pill svg{width:12px;height:12px;flex:none}
.sf-sl{color:var(--g);font-weight:700;letter-spacing:.1em}
.sf-pill a,.sf-pill a:hover{color:var(--gl);font-weight:700;border-bottom:1px solid rgba(246,222,155,.6);transition:color .2s,border-color .2s}
.sf-pill a:hover{color:#fff;border-color:#fff}
.sf-corner{position:absolute;bottom:0;width:clamp(140px,20vw,340px);height:clamp(80px,9vw,150px);pointer-events:none}
.sf-corner.l{left:0}.sf-corner.r{right:0;transform:scaleX(-1)}
.sf-corner svg{width:100%;height:100%}
.sf-cl{position:absolute;bottom:20px;width:44px;height:44px;color:var(--g);z-index:1}
.sf-cl.l{left:clamp(20px,4vw,64px)}.sf-cl.r{right:clamp(20px,4vw,64px);transform:scaleX(-1)}

@media(min-width:1101px){.sf-ct span.t{white-space:nowrap}}
@media(max-width:1100px){
 .sf-card{flex-wrap:wrap;border-radius:36px}
 .sf-vsep{display:none}
 .sf-ctext{flex:1 1 100%}
 .sf-main{grid-template-columns:1fr 1fr;row-gap:30px}
 .sf-col:nth-child(1){grid-column:1/-1;padding:0}
 .sf-col:nth-child(2){padding-left:0}
 .sf-col:nth-child(2)::before,.sf-col:nth-child(2)::after{display:none}
}
/* டேப்ளெட் (701–1100px): முதல் பகுதி (லோகோ + வாசகம் + சமூக ஐகான்கள்) நடுவில் */
@media(min-width:701px) and (max-width:1100px){
 .sf-col:nth-child(1){text-align:center}
 .sf-col:nth-child(1) .sf-logo{justify-content:center}
 .sf-col:nth-child(1) .sf-tag{margin-left:auto;margin-right:auto}
 .sf-col:nth-child(1) .sf-soc.sm{justify-content:center}
}
@media(max-width:700px){
 .sf-orn{display:none}
 .sf-card{flex-direction:column;text-align:center;border-radius:26px;padding:22px 18px}
 .sf-ctext p{margin-left:auto;margin-right:auto}
 .sf-btns{width:100%;justify-content:center}
 .sf-btn{width:100%;justify-content:center}
 .sf-main{grid-template-columns:1fr;text-align:center}
 .sf-col,.sf-col:nth-child(2),.sf-col:nth-child(3){padding:0}
 .sf-col+.sf-col{padding-top:24px;border-top:1px solid rgba(226,180,79,.35)}
 .sf-col+.sf-col::before,.sf-col+.sf-col::after{display:none}
 .sf-logo{flex-direction:column}
 .sf-en{justify-content:center}
 .sf-tag{margin-left:auto;margin-right:auto}
 .sf-soc{justify-content:center}
 .sf-h{justify-content:center}
 .sf-ct{justify-items:start;width:max-content;max-width:100%;margin:0 auto}
 .sf-slogan{transform:rotate(-4deg);transform-origin:center;display:inline-block;text-align:left}
 .sf-copy::before,.sf-copy::after{display:none}
 .sf-pill{margin:0;padding:10px 20px;border-radius:22px;flex-direction:column;gap:2px}
 .sf-sl{display:none}
 .sf-cl{display:none}
}

/* ===== மொபைல் அலைன்மெண்ட் திருத்தங்கள் (டெஸ்க்டாப் மாறாது) ===== */
@media(max-width:700px){
 .sf-top{padding:20px 16px}
 .sf-card{gap:16px;padding:22px 18px;align-items:center}
 .sf-ctext{flex:none;width:100%}
 .sf-ctext h3{font-size:17px}
 .sf-ctext p{font-size:13px;max-width:none}
 .sf-btns{flex:none;width:100%;flex-direction:column;flex-wrap:nowrap;gap:10px}
 .sf-btn,.sf-btn:hover{width:100%;justify-content:center;padding:12px 20px;font-size:14px}
 .sf-main{row-gap:0;padding:24px 20px 20px}
 .sf-col+.sf-col{margin-top:24px;padding-top:24px}
 .sf-logo{gap:12px}
 .sf-tag{max-width:320px;margin:12px auto 0}
 .sf-soc.sm{justify-content:center}
 .sf .sf-h{justify-content:center;width:100%;margin-bottom:18px}
 .sf-ct{gap:12px;justify-items:start;width:max-content;max-width:100%;margin:0 auto;text-align:left}
 .sf-slogan{transform:none;display:block;margin-top:20px;padding-left:0;text-align:center;font-size:20px;white-space:normal}
 .sf-slogan span{padding-left:0}
 .sf-slogan::after{width:60%;margin:5px auto 0;transform:none}
 .sf-corner{width:80px;height:48px}
 .sf-bot{padding-bottom:18px}
 .sf-copy{margin-top:14px;padding:0 16px}
 .sf-pill{width:100%;max-width:340px;font-size:12px;padding:10px 16px}
 .sf-col{width:100%;text-align:center}
 .sf .sf-h{display:flex!important;width:100%}
 .sf-ct{width:100%;max-width:none;margin:0;justify-items:center;text-align:center}
 .sf-ct li{display:flex;justify-content:center;width:100%}
 .sf-ct a,.sf-ct a:hover,.sf-ct div{justify-content:center;text-align:center}
 .sf-col .sf-soc{width:100%;justify-content:center}
}
@media(max-width:380px){
 .sf-tn{font-size:17px}
 .sf-en{letter-spacing:.2em;font-size:10px}
 .sf-card{padding:20px 14px}
 .sf-main{padding:22px 16px 18px}
 .sf-ct span.t{font-size:12.5px}
}
</style>

<footer class="sf">
 <!-- SVG வடிவங்கள் (ஒரே முறை வரையறுக்கப்பட்டவை) -->
 <svg class="sf-defs" aria-hidden="true" focusable="false">
  <defs>
   <linearGradient id="sfGold" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#FBEAB0"/><stop offset=".55" stop-color="#E2B44F"/><stop offset="1" stop-color="#B8862C"/></linearGradient>
   <linearGradient id="sfMar" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#6A0D2B"/><stop offset="1" stop-color="#3A0517"/></linearGradient>
   <symbol id="sfLotus" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.5c2.6 3 2.6 7.5 0 11-2.6-3.5-2.6-8 0-11z"/><path d="M6.6 6.6c.9 4.2 2.8 6.9 5.4 8-3.6.9-6.6-2.2-5.4-8z"/><path d="M17.4 6.6c-.9 4.2-2.8 6.9-5.4 8 3.6.9 6.6-2.2 5.4-8z"/><path d="M2.4 11c2.7.4 6 2.8 9.6 5.2-5.2.7-8.6-1.4-9.6-5.2z"/><path d="M21.6 11c-2.7.4-6 2.8-9.6 5.2 5.2.7 8.6-1.4 9.6-5.2z"/><path d="M7 18.4c2.4 1.1 7.6 1.1 10 0-2 2.7-8 2.7-10 0z"/></symbol>
   <symbol id="sfLeaf" viewBox="0 0 24 24" fill="currentColor"><path d="M21 3C11 3 4.5 7.5 4.5 14.5c0 2 .8 3.8 2 5C7 13.6 11 8.2 21 3z"/><path d="M3 21c1-3.5 3-6.5 6-9" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></symbol>
   <symbol id="sfSprig" viewBox="0 0 90 90" fill="currentColor"><path d="M8 84C26 66 44 46 58 12" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M56 8c-12 4-17 14-14 24 9-4 15-13 14-24z"/><path d="M40 30c-13-1-22 6-24 17 11 1 21-5 24-17z"/><path d="M47 40c10-6 20-4 26 5-9 6-21 5-26-5z"/><path d="M28 54c-12 1-19 9-19 19 10-1 18-8 19-19z"/><path d="M36 58c8-8 20-9 28-1-7 9-20 10-28 1z"/><path d="M60 14c8-2 16 2 20 10-8 3-17 1-20-10z"/></symbol>
   <symbol id="sfArrow" viewBox="0 0 16 16"><path d="M2 8h11M9 3.5 13.5 8 9 12.5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></symbol>
   <symbol id="sfPhone" viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8a15 15 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11 11 0 0 0 3.6.6 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.6 3.6a1 1 0 0 1-.25 1z"/></symbol>
   <symbol id="sfWa" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.2-1.4A10 10 0 1 0 12 2zm5.2 13.8c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .2-3.3-.7-2.8-1.2-4.6-4-4.7-4.2-.1-.2-1.1-1.5-1.1-2.8s.7-2 1-2.3c.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.9 2.1c.1.2.1.4 0 .5l-.4.6c-.1.2-.3.3-.1.6.2.3.8 1.3 1.7 2.1 1.2 1 2.1 1.3 2.4 1.5.3.1.4.1.6-.1l.8-1c.2-.3.4-.2.6-.1l2 1c.3.1.5.2.5.3.1.2.1.8-.1 1.3z"/></symbol>
   <symbol id="sfMail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6.5 8.5 6.5 8.5-6.5"/></symbol>
   <symbol id="sfPin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.6"/></symbol>
   <symbol id="sfGlobe" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="12" r="9"/><ellipse cx="12" cy="12" rx="4" ry="9"/><path d="M3 12h18M4.5 7.5h15M4.5 16.5h15"/></symbol>
   <symbol id="sfInsta" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.3" cy="6.7" r="1.1" fill="currentColor" stroke="none"/></symbol>
   <symbol id="sfYt" viewBox="0 0 24 24" fill="currentColor"><path d="M22 8.2a3 3 0 0 0-2.1-2.1C18 5.6 12 5.6 12 5.6s-6 0-7.9.5A3 3 0 0 0 2 8.2 31 31 0 0 0 1.6 12c0 1.3.1 2.6.4 3.8a3 3 0 0 0 2.1 2.1c1.9.5 7.9.5 7.9.5s6 0 7.9-.5a3 3 0 0 0 2.1-2.1c.3-1.2.4-2.5.4-3.8s-.1-2.6-.4-3.8zM10 15V9l5.2 3z"/></symbol>
   <symbol id="sfTg" viewBox="0 0 24 24" fill="currentColor"><path d="M21.6 3.4 2.9 10.7c-.8.3-.8 1.4 0 1.7l4.6 1.5 1.8 5.6c.2.6 1 .8 1.4.3l2.6-2.6 4.8 3.5c.6.4 1.3.1 1.5-.6L22.9 4.7c.2-.9-.6-1.6-1.3-1.3zM9.6 13.6l8.8-5.4-6.9 6.6-.3 3.1z"/></symbol>
   <symbol id="sfUsers" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="8" r="3.3"/><circle cx="5" cy="9.5" r="2.4"/><circle cx="19" cy="9.5" r="2.4"/><path d="M5.5 19c0-3.3 2.9-5.5 6.5-5.5s6.5 2.2 6.5 5.5z"/><path d="M1.2 17.5c0-2.2 1.6-3.7 3.8-3.9-.7.8-1.1 1.8-1.2 2.9v1z"/><path d="M22.8 17.5c0-2.2-1.6-3.7-3.8-3.9.7.8 1.1 1.8 1.2 2.9v1z"/></symbol>
  </defs>
 </svg>

 <svg class="sf-bgleaf l" viewBox="0 0 90 90" aria-hidden="true"><use href="#sfSprig"/></svg>
 <svg class="sf-bgleaf r" viewBox="0 0 90 90" aria-hidden="true"><use href="#sfSprig"/></svg>

 <!-- மேல் அழைப்பு அட்டை -->
 <div class="sf-top">
  <div class="sf-card">
   <svg class="sf-orn l" viewBox="0 0 90 90" aria-hidden="true"><use href="#sfSprig"/></svg>
   <svg class="sf-orn r" viewBox="0 0 90 90" aria-hidden="true"><use href="#sfSprig"/></svg>
   <svg class="sf-lot" viewBox="0 0 24 24" aria-hidden="true"><use href="#sfLotus"/></svg>
   <div class="sf-ctext">
    <h3>உங்கள் விழாவுக்கு அழகான<br>அழைப்பிதழ் தேவையா?</h3>
    <p>இங்கே, சிறந்த வடிவமைப்புகள், உங்களின் தேவைக்கேற்ற சிறப்பு தரமான சேவைகளை எங்களிடமிருந்து பெறுங்கள்.</p>
   </div>
   <span class="sf-vsep" aria-hidden="true"></span>
   <div class="sf-btns">
    <a class="sf-btn g" href="https://wa.me/<?=ltrim($sfTel,'+')?>" target="_blank" rel="noopener"><svg viewBox="0 0 24 24"><use href="#sfWa"/></svg>WhatsApp<svg class="ar" viewBox="0 0 16 16"><use href="#sfArrow"/></svg></a>
    <a class="sf-btn o" href="tel:<?=$sfTel?>"><svg viewBox="0 0 24 24"><use href="#sfPhone"/></svg>அழைப்புகள்<svg class="ar" viewBox="0 0 16 16"><use href="#sfArrow"/></svg></a>
   </div>
  </div>
 </div>

 <!-- முக்கியப் பகுதி -->
 <div class="sf-main">
  <div class="sf-col">
   <div class="sf-logo">
    <span class="sf-seal sf-logoimg" role="img" aria-label="ஏதேன் அழைப்பிதழ்"></span>
    <div class="sf-brand">
     <div class="sf-tn">ஏதேன் அழைப்பிதழ்</div>
     <div class="sf-en"><span>ATHEN</span><em></em><b>INVITATION</b></div>
    </div>
   </div>
   <p class="sf-tag">உங்கள் சிறந்த தருணங்களை அழகாகவும், மறக்கமுடியாதவையாகவும் மாற்றும் தரமான அழைப்பிதழ்கள்.</p>
  </div>

  <div class="sf-col">
   <h3 class="sf-h"><svg viewBox="0 0 24 24" aria-hidden="true"><use href="#sfPhone"/></svg>தொடர்பு கொள்ளுங்கள்</h3>
   <ul class="sf-ct">
    <li><a href="tel:<?=$sfTel?>"><span class="sf-ic"><svg viewBox="0 0 24 24"><use href="#sfPhone"/></svg></span><span class="t"><?=$sfPhone?></span></a></li>
    <li><div><span class="sf-ic"><svg viewBox="0 0 24 24"><use href="#sfPin"/></svg></span><span class="t addr"><b class="a-ta">26/1, ஸ்ரீனிவாசகம் வளாகம்,<br>பாளையங்கோட்டை, திருநெல்வேலி.</b><span class="a-en">26/1, Srinivasagam Complex,<br>Palayamkottai, Tirunelveli.</span></span></div></li>
   </ul>
  </div>

  <div class="sf-col">
   <h3 class="sf-h"><svg viewBox="0 0 24 24" aria-hidden="true"><use href="#sfUsers"/></svg>எங்களை பின்தொடருங்கள்</h3>
   <div class="sf-slogan">Together Towards<span>a Better Future</span></div>
  </div>
 </div>

 <!-- கீழ்ப் பகுதி -->
 <div class="sf-bot">
  <div class="sf-orline" aria-hidden="true"><i></i><svg viewBox="0 0 24 24"><use href="#sfLotus"/></svg><i></i></div>

  <div class="sf-corner l" aria-hidden="true">
   <svg viewBox="0 0 460 210" preserveAspectRatio="none"><path d="M0 40C70 120 190 190 460 206V210H0z" fill="url(#sfMar)"/><path d="M0 40C70 120 190 190 460 206" fill="none" stroke="url(#sfGold)" stroke-width="2.4"/><path d="M0 70C60 140 180 200 380 209" fill="none" stroke="#E2B44F" stroke-opacity=".5" stroke-width="1.2"/></svg>
  </div>
  <div class="sf-corner r" aria-hidden="true">
   <svg viewBox="0 0 460 210" preserveAspectRatio="none"><path d="M0 40C70 120 190 190 460 206V210H0z" fill="url(#sfMar)"/><path d="M0 40C70 120 190 190 460 206" fill="none" stroke="url(#sfGold)" stroke-width="2.4"/><path d="M0 70C60 140 180 200 380 209" fill="none" stroke="#E2B44F" stroke-opacity=".5" stroke-width="1.2"/></svg>
  </div>
  <svg class="sf-cl l" viewBox="0 0 90 90" aria-hidden="true"><use href="#sfSprig"/></svg>
  <svg class="sf-cl r" viewBox="0 0 90 90" aria-hidden="true"><use href="#sfSprig"/></svg>

  <div class="sf-copy">
   <span class="sf-pill"><span>© ஏதேன் அழைப்பிதழ்</span><span class="sf-sl" aria-hidden="true">//</span><span>© <a href="<?=htmlspecialchars($sfLcUrl,ENT_QUOTES)?>" target="_blank" rel="noopener">Life Changers Ind</a>. All Rights Reserved.</span></span>
  </div>
 </div>
</footer>