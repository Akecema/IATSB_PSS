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

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
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
          <h1><i class="fa fa-users"></i> User Maintenance</h1>
          <p>Assign Vendor</p>
          
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">User Maintenance</li>
          <li class="breadcrumb-item"><a href="crt-vendor_user.php">Assign Vendor</a></li>
        </ul>
      </div>  
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link"  href="add_user.php">Add User</a></li>
                <li class="nav-item"><a class="nav-link" href="display_user.php">Display User</a></li>
                <li class="nav-item"><a class="nav-link" href="reset_password_user.php">Reset Password</a></li>
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="crt-vendor_user.php">Assign Vendor</a></li>
                <li class="nav-item"><a class="nav-link" href="display-vendor_user.php">Display Assign Vendor</a></li>
              </ul>
     <?php

$message_uname1 = "";
$message_uname2 = "";
$message_vend = "";



	 
if(isset($_POST['SubmitT']))
{
// load the variables form address bar

$username1 = $_POST["username1"];
$ath_status = $_POST["ath_status"];
$vendor_id = $_POST["vendor_id"];

    //check for a username
   	if (($_POST['username1'] == "") || ($_POST['username1'] == "NULL"))
       { 
	     $username1 = FALSE;
	     $message_uname1 ='<span class="badge badge-pill badge-danger">Please to select user!</span>';
      
	   }
    
     
	  
		// check for a vendor
	if (($_POST['vendor_id'] == "") || ($_POST['vendor_id'] == "NULL"))
	{ $vendor_id = FALSE;
	  $message_vend = '<span class="badge badge-pill badge-danger">Please to select vendor!</span>';
	  }

	
	
	if($username1 && $vendor_id) { // Everything's OK
	
    $username1 = $_POST["username1"];
	$ath_status = $_POST["ath_status"];
    $vendor_id = $_POST["vendor_id"];
			 
				 
	$query_ins_tbl = "INSERT INTO function_ath_vendordetail(id_ath,username,staff_ID,vendor_id,ath_status,date_create,user_create,date_update,user_update,plant_code) VALUES('','".sql_esc($username1)."','".sql_esc($username1)."','".sql_esc($vendor_id)."','".sql_esc($ath_status)."',NOW(),'".sql_esc($username)."','','','3100')";
    $result_ins_tbl = mysqli_query($dbc,$query_ins_tbl) or die (mysqli_error($dbc));
	
	
	
   
	
	  
	  
	  
             if($result_ins_tbl)
             {
				echo "<script>";
				echo "alert('Congratulations! Assign vendor successfully created');";
				echo "window.location='crt-vendor_user.php'";
				echo "</script>";
			    exit(); //quit the script
             }
             else 
			 {
             $message = '<p><strong>Error!</strong> Cannot create assign vendor. </p>';
              mysqli_close($dbc); //close db
             }  
	  
	    }  //End of the main Submit conditional
	  
	  
	  //Print error
	if(isset($message))
{ echo '<div class="msg msg-error"><font color="red" class ="error_entry">', $message, '</font></div>';
}

}
	  ?>

        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Assign Vendor</h3>
            <div class="tile-body">
              <form name="form1" method="post" action="" class="form-horizontal">         
              <div class="form-group row">
                  <label class="control-label col-md-3">Username : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
   <select name="username1" id="username1" class="form-control" required>
      <option value="NULL" placeholder="Select username"> -- Select username --</option>
      <?php
	               
				   $query2_g = "SELECT * FROM user_detail WHERE status = 'AC' ORDER BY vendor_no ASC";
                   $result2_g = mysqli_query($dbc,$query2_g);
  
                   while($row2_g = mysqli_fetch_array($result2_g)) 
			      {
                  echo'<option value="',html_esc($row2_g["staff_ID"]),'">',stripslashes($row2_g["staff_ID"]),' - ',stripslashes($row2_g["user_fullname"]),'</option>';
                  }
				?>
    </select>
       <div class="form-control-feedback" ><?php echo $message_uname1; ?></div>
       <div class="form-control-feedback" ><?php echo $message_uname2; ?></div>
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Vendor : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                    <select name="vendor_id" id="vendor_id" class="form-control" required>
      <option value="NULL" placeholder="Select vendor"> -- Select vendor --</option>
      <?php
	               
				   $query_g = "SELECT * FROM vendor_detail WHERE status_acc = 'Y' ORDER BY vendor_code ASC";
                   $result_g = mysqli_query($dbc,$query_g);
  
                   while($row_g = mysqli_fetch_array($result_g)) 
			      {
                  echo'<option value="',html_esc($row_g["vendor_code"]),'">',stripslashes($row_g["vendor_code"]),' - ',stripslashes($row_g["vendor_name"]),'</option>';
                  }
				?>
    </select>
              </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Status :</label>
                    <div class="col-md-8">
                   <select name="ath_status" id="ath_status" class="form-control">
                   <?php if($_POST['SubmitT'] == true)
						{ ?>
               <option value="AC" <?php if($_POST["ath_status"] == 'Y') { ?> selected="selected"<?php } ?>>ACTIVE</option>
               <option value="NA" <?php if($_POST["ath_status"] == 'N') { ?> selected="selected"<?php } ?>>NON-ACTIVE</option>
               <?php 
						}
						else
						{ ?>
               <option value="Y">ACTIVE</option>
               <option value="N">NON-ACTIVE</option>
               <?php } ?>
                 </select>
                 
                </div>
              </div>
              
             
              <div class="form-group row">
                  <label class="control-label col-md-3"><font color="#FF0000"><b>  * Compulsory field</b></font></label>
                    <div class="col-md-8">
                  &nbsp;
                </div>
              </div>
              
                <div class="form-group col-md-8 align-self-end">
               <input name="SubmitT" type="submit" id="submit" value="SUBMIT" class="btn btn-primary">
               <input name="Reset" type="reset" id="Reset" class="btn btn-warning" value="CLEAR">
           
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