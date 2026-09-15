<?php
require_once __DIR__ . '/includes/auth.php';
require_login();

$user = current_user($pdo);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $profileImage = $user['profile_image'];

    if ($fullName === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please provide a valid name and email.';
    }

    $check = $pdo->prepare('SELECT id FROM users WHERE email = :email AND id != :id');
    $check->execute(['email' => $email, 'id' => $user['id']]);
    if ($check->fetch()) {
        $errors[] = 'That email is already in use.';
    }

    if ($password !== '' && strlen($password) < 8) {
        $errors[] = 'New password must be at least 8 characters.';
    }

    if (!empty($_FILES['profile_image']['name'])) {
        if ($_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'The profile image could not be uploaded.';
        } else {
            $image = $_FILES['profile_image'];
            $mime = (new finfo(FILEINFO_MIME_TYPE))->file($image['tmp_name']);
            $allowedTypes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
            if ($image['size'] > 2 * 1024 * 1024) {
                $errors[] = 'Profile images must be 2 MB or smaller.';
            } elseif (!isset($allowedTypes[$mime])) {
                $errors[] = 'Please upload a JPG, PNG, GIF, or WebP image.';
            } else {
                $uploadDirectory = __DIR__ . '/assets/uploads';
                if (!is_dir($uploadDirectory)) {
                    mkdir($uploadDirectory, 0755, true);
                }
                $profileImage = bin2hex(random_bytes(16)) . '.' . $allowedTypes[$mime];
                if (!move_uploaded_file($image['tmp_name'], $uploadDirectory . '/' . $profileImage)) {
                    $errors[] = 'The profile image could not be saved.';
                }
            }
        }
    }

    if (!$errors) {
        $sql = 'UPDATE users SET full_name = :full_name, email = :email, profile_image = :profile_image';
        $params = ['full_name' => $fullName, 'email' => $email, 'profile_image' => $profileImage, 'id' => $user['id']];
        if ($password !== '') {
            $sql .= ', password = :password';
            $params['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $sql .= ' WHERE id = :id';
        $update = $pdo->prepare($sql);
        $update->execute($params);
        flash('success', 'Profile updated successfully.');
        redirect('profile.php');
    }

    $user['full_name'] = $fullName;
    $user['email'] = $email;
    $user['profile_image'] = $profileImage;
}

$pageTitle = 'Profile';
require __DIR__ . '/includes/header.php';
?>
<div class="page-title"><div><span class="eyebrow">YOUR ACCOUNT</span><h1>Profile</h1></div></div>
<div class="profile-page">
    <aside class="profile-summary panel">
        <div class="profile-avatar-wrap">
            <?php if (!empty($user['profile_image'])): ?><img class="profile-avatar" src="assets/uploads/<?= e($user['profile_image']) ?>" alt="Profile image"><?php else: ?><div class="profile-avatar placeholder"><i class="fa-solid fa-user"></i></div><?php endif; ?>
        </div>
        <div class="profile-summary-body">
            <span class="profile-badge">Account</span>
            <h2><?= e($user['full_name']) ?></h2>
            <p><?= e($user['email']) ?></p>
            <div class="member-meta">
                <i class="fa-regular fa-calendar"></i>
                <span>Member since <?= pretty_date(substr($user['created_at'], 0, 10)) ?></span>
            </div>
        </div>
    </aside>

    <section class="panel profile-panel">
        <?php foreach ($errors as $error): ?><div class="alert alert-danger py-2 mb-3"><?= e($error) ?></div><?php endforeach; ?>

        <form method="post" enctype="multipart/form-data" class="profile-form">
            <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">

            <div class="profile-form-section">
                <div class="section-heading-row">
                    <h3>Profile details</h3>
                </div>

                <div class="profile-form-grid">
                    <div class="form-field form-field-full">
                        <label>Profile image</label>
                        <input class="form-control" type="file" name="profile_image" accept="image/jpeg,image/png,image/gif,image/webp">
                        <div class="form-text">JPG, PNG, GIF, or WebP. Maximum 2 MB.</div>
                    </div>

                    <div class="form-field">
                        <label>Full name</label>
                        <input class="form-control" name="full_name" value="<?= e($user['full_name']) ?>" required>
                    </div>

                    <div class="form-field">
                        <label>Username</label>
                        <input class="form-control" value="<?= e($user['username']) ?>" disabled>
                    </div>

                    <div class="form-field form-field-full">
                        <label>Email</label>
                        <input class="form-control" type="email" name="email" value="<?= e($user['email']) ?>" required>
                    </div>
                </div>
            </div>

            <div class="profile-form-section security-section">
                <div class="section-heading-row">
                    <h3>Change password</h3>
                </div>
                <div class="form-field form-field-full">
                    <label>New password <span class="muted fw-normal">(leave blank to keep current)</span></label>
                    <input class="form-control" type="password" name="password" minlength="8">
                </div>
            </div>

            <div class="profile-actions">
                <button class="btn btn-primary">Update profile</button>
            </div>
        </form>
    </section>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
