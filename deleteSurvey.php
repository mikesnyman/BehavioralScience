<?php
session_start();

if(isset($_POST['id']))
{

$var_value = htmlspecialchars($_POST["id"]);
//$_SESSION['varname2'] = $var_value;
include('ConnectToDb.php');
//delete answers first, next the questions, then finally the survey. Bottom on up deletion method.
$qid= -1;

$quesDEL = "DELETE FROM Question where idSurvey = $var_value";
$surveyDEL = "DELETE FROM Survey where idSurvey = $var_value";
//get question id's so I can delete answers associated with survey
$quesID = "SELECT idQuestion from Question where idSurvey = $var_value";
//delete question answers
$result = $conn->query($quesID);
   
    if ($result->num_rows > 0){
        // output data of each row
        while($row = $result->fetch_assoc())
         {
         	$qid = $row['idQuestion'];
         	$ansDEL = "DELETE FROM Answer where idQuestion = $qid";
            $conn->query($ansDEL);
         }
    } 
    //delete questions          
     $conn->query($quesDEL);
     //delete survey
     $conn->query($surveyDEL);

     
}
echo"<script>window.location.href = \"surveyeditfilter.php\";</script>";
?>