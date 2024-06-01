<?php
ob_start();
session_start();

// if (!isset($_SESSION['username'])) {
//     header('Location: login.php');
//     exit;
// }

?>

<?php include('connect.php'); ?>

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
  
  .row {  
    display: flex;
    flex-wrap: wrap;
  }

  .content {
    flex: 30%;
    background-color: white;
    padding: 50px;
  }

  select {
    font-size: 15px;
  }

  option {
    font-size: 15px;
  }

  a:hover {
    color: blue;
  }

  p {
    font-size: 15px;
  }

  img {
    height: 200px;
    width: 300px;
  }

  .user-info {
    float: right;
    margin-top: 10px;
    margin-right: 20px;
    font-weight: bold;
    text-transform: uppercase;
    color: #FFF;
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

  .right-content {
    flex: 50%;
    background-color: #f2f2f2;
    padding: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  @media (max-width: 768px) {
    .content {
        flex: 100%; /* Use full width for content on smaller screens */
        padding: 20px; /* Reduce padding for mobile view */
    }

    .right-content {
        flex: 100%; /* Use full width for chart on smaller screens */
        padding: 20px; /* Reduce padding for mobile view */
    }

    #attendanceChart {
        width: 100%; /* Use full width for the chart canvas */
        height: 300px; /* Adjust the height as needed for mobile view */
    }

    /* Adjust font sizes for better readability on mobile */
    table {
        font-size: 14px;
    }

    th, td {
        padding: 5px 10px;
    }
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

<div class="row">
    <div class="content col-md-6">
        <?php
        $studentId = $_SESSION['st_id'];
        $student_query = $conn->query("SELECT st_id, st_name FROM reports WHERE st_id='$studentId'");

        if ($student_query) {
            $student_data = $student_query->fetch_assoc();
            $studentName = $student_data['st_name'];
            $studentId = $student_data['st_id'];
            // $studentCourse = $student_data['course'];
            $attendance_query = $conn->query("SELECT stat_date, course, st_status FROM reports WHERE st_id='$studentId' ORDER BY stat_date");

            if ($attendance_query) {
                echo '<h3>Overall Attendance Percentage</h3>';
                echo '<table class="table table-striped">';
                echo '<tbody>';
                echo '<tr><th>Date</th><th>Course</th><th>Status</th></tr>';

                $attendanceData = array(); // Store attendance data for each date
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

                // Get today's date and previous four days
                $currentDate = date("Y-m-d");
                $previousDates = array();
                for ($i = 1; $i <= 4; $i++) {
                    $previousDates[] = date("Y-m-d", strtotime("-$i day"));
                }

                $datesToDisplay = array_merge($previousDates, array($currentDate));

                // Step 1: Sort the dates
                sort($datesToDisplay);

                 foreach ($datesToDisplay as $date) {
                     if (isset($attendanceData[$date])) {
                         $rowspan = count($attendanceData[$date]);
                         $first = true;

                         foreach ($attendanceData[$date] as $course => $statuses) {
                             if (!$first) {
                                 echo '<tr>';
                              }

                        $totalClasses = count($statuses);
                        $presentClasses = array_count_values($statuses)['Present'];

                        if ($first) {
                            echo '<td rowspan="' . $rowspan . '">' . $date . '</td>';
                        }

                       echo '<td>' . $course . ' (' . $totalClasses . ')</td>';
                       echo '<td>' . implode(', ', $statuses) . '</td>';

                       if ($first) {
                         echo '</tr>';
                        } else {
                            echo '</tr>';
                        }

                     $first = false;
                   }
               }
            }

                echo '</tbody>';
                echo '</table>';
                echo '<br>';
                echo '<br>';
                
                $totalAttendance = array_reduce($attendanceData, function ($carry, $courses) {
                    return $carry + array_reduce($courses, function ($carry, $statuses) {
                        return $carry + count($statuses);
                    }, 0);
                }, 0);
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
        <!-- Attendance table -->
        <table class="table table-striped">
            <tr><th>Information</th><th>Details</th></tr>
                    <tr><td>Student ID</td><td><?php echo $studentId; ?></td></tr>
                    <tr><td>Student Name</td><td><?php echo $studentName; ?></td></tr>
                    <tr><td>Total Classes</td><td><?php echo $totalAttendance; ?></td></tr>
                    <tr><td>Present Classes</td><td><?php echo $totalPresent; ?></td></tr>
                    <tr><td>Attendance Percentage</td><td><?php echo $attendancePercentage; ?>%</td></tr>
        </table>
    </div>

    <!-- Right content with bar chart -->
    <div class="right-content">
        <canvas id="attendanceChart" width="400" height="200"></canvas>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>


<canvas id="attendanceChart" width="800" height="400"></canvas>

<script>
document.addEventListener("DOMContentLoaded", function () {
    var ctx = document.getElementById("attendanceChart").getContext("2d");
    var courseLabels = <?php echo json_encode(array_keys($attendanceData[array_keys($attendanceData)[0]])); ?>;
    var chart;

    function updateChart() {
        var attendanceData = <?php echo json_encode($attendanceData); ?>;
        var dates = Object.keys(attendanceData);
        var presentCounts = [];
        var absentCounts = [];
        var courseCounts = {};

        var datesToDisplay = dates.slice(-5); // Get the data for the last five dates

        datesToDisplay.forEach(function (date) {
            var courseStatuses = attendanceData[date];
            var presentCount = 0;
            var absentCount = 0;

            for (var course in courseStatuses) {
                var statuses = courseStatuses[course];
                presentCount += statuses.filter(function (status) {
                    return status === "Present";
                }).length;
                absentCount += statuses.filter(function (status) {
                    return status === "Absent";
                }).length;

                if (!courseCounts[course]) {
                    courseCounts[course] = 1;
                } else {
                    courseCounts[course]++;
                }
            }

            presentCounts.push(presentCount);
            absentCounts.push(absentCount);
        });

        // Update or create the chart
        if (chart) {
            chart.data.labels = datesToDisplay;
            chart.data.datasets[0].data = presentCounts;
            chart.data.datasets[1].data = absentCounts;
            chart.update();
        } else {
            chart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: datesToDisplay,
                    datasets: [
                        {
                            label: "Present",
                            data: presentCounts,
                            backgroundColor: "rgba(0, 255, 0, 0.5)",
                            borderColor: "rgba(0, 255, 0, 1)",
                            borderWidth: 1,
                        },
                        {
                            label: "Absent",
                            data: absentCounts,
                            backgroundColor: "rgba(255, 0, 0, 0.5)",
                            borderColor: "rgba(255, 0, 0, 1)",
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    // ... (existing chart options)
                },
            });
        }
    }

    // Call the updateChart function initially
    updateChart();

    // Attach an event listener to the table to update the chart when data changes
    var table = document.querySelector(".table");
    if (table) {
        var observer = new MutationObserver(function () {
            updateChart();
        });
        observer.observe(table, { childList: true, subtree: true });
    }
});
</script>
<script>
    window.addEventListener('popstate', function(event) {
    window.location.href = "studentindex.php";
});
</script>
</body>
</html>
