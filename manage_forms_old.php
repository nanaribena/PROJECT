<?php
header('Content-Type: application/json'); // Ensure the response is JSON
require_once 'db_connection.php'; // Include database connection functions

try {
    // Open the database connection
    $conn = openConnection();

    // Query to fetch all submitted forms from the `borang_ict1` table
    $query = "SELECT id, username, form_type, tarikh_diperlukan, keutamaan, created_at, status FROM borang_ict1 ORDER BY created_at DESC";
    $stmt = $conn->prepare($query); // Prepare the query
    $stmt->execute(); // Execute the query

    // Fetch all results as an associative array
    $forms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return success response with all form data
    echo json_encode([
        'success' => true,
        'forms' => $forms,
    ]);
} catch (Exception $e) {
    // Catch any exceptions and return an error response
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage(),
    ]);
} finally {
    // Ensure the database connection is closed
    closeConnection($conn);
}
?>
