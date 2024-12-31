<?php
// Include database connection
require_once 'db_connection.php';

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Validate input
    if (!$data || !isset($data['id'], $data['username'], $data['full_email'], $data['no_tel'], $data['user_role'])) {
        throw new Exception('Invalid input.');
    }

    $id = $data['id'];
    $username = $data['username']; // Maps to `username`
    $fullEmail = $data['full_email'];   // Maps to `full_email`
    $noTel = $data['no_tel'];  // Maps to `no_tel`
    $userRole = $data['user_role'];

    $conn = openConnection();

    // Prepare SQL statement
    $stmt = $conn->prepare("UPDATE login_users SET username = ?, full_email = ?, no_tel = ?, user_role = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $username, $fullEmail, $noTel, $userRole, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Failed to update user details.');
    }

    $stmt->close();
    closeConnection($conn);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
