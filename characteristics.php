<?php
include('header.php');
?>

<input type="button" class = "cBtn fRight" value="Home" onclick="location='index.php'" />
<h2>User Characteristics Profile</h2><br>
<?php
//connected to database
include('ConnectToDb.php');

//recieves user uvuID, question ID and answer ID, check if the user has previously answered them.
//if user has answered the question previously, display question as selected.
function checkIfAns($uvID,$QID,$AID)
{
include('ConnectToDb.php');
//////---------------------------SET FOR SURVEY #1-----------------------------\\\\\\\\\\\\\
$sqlCheckUserAns = "SELECT * from UserAnswer where (idQuestion = $QID and idAnswer = $AID and idUser = $uvID and idSurvey = 1)";
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
 b.idAnswer as ansId from Question a INNER JOIN Answer b on  a.idQuestion = b.idQuestion where idSurvey = 1  order by a.idQuestion, b.idAnswer";
 //sql user Answers
 //query results
$result = $conn->query($sqlGetQuestions);
$noRepeat = false;
$previousQuest = "";

if ($result->num_rows > 0) {
	echo "<form method=\"post\" name=\"characteristics\" action=\"characteristicsAction.php\">";
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
     }
	 ?>
	 <input type="button" style="visibility:hidden;" /><br /><hr />
	 <?php
     echo "<input type = \"submit\" class = \"cBtn\" name = 'submitSurvey' value = \"Submit\">";
 	 echo "</form>";


?>




<?php
include('footer.php');
?>