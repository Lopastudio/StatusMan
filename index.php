<?php
include './lang/lang.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/tailwind.min.css" rel="stylesheet">
    <title>Kontrola stavu objednávky - StatusMan</title>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="w-1/2 bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold mb-4"><?= $lang_strings['mainPage_TitleBar'] ?></h1>
        <form action="check_order.php" method="post">
            <label for="order_code" class="block font-medium mb-2">Váš kód:</label>
            <input type="text" id="order_code" name="order_code" class="w-full p-2 border rounded-md focus:outline-none focus:border-blue-500" required>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring">Check Status</button>
        </form>
    </div>

</body>
</html>
