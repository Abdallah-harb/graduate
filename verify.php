<?php  //signin page
ob_start();
session_start();

$pageName = "Verify";
if(isset($_SESSION['useremail'])){

	include("init.php");
	//message before verify email .

		
	if(isset($_GET['newemail'])){

		$email = $_GET['newemail'];
		
		//message before verify account.!
		echo "	Thanks for signing up ! "; 
		echo " Your account has been created, Please  pressing the url below to activate your account."	;	 
		echo"<div class='text-center'>----------------------------</div>";		
		echo" Username: '".$name."'";			
		echo"Password: '".$password."'";			
		echo"<div class='text-center'>----------------------------</div> ";		

		
		//pring account that not verified from database
		$stmt = $db->prepare("SELECT `user_email`,`verify`
								FROM `user`
								Where `user_email` = ?
								And `verify` = 1
								limit 1 ");
		$stmt->execute(array($email));
		$fetchdata = $stmt->fetch();
		$row       = $stmt->rowCount();
		if($row == 1){
			//validation email
			$update = $db->prepare("UPDATE `user` SET `verify`= 1 WHERE `user_email` = ?");
			$update -> execute(array($email));
			if($update){
				echo "<div class='alert alert-info'>Your Account Is Verified </div>";
				echo "<div class='alert alert-info'><a href='signin.php'>Click to ligin </a></div>";
			}else{
				echo "<div class='alert alert-info'>Your Account Not Verified Try again </div>";
			}

		}else{
			echo "<div class='container'>";

				echo "<div class='alert alert-info'>This email already verified or invalid</div> ";
			echo "</div>";
		}


	}else{
			echo "<div class='container'>";

				echo "<div class='alert alert-danger'>Sorry There are Wrong on email verify please try again</div> ";
			echo "</div>";	
	}			

}
	
