<?php
session_start();
include('header.php');
?>


<?php
include('ConnectToDb.php');
$sql = "SELECT UserType from User where uvuID = $uvid";
$result = $conn->query($sql);
$conn->close();
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
if($userLevel != 'Admin')
{
	if($userLevel != 'Researcher' && $userLevel != 'Teacher')
	{
		echo"<script>window.location.href = \"index.php\";</script>";
		exit();
	}
	
}
?>


<?php
include('ConnectToDb.php');
$sql = "SELECT UserType from User where uvuID = $uvid";
$result = $conn->query($sql);
$conn->close();
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
if($userLevel != 'Admin')
{
	if($userLevel != 'Researcher')
	{
		echo"<script>window.location.href = \"index.php\";</script>";
		exit();
	}
	
}
?>



<?php


if (isset($_POST['createSurvey'])) {
    echo "Enter Survey Name:<br/>";
    echo "<form action ='surveycreation.php' method = 'post'>

    <input type = 'text' name = 'surveyName'><br>
    <input type='radio' name=\"type\" value= 1>Survey<br>
    <input type='radio' name=\"type\" value= 2>Qualtrics<br>
    <p>If Qualtrics, Provide Link</p>
    <input type = 'text' name = 'surveyLink'><br>
    <br/>
    <input type='submit' name = 'submit' value='Submit'>

    </form>
    <br/>";    
}
?>
<form action="surveycreationmain.php" method = "post">
<input type="submit" name="createSurvey" value="Create Another Survey" />
</form>
<input type="button" value="Back" onclick="location='index.php'" />
<?php
include('footer.php');
?>

