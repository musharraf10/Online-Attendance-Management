<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'src/IOFactory.php';
require_once 'src/Spreadsheet.php';


if(isset($_POST['sdate']) && isset($_POST['course'])) {
    // Get the selected date and course from the form
    $sdate = $_POST['sdate'];
    $course = $_POST['course'];

    // Create a new PHPExcel object
    $objPHPExcel = new PHPExcel();

    // Add data to the Excel sheet (adjust this part to match your table structure)
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Student ID');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Name');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Department');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Batch');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Date');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Attendance Status');

    $row = 2; // Start from the second row
    while ($data = $all_query->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $data['st_id']);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $data['st_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $data['st_dept']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $data['st_batch']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $data['stat_date']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $data['st_status']);
        $row++;
    }

    // Set the file name for download
    $filename = 'attendance_report_' . $sdate . '_' . $course . '.xlsx';

    // Set the header for Excel file download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // Create Excel writer and send to browser for download
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
} else {
    // Handle the case where sdate and course are not set properly
    echo 'Invalid request';
}
?>
