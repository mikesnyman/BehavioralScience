<?php
$sql = "SELECT uvuID from User where uvuID = $uvid";//check if user exists or is new

$result = $conn->query($sql);
if ($result->num_rows > 0)
{
    // output data of each row
    while($row = $result->fetch_assoc())
     {
        //echo "UserId#: " . $row["UserID"]." Does exists in database<br>";

    }
} else {
    //echo "0 results found, adding new user to database.<br>";
    //add user to database with participant clearance
	$sql = "INSERT INTO User (UserType,uvuID) VALUES ('New',$uvid)";//add new user to database
	$conn->query($sql);
	}

//get user menu options based on user level
$sql = "SELECT UserType from User where uvuID = $uvid";

$result = $conn->query($sql);

if ($result->num_rows > 0)
{
    // output data of each row
    while($row = $result->fetch_assoc())
     {
        $userLevel = $row["UserType"];

    }
} else {
    echo "0 results found.<br>";
    //add user to database with participant clearance

}
?>