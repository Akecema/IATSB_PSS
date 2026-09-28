<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
include '../include/config_mail.php';

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "2")) {
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
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo html_esc($data_setup["tajuk_sys"]); ?>">
    <title><?php echo html_esc($data_setup["title_desc"]); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
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
	background-color: #eeeeee;
}
.style2 {
	color: #000066;
	font-weight: bold;
}
.style3 {font-size: 11px}
.style11 {font-size: 11px; font-family: Geneva, Arial, Helvetica, sans-serif; font-weight: bold; }
.style8 {font-size: 11px; font-family: Geneva, Arial, Helvetica, sans-serif; }
-->
</style>
 </head>
  
  <body class="app sidebar-mini">

  <table width="100%" height="165" border="0" cellpadding="0" cellspacing="0" >
  <tr> 
    <td width="148" height="15"><span class="style2"><div align="center"><img src="../images/lock2.png" /></div></span></td>
    <td width="422"><p class="style2">&nbsp;</p>
    <p class="style2">Your password is expired. Please change your password.</p></td>
  </tr>
  <tr> 
    <td height="150" colspan="2"> 
      <?php 

// make the query.
// change password
if(isset($_POST['submit']))
{
 // require_once('include/config.php');   //connect to the db.

// create a function for escaping the data.
/*function escape_data ($data) {
global $dbc;   // need the connection.
if(ini_get('magic_quotes_gpc')) {
    $data = stripslashes($data);
	}
	return mysql_real_escape_string($data,$dbc);
	}   // end function.*/
$message = NULL; // create an empty new variable.

	
	
    //check for a username
    if(empty($_POST['username1'])) 
       { $user = FALSE;
	     $message .='<p> You forgot to enter your username!</p>';
           }
    
      else {
	  
	      if($_POST['username1'] == $username) {
			  $user = addslashes($_POST['username1']);
			  } else {
			    $user = FALSE;
				$message .= '<p>Your username did not match from database!</p>';
				}
	
      }
	  

    //check for a old password
    if(empty($_POST['password'])) 
       {  $password = FALSE;
	       $message .='<p> You forgot to enter your existing password!</p>';
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
		$message .= '<p>  Your passwords is weak.! Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit.</p>';
         
         }
			  
			  } else {
			    $newpass = FALSE;
				$message .= '<p>Your new password did not match the confirmed new password!</p>';
				}
			}
			
				  	  
                 if($user && $password && $newpass) { // Everything's OK
				 
				 require_once __DIR__ . '/../include/auth.php';
				  $newpass = password_hash($_POST['newpass'], PASSWORD_DEFAULT);
				 
				  $query = "SELECT * FROM login_detail WHERE username ='".sql_esc($user)."'";
				  $result = mysqli_query($dbc,$query);
				  $num = mysqli_num_rows($result);
				  
				  if($num == 1 && ($row_chk = mysqli_fetch_array($result)) && verify_password($password, (string)$row_chk['password'])) {
				    mysqli_data_seek($result, 0);
				    $row = mysqli_fetch_array($result);
					
						//Make the query
				//---------------------------update table login_detail & user_detail
				
				
				
				  $query12 = "UPDATE login_detail set password = '".sql_esc($newpass)."', status_pass = 'Y', user_update = '".sql_esc($row["username"])."', date_update = NOW() where username='".sql_esc($row["username"])."'";
				  $result12 = mysqli_query($dbc,$query12) or die (mysqli_error());
				
				//----------------------------------------------	
			       $query2 = "UPDATE user_detail set password = '".sql_esc($newpass)."', user_update = '".sql_esc($row["username"])."', date_update = NOW() where username='".sql_esc($row["username"])."'";
				  $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
				  
				  if(mysqli_affected_rows($dbc) == 1) { //If it ran ok
				  
				  //Send an email, if desired
				$pass_new =  $_POST['newpass'];
				
			    $to = $row["user_email"]; 
				$subject = "PSS Online Account password changed."; 
				$headers = "From: " .$data_setup["email_account"]."\r\n"; 
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
				
				$mess2 ="<p>Dear Sir; </br>";
				
				$mess2 .="<p>The password for your PSS Online Account was recently changed as below; </p>";
				$mess = '<html><body>';
				$mess .= '<table cellpadding="5">';
				$mess .= "<tr><td><strong>Username :</strong> </td><td>" .$row["username"].  "</td></tr>";		
				$mess .= "<tr><td><strong>Password :</strong> </td><td>" .$pass_new. "</td></tr>";
				$mess .= "</table>";	
				$mess .= "<br>"; 
			
				$mess .="<p>Please use the following link to view:</br>";
				$mess .="<a href='".$data_setup["urls_system"]."'>" .$data_setup["urls_system"]."</a> </p>";
				$mess .= "<p><font color='black'>This is a system generated email. Please DO NOT reply. </font></p>";
				$mess .= "<p>&nbsp;</p>";
				$mess .= "</body></html>";
				
				mail($to, $subject, $mess2.$mess, $headers);
			
			//------------------------get from table sys_param----------------------
			
			       $query_param = "SELECT * FROM sys_param WHERE param_name = 'logon_exp_days' ORDER BY id_param ASC";
                   $result_param = mysqli_query($dbc,$query_param);
				   $row_param = mysqli_fetch_array($result_param);
			
			//--------------------------------calculation date for expiry date after change password-----------------------
					
				   $query_dtl = "SELECT * FROM login_detail WHERE username = '".sql_esc($row["username"])."'";
                   $result_dtl = mysqli_query($dbc,$query_dtl);
				   $row_dtl = mysqli_fetch_array($result_dtl);
					
					 //------range date for new value ----------------------------
			 $start_date_check = $row_dtl["date_update"];
			 $end_date_check = date('Y-m-d H:m:s', strtotime("$row_param[new_value]"));
 
 
			  $query_dt = "UPDATE login_detail set expired_pass_date = '$end_date_check' where username='".$row["username"]."'";
		      $result_dt = mysql_query($query_dt) or die (mysqli_error());
			

		 echo "<script language='javascript'>alert('Your new password has been send to your email. We recommend you to print the e-mail for your reference.');window.location='index_production.php';</script>";
		   
		   //------------------auto logout for new password------------------------
				 
				  exit();
				  
				  } else {   //If it did not run OK
				  echo "<script language='javascript' type='text/javascript'>alert('Password cannot be change due to system error. We apologize for any inconvenience.');window.location='backjob_initial_pass.php';
				</script>";
				
			     return false;
				  }
				}else { 
				    echo "<script language='javascript' type='text/javascript'>alert('Your username and password do not match our database.');window.location='backjob_initial_pass.php';
				</script>";
				 }
				 mysqli_close($dbc);    //Close the database connection
				 
			 }/* else {
			     $message .='<p>Please try again.</p>';
	           }  */
			   
	  }  //End of the main Submit conditional
	  
	  //Print error
	  if (isset($message)) {
	     echo'<font color ="red">', $message, '</font>';
	    }
	  ?>
     
      <form action=""  method="post">
         <table width="99%" border="0" class="table table-striped table-hover table-bordered">
          <tr> 
            <td><div align="right">Username </div></td>
            <td><div align="center">:</div></td>
            <td><input type="text" name="username1" size="30" class="form-control" id="username1" readonly value="<?php echo html_esc($username); ?>" placeholder="Enter your username"></td>
            </tr>
          <tr> 
            <td><div align="right">Current Password </div></td>
            <td> <div align="center">:</div></td>
            <td><input type="password" name="password" class="form-control" id="password" size="30" placeholder="Enter current password"></td>
            </tr>
          <tr> 
            <td><div align="right">New Password </div></td>
            <td><div align="center">:</div></td>
            <td><input type="password" name="newpass" class="form-control" id="newpass" size="30" placeholder="Enter new password"></td>
            </tr>
          <tr> 
            <td><div align="right">Confirm New Password </div></td>
            <td> <div align="center">:</div></td>
            <td><input type="password" name="newpass2" class="form-control" id="newpass2" size="30" placeholder="Enter new password"></td>
            </tr>
          <tr>
            <td colspan="4"> <div class="row templatemo-form-buttons">
              <div class="col-md-12 text-center">
                <input type="submit" name="submit" value="Change Password" class="btn btn-primary"/>
              </div></div></td>
            </tr>
            </table>
         <p class="style11">Password Composition and Rules</p>
         <ul>
           <li class="style8">Passwords shall be at least 8 non-sequential characters long.</li>
           <li class="style8">Passwords shall be composed of alpha-numeric characters. </li>
           <li class="style8">Passwords shall contain all of the 4 characteristics below: </li>
           <li class="style8">&raquo; alphabet character (a, b, c...z) </li>
           <li class="style8">&raquo; upper case letter (A, B, C...Z) </li>
           <li class="style8">&raquo; number (0, 1, 2, 3...9) </li>
           <li class="style8">&raquo; special character (@, $, !...etc.) </li>
           <li class="style8">Regular passwords shall be changed at least every 3 months (90 days).</li>
         </ul>
         <p align="center">&nbsp;</p>
    
      </form></td>
  </tr>
</table>

</div> 
<!-- end of wrapper -->


</body>
</html>