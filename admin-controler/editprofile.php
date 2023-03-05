<?php
ob_start();
session_start();
$pageName="Edit Profile";
if(isset($_SESSION['Admin_Email'])){
	include("init.php");
	$do = isset($_GET['do'])?$_GET['do']:'manage';
	if($do == 'Edit'){
		$admin=isset($_GET['adminid'])&& is_numeric($_GET['adminid'])?intval($_GET['adminid']):0;
		//get admin info from database
		$stmt = $db->prepare("SELECT * FROM `user` 
								WHERE `User_id` = ?
								AND  `Reg_status` = 1 
								limit 1");
		$stmt->execute(array($admin));
		$row   = $stmt->fetch();
		$count = $stmt->rowCount();
		if($stmt->rowCount() > 0){?>
			<!--showdat to edit it -->
			<div class="container">
			<form  action="?do=Update" method="POST"
					class="form-horizontal admimedit" >
				<h2 class="text-center">Edit Your Informations</h2>
				<!--To use it when i update date -->
				<input type="hidden" name ="adminid" value="<?php echo $admin; ?>" >
				<div class="form-group">
				    <label for="inputPassword3" class="col-sm-2 control-label">Name</label>
				    <div class="col-sm-10 col-md-7">
				      <input type="text" class="form-control"  placeholder="Password"
				      	value="<?php echo $row['User_Name'];?>" name="adminname">
				    </div>
			    </div>
			    <div class="form-group">
				    <label for="inputPassword3" class="col-sm-2 control-label">FullName</label>
				    <div class="col-sm-10 col-md-7">
				      <input type="text" class="form-control" placeholder="Password" 
				      	value="<?php echo $row['Full_name'];?>" name="fullname">
			    	</div>
			    </div>
			  <div class="form-group">
			    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
			    <div class="col-sm-10 col-md-7">
			      <input type="email" class="form-control" id="inputEmail3" placeholder="Email"
			      	value="<?php echo $row['user_email'];?>" name="email">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
			     <div class="col-sm-10 col-md-7">
					    	<input type="hidden" name="oldpassword"
					    	 value='<?php echo $row["user_password"]?>'>
					      	<input type="password" class="form-control" id="inputPassword3" 
					      		placeholder="Leave Blank if you Don't To Change.!" name="newpassword" 
					      		autocomplete="new-password">
				 </div>
			  </div>
			  	<div class="form-group">
				    <label for="inputPassword3" class="col-sm-2 control-label">Address</label>
				    <div class="col-sm-10 col-md-7">
				      <input type="text" class="form-control" placeholder="Your address"
				      	value="<?php echo $row['user_Address'];?>" name="address">
				    </div>
			    </div>
			  <div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      <button type="submit" class="btn btn-primary">Save</button>
			    </div>
			  </div>
			</form>
		</div>

	<?php		

		}else{
			echo "<div class='alert alert-info'>There are data to show that you not admin";
		}
	}elseif($do == "Update"){
		//Update Your infos
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			echo "<div class='container'>";
				echo "<h2 class='text-center'>Your info are Update .</h2>";
				$adid     = $_POST['adminid'];
				$Name     = $_POST['adminname'];
				$FullName = $_POST['fullname'];
				$Email    = $_POST['email'];
				//password track
					   //with if condition shorting >> condition ?TRue : false ;
				$pass = empty($_POST["newpassword"])? $_POST["oldpassword"]:sha1($_POST["newpassword"]);
				$Address  = $_POST['address'];

				$stmt =$db->prepare(' UPDATE `user` SET    `User_Name` = ?,
					 										`Full_name`= ?, 
					 										`user_email` = ?,
					 										`user_password` = ?,
					 										`user_Address` = ?		         
													WHERE  `User_id`= ?');
				$stmt->execute(array($Name,$FullName,$Email,$pass,$Address,$adid));
				//success message
				$thismsg ="<div class='alert alert-success'>".$stmt->rowCount()."record Update</div>";
				redirectHome($thismsg,"back");
			echo "</div>";

		}

	}
	
	


}

include($tpl."footer.php");
ob_end_flush();	