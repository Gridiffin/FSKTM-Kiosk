<?php
// Database connection details
$servername = "srv1760.hstgr.io";
$username = "u455195652_fsktmkiosk"; // Update with your database username
$password = "Webdev2024"; // Update with your database password
$dbname = "u455195652_FSKTMkiosk"; // Update with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to close the connection when not needed
function closeConnection($conn) {
    $conn->close();
}
?>
