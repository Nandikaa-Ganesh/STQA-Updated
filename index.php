<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booking System</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
        /* Button hover styles */
        .button {
            font-family:Inter;
            padding: 10px 20px;
            font-size: 1em;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-button {
            background-color: #7ca7d5;
        }

        .register-button {
            background-color: #23ac63;

        }

        .login-button:hover {
            background-color: #1c344e; /* Darker blue on hover */
        }

        .register-button:hover {
            background-color: #0b3415; /* Darker green on hover */
        }
    </style>
<body>
    <header>
        <h1>Patient Appointment Booking</h1>
        
    </header>
   
   
    <div style="font-family:Inter, margin:50px; text-align: center; padding: 50px; background-color: #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h1 style="font-size: 2.5em; color: #333;">Welcome to Our Platform</h1>
        <p style="font-size: 1.2em; color: #666;">Manage your appointments with ease.</p>

        <!-- Login and Register Buttons -->
        <div style="margin-top: 20px;">
            <a href="login.php" style="text-decoration: none; margin-right: 10px;">
                <button class="button login-button">Login</button>
            </a>
            <a href="register.php" style="text-decoration: none;">
                <button class="button register-button">Register</button>
            </a>
        </div>
    </div>
    
</body>
</html>
