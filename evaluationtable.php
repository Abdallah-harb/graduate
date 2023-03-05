<?php
ob_start();
session_start();
$pageName="Evaluation";
if(isset($_SESSION['useremail'])){
	include("init.php");
	$do =isset($_GET["do"])?$_GET['do']:"Manage";
	if($do == 'Manage'){
		//fetch data from table user to table craftsmeninfo
		$stmt = $db->prepare("SELECT `craftsmen`.*,
									`user`.`User_Name`  AS `Craft_Name`,
									`user`.`Full_name` AS `Craft_full_user_name`,
									`user`.`user_avatar` AS `Craft_avatar`
							  	from `craftsmen`
								inner join `user` on `user`.`User_id` = `craftsmen`.`user_id`
								ORDER BY `Craft_ID` DESC");
		$stmt->execute();
		$infos = $stmt->fetchAll();
	?>
		<div class="container admimedit">
			<form method="POST" action="?do=rated">
				<h2 class="text-center">Start Evaluate Craftsmen </h2>
				<div class="table-responsive">
					<table class="table text-center table-bordered">
						<tr>
							<td>Name</td>
							<td>LastName</td>
							<td>Image</td>
							<td>Evaluation </td>
							<td>Start evaluate</td>
						</tr>
						<?php 
							foreach($infos as $info){
								echo '<tr>';
									echo '<td>'.$info['Craft_Name'].'</td>';
									echo '<td>'.$info['Craft_full_user_name'].'</td>';	
									echo '<td>';
									   echo "<img src='admin-controler/upload/".$info['Craft_avatar']."'width='50px' height='50px'>";
									echo '</td>';
									echo '<td  width="206px">';
										echo '<div class="rateyo"id ="rating" data-rateyo-rating="4"data-rateyo-num-stars="5" data-rateyo-score="3"></div>';
									echo '</td>';
									echo '<td>';
										echo "<a href='?do=insert&craftid=".$info['Craft_ID']. "'class='btn btn-success sa'><i class='fas fa-star'></i>To Svaluate</a>";
									echo '</td>';	
								echo '</tr>';			
								}
							?>
					</table>
				</div>
			</form>			
		</div>
<?php
	}elseif($do == 'insert'){
		$craft= isset($_GET['craftid']) &&is_numeric($_GET['craftid'])?intval($_GET['craftid']):0;
		$stmt = $db->prepare(" SELECT `craftsmen`.*,
									`user`.`User_Name`  AS `Craft_Name`,
									`user`.`user_avatar` AS `Craft_avatar`
							  	from `craftsmen`
								inner join `user` on `user`.`User_id` = `craftsmen`.`user_id`
								WHERE Craft_ID = ?");
		$stmt ->execute(array($craft));
		$row = $stmt ->fetch();
		$count = $stmt ->rowCount();
		if($count > 0){}
		?>
		<div class="container">
			<form action="?do=evaluate" method="POST">
				<h2 class="text-center">start to Evaluate the craft</h2>
				<input type="hidden" name ="craftingid" value="<?php echo $craft; ?>">
				<div class="rateyo"id ="rating" data-rateyo-rating="4"data-rateyo-num-stars="5" data-rateyo-score="3"></div>
				  <span class="result" style="display: block;">0</span>
				<input type="hidden" name="rating">
				<div class="form-group">
				    <label for="inputEmail3" class="col-sm-2 control-label">CraftName</label>
				    <div class="col-sm-10 col-md-7">
				      <input type="text" class="form-control"  name="craftnames" disabled
				        required="required" value="<?php echo $row['Craft_Name'];?>">
				    </div>
				</div>
				<button class="btn btn-success">save</button>
			</form>	
		</div>	

	<?php	


	}elseif($do == 'evaluate'){
		//start to submt evaluate to database

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$craftid   = $_POST['craftingid'];
			$rate      = $_POST['rating'];

			//insert the rate to database
			$stmt = $db->prepare('INSERT INTO `rating`(`craft_id`,`rate_num`)
									VALUES (:zcraftid,:zrate) ');
			$test = $stmt->execute(array(
				'zcraftid'   => $craftid,
				'zrate'      => $rate));
			if($test){
				echo "<div class='container'>";
			$message = "<div class='alert alert-info'> rate added successfuly </div>";
			redirectHome($message);
			echo "</div>";
			}else{
				echo "<div class='alert alert-danger'> rate Not added there are error </div>";
			}

		}
	}
}else{
	header("location:index.php");
	exit();
}
include($tpl."footer.php");
ob_end_flush();		