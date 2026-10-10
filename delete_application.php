<?php
session_start();
require_once "db.php";
require_once "auth_check.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?msg=auth_required");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = mysqli_prepare($conn, "DELETE FROM applications WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>
            alert('Application Safaltapoorvak Delete Ho Gayi Hai.');
            window.location.href = 'my_application.php';
          </script>";
} else {
    echo "<script>
            alert('Delete karne me samasya aayi: " . addslashes(mysqli_error($conn)) . "');
            window.location.href = 'my_application.php';
          </script>";
}
exit();
?>
