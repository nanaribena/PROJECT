<?php
// db_connection.php - to connect to the database
require_once 'db_connection.php';

header('Content-Type: application/json');

// Check if data is received via POST
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id']) || !isset($data['status'])) {
    echo json_encode(['success' => false, 'message' => 'Missing form ID or status']);
    exit;
}

$formId = $data['id'];
$status = $data['status'];

// Prepare SQL statement to update form status
$sql = "UPDATE borang_ict1 SET status = ? WHERE id = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("si", $status, $formId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Database query failed']);
}

$conn->close();
?>
