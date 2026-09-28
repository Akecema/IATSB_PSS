<?php
				 

 //-----------approval details -------------------
 
   $query_auth_aprv = "SELECT * FROM acc_email_coo WHERE id = '1'";
   $result_auth_aprv = mysqli_query($dbc,$query_auth_aprv) or die (mysqli_error($dbc));
   $data_auth_aprv = mysqli_fetch_array($result_auth_aprv);


//Requestor

$sta_apprv = "SELECT * from function_apprv_detail WHERE id_apprv = '1'";
$res_apprv = mysqli_query($dbc,$sta_apprv);
$rst_apprv = mysqli_fetch_array($res_apprv);

//HOD Requestor

$sta_apprv2 = "SELECT * from function_apprv_detail WHERE id_apprv = '2'";
$res_apprv2 = mysqli_query($dbc,$sta_apprv2);
$rst_apprv2 = mysqli_fetch_array($res_apprv2);

//HOD Stamping

$sta_apprv3 = "SELECT * from function_apprv_detail WHERE id_apprv = '3'";
$res_apprv3 = mysqli_query($dbc,$sta_apprv3);
$rst_apprv3 = mysqli_fetch_array($res_apprv3);

//HOD Assembly

$sta_apprv9 = "SELECT * from function_apprv_detail WHERE id_apprv = '9'";
$res_apprv9 = mysqli_query($dbc,$sta_apprv9);
$rst_apprv9 = mysqli_fetch_array($res_apprv9);

//HOD Engineering


$sta_apprv10 = "SELECT * from function_apprv_detail WHERE id_apprv = '10'";
$res_apprv10 = mysqli_query($dbc,$sta_apprv10);
$rst_apprv10 = mysqli_fetch_array($res_apprv10);

//HOD Production

$sta_apprv4 = "SELECT * from function_apprv_detail WHERE id_apprv = '4'";
$res_apprv4 = mysqli_query($dbc,$sta_apprv4);
$rst_apprv4 = mysqli_fetch_array($res_apprv4);

//QC

$sta_apprv5 = "SELECT * from function_apprv_detail WHERE id_apprv = '5'";
$res_apprv5 = mysqli_query($dbc,$sta_apprv5);
$rst_apprv5 = mysqli_fetch_array($res_apprv5);

//HOD QC

$sta_apprv6 = "SELECT * from function_apprv_detail WHERE id_apprv = '6'";
$res_apprv6 = mysqli_query($dbc,$sta_apprv6);
$rst_apprv6 = mysqli_fetch_array($res_apprv6);

//COO

$sta_apprv7 = "SELECT * from function_apprv_detail WHERE id_apprv = '7'";
$res_apprv7 = mysqli_query($dbc,$sta_apprv7);
$rst_apprv7 = mysqli_fetch_array($res_apprv7);

//CEO

  if($data_auth_aprv["nm_initial_lvl"] == '8')
  {

	$sta_apprv8 = "SELECT * from function_apprv_detail WHERE id_apprv = '8'";
	$res_apprv8 = mysqli_query($dbc,$sta_apprv8);
	$rst_apprv8 = mysqli_fetch_array($res_apprv8);
	
  }else{
	  
	$sta_apprv8 = "SELECT * from function_apprv_detail WHERE id_apprv = '7'";
	$res_apprv8 = mysqli_query($dbc,$sta_apprv8);
	$rst_apprv8 = mysqli_fetch_array($res_apprv8);  
	  
  }


?>