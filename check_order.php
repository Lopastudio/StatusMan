<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderCode = $_POST['order_code'];
    $orderStates = json_decode(file_get_contents('data/order_states.json'), true);
    $status = $orderStates[$orderCode] ?? null;
    $validOrder = isset($status);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/tailwind.min.css" rel="stylesheet">
    <title>Order Status</title>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="w-1/2 bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold mb-4">Order Status</h1>
        <?php if ($validOrder) { ?>
            <p class="text-lg mb-2">Order Code: <?= $orderCode ?></p>
            <p class="text-lg mb-2">Status: <?= $status ?></p>
        <?php } else { ?>
            <p class="text-lg text-red-500 mb-2">Invalid order code.</p>
        <?php } ?>
        <a href="index.php" class="text-blue-500 hover:underline focus:outline-none focus:ring">Check Another Order</a>
    </div>

    <?php if (!$validOrder) { ?>
    <div id="errorModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="absolute inset-0 bg-gray-900 opacity-50"></div>
        <div class="bg-white p-6 rounded-lg shadow-md z-10">
            <h2 class="text-xl font-semibold mb-2">Error</h2>
            <p>This order was not found. Please check if you inputted the order code correctly.</p>
            <button id="closeModal" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring">Close</button>
        </div>
    </div>
    <script>
        const modal = document.getElementById('errorModal');
        const closeModal = document.getElementById('closeModal');
        modal.classList.remove('hidden');
        closeModal.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    </script>
    <?php } ?>

</body>
</html>
