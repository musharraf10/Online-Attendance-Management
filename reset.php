<?php
include('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Online Attendance Management System 1.0</title>
  <link rel="stylesheet" type="text/css" href="main.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <header>
    <h1>Online Attendance Management System</h1>
    <div class="navbar">
      <a href="index.php">Login</a>
    </div>
  </header>

  <center>
    <div class="content">
      <div class="row">
        <form method="post" class="form-horizontal col-md-6 col-md-offset-3">
          <h3>Recover your password</h3>
          <div class="form-group">
            <label for="input1" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
              <input type="email" name="email"  class="form-control" id="input1" placeholder="your email" />
            </div>
          </div>
          <input type="submit" class="btn btn-primary col-md-2 offset-md-10" value="Go" name="reset" />
        </form>
        <br>

        <?php
          if(isset($_POST['reset'])){
            $test = $_POST['email'];
            $row = 0;
            $query = mysql_query("SELECT password FROM admininfo WHERE email = '$test'");
            $row = mysql_num_rows($query);

            if($row == 0){
        ?>
              <div class="content"><p>Email is not associated with any account. Contact HOD</p></div>
        <?php
            } else {
              $i = 0;
              while($dat = mysql_fetch_array($query)){
                $i++;
        ?>
                <strong>
                  <p style="text-align: left;">
                    Hi there!<br>
                    You requested for a password recovery. You may <a href="attindex.php">Login here</a> and enter this key as your password to login. Recovery key: <mark><?php echo $dat['password']; ?></mark><br>
                    Regards,<br>Online Attendance Management System
                  </p>
                </strong>
        <?php
              }
            }
          }
        ?>
      </div>
    </div>
  </center>
</body>
</html>
