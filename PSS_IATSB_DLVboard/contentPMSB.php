<?php

date_default_timezone_set('Asia/Kuala_Lumpur');
$currentdate = (date("Y-m-d"));
//$Cdate = date ("l, j F Y ");
$nextpage = 1;

          $masa = (date("H:m:s"));

          $query_shtA = "SELECT * FROM shift_detail WHERE id_shift = '1'";
		  $result_shtA = mysqli_query($dbc,$query_shtA);
		  $data_shtA = mysqli_fetch_array($result_shtA); 
		  
		 //----shift posting ----
		 
		 if(($masa >= $data_shtA["time_start"]) && ($masa <= $data_shtA["time_end"]))
		 {
			 
		 $shif_pA = "Day"; 
		 $shift_chkA = "D/S";
		 
		 }else
		 {
		 
		 $shif_pA = "Night"; 
		 $shift_chkA = "N/S";
		
		 }	 
		 
		 //---shift detail ------
	
	  $query_sht_checking = "SELECT * FROM shift_detail WHERE id_shift = '1'";
	  $result_sht_checking = mysqli_query($dbc,$query_sht_checking);
	  $data_sht_checking = mysqli_fetch_array($result_sht_checking); 
	  
	 //----shift posting ----
	 $prev_date = date('Y-m-d', strtotime($currentdate .' -1 day'));
	 
	 if(($masa >= $data_sht_checking["time_start"]) && ($masa <= $data_sht_checking["time_end"]))
	 {
		 
     $date_baru = $currentdate;
	
	 
	 }else
	 {
	    if(($masa >= '00:00:00') && ($masa <= '07:59:00'))
	   {
	    $date_baru = $prev_date; 
	   }else{
		   
		 $date_baru = $currentdate;   
	   }
	
	 }


?>
<?php

/*$sql = "SELECT * FROM material_request AS MR, scan_detail AS SD WHERE MR.id_scan = SD.id_scan AND MR.status_request = 'Y' AND (MR.status != 'Close' AND MR.status != 'Cancel')  GROUP BY MR.temp_mrin, SD.work_center ";
*/
$sqlT = "SELECT *, DATE_FORMAT(dlv_date,'%d-%m-%Y') AS R FROM dlv_ord_all_delivery WHERE vendor_name = '100000' AND (status_DO = '".sql_esc($rst_sta3["status_desc"])."') AND posting_date = '".sql_esc($date_baru)."' AND (cycle_no = '".sql_esc($shift_chkA)."') GROUP BY material_no ORDER BY material_doc_gen DESC ";
$resultT = mysqli_query($dbc,$sqlT);
$r = mysqli_num_rows($resultT);
$r2 = mysqli_fetch_array($resultT);


$numrows = $r;


$rowsperpage = 14;

// $totalpages = ceil($numrows / $rowsperpage);
$totalpages = intval($numrows / $rowsperpage);
$lastpage =  fmod($numrows , $rowsperpage);

 if ($lastpage > 0)
 {
	$totalpages = ($totalpages + 1);
	}

	
if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {

$currentpage = (int) $_GET['currentpage'];
} else {

$currentpage = 1;
}


if ($currentpage > $totalpages) {

$currentpage = $totalpages;
} 
if ($currentpage < 1) {

$currentpage = 1;
} 


$offset = ($currentpage - 1) * $rowsperpage;


$range = 10;


if ($currentpage > 1) {

//echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=1'><<</a> ";

$prevpage = $currentpage - 1;

//echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'><</a> ";



}  // end if $currentpage

for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {

if (($x > 0) && ($x <= $totalpages)) {

if ($x == $currentpage) {

 //echo " [<b>$x</b>] ";

} else {

 //echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a> ";
} 


} // end if
} // end for


if ($currentpage != $totalpages) {

$nextpage = $currentpage + 1;

//echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>Next></a> ";

//echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>Last>></a> ";

}  // end if


header('Refresh: 15; URL='.$_SERVER['PHP_SELF'].'?currentpage='.$nextpage);



?>