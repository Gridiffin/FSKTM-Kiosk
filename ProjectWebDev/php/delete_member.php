<?php
// Include database connection
include 'connection.php';

// Get memberID from the query string
$memberID = $_GET['memberID'];

// Delete the member from the database
$query = "DELETE FROM member WHERE memberID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $memberID);

if ($stmt->execute()) {
    echo "Member deleted successfully.";
} else {
    echo "Error deleting member.";
}

// Close the database connection
$stmt->close();
$conn->close();
?>