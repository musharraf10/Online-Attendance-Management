<?php
header('Content-Type: text/html; charset=utf-8');

$servername = "localhost";
$username = "nriitac_student";
$password = "College@123456";
$dbName = "nriitac_college";

// Create a new mysqli instance
$conn = new mysqli($servername, $username, $password, $dbName);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST))
{
  $name = $_POST['name'] ?? '';
  $roll = $_POST['roll'] ?? '';
  $academic_year = $_POST['academic_year'] ?? '';
  $department = $_POST['department'] ?? '';
  $email = $_POST['email'] ?? '';
  $gender = $_POST['gender'] ?? '';
  $blood_group = $_POST['blood_group'] ?? '';

  // Image uploading functionality
  if(isset($_FILES['profile']) && $_FILES['profile']['error'] === UPLOAD_ERR_OK) {
    $filename = $_FILES['profile']['name'];
    $tmpname = $_FILES['profile']['tmp_name'];
    $folder = 'uploads/';
    $filepath = $folder . $filename;
    move_uploaded_file($tmpname, $filepath);
  } else {
    $filepath = '';
  }

  // check if the 'roll' value is already in the database
  $check_roll_sql = "SELECT * FROM register WHERE roll = ?";
  $check_roll_stmt = $conn->prepare($check_roll_sql);
  $check_roll_stmt->bind_param("s", $roll);
  $check_roll_stmt->execute();
  $check_roll_result = $check_roll_stmt->get_result();
  if ($check_roll_result->num_rows > 0) {
    echo "Error: Roll number already registered";
    exit();
  }
  $check_roll_stmt->close();

  // check if the 'email' value is already in the database
  $check_email_sql = "SELECT * FROM register WHERE email = ?";
  $check_email_stmt = $conn->prepare($check_email_sql);
  $check_email_stmt->bind_param("s", $email);
  $check_email_stmt->execute();
  $check_email_result = $check_email_stmt->get_result();
  if ($check_email_result->num_rows > 0) {
    echo "Error: Email already registered";
    exit();
  }
  $check_email_stmt->close();

  // insert the new record if roll and email are unique
  $insert_sql = "INSERT INTO register (name,roll,academic_year,department,email,gender,blood_group,profile) VALUES (?,?,?,?,?,?,?,?)";
  $insert_stmt = $conn->prepare($insert_sql);
  $insert_stmt->bind_param("ssssssss", $name, $roll, $academic_year, $department, $email, $gender, $blood_group, $filepath);
  if ($insert_stmt->execute()) {
    echo "New record created successfully";
    echo"<script>
             function redirection()
             {
                window.location.href='register.html';
             }
             setTimeout(redirection,2000);
             </script>";
    exit();
  } else {
    echo "Error: " . $insert_sql . "<br>" . $conn->error;
  }
  $insert_stmt->close();
}

// Close the connection
$conn->close();
?>
