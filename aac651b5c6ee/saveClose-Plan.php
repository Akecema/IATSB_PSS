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


 $qty_update = "UPDATE pps_detail SET ".sql_ident($_POST["column"])." = '".sql_esc($_POST["editval"])."', user_update = '".sql_esc($username)."', date_update = NOW() WHERE id = '".sql_esc($_POST["id"])."'";
 $result_qty_update = mysqli_query($dbc,$qty_update);  
 
      
			
         
?>