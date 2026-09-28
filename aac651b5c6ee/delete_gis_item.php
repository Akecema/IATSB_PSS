<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

		    $p_id = $_GET["p_id"];
		    $scan_doc = $_GET["scan_doc"];
			$work_center = $_GET["work_center"];
            $dateF = $_GET["date1"];
           	$plant_code = $_GET["plant_code"];
			$shift_ops = $_GET["shift_ops"];
			$material_no = $_GET["material_no"];

   //-------------------------update delete production reject request from table------------------------------
   //--------------------------------------------------------------------------------------------------
   
    $query_delete = "DELETE FROM sc_gis_con_rcv WHERE id_scan_gis  = '".sql_esc($p_id)."'";
	$result_delete = mysqli_query($dbc,$query_delete);
	

     if($result_delete)
	 {
	
			 
			 echo "<script>";
			 echo "window.location='detail_GR_GI-receive.php?scan_doc=".html_esc($scan_doc)."&&plant_code=".html_esc($plant_code)."&&date1=".html_esc($dateF)."&&shift_ops=".html_esc($shift_ops)."&&work_center=".html_esc($work_center)."&&material_no=".html_esc($material_no)."'";
		     echo "</script>"; 
		     exit(); //quit the script
		 
    }
?>

