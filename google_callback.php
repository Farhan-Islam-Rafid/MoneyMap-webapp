<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/google.php';

if (!google_is_configured() || empty($_GET['code']) || !hash_equals($_SESSION['google_oauth_state'] ?? '', $_GET['state'] ?? '')) {
    unset($_SESSION['google_oauth_state']);
    flash('error', 'Google sign-in could not be verified. Please try again.');
    redirect('login.php');
}

unset($_SESSION['google_oauth_state']);
$googleUser = google_user_from_code($_GET['code']);
if ($googleUser === null) {
    flash('error', 'Google sign-in failed. Please try again.');
    redirect('login.php');
}

$googleId = $googleUser['sub'];
$email = strtolower(trim($googleUser['email']));
$fullName = trim($googleUser['name'] ?? '') ?: $email;

$statement = $pdo->prepare('SELECT * FROM users WHERE google_id = :google_id OR email = :email LIMIT 1');
$statement->execute(['google_id' => $googleId, 'email' => $email]);
$user = $statement->fetch();

if ($user) {
    if (empty($user['google_id'])) {
        $link = $pdo->prepare('UPDATE users SET google_id = :google_id WHERE id = :id');
        $link->execute(['google_id' => $googleId, 'id' => $user['id']]);
    }
} else {
    $baseUsername = preg_replace('/[^a-z0-9_]/', '', strtolower((string) strstr($email, '@', true)));
    $baseUsername = trim($baseUsername ?: 'google_user', '_');
    $baseUsername = substr($baseUsername, 0, 42);
    $username = $baseUsername;
    $suffix = 1;
    $checkUsername = $pdo->prepare('SELECT id FROM users WHERE username = :username LIMIT 1');
    while (true) {
        $checkUsername->execute(['username' => $username]);
        if (!$checkUsername->fetch()) {
            break;
        }
        $username = $baseUsername . '_' . $suffix++;
    }

    $insert = $pdo->prepare('INSERT INTO users (full_name, username, email, password, google_id) VALUES (:full_name, :username, :email, NULL, :google_id)');
    $insert->execute([
        'full_name' => $fullName,
        'username' => $username,
        'email' => $email,
        'google_id' => $googleId,
    ]);
    $user = ['id' => $pdo->lastInsertId(), 'full_name' => $fullName];
}

session_regenerate_id(true);
$_SESSION['user_id'] = (int) $user['id'];
flash('success', 'Welcome to MoneyMap, ' . $user['full_name'] . '.');
redirect('dashboard.php');
