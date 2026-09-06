<?php
require_once __DIR__ . '/includes/auth.php';

$mmStyles = <<<CSS
@import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Manrope:wght@400;500;600;700&display=swap');

.mm-page{
    --ink:#F5F7FB;
    --ink-soft:#FFFFFF;
    --ink-line: rgba(23,32,51,.12);
    --paper:#172033;
    --slate:#68778D;
    --amber:#F2B84B;
    --amber-soft: rgba(242,184,75,.16);
    --teal:#4FD1AE;
    --radius: 14px;
    font-family: 'Manrope', system-ui, sans-serif;
    color: var(--paper);
    background: var(--ink);
    overflow-x: hidden;
}
html[data-theme='dark'] .mm-page{
    --ink:#0B1220;
    --ink-soft:#101B2D;
    --ink-line: rgba(237,231,216,.12);
    --paper:#EDE7D8;
    --slate:#8FA3BE;
}
.mm-page *{ box-sizing: border-box; }
.mm-page h1, .mm-page h2, .mm-page .mm-display{
    font-family: 'Fraunces', Georgia, serif;
    font-weight: 500;
    letter-spacing: -0.01em;
    line-height: 1.05;
    margin: 0;
    color: var(--paper);
}
.mm-page p{ color: var(--slate); line-height: 1.65; margin: 0; }
.mm-page a{ text-decoration: none; }
.mm-public-nav{
    max-width:1180px; margin:0 auto; padding:1.25rem 1.5rem 0;
    display:flex; align-items:center; justify-content:space-between; gap:1rem;
}
.mm-public-brand{ display:inline-flex; align-items:center; gap:.65rem; color:var(--paper); font-weight:700; letter-spacing:-.02em; }
.mm-public-brand-mark{ width:34px; height:34px; border-radius:11px; display:grid; place-items:center; color:#14100A; background:linear-gradient(135deg,#F2B84B,#E8992C); box-shadow:0 8px 20px -10px rgba(242,184,75,.8); }
.mm-public-brand small{ display:block; color:var(--slate); font-size:.64rem; font-weight:500; letter-spacing:.02em; }
.mm-public-links{ display:flex; align-items:center; gap:1.35rem; }
.mm-public-links > a:not(.mm-btn){ color:var(--slate); font-size:.82rem; font-weight:600; }
.mm-public-links > a:not(.mm-btn):hover{ color:var(--paper); }
.mm-nav-login{ color:var(--paper)!important; }
.mm-mark{
    display:inline-flex; align-items:center; gap:.5rem;
    font-size: .82rem; color: var(--amber); font-weight: 600;
    margin-bottom: 1.1rem;
}
.mm-mark::before{
    content:''; width: 7px; height: 7px; border-radius: 50%;
    background: var(--amber); box-shadow: 0 0 0 4px var(--amber-soft);
    flex-shrink: 0;
}
.mm-btn{
    display:inline-flex; align-items:center; justify-content:center; gap:.6rem;
    padding: .9rem 1.6rem; border-radius: 999px; font-weight: 600; font-size: .98rem;
    border: 1px solid transparent; transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
    cursor:pointer;
}
.mm-btn-primary{
    background: linear-gradient(135deg, #F2B84B, #E8992C);
    color: #14100A;
    box-shadow: 0 10px 30px -12px rgba(242,184,75,.55);
}
.mm-btn-primary:hover{ transform: translateY(-2px); box-shadow: 0 16px 34px -12px rgba(242,184,75,.7); }
.mm-btn-ghost{
    background: transparent; color: var(--paper); border-color: var(--ink-line);
}
.mm-btn-ghost:hover{ border-color: rgba(237,231,216,.35); background: rgba(237,231,216,.04); }

/* ---------- Welcome back (logged in) ---------- */
.mm-welcome{
    min-height: 78vh; display:flex; align-items:center; justify-content:center; text-align:center;
    padding: 6rem 1.5rem; position:relative;
}
.mm-welcome::before{
    content:''; position:absolute; inset:0;
    background-image: radial-gradient(circle, rgba(237,231,216,.07) 1px, transparent 1px);
    background-size: 26px 26px;
    mask-image: radial-gradient(ellipse 60% 60% at 50% 45%, black, transparent);
    pointer-events:none;
}
.mm-welcome-inner{ position:relative; max-width: 620px; }
.mm-welcome h1{ font-size: clamp(2.2rem, 4vw, 3.2rem); margin: .6rem 0 1.1rem; }
.mm-welcome h1 span{ color: var(--teal); }
.mm-pin{
    width: 54px; height: 54px; margin: 0 auto 1.4rem; border-radius: 50%;
    background: var(--ink-soft); border: 1px solid var(--ink-line);
    display:flex; align-items:center; justify-content:center; color: var(--teal); font-size: 1.2rem;
}
.mm-welcome p.lead{ font-size: 1.08rem; margin-bottom: 2rem; }

/* ---------- Hero ---------- */
.mm-hero{
    display:grid; grid-template-columns: 1.05fr .95fr; gap: 3.5rem; align-items:center;
    max-width: 1180px; margin: 0 auto; padding: 6rem 1.5rem 5rem;
}
.mm-hero h1{ font-size: clamp(2.6rem, 4.4vw, 3.75rem); }
.mm-hero h1 span{ color: var(--amber); }
.mm-hero-copy p{ font-size: 1.08rem; max-width: 46ch; margin-top: 1.3rem; }
.mm-hero-copy .mm-mark{ margin-bottom:.9rem; }
.mm-hero-actions{ display:flex; align-items:center; gap: 1.4rem; margin-top: 2.2rem; flex-wrap: wrap; }
.mm-hero-trust{ display:flex; gap: 1.6rem; margin-top: 2.4rem; flex-wrap: wrap; }
.mm-hero-trust span{ display:flex; align-items:center; gap:.5rem; font-size:.85rem; color: var(--slate); }
.mm-hero-trust i{ color: var(--teal); }

.mm-hero-art{
    position:relative; background: var(--ink-soft); border: 1px solid var(--ink-line);
    border-radius: 22px; padding: 2rem; min-height: 420px; overflow:hidden;
}
.mm-hero-art::before{
    content:''; position:absolute; inset:-40% -40% auto auto; width: 70%; padding-bottom: 70%;
    border-radius: 40% 60% 55% 45% / 50% 45% 55% 50%;
    border: 1px dashed rgba(237,231,216,.14);
}
.mm-hero-art::after{
    content:''; position:absolute; inset: auto auto -30% -20%; width: 55%; padding-bottom: 55%;
    border-radius: 55% 45% 50% 50% / 45% 55% 45% 55%;
    border: 1px dashed rgba(79,209,174,.16);
}
.mm-hero-label{
    display:flex; align-items:center; gap:.6rem; font-size:.82rem; color: var(--slate);
    position:relative; z-index:2;
}
.mm-hero-label strong{ color: var(--paper); font-weight: 600; }
.mm-live{ width:7px; height:7px; border-radius:50%; background: var(--teal); position:relative; }
.mm-live::after{
    content:''; position:absolute; inset:-5px; border-radius:50%; border:1px solid var(--teal);
    animation: mm-ping 2.2s ease-out infinite;
}
@keyframes mm-ping{ 0%{ transform:scale(.6); opacity:.9;} 100%{ transform:scale(2.4); opacity:0;} }

.mm-route-svg{ position:relative; z-index:1; width:100%; height:150px; margin-top: .5rem; }
.mm-route-svg path{
    fill:none; stroke: var(--amber); stroke-width:2; stroke-linecap:round;
    stroke-dasharray: 6 8; stroke-dashoffset: 500; animation: mm-draw 2.2s ease forwards .3s;
}
@keyframes mm-draw{ to{ stroke-dashoffset: 0; } }
.mm-route-svg circle{ fill: var(--ink-soft); stroke: var(--amber); stroke-width:2; }

.mm-stat{
    position:relative; z-index:2; background: var(--ink);
    border: 1px solid var(--ink-line); border-radius: 16px; padding: 1.1rem 1.3rem;
}
.mm-stat-main{ margin-top: -1.6rem; }
.mm-stat small{ display:block; font-size:.7rem; letter-spacing:.03em; color: var(--slate); margin-bottom:.4rem; }
.mm-stat strong{ font-family:'Fraunces',serif; font-size: 1.7rem; font-weight:500; }
.mm-stat span{ display:flex; align-items:center; gap:.35rem; font-size:.78rem; color: var(--teal); margin-top:.3rem; }
.mm-stat-float{
    position:absolute; right: 1.6rem; bottom: 1.6rem; width: 170px;
}
.mm-stat-float span{ color: var(--slate); }
.mm-bars{ display:flex; align-items:flex-end; gap:4px; height: 22px; margin-top:.6rem; }
.mm-bars i{ flex:1; background: var(--amber-soft); border-radius: 2px; }
.mm-bars i:nth-child(1){height:35%;} .mm-bars i:nth-child(2){height:55%;} .mm-bars i:nth-child(3){height:40%;}
.mm-bars i:nth-child(4){height:75%;background:var(--amber);} .mm-bars i:nth-child(5){height:60%;}
.mm-bars i:nth-child(6){height:85%;background:var(--amber);} .mm-bars i:nth-child(7){height:65%;}

/* ---------- The route (features) ---------- */
.mm-route-band{ padding: 5rem 1.5rem; max-width: 1180px; margin:0 auto; }
.mm-route-band{ scroll-margin-top:2rem; }
.mm-section-head{ max-width: 560px; margin-bottom: 3.2rem; }
.mm-section-head h2{ font-size: clamp(1.9rem, 3vw, 2.5rem); margin: .5rem 0 .8rem; }
.mm-stops{
    display:grid; grid-template-columns: repeat(4, 1fr); gap: 1.6rem; position:relative;
}
.mm-stops::before{
    content:''; position:absolute; top: 22px; left: 6%; right: 6%; height:1px;
    background: repeating-linear-gradient(90deg, var(--ink-line) 0 10px, transparent 10px 18px);
}
.mm-stop{ position:relative; padding-top: 3rem; }
.mm-stop-dot{
    position:absolute; top:0; left:0; width: 44px; height:44px; border-radius:50%;
    background: var(--ink-soft); border: 1px solid var(--ink-line);
    display:flex; align-items:center; justify-content:center; color: var(--amber); font-size:1.05rem;
    z-index:1;
}
.mm-stop-num{ position:absolute; top: 4px; left: 48px; font-size:.72rem; color: var(--slate); font-weight:600; }
.mm-stop h3{ font-family:'Fraunces',serif; font-size:1.2rem; font-weight:500; margin: .3rem 0 .5rem; color: var(--paper); }
.mm-stop p{ font-size: .92rem; }

/* ---------- Closing band ---------- */
.mm-cta-band{
    position:relative; margin: 0 1.5rem 5rem; padding: 4rem 2.5rem; border-radius: 24px;
    background: var(--ink-soft); border: 1px solid var(--ink-line);
    display:flex; align-items:center; justify-content:space-between; gap: 2rem; flex-wrap: wrap;
    overflow:hidden;
}
.mm-cta-band::before{
    content:''; position:absolute; inset:0; opacity:.5;
    background-image: linear-gradient(var(--ink-line) 1px, transparent 1px), linear-gradient(90deg, var(--ink-line) 1px, transparent 1px);
    background-size: 42px 42px;
    mask-image: radial-gradient(ellipse 80% 100% at 20% 50%, black, transparent);
    pointer-events:none;
}
.mm-cta-band > *{ position:relative; z-index:1; }
.mm-cta-band h2{ font-size: clamp(1.9rem, 3vw, 2.5rem); position:relative; max-width: 480px; }

@media (max-width: 900px){
    .mm-hero{ grid-template-columns: 1fr; padding-top: 4rem; }
    .mm-stops{ grid-template-columns: 1fr; }
    .mm-stops::before{ display:none; }
    .mm-stat-float{ position: static; margin-top: 1rem; width:auto; }
}
@media (max-width: 640px){
    .mm-public-nav{ padding:1rem 1rem 0; }
    .mm-public-links{ gap:.7rem; }
    .mm-public-links > a:not(.mm-btn){ display:none; }
    .mm-public-links .mm-btn{ padding:.65rem .95rem; font-size:.78rem; }
    .mm-hero{ padding:4.25rem 1rem 3.8rem; }
    .mm-hero-art{ min-height:370px; padding:1.25rem; }
    .mm-route-band{ padding:4rem 1rem; }
    .mm-cta-band{ margin:0 1rem 3.5rem; padding:2.2rem 1.35rem; }
}
@media (prefers-reduced-motion: reduce){
    .mm-route-svg path{ animation:none; stroke-dashoffset:0; }
    .mm-live::after{ animation:none; }
}
CSS;

if (!empty($_SESSION['user_id'])) {
    $pageTitle = 'Welcome'; require __DIR__ . '/includes/header.php';
    ?>
    <style><?= $mmStyles ?></style>
    <div class="mm-page">
        <section class="mm-welcome">
            <div class="mm-welcome-inner">
                <div class="mm-pin"><i class="fa-solid fa-location-dot"></i></div>
                <span class="mm-mark">Your financial home</span>
                <h1>Welcome back to<br><span>your MoneyMap.</span></h1>
                <p class="lead">Your numbers are waiting. Pick up where you left off and keep the bigger picture in view.</p>
                <a class="mm-btn mm-btn-primary" href="dashboard.php">Go to dashboard <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </section>
    </div>
    <?php require __DIR__ . '/includes/footer.php'; exit;
}
$pageTitle = 'Manage Your Money'; require __DIR__ . '/includes/header.php';
?>
<style><?= $mmStyles ?></style>
<div class="mm-page">
    <nav class="mm-public-nav" aria-label="Public navigation">
        <a class="mm-public-brand" href="index.php"><span class="mm-public-brand-mark"><i class="fa-solid fa-chart-line"></i></span><span>MoneyMap<small>Personal finance, made clear.</small></span></a>
        <div class="mm-public-links"><a href="#features">How it works</a><a class="mm-nav-login" href="login.php">Sign in</a><a class="mm-btn mm-btn-primary" href="register.php">Get started <i class="fa-solid fa-arrow-right"></i></a></div>
    </nav>

    <section class="mm-hero">
        <div class="mm-hero-copy">
            <span class="mm-mark">A clearer way to move forward</span>
            <h1>Give your money<br><span>a direction.</span></h1>
            <p>MoneyMap turns everyday transactions into a calm, useful view of your financial life, so your next decision feels obvious.</p>
            <div class="mm-hero-actions">
                <a class="mm-btn mm-btn-primary" href="register.php">Start mapping <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                <a class="mm-btn mm-btn-ghost" href="login.php">Sign in <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="mm-hero-trust">
                <span><i class="fa-solid fa-shield-halved"></i> Private by design</span>
                <span><i class="fa-solid fa-bolt"></i> Built for daily use</span>
            </div>
        </div>

        <div class="mm-hero-art">
            <div class="mm-hero-label"><span class="mm-live"></span> Financial pulse — <strong>live overview</strong></div>

            <svg class="mm-route-svg" viewBox="0 0 340 150" preserveAspectRatio="none">
                <path d="M10,120 C 70,120 60,40 130,45 S 220,110 300,30" />
                <circle cx="10" cy="120" r="4"></circle>
                <circle cx="130" cy="45" r="4"></circle>
                <circle cx="300" cy="30" r="4"></circle>
            </svg>

            <div class="mm-stat mm-stat-main">
                <small>Available balance</small>
                <strong>৳ 20,988</strong>
                <span><i class="fa-solid fa-arrow-trend-up"></i> 12.4% from last month</span>
                <div class="mm-bars"><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div>
            </div>

            <div class="mm-stat mm-stat-float">
                <small>Monthly savings</small>
                <strong style="font-size:1.3rem;">৳ 36,468</strong>
                <span>On the right track</span>
            </div>
        </div>
    </section>

    <section class="mm-route-band" id="features">
        <div class="mm-section-head">
            <span class="mm-mark">One view. More control.</span>
            <h2>A better relationship with your numbers.</h2>
            <p>Less guessing. More useful momentum.</p>
        </div>
        <div class="mm-stops">
            <div class="mm-stop">
                <div class="mm-stop-dot"><i class="fa-solid fa-arrow-right-arrow-left"></i></div>
                <span class="mm-stop-num">01</span>
                <h3>Capture the movement</h3>
                <p>Log income and spending in seconds, with notes that keep the context.</p>
            </div>
            <div class="mm-stop">
                <div class="mm-stop-dot"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
                <span class="mm-stop-num">02</span>
                <h3>Find the signal</h3>
                <p>Filter your history by type, date, month, or year to see what matters.</p>
            </div>
            <div class="mm-stop">
                <div class="mm-stop-dot"><i class="fa-solid fa-seedling"></i></div>
                <span class="mm-stop-num">03</span>
                <h3>Watch progress grow</h3>
                <p>See balances, savings, and trends update from your real activity.</p>
            </div>
            <div class="mm-stop">
                <div class="mm-stop-dot"><i class="fa-solid fa-calendar-check"></i></div>
                <span class="mm-stop-num">04</span>
                <h3>Keep the record</h3>
                <p>Preserve each completed year in an archive you can return to.</p>
            </div>
        </div>
    </section>

    <section class="mm-cta-band">
        <div>
            <span class="mm-mark">Your next good decision</span>
            <h2>Start with one transaction.</h2>
        </div>
        <a class="mm-btn mm-btn-primary" href="register.php">Create your free account <i class="fa-solid fa-arrow-right"></i></a>
    </section>

</div>
<?php require __DIR__ . '/includes/footer.php'; ?>