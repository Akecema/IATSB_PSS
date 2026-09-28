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

$query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
$result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
$res = mysqli_fetch_array($result2);

$url = "detail_pps_month_reprint.php"; 
require_once('tcpdf_barcodes_2d.php');


?>

<style media="print">
@media print {
	panel 
	{
		page-break-after: always;
	}
	.tblspace
	{ 
		display: none; 
	}
	.prt-button 
	{ 
		display: none; 
	}
	
}

@page {
margin: 10mm 10mm 10mm 0;
size: landscape;
margin-left: 30px;
}

/*.forPrint{

page-break-before:avoid;
page-break-after: always;
}*/

.forPrint2{
page-break-before:always;
}

</style>

 
<?php
/*https://stackoverflow.com/questions/26868834/repeat-html-table-header-after-n-row-in-php*/
$query = "SELECT * FROM prt_sheet_pps_new_test where doc_generate='2380000063' group by work_center ";
$result = mysqli_query($dbc,$query);

while($row = mysqli_fetch_array($result))
{
	$prt_HDR = "SELECT *,DATE_FORMAT(PS.date_plan,'%d-%m-%Y') AS H FROM pps_detail_test as PS WHERE id = '".sql_esc($row['id_pps_dtl'])."' ";
	$resprt_HDR = mysqli_query($dbc,$prt_HDR);
	$dtprt_HDR = mysqli_fetch_array($resprt_HDR);
	
	?>

    <!--header-->
   <!-- <table width="200" border="2">
      <tr>
        <td>Production Planning Sheet</td>
      </tr>
    </table>-->
    <!--/n header-->
    
    <!--<table border="2">
    <thead>
    <tr>
    <th width="20">No</th>
    <th width="53">Plan No</th>      
    <th width="102">Work Center</th>
    </tr>
    </thead>-->
    
 
 
	<?php
	$dtprt_HDR = mysqli_fetch_array($resprt_HDR);
	
	$query2 = "SELECT * FROM prt_sheet_pps_new_test where doc_generate='".sql_esc($row['doc_generate'])."' and work_center = '".sql_esc($row['work_center'])."' ";
	$result2 = mysqli_query($dbc,$query2);
	
	$rows = 0;
	$n = 5;

	while($row2 = mysqli_fetch_array($result2))
	{
      
	  if ($rows % $n == 0) { //repeat after nth row   
	  //echo "break"; 
	  
    ?>
    
  
    <!--space-->
    <div class="tblspace">
	<table border="0"><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table>
    </div>
    <!--space-->
    
    <div class="forPrint2">  <!--PRINT VIEW---> 
    
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
    <?php } ?>
    
    <tbody>
    <tr>
        <td><?php echo $row2['id_pps_dtl']; ?></td>
        <td><?php echo $row2['plan_no']; ?></td> 
        <td><?php echo $row2['work_center']; ?></td>
    </tr>
    <?php $rows++;  }   ?>
    
    </tbody>
	</table>
    </div>
     
   
    
<?php }  ?>

<div class="prt-button">
  <button type="button" name="btn_release" id="btn_release" class="btn btn-success btn-sm" onClick="window.print()">Print this Page</button>
</div>