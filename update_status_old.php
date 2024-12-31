<?php
require 'db_connection.php';

header('Content-Type: application/json');

// Step 1: Read the raw POST data
$rawPostData = file_get_contents("php://input");
error_log("Raw POST data: " . $rawPostData);  // Log raw POST data

// Step 2: Decode the JSON data
$data = json_decode($rawPostData, true);
error_log("Decoded Data: " . var_export($data, true));  // Log decoded data

// Step 3: If data is missing or incorrect, output error
if (empty($rawPostData) || !isset($data['id']) || !isset($data['status'])) {
    echo json_encode(["success" => false, "message" => "Error: Missing or invalid data in the POST request."]);
    exit;  // Exit if data is invalid or missing
}

// Step 4: Extract and sanitize the data
$id = intval($data['id']);  // Ensure ID is an integer
$status = htmlspecialchars(trim($data['status']));  // Sanitize and trim status input
error_log("Received: ID = $id, Status = $status");  // Log the received data

// Step 5: Prepare the SQL query and bind parameters
try {
    $pdo = openConnection();  // Open database connection

    // Check if connection is successful
    if (!$pdo) {
        echo json_encode(["success" => false, "message" => "Error: Could not establish a database connection."]);
        exit;
    }

    // Prepare the update query
    $stmt = $pdo->prepare("UPDATE borang_ict1 SET status = :status WHERE id = :id");

    // Bind the parameters
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Step 6: Execute the query
    if ($stmt->execute()) {
        // Step 7: Check if any rows were affected
        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => true, "message" => "Status updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "No rows affected. Please check the ID or status."]);
        }
    } else {
        // Step 8: Query failed to execute
        echo json_encode(["success" => false, "message" => "Failed to execute the query."]);
    }

} catch (PDOException $e) {
    // Step 9: Handle database errors
    echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
} catch (Exception $e) {
    // Step 10: Handle other errors
    echo json_encode(["success" => false, "message" => "Unexpected error: " . $e->getMessage()]);
} finally {
    // Step 11: Ensure the database connection is closed
    if (isset($pdo)) {
        closeConnection($pdo);
    }
}
?>
