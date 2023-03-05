<?php
ob_start(); //to prevent default error
session_start();
$navbar= "";
$pageName="admin login"; 
include("init.php");
if(isset($_SESSION['Admin_Email'])){
	header("location:dashbord.php");
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$Email    	  = $_POST['email'];
	$Name    	  = $_POST['adminname'];
	$Password 	  = $_POST['password'];
	$hashpassword = sha1($Password);

	$stmt= $db->prepare("SELECT
							 `user_email`,`User_Name`,`user_password`,`User_id`
						FROM 
							 `user`

						WHERE 
							 `user_email` = ?
						AND 
						    `user_password` = ?	 
						AND 
						    `Reg_status` = '1'
						limit 1");
	$stmt->execute(array($Email,$hashpassword));
	//fetch data from database
	$fetch = $stmt->fetch();
	$count =$stmt->rowCount();
	if($count > 0){
		//make session and move him direct to dashbord page
		$_SESSION['Admin_Email'] = $Email;
		$_SESSION['adminname']   = $fetch['User_Name'];
		$_SESSION['id']          = $fetch['User_id'];
		header("location:dashbord.php");
	}else{
		echo "<div class='alert alert-danger text-center'>Sory this page for admin only | Or the email or password for admin are incorrect</div>";
	}

}
?>

<form class="login"action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
	<h2 class="text-center"> Admin Login</h2>
  <div class="form-group">
    <label for="exampleInputEmail1">Email</label>
    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email"
   		required="required" name="email">
  </div>
    <div class="form-group">
 
    <input type="hidden" name="adminname" >
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
    	required="required" name="password">
  </div>
  <button type="submit" class="btn btn-success">Login</button>
</form>
<?php
include($tpl."footer.php");
ob_end_flush();
?>