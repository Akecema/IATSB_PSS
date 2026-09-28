<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

		    $p_id = $_GET["p_id"];
		    $scan_doc = $_GET["scan_doc"];
						
   //-------------------------delete item from table sc_kanban_assy------------------------------
   //--------------------------------------------------------------------------------------------------
   
    $query_delete = "DELETE FROM sc_kanban_assy WHERE id  = '".sql_esc($p_id)."' AND scan_doc = '".sql_esc($scan_doc)."'";
	$result_delete = mysqli_query($dbc,$query_delete);
	

     if($result_delete)
	 {
			
			 echo "<script>";
			 echo "window.location='ups_pps_month-assy.php?scan_doc=".html_esc($scan_doc)."'";
		     echo "</script>"; 
		     exit(); //quit the script
		 
    }
?>

