<?php
ob_start();
session_start();


?>

<?php include('connect.php'); ?>

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
       
.row {  

    display: flex;
    flex-wrap: wrap;
}

.content {
    flex: 30%;
    background-color: white; /*#3e4651;*/
    padding: 50px;
    justify-content: center;
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


        .menu-icon {
            display: block;
            width: 25px;
            height: 2px;
            margin: 4px auto;
            background-color: #333;
        }
        
        /* ... Media queries and other styles ... */
        
    @media (max-width: 768px) {
            .table th:nth-child(3),
            .table td:nth-child(3),
            .table th:nth-child(4),
            .table td:nth-child(4),

            .table th:nth-child(7),
            .table td:nth-child(7),
            .table th:nth-child(8),
            .table td:nth-child(8) {
                display: none;
            }
            .table th,
    .table td {
        font-size: 13px;
    }
            
        }

    </style>
</head>

<body>
    <header>
        <h1>Admin</h1>
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
                   <li class="nav-item"><a class="nav-link animated-link" href="adminindex.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link animated-link" href="adminsignup.php">Add Admin</a></li>
                    <li class="nav-item"><a class="nav-link animated-link" href="admin_subjects_add.php">Add Subjects</a></li>
                    <li class="nav-item"><a class="nav-link animated-link" href="students.php">Students</a></li>
                    <li class="nav-item"><a class="nav-link animated-link" href="admin_all_percentage_view.php">Percentages%</a></li>
                    <li class="nav-item"><a class="nav-link animated-link" href="teacheradd.php">Add Teacher</a></li>
                    <li class="nav-item"><a class="nav-link animated-link" href="absenties.php">Send SMS</a></li>
                    <li class="nav-item"><a class="nav-link animated-link" href="logout.php">Logout</a></li>
                
                </ul>
            </div>
            <div class="right-elements">
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
        </nav>
    </header>
    <center>
        <div class="row">
            <div class="content">
                <h3>Students Attendance Percentage</h3>
                <br>
                <form method="POST" autocomplete="off">
                    <label for="batch">Batch: </label>
                    <input type="text" name="batch" id="batch" placeholder="Enter Batch (20)">
<br>
                    <label for="dept">Dept:</label>
                    <input type="text" name="dept" id="dept" placeholder="Enter Department" oninput="this.value = this.value.toUpperCase();" required>
<br>
                    <input type="submit" name="filter" value="Filter">
                </form>

                <?php
                if (isset($_POST['filter'])) {
                    $selectedBatch = $_POST['batch'];
                    $selectedDept = $_POST['dept'];
                    $query = "SELECT st_id, st_name, st_batch, st_dept, ";
                    $query .= "SUM(CASE WHEN st_status='Present' THEN 1 ELSE 0 END) AS presentClasses, ";
                    $query .= "COUNT(*) AS totalClasses ";
                    $query .= "FROM reports WHERE 1 ";

                    if (!empty($selectedBatch)) {
                        $query .= "AND st_batch LIKE '%$selectedBatch%' ";
                    }

                    if (!empty($selectedDept)) {
                        $query .= "AND st_dept LIKE '%$selectedDept%' ";
                    }

                    $query .= "GROUP BY st_id, st_name, st_batch, st_dept";

                    // Execute the query
                    $filteredStudentsQuery = $conn->query($query);

                    if ($filteredStudentsQuery) {
                        echo '<table class="table table-striped">';
                        echo '<thead>';
                        echo '<tr><th>Student ID</th><th>Student Name</th><th>Batch</th><th>Department</th><th>Attendance Percentage</th></tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        while ($studentData = $filteredStudentsQuery->fetch_assoc()) {
                            $studentId = $studentData['st_id'];
                            $studentName = $studentData['st_name'];
                            $studentBatch = $studentData['st_batch'];
                            $studentDept = $studentData['st_dept'];
                            $presentClasses = $studentData['presentClasses'];
                            $totalClasses = $studentData['totalClasses'];

                            if ($totalClasses > 0) {
                                $attendancePercentage = ($presentClasses / $totalClasses) * 100;
                            } else {
                                $attendancePercentage = 0; // Avoid division by zero
                            }

                            echo '<tr>';
                            echo '<td>' . $studentId . '</td>';
                            echo '<td>' . $studentName . '</td>';
                            echo '<td>' . $studentBatch . '</td>';
                            echo '<td>' . $studentDept . '</td>';
                            echo '<td>' . number_format($attendancePercentage, 2) . '%</td>';
                            echo '</tr>';
                        }

                        echo '</tbody>';
                        echo '</table>';
                    } else {
                        echo "Filtered student query error: " . $conn->error;
                    }
                }
                ?>
            </div>
        </div>
    </center>
</body>  
 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
    window.location.href = "adminindex.php";
});
</script>
<!--<script>-->

<!--    window.onbeforeunload = function() {-->
<!--        return "You have unsaved changes. Are you sure you want to leave this page?";-->
<!--    };-->
<!--</script>-->


</html>