<?php
ob_start();
session_start();
?>

<?php include('connect.php'); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <title>Attendance Management</title>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"> 
    <!--<link rel="stylesheet" href="styles.css"><!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Include jQuery and Bootstrap JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="studentindex.css">
    
   <style type="text/css">
 body {
            font-family: Arial, sans-serif;
              overflow-x:hidden;
        }
     .table-container {
    width: 80%;
    padding: 40px;
    margin-left: 150px;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  #comments {
        text-align: center;
        margin: auto;
        max-width: 80%; 
    }
  .comments {
        position: relative;
        margin-top: 20px;
        margin-right: 200px;
        width: 100%;
        text-align: right; 
    }
    
    .comments ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .comments h6 {
        font-size: 14px;
        margin: 5px 0;
        color: black;
    }
    .container{
        margin-top:25px;
        margin-bottom:25px;
    }
    .left{
        display:block;
        width:50%;
    }
    
    </style>
</head>
<body>
    
<div class="header">
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
</div>
 
<div class="row">
    <div class="wrapper col-md-6">
      <header>
        <p class="current-date"></p>
        <div class="icons">
          <span id="prev" class="material-symbols-rounded">chevron_left</span>
          <span id="next" class="material-symbols-rounded">chevron_right</span>
        </div>
      </header>
      <div class="calendar">
        <ul class="weeks">
          <li>Sun</li>
          <li>Mon</li>
          <li>Tue</li>
          <li>Wed</li>
          <li>Thu</li>
          <li>Fri</li>
          <li>Sat</li>
        </ul>
        <ul class="days"></ul>

      </div>
      <div class="comments" id="comments">
       <ul>
  <li>
    <h6 style="font-family: italic; font-weight: bold;"><span style="color: green; font-family: italic;">Green - More than 75% </span></h6>
  </li>
  <li>
    <h6 style="font-family: italic; font-weight: bold;"><span style="color: orange; font-family: italic;">Orange - Above 50% Below 75%</span></h6>
  </li>
  <li>
    <h6 style="font-family: italic; font-weight: bold;"><span style="color: red; font-family: italic;">Red - Less than 50% </span></h6>
  </li>
  <li>
    <h6 style="font-family: italic; font-weight: bold; font-style: italic;"><span style="color: black; font-family: italic;">Note:- Day-to-Day Percentage</span></h6>
  </li>
</ul>

    </div>
    </div>  
    <br>
    <br>
    <br>
    <div class="content col-md-6">
           <?php
        $studentId = $_SESSION['st_id'];
        $student_query = $conn->query("SELECT st_id, st_name FROM reports WHERE st_id='$studentId'");

        if ($student_query) {
            $student_data = $student_query->fetch_assoc();
            $studentName = $student_data['st_name'];
            $studentId = $student_data['st_id'];
            $attendance_query = $conn->query("SELECT stat_date, course, st_status FROM reports WHERE st_id='$studentId' ORDER BY stat_date");

            if ($attendance_query) {


                $attendanceData = array();
                while ($data = $attendance_query->fetch_assoc()) {
                    $date = $data['stat_date'];
                    $course = $data['course'];
                    $status = $data['st_status'];

                    if (!isset($attendanceData[$date])) {
                        $attendanceData[$date] = array();
                    }
                    if (!isset($attendanceData[$date][$course])) {
                        $attendanceData[$date][$course] = array();
                    }
                    $attendanceData[$date][$course][] = $status;
                }
                $currentDate = date("Y-m-d");
                $previousDates = array();
                for ($i = 1; $i <= 4; $i++) {
                    $previousDates[] = date("Y-m-d", strtotime("-$i day"));
                }
                $datesToDisplay = array_merge($previousDates, array($currentDate));
                sort($datesToDisplay);

                 foreach ($datesToDisplay as $date) {
                     if (isset($attendanceData[$date])) {
                         $rowspan = count($attendanceData[$date]);
                         $first = true;
                         foreach ($attendanceData[$date] as $course => $statuses) {
                        $totalClasses = count($statuses);
                        $presentClasses = array_count_values($statuses)['Present'];
                   }
               }
            }
                $totalAttendance = array_reduce($attendanceData, function ($carry, $courses) {
                    return $carry + array_reduce($courses, function ($carry, $statuses) {
                        return $carry + count($statuses);
                    },0);
                },0);
                $totalPresent = array_reduce($attendanceData, function ($carry, $courses) {
                    return $carry + array_reduce($courses, function ($carry, $statuses) {
                        return $carry + array_count_values($statuses)['Present'];
                    }, 0);
                }, 0);

                if ($totalAttendance > 0) {
                    $attendancePercentage = ($totalPresent / $totalAttendance) * 100;
                } else {
                    $attendancePercentage = 0;
                }
                $absentDays = $totalAttendance - $totalPresent;
            }
        }
        
        ?>
        <div class="container chart" data-size="350" data-value="<?php echo $attendancePercentage; ?>" data-arrow="up"></div>
    </div>
</div>
 
    
    <script>
document.addEventListener("DOMContentLoaded", function () {
  let commentsIndex = 0;
  const commentsList = document.querySelectorAll(".comments ul li");
  const hideAllComments = () => {
    commentsList.forEach((li) => {
      li.style.display = "none";
    });
  };
  hideAllComments();

  setInterval(function () {
    hideAllComments();
    commentsList[commentsIndex].style.display = "block";
    commentsIndex = (commentsIndex + 1) % commentsList.length;
  }, 5000);
});
</script>
    <script src="studentindexscript.js" defer></script>
</body>
</html>
