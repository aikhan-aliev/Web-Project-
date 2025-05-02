<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$users = json_decode(file_get_contents('users.json'), true);

$valid_user = null;
foreach ($users as $user) {
    if ($user['email'] === $email && $user['password'] === $password) {
        $valid_user = $user;
        break;
    }
}

if ($valid_user) {
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $valid_user['username'];
    $_SESSION['email'] = $valid_user['email'];
    $_SESSION['isAdmin'] = $valid_user['isAdmin'];

    header("Location: /index.php");
    exit();
} else {
    header("Location: login.php?error=invalid_credentials");
    exit();
}
?>