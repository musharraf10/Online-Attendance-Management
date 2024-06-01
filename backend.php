<?php
include('connect.php'); // Include your database connection file

$studentId = $_SESSION['st_id'];

try {
    // Execute the SQL query to count occurrences
    $stmt = $conn->prepare("SELECT stat_date, COUNT(*) as count, st_status FROM attendance WHERE stat_id = ? GROUP BY stat_date, st_status ORDER BY stat_date");

    if (!$stmt) {
        throw new Exception("SQL Statement Preparation Error: " . $conn->error);
    }

    $stmt->bind_param("s", $studentId);

    if (!$stmt->execute()) {
        throw new Exception("SQL Statement Execution Error: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if (!$result) {
        throw new Exception("Result Set Error: " . $conn->error);
    }

    $attendanceData = array();

    while ($row = $result->fetch_assoc()) {
        $attendanceData[] = $row;
    }

    // Close the prepared statement
    $stmt->close();

    // Close the database connection
    $conn->close();

    // Return the attendance data as JSON
    header("Content-Type: application/json");
    echo json_encode($attendanceData);
} catch (Exception $e) {
    // Handle any exceptions or errors
    echo "Error: " . $e->getMessage();
}
?>
