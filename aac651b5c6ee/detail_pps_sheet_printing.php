<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("dmY"));


                 $drun = substr($fmt_curr_date,2,2);
				 $mrun = substr($fmt_curr_date,3,2);
				 $yrun = substr($fmt_curr_date,6,2);
				 
				 $date_run = ($drun.$mrun.$yrun);

set_time_limit(0);
// include 2D barcode class (search for installation path)
require_once('tcpdf_barcodes_2d.php');


// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------		

//CR status (New)

$sta = "SELECT * from request_status WHERE status_id = '1' ";
$sta_res = mysqli_query($dbc,$sta);
$rst_sta = mysqli_fetch_array($sta_res);

//CR status (Released)
$sta2 = "SELECT * from request_status WHERE status_id = '2' ";
$sta_res2 = mysqli_query($dbc,$sta2);
$rst_sta2 = mysqli_fetch_array($sta_res2);	

//CR status (Cancel)
$sta4 = "SELECT * from request_status WHERE status_id = '4' ";
$sta_res4 = mysqli_query($dbc,$sta4);
$rst_sta4 = mysqli_fetch_array($sta_res4);
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
    
    <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        $("#myModalXX").modal('show');
    });
</script>
    
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>


</head>
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
function printWindow() {
bV = parseInt(navigator.appVersion);
if (bV >= 4) window.print();
}

//  End -->
</script>
<script>
function myFunction() {
    window.print();
}
</script>
<?php

function encode($ss,$ntime){
    for($i=0;$i<$ntime;$i++){
        $ss=base64_encode($ss);
    }
return $ss;
}


function decode($ss,$ntime){
    for($i=0;$i<$ntime;$i++){
        $ss=base64_decode($ss);
    }
return $ss;
}

//- First page:
$url = 'upload_pps_month.php';

?>

<body class="app sidebar-mini">
<div class="widget-box">

  <?php

 $upload_id = $_GET["upload_id"];
 $plant_code = $_GET["plant_code"];
 
   $number = "";
    
 
 
   if(isset($_POST['submit3'])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.


// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}
// create a function for escaping the data.
function escape_data ($data) {
global $dbc;   // need the connection.
if (ini_get('magic_quotes_gpc')) {
    $data = stripslashes($data);
	}
	return mysqli_real_escape_string($data,$dbc);
	}   // end function.
$message = NULL; // create an empty new variable.	
	

  $upload_id = $_POST["upload_id"];
 
      $query_by_batch = "SELECT * from pps_detail WHERE upload_id = '".sql_esc($upload_id)."'";
      $result_by_batch = mysqli_query($dbc,$query_by_batch);   //run the query.
		
		
      $counter = 1;
      $no = 1;
	  $i = 1; 
	
     if($plant_code == '2300')
  {
  
  //------generate Planned Order No. [2300].---------------------------------
	
	$query_id = "SELECT count_max FROM run_count_itsb WHERE uid = '4'";
	$result_id = mysqli_query($dbc,$query_id);
	
  }elseif($plant_code == '2301')
  {
	  
	 //------generate Planned Order No. [2300].---------------------------------
	
	$query_id = "SELECT count_max FROM run_count_itsb WHERE uid = '59'";
	$result_id = mysqli_query($dbc,$query_id);  
	  
   } //end elseif
	
	if ($result_id) 
{
	$nrows = mysqli_num_rows($result_id);
	$row_id = mysqli_fetch_row($result_id);
	
	$dht = 0000000; 
	$dht_OK = "";
	$dg2 = 0;
	$number2 = "";
				 
  	if($row_id[0] <= 0)
  	{ 
   
    	$lastID = ($row_id[0] + 1);
    	$dg = ($dht + ($lastID));
   }
   else
   {
      $lastID = ($row_id[0] + 1);
      $dg =  $lastID;
	
    }
	$number2 = $dg; // Length of running no
    $number = sprintf('%07d', $number2);  
	
	  $ref = ($plant_code.($number));
	
	 
	
	} // end if $result_id
  
 
   while($row_by_batch = mysqli_fetch_array($result_by_batch))
   {
   
   
   
    $query_update = "UPDATE pps_detail SET plan_no = '".sql_esc($ref)."', status_pps = '".sql_esc($rst_sta["status_desc"])."', user_update = '".sql_esc($username)."', date_update = NOW(), user_posting = '".sql_esc($username)."', date_posting = NOW() WHERE id = '".sql_esc($row_by_batch["id"])."'";
    $result_update = mysqli_query($dbc,$query_update); 
   
    $counter++; // menambah counter 
    $no++; 
    $ref++; 
    $number2++;
   
   
   }
  
    //update count_max---------------------------------------- 
		 if($plant_code == '2300')
        {  
	    
		$new_number = ($number2 - 1);
	  
		$query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($new_number)."', date_updated = NOW() WHERE uid = '4'";
	    $result_max_a = mysqli_query($dbc,$query_max_a); 
		
		}elseif($plant_code == '2301')
        {  
		
		$new_number = ($number2 - 1);
		
		$query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($new_number)."', date_updated = NOW() WHERE uid = '59'";
	    $result_max_a = mysqli_query($dbc,$query_max_a); 
		
		
		}
	
	     //end update count_max ---------------------------------	
  
	  
	  
  
		   echo "<script>";
		   echo "alert('Successfully upload the data.');";
		   echo "location.href = 'upload_pps_month.php';";
		  // echo "window.open('printing_pps_sheet_release.php?upload_id=$upload_id')";
		   echo "</script>"; 
		   exit(); //quit the script
	
} // end if submit3


	
  if(isset($_POST['submit9'])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

$upload_id = $_POST["upload_id"];


//--------------update status_pps = 'Cancel' in table pps_detail------------------
         $query_update_sta = "UPDATE pps_detail SET status_pps = '".sql_esc($rst_sta4["status_desc"])."', user_update = '".sql_esc($username)."', date_update = NOW(), user_posting = '".sql_esc($username)."', date_posting = NOW() WHERE upload_id = '".sql_esc($upload_id)."'";
         $result_update_sta = mysqli_query($dbc,$query_update_sta);


           echo "<script>";
		   echo "alert('Successfully cancel the data.');";
		   echo "location.href = 'upload_pps_month.php';";
		   echo "</script>"; 
		   exit(); //quit the script

}//end if submit9
 
 ?>
 </div>

 <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-notify.min.js"></script>
    <script type="text/javascript" src="js/plugins/sweetalert.min.js"></script>
   
 
 
           
</body>
</html>
