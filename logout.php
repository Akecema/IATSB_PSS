<?php
	require("include/config.php");
	require("status.php");
	require_once __DIR__ . "/include/auth.php";

	// Table/column names are fixed literals from this file, never request input.
	function delete_user_scans(mysqli $dbc, string $table, string $status_col, string $date_col, $status, $user, $date): void
	{
		$stmt = $dbc->prepare("DELETE FROM `$table` WHERE `$status_col` = ? AND user_create = ? AND `$date_col` = ?");
		$stmt->bind_param("sss", $status, $user, $date);
		$stmt->execute();
	}
	
	session_start();
    $username = $_SESSION["username"];
	$lvl_id = $_SESSION["lvl_id"];
    header("Cache-control: private");
	date_default_timezone_set('Asia/Kuala_Lumpur');

	$currentdate = (date("Y-m-d"));
	
	
	//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);


//CR status (New)

$sta = "SELECT * from request_status WHERE status_id = '1'";
$sta_res = mysqli_query($dbc,$sta);
$rst_sta = mysqli_fetch_array($sta_res);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="1;URL=index.php">
    <link rel="shortcut icon" href="images/favicon.ico">
    <!-- Main CSS-->
   <link rel="stylesheet" type="text/css" href="css/main-idx.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title><?php echo html_esc($data_setup["title_desc"]); ?></title>
    <script language="javascript">

 defaultStatus = "PSS Online  <?php echo html_esc($data_setup['title_desc']); ?>"
 function show ( text )
 {
  window.status=text;
  return true;
 }
</script>

<style type="text/css">

