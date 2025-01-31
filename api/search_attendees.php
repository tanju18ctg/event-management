<?php
include 'config.php';

header('Content-Type: text/html; charset=UTF-8');

if (!isset($_GET["event_id"]) || empty($_GET["event_id"])) {
    die("Error: Missing event_id");
}

$event_id = $_GET["event_id"];
$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$params = [];
$types = "i";
$search_sql = "";

// If search query exists, add WHERE condition
if (!empty($search)) {
    $search_sql = "AND (name LIKE ? OR email LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= "ss";
}

// Prepare SQL query
$sql = "SELECT name, email, registered_at FROM attendees WHERE event_id = ? $search_sql";
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, $event_id, ...$params);
} else {
    $stmt->bind_param("i", $event_id);
}

$stmt->execute();
$result = $stmt->get_result();

// Debugging - Log Errors if SQL Fails
if (!$result) {
    die("<tr><td colspan='3' class='text-center text-danger'>SQL Error: " . $stmt->error . "</td></tr>");
}

// Output results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['registered_at']) . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='3' class='text-center text-muted'>No attendees found.</td></tr>";
}
?>
