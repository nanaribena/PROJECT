<?php
require_once 'db_connection.php'; // Include the database connection functions

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form data
    $perkakasan = isset($_POST['perkakasan']) ? (array) $_POST['perkakasan'] : []; // Ensure it's an array
    $other_answer = htmlspecialchars(trim($_POST['other_answer'] ?? 'N/A'));
    $username = htmlspecialchars(trim($_POST['username'] ?? 'Unknown'));
    $jenis_permintaan = isset($_POST['jenis_permintaan']) ? (array) $_POST['jenis_permintaan'] : [];
    $keutamaan = isset($_POST['keutamaan']) ? (array) $_POST['keutamaan'] : [];
    $tarikh_diperlukan = htmlspecialchars(trim($_POST['tarikh_diperlukan'] ?? ''));
    $hari = htmlspecialchars(trim($_POST['hari'] ?? ''));
    $keterangan_permohonan = htmlspecialchars(trim($_POST['keterangan_permohonan'] ?? 'N/A'));

    // Validate required fields
    if (empty($tarikh_diperlukan) || empty($hari) || empty($perkakasan) || empty($jenis_permintaan) || empty($keutamaan)) {
        echo "Error: Missing required fields.";
        exit;
    }

    // Convert arrays to comma-separated strings
    $perkakasan_str = implode(", ", array_map('htmlspecialchars', $perkakasan));
    $jenis_permintaan_str = implode(", ", array_map('htmlspecialchars', $jenis_permintaan));
    $keutamaan_str = implode(", ", array_map('htmlspecialchars', $keutamaan));

    try {
        // Open database connection
        $conn = openConnection();

        // Prepare the insert query using mysqli
        $query = "INSERT INTO borang_ict1 
                  (tarikh_diperlukan, hari, perkakasan, other_answer, username, jenis_permintaan, keutamaan, keterangan_permohonan) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);

        // Check if the statement was prepared successfully
        if (!$stmt) {
            throw new Exception("Failed to prepare the query: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param(
            "ssssssss",
            $tarikh_diperlukan,
            $hari,
            $perkakasan_str,
            $other_answer,
            $username,
            $jenis_permintaan_str,
            $keutamaan_str,
            $keterangan_permohonan
        );

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to success page upon successful submission
            header("Location: success_page.php");
            exit;
        } else {
            echo "Error: Failed to submit the form. Please try again.";
        }
    } catch (Exception $e) {
        // Handle database or other errors
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the statement and database connection
        if (isset($stmt)) {
            $stmt->close();
        }
        closeConnection($conn);
    }
} else {
    // Reject non-POST requests
    echo "Error: This page can only be accessed via form submission.";
    exit;
}
?>