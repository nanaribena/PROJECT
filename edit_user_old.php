<?php
// Include the database connection file
include('db_connection.php');

// Initialize error and success messages
$errorMessage = '';
$successMessage = '';

// Fetch the current username from the session (assuming the user is logged in and their username is stored in the session)
session_start();  // Ensure the session is started
$currentUsername = $_SESSION['username']; // Assuming the username is stored in the session

// Initialize variables to hold user data
$currentEmail = '';
$currentRole = '';
$currentPhone = '';

// Fetch current user details from the database
try {
    // Open the database connection using PDO
    $conn = openConnection();

    // Query to fetch the user details
    $sql = "SELECT full_email, user_role, no_tel FROM login_users WHERE username = :username";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    // Bind the username parameter
    $stmt->bindParam(':username', $currentUsername);
    
    // Execute the statement
    $stmt->execute();
    
    // Check if the user exists
    if ($stmt->rowCount() > 0) {
        // Fetch the result
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Store user details
        $currentEmail = $user['full_email'];
        $currentRole = $user['user_role'];
        $currentPhone = $user['no_tel'];
    } else {
        $errorMessage = "User not found.";
    }

    // Close the connection
    $conn = null;  // Close the PDO connection by setting it to null
} catch (PDOException $e) {
    // Catch any exceptions
    $errorMessage = "Error: " . $e->getMessage();
}

// Process the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data and sanitize it
    $newUsername = isset($_POST['new_username']) ? trim($_POST['new_username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $role = isset($_POST['role']) ? trim($_POST['role']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

    // Validate form data
    if (empty($newUsername) || empty($email) || empty($role) || empty($phone)) {
        $errorMessage = "Please fill in all fields.";
    } else {
        try {
            // Open the database connection using PDO
            $conn = openConnection();

            // Prepare the UPDATE query with placeholders (including the username change)
            $sql = "UPDATE login_users 
                    SET username = :new_username, full_email = :email, user_role = :role, no_tel = :phone 
                    WHERE username = :username";

            // Prepare the statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':username', $currentUsername);    // Current username
            $stmt->bindParam(':new_username', $newUsername); // New username
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':phone', $phone);

            // Execute the statement
            if ($stmt->execute()) {
                // Check if any rows were affected
                if ($stmt->rowCount() > 0) {
                    // Update session username if the update is successful
                    $_SESSION['username'] = $newUsername;
                    $successMessage = "User updated successfully!";
                } else {
                    $errorMessage = "No changes were made or user not found.";
                }
            } else {
                $errorMessage = "Error updating user.";
            }

            // Close the connection
            $conn = null;  // Close the PDO connection by setting it to null

        } catch (PDOException $e) {
            // Catch any exceptions
            $errorMessage = "Error: " . $e->getMessage();
        }
    }
}
?>

<!-- HTML Form for Editing User -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f9;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-container {
            width: 60%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .form-container label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }
        .form-container input, .form-container select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-container button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
        .message {
            text-align: center;
            margin: 10px 0;
        }
        .error-message {
            color: red;
        }
        .success-message {
            color: green;
        }
        .back-button {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
        .back-button:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>

    <h2>Edit User</h2>

    <div class="form-container">

        <!-- Display the error message if any -->
        <?php if (!empty($errorMessage)): ?>
            <div class="message error-message">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

        <!-- Display success message if updated successfully -->
        <?php if (!empty($successMessage)): ?>
            <div class="message success-message">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php endif; ?>

        <!-- Form to edit user details -->
        <form action="edit_user.php" method="POST">
            <div>
                <label for="current_username">Current Username:</label>
                <input type="text" id="current_username" value="<?php echo htmlspecialchars($currentUsername); ?>" readonly>
            </div>
            <div>
                <label for="new_username">New Username:</label>
                <input type="text" id="new_username" name="new_username" value="<?php echo isset($newUsername) ? htmlspecialchars($newUsername) : ''; ?>" required>
            </div>
            <div>
                <label for="email">Current Email:</label>
                <input type="email" id="email" value="<?php echo isset($currentEmail) ? htmlspecialchars($currentEmail) : ''; ?>" readonly>
            </div>
            <div>
                <label for="new_email">New Email:</label>
                <input type="email" id="new_email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
            </div>
            <div>
                <label for="role">Current Role:</label>
                <input type="text" id="role" value="<?php echo isset($currentRole) ? htmlspecialchars($currentRole) : ''; ?>" readonly>
            </div>
            <div>
                <label for="new_role">New Role:</label>
                <select id="new_role" name="role" required>
                    <option value="Admin" <?php echo isset($currentRole) && $currentRole == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="Ketua Seksyen" <?php echo isset($currentRole) && $currentRole == 'Ketua Seksyen' ? 'selected' : ''; ?>>Ketua Seksyen</option>
                </select>
            </div>
            <div>
                <label for="phone">Current Phone:</label>
                <input type="text" id="phone" value="<?php echo isset($currentPhone) ? htmlspecialchars($currentPhone) : ''; ?>" readonly>
            </div>
            <div>
                <label for="new_phone">New Phone:</label>
                <input type="text" id="new_phone" name="phone" value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>" required>
            </div>
            <button type="submit">Update User</button>
        </form>

        <!-- Button to go back to the manage_users page -->
        <form action="manage_users.html" method="get">
            <button class="back-button" type="submit">Back to Manage Users</button>
        </form>

    </div>

</body>
</html>

<?php
session_start(); // Start session

if (!isset($_SESSION['username'])) {
    echo json_encode(["error" => "User not logged in. Please log in to continue."]);
    exit;
}

// Include database connection
include 'db_connection.php';

try {
    $pdo = openConnection();

    // Normalize session username
    $username = strtolower(trim($_SESSION['username'])); // Ensure consistency with database

    // Debugging output
    error_log("Debug: Logged-in user: " . $username);

    // Fetch data from borang_ict1
    $query1 = "
        SELECT id, perkakasan, other_answer, username, jenis_permintaan, keutamaan, date_start, 
               day_start, date_end, day_end, description, files, created_at
        FROM borang_ict1
        WHERE LOWER(TRIM(username)) = :username
        ORDER BY created_at DESC
    ";

    // Fetch data from borang_ict2 (columns without username, date_start, day_start, date_end, day_end, description, files)
    $query2 = "
        SELECT id, perkakasan, other_answer, username, jenis_permintaan, keutamaan, date_start, 
               day_start, date_end, day_end, description, NULL AS files, created_at
        FROM borang_ict2
        WHERE LOWER(TRIM(username)) = :username
        ORDER BY created_at DESC
    ";

    // Prepare and execute the first query for borang_ict1
    $stmt1 = $pdo->prepare($query1);
    $stmt1->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt1->execute();
    $forms1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    // Prepare and execute the second query for borang_ict2
    $stmt2 = $pdo->prepare($query2);
    $stmt2->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt2->execute();
    $forms2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    // Merge the two results
    $allForms = array_merge($forms1, $forms2);

    if ($allForms) {
        // Return all forms as JSON
        echo json_encode($allForms);
    } else {
        // No forms found for the user
        error_log("Debug: No forms found for user: " . $username);
        echo json_encode(["debug" => "No forms found for user: " . $username]);
    }

    closeConnection($pdo);
} catch (PDOException $e) {
    // Log error and return response
    error_log("Error fetching forms: " . $e->getMessage());
    echo json_encode(["error" => "Error fetching forms. Please try again later."]);
}
?>
