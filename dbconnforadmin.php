<?php
// Database connection parameters
$host = 'localhost'; // Change this if your MySQL database is hosted elsewhere
$dbname = 'acs'; // Change this to your database name
$username = ''; // Leave this empty if you don't have a username
$password = ''; // Leave this empty if you don't have a password

// Establish a database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Display an error message if connection fails
    echo "Connection failed: " . $e->getMessage();
}
?>
