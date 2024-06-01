<?php
include('studentconnect.php');

if (isset($_POST['sr_dept'], $_POST['st_sem'])) {
    $srbatch = $_POST['sr_dept'];
    $srsem = $_POST['st_sem'];
    $i = 0;
    $all_query = $conn->query("SELECT * FROM students WHERE st_dept = '$srbatch' AND st_sem = '$srsem' ORDER BY st_id ASC");

    if ($all_query->num_rows > 0) {
        while ($data = $all_query->fetch_assoc()) {
            $i++;
?>
            <tr>
                <td><?php echo $data['st_id']; ?></td>
                <td><?php echo $data['st_name']; ?></td>
                <td><?php echo $data['st_dept']; ?></td>
                <td><?php echo $data['st_batch']; ?></td>
                <td><?php echo $data['st_sem']; ?></td>
                <td><?php echo $data['st_phone_number']; ?></td>
                <td><?php echo $data['st_email']; ?></td>
                <td>
                    <a href="#" class="btn btn-danger btn-sm delete-button" data-student-id="<?php echo $data['st_id']; ?>" data-phone-number="<?php echo $data['st_phone_number']; ?>">Delete</a>
                </td>
            </tr>
<?php
        }
    } else {
        echo "<tr><td colspan='8'>No students found.</td></tr>";
    }
} else {
    echo "<tr><td colspan='8'>Invalid request.</td></tr>";
}
?>
