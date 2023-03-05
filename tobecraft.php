<?php 

ob_start();
session_start();
$pageName = "To Be Craftmen";
include("init.php");
if($_SESSION['useremail']){

	$do = isset($_GET['do'])?$_GET["do"]:"Add";
	if($do == "Add"){
		//Add members?>

		<div class="container">
			<form class="form-horizontal"action="?do=insert" method="POST"
					enctype="multipart/form-data">
				<h2 class="text-center">To Be Craftmen</h2>
				<!--Start user name-->
					<div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label">Your Name</label>
					    <div class="col-sm-10 col-md-7">
					      <input type="text" class="form-control"  name="member"
					       required="required" value="<?php echo $_SESSION['name'] ;?>" 
					      readonly>
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
				     <!--start The craft location-->
				  <div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label">location</label>
					    <div class="col-sm-10 col-md-7">
					      <input type="text" class="form-control"  name="location"
					       required="required" 
					      placeholder="Write Your Location">
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
			echo "<h2 class='edit'>ADD New Craft</h2>";
			echo "<div class='container'>";

			
			$thecraftname = $_POST['thecraftname'];
			$Description  = $_POST['description']; 
			$Age          = $_POST['craftage'];
			$Location     = $_POST['location'];
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
			if(strlen($Location ) < 3){
				$formerrors [] = "<div class='alert alert-danger'>The <strong>Location </strong>must be larger than 3 characters </div>";
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
										   `Craft_age`,`Craft_locations`,`Craft_Phone`,`cat_id`)
										VALUES
											(:zuser,:zcraftingname,:zdesc,:zage,:zlocation,
														:zphone,:zcat)");

			$stmt->execute(array(
						'zuser'            => $_SESSION['uid'],
						'zcraftingname'    =>  $thecraftname,
						'zdesc'            => $Description,
						'zage'             => $Age,
						'zlocation'        => $Location,
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

	}

	
}else{

	echo "<div class='container'>";
		echo "<div class='alert alert-info'>Click TO <a href='signin.php'>Signin </a></div>";
	echo "</div>";
}

	

include($tpl."footer.php");
ob_end_flush();
?>