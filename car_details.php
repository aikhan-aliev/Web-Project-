<?php
session_start();

include 'storage.php';
$cars = json_decode(file_get_contents('cars.json'), true);

$car_id = $_GET['id'] ?? 0;

$car = null;
foreach ($cars as $item) {
    if ($item['id'] == $car_id) {
        $car = $item;
        break;
    }
}

if (!$car) {
    echo "Car not found!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Car Details - <?= htmlspecialchars($car['brand']) ?> <?= htmlspecialchars($car['model']) ?></title>
</head>
<body>
    <header>
        <div class="logo">iKarRental</div>
        <div class="nav">
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <span class="user-info">
                    <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === true): ?>
                        Admin User
                    <?php else: ?>
                        <?= htmlspecialchars($_SESSION['username']) ?>
                    <?php endif; ?>
                </span>
                <a href="profile.php" class="btn">Profile</a>
                <a href="auth/logout.php" class="btn">Logout</a>
            <?php else: ?>
                <a href="auth/login.php" class="btn">Login</a>
                <a href="auth/register.php" class="btn">Register</a>
            <?php endif; ?>
        </div>
    </header>
    <main class="car-details-page">
        <div class="details-container">
            <div class="car-image">
                <img src="<?= htmlspecialchars($car['image']) ?>" alt="<?= htmlspecialchars($car['brand']) ?> <?= htmlspecialchars($car['model']) ?>">
            </div>
            <div class="car-info">
                <h1><?= htmlspecialchars($car['brand']) ?> <?= htmlspecialchars($car['model']) ?></h1>
                <p><strong>Fuel:</strong> <?= htmlspecialchars($car['fuel_type']) ?></p>
                <p><strong>Shifter:</strong> <?= htmlspecialchars($car['transmission']) ?></p>
                <p><strong>Year of manufacture:</strong> <?= htmlspecialchars($car['year']) ?></p>
                <p><strong>Number of seats:</strong> <?= htmlspecialchars($car['passengers']) ?></p>
                <div class="car-price">
                    <h2>HUF <?= number_format($car['daily_price_huf'], 0) ?>/day</h2>
                </div>
                <div class="car-actions">
                    <a href="book.php?car_id=<?= htmlspecialchars($car['id']) ?>" class="btn btn-book">Book it</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
