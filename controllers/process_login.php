<?php
include '../config/config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Access Denied!");
}

$email = trim($_POST["email"]);
$password = $_POST["password"];

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: login.php?error=Invalid email format!");
    exit();
}

// Fetch user details securely
$sql = "SELECT id, username, password FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $username, $hashed_password);
    $stmt->fetch();

    // Verify password
    if (password_verify($password, $hashed_password)) {
        // Ensure session starts
        session_regenerate_id(true); // Prevent session fixation attack

        $_SESSION["user_id"] = $id;
        $_SESSION["username"] = $username;

        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: ../views/auth/login.php?error=Invalid email or password!");
        exit();
    }
} else {
    header("Location: ../views/auth/login.php?error=User not found!");
    exit();
}
?>
