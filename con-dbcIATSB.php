<?php 
include 'cGhzvxff/config.php';
include 'cGhzvxff/config_mail.php';

date_default_timezone_set("Asia/Kuala_Lumpur");

$stas = "AC";
//--------setup website page --------------------------

$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system=?"; // SQL with parameters
$rs_setup = $dbc->prepare($query_setup); 
$rs_setup->bind_param("s", $stas);
$rs_setup->execute();
$result = $rs_setup->get_result(); // get the mysqli result
$data_setup = $result->fetch_assoc(); // fetch data   

?>