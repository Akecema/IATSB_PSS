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
	
	
	
$url = "display_setup_disposal_aprv.php"; 
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
  <style>
th {
  cursor: pointer;
 /* background-color: coral;*/
}    
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    max-height: calc(100vh - 200px);
    overflow-y: auto;
}
</style>   
    
 <!-- <style>
  
.modal-dialog{
          width: 700px;
		  margin-left:0;
		  /*z-index:-5px;*/
        }
.modal-header {
	width: 700px;
    background-color: #067EC6;
    padding:16px 16px;
    color:#FFF;
    border-bottom:2px #337AB7;
 }
 .modal-body {
	width: 700px;
    background-color: #FFF;
  
 }
	</style> -->
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
          <h1><i class="fa fa-th-list"></i> Setup Approval Disposal</h1>
          <p>Disposal Approval Setting</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"> Setup Approval Disposal</li>
          <li class="breadcrumb-item"><a href="display_setup_tbl_disposal.php">Disposal Approval Production Setting</a></li>
        </ul>
      </div>  
              <ul class="nav nav-tabs">
                 <li class="nav-item"><a class="nav-link" data-toggle="tab" href="">Add Setting</a></li>
                 <li class="nav-item"><a class="nav-link" href="display_setup_disposal_aprv.php">Display Setting</a></li>
                 <li class="nav-item"><a class="nav-link" href="display_setup_tbl_disposal.php">Disposal Approval Setting</a></li>
                 <li class="nav-item"><a class="nav-link active" href="display_setup_tbl_disposal-prod.php">Disposal Approval Production Setting</a></li>
              </ul>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
              
   <?php   
   
 
     //------------------------------end function --------------------------------
if (isset($_POST['submitTProc']))
{

  $status_accC = $_POST['status_accC'];
  $status_accD = $_POST['status_accD'];
  $status_accE = $_POST['status_accE'];
  
// check for a status_accC
if (empty($_POST['status_accC']))
{ 
$status_accC = FALSE;
  }

// check for a status_accD
if (empty($_POST['status_accD']))
{ 
$status_accD = FALSE;
  }
  
  // check for a status_accC
if (empty($_POST['status_accE']))
{ 
  $status_accE = FALSE;
  
  }else{
	  
 $status_accE = TRUE;	  
	  
  }
  
 
 if($status_accC || $status_accD || $status_accE )
 {

  $status_accC = addslashes($_POST['status_accC']);
  $status_accD = addslashes($_POST['status_accD']);
  $status_accE = addslashes($_POST['status_accE']);
 
 if($status_accC == "Y")
 {
	 $query_upd_A1 = "UPDATE sys_setup_disposal SET status_acc = 'Y' WHERE id = '1'";
	 $rs_upd_A1 = mysqli_query($dbc,$query_upd_A1);   //run the query.
 }else{
	 
	 $query_upd_A1 = "UPDATE sys_setup_disposal SET status_acc = 'N' WHERE id = '1'";
	 $rs_upd_A1 = mysqli_query($dbc,$query_upd_A1);   //run the query. 
	 
 }

 if($status_accD == "Y")
 {
	 $query_upd_A2 = "UPDATE sys_setup_disposal SET status_acc = 'Y' WHERE id = '2'";
	 $rs_upd_A2 = mysqli_query($dbc,$query_upd_A2);   //run the query.
 }else{
	 
	 $query_upd_A2 = "UPDATE sys_setup_disposal SET status_acc = 'N' WHERE id = '2'";
	 $rs_upd_A2 = mysqli_query($dbc,$query_upd_A2);   //run the query. 
	 
 }
 
 if($status_accE == "Y")
 {
	 $query_upd_A3 = "UPDATE sys_setup_disposal SET status_acc = 'Y' WHERE id = '3'";
	 $rs_upd_A3 = mysqli_query($dbc,$query_upd_A3);   //run the query.
 }else{
	 
	 $query_upd_A3 = "UPDATE sys_setup_disposal SET status_acc = 'N' WHERE id = '3'";
	 $rs_upd_A3 = mysqli_query($dbc,$query_upd_A3);   //run the query. 
	 
	 
 }

			echo "<script>";
			echo "alert('Disposal setup is successfully updated.');";
			echo "window.location='display_setup_disposal_aprv.php'";
			echo "</script>"; 
			exit(); 			
							
	 
 }else{
	 
	        echo "<script>";
			echo "alert('Error and failed updated.');";
			echo "window.location='display_setup_tbl_disposal-prod.php'";
			echo "</script>"; 
	 
	 
 }
 
 
 
         
 
 
 
}//end submit
     ?>         
              
              
              
              
              
              <form name="formEdit" id="everything" method="post" action="" class="needs-validation"  novalidate>
              
                 <?php

  
$queryProc = "SELECT * FROM sys_setup_disposal WHERE bil_table != '' ORDER BY id ASC";
$rsProc = mysqli_query($dbc,$queryProc);   //run the query.
$numProc = mysqli_num_rows($rsProc);   //how many material are there?


 
   $counter = 1;
   $no = 1;
   
  
?>
              <hr width="100%">  
                
                <!-- Delivery Instruction --->
              
               <p><b>Disposal Approval Production Setting</b></p>
               
               <?php
               
           while($rowProc = mysqli_fetch_array($rsProc))
   {        ?>
               
                <div class="form-group">
                 
                <?php if($rowProc["cat_acc"] == 'C'){ ?>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" id="status_accC" name="status_accC" value="Y" <?php if(($rowProc["status_acc"] == 'Y') && ($rowProc["cat_acc"] == 'C')){ ?> checked <?php  } ?>>Production Assy
                    </label>
                  </div><?php } ?>
                  <?php if($rowProc["cat_acc"] == 'D'){ ?>
                   <div class="form-check">
                    <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" id="status_accD" name="status_accD" value="Y" <?php if(($rowProc["status_acc"] == 'Y') && ($rowProc["cat_acc"] == 'D')){ ?> checked <?php  } ?>>Production Stamping
                    </label>
                  </div> <?php  } ?> 
                  <?php if($rowProc["cat_acc"] == 'E'){ ?>
                   <div class="form-check">
                    <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" id="status_accE" name="status_accE" value="Y" <?php if(($rowProc["status_acc"] == 'Y') && ($rowProc["cat_acc"] == 'E')){ ?> checked <?php  } ?>>HOD Production
                    </label>
                  </div><?php  } ?>
                </div>
               
            
           
          <?php 
		  
		//  $no++;
		//  $counter++; // menambah counter
		  }  ?>
               <input name="submitTProc" type="submit" id="submitTProc" value="UPDATE" class="btn btn-info" onClick="return confirm('Confirm to update?');" >                

           </form>   
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
    <!-- Data table plugin-->
    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
    
  </body>
</html>