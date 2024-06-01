<?php
ob_start();
session_start();
include('studentconnect.php');

if (isset($_GET['st_id'], $_GET['st_phone_number'])) {
    $student_id = $_GET['st_id'];
    $student_username = $_GET['st_phone_number'];

    $delete_query = $conn->query("DELETE FROM students WHERE st_id = '$student_id'");
    $delete_admin_query = $conn->query("DELETE FROM admininfo WHERE phone = '$student_username'");

    if ($delete_query && $delete_admin_query) {
        $success_msg = 'Student data and associated admin data deleted Successfully';
    } else {
        $error_msg = 'Failed to delete Student data and/or associated admin data';
    }
}
if (isset($_POST['delete_all_btn'], $_POST['selected_dept'], $_POST['selected_sem'])) {
    $selected_dept = $_POST['selected_dept'];
    $selected_sem = $_POST['selected_sem'];

    $delete_all_query = $conn->query("DELETE FROM students WHERE st_dept = '$selected_dept' AND st_sem = '$selected_sem'");

    if ($delete_all_query) {
        $success_msg = 'All student data for selected department and semester deleted successfully';
    } else {
        $error_msg = 'Failed to delete all student data for selected department and semester';
    }
}




?>

<?php include('studentconnect.php');?>
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
        .intro-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .intro-img {
            max-width: 50%;
            animation: fadeOut 3s ease-in-out forwards;
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            100% { opacity: 0; display: none; }
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
        <h1 class="animate__animated animate__fadeInUp">Student Details</h1>
        <br>
        <div class="content animate__animated animate__fadeInUp">
            <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">
                <div class="form-group">
                    <label for="input1" class="col-sm-3 control-label">Department</label>
                    <div class="col-sm-7">
                        <input type="text" name="sr_dept" class="form-control" id="input1" placeholder="enter your Dept(IT) to continue" maxlength="6" oninput="this.value = this.value.toUpperCase();" required value="<?php if(isset($_POST['sr_dept'])) { echo $_POST['sr_dept']; } ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="input1" class="col-sm-3 control-label">Semester</label>
                    <div class="col-sm-7">
                        <!--<input type="text" name="st_sem" class="form-control" id="input1" placeholder="enter your Sem(4-1) to continue" maxlength="5" required value="<?php if(isset($_POST['st_sem'])) { echo $_POST['st_sem']; } ?>" />-->
                        <select name="st_sem" class="form-control" id="input1" required>
                            <option value="">Select</option>
                            <option value="1-1" <?php if(isset($_POST['st_sem']) && $_POST['st_sem'] === '1-1') { echo 'selected'; } ?>>1-1</option>
                            <option value="1-2" <?php if(isset($_POST['st_sem']) && $_POST['st_sem'] === '1-2') { echo 'selected'; } ?>>1-2</option>
                            <option value="2-1" <?php if(isset($_POST['st_sem']) && $_POST['st_sem'] === '2-1') { echo 'selected'; } ?>>2-1</option>
                            <option value="2-2" <?php if(isset($_POST['st_sem']) && $_POST['st_sem'] === '2-2') { echo 'selected'; } ?>>2-2</option>
                            <option value="3-1" <?php if(isset($_POST['st_sem']) && $_POST['st_sem'] === '3-1') { echo 'selected'; } ?>>3-1</option>
                            <option value="3-2" <?php if(isset($_POST['st_sem']) && $_POST['st_sem'] === '3-2') { echo 'selected'; } ?>>3-2</option>
                            <option value="4-1" <?php if(isset($_POST['st_sem']) && $_POST['st_sem'] === '4-1') { echo 'selected'; } ?>>4-1</option>
                            <option value="4-2" <?php if(isset($_POST['st_sem']) && $_POST['st_sem'] === '4-2') { echo 'selected'; } ?>>4-2</option>
                        </select>

                    </div>
                </div>
                <input type="submit" class="btn btn-primary col-md-3 col-md-offset-7" value="Go!" name="sr_btn" />
            </form>

            <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">
    <!-- ... Other form inputs ... -->
    <input type="hidden" name="selected_dept" value="<?php echo $_POST['sr_dept']; ?>">
    <input type="hidden" name="selected_sem" value="<?php echo $_POST['st_sem']; ?>">
    <div class="form-group">
        <label for="input1" class="col-sm-3 control-label">Delete All</label>
        <div class="col-sm-7">
            <button type="submit" class="btn btn-danger" id="delete-all-btn" name="delete_all_btn">Delete All Data</button>
        </div>
    </div>
</form>

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
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <?php
                if (isset($_POST['sr_btn'])) {
                    $srbatch = $_POST['sr_dept'];
                    $srsem = $_POST['st_sem'];
                    $i = 0;
                    $all_query = $conn->query("SELECT * FROM students WHERE st_dept = '$srbatch' AND st_sem='$srsem' ORDER BY st_id ASC");

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
                                <a href="?st_id=<?php echo $data['st_id']; ?>&st_phone_number=<?php echo $data['st_phone_number']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
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
    $(document).ready(function() {
        $(".delete-button").on("click", function() {
            var studentId = $(this).data("student-id");
            var phoneNumber = $(this).data("phone-number");
            var rowToRemove = $(this).closest("tr");

            jQuery.ajax({
                type: "POST",
                url: "delete_student.php",
                data: { st_id: studentId, st_phone_number: phoneNumber },
                success: function(response) {
                    rowToRemove.remove();
                    
                    var selectedDept = $("input[name='selected_dept']").val();
                    var selectedSem = $("input[name='selected_sem']").val();
                    
                    jQuery.ajax({
                        type: "POST",
                        url: "fetch_students.php",
                        data: { sr_dept: selectedDept, st_sem: selectedSem },
                        success: function(newStudentDetails) {
                            $("table.table").html(newStudentDetails);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   <script>
       window.addEventListener('popstate', function(event) {
    window.location.href = "adminindex.php";
});
   </script>

</body>
</html>
