<?php
session_start();

if (!isset($_SESSION['email'])) {
    echo json_encode([]);
    exit;
}

$email = $_SESSION['email'];
$cart = $_SESSION['cart'][$email] ?? [];

// Ensure item_price is a float
foreach ($cart as &$item) {
    $item['item_price'] = (float)$item['item_price'];
}

echo json_encode($cart);
?>