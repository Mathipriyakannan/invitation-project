<?php session_start();require __DIR__.'/../includes/config.php';$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){if(hash_equals(ADMIN_USER,(string)($_POST['u']??''))&&hash_equals(ADMIN_PASS,(string)($_POST['p']??''))){session_regenerate_id(true);$_SESSION['adm']=1;header('Location: dashboard.php');exit;}$err='Wrong username or password';}
if(!empty($_SESSION['adm'])){header('Location: dashboard.php');exit;} ?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Login - ATHEN</title>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600&family=Cormorant+Garamond:wght@500;600&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box}html,body{margin:0;min-height:100%}
body{font-family:'Montserrat','Segoe UI',system-ui,sans-serif;min-height:100vh;display:grid;grid-template-columns:53% 47%;background:#f7f8f5;color:#0b4a4e}
/* LEFT */
.brand{position:relative;overflow:hidden;display:grid;place-items:center;text-align:center;padding:40px 24px;color:#fff;background:radial-gradient(ellipse at 35% 55%,#06223a 0,#08304a 45%,#0b4a58 80%,#1b6b6c 100%)}
.brand svg.deco{position:absolute;inset:0;width:100%;height:100%;pointer-events:none}
.bi{position:relative;z-index:1}
.mono{width:min(150px,22vw);height:auto;display:block;margin:0 auto 10px}
.bi h1{margin:0;font-family:'Cinzel',serif;font-weight:600;font-size:clamp(46px,6.2vw,92px);letter-spacing:.04em;line-height:1;color:#fff;text-shadow:0 4px 20px rgba(0,0,0,.35)}
.bi h2{margin:18px 0 0;font-family:'Montserrat';font-weight:400;font-size:clamp(22px,3vw,44px);letter-spacing:.36em;margin-right:-.36em;color:#e3b873}
.adm{display:flex;align-items:center;justify-content:center;gap:22px;margin-top:16px;font-size:clamp(14px,1.7vw,26px);letter-spacing:.5em;font-weight:400;color:#fff}
.adm:before,.adm:after{content:'';height:2px;width:clamp(40px,5.6vw,96px);background:linear-gradient(90deg,transparent,#d9a85f)}.adm:after{transform:scaleX(-1)}
.tag{margin-top:46px;font-size:clamp(11px,1.2vw,18px);display:flex;gap:18px;justify-content:center;flex-wrap:wrap;color:#f2f6f6}.tag i{font-style:normal;color:#e3b873}
/* RIGHT */
.pane{position:relative;display:grid;place-items:center;padding:16px 24px;overflow:hidden;background:radial-gradient(circle at 100% 0,#dfeeea 0,transparent 22%),radial-gradient(circle at 100% 100%,#e3f0ec 0,transparent 18%),#f6f7f4}
.card{position:relative;width:100%;max-width:640px;background:#fafaf8;border-radius:22px;padding:140px 44px 28px;box-shadow:0 20px 60px rgba(11,74,78,.12),0 2px 8px rgba(11,74,78,.05);text-align:center}
.crest{position:absolute;left:50%;top:20px;transform:translateX(-50%);width:104px;height:104px;border-radius:50%;border:3px solid #e2b772;display:grid;place-items:center;background:#fafaf8;box-shadow:0 6px 18px rgba(11,74,78,.2)}
.crest span{width:90px;height:90px;border-radius:50%;background:radial-gradient(circle at 35% 25%,#13706f,#0a4a4f);display:grid;place-items:center}
.crest svg{width:44px;height:44px}
.card h3{margin:0;font-family:'Cinzel',serif;font-weight:600;font-size:clamp(30px,3vw,42px);letter-spacing:.06em;color:#0b5557;line-height:1.15}
.card h4{margin:8px 0 0;font-weight:500;font-size:clamp(17px,1.8vw,27px);letter-spacing:.3em;margin-right:-.3em;color:#0b5557}
.card .sub{margin:14px 0 22px;color:#6f9094;font-size:clamp(14px,1.3vw,19px)}
.err{background:#fde8e1;color:#9e431f;border:1px solid #f1bba6;padding:10px 14px;border-radius:12px;font-size:14px;margin:-14px 0 20px}
form{text-align:left;margin:0}
label{display:flex;align-items:center;gap:10px;font-weight:500;font-size:17px;color:#0b4a4e;margin:0 0 8px}
label svg{width:22px;height:22px;stroke:#0b5557;fill:none;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round}
.f{position:relative;margin-bottom:18px}
.f>svg{position:absolute;left:20px;top:50%;transform:translateY(-50%);width:22px;height:22px;stroke:#0b5557;fill:none;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round}
.f input{width:100%;height:56px;padding:0 54px 0 60px;border:1.5px solid #dde3e1;border-radius:16px;font:inherit;font-size:18px;color:#0b4a4e;background:#fff;transition:.2s}
.f input::placeholder{color:#9db0b2}
.f input:focus{outline:0;border-color:#8fd3cf;box-shadow:0 0 0 4px rgba(120,205,198,.22)}
.eye{position:absolute;right:16px;top:50%;transform:translateY(-50%);border:0;background:none;padding:6px;cursor:pointer;display:grid}
.eye svg{width:26px;height:26px;stroke:#5f8184;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
.go{width:100%;height:58px;margin-top:4px;border:0;border-radius:40px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:12px;font:inherit;font-weight:500;font-size:21px;color:#fff;background:linear-gradient(90deg,#0b5a5d,#0a4a50);box-shadow:0 10px 24px rgba(10,74,80,.28);transition:.2s}
.go:hover{transform:translateY(-2px);box-shadow:0 14px 30px rgba(10,74,80,.35)}
.go svg{width:24px;height:24px;stroke:#fff;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
.sec{display:flex;align-items:center;gap:22px;margin-top:20px;color:#7a9598;font-size:17px;justify-content:center}
.sec:before,.sec:after{content:'';flex:1;max-width:100px;height:1px;background:#cfd8d6}
@media(max-width:900px){body{grid-template-columns:1fr}.brand{padding:36px 20px}.tag{margin-top:22px}.card{padding:136px 24px 26px}.pane{padding:24px 14px 40px}}
</style></head>
<body>
<section class="brand">
<svg class="deco" viewBox="0 0 900 940" preserveAspectRatio="xMidYMid slice" fill="none"><defs><linearGradient id="g1" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#2d7c7a"/><stop offset="1" stop-color="#0d4f58"/></linearGradient><linearGradient id="gl" x1="0" y1="0" x2="1" y2="0"><stop offset="0" stop-color="#8a5a24"/><stop offset=".5" stop-color="#f0cf8e"/><stop offset="1" stop-color="#b98443"/></linearGradient></defs>
<path d="M0 0H300C230 90 110 170 0 195Z" fill="url(#g1)" opacity=".85"/><path d="M300 0C230 90 110 170 0 195" stroke="url(#gl)" stroke-width="2"/>
<path d="M0 765C120 810 230 880 290 940H0Z" fill="url(#g1)" opacity=".8"/><path d="M0 765C120 810 230 880 290 940" stroke="url(#gl)" stroke-width="3"/>
<path d="M900 655C760 700 620 820 540 940H900Z" fill="url(#g1)" opacity=".85"/><path d="M900 655C760 700 620 820 540 940" stroke="url(#gl)" stroke-width="2"/>
<g stroke="#2f6b66" stroke-width="1.5" fill="#164a4d" opacity=".75"><path d="M60 800C50 700 70 600 85 510" fill="none"/><path d="M85 510c-22 30-28 60-12 90 24-26 28-60 12-90Z"/><path d="M62 640c-24 6-48 30-52 64 30 0 54-24 52-64Z"/><path d="M68 590c22-14 42-12 54 6-18 22-42 22-54-6Z"/><path d="M48 760c30-10 60 0 78 28-30 14-62 4-78-28Z"/><path d="M100 800c10-30 36-50 70-52-4 34-28 56-70 52Z"/><path d="M0 690c28 6 48 30 50 60-30-4-50-28-50-60Z"/></g></svg>
<div class="bi">
<svg class="mono" viewBox="0 0 150 140"><defs><linearGradient id="mg" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#f5dca0"/><stop offset=".5" stop-color="#d7a35c"/><stop offset="1" stop-color="#a77335"/></linearGradient></defs>
<path d="M62 6 20 118h16l12-34h44l12 34h18L72 6Z" fill="none"/><text x="14" y="120" font-family="Cormorant Garamond,Georgia,serif" font-size="150" font-weight="500" fill="url(#mg)" textLength="104" lengthAdjust="spacingAndGlyphs">A</text>
<g fill="url(#mg)"><path d="M118 130c14-14 20-40 14-70" stroke="#d7a35c" stroke-width="2" fill="none"/><ellipse cx="127" cy="52" rx="4" ry="9" transform="rotate(-10 127 52)"/><ellipse cx="134" cy="68" rx="4" ry="9" transform="rotate(25 134 68)"/><ellipse cx="122" cy="76" rx="4" ry="9" transform="rotate(-35 122 76)"/><ellipse cx="133" cy="88" rx="4" ry="9" transform="rotate(30 133 88)"/><ellipse cx="120" cy="96" rx="4" ry="9" transform="rotate(-40 120 96)"/><ellipse cx="128" cy="108" rx="4" ry="8" transform="rotate(30 128 108)"/><ellipse cx="116" cy="114" rx="4" ry="8" transform="rotate(-45 116 114)"/></g></svg>
<h1>ATHEN</h1><h2>INVITATION</h2><div class="adm">ADMIN</div>
<div class="tag"><span>Manage Invitations</span><i>•</i><span>Create Memories</span><i>•</i><span>Together</span></div>
</div></section>

<section class="pane"><div class="card">
<div class="crest"><span><svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="3"/><circle cx="5.5" cy="10" r="2"/><circle cx="18.5" cy="10" r="2"/><path d="M6.5 19v-1.5a5.5 5.5 0 0 1 11 0V19Z"/><path d="M2 18.5v-1a3 3 0 0 1 3-3M22 18.5v-1a3 3 0 0 0-3-3"/></svg></span></div>
<h3>ATHEN</h3><h4>INVITATION ADMIN</h4><p class="sub">Sign in to manage cards &amp; messages</p>
<?php if($err): ?><div class="err"><?=htmlspecialchars($err)?></div><?php endif; ?>
<form method="post" autocomplete="off">
<label for="u"><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/></svg>Username</label>
<div class="f"><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/></svg><input id="u" type="text" name="u" placeholder="Enter username" required autofocus></div>
<label for="p"><svg viewBox="0 0 24 24"><rect x="4" y="10" width="16" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/><circle cx="12" cy="15.5" r="1"/></svg>Password</label>
<div class="f"><svg viewBox="0 0 24 24"><rect x="4" y="10" width="16" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/><circle cx="12" cy="15.5" r="1"/></svg><input id="p" type="password" name="p" placeholder="Enter password" required>
<button class="eye" type="button" id="eye" aria-label="Show password"><svg viewBox="0 0 24 24"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg></button></div>
<button class="go" type="submit"><svg viewBox="0 0 24 24"><path d="M14 4h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-5"/><path d="M3 12h11M10 8l4 4-4 4"/></svg>Login</button>
</form>
<div class="sec">Secure Access</div>
</div></section>
<script>var e=document.getElementById('eye'),p=document.getElementById('p');e.onclick=function(){p.type=p.type==='password'?'text':'password'}</script>
</body></html>