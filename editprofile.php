<?php
ob_start();
session_start();
$pageName="Edit Profile";
if(isset($_SESSION['useremail'])){
	include("init.php");

	$do = isset($_GET['do'])?$_GET['do']:'Edit';
	if($do == "Edit"){
		//edit user info
		$user = isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;
		$userinfo = $db->prepare('SELECT * FROM `user` WHERE `User_id` = ? ');
		$userinfo->execute(array($user));
		$row = $userinfo->fetch();
		$count = $userinfo->rowCount();
		if($count > 0){?>
			<div class="container">
				<form class="form-horizontal " action="?do=Update" method="POST">
					<h2 class="text-center">Edit Your Main Informations</h2>
					<!--To use it when i update date -->
					<input type="hidden" name ="userid" value="<?php echo $user; ?>" >
					<!--start user name-->
					 <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">User Name</label>
						    <div class="col-sm-10 col-md-7">
						      <input type="text" class="form-control" id="inputText3" required="required"
						      placeholder="Your Name" name="username" autocomplete="off" 
						      value="<?php echo $row['User_Name']?>" >
						    </div>
					  </div>
					  	<!--start password-->
					   <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
						    <div class="col-sm-10 col-md-7">

						    	<input type="hidden" name="oldpassword"
						    	 value='<?php echo $row["user_password"]?>'>
						      	<input type="password" class="form-control" id="inputPassword3" 
						      		placeholder="Leave Blank if you Don't To Change.!" 
						      		name="newpassword"	autocomplete="new-password">
						    </div>
					  </div>
					  <!--start email-->
					  <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label right">Email</label>
						    <div class="col-sm-10 col-md-7">
						      <input type="email" class="form-control"  name='email'id="inputEmail3"value='<?php echo $row["user_email"];//email : email from database?>' placeholder="Email">
						    </div>
					  </div>
					  <!--start fullName-->
					  <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">Full Name</label>
						    <div class="col-sm-10 col-md-7">
						      <input type="text" class="form-control" id="inputTxtl3" placeholder="full-name" name="fullname" required="required"
						      value='<?php echo $row["Full_name"];//full user name : 
						   											   //name from database?>'>
						    </div>
					  </div>
					   <!--start fullName-->
					  <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">Address
						    </label>
						    <div class="col-sm-10 col-md-7">
						      <input type="text" class="form-control" id="inputTxtl3" placeholder="full-name" name="address" required="required"
						      value='<?php echo $row["user_Address"];//full user name : 
						   											   //name from database?>'>
						    </div>
					  </div>
					  
						<!--start submit-->
					  <div class="form-group">
						    <div class="col-sm-offset-2 col-sm-10">
						      <button type="submit" class="btn btn-primary Save"> Save</button>
						    </div>
					  </div>
			    </form>
			</div>
		<?php	
		}else{
			echo "<div class ='container'>";
				$thismessage =  "<div class='alert alert-danger'>theres no id for that statment </div>";
				redirectHome($thismessage,"back",7);
			echo "</div>";
		}
	}else if($do == 'Update'){
		//update user info
		if($_SERVER['REQUEST_METHOD'] == 'POST'){

			echo "<h1 class='text-center'>Update Info</h1>";

			$iduser    = $_POST['userid'];
			$userName  = $_POST['username'];
			$pass      = empty($_POST['newpassword'])?$_POST['oldpassword']:sha1($_POST['				newpassword']);
			$Email     = $_POST['email'];
			$fullName  = $_POST['fullname'];
			$Address   = $_POST['address'];

			$formerrors = array();
			if(strlen($userName ) < 3){
				$formerrors[] = "<div class='alert alert-danger'> your <strong>name</strong> must be larger than 3 char</div>";
				}
			if(empty($Email)){
				$formerrors[] = "<div class='alert alert-danger'> <strong> Email </stong> must not be empty";
			}
			if(strlen($fullName) < 3 ){
				$formerrors[] = "<div class='alert alert-danger'><strong>FullName </strong> musst be larger than 3 characters";
			}
			if(empty($Address)){
				$formerrors[] = "<div class='alert alert-danger'> <strong> Address </stong> must not be empty";
			}
			foreach($formerrors as $formerror){
				 echo "<div class ='container'>";
					redirectHome($formerror,'back',5);
				 echo "</div>";
			}
			if(empty($formerrors)){
				//check the data that user update that not for other users
				$stmt = $db->prepare('SELECT * FROM `user`
											   WHERE `user_email` = ?
										  	   AND `User_id` != ?');
				$stmt->execute(array($Email,$iduser));
				$count = $stmt->rowCount();
				if($count == 1){
					echo '<div class="alert alert-danger"> Sorry This <strong> Email </strong> is exist Please Write another Email ';
				}else{
					//if the data for email is right then update it
					$stmt = $db->prepare('UPDATE `user` SET   `User_Name` = ?, 
															   `user_password` = ?,
															   `user_email` = ?,
															   `Full_name` = ?,
															   `user_Address` = ?
														WHERE 
																`User_id` = ?');
					$stmt->execute(
						array($userName,$pass,$Email,$fullName,$Address,$iduser));
						//success message
					echo "<div class ='container'>";
						$themsg = "<div class='alert alert-success'> <strong>Well Done ".$stmt->rowCount(). "Recod Update</div>";
						redirectHome($themsg,"back",3);
					echo "<div>";
				}

			}else{

				echo "<div class ='container'>";
				$themsge = '<div class="alert alert-danger"> Error ecoured on the form update </div>';
				redirectHome($themsge,"back",3);
				echo "<div>";
			}	

		} 

	}
}else{
	header("location:index.php");
	exit();
}

include($tpl."footer.php");
ob_end_flush();	