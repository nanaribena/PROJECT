<?php
header('Content-Type: application/json'); // Set response as JSON
require_once 'db_connection.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Trim and sanitize input
    $email = htmlspecialchars(trim($_POST['email'] ?? ''), ENT_QUOTES, 'UTF-8');
    $username = htmlspecialchars(trim($_POST['username'] ?? ''), ENT_QUOTES, 'UTF-8');
    $password = trim($_POST['password'] ?? '');
    $no_tel = htmlspecialchars(trim($_POST['no_tel'] ?? ''), ENT_QUOTES, 'UTF-8');
    $user_role = htmlspecialchars(trim($_POST['user_role'] ?? ''), ENT_QUOTES, 'UTF-8');

    // Validate inputs
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'A valid email is required.']);
        exit;
    }

    if (empty($username)) {
        echo json_encode(['success' => false, 'message' => 'Username is required.']);
        exit;
    }

    if (empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Password is required.']);
        exit;
    }

    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters long.']);
        exit;
    }

    if (empty($no_tel)) {
        echo json_encode(['success' => false, 'message' => 'Phone number is required.']);
        exit;
    }

    if (empty($user_role)) {
        echo json_encode(['success' => false, 'message' => 'User role is required.']);
        exit;
    }

    try {
        // Open database connection
        $conn = openConnection();

        // Check if email already exists
        $checkEmailQuery = "SELECT id FROM login_users WHERE full_email = ?";
        $stmt = $conn->prepare($checkEmailQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo json_encode(['success' => false, 'message' => 'Email already exists.']);
            $stmt->close();
            exit;
        }

        $stmt->close(); // Close the email check statement

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert new user
        $insertQuery = "INSERT INTO login_users (full_email, username, password, no_tel, user_role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sssss", $email, $username, $hashed_password, $no_tel, $user_role);

        if ($stmt->execute()) {
            // Successful registration, redirect to success page
            header('Location: success_register.php');
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Registration failed. Please try again.']);
        }

        $stmt->close(); // Close the insert statement

    } catch (mysqli_sql_exception $e) {
        // Handle database errors
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    } finally {
        // Close connection
        if (isset($conn)) {
            closeConnection($conn); // Assuming closeConnection() properly closes MySQLi connection
        }
    }
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
