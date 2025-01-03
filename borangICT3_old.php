<?php
// Start the session
session_start();

// Ensure the user is logged in (if applicable)
if (!isset($_SESSION['username'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Retrieve the logged-in user's username from the session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borang ICT 3</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
        }
        .form-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .top-left {
            position: absolute;
            top: 20px;
            left: 20px;
            font-weight: bold;
            font-size: 16px;
        }
        .top-right {
            position: absolute;
            top: 20px;
            right: 20px;
            text-align: right;
        }
        .top-right .small-title {
            font-weight: bold;
            font-size: 16px;
        }
        .top-right .application-no {
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .signature-section {
            margin-top: 20px;
        }
        .signature-container {
            border: 1px solid #000;
            padding: 15px;
            margin-bottom: 15px;
        }
        .signature-container strong {
            display: block;
            margin-bottom: 10px;
        }
        .submit-button {
            text-align: center;
            margin-top: 20px;
        }
    </style>
    <link rel="stylesheet" href="styles.css"> <!-- Link your CSS file here -->
</head>
<body>
    <div class="container">
        <h1>Borang ICT 3</h1>
        <form action="form3_submit.php" method="POST">
            <!-- Section 1: General Information -->
            <fieldset>
                <legend>Maklumat Am</legend>
                <label for="no_permohonan">No Permohonan:</label>
                <input type="text" id="no_permohonan" name="no_permohonan" required>

                <!-- Nama Pengguna field automatically filled with logged-in user's username -->
                <label for="username">Nama Pengguna:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly>

                <label for="jawatan">Jawatan:</label>
                <input type="text" id="jawatan" name="jawatan" required>

                <label for="tujuan">Tujuan:</label>
                <input type="text" id="tujuan" name="tujuan">

                <label for="jabatan">Jabatan:</label>
                <input type="text" id="jabatan" name="jabatan">

                <label for="tempat_digunakan">Tempat Digunakan:</label>
                <input type="text" id="tempat_digunakan" name="tempat_digunakan">
            </fieldset>

            <!-- Section 2: Asset Details -->
            <fieldset>
                <legend>Butiran Aset</legend>
                <label for="nama_pengeluar">Nama Pengeluar:</label>
                <input type="text" id="nama_pengeluar" name="nama_pengeluar">

                <label for="bil">Bil:</label>
                <input type="number" id="bil" name="bil" min="1">

                <label for="no_siri">No Siri:</label>
                <input type="text" id="no_siri" name="no_siri">

                <label for="keterangan_aset">Keterangan Aset:</label>
                <textarea id="keterangan_aset" name="keterangan_aset"></textarea>
            </fieldset>

            <!-- Section 3: Date Details -->
            <fieldset>
                <legend>Maklumat Tarikh</legend>
                <label for="tarikh_diperlukan">Tarikh Dipinjam:</label>
                <input type="date" id="tarikh_diperlukan" name="tarikh_diperlukan">

                <label for="tarikh_dijangka_pulang">Tarikh Dijangka Pulang:</label>
                <input type="date" id="tarikh_dijangka_pulang" name="tarikh_dijangka_pulang">

                <label for="tarikh_dipulangkan">Tarikh Dipulangkan:</label>
                <input type="date" id="tarikh_dipulangkan" name="tarikh_dipulangkan">

                <label for="tarikh_diterima">Tarikh Diterima:</label>
                <input type="date" id="tarikh_diterima" name="tarikh_diterima">
            </fieldset>

            <!-- Section 4: Approval and Remarks -->
            <fieldset>
                <legend>Status & Catatan</legend>
                <label for="status_lulus">Status Lulus:</label>
                <input type="text" id="status_lulus" name="status_lulus">

                <label for="catatan">Catatan:</label>
                <textarea id="catatan" name="catatan"></textarea>
            </fieldset>

            <!-- Section 5: Signatures -->
            <fieldset>
                <legend>Tandatangan</legend>
                <h3>Peminjam</h3>
                <label for="peminjam_nama">Nama:</label>
                <input type="text" id="peminjam_nama" name="peminjam_nama">

                <label for="peminjam_jawatan">Jawatan:</label>
                <input type="text" id="peminjam_jawatan" name="peminjam_jawatan">

                <label for="peminjam_tarikh">Tarikh:</label>
                <input type="date" id="peminjam_tarikh" name="peminjam_tarikh">

                <h3>Pelulus</h3>
                <label for="pelulus_nama">Nama:</label>
                <input type="text" id="pelulus_nama" name="pelulus_nama">

                <label for="pelulus_jawatan">Jawatan:</label>
                <input type="text" id="pelulus_jawatan" name="pelulus_jawatan">

                <label for="pelulus_tarikh">Tarikh:</label>
                <input type="date" id="pelulus_tarikh" name="pelulus_tarikh">

                <h3>Pemulang</h3>
                <label for="pemulang_nama">Nama:</label>
                <input type="text" id="pemulang_nama" name="pemulang_nama">

                <label for="pemulang_jawatan">Jawatan:</label>
                <input type="text" id="pemulang_jawatan" name="pemulang_jawatan">

                <label for="pemulang_tarikh">Tarikh:</label>
                <input type="date" id="pemulang_tarikh" name="pemulang_tarikh">

                <h3>Penerima</h3>
                <label for="penerima_nama">Nama:</label>
                <input type="text" id="penerima_nama" name="penerima_nama">

                <label for="penerima_jawatan">Jawatan:</label>
                <input type="text" id="penerima_jawatan" name="penerima_jawatan">

                <label for="penerima_tarikh">Tarikh:</label>
                <input type="date" id="penerima_tarikh" name="penerima_tarikh">

                <label for="priority">Keutamaan:</label>
    <select id="priority" name="priority">
        <option value="Biasa" selected>Biasa</option>
        <option value="Penting">Penting</option>
        <option value="Sangat Penting">Sangat Penting</option>
    </select>
            </fieldset>

            <button type="submit">Hantar</button>
        </form>
    </div>
</body>
</html>
