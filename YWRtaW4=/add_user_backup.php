<?php
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
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
	
	
$url = "add_user.php"; 
	?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo $data_setup["tajuk_sys"]; ?>">
    <title><?php echo $data_setup["title_desc"]; ?></title>
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
          <h1><i class="fa fa-edit"></i> User Maintenance</h1>
          <p>Add User</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">User Maintenance</li>
          <li class="breadcrumb-item"><a href="add_user.php">Add User</a></li>
        </ul>
      </div>  
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="add_user.php">Add User</a></li>
                <li class="nav-item"><a class="nav-link" href="display_user.php">Display User</a></li>
                <li class="nav-item"><a class="nav-link" href="reset_password_user.php">Reset Password</a></li>
                
              </ul>
       <?php
	   
	   $message_vendor = ""; 
	   $message_staff = "";
	   $message_name = "";
	   $message_pass = "";
	   $message_comp = "";
	   $message_dept = "";
	   $message_design = "";
	   $message_email = "";
	   $message_level = "";
	   $message_sta = "";
	   $message_telno1 = "";
// Set the page title and include the HTML header.
//include ('templates/header.inc');

if (isset($_POST['submit'])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.


// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}
// create a function for escaping the data.
function escape_data($data) {
global $dbc;   // need the connection.
if (ini_get('magic_quotes_gpc')) {
    $data = stripslashes($data);
	}
	return mysqli_real_escape_string($data,$dbc);
	}   // end function.
$message = NULL; // create an empty new variable.
   
   $vendor_no = $_POST['vendor_no'];
   $user_id = $_POST['user_id'];
   $upw = $_POST['user_password'];
   $user_fullname = $_POST['user_fullname'];
   $department = $_POST['dept'];
   $designation = $_POST['design'];
   $company = $_POST['company'];
   $user_telno1 = $_POST['user_telno1'];
   $level_id = $_POST['level_id'];
   $status = $_POST['status'];
   $user_email = $_POST['user_email'];

  
// check for a vendor no
if (empty($_POST['vendor_no']))
{ $vendor_no = FALSE;
  $message_vendor = '<p><font color="red"><strong>Error!</strong> You are required to enter COMPANY CODE!</font></p>';
  }


// check for a user id
if (empty($_POST['user_id']))
{ $user_id = FALSE;
  $message_staff = '<p><font color="red"><strong>Error!</strong> You are required to enter USER ID!</font></p>';
  }
 
// check for a password and match against the confirmed password.
if (empty($_POST['user_password']))
{ $upw = FALSE;
  $message_pass = '<p><font color="red"><strong>Error!</strong> You are required to enter PASSWORD!</font></p>';
  }
  else
  { 
  
  if ($_POST['user_password'] == $_POST['user_password2'])
    { 
	$upw = $_POST['user_password'];
	    if (preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $upw)) {
		$message_pass = '<p><font color="red"><strong>Error!</strong>Your passwords is strong.!</font></p>';
        
         } else {
		$message_pass = '<p><font color="red"><strong>Error!</strong> Your passwords is weak.! Password must be at least 20 characters and must contain at least one lower case letter, one upper case letter and one digit</font></p>';
         
         }
	//$upw = escape_data($_POST['user_password']); 
	}
	else
    { $upw = FALSE;
      $message_pass = '<p><font color="red"><strong>Error!</strong> PASSWORD did not match the CONFIRMED PASSWORD!</font></p>';
     }
  }


// check for a fullname
if (empty($_POST['user_fullname']))
{ $user_fullname = FALSE;
  $message_name = '<p><font color="red"><strong>Error!</strong> You are required to enter your NAME!</font></p>';
  }
 

// check for a telephone no 1
if (empty($_POST['user_telno1']))
{ $user_telno1 = FALSE;
  $message_telno1 = '<p><font color="red"><strong>Error!</strong> You are required to enter TELEPHONE NO (1)!</font></p>';
  }

  // check for a EMAIL
  
  $email = $user_email;
  $regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";

if (!preg_match($regexp, $email)) {
    
   $user_email = FALSE; 
   $message_email = '<p><font color="red"><strong>Error!</strong> You are required to enter a valid E-MAIL address!</font></p>';
}

