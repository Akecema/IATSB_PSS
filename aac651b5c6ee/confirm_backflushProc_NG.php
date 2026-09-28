<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));
$masa = (date("H:m:s"));

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

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2);
    $res = mysqli_fetch_array($result2);
	
    $url = "confirm_backflush_tran_NG.php"; 
	
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

//CR status (Draft)
$sta6 = "SELECT * from request_status WHERE status_id = '6'";
$sta_res6 = mysqli_query($dbc,$sta6);
$rst_sta6 = mysqli_fetch_array($sta_res6);

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
	$('.datepicker').pickadate({
weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
showMonthsShort: true
})
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
          <h1><i class="fa fa-file-text-o"></i> Backflush</h1>
          <p>Confirm Backflush (NG)</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Backflush </li>
          <li class="breadcrumb-item"><a href="confirm_backflush_tran_NG.php">Confirm Backflush (NG)</a></li>
        </ul>
      </div> 
            
              
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
      <?php
	   $uid2 = $_GET["uid2"];
	
	  // echo $uid;
	  
	  
	  
	   $query_scan = "SELECT *, DATE_FORMAT(scan_date_plan,'%d-%m-%Y') as B FROM sc_prd_planning_ng WHERE id_scan = '".sql_esc($uid2)."'";
	   $result_scan = mysqli_query($dbc,$query_scan);
	   $data_scan = mysqli_fetch_array($result_scan);
	   
	   $date_arini = date('Y-m-d'); 
	   $current_date = date('Y-m-d H:i:s'); 
	   $next_date = date('Y-m-d H:i:s', strtotime($current_date .' +2 day'));
	   
	   
	   $message_bcode = ""; 
	   $message_qng = "";       
	   
   //--------------------------------------------------------------------------
     if((isset($_POST["con_firmng"])) && $_POST!=="")  
   { // handle the form.

// create a function for escaping the data.
function escape_data ($data) {
global $dbc;   // need the connection.
if(ini_get('magic_quotes_gpc')) {
    $data = stripslashes($data);
	}
	return mysqli_real_escape_string($data,$dbc);
	}   // end function.
$message = NULL; // create an empty new variable.

       $qty_NG = $_POST["qty_NG"];
       $date2 = $_POST["date2"];
       $time3 = $_POST["time3"]; 
       $time4 = $_POST["time4"];
	   $proc_reject = $_POST["proc_reject"];
	   $type_reject = $_POST["type_reject"];
	   $type_defect = $_POST["type_defect"];
	   $reason_reject = $_POST["reason_reject"];
	   $material_no = $_POST["material_no"];
	   $back_no = $_POST["back_no"];
	   
	  $date_arini = date('Y-m-d'); 
      $current_date = date('Y-m-d H:i:s'); 
	  $next_date = date('Y-m-d H:i:s', strtotime($current_date .' +2 day'));
	  $next_date2 = date('Y-m-d', strtotime($date_arini .' +1 day'));
	  
	  
 
     //check only deilvery date
	 
	             $ddF = substr($_POST["date2"],0,2);
				 $mmF = substr($_POST["date2"],3,2);
				 $yyF = substr($_POST["date2"],6,4);
			
			     $date2_final = ($yyF.'-'.$mmF.'-'.$ddF);
	 
					  
				 $date_date2 = (($_POST["date2"])." ".($_POST["time3"]).":".($_POST["time4"]).":00");
				  
			
						  
				if(($_POST["date2"]) == "NULL")
				{
				  $date2 = FALSE;
				  $message.= '<p align="center">You are required to select Date!</p>';
				  }else{
				  $date2 = TRUE;
				  }
				      
					
				if(($_POST["time3"]) == "NULL")
				{
				  $time3 = FALSE;
				  $message.= '<p align="center">You are required to select Hours!</p>';
				  }else{
				  $time3 = TRUE;
				  }
				  
				  if(($_POST["time4"]) == "NULL")
				{
				  $time4 = FALSE;
				  $message.= '<p align="center">You are required to select Minutes!</p>';
				  } else{
				  $time4 = TRUE;
				  }
				  
		  //---check process of reject
		       if(($_POST["proc_reject"]) == "NULL")
				{
				  $proc_reject = FALSE;
				  $message.= '<p align="center">You are required to select Process of Reject!</p>';
				  } else{
				  $proc_reject = TRUE;
				  }		
				  
		//---check type of reject
		       if(($_POST["type_reject"]) == "NULL")
				{
				  $type_reject = FALSE;
				  $message.= '<p align="center">You are required to select Type of Reject!</p>';
				  } else{
				  $type_reject = TRUE;
				  }		
				  
	   //---check type of defective
		       if(($_POST["type_defect"]) == "NULL")
				{
				  $type_defect = FALSE;
				  $message.= '<p align="center">You are required to select Type of Defective!</p>';
				  } else{
				  $type_defect = TRUE;
				  }		    
	   
	   //---check reason reject
		       if(($_POST["reason_reject"]) == "NULL")
				{
				  $reason_reject = FALSE;
				  $message.= '<p align="center">You are required to select Reason Reject!</p>';
				  } else{
				  $reason_reject = TRUE;
				  }	
				  
		
				  
				   if(($_POST["qty_NG"]) == "")
				{
				  $qty_NG = FALSE;
				  $message_qng = '<span class="badge badge-pill badge-danger"> You are required to enter NG quantity!</span>';
				  }else{
				  $qty_NG = TRUE;
				  } 
				 
		     
	   if($qty_NG && $time3 && $time4 && $date2 && $proc_reject && $type_reject && $type_defect && $reason_reject)
	   {
		   
	   $qty_NG = $_POST["qty_NG"];
       $date2 = $_POST["date2"];
       $time3 = $_POST["time3"]; 
       $time4 = $_POST["time4"];
	   $proc_reject = $_POST["proc_reject"];
	   $type_reject = $_POST["type_reject"];
	   $type_defect = $_POST["type_defect"];
	   $reason_reject = $_POST["reason_reject"];
	   $material_no = $_POST["material_no"];
	   $back_no = $_POST["back_no"];

	$t_time2 = (($_POST["time3"]).":".($_POST["time4"]));  
	
	$ref = "";
	
	  //---shift detail ------
		
		  $query_shtA = "SELECT * FROM shift_detail WHERE id_shift = '1'";
		  $result_shtA = mysqli_query($dbc,$query_shtA);
		  $data_shtA = mysqli_fetch_array($result_shtA); 
		  
		 //----shift posting ----
		 
		 if(($t_time2 >= $data_shtA["time_start"]) && ($t_time2 <= $data_shtA["time_end"]))
		 {
			 
		 $shif_pA = "D/S"; 
		 
		 }else
		 {
		 
		 $shif_pA = "N/S"; 
		
		 }	

	//echo $date2_final;
	 //--------- generate backflush no NG ---------------
	 
	  if($data_scan["scan_plant"] == '3100')
	{
	
	$query_id = "SELECT * FROM run_count_itsb WHERE uid = '13'";
	$result_id = mysqli_query($dbc,$query_id);
	
	}elseif($data_scan["scan_plant"] == '3101')
	{
		
	$query_id = "SELECT * FROM run_count_itsb WHERE uid = '68'";
	$result_id = mysqli_query($dbc,$query_id);	
		
	}
	
	if ($result_id) 
{
	$nrows = mysqli_num_rows($result_id);
	$row_id = mysqli_fetch_array($result_id);
	
	$dht = 00000; 
	$dht_OK = "221";
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
    $number = sprintf('%03d', $number);  
	
	
	 // $ref = ($dht_OK.($number));
	
	  $ref = (($row_id["start_ref"]).$dht_OK.$date_run.($number));
	
	} // end if $result_id
	
			  
			  
  //update count_max----------------------------------------
		 if($data_scan["scan_plant"] == '3100')
	{
	
       $query_max_b = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '13'";
	   $result_max_b = mysqli_query($dbc,$query_max_b);
	   
	}elseif($data_scan["scan_plant"] == '3101')
	{   
	   $query_max_b = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '68'";
	   $result_max_b = mysqli_query($dbc,$query_max_b);
	   
	}
   //end update count_max ---------------------------------	
	
	
      if($data_scan["material_no"] == "N/A")
	    { 
	
	 //--------- pps detail ------------
	   $query_pps = "SELECT * FROM pps_detail WHERE material_no = '".sql_esc($material_no)."' AND back_no = '".sql_esc($back_no)."' AND date_plan = '".sql_esc($date2_final)."' AND (shift_pps1 = '".sql_esc($shif_pA)."' OR shift_pps2 = '".sql_esc($shif_pA)."') AND status_pps != '".sql_esc($rst_sta4["status_desc"])."' AND status_pps != '".sql_esc($rst_sta13["status_desc"])."'";
	   $result_pps = mysqli_query($dbc,$query_pps);
	   $data_pps = mysqli_fetch_array($result_pps); 
	 
	   	   	   	
  $query_q2A = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($material_no)."'";
  $result_q2A = mysqli_query($dbc,$query_q2A);
  $ans3A = mysqli_fetch_array($result_q2A);
  
  //-------model-----------------
  
  $query_model = "SELECT * FROM model_detail_tbl WHERE id_model = '".sql_esc($ans3A["model_code"])."' AND material_type = '".sql_esc($ans3A["mat_type"])."'";
  $result_model = mysqli_query($dbc,$query_model);
  $data_model = mysqli_fetch_array($result_model);
  
  //-----material type material_type_tbl ---------
  
  $query_mtype = "SELECT * FROM material_type_tbl WHERE id = '".sql_esc($ans3A["mat_type"])."'";
  $result_mtype = mysqli_query($dbc,$query_mtype);
  $data_mtype = mysqli_fetch_array($result_mtype);
	 
	    if($data_pps["plan_no"]  > 0)
	        {
				
		
	
	$query_upd_scan = "UPDATE sc_prd_planning_ng SET plan_no = '".sql_esc($data_pps["plan_no"])."', work_center = '".sql_esc($data_pps["work_center"])."', model_code = '".sql_esc($data_pps["model_code"])."', kanban_no = '".sql_esc($data_pps["kanban_no"])."', scan_shift = '".sql_esc($shif_pA)."', scan_date_plan = '".sql_esc($date2_final)."', material_no = '".sql_esc($material_no)."', material_desc = '".sql_esc($ans3A["material_desc"])."',  back_no = '".sql_esc($back_no)."', material_type = '".sql_esc($data_mtype["mat_type_id"])."', scan_date_plan = '".sql_esc($date2_final)."', scan_qty = '".sql_esc($qty_NG)."', scan_uom = '".sql_esc($ans3A["BUn"])."' WHERE id_scan = '".sql_esc($uid2)."'";
	$result_upd_scan = mysqli_query($dbc,$query_upd_scan);	
		
		//----------find posting log depend material type
	  
	   if(($data_pps["material_type"] == "Z301") && ($data_pps["plan_category"] == "ASSY"))
	  {
		$ploc = "W1RJ";  
		  
	  }elseif(($data_pps["material_type"] == "Z301") && ($data_pps["plan_category"] == "STM"))
	  {
		$ploc = "P1RJ";  
		  
	  }elseif(($data_pps["material_type"] == "Z201")  && ($data_pps["plan_category"] == "ASSY"))
	  {
		$ploc = "W1RJ";
	  }elseif(($data_pps["material_type"] == "Z201")  && ($data_pps["plan_category"] == "STM"))
	  {
		$ploc = "P1RJ";
	  }elseif(($data_pps["material_type"] == "Z301")  && ($data_pps["plan_category"] == "BLK"))
	  {
		$ploc = "B1RJ";
		
	  }elseif(($data_pps["material_type"] == "Z101")  && ($data_pps["plan_category"] == "BLK"))
	  {
		$ploc = "B1RJ";
	  }
	  else{
		
		$ploc = "";
	  }
		
		 //-----shift post ------
	 
	      $query_shtB = "SELECT * FROM shift_detail WHERE id_shift = '1'";
		  $result_shtB = mysqli_query($dbc,$query_shtB);
		  $data_shtB = mysqli_fetch_array($result_shtB); 
		  
		 //----shift posting ----
		 
		 if(($masa >= $data_shtB["time_start"]) && ($masa <= $data_shtB["time_end"]))
		 {
			 
		 $shif_pB = "D/S"; 
		 
		 }else
		 {
		 
		 $shif_pB = "N/S"; 
		
		 }	 
	 
	 

		
		//----------- find cost center --------------
		$query_cs_cent = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($data_scan["work_center"])."'";
		$result_cs_cent = mysqli_query($dbc,$query_cs_cent); 
		$row_cs_cent = mysqli_fetch_array($result_cs_cent);
		
		

	  
	 //insert into table pps_detail_trn_fg_ng-------------
	
$query_data2 = "INSERT INTO pps_detail_trn_fg_ng (id,pps_id,ref_id,bflush_no,plan_no,id_scan,upload_id,model_code,month_plan,material_no,material_desc,material_type,qty_plan,qty_actual,qty_balance,qty_NG,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,status,user_upload,date_upload,user_create,date_create,user_update,date_update,user_posting,date_posting,time_posting,ploc,delivery_loc,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,status_ftp_bflush,bflush_no_ref,user_cancel,date_cancel,remark_cancel,plant_code,shift_posting,stamp_ind,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($data_pps["id"])."','".sql_esc($data_pps["ref_id"])."','".sql_esc($ref)."','".sql_esc($data_pps["plan_no"])."','".sql_esc($uid2)."','".sql_esc($data_pps["upload_id"])."','".sql_esc($data_pps["model_code"])."','".sql_esc($data_pps["month_plan"])."','".sql_esc($data_pps["material_no"])."','".sql_esc($ans3A["material_desc"])."','".sql_esc($data_pps["material_type"])."','".sql_esc($data_pps["qty_plan"])."','','','".sql_esc($qty_NG)."','".sql_esc($rst_sta6["status_desc"])."','".sql_esc($data_pps["plant_code"])."','".sql_esc($data_pps["work_center"])."','".sql_esc($data_pps["shift_pps1"])."','".sql_esc($data_pps["shift_pps2"])."','".sql_esc($data_pps["date_plan"])."','Y','".sql_esc($data_pps["user_upload"])."','".sql_esc($data_pps["date_upload"])."','".sql_esc($username)."',NOW(),'','','".sql_esc($username)."','".sql_esc($date2_final)."','".sql_esc($t_time2)."','".sql_esc($data_mat_info["sloc"])."','".sql_esc($ploc)."','".sql_esc($proc_reject)."','".sql_esc($type_reject)."','".sql_esc($type_defect)."','".sql_esc($reason_reject)."','".sql_esc($username)."',NOW(),NOW(),'Y','','','','','".sql_esc($data_pps["plant_code"])."','','".sql_esc($data_pps["plan_category"])."','".sql_esc($data_pps["back_no"])."','".sql_esc($data_pps["kanban_no"])."','','')";
$result_data2 = mysqli_query($dbc,$query_data2);
 
  //-------------------update---------------------
  
      $query_all_info = "SELECT * FROM pps_detail_trn_fg_ng WHERE id = '".mysqli_insert_id($dbc)."'";
	  $result_all_info = mysqli_query($dbc,$query_all_info);
	  $data_all_info = mysqli_fetch_array($result_all_info); 
	   

      //insert into table disposal_detail_prd_ng -------------
	  //production BF NG ---> masuk dlm disposal
	  
	 	$query_ins_dis = "INSERT INTO disposal_detail_prd_ng(id_disposal,doc_dis,doc_disposal_no,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit, comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','','','".sql_esc($ref)."','".sql_esc($data_pps["plan_no"])."','".sql_esc($data_all_info["id"])."','".sql_esc($data_pps["material_no"])."','".sql_esc($data_scan["material_desc"])."','".sql_esc($data_scan["material_type"])."','".sql_esc($data_pps["model_code"])."','".sql_esc($data_pps["qty_plan"])."','','','".sql_esc($qty_NG)."','','','','".sql_esc($data_scan["scan_uom"])."','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_scan["work_center"])."','".sql_esc($shif_pB)."','".sql_esc($date2_final)."','".sql_esc($username)."','".sql_esc($date2_final)."','".sql_esc($t_time2)."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($ans3A["sloc"])."','".sql_esc($ploc)."','','".sql_esc($proc_reject)."','".sql_esc($type_reject)."','".sql_esc($type_defect)."','".sql_esc($reason_reject)."','".sql_esc($username)."','".sql_esc($date2_final)."','".sql_esc($t_time2)."','','','','','','','".sql_esc($username)."','".sql_esc($date2_final)."','','PR','".sql_esc($username)."',NOW(),'','','','','','','','','','','','','','','','','','','','','".sql_esc($row_cs_cent["cost_center"])."','".sql_esc($row_cs_cent["id_factory"])."','','','','','".sql_esc($data_scan["plant_cd"])."','','".sql_esc($data_all_info["stamp_ind"])."','".sql_esc($data_pps["back_no"])."','".sql_esc($data_pps["kanban_no"])."','".sql_esc($data_all_info["SAP_ref_doc"])."','".sql_esc($data_all_info["SAP_ref_doc_can"])."')";
$result_ins_dis = mysqli_query($dbc,$query_ins_dis); 

	  
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
	$query_upd_detail2 = "UPDATE pps_detail_trn_fg_ng SET shift_posting = '".sql_esc($shif_p)."' WHERE id = '".sql_esc($data_all_info["id"])."'";
	$result_upd_detail2 = mysqli_query($dbc,$query_upd_detail2);  
	
	//---------update shift posting ---------------
	$query_upd_detail3 = "UPDATE disposal_detail_prd_ng SET shift_posting = '".sql_esc($shif_p)."' WHERE bflush_qqc_no = '".sql_esc($data_all_info["bflush_no"])."'";
	$result_upd_detail3 = mysqli_query($dbc,$query_upd_detail3);  

	   
	    //----edit by azie 17 nov 2021 night shift ------	
  
  
	$query_upd_shift = "SELECT * FROM pps_detail_trn_fg_ng WHERE id = '".sql_esc($data_all_info["id"])."'";
    $result_upd_shift = mysqli_query($dbc,$query_upd_shift);
	$row_upd_shift = mysqli_fetch_array($result_upd_shift);
	
	
	if(($row_upd_shift["shift_posting"] == "N/S") && ($row_upd_shift["date_posting"] == $currentdate))
	{
	
	$prev_date = date('Y-m-d', strtotime($currentdate .' -1 day'));	
	
	if(($row_upd_shift["time_posting"] > "20:00:00" ) && ($row_upd_shift["time_posting"] < "23:59:59" ))
	{
		
	}else{
		
	$query_upd_shift2 = "UPDATE pps_detail_trn_fg_ng SET date_posting = '".sql_esc($prev_date)."' WHERE id = '".sql_esc($row_upd_shift["id"])."'";
	$result_upd_shift2 = mysqli_query($dbc,$query_upd_shift2); 
	
	}
		
	}
	   
	   
	   
	    }else{
			
				  echo "<script>";
				  echo "alert('ERROR! Please Scan Kanban QR Code. Planning not exist');";
				  echo "window.location='confirm_backflushProc_NG.php?uid2=".html_esc($uid2)."'";
				  echo "</script>";
				  exit(); //quit the script
			 
				 }  // if($data_pps["plan_no"]  > 0)
	   
 
	 
	 
		}//  if($data_scan["material_no"] == "N/A")
		else{  
		
		
		  //---shift detail ------
	
	  $query_sht_checking = "SELECT * FROM shift_detail WHERE id_shift = '1'";
	  $result_sht_checking = mysqli_query($dbc,$query_sht_checking);
	  $data_sht_checking = mysqli_fetch_array($result_sht_checking); 
	  
	 //----shift posting ----
	 $prev_date = date('Y-m-d', strtotime($currentdate .' -1 day'));
	 
	 if(($masa >= $data_sht_checking["time_start"]) && ($masa <= $data_sht_checking["time_end"]))
	 {
		 
     $date_baru = $date2_final;
	
	 
	 }else
	 {
	    if(($masa >= '00:00:00') && ($masa <= '07:59:00'))
	   {
	    $date_baru = $prev_date; 
	   }else{
		   
		 $date_baru = $date2_final;   
	   }
	
	 }
  
	 //--------- pps detail ------------
	 
	   $query_pps = "SELECT * FROM pps_detail WHERE material_no = '".sql_esc($data_scan["material_no"])."' AND back_no = '".sql_esc($data_scan["back_no"])."' AND date_plan = '".sql_esc($date_baru)."' AND (shift_pps1 = '".sql_esc($shif_pA)."' OR shift_pps2 = '".sql_esc($shif_pA)."') AND status_pps != '".sql_esc($rst_sta4["status_desc"])."' AND status_pps != '".sql_esc($rst_sta13["status_desc"])."'";
	   $result_pps = mysqli_query($dbc,$query_pps);
	   $data_pps = mysqli_fetch_array($result_pps);
	   
	   
	   	   	
  $query_q2A = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($data_scan["material_no"])."'";
  $result_q2A = mysqli_query($dbc,$query_q2A);
  $ans3A = mysqli_fetch_array($result_q2A);
  
  //-------model-----------------
  
  $query_model = "SELECT * FROM model_detail_tbl WHERE id_model = '".sql_esc($ans3A["model_code"])."' AND material_type = '".sql_esc($ans3A["mat_type"])."'";
  $result_model = mysqli_query($dbc,$query_model);
  $data_model = mysqli_fetch_array($result_model);
  
  //-----material type material_type_tbl ---------
  
  $query_mtype = "SELECT * FROM material_type_tbl WHERE id = '".sql_esc($ans3A["mat_type"])."'";
  $result_mtype = mysqli_query($dbc,$query_mtype);
  $data_mtype = mysqli_fetch_array($result_mtype);
	 
	
		
		//----------find posting log depend material type
	  
	   if(($data_pps["material_type"] == "Z301") && ($data_pps["plan_category"] == "ASSY"))
	  {
		$ploc = "W1RJ";  
		  
	  }elseif(($data_pps["material_type"] == "Z301") && ($data_pps["plan_category"] == "STM"))
	  {
		$ploc = "P1RJ";  
		  
	  }elseif(($data_pps["material_type"] == "Z201")  && ($data_pps["plan_category"] == "ASSY"))
	  {
		$ploc = "W1RJ";
	  }elseif(($data_pps["material_type"] == "Z201")  && ($data_pps["plan_category"] == "STM"))
	  {
		$ploc = "P1RJ";
	  }elseif(($data_pps["material_type"] == "Z301")  && ($data_pps["plan_category"] == "BLK"))
	  {
		$ploc = "B1RJ";
		
	  }elseif(($data_pps["material_type"] == "Z101")  && ($data_pps["plan_category"] == "BLK"))
	  {
		$ploc = "B1RJ";
	  }
	  else{
		
		$ploc = "";
	  }
		
		 //-----shift post ------
	 
	      $query_shtB = "SELECT * FROM shift_detail WHERE id_shift = '1'";
		  $result_shtB = mysqli_query($dbc,$query_shtB);
		  $data_shtB = mysqli_fetch_array($result_shtB); 
		  
		 //----shift posting ----
		 
		 if(($masa >= $data_shtB["time_start"]) && ($masa <= $data_shtB["time_end"]))
		 {
			 
		 $shif_pB = "D/S"; 
		 
		 }else
		 {
		 
		 $shif_pB = "N/S"; 
		
		 }	 
	 
	     
		 
		  if($data_pps["plan_no"]  > 0)
	        {
	 

       $query_scan_upd = "UPDATE sc_prd_planning_ng SET plan_no = '".sql_esc($data_pps["plan_no"])."', scan_shift = '".sql_esc($shif_pB)."', scan_date_plan = '".sql_esc($date2_final)."' WHERE id_scan = '".sql_esc($uid2)."'";
	   $result_scan_upd = mysqli_query($dbc,$query_scan_upd);

		
		//----------- find cost center --------------
		$query_cs_cent = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($data_scan["work_center"])."'";
		$result_cs_cent = mysqli_query($dbc,$query_cs_cent); 
		$row_cs_cent = mysqli_fetch_array($result_cs_cent);

	  
	 //insert into table pps_detail_trn_fg_ng-------------
	
$query_data2 = "INSERT INTO pps_detail_trn_fg_ng (id,pps_id,ref_id,bflush_no,plan_no,id_scan,upload_id,model_code,month_plan,material_no,material_desc,material_type,qty_plan,qty_actual,qty_balance,qty_NG,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,status,user_upload,date_upload,user_create,date_create,user_update,date_update,user_posting,date_posting,time_posting,ploc,delivery_loc,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,status_ftp_bflush,bflush_no_ref,user_cancel,date_cancel,remark_cancel,plant_code,shift_posting,stamp_ind,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($data_pps["id"])."','".sql_esc($data_pps["ref_id"])."','".sql_esc($ref)."','".sql_esc($data_pps["plan_no"])."','".sql_esc($uid2)."','".sql_esc($data_pps["upload_id"])."','".sql_esc($data_pps["model_code"])."','".sql_esc($data_pps["month_plan"])."','".sql_esc($data_pps["material_no"])."','".sql_esc($ans3A["material_desc"])."','".sql_esc($data_pps["material_type"])."','".sql_esc($data_pps["qty_plan"])."','','','".sql_esc($qty_NG)."','".sql_esc($rst_sta6["status_desc"])."','".sql_esc($data_pps["plant_code"])."','".sql_esc($data_pps["work_center"])."','".sql_esc($data_pps["shift_pps1"])."','".sql_esc($data_pps["shift_pps2"])."','".sql_esc($data_pps["date_plan"])."','Y','".sql_esc($data_pps["user_upload"])."','".sql_esc($data_pps["date_upload"])."','".sql_esc($username)."',NOW(),'','','".sql_esc($username)."','".sql_esc($date2_final)."','".sql_esc($t_time2)."','".sql_esc($data_mat_info["sloc"])."','".sql_esc($ploc)."','".sql_esc($proc_reject)."','".sql_esc($type_reject)."','".sql_esc($type_defect)."','".sql_esc($reason_reject)."','".sql_esc($username)."',NOW(),NOW(),'Y','','','','','".sql_esc($data_pps["plant_code"])."','','".sql_esc($data_pps["plan_category"])."','".sql_esc($data_pps["back_no"])."','".sql_esc($data_pps["kanban_no"])."','','')";
$result_data2 = mysqli_query($dbc,$query_data2);
 
  //-------------------update---------------------
  
      $query_all_info = "SELECT * FROM pps_detail_trn_fg_ng WHERE id = '".mysqli_insert_id($dbc)."'";
	  $result_all_info = mysqli_query($dbc,$query_all_info);
	  $data_all_info = mysqli_fetch_array($result_all_info); 
	   

      //insert into table disposal_detail_prd_ng -------------
	  //production BF NG ---> masuk dlm disposal
	  
	 	$query_ins_dis = "INSERT INTO disposal_detail_prd_ng(id_disposal,doc_dis,doc_disposal_no,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit, comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','','','".sql_esc($ref)."','".sql_esc($data_pps["plan_no"])."','".sql_esc($data_all_info["id"])."','".sql_esc($data_pps["material_no"])."','".sql_esc($data_scan["material_desc"])."','".sql_esc($data_scan["material_type"])."','".sql_esc($data_scan["model_code"])."','".sql_esc($data_pps["qty_plan"])."','','','".sql_esc($qty_NG)."','','','','".sql_esc($data_scan["scan_uom"])."','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_scan["work_center"])."','".sql_esc($shif_pB)."','".sql_esc($date2_final)."','".sql_esc($username)."','".sql_esc($date2_final)."','".sql_esc($t_time2)."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($ans3A["sloc"])."','".sql_esc($ploc)."','','".sql_esc($proc_reject)."','".sql_esc($type_reject)."','".sql_esc($type_defect)."','".sql_esc($reason_reject)."','".sql_esc($username)."','".sql_esc($date2_final)."','".sql_esc($t_time2)."','','','','','','','".sql_esc($username)."','".sql_esc($date2_final)."','','PR','".sql_esc($username)."',NOW(),'','','','','','','','','','','','','','','','','','','','','".sql_esc($row_cs_cent["cost_center"])."','".sql_esc($row_cs_cent["id_factory"])."','','','','','".sql_esc($data_scan["plant_cd"])."','','".sql_esc($data_all_info["stamp_ind"])."','".sql_esc($data_pps["back_no"])."','".sql_esc($data_pps["kanban_no"])."','".sql_esc($data_all_info["SAP_ref_doc"])."','".sql_esc($data_all_info["SAP_ref_doc_can"])."')";
$result_ins_dis = mysqli_query($dbc,$query_ins_dis); 

	  
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
	$query_upd_detail2 = "UPDATE pps_detail_trn_fg_ng SET shift_posting = '".sql_esc($shif_p)."' WHERE id = '".sql_esc($data_all_info["id"])."'";
	$result_upd_detail2 = mysqli_query($dbc,$query_upd_detail2);  
	
	//---------update shift posting ---------------
	$query_upd_detail3 = "UPDATE disposal_detail_prd_ng SET shift_posting = '".sql_esc($shif_p)."' WHERE bflush_qqc_no = '".sql_esc($data_all_info["bflush_no"])."'";
	$result_upd_detail3 = mysqli_query($dbc,$query_upd_detail3);  

	
		   
  //-------update status "Released" to "Inprogress" in table pps_detail	
	
	/*$query_upd_detail = "UPDATE pps_detail SET user_posting = '".$username."', date_posting = NOW(), status_pps = '".$rst_sta7["status_desc"]."' WHERE  id = '".$data_all_info["pps_id"]."'";
	$result_upd_detail = mysqli_query($dbc,$query_upd_detail);
	*/


  //----edit by azie 17 nov 2021 night shift ------	
  
  
	$query_upd_shift = "SELECT * FROM pps_detail_trn_fg_ng WHERE id = '".sql_esc($data_all_info["id"])."'";
    $result_upd_shift = mysqli_query($dbc,$query_upd_shift);
	$row_upd_shift = mysqli_fetch_array($result_upd_shift);
	
	
	if(($row_upd_shift["shift_posting"] == "N/S") && ($row_upd_shift["date_posting"] == $currentdate))
	{
	
	$prev_date = date('Y-m-d', strtotime($currentdate .' -1 day'));	
	
	if(($row_upd_shift["time_posting"] > "20:00:00" ) && ($row_upd_shift["time_posting"] < "23:59:59" ))
	{
		
	}else{
		
	$query_upd_shift2 = "UPDATE pps_detail_trn_fg_ng SET date_posting = '".sql_esc($prev_date)."' WHERE id = '".sql_esc($row_upd_shift["id"])."'";
	$result_upd_shift2 = mysqli_query($dbc,$query_upd_shift2);  	
		
	}
	}

   


	
 //------- crete text file to SAP [FolderPortal] -----------
 
             }else{
			
				  echo "<script>";
				  echo "alert('ERROR! Please Scan Kanban QR Code. Planning not exist');";
				  echo "window.location='confirm_backflushProc_NG.php?uid2=".html_esc($uid2)."'";
				  echo "</script>";
				  exit(); //quit the script
			 
				 }  // if($data_pps["plan_no"]  > 0)
 
 
 
 
		}  // end else if($data_scan["material_no"] == "N/A")
		
	 
	  
	       $ref11 =	base64_encode($ref);
		   $uid22 =	base64_encode($uid2);	
	     
           echo "<script>";
		 //  echo "alert('Backflush Document No : $ref');";
		   echo "window.location='confirm_backflushProc_NG-pr2.php?buid=$ref11&&uid=$uid22'";
	       echo "</script>"; 
		   exit(); //quit the script
	
 	
		 
	  	   }	//end if ok
	  
	   
	// mysql_close();  
	   
  //print the message if there is one.
if (isset($message))
{ echo '<div class="msg msg-error"><font color="red" class ="error_entry">', $message, '</font></div>';
}
  
} // end if submit


   //------------------------------------------------------------------------------

		 $no = 1; 
		 
		  //------------plant code detail -------------
		 
		 $query_plant = "SELECT * FROM plant_detail WHERE plant_code = '".sql_esc($data_scan["plant_cd"])."'";
		 $result_plant = mysqli_query($dbc,$query_plant);
	     $data_plant = mysqli_fetch_array($result_plant);
		  
		  ?>
         <form name="myform" method="post" action="confirm_backflushProc_NG.php?uid2=<?php echo html_esc($uid2); ?>">        
          <table width="100%" border="0" cellpadding="2">
        <tr>
       <td width="52%" ><p>&nbsp;</p></td>
       <td width="48%">
           <table width="95%" border="0" align="center" cellpadding="2">
            <tr>
             <td width="65%"><span class="style4">&nbsp;<?php echo date("D M d, Y");   ?></span>&nbsp;&nbsp;<span class="style5"><?php echo date("h:i:s");  ?></span></td>
             </tr>
           </table></td>
     </tr>
     </table> 
     
     <table width="100%" border="0" cellpadding="2">
             <tr>
               <td><p>Please enter backflush output quantity for NG</p>
                 <table width="99%" align="right" class="table table-bordered"> 
                  <tr>
                     <td width="14%">Part Number</td>
                     <td width="2%">:</td>
                     <td colspan="2">
					 <?php
					 
					if($data_scan["material_no"] != "N/A")
					{ 
	                 $query39 = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($data_scan["material_no"])."' AND status_BOM = 'Y' ORDER BY id_mat ASC";
                     $result39 = mysqli_query($dbc,$query39);

                        ?>
 
              <select name="material_no" id="material_no" class="form-control">
         
				<?php
              while($row39=mysqli_fetch_array($result39)) 
                {
                    
                
                ?>
                  <option value="<?php echo html_esc($row39["material_no"]); ?>" >(<?php echo html_esc($row39["back_no"]); ?>)&nbsp;<?php echo html_esc($row39["material_no"]); ?> - <?php echo html_esc($row39["material_desc"]); ?> </option>
                
                <?php     }
                
                ?>
            </select>
          
            <input class="form-control" id="back_no" type="hidden"  name="back_no" value="<?php echo html_esc($data_scan["back_no"]); ?>" />  
            <?php    }else{
				
				
			 $query39A = "SELECT * FROM table_material_itsb WHERE (Vclass = 'Z201' OR Vclass = 'Z301') AND status_BOM = 'Y' ORDER BY id_mat ASC";
             $result39A = mysqli_query($dbc,$query39A);

                        ?>
 
              <select name="material_no" id="material_no" class="form-control" onChange="getDesc(this.value)">
              <option value="NULL" placeholder="Select Part Number"> -- Select Part Number --</option>
          
				<?php
              while($row39A=mysqli_fetch_array($result39A)) 
                {
                    
                
                ?>
                  <option value="<?php echo html_esc($row39A["material_no"]); ?>" >(<?php echo html_esc($row39A["back_no"]); ?>)&nbsp;<?php echo html_esc($row39A["material_no"]); ?> - <?php echo html_esc($row39A["material_desc"]); ?></option>
                
                <?php     }
                
                ?>
            </select>
              <div id="mat_div"> 
              
              </div>
				
			<?php	
				
			     }  ?>
                     
   
                     </td>
                    </tr>
                   <tr>
                     <td width="14%">Posting Date</td>
                     <td width="2%">:</td>
                     <td colspan="2"> 
                     <input class="form-control" id="PSS2Date" type="text" placeholder="Select Date" name="date2" value="<?php if(isset($_POST['date2'])){ echo html_esc($_POST['date2']); }else{ echo $fmt_curr_date; } ?>" />
                     </td>
                    </tr>
                     <tr>
                     <td>Posting Time </td>
                     <td>:</td>
                     <td width="40%"><font color="#999999" size="-1">Hours</font><br><select name="time3" id="time3" class="form-control form-control-sm">
                       <?php if($_POST["con_firmng"] == true)
		{  
		?>
                       <option value="<?php echo html_esc($_POST["time3"]); ?>"><?php echo sprintf('%02d', $_POST["time3"]);	 ?></option>
                       <?php
	 }else{
	 ?>
                       <option value="<?php echo sprintf('%02d', date('H'));	 ?>" placeholder="HOURS"><?php echo sprintf('%02d', date('H'));	 ?></option>
                       <?php
	  }
	  
      for($b2 = 0; $b2 <= 23; $b2++): ?>
                       <option value="<?= $b2; ?>"> <?php echo sprintf('%02d', $b2); ?></option>
                       <?php endfor; ?>
                     </select></td>
                      <td width="40%"><font color="#999999" size="-1"> Minutes</font><br>
                      <select name="time4" id="time4" class="form-control form-control-sm">
                       <?php if($_POST["con_firmng"] == true)  
		{  
		?>
                       <option value="<?php echo html_esc($_POST["time4"]); ?>"><?php echo sprintf('%02d', $_POST["time4"]);	 ?></option>
                       <?php
	 }else{
	 ?>
                       <option value="<?php echo sprintf('%02d', date('i'));	 ?>" placeholder="MINUTES"><?php echo sprintf('%02d', date('i'));	 ?></option>
                       <?php
	  }
      for($w = 0; $w <= 59; $w++): ?>
                       <option value="<?= $w; ?>"> <?php echo sprintf('%02d', $w); ?></option>
                       <?php endfor; ?>
                     </select></td>
                  
                     </tr>
                  
                   <tr>
                     <td>Enter NG Quantity</td>
                     <td>:</td>
                     <td colspan="5"><input name="qty_NG" type="number" min="1" value="<?php if(isset($_POST["qty_NG"])) { echo html_esc($_POST["qty_NG"]); } ?>"  class="form-control" /><div class="form-control-feedback" ><?php echo $message_qng; ?></div></td>
                     </tr>
                    <tr>
                     <td>Process of Reject</td>
                     <td>:</td>
                     <td colspan="5"><select name="proc_reject" id="proc_reject" class="form-control" onChange="getProcRej(this.value)">
                  <option value="NULL" placeholder="Select Process of Reject"> -- Select Process of Reject --</option>
                  <?php
	               $query_proc = "SELECT * FROM proc_reject_detail_prd WHERE status_proc = 'Y' ORDER BY id_proc ASC";
                   $result_proc = mysqli_query($dbc,$query_proc);
  
                   while($row_proc = mysqli_fetch_array($result_proc)) 
			      {
					  
				   ?>
                     <?php if($_POST["con_firmng"] == true)  
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
              </select></td>
                
                   </tr>
                   <tr>
                     <td>Type of Reject</td>
                     <td>:</td>
                     <td colspan="5">
                     <div id="rtype_div">
                     <select name="type_reject" id="type_reject" class="form-control" onChange="getRejType(this.value)">
                  <option value="NULL" placeholder="Select Type of Reject"> -- Select Type of Reject --</option>
                  
              </select></div></td>
                    
                    </tr>
                    <tr>
                     <td>Defectives</td>
                     <td>:</td>
                     <td colspan="5">
                      <div id="defect_div"> 
                      <select name="type_defect" class="form-control" onChange="getDefectType(this.value)">
                      <option value="NULL" placeholder="Select Defective"> -- Select Defective --</option>
                      </select>
                      </div>
                      </td>   
                     </tr>
                   <tr>
                     <td>Reason</td>
                     <td>:</td>
                     <td colspan="5"><div id="reason_div"> 
                       <input class="form-control" id="reason_reject" type="text" name="reason_reject" />  
        
                      </div></td>
                   </tr>
                 
                 
                 </table>
                 
                   
          <br>  
                 
                 
                 <table>
                     <tr>
                     <td colspan="7">&nbsp;<input name="con_firmng" type="submit" id="con_firmng" value="SUBMIT" class="btn btn-success btn-sm" ></td>
                     </tr></table></td>
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
		defaultDate: new Date(),   
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
		
		var strURL="findRejType.php?proc_reject="+proc_reject;
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
		
		var strURL="findDefect3.php?type_reject="+type_reject;
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
	
	function getDesc(material_no) {		
		
		var strURL="findDesc-BF.php?material_no="+material_no;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('mat_div').innerHTML=req.responseText;						
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