<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "aqi");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// LOGIN HANDLER (via AJAX)
if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $email = $conn->real_escape_string($_POST['email']);
    $pass = $_POST['pass'];

    $result = $conn->query("SELECT * FROM user WHERE Email='$email'");

    if ($result && $result->num_rows === 1) {
        
        $row = $result->fetch_assoc();
 

        //updated
        if (password_verify($pass, $row['Password'])) {
            $_SESSION['email'] = $row['Email']; // Store user email in session
            echo 'success';
        }
        


        
        else {
            echo 'fail';
        }
    } else {
        echo 'fail';
    }
    exit;
}

// CONFIRMATION HANDLER (final step to save user)
if (isset($_POST['confirm'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password']; // already hashed
    $dob = $_POST['dob'];
    $country = $_POST['country'];
    $gender = $_POST['gender'];
    $opinion = $_POST['opinion'];
    $color = $_POST['color'];

    $stmt = $conn->prepare("INSERT INTO user (Fullname, Email, Password, Dob, Country, Gender, Opinion, Color) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $fullname, $email, $password, $dob, $country, $gender, $opinion, $color);



    if ($stmt->execute()) {
        echo "<script>
            alert('Information saved successfully!');
            window.location.href = 'index.html';
        </script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    exit();
}

// INITIAL FORM SUBMISSION HANDLER (from index.html)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT); // encrypt here
    $birthdate = htmlspecialchars($_POST['dob']);
    $country = htmlspecialchars($_POST['country']);
    $gender = htmlspecialchars($_POST['gender']);
    $color = htmlspecialchars($_POST['color']);
    $opinion = htmlspecialchars($_POST['bio']);
    ?>

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

    <div class="box">
        <h2>Confirm Your Information</h2>
        <div class="info">
            <p><strong>Full Name:</strong> <?= $fullname ?></p>
            <p><strong>Email:</strong> <?= $email ?></p>
            <p><strong>Birthdate:</strong> <?= $birthdate ?></p>
            <p><strong>Country:</strong> <?= $country ?></p>
            <p><strong>Gender:</strong> <?= ucfirst($gender) ?></p>
            <p><strong>Favorite Color:</strong> <span style="color: <?= $color ?>;"><?= $color ?></span></p>
            <p><strong>Opinion:</strong> <?= $opinion ?></p>
        </div>

        <div class="buttons">
            <form action="index.html" method="get" style="margin:0;">
                <button type="submit" class="back-btn">Back</button>
            </form>

            <form method="post" style="margin:0;">
                <!-- Hidden inputs to pass data -->
                <input type="hidden" name="fullname" value="<?= $fullname ?>">
                <input type="hidden" name="email" value="<?= $email ?>">
                <input type="hidden" name="password" value="<?= $password ?>">
                <input type="hidden" name="dob" value="<?= $birthdate ?>">
                <input type="hidden" name="country" value="<?= $country ?>">
                <input type="hidden" name="gender" value="<?= $gender ?>">
                <input type="hidden" name="opinion" value="<?= $opinion ?>">
                <input type="hidden" name="color" value="<?= $color ?>">


                <button type="submit" name="confirm" class="confirm-btn">Confirm</button>
            </form>
        </div>
    </div>

    </body>
    </html>

    <?php
} else {
    echo "<p>Invalid request.</p>";
}
?>
