<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }
  
  h1 {
    text-align: center;
    margin-bottom: 20px;
  }
  
  p {
    text-align: center;
    margin-bottom: 40px;
  }
  
  form  {
    background-color: #ffffff;
    border-radius: 5px;
    padding: 20px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    width: 300px;
  }
  
  label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
  }
input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px; /* Reduce margin-bottom to 10px */
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box; /* Ensure padding and border don't increase width */
}
  button {
    background-color: #007bff;
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
  }
  
  button:hover {
    background-color: #0056b3;
  }
</style>
</head>
<body>
 <?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$error_msg = "";
function generateOTP() {
    return rand(1000, 9999);
}

// Database connection details
$servername = "localhost";
$username = "nriitac_student";
$password = "College@123456";
$dbname = "nriitac_st_attendence";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$step = 1;
if (isset($_POST['send_otp'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $sql = "SELECT * FROM admininfo WHERE username = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $otp = generateOTP();
        $updateSql = "UPDATE admininfo SET otp = ? WHERE username = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("is", $otp, $username);
        $updateStmt->execute();

        $row = $result->fetch_assoc();
        $to = $row['email'];
        $subject = "Password Reset OTP";
        $message = "This is From NRI  Your OTP is: $otp ";
        $headers = "From: Nriit@college.com";

        mail($to, $subject, $message, $headers);
        $step = 2;
        $success_msg= "OTP sent to your email.";
    } else {
        $error_msg ="Username and email do not match our records.";
    }
}

if (isset($_POST['verify'])) {
    $otp = $_POST['otp'];

    $sql = "SELECT * FROM admininfo WHERE otp = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $step = 3;
    } else {
        $error_msg="Invalid OTP.";
    }
}

if (isset($_POST['reset_password'])) {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $otp = $_POST['otp'];

    if ($newPassword === $confirmPassword) {
        $hashedPassword = $newPassword;
        $sql = "UPDATE admininfo SET password = ? WHERE otp = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $hashedPassword, $otp);
        $stmt->execute();
        $success_msg= "Password updated successfully.";
         echo '<script>
                 setTimeout(function(){
                window.location.href = "attindex.php";
                }, 2000);
                </script>';
    } else {
        $error_msg="Passwords do not match.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
</head>
<body>
    <div class="center">
    <p>
        <?php
        if (isset($success_msg)) echo $success_msg;
        if (isset($error_msg)) echo $error_msg;
        ?>
    </p>

    <?php if ($step === 1) { ?>
        <!-- Step 1: Display username and email form -->
        <form action="" method="post" class="form-body">
            <h1>Forgot Password</h1>
            <p>Enter Existed Details</p>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <button type="submit" name="send_otp">Send OTP</button>
        </form>
    <?php } elseif ($step === 2) { ?>
        <!-- Step 2: Display OTP verification form -->
        <form action="" method="post">
            <h1>Verify OTP</h1>
            <p>Please enter the OTP sent to your email.</p>
            <label for="otp">OTP:</label>
            <input type="text" id="otp" name="otp" required>
            <button type="submit" name="verify">Verify OTP</button>
        </form>
    <?php } elseif ($step === 3) { ?>
        <!-- Step 3: Display password reset form -->
        <form action="" method="post">
            <h1>Reset Password</h1>
            <p>Enter your new password.</p>
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <input type="hidden" name="otp" value="<?php echo $_POST['otp']; ?>">
            <button type="submit" name="reset_password">Reset Password</button>
        </form>
    <?php } ?>
</div>
<script>
    window.addEventListener('popstate', function(event) {
    window.location.href = "attindex.php";
});
</script>
</body>
</html>