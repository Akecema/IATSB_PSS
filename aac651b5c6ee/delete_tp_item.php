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
			 echo "window.location='prog_trn-posting.php?scan_doc=".html_esc($scan_doc)."&&barcode_ref=".html_esc($barcode_ref)."&&sloc_f=".html_esc($sloc_f)."&&sloc_t=".html_esc($sloc_t)."&&plant_code=".html_esc($plant_code)."&&date1=".html_esc($dateF)."&&shift_ops=".html_esc($shift_ops)."&&model_code=".html_esc($model_code)."&&material_type=".html_esc($material_type)."&&stamp_ind=".html_esc($stamp_ind)."&&material_no=".html_esc($material_no)."'";
		     echo "</script>"; 
		     exit(); //quit the script
		 
    }
?>

