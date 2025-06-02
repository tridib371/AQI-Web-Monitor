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
            background: linear-gradient(rgb(46, 46, 44));
            margin: 0;
            padding: 0;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }

        .left-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .top-bar button {
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            font-weight: bold;
            color: white;
            background-color: #5c6bc0;
            transition: background 0.2s;
        }

        .top-bar button:hover {
            background-color: #3f51b5;
        }

        .avatar {
            display: none;
            margin-left: 10px;
        }

        .avatar img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 2px solid #3f51b5;
        }

        .container {
            max-width: 600px;
            background: white;
            margin: 20px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .city-item {
            background: linear-gradient(to right,rgb(88, 105, 235),rgb(111, 120, 152));
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
            accent-color:rgb(40, 18, 36);
        }

        input[type="submit"] {
            background: linear-gradient(rgb(120, 76, 195));
            border: none;
            color: white;
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            display: block;
            margin: 30px auto 0;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background: linear-gradient(rgb(36, 199, 47));
        }
    </style>
</head>
<body>

    <div class="top-bar">
        <div class="left-controls">
            <button onclick="toggleAvatar()">Username</button>
            <div class="avatar" id="avatarBox">
                <img src="https://i.pravatar.cc/100?img=3" alt="User Avatar">
            </div>
        </div>
        <button onclick="logout()">Logout</button>
    </div>

    <div class="container">
        <h2>Select Between 1 to 10 Cities</h2>
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
            if (checkboxes.length === 0 || checkboxes.length > 10) {
                alert("Please select between 1 and 10 cities.");
                return false;
            }
            return true;
        }

        function toggleAvatar() {
            const avatar = document.getElementById("avatarBox");
            avatar.style.display = avatar.style.display === "none" || avatar.style.display === "" ? "block" : "none";
        }

        function logout() {
            window.location.href = "index.html";
        }
    </script>

</body>
</html>
