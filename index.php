<?php
include('header.php');
include('ConnectToDb.php');
include('GetUserLevel.php');

switch($userLevel)
{
	case 'New':
		echo "<h2>New User Page </h2><br><br>";
		echo "<input type=\"button\" value=\"charateristics\" onclick=\"location='characteristics.php'\" /><br>";
		break;
	case 'Particpant':
		echo "<h2>Participant Page</h2><br><br>";
		echo "<input type=\"button\" value=\"charateristics\" onclick=\"location='characteristics.php'\" /><br>";
		echo "<input type=\"button\" value=\"surveys\" onclick=\"location='index.php'\" /><br>";
		break;
	case 'Teacher':
		echo "<h2>Teacher Page</h2><br><br>";
		echo "<p>Teachers can view what participant's IDs that particpated in the survey</p>";
		break;
	case 'Researcher':
		echo "<h2>Researcher Page</h2><br><br>";
		echo "<input type=\"button\" value=\"Create and Edit Surveys\" onclick=\"location='surveyedit.php'\" /><br>";
		echo "<input type=\"button\" value=\"View Survey Results\" onclick=\"location='index.php'\" /><br>";
		break;
	case 'Admin':
		echo "<h2>Admin Page</h2><br><br>";
		echo "<input type=\"button\" value=\"View/Edit characteristics\" onclick=\"location='characteristicsedit.php'\" /><br>";
		echo "<input type=\"button\" value=\"View/Edit surveys\" onclick=\"location='surveyedit.php'\" /><br>";
		echo "<input type=\"button\" value=\"View/Edit Users\" onclick=\"location='index.php'\" /><br>";		
		echo "<input type=\"button\" value=\"SetUserType\" onclick=\"location='setUserType.php'\" /><br>";	
		break; 
	default:
		echo "No user type found";
		
}
$conn->close();
                        ?>

<?php
include('footer.php');
?>

