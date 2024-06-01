<?php
include('connect.php');

if (isset($_GET['show_semester']) && isset($_GET['show_department'])) {
    $show_semester = $_GET['show_semester'];
    $show_department = $_GET['show_department'];
    
    $result = $conn->query("SELECT * FROM subjects WHERE st_sem = '$show_semester' AND st_dept = '$show_department'");
    
    if ($result->num_rows > 0) {
        echo '<h2>Retrieved Subjects</h2>';
        echo '<table class="table center-table">
                <tr>
                    <th>Subject</th>
                    <th>Actions</th>
                </tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . $row['subject'] . '</td>
                    <td>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="delete_subject" value="' . $row['subject'] . '">
                            <input type="submit" class="btn btn-danger" value="Delete">
                        </form>
                        <button class="btn btn-primary edit-btn" data-subject="' . $row['subject'] . '">Edit</button>
                    </td>
                </tr>';
        }
        echo '</table>';
    } else {
        echo '<p>No subjects found for the given semester and department.</p>';
    }
}
?>

