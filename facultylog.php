<?php
// Database credentials
$servername = "localhost"; // Replace with your server name
$username = "nriitac_student"; // Replace with your database username
$password = "College@123456"; // Replace with your database password
$dbname = "nriitac_college"; // Replace with your database name

// Create a connection
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the user ID and password from the form
    $userid = $_POST['userid'];
    $password = $_POST['password'];

    // Validate the user ID and password (you can add more validation if needed)
    if (!empty($userid) && !empty($password)) {
        // Query the database to check if the user exists and has been granted access
        $query = "SELECT * FROM faculty WHERE userid = '$userid' AND password = '$password' AND access = 1";
        $result = mysqli_query($connection, $query);

        // Check if the query returned any rows
        if (mysqli_num_rows($result) == 1) {
            // Login successful
            // Redirect to a logged-in page
            header("Location: attendance.html");
            exit();
        } else {
            // Login failed
            $error = "Invalid user ID or password, or access not granted!";
        }
    } else {
        // Empty user ID or password
        $error = "Please enter a user ID and password!";
    }
}
?>