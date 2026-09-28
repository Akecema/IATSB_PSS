<?php
$purc_ord_no = $_GET['purc_ord_no'];
include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	


$query41 = "SELECT * FROM po_detail WHERE purc_ord_no = '".sql_esc($purc_ord_no)."' GROUP BY purc_ord_no ORDER BY purc_ord_no ASC";
$result41 =mysqli_query($dbc,$query41);
$row41=mysqli_fetch_array($result41);

//-------check vendor detail ----------

$query42 = "SELECT * FROM vendor_detail WHERE vendor_code = '".sql_esc($row41["vendor_id"])."'";
$result42 = mysqli_query($dbc,$query42);
$row42 = mysqli_fetch_array($result42);


?>

<div id="vendordiv">

<input class="form-control" id="vendor_id" type="text" placeholder="Enter Delivery Order No." name="vendor_id" value="<?php if(isset($_POST['vendor_id'])){ echo html_esc($_POST['vendor_id']); } else { echo html_esc($row41["vendor_id"]). ' - ' .html_esc($row42["vendor_name"]); } ?>" />


<!--echo $row41["vendor_id"]. '-' .$row42["vendor_name"];  -->
</div>
