<?php
require_once 'auth_check.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Date and Time</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            margin-top: 60px;
            background-color: #f4f7f6;
        }

        .box {
            width: 420px;
            margin: auto;
            padding: 30px;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        h2 {
            color: #333;
            margin-bottom: 25px;
        }

        .time-box {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: left;
            font-size: 16px;
            line-height: 1.8;
            color: #065f46;
        }

        .greeting {
            font-size: 20px;
            font-weight: bold;
            color: #047857;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #6ee7b7;
        }

        .back-btn {
            display: inline-block;
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
    <h2>⏰ Current Date and Time</h2>

    <div class="time-box">
        <?php
        date_default_timezone_set("Asia/Kolkata");

        $date = date("d-m-Y");
        $time = date("h:i:s A");
        $day  = date("l");
        $hour = date("H");

        echo "<b>📅 Date:</b> " . $date . " (" . $day . ")<br>";
        echo "<b>⏱️ Time:</b> " . $time . "<br>";

        echo "<div class='greeting'>";
        if ($hour < 12) {
            echo "☀️ Good Morning!";
        } elseif ($hour < 17) {
            echo "🌤️ Good Afternoon!";
        } else {
            echo "🌙 Good Evening!";
        }
        echo "</div>";
        ?>
    </div>

    <div>
        <a href="index.php" class="back-btn">← Back to Home Page</a>
    </div>
</div>

</body>
</html>
