<?php
$orderCode = generateRandomCode(8); // Generate 8-digit code
$orderStatus = 'Pending'; // Initial status for new order

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['products']) && isset($_POST['quantities'])) {
    $selectedProducts = $_POST['products'];
    $quantities = $_POST['quantities'];
    $formattedProducts = array();

    foreach ($selectedProducts as $productKey) {
        $formattedProducts[] = $products[$productKey] . ' (' . $quantities[$productKey] . ' pcs)';
    }

    // Load existing cart data from cart.json
    $cartData = json_decode(file_get_contents('data/cart.json'), true);

    // Add the new order to the cart data
    $cartData[$orderCode] = array(
        'status' => $orderStatus,
        'products' => $formattedProducts
    );

    // Save the updated cart data back to cart.json
    file_put_contents('data/cart.json', json_encode($cartData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
	
	// Save the order to the system
    $orderStates = json_decode(file_get_contents('data/order_states.json'), true);
    $orderStates[$orderCode] = $orderStatus;
    file_put_contents('data/order_states.json', json_encode($orderStates, JSON_PRETTY_PRINT));
	
    // Redirect back to the order form or wherever you want
    header('Location: order_form.php');
    exit;
}

function generateRandomCode($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomCode = '';
    for ($i = 0; $i < $length; $i++) {
        $randomCode .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomCode;
}
?>
