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
<h2>Survey Filter</h2><hr/>
<p>Select the answers for the filter.</p><br />
<p>Must select at least one.</p>

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

//for now work on survey id # 1, the characteristics profile

//connect to db
include('ConnectToDb.php');


//populate a list of questions and answers, EACH with a check box
//next update precheck list if its already been checked 

//$MySIds = "";
//$sqlMySurveys = "select idSurvey from Survey where idResearcher = $uvid";
//$Myresult = $conn->query($sqlMySurveys);
//if ($Myresult->num_rows > 0) {
//	while($Srow = $Myresult->fetch_assoc())
//     {
//		$MySIds .= $Srow["idSurvey"] . ",";
//	 }
//}
//$MySIds = rtrim($MySIds, ",");

$sqlMySurveys = "select idSurvey, description from Survey where idResearcher = $uvid";
$Myresult = $conn->query($sqlMySurveys);
if ($Myresult->num_rows > 0) {
	while($Srow = $Myresult->fetch_assoc())
     {
	 //name of survey
		$SName = $Srow["description"];
		$MySIds = $Srow["idSurvey"];
		echo "<hr /><h3>".$SName."</h3>";
		$sql = "select a.idAnswer, q.idQuestion, q.idSurvey, a.description as AnsDesc, q.description as QueDesc from Answer a 
		inner join Question q on a.idQuestion = q.idQuestion where q.idSurvey in($MySIds)  order by q.idQuestion ASC ,a.idAnswer ASC";
		$result = $conn->query($sql);
		$teh = "";
		$test = "";
		$idAns ="";
		$idSur ="";
		$idQue ="";


		if ($result->num_rows > 0) {
			// output data of each row  
			  echo "<form method=\"post\" name=\"filterMySurvey\" action=\"filterMySurvey.php\">";		
			while($row = $result->fetch_assoc())
			 {	 

				if( $row["QueDesc"] != $teh)
				{
					$test = $row["QueDesc"];
					 echo "<strong>". $row["QueDesc"]."</strong><br>";
					 //$test = str_replace(' ', '^*^',$test);
				}
				$teh = $row["QueDesc"];       
				//echo $row["bdescription"];
				$ans = $row["AnsDesc"];
				$idAns =  $row["idAnswer"];
				$idSur =  $row["idSurvey"];
				$idQue =  $row["idQuestion"];
				$checkBoxValue = $idAns." ".$idQue;
				
				$Query = "Select idAnswer, idQuestion from SurveyQualification where idSurvey = $idSurvey and idQuestion = $idQue";
				$fResult = $conn->query($Query);
				
				//creates checkbox
				echo " {$row['AnsDesc']}   <input type=\"checkbox\" value=\"".$checkBoxValue."\" name=\"checkbox[]\"";
				
				if ($fResult->num_rows > 0) {
					while($frow = $fResult->fetch_assoc()){
						$filterAnswer = $frow["idAnswer"];
						$filterQuestion = $frow["idQuestion"];
						$SurveyFilter = $filterAnswer." ".$filterQuestion;	
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
 
		}//end of sql to get questions
	}
	
	echo "<input type = \"submit\" class='cBtn' value = \"Submit\">";
	 echo "</form>";  
}

 else {
    echo "0 results found";
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
 	
		$parts = preg_split('/\s+/', $checkbox);
		//echo $parts[0]." ";
		//echo $parts[1]."<br />";
		$ansNum = $parts[0];
		$quesNum = $parts[1];
 //while($row2 = $result->fetch_assoc())
     //{	
     	//$compare = $row2["idAnswer"].$row2["idQuestion"];
     	//echo $compare;
     	//echo "   ".$checkbox ;
     	//echo "the compare is".$compare;
     //	$ansNum = $row2["idAnswer"];
     //	$quesNum = $row2["idQuestion"];
     	$sqlInsert = "INSERT INTO SurveyQualification (idSurvey, idAnswer, idQuestion) VALUES ($sNum, $ansNum, $quesNum)";
     //	if($compare == $checkbox)
     	{
     		
     		//echo $sNum. " " .$quesNum. " " . $ansNum;
     		
     		
     		$array[] = $sqlInsert;
     		$conn->query($sqlInsert);
     		//echo "FOUND MATCH";//
     	}
    // }
 }

 }
 // foreach($array as $value)
 // {
 // 	echo $value."<br/>";
 // }
	echo"<script>window.location.href = \"filterMySurvey.php\";</script>";
}
 
//User checks boxes they want to be part of the filter, multiple answers from same question is permitable.

//using MAGIC and the dark crafts. Manage to create the filter (do I save the results into a new table I create? The filter has to be saved so yes.)
//the surveyid tied to the filter as the foreign key with the filter id 
?>

<?php
include('footer.php');
?>