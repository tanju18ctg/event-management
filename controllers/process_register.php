<?php


session_start();
include '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $password_confirm = trim($_POST["password_confirm"]);

    // Check if passwords match
    if ($password !== $password_confirm) {
        $_SESSION["error"] = "Passwords do not match.";
        header("Location: ../views/auth/register.php");
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    
    if ($stmt->execute()) {
        $_SESSION["success"] = "Account created successfully! Please log in.";
        header("Location: ../views/auth/login.php");
        exit();
    } else {
        $_SESSION["error"] = "Registration failed. Try again.";
        header("Location: ../views/auth/register.php");
        exit();
    }
}
?>
