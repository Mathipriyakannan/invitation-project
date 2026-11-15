/* ===== View Book (flipbook) - digital-edition style =====
   window.AthenBook.open({title:'Card name', code:'W1', pages:['uploads/a.jpg', ...], h:'Heading', s:'Subtitle', c:'Content'})
   pages = every photo of the invitation in order (front page, back page, extra photos) - added from the admin side.
   Desktop / tablet (wider than 820px): real two-page book.
     - closed book = front photo (centered)
     - right arrow opens it: LEFT page = content only, RIGHT page = one photo
     - every next click turns the page: LEFT = content only, RIGHT = next photo
   Mobile: one page at a time (front photo, content, next photos...). Swipe or use the arrows.
   Keys: left / right arrows, Esc. Click right / left half of the book also turns the page. */
(function(){
var el,bk,sl,ttl,cid,pn,pvB,nxB,D=null,mode='two',s=0,MAX=0,N=0,sheets=[],busy=false,pw=0,ph=0,ratio=.62,DUR=900,tok=0,tmr=0,imgs=[],txt=null,oldOv='';
var AL='<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>',
    AR='<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>';
function esc(t){var d=document.createElement('div');d.textContent=t==null?'':String(t);return d.innerHTML}
function make(){if(el)return;
 el=document.createElement('div');el.className='fb';el.setAttribute('role','dialog');el.setAttribute('aria-modal','true');el.setAttribute('aria-label','View Book');
 el.innerHTML='<div class="fb-top"><div class="fb-ttl"><b></b><span></span></div><button type="button" class="fb-x" aria-label="Close">✕</button></div>'+
  '<div class="fb-stage"><div class="fb-sl"><div class="fb-bk"></div></div></div>'+
  '<button type="button" class="fb-nv prev" aria-label="முந்தைய பக்கம்">'+AL+'</button><button type="button" class="fb-nv next" aria-label="அடுத்த பக்கம்">'+AR+'</button>'+
  '<div class="fb-bot"><span class="fb-pn"></span></div>';
 document.body.appendChild(el);
 bk=el.querySelector('.fb-bk');sl=el.querySelector('.fb-sl');ttl=el.querySelector('.fb-ttl b');cid=el.querySelector('.fb-ttl span');pn=el.querySelector('.fb-pn');pvB=el.querySelector('.fb-nv.prev');nxB=el.querySelector('.fb-nv.next');
 el.querySelector('.fb-x').addEventListener('click',close);
 pvB.addEventListener('click',function(e){e.stopPropagation();go(-1)});nxB.addEventListener('click',function(e){e.stopPropagation();go(1)});
 bk.addEventListener('click',function(e){if(e.target.closest('.fb-ct'))return;var r=bk.getBoundingClientRect();go(e.clientX-r.left>r.width/2?1:-1)});
 var x0=null,y0=0;
 el.addEventListener('touchstart',function(e){var t=e.touches[0];x0=t.clientX;y0=t.clientY},{passive:true});
 el.addEventListener('touchend',function(e){if(x0===null)return;var t=e.changedTouches[0],dx=t.clientX-x0,dy=t.clientY-y0;x0=null;if(Math.abs(dx)>50&&Math.abs(dx)>Math.abs(dy)*1.3){e.preventDefault();go(dx<0?1:-1)}});
 document.addEventListener('keydown',function(e){if(!el.classList.contains('on'))return;
  if(e.key==='Escape'){e.stopImmediatePropagation();e.preventDefault();close()}
  else if(e.key==='ArrowRight'){e.stopImmediatePropagation();go(1)}
  else if(e.key==='ArrowLeft'){e.stopImmediatePropagation();go(-1)}},true);
 window.addEventListener('resize',function(){if(!el.classList.contains('on')||!D)return;clearTimeout(tmr);tmr=setTimeout(refit,160)});
 window.addEventListener('orientationchange',function(){if(el.classList.contains('on')&&D){clearTimeout(tmr);tmr=setTimeout(refit,300)}})}
/* ---- pages ---- */
function pageHtml(p){
 if(!p)return '';
 if(p.t==='i')return '<div class="fb-pg"><img src="'+esc(p.src)+'" alt="" draggable="false"></div>';
 if(p.t==='t')return '<div class="fb-pg fb-tx"><small>ஏதேன் அழைப்பிதழ்</small>'+(p.h?'<h3>'+esc(p.h)+'</h3>':'')+'<div class="fb-dv"><i></i></div>'+(p.s?'<h4>'+esc(p.s)+'</h4>':'')+(p.c?'<div class="fb-ct">'+esc(p.c)+'</div>':'')+'</div>';
 return '<div class="fb-pg fb-br"><i>✝</i><b>ஏதேன்<br>அழைப்பிதழ்</b><div class="fb-dv"><i></i></div><em>ATHEN INVITATION</em></div>'}
function TXT(){return{t:'t',h:txt.h,s:txt.s,c:txt.c}}
function content(o){imgs=(o.pages||[]).filter(Boolean);
 txt={h:o.h||o.title||'',s:o.s||'',c:o.c||''}}
/* ---- size: every page has the same shape as the front photo ---- */
function layout(){var st=el.querySelector('.fb-stage'),aw=st.clientWidth,ah=st.clientHeight-8,m=el.clientWidth>820?'two':'one',r=ratio;
 if(m==='two'){var mw=(aw-2*84)/2;ph=Math.max(120,Math.min(ah,mw/r));pw=ph*r}
 else{var mw1=aw-28;ph=Math.max(120,Math.min(ah,mw1/r));pw=ph*r}
 bk.style.width=(m==='two'?2*pw:pw)+'px';bk.style.height=ph+'px';return m}
/* ---- build the sheets ----
   two-page book: sheet k = front: photo k (right page)  /  back: content (left page of the next spread)
   so spread k = [content | photo k] */
function build(ii){
 var m=layout();mode=m;var n=imgs.length,h='',list=[],k;
 if(m==='two'){
  for(k=0;k<n;k++){list.push({t:'i',src:imgs[k]});list.push(k<n-1||n===1?TXT():{t:'e'})}
  N=n;MAX=n===1?1:n-1;
  for(k=0;k<N;k++)h+='<div class="fb-sh" data-k="'+k+'"><div class="fb-f">'+pageHtml(list[2*k])+'</div><div class="fb-f b">'+pageHtml(list[2*k+1])+'</div></div>';
  s=Math.min(MAX,Math.max(0,ii))}
 else{
  list.push({t:'i',src:imgs[0]});list.push(TXT());for(k=1;k<n;k++)list.push({t:'i',src:imgs[k]});
  N=list.length;MAX=N-1;
  for(k=0;k<N;k++)h+='<div class="fb-sh one" data-k="'+k+'"><div class="fb-f">'+pageHtml(list[k])+'</div></div>';
  s=ii<=0?0:Math.min(MAX,ii+1)}
 bk.innerHTML=h;sheets=[].slice.call(bk.querySelectorAll('.fb-sh'));
 sl.style.transition='none';
 sheets.forEach(function(sh,k){sh.style.transition='none';sh.classList.toggle('fl',k<s)});
 zfix();shift();
 void bk.offsetWidth;
 requestAnimationFrame(function(){sl.style.transition='';sheets.forEach(function(sh){sh.style.transition=''})});
 info()}
function zfix(){sheets.forEach(function(sh,k){sh.style.zIndex=k<s?k+1:N-k})}
/* two-page mode: the closed book (front photo only) sits in the middle of the screen */
function shift(){var x=0;if(mode==='two'&&s===0)x=-pw/2;sl.style.transform='translateX('+x+'px)'}
function curImg(){var n=imgs.length;if(mode==='two')return Math.min(s,n-1);return s<=1?0:s-1}
function info(){pn.textContent=(curImg()+1)+' / '+imgs.length;pvB.disabled=s<=0;nxB.disabled=s>=MAX}
function go(d){if(busy||!D)return;var ns=s+d;if(ns<0||ns>MAX)return;busy=true;
 var sh=sheets[d>0?s:s-1];if(sh){sh.style.zIndex=1000;sh.classList.add('tn');setTimeout(function(){sh.classList.remove('tn')},DUR)}
 s=ns;sheets.forEach(function(x,k){x.classList.toggle('fl',k<s)});shift();info();
 setTimeout(function(){zfix();busy=false},DUR)}
function refit(){var ii=curImg(),old=mode,m=layout();
 if(m!==old){busy=false;build(ii);return}
 sl.style.transition='none';shift();void sl.offsetWidth;sl.style.transition=''}
/* ---- open / close ---- */
function open(o){make();D=o;content(o);if(!imgs.length)return;
 ttl.textContent=o.title||'';cid.textContent=o.code?'ID : '+o.code:'';
 oldOv=document.body.style.overflow;document.body.style.overflow='hidden';
 bk.innerHTML='';pn.textContent='';pvB.disabled=true;nxB.disabled=true;busy=false;
 el.classList.add('on');
 imgs.forEach(function(u,i){if(i>0){var p=new Image();p.src=u}});
 var my=++tok,done=false,im=new Image();
 function fin(){if(done||my!==tok)return;done=true;if(im.naturalWidth&&im.naturalHeight)ratio=Math.min(1.3,Math.max(.45,im.naturalWidth/im.naturalHeight));else ratio=.62;build(0)}
 im.onload=fin;im.onerror=fin;setTimeout(fin,2500);im.src=imgs[0]}
function close(){if(!el)return;tok++;D=null;el.classList.remove('on');bk.innerHTML='';sheets=[];document.body.style.overflow=oldOv}
window.AthenBook={open:open,close:close};
})();