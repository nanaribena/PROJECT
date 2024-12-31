<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'DefaultUsername'; // Replace with actual logic if needed.
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borang ICT1</title>
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
    <h1>ICT Form 1: Equipment Request & Maintenance</h1>
    <form action="form1_submit.php" method="POST">
        <fieldset>
            <legend>Tarikh Diperlukan</legend>
            <div class="form-section">
                <label for="tarikh_diperlukan">Tarikh Diperlukan:</label>
                <input type="date" id="tarikh_diperlukan" name="tarikh_diperlukan" required>
            </div>
        </fieldset>

        <fieldset>
            <legend>Hari</legend>
            <div class="form-section">
                <label for="hari">Hari:</label>
                <input type="text" id="hari" name="hari" required>
            </div>
        </fieldset>

        <fieldset>
            <legend>Perkakasan</legend>
            <div class="form-section">
                <label>Perkakasan:</label>
                <input type="checkbox" name="perkakasan[]" value="Laptop"> Laptop
                <input type="checkbox" name="perkakasan[]" value="Printer"> Printer
                <input type="checkbox" name="perkakasan[]" value="Scanner"> Scanner
                <input type="checkbox" name="perkakasan[]" value="Other"> Other<br>
                <label for="other_answer">If Other, please specify:</label>
                <input type="text" id="other_answer" name="other_answer">
            </div>
        </fieldset>

        <fieldset>
            <legend>Username</legend>
            <div class="form-section">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" readonly>
            </div>        
        </fieldset>

        <fieldset>
            <legend>Jenis Permintaan</legend>
            <div class="form-section">
                <label>Jenis Permintaan:</label>
                <input type="checkbox" name="jenis_permintaan[]" value="Repair"> Repair
                <input type="checkbox" name="jenis_permintaan[]" value="Replacement"> Replacement
                <input type="checkbox" name="jenis_permintaan[]" value="New"> New
            </div>
        </fieldset>

        <fieldset>
            <legend>Keutamaan</legend>
            <div class="form-section">
                <label>Keutamaan:</label>
                <input type="radio" name="keutamaan" value="High" required> High
                <input type="radio" name="keutamaan" value="Medium" required> Medium
                <input type="radio" name="keutamaan" value="Low" required> Low
            </div>
        </fieldset>

        <fieldset>
            <legend>Keterangan Permohonan</legend>
            <div class="form-section">
                <label for="keterangan_permohonan">Keterangan Permohonan:</label>
                <textarea id="keterangan_permohonan" name="keterangan_permohonan" required></textarea>
            </div>
        </fieldset>

        <button type="submit">Submit</button>
        <!-- Back to Dashboard Button -->
        <a href="ketuaSeksyen_dashboard.php" style="text-decoration: none;">
            <button type="button" style="background: linear-gradient(45deg, #28a745, #218838); margin-top: 15px;">Back to Dashboard</button>
        </a>
    </form>
</body>
</html>
