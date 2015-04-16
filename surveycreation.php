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
    echo "No User Found.<br>";
   

}
if($userLevel != 'Admin')
{
	if($userLevel != 'Resercher')
	{
		echo"<script>window.location.href = \"index.php\";</script>";
		exit();
	}
	
}
?>
<h2>Survey Creation Page</h2><br>

<?php
if(isset($_POST['submit']))
{
	$sName = $_POST['surveyName'];
	$_SESSION['sName'] = $sName;
	echo "Your survey name: ";
	
	echo $sName."<br/>";
$surveyType = $_POST['type'];
$link = $_POST['surveyLink'];
echo "Your survey type is: ".$surveyType."<br>";
echo "Your survey link is: ".$link;
$_SESSION['sType'] = $surveyType;
include('ConnectToDb.php');
$sql = "INSERT INTO Survey (idResearcher, description,DateCreate,SurveyType,Link) VALUES ($uvid, '$sName',NOW(),$surveyType,'$link')";
$conn->query($sql);	





}

if(isset($_POST['addQuestion']))
{
	//session_start();
	$sName = $_SESSION['sName'];

	createQuestion();
}

if(isset($_POST['add']))
{
//session_start();
$sName = $_SESSION['sName'];


include('ConnectToDb.php');
//echo "before prepare";
$question = $_POST['question'];
$ans1 = $_POST['ans1'];
$ans2 = $_POST['ans2'];
$ans3 = $_POST['ans3'];
$ans4 = $_POST['ans4'];
$ans5 = $_POST['ans5'];
$ans6 = $_POST['ans6'];
//get survey id
$sql = "SELECT idSurvey from Survey WHERE description = \"$sName\"";

$result = $conn->query($sql);
if ($result->num_rows > 0)
{
$sid = "";
    // output data of each row
    while($row = $result->fetch_assoc())
{
 $sid = $row["idSurvey"];
}
     
       

    
} else {
    echo "No Survey found.<br>";

}
//get question id
$sql = "INSERT INTO Question (idSurvey, description) VALUES ($sid, \"$question\")";
$conn->query($sql);
$sql = "SELECT idQuestion from Question WHERE description = \"$question\"";

$result = $conn->query($sql);
if ($result->num_rows > 0)
{
    // output data of each row
    $row = $result->fetch_assoc();
     
        $qid = $row["idQuestion"];

    
} else {
    echo "No Question Found.<br>";

}
//inserts for the questions as long as they are not null
if ($ans1 != NULL)
{
$sql = "INSERT INTO Answer (idAnswer, idQuestion, description) VALUES (1,$qid, \"$ans1\")";
$conn->query($sql);

}

if ($ans2 != NULL)
{
$sql = "INSERT INTO Answer (idAnswer,idQuestion, description) VALUES (2,$qid, \"$ans2\")";

$conn->query($sql);

}

if ($ans3 != NULL)
{
$sql = "INSERT INTO Answer (idAnswer,idQuestion, description) VALUES (3,$qid, \"$ans3\")";

$conn->query($sql);

}

if ($ans4 != NULL)
{
$sql = "INSERT INTO Answer (idAnswer,idQuestion, description) VALUES (4,$qid, \"$ans4\")";

$conn->query($sql);

}

if ($ans5 != NULL)
{
$sql = "INSERT INTO Answer (idAnswer,idQuestion, description) VALUES (5,$qid, \"$ans5\")";

$conn->query($sql);

}

if ($ans6 != NULL)
{
$sql = "INSERT INTO Answer (idAnswer,idQuestion, description) VALUES (6,$qid, \"$ans6\")";

$conn->query($sql);

}
$conn->close();
}

//echo out the form to fill out for question creation
function createQuestion()
{
	echo"<h3>Add a Question</h3><br/>";

echo "<form action= '' method='post'>
Question: &nbsp; <input type='text' name='question' />
<br /><br/>
Answer One: &nbsp; <input type='text' name='ans1' />
<br /><br/>
Answer Two: &nbsp; <input type='text' name='ans2' />
<br /><br/>
Answer Three: &nbsp; <input type='text' name='ans3' />
<br /><br/>
Answer Four: &nbsp; <input type='text' name='ans4' />
<br /><br/>
Answer Five: &nbsp; <input type='text' name='ans5' />
<br /><br/>
Answer Six: &nbsp; <input type='text' name='ans6' />
<br /><br/>
<input type='submit' name='add' value = 'Submit'/>
</form>";
}
?>

<form action="surveycreation.php" method = "post">
<input type="submit" name="addQuestion" value="Add a Question" />

<!--<input type="submit" name="finish" value="Finish" /> -->
</form>
<input type="button" value="Back" onclick="location='surveycreationmain.php'" />


<?php
include('footer.php');
?>
