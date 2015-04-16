<?php
session_start();
include ('header.php');


include('ConnectToDb.php');
//get user menu options based on user level
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
    echo"<script>window.location.href = \"index.php\";</script>";
    exit();
}

echo "<h2>Edit Question Page</h2>";

if(isset($_POST['id']))
{

$questID = htmlspecialchars($_POST["id"]);
$_SESSION['questionID'] = $questID;

}
//delete answer from database
if(isset($_POST['answerIDDelete']))
{
	//echo"<script>alert('deleted part duex')</script>";
	$questID = $_SESSION['questionID'];
	$ansIDDelete = $_POST['answerIDDelete'];
	include('ConnectToDb.php');
	$sqlAnsDel = "DELETE FROM Answer where idQuestion = $questID and idAnswer = $ansIDDelete";
	$conn->query($sqlAnsDel);
}

//edit answer actions database.
if(isset($_POST['submitAns']))
{
	$newAnsName = $_POST['answerName'];
	$answerIDWork = $_SESSION['answerIDsession'];
	//echo $answerIDWork;
	//$_SESSION['newQuest'] = $newName;
	$questID = $_SESSION['questionID'];
	include('ConnectToDb.php');
	$sqlAnsReplace = "UPDATE Answer SET description = '$newAnsName' where idQuestion = $questID and idAnswer = $answerIDWork";
	$conn->query($sqlAnsReplace);
}

//get question
$questID = $_SESSION['questionID'];
//replace questions name
if(isset($_POST['submit']))
{
	$newName = $_POST['questionName'];
	//$_SESSION['newQuest'] = $newName;
	
	include('ConnectToDb.php');
	$sqlQuestReplace = "UPDATE Question SET description = '$newName' where idQuestion = $questID";
	$conn->query($sqlQuestReplace);
}
//add question
if(isset($_POST['submitNewAns']))
{
	$newAnswer = $_POST['answerNew'];
	$questID = $_SESSION['questionID'];
	$newAID = $_SESSION['lastNum'];
	//check if answer id is greater than 6, if it is then don't run it.
	if($newAID <= 6)
	{
		echo "adding ".$newAnswer." to question with answer id of ".$newAID;
		include('ConnectToDb.php');
		$sqlAddNewAns = "INSERT INTO Answer (idAnswer,idQuestion,description) VALUES($newAID,$questID,'$newAnswer')";
		$conn->query($sqlAddNewAns);
	}
	else
	{
		echo "<strong>Cannot add answer to question, since there is already 6 for this question.</strong>";
	}
	
}


$sqlQuest = "SELECT * FROM Question WHERE idQuestion = $questID";
$sqlAns = "SELECT * FROM Answer WHERE idQuestion = $questID";

include('ConnectToDb.php');
$resultQuest = $conn->query($sqlQuest);
if ($resultQuest->num_rows > 0){
	while($row = $resultQuest->fetch_assoc())
	{
		$QuestionName = $row['description'];
	}

}

//rename question?
echo "<h3>$QuestionName</h3>";
echo "<p>Rename Question:</p>";
echo "<form action ='questionEdit.php' method = 'post'>

    <input type = 'text' name = 'questionName'><br>
 	<input type='submit' class = \"cBtn\" name = 'submit' value='Submit'>

    </form>
    <br/>"; 
//show answers
$resultAns = $conn->query($sqlAns);
   $QuestionAnswers='';
   $counter = 1;
   //set at 6 for now
   $_SESSION['lastNum'] = 7;
    if ($resultAns->num_rows > 0){
        // output data of each row
        while($row = $resultAns->fetch_assoc())
         {
         	$AnswerName = $row['description'];          
            $QID = $row['idQuestion']; 
            $AID = $row['idAnswer'];
         	$QuestionAnswers.= "<div class =\"innerRow selectRow\">
            <span class=\"inline\"><strong>$AnswerName</strong></span>        
            <span class=\"inline\" onclick =\"editSelect($AID)\">Edit</span>            
            <span class=\"inline\" onclick =\"deleteSelect($AID)\">Delete Answer</span></div>";
            if($counter != $AID && $counter <= 6)
            {
            	$_SESSION['lastNum'] = $counter;
            }
            $counter++;
         }
    } 
//rename answer?

//add answer?

//delete answer?
//show div box for answer options
echo "<div id=\"surveyBox\" class = \"fLef\">
    <h3>Characterisitics Questions</h3>

    <div class=\"scroll\"><div >$QuestionAnswers</div></div><br />    
</div>";

//edit answer name
if(isset($_POST['answerID']))
{
	//echo "Yeaaaaah baby!<br/>";
	//echo "answer ID: ".$_POST['answerID']."<br/>";
	$ansID = $_POST["answerID"];
	$_SESSION['answerIDsession'] = $ansID;
	//echo "question ID: ".$_POST['questionID']."<br/>";
	echo "<p>Rename Answer:</p>";
	echo "<form action ='questionEdit.php' method = 'post'>

    <input type = 'text' name = 'answerName'><br>
 	<input type='submit' class = \"cBtn\" name = 'submitAns' value='Submit'>

    </form>
    <br/>"; 
}

//answer creation
echo "<p>Add Answer:</p>";
echo "<form action ='questionEdit.php' method = 'post'>

    <input type = 'text' name = 'answerNew'><br>
 	<input type='submit' class = \"cBtn\" name = 'submitNewAns' value='Submit'>

    </form>
    <br/>";

?>

<input type="button" class = "cBtn" value="Back" onclick="location='characteristicsedit.php'" />

<script type="text/javascript">
function editSelect($AID){
    var form = document.createElement("form");
    var input = document.createElement("input");

form.action = "questionEdit.php";
form.method = "post"
input.name = "answerID";
input.value =  $AID;
//alert($AID);
form.appendChild(input);

document.body.appendChild(form);
form.submit();
}

function deleteSelect($AID)
{
var form = document.createElement("form");
var input = document.createElement("input");
//alert("deleted");
form.action = "questionEdit.php";
form.method = "post"
input.name = "answerIDDelete";
input.value =  $AID;
//alert($AID);
form.appendChild(input);


document.body.appendChild(form);
form.submit();
}
function redirect(url){
 var win = window.open(url, '_blank');
  win.focus();
}
</script>
<?php
include('footer.php');
?>