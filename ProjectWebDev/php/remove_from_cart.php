<?php
session_start();

if (!isset($_SESSION['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}

$email = $_SESSION['email'];
$rawData = file_get_contents("php://input");
$postData = json_decode($rawData, true);

$itemId = $postData['item_id'] ?? null;

if (!$itemId) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data.']);
    exit;
}

// Find the item in the cart and remove it
foreach ($_SESSION['cart'][$email] as $key => $item) {
    if ($item['item_id'] === $itemId) {
        unset($_SESSION['cart'][$email][$key]);
        break;
    }
}

echo json_encode(['status' => 'success', 'message' => 'Item removed.']);
?>