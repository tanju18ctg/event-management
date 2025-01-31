<?php
include '../config/config.php';
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../views/auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Access Denied!");
}

// Handle Create Event
if (isset($_POST["create_event"])) {
    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);
    $max_capacity = (int)$_POST["max_capacity"];
    $event_date = $_POST["event_date"];
    $user_id = $_SESSION["user_id"];

    $sql = "INSERT INTO events (user_id, name, description, max_capacity, event_date) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issis", $user_id, $name, $description, $max_capacity, $event_date);

    if ($stmt->execute()) {
        header("Location: ../views/events/event_list.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle Update Event
if (isset($_POST["update_event"])) {
    $id = $_POST["id"];
    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);
    $max_capacity = (int)$_POST["max_capacity"];
    $event_date = $_POST["event_date"];

    $sql = "UPDATE events SET name=?, description=?, max_capacity=?, event_date=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $name, $description, $max_capacity, $event_date, $id);

    if ($stmt->execute()) {
        header("Location: ../views/events/event_list.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
