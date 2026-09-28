<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
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
	
	
	
$url = "add_tbl_storage_PD.php"; 
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
          <p>Line</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Table Maintenance</li>
          <li class="breadcrumb-item"><a href="add_tbl_storage_PD.php">Line</a></li>
        </ul>
      </div>  
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" href="add_tbl_storage_PD.php" data-toggle="tab">Line</a></li>
                <li class="nav-item"><a class="nav-link"  href="storage_PD_list.php">Line List</a></li>
                <li class="nav-item"><a class="nav-link" href="storage_rjt_prd_list.php">Line PRD Reject List</a></li>
                <li class="nav-item"><a class="nav-link" href="storage_rjt_qc_list.php">Line QC Reject List</a></li>

              </ul>
            
      <?php
	  
	  $message_sloc = "";
	  $message_slocdesc = "";
	  $message_pcode = "";
	  $message_sta = "";
	  
	  
if (isset($_POST['Submit7'])) 
{ // handle the form.


$message = NULL; // create an empty new variable.
   
$slocCD = $_POST['sloc_code'];
$slocDC = $_POST['sloc_desc'];
$plant_code = $_POST['plant_code'];
$status_sloc = $_POST['status_sloc'];
  

// check for a wastage_desc.
if(empty($_POST['sloc_code']))
{ 
	$slocCD = FALSE;
	$message_sloc = '<span class="badge badge-pill badge-danger">Please enter Storage Location Code!</span>';
}
else
{ 
	$slocCD = addslashes($_POST['sloc_code']);
}


// check for a status
if(empty($_POST['sloc_desc'])) 
{ 
	$slocDC = FALSE;
	$message_slocdesc = '<span class="badge badge-pill badge-danger">Please enter storage location description</span>';
}
else
{ 
	$slocDC = addslashes($_POST['sloc_desc']);
}

// check for status account
if(empty($_POST["status_sloc"]) || ($_POST["status_sloc"] == "NULL"))
{ $status_sloc = FALSE;
  $message_sta = '<span class="badge badge-pill badge-danger">Please select Status Account!</span>';
  }
  else
  { $status_sloc = addslashes($_POST["status_sloc"]);
  }

// check for plant code
if(empty($_POST["plant_code"]) || ($_POST["plant_code"] == "NULL"))
{ $plant_code = FALSE;
  $message_pcode = '<span class="badge badge-pill badge-danger">Please select plant code!</span>';
  }
  else
  { $plant_code = addslashes($_POST["plant_code"]);
  }

if($slocCD && $slocDC && $plant_code && $status_sloc) //everything ok
{
	
	
	//register the user in the db.
	$query_db = "INSERT INTO sloc_tbl(sloc_id,sloc_code,sloc_desc,plant_code,status_sloc) VALUES('','".sql_esc($slocCD)."','".sql_esc($slocDC)."','".sql_esc($plant_code)."','".sql_esc($status_sloc)."')";
	$result = mysqli_query($dbc,$query_db) or die (mysqli_error($dbc));
	
	if($result)
	{
		echo "<script>";
		echo "alert('Line is successfully created.');";
		echo "window.location='storage_PD_list.php'";
		echo "</script>";
		exit(); //quit the script
	}
	else 
	{
		$message = '<p><strong>Error!</strong> Cannot create line. </p>';
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
            <h3 class="tile-title">Line</h3>
            <div class="tile-body">
              <form name="form1" method="post" action="" class="form-horizontal">
                <div class="form-group row">
                  <label class="control-label col-md-3">Line Code : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                  <input name="sloc_code" type="text" class="form-control" id="sloc_code" size="20" maxlength="20" value="<?php if(isset($_POST['sloc_code'])) echo $_POST['sloc_code']; ?>"  placeholder="Enter Storage Location" />
                   <div class="form-control-feedback" ><?php echo $message_sloc; ?></div>
                    </div>
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Line Description : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                  <input name="sloc_desc" type="text" class="form-control" id="sloc_desc" size="20" maxlength="20" value="<?php if(isset($_POST['sloc_desc'])) echo $_POST['sloc_desc']; ?>"  placeholder="Enter Storage Location Description"/>
                   <div class="form-control-feedback" ><?php echo $message_slocdesc; ?></div>
                    </div>
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Plant : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                    <select name="plant_code" class="form-control">
            <option value="NULL" placeholder="Select Plant"> -- Select Plant -- </option>
          <?php
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM plant_detail WHERE status_plant = "Y"';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
              ?>
         <option value="<?php echo $row27["plant_code"]; ?>" > <?php echo stripslashes($row27["plant_code"]); ?> - <?php echo $row27["plant_desc"]; ?></option>
          <?php
           }  ?>
                            
        </select>
                    
                   <div class="form-control-feedback" ><?php echo $message_pcode; ?></div>
               
                </div></div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Status Account: <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
               <select name="status_sloc" id="status_cust" class="form-control">
               <option value="NULL"> --- Select --- </option>
                   <?php if($_POST['Submit7'] == true)
						{ ?>
               <option value="Y" <?php if($_POST["status_sloc"] == 'Y') { ?> selected="selected"<?php } ?>>ACTIVE</option>
               <option value="N" <?php if($_POST["status_sloc"] == 'N') { ?> selected="selected"<?php } ?>>INACTIVE</option>
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