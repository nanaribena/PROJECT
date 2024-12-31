<?php
require_once 'db_connection.php'; // Include the database connection functions

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form data
    $sistem = isset($_POST['sistem']) ? (array) $_POST['sistem'] : []; // Ensure it's an array
    $sistem_other = htmlspecialchars(trim($_POST['sistem_other'] ?? 'N/A'));
    $jenis_permintaan = isset($_POST['jenis_permintaan']) ? (array) $_POST['jenis_permintaan'] : [];
    $keutamaan = isset($_POST['keutamaan']) ? (array) $_POST['keutamaan'] : [];
    $tarikh_mula = htmlspecialchars(trim($_POST['tarikh_mula'] ?? ''));
    $tarikh_hingga = htmlspecialchars(trim($_POST['tarikh_hingga'] ?? ''));
    $keterangan_permohonan = htmlspecialchars(trim($_POST['keterangan_permohonan'] ?? 'N/A'));
    $username = htmlspecialchars(trim($_POST['username'] ?? 'Unknown'));
    $bahagian = htmlspecialchars(trim($_POST['bahagian'] ?? ''));
    $tarikh_pemohon = htmlspecialchars(trim($_POST['tarikh_pemohon'] ?? ''));

    // If tarikh_mula is set, send it to both tarikh_mula and tarikh_diperlukan
    $tarikh_diperlukan = $tarikh_mula;

    // Validate required fields
    if (empty($tarikh_mula) || empty($tarikh_hingga) || empty($sistem) || empty($jenis_permintaan) || empty($keutamaan)) {
        echo "Error: Missing required fields.";
        exit;
    }

    // Convert arrays to comma-separated strings
    $sistem_str = implode(", ", array_map('htmlspecialchars', $sistem));
    $jenis_permintaan_str = implode(", ", array_map('htmlspecialchars', $jenis_permintaan));
    $keutamaan_str = implode(", ", array_map('htmlspecialchars', $keutamaan));

    // Set form_type to "ICT 2"
    $form_type = "ICT 2";

    try {
        // Open database connection
        $conn = openConnection();

        // Prepare the insert query using mysqli
        $query = "INSERT INTO borang_ict2 
                  (sistem, sistem_other, jenis_permintaan, keutamaan, tarikh_mula, tarikh_diperlukan, tarikh_hingga, keterangan_permohonan, username, bahagian, tarikh_pemohon, form_type) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);

        // Check if the statement was prepared successfully
        if (!$stmt) {
            throw new Exception("Failed to prepare the query: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param(
            "ssssssssssss",
            $sistem_str,
            $sistem_other,
            $jenis_permintaan_str,
            $keutamaan_str,
            $tarikh_mula,
            $tarikh_diperlukan, // Send tarikh_mula to tarikh_diperlukan as well
            $tarikh_hingga,
            $keterangan_permohonan,
            $username,
            $bahagian,
            $tarikh_pemohon,
            $form_type // Insert "ICT 2" as form_type
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
