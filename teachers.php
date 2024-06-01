<?php

ob_start();
session_start();

// if($_SESSION['name']!='oasis')
// {
//   header('location: login.php');
// }
?>
<?php include('connect.php');?>

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
    color: #FFF; /* Adjust the color as needed */
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
     @media (max-width: 768px) {
            
            .table th:nth-child(4),
            .table td:nth-child(4),
            
            .table th:nth-child(6),
            .table td:nth-child(6),
            .table th:nth-child(8),
            .table td:nth-child(8) {
                display: none;
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
                <li class="nav-item"><a class="nav-link animated-link" href="teacher_student_view.php">Students</a></li>
                <li class="nav-item"><a class="nav-link animated-link" href="teacher_edit_student_account.php">Edit Students</a></li>
                <li class="nav-item"><a class="nav-link animated-link" href="teachers.php">Faculties</a></li>
                <li class="nav-item"><a class="nav-link animated-link" href="teacherattendance.php">Attendance</a></li>
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
    <h3>Teacher List</h3>
    
    <table class="table table=stripped">
        <thead>  
          <tr>
            <th scope="col">Teacher ID</th>
            <th scope="col">Name</th>
            <th scope="col">Department</th>
            <th scope="col">Phone Number</th>
            <th scope="col">Course</th>
          </tr>
        </thead>

        <?php
$i = 0;
$tcr_query = $conn->query("SELECT * FROM teachers ORDER BY tc_id ASC");

while ($tcr_data = $tcr_query->fetch_assoc()) {
    $i++;
    
    echo '<tbody>';
    echo '<tr>';
    echo '<td>' . $tcr_data['tc_id'] . '</td>';
    echo '<td>' . $tcr_data['tc_name'] . '</td>';
    echo '<td>' . $tcr_data['tc_dept'] . '</td>';
    echo '<td>' . $tcr_data['tc_phone_number'] . '</td>';
    echo '<td>' . $tcr_data['tc_course'] . '</td>';
    echo '</tr>';
    echo '</tbody>';
}
?>

          
    </table>

  </div>

</div>

</center>
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
