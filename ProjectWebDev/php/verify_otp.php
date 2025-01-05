<?php
include 'connection.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = mysqli_real_escape_string($conn, $_POST['otp']);

    // Check if the OTP exists in the database
    $checkOTPQuery = "SELECT * FROM member WHERE otp = ?";
    $stmt = $conn->prepare($checkOTPQuery);
    $stmt->bind_param("s", $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // OTP is valid, update the member's status to verified
        $updateQuery = "UPDATE member SET is_verified = 1 WHERE otp = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("s", $otp);

        if ($stmt->execute()) {
            $successMessage = "OTP verification successful. Your account is now verified.";
        } else {
            $errorMessage = "Error verifying OTP. Please try again.";
        }
    } else {
        $errorMessage = "Invalid OTP. Please check your OTP and try again.";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to the OTP verification form if the request method is not POST
    header('Location: verify_otp.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - My Website</title>
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
        <!-- OTP Verification Container -->
        <div class="registration-container">
            <p id="head1">VERIFY YOUR ACCOUNT</p>
            <h1 id="head2">OTP VERIFICATION</h1>

            <?php if (isset($successMessage)): ?>
                <div class="success-message">
                    <?php echo $successMessage; ?>
                </div>
                <p>You can now <a href="login.html">log in</a> to your account.</p>
            <?php elseif (isset($errorMessage)): ?>
                <div class="error-message">
                    <?php echo $errorMessage; ?>
                </div>
                <p>Please <a href="verify_otp.html">try again</a>.</p>
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