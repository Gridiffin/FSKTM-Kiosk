<?php
session_start();

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle adding items to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemId = $_POST['item_id'];
    $itemName = $_POST['item_name'];
    $itemPrice = $_POST['item_price'];

    // Check if the item already exists in the cart
    $itemExists = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] === $itemId) {
            $item['quantity'] += 1;
            $itemExists = true;
            break;
        }
    }

    // If the item doesn't exist, add it to the cart
    if (!$itemExists) {
        $_SESSION['cart'][] = [
            'id' => $itemId,
            'name' => $itemName,
            'price' => $itemPrice,
            'quantity' => 1,
        ];
    }

    // Send a success response
    echo "Item added to cart!";
}
?>