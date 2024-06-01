<?php
// establishing connection
include('connect.php'); 

$error_msg = ""; 

try {
    if(isset($_POST['signup'])) {
      
        $stmt = $conn->prepare("INSERT INTO admininfo (email, username, password, fname, phone, type) VALUES (?, ?, ?, ?, ?, ?)");
        
        $uname = $_POST['uname'];
        $pass = $_POST['pass'];
        $email = $_POST['email'];
        $fname = $_POST['fname'];
        $phone = $_POST['phone'];
        $type = $_POST['type'];

        $stmt->bind_param("ssssss", $email, $uname, $pass,$fname, $phone, $type);
        
        if ($stmt->execute()) {
            $success_msg = "Signup Successfully!";
        } else {
            $error_msg = "Signup failed.";
        }

        $stmt->close();
    }
} catch (Exception $e) {
    $error_msg = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Online Attendance Management System</title>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
      <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            margin-top:0px;
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
        } .user-info {
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
        <p class="animate__animated animate__fadeInUp">
            <?php if(isset($success_msg)) echo $success_msg; if(isset($error_msg)) echo $error_msg; ?>
        </p>
        <br>
        <div class="content animate__animated animate__fadeInUp">
    <section class="container">
      <div class="header1">Admin Registration Form</div>
      <form method="post" class="form">
        <div class="column">
        <div class="input-box">
          <label for="input1">Full Name</label>
          <input type="text" name="fname"  class="form-control" id="input1" placeholder="your full name" required/>
        </div>
        <div class="input-box">
          <label for="input1">Type</label>
          <select name="type" required>
            <option value="admin">Admin</option>
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
        <button name="signup">Signup</button>
      </form>
    </section>
              <p class="animate__animated animate__fadeInUp login-link">
                <strong>Go to Login page? <a href="attindex.php" class="animated-link">Click here</a>.</strong>
            </p>
        </div>
    </center>

    
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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
