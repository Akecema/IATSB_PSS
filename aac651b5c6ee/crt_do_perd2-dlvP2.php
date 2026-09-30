<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
require_once "excel_reader2.php"; 
date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));

         $drun = substr($fmt_curr_date,0,2);
				 $mrun = substr($fmt_curr_date,3,2);
				 $yrun = substr($fmt_curr_date,8,2);
				 
				 $date_run = ($drun.$mrun.$yrun);

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "2")) {
header('Location: ../index.php');
exit();
}

$masa = (date("H:m:s"));

      $query_shtA = "SELECT * FROM shift_detail WHERE id_shift = '1'";
		  $result_shtA = mysqli_query($dbc,$query_shtA);
		  $data_shtA = mysqli_fetch_array($result_shtA); 
		  
		 //----shift posting ----
		 
		 if(($masa >= $data_shtA["time_start"]) && ($masa <= $data_shtA["time_end"]))
		 {
			 
		 $shif_pA = "Day"; 
		 $shift_chkA = "D/S";
		 
		 }else
		 {
		 
		 $shif_pA = "Night"; 
		 $shift_chkA = "N/S";
		
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
	
	
	
$url = "crt_do_perd2-dlvP2.php"; 

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

//CR status (In Progress)
$sta7 = "SELECT * from request_status WHERE status_id = '7'";
$sta_res7 = mysqli_query($dbc,$sta7);
$rst_sta7 = mysqli_fetch_array($sta_res7);

//CR status (Pending)
$sta8 = "SELECT * from request_status WHERE status_id = '8'";
$sta_res8 = mysqli_query($dbc,$sta8);
$rst_sta8 = mysqli_fetch_array($sta_res8);

//CR status (Closed)
$sta13 = "SELECT * from request_status WHERE status_id = '13'";
$sta_res13 = mysqli_query($dbc,$sta13);
$rst_sta13 = mysqli_fetch_array($sta_res13);

//CR status (Completed)
$sta14 = "SELECT * from request_status WHERE status_id = '14'";
$sta_res14 = mysqli_query($dbc,$sta14);
$rst_sta14 = mysqli_fetch_array($sta_res14);

//CR status (Deleted)
$sta16 = "SELECT * from request_status WHERE status_id = '16'";
$sta_res16 = mysqli_query($dbc,$sta16);
$rst_sta16 = mysqli_fetch_array($sta_res16);


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
     <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
    <!-- <script src="https://www.w3schools.com/lib/w3.js"></script>-->
	
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
    <script language="javascript">
document.addEventListener('DOMContentLoaded', function () {
	$('.datepicker').pickadate({
	weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
	showMonthsShort: true
	})
	
});
</script>
   
    <style>
input[value="+ Scan Item"]{
  display:none;
}
	

</style>
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
          <p>Create DO Perodua Global</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"> Delivery</li>
          <li class="breadcrumb-item"><a href="crt_do_perd2-dlvP2.php">Create DO Perodua Global</a></li>
        </ul>
      </div> 
      
              <ul class="nav nav-tabs">
                 <li class="nav-item"><a class="nav-link active"  href="crt_do_perd2-dlvP2.php">Create New </a></li>
                 <li class="nav-item"><a class="nav-link"  href="view_do_perd2-dlvP2.php">View DO Perodua</a></li>
               
              </ul>
              
       <?php

	   $message_file = ""; 
	   $message_so = "";
	   $message_p2qr = "";
	   $message_iaqr = "";
	   $message_tripno = "";
	   
	  if($res["plant_code"] == '3100')
	{
	
	$query_id = "SELECT * FROM run_count_itsb WHERE uid = '128'";
	$result_id = mysqli_query($dbc,$query_id);
	
	}elseif($res["plant_code"] == '3101')
	{
		
	$query_id = "SELECT * FROM run_count_itsb WHERE uid = '129'";
	$result_id = mysqli_query($dbc,$query_id);	
		
	}
   

	if ($result_id) 
{
	$nrows = mysqli_num_rows($result_id);
	$row_id = mysqli_fetch_array($result_id);
	
	$dht = 000; 
	//$dht_OK = "211";
	$dg2 = 0;

  	if($row_id["count_max"] <= 0)
  	{ 
   
    	$lastID = ($row_id["count_max"] + 1);
    	$dg = ($dht + ($lastID));
   }
   else
   {
      $lastID = ($row_id["count_max"] + 1);
      $dg =  $lastID;
	
    }
	$number = $dg; // Length of running no
    $number = sprintf('%07d',$number);  
	
	$ref = $number;
	  
	
	} // end if $result_id	
	   
	
// Set the page title and include the HTML header.
//include ('templates/header.inc');

if((isset($_POST["submit8"]))  && $_POST!=="") 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

 $so_no = $_POST['so_no'];

//checking delete space semasa scanning

$so_no2 = trim($so_no);
			
 
//split dulu pps ref kpd prod_order, material,uom, plant, sloc, qty
$str = $so_no2;

if($str)
{

if(explode('|', $str, 2))
{
list($part1, $part2) = (explode('|', $str, 2));	


	 //-------------update so_detail_dlv---------
		
            $query_chk_cust = "SELECT * FROM so_detail_dlv WHERE so_no = '".sql_esc($part1)."' AND ship_no = '100124' ";
					  $result_chk_cust = mysqli_query($dbc,$query_chk_cust);  
					  $rst_chk_cust = mysqli_fetch_array($result_chk_cust); 
					  
					  if($rst_chk_cust > 1)
					  {
						  
					  }else{
			

						  if(($part2)  == "100124")
							 {
			
								 
							 }else{
						
							  echo "<script>";
							  echo "alert('ERROR! Please Scan Correct Menu');";
							  echo "window.location='crt_do_perd2-dlvP2.php'";
							  echo "</script>";
							  exit(); //quit the script	 
						 
							 }
				 
					  }  // end $rst_chk_cust
		
		

}






} // end str
        

if($_POST["so_no"] != "")
{ 	

//-----------get info detail cust_detail

$query_cust_info = "SELECT * FROM cust_detail WHERE id_cust = '100124'";
$result_cust_info = mysqli_query($dbc,$query_cust_info);  
$rst_cust_info = mysqli_fetch_array($result_cust_info); 

$curr_month = date('m', strtotime($currentdate));

//------so ftp SAP ------

$query_info_so2 = "SELECT * FROM so_detail_dlv WHERE so_no = '".sql_esc($part1)."' AND ship_no = '".sql_esc($part2)."' AND status_so = '".sql_esc($rst_sta["status_desc"])."' AND (sold_no = '100124') AND doc_month = '".sql_esc($curr_month)."'";
$result_info_so2 = mysqli_query($dbc,$query_info_so2);

while($rst_info_so2 = mysqli_fetch_array($result_info_so2))
{


 //Add the record to the database
$query_perodua = "INSERT INTO scan_so_perodua1(id,scan_gen,material_doc_gen,so_no,ship_no,ship_name,doc_gen,user_create,date_create,time_create,status_so,user_posting,date_posting,time_posting,plant_code,dlv_date,trip_no,shift_ops,doc_month,status_DO,material_no,item_no,qty_order,unit_order,matl_group,ship_point,pdio_no) VALUES ('','".sql_esc($ref)."','','".sql_esc($part1)."','100124','".sql_esc($rst_cust_info["cust_desc"])."','".sql_esc($rst_info_so2["doc_gen"])."','".sql_esc($username)."',NOW(),NOW(),'N','','','','3100','','','','".sql_esc($rst_info_so2["doc_month"])."','New','".sql_esc($rst_info_so2["material_no"])."','".sql_esc($rst_info_so2["item_no"])."','".sql_esc($rst_info_so2["qty_upload"])."','".sql_esc($rst_info_so2["unit_upload"])."','".sql_esc($rst_info_so2["matl_group"])."','".sql_esc($rst_info_so2["ship_point"])."','')";
$result_perodua = mysqli_query($dbc,$query_perodua);   

}

$query_all_donum = new PreparedSql("SELECT * FROM scan_crt_donum WHERE id_DO = ? AND status_acc = 'N'", [$ref]);
$result_all_donum = db_query($dbc, $query_all_donum);  
$rst_all_donum  = mysqli_fetch_array($result_all_donum); 


if($rst_all_donum < 1 )
{

//Add the record scan update no
$query_ref_perodua = new PreparedSql("INSERT INTO scan_crt_donum(id,id_DO,status_acc,user_create,date_create) VALUES ('',?,'N',?,NOW())", [$ref, $username]);
$result_ref_perodua = db_query($dbc, $query_ref_perodua) or die (mysqli_error($dbc));  

 

}else{
	
	
}

}// end  if SO scan
	
}  // end submit8





