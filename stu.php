<!DOCTYPE html>
<html>
<head>
  <title>Student Search</title>
</head>
<body>

  <!-- HTML form to enter the roll number -->
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Roll Number: <input type="text" name="roll"><br>
    <input type="submit" value="Search">
  </form>

  <?php
  // Process the form data and retrieve the student details
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll = $_POST['roll'];
    $conn = mysqli_connect("localhost", "username", "password", "students");
    $result = mysqli_query($conn, "SELECT * FROM register WHERE roll = '$roll'");
    if ($row = mysqli_fetch_assoc($result)) {
      // display the student details
      echo "<h2>Student Details</h2>";
      echo "<p><strong>Name:</strong> " . $row['name'] . "</p>";
      echo "<p><strong>Roll:</strong> " . $row['roll'] . "</p>";
      echo "<p><strong>Department:</strong> " . $row['department'] . "</p>";
      echo "<p><strong>Academic Year:</strong> " . $row['academic_year'] . "</p>";
      echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
      echo "<p><strong>Gender:</strong> " . $row['gender'] . "</p>";
      echo "<p><strong>Blood Group:</strong> " . $row['blood_group'] . "</p>";
      echo "<p><strong>Profile:</strong> " . $row['profile'] . "</p>";
    } else {
      echo "<p>No student found with roll number " . $roll . "</p>";
    }
    mysqli_close($conn);
  }
  ?>

</body>
</html>
