
<?php
include('header.php');
?> 
                     
<?php

echo "<h2>User Characteristics Profile</h2><br>";
//pull from database using userID and user level given from call(global variable?)
//if not new
include('ConnectToDb.php');

echo "<strong>Connected successfully</strong><br>";
$array = array();
$sql = "SELECT *,a.idQuestion as aid, b.idQuestion as bid, a.description as adescription, b.description as bdescription from Question a INNER JOIN Answer b on  a.idQuestion = b.idQuestion where idSurvey = 1  order by a.idQuestion, b.idAnswer";
$result = $conn->query($sql);
$check = false;
$test;
$array = array();
$valueTextMap = array();
$array2 = array();
$array3 = array();


if ($result->num_rows > 0) {
		echo "<form method=\"post\" name=\"characteristics\" action=\"characteristics.php\">";
		$teh = "";
    // output data of each row   		
    while($row = $result->fetch_assoc())
     {	 

     	if($row["adescription"] != $teh && $check == true)
     	{
        echo " </select> ";
      	echo "<br/>";


     	}

     	if( $row["adescription"] != $teh)
     	{	
     		$test = $row["adescription"];
     		$array3[] = $test;
     		$test = str_replace(' ', '^*^',$test);
     		$array[] = $test;
     		 echo "Question: ". $row["adescription"]."<br>";
     		 echo "<select name=\"$test\">";
        	 echo "<option value=\"0\" selected=\"selected\">Pick Your Answer</option> ";
     	}  
     	$teh = $row["adescription"];
     	if( $row["adescription"] == $teh)
     	{
     		$check = true;
     	}
     	$ans = $row["bdescription"];
     	$num = $row["idAnswer"];  
     	//echo $row["bdescription"];

     	echo "<option value=\"a".$num."\">$ans</option>"; 
     	$array2[$test.'a'.$num] = ($valueTextMap["a".$num] = $ans); 
      
    }
		
    
} else {
    echo "0 results found";
}


$conn->close();
echo "<br/>";
echo "<br/>";  
  echo " &nbsp<input type = \"submit\" value = \"Submit\">";

  echo "</form>";
  echo "<hr>"; 
echo "<br/>";
echo "<br/>";  
$allAns = false;
$answerArray = array();
foreach ($array as &$value) {

    if(isset($_POST[$value]) && $_POST[$value] == 'a1')
	{ 	
	$x = $_POST[$value];
	$texta1 = $array2[$value.$x];
	//echo $texta1;
	$answerArray[$value] = $texta1;
	$allAns	= true;
	// echo "<br/>";
	} 
	if(isset($_POST[$value]) && $_POST[$value] == 'a2')
	{ 
	$x = $_POST[$value];
	$texta2 = $array2[$value.$x];
	//echo $texta2;
	$answerArray[$value] = $texta2;
	$allAns	= true;
	// echo "<br/>";
	} 
	if(isset($_POST[$value]) && $_POST[$value] == 'a3')
	{ 
	$x = $_POST[$value];
	$texta3 = $array2[$value.$x];
	$answerArray[$value] = $texta3;
	//echo $texta3;
	$allAns	= true;	
	// echo "<br/>";
	} 
	if(isset($_POST[$value]) && $_POST[$value] == 'a4')
	{ 
	$x = $_POST[$value];
	$texta4 = $array2[$value.$x];
	$answerArray[$value] = $texta4;
	//echo $texta4;
	$allAns	= true;	
	// echo "<br/>";
	} 
	if(isset($_POST[$value]) && $_POST[$value] == 'a5')
	{ 
	$x = $_POST[$value];
	$texta5 = $array2[$value.$x];
	$answerArray[$value] = $texta5;
	//echo $texta5;
	$allAns	= true;	
	// echo "<br/>";
	} 
	if(isset($_POST[$value]) && $_POST[$value] == 'a6')
	{ 
	$x = $_POST[$value];
	$texta6 = $array2[$value.$x];
	$answerArray[$value] = $texta6;
	//echo $texta6;
	$allAns	= true;	
	// echo "<br/>";
	} 
	if(isset($_POST[$value]) && $_POST[$value] == '0')
	{
		echo "You didn't answer all the questions.";
		$allAns = false;
	}
}
if($allAns == true)
{

	include('ConnectToDb.php');
	include('GetUserLevel.php');
	//if user is 0
	if( $userLevel == "New" || "Admin")
	{
		
	//submit answers to database
	
	
	foreach ($answerArray as $key => $val)
	{
		//echo $key . " ". $val. " " . $uvid;
		$key = str_replace('^*^', ' ',$key);
		$sql = "SELECT *,a.idQuestion as aid, b.idQuestion as bid, a.description as adescription, b.description as bdescription from Question a INNER JOIN Answer b on  a.idQuestion = b.idQuestion where idSurvey = 1  order by a.idQuestion, b.idAnswer";
		//echo $key." ".$val;

		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc())
     		{	
     			if( $row["adescription"] == $key)
     			{
     				
     				if($row["bdescription"] == $val)
     				{	//echo "Question: ". $row["adescription"]." ".$row["aid"]."<br>";
     					//echo "Answer: ". $row["bdescription"]." ".$row["bid"]."<br>";
     					$bid = $row["idAnswer"];
     					$aid = $row["aid"];
     					
     					$sql = "SELECT * from UserAnswer where idAnswer = $bid and idQuestion = $aid and idSurvey = 1 and idUser = $uvid";
     					$result2 = $conn->query($sql);
     					if ($result2->num_rows == 0)
     					{
     						$sql = "SELECT * from UserAnswer";
     						$result3 = $conn->query($sql);
     						if ($result3->num_rows > 0) {
     							while($row2 = $result3->fetch_assoc())
     							{
	     							if($row2["idQuestion"] == $aid)
	     							{
	     								echo "Question already answered, replacing previous answer";
	     								//maybe not use delete, maybe use update instead
	     								$sql = "DELETE FROM UserAnswer where (idQuestion = $aid and idUser = $uvid and idSurvey = 1)";
	     								$conn->query($sql);
	     								echo "Adding to database user answer AFTER DELETE<br/>";
	     								$sql = "INSERT INTO UserAnswer (idAnswer,idQuestion, idSurvey, idUser) VALUES ($bid,$aid,1,$uvid)";
	     								$conn->query($sql);
	     							}
	     							else
	     							{
	     								//echo "Adding to database user answer, it is clear to add<br/>";
     									$sql = "INSERT INTO UserAnswer (idAnswer,idQuestion, idSurvey, idUser) VALUES ($bid,$aid,1,$uvid)";
     									$conn->query($sql);
	     							}
     							}
     						}
     						else
     						{
     							echo "Adding to database user answer, table is empty<br/>";
     							$sql = "INSERT INTO UserAnswer (idAnswer,idQuestion, idSurvey, idUser) VALUES ($bid,$aid,1,$uvid)";
     							$conn->query($sql);
     						}
     						
     					}
     					else
     					{
     						echo "Cannot add to database, user answer exists<br/>";
     					}
     					
     					
     				}
     			}
     			
     			
    		}
		}
		

		//
	}
	
	//change user from 0 to 1
	if($userLevel == 'New')
	{
	$sql = "UPDATE User set UserType = \"Partcipiant\" where idUser = $uvid"; 
		$conn->query($sql);
	}
	}


	//if user is 1, update characteristics unless its a one time thing
	if( $userLevel == "Partcipiant")
	{
		//echo "WHOOP WHOOP";
	}
}
 

?>


<input type="button" value="Back" onclick="location='index.php'" />


<?php
include('footer.php');
?>
