<?php
session_start(); // Start the session
include 'connection.php'; // Include database connection

// Get the email from the session
$email = isset($_SESSION['email']) ? $_SESSION['email'] : null;

if ($email) {
    // Fetch admin data from the database
    $query = "SELECT adminID, adminName, adminEmail, role FROM admin WHERE adminEmail = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $adminData = $result->fetch_assoc(); // Fetch admin data
    } else {
        $errorMessage = "Admin not found.";
    }

    $stmt->close();
} else {
    $errorMessage = "No email provided.";
}

$conn->close();

// Pass data to the frontend (admin_profile.html)
$data = [
    'adminData' => $adminData ?? null,
    'errorMessage' => $errorMessage ?? null
];

// Output data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>