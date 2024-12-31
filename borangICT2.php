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

        /* Smooth Background Animation */
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

        /* Enhanced Form Container */
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

        /* Form Elements */
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

        input[type="radio"],
        input[type="checkbox"] {
            width: auto;
            display: inline-block;
            margin-right: 10px;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        select:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
            background-color: #e9f2ff;
        }

        /* Button Styling */
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

        /* Form Section Header */
        .form-section {
            margin-bottom: 20px;
        }

        /* Improved Animations */
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

        /* Responsive Design for Smaller Screens */
        @media screen and (max-width: 600px) {
            body {
                padding: 20px;
            }

            .container {
                padding: 30px 20px;
                width: 100%;
                max-width: 100%;
            }

            h1 {
                font-size: 2.5rem;
            }

            button {
                font-size: 1rem;
            }
        }

        /* Style for the 'Back to Dashboard' button */
        .back-button {
            background: linear-gradient(45deg, #28a745, #218838);
            margin-top: 15px;
            width: 100%;
        }

        /* Hover Effect for Back Button */
        .back-button:hover {
            background: linear-gradient(45deg, #218838, #28a745);
        }

        /* Fieldset Styling */
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
    </style>
</head>
<body>
    <h1>ICT Form 2: BORANG PERMOHONAN PINDAAN MAKLUMAT LAMAN WEB</h1>
    <div class="container">
        <form action="form2_submit.php" method="POST">
            <!-- Fieldset for Sistem -->
            <fieldset>
                <legend>Sistem</legend>
                <label><input type="checkbox" name="sistem[]" value="Laman Utama"> Laman Utama</label>
                <label><input type="checkbox" name="sistem[]" value="Pengenalan"> Pengenalan</label>
                <label><input type="checkbox" name="sistem[]" value="Perkhidmatan"> Perkhidmatan</label>
                <label><input type="checkbox" name="sistem[]" value="Direktori"> Direktori</label>
                <label><input type="checkbox" name="sistem[]" value="Internet"> Internet</label>
                <label><input type="checkbox" name="sistem[]" value="Lain-lain"> Lain-lain</label>
                <br>
                <label for="sistem_other">If Other, please specify:</label>
                <input type="text" id="sistem_other" name="sistem_other">
            </fieldset>
    
            <!-- Fieldset for Jenis Permintaan -->
            <fieldset>
                <legend>Jenis Permintaan</legend>
                <label><input type="checkbox" name="jenis_permintaan[]" value="create"> Maklumat Baharu (Create)</label>
                <label><input type="checkbox" name="jenis_permintaan[]" value="update"> Kemaskini (Update)</label>
                <label><input type="checkbox" name="jenis_permintaan[]" value="upload"> Iklan (Upload)</label>
            </fieldset>
    
            <!-- Fieldset for Keutamaan -->
            <fieldset>
                <legend>Keutamaan</legend>
                <label><input type="radio" name="keutamaan" value="sangat_penting" required> Sangat Penting</label>
                <label><input type="radio" name="keutamaan" value="penting"> Penting</label>
                <label><input type="radio" name="keutamaan" value="biasa"> Biasa</label>
            </fieldset>

            <!-- Fieldset for Tarikh -->
            <fieldset>
                <legend>Tarikh</legend>
                <label for="tarikh_mula">Mula</label>
                <input type="date" id="tarikh_mula" name="tarikh_mula" required>
                <label for="tarikh_hingga">Hingga</label>
                <input type="date" id="tarikh_hingga" name="tarikh_hingga">
            </fieldset>
    
            <!-- Fieldset for Keterangan Permohonan -->
            <fieldset>
                <legend>Keterangan Permohonan</legend>
                <textarea name="keterangan_permohonan" rows="5" required placeholder="Sila sertakan 'softcopy' atau dokumen sokongan (jika ada)."></textarea>
            </fieldset>

            <!-- Fieldset for Ketua Unit / Seksyen -->
            <fieldset>
                <legend>Dipohon Oleh Ketua Unit / Seksyen</legend>
                <label for="username">Nama Pemohon</label>
                <!-- Automatically filled in using the session username -->
                <input type="text" id="username" name="username" 
                       value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>" 
                       readonly>
                <label for="bahagian">Bahagian / Seksyen / Unit</label>
                <input type="text" id="bahagian" name="bahagian" required>
                <label for="tarikh_pemohon">Tarikh</label>
                <input type="date" id="tarikh_pemohon" name="tarikh_pemohon" required>
            </fieldset>
    
            <!-- Hidden field for tarikh_diperlukan -->
            <input type="hidden" id="tarikh_diperlukan" name="tarikh_diperlukan">

            <button type="submit">Submit</button>
            <!-- Back to Dashboard Button -->
            <a href="ketuaSeksyen_dashboard.php" style="text-decoration: none;">
                <button type="button" class="back-button">Back to Dashboard</button>
            </a>
        </form>
    </div>

    <script>
        // JavaScript to copy the value of tarikh_mula to tarikh_diperlukan when the form is submitted
        document.querySelector('form').onsubmit = function() {
            var tarikhMula = document.getElementById('tarikh_mula').value;
            document.getElementById('tarikh_diperlukan').value = tarikhMula;
        };
    </script>
</body>
</html>
