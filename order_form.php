<?php
$products = array(
    '60minAudioKazeta' => '60 minútová AudioKazeta - 6.50€/ks',
    // ... (other product entries) ...
    'Platna7Inch' => '1 Platňa (7 Inch) - 4€',
);
$orderCode = generateRandomCode(8); // Generate 8-digit code
$orderStatus = 'Pending'; // Initial status for new order

function generateRandomCode($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomCode = '';
    for ($i = 0; $i < $length; $i++) {
        $randomCode .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomCode;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['products']) && isset($_POST['quantities'])) {
    // ... Existing code for processing the order ...

    // Process the contact form
    $contactData = array(
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'message' => $_POST['message']
    );

    // Load existing order statuses from order_states.json
    $orderStates = json_decode(file_get_contents('data/order_states.json'), true);

    // Make sure the contact_data array exists before accessing it
    if (!isset($orderStates[$orderCode]['contact_data'])) {
        $orderStates[$orderCode]['contact_data'] = array();
    }

    // Add the contact data to the order status
    $orderStates[$orderCode]['contact_data'] = $contactData;

    // Save the updated order statuses back to order_states.json
    file_put_contents('data/order_states.json', json_encode($orderStates, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="p-6">
        <h1 class="text-2xl font-semibold mb-4">Order Form</h1>
		<?php if(isset($orderCode)) { ?>
			<p class="alert alert-success">Your order has been placed successfully! Your access code is: <?= $orderCode ?></p>
		<?php } ?>
        <form action="order_form.php" method="post">
            <label class="block font-medium mb-2">Select Products:</label>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">
                <?php foreach ($products as $productKey => $productName) { ?>
                    <div class="col">
                        <div class="d-flex align-items-center">
                            <label class="d-flex align-items-center">
                                <input type="checkbox" name="products[]" value="<?= $productKey ?>" class="form-check-input me-2">
                                <?= $productName ?>
                            </label>
                            <input value="0" type="number" name="quantities[<?= $productKey ?>]" min="0" max="100" class="form-control w-25 ms-2">
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="mt-4">
                <label class="block font-medium mb-2">Contact Information:</label>
                <div class="row g-2">
                    <div class="col">
                        <input type="text" name="name" class="form-control" placeholder="Vaše celé meno">
                    </div>
                    <div class="col">
                        <input type="email" name="email" class="form-control" placeholder="Váš email">
                    </div>
                    <div class="col">
                        <input type="number" name="phone" class="form-control" placeholder="Vaše telefónne číslo">
                    </div>
                </div>
                <div class="mt-2">
                    <textarea name="message" class="form-control" rows="5" placeholder="Správa / požiadavky (nepovinné)"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-success mt-4">Place Order</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
