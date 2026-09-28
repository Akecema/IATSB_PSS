<?php

$type_defect =intval($_GET['type_defect']);
include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	


$query41 = "SELECT * FROM type_defect_detail_prd WHERE id_defect = '".sql_esc($type_defect)."' ORDER BY id_defect ASC";
$result41 = mysqli_query($dbc,$query41);
$data_41 = mysqli_fetch_array($result41);
?>

<div id="reason_div">
<input class="form-control" id="reason_reject" type="text"  name="reason_reject" value="<?php if(isset($_POST['reason_reject'])){ echo $_POST['reason_reject']; }else { echo $data_41["id_reason"];  } ?>" />


 </div>
