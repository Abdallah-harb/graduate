<?php
ob_start();
session_start();
$pageName="Members";
if(isset($_SESSION['Admin_Email'])){
	include("init.php");
	$do =isset($_GET["do"])?$_GET['do']:"Manage";
	if($do == 'Manage'){
		//manage members

		//fetch data except admin
		$stmt  = $db->prepare("SELECT * FROM `user` WHERE `Reg_status` !=1 ORDER BY `User_id` DESC");
		$stmt->execute();
		$rows   = $stmt->fetchAll();
		$count = $stmt->rowCount();
		//if count > 0 start manage the members
		//else back to dashbord page

		if($count > 0 ){?>
			<!--srart table to manage members-->
			
			<div class="container admimedit">
				<h2 class="text-center">Manage Members</h2>
				<div class="table-responsive">
					<table class="table text-center table-bordered">
						<tr>
							<td># ID</td>
							<td>Name</td>
							<td>FullName</td>
							<td>Email</td>
							<td>Address</td>
							<td>Avatar</td>
							
							<td>Controls</td>
						</tr>
						<?php
							foreach($rows as $row){

								echo "<tr>";
									echo "<td>".$row['User_id']."</td>";
									echo "<td>".$row['User_Name']."</td>";
									echo "<td>".$row['Full_name']."</td>";
									echo "<td>".$row['user_email']."</td>";
									echo "<td>".$row['user_Address']."</td>";
									echo "<td>";
										if(!empty($row['user_avatar'])){
											echo "<img src='upload/".$row['user_avatar']."'width='50px' height='50px'>";
										}else{
											echo "<img src='upload/craftsman.jpg'alt='image' width='50px' height='50px'>";
										}
									echo"</td>";
									
									echo "<td>
											<a href='?do=Edit&userid=".$row['User_id']. "'class='btn btn-success sa'><i class='fa fa-edit'></i>Edit</a>
													 <a href='?do=Delete&userid=".$row['User_id']. "' class='btn btn-danger da'><i class='fas fa-trash-alt'></i>Delete</a>";
									echo "</td>";
								echo "</tr>";
							}
						?>	
					</table>
				</div>
				<a href='members.php?do=Add'class=" Add btn btn-primary" ><i class="fa fa-plus"> Add New Member</i> </a>		
			</div>	
		<?php
		}else{

			echo "<div class='container'>";
			$message = "<div class='alert alert-info'>There is No members To Show </div>";
			redirectHome($message);
			echo "</div>";
		}
	}elseif($do == "Add"){
		//Add members?>

		<div class="container">
			<form class="form-horizontal admimedit"action="?do=insert" method="POST"
					enctype="multipart/form-data">
				<h2 class="text-center">ADD New Member</h2>
				<!--start user name-->
				 <div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label">User Name</label>
					    <div class="col-sm-10 col-md-7">
					      <input type="text" class="form-control" id="inputText3" placeholder="username" name="username" autocomplete="off" required="required">
					    </div>
				  </div>
				  	<!--start password-->
				   <div class="form-group">
					    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
					    <div class="col-sm-10 col-md-7">
					      	<input type="password" class="password form-control" id="inputPassword3" 
					      		placeholder="Password Must be hard & complex" name="password" 
					      		required="required" autocomplete="off">
					      		<i class="show-pass fa fa-eye fa-1x" title="Show password"></i>
					  
					      		
					    </div>
				  </div>
				  <!--start email-->
				  <div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label right">Email</label>
					    <div class="col-sm-10 col-md-7">
					      	<input type="email" class="form-control"  name='email'id="inputEmail3" placeholder="Email" required="required">
					    </div>
				  </div>
				  <!--start fullName-->
				  <div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label">Full Name</label>
					    <div class="col-sm-10 col-md-7">
					      <input type="text" class="form-control" placeholder="full-name" name="fullname" required="required">
					    </div>
				  </div>
				   <!--start avatar-->
				  <div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label">Image</label>
					    <div class="col-sm-10 col-md-7">
					      <input type="file" class="form-control"  name="avatar">
					    </div>
				  </div>
				   <!--start Address-->
				  <div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label">Address</label>
					    <div class="col-sm-10 col-md-7">
					      <input type="text" class="form-control"  name="address" 
					      placeholder="32.ST.City">
					    </div>
				  </div>
				  
					<!--start submit-->
				  <div class="form-group">
					    <div class="col-sm-offset-2 col-sm-10">
					      <button type="submit" class="btn btn-primary"> Add Member </button>
					    </div>
				  </div>
		    </form>
		</div>


	<?php	
	}elseif($do == "insert"){
		//insert members

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			
			echo "<div class='container admimedit'>";
			echo "<h2 class='text-center'>ADD New Member</h2>";
			//avatar info
			$avatarName = $_FILES['avatar']['name'];
			$avatarSize = $_FILES['avatar']['size'];
			$avatartmp  = $_FILES['avatar']['tmp_name'];
			$avatartype = $_FILES['avatar']['type'];

			//avatar type extensions
			$avatarallowextensions = array("jpeg","jpg","png","gif");
			//to take the extensions from avatar name
			$avatarextensions = strtolower(end(explode(".", $avatarName))); 
			//form info
			$UserName    = $_POST['username'];
			$password    = $_POST['password'];
			$Email       = $_POST['email'];
			$fullname    = $_POST['fullname'];
			$Address     = $_POST['address'];
			
			$passhah     = sha1($password);

			$formerrors = array();
			if(strlen($UserName) < 3){
				$formerrors [] = "<div class='alert alert-danger'>The <strong> Name </strong>must be larger than 3 characters </div>";
			}
			if(empty($password)){
				$formerrors [] = "<div class='alert alert-danger'>The <strong>Password </strong>must be Written </div>";
			}
			if(strlen($fullname )< 5){
				$formerrors [] = "<div class='alert alert-danger'>The <strong>Full Name </strong>must be larger than 5 characters </div>";
			}
			if(!empty($avatarName) && !in_array($avatarextensions, $avatarallowextensions)){
				$formerrors[] = "<div class ='alert alert-danger'><strong>Image</strong> Must Be Uploaded</div>";
			}
			// size to upload 4MB = 4*1024*1024
			if($avatarSize > 4194304){
				$formerrors [] = "<div class='alert alert-danger'><strong> image size </strong> Must be 4MB Or Lower not larger</div>";
			}
			
			foreach($formerrors as $errors){
				 
				redirectHome($errors,"back",4);

			}
			if(empty($formerrors)){

				//to make every avatar name has a name diffren than others
				$avatar = rand(0,10000)."_".$avatarName;
				//to save every image on this destination 
				move_uploaded_file($avatartmp,"upload\\".$avatar);

				//to check if the data is exist on database or not
				$check = checkItem("user_email","user",$Email);
				if($check == 1){
					echo"<div class='alert alert-info '> Sorry This Data are already exist please change the Email</div>";
				}else{

					//insert the new data on database
					$stmt = $db->prepare("INSERT INTO `user`(`User_Name`,`user_email`,
															 `user_password`,`Full_name`,`date`,
															  `reg_status`,`user_Address`,
															   `user_avatar`)

														VALUES 
																(:zname,:zemail,:zpass,
																:fullname, now(),0,:zaddress,:zavatar)");
					$stmt->execute(array(
						"zname"          =>  $UserName,
						"zemail"         =>  $Email,
						"fullname"       =>  $fullname,
						"zaddress"       =>  $Address,
						"zpass"          =>  $passhah,
						"zavatar"        =>  $avatar));
					//sucess message 
					$sucmessage = "<div class='alert alert-success'> 1 member added</div>";
					redirectHome($sucmessage,"back",3);
				}
			}
			echo "</div>";
		}else{
			echo "<div class='container'>";
			$message ="<div class='alert alert-info'>There is Error ecured to insert members</div>"; 
			redirectHome($message);
			echo "</div>";
		}

	}elseif($do == "Edit"){
		//edit membres
		$userid = isset($_GET['userid']) &&is_numeric($_GET['userid'])?intval($_GET['userid']):0;
		//pring data from database
		$stmt  = $db->prepare("SELECT * FROM user WHERE User_id = ? ");
		$stmt -> execute(array($userid));
		$row   = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count > 0 ){
			?>
			<div class="container">
				<form class="form-horizontal admimedit"action="?do=Update" method="POST"
						enctype="multipart/form-data">
					<h2 class="text-center">Edit Member</h2>
					<!--To use it when i update date -->
					<input type="hidden" name ="userid" value="<?php echo $userid; ?>" >
					<!--start user name-->
					 <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">User Name</label>
						    <div class="col-sm-10 col-md-7">
						      <input type="text" class="form-control" id="inputText3" placeholder="username" name="username" autocomplete="off" required="required"
						      value="<?php echo $row['User_Name']?>">
						    </div>
					  </div>
					  	<!--start password-->
					   <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
						    <div class="col-sm-10 col-md-7">

						    	<input type="hidden" name="oldpassword"
						    	 value='<?php echo $row["user_password"]?>'>
						      	<input type="password" class="form-control" id="inputPassword3" 
						      		placeholder="Leave Blank if you Don't To Change.!" name="newpassword"	autocomplete="new-password">
						      		<i class="show-pass fa fa-eye fa-1x" title="Show password"></i>
						    </div>
					  </div>
					 
					  <!--start email-->
					  <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label right">Email</label>
						    <div class="col-sm-10 col-md-7">
						      	<input type="email" class="form-control"  name='email'id="inputEmail3" placeholder="Email" required="required" 
						      	value="<?php echo $row['user_email']?>">
						    </div>
					  </div>
					  <!--start fullName-->
					  <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">Full Name</label>
						    <div class="col-sm-10 col-md-7">
						      <input type="text" class="form-control" placeholder="full-name" name="fullname" required="required" 
						      value="<?php echo $row['Full_name']?>">
						    </div>
					  </div>
					   <!--start avatar-->
					 	<table >
					  		<label for="inputEmail3" class="col-sm-2 control-label">old Image</label>
					  		<td width="100px" >
					  		<?php

					  			echo '<img width = "50px" height="50px"src="upload/avatar/'.$row['user_avatar'].'">';
					  		?>
					  		</td>
				  		</table>
				  		<div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">New Image</label>
						    <div class="col-sm-10 col-md-7">
						      <input type="file" class="form-control" name="avatar">
						    </div>
				  		</div>
					   <!--start Address-->
					  <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">Address</label>
						    <div class="col-sm-10 col-md-7">
						      <input type="text" class="form-control"  name="address" 
						      placeholder="32.ST.City" value="<?php echo $row['user_Address']?>">
						    </div>
					  </div>
					  
						<!--start submit-->
					 <div class="form-group">
					    <div class="col-sm-offset-2 col-sm-10">
					      <button type="submit" class="btn btn-primary"> Save</button>
					    </div>
				  </div>
			    </form>
			</div>
	<?php
		}else{

			echo "<div class='container'>";
			$message = "<div class='alert alert-info'> error ecoured in edit page </div>";
			redirectHome($message,"back",3);
			echo "</div>";
		}
		
	}elseif($do == "Update"){
		//update members
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			//start update users
			echo "<div class='container admimedit'>";
				echo '<h2 class="text-center">Update Member</h2>';

				//form info
				$userid     = $_POST['userid'];
				$username   = $_POST['username'];
				$pass       = empty($_POST['newpassword'])?$_POST['oldpassword']:sha1($_POST['newpassword']);
				$Email      = $_POST['email'];
				$Fullname   = $_POST['fullname'];
				$address    = $_POST['address'];
				//avatar
				$avatarName = $_FILES['avatar']['name'];
				$avatarSize = $_FILES['avatar']['size'];
				$avatartmp  = $_FILES['avatar']['tmp_name'];
				$avatartype = $_FILES['avatar']['type'];
				//avatar extensions
				$avatarAllowextensions = array("jpeg","jpg","png","gif");
				$avatarExtensions = strtolower(end(explode(".", $avatarName)));
				//form errors
				$Formerors = array();
				if(strlen($username) < 3){
					$Formerors[] ='<div class="alert alert-danger"><strong>Name must </strong>have more than 4 characters</div>';
					}
				if(empty($username)){
					 $Formerors[] = '<div class="alert alert-danger"><strong>User Name </strong>must be wtitten</div>';
				}
				if(empty($Email)){
					 $Formerors[] = '<div class="alert alert-danger"><strong>Email </strong>must be wtitten</div>';
				}
				if(strlen($Fullname) < 3){
					$Formerors[] ='<div class="alert alert-danger"><strong>Full Name</strong> must have more than 3 characters</div>';
				}
				if(empty($Fullname)){

						 $Formerors[] = '<div class="alert alert-danger"><strong>Full Name</strong>  must be wtitten</div>';

				}
			
				if(!empty($avatarName) && !in_array($avatarExtensions,$avatarAllowextensions)){

					$Formerors[] = '<div class="alert alert-danger"><strong>Image</strong>  must be Uploaded</div>';
				}
				
				if($avatarSize > 4194304){//4MB=1024*4MB=4096*1024=4194304.!
					$Formerors[] = '<div class="alert alert-danger">image <strong>size </strong>can not be larger than 4MB </div>';
				}
				foreach($Formerors as $errors){
					redirectHome($errors,"back",4);
				}
				if(empty($Formerors)){

					$avatars = rand(0,10000);
					move_uploaded_file($avatartmp,"upload\\".$avatars);
					//check that the data that you update not on database
					$stmt = $db->prepare("SELECT * FROM `user`
													WHERE `user_email` = ?
													AND `User_id` != ?");
					$stmt->execute(array($Email,$userid));
					$count = $stmt->rowCount();
					if($count == 1){
						$message ="<div class='alert alert-info'>The data you update are already exists please choose anothers email<div>";
						redirectHome($message,"back",3);
					}else{
						//update data 
						$stmt = $db->prepare("UPDATE `user` SET   `User_Name` = ?, 
															  	   `user_password` = ?,
															       `user_email` = ?,
															       `Full_name` = ?,
															       `user_Address` = ?,
															       `user_avatar`= ?
														WHERE 
																`User_id` = ?");
						$stmt->execute(array($username,$pass,$Email,$Fullname,$address,$avatars,$userid));
						//success message
						$themsg = "<div class='alert alert-success'> <strong>Well Done ".$stmt->rowCount(). "Recod Update</div>";
						redirectHome($themsg,"back",3);

					}
				}else{

					$message ="<div class='alert alert-info'>There are error ecuerd on form update<div>";
					redirectHome($message,"back",3);
				}
			echo "</div>";
		}else{

			echo "<div class='container'>";
			$message ="<div class='alert alert-info'> There are error ecuerd on update members</div>";
			redirectHome($message,"back",3);
			echo "</div>";
		}
	}elseif($do == "Delete"){
		//delet members	

	 	
	 	echo '<div class = "container admimedit">';
	 	echo'<h2 class="text-center"> Delete Members</h2>';
	 		//comme if statmant to check the user id is intger.!
		$userid = isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;

			/*I need one result*/

		$stmt = $db->prepare('SELECT * FROM user WHERE  User_id = ? limit  1'); 

		$stmt -> execute(array($userid));

		// check if >0 this mean that it exist in database

		$count = $stmt-> rowCount();

		if( $stmt-> rowCount() > 0){

			$stmt = $db ->prepare('DELETE FROM user WHERE User_id = :zuser AND Reg_status = 0 ');
			//to make :zuser take value equel $Userd
			$stmt -> bindParam(':zuser', $userid);
			//to execute
			$stmt -> execute();
			// message delete
			 $theMsg = '<div class="alert alert-danger" role="alert">'. " <strong> Oh snap.! </strong>"
					      .$stmt->rowCount()." record Delete  </div>";
				 	redirectHome($theMsg,"back",2);

		 }else{

			//errors message from the function page 
			$theMsg = "the id is not exist";
			redirectHome($theMsg);

			 }

		 echo "</div>";

	}	


}

include($tpl."footer.php");
ob_end_flush();	