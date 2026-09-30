<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));

                 $drun = substr($fmt_curr_date,0,2);
				 $mrun = substr($fmt_curr_date,3,2);
				 $yrun = substr($fmt_curr_date,8,2);
				 
				 $date_run = ($drun.$mrun.$yrun);


set_time_limit(0);

//-----date----
$today = getdate();
$hours = $today['hours']; 
$minutes = $today['minutes'];
$seconds = $today['seconds'];
$month = $today['mon']; 
$mday = $today['mday']; 
$year = $today['year']; 


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
	
$url = "detail_GR_return-receive.php"; 

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

//CR status (Transfer Posting)
$sta19 = "SELECT * from request_status WHERE status_id = '19'";
$sta_res19 = mysqli_query($dbc,$sta19);
$rst_sta19 = mysqli_fetch_array($sta_res19);	

//CR status (Transfer GRA)
$sta23 = "SELECT * from request_status WHERE status_id = '23'";
$sta_res23 = mysqli_query($dbc,$sta23);
$rst_sta23 = mysqli_fetch_array($sta_res23);	

//CR status (Return GRA)
$sta26 = "SELECT * from request_status WHERE status_id = '26'";
$sta_res26 = mysqli_query($dbc,$sta26);
$rst_sta26 = mysqli_fetch_array($sta_res26);	

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
    
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script> 
    
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    
    
    
    
    
    
    
 <!--   <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script> 
    
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>-->
    
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
 
     <script language="javascript">
    $(document).ready(function() {
    $('#example').DataTable( {
        "scrollX": true
    } );
} );
</script>
<style>
div.dataTables_wrapper {
        width: 1000px;
        margin: 0 auto;
    }
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
<style>
.pagin {
  display: inline-block;
}

.pagin a {
  color: black;
  float: left;
  padding: 7px 10px;
  text-decoration: none;
  border: 1px solid #ddd;
}

.pagin a.active {
  background-color: #32A478;
  color: white;
  border: 1px solid #32A478;
}