body {
	background-color: #FFFFFF;
	background-image: url();
}
.style1 {color: #FFFFFF}
.reflectBelow	{ 
    -webkit-box-reflect: below 0px -webkit-gradient(linear, left top, left bottom, from(transparent), to(rgba(250, 250, 250, 0.1)));

	
}
.page_center {
	width: 1000px;
	margin: 0 auto;
	padding: 70px 0;
}

</style>
<body >
<div class="page_center">

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" height="500">
  <tr> 
    <td align="center" style="font-family:verdana;font-size:11px" height="14">&nbsp;</td>
  </tr>
  <tr> 
    <td align="center" style="font-family:verdana;font-size:11px" height="346"> 
    
      <?php


	
    $stmt_user = $dbc->prepare("SELECT * FROM user_detail WHERE username = ?");
	$stmt_user->bind_param("s", $username);
	$stmt_user->execute();
	$result = $stmt_user->get_result();
	$db_rst = $result->fetch_array();
	
	if($result){
	
?><fieldset>
<div class="login-box">
<table width="80%" >
<tr> 
    <td align="center" style="font-family:verdana;font-size:11px" height="14">&nbsp;</td>
  </tr>
  <tr> 
    <td align="center" style="font-family:verdana;font-size:11px" height="14">&nbsp;</td>
  </tr>
  <tr> 
    <td align="center" style="font-family:verdana;font-size:11px" height="14">&nbsp;<img src="images/log_out.png" alt="EXIT" width="80" height="80"></td>
  </tr>
  <tr>
    <td><br><div align="center"> 
	 <h5><i class="fa fa-lg fa-fw fa-sign-out"></i>Logout  successfully, <?php echo htmlspecialchars((string)$username, ENT_QUOTES, "UTF-8"); ?>.Please click <a href='index.php'>here</a> to proceed.</h5>
	
	<?php
		
		unset($_SESSION["username"]);
		unset($_SESSION["lvl_id"]);
		session_unset();
		session_destroy();   
		
		clear_login_cookies();
	
	
   //-------------------upldate last login in table user_detail
	$stmt_upd = $dbc->prepare("UPDATE user_detail SET last_login = NOW() WHERE user_no = ?");
	$stmt_upd->bind_param("s", $db_rst["user_no"]);
	$stmt_upd->execute();
	
	//-------------------upldate last login in table user_detail
	$stmt_upd2 = $dbc->prepare("UPDATE login_detail SET last_login = NOW() WHERE staff_ID = ?");
	$stmt_upd2->bind_param("s", $db_rst["staff_ID"]);
	$stmt_upd2->execute();
    //header("Location: index.php"); 
	
	
		
	//-----------delete Disposal QC-------------

   delete_user_scans($dbc, 'sc_gra_disposal_qqc', 'status_dis', 'scan_date', $rst_sta["status_desc"], $username, $currentdate);

   //---------end delete ----------------------------------	
   
   //-----------delete GRA-------------

   delete_user_scans($dbc, 'sc_gra_qqc', 'status_gra', 'scan_date', $rst_sta["status_desc"], $username, $currentdate);

   //---------end delete ----------------------------------	
	

		
	//-----------delete Transfer Material Receiving -------------

   delete_user_scans($dbc, 'sc_trans_mat_rcv', 'status_tm', 'scan_date', $rst_sta["status_desc"], $username, $currentdate);
   
   delete_user_scans($dbc, 'sc_trans_mat_rcv_temp', 'status_tm', 'scan_date', $rst_sta["status_desc"], $username, $currentdate);


   //-----------delete Disposal Receiving -------------

   delete_user_scans($dbc, 'sc_gra_disposal_ppcrec', 'status_dis', 'scan_date', $rst_sta["status_desc"], $username, $currentdate);
   
   //-----------delete GI Condumable Receiving -------------

   delete_user_scans($dbc, 'sc_gis_con_rcv', 'status_gis', 'scan_date', $rst_sta["status_desc"], $username, $currentdate);
   
   
    //-----------delete Goods Return Receiving -------------

   delete_user_scans($dbc, 'sc_gra_return_rcv', 'status_gra', 'scan_date', $rst_sta["status_desc"], $username, $currentdate);
   
   //-----------delete Transfer Posting -------------

   delete_user_scans($dbc, 'scan_tp_store', 'status_tp', 'scan_date', $rst_sta["status_desc"], $username, $currentdate);
   
    //-----------delete Disposal Delivery -------------

   delete_user_scans($dbc, 'sc_do_disposal_ppcdlv', 'status_dis', 'scan_date', $rst_sta["status_desc"], $username, $currentdate);
   
     //-----------delete BF Transit Delivery -------------

   delete_user_scans($dbc, 'scan_bf_transit_dlv', 'status_bf', 'scan_date', $rst_sta["status_desc"], $username, $currentdate);
   
   

   //---------end delete ----------------------------------	
   	
	
	//-----------delete component reject -------------

   delete_user_scans($dbc, 'scan_prd_creject', 'status_dis', 'scan_date', $rst_sta["status_desc"], $username, $currentdate);
   
   
   //--------end delete ----------------------------------
   
   //-----------delete delivery perodua 100024 -------------
   
   delete_user_scans($dbc, 'scan_so_perodua1', 'status_DO', 'date_create', $rst_sta["status_desc"], $username, $currentdate);
   
   delete_user_scans($dbc, 'scan_p2_perodua1', 'status_DO', 'date_create', $rst_sta["status_desc"], $username, $currentdate);


//-----------delete delivery perodua 100002 -------------
   
delete_user_scans($dbc, 'scan_so_perodua2', 'status_DO', 'date_create', $rst_sta["status_desc"], $username, $currentdate);

delete_user_scans($dbc, 'scan_p2_perodua2', 'status_DO', 'date_create', $rst_sta["status_desc"], $username, $currentdate);



    //-----------delete delivery perodua 100000 -------------
   
    delete_user_scans($dbc, 'scan_so_perodua3', 'status_DO', 'date_create', $rst_sta["status_desc"], $username, $currentdate);
    
    delete_user_scans($dbc, 'scan_p2_perodua3', 'status_DO', 'date_create', $rst_sta["status_desc"], $username, $currentdate);


    //-----------delete delivery others cust -------------
   
    delete_user_scans($dbc, 'scan_so_othcust', 'status_DO', 'date_create', $rst_sta["status_desc"], $username, $currentdate);
    
    delete_user_scans($dbc, 'scan_p2_othcust', 'status_DO', 'date_create', $rst_sta["status_desc"], $username, $currentdate);

   
   
   //---------delete Goods receipt scan QR code --------------
	
   delete_user_scans($dbc, 'sc_good_receipt_rcv', 'status_gr', 'scan_date', $rst_sta["status_desc"], $username, $currentdate);
	
	
	//---------delete Goods receipt FOC scan QR code --------------
	
   delete_user_scans($dbc, 'sc_good_receipt_foc_rcv', 'status_gr', 'scan_date', $rst_sta["status_desc"], $username, $currentdate);
   
   
   //--------delete scan kanban utk create planning
    $stmt_kanban = $dbc->prepare("DELETE FROM sc_kanban_assy WHERE plan_no = '' AND status_pps = ? AND user_create = ? AND date_kanban = ?");
    $stmt_kanban->bind_param("sss", $rst_sta["status_desc"], $username, $currentdate);
    $stmt_kanban->execute();
   	

//--------delete scan Reeject Part Disposal Engineering
    delete_user_scans($dbc, 'sc_gra_disposal_prdeng', 'status_dis', 'scan_date', $rst_sta["status_desc"], $username, $currentdate);
	
	}
	else
	{
		echo '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Technical Errors. Please click <a href="javascript:history.go(-1)">here</a> to proceed.';
	}//endif
	?></div></td>
  </tr>
</table></div></fieldset>
    </td>
  </tr>
</table>
</div>
