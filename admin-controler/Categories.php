<?php
ob_start();
session_start();
$pageName="Categories";
if(isset($_SESSION['Admin_Email'])){
	include("init.php");
	$do = isset($_GET['do'])?$_GET['do']:'manage';
		if($do == 'manage'){
			$sort ='ASC';
			$sort_array = array('ASC','DESC');
			if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){
				$sort = $_GET['sort'];
			}
			$stmt = $db->prepare("SELECT * FROM `categories` 
									ORDER BY `Cat_id` $sort ");
			$stmt ->execute();
			$fetchs = $stmt->fetchAll();
			/*
			//if there is categorey show the table 
			//if there is categorey back to home page.
			*/
			if(!empty($fetchs)){
			?>
			
			<div class="container categorey">
				<h2 class=" text-center"> Manage Categories</h2>
				<div class="panel panel-default">
					<div class="panel panel-heading head">
					 	Manage
					 	<div class = "ordering pull-right">
					 		Ordering - 
					 		<a class="<?php if($_GET['sort']=='ASC'){echo "active";}?>"href="?sort=ASC">ASC</a> /
					 		<a class='<?php if($_GET['sort']=='DESC'){echo "active";}?> 'href="?sort=DESC">DESC</a>
					 	</div>
					</div>
					<div class="panel panel-body bd">
						<?php
							foreach ($fetchs as $fetch) {

								echo "<div class='cat'>";
									echo '<div class="button">';
										echo "<a href='categories.php?do=Edit&catid=".$fetch['Cat_id']."' class=' btn btn-primary aa'>
											<i class='fa fa-edit'></i>Edit</a>";
										echo "<a href='?do=Delete&catid=".$fetch['Cat_id']."' class=' btn btn-danger'>
											<i class='fas fa-trash-alt'></i>Delete</a>";
									echo '</div>';
									echo "<h3>".$fetch ['Cat_Name']."</h3>";
									echo "<div class='option'>";
										echo "<p>"; if($fetch['Cat_Description'] == ''){
														echo "this Category has no description";
													}else {
														echo $fetch['Cat_Description'];
													}
										echo"</p>";
									echo "</div>";
								echo "</div>";
								echo "<hr>";
							}
						?>
					</div>
				</div>
				<a href='?do=Add'class=" Add btn btn-primary" ><i class="fa fa-plus"> Add New Categories </i> </a>
			</div>
			<?php }else{
				echo "<div class='container'>";
					echo '<a href="Categories.php.php?do=Add" class=" Add btn btn-primary" ><i class="fa fa-plus"> Add New Categories</i> </a>';
					$theMsg = '<div class="alert alert-info" role="alert">ther is No Categories to show</div>';
					//redirectHome($theMsg);
				echo '</div>';
			}?>

  <?php }else if($do == 'Add'){?>
			<div class="container">
				<form class="form-horizontal" action='?do=insert' method="POST">
					<h2 class="text-center">Add New Categories</h2>
					<!--start categorey name-->
					 <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
						    <div class="col-sm-10 col-md-7">
						      <input type="text" class="form-control" id="inputText3"
						       placeholder="Catefory name" name="name" autocomplete="off"
						        required="required">
						    </div>
					  </div>
					  	<!--start Description-->
					   <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">Description
						    </label>
						    <div class="col-sm-10 col-md-7">
						      	<input type="text" class="form-control" 
						      		placeholder="Description the categories" name="description">
						      						  	
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
<?php
	    }else if($do == 'insert'){


			//insert new member

	 		
	 		if($_SERVER['REQUEST_METHOD'] == 'POST'){

	 				
	 				echo '<div class = "container">';
	 				echo'<h2 class="text-center"> Insert Categories</h2>';

	 			$Name       = $_POST['name'];
	 			$desc       = $_POST['description'];
	 			
				 //check if user exist in database
				$check = checkItem('Cat_Name','categories',$Name);
				if($check == 1){
					$theMsg = '<div class= "alert alert-danger"> Sorry category is exist</div>';
					redirectHome($theMsg,"back",3);
				}else{
					//Insert the top date from bottom from database
					$stmt = $db->prepare('INSERT INTO categories (`Cat_Name`,`Cat_Description` )
												/*valus is Aky that valuse is have no value
												becouse the : mean it mepty , the data take key 
												zuser from array and valus from $_post/ >>$useName */
												VALUES(:zname,:zdesc)
										');

							$stmt -> execute(array(

								'zname'     => $Name,
								'zdesc'     => $desc));

						  //sucess message.

						 $theMsg = '<div class="alert alert-success" role="alert">'. " <strong> Well done ! </strong> ".$stmt->rowCount()." record insert </div>";

						 redirectHome($theMsg,'back',3);
					}
					
				
	 		}else{
	 				//error message from function page 
	 			echo "<div class='container'>";

	 			$theMsg= '<div class=" alert alert-danger"> "You cannot redirect this page 															redirect"</div>';
	 			redirectHome($theMsg,"back",3);
	 			echo "</div>";
	 		}
	 		//end of the container.!
	 		echo "</div>";

		}else if($do == 'Edit'){

			$catid = isset($_GET['catid']) && is_numeric($_GET['catid'])?intval($_GET['catid']):0;
			$stmt = $db->prepare("SELECT * FROM categories WHERE Cat_id = ?");
			$stmt->execute(array($catid));
			$cat=$stmt->fetch();
			$count = $stmt->rowCount();
			if($count>0){
				?>
				<div class="container">
					<form class="form-horizontal" action='?do=Update' method="POST">
						<h2 class="text-center">Edit Categories</h2>
						<!--start categorey name-->
						 <div class="form-group">
							    <label for="inputEmail3" class="col-sm-2 control-label">CaregoryName
							    </label>
							    <div class="col-sm-10 col-md-7">
							    	<!--To use it when i update date -->
									<input type="hidden" name ="catid" value="<?php echo $catid; ?>" >
							      <input type="text" class="form-control" id="inputText3" 
							      placeholder="name" name="name" value="<?php echo $cat['Cat_Name']?>" required="required">
							    </div>
						  </div>
						  	<!--start Description-->
						   <div class="form-group">
							    <label for="inputPassword3" class="col-sm-2 control-label">Description</label>
							    <div class="col-sm-10 col-md-7">
							      	<input type="text" class="form-control" 
							      		 value="<?php echo $cat['Cat_Description']?>"  
							      		placeholder="Description the categories" name="description">
							      						  	
							    </div>
						  </div> 
						  <!--start submit-->
					  <div class="form-group">
						    <div class="col-sm-offset-2 col-sm-10">
						      <button type="submit" class="btn btn-primary"> Save </button>
						    </div>
					  </div>
		 <?php }else{

			 	//error message from the function.php
				$theMsg = "there is no such id to edit memebrrs";
				redirectHome($theMsg,"back",3);

			}

		}else if ($do == 'Update'){

			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
	 			echo '<div class = "container">';
	 			echo'<h2 class="text-center"> Update Categories</h2>';

	 			$id         = $_POST['catid'];
	 			$name       = $_POST['name'];
	 			$decripe    = $_POST['description'];
	 			
	 			$stmt = $db->prepare("UPDATE categories SET `Cat_Name` = ?,
	 														`Cat_Description` = ?
	 									WHERE `Cat_id`=?");
	 			$stmt->execute(array($name,$decripe,$id));

	 			$theMsg = '<div class="alert alert-success" role="alert">'. " <strong> Well done ! </strong> ".$stmt->rowCount()." record Update </div>";
						 redirectHome($theMsg,"back",2);
	 			
			}else{
			//errors message from function page

	 			$theMsg = "fatel error:ecoured";
	 			redirectHome($theMsg,"back",3);
			}
			echo '</div>';

		}else if($do == 'Delete'){

			
	 		echo '<div class = "container">';
	 		echo'<h2 class="text-center"> Delete Categories</h2>';
	 		$catid = isset($_GET['catid']) && is_numeric($_GET['catid'])?intval($_GET['catid']):0;
			$stmt = $db->prepare("SELECT * FROM `categories` WHERE `Cat_id` = ?");
			$stmt->execute(array($catid));
			$count = $stmt->rowCount();
			if($count >0){

				$stmt = $db->prepare("DELETE  FROM `categories` WHERE `Cat_id` = ? ");
				$stmt->execute(array($catid));
				 $theMsg = '<div class="alert alert-danger" role="alert">'. " <strong> Oh snap.!  </strong>".$stmt->rowCount()." record Delete  </div>";
				 redirectHome($theMsg,"back",2);

			}else{
				$theMsg = "that id is not exist is database";
	 			redirectHome($theMsg,"back",3);

			}
	 		echo "</div>";
		}


	
}else{
	header("location:index.php");
}

include($tpl."footer.php");
ob_end_flush();	