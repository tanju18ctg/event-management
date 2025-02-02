<?php
include '../../config/config.php';
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Check if event_id is provided
if (!isset($_GET["event_id"])) {
    die("Invalid request!");
}

$event_id = $_GET["event_id"];

// Fetch event name
$sql = "SELECT name FROM events WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

if (!$event) {
    die("Event not found!");
}

// Fetch attendees
$sql = "SELECT name, email, registered_at FROM attendees WHERE event_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

// Set CSV headers
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="attendees_' . $event_id . '.csv"');

// Open output stream
$output = fopen("php://output", "w");

// Write CSV column headers
fputcsv($output, ["Name", "Email", "Registered At"]);

// Write attendee data to CSV
while ($row = $result->fetch_assoc()) {
    fputcsv($output, [$row["name"], $row["email"], $row["registered_at"]]);
}

// Close file
fclose($output);
exit();
?>
