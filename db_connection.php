<?php
// Function to open the database connection
function openConnection() {
    $host = 'localhost';      // Database host
    $username = 'root';       // Your MySQL username
    $password = '';           // Your MySQL password
    $dbname = 'formdb';       // Your database name

    // Create the connection
    $dbConnection = new mysqli($host, $username, $password, $dbname);

    // Check for connection errors
    if ($dbConnection->connect_error) {
        // Log error details for debugging purposes (you can check the error log later)
        error_log("Database connection failed: " . $dbConnection->connect_error, 0);
        return null; // Return null instead of terminating the script
    }

    return $dbConnection;
}

// Function to close the database connection
function closeConnection($dbConnection) {
    if ($dbConnection) {
        $dbConnection->close();
    }
}
?>
