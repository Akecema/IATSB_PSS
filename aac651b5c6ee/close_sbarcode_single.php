<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';


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

//CR status (Transfer QC)
$sta18 = "SELECT * from request_status WHERE status_id = '18'";
$sta_res18 = mysqli_query($dbc,$sta18);
$rst_sta18 = mysqli_fetch_array($sta_res18);

//CR status (Cancel)
$sta21 = "SELECT * from request_status WHERE status_id = '21'";
$sta_res21 = mysqli_query($dbc,$sta21);
$rst_sta21 = mysqli_fetch_array($sta_res21);

//CR status (Close)
$sta22 = "SELECT * from request_status WHERE status_id = '22'";
$sta_res22 = mysqli_query($dbc,$sta22);
$rst_sta22 = mysqli_fetch_array($sta_res22);



$puid = $_GET["puid"];

//echo $puid; 

$qry = mysqli_query($dbc,"SELECT *, DATE_FORMAT(MR.date_plan,'%d-%m-%Y') as R, DATE_FORMAT(MR.date_posting,'%d-%m-%Y') as R2, DATE_FORMAT(MR.date_create,'%d-%m-%Y') as R3 FROM pps_detail AS MR  WHERE MR.plan_no = '".sql_esc($puid)."' AND (MR.status_pps = '".sql_esc($rst_sta7["status_desc"])."' OR MR.status_pps = '".sql_esc($rst_sta18["status_desc"])."') AND MR.status = 'Y' ");
$data = "";
while($rown = mysqli_fetch_array($qry)) {
	
	//update table pps_detail
		
	$query_releas_v = "UPDATE pps_detail SET status_pps = '".sql_esc($rst_sta13["status_desc"])."', user_update = '".sql_esc($username)."', date_update = NOW(), user_closed = '".sql_esc($username)."', date_closed = NOW() WHERE id = '".sql_esc($rown["id"])."'";
    $result_releas_v = mysqli_query($dbc,$query_releas_v);
	
	$query_infoN = "SELECT * FROM pps_detail WHERE id = '".sql_esc($rown["id"])."' AND status_pps = '".sql_esc($rst_sta13["status_desc"])."'";
	$result_infoN = mysqli_query($dbc,$query_infoN);
	$row_infoN = mysqli_fetch_array($result_infoN);
		
	  
	   
    $query_pps_closed = "INSERT INTO pps_detail_close(id,id_pps,ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,status,user_upload,date_upload,user_create,date_create,user_update,date_update,user_posting,date_posting,user_closed,date_closed,plan_category,id_factory_pps,rev_pps,seq_pps,man_hours,work_hours,plant_code,year_plan,material_type,sloc,remark_closed,type_closed,remark_closed_plan) VALUES('','".sql_esc($row_infoN["id"])."','".sql_esc($row_infoN["ref_id"])."','".sql_esc($row_infoN["plan_no"])."','".sql_esc($row_infoN["upload_id"])."','".sql_esc($row_infoN["model_code"])."','".sql_esc($row_infoN["month_plan"])."','".sql_esc($row_infoN["material_no"])."','".sql_esc($row_infoN["qty_plan"])."','".sql_esc($row_infoN["qty_actual"])."','".sql_esc($row_infoN["status_pps"])."','".sql_esc($row_infoN["comp_code"])."','".sql_esc($row_infoN["work_center"])."','".sql_esc($row_infoN["shift_pps1"])."','".sql_esc($row_infoN["shift_pps2"])."','".sql_esc($row_infoN["date_plan"])."','".sql_esc($row_infoN["status"])."','".sql_esc($row_infoN["user_upload"])."','".sql_esc($row_infoN["date_upload"])."','".sql_esc($row_infoN["user_create"])."','".sql_esc($row_infoN["date_create"])."','".sql_esc($row_infoN["user_update"])."','".sql_esc($row_infoN["date_update"])."','".sql_esc($row_infoN["user_posting"])."','".sql_esc($row_infoN["date_posting"])."','".sql_esc($username)."',NOW(),'".sql_esc($row_infoN["plan_category"])."','".sql_esc($row_infoN["id_factory_pps"])."','".sql_esc($row_infoN["rev_pps"])."','".sql_esc($row_infoN["seq_pps"])."','".sql_esc($row_infoN["man_hours"])."','".sql_esc($row_infoN["work_hours"])."','".sql_esc($row_infoN["plant_code"])."','".sql_esc($row_infoN["year_plan"])."','".sql_esc($row_infoN["material_type"])."','".sql_esc($row_infoN["sloc"])."','".sql_esc($row_infoN["remark_closed"])."','".sql_esc($row_infoN["type_closed"])."','".sql_esc($row_infoN["remark_closed_plan"])."')";
	$rst_pps_closed = mysqli_query($dbc,$query_pps_closed);
	

     
}

			
				echo "<script>";
				echo "window.location='technical_complete_tran.php';"; 
				echo "</script>";
				exit(); //quit the script	
				
		
      
    
?>
