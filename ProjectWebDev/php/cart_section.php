<?php
session_start();

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle fetch request
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'fetch') {
    echo json_encode($_SESSION['cart']);
    exit;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $action = $data['action'];

    if ($action === 'update') {
        $itemId = $data['item_id'];
        $quantity = (int)$data['quantity'];

        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] === $itemId) {
                $item['quantity'] += $quantity;
                if ($item['quantity'] < 1) $item['quantity'] = 1; // Ensure quantity doesn't go below 1
                break;
            }
        }
    } elseif ($action === 'remove') {
        $itemId = $data['item_id'];
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($itemId) {
            return $item['id'] !== $itemId;
        });
    }

    // Send a success response
    echo json_encode(['status' => 'success', 'message' => 'Cart updated!']);
    exit;
}
?>