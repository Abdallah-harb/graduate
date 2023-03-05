<?php
ob_start();
session_start();
$pageName="dashpord";
if(isset($_SESSION['Admin_Email'])){
	include("init.php");

	// to get last item in the page 
	 $NumUser = 3; //number of last user i get to show it 
	 $latestUsers = getitem("*","user","User_id",$NumUser);
	 $NumCraft = 3; //number of last item added to show on dashbord
	 $latesCrafts = getitem('*','craftsmen','Craft_ID',$NumCraft);?>

	<div class="container home-stat text-center">
		<h1>Dashbord</h1>
		<div class="row">
			<div class="col-md-3">
				<div class="stat st-member">
					<a href="members.php "class="pig"><i class="fa fa-users"></i></a>
					<div class="info">
						<a href ="members.php">Total Members</a>
						<!-- from function page to count number of members -->
							<span>
								<a href="members.php"><?php echo countItem('User_id','user')?></a>
							</span>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="stat st-craft">
					<a href="craftsmen.php" class="pig"><i class="fas fa-user-secret"></i></a>
					<div class="info">
							<a href ="craftsmen.php">Totel Craftsmen</a>
							<!-- from function page to count number of members -->
							<span>
								<a href="craftsmen.php"><?php echo countItem('Craft_ID','  craftsmen')?></a>
							</span>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="stat st-detls">
					<a href="craftsmeninfo.php" class="pig"><i class="fas fa-users-cog"></i></a>
					<div class="info">
						<a href ="craftsmeninfo.php">Craftsmen Info</a>
						<span>
								<a href="item.php">
									<a href="craftsmeninfo.php"><?php echo countItem('Craft_ID','  craftsmen')?></a>					
									</a>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="stat st-categoriess">
					<a href="Categories.php" class="pig"><i class="fa fa-tag"></i></a>
					<div class="info" >
						<a href="Categories.php">Total Categories</a>
							<span>
								<a href="Categories.php">
									<?php echo countItem('Cat_id','categories')?>			
								</a>
							</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--start latest 3 of user or craftsme -->
	<div class="container latest">
		<div class="row">
			<div class="col-md-6 col-xs-6">
				<h3 class="text-center">Latest <?php echo $NumUser;?>  Registration </h3>
				<div class="table-responsive">
  					<table class="table">
  						<tr>
	   						 <td>#ID</td>
	   						 <td>User Name</td>
	   						 <td>Img</td>
   						</tr>
   						<?php
   							//to show the latest users
   						if(!empty($latestUsers)){
	   						foreach($latestUsers as $latestUser){
		   						echo "<tr>";
		   							echo "<td>".$latestUser['User_id']."</td>";
		   							echo "<td>".$latestUser['User_Name']."</td>";
		   							echo "<td>";
										if(!empty($latestUser['user_avatar'])){
											echo "<img src='upload/".$latestUser['user_avatar']."'width='50px' height='50px'>";
										}else{
											echo "<img src='upload/craftsman.jpg'alt='image' width='50px' height='50px'>";
										}
									echo"</td>";

		   						echo "</tr>";
	   						}
	   					
   						}else{
   							echo "<div class='alert alert-info'>There are No user to Show</div>";
   						}
   						
   						?>
  					</table>
				</div>
			</div>	
			<div class="col-md-6 col-xs-6">
				<h3 class="text-center">Latest <?php echo $NumCraft;?> Craftsmen </h3>
				<div class="table-responsive">
  					<table class="table">
  						<tr>
   							<td>#ID</td>
   						 	<td>Craft Name</td>
   							<td>Img</td>
   						</tr>
   						<?php
   							//to show the latest crafts
   						if(!empty($latesCrafts)){
	   						foreach($latesCrafts as $latesCraft){
		   						echo "<tr>";
		   							echo "<td>".$latesCraft['Craft_ID']."</td>";
		   							echo "<td>".$latesCraft['Crafting_name']."</td>";
		   							echo "<td>".$latesCraft['Craft_age']."</td>";

		   						echo "</tr>";
	   						}
	   					
   						}else{
   							echo "<div class='alert alert-info'>There are No user to Show</div>";
   						}
   						
   						?>
  					</table>
				</div>
			</div>
		</div>	
	</div>	
	<!--end latest 3 of user or craftsme -->
	<!--start show craftsmen on map-->
	<div class="container map">
		<h1 class="text-center">Show craftsmen on map</h1>
		<form class="form-group"method="POST" action="<?php echo $_SERVER['PHP_SELF']?>"
				 enctype="multipart/data">
			<input type="text"  name="user_query" placeholder="Write A craft you need it">
			<input type="submit"  class="btn btn-success"name="Search" value="search">
		 </form>

		 <?php
		 	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		 		$usersearch  = $_POST['user_query'] ;
		 		$stmt = $db->prepare("SELECT `craftsmen`.*,
										 `categories`.`Cat_Name` AS `category_name`,
										 `user`.`User_Name` AS `Craft_Name`
									from `craftsmen`
									inner join`categories` on `categories`.`Cat_id`=`craftsmen`.`cat_id`
									inner join `user` on `user`.`User_id` = `craftsmen`.`user_id`
								
		 							WHERE `Crafting_name` LIKE '%$usersearch%'");
		 		$stmt->execute();
		 		$rows = $stmt->fetchAll();
		 		$count = $stmt->rowCount();
		 		if($count > 0 ){
		 			foreach($rows as $row){
		 				echo "<div class=' '>";
		 					echo "<h3>".$row['Craft_Name']."</h3>";
		 					echo "<h3>".$row['Crafting_name']."</h3>";
		 					echo "<h3>".$row['Craft_Phone']."</h3>";
		 					echo "<h3>".$row['category_name']."</h3>";
		 				echo "</div>";
		 			}

		 		}else{
		 			echo "<div class='alert alert-info'> There are no data for this search </div>";
		 		}
		 	}

		 	
		 ?>
	</div>	
	<!--start show craftsmen on map-->

<?php	
}

include($tpl."footer.php");
ob_end_flush();