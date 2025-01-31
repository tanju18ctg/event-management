<?php

include '../../config/config.php';
include '../../config/session.php';
session_start();
?>
<?php  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: url('https://source.unsplash.com/1600x900/?business,technology') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        .alert {
            transition: opacity 0.5s ease-in-out;
        }
        .btn-primary {
            background: #007bff;
            border: none;
            padding: 10px;
            font-size: 16px;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        @media (max-width: 768px) {
            .login-container {
                width: 90%;
            }
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="login-container">
        <h2 class="text-center"><i class="fas fa-user-circle"></i> User Login</h2>

        <!-- Flash Messages -->
        <?php if (isset($_SESSION["success"])): ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($_SESSION["success"]) ?></div>
            <?php unset($_SESSION["success"]); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION["error"])): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($_SESSION["error"]) ?></div>
            <?php unset($_SESSION["error"]); ?>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="../../controllers/process_login.php" method="POST">
            <div class="mb-3">
                <label><i class="fas fa-envelope"></i> Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label><i class="fas fa-lock"></i> Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-sign-in-alt"></i> Login</button>
        </form>

        <p class="mt-3 text-center text-muted">Don't have an account? <a href="register.php">Register here</a></p>
    </div>

    <script>
        // Auto-hide flash message after 5 seconds
        setTimeout(() => {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);
    </script>

</body>
</html>
