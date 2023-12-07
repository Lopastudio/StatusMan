<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About StatusMan</title>
    <link href="assets/tailwind.min.css" rel="stylesheet">
	<link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
</head>
<body class="bg-gray-100">
    <?php include './globals/navbar.php'; ?>
    
    <div class="p-6">
        <h1 class="text-3xl font-semibold mb-4">About StatusMan</h1>
        <h2 class="text-xl font-semibold mb-2">Streamlining Your Orders, Simplifying Your Workflow</h2>
        <p class="mb-4">This application is designed to enhance the customer experience by providing real-time updates on the status of their purchases. With its user-friendly interface, customers can easily track and monitor the current state of their orders, gaining valuable insights into the fulfillment process. Utilize this application to stay connected with your purchases every step of the way.</p>
        
        <h1 class="text-2xl font-semibold mb-4">Sources:</h1>
        <p>Favicon from <a href="https://www.freepik.com/icons/" target="_blank" class="text-blue-500 hover:underline">https://www.freepik.com/icons/</a></p>
    </div>
    
    <?php include './globals/footer.html'; ?>
</body>
</html>

