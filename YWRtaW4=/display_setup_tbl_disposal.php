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
          <li class="breadcrumb-item"><a href="display_setup_tbl_disposal.php">Disposal Approval Setting</a></li>
        </ul>
      </div>  
              <ul class="nav nav-tabs">
                 <li class="nav-item"><a class="nav-link" data-toggle="tab" href="">Add Setting</a></li>
                 <li class="nav-item"><a class="nav-link" href="display_setup_disposal_aprv.php">Display Setting</a></li>
                 <li class="nav-item"><a class="nav-link active" href="display_setup_tbl_disposal.php">Disposal Approval Setting</a></li>
                 <li class="nav-item"><a class="nav-link" href="display_setup_tbl_disposal-prod.php">Disposal Approval Production Setting</a></li>
              </ul>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
              
   <?php           
     //------------------------------end function --------------------------------
if (isset($_POST['submitT']))
{
	
   $bil_table = $_POST['bil_table'];
  
// check for a vendor no
if (empty($_POST['bil_table']))
{ 
$bil_table = FALSE;
  }

 
 
 if($bil_table)
 {

 $bil_table = $_POST['bil_table'];	 
 
    if($bil_table == "4")
	{
	//echo "A";	
	 $query_upd_A1 = "UPDATE sys_setup_disposal SET bil_table = '4', cat_acc = 'C' WHERE id = '1'";
	 $rs_upd_A1 = mysqli_query($dbc,$query_upd_A1);   //run the query.

	 $query_upd_A2 = "UPDATE sys_setup_disposal SET bil_table = '4', cat_acc = 'D' WHERE id = '2'";
	 $rs_upd_A2 = mysqli_query($dbc,$query_upd_A2);   //run the query.
	
	 $query_upd_A3 = "UPDATE sys_setup_disposal SET bil_table = '4', cat_acc = 'E' WHERE id = '3'";
	 $rs_upd_A3 = mysqli_query($dbc,$query_upd_A3);   //run the query.
	 
	 $query_upd_A4 = "UPDATE sys_setup_disposal SET bil_table = '4', cat_acc = 'A' WHERE id = '4'";
	 $rs_upd_A4 = mysqli_query($dbc,$query_upd_A4);   //run the query.
	 
	 $query_upd_A5 = "UPDATE sys_setup_disposal SET bil_table = '4', cat_acc = 'A' WHERE id = '5'";
	 $rs_upd_A5 = mysqli_query($dbc,$query_upd_A5);   //run the query.
		
	}elseif($bil_table == "5")
    {
	 
	// echo "B";	
	 $query_upd_B1 = "UPDATE sys_setup_disposal SET bil_table = '5', cat_acc = 'C' WHERE id = '1'";
	 $rs_upd_B1 = mysqli_query($dbc,$query_upd_B1);   //run the query.

	 $query_upd_B2 = "UPDATE sys_setup_disposal SET bil_table = '5', cat_acc = 'D' WHERE id = '2'";
	 $rs_upd_B2 = mysqli_query($dbc,$query_upd_B2);   //run the query.
	
	 $query_upd_B3 = "UPDATE sys_setup_disposal SET bil_table = '5', cat_acc = 'E' WHERE id = '3'";
	 $rs_upd_B3 = mysqli_query($dbc,$query_upd_B3);   //run the query.
	 
	 $query_upd_B4 = "UPDATE sys_setup_disposal SET bil_table = '5', cat_acc = 'B' WHERE id = '4'";
	 $rs_upd_B4 = mysqli_query($dbc,$query_upd_B4);   //run the query.
	 
	 $query_upd_B5 = "UPDATE sys_setup_disposal SET bil_table = '5', cat_acc = 'B' WHERE id = '5'";
	 $rs_upd_B5 = mysqli_query($dbc,$query_upd_B5);   //run the query.
		
	

     }else{ } // end
	 


			echo "<script>";
			echo "alert('Disposal setup is successfully updated.');";
			echo "window.location='display_setup_disposal_aprv.php'";
			echo "</script>"; 
			exit(); 			
							
	 
 }else{
	 
	        echo "<script>";
			echo "alert('Error and failed updated.');";
			echo "window.location='display_setup_tbl_disposal.php'";
			echo "</script>"; 
	 
	 
 }
 
 
 
         
 
 
 
}//end submit
     ?>         
              
              
              
              
              
              <form name="formEdit" id="everything" method="post" action="" class="needs-validation"  novalidate>
              
                 <?php

  
$query = "SELECT * FROM sys_setup_disposal GROUP BY bil_table ORDER BY id ASC";
$rs = mysqli_query($dbc,$query);   //run the query.
$num = mysqli_num_rows($rs);   //how many material are there?


 
   $counter = 1;
   $no = 1;
   
   while($row = mysqli_fetch_array($rs))
   {
?>
              <hr width="100%">  
                
                <!-- Delivery Instruction --->
              
               <p><b>Disposal Approval Setting</b></p>
               
               
               
                <div class="form-group">
                 
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="form-check-input" type="radio" id="bil_table" name="bil_table" value="4" <?php if($row["bil_table"] == '4'){ ?> checked <?php  } ?>>HOD QC
                    </label>
                  </div>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="form-check-input" type="radio" id="bil_table" name="bil_table" value="5" <?php if($row["bil_table"] == '5'){ ?> checked <?php  } ?>>COO/CEO
                    </label>
                  </div>
                </div>
               
            
           
          <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  }  ?>
               <input name="submitT" type="submit" id="submitT" value="UPDATE" class="btn btn-info" onClick="return confirm('Confirm to update?');" >                

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