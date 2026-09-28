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
	
    $url = "confirm_backflush_tran.php"; 
	
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
          <p>Confirm Backflush (OK)</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Backflush </li>
          <li class="breadcrumb-item"><a href="confirm_backflush_tran.php">Confirm Backflush (OK)</a></li>
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
	  
	
	  
	  
	  
	  
	  
	  
	     //---shift detail ------
			   
	$message_bcode = ""; 
	$message_qok = "";  
	
		

	
	   $query_scan = "SELECT *, DATE_FORMAT(scan_date_plan,'%d-%m-%Y') as B FROM sc_prd_planning_ok WHERE id_scan = '".sql_esc($uid2)."'";
	   $result_scan = mysqli_query($dbc,$query_scan);
	   $data_scan = mysqli_fetch_array($result_scan);
	   
	   $date_arini = date('Y-m-d'); 
	   $current_date = date('Y-m-d H:i:s'); 
	   $next_date = date('Y-m-d H:i:s', strtotime($current_date .' +2 day'));
	   
	   $prev_date = date('Y-m-d', strtotime($currentdate .' -1 day'));	  
	   
   //--------------------------------------------------------------------------
	   if((isset($_POST["con_bfok"])) && $_POST!=="") 
  
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

       $qty_actual = $_POST["qty_actual"];
       $date1 = $_POST["date1"];
       $time1 = $_POST["time1"]; 
       $time2 = $_POST["time2"];
	   $material_no = $_POST["material_no"];
	   $back_no = $_POST["back_no"];
	   
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
				  
				  
				 if(($_POST["qty_actual"]) == "")
				{
				  $qty_actual = FALSE;
				  $message_qok = '<span class="badge badge-pill badge-danger"> You are required to enter OK quantity!</span>';
				  }else{
				  $qty_actual = TRUE;
				  } 
				  
	   
	   
	   if($qty_actual && $time1 && $time2 && $date1)
	   {
		   
	   $qty_actual = $_POST["qty_actual"];
       $date1 = $_POST["date1"];
       $time1 = $_POST["time1"]; 
       $time2 = $_POST["time2"];
	   $material_no = $_POST["material_no"];
	   $back_no = $_POST["back_no"];
	   
	             $ddF = substr($_POST["date1"],0,2);
				 $mmF = substr($_POST["date1"],3,2);
				 $yyF = substr($_POST["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
		
    $t_time = (($_POST["time1"]).":".($_POST["time2"]));  
	
	
	$ref = "";
	
	      $query_shtA = "SELECT * FROM shift_detail WHERE id_shift = '1'";
		  $result_shtA = mysqli_query($dbc,$query_shtA);
		  $data_shtA = mysqli_fetch_array($result_shtA); 
		  
		 //----shift posting ----
		 
		 if(($t_time >= $data_shtA["time_start"]) && ($t_time <= $data_shtA["time_end"]))
		 {
			 
		 $shif_pA = "D/S"; 
		 
		 }else
		 {
		 
		 $shif_pA = "N/S"; 
		
		 }	 
  
  //------generate Backflush OK No.---------------------------------
  
    if($data_scan["scan_plant"] == '3100')
	{
	
	$query_id = "SELECT * FROM run_count_itsb WHERE uid = '11'";
	$result_id = mysqli_query($dbc,$query_id);
	
	}elseif($data_scan["scan_plant"] == '3101')
	{
		
	$query_id = "SELECT * FROM run_count_itsb WHERE uid = '66'";
	$result_id = mysqli_query($dbc,$query_id);	
		
	}
	if ($result_id) 
{
	$nrows = mysqli_num_rows($result_id);
	$row_id = mysqli_fetch_array($result_id);
	
	$dht = 00000; 
	$dht_OK = "211";
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
  
	
	
	 /*     if($result_data2)
		  {*/
			  
			  
  //update count_max----------------------------------------
  
    if($data_scan["scan_plant"] == '3100')
	{     
		
       $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '11'";
	   $result_max_a = mysqli_query($dbc,$query_max_a);
	   
	}elseif($data_scan["scan_plant"] == '3101')
	{
	   $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '66'";
	   $result_max_a = mysqli_query($dbc,$query_max_a);
		
		
	}
   //end update count_max ---------------------------------	
	
	//-----date latest or date plan current date-----------------------------------
	
	//if($data_scan["date_create"]
	

	
	
	
	 if($data_scan["material_no"] == "N/A")
	    { 
		
	 //--------- pps detail ------------

	   $query_pps = "SELECT * FROM pps_detail WHERE material_no = '".sql_esc($material_no)."' AND back_no = '".sql_esc($back_no)."' AND ((date_plan = '".sql_esc($date1_final)."' AND (shift_pps1 = '".sql_esc($shif_pA)."' OR shift_pps2 = '".sql_esc($shif_pA)."')) AND status_pps != '".sql_esc($rst_sta4["status_desc"])."' AND status_pps != '".sql_esc($rst_sta13["status_desc"])."'";
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
				
		
	
	$query_upd_scan = "UPDATE sc_prd_planning_ok SET plan_no = '".sql_esc($data_pps["plan_no"])."', work_center = '".sql_esc($data_pps["work_center"])."', model_code = '".sql_esc($data_pps["model_code"])."', kanban_no = '".sql_esc($data_pps["kanban_no"])."', scan_shift = '".sql_esc($shif_pA)."', scan_date_plan = '".sql_esc($date1_final)."', material_no = '".sql_esc($material_no)."', material_desc = '".sql_esc($ans3A["material_desc"])."',  back_no = '".sql_esc($back_no)."', material_type = '".sql_esc($data_mtype["mat_type_id"])."', scan_date_plan = '".sql_esc($date1_final)."', scan_qty = '".sql_esc($qty_actual)."', scan_uom = '".sql_esc($ans3A["BUn"])."' WHERE id_scan = '".sql_esc($uid2)."'";
	$result_upd_scan = mysqli_query($dbc,$query_upd_scan);			
					
	   //----------find posting log depend material type

	  
	  if(($data_pps["material_type"] == "Z301") && ($data_pps["plan_category"] == "ASSY"))
	  {
		$ploc = "S130";  
		  
	  }elseif(($data_pps["material_type"] == "Z301") && ($data_pps["plan_category"] == "STM"))
	  {
		$ploc = "S130";  
		  
	  }elseif(($data_pps["material_type"] == "Z201")  && ($data_pps["plan_category"] == "ASSY"))
	  {
		$ploc = "S120";
	  }elseif(($data_pps["material_type"] == "Z201")  && ($data_pps["plan_category"] == "STM"))
	  {
		$ploc = "S120";
	  }elseif(($data_pps["material_type"] == "Z301")  && ($data_pps["plan_category"] == "BLK"))
	  {
		$ploc = "S130";
		
	  }elseif(($data_pps["material_type"] == "Z101")  && ($data_pps["plan_category"] == "BLK"))
	  {
		$ploc = "S110";
	  }else{
		
		$ploc = "";
	  }
	  

	  
	  
	 //insert into table pps_detail_transaction-------------
	
$query_data2 = "INSERT INTO pps_detail_trn_fg_ok (id,pps_id,ref_id,bflush_no,plan_no,id_scan,upload_id,model_code,month_plan,material_no,material_desc,material_type,qty_plan,qty_actual,qty_balance,qty_NG,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,status,user_upload,date_upload,user_create,date_create,user_update,date_update,user_posting,date_posting,time_posting,ploc,delivery_loc,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,status_ftp_bflush,bflush_no_ref,user_cancel,date_cancel,remark_cancel,plant_code,shift_posting,stamp_ind,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($data_pps["id"])."','".sql_esc($data_pps["ref_id"])."','".sql_esc($ref)."','".sql_esc($data_pps["plan_no"])."','".sql_esc($uid2)."','".sql_esc($data_pps["upload_id"])."','".sql_esc($data_pps["model_code"])."','".sql_esc($data_pps["month_plan"])."','".sql_esc($data_pps["material_no"])."','".sql_esc($ans3A["material_desc"])."','".sql_esc($data_pps["material_type"])."','".sql_esc($data_pps["qty_plan"])."','".sql_esc($qty_actual)."','','','".sql_esc($rst_sta6["status_desc"])."','".sql_esc($data_pps["plant_code"])."','".sql_esc($data_pps["work_center"])."','".sql_esc($data_pps["shift_pps1"])."','".sql_esc($data_pps["shift_pps2"])."','".sql_esc($data_pps["date_plan"])."','Y','".sql_esc($data_pps["user_upload"])."','".sql_esc($data_pps["date_upload"])."','".sql_esc($username)."',NOW(),'','','".sql_esc($username)."','".sql_esc($date1_final)."','".sql_esc($t_time)."','".sql_esc($ploc)."','','','','','','','','','Y','','','','','".sql_esc($data_pps["plant_code"])."','','".sql_esc($data_pps["plan_category"])."','".sql_esc($data_pps["back_no"])."','".sql_esc($data_pps["kanban_no"])."','','')";
$result_data2 = mysqli_query($dbc,$query_data2);
 
  //-------------------update---------------------
  
      $query_all_info = "SELECT * FROM pps_detail_trn_fg_ok WHERE id = '".mysqli_insert_id($dbc)."'";
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
	$query_upd_detail2 = "UPDATE pps_detail_trn_fg_ok SET shift_posting = '".sql_esc($shif_p)."' WHERE id = '".sql_esc($data_all_info["id"])."'";
	$result_upd_detail2 = mysqli_query($dbc,$query_upd_detail2);  
	
	
	 //----edit by azie 17 nov 2021 night shift ------	
  
  
	$query_upd_shift = "SELECT * FROM pps_detail_trn_fg_ok WHERE id = '".sql_esc($data_all_info["id"])."'";
    $result_upd_shift = mysqli_query($dbc,$query_upd_shift);
	$row_upd_shift = mysqli_fetch_array($result_upd_shift);
	
	
	if(($row_upd_shift["shift_posting"] == "N/S") && ($row_upd_shift["date_posting"] == $currentdate))
	{
	
	$prev_date = date('Y-m-d', strtotime($currentdate .' -1 day'));	
	
	if(($row_upd_shift["time_posting"] > "20:00:00" ) && ($row_upd_shift["time_posting"] < "23:59:59" ))
	{
		
	}else{
		
	$query_upd_shift2 = "UPDATE pps_detail_trn_fg_ok SET date_posting = '".sql_esc($prev_date)."' WHERE id = '".sql_esc($row_upd_shift["id"])."'";
	$result_upd_shift2 = mysqli_query($dbc,$query_upd_shift2);  	
		
	}
	}
	

	
  //-------insert table print_tag_backflush [generate print tag] ---------------	
	
	$query_tag = "SELECT * FROM pps_detail_trn_fg_ok WHERE id = '".sql_esc($data_all_info["id"])."'";
    $result_tag = mysqli_query($dbc,$query_tag);

  $no_tg = 1;
  
while($row = mysqli_fetch_array($result_tag))
{
		
	  $dl_qty = (intval($row["qty_actual"]));
	  
	  //----detail standard packaging [ambil dari table mat_master_header]
	  
	   $query_pack = "SELECT std_packaging, type_package, BUn FROM table_material_itsb WHERE material_no = '".sql_esc($row["material_no"])."'";
	   $result_pack = mysqli_query($dbc,$query_pack);
	   $data_pack = mysqli_fetch_array($result_pack);
		
		
		        if(($data_pack["std_packaging"] == "") || ($data_pack["std_packaging"] == "0"))
		        {
		
		        $st_pack = (intval($row["qty_actual"]));
	         
	   
	          	}elseif(($data_pack["std_packaging"] == "") || ($data_pack["type_package"] == ""))
		        {
		
		        $st_pack = (intval($row["qty_actual"]));
	            
				}else{
		
                $st_pack = (intval($data_pack["std_packaging"]));
				
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
	
	 $b =  intval($bil_tag);
	 
	   if($b == 1)
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
	
	     $bil_tag_newA = (($dl_qty)/($st_pack));
           
		    if(($bil_tag_newA > '1.000') && ($bil_tag_newA < '1.999'))
		   {
			   
		
       $query_tag3 = "INSERT INTO print_tag_bf_ok(id_tag,tag_no,id_tran,bflush_no,plan_no,rev_plan_no,material_no,material_desc,tag_qty,shift_tag,tag_uom,ploc,station_loc,model_code,pack_type,pack_no,posting_by,posting_date,posting_time,user_create,date_create,status_tag,status_print,month_plan,year_plan,slip_no,total_slip,plant_cd,status_bf,stamp_ind,material_type,back_no,kanban_no)  VALUES('','','".sql_esc($row["id"])."','".sql_esc($row["bflush_no"])."','".sql_esc($row["plan_no"])."','','".sql_esc($row["material_no"])."','".sql_esc($row["material_desc"])."','".sql_esc($st_pack)."','".sql_esc($row["shift_posting"])."','".sql_esc($data_pack["BUn"])."','".sql_esc($row["ploc"])."','".sql_esc($row["work_center"])."','".sql_esc($row["model_code"])."','".sql_esc($data_pack["type_package"])."','".sql_esc($data_pack["std_packaging"])."','".sql_esc($username)."','".sql_esc($row["date_posting"])."','".sql_esc($row["time_posting"])."','".sql_esc($username)."',NOW(),'N','N','".sql_esc($row["month_plan"])."',NOW(),'".sql_esc($w)."','2','".sql_esc($row["plant_code"])."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($row["stamp_ind"])."','".sql_esc($row["material_type"])."','".sql_esc($row["back_no"])."','".sql_esc($row["kanban_no"])."')";
	   $result_tag3 = mysqli_query($dbc,$query_tag3);
	   
	     $tag_no = ($row["bflush_no"].'/'.$w.'/'.$data_pack["std_packaging"].'/'.$no_tg);
		
		 
		 $query_tag3_t = "UPDATE print_tag_bf_ok SET tag_no = '".sql_esc($tag_no)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND bflush_no = '".sql_esc($ref)."'";
	     $result_tag3_t = mysqli_query($dbc,$query_tag3_t);	   
			   
		   
		   }else{
	 
       $query_tag3 = "INSERT INTO print_tag_bf_ok(id_tag,tag_no,id_tran,bflush_no,plan_no,rev_plan_no,material_no,material_desc,tag_qty,shift_tag,tag_uom,ploc,station_loc,model_code,pack_type,pack_no,posting_by,posting_date,posting_time,user_create,date_create,status_tag,status_print,month_plan,year_plan,slip_no,total_slip,plant_cd,status_bf,stamp_ind,material_type,back_no,kanban_no)  VALUES('','','".sql_esc($row["id"])."','".sql_esc($row["bflush_no"])."','".sql_esc($row["plan_no"])."','','".sql_esc($row["material_no"])."','".sql_esc($row["material_desc"])."','".sql_esc($st_pack)."','".sql_esc($row["shift_posting"])."','".sql_esc($data_pack["BUn"])."','".sql_esc($row["ploc"])."','".sql_esc($row["work_center"])."','".sql_esc($row["model_code"])."','".sql_esc($data_pack["type_package"])."','".sql_esc($data_pack["std_packaging"])."','".sql_esc($username)."','".sql_esc($row["date_posting"])."','".sql_esc($row["time_posting"])."','".sql_esc($username)."',NOW(),'N','N','".sql_esc($row["month_plan"])."',NOW(),'".sql_esc($w)."','".sql_esc($no_tg)."','".sql_esc($row["plant_code"])."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($row["stamp_ind"])."','".sql_esc($row["material_type"])."','".sql_esc($row["back_no"])."','".sql_esc($row["kanban_no"])."')";
	   $result_tag3 = mysqli_query($dbc,$query_tag3);
	   
	     $tag_no = ($row["bflush_no"].'/'.$w.'/'.$data_pack["std_packaging"].'/'.$no_tg);
		
		 
		 $query_tag3_t = "UPDATE print_tag_bf_ok SET tag_no = '".sql_esc($tag_no)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND bflush_no = '".sql_esc($ref)."'";
	     $result_tag3_t = mysqli_query($dbc,$query_tag3_t);
		 
		 
		   }
	   
     $w++; 
	
	 
	 } // end for loop
	 
	  if(($last_tag > 0) || ($dl_qty < ($st_pack))){	   // kalau qty lebih kecil drpd std packaging and baki drpd bahagi tag
	  
	  
	        $bil_tag_new = (($dl_qty)/($st_pack));
           
		    if(($bil_tag_new > '1.000') && ($bil_tag_new < '1.999'))
		   {
			   
		$query_tag2 = "INSERT INTO print_tag_bf_ok(id_tag,tag_no,id_tran,bflush_no,plan_no,rev_plan_no,material_no,material_desc,tag_qty, shift_tag,tag_uom,ploc,station_loc,model_code,pack_type,pack_no,posting_by,posting_date,posting_time,user_create,date_create,status_tag,status_print,month_plan,year_plan,slip_no,total_slip,plant_cd,status_bf,stamp_ind,material_type,back_no,kanban_no)  VALUES('','','".sql_esc($row["id"])."','".sql_esc($row["bflush_no"])."','".sql_esc($row["plan_no"])."','','".sql_esc($row["material_no"])."','".sql_esc($row["material_desc"])."','".sql_esc($bil_tag3)."','".sql_esc($row["shift_posting"])."','".sql_esc($data_pack["BUn"])."','".sql_esc($row["ploc"])."','".sql_esc($row["work_center"])."','".sql_esc($row["model_code"])."','".sql_esc($data_pack["type_package"])."','".sql_esc($data_pack["std_packaging"])."','".sql_esc($username)."','".sql_esc($row["date_posting"])."','".sql_esc($row["time_posting"])."','".sql_esc($username)."',NOW(),'N','N','".sql_esc($row["month_plan"])."',NOW(),'".sql_esc($w)."','2','".sql_esc($row["plant_code"])."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($row["stamp_ind"])."','".sql_esc($row["material_type"])."','".sql_esc($row["back_no"])."','".sql_esc($row["kanban_no"])."')"; 
	    $result_tag2 = mysqli_query($dbc,$query_tag2);
       
	     $tag_no2 = ($row["bflush_no"].'/'.$w.'/'.$bil_tag3.'/'.($b + 1));
		 
		 $query_tag2_t = "UPDATE print_tag_bf_ok SET tag_no = '".sql_esc($tag_no2)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND bflush_no = '".sql_esc($ref)."'";
	     $result_tag2_t = mysqli_query($dbc,$query_tag2_t);   
			   
			      
		   }else{
	 
	    $query_tag2 = "INSERT INTO print_tag_bf_ok(id_tag,tag_no,id_tran,bflush_no,plan_no,rev_plan_no,material_no,material_desc,tag_qty, shift_tag,tag_uom,ploc,station_loc,model_code,pack_type,pack_no,posting_by,posting_date,posting_time,user_create,date_create,status_tag,status_print,month_plan,year_plan,slip_no,total_slip,plant_cd,status_bf,stamp_ind,material_type,back_no,kanban_no)  VALUES('','','".sql_esc($row["id"])."','".sql_esc($row["bflush_no"])."','".sql_esc($row["plan_no"])."','','".sql_esc($row["material_no"])."','".sql_esc($row["material_desc"])."','".sql_esc($bil_tag3)."','".sql_esc($row["shift_posting"])."','".sql_esc($data_pack["BUn"])."','".sql_esc($row["ploc"])."','".sql_esc($row["work_center"])."','".sql_esc($row["model_code"])."','".sql_esc($data_pack["type_package"])."','".sql_esc($data_pack["std_packaging"])."','".sql_esc($username)."','".sql_esc($row["date_posting"])."','".sql_esc($row["time_posting"])."','".sql_esc($username)."',NOW(),'N','N','".sql_esc($row["month_plan"])."',NOW(),'".sql_esc($w)."','".sql_esc($no_tg)."','".sql_esc($row["plant_code"])."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($row["stamp_ind"])."','".sql_esc($row["material_type"])."','".sql_esc($row["back_no"])."','".sql_esc($row["kanban_no"])."')"; 
	    $result_tag2 = mysqli_query($dbc,$query_tag2);
       
	     $tag_no2 = ($row["bflush_no"].'/'.$w.'/'.$bil_tag3.'/'.($b + 1));
		 
		 $query_tag2_t = "UPDATE print_tag_bf_ok SET tag_no = '".sql_esc($tag_no2)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND bflush_no = '".sql_esc($ref)."'";
	     $result_tag2_t = mysqli_query($dbc,$query_tag2_t);
	   
	   
		   }
		   
		   
	   
		 }// end if
	
	 
	  }// end while loop

 
					 
				 }else{
			
				  echo "<script>";
				  echo "alert('ERROR! Please Scan Kanban QR Code. Planning not exist');";
				  echo "window.location='confirm_backflushProc.php?uid2=$uid2'";
				  echo "</script>";
				  exit(); //quit the script
			 
				 }
	   
	     }  // $data_scan["material_no"] == "N/A")
	   else{
		   
	     //---shift detail ------
	
	  $query_sht_checking = "SELECT * FROM shift_detail WHERE id_shift = '1'";
	  $result_sht_checking = mysqli_query($dbc,$query_sht_checking);
	  $data_sht_checking = mysqli_fetch_array($result_sht_checking); 
	  
	 //----shift posting ----
	 $prev_date = date('Y-m-d', strtotime($currentdate .' -1 day'));
	 
	 if(($masa >= $data_sht_checking["time_start"]) && ($masa <= $data_sht_checking["time_end"]))
	 {
		 
     $date_baru = $date1_final;
	
	 
	 }else
	 {
	    if(($masa >= '00:00:00') && ($masa <= '07:59:00'))
	   {
	    $date_baru = $prev_date; 
	   }else{
		   
		 $date_baru = $date1_final;   
	   }
	
	 }
	 

	 //--------- pps detail ------------
	 
	   $query_pps = "SELECT * FROM pps_detail WHERE material_no = '".sql_esc($data_scan["material_no"])."' AND back_no = '".sql_esc($data_scan["back_no"])."' AND date_plan = '".sql_esc($date_baru)."' AND (shift_pps1 = '".sql_esc($shif_pA)."' OR shift_pps2 = '".sql_esc($shif_pA)."') AND status_pps != '".sql_esc($rst_sta4["status_desc"])."' AND status_pps != '".sql_esc($rst_sta13["status_desc"])."'";
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
	 
	   
	  //----------find posting log depend material type
	  
	  if(($data_pps["material_type"] == "Z301") && ($data_pps["plan_category"] == "ASSY"))
	  {
		$ploc = "S130";  
		  
	  }elseif(($data_pps["material_type"] == "Z301") && ($data_pps["plan_category"] == "STM"))
	  {
		$ploc = "S130";  
		  
	  }elseif(($data_pps["material_type"] == "Z201")  && ($data_pps["plan_category"] == "ASSY"))
	  {
		$ploc = "S120";
	  }elseif(($data_pps["material_type"] == "Z201")  && ($data_pps["plan_category"] == "STM"))
	  {
		$ploc = "S120";
	  }elseif(($data_pps["material_type"] == "Z301")  && ($data_pps["plan_category"] == "BLK"))
	  {
		$ploc = "S130";
		
	  }elseif(($data_pps["material_type"] == "Z101")  && ($data_pps["plan_category"] == "BLK"))
	  {
		$ploc = "S110";
	  }else{
		
		$ploc = "";
	  }
	  
	        if($data_pps["plan_no"]  > 0)
	        {
				
	  
    $query_upd_scan = "UPDATE sc_prd_planning_ok SET plan_no = '".sql_esc($data_pps["plan_no"])."', scan_shift = '".sql_esc($shif_pA)."', scan_date_plan = '".sql_esc($date1_final)."', material_no = '".sql_esc($material_no)."', material_desc = '".sql_esc($ans3A["material_desc"])."',  back_no = '".sql_esc($back_no)."', material_type = '".sql_esc($data_mtype["mat_type_id"])."', scan_date_plan = '".sql_esc($date1_final)."', scan_qty = '".sql_esc($qty_actual)."', scan_uom = '".sql_esc($ans3A["BUn"])."' WHERE id_scan = '".sql_esc($uid2)."'";
	$result_upd_scan = mysqli_query($dbc,$query_upd_scan);	
	  
	  
	 //insert into table pps_detail_transaction-------------
	
$query_data2 = "INSERT INTO pps_detail_trn_fg_ok (id,pps_id,ref_id,bflush_no,plan_no,id_scan,upload_id,model_code,month_plan,material_no,material_desc,material_type,qty_plan,qty_actual,qty_balance,qty_NG,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,status,user_upload,date_upload,user_create,date_create,user_update,date_update,user_posting,date_posting,time_posting,ploc,delivery_loc,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,status_ftp_bflush,bflush_no_ref,user_cancel,date_cancel,remark_cancel,plant_code,shift_posting,stamp_ind,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($data_pps["id"])."','".sql_esc($data_pps["ref_id"])."','".sql_esc($ref)."','".sql_esc($data_pps["plan_no"])."','".sql_esc($uid2)."','".sql_esc($data_pps["upload_id"])."','".sql_esc($data_pps["model_code"])."','".sql_esc($data_pps["month_plan"])."','".sql_esc($data_pps["material_no"])."','".sql_esc($ans3A["material_desc"])."','".sql_esc($data_pps["material_type"])."','".sql_esc($data_pps["qty_plan"])."','".sql_esc($qty_actual)."','','','".sql_esc($rst_sta6["status_desc"])."','".sql_esc($data_pps["plant_code"])."','".sql_esc($data_pps["work_center"])."','".sql_esc($data_pps["shift_pps1"])."','".sql_esc($data_pps["shift_pps2"])."','".sql_esc($data_pps["date_plan"])."','Y','".sql_esc($data_pps["user_upload"])."','".sql_esc($data_pps["date_upload"])."','".sql_esc($username)."',NOW(),'','','".sql_esc($username)."','".sql_esc($date1_final)."','".sql_esc($t_time)."','".sql_esc($ploc)."','','','','','','','','','Y','','','','','".sql_esc($data_pps["plant_code"])."','','".sql_esc($data_pps["plan_category"])."','".sql_esc($data_pps["back_no"])."','".sql_esc($data_pps["kanban_no"])."','','')";
$result_data2 = mysqli_query($dbc,$query_data2);
 
  //-------------------update---------------------
  
      $query_all_info = "SELECT * FROM pps_detail_trn_fg_ok WHERE id = '".mysqli_insert_id($dbc)."'";
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
	$query_upd_detail2 = "UPDATE pps_detail_trn_fg_ok SET shift_posting = '".sql_esc($shif_p)."' WHERE id = '".sql_esc($data_all_info["id"])."'";
	$result_upd_detail2 = mysqli_query($dbc,$query_upd_detail2); 
	
	
	 //----edit by azie 17 nov 2021 night shift ------	
  
  
	$query_upd_shift = "SELECT * FROM pps_detail_trn_fg_ok WHERE id = '".sql_esc($data_all_info["id"])."'";
    $result_upd_shift = mysqli_query($dbc,$query_upd_shift);
	$row_upd_shift = mysqli_fetch_array($result_upd_shift);
	
	
	if(($row_upd_shift["shift_posting"] == "N/S") && ($row_upd_shift["date_posting"] == $currentdate))
	{
	
	$prev_date = date('Y-m-d', strtotime($currentdate .' -1 day'));	
	
	if(($row_upd_shift["time_posting"] > "20:00:00" ) && ($row_upd_shift["time_posting"] < "23:59:59" ))
	{
		
	}else{
		
	$query_upd_shift2 = "UPDATE pps_detail_trn_fg_ok SET date_posting = '".sql_esc($prev_date)."' WHERE id = '".sql_esc($row_upd_shift["id"])."'";
	$result_upd_shift2 = mysqli_query($dbc,$query_upd_shift2);  	
	
	 }
	}
	
	
  //-------insert table print_tag_backflush [generate print tag] ---------------	
	
	$query_tag = "SELECT * FROM pps_detail_trn_fg_ok WHERE id = '".sql_esc($data_all_info["id"])."'";
    $result_tag = mysqli_query($dbc,$query_tag);

  $no_tg = 1;
  
while($row = mysqli_fetch_array($result_tag))
{
		
	  $dl_qty = (intval($row["qty_actual"]));
	  
	  //----detail standard packaging [ambil dari table mat_master_header]
	  
	   $query_pack = "SELECT std_packaging, type_package, BUn FROM table_material_itsb WHERE material_no = '".sql_esc($row["material_no"])."'";
	   $result_pack = mysqli_query($dbc,$query_pack);
	   $data_pack = mysqli_fetch_array($result_pack);
	   
	             if(($data_pack["std_packaging"] == "") || ($data_pack["std_packaging"] == "0"))
		        {
		
		        $st_pack = (intval($row["qty_actual"]));
	         
	   
	          	}elseif(($data_pack["std_packaging"] == "") || ($data_pack["type_package"] == ""))
		        {
		
		        $st_pack = (intval($row["qty_actual"]));
	            
				}else{
		
                $st_pack = (intval($data_pack["std_packaging"]));
				
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
	
	 $b =  intval($bil_tag);
	 
	   if($b == 1)
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
		     $bil_tag_newA = (($dl_qty)/($st_pack));
           
		    if(($bil_tag_newA > '1.000') && ($bil_tag_newA < '1.999'))
		   {
			   
		
       $query_tag3 = "INSERT INTO print_tag_bf_ok(id_tag,tag_no,id_tran,bflush_no,plan_no,rev_plan_no,material_no,material_desc,tag_qty,shift_tag,tag_uom,ploc,station_loc,model_code,pack_type,pack_no,posting_by,posting_date,posting_time,user_create,date_create,status_tag,status_print,month_plan,year_plan,slip_no,total_slip,plant_cd,status_bf,stamp_ind,material_type,back_no,kanban_no)  VALUES('','','".sql_esc($row["id"])."','".sql_esc($row["bflush_no"])."','".sql_esc($row["plan_no"])."','','".sql_esc($row["material_no"])."','".sql_esc($row["material_desc"])."','".sql_esc($st_pack)."','".sql_esc($row["shift_posting"])."','".sql_esc($data_pack["BUn"])."','".sql_esc($row["ploc"])."','".sql_esc($row["work_center"])."','".sql_esc($row["model_code"])."','".sql_esc($data_pack["type_package"])."','".sql_esc($data_pack["std_packaging"])."','".sql_esc($username)."','".sql_esc($row["date_posting"])."','".sql_esc($row["time_posting"])."','".sql_esc($username)."',NOW(),'N','N','".sql_esc($row["month_plan"])."',NOW(),'".sql_esc($w)."','2','".sql_esc($row["plant_code"])."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($row["stamp_ind"])."','".sql_esc($row["material_type"])."','".sql_esc($row["back_no"])."','".sql_esc($row["kanban_no"])."')";
	   $result_tag3 = mysqli_query($dbc,$query_tag3);
	   
	     $tag_no = ($row["bflush_no"].'/'.$w.'/'.$data_pack["std_packaging"].'/'.$no_tg);
		
		 
		 $query_tag3_t = "UPDATE print_tag_bf_ok SET tag_no = '".sql_esc($tag_no)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND bflush_no = '".sql_esc($ref)."'";
	     $result_tag3_t = mysqli_query($dbc,$query_tag3_t);	   
			   
		   
		   }else{
	 
       $query_tag3 = "INSERT INTO print_tag_bf_ok(id_tag,tag_no,id_tran,bflush_no,plan_no,rev_plan_no,material_no,material_desc,tag_qty,shift_tag,tag_uom,ploc,station_loc,model_code,pack_type,pack_no,posting_by,posting_date,posting_time,user_create,date_create,status_tag,status_print,month_plan,year_plan,slip_no,total_slip,plant_cd,status_bf,stamp_ind,material_type,back_no,kanban_no)  VALUES('','','".sql_esc($row["id"])."','".sql_esc($row["bflush_no"])."','".sql_esc($row["plan_no"])."','','".sql_esc($row["material_no"])."','".sql_esc($row["material_desc"])."','".sql_esc($st_pack)."','".sql_esc($row["shift_posting"])."','".sql_esc($data_pack["BUn"])."','".sql_esc($row["ploc"])."','".sql_esc($row["work_center"])."','".sql_esc($row["model_code"])."','".sql_esc($data_pack["type_package"])."','".sql_esc($data_pack["std_packaging"])."','".sql_esc($username)."','".sql_esc($row["date_posting"])."','".sql_esc($row["time_posting"])."','".sql_esc($username)."',NOW(),'N','N','".sql_esc($row["month_plan"])."',NOW(),'".sql_esc($w)."','".sql_esc($no_tg)."','".sql_esc($row["plant_code"])."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($row["stamp_ind"])."','".sql_esc($row["material_type"])."','".sql_esc($row["back_no"])."','".sql_esc($row["kanban_no"])."')";
	   $result_tag3 = mysqli_query($dbc,$query_tag3);
	   
	     $tag_no = ($row["bflush_no"].'/'.$w.'/'.$data_pack["std_packaging"].'/'.$no_tg);
		
		 
		 $query_tag3_t = "UPDATE print_tag_bf_ok SET tag_no = '".sql_esc($tag_no)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND bflush_no = '".sql_esc($ref)."'";
	     $result_tag3_t = mysqli_query($dbc,$query_tag3_t);
		 
		 
		   }
	   
     $w++; 
	
	 
	 } // end for loop
	 
	  if(($last_tag > 0) || ($dl_qty < ($st_pack))){	   // kalau qty lebih kecil drpd std packaging and baki drpd bahagi tag
	 
	       $bil_tag_new = (($dl_qty)/($st_pack));
           
		    if(($bil_tag_new > '1.000') && ($bil_tag_new < '1.999'))
		   {
			   
		 $query_tag2 = "INSERT INTO print_tag_bf_ok(id_tag,tag_no,id_tran,bflush_no,plan_no,rev_plan_no,material_no,material_desc,tag_qty, shift_tag,tag_uom,ploc,station_loc,model_code,pack_type,pack_no,posting_by,posting_date,posting_time,user_create,date_create,status_tag,status_print,month_plan,year_plan,slip_no,total_slip,plant_cd,status_bf,stamp_ind,material_type,back_no,kanban_no)  VALUES('','','".sql_esc($row["id"])."','".sql_esc($row["bflush_no"])."','".sql_esc($row["plan_no"])."','','".sql_esc($row["material_no"])."','".sql_esc($row["material_desc"])."','".sql_esc($bil_tag3)."','".sql_esc($row["shift_posting"])."','".sql_esc($data_pack["BUn"])."','".sql_esc($row["ploc"])."','".sql_esc($row["work_center"])."','".sql_esc($row["model_code"])."','".sql_esc($data_pack["type_package"])."','".sql_esc($data_pack["std_packaging"])."','".sql_esc($username)."','".sql_esc($row["date_posting"])."','".sql_esc($row["time_posting"])."','".sql_esc($username)."',NOW(),'N','N','".sql_esc($row["month_plan"])."',NOW(),'".sql_esc($w)."','2','".sql_esc($row["plant_code"])."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($row["stamp_ind"])."','".sql_esc($row["material_type"])."','".sql_esc($row["back_no"])."','".sql_esc($row["kanban_no"])."')"; 
	     $result_tag2 = mysqli_query($dbc,$query_tag2);
       
	     $tag_no2 = ($row["bflush_no"].'/'.$w.'/'.$bil_tag3.'/'.($b + 1));
		 
		 $query_tag2_t = "UPDATE print_tag_bf_ok SET tag_no = '".sql_esc($tag_no2)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND bflush_no = '".sql_esc($ref)."'";
	     $result_tag2_t = mysqli_query($dbc,$query_tag2_t);   
			   
		   }else{
	 
	    $query_tag2 = "INSERT INTO print_tag_bf_ok(id_tag,tag_no,id_tran,bflush_no,plan_no,rev_plan_no,material_no,material_desc,tag_qty, shift_tag,tag_uom,ploc,station_loc,model_code,pack_type,pack_no,posting_by,posting_date,posting_time,user_create,date_create,status_tag,status_print,month_plan,year_plan,slip_no,total_slip,plant_cd,status_bf,stamp_ind,material_type,back_no,kanban_no)  VALUES('','','".sql_esc($row["id"])."','".sql_esc($row["bflush_no"])."','".sql_esc($row["plan_no"])."','','".sql_esc($row["material_no"])."','".sql_esc($row["material_desc"])."','".sql_esc($bil_tag3)."','".sql_esc($row["shift_posting"])."','".sql_esc($data_pack["BUn"])."','".sql_esc($row["ploc"])."','".sql_esc($row["work_center"])."','".sql_esc($row["model_code"])."','".sql_esc($data_pack["type_package"])."','".sql_esc($data_pack["std_packaging"])."','".sql_esc($username)."','".sql_esc($row["date_posting"])."','".sql_esc($row["time_posting"])."','".sql_esc($username)."',NOW(),'N','N','".sql_esc($row["month_plan"])."',NOW(),'".sql_esc($w)."','".sql_esc($no_tg)."','".sql_esc($row["plant_code"])."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($row["stamp_ind"])."','".sql_esc($row["material_type"])."','".sql_esc($row["back_no"])."','".sql_esc($row["kanban_no"])."')"; 
	    $result_tag2 = mysqli_query($dbc,$query_tag2);
       
	    $tag_no2 = ($row["bflush_no"].'/'.$w.'/'.$bil_tag3.'/'.($b + 1));
		 
		$query_tag2_t = "UPDATE print_tag_bf_ok SET tag_no = '".sql_esc($tag_no2)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND bflush_no = '".sql_esc($ref)."'";
	    $result_tag2_t = mysqli_query($dbc,$query_tag2_t);
	   
		   }
	   
	   
	   
		 }// end if
	
	 
	  }// end while loop	
	  
	  
	      }else{
			
				  echo "<script>";
				  echo "alert('ERROR! Please Scan Kanban QR Code. Planning not exist');";
				  echo "window.location='confirm_backflushProc.php?uid2=$uid2'";
				  echo "</script>";
				  exit(); //quit the script
			 
				 }
	  
	  
	  
	  

	   }// end else if NA
	
 //------- crete text file to SAP [FromPortal] -----------

			  
		   $ref11 =	base64_encode($ref);
		   $uid22 =	base64_encode($uid2);	  
	
	       echo "<script>";
		   echo "window.location='confirm_backflushProc-pr2.php?buid=$ref11&&uid=$uid22'";
	       echo "</script>"; 
		   exit(); //quit the script
		   

	   }
	   
	// mysql_close();  
	   
  //print the message if there is one.
if (isset($message))
{ echo '<div class="msg msg-error"><font color="red" class ="error_entry">', $message, '</font></div>';
}
  
} // end if

   //------------------------------------------------------------------------------

		 $no = 1; 
		 
		 //------------plant code detail -------------
		 
		 $query_plant = "SELECT * FROM plant_detail WHERE plant_code = '".sql_esc($data_scan["plant_cd"])."'";
		 $result_plant = mysqli_query($dbc,$query_plant);
	     $data_plant = mysqli_fetch_array($result_plant);
		  
		
		  
		  ?>        
        <form name="myform" method="post" action="confirm_backflushProc.php?uid2=<?php echo $uid2; ?>">
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
     
               <table width="98%" align="right" >
               <tr>
                 <td><p>Please enter backflush output quantity for OK</p>
                   <table width="99%" class="table table-bordered">
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
                  <option value="<?php echo $row39["material_no"]; ?>" >(<?php echo $row39["back_no"]; ?>)&nbsp;<?php echo $row39["material_no"]; ?> - <?php echo $row39["material_desc"]; ?> </option>
                
                <?php     }
                
                ?>
            </select>
          
            <input class="form-control" id="back_no" type="hidden"  name="back_no" value="<?php echo $data_scan["back_no"]; ?>" />  
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
                  <option value="<?php echo $row39A["material_no"]; ?>" >(<?php echo $row39A["back_no"]; ?>)&nbsp;<?php echo $row39A["material_no"]; ?> - <?php echo $row39A["material_desc"]; ?></option>
                
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
                       <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php if(isset($_POST['date1'])){ echo $_POST['date1']; }else{ echo $fmt_curr_date; } ?>" /> 
                     </td>
                    </tr>
                     <tr>
              <td>Posting Time </td>
                     <td>:</td>
                     <td width="40%">Hours<select name="time1" id="time1" class="form-control form-control-sm timepicker">
                       <?php if($_POST["con_bfok"] == true)
		{  
		?>
                       <option value="<?php echo $_POST["time1"]; ?>"><?php echo sprintf('%02d', $_POST["time1"]);	 ?></option>
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
                       <?php if($_POST["con_bfok"] == true)  
		{  
		?>
                       <option value="<?php echo $_POST["time2"]; ?>"><?php echo sprintf('%02d', $_POST["time2"]);	 ?></option>
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
                     <td>Enter OK Quantity</td>
                     <td>:</td>
                     <td colspan="2"><input name="qty_actual" type="number" min="1" value="<?php if(isset($_POST["qty_actual"])) { echo $_POST["qty_actual"]; } ?>" class="form-control"/><div class="form-control-feedback" ><?php echo $message_qok; ?></div></td>
                      </tr>  
                  
                  </table></td>
               </tr>
             </table>
               <br>           
                   <table>          
                   <tr>
                     <td>
                     &nbsp;<input name="con_bfok" type="submit" id="con_bfok" value="SUBMIT" class="btn btn-success btn-sm" ></td>
                      <td>&nbsp;</td>
                      <td width="40%">&nbsp;</td>
                      <td width="40%">&nbsp;</td>
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
	
	function getFactory(factory) {		
		
		var strURL="findWorkcenter2.php?factory="+factory;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('work_centerdiv').innerHTML=req.responseText;						
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