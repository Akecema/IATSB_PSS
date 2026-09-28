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

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
$url = "reason_wastage_table.php"; 
	?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="PSS ITSB Online, Ingress Technologies Sdn. Bhd.,Ingress ">
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
          <p>Add Reason Wastage</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Table Maintenance</li>
          <li class="breadcrumb-item"><a href="add_tbl_reason_wastage.php">Add Reason Wastage</a></li>
        </ul>
      </div>  
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" href="add_tbl_reason_wastage.php" data-toggle="tab">Add Reason Wastage</a></li>
                <li class="nav-item"><a class="nav-link"  href="reason_wastage_table.php">Display Reason Wastage</a></li>
            </ul>
            
      <?php
	  
	  $message_wasdesc = "";
	  $message_sta = "";
	  
if (isset($_POST['Submit7'])) 
{ // handle the form.


$message = NULL; // create an empty new variable.
   
$status_reason_wastage = $_POST['status_reason_wastage'];
$reason_wastage_desc = $_POST['reason_wastage_desc'];
  

// check for a reason_wastage_desc.
if (empty($_POST['reason_wastage_desc']))
{ $reason_wastage_desc = FALSE;
  $message_wasdesc = '<span class="badge badge-pill badge-danger">Please enter Reason Wastage Description.!</span>';
  }else
  { $reason_wastage_desc = addslashes($_POST['reason_wastage_desc']);
  }
  
// check for a status
if (empty($_POST['status_reason_wastage'])) 
{ 
  $status_reason_wastage = FALSE;
  $message_sta = '<span class="badge badge-pill badge-danger">Please select Status Wastage!</span>';
  }
    else
  { $status_reason_wastage = addslashes($_POST['status_reason_wastage']);
  }

   
 if($reason_wastage_desc && $status_reason_wastage) //everything ok
{

//register the user in the db.
$query_db = "INSERT INTO reason_wastage(id_reason_wastage,reason_wastage_desc,status_reason_wastage) VALUES
                                ('','".sql_esc($reason_wastage_desc)."','".sql_esc($status_reason_wastage)."')";
$result = mysqli_query($dbc,$query_db) or die (mysqli_error($dbc));


             if($result)
             {
echo "<script>";
echo "alert('Reason of Wastage is successfully created');";
echo "window.location='reason_wastage_table.php'";
echo "</script>";
			  exit(); //quit the script
             }
             else 
			 {
             $message = '<p><strong>Error!</strong> Cannot create Reason Wastage. </p>';
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
            <h3 class="tile-title">Add Reason Wastage</h3>
            <div class="tile-body">
              <form name="form1" method="post" action="" class="form-horizontal">
                <div class="form-group row">
                  <label class="control-label col-md-3">Reason Wastage Desc. : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                  <input name="reason_wastage_desc" type="text" class="form-control" id="reason_wastage_desc" size="20" maxlength="20" value="<?php if(isset($_POST['reason_wastage_desc'])) echo html_esc($_POST['reason_wastage_desc']); ?>"  placeholder="Enter Reason Wastage Description" />
                   <div class="form-control-feedback" ><?php echo $message_wasdesc; ?></div>
                    </div>
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Status of Wastage  : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                     <select name="status_reason_wastage" id="status_reason_wastage" class="form-control">
                   <?php if($_POST['Submit7'] == true)
						{ ?>
               <option value="Y" <?php if($_POST["status_reason_wastage"] == 'Y') { ?> selected="selected"<?php } ?>>ACTIVE</option>
               <option value="N" <?php if($_POST["status_reason_wastage"] == 'N') { ?> selected="selected"<?php } ?>>INACTIVE</option>
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