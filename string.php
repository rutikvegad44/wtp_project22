<?php
require_once 'auth_check.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP String Program</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            margin-top: 50px;
            background-color: #f4f7f6;
        }

        .box {
            width: 450px;
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
            background-color: #f43f5e;
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
            background-color: #e11d48;
        }

        .result {
            margin-top: 20px;
            font-size: 16px;
            background: #fff1f2;
            border: 1px solid #ffe4e6;
            padding: 15px;
            border-radius: 8px;
            text-align: left;
        }

        .result h3 {
            font-size: 15px;
            color: #be123c;
            margin-bottom: 4px;
        }

        .result-val {
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 12px;
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
    <h2>PHP String Program</h2>

    <form method="post">
        <input type="text" name="name" placeholder="Enter Your Name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
        <input type="text" name="string" placeholder="Enter a String" value="<?php echo isset($_POST['string']) ? htmlspecialchars($_POST['string']) : ''; ?>" required>
        <button type="submit">Submit</button>
    </form>

    <?php
    if (isset($_POST['name']) && isset($_POST['string'])) {
        $name = htmlspecialchars($_POST['name']);
        $string = $_POST['string'];
        $size = strlen($string);

        echo "<div class='result'>";
        echo "<h3>10.2.1 Your Name:</h3>";
        echo "<div class='result-val'>$name</div>";

        echo "<h3>10.2.2 Size of String:</h3>";
        echo "<div class='result-val'>$size characters</div>";
        echo "</div>";
    }
    ?>

    <div>
        <a href="index.php" class="back-btn">← Back to Home Page</a>
    </div>
</div>

</body>
</html>
