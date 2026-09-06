<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$pageTitle = $pageTitle ?? 'MoneyMap v2.0';
$isAuthenticated = !empty($_SESSION['user_id']);
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
</head>
<body>
<?php if ($isAuthenticated): ?>
<nav class="navbar navbar-expand-lg app-nav">
    <div class="container-fluid app-shell">
        <a class="navbar-brand brand-mark" href="dashboard.php"><span class="brand-icon"><i class="fa-solid fa-chart-line"></i></span> MoneyMap <small>v2.0</small></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"><i class="fa-solid fa-bars"></i></button>
        <div class="collapse navbar-collapse" id="mainNav">
            <div class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <a class="nav-link" href="dashboard.php"><i class="fa-solid fa-grid-2 me-1"></i> Dashboard</a>
                <a class="nav-link" href="transactions.php"><i class="fa-solid fa-receipt me-1"></i> Transactions</a>
                <a class="nav-link" href="archive.php"><i class="fa-solid fa-box-archive me-1"></i> Archive</a>
                <a class="nav-link" href="profile.php"><i class="fa-solid fa-user me-1"></i> Profile</a>
                <a class="btn btn-outline-danger btn-sm ms-lg-2" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket me-1"></i> Logout</a>
            </div>
        </div>
    </div>
</nav>
<?php endif; ?>
<main class="app-shell <?= $isAuthenticated ? 'page-content' : '' ?>">
<?php if ($message = flash('success')): ?><div class="alert alert-success mt-3"><i class="fa-solid fa-circle-check me-2"></i><?= e($message) ?></div><?php endif; ?>
<?php if ($message = flash('error')): ?><div class="alert alert-danger mt-3"><i class="fa-solid fa-circle-exclamation me-2"></i><?= e($message) ?></div><?php endif; ?>
