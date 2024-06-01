<?php

 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $db = "st_attendence";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

?>