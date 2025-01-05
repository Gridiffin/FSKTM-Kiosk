<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, return an error
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}

// Get the logged-in user's email
$email = $_SESSION['email'];

// Get the raw POST data
$rawData = file_get_contents("php://input");
$postData = json_decode($rawData, true);

// Log the received data
error_log("Received data: " . print_r($postData, true));

// Get the item details from the POST request
$itemId = $postData['item_id'] ?? null;
$itemName = $postData['item_name'] ?? null;
$itemPrice = $postData['item_price'] ?? null;
$itemAmount = $postData['item_amount'] ?? 1; // Default amount is 1

// Validate the input
if (!$itemId || !$itemName || !$itemPrice) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid item data.']);
    exit;
}

// Initialize the cart in the session if it doesn't exist
if (!isset($_SESSION['cart'][$email])) {
    $_SESSION['cart'][$email] = [];
}

// Add the item to the cart
$item = [
    'item_id' => $itemId,
    'item_name' => $itemName,
    'item_price' => (float)$itemPrice, // Convert to float
    'amount' => $itemAmount,
];

// Check if the item already exists in the cart
$itemExists = false;
foreach ($_SESSION['cart'][$email] as &$cartItem) {
    if ($cartItem['item_id'] === $itemId) {
        $cartItem['amount'] += $itemAmount; // Increment amount if item exists
        $itemExists = true;
        break;
    }
}

// If the item doesn't exist, add it to the cart
if (!$itemExists) {
    $_SESSION['cart'][$email][] = $item;
}

// Return success response
echo json_encode(['status' => 'success', 'message' => 'Item added to cart.']);
?>