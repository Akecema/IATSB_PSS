<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();

include 'include/config.php';

$currentdate = (date("Y-m-d"));

set_time_limit(0);

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

//CR status (Closed)
$sta13 = "SELECT * from request_status WHERE status_id = '13'";
$sta_res13 = mysqli_query($dbc,$sta13);
$rst_sta13 = mysqli_fetch_array($sta_res13);


//------------------------------------------------------------------------------------------------
//  update planning status "Closed" pps after logout
//------------------------------------------------------------------------------------------------

//------range date for 7 days----------------------------
 $start_date_check = date('Y-m-d', strtotime("-30 days"));
 $end_date_check = date('Y-m-d', strtotime("-90 days"));
 
  //echo $start_date_check;
  //echo $end_date_check;
 
$sql_pps = "SELECT * FROM pps_detail WHERE status_pps = '".sql_esc($rst_sta7["status_desc"])."' AND (date_posting >= '".sql_esc($end_date_check)."' AND date_posting <= '".sql_esc($start_date_check)."')";
$result_pps = mysqli_query($dbc,$sql_pps) or trigger_error("SQL", E_USER_ERROR);
$r_pps = mysqli_num_rows($result_pps);

$numrows2 = $r_pps;
//echo $numrows2;
//echo "<br>";
while ($r2_pps = mysqli_fetch_array($result_pps))
{

//----update pps_detail status --"Closed"

    $query_releas_v = "UPDATE pps_detail SET status_pps = '".sql_esc($rst_sta13["status_desc"])."', user_update = '".sql_esc($username)."', date_update = NOW(), user_closed = '".sql_esc($username)."', date_closed = NOW() WHERE id = '".sql_esc($r2_pps["id"])."'";
    $result_releas_v = mysqli_query($dbc,$query_releas_v);

//-----add data to table pps_detail_close-------
        $query_infoN = "SELECT * FROM pps_detail WHERE id = '".sql_esc($r2_pps["id"])."' AND status_pps = '".sql_esc($rst_sta13["status_desc"])."'";
		$result_infoN = mysqli_query($dbc,$query_infoN);
		$row_infoN = mysqli_fetch_array($result_infoN);
		
	   
    $query_pps_closed = "INSERT INTO pps_detail_close(id,id_pps,ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,status,user_upload,date_upload,user_create,date_create,user_update,date_update,user_posting,date_posting,user_closed,date_closed,plan_category,id_factory_pps,rev_pps,seq_pps,man_hours,work_hours,plant_code,year_plan,material_type,sloc,remark_closed,type_closed,remark_closed_plan) VALUES('','".sql_esc($row_infoN["id"])."','".sql_esc($row_infoN["ref_id"])."','".sql_esc($row_infoN["plan_no"])."','".sql_esc($row_infoN["upload_id"])."','".sql_esc($row_infoN["model_code"])."','".sql_esc($row_infoN["month_plan"])."','".sql_esc($row_infoN["material_no"])."','".sql_esc($row_infoN["qty_plan"])."','".sql_esc($row_infoN["qty_actual"])."','".sql_esc($row_infoN["status_pps"])."','".sql_esc($row_infoN["comp_code"])."','".sql_esc($row_infoN["work_center"])."','".sql_esc($row_infoN["shift_pps1"])."','".sql_esc($row_infoN["shift_pps2"])."','".sql_esc($row_infoN["date_plan"])."','".sql_esc($row_infoN["status"])."','".sql_esc($row_infoN["user_upload"])."','".sql_esc($row_infoN["date_upload"])."','".sql_esc($row_infoN["user_create"])."','".sql_esc($row_infoN["date_create"])."','".sql_esc($row_infoN["user_update"])."','".sql_esc($row_infoN["date_update"])."','".sql_esc($row_infoN["user_posting"])."','".sql_esc($row_infoN["date_posting"])."','".sql_esc($username)."',NOW(),'".sql_esc($row_infoN["plan_category"])."','".sql_esc($row_infoN["id_factory_pps"])."','".sql_esc($row_infoN["rev_pps"])."','".sql_esc($row_infoN["seq_pps"])."','".sql_esc($row_infoN["man_hours"])."','".sql_esc($row_infoN["work_hours"])."','".sql_esc($row_infoN["plant_code"])."','".sql_esc($row_infoN["year_plan"])."','".sql_esc($row_infoN["material_type"])."','".sql_esc($row_infoN["sloc"])."','".sql_esc($row_infoN["remark_closed"])."','".sql_esc($row_infoN["type_closed"])."','".sql_esc($row_infoN["remark_closed_plan"])."')";
	$rst_pps_closed = mysqli_query($dbc,$query_pps_closed);


}


	      
?>