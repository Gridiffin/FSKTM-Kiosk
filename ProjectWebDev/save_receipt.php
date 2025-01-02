<?php include 'connection.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $receiptID = rand(100000, 999999); // Auto-increment simulation
    $email = $_POST['email'];
    $itemID = "12345";
    $itemName = "Delicious Burger";
    $itemPrice = 10.99;
    $totalPrice = 10.99;
    $payment = 20.00;
    $change = $payment - $totalPrice;

    // Save receipt to database (Simulated for this example)
    // In a real application, this would involve a database connection and an SQL INSERT statement
    $receipt = [
        'receiptID' => $receiptID,
        'email' => $email,
        'itemID' => $itemID,
        'itemName' => $itemName,
        'itemPrice' => $itemPrice,
        'totalPrice' => $totalPrice,
        'payment' => $payment,
        'change' => $change
    ];

    // Create a downloadable receipt file
    $receiptText = "Receipt ID: {$receipt['receiptID']}\n" .
                   "Customer Email: {$receipt['email']}\n" .
                   "Item ID: {$receipt['itemID']}\n" .
                   "Item Name: {$receipt['itemName']}\n" .
                   "Item Price: {$receipt['itemPrice']}\n" .
                   "Total Price: {$receipt['totalPrice']}\n" .
                   "Payment: {$receipt['payment']}\n" .
                   "Change: {$receipt['change']}\n";

    header('Content-Type: text/plain');
    header("Content-Disposition: attachment; filename=receipt_{$receipt['receiptID']}.txt");
    echo $receiptText;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment and Receipt - My Website</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <nav>
            <ul>
                <li><a href="/index.html">Home</a></li>
                <li><a href="/login.html">Login</a></li>
                <li><a href="/purchase.html">Purchase</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <h1>Payment Confirmation</h1>
        <form method="POST">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <br>
            <button type="submit">Confirm Payment</button>
        </form>
    </main>
</body>
</html>
