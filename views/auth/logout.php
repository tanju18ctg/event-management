<?php

session_start();
session_unset();  // Unset all session variables
session_destroy();  // Destroy the session

// Ensure no cache issues
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Redirect to login page
header("Location: login.php");
exit();
?>
