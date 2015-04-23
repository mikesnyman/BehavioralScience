<?php
//session start
session_start();
include('header.php');
//phpinfo();
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
<h2>Study Filter</h2><hr/>

<?php
//from post get survey name (survey id most likely) for the the filter to be attached to. 

if(isset($_POST['id']))
{
	//$sNum = $_POST['surveyNum'];
	//$_SESSION['sNum'] = $sNum;
	//echo "Your survey id: " ;
	
	//echo $sNum."<br/>";
	//echo "XXXXXXXXXXXXXXXXXXXXXXX";
$var_value = htmlspecialchars($_POST["id"]);
    $_SESSION['varname2'] = $var_value;
	//echo $var_value;
	$_SESSION['idSurvey'] =($_POST['id']);
}
$idSurvey = $_SESSION['idSurvey'];
//if filter exists already for this survey, do we update the filter and display a warning to the researcher?

echo "<form action=\"filter.php\" method = \"post\">
<input type=\"submit\" class=\"cBtn\" name=\"selectAll\" value=\"select All\" />
<input type=\"submit\" class=\"cBtn\" name=\"deselectAll\" value=\"deselect All\" />
</form>";


//for now work on survey id # 1, the characteristics profile

//connect to db
include('ConnectToDb.php');

//populate a list of questions and answers, EACH with a check box
//next update precheck list if its already been checked 
$sql = "select a.idAnswer, q.idQuestion, q.idSurvey, a.description as AnsDesc, q.description as QueDesc from Answer a 
inner join Question q on a.idQuestion = q.idQuestion where q.idSurvey =1  order by q.idQuestion ASC ,a.idAnswer ASC";
$result = $conn->query($sql);
$teh = "";
$test = "";
$idAns ="";
$idSur ="";
$idQue ="";


if ($result->num_rows > 0) {
    // output data of each row  
      echo "<form method=\"post\" name=\"filter\" action=\"filter.php\">";		
    while($row = $result->fetch_assoc())
     {	 

     	if( $row["QueDesc"] != $teh)
     	{
     		$test = $row["QueDesc"];
     		 echo "<hr /><strong>". $row["QueDesc"]."</strong><br>";
     		 //$test = str_replace(' ', '^*^',$test);
     	}
     	$teh = $row["QueDesc"];       
      	//echo $row["bdescription"];
      	$ans = $row["AnsDesc"];
		$idAns =  $row["idAnswer"];
		$idSur =  $row["idSurvey"];
		$idQue =  $row["idQuestion"];
		$checkBoxValue = $idAns.$idQue;
		
		$Query = "Select idAnswer, idQuestion from SurveyQualification where idSurvey = $idSurvey and idQuestion = $idQue";
		$fResult = $conn->query($Query);
		
		//creates checkbox
		echo " {$row['AnsDesc']}   <input type=\"checkbox\" value=\"".$checkBoxValue."\" name=\"checkbox[]\"";
		
		if ($fResult->num_rows > 0) {
			while($frow = $fResult->fetch_assoc()){
				$filterAnswer = $frow["idAnswer"];
				$filterQuestion = $frow["idQuestion"];
				$SurveyFilter = $filterAnswer.$filterQuestion;	
//puts chechs in boxes			 	
				if($checkBoxValue ==$SurveyFilter) echo 'checked="checked"';  
			}
		}	
		//end checkboxes
		echo "/>";
		
		echo "<br />";  

     	echo "<br/>";
		$filterQuestion="";
		$SurveyFilter ="";
		$filterAnswer ="";
    }

    echo "<hr /><input type = \"submit\" class='cBtn' value = \"Submit\">";
     echo "</form>";   
} else {
    echo "0 results found";
}

if(isset($_POST['deselectAll']))
{
	$AllChar = "delete from SurveyQualification where idSurvey = $idSurvey ";
	$result = $conn->query($AllChar);
	echo"<script>window.location.href = \"filter.php\";</script>";
}

if(isset($_POST['selectAll']))
{
	$idSurvey = $_SESSION['idSurvey'];
	$AllChar = 'select a.idQuestion, a.idAnswer from Answer a inner join Question q on q.idQuestion = a.idQuestion where q.idSurvey = 1 order by q.idQuestion';
	$result = $conn->query($AllChar);

	if ($result->num_rows > 0) {
		// output data of each row  	
		while($row = $result->fetch_assoc())
		{
			$Que = $row["idQuestion"];
			$Ans = $row["idAnswer"];
			$insertAll = "insert into SurveyQualification (idSurvey,idAnswer,idQuestion) values ($idSurvey,$Ans,$Que)";
			$Aresult = $conn->query($insertAll);
		echo"<script>window.location.href = \"filter.php\";</script>";

		}
	}	 
}


if(isset($_POST['checkbox']))
{
	$sNum =  $_SESSION['varname2'];
	$compare = "";
	$array = array();
	$sqlDel = "DELETE FROM SurveyQualification where idSurvey = $sNum";
	$conn->query($sqlDel);
	foreach($_POST['checkbox'] as $checkbox){

  //echo $checkbox . ' <br/>';
  $result = $conn->query($sql);
 if ($result->num_rows > 0) {
 	
 
 	//delete previous records, to have clean slate for filters in case they resubmit
 	
 while($row2 = $result->fetch_assoc())
     {	
     	$compare = $row2["idAnswer"].$row2["idQuestion"];
     	echo $compare;
     	echo "   ".$checkbox ."<br />";
     	//echo "the compare is".$compare;
     	$ansNum = $row2["idAnswer"];
     	$quesNum = $row2["idQuestion"];
     	$sqlInsert = "INSERT INTO SurveyQualification (idSurvey, idAnswer, idQuestion) VALUES ($sNum, $ansNum, $quesNum)";
     	if($compare == $checkbox)
     	{
     		
     		//echo $sNum. " " .$quesNum. " " . $ansNum;
     		
     		
     		$array[] = $sqlInsert;
     		$conn->query($sqlInsert);
     		//echo "FOUND MATCH";//
     	}
     }
 }

 }
 // foreach($array as $value)
 // {
 // 	echo $value."<br/>";
 // }
 echo"<script>window.location.href = \"surveyeditfilter.php\";</script>";
}
 
//User checks boxes they want to be part of the filter, multiple answers from same question is permitable.

//using MAGIC and the dark crafts. Manage to create the filter (do I save the results into a new table I create? The filter has to be saved so yes.)
//the surveyid tied to the filter as the foreign key with the filter id 
?>

<?php
include('footer.php');
?>