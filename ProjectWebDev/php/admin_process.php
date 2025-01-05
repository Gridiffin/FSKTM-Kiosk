<?php
// Include database connection
include 'connection.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $action = $_POST['action'] ?? ''; // 'add' or 'edit'
    $prodID = $_POST['prodID'] ?? null; // Only for edit action
    $prodName = $_POST['prodName'] ?? '';
    $prodPrice = $_POST['prodPrice'] ?? '';
    $prodType = $_POST['prodType'] ?? '';
    $amount = $_POST['amount'] ?? 0; // Get the amount

    // Validate input
    if (empty($prodName) || empty($prodPrice) || empty($prodType) || empty($amount)) {
        echo "All fields are required.";
        exit;
    }

    // Convert price to a number
    $prodPrice = (float)$prodPrice;

    // Handle file upload
    if (isset($_FILES['prodPic']) && $_FILES['prodPic']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/images/'; // Directory to store uploaded images
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
        }

        $fileName = basename($_FILES['prodPic']['name']);
        $uploadFilePath = $uploadDir . $fileName;

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($_FILES['prodPic']['tmp_name'], $uploadFilePath)) {
            $prodPic = $uploadFilePath; // Save the file path in the database
        } else {
            echo "Error uploading file.";
            exit;
        }
    } else {
        echo "No file uploaded or file upload error.";
        exit;
    }

    if ($action === 'add') {
        // Add new product
        $query = "INSERT INTO product (prodName, prodPrice, prodPic, prodType, amount) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sdssi", $prodName, $prodPrice, $prodPic, $prodType, $amount); // Include amount

        if ($stmt->execute()) {
            echo "Product added successfully!";
        } else {
            echo "Error adding product: " . $stmt->error;
        }
    } elseif ($action === 'edit' && $prodID) {
        // Edit existing product
        $query = "UPDATE product SET prodName = ?, prodPrice = ?, prodPic = ?, prodType = ?, amount = ? WHERE prodID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sdssii", $prodName, $prodPrice, $prodPic, $prodType, $amount, $prodID); // Include amount

        if ($stmt->execute()) {
            echo "Product updated successfully!";
        } else {
            echo "Error updating product: " . $stmt->error;
        }
    } else {
        echo "Invalid action or product ID.";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>