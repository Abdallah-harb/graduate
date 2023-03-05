<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo title();?></title>
	<link rel="stylesheet" href="http://localhost/graduate/layout/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://localhost/graduate/layout/css/jquery.rateyo.min.css">
	<link rel="stylesheet" href="http://localhost/graduate/layout/css/normalize.css">
	<link rel="stylesheet" href="http://localhost/graduate/layout/css/style.css">

</head>
<body>
	<nav class="navbar navbar-inverse">
	  <div class="container">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="index.php"><i class="fas fa-home"></i>Home</a>
	    </div>
	    <div class="collapse navbar-collapse" id="app-nav">
	      <ul class="nav navbar-nav">
	         <li class="dropdown">
	          <a href="Categories.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-tag"></i>Categories <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	          	<li><a href="Sanitaryware.php">Sanitary ware</a></li>
	          	<li><a href="Paints.php">Paints</a></li>
	          	<li><a href="Furniture.php">Furniture</a></li>
	          	<li><a href="ElectricianTechnicals.php">Electrician Technicals</a></li>
	          	<li><a href="carstechnicals.php">cars technicals</a></li>
	          
	          </ul>	
	        </li>
	        <?php
	        if(isset($_SESSION['useremail'])){
	       	 echo '<li><a href="chat.php"><i class="fas fa-comments"></i> Chat Room</a></li>';
	       	 $stnt = $db->prepare('SELECT * FROM `craftsmen` WHERE `user_id` = ?');
	       	 $stnt->execute(array($_SESSION['uid']));
	       	 $count = $stnt->rowCount();
		       	 if($stnt->rowCount() <= 0){
		       	 		echo '<li><a href="evaluationtable.php"><i class="fas fa-star"></i>Evalute craft</a></li>';
		       	 }
	       	}
	        ?>
	      
	      </ul>
	     
		      <ul class="nav navbar-nav navbar-right">
		      	 <?php 
	      		if(isset($_SESSION['useremail'])){?>
			        <li class="dropdown ">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['name'];?> <span class="caret"></span></a>
			          <ul class="dropdown-menu">
			            <li>
			              <a href="profile.php"><i class="fas fa-user-circle"></i>My profile</a></li>
			            <li><a href='editprofile.php?do=Edit&userid=<?php echo $_SESSION["uid"]?>'>
			            <i class="fas fa-user-edit"></i>Edit Profile</a></li>
			            <?php
			            $craft = $db->prepare('SELECT * FROM `craftsmen` WHERE `user_id` = ?');
				       	 $craft->execute(array($_SESSION['uid']));
				       	 $countdata = $craft->rowCount();
				       	 if( $countdata <= 0 ){
				       	 	echo '<li><a href="tobecraft.php"><i class="fas fa-hammer"></i>To be Craftsmen</a></li>';
				       	 }
			            
			            ?>
			            <li role="separator" class="divider"></li>
			            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>logout</a></li>
			          </ul>
			        </li>
		        <?php
				}else{
					echo "<li>";
						echo '<a href="signin.php"> Signin</a>';
					echo "</li>";	
				}
		   		 ?>
		      </ul>
		      
	    </div>
	  </div>
	</nav>

	<!-- start button scroll top-->
		<a href="#" id="scroll" style="display: none;"><span></span></a>
	<!-- End button scroll top-->