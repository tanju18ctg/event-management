<?php 
include '../config/session.php'; 

// Get current page name
$current_page = basename($_SERVER['PHP_SELF']);

// Adjust margin based on the page
$margin_left = ($current_page == "dashboard.php") ? "180px" : "0px";
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" style="margin-left: <?= $margin_left ?>; width: calc(100% - <?= $margin_left ?>);">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="dashboard.php">📊 Event Management</a>

        <!-- Right side of navbar -->
        <div class="d-flex align-items-center ms-auto">
            <span class="navbar-text text-white me-3">
                <i class="fas fa-user-circle"></i> <?= htmlspecialchars($_SESSION["username"]); ?>
            </span>
            <a href="views/auth/logout.php" class="btn btn-outline-light btn-sm">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>  
</nav>
