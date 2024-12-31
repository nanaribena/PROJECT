<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session to access user info
session_start();

// Include the database connection
include 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

// Get the user ID from the session
$userId = $_SESSION['id'];

try {
    // Establish the database connection
    $conn = openConnection();

    // Query to fetch the forms submitted by the logged-in user
    $sql = "SELECT id, username, form_type, keutamaan, status FROM (
                SELECT id, username, 'borang_ict1' AS form_type, keutamaan, status FROM borang_ict1 WHERE id = ?
                UNION ALL
                SELECT id, username, 'borang_ict2' AS form_type, keutamaan, status FROM borang_ict2 WHERE id = ?
                UNION ALL
                SELECT id, username, 'borang_ict3' AS form_type, keutamaan, status FROM borang_ict3 WHERE id = ?
            ) AS user_forms ORDER BY id";
    $stmt = $conn->prepare($sql);

    // Check if the query was prepared successfully
    if (!$stmt) {
        throw new Exception('Failed to prepare SQL query: ' . $conn->error);
    }

    $stmt->bind_param('iii', $userId, $userId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the data if available
    if ($result->num_rows > 0) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                'id' => $row['id'],
                'username' => $row['username'],
                'form_type' => $row['form_type'],
                'keutamaan' => $row['keutamaan'],
                'status' => $row['status']
            ];
        }
        echo json_encode(['success' => true, 'data' => $data]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No forms found']);
    }

    // Close the database connection
    $stmt->close();
    closeConnection($conn);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
