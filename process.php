
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Submitted Data</title>
    <style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background: #474787;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
    }

    .box {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 40px 50px;
        max-width: 600px;
        width: 100%;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .box:hover {
        transform: scale(1.01);
    }

    .box h2 {
        text-align: center;
        margin-bottom: 28px;
        color: #2c3e50;
        font-size: 28px;
    }

    .info p {
        margin: 12px 0;
        padding: 6px 0;
        font-size: 18px;
        line-height: 1.6;
    }

    .buttons {
        margin-top: 35px;
        display: flex;
        justify-content: center;
        gap: 28px;
    }

    .buttons button {
        padding: 12px 28px;
        border: none;
        border-radius: 8px;
        font-size: 17px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.2s ease;
    }

    .confirm-btn {
        background-color: #4caf50;
        color: white;
        border: 2px solid #388e3c;
    }

    .confirm-btn:hover {
        background-color: #388e3c;
    }

    .back-btn {
        background-color: #f57c00;
        color: white;
        border: 2px solid #e65100;
    }

    .back-btn:hover {
        background-color: #e65100;
    }
</style>


</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $birthdate = htmlspecialchars($_POST['dob']);
    $country = htmlspecialchars($_POST['country']);
    $gender = htmlspecialchars($_POST['gender']);
    $color = htmlspecialchars($_POST['color']);
    $opinion = htmlspecialchars($_POST['bio']);

    echo '<div class="box">';
    echo '<h2>Confirm Your Information</h2>';

    echo '<div class="info">';
    echo "<p><strong>Full Name:</strong> $fullname</p>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo "<p><strong>Birthdate:</strong> $birthdate</p>";
    echo "<p><strong>Country:</strong> $country</p>";
    echo "<p><strong>Gender:</strong> " . ucfirst($gender) . "</p>";
    echo "<p><strong>Favorite Color:</strong> <span style='color: $color;'>$color</span></p>";
    echo "<p><strong>Opinion:</strong> $opinion</p>";
    echo '</div>';

    echo '<div class="buttons">';
    echo '<form action="index.html" method="get" style="margin:0;">';
    echo '<button type="submit" class="back-btn">Back</button>';
    echo '</form>';
    echo '<button class="confirm-btn" onclick="confirmAction()">Confirm</button>';
    echo '</div>';
    echo '</div>';
} else {
    echo '<p>Invalid request method.</p>';
}
?>



</body>
</html>