<?php
include 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Validate and fetch event details
if (!isset($_GET["event_id"]) || !is_numeric($_GET["event_id"])) {
    die("Error: Invalid Event ID.");
}

$event_id = (int)$_GET["event_id"]; // Ensure it's an integer

$sql = "SELECT id, name, max_capacity, (SELECT COUNT(*) FROM attendees WHERE event_id = events.id) AS current_attendees FROM events WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

if (!$event) {
    die("Error: Event not found.");
}

// Check if event is full
if ($event["current_attendees"] >= $event["max_capacity"]) {
    die("<div class='alert alert-danger text-center'>Registration is closed. The event is full!</div>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register for <?= htmlspecialchars($event["name"]) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div id="alertMessage"></div>

        <h2 class="text-center"><i class="fas fa-user-plus"></i> Register for <?= htmlspecialchars($event["name"]) ?></h2>
        <form id="registerForm">
            <input type="hidden" name="event_id" value="<?= $event_id ?>">
            <div class="mb-3">
                <label><i class="fas fa-user"></i> Your Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label><i class="fas fa-envelope"></i> Your Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-check-circle"></i> Register</button>
            <a href="event_list.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Event List</a>
        </form>
    </div>

    <script>
        $(document).ready(function(){
            $("#registerForm").submit(function(e){
                e.preventDefault();

                $.ajax({
                    url: "process_attendee.php",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        $("#alertMessage").html('<div class="alert alert-' + (response.status === "success" ? "success" : "danger") + ' text-center">' + response.message + '</div>');

                        if (response.status === "success") {
                            $("#registerForm")[0].reset();
                            setTimeout(function() {
                                $("#alertMessage").fadeOut();
                            }, 2000);
                        }
                    },
                    error: function() {
                        $("#alertMessage").html('<div class="alert alert-danger text-center">An error occurred. Please try again.</div>');
                    }
                });
            });
        });
    </script>
</body>
</html>
