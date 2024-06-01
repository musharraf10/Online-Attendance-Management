<!DOCTYPE html>
<html>
  <head>
    <title>Student Information Search</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <div class="wrapper">
      <h1>Student Information Search</h1>
      <form class="form" action="retrieve.php" method="GET">
        <label for="roll">Enter Roll Number:</label>
        <input type="text" id="roll" name="roll" required>
        <button type="submit">Search</button>
      </form>
    </div>
  </body>
</html>
