<?php
// Include database connection
include 'connection.php';

// Fetch members from the database
$query = "SELECT memberID, memberName, memberEmail, is_verified FROM member";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $members = [];
    while ($row = $result->fetch_assoc()) {
        $members[] = $row;
    }
    // Return members as JSON
    echo json_encode($members);
} else {
    // No members found
    echo json_encode([]);
}

// Close the database connection
$conn->close();
?>