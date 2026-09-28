<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
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

//CR status (Closed)
$sta13 = "SELECT * from request_status WHERE status_id = '13' ";
$sta_res13 = mysqli_query($dbc,$sta13);
$rst_sta13 = mysqli_fetch_array($sta_res13);


   
	        $dateF = $_GET["date1"];
            $dateT = $_GET["date2"];
			$plan_category = $_GET["plan_category"];
			$material_no = $_GET["material_no"]; 
			$shift_ops = $_GET["shift_ops"];
			
 
if(isset($_POST['e_tcid']))
{
	  
    $trc_id = $_POST["e_tcid"]; 
    $st = count($trc_id);
	

	    
		 for($i=0; $i<$st; $i++)
	{		

		//update table pps_detail
		
	$query_releas_v = "UPDATE pps_detail SET status_pps = '".sql_esc($rst_sta13["status_desc"])."', user_update = '".sql_esc($username)."', date_update = NOW(), user_closed = '".sql_esc($username)."', date_closed = NOW() WHERE id = '".sql_esc($trc_id[$i])."'";
    $result_releas_v = mysqli_query($dbc,$query_releas_v);
	
	
	    $query_infoN = "SELECT * FROM pps_detail WHERE id = '".sql_esc($trc_id[$i])."' AND status_pps = '".sql_esc($rst_sta13["status_desc"])."'";
		$result_infoN = mysqli_query($dbc,$query_infoN);
		$row_infoN = mysqli_fetch_array($result_infoN);
		
	  
	   
    $query_pps_closed = "INSERT INTO pps_detail_close(id,id_pps,ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,status,user_upload,date_upload,user_create,date_create,user_update,date_update,user_posting,date_posting,user_closed,date_closed,plan_category,id_factory_pps,rev_pps,seq_pps,man_hours,work_hours,plant_code,year_plan,material_type,sloc,remark_closed,type_closed,remark_closed_plan,back_no,kanban_no) VALUES('','".sql_esc($row_infoN["id"])."','".sql_esc($row_infoN["ref_id"])."','".sql_esc($row_infoN["plan_no"])."','".sql_esc($row_infoN["upload_id"])."','".sql_esc($row_infoN["model_code"])."','".sql_esc($row_infoN["month_plan"])."','".sql_esc($row_infoN["material_no"])."','".sql_esc($row_infoN["qty_plan"])."','".sql_esc($row_infoN["qty_actual"])."','".sql_esc($row_infoN["status_pps"])."','".sql_esc($row_infoN["comp_code"])."','".sql_esc($row_infoN["work_center"])."','".sql_esc($row_infoN["shift_pps1"])."','".sql_esc($row_infoN["shift_pps2"])."','".sql_esc($row_infoN["date_plan"])."','".sql_esc($row_infoN["status"])."','".sql_esc($row_infoN["user_upload"])."','".sql_esc($row_infoN["date_upload"])."','".sql_esc($row_infoN["user_create"])."','".sql_esc($row_infoN["date_create"])."','".sql_esc($row_infoN["user_update"])."','".sql_esc($row_infoN["date_update"])."','".sql_esc($row_infoN["user_posting"])."','".sql_esc($row_infoN["date_posting"])."','".sql_esc($username)."',NOW(),'".sql_esc($row_infoN["plan_category"])."','".sql_esc($row_infoN["id_factory_pps"])."','".sql_esc($row_infoN["rev_pps"])."','".sql_esc($row_infoN["seq_pps"])."','".sql_esc($row_infoN["man_hours"])."','".sql_esc($row_infoN["work_hours"])."','".sql_esc($row_infoN["plant_code"])."','".sql_esc($row_infoN["year_plan"])."','".sql_esc($row_infoN["material_type"])."','".sql_esc($row_infoN["sloc"])."','".sql_esc($row_infoN["remark_closed"])."','".sql_esc($row_infoN["type_closed"])."','".sql_esc($row_infoN["remark_closed_plan"])."','".sql_esc($row_infoN["back_no"])."','".sql_esc($row_infoN["kanban_no"])."')";
	$rst_pps_closed = mysqli_query($dbc,$query_pps_closed);
	
	 //----delete table  pps_detail ------
     
        /* $sql_delete_request_pps = "DELETE FROM pps_detail WHERE id = '".$trc_id[$i]."'";
         $result_delete_request_pps = mysqli_query($dbc,$sql_delete_request_pps);*/
		  
			}// end for loop
			
			
			
			
			
   }// end if

?>
 