(function(){
document.documentElement.classList.add('js');
var $=function(s,r){return(r||document).querySelector(s)},$$=function(s,r){return[].slice.call((r||document).querySelectorAll(s))};
var L=[];try{L=JSON.parse(localStorage.getItem('athen_liked')||'[]')}catch(e){}
function toast(m){var t=$('#toast');t.textContent=m;t.classList.add('on');clearTimeout(toast.t);toast.t=setTimeout(function(){t.classList.remove('on')},2800)}
function api(d){return fetch('api/feedback.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(d)}).then(function(r){return r.json()})}
function paint(){$$('.lk').forEach(function(b){var on=L.indexOf(b.dataset.key)>-1;b.classList.toggle('on',on);$('span',b).textContent=on?'♥':'♡'})}
function like(k){var on=L.indexOf(k)<0;if(on)L.push(k);else L.splice(L.indexOf(k),1);try{localStorage.setItem('athen_liked',JSON.stringify(L))}catch(e){}paint();
 api({action:on?'like':'unlike',key:k}).then(function(r){if(r.ok)$$('.lk[data-key="'+k+'"] em').forEach(function(e){e.textContent=r.count});if(on)toast('❤ லைக் செய்தீர்கள்! கடைக்குத் தெரிவிக்கப்பட்டது')}).catch(function(){toast('இணைப்பு பிழை')})}
var mo=$('#mo'),cur=null;
function open(c){cur=c.dataset.key;$('#mph').innerHTML=$('.ph',c).innerHTML;$('#mpv').style.cssText=c.getAttribute('style');$('#mn').textContent=c.dataset.name;$('#mdsc').textContent=c.dataset.desc;$('#mp').textContent=c.dataset.price;
 var b=$('#mlk');b.dataset.key=cur;$('em',b).textContent=$('.lk em',c).textContent;mo.classList.remove('sent');$('#mform').reset();paint();mo.classList.add('on');document.body.style.overflow='hidden'}
function close(){mo.classList.remove('on');document.body.style.overflow=''}
document.addEventListener('click',function(e){
 if(e.target.closest('.wa'))return;
 var lk=e.target.closest('.lk');if(lk){e.stopPropagation();like(lk.dataset.key);return}
 var c=e.target.closest('.card');if(c&&!c.classList.contains('mpv')){open(c);return}
 if(e.target===mo||e.target.id==='mx')close()});
document.addEventListener('keydown',function(e){if(e.key==='Escape')close()});
$('#mform').addEventListener('submit',function(e){e.preventDefault();var f=new FormData(this),btn=$('button[type=submit]',this);btn.disabled=true;
 api({action:'message',key:cur,name:f.get('name'),phone:f.get('phone'),message:f.get('message')}).then(function(r){btn.disabled=false;if(r.ok){mo.classList.add('sent')}else toast('செய்தியை எழுதவும்')}).catch(function(){btn.disabled=false;toast('இணைப்பு பிழை')})});
var cf=$('#cform');if(cf)cf.addEventListener('submit',function(e){e.preventDefault();var f=new FormData(cf);
 api({action:'contact',name:f.get('name'),phone:f.get('phone'),message:f.get('message')}).then(function(r){if(r.ok){cf.reset();toast('நன்றி! உங்கள் செய்தி அனுப்பப்பட்டது.')}else toast('செய்தியை எழுதவும்')})});
paint();
var it=$('#intro');if(it){var seen=0;try{seen=sessionStorage.getItem('athen_intro')}catch(e){}
 if(seen)it.remove();else{document.body.style.overflow='hidden';var fin=function(){try{sessionStorage.setItem('athen_intro','1')}catch(e){}it.classList.add('out');document.body.style.overflow='';setTimeout(function(){it.remove()},950)};
 $('#seal').onclick=function(){it.classList.add('open');setTimeout(fin,2600)};$('#skip').onclick=fin}}
if(window.matchMedia&&matchMedia('(hover:hover)').matches)$$('.card:not(.mpv)').forEach(function(c){c.addEventListener('mousemove',function(e){var r=c.getBoundingClientRect();c.style.setProperty('--ry',((e.clientX-r.left)/r.width-.5)*10+'deg');c.style.setProperty('--rx',(.5-(e.clientY-r.top)/r.height)*8+'deg')});c.addEventListener('mouseleave',function(){c.style.setProperty('--rx','0deg');c.style.setProperty('--ry','0deg')})});
var io='IntersectionObserver' in window?new IntersectionObserver(function(es){es.forEach(function(x){if(x.isIntersecting){x.target.classList.add('in');io.unobserve(x.target)}})},{threshold:.12}):null;
$$('.rv').forEach(function(el,i){if(io){el.style.transitionDelay=(i%4)*90+'ms';io.observe(el)}else el.classList.add('in')});
})();
