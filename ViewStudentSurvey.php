<?php
	include('header.php');
	include('ConnectToDb.php');
	include('GetUserLevel.php');
	echo "<br /><button class = 'cBtn fRight' onclick=\"location.href = 'index.php';\">Home</button>";
	echo "<h2>Student Id by Study</h2>
	<hr />";
	if($userLevel =="Teacher" || $userLevel =="Admin"){
	
	echo "
<ul class=\"nav nav-pills\">
    <li class=\"active\"  id=\"studyPill\" onclick = \"ByStudy()\" ><a href=\"#\">By Study</a></li>
    <li class = \"\"><a href=\"#\"  id=\"classPill\" onclick = \"ByStudy()\">By Class</a></li>
  </ul><hr />";


echo "<div id = \"classDiv\" class = \"hide\">";
	$AllClasses = 'select distinct ss.SectionNum from StudentSurvey ss where ss.dateTaken >= CURDATE()-120';
	$printClasses ="";
	$cResult = $conn->query($AllClasses);
	if ($cResult->num_rows > 0){
			// output data of each row
			while($Crow = $cResult->fetch_assoc())
			{
				$Classes = $Crow['SectionNum'];
				$printClasses ="<h3>$Classes</h3>";
			 
				$StudByClass="";
				$ByStudent = "select count(idUser) as counts, idUser from StudentSurvey s where s.SectionNum = \"$Classes\" and dateTaken >= CURDATE()-120  group by idUser";
				$result = $conn->query($ByStudent);
				if ($result->num_rows > 0){
						// output data of each row
						while($row = $result->fetch_assoc())
						 {
							$Count = $row['counts'];
							$idUser = $row['idUser'];
							$StudByClass.= "<div class=\"innerRow padL\"> $Count &nbsp; &nbsp; $idUser</div>";
						 }
					}
					echo $printClasses.$StudByClass;
			}
		}
	
	echo "</div>";

echo "<div id = \"studyDiv\" class = \"\">";	  
	//gets surveys and students who have taken them for the last 4 months
		$UserSurvey = "select s.description, s.idSurvey from StudentSurvey ss inner join Survey s on ss.idSurvey = s.idSurvey where s.DateCreate >= CURDATE()-120 order by s.idSurvey desc";
		$resultSurvey = $conn->query($UserSurvey);
		$SSurvey='';
		if ($resultSurvey->num_rows > 0){
			// output data of each row
			while($row = $resultSurvey->fetch_assoc())
			 {
				$SurveyId = $row['idSurvey'];
				$SurveyName = $row['description'];
				
				//get Users who have taken this survey
				$UsersForSurvey = "select ss.idUser from StudentSurvey ss inner join Survey s on ss.idSurvey = s.idSurvey where s.idSurvey =$SurveyId";
				$resultUsers = $conn->query($UsersForSurvey);
				$SUsers='';
				if ($resultUsers->num_rows > 0){
					// output data of each row
					while($row = $resultUsers->fetch_assoc())
					 {
						$Student = $row['idUser'];
						$SUsers.= "<div class =\"innerRow\"><div class =\"half\"> $Student </div></div>";
					}
				}
				
				//end of users
				$SSurvey.= "<div class =\"innerRow selectRow\"><div  onclick = \"ShowAnswers('$SurveyId')\">$SurveyName </div><div  id =$SurveyId class =\"hide\"> $SUsers </div></div>";
			}
			echo "<div><div class =\"padL\"><h3 class =\"third\">Stuy Name<h4 class =\"third\">(click study to see participants)</h4></h3></div></div>";
			echo"<div class=\"scroll-large\"><div >$SSurvey</div></div><br />";
		}
	echo "</div>";
			//post function  and hide show function
	echo "
			<script type=\"text/javascript\">
				
				function ShowAnswers(survey){
					var Users = document.getElementById(survey);
					if(Users.className ==\"hide\"){
					Users.className =\"\";
					}
					else{
					Users.className = \"hide\";
					}
				}
				
				function ByStudy(){
					var byStudy = document.getElementById(\"studyDiv\");
					var byClass = document.getElementById(\"ByClass\");
					var studyPill = document.getElementById(\"studyPill\");
					var classPill = document.getElementById(\"classPill\");
					if(studyDiv.className == \"hide\"){
						studyDiv.className = \"\";
						classDiv.className = \"hide\";
						studyPill.className = \"active\";
						classPill.className = \"\";
					}
					else{
						classDiv.className = \"\";
						studyDiv.className = \"hide\";
						studyPill.className = \"\";
						classPill.className = \"active\";
					
					}
				}
				</script>";
	}
	include('footer.php');
?>