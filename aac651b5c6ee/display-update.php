<?php
 //-------------- click button "SAVE"----------------

session_start();

include '../include/config.php';
$username = $_SESSION['username'];

//GET record
$dateF = $_GET["date1"];
$dateT = $_GET["date2"];
$plan_category = $_GET["plan_category"];
$material_no = $_GET["material_no"];
$shift_ops = $_GET["shift_ops"];

			
$msgSend = "";

if(isset($_POST["edt_btnMul"])) 
{ // handle the form.

	$uid = $_POST["uid"];
	$tid = $_POST["tid"];
	$shift_ops2 = $_POST["shift_ops2"];
	$date_plan = $_POST["date_plan"];
	
	$how_many = count($tid); 
	
	// echo $how_many;
	
	for ($i=0; $i<$how_many; $i++) { 
	
		// echo $uid;  echo "upload"; 
		// echo $shift_ops2[$i];  echo "      id :".$tid[$i]; echo "<br>";
	
		if($shift_ops2[$i] == "D/S")
		{
			$query_up_sta = "UPDATE pps_detail SET shift_pps1 = '".sql_esc($shift_ops2[$i])."', shift_pps2 = '', date_plan = '".sql_esc($date_plan[$i])."'  WHERE id ='".sql_esc($tid[$i])."'";
			$result_up_sta = mysqli_query($dbc,$query_up_sta);
		
		}
		elseif($shift_ops2[$i] == "N/S")
		{	
			$query_up_sta2 = "UPDATE pps_detail SET shift_pps2 = '".sql_esc($shift_ops2[$i])."', shift_pps1 = '', date_plan = '".sql_esc($date_plan[$i])."'  WHERE id ='".sql_esc($tid[$i])."'";
			$result_up_sta2 = mysqli_query($dbc,$query_up_sta2);
		}
	
		///---------------select info pss-detail-----------------
		
		$qty_upd_inf = new PreparedSql("SELECT * FROM pps_detail WHERE id = ?", [$tid[$i]]);
		$rst_qty_upd_inf = db_query($dbc, $qty_upd_inf);  
		$rowac = mysqli_fetch_array($rst_qty_upd_inf);
	
		$ddm = substr($rowac["date_plan"],8,2);
		$mmm = substr($rowac["date_plan"],5,2);
		$yym = substr($rowac["date_plan"],0,4);
		
		$date1_m = ($yym.'-'.$mmm.'-'.$ddm);
		
		$qty_update_m = "UPDATE pps_detail SET month_plan = '".sql_esc($mmm)."', year_plan = '".sql_esc($yym)."', user_update = '".sql_esc($username)."', date_update = NOW() WHERE id = '".sql_esc($tid[$i])."'";
		$rst_qty_update_m = mysqli_query($dbc,$qty_update_m);  
	
	
	
	} // end for loop


$msgSend = "<script language='JavaScript'>alert('Your transaction has been processed successfully.');window.location='display_pps_month_reprint2.php?date1=$dateF&&date2=$dateT&&plan_category=$plan_category&&material_no=$material_no&&shift_ops=$shift_ops';</script>";

echo $msgSend;




}// end submit
?>