<?php
// Establish database connection
$servername = "localhost";
$username = "nriitac_student";
$password = "College@123456";
$dbname = "nriitac_college";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize form inputs
$title = $_POST['title'];
$company = $_POST['company'];
$location = $_POST['location'];
$description = $_POST['description'];
$applyLink = $_POST['applyLink'];

// Insert data into the database
$sql = "INSERT INTO jobs (title, company, location, description, apply_link)
        VALUES ('$title', '$company', '$location', '$description', '$applyLink')";

if ($conn->query($sql) === TRUE) {
    echo "added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
