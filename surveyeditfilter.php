<?php
//change name most likley, survey edit landing page, remove create survey add to its own button on main
include('header.php');
include('ConnectToDb.php');
include('GetUserLevel.php');
if($userLevel =="Teacher" || $userLevel =="Researcher" || $userLevel =="Admin"){
echo '<input type="button" class = "cBtn fRight" value="Home" onclick="location=\'index.php\'" />';
echo "<h2>Study Edit Page</h2><hr />";
$sql = "SELECT description,SurveyType, idSurvey from Survey where idResearcher = $uvid";
$resultMe = $conn->query($sql);
    $ResearchSurvey='';
    if ($resultMe->num_rows > 0){
        // output data of each row
        while($row = $resultMe->fetch_assoc())
         {
            $Survey = $row['description'];
            $SID = $row['idSurvey'];
            $Type = $row['SurveyType'];
			if($Type == 0){
			$ResearchSurvey.= "<div class =\"innerRow\"><span class=\"fifty padL\">$Survey</span><span class=\"padL selectRow\" onclick =\"testSelect($SID)\">|  Edit Study  |</span><span class=\"padL selectRow\" onclick =\"QualtricsfilterSelect($SID)\">|  Add Filter  |</span><span class=\"padL selectRow\" onclick =\"deleteSelect($SID)\">|  Delete Study  |</span></div>";
			}
			else{
            $ResearchSurvey.= "<div class =\"innerRow\"><span class=\"fifty padL\">$Survey</span><span class=\"padL selectRow\" onclick =\"testSelect($SID)\">|  Edit Study  |</span><span class=\"padL selectRow\" onclick =\"filterSelect($SID)\">|  Add Filter  |</span><span class=\"padL selectRow\" onclick =\"deleteSelect($SID)\">|  Delete Study  |</span></div>";
			}
        }
    }           

}

echo "<div id=\"surveyBox\" class = \"fLef\">
    <h3>Your Studies</h3>

    <div class=\"scroll\"><div >$ResearchSurvey</div></div><br />    
</div>";

?>



<script type="text/javascript">
function testSelect($SID){
    var form = document.createElement("form");
    input = document.createElement("input");

form.action = "editSurvey.php";
form.method = "post"

input.name = "id";
input.value = $SID;
form.appendChild(input);

document.body.appendChild(form);
form.submit();
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

function deleteSelect($SID){
    var form = document.createElement("form");
    input = document.createElement("input");

form.action = "deleteSurvey.php";
form.method = "post"

input.name = "id";
input.value = $SID;
form.appendChild(input);

document.body.appendChild(form);
form.submit();
}

function redirect(url){
 var win = window.open(url, '_blank');
  win.focus();
}
</script>