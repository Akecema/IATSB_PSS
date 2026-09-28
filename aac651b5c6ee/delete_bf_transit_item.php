<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

		    $p_id = $_GET["p_id"];
		    $scan_doc = $_GET["scan_doc"];

   //-------------------------update delete bf transit request from table------------------------------
   //--------------------------------------------------------------------------------------------------
   
    $query_delete = "DELETE FROM scan_bf_transit_dlv WHERE id_scan_tp  = '".sql_esc($p_id)."' AND scan_doc = '".sql_esc($scan_doc)."'";
	$result_delete = mysqli_query($dbc,$query_delete);
	

     if($result_delete)
	 {
			 
			 echo "<script>";
			 echo "window.location='bf_transit_do-dlv.php?uid2=$scan_doc'";
		     echo "</script>"; 
		     exit(); //quit the script
		 
    }
?>

