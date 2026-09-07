<?php
require_once __DIR__ . '/includes/auth.php';
if (!empty($_SESSION['user_id'])) redirect('dashboard.php');
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $fullName = trim($_POST['full_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    if ($fullName === '' || $username === '' || $email === '' || $password === '') $errors[] = 'All fields are required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
    if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters.';
    if ($password !== $confirm) $errors[] = 'Password confirmation does not match.';
    if (!$errors) {
        $check = $pdo->prepare('SELECT id FROM users WHERE username = :username OR email = :email');
        $check->execute(['username' => $username, 'email' => $email]);
        if ($check->fetch()) $errors[] = 'Username or email already exists.';
    }
    if (!$errors) {
        $statement = $pdo->prepare('INSERT INTO users (full_name, username, email, password) VALUES (:full_name, :username, :email, :password)');
        $statement->execute(['full_name' => $fullName, 'username' => $username, 'email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)]);
        flash('success', 'Your account is ready. Please log in.');
        redirect('login.php');
    }
}
$pageTitle = 'Create account'; require __DIR__ . '/includes/header.php';
?>
<section class="auth-layout"><div class="auth-panel"><a class="brand-mark" href="index.php"><span class="brand-icon"><i class="fa-solid fa-chart-line"></i></span> MoneyMap <small>v2.0</small></a><div class="auth-copy"><span class="eyebrow">START WITH CLARITY</span><h1>Make every taka count.</h1><p>A calm, private place to understand where your money goes and where it can take you.</p></div></div><div class="auth-form-wrap"><div class="auth-form"><div class="mobile-brand"><a class="brand-mark" href="index.php"><span class="brand-icon"><i class="fa-solid fa-chart-line"></i></span> MoneyMap</a></div><h2>Create your account</h2><p class="muted">Your personal money map starts here.</p><?php foreach ($errors as $error): ?><div class="alert alert-danger py-2"><?= e($error) ?></div><?php endforeach; ?><a class="btn btn-outline-secondary w-100 mb-3" href="google_login.php"><i class="fa-brands fa-google me-2"></i> Sign up with Google</a><div class="auth-divider"><span>or</span></div><form method="post"><input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>"><div class="mb-3"><label>Full name</label><input class="form-control" name="full_name" value="<?= e($_POST['full_name'] ?? '') ?>" required></div><div class="row"><div class="col-md-6 mb-3"><label>Username</label><input class="form-control" name="username" value="<?= e($_POST['username'] ?? '') ?>" required></div><div class="col-md-6 mb-3"><label>Email</label><input class="form-control" type="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" required></div></div><div class="row"><div class="col-md-6 mb-3"><label>Password</label><input class="form-control" type="password" name="password" minlength="8" required></div><div class="col-md-6 mb-3"><label>Confirm password</label><input class="form-control" type="password" name="confirm_password" minlength="8" required></div></div><button class="btn btn-primary w-100 mt-2">Create account <i class="fa-solid fa-arrow-right ms-1"></i></button></form><p class="auth-switch">Already have an account? <a href="login.php">Log in</a></p></div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
