<?php

include 'include/configLi.php'; 
include 'inc-url.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>E-leave - <?php echo $objRst_url['comp']; ?></title>
	<link rel="ICON" href="img/ingress.ico" type="image/ico" /><meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="flogin/assets/css/login.css">
	
	<style>
	Errorm
	{
		/*background-color:#CC0000;*/
		top : 10px;
		font-size :13px;
		color:#FF0000;
		/*height:40px;*/
	}
	</style>

</head>
<body>

<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

//server setting for email
include "inc-server-email-settings.php";

//email notification subject
include "inc-notification.php";
?>

<?php
//FUNCTION RETAIN TEXTBOX VALUE
function prepopulate($name) 
{ 
	if(isset($_POST[$name])) 
	{ 
		return $_POST[$name]; 
	} 
	else 
	{ 
		return ""; 
	} 
} 
?>

<?php 

$msg = "";
$msgNO = "";
$msgMT = "";
$msgIV = "";

if(isset($_POST['save']))
{
	
	// create a function for escaping the data.
	function escape_data($data) 
	{
		global $conn;   // need the connection.
		
		if(ini_get('magic_quotes_gpc')) 
		{
    		$data = stripslashes($data);
		}
		return mysqli_real_escape_string($eleaveDb,$data);
	}   // end function.
	$message = NULL; // create an empty new variable.
	
	
	$user_name = mysqli_real_escape_string($eleaveDb,$_POST['username']);
	$email = $_POST['email'];
	
	  
	// check for existence of that username
    if($user_name != "" && $email != "") 
	{ 
		
		$query = "SELECT * FROM login as l,staff as s WHERE l.st_id = s.st_id and l.username = '".sql_esc($user_name)."' ";
		$result = mysqli_query($eleaveDb,$query);
		$num = mysqli_num_rows($result);
		   
		if($num == 1) 
		{
			$row = mysqli_fetch_array($result);
		
			//URL
			$sql_URL = "SELECT * FROM url WHERE id = '1'";
			$rst_URL = mysqli_query($eleaveDb,$sql_URL);
			$row_URL = mysqli_fetch_array($rst_URL);
		
			//STAFF
			$name = "SELECT * FROM staff WHERE st_id = '".sql_esc($user_name)."'";
			$rst_name = mysqli_query($eleaveDb,$name);
			$row_name = mysqli_fetch_array($rst_name);
			
			$Uname = $row_name['name'];
			$Wdesc = $rowstemail['web'];
			$Uurl = $row_URL['url'];
	
	
			if(($row['email'] == "") or ($row['email'] == "NULL"))
			{ 
				$msgNO = '<Errorm>';
				$msgNO .= "User don't have an e-mail account. Please create an e-mail account for this user.</br>";
				$msgNO .= '</Errorm>';
			}
			elseif($row['email'] != $email)
			{
				$msgMT = '<Errorm>';
				$msgMT .= "Your email do not match with registered email.<br/>";
				$msgMT .= '</Errorm>';
			}
			else
			{
				
				//generate random pass n hash
				$sbstr = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 10 );
				$pPwd = base64_encode($sbstr);
				
				//reset new password
				$query2 = "UPDATE login set password = '".sql_esc($pPwd)."' where username = '".sql_esc($user_name)."'";
				$result2 = mysqli_query($eleaveDb,$query2);
				
				//--------------------------------------------------------
				//body message
				$message = file_get_contents('fgot-pswd0.html'); 
				
				//name
				$message = str_replace('%uname%', $Uname, $message); 
				//web desc
				$message = str_replace('%wdesc%', $Wdesc, $message); 
				//new psword
				$message = str_replace('%tmpasword%', $sbstr, $message); 
				//url
				$message = str_replace('%uurl%', $Uurl, $message); 
				
		
					
				//PHPMailer Object
				$mail = new PHPMailer(); //Argument true in constructor enables exceptions
			
				//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
				$mail->isSMTP();
				$mail->Host       = $rowstemail['host'];              		// Set the SMTP server to send through
				$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
				$mail->Username   = $rowstemail['username'];         		// SMTP username
				$mail->Password   = $rowstemail['password'];                // SMTP password
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
				$mail->Port       = $rowstemail['port'];

				$mail->From = $rowstemail['username'];
				$mail->FromName = $rowstemail['web'];
				
				//To address and name
				$mail->addAddress($email, $row_name['web']);
				
				//Send HTML or Plain Text email
				$mail->isHTML(true);
			
				$mail->Subject = "Temporary Password for E-leave";
				$mail->MsgHTML($message);
				
				
				$mail->CharSet="utf-8";
				
				//send the mail
				$mail->send();

				$msg = "<script language='JavaScript'>alert('Your new password is successfully send to your email.');window.location='index.php';</script>";
				//-----------------------------------------------

			
			}
			
		}
		else
		{
			$msgIV = '<Errorm>';
			$msgIV .= "Invalid username entered.</br>";
			$msgIV .= '</Errorm>';
		}

		
	}	
				 
}  //End of the main Submit conditional

echo $msg;
	  
?>

  <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
    <div class="container">
      <div class="card login-card">
        <div class="row no-gutters">
          <div class="col-md-7">
            <img src="flogin/icon/back4.jpg" alt="login" class="login-card-img">
          </div>
          <div class="col-md-5">
            <div class="card-body">
              <div class="brand-wrapper">
                <img src="img/logo.jpeg" alt="logo" class="logo">
              </div>
              <p class="login-card-description">Forgot Password</p>
              <form action="" method = "post">
				 <div class="form-group">
                    <label for="email" class="sr-only">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?php echo prepopulate('username');?>" required>
					<?php echo $msgIV; ?>
				  </div>
				  
                  <div class="form-group">
                    <label for="email" class="sr-only">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="<?php echo prepopulate('email');?>" required>
					<?php echo $msgNO; ?> <?php echo $msgMT; ?>   
                  </div>
                  
                  <input type="submit" name="save" id="save" class="btn btn-block login-btn mb-4" type="button" value="Submit">
				  
                </form>
				
                <a href="index.php" class="forgot-password-link">Login</a>
                <!--<p class="login-card-footer-text">Don't have an account? <a href="#!" class="text-reset">Register here</a></p>-->
                <!--<nav class="login-card-footer-nav">
                  <a href="#!">Terms of use.</a>
                  <a href="#!">Privacy policy</a>-->
                </nav>
            </div>
          </div>
        </div>
      </div>
      <!-- <div class="card login-card">
        <img src="assets/images/login.jpg" alt="login" class="login-card-img">
        <div class="card-body">
          <h2 class="login-card-title">Login</h2>
          <p class="login-card-description">Sign in to your account to continue.</p>
          <form action="#!">
            <div class="form-group">
              <label for="email" class="sr-only">Email</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Email">
            </div>
            <div class="form-group">
              <label for="password" class="sr-only">Password</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Password">
            </div>
            <div class="form-prompt-wrapper">
              <div class="custom-control custom-checkbox login-card-check-box">
                <input type="checkbox" class="custom-control-input" id="customCheck1">
                <label class="custom-control-label" for="customCheck1">Remember me</label>
              </div>              
              <a href="#!" class="text-reset">Forgot password?</a>
            </div>
            <input name="login" id="login" class="btn btn-block login-btn mb-4" type="button" value="Login">
          </form>
          <p class="login-card-footer-text">Don't have an account? <a href="#!" class="text-reset">Register here</a></p>
        </div>
      </div> -->
    </div>
  </main>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
