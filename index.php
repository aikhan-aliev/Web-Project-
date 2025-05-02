<?php
session_start();
include 'storage.php';

$carsStorage = new Storage(new JsonIO('cars.json'));
$bookingsStorage = new Storage(new JsonIO('books.json'));

$cars = $carsStorage->findAll();
$bookings = $bookingsStorage->findAll();

$filters = [
    'seats' => $_GET['seats'] ?? '',
    'start_date' => $_GET['start_date'] ?? '',
    'end_date' => $_GET['end_date'] ?? '',
    'gear_type' => $_GET['gear_type'] ?? '',
    'min_price' => $_GET['min_price'] ?? '',
    'max_price' => $_GET['max_price'] ?? ''
];

function filterCars($car) {
    global $filters, $bookings;

    if ($filters['seats'] && $car['passengers'] < (int)$filters['seats']) {
        return false;
    }

    if ($filters['gear_type'] && $car['transmission'] !== $filters['gear_type']) {
        return false;
    }

    if ($filters['min_price'] && $car['daily_price_huf'] < (int)$filters['min_price']) {
        return false;
    }

    if ($filters['max_price'] && $car['daily_price_huf'] > (int)$filters['max_price']) {
        return false;
    }

    if ($filters['start_date'] && $filters['end_date']) {
        foreach ($bookings as $booking) {
            if ($booking['car_id'] == $car['id'] &&
                !($filters['end_date'] < $booking['start_date'] || $filters['start_date'] > $booking['end_date'])) {
                return false;
            }
        }
    }

    return true;
}

$filteredCars = array_filter($cars, 'filterCars');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_car'])) {
        $carId = $_POST['delete_car'];
        $carsStorage->deleteCar($carId);
        $bookingsStorage->deleteMany(fn($booking) => $booking['car_id'] == $carId);
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>iKarRental</title>
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
                <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === true): ?>
                    <a href="admin/add_car.php" class="btn">Add Car</a>
                <?php endif; ?>
                <a href="auth/logout.php" class="btn">Logout</a>
            <?php else: ?>
                <a href="auth/login.php" class="btn">Login</a>
                <a href="auth/register.php" class="btn">Register</a>
            <?php endif; ?>
        </div>
    </header>
    <main>
        <div class="hero">
            <h1>Rent cars easily!</h1>
        </div>
        <div class="filters">
            <form method="GET" action="">
                <input type="number" name="seats" placeholder="Seats" value="<?= htmlspecialchars($filters['seats']) ?>">
                <input type="date" name="start_date" value="<?= htmlspecialchars($filters['start_date']) ?>">
                <input type="date" name="end_date" value="<?= htmlspecialchars($filters['end_date']) ?>">
                <select name="gear_type">
                    <option value="">Gear type</option>
                    <option value="Manual" <?= $filters['gear_type'] === 'Manual' ? 'selected' : '' ?>>Manual</option>
                    <option value="Automatic" <?= $filters['gear_type'] === 'Automatic' ? 'selected' : '' ?>>Automatic</option>
                </select>
                <input type="number" name="min_price" placeholder="Min Price" value="<?= htmlspecialchars($filters['min_price']) ?>">
                <input type="number" name="max_price" placeholder="Max Price" value="<?= htmlspecialchars($filters['max_price']) ?>">
                <button type="submit" class="btn">Filter</button>
            </form>
        </div>
        <div class="car-list">
            <?php foreach ($filteredCars as $car): ?>
                <div class="car-card">
                    <a href="car_details.php?id=<?= $car['id'] ?>">
                        <img src="<?= htmlspecialchars($car['image']) ?>" alt="<?= htmlspecialchars($car['brand']) ?> <?= htmlspecialchars($car['model']) ?>">
                    </a>
                    <div class="car-details">
                        <h3><?= htmlspecialchars($car['brand']) ?> <?= htmlspecialchars($car['model']) ?></h3>
                        <p><?= htmlspecialchars($car['passengers']) ?> seats - <?= htmlspecialchars($car['transmission']) ?></p>
                        <div class="car-price">
                            <span><?= htmlspecialchars(number_format($car['daily_price_huf'], 0)) ?> HUF/day</span>
                            <div class="car-actions">
                                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                                    <a href="book.php?car_id=<?= $car['id'] ?>" class="btn-book">Book</a>
                                    <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === true): ?>
                                        <a href="admin/edit_car.php?id=<?= $car['id'] ?>" class="btn-edit">Edit</a>
                                        <form method="POST" action="" style="display:inline;">
                                            <input type="hidden" name="delete_car" value="<?= htmlspecialchars($car['id']) ?>">
                                            <button type="submit" class="btn-delete">Delete</button>
                                        </form>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="auth/login.php" class="btn-book">Book</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>