<?php
include '../../config/config.php';
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

// Pagination settings
$limit = 5; // Number of events per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Sorting
$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'event_date';
$sort_order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'DESC' : 'ASC';

// Search functionality
$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$search_sql = $search ? "WHERE name LIKE '%$search%'" : "";

// Fetch paginated and sorted events
$sql = "SELECT * FROM events $search_sql ORDER BY $sort_column $sort_order LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Get total records for pagination
$total_events_sql = "SELECT COUNT(*) as count FROM events $search_sql";
$total_events_result = $conn->query($total_events_sql);
$total_events = $total_events_result->fetch_assoc()['count'];
$total_pages = ceil($total_events / $limit);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Event List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        .sortable {
            cursor: pointer;
        }
        .search-box {
            max-width: 400px;
        }
        .pagination {
            margin-top: 20px;
        }
        .full-width-header {
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: white;
            padding: 10px 20px;
            z-index: 1000;
        }
        .main-content {
            margin-top: 60px;
            max-width: 90%;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .main-content {
                max-width: 100%;
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    <!-- Full-Width Header -->
    <div class="full-width-header">
        <?php include '../../includes/navbar.php'; ?>
    </div>

    <div class="container mt-4">
        <div class="container-box">
            <!-- Back to Dashboard Button -->
            <a href="../../dashboard.php" class="btn btn-dark mb-3"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>

            <h2 class="text-center"><i class="fas fa-list"></i> Event List</h2>

            <!-- Search Bar & Create Event Button -->
            <div class="d-flex justify-content-between mb-3">
                <!-- Search Bar -->
                <div class="search-box w-100 me-2">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search events...">
                </div>

                <!-- Create Event Button -->
                <a href="create_event.php" class="btn btn-success"><i class="fas fa-plus"></i> Create Event</a>
            </div>

            <!-- Event List Table -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><a href="?sort=name&order=<?= $sort_order === 'ASC' ? 'desc' : 'asc' ?>" class="sortable">Name <i class="fas fa-sort"></i></a></th>
                            <th>Description</th>
                            <th><a href="?sort=max_capacity&order=<?= $sort_order === 'ASC' ? 'desc' : 'asc' ?>" class="sortable">Capacity <i class="fas fa-sort"></i></a></th>
                            <th><a href="?sort=event_date&order=<?= $sort_order === 'ASC' ? 'desc' : 'asc' ?>" class="sortable">Event Date <i class="fas fa-sort"></i></a></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="eventTableBody">
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['description']) ?></td>
                                <td><?= $row['max_capacity'] ?></td>
                                <td><?= date('Y-m-d H:i', strtotime($row['event_date'])) ?></td>
                                <td>
                                    <a href="edit_event.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> </a>
                                    <a href="delete_event.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> </a>
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
                            <a class="page-link" href="?page=<?= $i ?>&sort=<?= $sort_column ?>&order=<?= $sort_order ?>"><?= $i ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </div>

<script>
$(document).ready(function() {
    $("#searchInput").on("keyup", function() {
        let searchText = $(this).val();
        $.ajax({
            url: "../../api/search_events.php",
            method: "GET",
            data: { query: searchText },
            success: function(response) {
                $("#eventTableBody").html(response);
            }
        });
    });
});
</script>

</body>

</html>
