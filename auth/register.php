<?php

$error = '';
$success = '';

$data_file = 'users.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $password_confirm = trim($_POST['password_confirm'] ?? '');

    if (!$name || !$email || !$password || !$password_confirm) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif ($password !== $password_confirm) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } else {
        $users = [];
        if (file_exists($data_file)) {
            $users = json_decode(file_get_contents($data_file), true) ?? [];
        }

        $email_exists = false;
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                $email_exists = true;
                break;
            }
        }

        if ($email_exists) {
            $error = 'An account with this email already exists.';
        } else {
            $hashed_password = $password;

            $user_data = [
                'name' => $name,
                'email' => $email,
                'password' => $hashed_password,
            ];

            $users[] = $user_data;

            if (file_put_contents($data_file, json_encode($users, JSON_PRETTY_PRINT))) {
                $success = 'Registration successful! You can now log in.';
                $_POST = [];
            } else {
                $error = 'Failed to save user data. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">
    <title>Register</title>
</head>
<body>
<header>
        <div class="logo">
            <a href="/index.php">iKarRental</a>
        </div>
        <div class="nav">
            <a href="login.php" class="btn">Log in</a>
            <a href="register.php">Registration</a>
        </div>
    </header>
    <main class="registration-page">
        <h1>Registration</h1>
        <form method="POST" action="">
            <div class="form-group">
                <input type="text" name="name" id="name" placeholder="Full name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" id="email" placeholder="Email address" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" name="password_confirm" id="password_confirm" placeholder="Password again" required>
            </div>
            <button type="submit" class="btn primary-btn">Registration</button>
        </form>
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?> 
        <?php if ($success): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>
    </main>
</body>
</html>
