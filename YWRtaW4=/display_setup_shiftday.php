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
	
	
	
$url = "display_setup_shiftday.php"; 
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
          <h1><i class="fa fa-th-list"></i> Setup Shift Day</h1>
          <p>Display Setting</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"> Setup Shift Day</li>
          <li class="breadcrumb-item"><a href="display_setup_shiftday.php">Display Shift Day</a></li>
        </ul>
      </div>  
            
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
              
                 <?php



								 
   $query8 = "SELECT COUNT(*) FROM shift_detail ORDER BY id_shift ASC";
   $result8 = mysqli_query($dbc,$query8) or die(mysqli_error($dbc));
   $num_rows = mysqli_fetch_row($result8);

  /* $pages = new Paginator;
   $pages->items_total = $num_rows[0];
   $pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
   $pages->paginate();*/
 
 
  
$query = "SELECT * FROM shift_detail ORDER BY id_shift ASC";
$rs = mysqli_query($dbc,$query);   //run the query.
$num = mysqli_num_rows($rs);   //how many material are there?


	
	 if ($num > 0) {
	 
	 echo '<div align="center">There are currently  '. html_esc($num_rows[0]).' record(s).</div>';
	 }

?>
                <table class="table table-hover table-bordered" id="sampleTable">
                  <thead>
                    <tr>
                    <th>No.</th>
                    <th>Shift Code</th>
                    <th>Shift Description</th>
                    <th>Time Start</th>
                    <th>Time End</th>
                    <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php
   
   $counter = 1;
   $no = 1;
   
   while($row = mysqli_fetch_array($rs))
   {
	   
	
	 
      ?> <tr>
            <td width="32"><?php echo $no; ?></td>
            <td><?php echo html_esc($row["shift_cd"]); ?></td>
            <td width="403"><?php echo html_esc($row["shift_desc"]); ?></td>
            <td><?php echo html_esc($row["time_start"]); ?></td>
            <td><?php echo html_esc($row["time_end"]); ?></td>
            <td>  <div align="center">
                 <a href="#myNoteEditM<?php echo html_esc($row["id_shift"]); ?>" data-toggle="modal" class="btn btn-warning square-btn-adjust"  target="_parent"><img src="../images/edit.gif" width="16" height="16" alt="Edit">&nbsp;Edit</a>
                 
                    <!--------------------------modal------------------------->
          <?php   include "shift_day_edit.php";   ?>
               </div>   </td>
         </tr>
          <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  }  ?>

                </tbody>
                </table>
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