<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();

include('connect.php');
$error_msg = "";
$success_msg = "";


// Handle form submission for adding subjects
if (isset($_POST['submit'])) {
    $department = $_POST['department'];
    $semester = $_POST['semester'];
    $numSubjects = $_POST['numSubjects'];

    $stmtSubject = $conn->prepare("INSERT INTO subjects (st_dept, st_sem, subject) VALUES (?, ?, ?)");
    if (!$stmtSubject) {
        die("Error preparing statement: " . $conn->error);
    }

    for ($i = 1; $i <= $numSubjects; $i++) {
        $subjectName = $_POST["subject$i"];
        $result = $stmtSubject->bind_param("sss", $department, $semester, $subjectName);
        if (!$result) {
            die("Error binding parameters: " . $stmtSubject->error);
        }
        if (!$stmtSubject->execute()) {
            $error_msg = "Error adding subjects: " . $stmtSubject->error;
            break;
        }
    }

    if (empty($error_msg)) {
        $success_msg = "Subjects added successfully.";
    }

    $stmtSubject->close();
}

if (isset($_POST['delete_subject'])) {
    $subjectToDelete = $_POST['delete_subject'];
    
    $stmtDelete = $conn->prepare("DELETE FROM subjects WHERE subject = ?");
    $stmtDelete->bind_param("s", $subjectToDelete);
    
    if ($stmtDelete->execute()) {
        $success_msg="Subject Deleted successfully";
    } else {
        $error_msg = "Error deleting subject.";
    }
    
    $stmtDelete->close();
}
if (isset($_POST['old_subject']) && isset($_POST['new_subject'])) {
    $oldSubject = $_POST['old_subject'];
    $newSubject = $_POST['new_subject'];
    
    $stmtUpdate = $conn->prepare("UPDATE subjects SET subject = ? WHERE subject = ?");
    $stmtUpdate->bind_param("ss", $newSubject, $oldSubject);
    
    if ($stmtUpdate->execute()) {
        $success_msg="Subject Edited successfully";
    } else {
        $error_msg = "Error updating subject.";
    }
    
    $stmtUpdate->close();
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
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh; /* Adjust the height as needed */
    text-align: center;
    margin-top: 20px; /* Add margin at the top of the container */
    background-color: transparent; /* Set background color to transparent */
    margin-bottom: 0; /* Remove the bottom margin */
}

