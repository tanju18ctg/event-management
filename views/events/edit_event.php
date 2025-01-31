<?php
include 'config.php';
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["id"])) {
    header("Location: event_list.php");
    exit();
}

$event_id = $_GET["id"];

// Fetch event details
$sql = "SELECT * FROM events WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

if (!$event) {
    echo "Event not found!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Event</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Event</h2>
        <form action="process_event.php" method="POST">
            <input type="hidden" name="id" value="<?= $event['id'] ?>">
            <div class="mb-3">
                <label>Event Name:</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($event['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Description:</label>
                <textarea name="description" class="form-control" required><?= htmlspecialchars($event['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label>Maximum Capacity:</label>
                <input type="number" name="max_capacity" class="form-control" value="<?= $event['max_capacity'] ?>" required min="1">
            </div>
            <div class="mb-3">
                <label>Event Date:</label>
                <input type="datetime-local" name="event_date" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($event['event_date'])) ?>" required>
            </div>
            <button type="submit" name="update_event" class="btn btn-primary">Update Event</button>
        </form>
    </div>
</body>
</html>
