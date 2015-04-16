<?php
$uvid = $_SERVER["REMOTE_USER"];
//pull from database using userID and user level given from call(global variable?)
//if not new
$servername = "stu-web2.uvu.edu";
$username = "test";
$password = "test";
$dbName = "bscience";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbName);

// Check connection
if ($conn->connect_error) {
    die("<strong>ERROR ERROR ERROR </strong>Connection failed: " . $conn->connect_error);
} 
//echo "<strong>Connected successfully</strong><br>";

?>