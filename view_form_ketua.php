<?php
session_start();

// Database connection (replace with your actual connection details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "formdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get form type and ID from query parameters
$formType = isset($_GET['form_type']) ? $_GET['form_type'] : null;
$formId = isset($_GET['id']) ? $_GET['id'] : null;

if (!$formType || !$formId) {
    echo "Invalid form type or form ID.";
    exit();
}

// Map form types to their respective table names
$tableMap = [
    'Form 1' => 'borang_ict1',
    'Form 2' => 'borang_ict2',
    'Form 3' => 'borang_ict3',
];

if (!isset($tableMap[$formType])) {
    echo "Invalid form type.";
    exit();
}

$tableName = $tableMap[$formType];

// Fetch all data for the selected form
$sql = "SELECT * FROM $tableName WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $formId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No data found for the selected form.";
    exit();
}

$formData = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Details - <?php echo htmlspecialchars($formType); ?></title>
    <style>
        /* General Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1b1e31, #0d111b); /* Deep navy gradient */
            color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: rgba(20, 30, 48, 0.95);
            border-radius: 15px;
            padding: 40px;
            max-width: 900px;
            width: 90%;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        h1 {
            font-size: 2.5rem;
            color: #00ffff;
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            font-size: 1.1rem;
        }
        th {
            background-color: #102542; /* Dark blue */
            color: #ffffff;
            text-transform: uppercase;
        }
        td {
            background-color: rgba(20, 30, 48, 0.9); /* Dark background for table */
            color: #ffffff;
        }
        td, th {
            border: 1px solid #1f4068; /* Dark blue border */
        }
        .back-btn {
            background: linear-gradient(135deg, #28a745, #218838);
            color: #ffffff;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: bold;
            margin-top: 20px;
            display: inline-block;
            transition: background-color 0.2s ease;
        }
        .back-btn:hover {
            background: #218838;
        }
        .print-btn {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #ffffff;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: bold;
            margin-top: 20px;
            display: inline-block;
            transition: background-color 0.2s ease;
        }
        .print-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Form Details - <?php echo htmlspecialchars($formType); ?></h1>

        <!-- Form Details Table -->
        <table>
            <tbody>
                <?php foreach ($formData as $key => $value): ?>
                    <tr>
                        <th><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $key))); ?></th>
                        <td><?php echo htmlspecialchars($value); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Buttons -->
        <a href="recently_submitted_forms.php" class="back-btn">Back to Recent Forms</a>
        <a href="javascript:window.print()" class="print-btn">Print this Form</a>
    </div>

    <script>
        // Print functionality
        function printForm() {
            window.print();
        }
    </script>
</body>
</html>
