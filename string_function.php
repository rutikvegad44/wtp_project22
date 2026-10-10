<?php
require_once 'auth_check.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>String Functions</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            margin-top: 40px;
            background-color: #f4f7f6;
        }

        .box {
            width: 500px;
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

        .form-group {
            text-align: left;
            margin-bottom: 12px;
        }

        .form-group label {
            display: block;
            margin-bottom: 4px;
            font-weight: 600;
            font-size: 13.5px;
            color: #475569;
        }

        input {
            padding: 10px 12px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
        }

        button {
            padding: 11px 25px;
            background-color: #0284c7;
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
            background-color: #0369a1;
        }

        .result {
            margin-top: 20px;
            padding: 15px;
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            text-align: left;
            font-size: 14px;
            line-height: 1.8;
            color: #0c4a6e;
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
    <h2>String Operations & Functions</h2>

    <form method="post">
        <div class="form-group">
            <label>Your Name:</label>
            <input type="text" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" placeholder="Enter Your Name" required>
        </div>

        <div class="form-group">
            <label>First String:</label>
            <input type="text" name="string1" value="<?php echo isset($_POST['string1']) ? htmlspecialchars($_POST['string1']) : ''; ?>" placeholder="Enter First String" required>
        </div>

        <div class="form-group">
            <label>Second String:</label>
            <input type="text" name="string2" value="<?php echo isset($_POST['string2']) ? htmlspecialchars($_POST['string2']) : ''; ?>" placeholder="Enter Second String" required>
        </div>

        <div class="form-group">
            <label>String to Search:</label>
            <input type="text" name="find" value="<?php echo isset($_POST['find']) ? htmlspecialchars($_POST['find']) : ''; ?>" placeholder="Enter String to Find" required>
        </div>

        <button type="submit">Perform Operations</button>
    </form>

<?php
if (isset($_POST['name'])) {
    $name = htmlspecialchars($_POST['name']);
    $string1 = $_POST['string1'];
    $string2 = $_POST['string2'];
    $find = $_POST['find'];

    echo "<div class='result'>";
    echo "<b>1. Name:</b> " . $name . "<br>";
    echo "<b>2. Size of String 1:</b> " . strlen($string1) . "<br>";
    echo "<b>3. Concatenated:</b> " . htmlspecialchars($string1 . " " . $string2) . "<br>";
    echo "<b>4. Upper Case:</b> " . htmlspecialchars(strtoupper($string1)) . "<br>";
    echo "<b>5. Lower Case:</b> " . htmlspecialchars(strtolower($string1)) . "<br>";

    if (strpos($string1, $find) !== false) {
        echo "<b>6. Search:</b> <span style='color:green; font-weight:bold;'>String '" . htmlspecialchars($find) . "' Found in String 1!</span>";
    } else {
        echo "<b>6. Search:</b> <span style='color:red; font-weight:bold;'>String '" . htmlspecialchars($find) . "' Not Found!</span>";
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
