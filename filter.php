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
	if($userLevel != 'Researcher')
	{
		echo"<script>window.location.href = \"index.php\";</script>";
		exit();
	}
	
}
?>
<h2>Survey Filter</h2>
<p>Select the answers for the filter.</p>
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
}

//if filter exists already for this survey, do we update the filter and display a warning to the researcher?

//for now work on survey id # 1, the characteristics profile

//connect to db
include('ConnectToDb.php');

//populate a list of questions and answers, EACH with a check box
//next update precheck list if its already been checked 
$sql = "SELECT *,a.idQuestion as aid, b.idQuestion as bid, a.description as adescription, b.description as bdescription from Question a 
INNER JOIN Answer b on  a.idQuestion = b.idQuestion where idSurvey = 1  order by a.idQuestion ASC ,b.idAnswer";
$result = $conn->query($sql);
$teh = "";
$test = "";


if ($result->num_rows > 0) {
    // output data of each row  
      echo "<form method=\"post\" name=\"filter\" action=\"filter.php\">";		
    while($row = $result->fetch_assoc())
     {	 

     	if( $row["adescription"] != $teh)
     	{
     		$test = $row["adescription"];
     		 echo "Question: ". $row["adescription"]."<br>";
     		 //$test = str_replace(' ', '^*^',$test);
     	}
     	$teh = $row["adescription"];       
      	//echo $row["bdescription"];
      	$ans = $row["bdescription"];
     	$num = $row["idAnswer"];
   
      	echo " 
	 {$row['bdescription']}   <input type=\"checkbox\" value=\"".$ans.$test."\" name=\"checkbox[]\" /><br />";  

     	echo "<br/>";


    }

    echo "<input type = \"submit\" value = \"Submit\">";
     echo "</form>";   
} else {
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
 	
 while($row2 = $result->fetch_assoc())
     {	
     	$compare = $row2["bdescription"].$row2["adescription"];
     	
     	//echo $checkbox . ' ';
     	//echo "the compare is".$compare;
     	$ansNum = $row2["idAnswer"];
     	$quesNum = $row2["aid"];
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
 echo"<script>window.location.href = \"surveyedit.php\";</script>";
}
 
//User checks boxes they want to be part of the filter, multiple answers from same question is permitable.

//using MAGIC and the dark crafts. Manage to create the filter (do I save the results into a new table I create? The filter has to be saved so yes.)
//the surveyid tied to the filter as the foreign key with the filter id 
?>

<?php
include('footer.php');
?>