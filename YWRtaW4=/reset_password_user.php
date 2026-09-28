<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

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

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	
	
$url = "add_user.php"; 
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
  </head>
  
  <body class="app sidebar-mini">
    <!-- Navbar-->
      <?php   include "top_modal_menu.php";   ?>
    
    
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <?php   include "left_admin_menu.php";   ?>
  
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-lock"></i> User Maintenance</h1>
          <p>Reset Password</p>
          
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">User Maintenance</li>
          <li class="breadcrumb-item"><a href="reset_password_user.php">Reset Password</a></li>
        </ul>
      </div>  
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link"  href="add_user.php">Add User</a></li>
                <li class="nav-item"><a class="nav-link" href="display_user.php">Display User</a></li>
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="reset_password_user.php">Reset Password</a></li>
                <li class="nav-item"><a class="nav-link" href="crt-vendor_user.php">Assign Vendor</a></li>
                <li class="nav-item"><a class="nav-link" href="display-vendor_user.php">Display Assign Vendor</a></li>
              </ul>
     <?php

$message_uname1 = "";
$message_uname2 = "";
$message_pass1 = "";
$message_pass2 = "";
$message_cc = "";


// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';



	 
if(isset($_POST['SubmitT']))
{
// load the variables form address bar
//$verif_box = $_POST["verif_box"];
$user = $_POST["username1"];

    //check for a username
    if(empty($_POST['username1'])) 
       { 
	     $user = FALSE;
	     $message_uname1 ='<span class="badge badge-pill badge-danger">Please to select username!</span>';
           }
    
      else {
	  
	      $query_all = "SELECT * FROM user_detail where user_no = '".sql_esc($_POST['username1'])."'";
		  $result_all = mysqli_query($dbc,$query_all);
		  $db_all = mysqli_fetch_array($result_all);
	  
	  
	      if($_POST["username1"] == $db_all["user_no"]) {
			  $user = addslashes($_POST['username1']);
			  } else {
			    $user = FALSE;
				$message_uname2 = '<span class="badge badge-pill badge-danger">Your username did not match from database!</span>';
				}
	
      }
	  
	  
         
     //check for a password and match against the confirmed password.
     if(empty($_POST['newpass'])) {
	     $newpass = FALSE;
		 $message_pass1 = '<span class="badge badge-pill badge-danger">You forgot to enter your new password!</span>';
		 } else {
		     if($_POST['newpass'] == $_POST['newpass2']) {
			  $newpass = addslashes($_POST['newpass']);
			  } else {
			    $newpass = FALSE;
				$message_pass2 = '<span class="badge badge-pill badge-danger">Your new password did not match the confirmed new password!</span>';
				}
			}
			
	
	
	if($user && $newpass) { // Everything's OK
	
    $user = $_POST["username1"];
			 
				 
	
     // add form data processing code here 
    // echo  '<strong>Verification successful.</strong>'; 
	 
				 
	// check to see if verificaton code was correct

				
				 $newpass = password_hash($_POST['newpass'], PASSWORD_DEFAULT);
				 // $pass = md5($password);
				 
				  $query_g = "SELECT * FROM user_detail WHERE user_no = '".sql_esc($user)."'";
				  $result_g = mysqli_query($dbc,$query_g);
				  $num = mysqli_num_rows($result_g);
				  
				  if($num == 1 ) {
				    
					$row_g = mysqli_fetch_array($result_g);
					
					
					
					
					
					//Make the query
			
		          $query2 = "UPDATE user_detail set password = '".sql_esc($newpass)."' where user_no ='".sql_esc($row_g["user_no"])."'";
				  $result2 = mysqli_query($dbc,$query2);
				  
				  $query12 = "UPDATE login_detail SET password = '".sql_esc($newpass)."', user_update = '".sql_esc($row_g["username"])."', date_update = NOW() WHERE username = '".sql_esc($row_g["username"])."'";
				  $result12 = mysqli_query($dbc,$query12);
				  
		   //if(mysqli_affected_rows($dbc) == 1) { //If it ran ok
		   
		     if(($row_g["user_email"] != "") || ($row_g["user_email"] != "NULL"))
		 { 
				  
				  //Send an email, if desired
			$pass_new =  $_POST['newpass'];
		            
					 $Uname = $row_g['user_fullname'];
			         $Wdesc = $data_setup['tajuk_sys'];
			         $Uurl = $data_setup['urls_system'];
					
     	  
				//----send e-mail of reset password --------------
	
				
				//--------------------------------------------------------
				//body message
				$message2 = file_get_contents('rset-pswd0.html'); 
				
				//name
				$message2 = str_replace('%uname%', $Uname, $message2); 
				//web desc
				$message2 = str_replace('%wdesc%', $Wdesc, $message2); 
				//new psword
				$message2 = str_replace('%tmpasword%', $pass_new, $message2); 
				//url
				$message2 = str_replace('%uurl%', $Uurl, $message2); 
				
		
					
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
				$mail->addAddress($email, $row_g["user_email"]);
				
				//Send HTML or Plain Text email
				$mail->isHTML(true);
			
				$mail->Subject = "Password Reset for PSS ITSB Online";
				$mail->MsgHTML($message2);
				
				
				$mail->CharSet="utf-8";
				
				//send the mail
				$mail->send();
			
			
				echo "<script>";
				echo "alert('Your new password has been send to your email.');";
				echo "window.location='display_user.php'";
				echo "</script>";
			    exit(); //quit the script

				  
				  } else {   //If it did not run OK
				  $message = '<p>Email Error.We apologize for any inconvenience.</p>';
				  }
				}else { 
				   $message = '<p><font color="#FF0000">Error!Your username and password do not match our database</font></p>';
				 }
				
				mysqli_close($dbc);    //Close the database connection
				 
			 } 
			   
   
	  }  //End of the main Submit conditional
	  
	  //Print error
	if(isset($message))
{ echo '<div class="msg msg-error"><font color="red" class ="error_entry">', $message, '</font></div>';
}
	  ?>

        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Reset Password</h3>
            <div class="tile-body">
              <form name="form1" method="post" action="" class="form-horizontal">         
              <div class="form-group row">
                  <label class="control-label col-md-3">Username : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
   <select name="username1" id="username1" class="form-control">
      <option value="NULL" placeholder="Select username"> -- Select username --</option>
      <?php
	               
				   $query2_g = "SELECT * FROM user_detail WHERE level_id != '1' AND status = 'AC' ORDER BY vendor_no ASC";
                   $result2_g = mysqli_query($dbc,$query2_g);
  
                   while($row2_g = mysqli_fetch_array($result2_g)) 
			      {
                  echo'<option value="',html_esc($row2_g["user_no"]),'">',stripslashes($row2_g["staff_ID"]),' - ',stripslashes($row2_g["user_fullname"]),'</option>';
                  }
				?>
    </select>
       <div class="form-control-feedback" ><?php echo $message_uname1; ?></div>
       <div class="form-control-feedback" ><?php echo $message_uname2; ?></div>
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Password : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                   <input name="newpass" type="password" class="form-control" id="newpass" size="20" maxlength="20" value="<?php if(isset($_POST['newpass'])) echo html_esc($_POST['newpass']); ?>" placeholder="Enter Password"/>
                    <div class="form-control-feedback" ><?php echo $message_pass1; ?></div> 
                    <div class="form-control-feedback" ><?php echo $message_pass2; ?></div> 
              </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Confirmed Password :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                    <input name="newpass2" type="password" class="form-control" placeholder="Enter Confirmed Password"  id="newpass2" size="20" maxlength="20" value="<?php if(isset($_POST['newpass2'])) echo html_esc($_POST['newpass2']); ?>"/>
                 
                </div>
              </div>
              
             
              <div class="form-group row">
                  <label class="control-label col-md-3"><font color="#FF0000"><b>  * Compulsory field</b></font></label>
                    <div class="col-md-8">
                  &nbsp;
                </div>
              </div>
              
                <div class="form-group col-md-8 align-self-end">
               <input name="SubmitT" type="submit" id="submit" value="RESET PASSWORD" class="btn btn-primary">
               <input name="Reset" type="reset" id="Reset" class="btn btn-warning" value="CLEAR">
                 <!--   <button class="btn btn-primary" type="button" onClick=""><i class="fa fa-fw fa-lg fa-check-circle"></i>Subscribe</button>-->
                </div>
              </form>
            </div>
          </div>
        
        
        
      
         </div>
         </div>
      
      
           
         
          </div>
        </div>
     
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
      </body>
</html>