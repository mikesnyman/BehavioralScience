

<?php
	if($userLevel =="Admin"){
		echo"<div class=\"fRight\"style = \"margin-right:15%;\">
		<input type=\"button\" class=\"cBtn\" value=\"View/Edit characteristics\" onclick=\"location='characteristicsedit.php'\" />
		<input type=\"button\" class=\"cBtn\" value=\"View/Set User Permissions\" onclick=\"location='setUserType.php'\" /><br /></div>";
		include('Teacher_Researcher.php');
	}
?>