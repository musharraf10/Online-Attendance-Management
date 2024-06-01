<?php

ob_start();
session_start();

// if($_SESSION['name']!='oasis')
// {
//   header('location: login.php');
// }
?>
<?php include('connect.php');?>

<?php 
$studentDept = $_SESSION['st_dept'];
$studentSem = $_SESSION['st_sem'];
$subject_query = "SELECT subject FROM subjects WHERE st_dept = '$studentDept' AND st_sem = '$studentSem'";
$subject_result = $conn->query($subject_query);

if ($subject_result) {
    $subjects = array();
    while ($subject_row = $subject_result->fetch_assoc()) {
        $subjects[] = $subject_row['subject'];
    }
    $_SESSION['subjects'] = $subjects;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<title>Online Attendance Management System</title>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <!-- Include Bootstrap and other stylesheets -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  
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
        color: blue; /* Add this line to change the color to blue */
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
.user-info {
    float: right;
    margin-top: 10px;
    margin-right: 20px;
    font-weight: bold;
    text-transform: uppercase;
    color: blue; /* Adjust the color as needed */
}

        
    </style>

</head>

<body>
<header>
    <h1>Student</h1>
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
                <li class="nav-item"><a class="nav-link animated-link" href="studenthome.php">Home</a></li>
                <li class="nav-item"><a class="nav-link animated-link" href="studentindex.php">Cummulative Attendence</a></li>
                <li class="nav-item"><a class="nav-link animated-link" href="studentreport.php">My Report</a></li>
                <li class="nav-item"><a class="nav-link animated-link" href="studentaccount.php">Student Account</a></li>
                <li class="nav-item"><a class="nav-link animated-link" href="student_percentage.php">Daily Overview</a></li>
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


<!-- Menus ended -->

<center>

<!-- Content, Tables, Forms, Texts, Images started -->
<div class="row">

  <div class="content">
    <h3>Student Report</h3>
    <br>
    <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">

  <div class="form-group">

    <label  for="input1" class="col-sm-3 control-label">Select Course</label>
      <div class="col-sm-4">
      <select name="whichsubject" id="input1">
        <?php
        if (isset($_SESSION['subjects'])) {
            foreach ($_SESSION['subjects'] as $subject) {
                echo '<option value="' . $subject . '">' . $subject . '</option>';
            }
        }
        ?>
    </select>
      </div>

  </div>

  <div class="form-group">
    <label for="input1" class="col-sm-3 control-label">Your Roll Number</label>
    <div class="col-sm-7">
        <p class="form-control-static"><?php echo $_SESSION['st_id']; ?></p>
    </div>
</div>
        <input type="submit" class="btn btn-primary col-md-3 col-md-offset-7" value="Go!" name="sr_btn" />
    </form>

    <div class="content"><br></div>

    <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">
    <table class="table table-striped">
    <?php
if (isset($_POST['sr_btn'])) {
    $sr_id = $_SESSION['st_id'];
    $course = $_POST['whichsubject'];
    
    $i = 0;
    $count_pre = 0;
    
    
    $all_query = $conn->query("SELECT * FROM reports WHERE st_id='$sr_id' AND course = '$course'");

    if ($all_query) {
        $count_tot = $all_query->num_rows;

        if ($count_tot > 0) {
            while ($data = $all_query->fetch_assoc()) {
                $i++;
                if ($data['st_status'] == "Present") {
                    $count_pre++;
                }

                if ($i === 1) {
                    echo '<tbody>';
                    echo '<tr>';
                    echo '<td>Student ID: </td>';
                    echo '<td>' . (isset($data['st_id']) ? $data['st_id'] : "N/A") . '</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td>Student Name: </td>';
                    echo '<td>' . (isset($data['st_name']) ? $data['st_name'] : "N/A") . '</td>';
                    echo '</tr>';

                }
                if ($i >= $count_tot) {
                    
                    echo '<tr>';
                    echo '<td>Total Class (Days): </td>';
                    echo '<td>' . $count_tot . '</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td>Present (Days): </td>';
                    echo '<td>' . $count_pre . '</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td>Absent (Days): </td>';
                    echo '<td>' . ($count_tot - $count_pre) . '</td>';
                    echo '</tr>';

                    
                    echo '</tbody>';
                }
            }
        } else {
            echo '<tr><td colspan="2" class="text-center text-danger">No attendance records available for the selected student and subject.</td></tr>';
        }
    } else {
       
        echo "Query error: " . $conn->error;
    }
}
?>
</table>
  </form>
  </div>
</div>
</center>
 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    window.addEventListener('popstate', function(event) {
    window.location.href = "studentindex.php";
});
</script>
</body>
</html>
