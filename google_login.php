<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/google.php';

if (!empty($_SESSION['user_id'])) {
    redirect('dashboard.php');
}

if (!google_is_configured()) {
    flash('error', 'Google sign-in is not configured yet. Add the Google OAuth credentials first.');
    redirect('login.php');
}

redirect(google_authorization_url());
