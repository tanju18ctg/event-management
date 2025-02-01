<?php
include '../config/config.php';

$query = isset($_GET['query']) ? trim($_GET['query']) : "";

// Fetch events matching the search query
$sql = "SELECT * FROM events WHERE event_date >= NOW() AND (name LIKE ? OR description LIKE ?) ORDER BY event_date ASC";
$stmt = $conn->prepare($sql);
$search_param = "%$query%";
$stmt->bind_param("ss", $search_param, $search_param);
$stmt->execute();
$result = $stmt->get_result();

// Display filtered events
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
        <a href="attendee_list.php?event_id=<?= $row['id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-list"></i> View Attendees</a>
        <a href="download_attendees.php?event_id=<?= $row['id'] ?>" class="btn btn-secondary btn-sm"><i class="fas fa-file-csv"></i> Download CSV</a>
        </td>
    </tr>
<?php } ?>
