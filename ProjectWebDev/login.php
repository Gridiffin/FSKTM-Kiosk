<?php
// Simulated database
$users = [
    ['email' => 'admin@example.com', 'password' => 'adminpass', 'role' => 'admin'],
    ['email' => 'user1@example.com', 'password' => 'userpass1', 'role' => 'user'],
    ['email' => 'user2@example.com', 'password' => 'userpass2', 'role' => 'user']
];
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['psswrd'] ?? '';
    $foundUser = null;

    foreach ($users as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            $foundUser = $user;
            break;
        }
    }

    if ($foundUser) {
        if ($foundUser['role'] === 'admin') {
            echo "Welcome Admin! Redirecting to the admin dashboard...";
            // Replace with actual redirection
            header('Location: /admin_dashboard.php');
        } else {
            echo "Welcome back, user! Redirecting to your dashboard...";
            // Replace with actual redirection
            header('Location: /user_dashboard.php');
        }
        exit;
    } else {
        echo "Invalid email or password. Please try again.";
    }
} else {
    echo "Invalid request method.";
}
?>
