
<?php
include('header.php');
?>
<input type="button" class = "cBtn fRight" value="Home" onclick="location='index.php'" />
<h2>Characteristics Questions Edit Page</h2><hr />

<?php
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

//delete answer from database
if(isset($_POST['QuestionIDDelete']))
{
    //echo"<script>alert('deleted part duex')</script>";
    $questID = $_POST['QuestionIDDelete'];    
    include('ConnectToDb.php');
    echo "<script>alert(DELETING $questID)</script>";
    $sqlAnsDel = "DELETE FROM Answer where idQuestion = $questID";
   $conn->query($sqlAnsDel);
    $sqlQuestDel = "DELETE FROM Question where idQuestion = $questID ";
   $conn->query($sqlQuestDel);
}


if (isset($_POST['viewChara'])) {
    viewChara();
} 
elseif (isset($_POST['editChara']))
{

    editChara();
}
elseif (isset($_POST['createChara']))
{
    createChara();

}
elseif (isset($_POST['edit']))
{
    //echo"BLAHLADJKFDSK:FJDSK:FJ";
}
elseif (isset($_POST['submit']))
{


echo "<br />";

include('ConnectToDb.php');
//echo "before prepare";
$question = $_POST['question'];
$ans1 = $_POST['ans1'];
$ans2 = $_POST['ans2'];
$ans3 = $_POST['ans3'];
$ans4 = $_POST['ans4'];
$ans5 = $_POST['ans5'];
$ans6 = $_POST['ans6'];

$sql = "INSERT INTO Question (idSurvey, description) VALUES (1, \"$question\")";
$conn->query($sql);
$sql = "SELECT idQuestion from Question WHERE description = \"$question\"";

$result = $conn->query($sql);
if ($result->num_rows > 0)
{
    // output data of each row
    $row = $result->fetch_assoc();
     
        $qid = $row["idQuestion"];

    
} else {
    echo "0 results found.<br>";
    //add user to database with participant clearance

}
if ($ans1 != NULL)
{
$sql = "INSERT INTO Answer (idAnswer, idQuestion, description) VALUES (1,$qid, \"$ans1\")";
$conn->query($sql);

}

if ($ans2 != NULL)
{
$sql = "INSERT INTO Answer (idAnswer,idQuestion, description) VALUES (2,$qid, \"$ans2\")";

$conn->query($sql);

}

if ($ans3 != NULL)
{
$sql = "INSERT INTO Answer (idAnswer,idQuestion, description) VALUES (3,$qid, \"$ans3\")";

$conn->query($sql);

}

if ($ans4 != NULL)
{
$sql = "INSERT INTO Answer (idAnswer,idQuestion, description) VALUES (4,$qid, \"$ans4\")";

$conn->query($sql);

}

if ($ans5 != NULL)
{
$sql = "INSERT INTO Answer (idAnswer,idQuestion, description) VALUES (5,$qid, \"$ans5\")";

$conn->query($sql);

}

if ($ans6 != NULL)
{
$sql = "INSERT INTO Answer (idAnswer,idQuestion, description) VALUES (6,$qid, \"$ans6\")";

$conn->query($sql);

}
$conn->close();
}



function editChara()
{
include('ConnectToDb.php');
$sql = "SELECT *,a.idQuestion as aid, b.idQuestion as bid, a.description as adescription, b.description as bdescription from Question a 
INNER JOIN Answer b on  a.idQuestion = b.idQuestion where idSurvey = 1  order by a.idQuestion ASC ,b.idAnswer";

$questionsql = "SELECT * from Question where idSurvey = 1";
$resultMe = $conn->query($questionsql);

$QuestionAnswers='';
    if ($resultMe->num_rows > 0){
        // output data of each row
        while($row = $resultMe->fetch_assoc())
         {
            $QuestionName = $row['description'];          
            $QID = $row['idQuestion'];         
             
            $QuestionAnswers.= "<div class =\"innerRow\">
            <span class=\"inline fifty\"><strong>$QuestionName</strong></span>        
            <span class=\"inline selectRow\" onclick =\"editSelect($QID)\">| Edit |</span>            
            <span class=\"inline selectRow\" onclick =\"deleteSelect($QID)\">| Delete Question |</span></div>";
        }
    }    

echo "<div id=\"surveyBox\" class = \"fLef\">
    <h3>Characterisitics Questions</h3>

    <div class=\"scroll\"><div >$QuestionAnswers</div></div><br />    
</div>";
}


function createChara()
{


echo "<form action= '' method='post'>
Question: &emsp; <input type='text' name='question' />
<br /><br />
Answer One: &emsp; <input type='text' name='ans1' />
<br /><br />
Answer Two: &emsp; <input type='text' name='ans2' />
<br /><br />
Answer Three: &emsp; <input type='text' name='ans3' />
<br /><br />
Answer Four: &emsp; <input type='text' name='ans4' />
<br /><br />
Answer Five: &emsp; <input type='text' name='ans5' />
<br /><br />
Answer Six: &emsp; <input type='text' name='ans6' />
<br /><br />
<input type='submit' class = \"cBtn\" name='submit' />
</form>";
}
?>

<form action="characteristicsedit.php" method = "post">
<input type="submit" class = "cBtn" name="editChara" value="Edit Characteristics Questions" />
<input type="submit" class = "cBtn" name="createChara" value="Create Characteristics Questions" />
</form>


<script type="text/javascript">
function editSelect($QID){
    var form = document.createElement("form");
    input = document.createElement("input");

form.action = "questionEdit.php";
form.method = "post";

input.name = "id";
input.value = $QID;
form.appendChild(input);

document.body.appendChild(form);
form.submit();
}

function deleteSelect($QID)
{
var form = document.createElement("form");
var input = document.createElement("input");
//alert("deleted");
form.action = "characteristicsedit.php";
form.method = "post";
input.name = "QuestionIDDelete";

input.value =  $QID;

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