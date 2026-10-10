<?php
require_once "auth_check.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Profile Information</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 40px 20px;
        }

        .box {
            max-width: 450px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            text-align: left;
        }

        h2 {
            text-align: center;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .info-row {
            padding: 10px 0;
            border-bottom: 1px solid #e2e8f0;
            font-size: 15px;
        }

        .back-btn {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
        }

        .back-btn:hover {
            color: #1e293b;
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="box">
    <h2>User Profile Information</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['name'])) {
        $name  = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $age   = htmlspecialchars($_POST['age']);
        $city  = htmlspecialchars($_POST['city']);

        echo "<div class='info-row'><b>Name:</b> $name</div>";
        echo "<div class='info-row'><b>Email:</b> $email</div>";
        echo "<div class='info-row'><b>Age:</b> $age</div>";
        echo "<div class='info-row'><b>City:</b> $city</div>";
    } else {
        echo "<p>No profile data submitted.</p>";
    }
    ?>

    <a href="index.php" class="back-btn">← Back to Home Page</a>
</div>

</body>
</html>
