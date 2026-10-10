<?php
require_once 'auth_check.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>3 Pyramid Patterns</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            margin-top: 40px;
            background-color: #f4f7f6;
        }

        .box {
            width: 700px;
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
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        button {
            padding: 11px 25px;
            background-color: #8b5cf6;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            margin-left: 10px;
        }

        button:hover {
            background-color: #7c3aed;
        }

        .patterns {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }

        .pattern {
            width: 30%;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
        }

        .pattern h3 {
            font-size: 16px;
            color: #475569;
            margin-bottom: 10px;
        }

        pre {
            font-size: 16px;
            font-family: monospace;
            text-align: left;
            display: inline-block;
            line-height: 1.3;
            color: #1e293b;
        }

        .back-btn {
            display: inline-block;
            margin-top: 25px;
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
    <h2>3 Different Pyramid Patterns</h2>

    <form method="post">
        <input type="number" name="rows" placeholder="Enter Number of Rows (e.g. 5)" min="1" max="15" required>
        <button type="submit">Print Patterns</button>
    </form>

    <?php
    if (isset($_POST['rows'])) {
        $rows = (int)$_POST['rows'];

        echo "<div class='patterns'>";

        /* Pattern 1 - Right Triangle */
        echo "<div class='pattern'>";
        echo "<h3>Pattern 1</h3>";
        echo "<pre>";
        for ($i = 1; $i <= $rows; $i++) {
            for ($j = 1; $j <= $i; $j++) {
                echo "* ";
            }
            echo "\n";
        }
        echo "</pre>";
        echo "</div>";

        /* Pattern 2 - Inverted Triangle */
        echo "<div class='pattern'>";
        echo "<h3>Pattern 2</h3>";
        echo "<pre>";
        for ($i = $rows; $i >= 1; $i--) {
            for ($j = 1; $j <= $i; $j++) {
                echo "* ";
            }
            echo "\n";
        }
        echo "</pre>";
        echo "</div>";

        /* Pattern 3 - Full Pyramid */
        echo "<div class='pattern'>";
        echo "<h3>Pattern 3</h3>";
        echo "<pre>";
        for ($i = 1; $i <= $rows; $i++) {
            for ($j = 1; $j <= $rows - $i; $j++) {
                echo " ";
            }
            for ($j = 1; $j <= (2 * $i - 1); $j++) {
                echo "*";
            }
            echo "\n";
        }
        echo "</pre>";
        echo "</div>";

        echo "</div>";
    }
    ?>

    <div>
        <a href="index.php" class="back-btn">← Back to Home Page</a>
    </div>
</div>

</body>
</html>
