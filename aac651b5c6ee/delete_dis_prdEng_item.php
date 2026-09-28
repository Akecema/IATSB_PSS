<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

		    $p_id = $_GET["p_id"];
		    $scan_doc = $_GET["scan_doc"];
  
            $barcode_ref = $_GET["barcode_ref"];
          //  $dateF = $_GET["date1"];
           	$plant_code = $_GET["plant_code"];
			$model_code = $_GET["model_code"]; 
			$shift_ops = $_GET["shift_ops"];
			$material_type = $_GET["material_type"]; 
			$stamp_ind = $_GET["stamp_ind"];
			$material_no = $_GET["material_no"];

   //-------------------------update delete production reject request from table------------------------------
   //--------------------------------------------------------------------------------------------------
   
    $query_deleteE = "DELETE FROM sc_gra_disposal_prdeng WHERE id_scan_dis  = '".sql_esc($p_id)."'";
	$result_deleteE = mysqli_query($dbc,$query_deleteE);
	

     if($result_deleteE)
	 {
			 

			 echo "<script>";
			 echo "window.location='detail_disposal_reject-prdEng.php?scan_doc=".html_esc($scan_doc)."&&barcode_ref=".html_esc($barcode_ref)."&&plant_code=".html_esc($plant_code)."&&shift_ops=".html_esc($shift_ops)."&&model_code=".html_esc($model_code)."&&material_type=".html_esc($material_type)."&&stamp_ind=".html_esc($stamp_ind)."&&material_no=".html_esc($material_no)."'";
		     echo "</script>"; 
		     exit(); //quit the script
		 
    }
?>

