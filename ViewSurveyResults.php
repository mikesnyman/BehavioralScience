<?php
session_start();
include('header.php');
include('ConnectToDb.php');
include('GetUserLevel.php');
echo "<br /><button class = 'cBtn fRight'  onclick=\"location.href = 'index.php';\">Home</button>";
echo "<h2>Study Results</h2><hr />";
if($userLevel =="Teacher" || $userLevel =="Researcher" || $userLevel =="Admin"){

//veiw to surveys
	if(isset($_POST['Surveys0']))
	{
		$AllMySurveys = "select idSurvey,description from Survey where idResearcher = $uvid and SurveyType = 1 order by idSurvey desc limit 50";	
		$resultMySurveys = $conn->query($AllMySurveys);
		$SurveyAll='';
		if ($resultMySurveys->num_rows > 0){
			// output data of each row
			while($row = $resultMySurveys->fetch_assoc())
			 {
				$Name = $row['description'];
				$Sid = $row['idSurvey'];
				$SurveyAll.= "<div class =\"innerRow selectRow\"  onclick= \"postChange($Sid,1)\"><span>$Name </span></div>";
			
			}
				echo "
					<div id = \"listOfSurveys\">
						<div class =\"half padL\">
							<h3>Select a study to view</h3>
						</div>
						<div class=\"scroll-large\">
							<div >$SurveyAll</div>
						</div>
					</div>
					<br />";
		}
	}	
	
	//view all questions for selected survey
	if(isset($_POST['Surveys1']))
	{	
		$Selection =  htmlspecialchars($_POST["Surveys1"]);
		//$sqlMe ="select s.description as survey, a.description as answer,q.description as question from UserAnswer ua inner join Survey s on s.idSurvey = ua.idSurvey inner join Question q on q.idQuestion = ua.idQuestion inner join Answer a on a.idAnswer = ua.idAnswer and a.idQuestion = ua.idQuestion  where idResearcher = $uvid order by survey, question, answer;";
		 $MyQuestions = "select idQuestion, description from Question where idSurvey = $Selection ";
		$resultMe = $conn->query($MyQuestions);
		$QAll='';
		if ($resultMe->num_rows > 0){
			// output data of each row
			while($row = $resultMe->fetch_assoc())
			 {
				$Name = $row['description'];
				//$Ans = $row['answer'];
				$Que = $row['idQuestion'];
				
				
				//get answers from Survey this is inside the question loop
				$TheAnswers = "select distinct(A.description), ua.idAnswer from UserAnswer ua 
								inner join Answer A on ua.idAnswer = A.idAnswer and ua.idQuestion = A.idQuestion 
								where ua.idQuestion = $Que order by A.description;";		 
				$resultAnswers = $conn->query($TheAnswers);
				$AAll='<div class =\"innerRow padL \"><div class =\"ninety\">&emsp; # of Students &emsp;&emsp; Answer </div></div>';
				if ($resultAnswers->num_rows > 0){
					// output data of each row
					while($row = $resultAnswers->fetch_assoc())
					 {
						$Answers =$row['description'];
						$idAns = $row['idAnswer'];
						$Count = "select count(idAnswer) as counts from UserAnswer where idAnswer =$idAns and idQuestion = $Que";
						$resultCount = $conn->query($Count);
						if ($resultCount->num_rows > 0){
							// output data of each row
							while($countRow = $resultCount->fetch_assoc())
							 {
								$ACount = $countRow['counts'];
								$AAll.= "<div class =\"innerRow padL \"><div class =\"ninety\">&emsp; $ACount &emsp;&emsp;&emsp;&emsp; $Answers </div></div>";
							 }
						}
					 }
				}
				//end of getting Answers
				
				$QAll.= "<div class =\"innerRow\"><div onclick = \"ShowAnswers('$Que')\" class =\"ninety selectRow\">$Name </div><div id =$Que class =\"hide\">$AAll</div></div>";
			}
			//end of getting questions
			echo "
					<div id = \"StudentSurveyResults\">
						<div>
							<h3 class =\"half\">Question
								<h4 class =\"third\">(click to see Answers)</h4>
							</h3> 
						</div>
						<div class=\"scroll-large\">
							<div >$QAll</div>
						</div>
					</div>
					<br />";
		}
				else{
				echo "<h4>There are no questions for this study</h4>";
				}
	echo "<br /><button class = 'cBtn' onclick= \"postChange(1,0)\">back</button>";
	}
		
		
	//post function  and hide show function
	echo "
			<script type=\"text/javascript\">
				function postChange(sid,num){
					var form = document.createElement(\"form\");
					input = document.createElement(\"input\");

				form.action = \"ViewSurveyResults.php\";
				form.method = \"post\"

				input.name = \"Surveys\"+num;
				input.value = sid;
				form.appendChild(input);

				document.body.appendChild(form);
				form.submit();
				}
				
				function ShowAnswers(question){
					var Answers = document.getElementById(question);
					if(Answers.className ==\"hide\"){
					Answers.className =\"\";
					}
					else{
					Answers.className = \"hide\";
					}
				}
				</script>";
			
}
	$conn->close();
	include('footer.php');
?>

				
