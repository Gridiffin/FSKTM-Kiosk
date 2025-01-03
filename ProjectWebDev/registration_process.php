<?php
include 'connection.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and collect form input
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if the email already exists in the database
    $checkEmailQuery = "SELECT * FROM member WHERE memberEmail = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already exists
        $errorMessage = "This email is already registered. Please <a href='login.html'>log in</a>.";
    } else {
        // Insert new user into the database
        $insertQuery = "INSERT INTO member (memberName, memberEmail, memberPswd) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sss", $fullname, $email, $hashedPassword);

        if ($stmt->execute()) {
            $successMessage = "Registration successful. You can now <a href='login.html'>log in</a>.";
        } else {
            $errorMessage = "Error: " . $stmt->error;
        }
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to the registration form if the request method is not POST
    header('Location: registration.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - My Website</title>
    <link rel="stylesheet" href="./assets/css/stylesregistration.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div id="logo-container">
            <a href="./index.html" id="logo-link">
                <img src="./assets/images/fsktm_logo.png" alt="Website Logo" id="logo">
            </a>
        </div>
        <div id="header-center-text">
            <h1>FSKTM Kiosk</h1>
        </div>
        <div id="nav-and-dark-mode-container">
            <nav id="nav-links">
                <a href="./index.html" class="nav-link">Home</a>
                <a href="./login.html" class="nav-link">Login</a>
                <a href="./purchase.html" class="nav-link">Purchase</a>
            </nav>
            <button id="dark-mode-btn">
                <i id="dark-mode-icon" class="fas fa-moon"></i>
            </button>
        </div>
    </header>

    <main>
        <p id="head1">WELCOME</p>
        <h1 id="head2">REGISTER YOUR ACCOUNT</h1>

        <?php if (isset($successMessage)): ?>
            <div class="success-message">
                <?php echo $successMessage; ?>
            </div>
        <?php elseif (isset($errorMessage)): ?>
            <div class="error-message">
                <?php echo $errorMessage; ?>
            </div>
        <?php else: ?>
            <form action="./registration_process.php" method="POST">
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" placeholder="Your Full Name" required><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Your Email" required><br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" 
                       placeholder="6-8 characters with uppercase, number, special character" required>
                <input type="submit" value="Register">
            </form>
        <?php endif; ?>
    </main>
</body>
</html>