<?php
ob_start();
session_start();
$pageName="Contact US";
if(isset($_SESSION['useremail'])){
	include("init.php");
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$Name      = $_POST['name'];
		$Email     = $_POST['email'];
		$Subjectm  = $_POST['subject'];
		$TExtarea  = $_POST['message'];

		$formerrors = array();
		if(isset($Name)) {
       		 $filterfirstname = filter_var($Name,FILTER_SANITIZE_STRING);
        	if(strlen($filterfirstname) < 3){
          	  $formerrors []  = " name must be larger than 3 characters  ";
       		 }
    	} 
    	if(isset($Subjectm)) {
       		 $filterSubjectm = filter_var($Subjectm,FILTER_SANITIZE_STRING);
        	if(strlen($filterSubjectm) < 4){
          	  $formerrors []  = " Subject must be larger than 4 characters  ";
       		 }
    	}
    	 if(isset($Email)){
	        $filteremail = filter_var($Email,FILTER_SANITIZE_EMAIL);
	        if(filter_var($filteremail,FILTER_VALIDATE_EMAIL) !=TRUE){
	            $formerrors [] = 'Sorry Your Email Not Valid';
	        }
    	}
    	if(isset($TExtarea)) {
       		 $filterTExtarea = filter_var($TExtarea,FILTER_SANITIZE_STRING);
        	if(strlen($filterTExtarea) < 10){
          	  $formerrors []  = " Message must be larger than 10 characters  ";
       		 }
    	}
    	
    	if(empty($formerrors)){
    		//send message
    		$header = 'From : ' . $Name . "<br>". 'Email : '.$Email. "\r\n";
    		  mail('abdallahabdelrahman186@gmail.com', $Subjectm, $TExtarea, $header); // Send our email
    		
    			echo "<div class='container'>";
					echo "<div class='alert alert-info'>Message send successfuly </div>";
				
				echo "</div>";
    		

    	}else{
    		//show error 
    		foreach($formerrors as $errors){
		        echo "<div class='container'>";
		            echo "<div class='alert alert-danger '>".$errors."</div>";
		        echo "</div>";
    		}
    	}
		//send message 
		$to  = 'abdallahabdelrahman186@gmail.com'; 
        $subject = $Subjectm; 
        $message = $TExtarea; // Our message above including the link
                             
        $headers = 'From:Craftsmen.com'. "\r\n"; // Set from headers
       
	}
?>
<!-- container -->
<div class="container">

	<!-- row -->
	<div class="row contactus">

		<!-- contact form -->
		<div class="col-md-6">
			<div class="contact-form">
				<h4>Send A Message</h4>
				<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
					<div class="form-group">
						<input class="input" type="text" name="name"
						 placeholder="Your Name"required="required">
					</div>
					<div class="form-group">
						<input class="input" type="email" name="email"
						 placeholder=" write Your Email" required="required">
					</div>
					<div class="form-group">
						<input class="input" type="text" name="subject"
						 placeholder="Subject Or Problem To Send ">
					</div>
					<div class="form-group">
						<textarea class="input" name="message" placeholder="Enter your Message"></textarea>
					</div>
					<button class="main-button " type="submit">Send Message
					</button>
				</form>
			</div>
		</div>
		<!-- /contact form -->

		<!-- contact information -->
		<div class="col-md-5">
			<h4>Contact Information</h4>
			<ul class="contact-details">
				<li><i class="fa fa-envelope"></i>Educate@email.com</li>
				<li><i class="fa fa-phone"></i>122-547-223-45</li>
				<li><i class="fab fa-facebook-square"></i><a href="">Facebook</a></li>
				<li><i class="fab fa-twitter"></i><a href="">Twitter</a></li>
			</ul>

		</div>
		<!-- contact information -->

	</div>
	<!-- /row -->

</div>
<!-- /container -->
<?php	

}else{
	header("location:index.php");
	exit();
}


include($tpl."footer.php");
ob_end_flush();	