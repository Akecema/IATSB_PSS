<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

		    $p_id = $_GET["p_id"];
		    $scan_doc = $_GET["scan_doc"];
  
            $barcode_ref = $_GET["barcode_ref"];
            $dateF = $_GET["date1"];
           	$plant_code = $_GET["plant_code"];
			$sloc_f = $_GET["sloc_f"];
			$sloc_t = $_GET["sloc_t"];
			$model_code = $_GET["model_code"]; 
			$shift_ops = $_GET["shift_ops"];
			$material_type = $_GET["material_type"]; 
			$stamp_ind = $_GET["stamp_ind"];
			$material_no = $_GET["material_no"];

   //-------------------------update delete production reject request from table------------------------------
   //--------------------------------------------------------------------------------------------------
   
    $query_delete = "DELETE FROM scan_tp_store WHERE id_scan_tp  = '".sql_esc($p_id)."'";
	$result_delete = mysqli_query($dbc,$query_delete);
	

     if($result_delete)
	 {
			 
			 echo "<script>";
			 echo "window.location='prog_trn-posting.php?scan_doc=$scan_doc&&barcode_ref=$barcode_ref&&sloc_f=$sloc_f&&sloc_t=$sloc_t&&plant_code=$plant_code&&date1=$dateF&&shift_ops=$shift_ops&&model_code=$model_code&&material_type=$material_type&&stamp_ind=$stamp_ind&&material_no=$material_no'";
		     echo "</script>"; 
		     exit(); //quit the script
		 
    }
?>

