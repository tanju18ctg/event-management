<?php
include 'config/config.php';
include 'config/session.php';

// Pagination settings
$limit = 5; // Events per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search functionality
$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$search_sql = $search ? "AND (name LIKE '%$search%' OR description LIKE '%$search%')" : "";

// Fetch total events & attendees
$total_events_sql = "SELECT COUNT(*) as count FROM events";
$total_events_result = $conn->query($total_events_sql);
$total_events = $total_events_result ? $total_events_result->fetch_assoc()['count'] : 0;

$total_attendees_sql = "SELECT COUNT(*) as count FROM attendees";
$total_attendees_result = $conn->query($total_attendees_sql);
$total_attendees = $total_attendees_result ? $total_attendees_result->fetch_assoc()['count'] : 0;

// Fetch upcoming events with search & pagination
$upcoming_events_sql = "SELECT * FROM events WHERE event_date >= NOW() $search_sql ORDER BY event_date ASC LIMIT $limit OFFSET $offset";
$upcoming_events_result = $conn->query($upcoming_events_sql);

// Get total event count for pagination
$total_events_query = "SELECT COUNT(*) as count FROM events WHERE event_date >= NOW() $search_sql";
$total_events_count = $conn->query($total_events_query)->fetch_assoc()['count'];
$total_pages = ceil($total_events_count / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f4f4f4;
        }
        /* Sidebar Styling */
        .sidebar {
            width: 180px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }
        .sidebar a {
            display: flex;
            align-items: center;
            color: white;
            padding: 10px 12px;
            text-decoration: none;
            font-size: 16px;
        }
        .sidebar a i {
            margin-right: 8px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        /* Header & Main Content */
        .main-content {
            margin-left: 200px;
            padding: 20px;
        }
        .dashboard-card {
            border-radius: 10px;
            padding: 10px;
            text-align: center;
        }
        .event-table th {
            background-color: #343a40;
            color: white;
        }
        .pagination {
            margin-top: 20px;
        }
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-center"><i class="fas fa-calendar-alt"></i> Event</h4>
    <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="views/events/create_event.php"><i class="fas fa-plus"></i> Create Event</a>
    <a href="views/events/event_list.php"><i class="fas fa-calendar"></i> Manage Events</a>
    <a href="views/auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <?php include 'includes/navbar.php'; ?> <!-- Including Navbar -->

    <h2 class="text-center" style="margin-top:30px">Dashboard</h2>

    <!-- Dashboard Statistics -->
    <div class="row text-center mt-2">
        <div class="col-md-4">
            <div class="card bg-primary text-white dashboard-card">
                <h4><i class="fas fa-calendar-alt"></i> Total Events</h4>
                <h2><?= $total_events ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white dashboard-card">
                <h4><i class="fas fa-users"></i> Total Attendees</h4>
                <h2><?= $total_attendees ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark dashboard-card">
                <h4><i class="fas fa-bell"></i> Upcoming Events</h4>
                <h2><?= $total_events_count ?></h2>
            </div>
        </div>
    </div>

    <!-- Upcoming Events Table -->
    <h3 class="mt-3">Upcoming Events</h3>

    <!-- Search Bar -->
    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search upcoming events..." onkeyup="searchEvents()">

    <div class="table-responsive">
        <table class="table table-bordered event-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Capacity</th>
                    <th>Event Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="eventTableBody">
                <?php while ($row = $upcoming_events_result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= $row['max_capacity'] ?></td>
                    <td><?= date('Y-m-d H:i', strtotime($row['event_date'])) ?></td>
                    <td>
                        <a href="register_attendee.php?event_id=<?= $row['id'] ?>" class="btn btn-success btn-sm"><i class="fas fa-user-plus"></i> Register</a>
                        <a href="../attendees/attendee_list.php?event_id=<?= $row['id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-list"></i> View Attendees</a>
                        <a href="../attendees/download_attendees.php?event_id=<?= $row['id'] ?>" class="btn btn-secondary btn-sm"><i class="fas fa-file-csv"></i> Download CSV</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>

<script>
function searchEvents() {
    let query = document.getElementById('searchInput').value;
    $.get('api/search_events.php', {query: query}, function(data) {
        document.getElementById('eventTableBody').innerHTML = data;
    });
}
</script>

</body>
</html>
