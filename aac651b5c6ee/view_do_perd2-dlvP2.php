<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "2")) {
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
	
	
	
$url = "crt_do_perd2-dlvP2.php"; 

//CR status (New)

$sta = "SELECT * from request_status WHERE status_id = '1'";
$sta_res = mysqli_query($dbc,$sta);
$rst_sta = mysqli_fetch_array($sta_res);

//CR status (Released)
$sta2 = "SELECT * from request_status WHERE status_id = '2'";
$sta_res2 = mysqli_query($dbc,$sta2);
$rst_sta2 = mysqli_fetch_array($sta_res2);
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
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    
    
    
    <!-- jQuery library -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->

<!-- Bootstrap library -->
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
-->

    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
    <script language="javascript">
	$('.datepicker').pickadate({
	weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
	showMonthsShort: true
	})
	</script>
  </head>
  
  <body class="app sidebar-mini">
    <!-- Navbar-->
      <?php   include "top_modal_menu.php";   ?>
    
    
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <?php   include "left_prod_menu.php";   ?>
  
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> Delivery</h1>
          <p>View DO Perodua Global</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"> Delivery</li>
          <li class="breadcrumb-item"><a href="view_do_perd2-dlvP2.php">View DO Perodua Global</a></li>
        </ul>
      </div> 
      
              <ul class="nav nav-tabs">
                 <li class="nav-item"><a class="nav-link"  href="crt_do_perd2-dlvP2.php">Create New </a></li>
                 <li class="nav-item"><a class="nav-link active"  href="view_do_perd2-dlvP2.php">View DO Perodua</a></li>
               
              </ul>
                         
       <?php

	 
	   $message_do = "";
	   $message_shippt = "";
	   $message_psdt = "";
	   $message_psdt2 = "";
	   
	
// Set the page title and include the HTML header.
//include ('templates/header.inc');

if(isset($_POST['submitCT'])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

		 
ini_set("display_errors",0);		 
set_time_limit(0);

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
   

 $material_doc_gen = $_POST['material_doc_gen'];
 $ship_point = $_POST['ship_point'];
 $dateF = $_POST["date1"];
 $dateT = $_POST["date2"];

 	
 //check material doc gen
 	/*if(($_POST["material_doc_gen"]) == "")
     {
	     $material_doc_gen = FALSE;
		 $message_do = '<span class="badge badge-pill badge-danger"> Please enter DO Number!</span>';
	 }else{
		 $material_doc_gen = TRUE;
	  }	
*/
	  
  
  if($ship_point && $dateF && $dateT) //everything ok
 {  	
   
 $material_doc_gen = $_POST['material_doc_gen'];
 $ship_point = $_POST['ship_point'];
 $dateF = $_POST["date1"];
 $dateT = $_POST["date2"];
  

			echo "<script>";
            echo "window.location='view_do_perd2-dlvP2Proc2.php?material_doc_gen=$material_doc_gen&&ship_point=$ship_point&&date1=$dateF&&date2=$dateT'";
            echo "</script>";
            exit(); //quit the script   
			
			
			
       }
				  mysqli_close($dbc);   // close database conn
				

 } //----------------------end check upload /upload confirm -----------------------------------------------------------------	
 
	  		   
	
?>
      
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">View Delivery Order - Perodua Global</h3>
            <div class="tile-body">
         
         <form name="form1" action="view_do_perd2-dlvP2.php" method="post" class="form-horizontal">
                   <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="2">&nbsp;</th>
            </tr>
             <tr>
                <th>DI/PDIO Number : </th>
                <th colspan="2">
           <input class="form-control" id="material_doc_gen" type="text" placeholder="Enter DI/PDIO Number" name="material_doc_gen" value="<?php if(isset($_POST['material_doc_gen'])){ echo html_esc($_POST['material_doc_gen']); } ?>" />    
          <div class="form-control-feedback" ><?php //echo $message_do; ?></div>
           
               </th>
              </tr>
            <tr>
            <th>Ship to Party : <font color="#FF0000">*</font></th>
            <td colspan="2">
           <input class="form-control" id="ship_point" type="text" placeholder="Enter Ship to Party" name="ship_point" value="<?php if(isset($_POST['ship_point'])){ echo html_esc($_POST['ship_point']); }else{ echo "100124";   } ?>" readonly />
         <div class="form-control-feedback" ><?php echo $message_shippt; ?></div>
		     </td>
             </tr>
               <tr>
                <th>Delivery Date from :  <font color="#FF0000">*</font></th>
                <td colspan="3"><input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php if(isset($_POST['date1'])){ echo html_esc($_POST['date1']); }else{ echo $fmt_curr_date; } ?>" /> <div class="form-control-feedback" ><?php echo $message_psdt; ?></div>
                  
                    </td></tr>
                <tr>
                <th>Delivery Date to :  <font color="#FF0000">*</font></th>
                <td colspan="3"><input class="form-control" id="PSSDate2" type="text" placeholder="Select Date" name="date2" value="<?php if(isset($_POST['date2'])){ echo html_esc($_POST['date2']); }else{ echo $fmt_curr_date; } ?>" /><div class="form-control-feedback" ><?php echo $message_psdt2; ?></div></td>
              </tr>
              
              <tr>
                <th><input name="submitCT" type="submit" class="btn btn-info" id="button" value="SEARCH" /></th>
                <th colspan="2">&nbsp;</th>
              </tr>
            
                </table>
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
    <!-- Data table plugin-->
    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
    
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-notify.min.js"></script>
    <script type="text/javascript" src="js/plugins/sweetalert.min.js"></script>
    <script type="text/javascript">
          
       $('#PSSDate').datepicker({
		defaultDate: new Date(),
		format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      
	   $('#PSSDate2').datepicker({
		defaultDate: new Date(),   
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
	   $('#PSSDate3').datepicker({
		defaultDate: new Date(),   
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      $('#demoSelect').select2();
    </script>
  
  
  </body>
</html>