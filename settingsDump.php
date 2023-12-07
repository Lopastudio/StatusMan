<?php
$options = json_decode(file_get_contents('./data/options.json'), true);
$orderStatusOptions = $options['order_status_options'];
?>