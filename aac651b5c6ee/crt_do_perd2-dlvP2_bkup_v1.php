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

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error());
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
          <p>Create DO Perodua</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"> Delivery</li>
          <li class="breadcrumb-item"><a href="crt_do_perd2-dlvP2.php">Create DO Perodua</a></li>
        </ul>
      </div> 
      
              <ul class="nav nav-tabs">
                 <li class="nav-item"><a class="nav-link active"  href="crt_do_perd2-dlvP2.php">Create New </a></li>
                 <li class="nav-item"><a class="nav-link"  href="view_do_perd2-dlvP2.php">View Upload DI</a></li>
               
              </ul>
                         
       <?php

	   $message_file = ""; 
	   $message_so = "";
	   $message_p2qr = "";
	   $message_iaqr = "";
	   $message_tripno = "";
	   
	  if($res["plant_code"] == '3100')
	{
	
	$query_id = "SELECT count_max FROM run_count_itsb WHERE uid = '128'";
	$result_id = mysqli_query($dbc,$query_id);
	
	}elseif($res["plant_code"] == '3101')
	{
		
	$query_id = "SELECT count_max FROM run_count_itsb WHERE uid = '129'";
	$result_id = mysqli_query($dbc,$query_id);	
		
	}
   

	if ($result_id) 
{
	$nrows = mysqli_num_rows($result_id);
	$row_id = mysqli_fetch_row($result_id);
	
	$dht = 000; 
	//$dht_OK = "211";
	$dg2 = 0;

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
	$number = $dg; // Length of running no
    $number = sprintf('%07d', $number);  
	
	$ref = $number;
	  
	
	} // end if $result_id	
	   
	
// Set the page title and include the HTML header.
//include ('templates/header.inc');


if(isset($_POST["submit8"]))
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

}

}

 //Add the record to the database
$query_perodua = "INSERT INTO scan_so_perodua1(id,scan_gen,material_doc_gen,so_no,ship_no,ship_name,user_create,date_create,time_create,status_so,user_posting,date_posting,time_posting,status_DO) VALUES ('','".sql_esc($ref)."','','".sql_esc($part1)."','100124','".sql_esc($part2)."','".sql_esc($username)."',NOW(),NOW(),'N','','','','New')";
$result_perodua = mysqli_query($dbc,$query_perodua) or die (mysqli_error());   




$query_all_donum = new PreparedSql("SELECT * FROM scan_crt_donum WHERE id_DO = ? AND status_acc = 'N'", [$ref]);
$result_all_donum = db_query($dbc, $query_all_donum);  
$rst_all_donum  = mysqli_fetch_array($result_all_donum); 


if($rst_all_donum < 1 )
{

//Add the record scan update no
$query_ref_perodua = new PreparedSql("INSERT INTO scan_crt_donum(id,id_DO,status_acc,user_create,date_create) VALUES ('',?,'N',?,NOW())", [$ref, $username]);
$result_ref_perodua = db_query($dbc, $query_ref_perodua) or die (mysqli_error());  

 

}else{
	
	
}



 


	
}  // end submit8


if(isset($_POST["submit9"]))
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

  $p2_barcode = $_POST['p2_barcode'];
  $ref_id = $_POST['ref_id'];


	
} // end submit9


if(isset($_POST["submit10"]))
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

 $p2_barcode = $_POST['p2_barcode'];
 $ref_id = $_POST['ref_id'];
 $ia_barcode = $_POST['ia_barcode'];
 

 





	
} // end submit10







