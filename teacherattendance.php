<?php

ob_start();
session_start();
?>

<?php
    include('connect.php');
    try{
      
    if(isset($_POST['att'])){

      $course = $_POST['whichcourse'];

      foreach ($_POST['st_status'] as $i => $st_status) {
        
        $stat_id = $_POST['stat_id'][$i];
        $dp = date('Y-m-d');
        $course = $_POST['whichcourse'];
        
        $stat = $conn->query("insert into attendance(stat_id,course,st_status,stat_date) values('$stat_id','$course','$st_status','$dp')");
        
        $att_msg = "Attendance Recorded.";

      }

    }
  }
  catch(Execption $e){
    $error_msg = $e->$getMessage();
  }
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Attendance Management</title>
<meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Include jQuery and Bootstrap JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

   <style type="text/css">
 body {
            font-family: Arial, sans-serif;
            overflow-x:hidden;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .navbar {
            background-color: #f8f9fa;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #dee2e6;
        }

        .navbar-toggler-icon {
            background: none;
            border: none;
            color:black;
        }

        .navbar a {
            color: #333;
            text-decoration: none;
            padding: 10px;
            transition: color 0.3s;
        }

        .navbar a:hover {
            color: #007bff;
        }

        .animated-link {
            position: relative;
            overflow: hidden;
        }

        .animated-link::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #007bff;
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.3s ease-in-out;
        }

        .animated-link:hover::before {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

       .user-info {
        font-weight: bold;
        color: blue;
    }
     .menu-icon {
            display: block;
            width: 25px;
            height: 2px;
            margin: 4px auto;
            background-color: #333;
        }
    
.row {  

    display: flex;
    flex-wrap: wrap;
}

.content {
    flex: 30%;
    background-color: white; /*#3e4651;*/
    padding: 50px;
}
select{

    font-size: 15px;
}
option{
    font-size: 15px;
}
a:hover{
    color: blue;
}
p{
    font-size: 15px;
}

img{

    height: 200px;
    width: 300px;
}

        
      
        </style>

<style type="text/css">
  .status{
    font-size: 10px;
  }
 @media (max-width: 768px) {
            .table th:nth-child(3),
            .table td:nth-child(3),
            .table th:nth-child(4),
            .table td:nth-child(4),
            .table th:nth-child(5),
            .table td:nth-child(5),
            .table th:nth-child(6),
            .table td:nth-child(6),
            .table th:nth-child(8),
            .table td:nth-child(8) {
                display: none;
            }
</style>

</head>
<body>

<header>
    <h1>Faculty</h1>
    <nav class="navbar navbar-expand-md">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <span class="menu-icon"></span>
                <span class="menu-icon"></span>
                <span class="menu-icon"></span>
            </span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
               <!-- Navigation links -->
                <li class="nav-item"><a class="nav-link animated-link" href="teacherindex.php">Home</a></li>
                <li class="nav-item"><a class="nav-link animated-link" href="teacherreport.php">overall attendence</a></li>
                <li class="nav-item"><a class="nav-link animated-link" href="teacher_edit_student_account.php">Edit Students</a></li>
                <li class="nav-item"><a class="nav-link animated-link" href="addcourse.php">Add course</a></li>
                <li class="nav-item"><a class="nav-link animated-link" href="teacherattendance.php">Attendance</a></li>
                <li class="nav-item"><a class="nav-link animated-link" href="modify_att.php">Check Attendance</a></li>
                <li class="nav-item"><a class="nav-link animated-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="user-info">
            <?php
            // Replace '$_SESSION['username']' with the actual session variable that holds the user's name
            if(isset($_SESSION['username'])) {
                $loggedInUsername = $_SESSION['username'];
                echo strtoupper($loggedInUsername); // Display the username in capital letters
            }
             else {
            
            echo '<script>window.location.href = "attindex.php";</script>';
        }
            ?>
        </div>
    </nav>
</header>


<center>

<div class="row">

 <div class="content">
    <h3>Attendance of <?php echo date('Y-m-d'); ?></h3>
    <br>

    <center><p><?php if(isset($att_msg)) echo $att_msg; if(isset($error_msg)) echo $error_msg; ?></p></center> 
    
    <form action="" method="post" class="form-horizontal col-md-6 col-md-offset-3">

        <div class="form-group">
            <label>Select Year</label> <br>       
            <select name="whichbatch" id="input1" class="form-control" required>
                <option value="">Select</option>
                <option value="1-1">1-1</option>
                <option value="1-2">1-2</option>
                <option value="2-1">2-1</option>
                <option value="2-2">2-2</option>
                <option value="3-1">3-1</option>
                <option value="3-2">3-2</option>
                <option value="4-1">4-1</option>
                <option value="4-2">4-2</option>
            </select>
            
        </div>
        <div class="form-group">
            <label for="input1" class="col-sm-3 control-label">Branch (2-5 characters)</label>
            <div class="col-sm-7">
                <input type="text" name="dept"  class="form-control" id="input1" placeholder="Your Branch(ex: IT,DS)" minlength="2" maxlength="5" oninput="this.value = this.value.toUpperCase();" required />
            </div>
        </div>
               
        <input type="submit" class="btn btn-primary col-md-2 col-md-offset-5" value="Show!" name="st_sem" />

    </form>

    <div class="content"></div>
    <form action="" method="post">

        <div class="form-group">
            <label>Select Course</label>
            <select name="whichcourse" id="input1">
            <?php
        if (isset($_POST['st_sem']) && isset($_POST['dept']) && isset($_SESSION['username'])) {
            $batch = $_POST['whichbatch'];
            $dept = $_POST['dept'];
            $username = $_SESSION['username'];
            $query = "SELECT DISTINCT tc_course FROM teachers WHERE tc_sem = ? AND tc_dept = ? AND tc_name = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $batch, $dept, $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['tc_course'] . '">' . $row['tc_course'] . '</option>';
                }
            } else {
                echo '<option value="no-course">No Course Found</option>';
            }

            $stmt->close(); // Close the statement
        } else {
            echo '<option value="no-session">No Session Found</option>';
        }
        ?>
    </select>
