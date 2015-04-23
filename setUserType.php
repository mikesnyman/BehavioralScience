<?php include 'header.php';
 include 'ConnectToDb.php'; 
include('GetUserLevel.php');
 echo "<br /><button class = 'cBtn fRight' onclick=\"location.href = 'index.php';\">Home</button>";
echo "<h2>Set User Type</h2><hr/>";
//only display page if admin status
if($userLevel == 'Admin'){   

//display after selecting student id and user type.  this runs the sql
	if(isset($_POST['btnUsrType'])){		
		$Typs = $_POST['usrTyp'];
		$Ids = $_POST['usrIds'];
		if ($Typs){
			$sql = "UPDATE User SET UserType= '$Typs'  WHERE uvuID=$Ids";
			if ($conn->query($sql) === TRUE) {
				echo "Record updated successfully";
			} 
			else {
				echo "Error updating record: " . $conn->error;
			}
		}
	else{
		echo "<h3>You must select a type</h3>";
		}
	echo '';
	}

//this allows user to select type of privliges submit is enabled upon selection	
	else if(isset($_POST['submit'])){		
			$Ed = $_POST['EdUsrTypeId'];		
			if (is_numeric($Ed) && $Ed != $uvid) //user can not change own privlages
			{
				$sql = "SELECT * from User where uvuID = $Ed";//check if user exists or is new
				$result = $conn->query($sql);
				if ($result->num_rows > 0){
					// output data of each row
					while($row = $result->fetch_assoc())
					 {
						$userLevel = $row['UserType'];
						// buttons and style
						echo "
							<div id=\"setType\">
								<h2>Select a user type</h2>
								<div class=\"padL\">
									<form action='setUserType.php' method = 'post'>
									<div>
									<input type='radio' id ='Admin' name='Utype' onclick = \"setType('Admin')\">Admin<br />
									<input type='radio' id ='Teacher' name='Utype' onclick = \"setType('Teacher')\">Teacher<br />
									<input type='radio' id ='Researcher' name='Utype' onclick = \"setType('Researcher')\">Researcher<br />
									<input type='radio' id ='Subject' name='Utype' onclick = \"setType('Participant')\">Particpant	
									<br />
									</div>
									<button class=\"cBtn\" id='btnUsrType' name = 'btnUsrType' disabled>Submit</button>
									<input id = usrTyp name = usrTyp class='hide'>
									<input id = usrIds name = usrIds class='hide'>
									</form>
								</div>
							</div>
							<script type=\"text/javascript\">
							function setType(type){
								document.getElementById(\"btnUsrType\");
								document.getElementById(\"usrTyp\");
								document.getElementById(\"usrIds\");
								usrTyp.value = type;
								usrIds.value = $Ed;
								btnUsrType.disabled=false;
							}
							</script>";						
					}
				}
				//if student id does not exist
			else {
					echo "<h3>invalid Student ID</h3>";
				}
			}
			//if alpha is enterd or own id is entered
		else {
				echo "<h3>You must enter a student Id that is not your own</h3>";
			}
		}
		
//The first screen an admin sees when on page.  
	else{
			//gets a list of all users
			$sql= "select uvuID, UserType from User";
			$result = $conn->query($sql);
			if ($result->num_rows > 0){
				// output data of each row
					$All='';
				while($row = $result->fetch_assoc())
				 {
					$UserTypes =$row['UserType'];
					$UserIDs = $row['uvuID'];
					$All.= "<div class =\"innerRow\"><span>$UserTypes</span> . . . . .<span>$UserIDs</span></div>";

				}
			}
			echo "
		<script type='text/javascript'>
			function viewUsrs(){
			 L = document.getElementById(\"usrList\");
			 if(L.className == \"hide\"){
				L.className = \"\"
			 }
			 else
				L.className = \"hide\";
			}
			</script>
			<div id=\"getUsrId\">	
				<form action='setUserType.php' method = 'post'>
				<h4>Enter the id for the user you would like to set privliges</h4>	
				<input class = 'padL' name='EdUsrTypeId' id=\"UserType\"/>	
				<button id='submit' class='cBtn' name = 'submit'>Submit</button>
				</form>
			</div>
			<br /><button class='cBtn' onclick=\"viewUsrs()\">View Users</button><br />
			<div class='hide' id='usrList'>
			<div class = 'usrRowstyle'><p class=\"padL\">List of current users<p></div>
			<div class=\"scroll-large\"><div >$All</div></div><br />
			</div>";
		}
}
 include 'footer.php';
?>
