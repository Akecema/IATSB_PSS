<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

		    $p_id = $_GET["p_id"];
		    $scan_gen = $_GET["scan_gen"];
  
            $so_no = $_GET["so_no"];
          
   //-------------------------update delete scan_p2_perodua1 from table------------------------------
   //--------------------------------------------------------------------------------------------------
   
    $query_deletePer2 = "DELETE FROM scan_p2_othcust WHERE id  = '".sql_esc($p_id)."'";
	$result_deletePer2 = mysqli_query($dbc,$query_deletePer2);
	

     if($result_deletePer2)
	 {
			 
			 echo "<script>";
			 echo "window.location='crt_do_oth_cust-dlv.php?scan_gen=$scan_gen&&so_no=$so_no'";
		     echo "</script>"; 
		     exit(); //quit the script
		 
    }
?>

