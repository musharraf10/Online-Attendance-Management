<!DOCTYPE html>
<html lang="en">
<head>
    <title>Online Attendance Management System</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
   
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
   
  <link rel="stylesheet" href="styles.css" >
   
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <header>
    <h1>Online Attendance Management System</h1>
<div class="navbar">
  <a href="studentindex.php">Home</a>
  <a href="students.php">Students</a>
  <a href="studentreport.php">My Report</a>
  <a href="studentaccount.php">My Account</a>
  <a href="logout.php">Logout</a>
</div>
    </header>
    <center>
        <div class="row">
            <div class="content">
                <h3>Update Account</h3>
                <br>
                <?php
                // Include your database connection code here
                
                // Handle form submission
                if(isset($_POST['done'])){
                    // Sanitize and validate user inputs here
                    $email = $_POST['email'];
                    $name = $_POST['name'];
                    $dept = $_POST['dept'];
                    $batch = $_POST['batch'];
                    $semester = $_POST['semester'];
                    
                    // Update student information in the students table based on email from admininfo table
                    $updateQuery = $conn->prepare("UPDATE students s
                                                 JOIN admininfo a ON s.st_email = a.email
                                                 SET s.st_name=?, s.st_dept=?, s.st_batch=?, s.st_sem=?
                                                 WHERE a.email=?");
                    $updateQuery->bind_param("sssss", $name, $dept, $batch, $semester, $email);
                    if($updateQuery->execute()){
                        $success_msg = "Profile updated successfully!";
                    } else {
                        $error_msg = "Error updating profile: " . $conn->error;
                    }
                    $updateQuery->close();
                }
                ?>
                <!-- Display success or error messages -->
                <p><?php if(isset($success_msg)) echo $success_msg; ?></p>
                <p><?php if(isset($error_msg)) echo $error_msg; ?></p>
                <br>
                <?php
                if(isset($_POST['sr_btn'])){
                    // Display the form for student information update based on email from admininfo table
                    ?>
                    <form action="" method="post" class="form-horizontal col-md-6 col-md-offset-3">
                        <!-- Your form fields here -->
                    </form>
                    <?php
                }
                ?>
            </div>
        </div>
    </center>
</body>
</html>
