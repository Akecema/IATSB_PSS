<?php
include 'cGhzvxff/config.php';
//include 'cGhzvxff/config_mail.php';


$today = getdate();
$hours = $today['hours']; 
$minutes = $today['minutes'];
$seconds = $today['seconds'];
$month = $today['mon']; 
$mday = $today['mday']; 
$year = $today['year']; 

$stas = "AC";
//--------setup website page --------------------------

$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system=?"; // SQL with parameters
$rs_setup = $dbc->prepare($query_setup); 
$rs_setup->bind_param("s", $stas);
$rs_setup->execute();
$result = $rs_setup->get_result(); // get the mysqli result
$data_setup = $result->fetch_assoc(); // fetch data   

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title><?php echo html_esc($data_setup["title_desc"]); ?></title>

<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
.style2 {
	color: #000066;
	font-weight: bold;
}
.style4 {font-size: 12px}
.style6 {font-size: 12px}
-->
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
//include "inc-server-email-settings.php";

//email notification subject
//include "inc-notification.php";
?>

 <?php 

// make the query.
// reset password
if(isset($_POST['submit2']))
{

// create a function for escaping the data.
function escape_data($data) {
global $dbc;   // need the connection.
if(ini_get('magic_quotes_gpc')) {
    $data = stripslashes($data);
	}
	return mysqli_real_escape_string($data,$dbc);
	}   // end function.
	
$message = NULL; // create an empty new variable.
	
	$user_name =  $_POST['user_name'];
	$email =  $_POST['email'];
	
    //check for a username
    if(empty($_POST['user_name'])) 
       { $user_name = FALSE;
	     $message .= 'You forgot to enter your username!';
           }
    
      else {
	      $user_name = addslashes($_POST['user_name']);
      }
	  
	  if(empty($_POST['email'])) 
       { $email = FALSE;
	     $message .= 'You forgot to enter your email!';
           }
    
      else {
	      $email = addslashes($_POST['email']);
      }
	  
// check for existence of that username
    if($user_name && $email) { 
	
	$user_name =  $_POST['user_name'];
	$email =  $_POST['email'];


	$query3 = "SELECT * FROM user_detail WHERE username=? AND user_email= ?"; // SQL with parameters
	$result3 = $dbc->prepare($query3); 
	$result3->bind_param("ss", $user_name,$email);
	//$result3->execute();

	
	
	if($result3->execute()){  
	
	$rst_rcord2 = $result3->get_result(); // get the mysqli result
	$row = $rst_rcord2->fetch_array();
	
	$created = date("Y:m:d h:i:s");			

					
					 $p = bin2hex(random_bytes(5));
					 $p2 = password_hash($p, PASSWORD_DEFAULT);
					 
					 $Uname = $row['user_fullname'];
			         $Wdesc = $data_setup['tajuk_sys'];
			         $Uurl = $data_setup['urls_system'];
					 
					 $resultA2= $dbc->prepare("UPDATE user_detail SET password =?, user_update =?, date_update =? 
					 WHERE username = ? AND user_email=?");
					 $resultA2->bind_param("sssss",$p2,$row["username"],$created,$user_name,$email);
					 $resultA2->execute();


                     $result_login = $dbc->prepare("UPDATE login_detail SET password =?, user_update =?, date_update =? 
					 WHERE username = ? AND user_email=?");
					 $result_login->bind_param("sssss",$p2,$row["username"],$created,$user_name,$email);
					 $result_login->execute();
					 
			
			      if(($row["user_email"] == "") or ($row["user_email"] == "NULL"))
				  { 
					echo "<script>";
					echo "alert('User don't have the e-mail account. Please create e-mail account for this user');";
					echo "window.location='index.php'";
					echo "</script>";
					//exit(); //quit the script


				  // echo "User don't have the e-mail account. Please create e-mail account for this user.";

				    }else{ //If it ran ok
					
     	  
				//----send e-mail of reset password --------------
				
				
				//--------------------------------------------------------
				//body message
				$message = file_get_contents('fgot-pswd0.html'); 
				
				//name
				$message = str_replace('%uname%', $Uname, $message); 
				//web desc
				$message = str_replace('%wdesc%', $Wdesc, $message); 
				//new psword
				$message = str_replace('%tmpasword%', $p, $message); 
				//url
				$message = str_replace('%uurl%', $Uurl, $message); 
				
		
					
				//PHPMailer Object
				$mail = new PHPMailer(); //Argument true in constructor enables exceptions
			
				//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
				$mail->isSMTP();
				$mail->Host       = $data_setup['smtp_account'];              		// Set the SMTP server to send through
				$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
				$mail->Username   = $data_setup['email_account'];         		// SMTP username
				$mail->Password   = $data_setup['passwd'];                // SMTP password
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
				$mail->Port       = $data_setup['port_no'];

				$mail->From = $data_setup['email_account'];
				$mail->FromName = $data_setup['tajuk_sys'];
				
				//To address and name
				$mail->addAddress($email, $row["user_email"]);
				
				//Send HTML or Plain Text email
				$mail->isHTML(true);
			
				$mail->Subject = "Temporary Password for PSS IATSB Online";
				$mail->MsgHTML($message);
				
				
				$mail->CharSet="utf-8";
				
				//send the mail
				$mail->send();


		   
			echo "<script>";
			echo "alert('Your new password has been send to your email. We recommend you to print the e-mail for your reference.');";
			echo "window.location='index.php'";
			echo "</script>";
			exit(); //quit the script
					
					
					
				   }  //end else
			
			echo "<script>";
			echo "alert('Your username and password do not match our database');";
		    echo "window.location='index.php'";
			echo "</script>";
			exit(); //quit the script
				   
				  
				}
					 
		    echo "<script>";
			echo "alert('Your username or password do not match our database');";
		    echo "window.location='index.php'";
			echo "</script>";
			exit(); //quit the script
				
			}	 
			
				// mysqli_close($dbc);    //Close the database connection
				 
		  //Print error 
		  if(isset($message)) {
			  
			  
		    echo "<script>";
			echo "alert('$message');";
		    echo "window.location='index.php'";
			echo "</script>";
			exit(); //quit the script
				    

	    }  
	            
	  }  //End of the main Submit conditional
	  
	  ?>


</body>
</html>