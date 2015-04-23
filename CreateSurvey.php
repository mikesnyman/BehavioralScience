<?php include 'header.php';
 include 'ConnectToDb.php'; 
include('GetUserLevel.php');
?>
<button class="cBtn"  onclick="location.href = 'index.php';">Home</button><br />
<?php 
//only display page if admin status
if($userLevel == 'Admin' || $userLevel == 'Teacher' || $userLevel == 'Researcher'){   

		echo "<br/>
		<input  class = 'padL' /><br />
		<p class = 'padL'>Survey Name</p><br />
		<button class=\"cBtn\">Create Questions</button>  
		<button class=\"cBtn\">Set Characteristic Filters</button><br />
		<button class=\"cBtn\">Save</button> 
		<button class=\"cBtn\">Cancel</button> <br />
		<p>List of active filter surveys for this researchers account</p>
		";
}
 include 'footer.php';
?>
