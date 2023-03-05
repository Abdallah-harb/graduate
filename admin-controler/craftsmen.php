<?php
ob_start();
session_start();
$pageName="Craftsmen";
if(isset($_SESSION['Admin_Email'])){
	include("init.php");
	$do = isset($_GET['do'])?$_GET["do"]:"Manaage";
	if($do == "Manaage"){
		//mex data from table user to table craftsmeninfo
		$stmt = $db->prepare("SELECT `craftsmen`.*,
									`user`.`User_Name`  AS `Craft_Name`,
									`user`.`user_email` AS `Craft_Email`,
									`user`.`Full_name` AS `Craft_full_user_name`,
									`user`.`user_Address` AS `Craft_Address`,
									`user`.`user_avatar` AS `Craft_avatar`,
									`categories`.`Cat_Name` AS `Craft_cat`
							  	from `craftsmen`
								inner join `user` on `user`.`User_id` = `craftsmen`.`user_id`
								inner join `categories` on `categories`.`Cat_id` = `craftsmen`.`cat_id`
								ORDER BY `Craft_ID` DESC");
		$stmt->execute();
		$infos = $stmt->fetchAll();
		if(!empty($infos)){?>
			
			<div class="container crafts">
				<h2 class="text-center"> Manage Craftsmen Info</h2>
				<div class="table-responsive">
					<table class="table text-center table-bordered">
						<tr>
							<td># ID</td>
							<td>Name</td>
							<td>Email</td>
							<td>FullName</td>
							<td>Category</td>
							<td>The Craft</td>
							<td>Controls</td>	
						</tr>
						<?php
							foreach($infos as $info){

								echo "<tr>";
									echo "<td>".$info['Craft_ID']."</td>";
									echo "<td>".$info['Craft_Name']."</td>";
									echo "<td>".$info['Craft_Email']."</td>";
									echo "<td>".$info['Craft_full_user_name']."</td>";
									echo "<td>".$info['Craft_cat']."</td>";
									echo "<td>".$info['Crafting_name']."</td>";
									echo "<td>
											<a href='?do=Edit&craftid=".$info['Craft_ID']. "'class='btn btn-success sa'><i class='fa fa-edit'></i>Edit</a>
													 <a href='?do=Delete&craftid=".$info['Craft_ID']. "' class='btn btn-danger da'><i class='fas fa-trash-alt'></i>Delete</a>";
									echo "</td>";
								echo "</tr>";
							}
						?>	
					</table>	
				</div>
				<a href='craftsmen.php?do=Add'class=" Add btn btn-primary" >
					<i class="fa fa-plus"> Add New Craft</i> </a>		
			</div>		
			</div>
	<?php		
		}else{
			echo "<div class='container'>";
					echo "<a href='craftsmen.php?do=Add'class='Add btn btn-primary' ><i class='fa fa-plus'> Add New Craft</i>
				 		</a>";
					$theMsg = '<div class="alert alert-info">ther is No items to show</div>';
					redirectHome($theMsg);
				echo '</div>';
		}
	}elseif($do == "Add"){
		//Add members?>

		<div class="container">
			<form class="form-horizontal"action="?do=insert" method="POST"
					enctype="multipart/form-data">
				<h2 class="text-center">ADD New Crafts</h2>
				<!--start user name-->
				<div class="form-group">
					    <label for="inputPassword3" class="col-sm-2 control-label">UserName</label>
					    <div class="col-sm-10 col-md-7">
					      	<select style="font-size: 15px" class="form-control select" name="member" >
					      		<option value="0">.....</option>
					      		<?php
					      			$allMembers = getAll('*','user','','','User_id');
					      			foreach($allMembers as $user){

					      				echo '<option value="'.$user["User_id"].'">'						.$user['User_Name'].
					      					'</option>';
					      			}

					      		?>
					       	</select>
					   </div>
				</div>
				 
				  <!--start The craft name-->
				  <div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label">The Crafting Name</label>
					    <div class="col-sm-10 col-md-7">
					      <input type="text" class="form-control"  name="thecraftname"
					       required="required" 
					      placeholder="Write the craft name that you want to be">
					    </div>
				  </div>
				  <!--start craft category-->
				   <div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label">Description</label>
					    <div class="col-sm-10 col-md-7">
					      <input type="text" class="form-control"  name="description"
					       required="required" 
					      placeholder="Write the Description for the craft you Written">
					    </div>
				  </div>
				   <!--start The craft Age-->
				  <div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label">The Craft Age</label>
					    <div class="col-sm-10 col-md-7">
					      <input type="text" class="form-control"  name="craftage"
					       required="required" 
					      placeholder="Write the craft Age">
					    </div>
				  </div>
				   <!--start The craft name-->
				  <div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label">The Craft phone</label>
					    <div class="col-sm-10 col-md-7">
					      <input type="text" class="form-control"  name="thecraftphone"
					       required="required" 
					      placeholder="Write a valid phone numbers">
					    </div>
				  </div>
				  <!--start craft category-->
				<div class="form-group">
					    <label for="inputPassword3" class="col-sm-2 control-label">Category</label>
					    <div class="col-sm-10 col-md-7">
					      	<select style="font-size: 15px" class="form-control select" name="category" >
					      		<option value="0">.....</option>
					      		<?php
					      			$allMembers = getAll('*','categories','','','Cat_id');
					      			foreach($allMembers as $user){

					      				echo '<option value="'.$user["Cat_id"].'">'.$user['Cat_Name'].
					      					'</option>';
					      			}

					      		?>
					       	</select>
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
			
			echo "<div class='container'>";
			echo "<h2 class='text-center'>ADD New Craft</h2>";
			
			$members      = $_POST['member'];
			$thecraftname = $_POST['thecraftname'];
			$Description  = $_POST['description']; 
			$Age          = $_POST['craftage'];
			$phone        = $_POST['thecraftphone'];
			$Categorey    = $_POST['category'];

			$formerrors = array();
			
			if(strlen($thecraftname )< 4){
				$formerrors [] = "<div class='alert alert-danger'>The <strong>CraftName </strong>must be larger than 4 characters </div>";
			}
			if(empty($thecraftname)){
				$formerrors [] = "<div class='alert alert-danger'>The <strong>CraftName </strong>must be Written</div>";
			}
			if(empty($Description)){
				$formerrors [] = "<div class='alert alert-danger'>The <strong>Description </strong>must be Written</div>";
			}
			if(strlen($Description) < 8 ){
				$formerrors [] = "<div class='alert alert-danger'>The <strong>Description </strong>must be Written at least 8 characters</div>";
			}
			if(empty($members)){
				$formerrors [] = "<div class='alert alert-danger'>The <strong>Member </strong>must be Written</div>";
			}
			if(empty($Categorey)){
				$formerrors [] = "<div class='alert alert-danger'>The <strong>category </strong>must be Written</div>";
			}
			foreach($formerrors as $errors){
				 
				redirectHome($errors,"back",4);

			}
			if(empty($formerrors)){
			//insert the new data on database

			$stmt = $db->prepare("INSERT INTO
										   `craftsmen`(`user_id`,`Crafting_name`,`Craft_description`,
										   `Craft_age`,`Craft_Phone`,`cat_id`)
										VALUES
											(:zuser,:zcraftingname,:zdesc,:zage,:zphone,:zcat)");

			$stmt->execute(array(
						'zuser'            => $members,
						'zcraftingname'    =>  $thecraftname,
						'zdesc'            => $Description,
						'zage'             => $Age,
						'zphone'           => $phone,
						'zcat'             => $Categorey));
					//sucess message 
					$sucmessage = "<div class='alert alert-success'> 1 Craft added</div>";
					redirectHome($sucmessage,"back",3);
				
			}
			echo "</div>";
		}else{
			echo "<div class='container'>";
			$message ="<div class='alert alert-info'>There is Error ecured to insert members</div>"; 
			redirectHome($message);
			echo "</div>";
		}

	}elseif($do == "Edit"){

		$craft = isset($_GET['craftid'])?intval($_GET['craftid']):0;
		$stmt = $db->prepare(" SELECT *
							  	from `craftsmen`
								WHERE `Craft_ID` = ?");
		$stmt ->execute(array($craft));
		$row = $stmt ->fetch();
		$count = $stmt ->rowCount();
		if($count > 0){?>

			<div class="container">
				<form class="form-horizontal" action='?do=Update' method="POST" 									enctype="multipart/data-form">
					<h2 class="text-center">Edit Craft info</h2>
					<!--start categorey name-->
					<input type="hidden" name ="craftid" value="<?php echo $craft; ?>" >
					  <!--start member-->
					  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">Member</label>
						    <div class="col-sm-10 col-md-7">
						      	<select style="font-size: 15px" class="form-control select" name="member" >
						      		<option value="0">.....</option>
						      		<?php
						      			$stmt = $db->prepare("SELECT * FROM `user`");
						      			$stmt->execute();
						      			$users = $stmt->fetchAll();
						      			foreach($users as $user){

						      				echo '<option value="'.$user["User_id"].'"';
						      				if($row['user_id'] == $user['User_id']){echo "selected";}
						      				echo '>'.$user['User_Name'].'</option>';
						      					
						      			}

						      		?>
						       	</select>
						   </div>
					  </div>
					  <!--sratr crafting name-->
					 <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">CraftingName</label>
						    <div class="col-sm-10 col-md-7">
						      <input type="text" class="form-control" id="inputText3" placeholder="name"
						       name="craftingname" required="required" value="<?php echo  $row['Crafting_name']?>">
						    </div>
					  </div>
					  <!--sratr description-->
					 <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">Description</label>
						    <div class="col-sm-10 col-md-7">
						      <input type="text" class="form-control" id="inputText3"
						       placeholder="write a description for you craft " name="description" required="required" 
						       value="<?php echo  $row['Craft_description']?>">
						    </div>
					  </div>
					  <!--sratr craft Age-->
					 <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">Age</label>
						    <div class="col-sm-10 col-md-7">
						      <input type="text" class="form-control" id="inputText3" placeholder="Age"
						       name="age" required="required" 
						       value="<?php echo  $row['Craft_age']?>">
						    </div>
					  </div>
					   <!--sratr craft phone-->
					 <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">Phone</label>
						    <div class="col-sm-10 col-md-7">
						      <input type="text" class="form-control" id="inputText3" placeholder="phone"
						       name="phone" required="required" 
						       value="<?php echo  $row['Craft_Phone']?>">
						    </div>
					  </div>
					  <!--start category-->
					  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">Category</label>
						    <div class="col-sm-10 col-md-7">
						      	<select style="font-size: 15px" class="form-control select" 
						      		name="categorey" >
						      		<option value="0">.....</option>
						      		<?php
						      			$stmt = $db->prepare("SELECT * FROM `categories`");
						      			$stmt->execute();
						      			$cats = $stmt->fetchAll();
						      			foreach($cats as $cat){

						      				echo '<option value="'.$cat["Cat_id"].'"';
						      				if($row['cat_id'] == $cat['Cat_id']){echo "selected";}
						      				echo '>'.$cat['Cat_Name'].'</option>';
						      					
						      			}

						      		?>
						       	</select>
						   </div>
					  </div>
						<!--start submit-->
					  <div class="form-group">
						    <div class="col-sm-offset-2 col-sm-10">
						      <button type="submit" class="btn btn-primary"> Save </button>
						    </div>
					  </div>
			   		 </form>
			   		 
				
			</div>


	<?php	}else{

			//error message from the function.php
			$theMsg = "<div class='alert alert-danger'>there is no such<strong id</stronf to edit memebrrs</div>";
			redirectHome($theMsg,"back",3);
			}
		
	}elseif($do == "Update"){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
	 			echo '<div class = "container">';
	 			echo'<h2 class="text-center"> Update Crafts Info</h2>';

	 			$id             = $_POST['craftid'];
	 			$Member         = $_POST['member'];
	 			$CrafingtName   = $_POST['craftingname'];
	 			$Description    = $_POST['description'];
	 			$Age            = $_POST['age'];
	 			$Phone          = $_POST['phone'];
	 			$Category       = $_POST['categorey'];

	 			$stmt = $db->prepare("UPDATE `craftsmen` SET 
	 													    `user_id`    = ?,
	 													    `Crafting_name`    = ?,
	 													    `Craft_description`    = ?,
	 													    `Craft_age`    = ?,
	 													    `Craft_Phone`   = ?,
	 													    `cat_id`    = ?
	 									WHERE `Craft_ID`=?");
	 			$stmt->execute(array($Member,$CrafingtName,$Description,$Age,$Phone,$Category,$id));

	 			$theMsg = '<div class="alert alert-success" role="alert">'. " <strong> Well done ! </strong> ".$stmt->rowCount()." record Update </div>";
						 redirectHome($theMsg,"back",3);
	 			
		}else{
			//errors message from function page

	 			$theMsg = "fatel error:ecoured";
	 			redirectHome($theMsg,"back",3);
			}
			echo '</div>';

	}elseif($do == "Delete"){

			
	 		echo '<div class = "container">';
	 		echo'<h2 class="text-center"> Update Items</h2>';
			$craft = isset($_GET['craftid'])?intval($_GET['craftid']):0;
			$stmt  = $db->prepare("SELECT * FROM craftsmen WHERE Craft_ID=?");
			$stmt->execute(array($craft));
			$count = $stmt->rowCount();
			if($count >0){

				$stmt = $db->prepare("DELETE  FROM craftsmen WHERE Craft_ID=? ");
				$stmt->execute(array($craft));
				 $theMsg = '<div class="alert alert-danger" role="alert">'. " <strong> Oh snap.!  </strong>".$stmt->rowCount()." record Delete  </div>";
				 redirectHome($theMsg,"back",2);

			}else{
				$theMsg = "that id is not exist is database";
	 			redirectHome($theMsg,"back",3);

			}
			
	 		echo "</div>";	} 

}

include($tpl."footer.php");
ob_end_flush();		