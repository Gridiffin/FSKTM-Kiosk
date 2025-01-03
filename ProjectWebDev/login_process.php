<?php
session_start(); // Start the session
include 'connection.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['psswrd'] ?? '';

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: /login.html?error=invalid_email');
        exit;
    }

    // Check for empty fields
    if (empty($email) || empty($password)) {
        header('Location: /login.html?error=empty_fields');
        exit;
    }

    // Retrieve the user's hashed password from the database
    $query = "SELECT memberPswd FROM member WHERE memberEmail = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['memberPswd']; // Hashed password from the database

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct
            $_SESSION['email'] = $email; // Store user email in the session

            echo "Welcome back! Redirecting to your dashboard...";
            sleep(2); // Delay for 2 seconds
            header('Location: /index.html'); // Redirect to the dashboard
            exit;
        } else {
            // Password is incorrect
            error_log("Login failed for email: $email - Incorrect password");
            header('Location: /login.html?error=invalid_credentials');
            exit;
        }
    } else {
        // User not found
        error_log("Login failed for email: $email - User not found");
        header('Location: /login.html?error=invalid_credentials');
        exit;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // Invalid request method
    header('Location: /login.html?error=invalid_request');
    exit;
}
?>