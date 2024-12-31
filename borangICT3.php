<?php
// Start the session
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Retrieve the logged-in user's username
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KEW.PA-9</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e, #162447, #1f4068);
            color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-size: cover;
            animation: backgroundFade 5s infinite alternate;
        }

        @keyframes backgroundFade {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        h1 {
            text-align: center;
            color: #f9f9f9;
            font-size: 3rem;
            letter-spacing: 2px;
            margin-bottom: 40px;
            text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.6);
            padding-top: 20px;
            text-transform: uppercase;
        }

        .container {
            background: rgba(22, 36, 71, 0.8);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-width: 800px;
            margin-top: 30px;
            padding: 40px;
            animation: fadeIn 0.8s ease-in-out;
        }

        label {
            display: block;
            font-size: 1.1rem;
            margin-bottom: 8px;
            color: #e0e0e0;
        }

        input[type="text"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 14px;
            margin: 12px 0;
            border: 2px solid #333;
            border-radius: 8px;
            background-color: #f1f1f1;
            color: #333;
            font-size: 1rem;
            box-sizing: border-box;
            transition: border 0.3s ease, background-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        select:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
            background-color: #e9f2ff;
        }

        button {
            padding: 12px 30px;
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            font-size: 1.2rem;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            box-sizing: border-box;
            margin-top: 20px;
        }

        button:hover {
            transform: translateY(-3px);
            background: linear-gradient(45deg, #0056b3, #007bff);
        }

        button:active {
            transform: scale(0.98);
        }

        .back-button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
            font-size: 1.2rem;
            text-align: center;
            text-decoration: none;
            border-radius: 12px;
            margin-top: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .back-button:hover {
            background: linear-gradient(135deg, #218838, #28a745);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
        }

        .back-button:focus {
            outline: none;
            box-shadow: 0 0 10px 2px #28a745;
        }

        .back-button:active {
            transform: scale(0.95);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.5);
        }

        fieldset {
            border: 2px solid #007bff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.1);
        }

        legend {
            font-size: 1.2rem;
            color: #007bff;
            font-weight: bold;
            padding: 5px 10px;
            background-color: rgba(0, 123, 255, 0.1);
            border-radius: 8px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <h1>KEW.PA-9 (BORANG ICT 3)</h1>
    <div class="container">
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
    <select id="status_lulus" name="status_lulus">
        <option value="Lulus">Lulus</option>
        <option value="Gagal">Gagal</option>
    </select>

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
            </fieldset>
            <button type="submit">Submit Form</button>
        </form>
        <a href="ketuaSeksyen_dashboard.php" class="back-button">Back to Dashboard</a>
    </div>
</body>
</html>