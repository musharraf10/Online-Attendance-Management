<?php

include('connect.php');

$error_msg = "";

try {
    if (isset($_POST['signup'])) {
        $stmtAdmin = $conn->prepare("INSERT INTO admininfo (email, username, password, fname, phone, type) VALUES (?, ?, ?, ?, ?, ?)");

        $email = $_POST['email'];
        $uname = $_POST['uname'];
        $pass = $_POST['pass']; 
        $fname = $_POST['fname'];
        $phone = $_POST['phone'];
        $type = $_POST['type'];
        $stmtAdmin->bind_param("ssssss", $email, $uname, $pass, $fname, $phone, $type);

        if ($stmtAdmin->execute()) {
            $admin_id = $stmtAdmin->insert_id;
            $stmtStudents = $conn->prepare("INSERT INTO students(st_id, st_name, st_dept, st_batch, st_sem, st_email, st_username, st_phone_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            $st_id = $_POST['rn'];
            $st_dept = $_POST['dept'];
            $st_batch = $_POST['batch'];
            $st_sem = $_POST['sem'];

            // Bind parameters for students insertion
            $stmtStudents->bind_param("ssssssss", $st_id, $fname, $st_dept, $st_batch, $st_sem, $email, $uname, $phone);

            if ($stmtStudents->execute()) {
                // Successfully inserted into students table
                $student_id = $stmtStudents->insert_id;

                // Insert data into the student_department_mapping table
                $stmtMapping = $conn->prepare("INSERT INTO student_department_mapping (st_id, dept) VALUES (?, ?)");
                $stmtMapping->bind_param("ss", $st_id, $st_dept);

                if ($stmtMapping->execute()) {
                    $success_msg = "Signup Successful!";
                     echo '<script>
                            setTimeout(function(){
                                window.location.href = "attindex.php";
                            }, 3000); // 3 seconds
                          </script>';
                } else {
                    $error_msg = "Signup failed for student_department_mapping table.";
                }

                $stmtMapping->close();
            } else {
                $duplicateCheck = $conn->prepare("SELECT * FROM admininfo WHERE email = ? OR phone = ?");
                $duplicateCheck->bind_param("ss", $email, $phone);
                $duplicateCheck->execute();
                $result = $duplicateCheck->get_result();
                $duplicateCheck->close();

                if ($result->num_rows > 0) {
                    $error_msg = "Signup failed. Email or phone number is already in use.";
                } else {
                    $error_msg = "Signup failed for students table.";
                }
            }

            $stmtStudents->close();
        } else {
            $error_msg = "Signup failed for admininfo table." ;
        }

        $stmtAdmin->close();
    }
} catch (Exception $e) {
    $error_msg = "Exception: " . $e->getMessage() . "\n";
    $error_msg .= "SQL Error: " . $conn->error;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>IT&DS Attendance Management</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
body {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  background: rgb(130, 106, 251);
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
.container header {
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
      <section class="container">
      <header>Student Registration Form</header>
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
            <option value="student">Student</option>
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
        <div class="column">
          <div class="input-box">
            <label for="input1">Branch</label>
            <input type="text" name="dept" id="input1" placeholder="your branch (IT)" minlength="2" maxlength="7" oninput="this.value = this.value.toUpperCase();" required />
          </div>
          <div class="input-box">
            <label for="input1">Roll Number</label>
            <input type="text" name="rn" id="input1" placeholder="your ID" maxlength="10" oninput="this.value = this.value.toUpperCase();"required />
          </div>
        </div>
        <div class="column">
        <div class="input-box">
          <label for="input1">Year-Semester(1-1)</label>
          <select name="sem" id="input1"  required>
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
          <label for="input1">Batch</label>
          <input type="text" name="batch" id="input1" placeholder="Batch (ex:20)" maxlength="2" required/>
        </div>
        </div>
        <button name="signup">Submit</button>
      </form>
      <p><strong>Already have an account? <a href="attindex.php">Login</a> here.</strong></p>
    </section>
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
    window.location.href = "attindex.php";
});
</script>


</body>

</html>
