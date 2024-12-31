<?php
// Include the database connection functions
include('db_connection.php');

// Open the database connection
$conn = openConnection();

// Check if the connection was successful
if ($conn === null) {
    die("Database connection failed.");
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escape user inputs for security
    $no_permohonan = mysqli_real_escape_string($conn, $_POST['no_permohonan']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $jawatan = mysqli_real_escape_string($conn, $_POST['jawatan']);
    $tujuan = mysqli_real_escape_string($conn, $_POST['tujuan']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $tempat_digunakan = mysqli_real_escape_string($conn, $_POST['tempat_digunakan']);
    $nama_pengeluar = mysqli_real_escape_string($conn, $_POST['nama_pengeluar']);
    $bil = mysqli_real_escape_string($conn, $_POST['bil']);
    $no_siri = mysqli_real_escape_string($conn, $_POST['no_siri']);
    $keterangan_aset = mysqli_real_escape_string($conn, $_POST['keterangan_aset']);
    $tarikh_diperlukan = mysqli_real_escape_string($conn, $_POST['tarikh_diperlukan']);
    $tarikh_dijangka_pulang = mysqli_real_escape_string($conn, $_POST['tarikh_dijangka_pulang']);
    $tarikh_dipulangkan = mysqli_real_escape_string($conn, $_POST['tarikh_dipulangkan']);
    $tarikh_diterima = mysqli_real_escape_string($conn, $_POST['tarikh_diterima']);
    $status_lulus = mysqli_real_escape_string($conn, $_POST['status_lulus']);
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan']);
    $peminjam_nama = mysqli_real_escape_string($conn, $_POST['peminjam_nama']);
    $peminjam_jawatan = mysqli_real_escape_string($conn, $_POST['peminjam_jawatan']);
    $peminjam_tarikh = mysqli_real_escape_string($conn, $_POST['peminjam_tarikh']);
    $pelulus_nama = mysqli_real_escape_string($conn, $_POST['pelulus_nama']);
    $pelulus_jawatan = mysqli_real_escape_string($conn, $_POST['pelulus_jawatan']);
    $pelulus_tarikh = mysqli_real_escape_string($conn, $_POST['pelulus_tarikh']);
    $pemulang_nama = mysqli_real_escape_string($conn, $_POST['pemulang_nama']);
    $pemulang_jawatan = mysqli_real_escape_string($conn, $_POST['pemulang_jawatan']);
    $pemulang_tarikh = mysqli_real_escape_string($conn, $_POST['pemulang_tarikh']);

    // Get the current timestamp for created_at
    $created_at = date('Y-m-d H:i:s');

    // Set the form type manually
    $form_type = 'KEW.PA-9';

    // Insert form data into the database
    $sql = "INSERT INTO borang_ict3 (no_permohonan, username, jawatan, tujuan, jabatan, tempat_digunakan, nama_pengeluar, bil, no_siri, keterangan_aset, tarikh_diperlukan, tarikh_dijangka_pulang, tarikh_dipulangkan, tarikh_diterima, status_lulus, catatan, peminjam_nama, peminjam_jawatan, peminjam_tarikh, pelulus_nama, pelulus_jawatan, pelulus_tarikh, pemulang_nama, pemulang_jawatan, pemulang_tarikh, form_type, created_at) 
            VALUES ('$no_permohonan', '$username', '$jawatan', '$tujuan', '$jabatan', '$tempat_digunakan', '$nama_pengeluar', '$bil', '$no_siri', '$keterangan_aset', '$tarikh_diperlukan', '$tarikh_dijangka_pulang', '$tarikh_dipulangkan', '$tarikh_diterima', '$status_lulus', '$catatan', '$peminjam_nama', '$peminjam_jawatan', '$peminjam_tarikh', '$pelulus_nama', '$pelulus_jawatan', '$pelulus_tarikh', '$pemulang_nama', '$pemulang_jawatan', '$pemulang_tarikh', '$form_type', '$created_at')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Display success message via popup
        echo '<script type="text/javascript">
                window.location.href = "success_page.php";
              </script>';
    } else {
        // Display error message via popup
        echo '<script type="text/javascript">
                alert("Error: ' . mysqli_error($conn) . ' Please try again.");
              </script>';
    }
}

// Close the database connection
closeConnection($conn);
?>
