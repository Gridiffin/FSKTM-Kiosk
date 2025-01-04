<?php
// Include database connection
include 'connection.php';

// Get the email from the query parameter
$email = isset($_GET['email']) ? mysqli_real_escape_string($conn, $_GET['email']) : null;

if ($email) {
    // Fetch user data from the database
    $query = "SELECT memberName, memberEmail FROM member WHERE memberEmail = ?";
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