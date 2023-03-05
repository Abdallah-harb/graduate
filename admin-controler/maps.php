<?php
ob_start();
session_start();
$pageName="Maps";
if(isset($_SESSION['Admin_Email'])){
	include("init.php");?>

	<!--start show craftsmen on map-->
	<div class="container map">
		<h1 class="text-center">Show craftsmen on map</h1>
		<form class="form-group"method="POST" action="<?php echo $_SERVER['PHP_SELF']?>"
				 enctype="multipart/data">
			<input type="text"  class="form-control" name="user_query" placeholder="Write A craft you need it" required="required">
			<input type="text"  class="form-control" name="user_location"
			 placeholder="Write Your locations" disabled="disabled">
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
		 							WHERE `Crafting_name` LIKE '%$usersearch'");
		 		$stmt->execute( array($usersearch));
		 		$rows = $stmt->fetchAll();
		 		$count = $stmt->rowCount();
		 		if($count > 0 ){
		 			foreach($rows as $row){
		 				echo "<div class=' '>";
		 					echo "<h3>".$row['Craft_Name']."</h3>";
		 					echo "<h3>".$row['Crafting_name']."</h3>";
		 					echo "<h3>".$row['Craft_Phone']."</h3>";
		 					echo "<h3>".$row['category_name']."</h3>";
		 						$rate = $db->prepare("SELECT DISTINCT `rating`.`rate_num`,rating.*   						FROM `rating`
		 											
		 												Where `craft_id` = ?
		 													ORDER BY `rate_id` DESC LIMIT 3 ");
		 						$rate->execute(array($row['Craft_ID']));
		 						$fetch = $rate->fetchAll();
		 						
		 							foreach($fetch as $ratecraft){
		 								echo "<span class='craft-rate'>".$ratecraft['rate_num']."</span>";
		 							}
		 					
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
