<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$is_logged_in = isset($_SESSION['user_id']);
$user_name = $is_logged_in ? $_SESSION['full_name'] : '';
$username = $is_logged_in ? $_SESSION['username'] : '';

// Function to generate smart link based on login state
function getItemLink($target_url, $is_logged_in) {
    if ($is_logged_in) {
        return $target_url;
    } else {
        // Redirect guest user to login / register with return destination
        return "login.php?msg=auth_required&redirect=" . urlencode($target_url);
    }
}
?>
<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Government MCA College Project Portal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f4f7f6;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Top Header */
        .top-header {
            background: linear-gradient(135deg, #ff8c00, #ff5722);
            color: white;
            padding: 22px 30px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .top-header h1 {
            font-size: 30px;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .top-header p {
            font-size: 15px;
            opacity: 0.95;
        }

        /* Navigation Bar */
        .navbar {
            background-color: #1e293b;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .nav-links {
            display: flex;
            list-style: none;
            align-items: center;
        }

        .nav-links li a {
            color: #e2e8f0;
            text-decoration: none;
            padding: 16px 18px;
            display: block;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-links li a:hover, .nav-links li a.active {
            background-color: #334155;
            color: #38bdf8;
        }

        /* User Auth in Nav */
        .nav-auth {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-greeting {
            color: #f1f5f9;
            font-size: 14px;
            font-weight: 600;
        }

        .user-greeting span {
            color: #38bdf8;
        }

        .btn-nav {
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-block;
        }

        .btn-nav-login {
            background-color: transparent;
            color: #ffffff;
            border: 1px solid #64748b;
        }

        .btn-nav-login:hover {
            background-color: #334155;
            border-color: #94a3b8;
        }

        .btn-nav-register {
            background-color: #3b82f6;
            color: white;
            border: 1px solid #3b82f6;
        }

        .btn-nav-register:hover {
            background-color: #2563eb;
        }

        .btn-nav-logout {
            background-color: #ef4444;
            color: white;
            border: 1px solid #ef4444;
        }

        .btn-nav-logout:hover {
            background-color: #dc2626;
        }

        /* Banner Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 25px 20px;
            flex: 1;
            width: 100%;
        }

        /* Alert / Status Bar */
        .status-banner {
            padding: 14px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 15px;
        }

        .status-guest {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .status-user {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        .status-banner .btn-action {
            padding: 6px 14px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
        }

        /* Hero section */
        .hero {
            background: white;
            padding: 35px 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            text-align: center;
        }

        .hero h2 {
            font-size: 26px;
            color: #1e293b;
            margin-bottom: 12px;
        }

        .hero p {
            font-size: 16px;
            color: #64748b;
            max-width: 750px;
            margin: 0 auto 15px;
            line-height: 1.6;
        }

        /* Grid of Items */
        .section-title {
            font-size: 22px;
            color: #1e293b;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
            gap: 22px;
            margin-bottom: 35px;
        }

        .item-card {
            background: white;
            border-radius: 10px;
            padding: 22px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.06);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s, box-shadow 0.2s;
            border-top: 4px solid #3b82f6;
        }

        .item-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }

        .item-card.green { border-top-color: #10b981; }
        .item-card.purple { border-top-color: #8b5cf6; }
        .item-card.orange { border-top-color: #f59e0b; }
        .item-card.rose { border-top-color: #f43f5e; }

        .item-icon {
            font-size: 32px;
            margin-bottom: 12px;
        }

        .item-title {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .item-desc {
            font-size: 14px;
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 18px;
            flex-grow: 1;
        }

        .item-btn {
            display: inline-block;
            text-align: center;
            padding: 10px 16px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.2s;
        }

        .item-btn:hover {
            background: #1d4ed8;
        }

        .item-btn.locked {
            background: #475569;
        }

        .item-btn.locked:hover {
            background: #334155;
        }

        /* Footer */
        .footer {
            background: #0f172a;
            color: #94a3b8;
            text-align: center;
            padding: 20px;
            font-size: 14px;
            margin-top: auto;
        }
    </style>
</head>
<body>

    <!-- ================= TOP HEADER ================= -->
    <header class="top-header">
        <h1>Government MCA College, Maninagar</h1>
        <p>Web Development & PHP Practical Project Portal</p>
    </header>

    <!-- ================= NAVBAR ================= -->
    <nav class="navbar">
        <ul class="nav-links">
            <li><a href="index.php" class="active">🏠 Home</a></li>
            <li><a href="<?php echo getItemLink('practical 2/index.php', $is_logged_in); ?>">About Group</a></li>
            <li><a href="<?php echo getItemLink('practical 3/form.php', $is_logged_in); ?>">Application Form</a></li>
            <li><a href="<?php echo getItemLink('practical 4/cal.php', $is_logged_in); ?>">Calculator</a></li>
            <li><a href="<?php echo getItemLink('profile.php', $is_logged_in); ?>">My Profile</a></li>
            <li><a href="<?php echo getItemLink('Webpage.php', $is_logged_in); ?>">College Webpage</a></li>
        </ul>

        <div class="nav-auth">
            <?php if ($is_logged_in): ?>
                <span class="user-greeting">👋 Hello, <span><?php echo htmlspecialchars($user_name); ?></span></span>
                <a href="profile.php" class="btn-nav btn-nav-login">Profile</a>
                <a href="logout.php" class="btn-nav btn-nav-logout">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn-nav btn-nav-login">Login</a>
                <a href="register.php" class="btn-nav btn-nav-register">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- ================= MAIN CONTAINER ================= -->
    <div class="container">

        <!-- Status Message Banner -->
        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'logged_out'): ?>
            <div class="status-banner status-guest">
                <span>ℹ️ Aap successfully logout ho chuke hain. Website dekhne ke liye dhanyawad!</span>
            </div>
        <?php endif; ?>

        <?php if ($is_logged_in): ?>
            <div class="status-banner status-user">
                <span>✅ <b>Aap Logged In hain (<?php echo htmlspecialchars($username); ?>).</b> Aap sabhi items aur practicals bina kisi rok-tok ke dekh sakte hain!</span>
            </div>
        <?php else: ?>
            <div class="status-banner status-guest">
                <span>👋 <b>Namaste Guest User!</b> Aap home page dekh rahe hain. Kisi bhi item ya practical ko open karne ke liye pehle Login ya Register karein.</span>
                <div>
                    <a href="register.php" class="btn-nav btn-nav-register" style="padding: 5px 12px; font-size: 13px;">Register</a>
                    <a href="login.php" class="btn-nav btn-nav-login" style="color: #333; border-color: #888; padding: 5px 12px; font-size: 13px;">Login</a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Hero Section -->
        <div class="hero">
            <h2>Welcome to Project & Practical Portal</h2>
            <p>
                Yeh website PHP aur HTML par aadharit hai. Yahan aap sabhi PHP practical programs, job application forms, calculator aur user profile management system dekh sakte hain.
            </p>
        </div>

        <!-- ================= ITEMS & PRACTICALS GRID ================= -->
        <h3 class="section-title">📦 Website Items & Practicals</h3>

        <div class="items-grid">

            <!-- Item 1: Maximum of 3 -->
            <div class="item-card">
                <div>
                    <div class="item-icon">🔢</div>
                    <div class="item-title">9.1 Maximum of 3 Values</div>
                    <div class="item-desc">3 numbers me se sabse bada number find karne ka PHP program.</div>
                </div>
                <a href="<?php echo getItemLink('max.php', $is_logged_in); ?>" class="item-btn <?php echo !$is_logged_in ? 'locked' : ''; ?>">
                    <?php echo $is_logged_in ? 'Open Program ➔' : '🔒 Login to View'; ?>
                </a>
            </div>

            <!-- Item 2: Print 1 to N -->
            <div class="item-card green">
                <div>
                    <div class="item-icon">📜</div>
                    <div class="item-title">9.2 Print 1 to N Numbers</div>
                    <div class="item-desc">1 se lekar N tak numbers ko display karne ka loop program.</div>
                </div>
                <a href="<?php echo getItemLink('numbers.php', $is_logged_in); ?>" class="item-btn <?php echo !$is_logged_in ? 'locked' : ''; ?>">
                    <?php echo $is_logged_in ? 'Open Program ➔' : '🔒 Login to View'; ?>
                </a>
            </div>

            <!-- Item 3: Pyramid Patterns -->
            <div class="item-card purple">
                <div>
                    <div class="item-icon">🔺</div>
                    <div class="item-title">9.3 Pyramid Patterns</div>
                    <div class="item-desc">3 alag-alag tarah ke star pyramid pattern generation logic.</div>
                </div>
                <a href="<?php echo getItemLink('pyramid.php', $is_logged_in); ?>" class="item-btn <?php echo !$is_logged_in ? 'locked' : ''; ?>">
                    <?php echo $is_logged_in ? 'Open Program ➔' : '🔒 Login to View'; ?>
                </a>
            </div>

            <!-- Item 4: Array Operations -->
            <div class="item-card orange">
                <div>
                    <div class="item-icon">📊</div>
                    <div class="item-title">10.1 Array Operations</div>
                    <div class="item-desc">PHP Array sorting, merging aur manipulation functions.</div>
                </div>
                <a href="<?php echo getItemLink('array.php', $is_logged_in); ?>" class="item-btn <?php echo !$is_logged_in ? 'locked' : ''; ?>">
                    <?php echo $is_logged_in ? 'Open Program ➔' : '🔒 Login to View'; ?>
                </a>
            </div>

            <!-- Item 5: String Operations -->
            <div class="item-card rose">
                <div>
                    <div class="item-icon">🔤</div>
                    <div class="item-title">10.2 String Operations</div>
                    <div class="item-desc">PHP string reverse, length, case change aur search operations.</div>
                </div>
                <a href="<?php echo getItemLink('string.php', $is_logged_in); ?>" class="item-btn <?php echo !$is_logged_in ? 'locked' : ''; ?>">
                    <?php echo $is_logged_in ? 'Open Program ➔' : '🔒 Login to View'; ?>
                </a>
            </div>

            <!-- Item 6: Max and Min in Array -->
            <div class="item-card">
                <div>
                    <div class="item-icon">📈</div>
                    <div class="item-title">11.1 Maximum & Minimum</div>
                    <div class="item-desc">Array ya numbers list me se max aur min values dhoondhna.</div>
                </div>
                <a href="<?php echo getItemLink('max_min.php', $is_logged_in); ?>" class="item-btn <?php echo !$is_logged_in ? 'locked' : ''; ?>">
                    <?php echo $is_logged_in ? 'Open Program ➔' : '🔒 Login to View'; ?>
                </a>
            </div>

            <!-- Item 7: Date and Time -->
            <div class="item-card green">
                <div>
                    <div class="item-icon">⏰</div>
                    <div class="item-title">11.2 Date and Time</div>
                    <div class="item-desc">Current date, time aur timezone format karne ka script.</div>
                </div>
                <a href="<?php echo getItemLink('date_time.php', $is_logged_in); ?>" class="item-btn <?php echo !$is_logged_in ? 'locked' : ''; ?>">
                    <?php echo $is_logged_in ? 'Open Program ➔' : '🔒 Login to View'; ?>
                </a>
            </div>

            <!-- Item 8: User Profile -->
            <div class="item-card purple">
                <div>
                    <div class="item-icon">👤</div>
                    <div class="item-title">11.3 User Profile</div>
                    <div class="item-desc">User details display aur database profile view.</div>
                </div>
                <a href="<?php echo getItemLink('profile.php', $is_logged_in); ?>" class="item-btn <?php echo !$is_logged_in ? 'locked' : ''; ?>">
                    <?php echo $is_logged_in ? 'Open Program ➔' : '🔒 Login to View'; ?>
                </a>
            </div>

            <!-- Item 9: String Functions -->
            <div class="item-card orange">
                <div>
                    <div class="item-icon">💡</div>
                    <div class="item-title">11.4 String Functions</div>
                    <div class="item-desc">Built-in PHP string functions aur demo implementation.</div>
                </div>
                <a href="<?php echo getItemLink('string_function.php', $is_logged_in); ?>" class="item-btn <?php echo !$is_logged_in ? 'locked' : ''; ?>">
                    <?php echo $is_logged_in ? 'Open Program ➔' : '🔒 Login to View'; ?>
                </a>
            </div>

            <!-- Item 10: Job Application Form -->
            <div class="item-card rose">
                <div>
                    <div class="item-icon">📋</div>
                    <div class="item-title">Job Application Form</div>
                    <div class="item-desc">Full Application Form with Personal & Education details.</div>
                </div>
                <a href="<?php echo getItemLink('practical 3/form.php', $is_logged_in); ?>" class="item-btn <?php echo !$is_logged_in ? 'locked' : ''; ?>">
                    <?php echo $is_logged_in ? 'Open Form ➔' : '🔒 Login to View'; ?>
                </a>
            </div>

            <!-- Item 11: Calculator -->
            <div class="item-card">
                <div>
                    <div class="item-icon">🧮</div>
                    <div class="item-title">Practical 4: Calculator</div>
                    <div class="item-desc">Interactive calculator with arithmetic calculations.</div>
                </div>
                <a href="<?php echo getItemLink('practical 4/cal.php', $is_logged_in); ?>" class="item-btn <?php echo !$is_logged_in ? 'locked' : ''; ?>">
                    <?php echo $is_logged_in ? 'Open Calculator ➔' : '🔒 Login to View'; ?>
                </a>
            </div>

            <!-- Item 12: My Application Status -->
            <div class="item-card green">
                <div>
                    <div class="item-icon">📁</div>
                    <div class="item-title">My Application Status</div>
                    <div class="item-desc">Aapke dwara bhare gaye job application ki status aur details.</div>
                </div>
                <a href="<?php echo getItemLink('my_application.php', $is_logged_in); ?>" class="item-btn <?php echo !$is_logged_in ? 'locked' : ''; ?>">
                    <?php echo $is_logged_in ? 'View Application ➔' : '🔒 Login to View'; ?>
                </a>
            </div>

        </div>

    </div>

    <!-- ================= FOOTER ================= -->
    <footer class="footer">
        <p>&copy; 2026 Government MCA College, Maninagar. All Rights Reserved.</p>
    </footer>

</body>
</html>
