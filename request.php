<?php
// request.php
$connection = new mysqli("localhost", "root", "", "aqi");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$query = "SELECT id, city FROM info";
$result = $connection->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Select 10 Cities</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #e0f7fa, #e1bee7);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            background: white;
            margin: 50px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .city-item {
            background: linear-gradient(to right, #ffccbc, #ffe0b2);
            padding: 10px 15px;
            margin: 10px 0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
            color: #333;
        }

        input[type="checkbox"] {
            transform: scale(1.3);
            accent-color: #f57c00;
        }

        input[type="submit"] {
            background: linear-gradient(to right, #26c6da, #7e57c2);
            border: none;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            display: block;
            margin: 30px auto 0;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background: linear-gradient(to right, #00acc1, #5e35b1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Select Exactly 10 Cities</h2>
        <form action="showAqi.php" method="POST" onsubmit="return validateForm();">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <label class="city-item">
                    <input type="checkbox" name="cities[]" value="<?= $row['id']; ?>">
                    <?= htmlspecialchars($row['city']); ?>
                </label>
            <?php endwhile; ?>
            <input type="submit" value="Submit">
        </form>
    </div>

    <script>
        function validateForm() {
            const checkboxes = document.querySelectorAll('input[name="cities[]"]:checked');
            if (checkboxes.length !== 10) {
                alert("Please select exactly 10 cities.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
