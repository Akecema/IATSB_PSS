<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

$buid = base64_decode($_GET["buid"]);
$uid = base64_decode($_GET["uid"]);


     // ---update status 

		$query_ftp = "UPDATE pps_detail_trn_fg_ng SET status_ftp_bflush = 'Y' WHERE bflush_no = '".sql_esc($buid)."'";
		$rst_query_ftp = mysqli_query($dbc,$query_ftp); //or die ("Error in query: $query_ftp"); 
		
				
		if($rst_query_ftp > 0)
		{
			
		echo "<script>";
		echo "window.location='confirm_backflush_tran_NG.php'";
		echo "</script>";
		exit(); //quit the script
		
	      }
		
?>
