<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
//include '../include/config_mail.php';
//include '../header2.php';

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "1")) {
header('Location: ../index.php');
exit();
}

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
//----------------------------------------------------	
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo html_esc($data_setup["tajuk_sys"]); ?>">
    <title><?php echo html_esc($data_setup["title_desc"]); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
<?php 


$today = getdate();
$hours = $today['hours']; 
$minutes = $today['minutes'];
$seconds = $today['seconds'];
$month = $today['mon']; 
$mday = $today['mday']; 
$year = $today['year']; 
?>

<style type="text/css">
<!--
.style1 {color: #FFFFFF}
body {
	background-color: #ffffff;
}
.style2 {
	color: #000066;
	font-weight: bold;
}
.style3 {font-size: 11px}
-->
</style>
  </head>
  
  <body class="app sidebar-mini">
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

// change password
if(isset($_POST["submit2"]))
{
	//include '../include/config_mail.php';

   $message = NULL; // create an empty new variable.

	$user = $_POST["username1"];
	$password = $_POST["password"];
	
    //check for a username
    if(empty($_POST['username1'])) 
       { $user = FALSE;
	     $message .='<span class="badge badge-pill badge-danger">Please You forgot to enter your username!</span>';
           }
    
      else {
	  
	      if($_POST['username1'] == $username) {
			  $user = addslashes($_POST['username1']);
			  } else {
			    $user = FALSE;
				$message .= '<span class="badge badge-pill badge-danger">Please Your username did not match from database!</span>';
				}
	
      }
	  

    //check for a old password
    if(empty($_POST['password'])) 
       {  $password = FALSE;
	       $message .='<span class="badge badge-pill badge-danger">Please You forgot to enter your existing password!</span>';
           }
    
      else {
	      $password = addslashes($_POST['password']);
	            }
				
				      
      //check for a password and match against the confirmed password.
     if(empty($_POST['newpass'])) {
	     $newpass = FALSE;
		 $message .= '<p>You forgot to enter your new password!</p>';
		 } else {
		     if($_POST['newpass'] == $_POST['newpass2']) {
			  $newpass = $_POST['newpass'];
			  
			  if (preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $newpass)) {
			   $newpass = addslashes($_POST['newpass']);
		$message .= '<p>  Your passwords is strong.!</p>';
         
		  
         } else {
		 $newpass = FALSE;
		$message .= '<p> Your passwords is weak.! Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit.</p>';
         
         }
			  
			  } else {
			    $newpass = FALSE;
				$message .= '<p>Your new password did not match the confirmed new password!</p>';
				}
			}
			
				  	  
                 if($user && $password && $newpass) { // Everything's OK
				 
				  require_once __DIR__ . '/../include/auth.php';
				  $newpass = password_hash($_POST['newpass'], PASSWORD_DEFAULT);
				  
				  $query = new PreparedSql("SELECT * FROM login_detail WHERE username = ?", [$user]);
				  $result = db_query($dbc, $query);
				  $num = mysqli_num_rows($result);
				  
				  if($num == 1 && ($row_chk = mysqli_fetch_array($result)) && verify_password($password, (string)$row_chk['password'])) {
				    mysqli_data_seek($result, 0);
				    $row = mysqli_fetch_array($result);
					
					
					//------user detail info --------
					
					$query_dtl = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$user]);
					$result_dtl = db_query($dbc, $query_dtl);
					$row_dtl = mysqli_fetch_array($result_dtl);
					
					 $Uname = $row_dtl['user_fullname'];
			         $Wdesc = $data_setup['tajuk_sys'];
			         $Uurl = $data_setup['urls_system'];
						//Make the query
				//---------------------------update table login_detail & user_detail
				
				
				
				  $query12 = "UPDATE login_detail SET password = '".sql_esc($newpass)."', status_pass = 'Y', user_update = '".sql_esc($row["username"])."', date_update = NOW() WHERE username='".sql_esc($row["username"])."'";
				  $result12 = mysqli_query($dbc,$query12) or die (mysqli_error($dbc));
				
				//----------------------------------------------	
			       $query2 = "UPDATE user_detail SET password = '".sql_esc($newpass)."', user_update = '".sql_esc($row["username"])."', date_update = NOW() WHERE username = '".sql_esc($row["username"])."'";
				  $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
				  
			if(mysqli_affected_rows($dbc) == 1) { //If it ran ok
				  
				  //Send an email, if desired
		    $pass_new =  $_POST['newpass'];
			$Wdesc2 =  $row["user_email"];
			$email = $row["user_email"];
			
			//--------------------------------------------------------
				//body message
				$message = file_get_contents('chg-pswd0.html'); 
				
				//name
				$message = str_replace('%uname%', $Uname, $message); 
				//web desc
				$message = str_replace('%wdesc%', $Wdesc, $message); 
				//web desc
				$message = str_replace('%wdesc2%', $Wdesc2, $message); 
				//new psword
				$message = str_replace('%tmpasword%', $pass_new, $message); 
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
			
				$mail->Subject = "PSS Online Account password changed";
				$mail->MsgHTML($message);
				
				
				$mail->CharSet="utf-8";
				
				//send the mail
				$mail->send();
			
	
			
			
			//------------------------get from table sys_param----------------------
			
			       $query_param = "SELECT * FROM sys_param WHERE param_name = 'logon_exp_days' ORDER BY id_param ASC";
                   $result_param = mysqli_query($dbc,$query_param);
				   $row_param = mysqli_fetch_array($result_param);
			
			//---------------calculation date for expiry date after change password-----------------------
					
				   $query_dtl = new PreparedSql("SELECT * FROM login_detail WHERE username = ?", [$row["username"]]);
                   $result_dtl = db_query($dbc, $query_dtl);
				   $row_dtl = mysqli_fetch_array($result_dtl);
					
		    //------range date for new value ----------------------------
 $start_date_check = $row_dtl["date_update"];
 $end_date_check = date('Y-m-d H:m:s', strtotime("$row_param[new_value]"));
 
 
			  $query_dt = "UPDATE login_detail set expired_pass_date = '".sql_esc($end_date_check)."' where username='".sql_esc($row["username"])."'";
		      $result_dt = mysqli_query($dbc,$query_dt) or die (mysqli_error($dbc));
			
			

          	echo "<script>";
			echo "alert('Your new password has been send to your email. We recommend you to print the e-mail for your reference.');";
			echo "window.location='index_admin.php'";
			echo "</script>";
			exit(); //quit the script
       

				  } else {   //If it did not run OK
				  
			echo "<script>";
			echo "alert('Password cannot be change due to system error. We apologize for any inconvenience.');";
		    echo "window.location='index_admin.php'";
			echo "</script>";
			exit(); //quit the script
				  
				  
		
				  }
				}else { 
	
				   
			echo "<script>";
			echo "alert('Your username and password do not match our database');";
		    echo "window.location='index_admin.php'";
			echo "</script>";
			exit(); //quit the script
				   
				   
				   
				 }
				// mysqli_close($dbc);    //Close the database connection
				 
			 } else {
				 
			echo "<script>";
			echo "alert('Please try again.');";
		    echo "window.location='index_admin.php'";
			echo "</script>";
			exit(); //quit the script
		
	           }
			   
	  }  //End of the main Submit conditional
	  
	  //Print error
	/*  if (isset($message)) {
	     echo'<font color ="red">', $message, '</font>';
	    }*/
	  ?>

</body>
</html>