
<?php
include('header.php');
include('ConnectToDb.php');
include('GetUserLevel.php');

switch($userLevel)
{
	case 'New':
		echo "<h2>New User Page </h2><hr />";
		include('NewUser.php');	
		break;
	case 'Participant':
		echo "<h2>Participant &nbsp;&nbsp;&nbsp;&nbsp; $uvid</h2><hr />";
		include('participant.php');	
		break;
	case 'Teacher':
		echo "<h2>Teacher &nbsp;&nbsp;&nbsp;&nbsp; $uvid</h2><hr />";
		include('Teacher_Researcher.php');
		break;
	case 'Researcher':
		echo "<h2>Researcher &nbsp;&nbsp;&nbsp;&nbsp; $uvid</h2><hr />";
		include('Teacher_Researcher.php');
		break;
	case 'Admin':
		echo "<h2>Admin &nbsp;&nbsp;&nbsp;&nbsp; $uvid</h2><hr />";
		include('Admin.php');
		break; 
	default:
		echo "No user type found";
}

$conn->close();
include('footer.php');
?>

