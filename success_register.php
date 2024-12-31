<?php
// Start the session (if you want to use session variables, or for general session handling)
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission Success</title>
    <link rel="stylesheet" href="style.css"> <!-- Optional: Include your styles -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #1a1a2e, #162447, #1f4068);
            color: #fff;
            text-align: center;
        }

        .container {
            padding: 50px;
            background-color: rgba(22, 36, 71, 0.9);
            border-radius: 12px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.6);
            width: 100%;
            max-width: 500px;
            animation: fadeIn 0.8s ease-in-out;
        }

        .container h1 {
            color: #4CAF50;
            margin-bottom: 20px;
            font-size: 2.5rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.6);
        }

        .container p {
            font-size: 1.2rem;
            color: #e0e0e0;
            margin-bottom: 20px;
        }

        .container a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 1.2rem;
            transition: background-color 0.3s;
        }

        .container a:hover {
            background-color: #45a049;
        }

        /* Smooth Animation for the container */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design for Smaller Screens */
        @media screen and (max-width: 600px) {
            body {
                padding: 20px;
            }

            .container {
                padding: 30px 20px;
            }

            .container h1 {
                font-size: 2rem;
            }

            .container a {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Registration Submitted Successfully!</h1>
        <p>Thank you for your registration!</p>
        <p>You will be redirected shortly.</p>
        <a href="login.php">Login</a> <!-- Redirect to the homepage or another page -->
    </div>

</body>
</html>
