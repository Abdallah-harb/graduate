<?php
ob_start();
session_start();
$pageName="Chat Room";
if(isset($_SESSION['useremail'])){
	include("init.php");
?>
	<div class="container">
		<div class="col-md-6 logocaht">
			<img src="layout/img/room.png">
		</div>
		<div class="col-md-6 chat">
			<div class="message">
			<?php
				$stmt = $db->prepare("SELECT * FROM `chatroom`");
				$stmt->execute();
				$rows = $stmt->fetchAll();
				if(!empty($rows)){

					foreach($rows as $row){

						 echo "<h4>".$row['user_name']."</h4>"; 
						 echo "<p>".$row['message_content']."</p>";
					}
				}else{
					echo "<div class='alert alert-info'>Type message to contact</div> ";
				}

				if($_SERVER["REQUEST_METHOD"]== 'POST'){

					$message = $_POST['message'];
					$stmt = $db->prepare("INSERT INTO `chatroom` (`message_content`,`user_name`)
													VALUES (:zmessage,:zname)");
					$stmt ->execute(array(

						"zmessage"  => $message,
						"zname"     => $_SESSION['name']));
					
						echo "<h4>".$_SESSION['name']."</h4>";
						echo "<p>".$message."<p>";
				}	
			?>
			</div>
			
			<form class="start_chat" method="POST" action="<?php  echo $_SERVER["PHP_SELF"];?>">
				<input type="message" name="message" class="messageval" placeholder="Type Your message" autocomplete="off">
				<input type="submit" name="submit" calss="messagesend" value="Send">
			</form>	

		</div>
	</div>

<?php	
	

}else{
	header("location:index.php");
	exit();
}


include($tpl."footer.php");
ob_end_flush();	