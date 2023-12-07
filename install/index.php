<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Statusman Installer</title>
  <link href="../assets/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex h-screen">
  <!-- Vertical Menu -->
  <div class="bg-gray-800 text-white p-4 w-1/5">
    <h1 class="text-xl font-bold mb-4">Statusman Installer</h1>
    <ul>
      <li class="mb-2"><a href="?stage=welcome">Welcome</a></li>
      <li class="mb-2"><a href="?stage=php_check">PHP Requirement Check</a></li>
      <li class="mb-2"><a href="?stage=database_install">Database Install</a></li>
      <li class="mb-2"><a href="?stage=config">Statusman Configuration</a></li>
      <li class="mb-2"><a href="?stage=congrats">Congratulations</a></li>
    </ul>
  </div>

  <!-- Central Content Area -->
  <div class="container mx-auto my-8 p-8 bg-white shadow-lg rounded-lg w-4/5">
    <?php
    // Determine the current stage
    $currentStage = isset($_GET['stage']) ? $_GET['stage'] : 'welcome';

    // Display content based on the current stage
    switch ($currentStage) {
      case 'php_check':
        echo '<h1 class="text-3xl font-bold mb-6">PHP Extension Check</h1>';
        if (!extension_loaded('mysqli')) {
          echo '<p class="text-red-500">Error: The "mysqli" extension is required. Please enable it to proceed with the installation.</p>';
        } else {
          echo '<p class="text-green-500">PHP extension check passed.</p>';
        }
        break;

      case 'database_install':
        if (!isset($_POST['install']) || (isset($_POST['install']) && !extension_loaded('mysqli'))) {
          echo '<h1 class="text-3xl font-bold mb-6">Database Installation</h1>';
          echo '<form method="post" action="?stage=database_install">';
          echo '<div class="mb-4">';
          echo '<label for="servername" class="block text-sm font-medium text-gray-600">Server Name</label>';
          echo '<input type="text" name="servername" id="servername" class="mt-1 p-2 border rounded-md w-full">';
          echo '</div>';
          
          // Add similar code for other database input fields

          echo '<button type="submit" name="install" class="bg-blue-500 text-white p-2 rounded-md">INSTALL</button>';
          echo '</form>';
        } else {
          $servername = $_POST['servername'];
          // Add similar code for other database input fields

          // Create connection
          $conn = new mysqli($servername, $username, $password, $dbname);

          // Check connection
          if ($conn->connect_error) {
            echo '<p class="text-red-500">Connection failed: ' . $conn->connect_error . '</p>';
          } else {
            // SQL to create table
            $sql = "CREATE TABLE IF NOT EXISTS MyGuests (
              id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              firstname VARCHAR(30) NOT NULL,
              lastname VARCHAR(30) NOT NULL,
              email VARCHAR(50),
              reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";

            if ($conn->query($sql) === TRUE) {
              echo '<p class="text-green-500">Table MyGuests created successfully</p>';
            } else {
              echo '<p class="text-red-500">Error creating table: ' . $conn->error . '</p>';
            }

            $conn->close();
          }
        }
        break;

      case 'config':
        echo '<h1 class="text-3xl font-bold mb-6">Statusman Configuration</h1>';
        // Add configuration settings form or instructions
        break;

      case 'congrats':
        echo '<h1 class="text-3xl font-bold mb-6">Congratulations!</h1>';
        echo '<p class="text-green-500">Statusman has been successfully installed and configured.</p>';
        break;

      default:
        echo '<h1 class="text-3xl font-bold mb-6">Welcome to Statusman Installer</h1>';
        echo '<p class="text-gray-600">This installer will guide you through the installation process.</p>';
        break;
    }
    ?>
  </div>
</body>
</html>
