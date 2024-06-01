<?php
// Database connection details
$servername = 'localhost';
$username = 'nriitac_student';
$password = 'College@123456';
$dbname = 'nriitac_college';

// Create a new MySQLi instance
$connection = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($connection->connect_error) {
    die('Connection failed: ' . $connection->connect_error);
}

// Perform authentication with your database
$validUsername = 'nriit@results';
$validPassword = 'Nriit@it&ds';

$inputUsername = $_POST['username'];
$inputPassword = $_POST['password'];

if ($inputUsername === $validUsername && $inputPassword === $validPassword) {
    // Redirect to the result upload page
    header('Location:adminupload.html');
    exit();
} else {
    echo 'Invalid username or password';
}

// Close the database connection
$connection->close();
?>