// check for a department
if (empty($_POST['dept']) || ($_POST['dept'] == ""))
{ $department= FALSE;
  $message_dept = '<p><font color="red"><strong>Error!</strong> You are required to select DEPARTMENT!</font></p>';
  }
// check for a designation
if (empty($_POST['design']) || ($_POST['design'] == ""))
{ $designation= FALSE;
  $message_design = '<p><font color="red"><strong>Error!</strong> You are required to select DESIGNATION!</font></p>';
  }

// check for a company
if (empty($_POST['company']) || ($_POST['company'] == ""))
{ $company= FALSE;
  $message_comp = '<p><font color="red"><strong>Error!</strong> You are required to select COMPANY!</font></p>';
  }



// check for a LEVEL USER
if (empty($_POST['level_id']) || ($_POST['level_id'] == ""))
{ $level_id = FALSE;
  $message_level = '<p><font color="red"><strong>Error!</strong> You are required to select LEVEL USER!</font></p>';
  }

// check for a Status
if (empty($_POST['status']) || ($_POST['status'] == ""))
{ $status= FALSE;
  $message_sta = '<p><font color="red"><strong>Error!</strong> You are required to select STATUS USER!</font></p>';
  }


  $user_telno2 = addslashes($_POST['user_telno2']);
  $user_fax = addslashes($_POST['user_fax']);
  
  $_POST['user_password'] = md5($_POST['user_password']);
 	if (!get_magic_quotes_gpc()) {
 		$_POST['user_password'] = addslashes($_POST['user_password']);
 		$user_id = addslashes($_POST['user_id']);
 			}
  
