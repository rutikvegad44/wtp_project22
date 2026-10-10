<?php
// Database Configuration
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "php_practical";

// Step 1: Connect to MySQL Server
$conn = mysqli_connect($servername, $username, $password);

if (!$conn) {
    die("Database Connection Error: " . mysqli_connect_error());
}

// Step 2: Create Database if not exists
$create_db_sql = "CREATE DATABASE IF NOT EXISTS `$dbname` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
mysqli_query($conn, $create_db_sql);

// Step 3: Select the Database
mysqli_select_db($conn, $dbname);

// Step 4: Create 'users' table if it doesn't exist
$create_users_table = "CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `full_name` VARCHAR(100) NOT NULL,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `mobile` VARCHAR(15) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB";
mysqli_query($conn, $create_users_table);

// Step 4b: Check and auto-add missing columns in 'users' if table was created previously
$cols_result = mysqli_query($conn, "SHOW COLUMNS FROM `users`");
$existing_cols = [];
if ($cols_result) {
    while ($col = mysqli_fetch_assoc($cols_result)) {
        $existing_cols[] = $col['Field'];
    }
}

if (!in_array('full_name', $existing_cols)) {
    mysqli_query($conn, "ALTER TABLE `users` ADD `full_name` VARCHAR(100) NOT NULL DEFAULT '' AFTER `id`");
}
if (!in_array('mobile', $existing_cols)) {
    mysqli_query($conn, "ALTER TABLE `users` ADD `mobile` VARCHAR(15) NOT NULL DEFAULT '' AFTER `email`");
}
if (!in_array('created_at', $existing_cols)) {
    mysqli_query($conn, "ALTER TABLE `users` ADD `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
}

// Step 5: Create 'applications' table for form.php & my_application.php
$create_applications_table = "CREATE TABLE IF NOT EXISTS `applications` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `fullName` VARCHAR(100) NOT NULL,
    `dob` VARCHAR(30),
    `gender` VARCHAR(20),
    `email` VARCHAR(100) NOT NULL,
    `mobile` VARCHAR(20) NOT NULL,
    `city` VARCHAR(50),
    `address` TEXT,
    `qualification` VARCHAR(50),
    `passingYear` VARCHAR(10),
    `college` VARCHAR(150),
    `percentage` VARCHAR(20),
    `position` VARCHAR(100),
    `experience` VARCHAR(50),
    `expectedSalary` VARCHAR(50),
    `skills` TEXT,
    `coverLetter` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB";
mysqli_query($conn, $create_applications_table);

// Step 6: Create 'profile' table for practical 7
$create_profile_table = "CREATE TABLE IF NOT EXISTS `profile` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `name` VARCHAR(100),
    `email` VARCHAR(100),
    `age` INT,
    `city` VARCHAR(50)
) ENGINE=InnoDB";
mysqli_query($conn, $create_profile_table);
?>
