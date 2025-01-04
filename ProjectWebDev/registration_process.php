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
        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);

        // Store the OTP in the database temporarily
        $insertQuery = "INSERT INTO member (memberName, memberEmail, memberPswd, otp) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssss", $fullname, $email, $hashedPassword, $otp);

        if ($stmt->execute()) {
            // Send OTP via email
            $subject = "Your OTP for Registration";
            $message = "Your OTP for registration is: $otp";
            $headers = "From: no-reply@yourwebsite.com";

            if (mail($email, $subject, $message, $headers)) {
                $successMessage = "Registration successful. Please check your email for the OTP to verify your account.";
            } else {
                $errorMessage = "Error sending OTP. Please try again.";
            }
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header>
        <!-- Logo Container -->
        <div id="logo-container">
            <a href="./index.html" id="logo-link">
                <img src="./assets/images/fsktm_logo.png" alt="Website Logo" id="logo">
            </a>
        </div>

        <!-- Centered Text -->
        <div id="header-center-text">
            <h1>FSKTM Kiosk</h1>
        </div>

        <!-- Grouped Navigation Links and Dark Mode Button -->
        <div id="nav-and-dark-mode-container">
            <!-- Home Button (Icon) -->
            <a href="./index.html" id="home-btn" class="icon-btn">
                <i class="fas fa-home"></i>
            </a>

            <!-- Dark Mode Toggle Icon -->
            <button id="dark-mode-btn" class="icon-btn">
                <i id="dark-mode-icon" class="fas fa-moon"></i>
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Registration Container -->
        <div class="registration-container">
            <p id="head1">WELCOME</p>
            <h1 id="head2">NEW MEMBER</h1>

            <?php if (isset($successMessage)): ?>
                <div class="success-message">
                    <?php echo $successMessage; ?>
                </div>
                <p>Please check your email for the OTP and <a href="verify_otp.html">click here</a> to verify your account.</p>
            <?php elseif (isset($errorMessage)): ?>
                <div class="error-message">
                    <?php echo $errorMessage; ?>
                </div>
            <?php else: ?>
                <form action="./registration_process.php" method="POST">
                    <div class="form-group">
                        <label for="fullname">Full Name:</label>
                        <input type="text" id="fullname" name="fullname" placeholder="Your Full Name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" 
                               placeholder="6-8 characters with uppercase, number, special character" required>
                    </div>
                    <div class="form-actions">
                        <input type="submit" value="Register" class="btn-register">
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer Section -->
    <footer id="footer">
        <div class="footer-content">
            <p>&copy; 2024 FSKTM Kiosk. All Rights Reserved. | <a href="./contact.html">Contact Us</a></p>
            <div class="social-media">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="./assets/js/registration.js"></script>
</body>
</html>