if(isset($_POST["submit10Y"]))
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

// $p2_barcode = $_POST['p2_barcodeW'];
 $ref_id = $_POST['ref_id'];
 $ia_barcode = $_POST['ia_barcode'];
 $so_no = $_POST['so_noA'];

	
} // end submit10


if(isset($_POST["submit9Y"]))
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

  $p2_barcode = $_POST['p2_barcodeW'];
  $ref_id = $_POST['ref_id'];
  $ia_barcode = $_POST['ia_barcode'];
  $so_no = $_POST['so_noA2'];


	
} // end submit9





if(isset($_POST['submitTT'])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

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
   
   
 $so_no = $_POST['so_noA'];
 $p2_barcode = $_POST['p2_barcodeW'];
 $ia_barcode = $_POST['ia_barcode'];
 $trip_no = $_POST['trip_no'];
 $ref_id = $_POST['ref_id'];
 $shift_ops = $_POST['shift_ops'];
 $date1 = $_POST['date1'];

  if(($_POST["p2_barcodeW"]) != "")
{ 	

 $query_chk_P2 = "SELECT * FROM scan_so_perodua1 WHERE pdio_no = '".sql_esc($_POST['p2_barcodeW'])."' AND scan_gen != '".sql_esc($ref)."'";
 $result_chk_P2 = mysqli_query($dbc,$query_chk_P2);  
 $rst_chk_P2 = mysqli_fetch_array($result_chk_P2); 
 
 if($rst_chk_P2 > 1)
 {
 
  $p2_barcode = FALSE;

   echo "<script>";
   echo "alert('ERROR! PDIO is already exist');";
   echo "window.location='crt_do_perd2-dlvP2.php'";
   echo "</script>";
   exit(); //quit the script	 


 }

} // p2_barcodeW 
 
 
  if(($_POST["shift_ops"]) == "")
	{ 
	
	         $shift_ops = FALSE;
	
	          echo "<script>";
		      	echo "alert('Please select Shift Posting.');";
            echo "window.location='crt_do_perd2-dlvP2.php?scan_gen=$ref&&so_no=$so_no&&ia_barcode=$ia_barcode&&p2_barcodeW=$p2_barcode&&trip_no=$trip_no&&shift_ops=$shift_ops';";
            echo "</script>";
          //  exit(); //quit the script 

	
	}	
	
	if(($_POST["trip_no"]) == "NULL")
	{ 
	
	         $trip_no = FALSE;
	
	          echo "<script>";
			      echo "alert('Please select Trip No.');";
            echo "window.location='crt_do_perd2-dlvP2.php?scan_gen=$ref&&so_no=$so_no&&ia_barcode=$ia_barcode&&p2_barcodeW=$p2_barcode&&trip_no=$trip_no&&shift_ops=$shift_ops';";
            echo "</script>";
          //  exit(); //quit the script 

	
	}	
 
 
   if($_POST['ia_barcode'] == "")
	{ 
	
	
	}else{ //  if IA Tag xde
 
 //$p2_barcodeT = trim($p2_barcode);
 $ia_barcode2 = trim($ia_barcode);
 

 //split dulu pps re f kpd prod_order, material,uom, plant, sloc, qty
$str_ia = $ia_barcode2;

if($str_ia)
{

if(explode('|', $str_ia, 10))
{
list($part1A, $part2A, $part3A, $part4A, $part5A, $part6A, $part7A, $part8A, $part9A, $part10A) = (explode('|', $str_ia, 10));	

}

}


	}//end if IA Tag

  if($_POST["ia_barcode"] != "")
  { 	


    if($so_no == "")
    {
  
   // $query_chk_P2B = "SELECT * FROM so_detail_dlv WHERE material_no = '".$part1A."' AND so_no = '".$so_no."' AND ship_no = '100124'";
    $query_chk_P2B = "SELECT * FROM so_detail_dlv WHERE material_no = '".sql_esc($part1A)."' AND ship_no = '100124'";
    $result_chk_P2B = mysqli_query($dbc,$query_chk_P2B);  
    $rst_chk_P2B = mysqli_fetch_array($result_chk_P2B); 
    
    if($rst_chk_P2B > 1)
    {
  
    }else{
    
      $ia_barcode = FALSE;
  
     
      echo "<script>";
      echo "alert('ERROR! Material is not exist');";
      echo "window.location='crt_do_perd2-dlvP2.php?scan_gen=$ref&&so_no=$so_no&&ia_barcode=$ia_barcode&&p2_barcodeW=$p2_barcode&&trip_no=$trip_no&&shift_ops=$shift_ops'";
      echo "</script>";
      exit(); //quit the script	 
     
     
    } // $rst_chk_P2B

  }else{

      $query_chk_P2B = "SELECT * FROM so_detail_dlv WHERE material_no = '".sql_esc($part1A)."' AND so_no = '".sql_esc($so_no)."' AND ship_no = '100124'";
      $result_chk_P2B = mysqli_query($dbc,$query_chk_P2B);  
      $rst_chk_P2B = mysqli_fetch_array($result_chk_P2B); 

      if($rst_chk_P2B > 1)
      {

      }else{

        $ia_barcode = FALSE;

      
        echo "<script>";
        echo "alert('ERROR! Material is not exist');";
        echo "window.location='crt_do_perd2-dlvP2.php?scan_gen=$ref&&so_no=$so_no&&ia_barcode=$ia_barcode&&p2_barcodeW=$p2_barcode&&trip_no=$trip_no&&shift_ops=$shift_ops'";
        echo "</script>";
        exit(); //quit the script	 
      
      
      } // $rst_chk_P2B



  }
  
	

//53702-BZ830|3100|31000000148|3100211050423172|05042023|S1W02|5|PCS|D55L|IAT002
//-----------get info detail cust_detail

$query_cust_info = "SELECT * FROM cust_detail WHERE id_cust = '100124'";
$result_cust_info = mysqli_query($dbc,$query_cust_info);  
$rst_cust_info = mysqli_fetch_array($result_cust_info); 

$curr_month = date('m', strtotime($currentdate));

 //------so ftp SAP ------
 
 $query_info_so2 = "SELECT * FROM so_detail_dlv WHERE material_no = '".sql_esc($part1A)."' AND ship_no = '100124' AND status_so = '".sql_esc($rst_sta["status_desc"])."' AND (sold_no = '100124') AND doc_month = '".sql_esc($curr_month)."'";
 $result_info_so2 = mysqli_query($dbc,$query_info_so2);
 
 while($rst_info_so2 = mysqli_fetch_array($result_info_so2))
 {
 
 
  //Add the record to the database
 $query_perodua = "INSERT INTO scan_so_perodua1(id,scan_gen,material_doc_gen,so_no,ship_no,ship_name,doc_gen,user_create,date_create,time_create,status_so,user_posting,date_posting,time_posting,plant_code,dlv_date,trip_no,shift_ops,doc_month,status_DO,material_no,item_no,qty_order,unit_order,matl_group,ship_point,pdio_no) VALUES ('','".sql_esc($ref)."','','".sql_esc($rst_info_so2["so_no"])."','100124','".sql_esc($rst_cust_info["cust_desc"])."','".sql_esc($rst_info_so2["doc_gen"])."','".sql_esc($username)."',NOW(),NOW(),'N','','','','3100','','','','".sql_esc($rst_info_so2["doc_month"])."','New','".sql_esc($rst_info_so2["material_no"])."','".sql_esc($rst_info_so2["item_no"])."','".sql_esc($rst_info_so2["qty_upload"])."','".sql_esc($rst_info_so2["unit_upload"])."','".sql_esc($rst_info_so2["matl_group"])."','".sql_esc($rst_info_so2["ship_point"])."','')";
 $result_perodua = mysqli_query($dbc,$query_perodua);   
 
 }
 
 $query_all_donum = new PreparedSql("SELECT * FROM scan_crt_donum WHERE id_DO = ? AND status_acc = 'N'", [$ref]);
 $result_all_donum = db_query($dbc, $query_all_donum);  
 $rst_all_donum  = mysqli_fetch_array($result_all_donum); 
 
 
 if($rst_all_donum < 1 )
 {
 
 //Add the record scan update no
 $query_ref_perodua = new PreparedSql("INSERT INTO scan_crt_donum(id,id_DO,status_acc,user_create,date_create) VALUES ('',?,'N',?,NOW())", [$ref, $username]);
 $result_ref_perodua = db_query($dbc, $query_ref_perodua) or die (mysqli_error($dbc));  
 
  
 
 }else{
   
   
 } 



} // end ia_barcode
	
	
  if($shift_ops && $trip_no)
  { 
  
  $shift_ops = $_POST['shift_ops'];
  $trip_no = $_POST['trip_no'];	
  $date1 = $_POST['date1'];

  //date convert $data_no2
  $dDlv = substr($date1,0,2);
  $mDlv = substr($date1,3,2);
  $yDlv = substr($date1,6,4);

    $dt_finalDLv = ($yDlv.'-'.$mDlv.'-'.$dDlv); 

//-------update scan_so_perodua1 -----

$query_upd_perodua = "UPDATE scan_so_perodua1 SET dlv_date = '".sql_esc($dt_finalDLv)."', shift_ops = '".sql_esc($shift_ops)."', trip_no = '".sql_esc($trip_no)."', pdio_no = '".sql_esc($p2_barcode)."', status_DO = '".sql_esc($rst_sta3["status_desc"])."' WHERE scan_gen = '".sql_esc($ref_id)."' AND material_no = '".sql_esc($part1A)."'";
$result_upd_perodua  = mysqli_query($dbc,$query_upd_perodua);  	


 //Info
$query_perodua_info = "SELECT * FROM scan_so_perodua1 WHERE scan_gen = '".sql_esc($ref_id)."'"; 
$result_perodua_info = mysqli_query($dbc,$query_perodua_info);  
$rst_perodua_info  = mysqli_fetch_array($result_perodua_info); 

  if($_POST['ia_barcode'] == "")
	{ 
 //Add the record to the database
$query_perodua2 = "INSERT INTO scan_p2_perodua1(id,id_so,scan_gen,material_doc_gen,p2_barcode,ia_barcode,so_no,ship_no,ship_name,trip_no,pdio_no,date_scan,dlv_date,material_no,material_desc,back_no,part_seq,qty_dlv,user_create,date_create,time_create,user_update,date_update,time_update,status_so,user_posting,date_posting,time_posting,status_DO,material_doc_ref,user_cancel,date_cancel,time_cancel,remark_cancel,material_no_sap,material_desc_sap,tag_no,plant_code,shift_dlv,SAP_ref_doc,SAP_ref_doc_can) VALUES ('','".sql_esc($rst_perodua_info["id"])."','".sql_esc($rst_perodua_info["scan_gen"])."','','".sql_esc($_POST['p2_barcodeW'])."','".sql_esc($_POST['ia_barcode'])."','".sql_esc($rst_perodua_info["so_no"])."','".sql_esc($rst_perodua_info["ship_no"])."','".sql_esc($rst_perodua_info["ship_name"])."','".sql_esc($trip_no)."','','','','','','','','".sql_esc($rst_perodua_info["qty_order"])."','".sql_esc($username)."',NOW(),NOW(),'".sql_esc($username)."',NOW(),NOW(),'N','','','','New','','','','','','','','','".sql_esc($res["plant_code"])."','".sql_esc($shift_ops)."','','')";
$result_perodua2 = mysqli_query($dbc,$query_perodua2) or die (mysqli_error($dbc));   
	
	
	}else{ //  if IA Tag xde

 //Add the record to the database
$query_perodua2 = "INSERT INTO scan_p2_perodua1(id,id_so,scan_gen,material_doc_gen,p2_barcode,ia_barcode,so_no,ship_no,ship_name,trip_no,pdio_no,date_scan,dlv_date,material_no,material_desc,back_no,part_seq,qty_dlv,user_create,date_create,time_create,user_update,date_update,time_update,status_so,user_posting,date_posting,time_posting,status_DO,material_doc_ref,user_cancel,date_cancel,time_cancel,remark_cancel,material_no_sap,material_desc_sap,tag_no,plant_code,shift_dlv,SAP_ref_doc,SAP_ref_doc_can) VALUES ('','".sql_esc($rst_perodua_info["id"])."','".sql_esc($rst_perodua_info["scan_gen"])."','','".sql_esc($_POST['p2_barcodeW'])."','".sql_esc($_POST['ia_barcode'])."','".sql_esc($rst_perodua_info["so_no"])."','".sql_esc($rst_perodua_info["ship_no"])."','".sql_esc($rst_perodua_info["ship_name"])."','".sql_esc($trip_no)."','','','','','','','','".sql_esc($part7A)."','".sql_esc($username)."',NOW(),NOW(),'".sql_esc($username)."',NOW(),NOW(),'N','','','','New','','','','','','','','".sql_esc($part4A)."','".sql_esc($res["plant_code"])."','".sql_esc($shift_ops)."','','')";
$result_perodua2 = mysqli_query($dbc,$query_perodua2) or die (mysqli_error($dbc));   
			
	}

//trim string $_POST['p2_barcodeA']

$query_p2_detail = "SELECT * FROM scan_p2_perodua1 WHERE id = '".mysqli_insert_id($dbc)."'";
$result_p2_detail = mysqli_query($dbc,$query_p2_detail);  
$rst_p2_detail  = mysqli_fetch_array($result_p2_detail); 

  
	 $data_no1 = substr($rst_p2_detail["p2_barcode"],0,10);
					 
				 					 
							 //---- checking closed SO ---------//		 
		      $query_po_list = "SELECT * FROM so_close_detail WHERE so_no = '".sql_esc($rst_p2_detail["so_no"])."' AND date_closed <= '".sql_esc($dt_finalDLv)."' AND status_so = '".sql_esc($rst_sta13["status_desc"])."'";
          $result_po_list = mysqli_query($dbc,$query_po_list);
          $row_list = mysqli_fetch_array($result_po_list);
       
			 
			  if($row_list > 0 )
			   {	 
				 
		     $query_delete_scan2F = "DELETE FROM scan_p2_perodua1 WHERE scan_gen = '".sql_esc($scan_gen)."' AND user_create = '".sql_esc($username)."' AND id = '".sql_esc($rst_p2_detail["id"])."'";
         $result_delete_scan2F = mysqli_query($dbc,$query_delete_scan2F);		 
				 
				 
				      echo "<script>";
						  echo "alert('Invalid SO Number. SO has been closed');";
						  echo "window.location='crt_do_perd2-dlvP2.php?scan_gen=$ref_id&&so_no=$so_no';";
						  echo "</script>";
						  exit(); //quit the script	 			 
				 
			           } 
		//infor table_material_cust
		$query_mat = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ?", [$part1A]);
		$result_mat = db_query($dbc, $query_mat);  
		$rst_mat  = mysqli_fetch_array($result_mat); 
		
	
		//--update scan_p2_perodua1
		
		$query_p2_upd = "UPDATE scan_p2_perodua1 SET pdio_no = '".sql_esc($p2_barcode)."', date_scan = '".sql_esc($dt_finalDLv)."', dlv_date = '".sql_esc($dt_finalDLv)."', material_no = '".sql_esc($rst_mat["material_cust_no"])."', back_no = '".sql_esc($rst_mat["back_no"])."',  material_desc = '".sql_esc($rst_mat["material_desc_cust"])."', material_no_sap = '".sql_esc($rst_mat["material_no"])."', material_desc_sap = '".sql_esc($rst_mat["material_desc"])."' WHERE id = '".sql_esc($rst_p2_detail["id"])."'"; 
		$result_p2_upd = mysqli_query($dbc,$query_p2_upd);  	


			 if($_POST['ia_barcode'] != "")
			{    
             
			 //----------------checking IA scan --------------------------------------

			$query_wannaOne = "SELECT * FROM scan_p2_perodua1 WHERE id = '".sql_esc($rst_p2_detail["id"])."'"; 
			$result_wannaOne = mysqli_query($dbc,$query_wannaOne);  
	    $rst_wannaOne  = mysqli_fetch_array($result_wannaOne);
	
			 
				  if(($rst_wannaOne["material_no_sap"]) != ($part1A))
				  {  
				  
				    $query_del_single = "DELETE FROM scan_p2_perodua1 WHERE id = '".sql_esc($rst_p2_detail["id"])."'";
				    $result_del_single = mysqli_query($dbc,$query_del_single);
	  
	            echo "<script>";
						  echo "alert('Wrong FG Tag. Please check.');";
						  echo "window.location='crt_do_perd2-dlvP2.php?scan_gen=$ref_id&&so_no=$so_no&&ia_barcode=$ia_barcode&&p2_barcodeW=$p2_barcode&&trip_no=$trip_no&&shift_ops=$shift_ops';";
						  echo "</script>";
						  exit(); //quit the script	  
						  
				  
 				 
				  }
				  
			}// end if 


							echo "<script>";
							echo "alert('Successfully add item.');";
							echo "window.location='crt_do_perd2-dlvP2.php?scan_gen=$ref_id&&so_no=$so_no&&p2_barcodeW=$p2_barcode&&trip_no=$trip_no&&shift_ops=$shift_ops&&date1=$date1';";
							echo "</script>";
						    exit(); //quit the script 
		   
  } // everything OK
		   

} // end submitTT




