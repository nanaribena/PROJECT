<?php
// Check if the form data was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all necessary parameters are available in the POST request
    if (!isset($_POST['form_type']) || !isset($_POST['id']) || !isset($_POST['status'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
        exit;
    }

    // Sanitize the inputs
    $form_type = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['form_type']); // Only allow alphanumeric and underscores
    $id = (int)$_POST['id']; // Ensure the ID is an integer
    $status = $_POST['status']; // Status will be a string

    // Validate status (if predefined values are used)
    $valid_statuses = ['pending', 'in-progress', 'completed'];
    if (!in_array($status, $valid_statuses)) {
        echo json_encode(['success' => false, 'message' => 'Invalid status']);
        exit; // Exit if the status is invalid
    }

    // Log sanitized input for debugging (consider removing or conditionally logging in production)
    error_log("Sanitized data: form_type=$form_type, id=$id, status=$status");

    // Validate form_type (ensure it's a valid table)
    $valid_form_types = ['borang_ict1', 'borang_ict2', 'borang_ict3']; // Adjust table names as needed

    if (!in_array($form_type, $valid_form_types)) {
        echo json_encode(['success' => false, 'message' => 'Invalid form type']);
        exit; // Exit if the form type is invalid
    }

    // Database connection
    $servername = "localhost"; // Your database server
    $username = "root";        // Your database username
    $password = "";            // Your database password
    $dbname = "formdb";        // Your database name

    // Create a new MySQLi connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
        exit;
    }

    // Prepare the SQL update query
    $sql = "UPDATE $form_type SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Check if the prepared statement was created successfully
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare query']);
        exit;
    }

    // Bind parameters to the prepared statement
    $stmt->bind_param("si", $status, $id); // "s" for string (status), "i" for integer (id)

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to the view page after successful update (with form type and id)
        header("Location: view_form.php?id=" . $id . "&form_type=" . $form_type);
        exit; // Make sure to exit after redirect
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status']);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
