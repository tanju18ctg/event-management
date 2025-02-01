<?php
include '../config/config.php';
session_start();
header('Content-Type: application/json'); // Ensure correct response type

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized Access!"]);
    exit();
}

// Only allow POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST")
{
    echo json_encode(["status" => "error", "message" => "Access Denied!"]);
    exit();
}

$event_id = $_POST["event_id"];
$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$user_id = $_SESSION["user_id"];

// Validate input
if (empty($name) || empty($email)) {
    echo json_encode(["status" => "error", "message" => "Name and Email are required."]);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status" => "error", "message" => "Invalid email format."]);
    exit();
}

// Check event capacity before registering
$sql = "SELECT max_capacity, (SELECT COUNT(*) FROM attendees WHERE event_id = events.id) AS current_attendees FROM events WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

if (!$event) {
    echo json_encode(["status" => "error", "message" => "Event not found."]);
    exit();
}

if ($event["current_attendees"] >= $event["max_capacity"]) {
    echo json_encode(["status" => "error", "message" => "Registration failed: Event is already full!"]);
    exit();
}

// Register attendee
$sql = "INSERT INTO attendees (event_id, user_id, name, email) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $event_id, $user_id, $name, $email);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Registration successful!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
}
exit();
?>
