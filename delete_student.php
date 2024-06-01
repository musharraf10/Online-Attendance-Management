<?php
include('studentconnect.php');

if (isset($_POST['st_id'], $_POST['st_phone_number'])) {
    $student_id = $_POST['st_id'];
    $student_username = $_POST['st_phone_number'];

    $delete_query = $conn->query("DELETE FROM students WHERE st_id = '$student_id'");
    $delete_admin_query = $conn->query("DELETE FROM admininfo WHERE phone = '$student_username'");

    if ($delete_query && $delete_admin_query) {
        echo "Student data and associated admin data deleted Successfully";
    } else {
        echo "Failed to delete Student data and/or associated admin data";
    }
} else {
    echo "Invalid request";
}
?>
