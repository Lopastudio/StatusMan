<?php
include './lang/lang.php'; 
include './settingsDump.php'; 

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['new_options'])) {
        // Process the new options and save to options.json
        $newOptions = explode(',', $_POST['new_options']);
        $newOptions = array_map('trim', $newOptions);
        $options['order_status_options'] = $newOptions;
        file_put_contents('./data/options.json', json_encode($options, JSON_PRETTY_PRINT));
        
        // Update the local variable for immediate use
        $orderStatusOptions = $newOptions;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang_strings['settings_title'] ?></title>
    <link href="assets/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <?php include './globals/navbar.php'; ?>

    <div class="p-6">
        <h1 class="text-2xl font-semibold mb-4"><?= $lang_strings['settings_title'] ?></h1>
        <form action="settings.php" method="post">
            <label for="new_options" class="block font-medium mb-2"><?= $lang_strings['order_status_options_label'] ?></label>
            <input type="text" id="new_options" name="new_options" value="<?= implode(', ', $orderStatusOptions) ?>" class="w-full p-2 border rounded-md focus:outline-none focus:border-blue-500" required>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring"><?= $lang_strings['update_options_button'] ?></button>
        </form>
    </div>

    <?php include './globals/footer.html'; ?>
</body>
</html>
