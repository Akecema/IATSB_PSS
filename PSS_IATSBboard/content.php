<?php

date_default_timezone_set('Asia/Kuala_Lumpur');

//$Cdate = date ("l, j F Y ");
$nextpage = 1;

?>
<?php

/*$sql = "SELECT * FROM material_request AS MR, scan_detail AS SD WHERE MR.id_scan = SD.id_scan AND MR.status_request = 'Y' AND (MR.status != 'Close' AND MR.status != 'Cancel')  GROUP BY MR.temp_mrin, SD.work_center ";
*/
$sqlT = "SELECT *, DATE_FORMAT(MR.date_plan,'%d-%m-%Y') AS R FROM pps_detail AS MR WHERE (MR.status_pps = '".sql_esc($rst_sta7["status_desc"])."' OR MR.status_pps = '".sql_esc($rst_sta18["status_desc"])."') AND MR.status = 'Y' ORDER BY MR.date_plan DESC ";

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