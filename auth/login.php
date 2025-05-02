<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">
    <title>Login</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="/index.php">iKarRental</a>
        </div>
        <div class="nav">
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <a href="logout.php" class="btn">Logout</a>
            <?php else: ?>
                <a href="login.php">Log in</a>
                <a href="register.php" class="btn">Registration</a>
            <?php endif; ?>
        </div>
    </header>
    <main class="login-page">
        <h1>Login</h1>
        <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid_credentials'): ?>
            <p class="error">Invalid email or password. Please try again.</p>
        <?php endif; ?>
        <form action="login_process.php" method="POST">
            <label for="email">Email address</label>
            <input type="email" id="email" name="email" placeholder="example@email.com" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>
            <button type="submit">Login</button>
        </form>
    </main>
</body>
</html>