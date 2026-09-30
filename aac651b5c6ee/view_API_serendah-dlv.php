<?php
session_start();
$username = $_SESSION['username'];
include __DIR__ . '/config.php';


$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));
$fmt_curr_time = (date("H:i:s"));
$pick_curr_time = (date("H:i a"));
$yearSkrg = (date("Y"));

if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "2")) {
header('Location: ../index.php');
exit();
}

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);



$url = "api_pdio_serendah.php";

 //CR status (New)
 $sta = "SELECT * from request_status WHERE status_id = '1'";
 $sta_res = mysqli_query($dbc,$sta);
 $rst_sta = mysqli_fetch_array($sta_res);

 //CR status (Released)
 $sta2 = "SELECT * from request_status WHERE status_id = '2'";
 $sta_res2 = mysqli_query($dbc,$sta2);
 $rst_sta2 = mysqli_fetch_array($sta_res2);

 //CR status (Approved)
 $sta3 = "SELECT * from request_status WHERE status_id = '3'";
 $sta_res3 = mysqli_query($dbc,$sta3);
 $rst_sta3 = mysqli_fetch_array($sta_res3);

 //CR status (Cancelled)
 $sta4 = "SELECT * from request_status WHERE status_id = '4'";
 $sta_res4 = mysqli_query($dbc,$sta4);
 $rst_sta4 = mysqli_fetch_array($sta_res4);

 //CR status (Rejected)
 $sta5 = "SELECT * from request_status WHERE status_id = '5'";
 $sta_res5 = mysqli_query($dbc,$sta5);
 $rst_sta5 = mysqli_fetch_array($sta_res5);

 //CR status (Draft)
 $sta6 = "SELECT * from request_status WHERE status_id = '6'";
 $sta_res6 = mysqli_query($dbc,$sta6);
 $rst_sta6 = mysqli_fetch_array($sta_res6);

 //CR status (In Progress)
 $sta7 = "SELECT * from request_status WHERE status_id = '7'";
 $sta_res7 = mysqli_query($dbc,$sta7);
 $rst_sta7 = mysqli_fetch_array($sta_res7);


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
          <p>View Upload PDIO (API)</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"> Delivery</li>
          <li class="breadcrumb-item"><a href="view_API_serendah-dlv.php">View Upload PDIO (API)</a></li>
        </ul>
      </div>

             <ul class="nav nav-tabs">
                 <li class="nav-item"><a class="nav-link" href="ups_pdio_serendah.php">Upload PDIO</a></li>
                 <li class="nav-item"><a class="nav-link"  href="view_pdio_serendah-dlv.php">View Upload PDIO</a></li>
                 <li class="nav-item"><a class="nav-link"  href="api_pdio_serendah.php">Upload PDIO (API)</a></li>
                 <li class="nav-item"><a class="nav-link active"  data-toggle="tab" href="view_API_serendah-dlv.php">View Upload PDIO (API)</a></li>

              </ul>

       <?php

	   $message_file = "";
	   $message_shippt = "";
	   $message_cust = "";


if(isset($_POST['submitCT']))
{ // handle the form.

require_once(__DIR__ . '/config.php');   //connect to the db.


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


 $cust_code = $_POST['cust_code'];
 $ship_point = $_POST['ship_point'];
 $pdio_no = $_POST['pdio_no'];
 $dateF = $_POST["date1"];
 $dateT = $_POST["date2"];

 //----get ship point extract string -----
 $plant_dlv = substr($ship_point,0,4);

// check for cust code

	if(($_POST["cust_code"]) == "NULL")
     {
	     $cust_code = FALSE;
		 $message_cust = '<span class="badge badge-pill badge-danger"> Please select Customer!</span>';
	 }else{
		 $cust_code = TRUE;
	  }


  if ($ship_point && $cust_code && $dateT && $dateF) //everything ok
 {

  $cust_code = $_POST["cust_code"];
  $ship_point = $_POST['ship_point'];
  $pdio_no = $_POST['pdio_no'];
  $dateF = $_POST["date1"];
  $dateT = $_POST["date2"];


			      echo "<script>";
            echo "window.location='view_API_serendah-dlvProc2.php?ship_point=$plant_dlv&&cust_code=$cust_code&&date1=$dateF&&date2=$dateT&&pdio_no=$pdio_no'";
            echo "</script>";
            exit(); //quit the script



       }


 } //----------------------end check upload /upload confirm -----------------------------------------------------------------



?>

        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">View Upload PDIO (API)</h3>
            <div class="tile-body">

         <form name="form1" action="view_API_serendah-dlv.php" method="post" class="form-horizontal">
                   <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="2">&nbsp;</th>
            </tr>

            <tr>
            <th>Shipping Point : <font color="#FF0000">*</font></th>
            <td colspan="2">
           <input class="form-control" id="ship_point" type="text" placeholder="Enter Shipping Point" name="ship_point" value="<?php if(isset($_POST['ship_point'])){ echo html_esc($_POST['ship_point']); }else{ echo "3100 - SERENDAH";   } ?>" readonly />
         <div class="form-control-feedback" ><?php echo $message_shippt; ?></div>
		     </td>
             </tr>
             <tr>
              <th>Customer : <font color="#FF0000">*</font></th>
              <td colspan="2">
                  <select name="cust_code" id="cust_code" class="form-control">
                  <option value="NULL" placeholder="Select Customer"> -- Select Customer --</option>
                  <?php

	               $query19 = "SELECT * FROM cust_detail WHERE cust_ID = 'PERODUA' AND status_cust = 'Y' ORDER BY id_cust ASC";
                   $result19 = mysqli_query($dbc,$query19);

                   while($row19 = mysqli_fetch_array($result19))
			      {
				   ?>
                     <option value="<?php echo html_esc($row19["id_cust"]); ?>"> <?php echo html_esc($row19["id_cust"]); ?> - <?php echo html_esc($row19["cust_desc"]); ?></option>

                  <?php
                  }
				?>
              </select>
              <div class="form-control-feedback" ><?php echo $message_cust; ?></div></td>
              </tr>
              <tr>
                <th>Delivery Date from : <font color="#FF0000">*</font></th>
                <td colspan="3"><input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php if(isset($_POST['date1'])){ echo html_esc($_POST['date1']); }else{ echo $fmt_curr_date; } ?>" />
                    </td></tr>
               <tr>
                <th>Delivery Date to :  <font color="#FF0000">*</font></th>
                <td colspan="3"><input class="form-control" id="PSSDate2" type="text" placeholder="Select Date" name="date2" value="<?php if(isset($_POST['date2'])){ echo html_esc($_POST['date2']); }else{ echo $fmt_curr_date; } ?>" /></td>
              </tr>
              <tr>
                <th>PDIO Number : </th>
                <th colspan="3">
           <input class="form-control" id="pdio_no" type="text" placeholder="Enter PDIO Number" name="pdio_no" value="<?php if(isset($_POST['pdio_no'])){ echo html_esc($_POST['pdio_no']); } ?>" />

               </th>
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
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
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

      
    </script>



  </body>
</html>
