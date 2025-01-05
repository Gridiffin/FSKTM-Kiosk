<?php
session_start();

// Check if the user is logged in by checking the session
$loggedIn = isset($_SESSION['email']);

// Return JSON response
header('Content-Type: application/json');
echo json_encode(['loggedIn' => $loggedIn]);
?>