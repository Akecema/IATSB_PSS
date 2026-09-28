<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
include '../include/config_mail.php';

$Cdate = date("l, j F Y ");
$currentdate = (date("Y-m-d"));

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

if(isset($_POST['id'])) {


$shift_pps1 = $_POST['shift_pps1'];
$id=$_POST['id'];

 $qty_update2 = "UPDATE pps_detail SET shift_pps1 = '".sql_esc($_POST["shift_pps1"])."', user_update = '".sql_esc($username)."', date_update = NOW() WHERE id = '".sql_esc($_POST["id"])."'";
 $result_qty_update2 = mysqli_query($dbc,$qty_update2);  


}

 

?>