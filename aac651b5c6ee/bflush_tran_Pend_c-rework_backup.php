<?php
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

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "2")) {
header('Location: ../index.php');
exit();
}
//-----date----
$today = getdate();
$hours = $today['hours']; 
$minutes = $today['minutes'];
$seconds = $today['seconds'];
$month = $today['mon']; 
$mday = $today['mday']; 
$year = $today['year']; 


//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
    $url = "backflush_tran_Pend-confirm_rework.php"; 
	
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

//CR status (QC OK)
$sta11 = "SELECT * from request_status WHERE status_id = '11'";
$sta_res11 = mysqli_query($dbc,$sta11);
$rst_sta11 = mysqli_fetch_array($sta_res11);

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
      <!----sort table https://stackoverflow.com/questions/10683712/html-table-sort/51648529---->
   <!-- <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>-->
    <!--  <script src="https://www.w3schools.com/lib/w3.js"></script>-->
	
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
    .box{
        color: #fff;
        padding: 5px;
        display: none;
        margin-top: 5px;
			
    }
    .OK{ background: #ffffff; 
	}
    .REWORK{ background: #ffffff;
      }
    .NG{ background: #ffffff;
      }
     label{ margin-right: 5px; 
	}
	
</style>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
	    var targetBox = $("." + inputValue);	  
	    $(".box").not(targetBox).hide();
				
        $(targetBox).show();
    });
});
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
          <h1><i class="fa fa-bar-chart"></i> Production</h1>
          <p>Rework</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Production </li>
          <li class="breadcrumb-item"><a href="backflush_tran_Pend-confirm_rework.php">Rework</a></li>
        </ul>
      </div> 
            
              
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
      <?php
	    $message_proc = "";
		$message_def = "";
		$message_tpe = "";
		$message_mqok = "";
		$message_mqng = "";
	   
	   $uid2 = $_GET["uid2"];
	
	  // echo $uid2;
	
	   $query_scan = "SELECT * FROM pps_detail_trn_fg_pending_confirm WHERE id = '".sql_esc($uid2)."'";
	   $result_scan = mysqli_query($dbc,$query_scan);
	   $data_scan = mysqli_fetch_array($result_scan);
	   
	   $date_arini = date('Y-m-d'); 
	   $current_date = date('Y-m-d H:i:s'); 
	   $next_date = date('Y-m-d H:i:s', strtotime($current_date .' +2 day'));
	   
	     //--------------checking qty [pps_detail_trn_fg_pending_confirm_rework] ---------------	
	   
	   $chk_qty_actual = 0.000;
	   $chk_qty_ok = 0.000;  
	   $chk_qty_ng = 0.000;
	   $chk_total_bal = $data_scan["qty_REWORK"];
	   
	   $query_chk_qt = "SELECT * FROM pps_detail_trn_fg_pending_confirm_rework WHERE confirm_id = '".sql_esc($uid2)."' AND status_pps != '".sql_esc($rst_sta4["status_desc"])."' ";
	   $result_chk_qt = mysqli_query($dbc,$query_chk_qt);
	   
	   $chk_qty_actual = $chk_total_bal; 
	  
	   while($data_chk_qt = mysqli_fetch_array($result_chk_qt))
	   {
		
		  
		   
		$chk_qty_ok = $chk_qty_ok + $data_chk_qt["qty_RW_OK"];
		$chk_qty_ng = $chk_qty_ng + $data_chk_qt["qty_RW_NG"];
	
		$chk_total_bal = ($chk_qty_actual - ($chk_qty_ok + $chk_qty_ng));
		
		 
	   }//end while loop $data_chk_qt
	   
	 /*  echo "AVAILABLE QTY :".$chk_total_bal; echo "<br>";
	
	   echo "ACTUAL : ".$chk_qty_actual; echo "<br>";
	   echo "OK : ".$chk_qty_ok; echo "<br>";
	   echo "NG : ".$chk_qty_ng; echo "<br>";
*/
	   
	   	if(($chk_total_bal <= 0.000))
		
		{
				echo "<script>";
                echo "alert('Insufficient amount!.');";
                echo "window.location='backflush_tran_Pend-confirm_rework.php'";
                echo "</script>";
				exit(); //quit the script
			
		}
 
	   
   //--------------------------------------------------------------------------
   if((isset($_POST["rwk_bfpend"])) && $_POST!=="")  
   { // handle the form.

// create a function for escaping the data.
function escape_data($data) {
global $dbc;   // need the connection.
if(ini_get('magic_quotes_gpc')) {
    $data = stripslashes($data);
	}
	return mysqli_real_escape_string($data,$dbc);
	}   // end function.
$message = NULL; // create an empty new variable.

      // $qty_actual = $_POST["qty_actual"];
       $date1 = $_POST["date1"];
       $time1 = $_POST["time1"]; 
       $time2 = $_POST["time2"];
	  // $shift_posting = $_POST["shift_posting"];
	   $status_butn = $_POST["colorRadio"];
	   $ok_qty = $_POST["ok_qty"];
	   //$rework_qty = $_POST["rework_qty"];
	   $ng_qty = $_POST["ng_qty"];
	   $proc_reject = $_POST["proc_reject"];
	   $type_reject = $_POST["type_reject"];
	   $type_defect = $_POST["type_defect"];
	   $reason_reject = $_POST["reason_reject"];
	   
	   
	  $date_arini = date('Y-m-d'); 
      $current_date = date('Y-m-d H:i:s'); 
	  $next_date = date('Y-m-d H:i:s', strtotime($current_date .' +2 day'));
	  $next_date2 = date('Y-m-d', strtotime($date_arini .' +1 day'));
	  
     //check only deilvery date
	 
	             $ddF = substr($_POST["date1"],0,2);
				 $mmF = substr($_POST["date1"],3,2);
				 $yyF = substr($_POST["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
					  
				 $date_date = (($_POST["date1"])." ".($_POST["time1"]).":".($_POST["time2"]).":00");
				  
			
			   if(($_POST["date1"]) == "NULL")
				{
				  $date1 = FALSE;
				  $message.= '<p align="center">You are required to select Date!</p>';
				  }else{
				  $date1 = TRUE;
				  }			  
				      
					
				if(($_POST["time1"]) == "NULL")
				{
				  $time1 = FALSE;
				  $message.= '<p align="center">You are required to select Hours!</p>';
				  }else{
				  $time1 = TRUE;
				  }
				  				  
				  if(($_POST["time2"]) == "NULL")
				{
				  $time2 = FALSE;
				  $message.= '<p align="center">You are required to select Minutes!</p>';
				  } else{
				  $time2 = TRUE;
				  }
				 
				  
				 if($_POST["colorRadio"] == "")
				 {
				  $status_butn = FALSE;
				  $message.= '<p align="center">You are required to enter OK/Rework/NG Quantity!</p>';
				  }else{
				  $status_butn = TRUE;
				 
				 
						   if($_POST["colorRadio"] == "OK")
						 {
										 
						 if(empty($_POST['ok_qty']))
						 { 
						  $ok_qty = FALSE;
						  $message_mqok = '<span class="badge badge-pill badge-danger">Please enter OK Qty!</span>';
						  }
						 else
						  { 
						  $ok_qty = mysqli_real_escape_string($dbc,$_POST['ok_qty']);
						  $status_butn = mysqli_real_escape_string($dbc,$_POST["colorRadio"]);
						  }	
							 
						 }
						 elseif($_POST["colorRadio"] == "NG")
						 {
							  
						if(empty($_POST['ng_qty']))
						 { 
						  $ng_qty = FALSE;
						  $message_mqng = '<span class="badge badge-pill badge-danger">Please enter NG Qty!</span>';
						  }
						 else
						  { 
						   $ng_qty = mysqli_real_escape_string($dbc,$_POST['ng_qty']);
						  // $proc_reject = mysqli_real_escape_string($dbc,$_POST["proc_reject"]);
						  // $type_reject = mysqli_real_escape_string($dbc,$_POST["type_reject"]);
						 //  $type_defect = mysqli_real_escape_string($dbc,$_POST["type_defect"]);
	   					   $reason_reject = mysqli_real_escape_string($dbc,$_POST["reason_reject"]);
						   $status_butn = mysqli_real_escape_string($dbc,$_POST["colorRadio"]);
						  }	
							 
						    
						    if(($_POST["proc_reject"]) == "NULL")
							 {
								 $proc_reject = FALSE;
								 $message_proc = '<span class="badge badge-pill badge-danger">Please select Process of Reject!</span>';
							 }else{
								 
								 $proc_reject = TRUE;
								 
							  }
					  
						  
						    if(($_POST["type_reject"]) == "NULL")
							 {
								 $type_reject = FALSE;
								 $message_tpe = '<span class="badge badge-pill badge-danger">Please select Type of Reject!</span>';
							 }else{
								 
								 $type_reject = TRUE;
							
								 
							  }
							  
							  
							  if(($_POST["type_defect"]) == "NULL")
							 {
								 $type_defect = FALSE;
								 $message_def = '<span class="badge badge-pill badge-danger">Please select Defectives!</span>';
							 }else{
								 
								 $type_defect = TRUE;	 
								 
							  }
						  	
							 
						 }/*else{
							 
							 
							  $ok_qty = FALSE;
							  $ng_qty = FALSE;

						 }*/
				  
				  }
				  
		  //---------------------------------------		
	  if($time1 && $time2 && $date1 && $status_butn && ($ok_qty || ($ng_qty && $proc_reject && $type_defect && $type_reject)))
	   {
		   
	   $date1 = $_POST["date1"];
       $time1 = $_POST["time1"]; 
       $time2 = $_POST["time2"];
	  // $shift_posting = $_POST["shift_posting"];
	   $status_butn = $_POST["colorRadio"];
	   $ok_qty = $_POST["ok_qty"];
	   //$rework_qty = $_POST["rework_qty"];
	   $ng_qty = $_POST["ng_qty"];
	   $proc_reject = $_POST["proc_reject"];
	   $type_reject = $_POST["type_reject"];
	   $type_defect = $_POST["type_defect"];
	   $reason_reject = $_POST["reason_reject"];
		   
		   
		
    $t_time = (($_POST["time1"]).":".($_POST["time2"]));  
	
	   $ref = "";
	  /* $status_butn = $_POST["colorRadio"];*/
	 
  
  //------generate Backflush OK No.---------------------------------
	if($data_scan["plant_code"] == '2300')
	{
		
		
		         if($_POST["colorRadio"] == "OK")
				 {
				
				$query_id = "SELECT count_max FROM run_count_itsb WHERE uid = '51'";
				$result_id = mysqli_query($dbc,$query_id);	
				
				if ($result_id) 
					{
						$nrows = mysqli_num_rows($result_id);
						$row_id = mysqli_fetch_row($result_id);
						
						$dht = 00000; 
						$dht_OK = "641";
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
						$number = sprintf('%05d', $number);  
						
						//  $ref = ($dht_OK.($number));
						
						  $ref = ($data_scan["plant_code"].$dht_OK.$date_run.($number));
						
						} // end if $result_id
					  
						
						//echo $ref;
				 
				 } // OK
				  
				
				 
				 if($_POST["colorRadio"] == "NG")
				 {
					 
				$query_id = "SELECT count_max FROM run_count_itsb WHERE uid = '53'";
				$result_id = mysqli_query($dbc,$query_id);	
				
					if ($result_id) 
					{
						$nrows = mysqli_num_rows($result_id);
						$row_id = mysqli_fetch_row($result_id);
						
						$dht = 00000; 
						$dht_OK = "651";
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
						$number = sprintf('%05d', $number);  
						
						//  $ref = ($dht_OK.($number));
						
						  $ref = ($data_scan["plant_code"].$dht_OK.$date_run.($number));
						
						} // end if $result_id
					  
						
						//echo $ref;
					 
				 }// NG
		
	
	}elseif($data_scan["plant_code"] == '2301')
	{
		
		      if($_POST["colorRadio"] == "OK")
				 {
					$query_id = "SELECT count_max FROM run_count_itsb WHERE uid = '98'";
					$result_id = mysqli_query($dbc,$query_id);	
					
					if ($result_id) 
				    {
					$nrows = mysqli_num_rows($result_id);
					$row_id = mysqli_fetch_row($result_id);
					
					$dht = 00000; 
					$dht_OK = "641";
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
					$number = sprintf('%05d', $number);  
					
					//  $ref = ($dht_OK.($number));
					
					  $ref = ($data_scan["plant_code"].$dht_OK.$date_run.($number));
					
					} // end if $result_id
				  
					
					//echo $ref;
	
				 }// OK
				 
				 
				  if($_POST["colorRadio"] == "NG")
				 {
					$query_id = "SELECT count_max FROM run_count_itsb WHERE uid = '100'";
					$result_id = mysqli_query($dbc,$query_id);	
					
					if ($result_id) 
				    {
					$nrows = mysqli_num_rows($result_id);
					$row_id = mysqli_fetch_row($result_id);
					
					$dht = 00000; 
					$dht_OK = "651";
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
					$number = sprintf('%05d', $number);  
					
					//  $ref = ($dht_OK.($number));
					
					  $ref = ($data_scan["plant_code"].$dht_OK.$date_run.($number));
					
					} // end if $result_id
				  
					
					//echo $ref;
	
				 }// NG
	
		
	}
	
	 //--------checking qty ---------
	  // $query_calculate = "SELECT * FROM pps_detail_trn_fg_pending_confirm WHERE bflush_no = '".$data_scan[""]."'";
	  
	  //$data_scan["qty_actual"];  - ["ok_qty"];
	   
	  //----------find posting log depend material type
	  
	  $query_mat_info = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ?", [$data_scan["material_no"]]);
      $result_mat_info = db_query($dbc, $query_mat_info) or die (mysqli_error());
      $data_mat_info = mysqli_fetch_array($result_mat_info);  
	
	
	 //--------- pps detail ------------
	 
	   $query_pps = "SELECT * FROM pps_detail WHERE plan_no = '".sql_esc($data_scan["plan_no"])."'";
	   $result_pps = mysqli_query($dbc,$query_pps);
	   $data_pps = mysqli_fetch_array($result_pps);
	   
	  //----------find posting log depend material type
	  
	  if($data_scan["material_type"] == "FERT")
	  {
		$ploc = "2360";  
		  
	  }elseif($data_scan["material_type"] == "HALB")
	  {
		$ploc = "2350";
	  }else{
		
		$ploc = "";
	  }
	  
	  //-----UOM detail----
	   $query_unit = new PreparedSql("SELECT * FROM mat_master_header WHERE material_no = ?", [$data_scan["material_no"]]);
	   $result_unit = db_query($dbc, $query_unit);
	   $data_unit = mysqli_fetch_array($result_unit);
	 
	  //----------- find cost center --------------
		$query_cs_cent = new PreparedSql("SELECT * FROM work_center_detail WHERE id_work = ?", [$data_scan["work_center"]]);
		$result_cs_cent = db_query($dbc, $query_cs_cent); 
		$row_cs_cent = mysqli_fetch_array($result_cs_cent);
	  
	  
	 //insert into table pps_detail_transaction-------------
	 
	  if($_POST["colorRadio"] == "NG")
	{

//insert pps_detail_trn_fg_disposal_ng
//production BF NG ---> masuk dlm disposal
 
 $ploc2 = "2360";
	  
	  $query_ins_dis = "INSERT INTO disposal_detail_prd_pending_confirm_rework(id_disposal,doc_dis,doc_disposal_no,bflush_rework,bflush_pending,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit,comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,SAP_ref_doc,SAP_ref_doc_can) VALUES('','','','".sql_esc($ref)."','".sql_esc($data_scan["bflush_pending"])."','".sql_esc($data_scan["bflush_no"])."','".sql_esc($data_scan["plan_no"])."','".sql_esc($uid2)."','".sql_esc($data_pps["material_no"])."','".sql_esc($data_scan["material_desc"])."','".sql_esc($data_scan["material_type"])."','".sql_esc($data_pps["model_code"])."','".sql_esc($data_scan["qty_plan"])."','".sql_esc($data_scan["qty_actual"])."','".sql_esc($data_scan["qty_balance"])."','".sql_esc($data_scan["qty_NG"])."','".sql_esc($data_scan["qty_REWORK"])."','','".sql_esc($ng_qty)."','".sql_esc($data_mat_info["BUn"])."','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_scan["work_center"])."','".sql_esc($data_scan["shift_posting"])."','".sql_esc($data_scan["date_plan"])."','".sql_esc($username)."','".sql_esc($date1_final)."','".sql_esc($t_time)."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($ploc)."','".sql_esc($ploc2)."','".sql_esc($ploc2)."','".sql_esc($proc_reject)."','".sql_esc($type_reject)."','".sql_esc($type_defect)."','".sql_esc($reason_reject)."','".sql_esc($username)."',NOW(),NOW(),'','','','','','','".sql_esc($username)."','".sql_esc($date1_final)."','','PR','".sql_esc($username)."',NOW(),'','','','','','','','','','','','','','','','','','','','','".sql_esc($row_cs_cent["cost_center"])."','".sql_esc($row_cs_cent["id_factory"])."','','','','','".sql_esc($data_scan["plant_code"])."','','".sql_esc($data_mat_info["category_mat"])."','','')";
$result_ins_dis = mysqli_query($dbc,$query_ins_dis); 
	  

	
$query_data2 = "INSERT INTO pps_detail_trn_fg_pending_confirm_rework (id,confirm_id,pps_id,ref_id,bflush_rework,bflush_pending,bflush_no,plan_no,id_scan,upload_id,model_code,month_plan,material_no,material_desc,material_type,qty_plan,qty_actual,qty_balance,qty_OK,qty_NG,qty_REWORK,qty_RW_OK,qty_RW_NG,status_rework,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,status,user_upload,date_upload,user_create,date_create,user_update,date_update,user_posting,date_posting,time_posting,user_rw_posting,date_rw_posting,time_rw_posting,ploc,delivery_loc,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,status_ftp_bflush,status_ftp_rwk,bflush_no_ref,user_cancel,date_cancel,remark_cancel,plant_code,shift_posting,shift_rwk,status_butn,stamp_ind,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($uid2)."','".sql_esc($data_scan["pps_id"])."','".sql_esc($data_scan["ref_id"])."','".sql_esc($ref)."','".sql_esc($data_scan["bflush_pending"])."','".sql_esc($data_scan["bflush_no"])."','".sql_esc($data_scan["plan_no"])."','".sql_esc($data_scan["id_scan"])."','".sql_esc($data_scan["upload_id"])."','".sql_esc($data_scan["model_code"])."','".sql_esc($data_scan["month_plan"])."','".sql_esc($data_scan["material_no"])."','".sql_esc($data_scan["material_desc"])."','".sql_esc($data_scan["material_type"])."','".sql_esc($data_scan["qty_plan"])."','".sql_esc($data_scan["qty_actual"])."','".sql_esc($data_scan["qty_balance"])."','".sql_esc($data_scan["qty_OK"])."','".sql_esc($data_scan["qty_NG"])."','".sql_esc($data_scan["qty_REWORK"])."','','".sql_esc($ng_qty)."','".sql_esc($rst_sta8["status_desc"])."','".sql_esc($rst_sta7["status_desc"])."','".sql_esc($data_scan["plant_code"])."','".sql_esc($data_scan["work_center"])."','".sql_esc($data_scan["shift_pps1"])."','".sql_esc($data_scan["shift_pps2"])."','".sql_esc($data_scan["date_plan"])."','Y','".sql_esc($data_scan["user_upload"])."','".sql_esc($data_scan["date_upload"])."','".sql_esc($data_scan["user_create"])."','".sql_esc($data_scan["date_create"])."','".sql_esc($data_scan["user_update"])."','".sql_esc($data_scan["date_update"])."','".sql_esc($username)."','".sql_esc($date1_final)."','".sql_esc($t_time)."','".sql_esc($username)."','".sql_esc($date1_final)."','".sql_esc($t_time)."','".sql_esc($ploc)."','".sql_esc($ploc2)."','".sql_esc($proc_reject)."','".sql_esc($type_reject)."','".sql_esc($type_defect)."','".sql_esc($reason_reject)."','".sql_esc($username)."',NOW(),NOW(),'".sql_esc($data_scan["status_ftp_bflush"])."','Y','','','','','".sql_esc($data_scan["plant_code"])."','".sql_esc($data_scan["shift_posting"])."','','".sql_esc($status_butn)."','".sql_esc($data_mat_info["category_mat"])."','','')";
$result_data2 = mysqli_query($dbc,$query_data2);



 //-------------------update---------------------
  
      $query_all_info = "SELECT * FROM pps_detail_trn_fg_pending_confirm_rework WHERE id = '".mysqli_insert_id($dbc)."'";
	  $result_all_info = mysqli_query($dbc,$query_all_info); 
	  $data_all_info = mysqli_fetch_array($result_all_info);	
	  
	  
	  
	 //---shift detail ------
	
	  $query_sht = "SELECT * FROM shift_detail WHERE id_shift = '1'";
	  $result_sht = mysqli_query($dbc,$query_sht);
	  $data_sht = mysqli_fetch_array($result_sht); 
	  
	 //----shift posting ----
	 
	 if(($data_all_info["time_posting"] >= $data_sht["time_start"]) && ($data_all_info["time_posting"] <= $data_sht["time_end"]))
	 {
		 
     $shif_p = "D/S"; 
	 
	 }else
	 {
	 
	 $shif_p = "N/S"; 
	
	 }
	
	
	  
  //---------update shift posting ---------------
	$query_upd_detail2 = "UPDATE pps_detail_trn_fg_pending_confirm_rework SET shift_posting = '".sql_esc($shif_p)."', shift_rwk = '".sql_esc($shif_p)."' WHERE id = '".sql_esc($data_all_info["id"])."'";
	$result_upd_detail2 = mysqli_query($dbc,$query_upd_detail2);  

	//---------update shift posting ---------------
	$query_upd_detail3 = "UPDATE disposal_detail_prd_pending_confirm_rework SET shift_posting = '".sql_esc($shif_p)."' WHERE bflush_qqc_no = '".sql_esc($data_all_info["bflush_no"])."' AND bflush_pending = '".sql_esc($data_all_info["bflush_pending"])."' AND bflush_rework = '".sql_esc($data_all_info["bflush_rework"])."'";
	$result_upd_detail3 = mysqli_query($dbc,$query_upd_detail3);  

	  
	  
	  
	      //-------------update status for completed rework qty ------- //
	  
	  
	  
	  
	      //-------insert table print_tag_backflush [generate print tag] ---------------	
	
	$query_tag = "SELECT * FROM pps_detail_trn_fg_pending_confirm_rework WHERE id = '".sql_esc($data_all_info["id"])."' AND bflush_rework = '".sql_esc($ref)."'";
    $result_tag = mysqli_query($dbc,$query_tag);
  
	while($row = mysqli_fetch_array($result_tag))
	{
		
	if($row["status_butn"] == "OK")
	 {	
	
	 $dl_qty = (intval($row["qty_RW_OK"]));
		
	 }
	   	
	  if($row["status_butn"] == "NG")
	 {	 
	
	 $dl_qty = (intval($row["qty_RW_NG"]));
		
	 }
	 
	
	 
	
	
	
	  
	  //----detail standard packaging [ambil dari table mat_master_header]
	  
	   $query_pack = "SELECT std_package, type_package, BUn FROM mat_master_header WHERE material_no = '".sql_esc($row["material_no"])."'";
	   $result_pack = mysqli_query($dbc,$query_pack);
	   $data_pack = mysqli_fetch_array($result_pack);
		
		
		        if(($data_pack["std_package"] == "") || ($data_pack["std_package"] == "0"))
		        {
		
		       // $st_pack = $row["qty_actual"];
				
						
						if($row["status_butn"] == "OK")
						 {	
						
						 $st_pack = (intval($row["qty_RW_OK"]));
							
						 }
						 
										
						  if($row["status_butn"] == "NG")
						 {	 
						
						 $st_pack = (intval($row["qty_RW_NG"]));
							
						 }
				
				
	            }else{
		
                $st_pack = $data_pack["std_package"];
		        }
		 
      $bil_tag = ($dl_qty / $st_pack);
		
     $b =  intval($bil_tag);  // genapkan value yg dibahagikan utk didarabkan 
	// $b = round($bil_tag, 0, PHP_ROUND_HALF_DOWN);  // genapkan value yg dibahagikan utk didarabkan 
	 $last_tag = ($bil_tag - $b);	   // sekiranya masih ada baki utk keluarkn delivery tag yg last
	 
	 
	 $bil_tag2 = ($st_pack * $b);
	 
	 if($dl_qty < ($st_pack))
	 {
	 $bil_tag3 = ($dl_qty);
	 
	 }else{
	 $bil_tag3 =  ($dl_qty - $bil_tag2);  //quantity delivery tag yg last
	
      }
	// echo "last qty ".$last_tag;
	 
	/* $query_id2 = "SELECT MAX(tag_no) FROM delivery_tagasn";
     $result_id2 = mysql_query($query_id2);
	 $row_id2 = mysql_fetch_row($result_id2);
	 
	 $tag_no = ($row_id[1] + 1);
	 echo $tag_no;   */
	 
	// echo "B  : ".$b;
	 
	 if($b <= 1)
	 {
	  $no_tg = 1;
	  }elseif($last_tag == 0)
	  {
	   $no_tg = $b;
	  }else{
	  
	  $no_tg = ($b + 1);
	  
	  }
	  
	$w = 1;
		   
     for($m=1; $m <= $bil_tag; $m++)
	 { 
	
	//-----print tag ok/rework/ng----------------

$query_tag3 = "INSERT INTO print_tag_bf_pending_confirm_rework(id_tag,tag_no,id_tran,bflush_rework,bflush_pending,bflush_no,plan_no,rev_plan_no,material_no, material_desc,tag_qty,shift_tag,tag_uom,ploc,station_loc,model_code,pack_type,pack_no,posting_by,posting_date,posting_time,user_create,date_create,status_tag,status_print,month_plan,year_plan,slip_no,total_slip,plant_cd,status_bf,status_butn,stamp_ind,material_type)  VALUES('','','".sql_esc($row["id"])."','".sql_esc($ref)."','".sql_esc($row["bflush_pending"])."','".sql_esc($row["bflush_no"])."','".sql_esc($row["plan_no"])."','','".sql_esc($row["material_no"])."','".sql_esc($row["material_desc"])."','".sql_esc($st_pack)."','".sql_esc($row["shift_rwk"])."','".sql_esc($data_pack["BUn"])."','".sql_esc($row["ploc"])."','".sql_esc($row["work_center"])."','".sql_esc($row["model_code"])."','".sql_esc($data_pack["type_package"])."','".sql_esc($data_pack["std_package"])."','".sql_esc($row["user_rw_posting"])."','".sql_esc($row["date_rw_posting"])."','".sql_esc($row["time_rw_posting"])."','".sql_esc($username)."',NOW(),'N','N','".sql_esc($row["month_plan"])."',NOW(),'".sql_esc($w)."','".sql_esc($no_tg)."','".sql_esc($row["plant_code"])."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($row["status_butn"])."','".sql_esc($row["stamp_ind"])."','".sql_esc($row["material_type"])."')";
	   $result_tag3 = mysqli_query($dbc,$query_tag3);
	   
	     $tag_no = ($ref.'/'.$w.'/'.$data_pack["std_package"].'/'.$no_tg);
		
		 
		 $query_tag3_t = "UPDATE print_tag_bf_pending_confirm_rework SET tag_no = '".sql_esc($tag_no)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND bflush_rework = '".sql_esc($ref)."'";
	     $result_tag3_t = mysqli_query($dbc,$query_tag3_t); 
	   
     $w++; 
	 
	 } // end for loop
	 
	  if(($last_tag > 0.000) || ($dl_qty < ($st_pack))){	   // kalau qty lebih kecil drpd std packaging and baki drpd bahagi tag
	 
	 $query_tag2 = "INSERT INTO print_tag_bf_pending_confirm_rework(id_tag,tag_no,id_tran,bflush_rework,bflush_pending,bflush_no,plan_no,rev_plan_no,material_no, material_desc,tag_qty, shift_tag,tag_uom,ploc,station_loc,model_code,pack_type,pack_no,posting_by,posting_date,posting_time,user_create,date_create,status_tag,status_print,month_plan,year_plan,slip_no,total_slip,plant_cd,status_bf,status_butn,stamp_ind,material_type)  VALUES('','','".sql_esc($row["id"])."','".sql_esc($ref)."','".sql_esc($row["bflush_pending"])."','".sql_esc($row["bflush_no"])."','".sql_esc($row["plan_no"])."','','".sql_esc($row["material_no"])."','".sql_esc($row["material_desc"])."','".sql_esc($bil_tag3)."','".sql_esc($row["shift_rwk"])."','".sql_esc($data_pack["BUn"])."','".sql_esc($row["ploc"])."','".sql_esc($row["work_center"])."','".sql_esc($row["model_code"])."','".sql_esc($data_pack["type_package"])."','".sql_esc($data_pack["std_package"])."','".sql_esc($row["user_rw_posting"])."','".sql_esc($row["date_rw_posting"])."','".sql_esc($row["time_rw_posting"])."','".sql_esc($username)."',NOW(),'N','N','".sql_esc($row["month_plan"])."',NOW(),'".sql_esc($w)."','".sql_esc($no_tg)."','".sql_esc($row["plant_code"])."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($row["status_butn"])."','".sql_esc($row["stamp_ind"])."','".sql_esc($row["material_type"])."')"; 
	   $result_tag2 = mysqli_query($dbc,$query_tag2);
	   

       
	     $tag_no = ($ref.'/'.$w.'/'.$bil_tag3.'/'.($b + 1));
		 
		 $query_tag2_t = "UPDATE print_tag_bf_pending_confirm_rework SET tag_no = '".sql_esc($tag_no)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND bflush_rework = '".sql_esc($ref)."'";
	     $result_tag2_t = mysqli_query($dbc,$query_tag2_t);   
	   
	   
	   
	   
		 }// end if
	
	 
	  }// end while loop	
	  mysqli_free_result($result_tag);


	}elseif($_POST["colorRadio"] == "OK")
	{
		
	$query_data2 = "INSERT INTO pps_detail_trn_fg_pending_confirm_rework (id,confirm_id,pps_id,ref_id,bflush_rework,bflush_pending,bflush_no,plan_no,id_scan,upload_id,model_code,month_plan,material_no,material_desc,material_type,qty_plan,qty_actual,qty_balance,qty_OK,qty_NG,qty_REWORK,qty_RW_OK,qty_RW_NG,status_rework,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,status,user_upload,date_upload,user_create,date_create,user_update,date_update,user_posting,date_posting,time_posting,user_rw_posting,date_rw_posting,time_rw_posting,ploc,delivery_loc,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,status_ftp_bflush,status_ftp_rwk,bflush_no_ref,user_cancel,date_cancel,remark_cancel,plant_code,shift_posting,shift_rwk,status_butn,stamp_ind,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($uid2)."','".sql_esc($data_scan["pps_id"])."','".sql_esc($data_scan["ref_id"])."','".sql_esc($ref)."','".sql_esc($data_scan["bflush_pending"])."','".sql_esc($data_scan["bflush_no"])."','".sql_esc($data_scan["plan_no"])."','".sql_esc($data_scan["id_scan"])."','".sql_esc($data_scan["upload_id"])."','".sql_esc($data_scan["model_code"])."','".sql_esc($data_scan["month_plan"])."','".sql_esc($data_scan["material_no"])."','".sql_esc($data_scan["material_desc"])."','".sql_esc($data_scan["material_type"])."','".sql_esc($data_scan["qty_plan"])."','".sql_esc($data_scan["qty_actual"])."','".sql_esc($data_scan["qty_balance"])."','".sql_esc($data_scan["qty_OK"])."','".sql_esc($data_scan["qty_NG"])."','".sql_esc($data_scan["qty_REWORK"])."','".sql_esc($ok_qty)."','','".sql_esc($rst_sta8["status_desc"])."','".sql_esc($rst_sta7["status_desc"])."','".sql_esc($data_scan["comp_code"])."','".sql_esc($data_scan["work_center"])."','".sql_esc($data_scan["shift_pps1"])."','".sql_esc($data_scan["shift_pps2"])."','".sql_esc($data_scan["date_plan"])."','Y','".sql_esc($data_scan["user_upload"])."','".sql_esc($data_scan["date_upload"])."','".sql_esc($data_scan["user_create"])."','".sql_esc($data_scan["date_create"])."','".sql_esc($data_scan["user_update"])."','".sql_esc($data_scan["date_update"])."','".sql_esc($data_scan["user_posting"])."','".sql_esc($data_scan["date_posting"])."','".sql_esc($data_scan["time_posting"])."','".sql_esc($username)."','".sql_esc($date1_final)."','".sql_esc($t_time)."','".sql_esc($ploc)."','','".sql_esc($proc_reject)."','".sql_esc($type_reject)."','".sql_esc($type_defect)."','".sql_esc($reason_reject)."','".sql_esc($username)."',NOW(),NOW(),'".sql_esc($data_scan["status_ftp_bflush"])."','Y','".sql_esc($data_scan["bflush_no_ref"])."','','','','".sql_esc($data_scan["plant_code"])."','".sql_esc($data_scan["shift_posting"])."','','".sql_esc($status_butn)."','".sql_esc($data_scan["material_type"])."','','')";	
$result_data2 = mysqli_query($dbc,$query_data2);	
		
			
	 //-------------------update---------------------
  
      $query_all_info = "SELECT * FROM pps_detail_trn_fg_pending_confirm_rework WHERE id = '".mysqli_insert_id($dbc)."'";
	  $result_all_info = mysqli_query($dbc,$query_all_info); 
	  $data_all_info = mysqli_fetch_array($result_all_info);
	  
	  
	    //---shift detail ------
	
	  $query_sht = "SELECT * FROM shift_detail WHERE id_shift = '1'";
	  $result_sht = mysqli_query($dbc,$query_sht);
	  $data_sht = mysqli_fetch_array($result_sht); 
	  
	 //----shift posting ----
	 
	 if(($data_all_info["time_posting"] >= $data_sht["time_start"]) && ($data_all_info["time_posting"] <= $data_sht["time_end"]))
	 {
		 
     $shif_p = "D/S"; 
	 
	 }else
	 {
	 
	 $shif_p = "N/S"; 
	
	 }
	
	  
  //---------update shift posting ---------------
	$query_upd_detail2 = "UPDATE pps_detail_trn_fg_pending_confirm_rework SET shift_posting = '".sql_esc($shif_p)."', shift_rwk = '".sql_esc($shif_p)."' WHERE id = '".sql_esc($data_all_info["id"])."'";
	$result_upd_detail2 = mysqli_query($dbc,$query_upd_detail2);  
	
	  
	  //-------insert table print_tag_backflush [generate print tag] ---------------	
	
	$query_tag = "SELECT * FROM pps_detail_trn_fg_pending_confirm_rework WHERE id = '".sql_esc($data_all_info["id"])."' AND bflush_rework = '".sql_esc($ref)."'";
    $result_tag = mysqli_query($dbc,$query_tag);
  
	while($row = mysqli_fetch_array($result_tag))
	{
		
	if($row["status_butn"] == "OK")
	 {	
	
	 $dl_qty = (intval($row["qty_RW_OK"]));
		
	 }
	   	
	  if($row["status_butn"] == "NG")
	 {	 
	
	 $dl_qty = (intval($row["qty_RW_NG"]));
		
	 }
	 
	
	  
	  //----detail standard packaging [ambil dari table mat_master_header]
	  
	   $query_pack = "SELECT std_package, type_package, BUn FROM mat_master_header WHERE material_no = '".sql_esc($row["material_no"])."'";
	   $result_pack = mysqli_query($dbc,$query_pack);
	   $data_pack = mysqli_fetch_array($result_pack);
		
		
		        if(($data_pack["std_package"] == "") || ($data_pack["std_package"] == "0"))
		        {
		
		       // $st_pack = $row["qty_actual"];
				
						
						if($row["status_butn"] == "OK")
						 {	
						
						 $st_pack = (intval($row["qty_RW_OK"]));
							
						 }
						 
										
						  if($row["status_butn"] == "NG")
						 {	 
						
						 $st_pack = (intval($row["qty_RW_NG"]));
							
						 }
				
				
	            }else{
		
                $st_pack = $data_pack["std_package"];
		        }
		 
      $bil_tag = ($dl_qty / $st_pack);
		
     $b =  intval($bil_tag);  // genapkan value yg dibahagikan utk didarabkan 
	// $b = round($bil_tag, 0, PHP_ROUND_HALF_DOWN);  // genapkan value yg dibahagikan utk didarabkan 
	 $last_tag = ($bil_tag - $b);	   // sekiranya masih ada baki utk keluarkn delivery tag yg last
	 
	 
	 $bil_tag2 = ($st_pack * $b);
	 
	 if($dl_qty < ($st_pack))
	 {
	 $bil_tag3 = ($dl_qty);
	 
	 }else{
	 $bil_tag3 =  ($dl_qty - $bil_tag2);  //quantity delivery tag yg last
	
      }
	// echo "last qty ".$last_tag;
	 
	/* $query_id2 = "SELECT MAX(tag_no) FROM delivery_tagasn";
     $result_id2 = mysql_query($query_id2);
	 $row_id2 = mysql_fetch_row($result_id2);
	 
	 $tag_no = ($row_id[1] + 1);
	 echo $tag_no;   */
	 
	// echo "B  : ".$b;
	 
	 if($b <= 1)
	 {
	  $no_tg = 1;
	  }elseif($last_tag == 0)
	  {
	   $no_tg = $b;
	  }else{
	  
	  $no_tg = ($b + 1);
	  
	  }
	  
	$w = 1;
		   
     for($m=1; $m <= $bil_tag; $m++)
	 { 
	
	//-----print tag ok/rework/ng----------------

$query_tag3 = "INSERT INTO print_tag_bf_pending_confirm_rework(id_tag,tag_no,id_tran,bflush_rework,bflush_pending,bflush_no,plan_no,rev_plan_no,material_no, material_desc,tag_qty,shift_tag,tag_uom,ploc,station_loc,model_code,pack_type,pack_no,posting_by,posting_date,posting_time,user_create,date_create,status_tag,status_print,month_plan,year_plan,slip_no,total_slip,plant_cd,status_bf,status_butn,stamp_ind,material_type)  VALUES('','','".sql_esc($row["id"])."','".sql_esc($ref)."','".sql_esc($row["bflush_pending"])."','".sql_esc($row["bflush_no"])."','".sql_esc($row["plan_no"])."','','".sql_esc($row["material_no"])."','".sql_esc($row["material_desc"])."','".sql_esc($st_pack)."','".sql_esc($row["shift_rwk"])."','".sql_esc($data_pack["BUn"])."','".sql_esc($row["ploc"])."','".sql_esc($row["work_center"])."','".sql_esc($row["model_code"])."','".sql_esc($data_pack["type_package"])."','".sql_esc($data_pack["std_package"])."','".sql_esc($row["user_rw_posting"])."','".sql_esc($row["date_rw_posting"])."','".sql_esc($row["time_rw_posting"])."','".sql_esc($username)."',NOW(),'N','N','".sql_esc($row["month_plan"])."',NOW(),'".sql_esc($w)."','".sql_esc($no_tg)."','".sql_esc($row["plant_code"])."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($row["status_butn"])."','".sql_esc($row["stamp_ind"])."','".sql_esc($row["material_type"])."')";
	   $result_tag3 = mysqli_query($dbc,$query_tag3);
	   
	     $tag_no = ($ref.'/'.$w.'/'.$data_pack["std_package"].'/'.$no_tg);
		
		 
		 $query_tag3_t = "UPDATE print_tag_bf_pending_confirm_rework SET tag_no = '".sql_esc($tag_no)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND bflush_rework = '".sql_esc($ref)."'";
	     $result_tag3_t = mysqli_query($dbc,$query_tag3_t); 
	   
     $w++; 
	 
	 } // end for loop
	 
	  if(($last_tag > 0.000) || ($dl_qty < ($st_pack))){	   // kalau qty lebih kecil drpd std packaging and baki drpd bahagi tag
	 
	 $query_tag2 = "INSERT INTO print_tag_bf_pending_confirm_rework(id_tag,tag_no,id_tran,bflush_rework,bflush_pending,bflush_no,plan_no,rev_plan_no,material_no, material_desc,tag_qty, shift_tag,tag_uom,ploc,station_loc,model_code,pack_type,pack_no,posting_by,posting_date,posting_time,user_create,date_create,status_tag,status_print,month_plan,year_plan,slip_no,total_slip,plant_cd,status_bf,status_butn,stamp_ind,material_type)  VALUES('','','".sql_esc($row["id"])."','".sql_esc($ref)."','".sql_esc($row["bflush_pending"])."','".sql_esc($row["bflush_no"])."','".sql_esc($row["plan_no"])."','','".sql_esc($row["material_no"])."','".sql_esc($row["material_desc"])."','".sql_esc($bil_tag3)."','".sql_esc($row["shift_rwk"])."','".sql_esc($data_pack["BUn"])."','".sql_esc($row["ploc"])."','".sql_esc($row["work_center"])."','".sql_esc($row["model_code"])."','".sql_esc($data_pack["type_package"])."','".sql_esc($data_pack["std_package"])."','".sql_esc($row["user_rw_posting"])."','".sql_esc($row["date_rw_posting"])."','".sql_esc($row["time_rw_posting"])."','".sql_esc($username)."',NOW(),'N','N','".sql_esc($row["month_plan"])."',NOW(),'".sql_esc($w)."','".sql_esc($no_tg)."','".sql_esc($row["plant_code"])."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($row["status_butn"])."','".sql_esc($row["stamp_ind"])."','".sql_esc($row["material_type"])."')"; 
	   $result_tag2 = mysqli_query($dbc,$query_tag2);
	   

       
	     $tag_no = ($ref.'/'.$w.'/'.$bil_tag3.'/'.($b + 1));
		 
		 $query_tag2_t = "UPDATE print_tag_bf_pending_confirm_rework SET tag_no = '".sql_esc($tag_no)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND bflush_rework = '".sql_esc($ref)."'";
	     $result_tag2_t = mysqli_query($dbc,$query_tag2_t);   
	   
	   
	   
	   
		 }// end if
	
	 
	  }// end while loop	
		mysqli_free_result($result_tag);
	}
 
		//
	  
	
	
 //------- crete text file to SAP [FromPortal] -----------
 
 
	      if($result_data2)
		  {
			  
			  
  //update count_max----------------------------------------
		if($data_scan["plant_code"] == '2300')
	{
	
		  if($_POST["colorRadio"] == "OK")
		{
		   $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '51'";
		   $result_max_a = mysqli_query($dbc,$query_max_a);
		}//OK
		
		  if($_POST["colorRadio"] == "NG")
		{
		   $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '53'";
		   $result_max_a = mysqli_query($dbc,$query_max_a);
		}//NG
	   
	}elseif($data_scan["plant_code"] == '2301')
	{
		 
		  if($_POST["colorRadio"] == "OK")
		{
		 $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '98'";
	     $result_max_a = mysqli_query($dbc,$query_max_a);
		}//OK
		
		 if($_POST["colorRadio"] == "NG")
		{
		 $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '100'";
	     $result_max_a = mysqli_query($dbc,$query_max_a);
		}//NG
	  
		
	 }else{
		 
	 }
	 
	 
	   //--------------checking qty [pps_detail_trn_fg_pending_confirm_rework] ---------------	
	   
	   $chk_qty_actual2 = 0.000;
	   $chk_qty_ok2 = 0.000;  
	   $chk_qty_ng2 = 0.000;
	   $chk_total_bal2 = $data_scan["qty_REWORK"];
	   
	   
	   $query_chk_qt2 = "SELECT * FROM pps_detail_trn_fg_pending_confirm_rework WHERE bflush_no = '".sql_esc($data_scan["bflush_no"])."' AND status_pps != '".sql_esc($rst_sta4["status_desc"])."'";
	   $result_chk_qt2 = mysqli_query($dbc,$query_chk_qt2);
	   
	   while($data_chk_qt2 = mysqli_fetch_array($result_chk_qt2))
	   {
		
		$chk_qty_actual2 = $data_chk_qt2["qty_REWORK"];   
		   
		$chk_qty_ok2 = $chk_qty_ok2 + $data_chk_qt2["qty_RW_OK"];
		$chk_qty_ng2 = $chk_qty_ng2 + $data_chk_qt2["qty_RW_NG"];
	
		$chk_total_bal2 = ($chk_qty_actual2 - ($chk_qty_ok2 + $chk_qty_ng2));
		
		 
	   }//end while loop $data_chk_qt2
	   
	   
	    	if(($chk_total_bal2 == 0))
		
		{
	   
	   //-------update status rework "Pending" to "QC OK" in table pps_detail_trn_fg_pending_confirm_rework	
	
	$query_upd_detail = "UPDATE pps_detail_trn_fg_pending_confirm_rework SET status_rework = '".sql_esc($rst_sta11["status_desc"])."' WHERE confirm_id = '".sql_esc($uid2)."'";
	$result_upd_detail = mysqli_query($dbc,$query_upd_detail);
	
	
	//-------update status rework "In Progress" to "QC OK" in table pps_detail_trn_fg_pending_confirm	
	$query_upd_detail2 = "UPDATE pps_detail_trn_fg_pending_confirm SET status_pps = '".sql_esc($rst_sta11["status_desc"])."' WHERE id = '".sql_esc($uid2)."' AND status_butn = 'REWORK'";
	$result_upd_detail2 = mysqli_query($dbc,$query_upd_detail2);	
	
		}  // end $chk_total_bal2
	 
	 
	 
	 
   //end update count_max ---------------------------------	
			  
			 if($_POST["colorRadio"] == "OK")
		{  
		   $ref11 =	base64_encode($ref);
		   $uid = base64_encode($uid2); 
		
	
	       echo "<script>";
		   echo "alert('Rework Document No : $ref                                      OK Quantity : $ok_qty');";
		   echo "window.location='ftp_bflush_SAP_pend-confirm-rwk.php?buid=$ref11&&uid=$uid'";
	       echo "</script>"; 
		   exit(); //quit the script
		   
		}
		
		   if($_POST["colorRadio"] == "NG")
		{  
	
	//-----detail process reject
	$query_prc = "SELECT * FROM  proc_reject_detail_prd WHERE id_proc = '".sql_esc($proc_reject)."' ORDER BY id_proc ASC";
    $result_prc = mysqli_query($dbc,$query_prc);
    $row_prc = mysqli_fetch_array($result_prc); 
	
	//-----detail type reject
	$query_type = "SELECT * FROM type_reject_detail_prd WHERE id_type = '".sql_esc($type_reject)."' ORDER BY id_type ASC";
    $result_type = mysqli_query($dbc,$query_type);
    $row_type = mysqli_fetch_array($result_type); 
	
	//----detail defect
	$query_defect = "SELECT * FROM type_defect_detail_prd WHERE id_defect = '".sql_esc($type_defect)."' ORDER BY id_defect ASC";
    $result_defect = mysqli_query($dbc,$query_defect);
    $row_defect = mysqli_fetch_array($result_defect);
	

 		   $ref11 =	base64_encode($ref);
		   $uid =	base64_encode($uid2); 
		   
	       echo "<script>";
		   echo "alert('Rework Document No : $ref                                        NG Quantity : $ng_qty     Process : ".html_esc($row_prc['proc_desc'])."         Type : ".html_esc($row_type['type_desc'])."         Defectives : ".html_esc($row_defect['defect_desc'])."        Reason : ".html_esc($row_defect['id_reason'])."     ');";
		   echo "window.location='ftp_bflush_SAP_pend-confirm-rwk.php?buid=$ref11&&uid=$uid'";
	       echo "</script>"; 
		   exit(); //quit the script
		   
		}
		   
		   
		   
	  
		  }
	  	   
	   }
	   
	// mysqli_close($dbc);  
	   
  //print the message if there is one.
if (isset($message))
{ echo '<div class="msg msg-error"><font color="red" class ="error_entry">', $message, '</font></div>';
}
  
} // end if

   //------------------------------------------------------------------------------

		 $no = 1; 
		 
		 //------------plant code detail -------------
		 
		 $query_plant = new PreparedSql("SELECT * FROM plant_detail WHERE plant_code = ?", [$data_scan["plant_code"]]);
		 $result_plant = db_query($dbc, $query_plant);
	     $data_plant = mysqli_fetch_array($result_plant);
		  
		  ?>        
        <form name="myform" method="post" action="bflush_tran_Pend_c-rework.php?uid2=<?php echo html_esc($uid2); ?>">
            <table width="100%" border="0" cellpadding="2">
     <tr>
       <td width="52%" height="234">
         <table width="95%" border="1" align="right" cellpadding="2" class="table-condensed">
            <tr>
             <th scope="row"><div align="left">Plant</div></th>
             <td>:</td>
             <td><?php echo html_esc($data_plant["plant_desc"]); ?></td>
            </tr>
            <tr>
             <th scope="row"><div align="left">Model</div></th>
             <td>:</td>
             <td><?php echo html_esc($data_scan["model_code"]); ?></td>
            </tr>
            <tr>
             <th scope="row"><div align="left">Part Name</div></th>
             <td>:</td>
             <td><?php echo html_esc($data_scan["material_desc"]); ?></td>
             </tr>
             <tr>
             <th scope="row"><div align="left">Part Number</div></th>
             <td>:</td>
             <td><?php echo html_esc($data_scan["material_no"]); ?></td>
             </tr>
             <tr>
             <th width="33%"><div align="left">Pending Doc. No.</div></th>
             <td width="5%"> :</td>
             <td width="62%"><?php echo html_esc($data_scan["bflush_no"]); ?></td>
             </tr>
             <!--<tr>
             <th scope="row"><div align="left">Planned Date</div></th>
             <td>:</td>
             <td><?php echo html_esc($data_scan["scan_date_plan"]); ?></td>
             </tr>-->
              <tr>
             <th scope="row"><div align="left">Quantity</div></th>
             <td>:</td>
             <td><?php echo (intval($data_scan["qty_REWORK"])); ?></td>
             </tr>
             <tr>
             <th scope="row"><div align="left">Balance Quantity Rework</div></th>
             <td>:</td>
             <td><?php echo (intval($chk_total_bal)); ?></td>
             </tr>
           </table></td>
       <td width="48%">
         <table width="95%" border="0" align="center" cellpadding="2">
           <tr>
             <td><span class="style4">&nbsp;<?php echo date("D M d, Y");   ?></span>&nbsp;&nbsp;<span class="style5"><?php echo date("h:i:s");  ?></span></td>
             </tr>
           <tr>
             <td><p>&nbsp;</p>
               <p>&nbsp;</p>
               <p>&nbsp;</p>
               <p>&nbsp;</p>
               <p>&nbsp;</p>
               <p>&nbsp;</p></td>
             </tr>
           
           </table></td>
     </tr>
     </table>
     
               <table width="98%" align="right" >
               <tr>
                 <td><p>Please enter backflush output quantity for Rework</p>
                   <table width="99%" class="table table-bordered">
                     <tr>
                     <td width="14%">Posting Date</td>
                     <td width="2%">:</td>
                     <td colspan="2"> 
                       <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php if(isset($_POST['date1'])){ echo html_esc($_POST['date1']); }else{ echo $fmt_curr_date; } ?>" /> 
                     </td>
                    </tr>
                     <tr>
              <td>Posting Time </td>
                     <td>:</td>
                     <td width="40%">Hours<select name="time1" id="time1" class="form-control form-control-sm timepicker">
                       <?php if($_POST["con_bfpend"] == true)
		{  
		?>
                       <option value="<?php echo html_esc($_POST["time1"]); ?>"><?php echo sprintf('%02d', $_POST["time1"]);	 ?></option>
                       <?php
	 }else{
	 ?>
                       <option value="<?php echo sprintf('%02d', date('H'));	 ?>" placeholder="HOURS"><?php echo sprintf('%02d', date('H'));	 ?></option>
                       <?php
	  }
	  
      for($i2 = 0; $i2 <= 23; $i2++): ?>
                       <option value="<?= $i2; ?>"> <?php echo sprintf('%02d', $i2); ?></option>
                       <?php endfor; ?>
                     </select></td>
                      <td width="40%"> Minutes
                       <select name="time2" id="time2" class="form-control form-control-sm">
                       <?php if($_POST["con_bfpend"] == true)  
		{  
		?>
                       <option value="<?php echo html_esc($_POST["time2"]); ?>"><?php echo sprintf('%02d', $_POST["time2"]);	 ?></option>
                       <?php
	 }else{
	 ?>
                       <option value="<?php echo sprintf('%02d', date('i'));	 ?>" placeholder="MINUTES"><?php echo sprintf('%02d', date('i'));	 ?></option>
                       <?php
	  }
      for($j = 0; $j <= 59; $j++): ?>
                       <option value="<?= $j; ?>"> <?php echo sprintf('%02d', $j); ?></option>
                       <?php endfor; ?>
                     </select></td>
                  
                     </tr>
                     <tr>
                     <td rowspan="3">Enter OK Quantity or NG Quantity?</td>
                     <td rowspan="3">:</td>
                     <td colspan="2">
                     <div class="form-check">
                      <label class="form-check-label">
                     <input class="form-check-input" type="radio" name="colorRadio" value="OK">OK
                      </label>
                    </div>
                    </td>
                     </tr>
                     <tr>
                       <td colspan="2"><div class="form-check">
                      <label class="form-check-label">
                     <input class="form-check-input" type="radio" name="colorRadio" value="NG">NG
                      </label>
                    </div></td>
                     </tr>
                     </table>
                    <div class="OK box"> 
                    <table width="99%" class="table table-bordered">
                     <tr>
                     <td width="20%"><font color="#000000">Enter OK Quantity</font></td>
                     <td width="1%">:</td>
                     <td colspan="2"> <input name="ok_qty" type="number" min="1" value="<?php if(isset($_POST["ok_qty"])) { echo html_esc($_POST["ok_qty"]); } ?>" class="form-control" max="<?php echo $chk_total_bal; ?>" /><div class="form-control-feedback" ><?php echo $message_mqok; ?></div></td>
                      </tr></table> </div>
                     <div class="NG box"> 
                     <table width="99%" class="table table-bordered">
                     <tr>
                     <td width="20%"><font color="#000000">Enter NG Quantity</font></td>
                     <td width="1%">:</td> 
                     <td colspan="2">  <input name="ng_qty" type="number" min="1" value="<?php if(isset($_POST["ng_qty"])) { echo html_esc($_POST["ng_qty"]); } ?>" class="form-control" max="<?php echo $chk_total_bal; ?>"/><div class="form-control-feedback" ><?php echo $message_mqng; ?></div></td>
                      </tr>
                       <tr>
                     <td width="20%"><font color="#000000">Process of Reject</font></td>
                     <td width="1%">:</td> 
                     <td colspan="2">  
                   <select name="proc_reject" id="proc_reject" class="form-control" onChange="getProcRej(this.value)">
                  <option value="NULL" placeholder="Select Process of Reject"> -- Select Process of Reject --</option>
                  <?php
	               $query_proc = "SELECT * FROM proc_reject_detail_prd WHERE status_proc = 'Y' ORDER BY id_proc ASC";
                   $result_proc = mysqli_query($dbc,$query_proc);
  
                   while($row_proc = mysqli_fetch_array($result_proc)) 
			      {
					  
				   ?>
                     <?php if($_POST["con_bfpend"] == true)  
		         {   ?>
                    <option value="<?php echo html_esc($row_proc["id_proc"]); ?>"<?php if($row_proc["id_proc"] == $_POST["proc_reject"]) echo "selected"; ?>> <?php echo html_esc($row_proc["proc_desc"]); ?></option>
                     
                  <?php
				 }else{
				  
				  ?> 
                  <option value="<?php echo html_esc($row_proc["id_proc"]); ?>"> <?php echo html_esc($row_proc["proc_desc"]); ?></option>
                  <?php
				    }  // else
				  
                  }
				?>
              </select><div class="form-control-feedback" ><?php echo $message_proc; ?></div></td>
                      </tr>
                      
                      <tr>
                     <td width="20%"><font color="#000000">Type of Reject</font></td>
                     <td width="1%">:</td> 
                     <td colspan="2">  
                 <div id="rtype_div">
                     <select name="type_reject" id="type_reject" class="form-control" onChange="getRejType(this.value)">
                  <option value="NULL" placeholder="Select Type of Reject"> -- Select Type of Reject --</option>
                  
              </select></div><div class="form-control-feedback" ><?php echo $message_tpe; ?></div></td>
                      </tr>
                    <tr>
                     <td>Defectives</td>
                     <td>:</td>
                      <td colspan="2">  
                      <div id="defect_div"> 
                      <select name="type_defect" class="form-control" onChange="getDefectType(this.value)">
                      <option value="NULL" placeholder="Select Defective"> -- Select Defective --</option>
                      </select>
                      </div><div class="form-control-feedback" ><?php echo $message_def; ?></div>
                      </td>   
                    
                     </tr>
                   <tr>
                     <td>Reason</td>
                     <td>:</td>
                      <td colspan="2">  <div id="reason_div"> 
                       <input class="form-control" id="reason_reject" type="text" name="reason_reject" />  
        
                      </div></td>
                   </tr>
                      </table></div>
                    <table width="99%" class="table">
                   <tr>
                     <td>&nbsp;<input name="rwk_bfpend" type="submit" id="rwk_bfpend" value="SUBMIT" class="btn btn-success btn-sm" onClick="return confirm('Are you sure? Confirm rework activity?');"></td>
                      <td>&nbsp;</td>
                      <td width="40%">&nbsp;</td>
                      <td width="40%">&nbsp;</td>
                     </tr>
                 </table></td>
               </tr>
             </table>
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
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
    <script type="text/javascript">
      $('#sl').on('click', function(){
      	$('#tl').loadingBtn();
      	$('#tb').loadingBtn({ text : "Signing In"});
      });
      
      $('#el').on('click', function(){
      	$('#tl').loadingBtnComplete();
      	$('#tb').loadingBtnComplete({ html : "Sign In"});
      });
      
      $('#PSSDate').datepicker({
		defaultDate: new Date(),
		format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      
	   $('#PSS2Date').datepicker({
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      $('#demoSelect').select2();
    </script>
   <script language="javascript" type="text/javascript">

function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }
	
	function getProcRej(proc_reject) {		
		
		var strURL="findRejType2.php?proc_reject="+proc_reject;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('rtype_div').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
	
	
	
	function getRejType(type_reject) {		
		
		var strURL="findDefect.php?type_reject="+type_reject;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('defect_div').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
	function getDefectType(type_defect) {		
		
		var strURL="findRejReason.php?type_defect="+type_defect;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('reason_div').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
</script>
  </body>
</html>