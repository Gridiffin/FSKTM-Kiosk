<?php
session_start(); // Start the session
include 'connection.php'; // Include database connection

// Get the email from the session or query parameter
$email = isset($_GET['email']) ? mysqli_real_escape_string($conn, $_GET['email']) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $name = mysqli_real_escape_string($conn, $data['name'] ?? '');
    $newEmail = mysqli_real_escape_string($conn, $data['email'] ?? '');
    $password = $data['password'] ?? '';

    // Validate email
    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
        exit;
    }

    // Check if the new email already exists (excluding the current user)
    $checkEmailQuery = "SELECT memberEmail FROM member WHERE memberEmail = ? AND memberEmail != ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("ss", $newEmail, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already exists.']);
        exit;
    }

    // Prepare the update query
    if (!empty($password)) {
        // If password is provided, hash it and update all fields
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE member SET memberName = ?, memberEmail = ?, memberPswd = ? WHERE memberEmail = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $name, $newEmail, $hashedPassword, $email);
    } else {
        // If password is not provided, update only name and email
        $query = "UPDATE member SET memberName = ?, memberEmail = ? WHERE memberEmail = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $name, $newEmail, $email);
    }

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Profile updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update profile.']);
    }

    $stmt->close();
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

// Close the database connection
$conn->close();
?>