<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newOrderCode = $_POST['new_order_code'];
    $orderStates = json_decode(file_get_contents('data/order_states.json'), true);
    $orderStates[$newOrderCode] = 'New Order';
    file_put_contents('data/order_states.json', json_encode($orderStates, JSON_PRETTY_PRINT));
    header('Location: dashboard.php');
    exit;
}
?>
