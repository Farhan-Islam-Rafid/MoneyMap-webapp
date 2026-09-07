<?php

$googleClientId = getenv('GOOGLE_CLIENT_ID') ?: '';
$googleClientSecret = getenv('GOOGLE_CLIENT_SECRET') ?: '';
$googleRedirectUri = getenv('GOOGLE_REDIRECT_URI') ?: 'http://localhost/MoneyMap/google_callback.php';
