<?php
session_start();
require_once "auth_check.php";
// Redirect user to form.php to update their application
header("Location: practical 3/form.php");
exit();
?>
