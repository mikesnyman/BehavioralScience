<?php
session_start();

//take question id, answer id, user id and find out if answer exists in database if not, add it, if it is but different answer id, update old and add new.
function addAnswer($QID,$AID,$UVID)
{
	//echo "adding question#".$QID." Answer#".$AID."<br>";
	include('ConnectToDb.php');
	//check if answer from same question exists
	$checkAnsQuesIdExists = "SELECT * from UserAnswer where idQuestion = $QID and idUser = $UVID";
	$cAQIEresult = $conn->query($checkAnsQuesIdExists);
	if ($cAQIEresult->num_rows > 0)
	{
		 while($row = $cAQIEresult->fetch_assoc())
		 {
		 	//if the same answer, do nothing
		 	if($row['idAnswer'] == $AID)
		 	{
		 		//echo "Answer is the same, do nothing.<br>";
		 		return;
		 	}
		 	else
		 	{
		 		//if different answer, update old answer add to database
		 		//echo "Answer is different, update old answer<br>";
		 		$updateAnsQues = "UPDATE UserAnswer SET idAnswer = $AID WHERE idQuestion = $QID and idUser = $UVID";
		 		$conn->query($updateAnsQues);
		 		return;
		 	}	
			
		 }
		
	}
	else
	{
		$Selection = $_SESSION['Selection'];
		//if not exists, add to database //////////warning using survey 1\\\\\\\\\\\\\\\\\
		//echo "Answer does not exists in database, adding it to database<br>";
		$addAnsQues = "INSERT INTO UserAnswer (idAnswer, idQuestion, idUser, idSurvey) VALUES ($AID,$QID,$UVID,$Selection)";
		$conn->query($addAnsQues);
		 return;
	}
	
	
	
}
//get results from characterisitcs
if(isset($_POST["submitSurvey"]))
{
	$Selection = $_SESSION['Selection'];
	$sectionNum = $_SESSION['sectionNum'];
	////////////////////////WARNING WARNING WARNING USING SURVEY # 1 in this example, make sure you set it to recieve idSurvey from $_POST\\\\\\\\\\\\\\\\\\\\\\\\\\\
	$sqlGetQuestions = "SELECT *,a.idQuestion as aid, b.idQuestion as bid, a.description as adescription, b.description as bdescription,
 	b.idAnswer as ansId from Question a INNER JOIN Answer b on  a.idQuestion = b.idQuestion where idSurvey = $Selection  order by a.idQuestion, b.idAnswer";
 //sql user Answers
 //query results
 	include('ConnectToDb.php');
	$StudentSurvey = "insert into StudentSurvey (idUser,idSurvey,remove,SectionNum,dateTaken) values ($uvid,$Selection,0,\"$sectionNum\",CurDate())"; 
	$result = $conn->query($StudentSurvey);
	$result = $conn->query($sqlGetQuestions);
	if ($result->num_rows > 0) {
	$noRepeat = false;
	$quesIdCheck = 0;
	$returnIndex = true;
	 while($row = $result->fetch_assoc())
     {
     	$quesName = $row['adescription'];
     	$quesNameShrt = $quesName;
     	$quesId = $row['aid'];
     	$ansId = $row['ansId'];

     	//echo "have question###-------- ".$quesId." -----ANSWER ID--------- ".$ansId."<br>";
     	$quesNameShrt = str_replace(' ', '',$quesNameShrt); 
     	$value = $_POST["$quesId"];
     	$value = str_replace('a', '',$value);
     	//echo "the value:".$value."<br />";
     	
     	
     	//prevent repeating and diffferent data being fed
     	if($quesIdCheck != $quesId)
     	{
     		$quesIdCheck = $quesId;
     		$noRepeat = false;
     	}
     	if($value != '0' && $noRepeat == false)
     	{
     		addAnswer($quesId,$value,$uvid);
     		$noRepeat = true;
     	}
     	
     	//$quesIdCheck = $quesId;
     	if($value == '0')
     	{
     		//echo "----------------didn't answer question------------------";
     		$returnIndex = false;
     	}
     	// function to do work
     }

 }
}

if($returnIndex == true)
{
	echo"<script>window.location.href = \"index.php\";</script>";
}
else
{
	//return to last User Survey(currently characterisitcs)
	echo"<script>window.location.href = \"takeSurvey.php\";</script>";
}

//if user has any missed questions, reroute back to characterisitcs.php

//if new user answer all of questions, switch them back to participant and reroute back to index
?>