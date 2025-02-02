<?php
include '../config/config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    echo "<tr><td colspan='5'>Unauthorized access</td></tr>";
    exit();
}

$user_id = $_SESSION["user_id"];
$user_role = $_SESSION["role"]; // Assuming 'role' is stored in session

$query = isset($_GET['query']) ? trim($_GET['query']) : "";

// Base query with search condition
$search_sql = "(name LIKE ? OR description LIKE ?) AND event_date >= NOW()";

if ($user_role === 'admin') {
    // Admin sees all events
    $sql = "SELECT * FROM events WHERE $search_sql ORDER BY event_date ASC";
    $stmt = $conn->prepare($sql);
    $search_param = "%$query%";
    $stmt->bind_param("ss", $search_param, $search_param);
} else {
    // Regular user sees only their own events
    $sql = "SELECT * FROM events WHERE user_id = ? AND $search_sql ORDER BY event_date ASC";
    $stmt = $conn->prepare($sql);
    $search_param = "%$query%";
    $stmt->bind_param("iss", $user_id, $search_param, $search_param);
}

$stmt->execute();
$result = $stmt->get_result();

// Display filtered events
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= $row['max_capacity'] ?></td>
            <td><?= date('Y-m-d H:i', strtotime($row['event_date'])) ?></td>
            <td>
                <a href="edit_event.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                <a href="delete_event.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> Delete</a>
                <a href="register_attendee.php?event_id=<?= $row['id'] ?>" class="btn btn-success btn-sm"><i class="fas fa-user-plus"></i> Register</a>
                <a href="../attendees/attendee_list.php?event_id=<?= $row['id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-list"></i> View Attendees</a>
                <a href="../attendees/download_attendees.php?event_id=<?= $row['id'] ?>" class="btn btn-secondary btn-sm"><i class="fas fa-file-csv"></i> Download CSV</a>
            </td>
        </tr>
    <?php }
} else {
    echo "<tr><td colspan='5' class='text-center'>No matching events found</td></tr>";
}
?>
