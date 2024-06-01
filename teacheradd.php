<?php
ob_start();
session_start();

include('connect.php');

$error_msg = "";
$success_msg = "";

try {
    if (isset($_POST['signup'])) {
        $stmt1 = $conn->prepare("INSERT INTO admininfo (email, username, password, fname, phone, type) VALUES (?, ?, ?, ?, ?, ?)");
        
        $email = $_POST['email'];
        $uname = $_POST['uname'];
        $pass = $_POST['pass'];
        $fname = $_POST['fname'];
        $phone = $_POST['phone'];
        $type = $_POST['type'];
        
        $stmt1->bind_param("ssssss", $email, $uname, $pass, $fname, $phone, $type);

        if ($stmt1->execute()) {
            $success_msg = "Admin Added Successfully.";

            $stmtTeacher = $conn->prepare("INSERT INTO teachers (tc_name, tc_dept, tc_email, tc_course, tc_phone_number, tc_sem) VALUES (?, ?, ?, ?, ?, ?)");
            
            $tc_dept = $_POST['dept'];
            $email = $_POST['email'];
            $tc_course = $_POST['course'];
            $tc_phone_number = $_POST['phone'];
            $tc_sem = $_POST['tc_sem'];
            
            $stmtTeacher->bind_param("ssssss", $fname, $tc_dept, $email, $tc_course, $tc_phone_number, $tc_sem);

            if ($stmtTeacher->execute()) {
                $success_msg .= " Teacher Added Successfully.";

                $stmtMapping = $conn->prepare("INSERT INTO teacher_course_mapping (teacher_username, course) VALUES (?, ?)");
                $teacher_username = $_POST['uname']; 
                $teacher_course = $_POST['course']; 
                $stmtMapping->bind_param("ss", $teacher_username, $teacher_course);
                
                if ($stmtMapping->execute()) {
                    $success_msg .= " Teacher-Course Mapping Added Successfully.";
                } else {
                    $error_msg .= " Teacher-Course Mapping Insertion Failed.";
                }
                $stmtMapping->close();
            } else {
                $error_msg = "Teacher Insertion Failed.";
            }

            $stmtTeacher->close();
        } else {
            $error_msg = "Admin Insertion Failed.". mysqli_error($conn);
        }
        
        $stmt1->close();
    }
} catch (Exception $e) {
    $error_msg = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style type="text/css">
        body { font-family: Arial, sans-serif; overflow-x: hidden; }
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
        @media (max-width: 567px) {
    .navbar {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
    }

    .menu-icon {
        display: block;
        width: 25px;
        height: 2px;
        background-color: #333;
    }

    .navbar-nav {
        display: flex;
        align-items: center; /* Center items vertically */
        margin: 0; /* Reset margin */
    }

    .user-info {
        text-align: right;
        margin-left: auto;
    }
}
        .navbar-toggler-icon { background: none; border: none; }
        .navbar a { color: #333; text-decoration: none; padding: 10px; transition: color 0.3s; }
        .navbar a:hover { color: #007bff; }
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            box-shadow: 0px 0px 20px 0px #888888;
        }
        .form-group {
            position: relative;
        }
        .form-group input {
            padding-left: 30px;
        }
        .form-group label {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            transition: all 0.2s ease;
            pointer-events: none;
            color: #333;
        }
        .form-group input:focus + label,
        .form-group input:valid + label {
            top: 10px;
            left: 10px;
            transform: translateY(-20px);
            background-color:#fff;
            font-size: 12px;
            color: blue;
        }
         @media (max-width: 768px) {
            .form-group input {
                padding-left: 10px;
                margin:10px;
            }
            .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            box-shadow: 0px 0px 20px 0px #888888;
            max-width: 100%;
            overflow: hidden;
        }
        .form-box {
            padding: 20px; /* Add space on all four sides */
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px 0px #888888;
            max-width: 80%; /* Adjust the max-width for the expanded width */
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
        .login-link {
            text-align: center;
            margin-top: -20px;
        }
         }
    </style>
<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}

.container {
  position: relative;
  max-width: 700px;
  width: 100%;
  background: #fff;
  padding: 25px;
  border-radius: 8px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}
.container .header1 {
  font-size: 1.5rem;
  color: #333;
  font-weight: 500;
  text-align: center;
}
.container .form {
  margin-top: 30px;
}
.form .input-box {
  width: 100%;
  margin-top: 20px;
}
.input-box label {
  color: #333;
}
.form :where(.input-box input, select) {
  position: relative;
  height: 50px;
  width: 100%;
  outline: none;
  font-size: 1rem;
  color: #707070;
  margin-top: 8px;
  border: 1px solid #ddd;
  border-radius: 6px;
  padding: 0 15px;
}
.input-box input:focus {
  box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
}
.form .column {
  display: flex;
  column-gap: 15px;
}
.form .gender-box {
  margin-top: 20px;
}
.gender-box h3 {
  color: #333;
  font-size: 1rem;
  font-weight: 400;
  margin-bottom: 8px;
}
.form :where(.gender-option, .gender) {
  display: flex;
  align-items: center;
  column-gap: 50px;
  flex-wrap: wrap;
}
.form .gender {
  column-gap: 5px;
}
.gender input {
  accent-color: rgb(130, 106, 251);
}
.form :where(.gender input, .gender label) {
  cursor: pointer;
}
.gender label {
  color: #707070;
}
.address :where(input, select) {
  margin-top: 15px;
}
 select {
  height: 100%;
  width: 100%;
  outline: none;
  border: none;
  color: #707070;
  font-size: 1rem;
}
.form button {
  height: 50px;
  width: 100%;
  color: #fff;
  font-size: 1rem;
  font-weight: 400;
  margin-top: 20px;
  margin-bottom:5px;
  border: none;
  cursor: pointer;
  transition: all 0.2s ease;
  background: rgb(130, 106, 251);
}
.form button:hover {
  background: rgb(88, 56, 250);
}
/*Responsive*/
@media screen and (max-width: 500px) {
  .form .column {
    flex-wrap: wrap;
  }
  .form :where(option, .gender) {
    row-gap: 15px;
  }
}
p{
    margin:5px;
    text-align:center;
}
</style>
</head>
<body>
    <header>
        <h1>Admin</h1>
    
    <nav class="navbar navbar-expand-md">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                else{
                    header('location: attindex.php');
                }
                ?>
            </div>
        </div>
    </nav>
    </header>
    <center>
<section class="container">
      <div class="header1">Teacher Registration Form</div>
      <p>    <?php
    if(isset($success_msg)) echo $success_msg;
    if(isset($error_msg)) echo $error_msg;
     ?>
     </p>
      <form method="post" class="form" autocomplete="off">
        <div class="column">
        <div class="input-box">
          <label for="input1">Full Name</label>
          <input type="text" name="fname"  class="form-control" id="input1" placeholder="your full name" required/>
        </div>
        <div class="input-box">
          <label for="input1">Type</label>
          <select name="type" required>
            <option value="teacher">Teacher</option>
          </select>
        </div>
      </div>
      <div class="column">
        <div class="input-box">
          <label for="input1">Username</label>
          <input type="text" name="uname"  class="form-control" id="input1" placeholder="choose username" required/>
        </div>
        <div class="input-box">
          <label for="input1">Password</label>
          <input type="password" name="pass" id="input1" placeholder="choose a strong password" required/>
        </div>
      </div>
        <div class="column">
          <div class="input-box">
            <label for="input1">Phone Number</label>
            <input type="tel" name="phone" id="input1" placeholder="your phone number" required />
          </div>
          <div class="input-box">
            <label for="input1">Email Address</label>
            <input type="email" name="email" id="input1" placeholder="your email" required/>
          </div>
        </div>
          <div class="input-box">
            <label for="input1">Branch (shorthand)</label>
            <input type="text" name="dept" id="input1" placeholder="your branch (IT)" minlength="2" maxlength="7" oninput="this.value = this.value.toUpperCase();" required />
          </div>
        <div class="column">
        <div class="input-box">
          <label for="input1">Year-Semester(1-1)</label>
          <select name="tc_sem" id="input1"  required>
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
        <div class="input-box">
          <label for="input6">Course(Subject)</label>
          <input type="text" name="course" class="form-control" id="input6" minlength="5" maxlength="25" oninput="this.value = this.value.toUpperCase();" placeholder="Enter Subject(DC)" required/>
        </div>
        </div>
        <button name="signup">Signup</button>
      </form>
      <p><strong>Already have an account? <a href="attindex.php">Login</a> here.</strong></p>
    </section>
    </center>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
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
   window.addEventListener("scroll", () => {
    const navbar = document.querySelectorAll(".navbar");
    if (window.scrollY > 0) {
        navbar.style.position = "fixed";
        navbar.style.top = "0";
    } else {
        navbar.style.position = "relative";
    }
});

</script>
<script>
    window.addEventListener('popstate', function(event) {
    window.location.href = "adminindex.php";
});
</script>
</body>
</html>
