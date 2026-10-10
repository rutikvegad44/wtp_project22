<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper function to check login status
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to enforce authentication on protected pages
function requireLogin() {
    if (!isLoggedIn()) {
        $current_page = $_SERVER['REQUEST_URI'];
        header("Location: login.php?msg=auth_required&redirect=" . urlencode($current_page));
        exit;
    }
}

// If this file is included directly on a protected page, check automatically:
if (!isset($_SESSION['user_id']) && basename($_SERVER['PHP_SELF']) !== 'index.php' && basename($_SERVER['PHP_SELF']) !== 'login.php' && basename($_SERVER['PHP_SELF']) !== 'register.php') {
    $current_page = $_SERVER['REQUEST_URI'];
    header("Location: login.php?msg=auth_required&redirect=" . urlencode($current_page));
    exit;
}
?>