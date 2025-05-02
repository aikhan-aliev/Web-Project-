<?php
session_start();

if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== true) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $transmission = $_POST['transmission'];
    $fuel_type = $_POST['fuel_type'];
    $passengers = $_POST['passengers'];
    $daily_price_huf = $_POST['daily_price_huf'];
    $image = $_POST['image'];

    if (empty($brand) || empty($model) || empty($year) || empty($transmission) || empty($fuel_type) || empty($passengers) || empty($daily_price_huf) || empty($image)) {
        $error = 'All fields are required.';
    } else {
        $cars = json_decode(file_get_contents('../cars.json'), true);
        $newCar = [
            'id' => count($cars) + 1,
            'brand' => $brand,
            'model' => $model,
            'year' => (int)$year,
            'transmission' => $transmission,
            'fuel_type' => $fuel_type,
            'passengers' => (int)$passengers,
            'daily_price_huf' => (int)$daily_price_huf,
            'image' => $image
        ];
        $cars[] = $newCar;
        file_put_contents('../cars.json', json_encode($cars, JSON_PRETTY_PRINT));
        $success = 'Car added successfully.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">
    <title>Add Car</title>
</head>
<body>
    <header>
        <div class="logo">iKarRental</div>
        <div class="nav">
            <a href="../index.php" class="btn">Home</a>
            <a href="../auth/logout.php" class="btn">Logout</a>
        </div>
    </header>
    <main>
        <h2>Add New Car</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand" required>
            <label for="model">Model:</label>
            <input type="text" id="model" name="model" required>
            <label for="year">Year:</label>
            <input type="number" id="year" name="year" required>
            <label for="transmission">Transmission:</label>
            <select id="transmission" name="transmission" required>
                <option value="Automatic">Automatic</option>
                <option value="Manual">Manual</option>
            </select>
            <label for="fuel_type">Fuel Type:</label>
            <input type="text" id="fuel_type" name="fuel_type" required>
            <label for="passengers">Passengers:</label>
            <input type="number" id="passengers" name="passengers" required>
            <label for="daily_price_huf">Daily Price (HUF):</label>
            <input type="number" id="daily_price_huf" name="daily_price_huf" required>
            <label for="image">Image URL:</label>
            <input type="text" id="image" name="image" required>
            <button type="submit" class="btn">Add Car</button>
        </form>
    </main>
</body>
</html>