/* Add margin to the top of .container for gap */
.container {
    margin-top: 50px; /* Adjust the margin value as needed */
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
            margin-top:30px;
        }
        .menu-icon {
            display: block;
            width: 25px;
            height: 2px;
            margin: 4px auto;
            background-color: #333;
        }
        h1{
            padding:30px;
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
   </header>                
            </div>
        </nav>
    
        </div>
    </nav>
    <center>
        <h1>Add Subjects</h1>
<?php
if(isset($success_msg)) {
    echo '<p id="successMessage">' . $success_msg . '</p>';
    echo '<script>setTimeout(() => document.querySelector("#successMessage").style.display = "none", 3000);</script>';
}

if(isset($error_msg)) {
    echo '<p>' . $error_msg . '</p>';
    echo '<script>setTimeout(() => document.querySelector("#error_msg").style.display = "none", 3000);</script>';
}
?>
        <br>
        <div class="row">
            <div class="col-md-12">
                <button id="addSubjectsBtn" class="btn btn-primary">Add Subjects</button>
                <button id="showSubjectsBtn1" class="btn btn-primary">See Subjects</button>
            </div>
        </div>
        <div class="content">
            <div class="row" id="addSubjectsBtn1" class="center-form" style="display:none;">
                <div class="col-md-9">
                    <form method="post" class="form-horizontal col-md-12" autocomplete="off">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Semester</label>
                            <div class="col-sm-7">
                                <!--<input type="text" name="semester" class="form-control" maxlength="3" placeholder="Ex : 1-1 , 2-2, 3-1 , 4-1 ..." required/>-->
                                <select name="semester" class="form-control" required>
                                    <option value="">Select</option>
                                    <option>1-1</option>
                                    <option>1-2</option>
                                    <option>2-1</option>
                                    <option>2-2</option>
                                    <option>3-1</option>
                                    <option>3-2</option>
                                    <option>4-1</option>
                                    <option>4-2</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Department(2-5 characters)</label>
                            <div class="col-sm-7">
                                <input type="text" name="department" class="form-control" oninput="this.value = this.value.toUpperCase();" placeholder="Enter Department (IT)" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Number of Subjects</label>
                            <div class="col-sm-7">
                                <input type="number" name="numSubjects" id="numSubjects" class="form-control" placeholder="Enter Subjects Count..." required/>
                            </div>
                        </div>
                        <div id="subjectFields"></div>
                        <div class="form-group">
                            <div class="col-sm-7 col-sm-offset-3">
                                <input type="submit" class="btn btn-primary" value="Add Subjects" name="submit"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="row" id="showSubjectsBtn2" style="display:none;" class="center-form">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h2>Show Subjects</h2>
                            <form method="get" class="form-horizontal" autocomplete="off">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Semester</label>
                                    <div class="col-sm-7">
                                        <!--<input type="text" id="show_semester" name="show_semester" class="form-control" placeholder="Enter the Semester ,Ex 4-1" required/>-->
                                <select name="show_smester" id=show_semester class="form-control">
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
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Department</label>
                                    <div class="col-sm-7">
                                        <input type="text" id="show_department" name="show_department" class="form-control" placeholder="Enter Department 2 to 3 Words..." oninput="this.value = this.value.toUpperCase();" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-7 col-sm-offset-4">
                                        <button type="button" id="showSubjectsBtn" class="btn btn-primary">Show Subjects</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="subjectListContainer"></div>
                </div>
            </div>
        </div>
    </center>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById("numSubjects").addEventListener("input", function () {
            var numSubjects = parseInt(this.value);
            var subjectFields = document.getElementById("subjectFields");
            subjectFields.innerHTML = "";
            for (var i = 1; i <= numSubjects; i++) {
                var subjectField = document.createElement("div");
                subjectField.className = "form-group";
                subjectField.innerHTML = `
                    <label class="col-sm-3 control-label">Subject ${i}</label>
                    <div class="col-sm-7">
                        <input type="text" id="subject${i}" name="subject${i}" class="form-control" placeholder="Enter Subject No : ${i}" oninput="this.value = this.value.toUpperCase();" required/>
                    </div>`;
                subjectFields.appendChild(subjectField);
            }
        });
    </script>
    <script>
       
        function load(){
             var editButtons = document.querySelectorAll(".edit-btn");
            editButtons.forEach(function (button) {
                button.addEventListener("click", function () {
                    var subjectName = button.getAttribute("data-subject");
                    var form = document.createElement("form");
                    form.method = "post";
                    form.action = "";
                    var subjectInput = document.createElement("input");
                    subjectInput.type = "text";
                    subjectInput.name = "new_subject";
                    subjectInput.value = subjectName;
                    subjectInput.className = "form-control";
                    form.appendChild(subjectInput);
                    var oldSubjectInput = document.createElement("input");
                    oldSubjectInput.type = "hidden";
                    oldSubjectInput.name = "old_subject";
                    oldSubjectInput.value = subjectName;
                    form.appendChild(oldSubjectInput);
                    var updateButton = document.createElement("input");
                    updateButton.type = "submit";
                    updateButton.className = "btn btn-success";
                    updateButton.value = "Update";
                    form.appendChild(updateButton);
                    var subjectCell = button.parentElement.previousElementSibling;
                    subjectCell.innerHTML = "";
                    subjectCell.appendChild(form);
                    
                });
            });
        }
    </script>
    <script>
        document.getElementById("addSubjectsBtn").addEventListener("click", function () {
            document.getElementById("addSubjectsBtn1").style.display = "block";
            document.getElementById("showSubjectsBtn2").style.display = "none";
        });
        document.getElementById("showSubjectsBtn1").addEventListener("click", function () {
            document.getElementById("showSubjectsBtn2").style.display = "block";
            document.getElementById("addSubjectsBtn1").style.display = "none";
        });
    </script>
    
    <script>
    $(document).ready(function () {
            $("#showSubjectsBtn").on("click",function(){
            var semester = $("#show_semester").val();//document.querySelector('input[name="show_semester"]').value;
            var department = $("#show_department").val();//document.querySelector('input[name="show_department"]').value;
    jQuery.ajax({
        type: 'GET',
        url: 'fetch_subjects.php',
        data: {
            show_semester: semester,
            show_department: department
        },
        success: function (data) {
            var subjectListContainer = document.getElementById("subjectListContainer");
            if (subjectListContainer) {
                subjectListContainer.innerHTML = data;
                subjectListContainer.style.display = "block";
                load();
            }
             
        },
        error: function (error) {
            console.log('Error:', error);
        }
    })
            })
    });  

    

    </script>
    
<script>
    window.onload = function() {
        var form = document.querySelector('form');
        if (form) {
            form.reset(); // This will clear all form fields
        }
    }
</script>
<script>
    window.addEventListener('popstate', function(event) {
    window.location.href = "adminindex.php";
});
</script>


</body>
</html>
