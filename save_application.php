<?php
session_start();
require_once "db.php";
require_once "auth_check.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?msg=auth_required");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName       = trim($_POST['fullName'] ?? '');
    $dob            = trim($_POST['dob'] ?? '');
    $gender         = trim($_POST['gender'] ?? '');
    $email          = trim($_POST['email'] ?? '');
    $mobile         = trim($_POST['mobile'] ?? '');
    $city           = trim($_POST['city'] ?? '');
    $address        = trim($_POST['address'] ?? '');
    $qualification  = trim($_POST['qualification'] ?? '');
    $passingYear    = (int)($_POST['passingYear'] ?? 0);
    $college        = trim($_POST['college'] ?? '');
    $percentage     = trim($_POST['percentage'] ?? '');
    $position       = trim($_POST['position'] ?? '');
    $experience     = (int)($_POST['experience'] ?? 0);
    $expectedSalary = trim($_POST['expectedSalary'] ?? '');

    $skills = "";
    if (isset($_POST['skills']) && is_array($_POST['skills'])) {
        $skills = implode(", ", $_POST['skills']);
    }

    $coverLetter = trim($_POST['coverLetter'] ?? '');

    // Check if we're editing an existing application
    $edit_id = isset($_POST['edit_id']) ? (int)$_POST['edit_id'] : 0;

    if ($edit_id > 0) {
        // Update existing application
        $update_sql = "UPDATE applications SET 
            fullName = ?, dob = ?, gender = ?, email = ?, mobile = ?, city = ?, address = ?,
            qualification = ?, passingYear = ?, college = ?, percentage = ?, position = ?,
            experience = ?, expectedSalary = ?, skills = ?, coverLetter = ?
            WHERE id = ? AND user_id = ?";
        
        $stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param(
            $stmt,
            "ssssssssisssisssii",
            $fullName, $dob, $gender, $email, $mobile, $city, $address,
            $qualification, $passingYear, $college, $percentage, $position,
            $experience, $expectedSalary, $skills, $coverLetter,
            $edit_id, $user_id
        );
    } else {
        // Insert new application (user can apply multiple times)
        $insert_sql = "INSERT INTO applications 
            (user_id, fullName, dob, gender, email, mobile, city, address, qualification, passingYear, college, percentage, position, experience, expectedSalary, skills, coverLetter)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param(
            $stmt,
            "issssssssisssisss",
            $user_id, $fullName, $dob, $gender, $email, $mobile, $city, $address,
            $qualification, $passingYear, $college, $percentage, $position,
            $experience, $expectedSalary, $skills, $coverLetter
        );
    }

    if (mysqli_stmt_execute($stmt)) {
        $msg = $edit_id > 0 ? 'Application Updated Successfully!' : 'Application Submitted Successfully!';
        echo "<script>
                alert('$msg');
                window.location.href = 'my_application.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Error: " . addslashes(mysqli_error($conn)) . "');
                window.history.back();
              </script>";
        exit;
    }
} else {
    header("Location: practical 3/form.php");
    exit;
}
?>