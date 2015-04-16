<?php
//change name most likley, survey edit landing page, remove create survey add to its own button on main
include('header.php');
include('ConnectToDb.php');
include('GetUserLevel.php');
if($userLevel =="Teacher" || $userLevel =="Researcher" || $userLevel =="Admin"){
echo "<h2>Survey Edit Page</h2><br>";
$sql = "SELECT description,idSurvey from Survey where idResearcher = $uvid";
$resultMe = $conn->query($sql);
    $ResearchSurvey='';
    if ($resultMe->num_rows > 0){
        // output data of each row
        while($row = $resultMe->fetch_assoc())
         {
            $Survey = $row['description'];
            $SID = $row['idSurvey'];
            $ResearchSurvey.= "<div class =\"innerRow selectRow\"><p>Survey Name</p><span class=\"inline\">$Survey</span><span class=\"inline\" onclick =\"testSelect($SID)\">Edit Survey</span><span class=\"inline\" onclick =\"filterSelect($SID)\">Add Filter</span><span class=\"inline\" onclick =\"deleteSelect($SID)\">Delete Survey</span></div>";
        }
    }           

}

echo "<div id=\"surveyBox\" class = \"fLef\">
    <h3>Your Surveys</h3>

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