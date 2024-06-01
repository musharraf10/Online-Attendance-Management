<?php
ob_start();
session_start();

include('connect.php');

try {
    //print_r($_POST);exit;
    if (isset($_POST['att'])) {
        $course = $_POST['whichcourse'];
        $date = $_POST['date'];
        $ids = $_POST['ids'];
        
        foreach ($ids as $key => $val ) {
            $stat_name = 'st_status'.$key;
            $st_status = $_POST[$stat_name][0];
            $stat = $conn->query("UPDATE attendance SET st_status = '$st_status' WHERE id = $key");
            
        }

        $att_msg = "Attendance Updated.";
    }
} catch (Exception $e) {
    $error_msg = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Attendance Management</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
   <style type="text/css">
 body {
            font-family: Arial, sans-serif;
            overflow-x:hidden;
            margin-bottom:10px;
            margin:0;
            padding:0;
            
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            overflow-x:hidden;
        }

        .navbar {
            background-color: #f8f9fa;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #dee2e6;
            overflow-x:hidden;
        }

        .navbar-toggler-icon {
            background: none;
            border: none;
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
    margin-left:2px;
    overflow-x:hidden;
     margin:0;
    padding:0;
}

.content {
    flex: 30%;
    background-color: white; /#3e4651;/
    padding: 50px;
    overflow-x:hidden;
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

         @media (max-width: 992px) {
             
    .content {
        flex: 90%; /* Adjust the content width for smaller screens */
        padding: 15px;
    }
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
            if(isset($_SESSION['username'])) {
                $loggedInUsername = $_SESSION['username'];
                echo strtoupper($loggedInUsername);
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
                <h3>Attendance</h3>
                <br>
                <form action="" method="post" class="form-horizontal col-md-6 col-md-offset-3" autocomplete="off">
                    <div class="form-group">
                        <label for="search_student">Student ID:</label>
                        <input type="text" name="search_student" id="search_student" placeholder="Enter Student ID" oninput="this.value = this.value.toUpperCase();" required>
                    </div>
                    <div class="form-group">
                    <label for="whichcourse">Select Course:</label>
                    <select name="whichcourse" id="whichcourse">
                    <?php
                     if (isset($_SESSION['username'])) {
                         $username = $_SESSION['username'];
                         $query = "SELECT DISTINCT tc_course FROM teachers WHERE tc_name = ?";
                         $stmt = $conn->prepare($query);
                         $stmt->bind_param("s", $username);
                         $stmt->execute();
                         $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['tc_course'] . '">' . $row['tc_course'] . '</option>';
                        }
                      } else {
                         echo '<option value="no-course">No Course Found</option>';
                    }

                        $stmt->close();
        } else {
            echo '<option value="no-session">No Session Found</option>';
        }
        ?>
    </select>
</div>
                    <div class="form-group">
                        <label for="id">Select Date:</label>
                        <input type="date" name="date" id="date" required>
                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                        const dateInput = document.getElementById('date');
                        dateInput.addEventListener('change', function() {
                        const selectedDate = new Date(this.value);
                        const threeDaysAgo = new Date();
                        threeDaysAgo.setDate(threeDaysAgo.getDate() - 3);
                        if (selectedDate < threeDaysAgo) {
                        alert('You can only modify data for the last three days.');
                        this.value = ''; 
                              }
                          });
                        });
                            document.getElementById("date").addEventListener("click", function() {
                             this.click();
                         });
                        </script>
                    </div>

                    <input type="submit" class="btn btn-primary col-md-2 col-md-offset-5" value="Search" name="search_btn" />
                </form>
            <?php
            if (isset($_POST['search_btn'])) {
                $search_query = $_POST['search_student'];
                $course = $_POST['whichcourse'];
                $date = $_POST['date'];
                $attendance_query = "SELECT * FROM attendance WHERE stat_id = '$search_query' AND course = '$course' AND stat_date = '$date'";
                $attendance_result = $conn->query($attendance_query);

                if ($attendance_result->num_rows > 0) {
                 ?>
                 <br>
                 <h5>Attendance Records for <?= $search_query ?> on <?= $date ?> for <?= $course ?></h5>
                 <br>
        <form action="" method="post">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Student ID</th>
                        <th scope="col">Course</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($student_data = $attendance_result->fetch_assoc()) {  //print_R($student_data);exit;?>
                        <tr>
                            <td><?= $student_data['id'] ?><input type="hidden" name="ids[<?php echo  $student_data['id'];?>]"></td>
                            <td><?= $student_data['stat_id'] ?></td>
                            <td><?= $student_data['course'] ?></td>
                            <td><?= $student_data['stat_date'] ?></td>
                            <td>
                              <label><input type="radio" name="st_status<?php echo $student_data['id'];?>[]" value="Present" <?=$student_data['st_status'] == 'Present' ? 'checked' : '';?>> Present</label>
                              <label><input type="radio" name="st_status<?php echo $student_data['id'];?>[]" value="Absent" <?=$student_data['st_status'] == 'Absent' ? 'checked' : '';?>> Absent</label>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <center><br>
                <input type="submit" class="btn btn-primary col-md-2 col-md-offset-10" value="Update" name="att" />
            </center>
        </form>
    <?php
    } else {
        echo '<p>No attendance data found for the selected student, course, and date.</p>';
    }
}
?>
            <center>
                <p><?php if (isset($att_msg)) echo $att_msg;
                    if (isset($error_msg)) echo $error_msg; ?></p>
            </center>
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