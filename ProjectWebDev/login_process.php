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

    // Check if the email exists in the admin table
    $adminQuery = "SELECT adminID, adminName, adminEmail, adminPswd FROM Admin WHERE adminEmail = ?";
    $stmt = $conn->prepare($adminQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $adminResult = $stmt->get_result();

    if ($adminResult->num_rows > 0) {
        // Email exists in the admin table
        $row = $adminResult->fetch_assoc();
        $adminPassword = $row['adminPswd']; // Plaintext password from the admin table

        // Verify the password (plaintext comparison)
        if ($password === $adminPassword) {
            // Password is correct (Admin)
            $_SESSION['user_id'] = $row['adminID']; // Store admin ID in the session
            $_SESSION['name'] = $row['adminName']; // Store admin name in the session
            $_SESSION['email'] = $row['adminEmail']; // Store admin email in the session
            $_SESSION['role'] = 'admin'; // Store admin role in the session

            echo "Welcome Admin! Redirecting to the admin dashboard...";
            sleep(2); // Delay for 2 seconds
            header('Location: /admin.html'); // Redirect to admin dashboard
            exit;
        } else {
            // Password is incorrect
            error_log("Login failed for admin email: $email - Incorrect password");
            header('Location: /login.html?error=invalid_credentials');
            exit;
        }
    }

    // If not an admin, check if the email exists in the member table
    $memberQuery = "SELECT memberID, memberName, memberEmail, memberPswd FROM member WHERE memberEmail = ?";
    $stmt = $conn->prepare($memberQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $memberResult = $stmt->get_result();

    if ($memberResult->num_rows > 0) {
        // Email exists in the member table
        $row = $memberResult->fetch_assoc();
        $hashedPassword = $row['memberPswd']; // Hashed password from the member table

        // Verify the password (hashed comparison)
        if (password_verify($password, $hashedPassword)) {
            // Password is correct (Member)
            $_SESSION['user_id'] = $row['memberID']; // Store member ID in the session
            $_SESSION['name'] = $row['memberName']; // Store member name in the session
            $_SESSION['email'] = $row['memberEmail']; // Store member email in the session
            $_SESSION['role'] = 'member'; // Store member role in the session

            echo "Welcome back, member! Redirecting to your dashboard...";
            sleep(2); // Delay for 2 seconds
            header('Location: /index.html'); // Redirect to member dashboard
            exit;
        } else {
            // Password is incorrect
            error_log("Login failed for member email: $email - Incorrect password");
            header('Location: /login.html?error=invalid_credentials');
            exit;
        }
    }

    // If email is not found in either table
    error_log("Login failed for email: $email - User not found");
    header('Location: /login.html?error=invalid_credentials');
    exit;

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // Invalid request method
    header('Location: /login.html?error=invalid_request');
    exit;
}
?>