if(isset($_POST['submitTT'])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

/*require_once "excel_reader2.php"; 
		 
ini_set("display_errors",0);		 
set_time_limit(0);*/

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
 $p2_barcode = $_POST['p2_barcodeA'];
 $ia_barcode = $_POST['ia_barcode'];
 $trip_no = $_POST['trip_no'];
 $ref_id = $_POST['ref_id'];
 
 $ia_barcode2 = trim($ia_barcode);
 
 
 //split dulu pps re f kpd prod_order, material,uom, plant, sloc, qty
$str_ia = $ia_barcode2;

if($str_ia)
{

if(explode('|', $str_ia, 8))
{
list($part1A, $part2A, $part3A, $part4A, $part5A, $part6A, $part7A, $part8A) = (explode('|', $str_ia, 8));	

}

}

 //Info
$query_perodua_info = "SELECT * FROM scan_so_perodua1 WHERE scan_gen = '".sql_esc($ref)."'"; 
$result_perodua_info = mysqli_query($dbc,$query_perodua_info);  
$rst_perodua_info  = mysqli_fetch_array($result_perodua_info); 



 //Add the record to the database
$query_perodua2 = "INSERT INTO scan_p2_perodua1(id,id_so,scan_gen,material_doc_gen,p2_barcode,ia_barcode,so_no,ship_no,ship_name,trip_no,pdio_no,date_scan,dlv_date,material_no,material_desc,back_no,part_seq,qty_dlv,user_create,date_create,time_create,user_update,date_update,time_update,status_so,user_posting,date_posting,time_posting,status_DO,material_doc_ref,user_cancel,date_cancel,time_cancel,remark_cancel,tag_no,SAP_ref_doc,SAP_ref_doc_can) VALUES ('','".sql_esc($rst_perodua_info["id"])."','".sql_esc($rst_perodua_info["scan_gen"])."','','".sql_esc($_POST['p2_barcodeA'])."','".sql_esc($_POST['ia_barcode'])."','".sql_esc($so_no)."','".sql_esc($rst_perodua_info["ship_no"])."','".sql_esc($rst_perodua_info["ship_name"])."','".sql_esc($trip_no)."','','','','','','','','','".sql_esc($username)."',NOW(),NOW(),'','','','N','','','','New','','','','','','".sql_esc($part4A)."','','')";
$result_perodua2 = mysqli_query($dbc,$query_perodua2) or die (mysqli_error());   
			


//trim string $_POST['p2_barcodeA']

$query_p2_detail = "SELECT * FROM scan_p2_perodua1 WHERE id = '".mysqli_insert_id($dbc)."'";
$result_p2_detail = mysqli_query($dbc,$query_p2_detail);  
$rst_p2_detail  = mysqli_fetch_array($result_p2_detail); 

//$rst_p2_detail["p2_barcode"];		 
    
	$data_no1 = substr($rst_p2_detail["p2_barcode"],10,9);
	$data_no2 = substr($rst_p2_detail["p2_barcode"],22,10);
	$data_no3 = substr($rst_p2_detail["p2_barcode"],55,14);
    $data_no4 = substr($rst_p2_detail["p2_barcode"],75,4);
	$data_no5 = substr($rst_p2_detail["p2_barcode"],81,4);
	
	//date convert $data_no2
	             $dDlv = substr($data_no2,0,2);
				 $mDlv = substr($data_no2,3,2);
				 $yDlv = substr($data_no2,6,4);
			
			     $dt_finalDLv = ($yDlv.'-'.$mDlv.'-'.$dDlv);
				 
				 //infor table_material_cust
$query_mat = "SELECT * FROM table_material_cust WHERE material_cust_no = '".sql_esc($data_no3)."'";
$result_mat = mysqli_query($dbc,$query_mat);  
$rst_mat  = mysqli_fetch_array($result_mat); 
	
//--update scan_p2_perodua1

$query_p2_upd = "UPDATE scan_p2_perodua1 SET pdio_no = '".sql_esc($data_no1)."', date_scan = '".sql_esc($data_no2)."', dlv_date = '".sql_esc($dt_finalDLv)."', material_no = '".sql_esc($data_no3)."', back_no = '".sql_esc($data_no4)."', qty_dlv = '".sql_esc($data_no5)."', material_desc = '".sql_esc($rst_mat["material_desc_cust"])."' WHERE id = '".sql_esc($rst_p2_detail["id"])."'"; 
$result_p2_upd = mysqli_query($dbc,$query_p2_upd);  	
      
		   	   
			echo "<script>";
			echo "alert('Successfully add item.');";
            echo "window.location='crt_do_perd2-dlvP2.php?scan_gen=$ref_id&&so_no=$so_no';";
            echo "</script>";
           // exit(); //quit the script 
		   

} // end submitTT

