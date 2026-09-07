<?php

require_once __DIR__ . '/../config/google.php';

function google_is_configured(): bool
{
    global $googleClientId, $googleClientSecret, $googleRedirectUri;
    return $googleClientId !== '' && $googleClientSecret !== '' && $googleRedirectUri !== '';
}

function google_authorization_url(): string
{
    global $googleClientId, $googleRedirectUri;

    $state = bin2hex(random_bytes(32));
    $_SESSION['google_oauth_state'] = $state;

    return 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
        'client_id' => $googleClientId,
        'redirect_uri' => $googleRedirectUri,
        'response_type' => 'code',
        'scope' => 'openid email profile',
        'state' => $state,
        'access_type' => 'online',
        'prompt' => 'select_account',
    ]);
}

function google_request(string $url, array $options = []): array
{
    $curl = curl_init($url);
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_FOLLOWLOCATION => false,
    ] + $options);
    $response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $error = curl_error($curl);
    curl_close($curl);

    if ($response === false || $error !== '' || $status < 200 || $status >= 300) {
        return [];
    }

    $data = json_decode($response, true);
    return is_array($data) ? $data : [];
}

function google_user_from_code(string $code): ?array
{
    global $googleClientId, $googleClientSecret, $googleRedirectUri;

    $token = google_request('https://oauth2.googleapis.com/token', [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'code' => $code,
            'client_id' => $googleClientId,
            'client_secret' => $googleClientSecret,
            'redirect_uri' => $googleRedirectUri,
            'grant_type' => 'authorization_code',
        ]),
        CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
    ]);

    if (empty($token['access_token'])) {
        return null;
    }

    $user = google_request('https://www.googleapis.com/oauth2/v3/userinfo', [
        CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $token['access_token']],
    ]);

    if (empty($user['sub']) || empty($user['email']) || ($user['email_verified'] ?? false) !== true) {
        return null;
    }

    return $user;
}
