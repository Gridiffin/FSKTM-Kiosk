<?php
include 'connection.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and collect form input
    $fullname = mysqli_real_escape_string($conn, $_POST['memberName']);
    $email = mysqli_real_escape_string($conn, $_POST['memberEmail']);
    $password = mysqli_real_escape_string($conn, $_POST['memberPswd']);

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if the email already exists in the database
    $checkEmailQuery = "SELECT * FROM member WHERE email = '$memberEmail'";
    $result = $conn->query($checkEmailQuery);

    if ($result->num_rows > 0) {
        // Email already exists
        echo "This email is already registered. Please <a href='login.html'>log in</a>.";
    } else {
        // Insert new user into the database
        $insertQuery = "INSERT INTO member (memberName, memberEmail, memberpswd) VALUES ('$Name', '$email', '$hashedPassword')";

        if ($conn->query($insertQuery) === TRUE) {
            echo "Registration successful. You can now <a href='login.html'>log in</a>.";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    // Close the database connection
    closeConnection($conn);
} else {
    // Redirect to the registration form if the request method is not POST
    header('Location: registration.html');
    exit;
}
?>
