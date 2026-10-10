<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$is_logged_in = isset($_SESSION['user_id']);
?>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    html {
        scroll-behavior: smooth;
    }
    body {
        font-family: Arial, Helvetica, sans-serif;
        background: #f4f6f8;
        color: #222;
        line-height: 1.6;
    }

    /* ================= HEADER ================= */
    .site-header {
        height: 115px;
        color: white;
        background: orange;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px 30px;
    }

    .profile-links {
        display: flex;
        gap: 18px;
    }

    .profile {
        color: white;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: bold;
    }

    .profile img {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        border: 2px solid white;
        object-fit: cover;
        margin-bottom: 5px;
    }

    .header-title {
        flex: 1;
        text-align: center;
    }

    .header-title h1 {
        font-size: 32px;
        margin-bottom: 5px;
    }

    .header-title p {
        font-size: 15px;
    }

    /* ================= NAVIGATION ================= */
    .main-nav {
        height: 42px;
        background: #38bdf8;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 18px;
        position: relative;
        z-index: 1000;
    }

    .main-nav a {
        color: #003b70;
        text-decoration: none;
        font-size: 15px;
        font-weight: 600;
        padding: 8px 12px;
        display: block;
    }

    .main-nav a:hover {
        color: black;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 4px;
    }

    /* ================= DROPDOWN ================= */
    .dropdown {
        position: relative;
    }

    .dropdown-content {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 170px;
        background: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        display: none;
        z-index: 1000;
        border-radius: 4px;
    }

    .dropdown-content a {
        display: block;
        padding: 10px 15px;
        color: #333;
    }

    .dropdown-content a:hover {
        background: #e8f5fb;
        color: #0284c7;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>

<!-- ================= HEADER ================= -->
<header class="site-header">
    <div class="header-title">
        <h1>Government MCA College, Maninagar</h1>
        <p>Web Practical & Project Portal</p>
    </div>
</header>

<!-- ================= NAVIGATION ================= -->
<nav class="main-nav">
    <a href="../index.php">🏠 Home</a>

    <div class="dropdown">
        <a href="#">About Us ▾</a>
        <div class="dropdown-content">
            <a href="../practical 2/index.php">Group 22 Home</a>
            <a href="../practical 2/profile1.php">26GMCA39 (Kashyap)</a>
            <a href="../practical 2/profile2.php">26GMCA56 (Mahesh)</a>
            <a href="../practical 2/profile3.php">26GMCA72 (Varun)</a>
        </div>
    </div>

    <a href="../practical 3/form.php">Application Form</a>
    <a href="../practical 4/cal.php">Calculator</a>
    <a href="../profile.php">My Profile</a>
    <a href="../Webpage.php">Webpage</a>

    <div class="dropdown">
        <a href="#">Practicals ▾</a>
        <div class="dropdown-content">
            <a href="../max.php">9.1 Maximum of 3</a>
            <a href="../numbers.php">9.2 Print 1 to N</a>
            <a href="../pyramid.php">9.3 Pyramid Patterns</a>
            <a href="../array.php">10.1 Array Operations</a>
            <a href="../string.php">10.2 String Operations</a>
            <a href="../max_min.php">11.1 Max & Min</a>
            <a href="../date_time.php">11.2 Date & Time</a>
            <a href="../string_function.php">11.4 String Functions</a>
        </div>
    </div>

    <?php if ($is_logged_in): ?>
        <a href="../logout.php" style="color: #b91c1c;">Logout</a>
    <?php else: ?>
        <a href="../login.php">Login</a>
        <a href="../register.php">Register</a>
    <?php endif; ?>
</nav>
