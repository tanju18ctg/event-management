<?php
session_start();

// If user is on login.php or register.php, don't force redirect to dashboard
$current_page = basename($_SERVER['PHP_SELF']);

if (!isset($_SESSION["user_id"]) && !in_array($current_page, ["login.php", "register.php"])) {
    header("Location: login.php");
    exit();
}

// If user is already logged in and tries to access login.php, send them to dashboard
if (isset($_SESSION["user_id"]) && $current_page == "login.php") {
    header("Location: ../../dashboard.php");
    exit();
}
?>
