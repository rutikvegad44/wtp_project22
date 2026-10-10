<?php
require_once 'auth_check.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Maximum of 3 Numbers</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            margin-top: 50px;
            background-color: #f4f7f6;
        }

        .box {
            width: 380px;
            margin: auto;
            padding: 30px;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        input {
            padding: 10px 12px;
            margin: 8px 0;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
        }

        button {
            padding: 11px 25px;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
        }

        button:hover {
            background-color: #2563eb;
        }

        .result {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #059669;
            background-color: #d1fae5;
            padding: 10px;
            border-radius: 6px;
        }

        .back-btn {
            display: inline-block;
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
    <h2>Find Maximum Value</h2>

    <form method="post">
        <input type="number" name="num1" placeholder="Enter First Value" required>
        <input type="number" name="num2" placeholder="Enter Second Value" required>
        <input type="number" name="num3" placeholder="Enter Third Value" required>
        <button type="submit">Find Maximum</button>
    </form>

    <?php
    if (isset($_POST['num1']) && isset($_POST['num2']) && isset($_POST['num3'])) {
        $num1 = $_POST['num1'];
        $num2 = $_POST['num2'];
        $num3 = $_POST['num3'];

        if ($num1 >= $num2 && $num1 >= $num3) {
            $max = $num1;
        }
        elseif ($num2 >= $num1 && $num2 >= $num3) {
            $max = $num2;
        }
        else {
            $max = $num3;
        }

        echo "<div class='result'>Maximum Value = $max</div>";
    }
    ?>

    <div>
        <a href="index.php" class="back-btn">← Back to Home Page</a>
    </div>
</div>

</body>
</html>
