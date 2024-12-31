<?php
include 'db_connection.php';

header('Content-Type: application/json');

try {
    // Open database connection
    $conn = openConnection();

    // Fetch user data
    $query = "SELECT id, username, full_email, no_tel, user_role FROM login_users";
    $result = $conn->query($query);

    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    // Return success response with user data
    echo json_encode(['success' => true, 'users' => $users]);

    // Close the connection
    closeConnection($conn);
} catch (Exception $e) {
    // Return error response
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
