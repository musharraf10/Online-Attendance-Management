<!DOCTYPE html>
<html>
<head>
    <title>Displaying Database Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #4CAF50;
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .action-buttons {
            display: flex;
            gap: 0.5cm;
        }

        .action-button {
            padding: 6px 10px;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .action-button.delete {
            background-color: #f44336;
        }

        .action-button.delete:hover {
            background-color: #d32f2f;
        }

        .action-button.grant {
            background-color: #4CAF50;
        }

        .action-button.grant:hover {
            background-color: #45a049;
        }

        .sno-column {
            font-weight: bold;
            color: #777;
        }
    </style>
</head>
<body>
    <h1>Displaying Database Data</h1>
    
    <table>
        <tr>
            <th>Sno</th>
            <th>User ID</th>
            <th>Password</th>
            <th>Name</th>
            <th>Department</th>
            <th>Mobile</th>
            <th>Action</th>
        </tr>
        
        <?php
        // Database credentials
        $servername = "localhost";
        $username = "nriitac_student";
        $password = "College@123456";
        $dbname = "nriitac_college";

        // Create a new connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if the delete button is clicked
            if (isset($_POST['delete'])) {
                // Get the user ID to delete
                $userid = $_POST['delete'];

                // Prepare and execute the SQL query to delete the record
                $sql = "DELETE FROM faculty WHERE userid = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $userid);
                $stmt->execute();

                // Check if the deletion was successful
                if ($stmt->affected_rows > 0) {
                    echo "Record deleted successfully.";
                    // Redirect to a separate page after deletion
                    header("Location: deleted.php");
                    exit();
                } else {
                    echo "Failed to delete record.";
                }
            } elseif (isset($_POST['grant'])) {
                // Get the user ID to grant
                $userid = $_POST['grant'];

                // Perform the grant action (add your custom grant logic here)
                // Update the 'access' column to grant login access
                $sql = "UPDATE faculty SET access = 1 WHERE userid = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $userid);
                $stmt->execute();

                // Check if the grant action was successful
                if ($stmt->affected_rows > 0) {
                    echo "Record granted successfully.";
                } else {
                    echo "Failed to grant record.";
                }
            }
        }

        // Retrieve data from the database
        $sql = "SELECT * FROM faculty";
        $result = $conn->query($sql);

        // Initialize serial number
        $sno = 1;

        // Output data in HTML table rows
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td class='sno-column'>" . $sno . "</td>";
                echo "<td>" . $row['userid'] . "</td>";
                echo "<td>**********</td>"; // Display asterisks instead of the actual password
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['department'] . "</td>";
                echo "<td>" . $row['mobile'] . "</td>";
                echo "<td class='action-buttons'>";
                echo "<form method='POST'>";
                echo "<input type='hidden' name='grant' value='" . $row['userid'] . "'>";
                echo "<button type='submit' class='action-button grant'>Grant</button>";
                echo "</form>";
                echo "<form method='POST'>";
                echo "<input type='hidden' name='delete' value='" . $row['userid'] . "'>";
                echo "<button type='submit' class='action-button delete'>Delete</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";

                // Increment serial number
                $sno++;
            }
        } else {
            echo "<tr><td colspan='7'>No data found</td></tr>";
        }

        // Close the database connection
        $conn->close();
        ?>
        
    </table>
</body>
</html>
