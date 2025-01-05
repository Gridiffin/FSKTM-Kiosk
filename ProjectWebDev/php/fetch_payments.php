<?php
// Include database connection
include 'connection.php';

// Fetch payment data from the database
$query = "SELECT * FROM payment";
$result = $conn->query($query);

if ($result) {
    $payments = [];
    while ($row = $result->fetch_assoc()) {
        $payments[] = $row;
    }
    echo json_encode($payments); // Return payment data as JSON
} else {
    echo json_encode([]); // Return an empty array if no data is found
}

// Close the database connection
$conn->close();
?>