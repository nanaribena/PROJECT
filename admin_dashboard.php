<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e, #162447, #1f4068);
            color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            animation: backgroundFade 5s infinite alternate;
        }

        /* Smooth Background Animation */
        @keyframes backgroundFade {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        h1 {
            text-align: center;
            color: #f9f9f9;
            font-size: 2.5rem;
            margin-bottom: 20px;
            letter-spacing: 2px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6);
        }

        p {
            text-align: center;
            color: #f9f9f9;
            font-size: 1.2rem;
            margin-bottom: 40px;
        }

        .dashboard-container {
            background: rgba(22, 36, 71, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 500px;
            animation: fadeIn 0.8s ease-in-out;
            text-align: center;
        }

        .link-button, .logout-button {
            display: inline-block;
            padding: 15px 30px;
            margin: 15px 0;
            font-size: 1.2rem;
            text-align: center;
            color: #fff;
            text-decoration: none;
            background: linear-gradient(45deg, #007bff, #0056b3);
            border-radius: 12px;
            width: 90%;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .link-button:hover, .logout-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.5);
            background: linear-gradient(45deg, #0056b3, #007bff);
        }

        .logout-button {
            margin-top: 30px;
            background: linear-gradient(45deg, #ff4b5c, #f25f79);
        }

        .logout-button:hover {
            background: linear-gradient(45deg, #f25f79, #ff4b5c);
            box-shadow: 0 10px 30px rgba(255, 75, 92, 0.5);
        }

        /* Add hover effects for buttons */
        .link-button:active, .logout-button:active {
            transform: scale(0.98);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            p {
                font-size: 1rem;
            }

            .dashboard-container {
                padding: 30px;
            }

            .link-button, .logout-button {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div>
        <h1>Admin Dashboard</h1>
        <p>Welcome to the admin dashboard. Please select an option below.</p>
        
        <div class="dashboard-container">
            <a href="manage_users.html" class="link-button">Manage Users</a>
            <a href="manage_forms.html" class="link-button">Manage Forms</a>
            <button class="logout-button" onclick="location.href='logout.php'">Logout</button>
        </div>
    </div>
</body>
</html>


