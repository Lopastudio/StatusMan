<?php
include './settingsDump.php';
session_start();
header('Content-Type: text/html; charset=UTF-8');

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderStates = json_decode(file_get_contents('data/order_states.json'), true);

    // Check if the submitted form updates the order states
    if (isset($_POST['new_order_code']) && isset($_POST['new_order_status'])) {
        $newOrderCode = $_POST['new_order_code'];
        $newOrderStatus = $_POST['new_order_status'];

        // Allow "Custom state" option
        if ($newOrderStatus == 'Custom state' && isset($_POST['custom_order_status'])) {
            $newOrderStatus = $_POST['custom_order_status'];
        }

        $orderStates[$newOrderCode] = $newOrderStatus;
        file_put_contents('data/order_states.json', json_encode($orderStates, JSON_PRETTY_PRINT));
    }
}

if (isset($_GET['delete'])) {
    $orderToDelete = $_GET['delete'];
    $orderStates = json_decode(file_get_contents('data/order_states.json'), true);
    if (isset($orderStates[$orderToDelete])) {
        unset($orderStates[$orderToDelete]);
        file_put_contents('data/order_states.json', json_encode($orderStates, JSON_PRETTY_PRINT));
        header('Location: dashboard.php');
        exit;
    }
}

$orderStates = json_decode(file_get_contents('data/order_states.json'), true);

include './lang/lang.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang_strings['dashboard_title'] ?></title>
    <link href="assets/tailwind.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
</head>
<body class="bg-gray-100">
    <?php include './globals/navbar.php'; ?>
    
    <div class="p-6">
        <h1 class="text-2xl font-semibold mb-4"><?= $lang_strings['dashboard_title'] ?></h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-2"><?= $lang_strings['manage_orders'] ?></h2>
                <?php foreach ($orderStates as $orderCode => $status) { ?>
                    <div class="flex items-center justify-between border-b py-2">
                        <div class="flex items-center">
                            <p class="text-lg font-semibold mr-2"><?= $lang_strings['order_number'] ?> <?= $orderCode ?></p>
                            <p class="text-gray-600"><?= $status ?></p>
                        </div>
                        <div class="flex items-center">
                            <a href="edit_order.php?order_code=<?= $orderCode ?>" class="text-blue-500 hover:underline mr-2"><?= $lang_strings['edit_link'] ?></a>
                            <a href="dashboard.php?delete=<?= $orderCode ?>" class="text-red-500 hover:underline"><?= $lang_strings['delete_link'] ?></a>
                            <a href="cart.php?order_code=<?= $orderCode ?>" class="text-green-500 hover:underline ml-2"><?= $lang_strings['cart_link'] ?></a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <h1>&nbsp;</h1>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-2"><?= $lang_strings['add_new_order'] ?></h2>
                <form action="dashboard.php" method="post">
                    <label for="new_order_code" class="block font-medium mb-2"><?= $lang_strings['order_code_label'] ?></label>

                    <?php
                    function generateRandomOrderNumber() {
                        return mt_rand(100000, 999999);
                    }

                    $randomOrderNumber = generateRandomOrderNumber();
                    ?>

                    <input type="text" id="new_order_code" name="new_order_code" value="<?= $randomOrderNumber ?>" class="w-full p-2 border rounded-md focus:outline-none focus:border-blue-500" required>

                    <label for="new_order_status" class="block font-medium mb-2 mt-4"><?= $lang_strings['order_status_label'] ?></label>
                    <select id="new_order_status" name="new_order_status" class="w-full p-2 border rounded-md focus:outline-none focus:border-blue-500" required>
                        <?php foreach ($orderStatusOptions as $option) { ?>
                            <option value="<?= $option ?>"><?= $option ?></option>
                        <?php } ?>
                        <option value="Custom state"><?= $lang_strings['custom_state_option'] ?></option>
                    </select>

                    <div id="customStateInput" style="display: none;">
                        <label for="custom_order_status" class="block font-medium mb-2 mt-4"><?= $lang_strings['custom_state_label'] ?></label>
                        <input type="text" id="custom_order_status" name="custom_order_status" class="w-full p-2 border rounded-md focus:outline-none focus:border-blue-500">
                    </div>

                    <script>
						// Disable Enable Custom State
                        document.getElementById('new_order_status').addEventListener('change', function () {
                            var customStateInput = document.getElementById('customStateInput');
                            if (this.value === 'Custom state') {
                                customStateInput.style.display = 'block';
                            } else {
                                customStateInput.style.display = 'none';
                            }
                        });
                    </script>

                    <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring"><?= $lang_strings['add_order_button'] ?></button>
                </form>

            </div>
        </div>
    </div>
    <?php include './globals/footer.html'; ?>
</body>
</html>
