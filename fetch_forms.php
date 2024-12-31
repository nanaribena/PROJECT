<?php
// Include the database connection
include 'db_connection.php';

// Check if the form_type is provided via GET request
if (isset($_GET['form_type'])) {
    $formType = $_GET['form_type']; // Get the form type (borang_ict1, borang_ict2, borang_ict3)

    // Validate form type to avoid SQL injection
    $validFormTypes = ['borang_ict1', 'borang_ict2', 'borang_ict3'];
    
    if (!in_array($formType, $validFormTypes)) {
        // Invalid form type
        echo json_encode(['success' => false, 'message' => 'Invalid form type']);
        exit;
    }

    // Establish database connection
    $conn = openConnection();

    // Safely prepare the SQL query based on the form type
    $sql = "SELECT * FROM `$formType`"; // Using backticks around table name for safety

    // Execute the SQL query using prepared statement (even though it's a SELECT)
    if ($stmt = $conn->prepare($sql)) {
        // Execute the prepared statement
        $stmt->execute();

        // Get the result of the query
        $result = $stmt->get_result();

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            $data = [];
            // Fetch all rows and store them in the $data array
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            // Return the data in JSON format
            echo json_encode(['success' => true, 'data' => $data]);
        } else {
            // No data found for the specified form type
            echo json_encode(['success' => true, 'data' => []]);  // Return empty array if no data
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Failed to prepare the SQL query
        echo json_encode(['success' => false, 'message' => 'Failed to prepare the SQL query']);
    }

    // Close the database connection
    closeConnection($conn);
} else {
    // No form type specified in the request
    echo json_encode(['success' => false, 'message' => 'No form type specified']);
}
?>
