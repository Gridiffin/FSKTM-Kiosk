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
$newQuantity = $postData['amount'] ?? null;

if (!$itemId || !$newQuantity) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data.']);
    exit;
}

// Find the item in the cart and update its quantity
foreach ($_SESSION['cart'][$email] as &$item) {
    if ($item['item_id'] === $itemId) {
        $item['amount'] = (int)$newQuantity;
        break;
    }
}

echo json_encode(['status' => 'success', 'message' => 'Quantity updated.']);
?>