<?php
session_start(); // Start the session to access user data
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borang ICT 2</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }

        .form-container {
            width: 80%;
            margin: auto;
            background: #ffffff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .form-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-header img {
            max-width: 80px;
        }

        h1, h2 {
            margin: 5px 0;
            font-size: 1.2rem;
        }

        .section {
            margin-bottom: 15px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            text-decoration: underline;
        }

        .input-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 15px;
        }

        .input-group label {
            font-size: 0.95rem;
            margin-bottom: 5px;
            display: block;
        }

        .input-group input,
        .input-group textarea {
            width: calc(100% - 10px);
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.95rem;
        }

        .checkbox-group,
        .radio-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form action="form2_submit.php" method="POST">
        <div class="section">
            <label class="section-title" for="sistem">1. SISTEM</label>
            <div class="input-group">
                <input type="text" id="sistem" name="sistem" required placeholder="Laman Utama / Pengenalan / Perkhidmatan / Direktori / Lain-lain (Nyatakan)">
            </div>
        </div>
    
        <div class="section">
            <label class="section-title">2. JENIS PERMINTAAN</label>
            <div class="checkbox-group">
                <label><input type="checkbox" name="jenis_permintaan[]" value="create"> Maklumat Baharu (Create)</label>
                <label><input type="checkbox" name="jenis_permintaan[]" value="update"> Kemaskini (Update)</label>
                <label><input type="checkbox" name="jenis_permintaan[]" value="upload"> Iklan (Upload)</label>
            </div>
        </div>
    
        <div class="section">
            <label class="section-title">3. KEUTAMAAN</label>
            <div class="radio-group">
                <label><input type="radio" name="keutamaan" value="sangat_penting" required> Sangat Penting</label>
                <label><input type="radio" name="keutamaan" value="penting"> Penting</label>
                <label><input type="radio" name="keutamaan" value="biasa"> Biasa</label>
            </div>
        </div>

        <div class="section">
            <label class="section-title">4. TARIKH</label>
            <div class="input-group">
                <label for="tarikh_mula">Mula</label>
                <input type="date" id="tarikh_mula" name="tarikh_mula" required>
                <label for="tarikh_hingga">Hingga</label>
                <input type="date" id="tarikh_hingga" name="tarikh_hingga">
            </div>
        </div>
    
        <div class="section">
            <label class="section-title">5. KETERANGAN PERMOHONAN</label>
            <textarea name="keterangan_permohonan" rows="5" required placeholder="Sila sertakan 'softcopy' atau dokumen sokongan (jika ada)."></textarea>
        </div>

        <div class="section">
            <label class="section-title">6. DIPOHON OLEH KETUA UNIT / SEKSYEN</label>
            <div class="input-group">
                <label for="nama_pemohon">Nama Pemohon</label>
                <!-- Automatically filled in using the session username -->
                <input type="text" id="nama_pemohon" name="nama_pemohon" 
                       value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>" 
                       readonly>
                <label for="bahagian">Bahagian / Seksyen / Unit</label>
                <input type="text" id="bahagian" name="bahagian" required>
                <label for="tarikh_pemohon">Tarikh</label>
                <input type="date" id="tarikh_pemohon" name="tarikh_pemohon" required>
            </div>
        </div>
    
        <div class="buttons">
            <button type="submit">Submit</button>
            <a href="ketuaSeksyen_dashboard.html">Go Back to Dashboard</a>
        </div>
    </form>
</body>
</html>
