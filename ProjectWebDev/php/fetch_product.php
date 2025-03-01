<?php
// Include database connection
include 'connection.php';

// Fetch products from the database
$query = "SELECT prodID, prodName AS name, CAST(prodPrice AS DECIMAL(10,2)) AS price, prodPic AS image, prodType AS category, amount FROM product";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    // Return products as JSON
    echo json_encode($products);
} else {
    // No products found
    echo json_encode([]);
}

// Close the database connection
$conn->close();
?>