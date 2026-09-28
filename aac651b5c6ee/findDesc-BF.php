<?php
$material_no = $_GET['material_no'];
include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	

$query39T = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($material_no)."' AND status_BOM = 'Y' ORDER BY id_mat ASC";
$result39T = mysqli_query($dbc,$query39T);
$row39T = mysqli_fetch_array($result39T);
?>

<div id="mat_div"> 
 <!-- Back No. : <?php  //echo $row39T["back_no"];   ?><br />
  Part Name : <?php  //echo $row39T["material_desc"];   ?><br />       --> 
            <input class="form-control" id="back_no" type="hidden"  name="back_no" value="<?php  echo html_esc($row39T["back_no"]);   ?>" />  

</div>
   
