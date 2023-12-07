<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['order_code'])) {
    $orderCode = $_GET['order_code'];
    $orderStates = json_decode(file_get_contents('data/order_states.json'), true);
    $orderStatus = $orderStates[$orderCode];
} else {
    header('Location: dashboard.php');
    exit;
}

$cartDataFile = 'data/cart.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product'])) {
    $product = $_POST['product'];

    // Load cart data from JSON file
    $cartData = json_decode(file_get_contents($cartDataFile), true);
    if (!isset($cartData[$orderCode])) {
        $cartData[$orderCode] = array(
            'status' => $orderStatus,
            'products' => array(),
        );
    }
    $cartData[$orderCode]['products'][$product] = $products[$product] . ' (1 pcs)';
    file_put_contents($cartDataFile, json_encode($cartData, JSON_PRETTY_PRINT));

    // Redirect back to the cart page to avoid form resubmission
    header("Location: cart.php?order_code=$orderCode");
    exit;
}

// Load cart data from JSON file
$cartData = json_decode(file_get_contents($cartDataFile), true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Dashboard</title>
    <link href="assets/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="p-6">
        <h1 class="text-2xl font-semibold mb-4">Cart for Order <?= $orderCode ?></h1>
        <form action="cart.php?order_code=<?= $orderCode ?>" method="post">
            <label for="product" class="block font-medium mb-2">Select Product:</label>
            <input type="text" id="product" name="product" class="w-full p-2 border rounded-md focus:outline-none focus:border-blue-500" placeholder="Enter product name" required>
            <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring">Add to Cart</button>
        </form>
        <h2 class="text-lg font-semibold mt-4">Cart Contents:</h2>
        <?php if (isset($cartData[$orderCode]['products']) && count($cartData[$orderCode]['products']) > 0) { ?>
            <ul class="list-disc pl-6 mt-2">
                <?php foreach ($cartData[$orderCode]['products'] as $product) { ?>
                    <li><?= $product ?></li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p class="text-gray-600 mt-2">Cart is empty.</p>
        <?php } ?>
        <a href="dashboard.php" class="text-blue-500 hover:underline mt-4 focus:outline-none focus:ring">Back to Dashboard</a>
    </div>

</body>
</html>
