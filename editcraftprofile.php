<?php
ob_start();
session_start();
$pageName="Edit Craft Profile";
if(isset($_SESSION['useremail'])){
	include("init.php");
		$do = isset($_GET['do'])?$_GET['do']:'Edit';
	if($do == "Edit"){

		$craft = isset($_GET['craftid'])?intval($_GET['craftid']):0;
		$stmt = $db->prepare(" SELECT *
							  	FROM `craftsmen`
								WHERE `Craft_ID` = ? 
								limit 1");
		$stmt -> execute(array($craft));
		$row = $stmt ->fetch();
		$count = $stmt ->rowCount();
		if($count > 0){?>

			<div class="container">
				<form class="form-horizontal" action='?do=Update' method="POST" >
					<h2 class="text-center">Edit Your Crafting Detels </h2>
					<!--start categorey name-->
					<input type="hidden" name ="craftid" value="<?php echo $craft; ?>" >
					  <!--start member-->
					  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">Member</label>
						    <div class="col-sm-10 col-md-7">
						    	<input type="text" class="form-control" id="inputText3"
						       placeholder="name" name="member" required="required" 
						       value="<?php echo $_SESSION['name'];?>" disabled>
						      
						   </div>
					  </div>
					  <!--sratr crafting name-->
					 <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">CraftingName</label>
						    <div class="col-sm-10 col-md-7">
						      <input type="text" class="form-control" id="inputText3"
						       placeholder="name" name="craftingname" required="required" 
						       value="<?php echo  $row['Crafting_name']?>">
						    </div>
					  </div>
					  <!--sratr description-->
					 <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">Description</label>
						    <div class="col-sm-10 col-md-7">
						      <input type="text" class="form-control" id="inputText3"
						       placeholder="write a description for you craft " name="description" required="required" value="<?php echo  $row['Craft_description']?>">
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
				echo'<h2 class="text-center"> Update Crafts Info</h2>';
	 			echo '<div class = "container">';

	 			$id             = $_POST['craftid'];
	 			$CrafingtName   = $_POST['craftingname'];
	 			$Description    = $_POST['description'];
	 			$Age            = $_POST['age'];
	 			$Phone          = $_POST['phone'];
	 			$Category       = $_POST['categorey'];

	 			$stmt = $db->prepare("UPDATE `craftsmen` SET
	 													    `Crafting_name`    = ?,
	 													    `Craft_description`  = ?,
	 													    `Craft_age`    = ?,
	 													    `Craft_Phone`   = ?,
	 													    `cat_id`    = ?
	 									WHERE `Craft_ID`=?");
	 			$stmt->execute(array($CrafingtName,$Description,$Age,$Phone,$Category,$id));

	 			$theMsg = '<div class="alert alert-success" role="alert">'. " <strong> Well done ! </strong> ".$stmt->rowCount()." record Update </div>";
						 redirectHome($theMsg,"back",3);
	 			
		}else{
			//errors message from function page

	 			$theMsg = "fatel error:ecoured";
	 			redirectHome($theMsg,"back",3);
			}
			echo '</div>';

	}
}else{
	header("location:index.php");
	exit();
}


include($tpl."footer.php");
ob_end_flush();		