<?php
// Database connection settings
$host = 'localhost'; // Hostname
$username = 'root';  // Database username
$password = '';      // Database password
$dbname = 'formdb';  // Database name

// Global connection variable
$conn = null;

// Open connection
function openConnection() {
    global $conn;

    // Check if connection is already established
    if ($conn === null) {
        $conn = new mysqli($GLOBALS['host'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    }

    return $conn;
}

// Close connection
function closeConnection() {
    global $conn;

    if ($conn !== null) {
        $conn->close();
        $conn = null;
    }
}

// Example function to fetch users
function fetchUsers() {
    $conn = openConnection();

    $query = "SELECT id, username, full_email, user_role, created_at, no_tel FROM login_users ORDER BY id ASC";

    // Prepare the statement
    if ($stmt = $conn->prepare($query)) {
        $stmt->execute(); // Execute the query
        
        $result = $stmt->get_result(); // Get the result of the query
        $users = [];

        // Fetch all the users
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        $stmt->close(); // Close the statement
        closeConnection(); // Close the connection

        return $users;
    } else {
        // Handle errors
        die("Error preparing statement: " . $conn->error);
    }
}

// Example function to insert a new user
function insertUser($email, $username, $password, $no_tel, $user_role) {
    $conn = openConnection();

    $query = "INSERT INTO login_users (full_email, username, password, no_tel, user_role) VALUES (?, ?, ?, ?, ?)";

    // Prepare the statement
    if ($stmt = $conn->prepare($query)) {
        // Bind parameters for the query
        $stmt->bind_param('sssss', $email, $username, $password, $no_tel, $user_role);
        
        // Execute the query
        $stmt->execute();
        
        $stmt->close(); // Close the statement
        closeConnection(); // Close the connection
    } else {
        // Handle errors
        die("Error preparing statement: " . $conn->error);
    }
}
?>
