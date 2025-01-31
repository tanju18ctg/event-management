<?php
$host = "localhost";
$username = "root";  // Change if using another DB user
$password = "";  // Change if using a DB password
$database = "event_management";  // Your DB name

$conn = new mysqli($host, $username, $password, $database);

// Check connection securely
if ($conn->connect_error) {
    die("Database connection failed.");
}

// Security: Disable error reporting in production
error_reporting(0);
ini_set('display_errors', 0);
?>
