<?php
// showAqi.php
session_start();

if (!isset($_POST['cities']) || count($_POST['cities']) < 1 || count($_POST['cities']) > 10) {
    die("Error: You must select between 1 and 10 cities.");
}

$selectedIds = $_POST['cities'];

$connection = new mysqli("localhost", "root", "", "aqi");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get user's background color from database using session email
$userEmail = $_SESSION['email'] ?? null;
$bgColor = "#ffffff"; // Default color

if ($userEmail) {
    $stmt = $connection->prepare("SELECT color FROM user WHERE Email = ?");
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $stmt->bind_result($dbColor);
    if ($stmt->fetch() && !empty($dbColor)) {
        $bgColor = htmlspecialchars($dbColor);
    }
    $stmt->close();
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
            background-color: <?= $bgColor ?>;
            margin: 0;
            padding: 0;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .username-btn, .logout-btn {
            padding: 10px 16px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .username-btn {
            background-color: #81d4fa;
            color: #01579b;
        }

        .logout-btn {
            background-color: #ef5350;
            color: white;
        }

        .avatar {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            margin-left: 10px;
            display: none;
            vertical-align: middle;
        }

        .container {
            max-width: 700px;
            background: white;
            margin: 60px auto;
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

    <div class="top-bar">
        <div>
            <button class="username-btn" onclick="toggleAvatar()">Username</button>
            <img src="https://i.pravatar.cc/40" class="avatar" id="avatar" alt="Avatar">
        </div>
        <button class="logout-btn" onclick="logout()">Logout</button>
    </div>

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

    <script>
        function toggleAvatar() {
            const avatar = document.getElementById('avatar');
            avatar.style.display = avatar.style.display === 'inline-block' ? 'none' : 'inline-block';
        }

        function logout() {
            window.location.href = "index.html";
        }
    </script>

<footer style="margin-top: 60px; background: #006266; padding: 30px 20px; text-align: center; border-top: 2px solid #b0bec5;">
        <h2 style="color: black;margin-left:40px; margin-bottom: 20px;">This system is developed by</h2>
        <div style="display: flex; justify-content: center; gap: 40px; flex-wrap: wrap;">

        <div style="max-width: 220px;">
                <img src="./assets/shan.jpeg" alt="Tridib Sarkar" style="width: 100px; height: 100px; border-radius: 50%; border: 3px solid #0288d1;">
                <p style="margin: 10px 0 0; font-weight: bold; color: white;">NAZMUS SAKIB SHAN
                </p>
                <p style="margin: 4px 0; color: white;">Course Instructor</p>
                <p style="margin: 4px 0; color: white;">AIUB</p>
            </div>

            <div style="max-width: 220px;">
                <img src="./assets/mehedi.png" alt="Mehedi Hasan Polash" style="width: 100px; height: 100px; border-radius: 50%; border: 3px solid #0288d1;">
                <p style="margin: 10px 0 0; font-weight: bold; color: white;">Md Mehedi Hasan Polash</p>
                <p style="margin: 4px 0; color: white;">ID: 22-46566-1</p>
                <p style="margin: 4px 0; color: white;">AIUB</p>
            </div>
            <div style="max-width: 220px;">
                <img src="./assets/tridib.png" alt="Tridib Sarkar" style="width: 100px; height: 100px; border-radius: 50%; border: 3px solid #0288d1;">
                <p style="margin: 10px 0 0; font-weight: bold; color: white;">Tridib Sarkar</p>
                <p style="margin: 4px 0; color: white;">ID: 22-46444-1</p>
                <p style="margin: 4px 0; color: white;">AIUB</p>
            </div>
        </div>
    </footer>


    

</body>
</html>
