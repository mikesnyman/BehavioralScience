<?php
	if($userLevel =="Teacher" || $userLevel =="Researcher" || $userLevel =="Admin"){
		include('participant.php');
		if($userLevel =="Teacher" || $userLevel =="Admin"){
			echo "<input type=\"button\" class='cBtn' value=\"View student Id's for studies\" onclick=\"location='ViewStudentSurvey.php'\" />";
		}
		echo "<input type=\"button\" class='cBtn' value=\"View study Results\" onclick=\"viewResults()\" />";
		echo "<input type=\"button\" class='cBtn' value=\"Edit study\" onclick=\"location='surveyeditfilter.php'\" />";
		echo "<input type=\"button\" class='cBtn' value=\"Create study\" onclick=\"location='surveycreationmain.php'\" />";
		
		echo "
			<script type=\"text/javascript\">
				function viewResults(){
					var form = document.createElement(\"form\");
					input = document.createElement(\"input\");
					input2 = document.createElement(\"input2\");

				form.action = \"ViewSurveyResults.php\";
				form.method = \"post\"

				input.name = \"Surveys0\";
				input.value = 1;
				input2.value = 1;
				form.appendChild(input);

				document.body.appendChild(form);
				form.submit();
				}
			</script>";
				}

	
?>


