<?php
ob_start();
session_start();
$pageName="Sanitary ware";
include("init.php");
?>
<div class="container">
	<div class="row sant">
		<?php
			$stmt = $db->prepare("SELECT * FROM `craftsmen` WHERE `cat_id` = 6 ");
			$stmt->execute();
			$fetchs = $stmt->fetchAll();
			foreach($fetchs as $fetch){
				?>
				<div class='col-md-4 col-sm-6 '>
					<div class="card" >
					  <img class="img-fluid" alt="Responsive image" src="layout/img/san.jpg" alt="Card image cap" width="300px">
					  <div class="card-body">
						    <h5 class="card-title">
						    	<span>Crafting : </span><?php echo $fetch['Crafting_name'];?>
							</h5>
						    <p class="card-text">
						    <span> Description : </span> <?php echo $fetch['Craft_description'];?></p>
					  </div>
					</div>
				</div>	
				<?php
			}
		?>
	</div>	
</div>	
<?php
include($tpl."footer.php");
ob_end_flush();	