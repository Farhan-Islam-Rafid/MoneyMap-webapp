<?php
require_once __DIR__ . '/includes/auth.php';
if (!empty($_SESSION['user_id'])) {
    $pageTitle = 'Welcome'; require __DIR__ . '/includes/header.php';
    ?>
    <section class="welcome-page"><span class="eyebrow">YOUR FINANCIAL HOME</span><h1>Welcome back to<br><span>your MoneyMap.</span></h1><p class="lead">Your numbers are waiting. Pick up where you left off and keep the bigger picture in view.</p><a class="btn btn-primary btn-lg" href="dashboard.php">Go to Dashboard <i class="fa-solid fa-arrow-right ms-2"></i></a></section>
    <?php require __DIR__ . '/includes/footer.php'; exit;
}
$pageTitle = 'Manage Your Money'; require __DIR__ . '/includes/header.php';
?>
<section class="hero"><div class="hero-copy"><span class="eyebrow">A CLEARER WAY TO MOVE FORWARD</span><h1>Manage Your Money.<br><span>Build Your Future.</span></h1><p>MoneyMap helps you track income, expenses, savings and financial progress in one simple place.</p><div class="hero-actions"><a class="btn btn-primary btn-lg" href="register.php">Get Started <i class="fa-solid fa-arrow-right ms-2"></i></a><a class="btn btn-link btn-lg" href="login.php">Login</a></div></div><div class="hero-art"><div class="orbit orbit-one"></div><div class="orbit orbit-two"></div><div class="hero-stat"><small>YOUR BALANCE</small><strong>৳ 20,988</strong><span><i class="fa-solid fa-arrow-trend-up"></i> Moving in the right direction</span></div><div class="hero-note"><i class="fa-solid fa-check"></i><span>Every detail, in one view.</span></div></div></section>
<section class="feature-band"><div class="section-heading"><span class="eyebrow">ONE VIEW. MORE CONTROL.</span><h2>Clarity you can act on.</h2></div><div class="feature-grid"><article><i class="fa-solid fa-arrow-right-arrow-left"></i><h3>Track income & expenses</h3><p>Capture the everyday movements that shape your financial life.</p></article><article><i class="fa-solid fa-magnifying-glass-chart"></i><h3>Understand your spending</h3><p>Use filters and summaries to find patterns without digging.</p></article><article><i class="fa-solid fa-seedling"></i><h3>Monitor your savings</h3><p>See what is saved now and what your habits make possible next.</p></article><article><i class="fa-solid fa-calendar-check"></i><h3>Yearly financial archive</h3><p>Keep a durable record of each year’s progress as you go.</p></article></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
