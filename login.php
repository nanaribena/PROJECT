<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
require_once 'db_connection.php';

// Initialize variables
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user inputs
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $selectedRole = isset($_POST['user_role']) ? trim($_POST['user_role']) : '';

    if (empty($username) || empty($password) || empty($selectedRole)) {
        $errorMessage = "Please fill in all fields and select a role.";
    } else {
        // Open database connection using mysqli
        $conn = openConnection();

        if ($conn) {
            try {
                // Query to fetch user data based on username and role
                $query = $conn->prepare("SELECT * FROM login_users WHERE username = ? AND user_role = ?");
                $query->bind_param("ss", $username, $selectedRole); // 'ss' means both parameters are strings
                $query->execute();
                $result = $query->get_result();

                if ($result->num_rows === 1) {
                    $user = $result->fetch_assoc();

                    // Verify password
                    if (password_verify($password, $user['password'])) {
                        session_start();
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['user_role'] = $user['user_role'];

                        // Redirect based on user role
                        if ($user['user_role'] === 'Admin') {
                            header("Location: admin_dashboard.html");
                            exit;
                        } elseif ($user['user_role'] === 'Ketua Seksyen') {
                            header("Location: ketuaSeksyen_dashboard.php");
                            exit;
                        } else {
                            $errorMessage = "Invalid role detected.";
                        }
                    } else {
                        $errorMessage = "Incorrect password.";
                    }
                } else {
                    $errorMessage = "Invalid username or role.";
                }
            } catch (Exception $e) {
                $errorMessage = "An error occurred: " . $e->getMessage();
            } finally {
                // Close connection
                closeConnection($conn);
            }
        } else {
            $errorMessage = "Database connection failed.";
        }
    }
}
?>

<!-- HTML Part -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #020c1b, #0b1d3f); /* Dark blue background */
            color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        h2 {
            text-align: center;
            color: #ffffff;
            font-size: 2rem;
            margin-bottom: 1rem;
            opacity: 0;
            animation: fadeInText 1s ease-out forwards 0.5s; /* Fade-in effect */
        }

        /* Container Styling */
        .form-container {
            background: linear-gradient(135deg, #1a1a2e, #16213e); /* Darker gradient for container */
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: slideIn 0.8s ease-in-out;
        }

        /* Form and Inputs */
        form {
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }

        input, select {
            padding: 14px;
            margin: 12px 0;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            background-color: #1f4068;
            color: #ffffff;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.3);
            transition: background-color 0.3s, transform 0.2s;
        }

        input:focus, select:focus {
            background-color: #283655;
            outline: none;
            transform: translateY(-2px);
        }

        button {
            padding: 14px;
            margin-top: 15px;
            background: linear-gradient(45deg, #00bcd4, #0089a2); /* Soft blue gradient */
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 188, 212, 0.4);
        }

        p {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .error {
            color: #ff4d4d;
            font-size: 1rem;
        }

        a {
            color: #00d4ff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #00aaff;
            text-decoration: underline;
        }

        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInText {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px 30px;
            }

            input, select, button {
                font-size: 14px;
                padding: 12px;
            }

            h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div>
                <label for="user_role">Role:</label>
                <select id="user_role" name="user_role" required>
                    <option value="" disabled selected>Select Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Ketua Seksyen">Ketua Seksyen</option>
                </select>
            </div>

            <button type="submit">Login</button>

            <?php if (!empty($errorMessage)): ?>
                <p class="error"><?php echo htmlspecialchars($errorMessage); ?></p>
            <?php endif; ?>
        </form>
    </div>

</body>
</html>
