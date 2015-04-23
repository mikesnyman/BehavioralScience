
<?php
session_start();
include('header.php');
?>
<input type="button" class = "cBtn fRight" value="Home" onclick="location='index.php'" />
<?php
include('ConnectToDb.php');
if(isset($_POST['id']))
{
$Selection =  htmlspecialchars($_POST["id"]);
	$_SESSION['Selection'] = $Selection;
}
$Selection = $_SESSION['Selection'];

$SName = "SELECT description,background FROM Survey where idSurvey =$Selection";
$result = $conn->query($SName);
if ($result->num_rows > 0) {
while($row = $result->fetch_assoc())
     {
		$joe= $row["description"];
        $backgroundInfo = $row['background'];
	 }
}

echo "<h2>$joe</h2><br>";
//pull from database using userID and user level given from call(global variable?)
//if not new
echo "<p>$backgroundInfo</p>";
//connected to database
include('ConnectToDb.php');
//recieves user uvuID, question ID and answer ID, check if the user has previously answered them.
//if user has answered the question previously, display question as selected.
function checkIfAns($uvID,$QID,$AID)
{
include('ConnectToDb.php');
$Selection = $_SESSION['Selection'];
//////---------------------------SET FOR SURVEY #1-----------------------------\\\\\\\\\\\\\
$sqlCheckUserAns = "SELECT * from UserAnswer where (idQuestion = $QID and idAnswer = $AID and idUser = $uvID and idSurvey = $Selection)";
$resultCheck = $conn->query($sqlCheckUserAns);
$doesExists = false;
if ($resultCheck->num_rows > 0) {
	 while($row = $resultCheck->fetch_assoc())
     {
	$doesExists = true;
	//echo "<script>alert(\"TRUE\");</script>";
	return $doesExists;
	}
}
else
{
	//echo "<script>alert(\"FALSE\");</script>";
	return $doesExists;
}

}


	
//sql Questions
$sqlGetQuestions = "SELECT *,a.idQuestion as aid, b.idQuestion as bid, a.description as adescription, b.description as bdescription,
 b.idAnswer as ansId from Question a INNER JOIN Answer b on  a.idQuestion = b.idQuestion where idSurvey = $Selection  order by a.idQuestion, b.idAnswer";
 //sql user Answers
 //query results
$result = $conn->query($sqlGetQuestions);
$noRepeat = false;
$previousQuest = "";

if ($result->num_rows > 0) {
	echo "<form method=\"post\" name=\"characteristics\" action=\"surveyAction.php\">";
	

	if(!isset($_POST['SectionNum'])){
	echo'
	<br /><div >Enter your Section <input type="text" id = "section" required name ="sectionNumber" onblur= "setSection()"/>
	</div>';
	}
	
	if(isset($_POST['SectionNum'])){
	$values = $_POST['SectionNum'];
	$values = strtoupper($values);
	$values = str_replace(" ", "", $values);
	if($values == "")
	{
		$values="None";
	}
	
	echo"
	<br /><div >Enter your Section <input type=\"text\" id = \"section\" required name =\"sectionNumber\" value = ".$values." onblur= \"setSection()\"/>
	</div>";
		$_SESSION['sectionNum']= $values;
	}
	
	
	 while($row = $result->fetch_assoc())
     {

     	//close selection option 
     	if($row["adescription"] != $previousQuest && $noRepeat == true)
     	{
        echo " </select> ";
      	echo "<br/>";


     	}	
     	$ansName = $row['bdescription'];
     	$numQues = $row['aid'];
     	$numAns = $row['ansId'];
     	$boolCheck = checkIfAns($uvid,$numQues,$numAns);
     	//prevent mutliple instances of question being shown 1 per answer group
     	if( $row["adescription"] != $previousQuest)
     	{
     	$quesName =	$row["adescription"];
     	$quesNameShrt = $quesName;
     	echo "<hr><strong>".$row['adescription']."</strong><br/>";
     	$quesNameShrt = str_replace(' ', '',$quesNameShrt);
        echo "<select name=\"$numQues\">";
    
        	if( $boolCheck == false)
        	{
        		 echo "<option value=\"0\" selected=\"selected\">Pick Your Answer</option> ";
        	}

   		}

     	$previousQuest = $row["adescription"];

     	
     	if( $row["adescription"] == $previousQuest)
     	{
     		$noRepeat = true;
     	}
     	//check if answer was previous answered by the user.
     	if($boolCheck == true)
     	{
     	echo "<option value=\"a".$numAns."\" selected=\"selected\">$ansName</option>"; 	
     	}
     	else
     	{
     	echo "<option value=\"a".$numAns."\">$ansName</option>";
     	}

     	}		
	 ?>
	 <input type="button" style="visibility:hidden;" /><br /><hr />
	 <?php
     }
     echo "<input type = \"submit\" class = \"cBtn\" name = 'submitSurvey' value = \"Submit\">";
 	 echo "</form>";


?>
<script type="text/javascript">
	function setSection(){
		var sec = document.getElementById("section").value;
		var form = document.createElement("form");
		input = document.createElement("input");
		form.action = "takeSurvey.php";
		form.method = "post"

		input.name = "SectionNum";
		input.value = sec;
		form.appendChild(input);

		document.body.appendChild(form);
		form.submit();

	}
</script>



<?php
include('footer.php');
?>