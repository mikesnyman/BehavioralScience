<?php
$ResearchSurvey='';
$QualticsSurvey='';
if($userLevel =="Participant" || $userLevel =="Teacher" || $userLevel =="Researcher" || $userLevel =="Admin"){
 //my Survey Div.  this is sql to get some crazy stuff.
	$MyAns="(SELECT sq.idSurvey,ua.idUser, count(ua.idSurvey) as counts FROM SurveyQualification sq inner join UserAnswer ua on sq.idQuestion = ua.idQuestion and sq.idAnswer = ua.idAnswer where ua.idUser = $uvid group by sq.idSurvey)";
	$QAns ="(SELECT s.SurveyType, sq.idSurvey, s.Description, COUNT(idQuestion) as counts, s.Link FROM (select distinct(idQuestion),idSurvey from SurveyQualification) sq inner join Survey s on sq.idSurvey = s.idSurvey   group by idSurvey)";
	$AllQualified ="(select  qa.SurveyType, ma.idUser, qa.Description,ma.idSurvey, qa.Link from $MyAns ma inner join $QAns qa on ma.idSurvey = qa.idSurvey where  qa.counts = ma.counts)";
	$ResSurv ="(SELECT a.Description, a.idSurvey FROM $AllQualified a WHERE (a.idSurvey) NOT IN (SELECT ss.idSurvey FROM StudentSurvey ss where remove = True) and a.SurveyType = 1)";
	$QualSur ="(SELECT a.Description, a.idSurvey, a.Link FROM $AllQualified a WHERE (a.idSurvey) NOT IN (SELECT ss.idSurvey FROM StudentSurvey ss where remove = True) and a.SurveyType = 0)";
	
	//Researcher survey
	$resultMe = $conn->query($ResSurv);
	$ResearchSurvey='';
	if ($resultMe->num_rows > 0){
		// output data of each row
		while($row = $resultMe->fetch_assoc())
		 {
			$Survey = $row['Description'];
			$SID = $row['idSurvey'];
			$ResearchSurvey.= "<div class =\"innerRow selectRow\"><span class=\"ninety\" onclick =\"testSelect($SID)\">$Survey</span><span class=\"X\" onclick =\"refresh('$SID')\">X</span></div>";
		}
	}			
	//QUaltrics survey
	$resultMe = $conn->query($QualSur);
	if ($resultMe->num_rows > 0){
		// output data of each row
		while($row = $resultMe->fetch_assoc())
		 {
			$Survey = $row['Description'];
			$SID = $row['idSurvey'];
			$Link = $row['Link'];
			if(!strpos($Link,"http://")){
			$Link = "http://" . $Link;
			}
			$QualticsSurvey.= "<div class =\"innerRow selectRow\"><span class=\"ninety\"  onclick =\"redirect('$Link','$SID')\">$Survey</span><span class=\"X\" onclick =\"refresh('$SID')\">X</span></div>";
		}
	}
	
}
	if(isset($_POST['survey']))
	{
	
		$sectionNum = $_SESSION['sectionNum'];
		$surveysId = $_POST['survey'];
		$sRemove = "update StudentSurvey ss set remove = True where ss.idUser = $uvid and ss.idSurvey = $surveysId";
		$conn->query($sRemove);
		$testTaken = "select * from StudentSurvey where idUser = $uvid and idSurvey = $surveysId";
		$result = $conn->query($testTaken);
		$sql = "insert into StudentSurvey (idUser,idSurvey,remove,SectionNum,dateTaken) values ($uvid,$surveysId,1,\"$sectionNum\",CurDate())"; 
		$result = $conn->query($sql);
		echo"<script>window.location.href = \"index.php\";</script>";
		
	}
	if(isset($_POST['preRedirect']))
	{
	
		$tArray = preg_split('/\s+/', $_POST['preRedirect']);
		$Link =  $tArray[0];
		$Selection =$tArray[1];
		$sql = "insert into StudentSurvey (idUser,idSurvey,remove,SectionNum,dateTaken) values ($uvid,$Selection,0,\"Online\",CurDate())"; 
		$result = $conn->query($sql);
		echo"<script>var win = window.open('$Link', '_blank');
				win.focus();</script>";
	}
?>
<script type="text/javascript">
function NotTaken(){
	alert("This Survey has not been taken");
};
function testSelect($SID){
	var form = document.createElement("form");
    input = document.createElement("input");

form.action = "takeSurvey.php";
form.method = "post"

input.name = "id";
input.value = $SID;
form.appendChild(input);

document.body.appendChild(form);
form.submit();
}
function refresh(test){
	var form = document.createElement("form");
    input = document.createElement("input");

form.action = "index.php";
form.method = "post"

input.name = "survey";
input.value = test;
form.appendChild(input);

document.body.appendChild(form);
form.submit();

}
function redirect(url,sid){
	var form = document.createElement("form");
    input = document.createElement("input");

form.action = "index.php";
form.method = "post"
input.name = "preRedirect";
input.value = url+" "+sid;
form.appendChild(input);

document.body.appendChild(form);
form.submit();
}

</script>