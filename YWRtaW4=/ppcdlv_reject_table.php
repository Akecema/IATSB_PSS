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
	
	
	
$url = "ppcdlv_reject_table.php"; 
	?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo $data_setup["tajuk_sys"]; ?>">
    <title><?php echo $data_setup["title_desc"]; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <!----sort table https://stackoverflow.com/questions/10683712/html-table-sort/51648529---->
   <!-- <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>-->
    <!--  <script src="https://www.w3schools.com/lib/w3.js"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script> 
    
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    
    
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
          <p>Delivery Reject</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Table Maintenance</li>
          <li class="breadcrumb-item"><a href="ppcdlv_reject_table.php">Delivery Reject</a></li>
        </ul>
      </div>  
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" href="ppcdlv_reject_table.php" data-toggle="tab">Add Process</a></li>
                <li class="nav-item"><a class="nav-link"  href="display_ppcdlv_reject.php">Display Process</a></li>
                <li class="nav-item"><a class="nav-link" href="ppcdlv_type-reject_table.php">Add Type</a></li>
                <li class="nav-item"><a class="nav-link"  href="display_ppcdlv_type-reject.php">Display Type</a></li>
                 <li class="nav-item"><a class="nav-link" href="ppcdlv_defect-reject_table.php">Add Defect</a></li>
                <li class="nav-item"><a class="nav-link"  href="display_ppcdlv_defect-reject.php">Display Defect</a></li>
                <!--<li class="nav-item"><a class="nav-link" href="prod_reason-reject_table.php">Add Reason</a></li>
                <li class="nav-item"><a class="nav-link"  href="display_prod_reason-reject.php">Display Reason</a></li>-->
            </ul>
            
      <?php
	  
	  $message_rejdesc = "";
	  $message_sta = "";
	  
if (isset($_POST['Submit7'])) 
{ // handle the form.


   $message = NULL; // create an empty new variable.
   
   $status_proc = $_POST['status_proc'];
   $proc_desc = $_POST['proc_desc'];
  

// check for a reason_reject_desc.
if (empty($_POST['proc_desc']))
{ $proc_desc = FALSE;
  $message_rejdesc = '<span class="badge badge-pill badge-danger">Please enter Process!</span>';
  }else
  { $proc_desc = addslashes($_POST['proc_desc']);
  }
  
// check for a status
if (empty($_POST['status_proc']) || ($_POST['status_proc'] == "NULL"))
{ 
  $status_proc = FALSE;
  $message_sta = '<span class="badge badge-pill badge-danger">Please select Status!</span>';
  }
    else
  { $status_proc = addslashes($_POST['status_proc']);
  }

   
 if($proc_desc && $status_proc) //everything ok
{

//register the user in the db.
$query_db = "INSERT INTO proc_reject_detail_ppcdlv(id_proc,proc_desc,status_proc) VALUES
                                ('','".sql_esc($proc_desc)."','".sql_esc($status_proc)."')";
$result = mysqli_query($dbc,$query_db) or die (mysqli_error($dbc));


             if($result)
             {
echo "<script>";
echo "alert('Delivery Reject is successfully created');";
echo "window.location='display_ppcdlv_reject.php'";
echo "</script>";
			  exit(); //quit the script
             }
             else 
			 {
             $message = '<p><strong>Error!</strong> Cannot create Delivery Reject. </p>';
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
            <h3 class="tile-title">Delivery Reject</h3>
            <div class="tile-body">
              <form name="form1" method="post" action="" class="form-horizontal">
                <div class="form-group row">
                  <label class="control-label col-md-3">Delivery Process Reject Desc. : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                  <input name="proc_desc" type="text" class="form-control" id="proc_desc" size="20" maxlength="40" value="<?php if(isset($_POST['proc_desc'])) echo $_POST['proc_desc']; ?>"  placeholder="Enter Receiving Process Reject Description" />
                   <div class="form-control-feedback" ><?php echo $message_rejdesc; ?></div>
                    </div>
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Status Receiving : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                     <select name="status_proc" id="status_proc" class="form-control">
                   <?php if($_POST['Submit7'] == true)
						{ ?>
               <option value="Y" <?php if($_POST["status_proc"] == 'Y') { ?> selected="selected"<?php } ?>>ACTIVE</option>
               <option value="N" <?php if($_POST["status_proc"] == 'N') { ?> selected="selected"<?php } ?>>INACTIVE</option>
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
               <input name="Submit7" type="submit" id="submit" value="CREATE" class="btn btn-primary">
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