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
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	
	
$url = "reason_hwork_table.php"; 
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
     <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    
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
          <h1><i class="fa fa-edit"></i> Table Maintenance</h1>
          <p>Reason Handwork</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Table Maintenance</li>
          <li class="breadcrumb-item"><a href="reason_hwork_table.php">Reason Handwork</a></li>
        </ul>
      </div>  
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" href="add_tbl_reason_hwork.php" data-toggle="tab">Reason Handwork</a></li>
                <li class="nav-item"><a class="nav-link"  href="reason_hwork_table.php">Reason Handwork List</a></li>
            </ul>
            
      <?php
	  
   $message_rdesc = "";
   $message_sta = "";
	  
if (isset($_POST['Submit7'])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

$message = NULL; // create an empty new variable.

   
$status_rhwork = $_POST['status_rhwork'];
$rhwork_desc = $_POST['rhwork_desc'];
  

// check for a reason_reject_desc.
if (empty($_POST['rhwork_desc']))
{ $rhwork_desc = FALSE;
  $message_rdesc = '<span class="badge badge-pill badge-danger">Please enter Reason Handwork!</span>';
  }else
  { $rhwork_desc = addslashes($_POST['rhwork_desc']);
  }
  
// check for a status
if (empty($_POST['status_rhwork']) || ($_POST['status_rhwork'] == "NULL"))
{ 
  $status_rhwork = FALSE;
  $message_sta = '<span class="badge badge-pill badge-danger">Please select Status!</span>';
  }
    else
  { $status_rhwork = addslashes($_POST['status_rhwork']);
  }




if($rhwork_desc && $status_rhwork) //everything ok
{
	$status_rhwork = $_POST['status_rhwork'];
    $rhwork_desc = $_POST['rhwork_desc'];     
	
	//register the user in the db.
	$query_db = "INSERT INTO reason_bfhwork(id_rhwork,rhwork_desc,status_rhwork) VALUES('','".sql_esc($rhwork_desc)."','".sql_esc($status_rhwork)."')";
	$result = mysqli_query($dbc,$query_db) or die (mysqli_error($dbc));
	
	if($result)
	{
		echo "<script>";
		echo "alert('Reason Handwork is successfully created.');";
		echo "window.location='reason_hwork_table.php'";
		echo "</script>";
		exit(); //quit the script
	}
	else 
	{
		$message = '<p><strong>Error!</strong> Cannot create reason handwork. </p>';
		mysqli_close($dbc); //close db
	}  
}
//print the message if there is one.
	  
	  
if (isset($message))
{ 
	echo '<div class="alert alert-error">', $message, '</div>';
}
}
?>    
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Reason Handwork</h3>
            <div class="tile-body">
              <form name="form1" method="post" action="" class="form-horizontal">
                <div class="form-group row">
                  <label class="control-label col-md-3">Reason Handwork  : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                  <input name="rhwork_desc" type="text" class="form-control" id="rhwork_desc" size="20" maxlength="20" value="<?php if(isset($_POST['rhwork_desc'])) echo html_esc($_POST['rhwork_desc']); ?>"  placeholder="Enter Reason Handwork" />
                   <div class="form-control-feedback" ><?php echo $message_rdesc; ?></div>
                    </div>
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Status Reason: <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                   <select name="status_rhwork" id="status_rhwork" class="form-control">
                   <option value="NULL"> --- Status --- </option>
                   
                   <?php if($_POST['Submit7'] == true)
						{ ?>
               <option value="Y" <?php if($_POST["status_rhwork"] == 'Y') { ?> selected="selected"<?php } ?>>ACTIVE</option>
               <option value="N" <?php if($_POST["status_rhwork"] == 'N') { ?> selected="selected"<?php } ?>>INACTIVE</option>
               <?php 
						}
						else
						{ ?>
               <option value="Y">ACTIVE</option>
               <option value="N">INACTIVE</option>
               <?php } ?>
                 </select>
                    <div class="form-control-feedback" ><?php echo $message_sta; ?></div>
                    </div>
                </div>
               <div class="form-group row">
                  <label class="control-label col-md-3"><font color="#FF0000"><b>* Compulsory field</b></font></label>
                    <div class="col-md-8">
                  &nbsp;
                </div>
                </div>
                <div class="form-group col-md-8 align-self-end">
               <input name="Submit7" type="submit" id="Submit7" value="CREATE" class="btn btn-primary">
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