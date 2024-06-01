<?php
$dbhost = "localhost";
$dbuser = "nriitac_student";
$dbpass = "College@123456";
$db = "nriitac_st_attendence";
$conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n" . $conn->error);

// Set the session save path
$session_save_path = '/home/nriitac/public_html/college/session'; // Replace with your desired session save path
if (!is_dir($session_save_path)) {
    mkdir($session_save_path, 0700, true); // Create the directory if it doesn't exist
}
ini_set('session.save_path', $session_save_path);

// Start the session
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

?>