if(isset($_POST["submit4Dlv"])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

$amount = "";
$amount4 = "";
$id = $_POST["id"];  
$scan_gen = $_POST['scan_gen'];
$qty_dlv = $_POST['qty_dlv'];
$how_many = count($id); 



       foreach($_POST["id"] as $j=>$i) {
		   
	  $amount .= (($_POST["qty_dlv"][$i]).';');
		$amount4 .= (($_POST["id"][$i]).';');
		
		//-----checking barcode GR Tag
		
		$string = explode(";",($amount));	
		$string4 = explode(";",($amount4));	
	
		
	
        }
		
	  
		 			
		   for ($i=0; $i<$how_many; $i++) { 
		   
		   
		   	
		  $query_update_scan2 = "UPDATE scan_p2_perodua1 SET qty_dlv = '".sql_esc($string[$i])."' WHERE id = '".sql_esc($string4[$i])."'";
	    $rst_update_scan2 = mysqli_query($dbc,$query_update_scan2);
		   
		   
		   }


    //-----------checking PDIO not used before --------
	
	 




      $query_all = "SELECT * FROM scan_p2_perodua1 WHERE scan_gen = '".sql_esc($scan_gen)."'";
      $result_all = mysqli_query($dbc,$query_all);
	  
	  while($data_all = mysqli_fetch_array($result_all))
	  {
	  /* 
      if($data_all["pdio_no"] != ''){

	    $query_chk_pdio = "SELECT * FROM dlv_ord_all_delivery WHERE scan_gen != '".sql_esc($scan_gen)."' AND pdio_no = '".$data_all["pdio_no"]."' AND status_DO = '".$rst_sta3["status_desc"]."' ";
      $result_chk_pdio = mysqli_query($dbc,$query_chk_pdio);
      $data_chk_pdio = mysqli_fetch_array($result_chk_pdio);
	  
            if($data_chk_pdio > 1 )
            {
          
                  echo "<script>";
                  echo "alert('PDIO/DI already exist.');";
                  echo "window.location='crt_do_perd2-dlvP2.php';";
                  echo "</script>";
                  exit(); //quit the script 	
              
              
            }

         } // end pdio no */

		          //-------month & yrs
		     $dy_do = substr($data_all["dlv_date"],8,2);
				 $mth_do = substr($data_all["dlv_date"],5,2);
				 $yrs_do = substr($data_all["dlv_date"],0,4);
	  
	  //-----uom----
	  
	  //infor table_material_cust
		$query_matE = "SELECT * FROM table_material_itsb WHERE material_cust_no = '".sql_esc($data_all["material_no"])."'";
		$result_matE = mysqli_query($dbc,$query_matE);  
		$rst_matE  = mysqli_fetch_array($result_matE); 
	  
	  //-------insert table prt_do_perodua_tag
		
		$query_print_tag = "INSERT INTO prt_do_perodua_tag(id,tag_gen,scan_gen,material_doc_gen,id_do,so_no,ship_point,cust_code,pdio_no,material_no,material_desc,cust_mat_no,qty_dlv,uom_dlv,ship_from,ship_to,dlv_date,plant_code,month_do,year_do,posting_date,posting_time,prepared_by,status_part,created_by,date_create,status_tag,shift_dlv) VALUES ('','".sql_esc($data_all["material_doc_gen"])."','".sql_esc($data_all["scan_gen"])."','".sql_esc($data_all["material_doc_gen"])."','".sql_esc($data_all["id"])."','".sql_esc($data_all["so_no"])."','".sql_esc($data_all["ship_no"])."','".sql_esc($data_all["ship_no"])."','".sql_esc($data_all["pdio_no"])."','".sql_esc($data_all["material_no_sap"])."','".sql_esc($data_all["material_desc"])."','".sql_esc($data_all["material_no"])."','".sql_esc($data_all["qty_dlv"])."','".sql_esc($rst_matE["BUn"])."','','".sql_esc($data_all["trip_no"])."','".sql_esc($data_all["dlv_date"])."','".sql_esc($data_all["plant_code"])."','".sql_esc($mth_do)."','".sql_esc($yrs_do)."','".sql_esc($data_all["date_posting"])."','".sql_esc($data_all["time_posting"])."','".sql_esc($username)."','PERODUA','".sql_esc($username)."',NOW(),'Y','".sql_esc($data_all["shift_dlv"])."')";
	    $rst_print_tag = mysqli_query($dbc,$query_print_tag);
	  
	  
	  }//end while loop






    
  $query_doc_generate = "SELECT *,DATE_FORMAT(posting_date,'%d-%m-%Y') as R, DATE_FORMAT(dlv_date,'%d-%m-%Y') as R7 FROM prt_do_perodua_tag WHERE scan_gen = '".sql_esc($scan_gen)."' GROUP BY pdio_no";
    $result_doc_generate = mysqli_query($dbc,$query_doc_generate);

while($row_doc_generate = mysqli_fetch_array($result_doc_generate))

{
		
	$query_pdio_grp2 = "SELECT *,DATE_FORMAT(posting_date,'%d-%m-%Y') as T, DATE_FORMAT(dlv_date,'%d-%m-%Y') as T7 FROM prt_do_perodua_tag WHERE pdio_no = '".sql_esc($row_doc_generate["pdio_no"])."'";
    $result_pdio_grp2 = mysqli_query($dbc,$query_pdio_grp2);

while($row_pdio2 = mysqli_fetch_array($result_pdio_grp2))

{ 

 //------generate Material Document No. for GR Generate.---------------------------------
	
	 if($res["plant_code"] == '3100')
	{
	
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '41'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	}elseif($res["plant_code"] == '3101')
	{
		
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '88'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
		
	}
	
	if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 00000; 
	$dht_OK2 = "511";
	$dg2 = 0;

  	if($row_id2["count_max"] <= 0)
  	{ 
   
    	$lastID2 = ($row_id2["count_max"] + 1);
    	$dg2 = ($dht2 + ($lastID2));
   }
   else
   {
      $lastID2 = ($row_id2["count_max"] + 1);
      $dg2 =  $lastID2;
	
    }
	$number2 = $dg2; // Length of running no
    $number2 = sprintf('%03d', $number2);  
	
    $ref3 = (($row_id2["start_ref"]).$dht_OK2.$date_run.($number2));
	  
	
	} // end if $result_id2





//---update material doc create DO in table scan_p2_perodua1 ---

      $query_upd_DO = "UPDATE scan_p2_perodua1 SET material_doc_gen = '".sql_esc($ref3)."', status_DO = '".sql_esc($rst_sta3["status_desc"])."', status_so = 'Y', user_posting = '".sql_esc($username)."', date_posting = NOW(), time_posting = NOW() WHERE scan_gen = '".sql_esc($scan_gen)."' AND  pdio_no = '".sql_esc($row_doc_generate["pdio_no"])."'";
      $result_upd_DO = mysqli_query($dbc,$query_upd_DO);
	  
	  
	    $query_upd_DO2 = "UPDATE scan_so_perodua1 SET material_doc_gen = '".sql_esc($ref3)."', status_DO = '".sql_esc($rst_sta3["status_desc"])."', status_so = 'Y', user_posting = '".sql_esc($username)."', date_posting = NOW(), time_posting = NOW() WHERE scan_gen = '".sql_esc($scan_gen)."'";
      $result_upd_DO2 = mysqli_query($dbc,$query_upd_DO2);
	  
	 	
			
		$query_all2 = "SELECT * FROM scan_p2_perodua1 WHERE id = '".sql_esc($row_pdio2["id_do"])."' AND material_doc_gen = '".sql_esc($ref3)."'  AND status_DO = '".sql_esc($rst_sta3["status_desc"])."' AND scan_gen = '".sql_esc($scan_gen)."' AND pdio_no = '".sql_esc($row_pdio2["pdio_no"])."'";
		$result_all2 = mysqli_query($dbc,$query_all2);
	  $data_all2 = mysqli_fetch_array($result_all2);
		
			if($data_all2["material_doc_gen"] != "")
		{
			
			//-----uom----
	  
	  //infor table_material_cust
		$query_matEE = "SELECT * FROM table_material_itsb WHERE material_cust_no = '".sql_esc($data_all2["material_no"])."'";
		$result_matEE = mysqli_query($dbc,$query_matEE);  
		$rst_matEE  = mysqli_fetch_array($result_matEE); 


    //------update data dlv_ord_all_delivery -----------//
//Info
$query_perodua_info4 = "SELECT * FROM scan_so_perodua1 WHERE scan_gen = '".sql_esc($scan_gen)."' AND material_no = '".sql_esc($rst_matEE["material_no"])."'"; 
$result_perodua_info4 = mysqli_query($dbc,$query_perodua_info4);  
$rst_perodua_info4  = mysqli_fetch_array($result_perodua_info4); 

			
			
		//insert table dlv_ord_all_delivery
	 $query_generate_do = "INSERT INTO dlv_ord_all_delivery(id,id_do,upload_id,scan_gen,material_doc_gen,pdio_no,order_no,vendor_name,shop_pt,lshop,ldock,dlv_cat,trip_no,lane_no,prod_date,dlv_date,cycle_no,back_no,material_no,material_desc,total_order_pcs,total_order_box,total_rcv_pcs,total_rcv_box,user_upload,date_upload,status_upload,user_update,date_update,so_no,ship_point,ship_name,tag_no,doc_gen,sold_desc,ship_no,ship_desc,item_no,material_no_sap,material_desc_sap,plant_code,qty_order,qty_bal,qty_rec,qty_dlv,unit_soi,matl_group,sales_org,posting_date,posting_time,user_post,date_post,time_post,ref_material_doc,user_cancel,date_cancel,remark_cancel,status_DO,status_part,qty_return,doc_no_return,return_by,date_return,reject_ticket_no,user_reject,date_reject) VALUES ('','".sql_esc($row_pdio2["id_do"])."','','".sql_esc($data_all2["scan_gen"])."','".sql_esc($data_all2["material_doc_gen"])."','".sql_esc($data_all2["pdio_no"])."','','".sql_esc($data_all2["ship_no"])."','".sql_esc($rst_perodua_info4["ship_point"])."','','','','".sql_esc($data_all2["trip_no"])."','','','".sql_esc($data_all2["dlv_date"])."','".sql_esc($data_all2["shift_dlv"])."','".sql_esc($data_all2["back_no"])."','".sql_esc($data_all2["material_no"])."','".sql_esc($data_all2["material_desc"])."','','','','','','','','".sql_esc($data_all2["user_update"])."','".sql_esc($data_all2["date_update"])."','".sql_esc($data_all2["so_no"])."','".sql_esc($data_all2["ship_no"])."','".sql_esc($data_all2["ship_name"])."','".sql_esc($data_all2["tag_no"])."','','','".sql_esc($data_all2["ship_no"])."','".sql_esc($data_all2["ship_name"])."','".sql_esc($rst_perodua_info4["item_no"])."','".sql_esc($data_all2["material_no_sap"])."','".sql_esc($data_all2["material_desc_sap"])."','".sql_esc($data_all2["plant_code"])."','".sql_esc($rst_perodua_info4["qty_order"])."','','','".sql_esc($data_all2["qty_dlv"])."','".sql_esc($rst_matEE["BUn"])."','".sql_esc($rst_matEE["material_group"])."','".sql_esc($rst_matEE["mat_group"])."','".sql_esc($data_all2["date_posting"])."','".sql_esc($data_all2["time_posting"])."','".sql_esc($username)."',NOW(),NOW(),'','','','','".sql_esc($data_all2["status_DO"])."','PERODUA','0.000','','','0000-00-00 00:00:00','','','0000-00-00 00:00:00')";
	 $rst_generate_do = mysqli_query($dbc,$query_generate_do);
	  
		}




     $query_update_temp2 = "UPDATE prt_do_perodua_tag SET material_doc_gen = '".sql_esc($ref3)."', posting_date = NOW(), posting_time = NOW() WHERE scan_gen = '".sql_esc($scan_gen)."' AND pdio_no = '".sql_esc($row_doc_generate["pdio_no"])."'";
	 $rst_update_temp2 = mysqli_query($dbc,$query_update_temp2);
   
   
   
    //generate text file ftp DO		
			
	$qry_ftp = mysqli_query($dbc,"SELECT *, DATE_FORMAT(posting_date,'%d%m%Y') AS R, DATE_FORMAT(dlv_date,'%d%m%Y') AS R7 FROM dlv_ord_all_delivery WHERE material_doc_gen = '".sql_esc($ref3)."' AND pdio_no = '".sql_esc($row_doc_generate["pdio_no"])."'");
	
$data = "";

while($row_ftp = mysqli_fetch_array($qry_ftp)) {
	
	$qty_nw = (intval($row_ftp['qty_dlv']));
 
	
	
  $data .= $row_ftp['so_no'].";".$row_ftp['R7'].";".$row_ftp['material_no'].";".$qty_nw.";".$row_ftp['material_doc_gen'].";".$row_ftp['pdio_no'].";".$row_ftp['tag_no']."\r\n";
 
  //--------insert into table ftp_dlv_ord_all_delivery
	
$query_ftp_info = "INSERT INTO ftp_dlv_ord_all_delivery(id_ftp,file_name,material_doc_gen,id_do,scan_gen,plant_code,so_no,ship_point,ship_name,pdio_no,item_no,material_no,material_desc,qty_order,qty_dlv,uom_dlv,dlv_date,ship_from,ship_to,user_posting,date_posting,time_posting,status_DO,status_ftp,status_part) VALUES ('','','".sql_esc($ref3)."','".sql_esc($row_ftp["id"])."','".sql_esc($row_ftp["scan_gen"])."','".sql_esc($row_ftp["plant_code"])."','".sql_esc($row_ftp["so_no"])."','".sql_esc($row_ftp["ship_no"])."','".sql_esc($row_ftp["ship_name"])."','".sql_esc($row_ftp["pdio_no"])."','".sql_esc($row_ftp["item_no"])."','".sql_esc($row_ftp["material_no"])."','".sql_esc($row_ftp["material_desc"])."','".sql_esc($row_ftp["qty_order"])."','".sql_esc($row_ftp["qty_dlv"])."','".sql_esc($row_ftp["unit_soi"])."','".sql_esc($row_ftp["dlv_date"])."','".sql_esc($row_ftp["plant_code"])."','".sql_esc($row_ftp["ship_no"])."','".sql_esc($row_ftp["user_post"])."','".sql_esc($row_ftp["date_post"])."','".sql_esc($row_ftp["time_post"])."','".sql_esc($row_ftp["status_DO"])."','Y','".sql_esc($row_ftp["status_part"])."')";
$rst_ftp_info = mysqli_query($dbc,$query_ftp_info);
 
     
}

$filen="DO".$ref3;
//$csv_filename = $filen."_".date("YmdHis",time());

$file = "../FromPortal2/DO/".$filen.".csv";
//chmod($file, 0777);
file_put_contents($file,$data);


  $query_upd_ftp = "UPDATE ftp_dlv_ord_all_delivery SET file_name = '".sql_esc($filen)."' WHERE material_doc_gen = '".sql_esc($ref3)."' AND scan_gen = '".sql_esc($scan_gen)."'";
  $result_upd_ftp = mysqli_query($dbc,$query_upd_ftp);
		
	
 

} // end while loop

//update count_max----------------------------------------
	 
	  if($res["plant_code"] == '3100')
	{
	   
	   $query_max_a1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '128'";
	   $result_max_a1 = mysqli_query($dbc,$query_max_a1);
	   
	   $query_max_a2 = "UPDATE scan_crt_donum SET status_acc = 'Y' WHERE id_DO = '".sql_esc($scan_gen)."' AND user_create = '".sql_esc($username)."'";
	   $result_max_a2 = mysqli_query($dbc,$query_max_a2);
	   
	   $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '41'";
	   $result_max_a = mysqli_query($dbc,$query_max_a);
	   
	   

	}elseif($res["plant_code"] == '3101')
	{
	   
	   $query_max_a1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '129'";
	   $result_max_a1 = mysqli_query($dbc,$query_max_a1);
	   
	   $query_max_a2 = "UPDATE scan_crt_donum SET status_acc = 'Y' WHERE id_DO = ''".sql_esc($scan_gen)."' AND user_create = '".sql_esc($username)."'";
	   $result_max_a2 = mysqli_query($dbc,$query_max_a2);
	   
	   $query_max_b = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '88'";
	   $result_max_b = mysqli_query($dbc,$query_max_b);
	}

   //end update count_max ---------------------------------	




 } // end while loop main

            echo "<script>";
			      echo "alert('Delivery Order successfully created.');";
            echo "window.location='crt_do_perd2-dlvP2.php';";
            echo "</script>";
            exit(); //quit the script 


}//submit4Dlv



