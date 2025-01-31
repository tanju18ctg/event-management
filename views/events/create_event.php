<?php
include '../../config/config.php';
include '../../config/session.php';
if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Event</title>
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
            width: 140px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
            transition: left 0.3s ease-in-out;
            z-index: 1000;
        }
        .sidebar a {
            display: flex;
            align-items: center;
            color: white;
            padding: 10px 12px;
            text-decoration: none;
            font-size: 14px;
            white-space: nowrap;
        }
        .sidebar a i {
            margin-right: 8px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .sidebar h4 {
            text-align: center;
            font-size: 16px;
            margin-bottom: 15px;
        }
        .main-content {
            flex-grow: 1;
            margin-left: 140px;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
        }
        /* Create Event Form Box */
        .container-box {
            max-width: 700px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px;
            font-size: 16px;
        }
        .btn-create {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            border-radius: 8px;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .sidebar {
                left: -140px;
                width: 180px;
            }
            .sidebar.open {
                left: 0;
            }
            .main-content {
                margin-left: 0;
            }
            .container-box {
                width: 100%;
                padding: 20px;
                margin-top: 30px;
            }
        }
    </style>
</head>
<body>



<div class="main-content">
    <div class="container-box">
        <h2><i class="fas fa-calendar-plus"></i> Create New Event</h2>
        <form action="../../controllers/process_event.php" method="POST">
            <div class="mb-3">
                <label for="name"><i class="fas fa-edit"></i> Event Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter event name" required>
            </div>

            <div class="mb-3">
                <label for="description"><i class="fas fa-align-left"></i> Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter event description" required></textarea>
            </div>

            <div class="mb-3">
                <label for="max_capacity"><i class="fas fa-users"></i> Maximum Capacity</label>
                <input type="number" class="form-control" id="max_capacity" name="max_capacity" placeholder="Enter max attendees" required min="1">
            </div>

            <div class="mb-3">
                <label for="event_date"><i class="fas fa-calendar-alt"></i> Event Date</label>
                <input type="datetime-local" class="form-control" id="event_date" name="event_date" required>
            </div>

            <button type="submit" class="btn btn-success btn-create" name="create_event"><i class="fas fa-plus"></i> Create Event</button>
        </form>

        <a href="../../dashboard.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </div>
</div>

</body>
</html>
