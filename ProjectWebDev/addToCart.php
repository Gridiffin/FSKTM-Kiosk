<?php
// Start session
session_start();

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Function to add item to the cart
function addToCart($itemId, $itemName, $quantity, $price) {
    // Check if the item already exists in the cart
    foreach ($_SESSION['cart'] as &$cartItem) {
        if ($cartItem['id'] == $itemId) {
            // Update the quantity if item exists
            $cartItem['quantity'] += $quantity;
            return;
        }
    }

    // Add new item to the cart
    $_SESSION['cart'][] = array(
        'id' => $itemId,
        'name' => $itemName,
        'quantity' => $quantity,
        'price' => $price
    );
}

// Handle add to cart request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemId = $_POST['item_id'];
    $itemName = $_POST['item_name'];
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);

    if ($itemId && $itemName && $quantity > 0 && $price > 0) {
        addToCart($itemId, $itemName, $quantity, $price);
        echo json_encode(array('success' => true, 'message' => 'Item added to cart.'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Invalid item data.'));
    }
}
?>