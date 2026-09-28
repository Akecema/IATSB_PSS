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
	
	
	
$url = "add_tbl_storage_QC.php"; 
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
          <p>QC Storage Location</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Table Maintenance</li>
          <li class="breadcrumb-item"><a href="add_tbl_storage_QC.php">QC Storage Location</a></li>
        </ul>
      </div>  
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" href="add_tbl_storage_QC.php" data-toggle="tab">QC Storage Location</a></li>
                <li class="nav-item"><a class="nav-link"  href="storage_QC_list.php">QC Storage Location List</a></li>
            </ul>
            
      <?php
	  
	  $message_sloc = "";
	  $message_slocdesc = "";
	  
	  
if (isset($_POST['Submit7'])) 
{ // handle the form.


$message = NULL; // create an empty new variable.
   
$slocCD = $_POST['qc_sloc_code'];
$slocDC = $_POST['qc_sloc_desc'];
  

// check for a wastage_desc.
if(empty($_POST['qc_sloc_code']))
{ 
	$slocCD = FALSE;
	$message_sloc = '<span class="badge badge-pill badge-danger">Please enter Storage Location Code!</span>';
}
else
{ 
	$slocCD = addslashes($_POST['qc_sloc_code']);
}


// check for a status
if(empty($_POST['qc_sloc_desc'])) 
{ 
	$slocDC = FALSE;
	$message_slocdesc = '<span class="badge badge-pill badge-danger">Please enter storage location description</span>';
}
else
{ 
	$slocDC = addslashes($_POST['qc_sloc_desc']);
}


if($slocCD && $slocDC) //everything ok
{
	//register the user in the db.
	$query_db = "INSERT INTO storage2_tbl(qc_sloc_id,qc_sloc_code,qc_sloc_desc) VALUES('','".sql_esc($slocCD)."','".sql_esc($slocDC)."')";
	$result = mysqli_query($dbc,$query_db) or die (mysqli_error($dbc));
	
	if($result)
	{
		echo "<script>";
		echo "alert('QC storage location is successfully created.');";
		echo "window.location='storage_QC_list.php'";
		echo "</script>";
		exit(); //quit the script
	}
	else 
	{
		$message = '<p><strong>Error!</strong> Cannot create QC storage location. </p>';
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
            <h3 class="tile-title">QC Storage Location</h3>
            <div class="tile-body">
              <form name="myform" method="post" action="" class="form-horizontal" >
                <div class="form-group row">
                  <label class="control-label col-md-3">Storage Location Code : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                  <input name="qc_sloc_code" type="text" class="form-control" id="qc_sloc_code" size="20" maxlength="20" value="<?php if(isset($_POST['qc_sloc_code'])) echo $_POST['qc_sloc_code']; ?>"  placeholder="Enter Storage Location" />
                   <div class="form-control-feedback" ><?php echo $message_sloc; ?></div>
                    </div>
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Storage Location : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                  <input name="qc_sloc_desc" type="text" class="form-control" id="qc_sloc_desc" size="20" maxlength="20" value="<?php if(isset($_POST['qc_sloc_desc'])) echo $_POST['qc_sloc_desc']; ?>"  placeholder="Enter Storage Location Description"/>
                   <div class="form-control-feedback" ><?php echo $message_slocdesc; ?></div>
                    </div>
                </div>
               <div class="form-group row">
                  <label class="control-label col-md-3"><font color="#FF0000"><b>* Compulsory field</b></font></label>
                    <div class="col-md-8">
                  &nbsp;
                </div>
                </div>
                <div class="form-group col-md-8 align-self-end">
               <input name="Submit7" type="submit" id="submit" value="CREATE" class="btn btn-primary" >
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