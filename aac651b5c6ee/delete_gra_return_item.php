<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

		    $p_id = $_GET["p_id"];
		    $scan_doc = $_GET["scan_doc"];
			$barcode_ref = $_GET["pps_ref"];
            $dateF = $_GET["date1"];
           //	$plant_code = $_GET["plant_code"];
			$shift_ops = $_GET["shift_ops"];
			
   //-------------------------delete GRA Return item from table sc_gra_return_rcv------------------------------
   //--------------------------------------------------------------------------------------------------
   
    $query_delete = "DELETE FROM sc_gra_return_rcv WHERE id_scan  = '".sql_esc($p_id)."' AND scan_doc = '".sql_esc($scan_doc)."'";
	$result_delete = mysqli_query($dbc,$query_delete);
	

     if($result_delete)
	 {
			
			 echo "<script>";
			 echo "window.location='detail_GR_return-receive.php?scan_doc=$scan_doc&&pps_ref=$barcode_ref&&shift_ops=$shift_ops&&date1=$dateF'";
		     echo "</script>"; 
		     exit(); //quit the script
		 
    }
?>

