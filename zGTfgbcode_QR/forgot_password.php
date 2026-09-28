<?php
include 'include/config.php';
//include 'include/config_mail.php';


$today = getdate();
$hours = $today['hours']; 
$minutes = $today['minutes'];
$seconds = $today['seconds'];
$month = $today['mon']; 
$mday = $today['mday']; 
$year = $today['year']; 

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------
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
	
	       $query = "SELECT * FROM user_detail WHERE username = '".sql_esc($user_name)."' and user_email= '".sql_esc($email)."'";
		   $result = mysqli_query($dbc,$query);
		   $num = mysqli_num_rows($result);
		   
				  if($num == 1) {
				    $row = mysqli_fetch_array($result);
					
					 $p = bin2hex(random_bytes(5));
					 $p2 = password_hash($p, PASSWORD_DEFAULT);
					 
					 $Uname = $row['user_fullname'];
			         $Wdesc = $data_setup['tajuk_sys'];
			         $Uurl = $data_setup['urls_system'];
					 
					 	
				  $query2 = "UPDATE user_detail set password = '".sql_esc($p2)."', user_update = '".sql_esc($row["username"])."', date_update = NOW() WHERE username = '".sql_esc($row["username"])."'";
				  $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
				  
				$query_login = "UPDATE login_detail SET password = '".sql_esc($p2)."', user_update = '".sql_esc($row["username"])."', date_update = NOW() WHERE username = '".sql_esc($row["username"])."'";
				$result_login = mysqli_query($dbc,$query_login) or die (mysqli_error());
				  
			
			      if(($row["user_email"] == "") or ($row["user_email"] == "NULL"))
				  { 
				   echo "User don't have the e-mail account. Please create e-mail account for this user.";

				    }else{ //If it ran ok
					
     	  
				//----send e-mail of reset password --------------
				
				
				//generate random pass n hash
				//$sbstr = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 10 );
				//$pPwd = base64_encode($sbstr);
				
				//reset new password
				//$query2 = "UPDATE login set password = '$pPwd' where username = '$user_name'";
				//$result2 = mysqli_query($eleaveDb,$query2);
				
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