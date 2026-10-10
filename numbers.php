<?php
require_once 'auth_check.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Print 1 to N Numbers</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            margin-top: 50px;
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
            background-color: #10b981;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
        }

        button:hover {
            background-color: #059669;
        }

        .result {
            margin-top: 20px;
            font-size: 16px;
            color: #1e293b;
            background-color: #e0f2fe;
            padding: 14px;
            border-radius: 6px;
            line-height: 1.6;
            word-wrap: break-word;
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
    <h2>Print 1 to N Numbers</h2>

    <form method="post">
        <input type="number" name="n" placeholder="Enter N (e.g. 10)" min="1" required>
        <button type="submit">Print Numbers</button>
    </form>

    <?php
    if (isset($_POST['n'])) {
        $n = (int)$_POST['n'];

        echo "<div class='result'>";
        echo "<b>Numbers from 1 to $n:</b><br><br>";

        for ($i = 1; $i <= $n; $i++) {
            echo $i . " ";
        }

        echo "</div>";
    }
    ?>

    <div>
        <a href="index.php" class="back-btn">← Back to Home Page</a>
    </div>
</div>

</body>
</html>
