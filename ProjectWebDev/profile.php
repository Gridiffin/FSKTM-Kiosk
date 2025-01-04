<?php
session_start(); // Start the session
include 'connection.php'; // Include database connection

// Get the email from the session
$email = isset($_SESSION['email']) ? $_SESSION['email'] : null;

if ($email) {
    // Fetch user data from the database
    $query = "SELECT memberID, memberName, memberEmail FROM member WHERE memberEmail = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc(); // Fetch user data
    } else {
        $errorMessage = "User not found.";
    }

    $stmt->close();
} else {
    $errorMessage = "No email provided.";
}

$conn->close();

// Pass data to the frontend (profile.html)
$data = [
    'userData' => $userData ?? null,
    'errorMessage' => $errorMessage ?? null
];

// Output data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>