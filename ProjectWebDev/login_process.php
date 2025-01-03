<?php
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
            header('Location: /admin.html');
        } else {
            echo "Welcome back, member! Redirecting to your dashboard...";
            // Replace with actual redirection
            header('Location: /index.html');
        }
        exit;
    } else {
        echo "Invalid email or password. Please try again.";
    }
} else {
    echo "Invalid request method.";
}
?>
