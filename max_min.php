<?php
require_once 'auth_check.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Maximum and Minimum</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            margin-top: 50px;
            background-color: #f4f7f6;
        }

        .box {
            width: 400px;
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
            font-weight: bold;
        }

        button:hover {
            background-color: #2563eb;
        }

        .result {
            margin-top: 20px;
            padding: 15px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            text-align: left;
        }

        .result h3 {
            margin: 5px 0;
            font-size: 16px;
            color: #166534;
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
    <h2>Find Maximum and Minimum</h2>

    <form method="post">
        <input type="number" name="num1" placeholder="Enter First Number" value="<?php echo isset($_POST['num1']) ? htmlspecialchars($_POST['num1']) : ''; ?>" required>
        <input type="number" name="num2" placeholder="Enter Second Number" value="<?php echo isset($_POST['num2']) ? htmlspecialchars($_POST['num2']) : ''; ?>" required>
        <input type="number" name="num3" placeholder="Enter Third Number" value="<?php echo isset($_POST['num3']) ? htmlspecialchars($_POST['num3']) : ''; ?>" required>
        <button type="submit">Find Max & Min</button>
    </form>

<?php
if (isset($_POST['num1']) && isset($_POST['num2']) && isset($_POST['num3'])) {
    $num1 = (float)$_POST['num1'];
    $num2 = (float)$_POST['num2'];
    $num3 = (float)$_POST['num3'];

    $max = max($num1, $num2, $num3);
    $min = min($num1, $num2, $num3);

    echo "<div class='result'>";
    echo "<h3>🔹 Maximum = $max</h3>";
    echo "<h3>🔹 Minimum = $min</h3>";
    echo "</div>";
}
?>

    <div>
        <a href="index.php" class="back-btn">← Back to Home Page</a>
    </div>
</div>

</body>
</html>
