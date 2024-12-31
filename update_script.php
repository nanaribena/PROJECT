<?php
// Include database connection
include 'db_connection.php';

header('Content-Type: application/json');

// Read input JSON
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['id']) && isset($input['status'])) {
    $id = $input['id'];
    $status = $input['status'];

    // Update the form's status in the database
    $query = "UPDATE borang_ict1 SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Status updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Database update failed."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid input data."]);
}

$conn->close();
?>
