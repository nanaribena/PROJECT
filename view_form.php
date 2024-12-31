<?php
// Database connection class
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "formdb";
    private $connection;

    public function connect() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->connection->connect_error) {
            die("Database connection failed: " . $this->connection->connect_error);
        }
        return $this->connection;
    }

    public function disconnect() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

// Initialize database connection
$db = new Database();
$conn = $db->connect();

// Check if the 'id' and 'form_type' parameters are provided
if (isset($_GET['id']) && isset($_GET['form_type'])) {
    $formId = intval($_GET['id']); // Sanitize ID
    $formType = htmlspecialchars($_GET['form_type']); // Sanitize form type

    // Set the table name based on form type
    $table = '';
    if ($formType === 'borang_ict1') {
        $table = 'borang_ict1';
    } elseif ($formType === 'borang_ict2') {
        $table = 'borang_ict2';
    } elseif ($formType === 'borang_ict3') {
        $table = 'borang_ict3';
    } else {
        echo "Invalid form type.";
        $db->disconnect();
        exit;
    }

    // Fetch column names dynamically
    $columnsQuery = "SHOW COLUMNS FROM $table";
    $columnsResult = $conn->query($columnsQuery);
    if (!$columnsResult || $columnsResult->num_rows === 0) {
        echo "Failed to fetch columns for table: $table";
        $db->disconnect();
        exit;
    }

    // Store column names
    $columns = [];
    while ($column = $columnsResult->fetch_assoc()) {
        $columns[] = $column['Field'];
    }

    // Fetch form details based on the ID
    $query = "SELECT * FROM $table WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo "Failed to prepare the query.";
        $db->disconnect();
        exit;
    }
    $stmt->bind_param("i", $formId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the form exists
    if ($result->num_rows > 0) {
        $formDetails = $result->fetch_assoc();
    } else {
        echo "Form not found.";
        $db->disconnect();
        exit;
    }
} else {
    echo "Invalid request. No form ID or form type provided.";
    $db->disconnect();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Form Details</title>
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #020c1b, #0b1d3f); /* Dark blue gradient */
            color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            min-height: 100vh; /* Full viewport height */
            flex-direction: column;
        }

        @keyframes gradientAnimation {
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Header Style */
        h1 {
            font-size: 3rem; /* Larger font for title */
            color: #00ffff; /* Bright cyan for title */
            letter-spacing: 3px;
            margin-top: 30px;
            text-shadow: 2px 2px 5px rgba(0, 255, 255, 0.3); /* Soft shadow for the title */
            text-align: center;
        }

        main {
            background: rgba(20, 30, 48, 0.95);
            border-radius: 15px;
            padding: 40px;
            max-width: 600px;
            width: 90%;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.5);
            margin-top: 30px;
            text-align: left; /* Left-align text for form */
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        h1, h2 {
            font-size: 28px;
            margin-bottom: 25px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.4);
        }

        table th, table td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 2px solid #444;
            font-size: 16px;
        }

        table th {
            background-color: #2d2d4e;
            color: #fff;
            text-transform: uppercase;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #333;
        }

        table tr:hover {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease-in-out;
            transform: scale(1.03);
        }

        table td {
            color: #ddd;
        }

        .status-btn, .back-btn {
            display: inline-block;
            padding: 12px 25px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-right: 15px;
            margin-top: 30px;
            text-align: center;
            font-size: 18px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .status-btn {
            background-color: #4CAF50;
        }

        .back-btn {
            background-color: #555;
        }

        .status-btn:hover {
            background-color: #45a049;
            transform: scale(1.05);
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.5);
        }

        .back-btn:hover {
            background-color: #444;
            transform: scale(1.05);
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>

    <header>
        <h1>View Form Details</h1>
    </header>

    <main>
        <h2>Form ID: <?php echo htmlspecialchars($formDetails['id']); ?></h2>

        <table>
            <?php foreach ($columns as $column): ?>
                <tr>
                    <th><?php echo ucwords(str_replace('_', ' ', $column)); ?></th>
                    <td><?php echo htmlspecialchars($formDetails[$column]); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Button to go to the update form status page -->
        <a href="update_form_status.html?id=<?php echo $formDetails['id']; ?>&form_type=<?php echo $formType; ?>" class="status-btn">Update Status</a>

        <!-- Button to go back to the manage forms page -->
        <a href="manage_forms.html" class="back-btn">Go Back to Manage Forms</a>
    </main>

</body>
</html>

<?php
// Close the database connection
$db->disconnect();
?>
