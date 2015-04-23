<?php
ob_start();
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
	if($userLevel != 'Researcher')
	{
		echo"<script>window.location.href = \"index.php\";</script>";
		exit();
	}
	
}
?>
<h2>Survey Edit Page</h2><br>
<?php

if (isset($_POST['editSurvey'])) {
	//connected to database
	include('ConnectToDb.php');
    $sql = "SELECT description,idSurvey from Survey where idResearcher = $uvid";
	$result = $conn->query($sql);
    echo "List of current surveys (name only)<br/>";
    if ($result->num_rows > 0) {
    	  while($row = $result->fetch_assoc())
     	{	 
     	echo  $row["description"]."<br/>";
     	//$_SESSION['sNum'] = $row["idSurvey"];
     	echo "
		<form action ='filter.php' method = 'post'>
		<input type='hidden' name='varname' value='".$row["idSurvey"]."'>		  
		<input type='submit' class=\"cBtn\"  name = 'filter' value='Add Filter'>
		</form>";

        echo "
        <form action ='editSurvey.php' method = 'post'>
        <input type='hidden' name='varname' value='".$row["idSurvey"]."'>         
        <input type='submit' class=\"cBtn\"  name = 'edit' value='Edit Survey'>
        </form>";
     	}
     }
     else
     {
     	echo "No Surveys Found for $uvid<br/>";
     }
    echo "Button to select which to edit Survey Details<br/>";
    echo "Go to survey edit page(allow you to edit each details";
}
if (isset($_POST['createSurvey'])) {
    echo "TextBox to enter survey name<br/>";
    echo "<form action ='surveycreation.php' method = 'post'>
    <input type = 'text' name = 'surveyName'>
    <input type='submit' class=\"cBtn\"  name = 'submit' value='Submit'>
    </form>";

    
}



?>
<form action="surveyedit.php" method = "post">
<input type="submit" class="cBtn"  name="editSurvey" value="Edit Surveys" />
<input type="submit" class="cBtn"  name="createSurvey" value="Create Survey" />
</form>
<input type="button" class="cBtn" value="Back" onclick="location='index.php'" />

<?php
include('footer.php');
?>
