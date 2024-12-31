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

$loggedInUser = $_SESSION['username'];

// Query to fetch recent forms from all three tables, grouped by form type
$sql = "
    (SELECT 'Form 1' AS form_type, id, tarikh_diperlukan, status
     FROM borang_ict1
     WHERE username = ? 
     ORDER BY tarikh_diperlukan DESC)
    UNION
    (SELECT 'Form 2' AS form_type, id, tarikh_diperlukan, status
     FROM borang_ict2
     WHERE username = ? 
     ORDER BY tarikh_diperlukan DESC)
    UNION
    (SELECT 'Form 3' AS form_type, id, tarikh_diperlukan, status
     FROM borang_ict3
     WHERE username = ? 
     ORDER BY tarikh_diperlukan DESC)
    LIMIT 10
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $loggedInUser, $loggedInUser, $loggedInUser);
$stmt->execute();
$result = $stmt->get_result();

// Organize the results into an associative array by form type
$formData = [
    'Form 1' => [],
    'Form 2' => [],
    'Form 3' => []
];

while ($row = $result->fetch_assoc()) {
    $formData[$row['form_type']][] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recent Forms Submitted</title>
    <style>
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
    padding: 30px;
    max-width: 1100px;
    width: 90%;
    box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.5);
    margin-top: 30px;
}

h1 {
    font-size: 2.5rem;
    color: #00ffff;
    letter-spacing: 2px;
    text-align: center;
}

.button-container {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 30px;
}

.form-button {
    background: linear-gradient(135deg, #00bcd4, #0097a7);
    color: #ffffff;
    padding: 15px 30px;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: bold;
    margin: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
}

.form-button:hover {
    background: linear-gradient(135deg, #00838f, #005662);
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.6);
}

.form-button.active-btn {
    background: linear-gradient(135deg, #ff5722, #d84315);
    transform: scale(1.05);
}

.form-section {
    display: none;
    margin-top: 20px;
    background: rgba(20, 30, 48, 0.95);
    padding: 20px;
    border-radius: 10px;
    text-align: left;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 15px;
    text-align: left;
}

th {
    background-color: #102542;
    color: #ffffff;
    text-transform: uppercase;
}

td {
    background-color: rgba(20, 30, 48, 0.9);
    color: #ffffff;
}

td, th {
    border: 1px solid #1f4068;
}

tr:hover td {
    background-color: #102542;
}

.view-btn {
    background: linear-gradient(135deg, #4caf50, #388e3c);
    color: #ffffff;
    padding: 8px 20px;
    border: none;
    border-radius: 5px;
    font-size: 0.9rem;
    font-weight: bold;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.view-btn:hover {
    background: #2e7d32;
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

/* Center the back button */
.back-btn-container {
    display: flex;
    justify-content: center;
    margin-top: 30px; /* Optional: Adjust the margin to add more space if necessary */
}
</style>
</head>
<body>
    <div class="container">
        <h1>Recent Forms Submitted</h1>
        <div class="button-container">
            <button class="form-button" id="form1-btn" onclick="toggleForm('form1')">View Form 1</button>
            <button class="form-button" id="form2-btn" onclick="toggleForm('form2')">View Form 2</button>
            <button class="form-button" id="form3-btn" onclick="toggleForm('form3')">View Form 3</button>
        </div>

        <!-- Form Sections -->
        <?php foreach ($formData as $formType => $formRows): ?>
        <div class="form-section" id="<?php echo strtolower(str_replace(' ', '', $formType)); ?>">
            <h2><?php echo htmlspecialchars($formType); ?></h2>

            <?php if (empty($formRows)): ?>
                <p>No forms submitted yet.</p>
            <?php else: ?>
                <table>
                    <tr>
                        <th>Form ID</th>
                        <th>Date Created</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php 
                    $formNumber = 1;  // Initialize form number to 1
                    foreach ($formRows as $row): 
                    ?>
                    <tr>
                        <td><?php echo $formNumber++; ?></td> <!-- Display sequential form ID -->
                        <td><?php echo htmlspecialchars($row['tarikh_diperlukan']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td>
                            <a href="view_form_ketua.php?form_type=<?php echo urlencode($formType); ?>&id=<?php echo htmlspecialchars($row['id']); ?>" class="view-btn">View</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>

        <!-- Back Button (Centered) -->
        <div class="back-btn-container">
            <a href="ketuaSeksyen_dashboard.php" class="back-btn">Back to Dashboard</a>
        </div>
    </div>

    <script>
        function toggleForm(formType) {
            const forms = document.querySelectorAll('.form-section');
            forms.forEach(form => form.style.display = 'none');
            const form = document.getElementById(formType);
            if (form) form.style.display = form.style.display === 'block' ? 'none' : 'block';
            const buttons = document.querySelectorAll('.form-button');
            buttons.forEach(button => button.classList.remove('active-btn'));
            const activeButton = document.getElementById(`${formType}-btn`);
            if (activeButton) activeButton.classList.add('active-btn');
        }
    </script>
</body>
</html>
