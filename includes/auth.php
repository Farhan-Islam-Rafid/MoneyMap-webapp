<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';

function require_login(): void
{
    if (empty($_SESSION['user_id'])) {
        flash('error', 'Please log in to continue.');
        redirect('login.php');
    }
}

function current_user(PDO $pdo): ?array
{
    static $user;
    if ($user !== null) {
        return $user;
    }
    if (empty($_SESSION['user_id'])) {
        return null;
    }
    $statement = $pdo->prepare('SELECT id, full_name, username, email, profile_image, created_at FROM users WHERE id = :id');
    $statement->execute(['id' => $_SESSION['user_id']]);
    $user = $statement->fetch() ?: null;
    return $user;
}
