<?php
session_start();

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'update') {
        $itemId = $_POST['item_id'];
        $quantity = (int)$_POST['quantity'];

        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] === $itemId) {
                $item['quantity'] = $quantity;
                break;
            }
        }
    } elseif ($action === 'remove') {
        $itemId = $_POST['item_id'];
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($itemId) {
            return $item['id'] !== $itemId;
        });
    }
}

// Calculate total price
function calculateTotalPrice() {
    $total = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    return $total;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - FSKTM Kiosk</title>
    <link rel="stylesheet" href="./assets/css/stylescheckout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div id="logo-container">
            <a href="./index.html" id="logo-link">
                <img src="./assets/images/fsktm_logo.png" alt="Website Logo" id="logo">
            </a>
        </div>
        <div id="header-center-text">
            <h1>FSKTM Kiosk</h1>
        </div>
        <div id="nav-and-dark-mode-container">
            <nav id="nav-links">
                <a href="./index.html" class="nav-link">Home</a>
                <a href="./login.html" class="nav-link">Login</a>
                <a href="./purchase.html" class="nav-link">Purchase</a>
            </nav>
            <button id="dark-mode-btn">
                <i id="dark-mode-icon" class="fas fa-moon"></i>
            </button>
        </div>
    </header>

    <main>
        <h2>Your Cart</h2>
        <div id="cart-section">
            <?php if (!empty($_SESSION['cart'])): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Price (Each)</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $cartItem): ?>
                            <?php $itemTotal = $cartItem['price'] * $cartItem['quantity']; ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cartItem['name']); ?></td>
                                <td>RM<?php echo htmlspecialchars(number_format($cartItem['price'], 2)); ?></td>
                                <td><?php echo htmlspecialchars($cartItem['quantity']); ?></td>
                                <td>RM<?php echo htmlspecialchars(number_format($itemTotal, 2)); ?></td>
                                <td>
                                    <form method="POST" action="cart_section.php" style="display:inline;">
                                        <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($cartItem['id']); ?>">
                                        <input type="number" name="quantity" value="<?php echo htmlspecialchars($cartItem['quantity']); ?>" min="1" required>
                                        <input type="hidden" name="action" value="update">
                                        <button type="submit">Update</button>
                                    </form>
                                    <form method="POST" action="cart_section.php" style="display:inline;">
                                        <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($cartItem['id']); ?>">
                                        <input type="hidden" name="action" value="remove">
                                        <button type="submit">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p><strong>Total Price:</strong> RM<?php echo htmlspecialchars(number_format(calculateTotalPrice(), 2)); ?></p>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>

        <div id="cart-actions">
            <a href="./menu.html"><button>Continue Shopping</button></a>
            <a href="./checkout.php"><button>Proceed to Checkout</button></a>
        </div>
    </main>
</body>
</html>