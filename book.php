<?php
session_start();

if (!isset($_GET['car_id'])) {
    die('Car ID not provided');
}

$carId = $_GET['car_id'];
$cars = json_decode(file_get_contents('cars.json'), true);
$users = json_decode(file_get_contents('auth/users.json'), true);
$car = array_filter($cars, fn($c) => $c['id'] == $carId);
if ($car) {
    $car = array_values($car)[0];
} else {
    die('Car not found');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        $error = 'You must be logged in to book a car.';
    } else {
        $startDate = $_POST['start_date'] ?? '';
        $endDate = $_POST['end_date'] ?? '';

        if (empty($startDate) || empty($endDate)) {
            $error = 'Both start date and end date are required.';
        } elseif ($startDate > $endDate) {
            $error = 'Start date cannot be later than end date.';
        } else {
            $bookings = json_decode(file_get_contents('books.json'), true);
            $userEmail = $_SESSION['email'];
            $userName = '';
            foreach ($users as $user) {
                if ($user['email'] === $userEmail) {
                    $userName = $user['name'];
                    break;
                }
            }
            $newBooking = [
                'id' => uniqid(),
                'car_id' => $carId,
                'user' => $userName,
                'start_date' => $startDate,
                'end_date' => $endDate
            ];
            $bookings[] = $newBooking;
            file_put_contents('books.json', json_encode($bookings, JSON_PRETTY_PRINT));
            $success = 'Car booked successfully.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Book <?= htmlspecialchars($car['brand']) ?> <?= htmlspecialchars($car['model']) ?></title>
</head>
<body>
    <header>
        <div class="logo">iKarRental</div>
        <div class="nav">
            <a href="index.php" class="btn">Home</a>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <a href="auth/logout.php" class="btn">Logout</a>
            <?php else: ?>
                <a href="auth/login.php" class="btn">Login</a>
                <a href="auth/register.php" class="btn">Register</a>
            <?php endif; ?>
        </div>
    </header>
    <main>
        <div class="booking-page">
            <h1>Book <?= htmlspecialchars($car['brand']) ?> <?= htmlspecialchars($car['model']) ?></h1>
            <?php if ($error): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <?php if ($success): ?>
                <p class="success"><?= htmlspecialchars($success) ?></p>
            <?php else: ?>
                <form action="book.php?car_id=<?= htmlspecialchars($carId) ?>" method="POST">
                    <label for="start_date">Start Date:</label>
                    <input type="date" id="start_date" name="start_date" required>
                    <label for="end_date">End Date:</label>
                    <input type="date" id="end_date" name="end_date" required>
                    <button type="submit" class="btn">Book</button>
                </form>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>