.pagin a:hover:not(.active) {background-color: #ddd;}

.pagin a:first-child {
  border-top-left-radius: 5px;
  border-bottom-left-radius: 5px;
}

.pagin a:last-child {
  border-top-right-radius: 5px;
  border-bottom-right-radius: 5px;
}
</style> 
<style>
.shortenedSelect {
    max-width: 300px;
}

</style>
    <style>
input[value="+ Add Item"]{
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
          <h1><i class="fa fa-file-text-o"></i> Receiving</h1>
          <p>Goods Return</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Receiving </li>
          <li class="breadcrumb-item"><a href="detail_GR_return-receive.php">Goods Return</a></li>
        </ul>
      </div> 
      
       <?php
 $message_pps = "";
 $message_gr = "";

	$query_id = "SELECT * FROM run_count_itsb WHERE uid = '116'";
	$result_id = mysqli_query($dbc,$query_id);
	
	
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
    $number = sprintf('%07d', $number);  
	
	
	  
	
	} // end if $result_id		

	     
  if((isset($_POST["submit3"]))  && $_POST!=="") 
{ // handle the form.


require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

function escape_data($data) {
global $dbc;   // need the connection.
if (ini_get('magic_quotes_gpc')) {
    $data = stripslashes($data);
	}
	return mysqli_real_escape_string($data,$dbc);
	}   // end function.
$message = NULL; // create an empty new variable.



   
   $pps_ref = $_POST["pps_ref"];
   
// check for a pps ref (scan from pps)

    if(($_POST["pps_ref"]) == "")
     {
	     $pps_ref = FALSE;
		 $message_pps = '<span class="badge badge-pill badge-danger">Please scan GRA barcode!</span>';
	 }else{
		 $pps_ref = TRUE;
	  }
 

if($pps_ref) //everything ok
{ 
 
  
   $pps_ref = $_POST["pps_ref"];
//checking delete space semasa scanning

$pps_ref2 =trim($pps_ref);
			
 
//split dulu pps ref kpd prod_order, material,uom, plant, sloc, qty
$str = $pps_ref2;


list($partA1, $partA2, $partA3, $partA4, $partA5, $partA6, $partA7, $partA8, $partA9, $partA10) = (explode('|', $str, 10));


              //---- date scan----

				 $ddS = substr($partA5,0,2);
				 $mmS = substr($partA5,3,2);
				 $yyS = substr($partA5,6,4);
			
			     $date2_final = ($yyS.'-'.$mmS.'-'.$ddS);

               /*//----date posting---

                 $ddF = substr($_POST["date1"],0,2);
				 $mmF = substr($_POST["date1"],3,2);
				 $yyF = substr($_POST["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);*/

    if($partA3 != "")
	{
  //--------- check for closed planning order x bleh scan pps------------- 
    $query_check_pps = "SELECT * FROM pps_detail WHERE plan_no = '".sql_esc($partA3)."'";
	$result_check_pps = mysqli_query($dbc,$query_check_pps);
    $data_check_pps = mysqli_fetch_array($result_check_pps);
	
	if(($data_check_pps["status_pps"] == "Closed") || ($data_check_pps["status_pps"] == "Transfer QC"))
	{
		
			  echo "<script>";
			  echo "alert('PPS is already Closed. Please scan the others pps.');";
			  echo "window.location='detail_GR_return-receive.php'";
			  echo "</script>";
			  exit(); //quit the script
		
	}
	
	}
	
	//if(($data_check_pps["status_pps"] != "Closed") || ($data_check_pps["status_pps"] != "Transfer QC"))
	//{
  

  
  //---get id_scan_gra from table gra_qc_detail
  
  $queryGR = "SELECT * FROM gra_qc_detail WHERE doc_gra = '".sql_esc($partA4)."' AND material_no = '".sql_esc($partA1)."' ORDER BY id_gra ASC";
  $resultGR = mysqli_query($dbc,$queryGR);
  $rowGR = mysqli_fetch_array($resultGR); 
				   
  $query_q2 = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ?", [$partA1]);
  $result_q2 = db_query($dbc, $query_q2);
  $ans3 = mysqli_fetch_array($result_q2);
  
  
  
  //---------detail material_type_tbl (material_type) ----
  
  $query_mtype2 = new PreparedSql("SELECT * FROM material_type_tbl WHERE id = ?", [$ans3["mat_type"]]);
  $result_mtype2 = db_query($dbc, $query_mtype2) or die (mysqli_error());
  $d_mtype2 = mysqli_fetch_array($result_mtype2);
  
  
  //---------detail model_detail_tbl(model_code) ---
  
  $query_mcode2 = new PreparedSql("SELECT * FROM model_detail_tbl WHERE id_model = ? AND material_type = ?", [$ans3["model_code"], $ans3["mat_type"]]);
  $result_mcode2 = db_query($dbc, $query_mcode2) or die (mysqli_error());
  $d_mcode2 = mysqli_fetch_array($result_mcode2);
  


//Part Number | Plant | Purchase Order No. | Doc. No. | Posting Date | Location | Quantity | UoM | GR Doc. No. | Delivery Order No.

//insert to scan_detail
$query_db = "INSERT INTO sc_gra_return_rcv(id_scan,id_gra_qc,scan_doc,barcode_ref,material_no,material_desc,plan_no,plant_code,material_type,work_center,scan_sloc,scan_shift,scan_qty,scan_uom,doc_no,gr_doc_no,dlv_ord_no,posting_date,scan_date,user_create,date_create,user_update,date_update,status,status_gra) VALUES('','".sql_esc($rowGR["id_gra"])."','".sql_esc($number)."','".sql_esc($pps_ref2)."','".sql_esc($partA1)."','".sql_esc($ans3["material_desc"])."','".sql_esc($partA3)."','".sql_esc($partA2)."','".sql_esc($d_mtype2["mat_type_id"])."','".sql_esc($ans3["prod_line"])."','".sql_esc($partA6)."','','".sql_esc($partA7)."','".sql_esc($partA8)."','".sql_esc($partA4)."','".sql_esc($partA9)."','".sql_esc($partA10)."','',NOW(),'".sql_esc($username)."',NOW(),'','','Y','".sql_esc($rst_sta["status_desc"])."')";
$result_db = mysqli_query($dbc,$query_db);


             if($result_db)
             {
			 
			 $query_sql = "SELECT * FROM sc_gra_return_rcv WHERE id_scan = '".mysqli_insert_id($dbc)."'";
			 $result_sql = mysqli_query($dbc,$query_sql);
			 $data_sql = mysqli_fetch_array($result_sql);
			 
			  echo "<script>";
			  echo "window.location='detail_GR_return-receive.php?scan_doc=$number&&pps_ref=$pps_ref'";
			  echo "</script>";
			  exit(); //quit the script
			  
             }
             else 
			 {
              echo "<script>";
			  echo "alert('Goods Return is failed. ');";
			  echo "</script>";
			  exit(); //quit the script	 
				 
             // mysqli_close($dbc); //close db
             }   
//} // end else

	
	 
}//print the message if there is one.
	  
} //end submit3


//-------------------------------------------------------------------------------------------------------------------------
if(isset($_POST["submit4"]))  
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}


       $shift_ops = $_POST["shift_ops"];
       $dateF = $_POST["date1"];
	   $scan_doc = $number;  
	   $item_no = $_POST["item_no"];
	   $id_scan = $_POST["id_scan"];  
	   $plant_code2 = $_POST["plant_code2"];
	   $bar_gr = $_POST["bar_gr"];
	   
	 

  if($id_scan)
  {
		   
	   //-------------------generate gra QC doc no.---------------
	
	 if($_POST["plant_code2"] == '3100')
	{
	
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '9'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	}elseif($_POST["plant_code2"] == '3101')
	{
		
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '64'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
		
	}
	
	if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 00000; 
	$dht_OK2 = "141";
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
	
    $ref5 = (($row_id2["start_ref"]).$dht_OK2.$date_run.($number2));
	  
	
	} // end if $result_id2

	  //update count_max----------------------------------------
	 
	  if($_POST["plant_code2"] == '3100')
	{
  
       $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '9'";
	   $result_max_a = mysqli_query($dbc,$query_max_a);
	   
	   $query_max_a1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '116'";
	   $result_max_a1 = mysqli_query($dbc,$query_max_a1);

	}elseif($_POST["plant_code2"] == '3101')
	{
	   $query_max_b = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '64'";
	   $result_max_b = mysqli_query($dbc,$query_max_b);
	   
	   $query_max_a1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '116'";
	   $result_max_a1 = mysqli_query($dbc,$query_max_a1);
	}

   //end update count_max ---------------------------------	   
		
		$amountA = "";
		$amountB = "";
		$amountC = "";

	    $how_many = count($id_scan); 
		
		$item_no = $_POST["item_no"]; 
		$id_scan = $_POST["id_scan"]; 
		$shift_ops = $_POST["shift_ops"];
        $dateF = $_POST["date1"];
		$bar_gr = $_POST["bar_gr"];
		
		
	         	//----date posting---

                 $ddF = substr($_POST["date1"],0,2);
				 $mmF = substr($_POST["date1"],3,2);
				 $yyF = substr($_POST["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 

       foreach($_POST["id_scan"] as $j=>$i) {
	
		$amountA .= (($_POST["item_no"][$i]).';');
		$amountB .= (($_POST["id_scan"][$i]).';');
		$amountC .= (($_POST["bar_gr"][$i]).';');

		
		//-----checking barcode GR Tag
		
		$stringA = explode(";",($amountA));	
		$stringB = explode(";",($amountB));	
		$stringC = explode(";",($amountC));	
		
		 if(($_POST["id_scan"][$i]) == "")
	      { 
		     $id_scan = FALSE;
			 $message_gr = '<span class="badge badge-pill badge-danger">Please enter GR Doc. No.!</span>';
				
		   }//end if
	
        }
		
	  
		 			
		   for ($i=0; $i<$how_many; $i++) { 

		   
		//echo $stringB[$i]; echo "</br>";
	
		
		
	
			
		$query_update_scan2 = "UPDATE sc_gra_return_rcv SET status_gra = '".sql_esc($rst_sta26["status_desc"])."', scan_shift = '".sql_esc($shift_ops)."', posting_date = '".sql_esc($date1_final)."', gr_doc_no = '".sql_esc($stringC[$i])."'  WHERE id_gra_qc = '".sql_esc($stringB[$i])."' AND scan_doc = '".sql_esc($number)."' ";
	    $rst_update_scan2 = mysqli_query($dbc,$query_update_scan2);
		
		$query_update_scan2A = "UPDATE gra_qc_detail SET status_gra = '".sql_esc($rst_sta26["status_desc"])."', doc_no_return = '".sql_esc($ref5)."', return_by = '".sql_esc($username)."', date_return = NOW(), gr_doc_no = '".sql_esc($stringC[$i])."' WHERE id_gra = '".sql_esc($stringB[$i])."'";
	    $rst_update_scan2A = mysqli_query($dbc,$query_update_scan2A);

		
			//---------get data from po_detail_trans_gr by azie 10 sept 2021------------
			
		
		$query_info_po = "SELECT * FROM po_detail_trans_gr WHERE material_doc_gen = '".sql_esc($stringC[$i])."' ";
		$result_info_po = mysqli_query($dbc,$query_info_po);
		$data_info_po = mysqli_fetch_array($result_info_po);
		
	    $query_update_scan3A = "UPDATE gra_qc_detail SET plan_no = '".sql_esc($data_info_po["purc_ord_no"])."', doc_no = '".sql_esc($data_info_po["dlv_ord_no"])."', dlv_ord_no = '".sql_esc($data_info_po["dlv_ord_no"])."' WHERE id_gra = '".sql_esc($stringB[$i])."' AND gr_doc_no = '".sql_esc($stringC[$i])."'";
	    $rst_update_scan3A = mysqli_query($dbc,$query_update_scan3A);
			 
		  //-------------end additional by azie 10 sept 2021---------------------------	
		
			
		 $query_dtl_chk2A = "SELECT * FROM gra_qc_detail WHERE status_gra = '".sql_esc($rst_sta26["status_desc"])."' AND id_gra = '".sql_esc($stringB[$i])."'";
		 $result_dtl_chk2A = mysqli_query($dbc,$query_dtl_chk2A);
		 $row_infoA = mysqli_fetch_array($result_dtl_chk2A); 
		 
		
			
		 //-------------get material detail ----------
		  $query_mate = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ?", [$row_infoA["material_no"]]);
		  $result_mate = db_query($dbc, $query_mate);
		  $data_mate = mysqli_fetch_array($result_mate);
		  
		  //---------detail material_type_tbl (material_type) ----
		  
		  $query_mtypeA = new PreparedSql("SELECT * FROM material_type_tbl WHERE id = ?", [$data_mate["mat_type"]]);
		  $result_mtypeA = db_query($dbc, $query_mtypeA) or die (mysqli_error());
		  $d_mtypeA = mysqli_fetch_array($result_mtypeA);
		  
		  
		  //---------detail model_detail_tbl(model_code) ---
		  
		  $query_mcodeA = new PreparedSql("SELECT * FROM model_detail_tbl WHERE id_model = ?", [$data_mate["model_code"]]);
		  $result_mcodeA = db_query($dbc, $query_mcodeA) or die (mysqli_error());
		  $d_mcodeA = mysqli_fetch_array($result_mcodeA);
		 
	     
		  //-----detail sloc_gr_return -------

		  $query_loc = "SELECT * FROM sloc_gr_return WHERE id_sloc = '1'";
		  $result_loc = mysqli_query($dbc,$query_loc) or die (mysqli_error());
		  $d_loc = mysqli_fetch_array($result_loc);
		  

		//---------insert data at table gra_qc_detail_return-rcv
		
		  $query_store_ret = "INSERT INTO gra_qc_detail_return_rcv(id,id_gra,scan_doc_return,doc_gra,id_scan_gra,scan_doc,item_no,material_no,material_desc,plan_no,doc_no,plant_code,sloc_from,vendor_no,qty_gra,uom_gra,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_gra,date_generate_gra,ref_doc_gra,user_cancel,date_cancel,status_ftp,status_tran,status_gra,barcode_gr,gr_doc_no,remark_gra,doc_no_return,return_by,date_return,received_by,date_received,lorry_no,ic_driver,dlv_ord_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_infoA["id_gra"])."','".sql_esc($number)."','".sql_esc($row_infoA["doc_gra"])."','".sql_esc($row_infoA["id_scan_gra"])."','".sql_esc($row_infoA["scan_doc"])."','".sql_esc($row_infoA["item_no"])."','".sql_esc($row_infoA["material_no"])."','".sql_esc($row_infoA["material_desc"])."','".sql_esc($row_infoA["plan_no"])."','".sql_esc($row_infoA["doc_no"])."','".sql_esc($row_infoA["plant_code"])."','".sql_esc($d_loc["sloc_code"])."','".sql_esc($row_infoA["vendor_no"])."','".sql_esc($row_infoA["qty_gra"])."','".sql_esc($row_infoA["uom_gra"])."','".sql_esc($date1_final)."','".sql_esc($shift_ops)."','".sql_esc($d_mcodeA["model_code"])."','".sql_esc($d_mtypeA["mat_type_id"])."','".sql_esc($row_infoA["stamp_ind"])."','".sql_esc($row_infoA["slip_no"])."','".sql_esc($row_infoA["user_create"])."','".sql_esc($row_infoA["date_create"])."','".sql_esc($row_infoA["user_generate_gra"])."','".sql_esc($row_infoA["date_generate_gra"])."','".sql_esc($row_infoA["ref_doc_gra"])."','".sql_esc($row_infoA["user_cancel"])."','".sql_esc($row_infoA["date_cancel"])."','N','Y','".sql_esc($row_infoA["status_gra"])."','".sql_esc($row_infoA["barcode_gr"])."','".sql_esc($row_infoA["gr_doc_no"])."','".sql_esc($row_infoA["remark_gra"])."','".sql_esc($row_infoA["doc_no_return"])."','".sql_esc($row_infoA["return_by"])."','".sql_esc($row_infoA["date_return"])."','".sql_esc($row_infoA["received_by"])."','".sql_esc($row_infoA["date_received"])."','".sql_esc($row_infoA["lorry_no"])."','".sql_esc($row_infoA["ic_driver"])."','".sql_esc($row_infoA["dlv_ord_no"])."','".sql_esc($row_infoA["SAP_ref_doc"])."','".sql_esc($row_infoA["SAP_ref_doc_can"])."')";          
		  $rst_store_ret = mysqli_query($dbc,$query_store_ret);
		
		

		//---update status "yes" for generate gra QC----
		
		$query_update_scan = "UPDATE sc_gra_return_rcv SET status = 'Y' WHERE id_gra_qc = '".sql_esc($stringB[$i])."'";
	    $rst_update_scan = mysqli_query($dbc,$query_update_scan);
		
	}//end for loop
       
	   //----checking ftp gra_qc_detail-------
    $data_rcv = "";
   

  $query_rcv_ftp = "SELECT *, DATE_FORMAT(posting_date,'%d%m%Y') AS J, DATE_FORMAT(date_create,'%d%m%Y') AS R2 FROM gra_qc_detail_return_rcv WHERE doc_no_return = '".sql_esc($ref5)."'";
   $result_rcv_ftp = mysqli_query($dbc,$query_rcv_ftp);
   
   $filen_rcv = "GR".$ref5; 
  
   while($data_rcv_ftp = mysqli_fetch_array($result_rcv_ftp))
   
   {
        //-----return by------
		 $query_prep = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$data_rcv_ftp["return_by"]]);
		 $result_prep = db_query($dbc, $query_prep) or die (mysqli_error());
		 $data_prep = mysqli_fetch_array($result_prep);
		 
		 //----quantity-----
		 $qty_new = (intval($data_rcv_ftp["qty_gra"]));
		 
		

/*Plant;Document No.;Delivery Order No.;Posting Date;Part No.;Quantity;Unit of Measure;Movement Type;Storage Location;Recipient 
Output: 2300;2300141070320001;DO001;29122019;57646-BZ060;700;PCS;122;R110;IKHRAM */


$data_rcv .= $data_rcv_ftp["plant_code"].";".$data_rcv_ftp["doc_no_return"].";".$data_rcv_ftp["dlv_ord_no"].";".$data_rcv_ftp["J"].";".$data_rcv_ftp["material_no"].";".$qty_new.";".$data_rcv_ftp["uom_gra"].";122;".$data_rcv_ftp["sloc_from"].";".$data_prep["user_fullname"]."\r\n";
   


  
     //----------update table ftp_tp_gra_qc_return-rcv------------
   
    $query_rcv_ftp_info = "INSERT INTO ftp_tp_gra_qc_return_rcv(id,file_name,doc_no_return,doc_gra,id_gra,plan_no,material_no,material_desc,qty_ftp,uom,plant,shift_day,slip_no,mvt_type,status_ftp,posting_date,posting_time,sloc_from,sloc_to,prepared_by,user_create,date_create,vendor_no,status_gra) VALUES('','".sql_esc($filen_rcv)."','".sql_esc($ref5)."','".sql_esc($data_rcv_ftp["doc_gra"])."','".sql_esc($data_rcv_ftp["id_gra"])."','".sql_esc($data_rcv_ftp["plan_no"])."','".sql_esc($data_rcv_ftp["material_no"])."','".sql_esc($data_rcv_ftp["material_desc"])."','".sql_esc($data_rcv_ftp["qty_gra"])."','".sql_esc($data_rcv_ftp["uom_gra"])."','".sql_esc($data_rcv_ftp["plant_code"])."','".sql_esc($data_rcv_ftp["shift_day"])."','".sql_esc($data_rcv_ftp["slip_no"])."','122','Y','".sql_esc($data_rcv_ftp["posting_date"])."','','".sql_esc($data_rcv_ftp["sloc_from"])."','','".sql_esc($data_prep["user_fullname"])."','".sql_esc($username)."',NOW(),'".sql_esc($data_rcv_ftp["vendor_no"])."','".sql_esc($data_rcv_ftp["status_gra"])."')"; 
     $rst_rcv_ftp_info = mysqli_query($dbc,$query_rcv_ftp_info);
	 
	  
	  
	  }

		$file_rcv = "../FromPortal2/GR/".$filen_rcv.".csv";
		file_put_contents($file_rcv,$data_rcv);

   
	   // ---update status 
   
		$query_rcv_ftp2 = "UPDATE gra_qc_detail_return_rcv SET status_ftp = 'Y' WHERE scan_doc_return = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
		$rst_query_rcv_ftp2 = mysqli_query($dbc,$query_rcv_ftp2); //or die ("Error in query: $query_ftp"); 
		
				
    //---------------------------------------end ftp -------------------------------------------------   
	   
	   
   
  // $ref_GRA = (base64_encode($ref));
   
    echo '<script type="text/javascript">';
	echo "alert('Material Document $ref5 posted.');";
	//echo "window.open('detail_gra_sheet_print.php?uid=$ref_GRA', '_blank');";
	echo "window.location='detail_GR_return-receive.php';"; 
	echo "</script>";
	exit(); //quit the script
   
	
	 }//end ifelse "OK"
	  else{
		   
		echo '<script type="text/javascript">';
		echo "alert('Error! Transaction failed. Please enter field correctly.');";
		echo "window.location='detail_GR_return-receive.php';"; 
		echo "</script>";
		exit(); //quit the script
		   
		   
	   }

}// end submit 4



