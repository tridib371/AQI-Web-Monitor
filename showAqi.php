<?php
// showAqi.php
if (!isset($_POST['cities']) || count($_POST['cities']) !== 10) {
    die("Error: You must select exactly 10 cities.");
}

$selectedIds = $_POST['cities'];

$connection = new mysqli("localhost", "root", "", "aqi");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$ids = implode(",", array_map('intval', $selectedIds));
$query = "SELECT city, country, aqi FROM info WHERE id IN ($ids)";
$result = $connection->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Selected City AQI</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #e1f5fe, #f3e5f5);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            background: white;
            margin: 50px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #444;
        }

        .city-card {
            background: linear-gradient(to right, #c8e6c9, #b2dfdb);
            padding: 15px 20px;
            margin: 15px 0;
            border-radius: 10px;
            color: #333;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .city-card span {
            font-weight: bold;
            color: #00796b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Selected Cities and Their AQI</h2>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <div class="city-card">
                <div><span>City:</span> <?= htmlspecialchars($row['city']); ?></div>
                <div><span>Country:</span> <?= htmlspecialchars($row['country']); ?></div>
                <div><span>AQI:</span> <?= htmlspecialchars($row['aqi']); ?></div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
