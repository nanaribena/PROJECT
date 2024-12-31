<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Log incoming POST data for debugging
    error_log("POST Data: " . print_r($_POST, true));

    // Validate input
    if (!isset($_POST['form_type'], $_POST['form_id'], $_POST['status'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid parameters: Missing form_type, form_id, or status']);
        exit;
    }

    $form_type_input = trim($_POST['form_type']); // User-provided form type
    $form_id = filter_var($_POST['form_id'], FILTER_VALIDATE_INT); // Validate form ID as an integer
    $status = trim($_POST['status']); // Trim and sanitize status

    // Define valid statuses and form types
    $valid_statuses = ['Pending', 'In Progress', 'Completed'];
    $form_type_mapping = [
        'ICT1' => 'borang_ict1',
        'ICT2' => 'borang_ict2',
        'KEW.PA-9' => 'borang_ict3',
    ];

    // Validate input
    if (!$form_id) {
        echo json_encode(['success' => false, 'message' => 'Invalid form ID']);
        exit;
    }

    if (!in_array($status, $valid_statuses)) {
        echo json_encode(['success' => false, 'message' => 'Invalid status']);
        exit;
    }

    if (!array_key_exists($form_type_input, $form_type_mapping)) {
        echo json_encode(['success' => false, 'message' => 'Invalid form type']);
        exit;
    }

    // Map user-provided form type to database table name
    $form_type = $form_type_mapping[$form_type_input];

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "formdb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
        exit;
    }

    // Prepare the update query
    $sql = "UPDATE $form_type SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare the query: ' . $conn->error]);
        $conn->close();
        exit;
    }

    // Bind parameters and execute the query
    $stmt->bind_param("si", $status, $form_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            // Redirect to the success page after updating
            header("Location: success_update_status.php");
            exit; // Always exit after header redirect
        } else {
            echo json_encode(['success' => false, 'message' => 'No matching record found for the provided ID']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to execute the query: ' . $stmt->error]);
    }

    // Clean up
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}
