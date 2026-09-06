<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$pageTitle = $pageTitle ?? 'MoneyMap v2.0';
$isAuthenticated = !empty($_SESSION['user_id']);
$navUser = $isAuthenticated ? current_user($pdo) : null;
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> | MoneyMap</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <script>if (localStorage.getItem('moneymap-theme') === 'dark') document.documentElement.dataset.theme = 'dark';</script>
</head>
<body>
<?php if ($isAuthenticated): ?>
<nav class="navbar navbar-expand-lg app-nav">
    <div class="container-fluid app-shell">
        <a class="navbar-brand brand-mark" href="dashboard.php"><span class="brand-icon"><i class="fa-solid fa-chart-line"></i></span><span>MoneyMap <small>v2.0</small><em></em></span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"><i class="fa-solid fa-bars"></i></button>
        <div class="collapse navbar-collapse" id="mainNav">
            <div class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <a class="nav-link <?= $currentPage === 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php"><i class="fa-solid fa-grid-2 me-1"></i> Dashboard</a>
                <a class="nav-link <?= $currentPage === 'transactions.php' ? 'active' : '' ?>" href="transactions.php"><i class="fa-solid fa-receipt me-1"></i> Transactions</a>
                <a class="nav-link <?= $currentPage === 'archive.php' ? 'active' : '' ?>" href="archive.php"><i class="fa-solid fa-box-archive me-1"></i> Archive</a>
                <a class="nav-link nav-profile <?= $currentPage === 'profile.php' ? 'active' : '' ?>" href="profile.php"><?php if (!empty($navUser['profile_image'])): ?><img class="avatar avatar-sm" src="assets/uploads/<?= e($navUser['profile_image']) ?>" alt="Profile image"><?php else: ?><i class="fa-solid fa-user me-1"></i><?php endif; ?> Profile</a>
                <a class="btn btn-outline-danger btn-sm ms-lg-2" data-confirm="Are you sure you want to log out?" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket me-1"></i> Logout</a>
            </div>
        </div>
    </div>
</nav>
<?php endif; ?>
<button class="theme-toggle" type="button" aria-label="Toggle night mode" title="Toggle night mode"><i class="fa-solid fa-moon"></i></button>
<main class="app-shell <?= $isAuthenticated ? 'page-content' : '' ?>">
<?php if ($message = flash('success')): ?><div class="alert alert-success mt-3 js-flash" data-alert-type="success" data-alert-message="<?= e($message) ?>"></div><?php endif; ?>
<?php if ($message = flash('error')): ?><div class="alert alert-danger mt-3 js-flash" data-alert-type="error" data-alert-message="<?= e($message) ?>"></div><?php endif; ?>
