<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['form_type']) || !isset($data['form_id'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        exit;
    }

    $form_type = preg_replace('/[^a-zA-Z0-9_]/', '', $data['form_type']);
    $form_id = (int) $data['form_id'];

    $valid_tables = ['borang_ict1', 'borang_ict2', 'borang_ict3'];

    if (!in_array($form_type, $valid_tables)) {
        echo json_encode(['success' => false, 'message' => 'Invalid table']);
        exit;
    }

    $conn = new mysqli("localhost", "root", "", "formdb");

    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM $form_type WHERE id = ?");
    $stmt->bind_param("i", $form_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Form deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete form']);
    }

    $stmt->close();
    $conn->close();
}
