<?php

session_start();
$username = $_SESSION['username'];
include '../include/config.php';

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "2")) {
header('Location: ../index.php');
exit();
}

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------

$query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
$result2 = db_query($dbc, $query2) or die (mysqli_error());
$res = mysqli_fetch_array($result2);

$url = "detail_pps_month_reprint.php"; 
require_once('tcpdf_barcodes_2d.php');


?>








<!--<table border="2">-->
<!--<thead>
<tr>
<th>No</th>
<th>Plan No</th>      
<th>Work Center</th>
</tr>
</thead>
<tbody>-->
<?php
/*https://stackoverflow.com/questions/26868834/repeat-html-table-header-after-n-row-in-php*/
$query = "SELECT * FROM prt_sheet_pps_new_test where doc_generate='2380000061' group by work_center ";
$result = mysqli_query($dbc,$query) or die('Query failed: ' . mysqli_error());

$rows = 0;
$n = 5;

while($row = mysqli_fetch_array($result))
{

	if ($rows % $n == 0) { //repeat after nth row      
?>

<!--header-->
<table width="200" border="2">
  <tr>
    <td>Production Planning Sheet</td>
  </tr>
</table>
<!--/n header-->

<table border="2" width="35%">
<thead>
<tr>
    <th width="2%">No 1</th>
    <th width="20%">Plan No 1</th>      
    <th width="10%">Work Center1 </th>
</tr> 
</thead>
<tbody>
<?php } ?>

<tr>
    <td><?php echo html_esc($row['id_pps_dtl']); ?></td>
    <td><?php echo html_esc($row['plan_no']); ?></td> 
    <td><?php echo html_esc($row['work_center']); ?></td>
</tr>
<?php $rows++; } ?>
</tbody>
</table>

<p>&nbsp;</p>