if(isset($_POST["submit5"])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

//-----------delete all data current screen-------------

   $query_delete_scan = "DELETE FROM sc_gra_return_rcv WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
   $result_delete_scan = mysqli_query($dbc,$query_delete_scan);

//---------end delete ----------------------------------


}

?>
      
   
        <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Goods Return </h3>
            <div class="tile-body">
              <div class="table-responsive">
            
          <form id="form1" method="post" action="" >
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="2">&nbsp;</th>
            </tr>
             <tr>
                <th>Scan GRA Barcode : <font color="#FF0000">*</font>&nbsp;&nbsp;<i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="1. Goods Return Advise" data-html="true" data-placement="left"></i></th>
                <th colspan="2">
          <input name="pps_ref" type="text" id="pps_ref" maxlength="200" value="<?php if(isset($_POST['pps_ref'])) { echo html_esc($_POST['pps_ref']); } ?>" class="form-control" autofocus/> 
            
          &nbsp;&nbsp;<small>Eg: Part Number|Plant|Purchase Order No.|Doc. No.|Posting Date|Location|Quantity|UoM|GR Doc. No.|Delivery Order No. </small>
          
            <div class="form-control-feedback" ><?php echo $message_pps; ?></div> <input name="submit3" type="submit" id="submit3" value="+ Add Item" class="button"  />
                
               </th>
              </tr>         
                </table>
        </form>
        
        
        
         <?php

     $no = 1;
	 $sloc_to = "";
	 $k = 1;
	 $w = 1;


   
             $query_sql2 = "SELECT *,DATE_FORMAT(posting_date,'%d-%m-%Y') as R FROM sc_gra_return_rcv WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
			 $result_sql2 = mysqli_query($dbc,$query_sql2);
			 $num_1 = mysqli_num_rows($result_sql2);   //how many material are there?
    
		  
		 if ($num_1 > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_1.' record(s).</div>'; 
	   
        
    	?>

                     
           <form action="detail_GR_return-receive.php?scan_doc=<?php echo $number; ?>&&pps_ref=<?php echo $pps_ref;  ?>" method="post" name="myform" id="myform">
           
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th colspan="3">&nbsp;</th>
            </tr>  
            <tr>
              <th>Posting Date :  <font color="#FF0000">*</font></th>
              <td colspan="3"><input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php if(isset($_POST['date1'])){ echo html_esc($_POST['date1']); }else{ echo $fmt_curr_date; } ?>" />
               <div class="form-control-feedback" ><?php echo $message_psdt; ?></div>
              </td>
              </tr>
               <tr>
                <th>Shift :  <font color="#FF0000">*</font></th>
                
                <td colspan="2">
                     <div class="form-check">
                        <input class="form-check-input" id="shift_post1" type="radio" name="shift_ops" value="D/S" checked="">Day
                      </div>
                   <div class="form-control-feedback" ><?php echo $message_shift; ?></div>
                    </td>
                <td><div class="form-check">
                        <input class="form-check-input" id="shift_post2" type="radio" name="shift_ops" value="N/S">Night
                    </div><div class="form-control-feedback" ><?php echo $message_shift; ?></div></td> 
              </tr>  
            </table>      
           
                <table class="table table-hover table-bordered" id="example">
                <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Item.</th>
                    <th>Part Number</th>
                    <th>Part Name</th>
                    <th>Quantity</th>
                    <th>UoM</th>
                    <th>GR Document No.</th>
                    <th>Remark</th>
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
		
		 //---get info sc_gra_return_rcv	
		$query_sc_asal = "SELECT * FROM gra_qc_detail WHERE id_gra = '".sql_esc($row["id_gra_qc"])."'";
		$rs_sc_asal  = mysqli_query($dbc,$query_sc_asal);
	    $data_sc_asal  = mysqli_fetch_array($rs_sc_asal);

	  
		
      ?>
                <tr>
                <td width="50"><a href="delete_gra_return_item.php?scan_doc=<?php echo html_esc($row["scan_doc"]); ?>&&p_id=<?php echo html_esc($row["id_scan"]); ?>&&pps_ref=<?php echo html_esc($row["barcode_ref"]); ?>&&date1=<?php echo html_esc($row["posting_date"]); ?>&&shift_ops=<?php echo html_esc($row["scan_shift"]); ?>" onclick="return confirm('Are you sure you want to delete?')"><img src="../images/delete.png" alt="Remove Item"></a></td>
                <td width="50"><?php echo $no4; ?><input name="id_scan[<?php echo html_esc($row["id_gra_qc"]); ?>]" type="hidden" value="<?php echo html_esc($row["id_gra_qc"]); ?>">
                <input name="item_no[<?php echo html_esc($row["id_gra_qc"]); ?>]" type="hidden" value="<?php echo $no4; ?>"></td>
                <td width="200"><?php echo html_esc($row["material_no"]); ?></td>
                <td width="350"><?php echo html_esc($row["material_desc"]); ?></td>
                <td width="100"> <?php echo intval($row["scan_qty"]); ?></td>
                <td width="80"><?php echo html_esc($row["scan_uom"]); ?></td> 
                <td width="300">		
				  <input name="bar_gr[<?php echo html_esc($row["id_gra_qc"]); ?>]" type="text" id="bar_gr" value="<?php if(isset($_POST['bar_gr'])){ echo html_esc($_POST["bar_gr"][($row["id_gra_qc"])]); }else{ echo html_esc($row["gr_doc_no"]); } ?>" class="form-control form-control-sm" onkeypress="return /[a-zA-Z0-9- ()]/i.test(event.key)" required autofocus/>
		        </td> 
                <td width="300"><?php echo html_esc($data_sc_asal["remark_gra"]); ?>
                <input name="plant_code2" type="hidden" value="<?php echo html_esc($row["plant_code"]); ?>">
                
                </td>
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
               <input name="submit4" type="submit" id="submit4" value="SUBMIT" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to return?');" >
               <input name="submit5" type="submit" id="submit5" class="btn btn-warning btn-sm" value="CLEAR">
          <!-- </div>-->
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
    </main>
      
             
             
             
     <!--
            </div>
          </div>
      
         </div>
         </div>
      
          </div>
        </div>
     
    </main>-->
    
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
     <!-- Data table plugin-->
    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
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