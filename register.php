<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If already logged in, redirect to home
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require_once 'db.php';

$error = "";
$success = "";
$redirect = isset($_GET['redirect']) ? htmlspecialchars($_GET['redirect']) : (isset($_POST['redirect']) ? htmlspecialchars($_POST['redirect']) : 'index.php');

if (isset($_GET['msg']) && $_GET['msg'] === 'auth_required') {
    $error = "Pehle Register ya Login karein taaki aap website ke items aur practicals access kar sakein.";
}

// Process POST registration request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName        = trim($_POST['fullName']);
    $username        = trim($_POST['username']);
    $email           = trim($_POST['email']);
    $mobile          = trim($_POST['mobile']);
    $password        = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $redirect_url    = !empty($_POST['redirect']) ? $_POST['redirect'] : 'index.php';

    if (empty($fullName) || empty($username) || empty($email) || empty($mobile) || empty($password) || empty($confirmPassword)) {
        $error = "Kripya sabhi fields dhyan se bharein.";
    } elseif ($password !== $confirmPassword) {
        $error = "Password aur Confirm Password match nahi ho rahe hain!";
    } elseif (strlen($password) < 4) {
        $error = "Password kam se kam 4 characters ka hona chahiye.";
    } else {
        // Check if username or email already exists
        $check_stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1");
        if ($check_stmt) {
            mysqli_stmt_bind_param($check_stmt, "ss", $username, $email);
            mysqli_stmt_execute($check_stmt);
            mysqli_stmt_store_result($check_stmt);

            if (mysqli_stmt_num_rows($check_stmt) > 0) {
                $error = "Yeh Username ya Email pehle se registered hai! Kripya doosra chunein ya Login karein.";
            } else {
                mysqli_stmt_close($check_stmt);

                // Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert new user
                $insert_stmt = mysqli_prepare($conn, "INSERT INTO users (full_name, username, email, mobile, password) VALUES (?, ?, ?, ?, ?)");
                if ($insert_stmt) {
                    mysqli_stmt_bind_param($insert_stmt, "sssss", $fullName, $username, $email, $mobile, $hashedPassword);

                    if (mysqli_stmt_execute($insert_stmt)) {
                        $new_user_id = mysqli_insert_id($conn);
                        mysqli_stmt_close($insert_stmt);

                        // Auto login after registration
                        $_SESSION['user_id']   = $new_user_id;
                        $_SESSION['full_name'] = $fullName;
                        $_SESSION['username']  = $username;
                        $_SESSION['email']     = $email;

                        header("Location: " . $redirect_url);
                        exit;
                    } else {
                        $error = "Registration me samasya aayi: " . mysqli_stmt_error($insert_stmt);
                    }
                } else {
                    $error = "Database error: " . mysqli_error($conn);
                }
            }
        } else {
            $error = "Database query error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - New User</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 25px 20px;
        }
        .register-card {
            background: #ffffff;
            width: 100%;
            max-width: 460px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .register-card h2 {
            text-align: center;
            color: #333;
            margin-bottom: 6px;
            font-size: 26px;
        }
        .register-card p.subtitle {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 18px;
            font-size: 14px;
            line-height: 1.4;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .form-group {
            margin-bottom: 14px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #444;
            font-size: 13.5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-group input:focus {
            border-color: #667eea;
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.2s;
        }
        .btn-submit:hover {
            background: #218838;
        }
        .card-footer {
            margin-top: 20px;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 15px;
            font-size: 14px;
            color: #555;
        }
        .card-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
        }
        .card-footer a:hover {
            text-decoration: underline;
        }
        .home-btn {
            display: inline-block;
            margin-top: 10px;
            color: #777;
            text-decoration: none;
            font-size: 13px;
        }
        .home-btn:hover {
            color: #333;
        }
    </style>
</head>
<body>

<div class="register-card">
    <h2>📝 Naya Account Banayein</h2>
    <p class="subtitle">Kripya apni jaankari bharein aur register karein</p>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <form action="register.php" method="POST">
        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">

        <div class="form-group">
            <label for="fullName">Poora Naam (Full Name)</label>
            <input type="text" id="fullName" name="fullName" placeholder="Apna poora naam daalein" value="<?php echo isset($_POST['fullName']) ? htmlspecialchars($_POST['fullName']) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Username chunein (jaise: mahesh22)" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="example@gmail.com" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="mobile">Mobile Number</label>
            <input type="tel" id="mobile" name="mobile" placeholder="10 digit mobile number" maxlength="10" value="<?php echo isset($_POST['mobile']) ? htmlspecialchars($_POST['mobile']) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password banayein" required>
        </div>

        <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Wahi password dobara daalein" required>
        </div>

        <button type="submit" class="btn-submit">Register Karein</button>
    </form>

    <div class="card-footer">
        <p>Pehle se account hai? <a href="login.php<?php echo !empty($redirect) ? '?redirect='.urlencode($redirect) : ''; ?>">Yahan Login Karein</a></p>
        <a href="index.php" class="home-btn">← Home Page Par Wapas Jaayein</a>
    </div>
</div>

</body>
</html>