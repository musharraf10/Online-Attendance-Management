<!DOCTYPE html>
<html>
  <head>
    <title>Student Information Search</title>
    <link rel="stylesheet" type="text/css" href="style.css">
<style>
    .details {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 20px;
  font-size: 16px; /* increase the font size */
}

.profile {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-right: 20px;
}

.profile img {
  border-radius: 50%;
  width: 150px; /* increase the profile image size */
  height: 150px; /* increase the profile image size */
}

table {
  border-collapse: collapse;
  width: 100%;
  background-color: transparent;
  font-size: 16px; /* increase the font size */
}

th,
td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
  font-size: 16px; /* increase the font size */
}

th {
  background-color: transparent; /* make the background color transparent */
}

    </style>
  </head>
  <body>
    <?php
    $dbname = 'nriitac_college';
    $username = 'nriitac_student';
    $password = 'College@123456';

    try {
        $db = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    if (isset($_GET['roll'])) {
        $roll = $_GET['roll'];
        $stmt = $db->prepare("SELECT * FROM register WHERE roll = ?");
        $stmt->execute([$roll]);
        $student = $stmt->fetch();
    }
    ?>

    <div class="wrapper">
      <h1>Student Information Search</h1>
      <form class="form" action="retrieve.php" method="GET">
        <label for="roll">Enter Roll Number:</label>
        <input type="text" id="roll" name="roll" required>
        <button type="submit">Search</button>
      </form>
    <?php if (isset($student) && $student !== false): ?>
  <div class="details">
    <div class="profile">
      <img src="<?php echo $student['profile']; ?>">
      <h2><?php echo $student['name']; ?></h2>
    </div>
    <table>
      <tr>
        <th>Roll</th>
        <td><?php echo $student['roll']; ?></td>
      </tr>
      <tr>
        <th>Department</th>
        <td><?php echo $student['department']; ?></td>
      </tr>
      <tr>
        <th>Academic Year</th>
        <td><?php echo $student['academic_year']; ?></td>
      </tr>
      <tr>
        <th>Email</th>
        <td><?php echo $student['email']; ?></td>
      </tr>
      <tr>
        <th>Gender</th>
        <td><?php echo $student['gender']; ?></td>
      </tr>
      <tr>
        <th>Blood Group</th>
        <td><?php echo $student['blood_group']; ?></td>
      </tr>
    </table>
  </div>
<?php elseif(isset($_GET['roll'])): ?>
        <div class="details">
          <p><strong>Roll number not found.</strong></p>
        </div>
      <?php endif; ?>
</div>
</body>
</html>

