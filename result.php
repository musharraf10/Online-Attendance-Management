<?php
// Connect to the database
$servername = "localhost";
$username = "nriitac_student";
$password = "College@123456";
$dbname = "nriitac_college";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the input values
$roll_number = $_POST['roll_number'];
$selected_semester = $_POST['semester']; // Assuming the name of the semester selection input is 'semester'

// Perform a database query based on the selected semester
$table_name = "results_" . str_replace('-', '_', $selected_semester); // Prefix "results_" and replace the hyphen with underscore in the semester to match the table name
$sql = "SELECT * FROM `$table_name` WHERE Htno = '$roll_number'";
$result = $conn->query($sql);

// Add CSS styles for the table
echo "<style>";
echo "table {border-collapse: collapse; width: 100%;}";
echo "th, td {text-align: left; padding: 8px;}";
echo "th {background-color: #4CAF50; color: white;}";
echo "tr:nth-child(even) {background-color: #f2f2f2}";
echo "</style>";

// Display the results in a table
if ($result->num_rows > 0) {
    echo "<table><tr><th>Htno</th><th>Subcode</th><th>Subname</th><th>Internals</th><th>Grade</th><th>Credits</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["Htno"]."</td><td>".$row["Subcode"]."</td><td>".$row["Subname"]."</td><td>".$row["Internals"]."</td><td>".$row["Grade"]."</td><td>".$row["Credits"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "No results found";
}

// Close the database connection
$conn->close();
?>
