<?php
// Database connection parameters
define('DB_SERVER', 'localhost'); // Your database server, usually 'localhost'
define('DB_USERNAME', 'root'); // Your database username (e.g., 'root' for XAMPP/WAMP)
define('DB_PASSWORD', 'MyStrongPassword123'); // <--- IMPORTANT: REPLACE WITH THE EXACT PASSWORD YOU SET IN PHPMYADMIN
define('DB_NAME', 'final_project'); // The name of your database, changed to use underscore

// Attempt to connect to MySQL database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// session_start() removed from here, as it should only be called once in the main script (e.g., register.php, login.php)
?>
