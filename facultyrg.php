<?php
$servername = "localhost";
$username = "nriitac_student";
$password = "College@123456";
$dbname = "nriitac_college";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = $_POST['userid'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $department = $_POST['department'];
    $mobile = $_POST['mobile'];

    $sql = "INSERT INTO faculty (userid, password, name, department, mobile) VALUES ('$userid', '$password', '$name', '$department', '$mobile')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<script>
                setTimeout(function() {
                    window.location.href = "facultylog.html";
                }, 2000);
              </script>';
    } else {
        echo '<script>showMessage(false);</script>';
    }
}

mysqli_close($conn);
?>

