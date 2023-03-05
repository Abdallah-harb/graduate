<?php
ob_start();
session_start();
$pageName="Craftsmen";
if(isset($_SESSION['Admin_Email'])){
	include("init.php");
	$do = isset($_GET['do'])?$_GET["do"]:"Manage";
	if($do == "Manage"){

		//manage craft Detels
		$stmt = $db->prepare("SELECT `craftsmen`.*,
									 `categories`.`Cat_Name` AS `category_name`,
									 `user`.`User_Name` AS `Craft_Name`
							from `craftsmen`
							inner join`categories` on `categories`.`Cat_id`=`craftsmen`.`cat_id`
							inner join `user` on `user`.`User_id` = `craftsmen`.`user_id`
							ORDER BY Craft_ID DESC");
		$stmt->execute();
		$detels = $stmt->fetchAll();
		if(!empty($detels)){?>
			
			<div class="container crafts">
				<h2 class="text-center"> Manage Crafts Detels</h2>
				<div class="table-responsive">
					<table class="table text-center table-bordered">
						<tr>
							<td># ID</td>
							<td>Name</td>
							<td>Age</td>
							<td> Phone </td>
							<td>CategoryName</td>
							<td>CarftingName</td>
							<td>Description</td>
							<td>Controls</td>	
						</tr>
						<?php
							foreach($detels as $detel){
								echo "<tr>";
									echo "<td>".$detel['Craft_ID']."</td>";
									echo "<td>".$detel['Craft_Name']."</td>";
									echo "<td>".$detel['Craft_age']."</td>";
									echo "<td>".$detel['Craft_Phone']."</td>";
									echo "<td>".$detel['category_name']."</td>";
									echo "<td>".$detel['Crafting_name']."</td>";
									echo "<td style= 'width:190px'>".$detel['Craft_description']."</td>";
									echo "<td>
											<a href='?do=Edit&detelid=".$detel['Craft_ID']. "'class='btn btn-success sa'><i class='fa fa-edit'></i>Edit</a>
													 <a href='?do=delete&detelid=".$detel['Craft_ID']. "' class='btn btn-danger da'><i class='fas fa-trash-alt'></i>Delete</a>";
									echo "</td>";  
								echo "</tr>";
							}
						?>	
					</table>	
				</div>		
			</div>		
			
	<?php		
		}else{
			echo "<div class='container'>";
			$message = "<div class='alert alert-info'>There is No members To Show </div>";
			redirectHome($message);
			echo "</div>";
		}			
	}elseif($do == "Edit"){

		//Edit craft Detels
		$detet = isset($_GET['detelid'])?intval($_GET['detelid']):0;
		$stmt = $db->prepare(" SELECT *
							  	from `craftsmen`
								WHERE `Craft_ID` = ?");
		$stmt ->execute(array($detet));
		$row = $stmt ->fetch();
		$count = $stmt ->rowCount();
		if($count > 0){?>

			<div class="container">
				<form class="form-horizontal" action='?do=Update' method="POST">
					<h2 class="text-center">Edit Craft Detels</h2>
					<!--To fetch  id that name with login -->
					<input type="hidden" name ="detelid" value="<?php echo $detet; ?>" >
					<!--start name -->
					 <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">Name</label>
						    <div class="col-sm-10 col-md-7">
						      	<select style="font-size: 15px" class="form-control select" 
						      	name="craftname" >
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
					  <!--start craftingAge-->
					   <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">Age</label>
						    <div class="col-sm-10 col-md-7">
								<input type="text" class="form-control"
						    			placeholder="The Crafting Age"
						    			value="<?php echo $row['Craft_age']?>" name="craftingAge">	  	
						    </div>
					  </div>
					  <!--start craftingPhone-->
					   <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">Phone</label>
						    <div class="col-sm-10 col-md-7">
								<input type="text" class="form-control"
						    			placeholder="The Crafting Phone"
						    			value="<?php echo $row['Craft_Phone']?>" name="craftingPhone">	
						    </div>
					  </div>
					  <!--start category name -->
					 <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">Category</label>
						    <div class="col-sm-10 col-md-7">
						      	<select style="font-size: 15px" class="form-control select" 
						      	name="category" >
						      		<option value="0">.....</option>
						      		<?php
						      			$stmt = $db->prepare("SELECT * FROM `categories`");
						      			$stmt->execute();
						      			$cats = $stmt->fetchAll();
						      			foreach($cats as $cat){

						      				echo '<option value="'.$cat["Cat_id"].'"';
						      				if($row['cat_id'] == $cat['Cat_id']){
						      					echo "selected";}
						      				echo '>'.$cat['Cat_Name'].'</option>';
						      					
						      			}

						      		?>
						       	</select>
						   </div>
					  </div>
					  <!--start craftingname-->
					   <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">CarftingName
						    </label>
						    <div class="col-sm-10 col-md-7">
								<input type="text" class="form-control"
						    			placeholder="The Crafting Name"
						    			value="<?php echo $row['Crafting_name']?>" 
						    	name="craftingname">			  	
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
				echo "<div class='container'>";
					$theMsg = '<div class="alert alert-info">ther is No items to show</div>';
					redirectHome($theMsg);
				echo '</div>';
			}	
		
	}elseif($do == "Update"){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){

				
	 			echo '<div class = "container">';
	 			echo'<h2 class="text-center"> Update Crafts Detels</h2>';

	 			$id             = $_POST['detelid'];
	 			$Name           = $_POST['craftname'];
	 			$age            = $_POST['craftingAge'];
	 			$Phone          = $_POST['craftingPhone'];
	 			$Category       = $_POST['category'];
	 			$craftingname   = $_POST['craftingname'];

	 			$stmt = $db->prepare('  UPDATE `craftsmen`
	 											SET 
	 												`user_id`= ?,
	 												`Craft_age` = ?,
	 												`Craft_Phone` = ?,
	 												`cat_id` = ?,
	 												`Crafting_name` = ?		
	 									WHERE `Craft_ID` = ?');
	 			//errors

	 			$stmt->execute(array($Name,$age,$Phone,$Category,$craftingname,$id));

	 			$theMsg = '<div class="alert alert-success" role="alert">'. " <strong> Well done ! </strong> ".$stmt->rowCount()." record Update </div>";
						 redirectHome($theMsg,"back",3);
	 			
		}else{
			//errors message from function page

	 			$theMsg ="<div class='alert alert-info'> There are error ecured in the form Update</div";
	 			redirectHome($theMsg,"back",3);
			}
			echo '</div>';

	}else if ($do == 'delete'){

			echo'<h2 class="edit">DELETE Crafts Detels</h2>';
	 		echo '<div class = "container">';
			$detet = isset($_GET['detelid'])?intval($_GET['detelid']):0;
			$stmt = $db->prepare("SELECT * FROM  craftsmen WHERE Craft_ID=?");
			$stmt->execute(array($detet));
			$count = $stmt->rowCount();
			if($count >0){

				$stmt = $db->prepare("DELETE  FROM craftsmen WHERE Craft_ID = ? ");
				$stmt->execute(array($detet));
				 $theMsg = '<div class="alert alert-danger" role="alert">'. " <strong> Oh snap.!  </strong>".$stmt->rowCount()." record Delete  </div>";
				 redirectHome($theMsg,"back",2);

			}else{
				$theMsg = "that id is not exist is database";
	 			redirectHome($theMsg,"back",3);

			}
			
	 		echo "</div>";

	}
}

include($tpl."footer.php");
ob_end_flush();