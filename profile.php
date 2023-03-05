<?php
ob_start();
session_start();
$pageName="My Profile";
if(isset($_SESSION['useremail'])){
	include("init.php");
	//pring data from database to show on profile page
	  $getUser = $db->prepare("SELECT * FROM `user` WHERE `User_id` = ?");
      $getUser -> execute(array($_SESSION['uid']));
      $Info = $getUser->fetch();
	?>
<div class="container emp-profile">
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/data-form">
        <div class="row">
            <div class="col-md-4">
                <div class="profile-img">
                	<?php
                		echo '<img src="admin-controler/upload/'.$Info['user_avatar'].'" alt="Your Photo">';
                	?>
                    <div class="file btn btn-lg btn-primary">
                        <a href="editimgprofile.php?do=Edit&imgid<?php echo $_SESSION["uid"];?>">Change Photo</a>
                        
                    </div>
                 
                  
                </div>
            </div>
            <div class="col-md-6">
                <div class="profile-head">
                	<?php
	                    echo '<h5>';
	                        echo $Info['User_Name'].' '.$Info['Full_name'];
	                    echo '</h5>';
	                    echo '<h6>';
	                        echo 'Register Date : '.$Info['date'];
	                   echo  '</h6>';
                    ?>
                </div>
            </div>
            <div class="col-md-2">
               <a href='editprofile.php?do=Edit&userid=<?php echo $_SESSION["uid"]?>'class="btn btn-default profile-button">Edit Profile </a>
            </div>
           <div class="col-md-8">
           	<div class="information">
           		<div class="panel panel-primary">
	                <div class="panel panel-heading text-center">My Information</div>
	                <div class="panel panel-body">
	                    <ul class="list-unstyled">
	                      <li>
	                        <i class="fa fa-user fa-fw"></i>
	                        <span> Name </span>: <?php echo $Info['User_Name'];?> 
	                      </li>
	                      <li>
	                        <i class="fas fa-envelope"></i>
	                        <span>Email</span> : <?php echo $Info['user_email'];?>
	                       </li>
	                      <li>
	                        <i class="fa fa-user fa-fw"></i>
	                        <span>Full Name</span> : <?php echo $Info['Full_name'];?>
	                       </li>
	                      <li>
	                        <i class="fas fa-business-time"></i>
	                        <span>Register Date </span>: <?php echo $Info['date'];?> 
	                      </li>
	                      <li>
	                        <i class="fas fa-map-marker-alt"></i>
	                        <span>Address  </span> : <?php echo $Info['user_Address'];?>
	                      </li>
	                    </ul>
	                </div>
             	</div>
            </div> 	
           	</div>
           </form>
           </div>
           	<?php
           	  $craftid = isset($_GEt['cid']) && intval($_GEt['uid'])?$_GEt['cid']:0;
			  $stmt = $db->prepare("SELECT `craftsmen`.*,
			                              `categories`.`Cat_Name` AS `Catname`
			                         from `craftsmen`
			                        inner join `categories` on `categories`.`Cat_id` = `craftsmen`.`cat_id`
			                        WHERE `user_id` = ?");
			  $stmt->execute(array($_SESSION['uid']));
			  $rows = $stmt->fetchAll();
			  $count = $stmt->rowCount();
			  if($count > 0){

			  	//fetch craftsmen informations
			  		foreach($rows as $row){?>
			  			<div class="col-md-4">
			                <div class="profile-img">
			                	<img src="layout/img/craft.jpg" >
			                </div>
			            </div>
						<div class="col-md-8">
			           	<div class="information">
			           		<div class="panel panel-primary">
				                <div class="panel panel-heading text-center">
				                	Craftsmen Information
				            	</div>
				                <div class="panel panel-body">
				                    <ul class="list-unstyled">
				                      <li>
				                        <i class="fa fa-unlock-alt fa-fw"></i>
				                        <span>Crafting Name </span>: <?php echo $row['Crafting_name'];?> 
				                      </li>
				                      <li>
				                        <i class="fas fa-pencil-ruler"></i>
				                        <span>Description</span> : <?php echo $row['Craft_description'];?>
				                       </li>
				                      <li>
				                        <i class="fa fa-user fa-fw"></i>
				                        <span>Age</span> : <?php echo $row['Craft_age'];?>
				                       </li>
				                      <li>
				                        <i class="fas fa-phone-square-alt"></i>
				                        <span>Phone</span>: <?php echo $row['Craft_Phone'];?> 
				                      </li>
				                      <li>
				                        <i class="fa fa-tags fa-fw"></i>
				                        <span>Category </span> : <?php echo $row['Catname'];?>
				                      </li>
				                      <li>
				                        <i class="fas fa-star"></i>
				                        <span>Last 3 Rate </span> :
				                         <?php
				                          $rate = $db->prepare("SELECT DISTINCT `rating`.`rate_num`												,rating.*   		FROM `rating`
		 											Where `craft_id` = ?
		 											ORDER BY `rate_id` DESC LIMIT 3 ");
					 						$rate->execute(array($row['Craft_ID']));
					 						$fetch = $rate->fetchAll();
		 						
				 							foreach($fetch as $ratecraft){
				 								echo $ratecraft['rate_num'];
				 							}
				                         ?>
				                      </li>
				                    </ul>
									<a href='editcraftprofile.php?do=Edit&craftid=<?php echo $row['Craft_ID']?>'class="btn btn-default profile-button">Edit Craft</a>
				                </div>
			             	</div>
			            </div> 	
			           	</div>
			  <?php	
			 	 }
			  }
			  	
			   
           	?>	
                
</div>
	<?php

}else{
	header("location:index.php");
	exit();
}


include($tpl."footer.php");
ob_end_flush();	