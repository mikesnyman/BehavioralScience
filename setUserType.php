<?php include 'header.php';
 include 'ConnectToDb.php'; 
include('GetUserLevel.php');
if($userLevel == 'Admin'){    
if(isset($_POST[$value]))
	{
		$sql = "SELECT uvuID from User where uvuID = $uvid";//check if user exists or is new

		$result = $conn->query($sql);
			$sql = 'SELECT uvuID from User where uvuID = $uvid';//check if user exists or is new
			$result = $conn->query($sql);
			if ($result->num_rows > 0){
				// output data of each row
				while($row = $result->fetch_assoc())
				 {
					$userLevel = $row["UserType"];
				echo "<script>
	alert('cool');
	setType.className=\"show\";
	getUsrId.className=\"hide\";
	</script>";
					
				}
				}
	}

echo "
<style type=\"text/css\">
.hide{
	display: none;
}
.show{
	display: block;
}
.pad{
	margin-left: 15px;
}
</style>
<script type=\"text/javascript\">
function Submit(){
EdUsrTypId = document.getElementById('EdUsrTypId');
if (/^[0-9]{9}$/.test(EdUsrTypId.value)){
	location.reload();
}
}
</script>

<div id='setType' class=\"hide\">
	 <h2>Select a user type</h2>
	<div class=\"pad\">
		<input type='radio' id ='Admin' name='Utype'>Admin<br />
		<input type='radio' id ='Teacher' name='Utype'>Teacher<br />
		<input type='radio' id ='Researcher' name='Utype'>Researcher<br />
		<input type='radio' id ='Subject' name='Utype'>Subject
	</div>
</div>
<div id='getUsrId'>	
	<h2>Enter the id for the user you would like to set privliges</h2>	
	<input class = 'pad' id='EdUsrTypId' />	
	<button id='submit' onclick =Submit()>Submit</button>	
</div>";
}
 include 'footer.php';
?>