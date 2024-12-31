<?php
include 'db_connection.php'; // Include the database connection file

header('Content-Type: application/json');

try {
    // Open database connection
    $conn = openConnection();

    // Get the JSON input data
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id'])) {
        throw new Exception('User ID is required');
    }

    $id = $data['id'];
    $username = $data['username'] ?? '';
    $full_email = $data['full_email'] ?? '';
    $no_tel = $data['no_tel'] ?? '';
    $user_role = $data['user_role'] ?? '';

    // Update query
    $query = "UPDATE login_users 
              SET username = ?, full_email = ?, no_tel = ?, user_role = ?
              WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssi', $username, $full_email, $no_tel, $user_role, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'User updated successfully']);
    } else {
        throw new Exception('Failed to update user: ' . $stmt->error);
    }

    // Close the connection
    closeConnection($conn);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
