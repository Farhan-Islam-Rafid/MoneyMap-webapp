<?php
require_once __DIR__ . '/includes/auth.php';
if (!empty($_SESSION['user_id'])) redirect('dashboard.php');
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $identity = trim($_POST['identity'] ?? '');
    $password = $_POST['password'] ?? '';
    $statement = $pdo->prepare('SELECT * FROM users WHERE username = :username OR email = :email LIMIT 1');
    $statement->execute(['username' => $identity, 'email' => $identity]);
    $user = $statement->fetch();
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true); $_SESSION['user_id'] = (int) $user['id'];
        flash('success', 'Welcome back, ' . $user['full_name'] . '.'); redirect('dashboard.php');
    }
    $error = 'Invalid username or password.';
}
$pageTitle = 'Log in'; require __DIR__ . '/includes/header.php';
?>
<section class="auth-layout"><div class="auth-panel"><a class="brand-mark" href="index.php"><span class="brand-icon"><i class="fa-solid fa-chart-line"></i></span> MoneyMap <small>v2.0</small></a><div class="auth-copy"><span class="eyebrow">YOUR MONEY, IN FOCUS</span><h1>Know the shape of your finances.</h1><p>See the signal in your income, spending, and savings without the spreadsheet sprawl.</p></div></div><div class="auth-form-wrap"><div class="auth-form"><div class="mobile-brand"><a class="brand-mark" href="index.php"><span class="brand-icon"><i class="fa-solid fa-chart-line"></i></span> MoneyMap</a></div><h2>Welcome back</h2><p class="muted">Log in to continue your financial story.</p><?php if ($error): ?><div class="alert alert-danger py-2"><?= e($error) ?></div><?php endif; ?><a class="btn btn-outline-secondary w-100 mb-3" href="google_login.php"><i class="fa-brands fa-google me-2"></i> Continue with Google</a><div class="auth-divider"><span>or</span></div><form method="post"><input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>"><div class="mb-3"><label>Username or email</label><input class="form-control" name="identity" value="<?= e($_POST['identity'] ?? '') ?>" autocomplete="username" required></div><div class="mb-3"><label>Password</label><input class="form-control" type="password" name="password" autocomplete="current-password" required></div><button class="btn btn-primary w-100 mt-2">Log in <i class="fa-solid fa-arrow-right ms-1"></i></button></form><p class="auth-switch">New to MoneyMap? <a href="register.php">Create an account</a></p></div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
