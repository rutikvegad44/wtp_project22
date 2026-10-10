<?php
require_once 'auth_check.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP Array Operations</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            margin-top: 40px;
            background-color: #f4f7f6;
        }

        .box {
            width: 550px;
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
            background-color: #f59e0b;
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
            background-color: #d97706;
        }

        .result {
            margin-top: 25px;
            text-align: left;
            background: #fffbeb;
            border: 1px solid #fde68a;
            padding: 20px;
            border-radius: 8px;
        }

        .result h3 {
            font-size: 15px;
            color: #b45309;
            margin-top: 10px;
            margin-bottom: 4px;
        }

        .result h3:first-child {
            margin-top: 0;
        }

        .result-val {
            font-size: 16px;
            font-weight: bold;
            color: #1e293b;
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
    <h2>PHP Array Operations</h2>

    <form method="post">
        <input type="text" name="array1" placeholder="Array 1 (comma separated: e.g. 5, 2, 8, 1)" value="<?php echo isset($_POST['array1']) ? htmlspecialchars($_POST['array1']) : '5, 2, 8, 1'; ?>" required>
        <input type="text" name="array2" placeholder="Array 2 (comma separated: e.g. 7, 3, 9, 4)" value="<?php echo isset($_POST['array2']) ? htmlspecialchars($_POST['array2']) : '7, 3, 9, 4'; ?>" required>
        <button type="submit">Perform Operations</button>
    </form>

<?php
if (isset($_POST['array1']) && isset($_POST['array2'])) {
    $array1 = explode(",", $_POST['array1']);
    $array2 = explode(",", $_POST['array2']);

    foreach ($array1 as $key => $value) {
        $array1[$key] = (int) trim($value);
    }
    foreach ($array2 as $key => $value) {
        $array2[$key] = (int) trim($value);
    }

    echo "<div class='result'>";

    echo "<h3>1. Array 1 Values:</h3>";
    echo "<div class='result-val'>" . implode(", ", $array1) . "</div>";

    echo "<h3>2. Reverse of Array 1:</h3>";
    $reverse = array_reverse($array1);
    echo "<div class='result-val'>" . implode(", ", $reverse) . "</div>";

    echo "<h3>3. Merged and Sorted Array:</h3>";
    $merge = array_merge($array1, $array2);
    sort($merge);
    echo "<div class='result-val'>" . implode(", ", $merge) . "</div>";

    echo "<h3>4. Sum of Array 1:</h3>";
    $sum = array_sum($array1);
    echo "<div class='result-val'>$sum</div>";

    echo "</div>";
}
?>

    <div>
        <a href="index.php" class="back-btn">← Back to Home Page</a>
    </div>
</div>

</body>
</html>
