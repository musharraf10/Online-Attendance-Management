<?php
ob_start();
session_start();
?>

<?php include('studentconnect.php');?>

<?php 
try {
    if(isset($_POST['done'])) {
        $sid = $_POST['id'];
        $username_query = $conn->query("SELECT st_username FROM students WHERE st_id='$sid'");
        $username_row = $username_query->fetch_assoc();
        $st_username = $username_row['st_username'];

        $result = $conn->query("update students set st_sem='$_POST[semester]', st_phone_number = '$_POST[number]' where st_id='$sid'");
        $success_msg = 'Your Details are ';

        $result_admininfo = $conn->query("UPDATE admininfo SET phone = '$_POST[number]' WHERE username='$st_username'");
        $success_msg .= ' Updated  successfully';
    }
} catch(Exception $e){
    $error_msg = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Attendance Management System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
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
            color: blue;
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
            color: blue;
        }

        .menu-icon {
            display: block;
            width: 25px;
            height: 2px;
            margin: 4px auto;
            background-color: #333;
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
        <h3>Update Account</h3>
        <br>
        <p>
            <?php
            if(isset($success_msg)) {
                echo $success_msg;
            }
            if(isset($error_msg)) {
                echo $error_msg;
            }
            ?>
        </p>
        <br>
        <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">
            <div class="form-group">
                <label for="input1" class="col-sm-3 control-label">Student ID</label>
                <div class="col-sm-7">
                    <input type="text" name="sr_id"  class="form-control" id="input1" oninput="this.value = this.value.toUpperCase();" placeholder="enter your id to continue" />
                </div>
            </div>
            <input type="submit" class="btn btn-primary col-md-3 col-md-offset-7" value="Go!" name="sr_btn" />
        </form>
        <div class="content"></div>
        <?php
        if(isset($_POST['sr_btn'])) {
            $sr_id = $_POST['sr_id'];
            $i = 0;
            $all_query = $conn->query("SELECT * FROM students WHERE st_id='$sr_id'");
            while ($data = $all_query->fetch_assoc()) {
                $i++;
        ?>
        <form action="" method="post" class="form-horizontal col-md-6 col-md-offset-3">
            <table class="table table-striped">
                <tr>
                    <td>Student ID:</td>
                    <td><?php echo $data['st_id']; ?></td>
                </tr>
                <tr>
                    <td>Student's Name:</td>
                    <td><?php echo $data['st_name']; ?></td>
                </tr>
                <tr>
                    <td>Department:</td>
                    <td><?php echo $data['st_dept']; ?></td>
                </tr>
                <tr>
                    <td>Batch:</td>
                    <td><?php echo $data['st_batch']; ?></td>
                </tr>
                <tr>
                    <td>Semester:</td>
                    <td><input type="text" name="semester" value="<?php echo $data['st_sem']; ?>"></input></td>
                </tr>
                <tr>
                    <td>Mobile No:</td>
                    <td><input type="text" name="number" value="<?php echo $data['st_phone_number']; ?>"></input></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><?php echo $data['st_email']; ?></td>
                </tr>
                <input type="hidden" name="id" value="<?php echo $sr_id; ?>">
                <tr><td></td></tr>
                <tr>
                    <td></td>
                    <td><input type="submit" class="btn btn-primary col-md-3 col-md-offset-7" value="Update" name="done" /></td>
                </tr>
            </table>
        </form>
        <?php 
            } 
        }  
        ?>
    </div>
</div>
</center>
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
    window.location.href = "teacherindex.php";
});
</script>

</body>
</html>
