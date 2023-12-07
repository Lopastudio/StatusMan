<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $users = json_decode(file_get_contents('data/users.json'), true);
    if (isset($users[$username]) && $users[$username]['password'] === $password) {
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        $loginError = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Dashboard</title>
    <link href="assets/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="w-1/2 bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold mb-4">Login to Dashboard</h1>
        <?php if (isset($loginError)) { ?>
            <p class="text-red-500 mb-2">Invalid username or password.</p>
        <?php } ?>
        <form action="login.php" method="post">
            <label for="username" class="block font-medium mb-2">Username:</label>
            <input type="text" id="username" name="username" class="w-full p-2 border rounded-md focus:outline-none focus:border-blue-500" required>
            <label for="password" class="block font-medium mb-2">Password:</label>
            <input type="password" id="password" name="password" class="w-full p-2 border rounded-md focus:outline-none focus:border-blue-500" required>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring">Login</button>
        </form>
    </div>

</body>
</html>
