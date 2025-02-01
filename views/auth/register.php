<?php
include '../../config/config.php';
include '../../config/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* Background Styling */
        body {
            background: url('../../assets/images/login2.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
        }

        /* Centered Register Form */
        .register-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .form-control {
            border-radius: 5px;
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

        .text-muted {
            font-size: 14px;
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .register-container {
                width: 90%;
            }
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="register-container">
        <h2 class="text-center"><i class="fas fa-user-plus"></i> User Registration</h2>

        <!-- Flash Messages -->
        <?php if (isset($_GET["error"])): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($_GET["error"]) ?></div>
        <?php endif; ?>
        <?php if (isset($_GET["success"])): ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($_GET["success"]) ?></div>
        <?php endif; ?>

        <form action="../../controllers/process_register.php" method="POST" onsubmit="return validateForm()">
            <div class="mb-3">
                <label><i class="fas fa-user"></i> Username:</label>
                <input type="text" name="username" id="username" class="form-control" >
                <small class="text-danger" id="usernameError"></small>
            </div>

            <div class="mb-3">
                <label><i class="fas fa-envelope"></i> Email:</label>
                <input type="email" name="email" id="email" class="form-control" >
                <small class="text-danger" id="emailError"></small>
            </div>

            <div class="mb-3">
                <label><i class="fas fa-lock"></i> Password:</label>
                <input type="password" id="password" name="password" class="form-control" ">
                <small class="text-danger" id="passwordError"></small>
            </div>

            <div class="mb-3">
                <label><i class="fas fa-lock"></i> Confirm Password:</label>
                <input type="password" id="password_confirm" name="password_confirm" class="form-control" >
                <small class="text-danger" id="passwordConfirmError"></small>
            </div>

            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-user-check"></i> Register</button>
        </form>

        <p class="mt-3 text-center text-muted">Already have an account? <a href="login.php">Login here</a></p>
    </div>

    <script>
        function validateForm() {
            let username = document.getElementById("username").value.trim();
            let email = document.getElementById("email").value.trim();
            let password = document.getElementById("password").value;
            let confirmPassword = document.getElementById("password_confirm").value;

            let isValid = true;

            // Username Validation
            if (username === "") {
                document.getElementById("usernameError").innerText = "Username is required.";
                isValid = false;
            } else {
                document.getElementById("usernameError").innerText = "";
            }

            // Email Validation
            if (email === "") {
                document.getElementById("emailError").innerText = "Email is required.";
                isValid = false;
            } else {
                document.getElementById("emailError").innerText = "";
            }

            // Password Validation
            if (password.length < 6) {
                document.getElementById("passwordError").innerText = "Password must be at least 6 characters.";
                isValid = false;
            } else {
                document.getElementById("passwordError").innerText = "";
            }

            // Confirm Password Validation
            if (password !== confirmPassword) {
                document.getElementById("passwordConfirmError").innerText = "Passwords do not match!";
                isValid = false;
            } else {
                document.getElementById("passwordConfirmError").innerText = "";
            }

            return isValid; // Prevent form submission if validation fails
        }
    </script>


</body>

</html>