<?php
ob_start();
session_start();
include('connect.php');

if(isset($_POST['sr_btn1'])) {
    $selectedDept = $_POST['sr_dept'];
    $selectedSem = $_POST['st_sem'];
}

if(isset($_POST['sr_date'])) {
    $sdate = $_POST['date'];
    $course = $_POST['whichcourse'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Attendance Management System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    
    <!-- Include Bootstrap and other stylesheets -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
   <style type="text/css">
 body {
    font-family: Arial, sans-serif;
    overflow-x: hidden;
    margin: 0;
    padding: 0;
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
        color: ;
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
    justify-content: center; /* Center the content horizontally */
    align-items: flex-start; /* Align items to the top */
    margin: 0;
    padding: 0;
}

.content {
    flex: 80%; /* Adjust the content width */
    max-width: 800px; /* Limit the maximum width */
    background-color: white;
    padding: 20px;
    margin: 10px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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


@media (max-width: 992px) {
    .content {
        flex: 90%; /* Adjust the content width for smaller screens */
        padding: 15px;
    }
}

@media (max-width: 768px) {
    .table th:nth-child(3),
    .table td:nth-child(3),
    .table th:nth-child(4),
    .table td:nth-child(4),
    .table th:nth-child(5),
    .table td:nth-child(5),
    .table th:nth-child(7),
    .table td:nth-child(7),
    .table th:nth-child(8),
    .table td:nth-child(8) {
        display: none;
    }

    .navbar {
        padding: 5px;
    }

    .menu-icon {
        margin: 2px auto;
    }

    .navbar-nav {
        text-align: center;
    }

    .animated-link::before {
        display: none;
    }
    .user-info.right {
    float: right;
    margin-top: 10px;
    margin-right: 20px;
    font-weight: bold;
    text-transform: uppercase;
    color: blue; /* Adjust the color as needed 
}
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
            <h3>Mass Report</h3>

            <?php
            if(!isset($selectedDept) && !isset($selectedSem)) {
                // Display the form for semester and department selection
                ?>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="input1" class="col-sm-3 control-label">Department</label>
                        <div class="col-sm-7">
                            <input type="text" name="sr_dept" class="form-control" id="input1" placeholder="Enter your Dept (IT) to continue" maxlength="6" oninput="this.value = this.value.toUpperCase();" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input1" class="col-sm-3 control-label">Semester</label>
                        <div class="col-sm-7">
                            <select name="st_sem" id="input1" class="form-control" required>
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
                    </div>
                    <input type="submit" class="btn btn-primary col-md-3 col-md-offset-7" value="Go!" name="sr_btn1" />
                </form>
                <?php
            }

            if(isset($selectedDept) && isset($selectedSem) && !isset($sdate) && !isset($course)) {
                // Display the form for subject and date selection
                ?>
                <form method="post" action="">
                    <input type="hidden" name="sr_dept" value="<?php echo $selectedDept; ?>">
                    <input type="hidden" name="st_sem" value="<?php echo $selectedSem; ?>">
                    <div class="form-group">
                        <label for="input1" class="col-sm-3 control-label">Select Subject</label>
                        <div class="col-sm-7">
                            <select name="whichcourse" class="form-control">
                                <?php
                                // Retrieve and display subjects based on selected department and semester
                                $subject_query = "SELECT subject FROM subjects WHERE st_dept = '$selectedDept' AND st_sem = '$selectedSem'";
                                $subject_result = $conn->query($subject_query);

                                if ($subject_result) {
                                    while ($subject_row = $subject_result->fetch_assoc()) {
                                        $subject = $subject_row['subject'];
                                        echo "<option value='$subject'>$subject</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="new">
                       <label for="input1" class="col-sm-3 control-label">Date (yyyy-mm-dd)</label>
                            <div class="col-sm-7">
                                <input type="date" name="date" class="form-control" id="input1" placeholder="Click to select date (yyyy-mm-dd)" />
                            </div>
                    </div>
                             <input type="submit" class="btn btn-primary col-md-3 col-md-offset-7" value="Go!" name="sr_date" />
               </form>
                <?php
            }

            if(isset($sdate) && isset($course)) {
                // Fetch and display the attendance data based on selected date and subject
                $all_query = $conn->query("SELECT * FROM reports WHERE reports.stat_date='$sdate' AND reports.course = '$course'");

                // Display the table with attendance data
                if($all_query) {
                    ?>
                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th scope="col">Student ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Department</th>
                                <th scope="col">Batch</th>
                                <th scope="col">Date</th>
                                <th scope="col">Attendance Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            while ($data = $all_query->fetch_assoc()) {
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $data['st_id']; ?></td>
                                    <td><?php echo $data['st_name']; ?></td>
                                    <td><?php echo $data['st_dept']; ?></td>
                                    <td><?php echo $data['st_batch']; ?></td>
                                    <td><?php echo $data['stat_date']; ?></td>
                                    <td><?php echo $data['st_status']; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <script>
    function fetchAttendanceData() {
        var sdate = '<?php echo $sdate; ?>';
        var course = '<?php echo $course; ?>';
        
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetch_all_query.php?sdate=' + sdate + '&course=' + course, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('new').innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }
</script>
                        </tbody>
                    </table>
                    <!-- <form method="post" action="generate_excel.php">-->
                    <!--    <input type="hidden" name="sdate" value="<?php echo $sdate; ?>">-->
                    <!--    <input type="hidden" name="course" value="<?php echo $course; ?>">-->
                    <!--    <button type="submit" class="btn btn-success">Download Excel</button>-->
                    <!--</form>-->
                    <?php
                }
            }
            ?>
        </div>
    </div>
</center>
<!-- Include jQuery, Popper.js, and Bootstrap JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    window.addEventListener('popstate', function(event) {
    window.location.href = "teacherindex.php";
});
</script>
</body>
</html>
