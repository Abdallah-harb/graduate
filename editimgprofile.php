<?php
ob_start();
session_start();
$pageName="Edit Profile";
if(isset($_SESSION['useremail'])){
	include("init.php");
	$do = isset($_GET['do'])?$_GET['do']:'Edit';
	if($do == "Edit"){
		//edit user info
	
		$userinfo = $db->prepare('SELECT * FROM `user` WHERE `User_id` = ? ');
		$userinfo->execute(array($_SESSION['uid']));
		$row = $userinfo->fetch();
		$count = $userinfo->rowCount();
		if($count > 0){?>
			<div class="container">
				<form class="form-horizontal edit-img" action="?do=Update" method="POST"
					enctype="multipart/form-data">
					<h2 class="text-center">Edit Your Photo</h2>
					<!--To use it when i update date -->
					<input type="hidden" name ="imgid" value="<?php echo $_SESSION['uid']; ?>" >
					<!--start user avatar-->
						<table >
					  		<label for="inputEmail3" class="col-sm-2 control-label">old Image</label>
					  		<td width="100px" >
								<img src="admin-controler/upload/<?php echo $row['user_avatar']?>"
					  		</td>
				  		</table>
				  		<div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">New Image</label>
						    <div class="col-sm-10 col-md-7">
						      <input type="file" class="form-control" name="avatar" required="required">
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
			echo "<div class='alert alert-danger'>Your are not allaewd to be here</div>";
		}
	}else if($do == 'Update'){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
  			//update data
			  		//avatar info
			$avatarName = $_FILES['avatar']['name'];
			$avatarSize = $_FILES['avatar']['size'];
			$avatartmp  = $_FILES['avatar']['tmp_name'];
			$avatartype = $_FILES['avatar']['type'];
			//avatar type extensions
			$avatarallowextensions = array("jpeg","jpg","png","gif");
			//to take the extensions from avatar name
			$avatarextensions = strtolower(end(explode(".", $avatarName))); 
			//image size and erors
			$formerrors = array();
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
				move_uploaded_file($avatartmp,"admin-controler/upload\\".$avatar);

				//update img
				$stmt = $db->prepare("UPDATE `user` SET `user_avatar`= ?
										 WHERE `User_id` = ?");
  			 	$stmt->execute(array($avatar,$_SESSION['uid']));
			}	
  			 
  		}
	}		
}else{
	header("location:index.php");
	exit();
}


include($tpl."footer.php");
ob_end_flush();		