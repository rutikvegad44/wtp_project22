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

// Handle notification messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'auth_required') {
        $error = "Pehle Login ya Register karein taaki aap content/items dekh sakein.";
    } elseif ($_GET['msg'] === 'registered') {
        $success = "Registration safaltapoorvak ho gaya hai! Kripya login karein.";
    } elseif ($_GET['msg'] === 'logged_out') {
        $success = "Aap successfully logout ho chuke hain.";
    }
}

// Process POST login request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_identifier = trim($_POST['user_identifier']);
    $password        = trim($_POST['password']);
    $redirect_url    = !empty($_POST['redirect']) ? $_POST['redirect'] : 'index.php';

    if (empty($user_identifier) || empty($password)) {
        $error = "Kripya Username/Email aur Password dono bharein.";
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, full_name, username, email, password FROM users WHERE username = ? OR email = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "ss", $user_identifier, $user_identifier);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            // Verify password (supports hashed and fallback plain text)
            if (password_verify($password, $user['password']) || $password === $user['password']) {
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['username']  = $user['username'];
                $_SESSION['email']     = $user['email'];

                header("Location: " . $redirect_url);
                exit;
            } else {
                $error = "Password galat hai! Kripya dobara koshish karein.";
            }
        } else {
            $error = "Account nahi mila! Agar aap naye user hain, to kripya pehle Register karein.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - User Portal</title>
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
            padding: 20px;
        }
        .login-card {
            background: #ffffff;
            width: 100%;
            max-width: 420px;
            padding: 35px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .login-card h2 {
            text-align: center;
            color: #333;
            margin-bottom: 8px;
            font-size: 26px;
        }
        .login-card p.subtitle {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 22px;
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
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #444;
            font-size: 14px;
        }
        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #ddd;
            border-radius: 6px;
            font-size: 15px;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-group input:focus {
            border-color: #667eea;
        }
        .btn-submit {
            width: 100%;
            padding: 13px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-submit:hover {
            background: #5a6fd6;
        }
        .card-footer {
            margin-top: 22px;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 18px;
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
            margin-top: 12px;
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

<div class="login-card">
    <h2>🔐 User Login</h2>
    <p class="subtitle">Apna account login karein aur items access karein</p>

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

    <form action="login.php" method="POST">
        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">

        <div class="form-group">
            <label for="user_identifier">Username ya Email</label>
            <input type="text" id="user_identifier" name="user_identifier" placeholder="Apna Username ya Email daalein" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Apna Password daalein" required>
        </div>

        <button type="submit" class="btn-submit">Login Karein</button>
    </form>

    <div class="card-footer">
        <p>Naye User hain? <a href="register.php<?php echo !empty($redirect) ? '?redirect='.urlencode($redirect) : ''; ?>">Yahan Register Karein</a></p>
        <a href="index.php" class="home-btn">← Home Page Par Wapas Jaayein</a>
    </div>
</div>

</body>
</html>