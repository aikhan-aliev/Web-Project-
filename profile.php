<?php
session_start();
include 'storage.php';

$bookingsStorage = new Storage(new JsonIO('books.json'));

$bookings = $bookingsStorage->findAll();
$users = json_decode(file_get_contents('auth/users.json'), true);
$userEmail = $_SESSION['email'] ?? '';
$userName = '';
foreach ($users as $user) {
    if ($user['email'] === $userEmail) {
        $userName = $user['name'];
        break;
    }
}

$userBookings = array_filter($bookings, fn($booking) => $booking['user'] === $userName);

if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === true) {
    $allBookings = $bookings;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_booking'])) {
    $bookingId = $_POST['delete_booking'];
    $bookingsStorage->deleteBooking($bookingId);
    header('Location: profile.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Profile</title>
</head>
<body>
    <header>
        <div class="logo">iKarRental</div>
        <div class="nav">
            <a href="index.php" class="btn">Home</a>
            <a href="auth/logout.php" class="btn">Logout</a>
        </div>
    </header>
    <main>
        <h1>Profile</h1>
        <h2>
            <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === true): ?>
                Admin User
            <?php else: ?>
                <?= htmlspecialchars($userName) ?>
            <?php endif; ?>
        </h2>

        <?php if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== true): ?>
            <h2>Your Bookings</h2>
            <?php if (empty($userBookings)): ?>
                <p>No bookings found.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($userBookings as $booking): ?>
                        <li>
                            Car ID: <?= htmlspecialchars($booking['car_id']) ?>, 
                            Start Date: <?= htmlspecialchars($booking['start_date']) ?>, 
                            End Date: <?= htmlspecialchars($booking['end_date']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === true): ?>
            <h2>All Bookings</h2>
            <?php if (empty($allBookings)): ?>
                <p>No bookings found.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($allBookings as $booking): ?>
                        <li>
                            Car ID: <?= htmlspecialchars($booking['car_id']) ?>, 
                            User: <?= htmlspecialchars($booking['user'] ?? 'Unknown') ?>, 
                            Start Date: <?= htmlspecialchars($booking['start_date']) ?>, 
                            End Date: <?= htmlspecialchars($booking['end_date']) ?>
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="delete_booking" value="<?= htmlspecialchars($booking['id'] ?? '') ?>">
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endif; ?>
    </main>
</body>
</html>