if ($vendor_no && $user_id && $upw && $user_fullname && $department && $designation && $company && $user_telno1 && $user_email && $level_id && $status) //everything ok
{  


//register the user in the db.
$query_db = "INSERT INTO user_detail (vendor_no,staff_ID,username,password,user_fullname,department,designation,company,user_telno1,user_telno2,user_fax,user_email,user_created,date_created,status,level_id,user_update,date_update,last_login,status_failed,date_failed) VALUES('".sql_esc($vendor_no)."','".sql_esc($user_id)."','".sql_esc($user_id)."','".sql_esc($_POST['user_password'])."','".sql_esc($user_fullname)."','".sql_esc($department)."','".sql_esc($designation)."','".sql_esc($company)."','".sql_esc($user_telno1)."','".sql_esc($user_telno2)."','".sql_esc($user_fax)."','".sql_esc($user_email)."','".sql_esc($username)."',now(),'".sql_esc($status)."','".sql_esc($level_id)."','','','','N','')";
$result = mysqli_query($dbc,$query_db) or die(mysqli_error());

//login detail
$query_login = "INSERT INTO login_detail (staff_ID, username, password, company, user_email, user_created, date_created, status, level_id, user_update, date_update, last_login, expired_pass_date, status_pass) VALUES('".strtoupper($user_id)."','".strtoupper($user_id)."', '".sql_esc($_POST['user_password'])."', '".sql_esc($company)."', '".sql_esc($user_email)."', '".sql_esc($username)."', NOW(), '".sql_esc($status)."', '".sql_esc($level_id)."','','','','','N')";
$result_login = mysqli_query($dbc,$query_login) or die (mysqli_error());



             if($result && $result_login)
             {
echo "<script>";
echo "alert('Congratulations! User successfully created');";
echo "window.location='display_user.php'";
echo "</script>";
			  exit(); //quit the script
             }
             else 
			 {
             $message = '<p><strong>Error!</strong> Cannot create User. </p>';
              mysqli_close($dbc); //close db
             }  
}
//print the message if there is one.
	  
	  
if (isset($message))
{ echo '<div class="alert alert-error">', $message, '</div>';
}
}
?>

      
      
      
      
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Add Account</h3>
            <div class="tile-body">
              <form name="form1" method="post" action="" class="form-horizontal">
                <div class="form-group row">
                  <label class="control-label col-md-3">Company Code :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                    <input name="vendor_no" type="text" id="vendor_no" size="20" maxlength="8" value="<?php if(isset($_POST['vendor_no'])) echo $_POST['vendor_no']; ?>" class="form-control" placeholder="Enter Vendor ID"/> 
                    <div class="form-control-feedback" ><?php echo $message_vendor; ?></div>
                    </div>
                   
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Staff ID : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                  <input name="user_id" type="text" class="form-control" id="user_id" size="20" maxlength="20" value="<?php if(isset($_POST['user_id'])) echo $_POST['user_id']; ?>"  placeholder="Enter Staff ID" />
                   <div class="form-control-feedback" ><?php echo $message_staff; ?></div>
                    </div>
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Password : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                   <input name="user_password" type="password" class="form-control" id="user_password" size="20" maxlength="20" value="<?php if(isset($_POST['user_password'])) echo $_POST['user_password']; ?>" placeholder="Enter Password"/>
                    <div class="form-control-feedback" ><?php echo $message_pass; ?></div>
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Confirmed Password :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                    <input name="user_password2" type="password" class="form-control" placeholder="Enter Confirmed Password"  id="user_password2" size="20" maxlength="20" value="<?php if(isset($_POST['user_password2'])) echo $_POST['user_password2']; ?>" />
                     <div class="form-control-feedback" ><?php echo $message_pass; ?></div>
                </div>
              </div>
               <div class="form-group row">
                  <label class="control-label col-md-3">Name : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                 <input name="user_fullname" type="text"  class="form-control" id="user_fullname" size="60" maxlength="100" value="<?php if(isset($_POST['user_fullname'])) echo $_POST['user_fullname']; ?>" placeholder="Enter Name" />
                  <div class="form-control-feedback" ><?php echo $message_name; ?></div>
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Company Name : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
   <?php		
 	echo '<select name="company" class="form-control">
  <option value=""> --Select-- </option>';
  
  //Retrieve and display the available types
  $query3 = 'SELECT * from company';
  $result3 = mysqli_query($dbc,$query3);
  
    
     while($row3 =mysqli_fetch_array($result3)) {
	
	 if($_POST['submit'] == true){ ?>
               <!--RETAIN VALUE-->
               <option value="<?php echo $row3["comp_code"]; ?>" <?php if($row3["comp_code"]==$_POST["company"]) echo "selected"; ?>> <?php echo $row3["comp_name"]; ?></option>
               <?php }else{ ?>
               <option value="<?php echo $row3["comp_code"]; ?>" > <?php echo stripslashes($row3["comp_name"]); ?></option>
               <?php } ?>
               <?php
							}
	 
	  	//complete the form
	
	echo '</select>';

	?>
       <div class="form-control-feedback" ><?php echo $message_comp; ?></div>       
                </div>
              </div>
              
              
              <div class="form-group row">
                  <label class="control-label col-md-3">Department : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
    <?php		
 	echo ' <select name="dept" class="form-control">
    <option value=""> --Select-- </option>';
  
  //Retrieve and display the available types
  $query2 = 'SELECT * FROM department';
  $result2 = mysqli_query($dbc,$query2);
  
      while($row2 = mysqli_fetch_array($result2)) {

        if($_POST['submit'] == true){ ?>
               <!--RETAIN VALUE-->
               <option value="<?php echo $row2["id_dept"]; ?>" <?php if($row2["id_dept"]==$_POST["dept"]) echo "selected"; ?>> <?php echo $row2["dept_name"]; ?></option>
               <?php }else{ ?>
               <option value="<?php echo $row2["id_dept"]; ?>" > <?php echo stripslashes($row2["dept_name"]); ?></option>
               <?php } ?>
               <?php
							}
					
	//complete the form
	
	echo '</select>';

	?>  <div class="form-control-feedback" ><?php echo $message_dept; ?></div>
                </div>
              </div>
              
                <div class="form-group row">
                  <label class="control-label col-md-3">Designation : <font color="#FF0000"><b> *</b></font></label>
            <div class="col-md-8">
     <?php		
 	echo '<select name="design" class="form-control">
  <option value=""> --Select-- </option>';
  
  //Retrieve and display the available types
  $query2b = 'SELECT * FROM designation';
  $result2b = mysqli_query($dbc,$query2b);
  
    while($row2b = mysqli_fetch_array($result2b)) {

      if($_POST['submit'] == true){ ?>
               <!--RETAIN VALUE-->
               <option value="<?php echo $row2b["id_design"]?>" <?php if($row2b["id_design"]==$_POST["design"]) echo "selected"; ?>> <?php echo $row2b["design"]?></option>
               <?php }else{ ?>
               <option value="<?php echo $row2b["id_design"]?>" > <?php echo strtoupper($row2b["design"])?></option>
               <?php } ?>
               <?php
							}
				
	echo '</select>';


	?>  <div class="form-control-feedback" ><?php echo $message_design; ?></div>
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Telephone No. 1 : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                  <input name="user_telno1" type="tel" id="user_telno1" class="form-control"  value="<?php if(isset($_POST['user_telno1'])) echo $_POST['user_telno1']; ?>"  placeholder="Enter Telephone No. 1"/>
                  
                    <div class="form-control-feedback" ><?php echo $message_telno1; ?></div>
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Telephone No. 2 : </label>
                    <div class="col-md-8">
                    <input name="user_telno2" type="tel" class="form-control" id="user_telno2" size="20" maxlength="20" value="<?php if(isset($_POST['user_telno2'])) echo $_POST['user_telno2']; ?>"  placeholder="Enter Telephone No. 2" />
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Fax No : </label>
                    <div class="col-md-8">
                  <input name="user_fax" type="tel" class="form-control" id="user_fax" size="20" maxlength="20" value="<?php if(isset($_POST['user_fax'])) echo $_POST['user_fax']; ?>"  placeholder="Enter Fax No "/>
                  
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">E-mail :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                     <input name="user_email" type="text" class="form-control" id="user_email" size="60" maxlength="200" value="<?php if(isset($_POST['user_email'])) echo $_POST['user_email']; ?>" placeholder="Enter E-mail " />
                    <div class="form-control-feedback" ><?php echo $message_email; ?></div>
                </div>
              </div>
               <div class="form-group row">
                  <label class="control-label col-md-3">Level : <font color="#FF0000"><b> *</b></font></label>
            <div class="col-md-8">
   <?php		
 	echo ' <select name="level_id" class="form-control">
  <option value=""> --Select-- </option>';
  
  //Retrieve and display the available types
  $query4 = 'SELECT * FROM level_detail where status_level = "Y"';
  $result4 = mysqli_query($dbc,$query4);
  
   
     while($row4 = mysqli_fetch_array($result4)) {
	 
	  if($_POST['submit'] == true){ ?>
               <!--RETAIN VALUE-->
               <option value="<?php echo $row4["id_level"]; ?>" <?php if($row4["id_level"]==$_POST["level_id"]) echo "selected"; ?>> <?php echo $row4["desc_level"]; ?></option>
               <?php }else{ ?>
               <option value="<?php echo $row4["id_level"]; ?>" > <?php echo stripslashes($row4["desc_level"]); ?></option>
               <?php } ?>
               <?php
							}
	 
	//complete the form
	
	echo '</select>';

	?>  <div class="form-control-feedback" ><?php echo $message_level; ?></div>
                </div>
              </div>
                <div class="form-group row">
                  <label class="control-label col-md-3">Status : <font color="#FF0000"><b> *</b></font></label>
            <div class="col-md-8">
            <select name="status" id="status" class="form-control">
                   <?php if($_POST['submit'] == true)
						{ ?>
               <option value="AC" <?php if($_POST["status"] == 'AC') { ?> selected="selected"<?php } ?>>ACTIVE</option>
               <option value="NA" <?php if($_POST["status"] == 'NA') { ?> selected="selected"<?php } ?>>NON-ACTIVE</option>
               <?php 
						}
						else
						{ ?>
               <option value="AC">ACTIVE</option>
               <option value="NA">NON-ACTIVE</option>
               <?php } ?>
                 </select>
                   <div class="form-control-feedback" ><?php echo $message_sta; ?></div>
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3"><font color="#FF0000"><b>  * Compulsory field</b></font></label>
                    <div class="col-md-8">
                  &nbsp;
                </div>
              </div>
              
                <div class="form-group col-md-8 align-self-end">
               <input name="submit" type="submit" id="submit" value="CREATE" class="btn btn-primary">
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