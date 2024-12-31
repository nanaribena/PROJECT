<?php
include 'db_connection.php';

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id'])) {
        $conn = openConnection();

        // Delete query
        $query = "DELETE FROM login_users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $data['id']);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete user.']);
        }

        closeConnection($conn);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request data.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
