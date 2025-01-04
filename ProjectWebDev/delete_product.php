<?php
// Include database connection
include 'connection.php';

// Get product ID from the query string
$prodID = $_GET['prodID'] ?? null;

if ($prodID) {
    // Delete the product
    $query = "DELETE FROM product WHERE prodID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $prodID);

    if ($stmt->execute()) {
        echo "Product deleted successfully!";
    } else {
        echo "Error deleting product: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Invalid product ID.";
}

// Close the database connection
$conn->close();
?>