<?php  //signin page
ob_start();
session_start();


if(isset($_SESSION['useremail'])){

    header("location:index.php");
    exit();
}
include("admin-controler/connection.php");
include("Include/functions/function.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){

    //avatar info
    $avatarName = $_FILES['avatar']['name'];
    $avatarSize = $_FILES['avatar']['size'];
    $avatartmp  = $_FILES['avatar']['tmp_name'];
    $avatartype = $_FILES['avatar']['type'];

    //avatar type extensions
    $avatarallowextensions = array("jpeg","jpg","png","gif");
    //to take the extensions from avatar name
    $avatarextensions = strtolower(end(explode(".", $avatarName))); 

    $firstname  = $_POST['firstname'];
    $lastname   = $_POST['lastname'];
    $Email      = $_POST['newemail'];
    $password1  = $_POST['password1'];
    $password2  = $_POST['password2'];
    $Address    = $_POST['Address'];
    
    

    //array for input errors

    $formerrors = array();
    if(isset($firstname)) {
        $filterfirstname = filter_var($firstname,FILTER_SANITIZE_STRING);
        if(strlen($filterfirstname) < 3){
            $formerrors []  = " firstname must be larger than 3 characters  ";
        }
    }  
    if(isset($lastname)) {
        $filterlastname = filter_var($lastname,FILTER_SANITIZE_STRING);
        if(strlen($filterlastname) < 3){
            $formerrors []  = " lastname must be larger than 3 characters  ";
        }
    }
    if(isset($Address)) {
        $filterAddress = filter_var($Address,FILTER_SANITIZE_STRING);
        if(strlen($filterAddress) < 5){
            $formerrors []  = " Address must be larger than 5 characters  ";
        }
    }
    if(isset($Email)){
        $filteremail = filter_var($Email,FILTER_SANITIZE_EMAIL);
        if(filter_var($filteremail,FILTER_VALIDATE_EMAIL) !=TRUE){
            $formerrors [] = 'Sorry Your Email Not Valid';
        }
    }
    if(isset($password1) && isset($password2)){

        if(empty($password1)){
            $formerrors [] = 'Sorry Password must be written';
        }

        $pass1 = sha1($password1);
        $pass2 = sha1($password2);
        if($pass1 !== $pass2){
            $formerrors [] = "Your password1 Not Equel password2";
        }
    }
    if(!empty($avatarName) && !in_array($avatarextensions, $avatarallowextensions)){
        $formerrors[] = "<div class ='alert alert-danger'><strong>Image</strong> Must Be Uploaded</div>";
    }
    // size to upload 4MB = 4*1024*1024
    if(isset($avatarSize) > 4194304){
        $formerrors [] = "<div class='alert alert-danger'><strong> image size </strong> Must be 4MB Or Lower not larger</div>";
    }
    if(empty($avatarName)){
        $formerrors[] = "Avater must be uploaded";
    }
    foreach($formerrors as $errors){
        echo "<div class='container'>";
            echo "<div class='alert alert-danger '>".$errors."</div>";
        echo "</div>";
    }
    if(empty($formerrors)){

        //to make every avatar name has a name diffren than others
        $avatar = rand(0,10000)."_".$avatarName;
        //to save every image on this destination 
        move_uploaded_file($avatartmp,"admin-controler\upload\\".$avatar);

        $check = checkItem("user_email","user",$Email);
            if($check == 1){
                
                echo"<div class='alert alert-info '>Please choose another email this email are exist </div>";
            }else{  

                //insert new members
                $stmt = $db->prepare("INSERT    INTO `user`(`User_Name`,`Full_name`,`user_email`,
                                                                `user_password`,`date`,`Reg_status`,
                                                                `user_Address`,`conditions`,`user_avatar`) 
                                                VALUES
                                                        (:zname,:zfullname,:zemail,:zpassword,
                                                           now(),0,:zaddress,1,:zavatar)");
                $stmt->execute(array(

                    "zname"     =>  $firstname,
                    "zfullname" =>  $lastname,
                    "zemail"    =>  $Email,
                    "zpassword" =>  $pass1,
                    "zaddress"  =>  $Address,
                    "zavatar"   =>  $avatar));
                echo "<div class='container text-center'>";
                    $messge = "<div class='alert alert-success'>Congertlate Signup is Done Successfuly<a href='signin.php'> click signin</div>";
                    echo $messge;
                echo "</div>";

                //to verify email
                $to      = $Email; // Send email to our user
                $subject = 'Signup | Verification'; // Give the email a subject 
                $message = "
                Thanks for signing up!
                Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
                 
                ------------------------
                Username: '.$firstname.'
                Password: '.$pass1.'
                ------------------------
                 
                Please click this link 
                 <a href='http://localhost/graduate/verify.php?newemail=".$Email."'></a>
                  to activate your account"; // Our message above including the link
                                     
                $headers = 'From:Craftsmen.com'. "\r\n"; // Set from headers
                mail($to, $subject, $message, $headers); // Send our email
                

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
                <a href="signin.php"  class="btnRegister">  login  </a> <br/> <br/>
            </div>
            <div class="col-md-9 register-right">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" 
                            aria-labelledby="home-tab">
                        <form  action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST"
                                 enctype="multipart/form-data">    
                            <div class="row register-form">
                                <div class="col-md-6">
                                        <div class="form-group">
                                         <input type="text" class="form-control" placeholder="Write your FirstName"
                                             required="required" name="firstname">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Write your LastName" 
                                                required="required" name="lastname">
                                         </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Write avalid email" 
                                                required="required" name="newemail">
                                        </div>
                                        <div class="form-group">
                                        <input type="password" class="form-control"  placeholder="Password"
                                            name="password1" required="required">
                                      </div> 
                                      <div class="form-group">
                                        <input type="password" class="form-control"  placeholder="Confirm your password"
                                            name="password2" required="required">
                                      </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <input type="text" class="form-control"  placeholder="Write your address"
                                        name="Address" required="required">
                                  </div>
                                  <div class="form-group">
                                        <input type="file" class="form-control" name="avatar" 
                                        required="required"placeholder="upload your avatar" required="required">
                                        
                                    </div>
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" required="required" name="check" >
                                            <button class="model"type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Conditions</button>
                                            <!-- Modal -->
                                        <div id="myModal" class="modal fade" role="dialog">
                                          <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button  type="button" class="close" data-dismiss="modal">&times;</button>
                                                <p class="modal-title">conditions</p>
                                              </div>
                                              <div class="modal-body">
                                                <p>this is our conditions .</p>
                                                <p>this is our conditions .</p>
                                                <p>this is our conditions .</p>
                                                <p>this is our conditions .</p>
                                                <p>this is our conditions .</p>
                                                <p>this is our conditions .</p>
                                                <p>this is our conditions .</p>
                                                <p>this is our conditions .</p>
                                                <p>this is our conditions .</p>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                    <i class="fas fa-times"></i>Close
                                                </button>
                                              </div>
                                            </div>

                                          </div>
                                        </div>
                                      </label>
                                    </div>
                                    <!--start submit-->
                                    <div class="form-group">
                                   <button type="submit" class="btn btn-primary"> Signup </button>
                                        
                                    </div>  
                                    <div class="link">Already have account.?  
                                        <a href="signin.php">Signin here.</a>
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