if(isset($_POST["submit5Dlv"])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

 $scan_gen = $_POST['scan_gen'];
//-----------delete all data current screen-------------

   $query_delete_scan = "DELETE FROM scan_so_perodua1 WHERE scan_gen = '".sql_esc($scan_gen)."' AND user_create = '".sql_esc($username)."'";
   $result_delete_scan = mysqli_query($dbc,$query_delete_scan);
   
   $query_delete_scan2 = "DELETE FROM scan_p2_perodua1 WHERE scan_gen = '".sql_esc($scan_gen)."' AND user_create = '".sql_esc($username)."'";
   $result_delete_scan2 = mysqli_query($dbc,$query_delete_scan2);

//---------end delete ----------------------------------

}//end submit5
	
?> 
     <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Create Delivery Order - Perodua Global</h3>
            <div class="tile-body">
            
           
    
      
         <form name="formCrtDO" action="crt_do_perd2-dlvP2.php?scan_gen=<?php echo $ref; ?>&&so_no=<?php echo $part1; ?>&&ia_barcode=<?php echo $ia_barcode; ?>&&p2_barcodeW=<?php echo $p2_barcode; ?>&&trip_no=<?php echo $trip_no; ?>&&shift_ops=<?php echo $shift_ops; ?>" method="post" class="form-horizontal">
  
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="2"></th>
            </tr>
             <tr>
                <th>Sales Order : </th>
                <th colspan="2">
           <input class="form-control" id="so_no" type="text" placeholder="Enter Sales Order No." name="so_no" value="<?php if(isset($_POST['so_no'])){ echo html_esc($_POST['so_no']); }else{ if($_GET["so_no"] != '') { echo html_esc($_GET["so_no"]); }  }?>" />    
          <div class="form-control-feedback" ><?php echo $message_so; ?></div>   
          <input name="submit8" type="submit" id="submit8" value="+ Scan Item" class="button"  />  
            <!-- <div id="result"></div>-->
               </th>
              </tr>
              <tr>
              <th>IA QRCode: <font color="#FF0000">*</font></th>
              <td colspan="2">
                 <input class="form-control" id="ia_barcode" type="text" placeholder="Enter IA QRCode" name="ia_barcode" value="<?php if(isset($_POST['ia_barcode'])){ echo html_esc($_POST['ia_barcode']); }else{ if($_GET["ia_barcode"] != '') { echo html_esc($_GET["ia_barcode"]); }  } ?>"  autofocus required />
              <div class="form-control-feedback" ><?php echo $message_iaqr; ?></div>
              <input class="form-control" id="so_noA" type="hidden"  name="so_noA" value="<?php echo $part1;  ?>" /> 
              <input name="submit10Y" type="submit" id="submit10Y" value="+ Scan Item" class="button"  /> </td>
              </tr>
            <tr>
            <th>P2 QRCode : </th>
            <td colspan="2">
           <input class="form-control" id="p2_barcode" type="text" placeholder="Enter P2 QRCode" name="p2_barcode" value="<?php if(isset($_POST['p2_barcode'])){ echo html_esc($_POST['p2_barcode']); }else{ if($_GET["p2_barcodeW"] != '') { echo html_esc($_GET["p2_barcodeW"]); }  } ?>" autofocus  />
         <div class="form-control-feedback" ><?php //echo $message_p2qr; ?></div>
         <input class="form-control" id="so_noA2" type="hidden"  name="so_noA2" value="<?php echo $part1;  ?>" /> 
         <input name="submit9Y" type="submit" id="submit9Y" value="+ Scan Item" class="button"  /> 
		     </td>
             </tr>
             <tr>
            <th>Delivery Date: <font color="#FF0000">*</font></th>
            <td>
           <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php if(isset($_POST['date1'])){ echo html_esc($_POST['date1']); }else{ if($_GET["date1"] != '') { echo html_esc($_GET["date1"]); }else{ echo $fmt_curr_date; }  } ?>" /><div class="form-control-feedback" ><?php echo $message_psdt; ?></div>
		     </td>
             </tr>
              <tr>
                <th>Shift :  <font color="#FF0000">*</font></th>
                
                <td colspan="2">
           	<?php

			  if(!isset($_POST['submitTT'])){
		

		   	$query_chk_shift = "SELECT * FROM scan_p2_perodua1 WHERE scan_gen = '".sql_esc($ref)."' AND user_create = '".sql_esc($username)."'"; 
		   	$result_chk_shift = mysqli_query($dbc,$query_chk_shift);  
		    $rst_chk_shift  = mysqli_fetch_array($result_chk_shift);
               
			   if($rst_chk_shift > 0 )
			   {
				   
				?>   <div class="form-check">
                   
                        <input class="form-check-input" id="shift_post1" type="radio" name="shift_ops" value="D/S" <?php if($rst_chk_shift["shift_dlv"] == "D/S") { ?> checked="checked" <?php } ?>>Day
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input class="form-check-input" id="shift_post2" type="radio" name="shift_ops" value="N/S" <?php if($rst_chk_shift["shift_dlv"] == "N/S") { ?> checked="checked" <?php } ?>>Night
                </div>
                
                  
                <?php   
				   
				   
			   }else{
				?>     
                <div class="form-check">
                        <input class="form-check-input" id="shift_post1" type="radio" name="shift_ops" value="D/S" checked="checked">Day
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input class="form-check-input" id="shift_post2" type="radio" name="shift_ops" value="N/S">Night
                    </div><div class="form-control-feedback" ><?php echo $message_shift; ?></div> 
                    
          
           <?php  }
			
			
			 }// if(!isset($_POST['submitTT']))  utk shift_ops
		   		   ?>     
                
                    </td>
               
              </tr>
              
              
              
            
              <tr>
                <th>Trip :<font color="#FF0000">*</font></th>
                <td>
                
                <?php

			  if(!isset($_POST['submitTT'])){
		

        $query_chk_tripA = "SELECT * FROM scan_p2_perodua1 WHERE scan_gen = '".sql_esc($ref)."' AND user_create = '".sql_esc($username)."'"; 
		   	$result_chk_tripA = mysqli_query($dbc,$query_chk_tripA);  
		    $rst_chk_tripA  = mysqli_fetch_array($result_chk_tripA);
               
			   if($rst_chk_tripA > 0 )
			   {
				   
				?> 

                    <select name="trip_no" id="trip_no" class="form-control" required >
                  <option value="1" <?php if($rst_chk_tripA["trip_no"] == "1") { ?> selected="selected"<?php } ?>>1</option>
                  <option value="2" <?php if($rst_chk_tripA["trip_no"] == "2") { ?> selected="selected"<?php } ?>>2</option>
                  <option value="3" <?php if($rst_chk_tripA["trip_no"] == "3") { ?> selected="selected"<?php } ?>>3</option>
                  <option value="4" <?php if($rst_chk_tripA["trip_no"] == "4") { ?> selected="selected"<?php } ?>>4</option>
                  <option value="5" <?php if($rst_chk_tripA["trip_no"] == "5") { ?> selected="selected"<?php } ?>>5</option>
                  <option value="6" <?php if($rst_chk_tripA["trip_no"] == "6") { ?> selected="selected"<?php } ?>>6</option>
                  <option value="7" <?php if($rst_chk_tripA["trip_no"] == "7") { ?> selected="selected"<?php } ?>>7</option>
                  <option value="8" <?php if($rst_chk_tripA["trip_no"] == "8") { ?> selected="selected"<?php } ?>>8</option>
                  <option value="9" <?php if($rst_chk_tripA["trip_no"] == "9") { ?> selected="selected"<?php } ?>>9</option>
                  <option value="10" <?php if($rst_chk_tripA["trip_no"] == "10") { ?> selected="selected"<?php } ?>>10</option>
                  <option value="11" <?php if($rst_chk_tripA["trip_no"] == "11") { ?> selected="selected"<?php } ?>>11</option>
                  <option value="12" <?php if($rst_chk_tripA["trip_no"] == "12") { ?> selected="selected"<?php } ?>>12</option>
                  <option value="13" <?php if($rst_chk_tripA["trip_no"] == "13") { ?> selected="selected"<?php } ?>>13</option>
                  <option value="14" <?php if($rst_chk_tripA["trip_no"] == "14") { ?> selected="selected"<?php } ?>>14</option>
                  <option value="15" <?php if($rst_chk_tripA["trip_no"] == "15") { ?> selected="selected"<?php } ?>>15</option>
                  <option value="16" <?php if($rst_chk_tripA["trip_no"] == "16") { ?> selected="selected"<?php } ?>>16</option>
                  <option value="17" <?php if($rst_chk_tripA["trip_no"] == "17") { ?> selected="selected"<?php } ?>>17</option>
                  <option value="18" <?php if($rst_chk_tripA["trip_no"] == "18") { ?> selected="selected"<?php } ?>>18</option>
                  <option value="19" <?php if($rst_chk_tripA["trip_no"] == "19") { ?> selected="selected"<?php } ?>>19</option>
                  <option value="20" <?php if($rst_chk_tripA["trip_no"] == "20") { ?> selected="selected"<?php } ?>>20</option>
                  <option value="21" <?php if($rst_chk_tripA["trip_no"] == "21") { ?> selected="selected"<?php } ?>>21</option> 
                  <option value="22" <?php if($rst_chk_tripA["trip_no"] == "22") { ?> selected="selected"<?php } ?>>22</option> 
                  <option value="23" <?php if($rst_chk_tripA["trip_no"] == "23") { ?> selected="selected"<?php } ?>>23</option>
                  <option value="24" <?php if($rst_chk_tripA["trip_no"] == "24") { ?> selected="selected"<?php } ?>>24</option>
                  <option value="25" <?php if($rst_chk_tripA["trip_no"] == "25") { ?> selected="selected"<?php } ?>>25</option>
                  <option value="26" <?php if($rst_chk_tripA["trip_no"] == "26") { ?> selected="selected"<?php } ?>>26</option>
                  <option value="27" <?php if($rst_chk_tripA["trip_no"] == "27") { ?> selected="selected"<?php } ?>>27</option> 
                  <option value="28" <?php if($rst_chk_tripA["trip_no"] == "28") { ?> selected="selected"<?php } ?>>28</option>
                  <option value="29" <?php if($rst_chk_tripA["trip_no"] == "29") { ?> selected="selected"<?php } ?>>29</option>
                  <option value="30" <?php if($rst_chk_tripA["trip_no"] == "30") { ?> selected="selected"<?php } ?>>30</option> 
                </select>
              
          
      <?php  
	          }else
	          {
				  
	

				?> 
                  <select name="trip_no" id="trip_no" class="form-control" required >
                  <option value="NULL" >-- Select Trip No. --</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
 				          <option value="5">5</option>
 				          <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option> 
                  <option value="22">22</option> 
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                  <option value="26">26</option>
                  <option value="27">27</option> 
                  <option value="28">28</option>
                  <option value="29">29</option>
                  <option value="30">30</option> 
				</select>

              
      <?php
			
		      

			}// end elseif  
				  
				  
} // end if
	  
	  
			   ?>
                
		
                    
                   <div class="form-control-feedback" ><?php echo $message_tripno;   ?>  </div>
                   <br>
                   
                   
                 </td>
             

              </tr>             
              <tr>
                <th>
                <input class="form-control" id="ref_id" type="hidden"  name="ref_id" value="<?php echo $ref;  ?>" /> 
                <input class="form-control" id="so_noA" type="hidden"  name="so_noA" value="<?php echo $part1;  ?>" />  
                <input id="p2_barcodeW" type="hidden"  name="p2_barcodeW" value="<?php echo html_esc($_POST['p2_barcode']);   ?>" /> 
                <input name="submitTT" type="submit" id="submitTT" value="+ Add Item" class="btn btn-primary btn-sm"  />    
                </th>
                <th colspan="2">&nbsp;</th>
              </tr>
            
                </table>
        </form> 
        
        
        
      <?php     
        
       $query_sql2A = "SELECT * FROM scan_p2_perodua1 WHERE scan_gen = '".sql_esc($ref)."' AND user_create = '".sql_esc($username)."'";
			 $result_sql2A = mysqli_query($dbc,$query_sql2A);
			 $num_1 = mysqli_num_rows($result_sql2A);   //how many material are there?
    
		  
		 if ($num_1 > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_1.' record(s).</div>'; 
        
        ?>
        
            <form action="" method="post" name="myform" id="myform">
            <table class="table table-hover table-bordered" id="example">
               <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Item.</th>
                    <th>Part Number</th>
                    <th>Part Name</th>
                    <th>Delivery Date</th>
                    <th>Quantity</th>
                    <th>PDIO No.</th>
                    <th>Tag No.</th>
                </tr>
              </thead>    
              <tbody>
           <?php 

   $counter = 1;
   $no4 = 1;
   $sta_out = "";
   
   while($row = mysqli_fetch_array($result_sql2A))
   {
	   
	    $no4 = sprintf('%04d',$no4);
	 
		
      ?>
                <tr>
                <td width="60"><div align="center"><a href="delete_do_per2_item.php?scan_gen=<?php echo html_esc($row["scan_gen"]); ?>&&so_no=<?php echo html_esc($row["so_no"]); ?>&&p_id=<?php echo html_esc($row["id"]); ?>" onclick="return confirm('Are you sure you want to delete?')"><img src="../images/delete.png" alt="Remove Item"></a></div></td>
                <td width="60"><?php echo $no4; ?><input name="id[<?php echo html_esc($row["id"]); ?>]" type="hidden" value="<?php echo html_esc($row["id"]); ?>">
                <input name="item_no[<?php echo html_esc($row["id"]); ?>]" type="hidden" value="<?php echo $no4; ?>"></td>
                <td width="200"><?php echo html_esc($row["material_no"]); ?></td>
                <td width="300"><?php echo html_esc($row["material_desc"]); ?></td> 
                <td width="100"><?php echo html_esc($row["dlv_date"]); ?></td>
                <td width="150"> <input name="qty_dlv[<?php echo html_esc($row["id"]); ?>]" type="number" min="1" value="<?php if(isset($_POST["qty_dlv"])) { echo html_esc($_POST["qty_dlv"][($row["id"])]); }else{   echo (intval($row["qty_dlv"]));  } ?>" id="qty_dlv" class="form-control form-control-sm">
                 </td>
              
                <td width="200"><?php echo html_esc($row["pdio_no"]); ?></td> 
                <td width="250"><?php echo html_esc($row["tag_no"]); ?>   
                <input class="form-control" id="scan_gen" type="hidden"  name="scan_gen" value="<?php echo html_esc($row["scan_gen"]);  ?>" /> </td>
                
                </tr>
                 
          <?php 
		  
		  $no4++;
		  $counter++; // menambah counter
		  $w ++; 
          $k ++;

		  } 
		  
       
		  ?>
 </tbody>
</table>  
 
  
      
               <input name="submit4Dlv" type="submit" id="submit4" value="SUBMIT" class="btn btn-success btn-sm" onclick="return confirm('Confirm to Create Delivery Order?');" >
               <input name="submit5Dlv" type="submit" id="submit5" class="btn btn-warning btn-sm" value="CLEAR">
  
               

<?php  
  mysqli_free_result($result_sql2A); 
  	
 } ?>


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
  <!--  <script type="text/javascript">$('#example').DataTable();</script>-->
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <!--<script type="text/javascript" src="js/plugins/select2.min.js"></script>-->
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
    <script type="text/javascript">
          
       $('#PSSDate').datepicker({
		defaultDate: new Date(),
		format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      
	   $('#PSS2Date').datepicker({
		defaultDate: new Date(),   
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      $('#demoSelect').select2();
	  

	  
    </script>
   
    
     <script language="javascript">
		  $(document).ready(function() {
				$('#example').DataTable( {
					"scrollX": true,
					"lengthMenu": [[-1], [ "All"]]
				} );
		} );
	  </script>
  
  
  </body>
</html>