<?php
include '../include/config.php';

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

//CR status (In Progress)
$sta7 = "SELECT * from request_status WHERE status_id = '7'";
$sta_res7 = mysqli_query($dbc,$sta7);
$rst_sta7 = mysqli_fetch_array($sta_res7);

   $dateF = $_GET["date1"];
   $dateT = $_GET["date2"];
   $plan_category = $_GET["plan_category"];
   $back_no = $_GET["back_no"]; 
   $shift_ops = $_GET["shift_ops"]; 
  // $name_file = $_GET["name_file"]; 
 
if(isset($_POST['e_tcid']))
{
	  

 
    $trc_id = $_POST["e_tcid"]; 
    $st = count($trc_id);
	$string = "";
	
	  
	
	    
		 for($i=0; $i<$st; $i++)
	{		
	
	    $query_releas = "UPDATE pps_detail SET status_pps = '".sql_esc($rst_sta4["status_desc"])."', user_update = '".sql_esc($username)."', date_update = NOW(), user_posting = '".sql_esc($username)."', date_posting = NOW() WHERE id = '".sql_esc($trc_id[$i])."' AND status_pps != '".sql_esc($rst_sta7["status_desc"])."'";
        $result_releas = mysqli_query($dbc,$query_releas);
		
		//insert table pps_detail_close
		
		$query_info = "SELECT * FROM pps_detail WHERE id = '".sql_esc($trc_id[$i])."' AND status_pps != '".sql_esc($rst_sta7["status_desc"])."'";
		$result_info = mysqli_query($dbc,$query_info);
		$row_info = mysqli_fetch_array($result_info);
		
	   
    $query_pps_can = "INSERT INTO pps_cancellation(id,ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,status,user_upload,date_upload,user_create,date_create,user_update,date_update,user_posting,date_posting,user_cancel,date_cancel,plan_category,id_factory_pps,rev_pps,seq_pps,man_hours,work_hours,plant_code,year_plan,back_no,kanban_no) VALUES('".sql_esc($row_info["id"])."','".sql_esc($row_info["ref_id"])."','".sql_esc($row_info['plan_no'])."','".sql_esc($row_info["upload_id"])."','".sql_esc($row_info["model_code"])."','".sql_esc($row_info["month_plan"])."','".sql_esc($row_info["material_no"])."','".sql_esc($row_info["qty_plan"])."','".sql_esc($row_info["qty_actual"])."','".sql_esc($row_info["status_pps"])."','".sql_esc($row_info["comp_code"])."','".sql_esc($row_info["work_center"])."','".sql_esc($row_info["shift_pps1"])."','".sql_esc($row_info["shift_pps2"])."','".sql_esc($row_info["date_plan"])."','".sql_esc($row_info["status"])."','".sql_esc($row_info["user_upload"])."','".sql_esc($row_info["date_upload"])."','".sql_esc($row_info["user_create"])."','".sql_esc($row_info["date_create"])."','".sql_esc($row_info["user_update"])."','".sql_esc($row_info["date_update"])."','".sql_esc($row_info["user_posting"])."','".sql_esc($row_info["date_posting"])."','".sql_esc($username)."',NOW(),'".sql_esc($row_info["plan_category"])."','".sql_esc($row_info["id_factory_pps"])."','".sql_esc($row_info["rev_pps"])."','".sql_esc($row_info["seq_pps"])."','".sql_esc($row_info["man_hours"])."','".sql_esc($row_info["work_hours"])."','".sql_esc($row_info["plant_code"])."','".sql_esc($row_info["year_plan"])."','".sql_esc($row_info["back_no"])."','".sql_esc($row_info["kanban_no"])."')"; 
     $rst_pps_can = mysqli_query($dbc,$query_pps_can);
		
	
		  
			}// end for loop
			
   }// end if
?>
 