<?php
// Include database connection
include 'connection.php';

// Fetch cart data from the database
$query = "SELECT c.cartID, c.prodID, c.prodName, c.quantity, c.price, p.prodPic 
          FROM cart c
          JOIN product p ON c.prodID = p.prodID"; // Join with product table to get the image
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $cartItems = [];
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }
    // Return cart items as JSON
    echo json_encode($cartItems);
} else {
    // No items in the cart
    echo json_encode([]);
}

// Close the database connection
$conn->close();
?>