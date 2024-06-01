<?php
include('connect.php'); // Include your database connection file

if(isset($_POST['attendanceData']) && isset($_POST['course']) && isset($_POST['date'])) {
    // Get the attendance data, course, and date from the AJAX request
    $attendanceData = $_POST['attendanceData'];
    $course = $_POST['course'];
    $date = $_POST['date'];

    // Loop through attendance data and update the database
    foreach ($attendanceData as $data) {
        $stat_id = $data['stat_id'];
        $st_status = $data['st_status'];

        // Update the attendance status in the database
        $query = "UPDATE attendance 
                  SET st_status = ?
                  WHERE stat_id = ? AND course = ? AND stat_date = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            die("Error in preparing the statement: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param("ssss", $st_status, $stat_id, $course, $date);

        if ($stmt->execute()) {
            $att_msg = "Attendance Updated Successfully.";
        } else {
            $error_msg = "Error updating attendance status: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    // Send a response message back to the AJAX request
    if (isset($att_msg)) {
        echo "<div class='alert alert-success'><strong>Success!</strong> $att_msg</div>";
    } elseif (isset($error_msg)) {
        echo "<div class='alert alert-danger'><strong>Error!</strong> $error_msg</div>";
    }
} else {
    echo "<div class='alert alert-danger'><strong>Error!</strong> Invalid request.</div>";
}
?>
