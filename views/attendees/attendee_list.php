<?php
include 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Get event details
if (!isset($_GET["event_id"])) {
    header("Location: event_list.php");
    exit();
}

$event_id = (int)$_GET["event_id"]; // Ensure it's an integer

// Fetch event details
$sql = "SELECT name FROM events WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

if (!$event) {
    die("Event not found!");
}

// Pagination settings
$limit = 10; // Number of attendees per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch attendees with pagination
$sql = "SELECT name, email, registered_at FROM attendees WHERE event_id = ? LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $event_id, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Get total attendees count for pagination
$total_sql = "SELECT COUNT(*) as count FROM attendees WHERE event_id = ?";
$total_stmt = $conn->prepare($total_sql);
$total_stmt->bind_param("i", $event_id);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_attendees = $total_result->fetch_assoc()['count'];
$total_pages = ceil($total_attendees / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Attendee List for <?= htmlspecialchars($event["name"]) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background-color: #f4f4f4;
        }
        .container-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .table thead {
            background-color: #343a40;
            color: white;
        }
        .pagination {
            margin-top: 20px;
        }
        .btn-back {
            background-color: #6c757d;
            border: none;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="container-box">
        <h2 class="text-center"><i class="fas fa-users"></i> Attendee List for <b><?= htmlspecialchars($event["name"]) ?></b></h2>

        <!-- Back to Events Button -->
        <a href="event_list.php" class="btn btn-primary mb-3"><i class="fas fa-arrow-left"></i> Back to Events</a>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><i class="fas fa-user"></i> Name</th>
                        <th><i class="fas fa-envelope"></i> Email</th>
                        <th><i class="fas fa-clock"></i> Registered At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= $row['registered_at'] ?></td>
                            </tr>
                        <?php } ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted">No attendees found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?event_id=<?= $event_id ?>&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>

    </div>
</div>

</body>
</html>
