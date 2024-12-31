<?php
header('Content-Type: application/json'); // Set response type as JSON
require_once 'db_connection.php'; // Include the database connection functions

try {
    // Open the database connection
    $conn = openConnection();

    // Query to fetch user data from the `login_users` table
    $query = "SELECT id, username, full_email, user_role, created_at, no_tel FROM login_users ORDER BY id ASC";

    // Execute the query using MySQLi
    $result = $conn->query($query);

    // Check if the query was successful
    if (!$result) {
        throw new Exception("Failed to fetch users: " . $conn->error);
    }

    // Fetch all results as an associative array
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    // Check if users exist
    if (empty($users)) {
        echo json_encode([
            'success' => true,
            'message' => 'No users found.',
            'users' => [], // Return an empty array for consistency
        ]);
        exit;
    }

    // Return success response with the user data
    echo json_encode([
        'success' => true,
        'users' => $users,
    ]);
} catch (Exception $e) {
    // Catch exceptions and return an error response
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage(),
    ]);
} finally {
    // Ensure the database connection is closed
    if (isset($conn)) {
        closeConnection($conn);
    }
}
?>

