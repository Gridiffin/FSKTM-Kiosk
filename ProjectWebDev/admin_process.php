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
    $prodPic = $_POST['prodPic'] ?? '';
    $prodType = $_POST['prodType'] ?? '';

    // Validate input
    if (empty($prodName) || empty($prodPrice) || empty($prodPic) || empty($prodType)) {
        echo "All fields are required.";
        exit;
    }

    // Convert price to a number
    $prodPrice = (float)$prodPrice;

    if ($action === 'add') {
        // Add new product
        $query = "INSERT INTO product (prodName, prodPrice, prodPic, prodType) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sdss", $prodName, $prodPrice, $prodPic, $prodType);

        if ($stmt->execute()) {
            echo "Product added successfully!";
        } else {
            echo "Error adding product: " . $stmt->error;
        }
    } elseif ($action === 'edit' && $prodID) {
        // Edit existing product
        $query = "UPDATE product SET prodName = ?, prodPrice = ?, prodPic = ?, prodType = ? WHERE prodID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sdssi", $prodName, $prodPrice, $prodPic, $prodType, $prodID);

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