<?php
session_start(); // Start the session

// Check if the user is logged in (member)
if (isset($_SESSION['email']) && $_SESSION['role'] === 'member') {
    // User is a member, proceed to save_receipt.php
    header('Location: save_receipt.php');
    exit;
} else {
    // User is not logged in (public user), redirect to register page
    header('Location: registration.html');
    exit;
}
?>