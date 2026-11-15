/* ===== View Book (flipbook) =====
   window.AthenBook.open({title:'Card name', code:'W1', pages:['uploads/a.jpg', ...], h:'Heading', s:'Subtitle', c:'Content'})
   pages = every photo of the invitation in order (front page, back page, extra photos).
   h / s / c are optional: when any of them is given, one text page is added right after the front page.
   Desktop / tablet (wider than 820px): real two-page book, right arrow opens the cover and turns the pages.
   Mobile: one page at a time. Keys: left / right arrows, Esc. Touch: swipe. */
(function(){
var el,bk,sl,ttl,cid,pn,pvB,nxB,D=null,mode='two',s=0,MAX=0,N=0,sheets=[],busy=false,pw=0,ph=0,ratio=.62,DUR=920,tok=0,tmr=0,pageList=[],oldOv='';
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
function content(o){var P=(o.pages||[]).filter(Boolean).map(function(u){return{t:'i',src:u}});
 if(o.h||o.s||o.c)P.splice(Math.min(1,P.length),0,{t:'t',h:o.h||'',s:o.s||'',c:o.c||''});return P}
/* ---- size: every page has the same shape as the front photo ---- */
function layout(){var st=el.querySelector('.fb-stage'),aw=st.clientWidth,ah=st.clientHeight-8,m=el.clientWidth>820?'two':'one',r=ratio;
 if(m==='two'){var mw=(aw-2*84)/2;ph=Math.max(120,Math.min(ah,mw/r));pw=ph*r}
 else{var mw1=aw-28;ph=Math.max(120,Math.min(ah,mw1/r));pw=ph*r}
 bk.style.width=(m==='two'?2*pw:pw)+'px';bk.style.height=ph+'px';return m}
/* ---- build the sheets ---- */
function build(startIdx){
 var m=layout();mode=m;var P=pageList,h='',list;
 if(m==='two'){list=P.slice();if(list.length%2)list.push({t:'e'});N=list.length/2;MAX=N;
  for(var k=0;k<N;k++)h+='<div class="fb-sh" data-k="'+k+'"><div class="fb-f">'+pageHtml(list[2*k])+'</div><div class="fb-f b">'+pageHtml(list[2*k+1])+'</div></div>';
  s=startIdx>0?Math.min(MAX,Math.ceil(startIdx/2)):0}
 else{list=P;N=list.length;MAX=Math.max(0,N-1);
  for(var j=0;j<N;j++)h+='<div class="fb-sh one" data-k="'+j+'"><div class="fb-f">'+pageHtml(list[j])+'</div></div>';
  s=Math.min(MAX,Math.max(0,startIdx))}
 bk.innerHTML=h;sheets=[].slice.call(bk.querySelectorAll('.fb-sh'));
 sl.style.transition='none';
 sheets.forEach(function(sh,k){sh.style.transition='none';sh.classList.toggle('fl',k<s)});
 zfix();shift();
 void bk.offsetWidth;
 requestAnimationFrame(function(){sl.style.transition='';sheets.forEach(function(sh){sh.style.transition=''})});
 info()}
function zfix(){sheets.forEach(function(sh,k){sh.style.zIndex=k<s?k+1:N-k})}
/* two-page mode: closed book sits in the middle of the screen */
function shift(){var x=0;if(mode==='two'){if(s===0)x=-pw/2;else if(s===MAX)x=pw/2}sl.style.transform='translateX('+x+'px)'}
function info(){var n=pageList.length,t;
 if(mode==='two'){if(s===0)t='1 / '+n;else{var lo=Math.min(2*s,n),hi=Math.min(2*s+1,n);t=lo===hi?lo+' / '+n:lo+' – '+hi+' / '+n}}
 else t=(s+1)+' / '+n;
 pn.textContent=t;pvB.disabled=s<=0;nxB.disabled=s>=MAX}
function go(d){if(busy||!D)return;var ns=s+d;if(ns<0||ns>MAX)return;busy=true;
 var sh=sheets[d>0?s:s-1];if(sh)sh.style.zIndex=1000;
 s=ns;sheets.forEach(function(x,k){x.classList.toggle('fl',k<s)});shift();info();
 setTimeout(function(){zfix();busy=false},DUR)}
function curIdx(){return mode==='two'?(s===0?0:2*s-1):s}
function refit(){var idx=curIdx(),old=mode,m=layout();
 if(m!==old){busy=false;build(idx);return}
 sl.style.transition='none';shift();void sl.offsetWidth;sl.style.transition=''}
/* ---- open / close ---- */
function open(o){make();D=o;pageList=content(o);if(!pageList.length)return;
 ttl.textContent=o.title||'';cid.textContent=o.code?'ID : '+o.code:'';
 oldOv=document.body.style.overflow;document.body.style.overflow='hidden';
 bk.innerHTML='';pn.textContent='';pvB.disabled=true;nxB.disabled=true;busy=false;
 el.classList.add('on');
 var my=++tok,done=false,first=pageList[0].t==='i'?pageList[0].src:'',im=new Image();
 function fin(){if(done||my!==tok)return;done=true;if(im.naturalWidth&&im.naturalHeight)ratio=Math.min(1.3,Math.max(.45,im.naturalWidth/im.naturalHeight));else ratio=.62;build(0)}
 if(!first){ratio=.62;build(0);return}
 im.onload=fin;im.onerror=fin;setTimeout(fin,2500);im.src=first}
function close(){if(!el)return;tok++;D=null;el.classList.remove('on');bk.innerHTML='';sheets=[];document.body.style.overflow=oldOv}
window.AthenBook={open:open,close:close};
})();
