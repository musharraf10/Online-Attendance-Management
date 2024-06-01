<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('connect.php'); // Include your database connection settings

// Check for connection errors
if ($conn->connect_error) {
    $response = array('success' => false, 'error' => $conn->connect_error);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tcId = $_POST['tc_id'];
    $username = $_SESSION['username'];

    // Check if the course is the last one for the given username
    $checkQuery = "SELECT COUNT(*) as course_count FROM teachers WHERE tc_name = ?";

    $stmtCheck = $conn->prepare($checkQuery);

    if ($stmtCheck === false) {
        $response = array('success' => false, 'error' => $conn->error);
        echo json_encode($response);
        exit;
    }

    $stmtCheck->bind_param("s", $username);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();
    $row = $result->fetch_assoc();
    $courseCount = $row['course_count'];

    $stmtCheck->close();

    // If the course is the last one, show an alert and do not delete
    if ($courseCount == 1) {
        $response = array('success' => false, 'message' => 'This is the last course. Cannot delete.');
        echo json_encode($response);
        exit;
    }

    // Prepare and execute the delete query
    $deleteQuery = "DELETE FROM teachers WHERE tc_id = ? AND tc_name = ?";
    $stmt = $conn->prepare($deleteQuery);

    if ($stmt === false) {
        $response = array('success' => false, 'error' => $conn->error);
        echo json_encode($response);
        exit;
    }

    $stmt->bind_param("is", $tcId, $username);

    if ($stmt->execute()) {
        $response = array('success' => true);
        echo json_encode($response);
    } else {
        $response = array('success' => false, 'error' => $stmt->error);
        echo json_encode($response);
    }

    $stmt->close();
}

// Close the MySQLi connection
$conn->close();
?>
