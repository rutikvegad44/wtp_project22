<?php
require_once "auth_check.php";
require_once "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?msg=auth_required");
    exit();
}

$message = "";

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $age = (int)$_POST['age'];
    $city = mysqli_real_escape_string($conn, $_POST['city']);

    $sql = "INSERT INTO profile (user_id, name, email, age, city)
            VALUES ('$user_id', '$name', '$email', '$age', '$city')
            ON DUPLICATE KEY UPDATE name='$name', email='$email', age='$age', city='$city'";

    if (mysqli_query($conn, $sql)) {
        header("Location: profile.php");
        exit();
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Practical No.7 - User Profile Form</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 40px 20px;
        }

        .form-box {
            max-width: 450px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        h2 {
            text-align: center;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #475569;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #2563eb;
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

<div class="form-box">
    <h2>Practical No.7 - User Profile Form</h2>

    <?php if (!empty($message)): ?>
        <p style="color:red;"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($_SESSION['full_name'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label>Age</label>
            <input type="number" name="age" placeholder="Enter age" required>
        </div>

        <div class="form-group">
            <label>City</label>
            <input type="text" name="city" placeholder="Enter city" required>
        </div>

        <button type="submit" name="submit">Submit Profile</button>
    </form>

    <a href="index.php" class="back-btn">← Back to Home Page</a>
</div>

</body>
</html>
