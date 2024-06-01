<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$dbhost = "localhost";
$dbuser = "nriitac_student";
$dbpass = "College@123456";
$db = "nriitac_st_attendence";
$conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n" . $conn->error);

$session_save_path = '/home/nriitac/public_html/college/session';
if (!is_dir($session_save_path)) {
    mkdir($session_save_path, 0700, true);
}
ini_set('session.save_path', $session_save_path);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["dept"]) && isset($_POST["semester"]) && isset($_POST["course"])) {
        $dept = $_POST["dept"];
        $semester = $_POST["semester"];
        $course = $_POST["course"];
        $username = $_SESSION["username"];

        $stmt = $conn->prepare("INSERT INTO teachers (tc_name, tc_dept, tc_course, tc_sem) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $dept, $course, $semester);
        
        if ($stmt->execute()) {
            $success_msg = "Subject Add successfully.";
            
        } else {
            $error_msg = "Sorry Error Occured!, Try Again";
        }
        $stmt->close();
    }
}

$conn->close();
?>
<script>setTimeout(() => document.getElementById("success-msg").style.display = "none", 2000);</script>
<script>setTimeout(() => document.getElementById("error-msg").style.display = "none", 2000);</script>

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
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    .menu-icon {
        display: block;
        width: 25px;
        height: 2px;
        margin: 4px auto;
        background-color: #333;
    }
    .options {
        display: flex;
        justify-content: center;
        margin: 50px;
    }
    .option {
        padding: 10px 20px;
        cursor: pointer;
        border: 1px solid #007bff;
        background-color: #007bff;
        color: white;
        margin: 0 10px;
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
    }
    .option:hover {
        background-color: white;
        color: #007bff;
    }
    .form-horizontal {
        display: none;
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        animation: slide-up 0.5s ease-out;
    }
    .form-group label {
        font-weight: bold;
    }
    .form-group input {
        margin-top: 5px;
    }
    .btn-primary {
        display: block;
        width: 100%;
        margin-top: 20px;
    }
    @keyframes slide-up {
        from {
            transform: translateY(100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
     @media (max-width: 576px) {
        .options {
            display: flex;
            flex-direction: column; /* Stack buttons vertically */
            align-items: center; /* Center buttons horizontally */
            justify-content: center; /* Center buttons vertically */
            margin:10px; /* Set container height to viewport height */
            padding: 50px; /* Add padding for gap */
        }

        .option {
            padding: 10px 20px;
            cursor: pointer;
            border: 1px solid #007bff;
            background-color: #007bff;
            color: white;
            margin: 10px 0; /* Add margin for spacing between buttons */
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .option:hover {
            background-color: white;
            color: #007bff;
        }
    }
    @media (max-width: 576px) {
        .overflow-x: hidden;
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
    .btn{
        display:inline-block;
        margin:1px;
        width:50px;
        font-size:0.5em;
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
                ?>
            </div>
        </nav>
    </header>
    <div class="options">
        <div class="option" id="addOption">Add</div>
        <div class="option" id="updateOption">Update</div>
    </div>
    <div class="form-container" id="formContainer">
        <div class="form-horizontal" id="addForm">
             <br>
                 <p>
                 <?php
                    if (isset($success_msg)) echo '<div id="success-msg">' . $success_msg . '</div>';
                    if (isset($error_msg)) echo '<div id="error-msg">' . $error_msg . '</div>';
                 ?>
                 </p>
                <br>
            <form method="post" autocomplete="off">
               
                <label for="dept">Department:</label>
                <input type="text" id="dept" name="dept" oninput="this.value = this.value.toUpperCase();" class="form-control" placeholder="Department"  required>

                <label for="semester">Semester:</label>
                <input type="text" id="semester" name="semester" class="form-control" placeholder="Semester" >

                <label for="course">Course:</label>
                <input type="text" id="course" name="course" class="form-control" oninput="this.value = this.value.toUpperCase();" placeholder="Course" required>
                
                <button class="btn btn-primary" type="submit">Submit</button>
            </form>
        </div>
       <div class="form-horizontal" id="updateForm">
            <form method="post">
    <table class="table">
    <thead>
        <tr>
            <th>Department</th>
            <th>Semester</th>
            <th>Course</th>
            <th>Actions</th> <!-- Add a new column for actions -->
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch data from the database and populate the table
        if (isset($_SESSION['username'])) {
            $loggedInUsername = $_SESSION['username'];
            $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n" . $conn->error);

            $sql = "SELECT tc_dept, tc_sem, tc_course,tc_id FROM teachers WHERE tc_name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $loggedInUsername);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['tc_dept'] . "</td>";
                echo "<td>" . $row['tc_sem'] . "</td>";
                echo "<td>" . $row['tc_course'] . "</td>";
                echo '<td>
                      <a class="edit-btn" data-subject="' . $row['tc_course'] . '" data-tc-id="' . $row['tc_id'] . '">Edit</a> |
                       <a class="delete-btn" data-id="' . $row['tc_id'] . '">Delete</a>
                      </td>';
                      

                echo "</tr>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>
    </tbody>
</table>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const addOption = document.getElementById("addOption");
            const updateOption = document.getElementById("updateOption");
            const addForm = document.getElementById("addForm");
            const updateForm = document.getElementById("updateForm");
            const updateDept = document.getElementById("updateDept");
            const updateSemester = document.getElementById("updateSemester");
            const updateCourse = document.getElementById("updateCourse");

            addOption.addEventListener("click", function () {
                addForm.style.display = "block";
                updateForm.style.display = "none";
            });

           updateOption.addEventListener("click", function () {
    addForm.style.display = "none";
    updateForm.style.display = "block";

    <?php
    if (isset($_SESSION['username'])) {
        $loggedInUsername = $_SESSION['username'];

        $dbhost = "localhost";
        $dbuser = "nriitac_student";
        $dbpass = "College@123456";
        $db = "nriitac_st_attendence";

        $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n" . $conn->error);

        $sql = "SELECT tc_dept, tc_sem, tc_course FROM teachers WHERE tc_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $loggedInUsername);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $tc_dept = $row['tc_dept'];
            $tc_sem = $row['tc_sem'];
            $tc_course = $row['tc_course'];
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    updateDept.value = "<?php echo $tc_dept; ?>";
    updateSemester.value = "<?php echo $tc_sem; ?>";
    updateCourse.value = "<?php echo $tc_course; ?>";
});

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
<script>
document.addEventListener('DOMContentLoaded', function () {
    var editButtons = document.querySelectorAll(".edit-btn");
    editButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            var subjectName = button.getAttribute("data-subject");
            var tcId = button.getAttribute("data-tc-id");

            var form = document.createElement("form");
            form.method = "post";
            form.action = "";
            var subjectInput = document.createElement("input");
            subjectInput.type = "text";
            subjectInput.name = "new_subject";
            subjectInput.style.width = "50px";
            subjectInput.value = subjectName;
            form.appendChild(subjectInput);

            var subjectCell = button.parentElement.previousElementSibling;
            var originalContent = subjectCell.innerHTML; // Store the original content

            subjectCell.innerHTML = ""; // Clear the cell
            subjectCell.appendChild(form);

            var actionCell = button.parentElement;
            var editButton = document.createElement("button");
            editButton.type = "button";
            editButton.className = "btn btn-success";
            editButton.textContent = "Update";
            editButton.addEventListener("click", function () {
                var updatedSubject = subjectInput.value;
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "update_course.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            subjectCell.innerHTML = updatedSubject; // Display the updated course directly
                            actionCell.appendChild(button); // Show the "Edit" button again
                            cancelButton.style.display = "none";
                            editButton.style.display = "none";
                        } else {
                            console.error("Update failed");
                        }
                    }
                };
                xhr.send("new_subject=" + updatedSubject + "&tc_id=" + tcId);
            });


            var cancelButton = document.createElement("button"); // Add a "Cancel" button
            cancelButton.type = "button";
            cancelButton.className = "btn btn-danger";
            cancelButton.textContent = "Cancel";
            cancelButton.addEventListener("click", function () {
                subjectInput.style.display = "none"; // Hide the input field
                actionCell.innerHTML = ""; 
                subjectCell.innerHTML = originalContent;
                actionCell.appendChild(button); 
            });

            actionCell.innerHTML = ""; 
            actionCell.appendChild(editButton);
            actionCell.appendChild(cancelButton); 
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
            var deleteButtons = document.querySelectorAll(".delete-btn"); // Select all delete buttons

            deleteButtons.forEach(function (deleteButton) {
                deleteButton.addEventListener("click", function () {
                    var tcId1 = deleteButton.getAttribute("data-id");
                    // Add code to delete the record based on tcId
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "delete_course.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.success) {
                               var row = deleteButton.closest("tr");
                                row.remove();
                            } else {
                                console.error("Delete failed");
                            }
                        }
                    };
                    xhr.send("tc_id=" + tcId1);
                });
            });
});
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
