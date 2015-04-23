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
	if($userLevel != 'Researcher' && $userLevel != 'Teacher')
	{
		echo"<script>window.location.href = \"index.php\";</script>";
		exit();
	}
	
}
?>

<input type="button" class = "cBtn fRight" value="Home" onclick="location='index.php'" />
<h2>Create Study</h2><hr />

<?php


//if (isset($_POST['createSurvey'])) {

    echo "Enter Study Name:<br/>";
    echo "<form action ='surveycreation.php' method = 'post'>

    <input type = 'text' name = 'surveyName'required><br><br>
    Enter Study Description:<br/>
    <textarea name=\"studyBG\" cols=\"40\" rows=\"5\" required></textarea><br><br>
    <input type='radio' name=\"type\" value= 1 required>Additional Study Filter<br>
    <input type='radio' name=\"type\" value= 0  required>Online Survey<br>
    <input type='radio' name=\"type\" value= 2 text=\"Lab Study\" required style = \"display:none;\"><br>
    <p>Provide Link If Needed</p>
    <input type = 'text' name = 'surveyLink'><br>
    <br/>
    <input type='submit' class = \"cBtn\" name = 'create' value='Submit'>

    </form>
    <br/>";    
//}
?>
<!--<form action="surveycreationmain.php" method = "post">
<input type="submit" class = "cBtn" name="createSurvey" value="Create Another Survey" />
</form>-->

<?php
include('footer.php');
?>

