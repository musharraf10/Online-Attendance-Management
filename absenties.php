<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();
include('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Online Attendance Management System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style type="text/css">
        body {
    font-family: Arial, sans-serif;
    padding: 0px;
}

header {
    background-color: #007bff;

    color: white;
    padding: 10px;
    text-align: center;
}

.container {
    margin-top: 0px;
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

.navbar {
    background-color: #f8f9fa;
    padding: 10px;
    width: 100%;
    display: flex; /* Add flex display */
    justify-content: space-between; /* Distribute items evenly */
    align-items: center; /* Center items vertically */
}

.navbar a {
    color: #333;
    text-decoration: none;
    width:100%;
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
}

        h1 {
            text-align: center;
        }

        .form-container {
            text-align: center;
        }

        form {
            display: inline-block;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="date"] {
            padding: 5px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #dee2e6;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }
        /* Center navbar items on mobile screens */
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
            margin: 4px auto;
            background-color: #333;
    }

    .navbar-nav {
        display: flex;
        align-items: center; /* Center items vertically */
        margin: 0; /* Reset margin */
    }

    .user-info {
            font-weight: bold;
            color: blue;
        
    }
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
        <h1>Send SMS to Absent Students</h1>
        <div class="form-container">
            <form method="post" action="">
                <label for="datePicker">Select a Date (DD-MM-YYYY):</label>
                <input type="date" id="datePicker" name="selectedDate" pattern="\d{2}-\d{2}-\d{4}" required>
                <button type="submit" name="submitButton">Get Absent Students</button>
            </form>
        </div>
<?php
$absentStudents = [];
    if (isset($_POST["submitButton"])) {
        $dbhost = "localhost";
        $dbuser = "nriitac_student";
        $dbpass = "College@123456";
        $db = "nriitac_st_attendence";
        $selectedDate = $_POST["selectedDate"];

        $conn = new mysqli($dbhost, $dbuser, $dbpass, $db);

        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        $query = "SELECT s.st_id, s.st_name, s.st_phone_number
                  FROM reports AS r
                  JOIN students AS s ON r.st_id = s.st_id
                  WHERE r.stat_date = '$selectedDate' AND r.st_status = 'Absent'";

        $result = $conn->query($query);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        $absentStudents = [];

        while ($row = $result->fetch_assoc()) {
            $absentStudents[] = $row;
        }

        $conn->close();

        echo "<form method='post'>";
        echo "<table border='1'>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Phone Number</th>
                    <th>Send SMS</th>
                </tr>";

        foreach ($absentStudents as $student) {
            echo "<tr>";
            echo "<td>{$student['st_id']}</td>";
            echo "<td>{$student['st_name']}</td>";
            echo "<td>{$student['st_phone_number']}</td>";
            echo "<td>
                    <input type='checkbox' name='selectedStudents[]' value='{$student['st_id']},{$student['st_phone_number']}' />
                  </td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "<button type='submit' name='sendSmsToSelectedButton'>Send SMS to Selected</button>";
        echo "<button type='submit' name='sendSmsToAllButton'>Send SMS to All</button>";
        echo "</form>";
    }

    if (isset($_POST["sendSmsToSelectedButton"]) && isset($_POST["selectedStudents"])) {
        $selectedStudents = $_POST["selectedStudents"];
        
        foreach ($selectedStudents as $studentInfo) {
            list($studentID, $studentPhoneNumber) = explode(",", $studentInfo);
            
            // Place SMS sending logic here
            $smsResponse = sendSms($studentID, $studentPhoneNumber);
            echo "SMS sent to Student ID: {$studentID}, Phone Number: {$studentPhoneNumber}, Response: {$smsResponse}<br>";
        }
    }

    if (isset($_POST["sendSmsToAllButton"])) {
        foreach ($absentStudents as $student) {
            $studentID = $student["st_id"];
            $studentPhoneNumber = $student["st_phone_number"];
            
            // Place SMS sending logic here
            $smsResponse = sendSms($studentID, $studentPhoneNumber);
            echo "SMS sent to Student ID: {$studentID}, Phone Number: {$studentPhoneNumber}, Response: {$smsResponse}<br>";
        }
    }
    
    function sendSms($studentID, $studentPhoneNumber) {
        // Here you can place your actual SMS sending logic
        // You can use the provided cURL code or integrate with your SMS gateway
        
        // Example SMS sending code using cURL:
        $apiurl = "http://adwingssms.com/sms/V1/send-sms-api.php";
         $apiKey = "mpV9cRoElgHArjGw";
                $senderID = "NRIITG";
                $templateID = "1707163893447333569";
                $entityID = "1701159913704978177"; // Replace with your actual entity ID

                $recipientPhoneNumber = $row["st_phone_number"];
                $customMessage = "Dear Parent, your ward is ABSENT today without prior notice. If the attendance of your ward is below 75%, your ward will not be promoted to next semester. So please send your ward to the college regularly. Thanks & Regards, HOD- IT&DS (Contact: 8885552793). NRI Institute of Technology.";

        $apiParams = [
            'apikey' => $apiKey,
            'senderid' => $senderID,
            'templateid' => $templateID,
            'entityid' => $entityID,
            'number' => $studentPhoneNumber,
            'message' => $customMessage,
            'format' => 'json'
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiurl . '?' . http_build_query($apiParams),
            CURLOPT_RETURNTRANSFER => true,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #" . $err;
        } else {
            return $response;
        }
    }
    ?>


<script>
    window.addEventListener('popstate', function(event) {
    window.location.href = "adminindex.php";
});
</script>



    </div>
</body>
</html>
