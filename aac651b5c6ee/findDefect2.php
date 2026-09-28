<?php

$type_reject =intval($_GET['type_reject']);
include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	


$query4 = "SELECT * FROM type_defect_detail_prd WHERE id_type = '".sql_esc($type_reject)."' ORDER BY id_defect ASC";
$result4 = mysqli_query($dbc,$query4);

?>

<div id="defect_div">
  <select name="type_defect" id="type_defect" class="form-control" onChange="getDefectType(this.value)">
   <option value="NULL" placeholder="Select Defective"> -- Select Defective --</option>
<?php
                while($row4 = mysqli_fetch_array($result4)) 
			      {
                  echo'<option value="',$row4["id_defect"],'">',stripslashes($row4["defect_desc"]),'</option>';
                  }
				  
				  ?>
</select></div>
