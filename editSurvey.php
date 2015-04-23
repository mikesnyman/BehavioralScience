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
	if($userLevel != 'Researcher' && $userLevel != 'Teacher')
	{
		echo"<script>window.location.href = \"index.php\";</script>";
		exit();
	}
	
}
?>
<input type="button" class = "cBtn fRight" value="Back" onclick="location='surveyeditfilter.php'" />
<input type="button" class = "cBtn fRight" value="Home" onclick="location='index.php'" />
<h2>Edit Study</h2><hr/>

<?php

	$_SESSION['varname2'] = $_SESSION['idSurvey'];


if( isset($_POST['id']))
{

	//$var_value = $_POST['varname'];
	$var_value = htmlspecialchars($_POST["id"]);
	$_SESSION['varname2'] = $var_value;
	//echo $var_value;
	
	
$sNum =  $_SESSION['varname2'];

include('ConnectToDb.php');
  $sql = "select description, SurveyType from Survey where idSurvey = $sNum";
  $result = $conn->query($sql);
	if ($result->num_rows > 0) {
		  while($row = $result->fetch_assoc())
		  {
			$_SESSION['SType']= $row["SurveyType"];
			$_SESSION['sName'] = $row["description"];   
		  }
	  }
}
$sName = $_SESSION['sName'];
$sNum =  $_SESSION['varname2'];
$Type = $_SESSION['SType'];
	echo "<h3>".$sName."</h3><br />";
echo '<form id="Addbtn" class="" action="editSurvey.php" method = "post">
<input type="submit" class = "cBtn fLeft" name="addQuestion" value="Add Question" />
<input type="submit" class = "cBtn fLeft" name="deleteQuestion" value="Delete Question" />
</form>';
if($Type ==0){
 echo '<input type = "button" class="cBtn fLeft" name ="AddFilter" value="Set Filter" onclick =QualtricsfilterSelect('.$sNum.')><br /><br /><br />';
}
else{
 echo '<input type = "button" class="cBtn fLeft" name ="AddFilter" value="Set Filter" onclick =filterSelect('.$sNum.')><br /><br /><br />';
}



$teh = "";
$counter = 0;
$sNum =  $_SESSION['varname2'];
//connect to database
include('ConnectToDb.php');
//show questions and answers
?>
<div class = "fLeft half">
<?php
$sql = "SELECT *,a.idQuestion as aid, b.idQuestion as bid, a.description as adescription, b.description as bdescription from Question a 
INNER JOIN Answer b on  a.idQuestion = b.idQuestion where idSurvey = $sNum  order by a.idQuestion ASC ,b.idAnswer";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc())
	  {
	  	if( $row["adescription"] != $teh)
     	{
     		$counter++;
     		 echo "<br /><strong>".$counter.". &nbsp&nbsp</strong>". $row["adescription"]."<br/>";
     		 //$test = str_replace(' ', '^*^',$test);
     	}
     	$teh = $row["adescription"];       
      	echo "<span class = 'padL'>".$row["bdescription"]."</span><br/>";
      	
	  }

  }
echo "<hr/>";
?>
</div>
<script type="text/javascript">
function showHide(){
	 var j = document.getElementById("Addbtn");
	 if(j.className == ""){
	 j.className = "hide";
	 }
	 else {
		j.className = "hide";
	 }
 }
 
function filterSelect($SID){
    var form = document.createElement("form");
    input = document.createElement("input");

form.action = "filter.php";
form.method = "post"

input.name = "id";
input.value = $SID;
form.appendChild(input);

document.body.appendChild(form);
form.submit();
}

function QualtricsfilterSelect($SID){
    var form = document.createElement("form");
    input = document.createElement("input");

form.action = "filterMySurvey.php";
form.method = "post"

input.name = "id";
input.value = $SID;
form.appendChild(input);

document.body.appendChild(form);
form.submit();
}

</script>
<?php
 if(isset($_POST['add']))
{
//session_start();
$sNum =  $_SESSION['varname2'];

echo"<script type=\"text/javascript\">
showHide();
</script>";
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
	//echo "<form action ='editSurvey.php' method = 'post'>";
		exit();

} 
//add question/answer
if (isset($_POST['addQuestion'])) {
?>
<div class = "fRight half">
<?php

echo"<script type=\"text/javascript\">
showHide();
</script>";
    echo"<h3>Add a Question</h3><br/>";

echo "<form action= '' method='post'>
Question: &nbsp; <input class = 'fRight largeInput' type='text' name='question' />
<br /><br/>
Answer One: &nbsp; <input class = 'fRight largeInput' type='text' name='ans1' />
<br /><br/>
Answer Two: &nbsp; <input class = 'fRight largeInput' type='text' name='ans2' />
<br /><br/>
Answer Three: &nbsp; <input class = 'fRight largeInput' type='text' name='ans3' />
<br /><br/>
Answer Four: &nbsp; <input class = 'fRight largeInput' type='text' name='ans4' />
<br /><br/>
Answer Five: &nbsp; <input class = 'fRight largeInput' type='text' name='ans5' />
<br /><br/>
Answer Six: &nbsp; <input class = 'fRight largeInput' type='text' name='ans6' />
<br /><br/>
<input type='submit' class = \"cBtn\" name='add' value = 'Submit'/>
</form><br/>";
?>
</div>
<?php
    
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
echo"<script type=\"text/javascript\">
showHide();
</script>";
	echo "Enter the question Number to remove<br/>";
    echo "<form action ='editSurvey.php' method = 'post'>
    <input type = 'text' name = 'questionDel'>
    <input type='submit' class = \"cBtn\" name = 'submit' value='Submit'>
    </form><br/>";
}
?>


<?php
include('footer.php');
?>