<?php

include '../storage.php';

$cars = json_decode(file_get_contents('../cars.json'), true);
$carId = $_GET['id'] ?? null;

if (!$carId || !isset($cars[$carId - 1])) {
    die('Car not found!');
}

$car = $cars[$carId - 1];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand = $_POST['brand'] ?? '';
    $model = $_POST['model'] ?? '';
    $year = $_POST['year'] ?? '';
    $transmission = $_POST['transmission'] ?? '';
    $fuel_type = $_POST['fuel_type'] ?? '';
    $passengers = $_POST['passengers'] ?? '';
    $daily_price_huf = $_POST['daily_price_huf'] ?? '';
    $image = $_POST['image'] ?? '';

    if (!$brand || !$model || !$year || !$transmission || !$fuel_type || !$passengers || !$daily_price_huf || !$image) {
        $error = 'All fields are required.';
    } else {
        $cars[$carId - 1] = [
            'id' => $carId,
            'brand' => $brand,
            'model' => $model,
            'year' => (int)$year,
            'transmission' => $transmission,
            'fuel_type' => $fuel_type,
            'passengers' => (int)$passengers,
            'daily_price_huf' => (int)$daily_price_huf,
            'image' => $image
        ];
        file_put_contents('../cars.json', json_encode($cars, JSON_PRETTY_PRINT));

        header('Location: /index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">
    <title>Edit Car</title>
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
        <div class="banner">
            <h1>Edit Car</h1>
        </div>
        <div class="form-container">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="brand">Brand:</label>
                    <input type="text" name="brand" id="brand" value="<?= htmlspecialchars($car['brand']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="model">Model:</label>
                    <input type="text" name="model" id="model" value="<?= htmlspecialchars($car['model']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="year">Year:</label>
                    <input type="number" name="year" id="year" value="<?= htmlspecialchars($car['year']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="transmission">Transmission:</label>
                    <select name="transmission" id="transmission" required>
                        <option value="Automatic" <?= $car['transmission'] === 'Automatic' ? 'selected' : '' ?>>Automatic</option>
                        <option value="Manual" <?= $car['transmission'] === 'Manual' ? 'selected' : '' ?>>Manual</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="fuel_type">Fuel Type:</label>
                    <input type="text" name="fuel_type" id="fuel_type" value="<?= htmlspecialchars($car['fuel_type']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="passengers">Passengers:</label>
                    <input type="number" name="passengers" id="passengers" value="<?= htmlspecialchars($car['passengers']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="daily_price_huf">Daily Price (HUF):</label>
                    <input type="number" name="daily_price_huf" id="daily_price_huf" value="<?= htmlspecialchars($car['daily_price_huf']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="image">Image URL:</label>
                    <input type="text" name="image" id="image" value="<?= htmlspecialchars($car['image']) ?>" required>
                </div>
                <button type="submit" class="btn">Save Changes</button>
            </form>
            <?php if (isset($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>