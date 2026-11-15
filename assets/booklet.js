/* புக்லெட் (flipbook): முகப்பில் உள்ள 5 கார்டில் எதையாவது (அல்லது "மேலும் காண்க") கிளிக் செய்தால் திறக்கும் */
(function(){
var D=window.ATHEN_BK||{},bk=document.getElementById('bk');if(!bk)return;
var Lh=bk.querySelector('.bk-L'),Rh=bk.querySelector('.bk-R'),leaf=bk.querySelector('.bk-leaf'),
 ttl=bk.querySelector('.bk-ttl b'),dots=bk.querySelector('.bk-dots'),pv=bk.querySelector('.bk-nv.prev'),nx=bk.querySelector('.bk-nv.next');
var cat=null,cur=0,busy=false,mq=window.matchMedia('(max-width:760px)');
function esc(t){var d=document.createElement('div');d.textContent=t;return d.innerHTML}
function sty(c){return '--c1:'+c.c1+';--c2:'+c.c2}
/* படம் இல்லை / திறக்கவில்லை என்றால் வரும் டிசைன் கார்டு */
function hasP(c){return !!(c.pages&&c.pages.length)}
function N(c){return hasP(c)?c.pages.length:c.words.length}
function fb(c,i){var w=hasP(c)?(c.pages[i].h||c.pages[i].s||''):(c.words[i]||'');return '<div class="bk-fb" style="'+sty(c)+'"><i>'+c.icon+'</i><em>'+esc(c.sub.toUpperCase())+'</em><b>'+esc(c.title)+'<br>அழைப்பிதழ்</b><s></s><span>'+esc(w)+'</span></div>'}
function right(i){var c=D[cat],u=hasP(c)?c.pages[i].img:c.images[i];
 return '<div class="bk-pr"><div class="fr" data-i="'+i+'">'+(u?'<img src="'+esc(u)+'" alt="'+esc(c.title)+' அழைப்பிதழ் '+(i+1)+'" referrerpolicy="no-referrer" loading="eager">':fb(c,i))+'</div></div>'}
/* அட்மின் "Book" பக்கம்: இடது பக்கம் = சப் இமேஜ் (முன்/பின்) + தலைப்பு, துணைத்தலைப்பு, உள்ளடக்கம் (எல்லாம் ஆப்ஷனல்) */
function leftP(i){var c=D[cat],p=c.pages[i],n=c.pages.length,hasT=!!(p.h||p.s||p.c),hasB=!!p.back;
 var th=function(u,lab){return '<div class="bk-mc bki"><img src="'+esc(u)+'" alt="'+lab+'" referrerpolicy="no-referrer" loading="eager"><small>'+lab+'</small></div>'};
 var pv=hasB?'<div class="bk-pv">'+th(p.img,'முன்பக்கம்')+th(p.back,'பின்பக்கம்')+'</div>':'';
 var tx=hasT?'<div class="bk-dv"><span></span></div>'+(p.h?'<h3 class="bk-h">'+esc(p.h)+'</h3>':'')+(p.s?'<h4 class="bk-s">'+esc(p.s)+'</h4>':'')+(p.c?'<div class="bk-c">'+esc(p.c)+'</div>':''):
  (hasB?'':'<div class="bk-emp"><i>✝</i><b>ஏதேன்<br>அழைப்பிதழ்</b><div class="bk-dv"><span></span></div></div>');
 return '<div class="bk-pl'+(hasB?'':' nopv')+'" style="'+sty(c)+'">'+pv+'<div class="bk-wd">'+tx+'<small>ஏதேன் அழைப்பிதழ் · '+(i+1)+' / '+n+'</small></div></div>'}
function left(i){var c=D[cat];if(hasP(c))return leftP(i);
 return '<div class="bk-pl" style="'+sty(c)+'"><div class="bk-pv">'+
  '<div class="bk-mc"><i>'+c.icon+'</i><b>'+esc(c.title)+'<br>அழைப்பிதழ்</b><small>முன்பக்கம்</small></div>'+
  '<div class="bk-mc bkb"><i>✝</i><b>ATHEN</b><small>பின்பக்கம்</small></div></div>'+
  '<div class="bk-wd"><div class="bk-dv"><span></span></div><p>'+esc(c.words[i])+'</p><small>ஏதேன் அழைப்பிதழ் · '+(i+1)+' / '+c.words.length+'</small></div></div>'}
/* படம் ஏற்றம் தோல்வி → டிசைன் கார்டு */
function guard(root){[].forEach.call(root.querySelectorAll('.bk-pr .fr img'),function(im){
 im.addEventListener('error',function(){var f=im.parentNode;f.innerHTML=fb(D[cat],+f.dataset.i)})})}
function put(el,html){el.innerHTML=html;guard(el)}
function paint(){pv.disabled=cur<=0;nx.disabled=cur>=N(D[cat])-1;
 [].forEach.call(dots.querySelectorAll('i'),function(d,k){d.classList.toggle('on',k===cur)});
 dots.querySelector('em').textContent=(cur+1)+' / '+N(D[cat])}
function show(i){cur=i;put(Lh,left(i));put(Rh,right(i));paint()}
function go(n,dir){if(busy||n<0||n>=N(D[cat])||n===cur)return;
 if(mq.matches){bk.style.setProperty('--dx',(dir>0?'28px':'-28px'));show(n);[Lh,Rh].forEach(function(e){e.classList.remove('bk-fade');void e.offsetWidth;e.classList.add('bk-fade')});return}
 busy=true;var t=null;
 if(dir>0){put(leaf,'');leaf.innerHTML='<div class="f">'+right(cur)+'</div><div class="b">'+left(n)+'</div>';guard(leaf);put(Rh,right(n));
  leaf.style.transition='none';leaf.style.transform='rotateY(0deg)';leaf.style.display='block';void leaf.offsetWidth;
  leaf.classList.remove('go');void leaf.offsetWidth;leaf.classList.add('go');leaf.style.transition='transform .85s cubic-bezier(.55,.05,.25,1)';leaf.style.transform='rotateY(-180deg)';
  t=function(){put(Lh,left(n));leaf.style.display='none';cur=n;paint();busy=false}}
 else{leaf.innerHTML='<div class="f">'+right(n)+'</div><div class="b">'+left(cur)+'</div>';guard(leaf);put(Lh,left(n));
  leaf.style.transition='none';leaf.style.transform='rotateY(-180deg)';leaf.style.display='block';void leaf.offsetWidth;
  leaf.classList.remove('go');void leaf.offsetWidth;leaf.classList.add('go');leaf.style.transition='transform .85s cubic-bezier(.55,.05,.25,1)';leaf.style.transform='rotateY(0deg)';
  t=function(){put(Rh,right(n));leaf.style.display='none';cur=n;paint();busy=false}}
 setTimeout(t,880)}
function open(k){if(!D[k])return;cat=k;var c=D[k];ttl.textContent=c.title+' அழைப்பிதழ்';
 var tot=N(c),dh='';if(tot<=14)for(var q=0;q<tot;q++)dh+='<i data-i="'+q+'"></i>';dots.innerHTML=dh+'<em></em>';
 leaf.style.display='none';busy=false;show(0);bk.classList.add('on');document.body.style.overflow='hidden'}
function close(){bk.classList.remove('on');document.body.style.overflow='';busy=false;leaf.style.display='none'}
pv.addEventListener('click',function(){go(cur-1,-1)});nx.addEventListener('click',function(){go(cur+1,1)});
bk.querySelector('.bk-x').addEventListener('click',close);
bk.addEventListener('click',function(e){if(e.target===bk)close();var d=e.target.closest('.bk-dots i');if(d){var n=+d.dataset.i;go(n,n>cur?1:-1)}});
document.addEventListener('keydown',function(e){if(!bk.classList.contains('on'))return;
 if(e.key==='Escape')close();else if(e.key==='ArrowRight')go(cur+1,1);else if(e.key==='ArrowLeft')go(cur-1,-1)});
var sx=null;bk.addEventListener('touchstart',function(e){sx=e.touches[0].clientX},{passive:true});
bk.addEventListener('touchend',function(e){if(sx===null)return;var dx=e.changedTouches[0].clientX-sx;sx=null;if(Math.abs(dx)>50)dx<0?go(cur+1,1):go(cur-1,-1)});
mq.addEventListener&&mq.addEventListener('change',function(){if(bk.classList.contains('on')){busy=false;leaf.style.display='none';show(cur)}});
/* கார்டு அல்லது "மேலும் காண்க" கிளிக் → புக்லெட் */
document.addEventListener('click',function(e){var a=e.target.closest('a[href^="products.php?type="]');if(!a)return;
 var k=(a.getAttribute('href').split('type=')[1]||'').split('&')[0];if(!D[k])return;e.preventDefault();open(k)});
})();
