<?php

session_start();
$username = $_SESSION['username'];
include '../include/config.php';
//include '../include/config_mail.php';
date_default_timezone_set('Asia/Kuala_Lumpur');

$Cdate = date("l, j F Y ");
$currentdate = (date("Y-m-d"));

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

//CR status (Approved)
$sta3 = "SELECT * from request_status WHERE status_id = '3'";
$sta_res3 = mysqli_query($dbc,$sta3);
$rst_sta3 = mysqli_fetch_array($sta_res3);

//CR status (Draft)
$sta6 = "SELECT * from request_status WHERE status_id = '6'";
$sta_res6 = mysqli_query($dbc,$sta6);
$rst_sta6 = mysqli_fetch_array($sta_res6);


 $qty_update = "UPDATE disposal_detail_prd_all SET ".sql_ident($_POST["column"])." = '".sql_esc($_POST["editval"])."' WHERE id = '".sql_esc($_POST["id"])."'";
 $result_qty_update = mysqli_query($dbc,$qty_update);  
 
 
 //-----get info table others disposal_detail_prd_ng
 $query_info_dis = "SELECT * FROM disposal_detail_prd_all WHERE id = '".sql_esc($_POST["id"])."'";
 $result_info_dis = mysqli_query($dbc,$query_info_dis);  
 $data_info_dis = mysqli_fetch_array($result_info_dis);
 
 
 $qty_updateD = "UPDATE disposal_detail_prd_all SET remark_approved5 = '".sql_esc($data_info_dis["remark_approved5"])."' WHERE doc_dis = '".sql_esc($data_info_dis["doc_dis"])."'";
 $result_qty_updateD = mysqli_query($dbc,$qty_updateD);  
 
 
 
 //-----update table-------------------------
   $sta_outA = substr($data_info_dis["doc_dis"],4,3);
   
   if($sta_outA == "311")
	  {
	
	$query_cancelDis1A = "UPDATE disposal_detail_prd_ng SET remark_approved5 = '".sql_esc($data_info_dis["remark_approved5"])."' WHERE doc_dis = '".sql_esc($data_info_dis["doc_dis"])."'";
	$result_cancelDis1A = mysqli_query($dbc,$query_cancelDis1A); 
	
		  
	  }elseif($sta_outA == "321")
	  {
	
	$query_cancelDis2A = "UPDATE disposal_detail_prd_pending_confirm SET remark_approved5 = '".sql_esc($data_info_dis["remark_approved5"])."' WHERE doc_dis = '".sql_esc($data_info_dis["doc_dis"])."'";
	$result_cancelDis2A = mysqli_query($dbc,$query_cancelDis2A); 
		  
	  }elseif($sta_outA == "331")
	  {
	
	$query_cancelDis3A = "UPDATE disposal_detail_prd_pending_confirm_hwork SET remark_approved5 = '".sql_esc($data_info_dis["remark_approved5"])."' WHERE doc_dis = '".sql_esc($data_info_dis["doc_dis"])."'";
	$result_cancelDis3A = mysqli_query($dbc,$query_cancelDis3A); 
		  
	  }elseif($sta_outA == "341")
	  {
	
	$query_cancelDis4A = "UPDATE disposal_detail_prd_pending_confirm_rework SET remark_approved5 = '".sql_esc($data_info_dis["remark_approved5"])."' WHERE doc_dis = '".sql_esc($data_info_dis["doc_dis"])."'";
	$result_cancelDis4A = mysqli_query($dbc,$query_cancelDis4A); 
		  
	  }elseif($sta_outA == "351")
	  {
    $query_cancelDisA = "UPDATE prd_creject_detail SET remark_approved5 = '".sql_esc($data_info_dis["remark_approved5"])."' WHERE doc_dis = '".sql_esc($data_info_dis["doc_dis"])."'";
	$result_cancelDisA = mysqli_query($dbc,$query_cancelDisA);    
	
			  
	  }else{
		  
		  
	  }
?>