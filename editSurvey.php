<?php

//probably change the name, the page that actually edits the survey
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
	if($userLevel != 'Researcher')
	{
		echo"<script>window.location.href = \"index.php\";</script>";
		exit();
	}
	
}
?>
<h2>Edit Survey</h2>

<?php

if($_POST['id'] || isset($_POST['id']))
{

	//$var_value = $_POST['varname'];
	$var_value = htmlspecialchars($_POST["id"]);
	$_SESSION['varname2'] = $var_value;
	//echo $var_value;
}
$teh = "";
$counter = 0;
$sNum =  $_SESSION['varname2'];
//connect to database
include('ConnectToDb.php');
//show questions and answers
$sql = "SELECT *,a.idQuestion as aid, b.idQuestion as bid, a.description as adescription, b.description as bdescription from Question a 
INNER JOIN Answer b on  a.idQuestion = b.idQuestion where idSurvey = $sNum  order by a.idQuestion ASC ,b.idAnswer";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc())
	  {
	  	if( $row["adescription"] != $teh)
     	{
     		$counter++;
     		 echo "#".$counter." Question: ". $row["adescription"]."<br/>";
     		 //$test = str_replace(' ', '^*^',$test);
     	}
     	$teh = $row["adescription"];       
      	echo $row["bdescription"]."<br/>";
      	
	  }

  }
echo "<hr/>";
 if(isset($_POST['add']))
{
//session_start();
$sNum =  $_SESSION['varname2'];


include('ConnectToDb.php');
//echo "before prepare";
$question = $_POST['question'];
$ans1 = $_POST['ans1'];
$ans2 = $_POST['ans2'];
$ans3 = $_POST['ans3'];
$ans4 = $_POST['ans4'];
$ans5 = $_POST['ans5'];
$ans6 = $_POST['ans6'];

//get question id
$sql = "INSERT INTO Question (idSurvey, description) VALUES ($sNum, \"$question\")";
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
echo"<script>window.location.href = \"editSurvey.php\";</script>";
		exit();

} 
//add question/answer
if (isset($_POST['addQuestion'])) {
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
</form><br/>";

    
}
//edit question/answer

//delete question
if(isset($_POST['submit']))
{
$teh = "";
$counter = 0;
$sNum =  $_SESSION['varname2'];
//connect to database
include('ConnectToDb.php');
//show questions and answers
$sql = "SELECT *,a.idQuestion as aid, b.idQuestion as bid, a.description as adescription, b.description as bdescription from Question a 
INNER JOIN Answer b on  a.idQuestion = b.idQuestion where idSurvey = $sNum  order by a.idQuestion ASC ,b.idAnswer";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	$sName = $_POST['questionDel'];
	if (is_numeric($sName)) {
	  while($row = $result->fetch_assoc())
	  {
	  	$questionId = $row['aid'];

	  	if( $row["adescription"] != $teh)
     	{
     		$counter++;
     		 //echo "#".$counter." Question: ". $row["adescription"]."<br/>";
     		 //$test = str_replace(' ', '^*^',$test);

     	}
     	$teh = $row["adescription"];       
      	//echo $row["bdescription"]."<br/>";
      	if($counter == $sName)
	  	{
	  		//echo "deleting".$counter;
	  		$sqla = "DELETE FROM Answer where idQuestion = $questionId";
	  		$conn->query($sqla);
	  		$sqla = "DELETE FROM Question where idQuestion = $questionId";
	  		$conn->query($sqla);
	  	}
      	
	  }
	  echo"<script>window.location.href = \"editSurvey.php\";</script>";
		exit();
	}
	else{
		echo "Not a valid input.";
	}

  }

}

if(isset($_POST['deleteQuestion']))
{
	echo "Enter the question Number to remove<br/>";
    echo "<form action ='editSurvey.php' method = 'post'>
    <input type = 'text' name = 'questionDel'>
    <input type='submit' name = 'submit' value='Submit'>
    </form><br/>";
}
?>

<form action="editSurvey.php" method = "post">
<input type="submit" name="addQuestion" value="Add Question" />
<input type="submit" name="deleteQuestion" value="Delete Question" />
</form>
<input type="button" value="Back" onclick="location='surveyedit.php'" />

<?php
include('footer.php');
?>