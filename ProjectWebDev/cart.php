<?php
// Start session
session_start();

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Function to add item to the cart
function addToCart($itemId, $itemName, $quantity, $price) {
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

// Function to update the quantity of an item in the cart
function updateCart($itemId, $quantity) {
    foreach ($_SESSION['cart'] as &$cartItem) {
        if ($cartItem['id'] == $itemId) {
            if ($quantity > 0) {
                $cartItem['quantity'] = $quantity;
            } else {
                removeItemFromCart($itemId);
            }
            return;
        }
    }
}

// Function to remove an item from the cart
function removeItemFromCart($itemId) {
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($itemId) {
        return $item['id'] != $itemId;
    });
}

// Function to calculate the total price
function calculateTotalPrice() {
    $total = 0;
    foreach ($_SESSION['cart'] as $cartItem) {
        $total += $cartItem['price'] * $cartItem['quantity'];
    }
    return $total;
}

// Handle requests (update, remove)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $itemId = $_POST['item_id'];
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

        switch ($action) {
            case 'update':
                updateCart($itemId, $quantity);
                break;
            case 'remove':
                removeItemFromCart($itemId);
                break;
        }
    }
}

// Display cart items
function displayCart() {
    if (empty($_SESSION['cart'])) {
        echo "<p>Your cart is empty.</p>";
        return;
    }

    echo "<table border='1'>
            <tr>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>";

    foreach ($_SESSION['cart'] as $cartItem) {
        $totalItemPrice = $cartItem['price'] * $cartItem['quantity'];
        echo "<tr>
                <td>{$cartItem['name']}</td>
                <td>\${$cartItem['price']}</td>
                <td>{$cartItem['quantity']}</td>
                <td>\${$totalItemPrice}</td>
                <td>
                    <form method='POST' style='display:inline;'>
                        <input type='hidden' name='item_id' value='{$cartItem['id']}'>
                        <input type='number' name='quantity' value='{$cartItem['quantity']}' min='1' required>
                        <input type='hidden' name='action' value='update'>
                        <button type='submit'>Update</button>
                    </form>
                    <form method='POST' style='display:inline;'>
                        <input type='hidden' name='item_id' value='{$cartItem['id']}'>
                        <input type='hidden' name='action' value='remove'>
                        <button type='submit'>Remove</button>
                    </form>
                </td>
            </tr>";
    }

    echo "</table>";

    $totalPrice = calculateTotalPrice();
    echo "<p><strong>Total Price: \$" . number_format($totalPrice, 2) . "</strong></p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart Management</title>
</head>
<body>
    <h1>Your Cart</h1>
    <?php displayCart(); ?>

    <h2>Add an Item</h2>
    <form method="POST" action="add_to_cart.php">
        <label for="item_id">Item ID:</label>
        <input type="text" name="item_id" required>
        <label for="item_name">Item Name:</label>
        <input type="text" name="item_name" required>
        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" required>
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" min="1" required>
        <button type="submit">Add to Cart</button>
    </form>
</body>
</html>
