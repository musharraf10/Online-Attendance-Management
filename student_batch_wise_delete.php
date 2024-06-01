<?php

ob_start();
session_start();

// if($_SESSION['name']!='oasis')
// {
//   header('location: login.php');
// }
include('studentconnect.php');

if (isset($_GET['st_id'], $_GET['st_phone_number'])) {
    $student_id = $_GET['st_id'];
    $student_username = $_GET['st_phone_number'];

    // Perform deletion logic for the specific student
    $delete_query = $conn->query("DELETE FROM students WHERE st_id = '$student_id'");
    $delete_admin_query = $conn->query("DELETE FROM admininfo WHERE phone = '$student_username'");

    if ($delete_query && $delete_admin_query) {
        // Successful deletion
        $success_msg = 'Student data and associated admin data deleted Successfully';
    } else {
        // Failed deletion
        $error_msg = 'Failed to delete Student data and/or associated admin data';
    }
}

if (isset($_POST['delete_all_btn'])) {
    $srbatch = $_POST['sr_batch'];

    // Perform deletion logic for all students in the batch
    $delete_all_query = $conn->query("DELETE FROM students WHERE st_batch = '$srbatch'");
    $delete_all_admin_query = $conn->query("DELETE FROM admininfo WHERE phone IN (SELECT st_phone_number FROM students WHERE st_batch = '$srbatch')");

    if ($delete_all_query && $delete_all_admin_query) {
        $success_msg = 'All displayed data and associated admin data deleted Successfully';
    } else {
        $error_msg = 'Failed to delete data';
    }
}
?>

?>
<?php include('studentconnect.php');?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Online Attendance Management System</title>
<meta charset="UTF-8">
  
  <link rel="stylesheet" type="text/css" href="main.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
  <link rel="stylesheet" href="styles.css" >
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</head>
<body>

<header>
<h1>IT&DS Online Attendance Management System</h1>
<div class="navbar">
    <a href="adminsignup.php">Add admin</a>
    <a href="admin_subjects_add.php">Add Subjects</a>
    <a href="students.php">Students</a>
    <a href="teacherreport.php">TeacherReport</a>
    <a href="teacheradd.php">Add Teacher</a>
    <a href="logout.php">Logout</a>
    <div class="user-info">
<?php

if(isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];
    echo strtoupper($loggedInUsername);
}
 else {
            
            echo '<script>window.location.href = "attindex.php";</script>';
        }
?>
</div>

</div>

</header>
<center>

<div class="row">

  <div class="content">
    <h3>Student List</h3>
    <br>
    <button class="btn btn-danger" id="delete-all-btn" name="delete_all_btn">Delete All Data</button>
   <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3" autocomplete="off">
      <div class="form-group">
          <label for="input1" class="col-sm-3 control-label">Batch</label>
            <div class="col-sm-7">
                <input type="text" name="sr_batch"  class="form-control" id="input1" placeholder="enter your BATCH(20) to continue" maxlength="2" oninput="this.value = this.value.toUpperCase();"required />
                
            </div>
         </div>  
      <input type="submit" class="btn btn-primary col-md-3 col-md-offset-7" value="Go!" name="sr_btn" />
      
   </form>
   <?php
include('studentconnect.php'); // Include your database connection

if (isset($_GET['st_id'],$_GET['st_phone_number'])) {
    $student_id = $_GET['st_id'];
    $student_username = $_GET['st_phone_number'];

    // Perform deletion logic for the specific student
    $delete_query = $conn->query("DELETE FROM students WHERE st_id = '$student_id'");
    if ($delete_query) {
        // Successful deletion
        $success_msg = 'Student data ';
    } else {
        // Failed deletion
        $error_msg = 'Failed to ';
    }
    $delete_all_query1 = $conn->query("DELETE FROM admininfo WHERE phone = '$student_username'");
    if ($delete_all_query1) {
      $success_msg = ' deleted Successfully';
  } else {
      $error_msg = 'delete data';
  }
}

if (isset($_POST['delete_all_btn'],$_GET['st_phone_number'])) {
    $srbatch = $_POST['sr_batch'];
    $student_username = $_GET['st_phone_number'];
    $delete_all_query = $conn->query("DELETE FROM students WHERE st_batch = '$srbatch'");
    if ($delete_all_query) {
        $success_msg = 'All displayed data';
    } else {
        $error_msg = 'Failed to ';
    }
    $delete_all_query1 = $conn->query("DELETE FROM admininfo WHERE phone = '$student_username'");
    if ($delete_all_query1) {
      $success_msg = ' Deleted Successfully';
  } else {
      $error_msg = 'delete data';
  }
}
?>

   <div class="content"></div>
    <table class="table table-striped">
      
      <thead>
      <tr>
        <th scope="col">Student ID</th>
        <th scope="col">Name</th>
        <th scope="col">Department</th>
        <th scope="col">Batch</th>
        <th scope="col">Semester</th>
        <th scope="col">Phone Number</th>
        <th scope="col">Email</th>
      </tr>
      </thead>
   <?php

    if(isset($_POST['sr_btn'])){
     
     $srbatch = $_POST['sr_batch'];
     $i=0;
     
     $all_query = $conn->query("SELECT * FROM students WHERE st_batch = '$srbatch' ORDER BY st_id ASC");

    while ($data = $all_query->fetch_assoc()) {
        $i++;
     
     ?>

     <tr>
       <td><?php echo $data['st_id']; ?></td>
       <td><?php echo $data['st_name']; ?></td>
       <td><?php echo $data['st_dept']; ?></td>
       <td><?php echo $data['st_batch']; ?></td>
       <td><?php echo $data['st_sem']; ?></td>
       <td><?php echo $data['st_phone_number']; ?></td>
       <td><?php echo $data['st_email']; ?></td>
       <td>
       <a href="?st_id=<?php echo $data['st_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
       </td>
     </tr>

     <?php 
          } 
              }
      ?>
    </table>
    
  </div>

</div>

</center>
<script>
    window.onload = function() {
        var form = document.querySelector('form');
        if (form) {
            form.reset();
        }
    }
</script>
<script>
    window.onbeforeunload = function() {
        return "You have unsaved changes. Are you sure you want to leave this page?";
    };
</script>


</body>
</html>

