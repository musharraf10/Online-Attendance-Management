<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Check if the ZipArchive extension is enabled
if (!extension_loaded('zip')) {
    die("The ZipArchive extension is not enabled. Please enable it in your PHP configuration.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $semester = $_POST['semester'];
    $servername = "localhost";
    $username = "nriitac_student";
    $password = "College@123456";
    $dbname = "nriitac_college";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $tableName = "results_" . $semester;

    if (isset($_FILES["excel"]["name"])) {
        $filename = $_FILES["excel"]["name"];
        $fileExtension = explode('.', $filename);
        $fileExtension = strtolower(end($fileExtension));
        $targetDirectory = "targetD/";
        $targetFile = $targetDirectory . basename($_FILES["excel"]["name"]);

        if (move_uploaded_file($_FILES["excel"]["tmp_name"], $targetFile)) {
            $reader = new SpreadsheetReader($targetFile);
            
            foreach ($reader as $key => $row) {
                $htno = $row[0];
                $subcode = $row[1];
                $subname = $row[2];
                $internals = $row[3];
                $grades = $row[4];
                $credits = $row[5];

                $stmt = $conn->prepare("INSERT INTO $tableName (Htno, Subcode, Subname, Internals, Grades, Credits) VALUES (?, ?, ?, ?, ?, ?)");
                
                if (!$stmt) {
                    die("Error in prepare: " . $conn->error);
                }
                
                $stmt->bind_param("sssisd", $htno, $subcode, $subname, $internals, $grades, $credits);
                
                if ($stmt->execute()) {
                    echo "<script>alert('Data inserted successfully');</script>";
                } else {
                    echo "<script>alert('Error inserting data: " . $stmt->error . "');</script>";
                }
                
                $stmt->close();
            }
            
            unlink($targetFile); // Delete the uploaded file after processing
            
            $conn->close();
        } else {
            echo "<script>alert('Error uploading file');</script>";
        }
    }
}
?>