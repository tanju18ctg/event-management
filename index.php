<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome to Event Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        /* Background Animation */
        body {
            background: linear-gradient(-45deg, #6a11cb, #2575fc, #ff416c, #ff4b2b);
            background-size: 400% 400%;
            animation: gradientBG 8s ease infinite;
            height: 100vh;
            font-family: 'Arial', sans-serif;
            color: white;
            text-align: center;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Centered Content */
        .welcome-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 600px;
            width: 90%;
            padding: 30px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translate(-50%, -55%); }
            to { opacity: 1; transform: translate(-50%, -50%); }
        }

        /* Heading Styling */
        .welcome-container h1 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .welcome-container p {
            font-size: 18px;
            margin-bottom: 20px;
            color: #f8f9fa;
        }

        /* Button Styling */
        .btn-custom {
            display: block;
            width: 100%;
            font-size: 18px;
            padding: 10px;
            border-radius: 25px;
            margin-bottom: 10px;
            transition: all 0.3s ease-in-out;
        }

        .btn-login {
            background: #28a745;
            color: white;
        }

        .btn-login:hover {
            background: #218838;
        }

        .btn-register {
            background: #ffc107;
            color: black;
        }

        .btn-register:hover {
            background: #e0a800;
        }

        /* Divider Line */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 2px solid white;
        }

        .divider span {
            padding: 0 10px;
            font-weight: bold;
            font-size: 16px;
        }

        /* Mobile Optimization */
        @media (max-width: 768px) {
            .welcome-container {
                width: 90%;
                padding: 20px;
            }
            .welcome-container h1 {
                font-size: 28px;
            }
            .welcome-container p {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

    <div class="welcome-container">
        <h1><i class="fas fa-calendar-alt"></i> Event Management</h1>
        <p>Manage your events efficiently with our smart event management system.</p>
        
        <a href="views/auth/login.php" class="btn btn-custom btn-login"><i class="fas fa-sign-in-alt"></i> Login</a>
        
        <div class="divider"><span>or</span></div>

        <a href="views/auth/register.php" class="btn btn-custom btn-register"><i class="fas fa-user-plus"></i> Sign Up</a>
    </div>

</body>
</html>
