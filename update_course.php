<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('connect.php');

// Check for connection errors
if ($conn->connect_error) {
    $response = array('success' => false, 'error' => $conn->connect_error);
    echo json_encode($response);
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newSubject = $_POST['new_subject'];
    // $oldSubject = $_POST['subject'];
    $tcId = $_POST['tc_id'];

    // Prepare and execute the update query
    $updateQuery = "UPDATE teachers SET tc_course = ? WHERE tc_name = ? AND tc_id = ?";
    $stmt = $conn->prepare($updateQuery);

    if ($stmt === false) {
        $response = array('success' => false, 'error' => $conn->error);
        echo json_encode($response);
        exit;
    }

    $stmt->bind_param("ssi", $newSubject, $_SESSION['username'],$tcId);
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
