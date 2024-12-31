<?php
// Database connection
include 'db_connection.php';

$id = $_GET['id']; // Changed from form_id to id
$formType = $_GET['form_type'];

if ($id && $formType) {
    $conn = openConnection();

    if ($formType == 'borang_ict1') {
        $sql = "SELECT * FROM borang_ict1 WHERE id = $id";
    } elseif ($formType == 'borang_ict2') {
        $sql = "SELECT * FROM borang_ict2 WHERE id = $id";
    } elseif ($formType == 'borang_ict3') {
        $sql = "SELECT * FROM borang_ict3 WHERE id = $id";
    }

    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $formDetails = $result->fetch_assoc();
        echo json_encode(['success' => true, 'data' => $formDetails]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Form not found']);
    }

    closeConnection($conn);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
}
?>
