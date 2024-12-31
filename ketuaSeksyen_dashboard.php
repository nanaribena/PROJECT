<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

$username = $_SESSION['username']; // Retrieve the username from session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ketua Seksyen Dashboard</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1b1e31, #0d111b); /* Deep navy gradient */
            color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            text-shadow: 4px 4px 10px rgba(0, 0, 0, 0.7);
            color: #00e7ff; /* Neon cyan */
        }

        #welcome-message {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 30px;
            color: #ffffff;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.5);
        }

        .dashboard-container {
            background: linear-gradient(135deg, #232946, #12172b); /* Sleek container gradient */
            padding: 40px 50px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            text-align: center;
            max-width: 600px;
            width: 90%;
            animation: slideIn 1s ease-in-out;
        }

        button {
            display: block;
            width: 100%;
            padding: 15px 20px;
            margin: 15px 0;
            background: linear-gradient(135deg, #0063ff, #0047cc); /* Cool blue gradient */
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 99, 255, 0.4);
        }

        button:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 99, 255, 0.6);
        }

        .link-button {
            background: linear-gradient(135deg, #00d4ff, #009bb7); /* Vibrant teal gradient */
        }

        .recent-button {
            background: linear-gradient(135deg, #ff9100, #d97700); /* Bright orange gradient */
            box-shadow: 0 5px 15px rgba(255, 145, 0, 0.4);
        }

        .recent-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(255, 145, 0, 0.6);
        }

        .logout-button {
            background: linear-gradient(135deg, #ff3e6c, #c72850); /* Bold red gradient for logout */
            box-shadow: 0 10px 25px rgba(255, 62, 108, 0.5);
        }

        .logout-button:hover {
            box-shadow: 0 15px 35px rgba(255, 62, 108, 0.7);
            transform: translateY(-5px);
        }

        /* Logout Modal Styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.5s, visibility 0.5s;
        }

        .modal.active {
            visibility: visible;
            opacity: 1;
        }

        .modal-content {
            background: linear-gradient(135deg, #1b1e31, #0d111b);
            padding: 30px 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .modal-content h2 {
            color: #ff3e6c;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .modal-content p {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #ffffff;
        }

        .close-btn {
            background: linear-gradient(135deg, #00d4ff, #009bb7);
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            border: none;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .close-btn:hover {
            background: linear-gradient(135deg, #008cba, #005f75);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Ketua Seksyen Dashboard</h1>
        <p id="welcome-message">Welcome, <span id="username"><?php echo htmlspecialchars($username); ?></span>!</p>
        <button class="link-button" onclick="window.location.href='borangICT1.php'">Fill Form 1 (ICT 1)</button>
        <button class="link-button" onclick="window.location.href='borangICT2.php'">Fill Form 2 (ICT 2)</button>
        <button class="link-button" onclick="window.location.href='borangICT3.php'">Fill Form KEW.PA-9</button>
        <button class="recent-button" onclick="window.location.href='recently_submitted_forms.php'">View Recent Submissions</button>
        <button class="logout-button" onclick="logout()">Logout</button>
    </div>

    <script>
        function logout() {
            // Redirect to success_logout.php when the logout button is clicked
            window.location.href = 'success_logout.php'; // Direct the user to success_logout.php
        }
    </script>
</body>
</html>
