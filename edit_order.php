<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderStates = json_decode(file_get_contents('data/order_states.json'), true);

    // Check if the submitted form updates the order states
    if (isset($_POST['order_code']) && isset($_POST['new_status'])) {
        $orderCode = $_POST['order_code'];
        $newStatus = $_POST['new_status'];
        $orderStates[$orderCode] = $newStatus;
        file_put_contents('data/order_states.json', json_encode($orderStates, JSON_PRETTY_PRINT));
        header('Location: dashboard.php');
        exit;
    }
}

if (isset($_GET['order_code'])) {
    $orderCode = $_GET['order_code'];
    $orderStates = json_decode(file_get_contents('data/order_states.json'), true);
    $orderStatus = $orderStates[$orderCode];
} else {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/tailwind.min.css" rel="stylesheet">
    <title>Edit Status</title>
</head>
<body class="bg-gray-100">

    <div class="p-6">
        <h1 class="text-2xl font-semibold mb-4">Edit Order</h1>
        <form action="edit_order.php" method="post">
            <input type="hidden" name="order_code" value="<?= $orderCode ?>">
            <label for="new_status" class="block font-medium mb-2">New Status:</label>
            <select id="new_status" name="new_status" class="w-full p-2 border rounded-md focus:outline-none focus:border-blue-500" required>
				<option value="Zaznamenana" <?= $orderStatus === 'Zaznamenana' ? 'selected' : '' ?>>Zaznamenana</option>
				<option value="Doručena ku nam" <?= $orderStatus === 'Doručena ku nam' ? 'selected' : '' ?>>Doručena ku nam</option>
				<option value="digitalizuje sa" <?= $orderStatus === 'digitalizuje sa' ? 'selected' : '' ?>>digitalizuje sa</option>
				<option value="uprava" <?= $orderStatus === 'uprava' ? 'selected' : '' ?>>uprava</option>
				<option value="zapis na digi medium" <?= $orderStatus === 'zapis na digi medium' ? 'selected' : '' ?>>zapis na digi medium</option>
				<option value="hotovo" <?= $orderStatus === 'hotovo' ? 'selected' : '' ?>>hotovo</option>
				<option value="Odoslane spät." <?= $orderStatus === 'Odoslane spät.' ? 'selected' : '' ?>>Odoslane spät.</option>
			</select>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring">Update Status</button>
        </form>
    </div>

</body>
</html>