</div>

<!-- Table for displaying student records -->
<table class="table table-stripped">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Department</th>
            <th scope="col">Batch</th>
            <th scope="col">Semester</th>
            <th scope="col">Email</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        $radio = 0;
        $batch = $_POST['whichbatch'];
        $dept = $_POST['dept'];
        $query = "SELECT * FROM students WHERE st_sem = ? AND st_dept = ? ORDER BY st_id ASC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $batch, $dept);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($data = $result->fetch_assoc()) {
            $i++;
        ?>
        <tr>
            <td><?php echo $data['st_id']; ?> <input type="hidden" name="stat_id[]" value="<?php echo $data['st_id']; ?>"></td>
            <td><?php echo $data['st_name']; ?></td>
            <td><?php echo $data['st_dept']; ?></td>
            <td><?php echo $data['st_batch']; ?></td>
            <td><?php echo $data['st_sem']; ?></td>
            <td><?php echo $data['st_email']; ?></td>
            <td>
                <label>Present</label>
                <input type="radio" name="st_status[<?php echo $radio; ?>]" value="Present" checked>
                <label>Absent</label>
                <input type="radio" name="st_status[<?php echo $radio; ?>]" value="Absent">
            </td>
        </tr>
        <?php
            $radio++;
        }
        $stmt->close(); // Close the statement
        ?>
    </tbody>
</table>

    <center><br>
    <input type="submit" class="btn btn-primary col-md-2 col-md-offset-10" value="Save!" name="att" />
  </center>

</form>
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
    window.addEventListener('popstate', function(event) {
    window.location.href = "teacherindex.php";
});
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