if(isset($_POST["submit4Dlv"])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

$scan_gen = $_POST['scan_gen'];




 //------generate Material Document No. for GR Generate.---------------------------------
	
	  if($res["plant_code"] == '3100')
	{
	
	 $query_id2 = "SELECT count_max FROM run_count_itsb WHERE uid = '130'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	}elseif($res["plant_code"] == '3101')
	{
		
	 $query_id2 = "SELECT count_max FROM run_count_itsb WHERE uid = '131'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
		
	}
	
	if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_row($result_id2);
	
	$dht2 = 000; 
	$dht_OK2 = 000;
	$dg2 = 0;

  	if($row_id2[0] <= 0)
  	{ 
   
    	$lastID2 = ($row_id2[0] + 1);
    	$dg2 = ($dht2 + ($lastID2));
   }
   else
   {
      $lastID2 = ($row_id2[0] + 1);
      $dg2 =  $lastID2;
	
    }
	$number2 = $dg2; // Length of running no
    $number2 = sprintf('%05d', $number2);  
	
    $ref2 = ($res["plant_code"].$date_run.($number2));
	
	
	} // end if $result_id2
	

      $query_upd_DO = "UPDATE scan_p2_perodua1 SET material_doc_gen = '".sql_esc($ref2)."', status_DO = 'Approved', status_so = 'Y', user_posting = '".sql_esc($username)."', date_posting = NOW(), time_posting = NOW() WHERE scan_gen = '".sql_esc($scan_gen)."'";
      $result_upd_DO = mysqli_query($dbc,$query_upd_DO);



//update count_max----------------------------------------
	 
	  if($res["plant_code"] == '3100')
	{
	   
	   $query_max_a1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '128'";
	   $result_max_a1 = mysqli_query($dbc,$query_max_a1);
	   
	   $query_max_a2 = "UPDATE scan_crt_donum SET status_acc = 'Y' WHERE id_DO = '".sql_esc($scan_gen)."' AND user_create = '".sql_esc($username)."'";
	   $result_max_a2 = mysqli_query($dbc,$query_max_a2);
	   
	   $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '130'";
	   $result_max_a = mysqli_query($dbc,$query_max_a);
	   
	   

	}elseif($res["plant_code"] == '3101')
	{
	   
	   $query_max_a1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '129'";
	   $result_max_a1 = mysqli_query($dbc,$query_max_a1);
	   
	   $query_max_a2 = "UPDATE scan_crt_donum SET status_acc = 'Y' WHERE id_DO = ''".sql_esc($scan_gen)."' AND user_create = '".sql_esc($username)."'";
	   $result_max_a2 = mysqli_query($dbc,$query_max_a2);
	   
	   $query_max_b = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '131'";
	   $result_max_b = mysqli_query($dbc,$query_max_b);
	}

   //end update count_max ---------------------------------	



            echo "<script>";
			echo "alert('Delivery Order $ref2 successfully created.');";
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
            <h3 class="tile-title">Create Delivery Order - Perodua</h3>
            <div class="tile-body">
      
         <form name="formCrtDO" action="crt_do_perd2-dlvP2.php?scan_gen=<?php echo $ref; ?>&&so_no=<?php echo $part1; ?>" method="post" class="form-horizontal">
  
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="2"></th>
            </tr>
             <tr>
                <th>Sales Order : <font color="#FF0000">*</font></th>
                <th colspan="2">
           <input class="form-control" id="so_no" type="text" placeholder="Enter Sales Order No." name="so_no" value="<?php if(isset($_POST['so_no'])){ echo html_esc($_POST['so_no']); }else{ if($_GET["so_no"] != '') { echo html_esc($_GET["so_no"]); }  }?>" autofocus required />    
          <div class="form-control-feedback" ><?php echo $message_so; ?></div>   <input name="submit8" type="submit" id="submit8" value="+ Scan Item" class="button"  />  
            <!-- <div id="result"></div>-->
               </th>
              </tr>
            <tr>
            <th>P2 QRCode : <font color="#FF0000">*</font></th>
            <td colspan="2">
           <input class="form-control" id="p2_barcode" type="text" placeholder="Enter P2 QRCode" name="p2_barcode" value="<?php if(isset($_POST['p2_barcode'])){ echo html_esc($_POST['p2_barcode']); } ?>" autofocus required />
         <div class="form-control-feedback" ><?php echo $message_p2qr; ?></div><input name="submit9" type="submit" id="submit9" value="+ Scan Item" class="button"  /> 
		     </td>
             </tr>
             <tr>
              <th>IA QRCode: <font color="#FF0000">*</font></th>
              <td colspan="2">
                 <input class="form-control" id="ia_barcode" type="text" placeholder="Enter IA QRCode" name="ia_barcode" value="<?php if(isset($_POST['ia_barcode'])){ echo html_esc($_POST['ia_barcode']); } ?>"  autofocus required/>
              <div class="form-control-feedback" ><?php echo $message_iaqr; ?></div><input name="submit10" type="submit" id="submit10" value="+ Scan Item" class="button"  /> </td>
              </tr>
            
              <tr>
                <th>Trip :<font color="#FF0000">*</font></th>
                <td>
                
                <select name="trip_no" class="form-control" id="trip_no">
<?php
    for ($q=1; $q<=20; $q++)
    {
        ?>
            <option value="<?php echo $q;?>"><?php echo $q;?></option>
        <?php
    }
?>
</select>
                    
                   <div class="form-control-feedback" ><?php echo $message_tripno;   ?>  </div>
                   <br>
                   
                   
                 </td>
             

              </tr>             
              <tr>
                <th>
                <input class="form-control" id="ref_id" type="hidden"  name="ref_id" value="<?php echo $ref;  ?>" /> 
                <input class="form-control" id="so_noA" type="hidden"  name="so_noA" value="<?php echo $part1  ?>" />  
                <input class="form-control" id="p2_barcodeA" type="hidden"  name="p2_barcodeA" value="<?php echo html_esc($_POST['p2_barcode']);   ?>" />     
                <input name="submitTT" type="submit" class="btn btn-info" id="button" value="SUBMIT" /></th>
                <th colspan="2">&nbsp;</th>
              </tr>
            
                </table>
        </form> 
        
        
        
      <?php  
        
        
        
             $query_sql2 = "SELECT * FROM scan_p2_perodua1 WHERE scan_gen = '".sql_esc($ref)."' AND user_create = '".sql_esc($username)."'";
			 $result_sql2 = mysqli_query($dbc,$query_sql2);
			 $num_1 = mysqli_num_rows($result_sql2);   //how many material are there?
    
		  
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
   
   while($row = mysqli_fetch_array($result_sql2))
   {
	   
	    $no4 = sprintf('%04d',$no4);
	 
		
      ?>
                <tr>
                <td width="60"><div align="center"><a href="delete_do_per2_item.php?scan_gen=<?php echo html_esc($row["scan_gen"]); ?>&&so_no=<?php echo html_esc($row["so_no"]); ?>&&p_id=<?php echo html_esc($row["id"]); ?>" onclick="return confirm('Are you sure you want to delete?')"><img src="../images/delete.png" alt="Remove Item"></a></div></td>
                <td width="60"><?php echo $no4; ?><input name="id[<?php echo html_esc($row["id"]); ?>]" type="hidden" value="<?php echo html_esc($row["id"]); ?>">
                <input name="item_no[<?php echo html_esc($row["id"]); ?>]" type="hidden" value="<?php echo $no4; ?>"></td>
                <td width="150"><?php echo html_esc($row["material_no"]); ?></td>
                <td width="300"><?php echo html_esc($row["material_desc"]); ?></td> 
                <td width="100"><?php echo html_esc($row["dlv_date"]); ?></td>
                <td width="150"> <input name="qty_dlv[<?php echo html_esc($row["id"]); ?>]" type="number" min="1" value="<?php if(isset($_POST["qty_dlv"])) { echo html_esc($_POST["qty_dlv"][($row["id"])]); }else{   echo (intval($row["qty_dlv"]));  } ?>" id="qty_dlv" class="form-control form-control-sm">
                 </td>
              
                <td width="80"><?php echo html_esc($row["pdio_no"]); ?><!--<input name="plant_code2" type="hidden" value="<?php //echo $row["plant_code"]; ?>">--></td> 
                <td width="200"><?php echo html_esc($row["tag_no"]); ?>   <input class="form-control" id="scan_gen" type="hidden"  name="scan_gen" value="<?php echo html_esc($row["scan_gen"]);  ?>" /> </td>
                </tr>
                 
          <?php 
		  
		  $no4++;
		  $counter++; // menambah counter
		  $w ++; 
          $k ++;

		  } 
		  
       mysqli_free_result($result_sql2); 		  
		  ?>
 </tbody>
</table> <!--
        <div class="form-actions">-->
      
               <input name="submit4Dlv" type="submit" id="submit4" value="SUBMIT" class="btn btn-success btn-sm" onclick="return confirm('Confirm to Create Delivery Order?');" >
               <input name="submit5Dlv" type="submit" id="submit5" class="btn btn-warning btn-sm" value="CLEAR">
                 

<?php  

 }else{
 
?> 

<?php   } ?>


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
  <!--  <script type="text/javascript" src="js/plugins/bootstrap-notify.min.js"></script>
    <script type="text/javascript" src="js/plugins/sweetalert.min.js"></script>-->
   
     <script type="text/javascript">
     
		  
      $('#PlanDate').datepicker({
	    defaultDate: new Date(),
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
      
	   $('#Plan2Date').datepicker({
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      
    </script>

  
  
  </body>
</html>