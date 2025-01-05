<?php
session_start(); // Start the session

// Check if the session email is set
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $data = ['email' => $email];
} else {
    $data = ['errorMessage' => 'No email provided in session.'];
}

// Output data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>