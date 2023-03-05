<?php  //signin page
ob_start();
session_start();

$pageName = "Signin";
if(isset($_SESSION['useremail'])){

	header("location:index.php");
	exit();
}
include("admin-controler/connection.php");
include("Include/functions/function.php");
if($_SERVER["REQUEST_METHOD"] == "POST"){

	$email    = $_POST['email'];
	$password = $_POST['password'];
	$hashpass = sha1($password);
	$name  = $_POST['name'];

	//form eror
	$formerrors = array();
	if(isset($email)){

		$emailfilter = filter_var($email,FILTER_SANITIZE_EMAIL);
		if(filter_var($emailfilter,FILTER_VALIDATE_EMAIL)  != TRUE){
			$formerrors[] = "<div class='alert alert-danger'>you must write a valide email </div>";
		}
	}
	if(empty($email)){
		$formerrors[]= "<div class='alert alert-danger'>Email must be written</div>";
	}
	if(empty($hashpass)){
		$formerrors[]= "<div class='alert alert-danger'>password must be written</div>";
	}
	
	if(empty($formerrors)){
			//fetch user info from database

			$stmt = $db->prepare(" SELECT 
											`User_id`,`user_email` ,`user_password`,`User_Name`
									FROM 
											`user`
									WHERE 	
											`user_email` = ?
									AND
											`user_password`= ?
									");
			$stmt->execute(array($email,$hashpass));
			$row = $stmt->fetch();
			$count = $stmt->rowCount();
			if($count > 0){

				$_SESSION['uid'] = $row['User_id'];	//to register user
				$_SESSION['name'] = $row['User_Name'];  // to print username
				$_SESSION['useremail'] = $email;
				header("location:index.php");//move user to main page.
				exit();

			}else{

				echo '<div class="alert alert-danger">Your Password Or Email Does Not Match</div>';
			}
	}else{
	
		foreach($formerrors as $formerror){
		echo "<div class ='container'>";
					echo $formerror;

		 echo "</div>";
	}
	}
}


?>

<!DOCTYPE HTML>
<html>
<head>
<title>register</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="http://localhost/graduate/layout/css/signin/css/style.css" />
<link rel="stylesheet" href="http://localhost/graduate/layout/css/signin/css/bootstrap.min.css" >
<script src="http://localhost/graduate/layout/js/jquery-3.4.1.min.js"></script>
<script src="http://localhost/graduate/layout/js/signup/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://localhost/graduate/layout/js/signup/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://localhost/graduate/layout/js/main.js"></script>
<script type="text/javascript" src="http://localhost/graduate/layout/js/signup/js/JFCore.js"></script>
</head>
<body>
<div class="wrap">
	<div class="container register">
		<div class="row">
			<div class="col-md-3 register-left">
			   
				
			   <a href="signup.php"  class="btnRegister"> register  </a> <br/> <br/>
			</div>
			<div class="col-md-9 register-right">
				
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
						<form class="login" action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
							<div class="row register-form">
								<div class="col-md-6">
									<div class="form-group">
										<input class="form-control" type="email" name="email" required="required" placeholder="Write avalid email "autocomplete="off">
									</div>
									<div class="form-group">
										<input class="form-control" type="password" name="password" 		placeholder="write your - password" required="required"  		autocomplete="new-password">
									</div>		
									<input type="hidden" name="name" >			
								</div>
								<div class="col-md-6">
									<input  class="btn btn-primary btn-block submit" name="login" type="submit" value="Login">
									<div class="link">Don't have account?  
										<a href="signup.php">creat New account</a>
									</div> 
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>	
<?php
ob_end_flush();