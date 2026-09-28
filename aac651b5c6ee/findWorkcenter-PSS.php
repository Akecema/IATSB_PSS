<?php

$plant_code = $_GET['plant_code'];
include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	


$query4 = "SELECT * FROM work_center_detail WHERE plant_code = '".sql_esc($plant_code)."' AND dept_acc = 'PRODUCTION' AND status_wc = 'Y' ORDER BY id_work ASC";
$result4 =mysqli_query($dbc,$query4);

?>

<div id="work_centerdiv">
  <select name="work_center" id="work_center" class="form-control" >
   <option value="NULL" placeholder="Select Work Center"> -- Select Work Center --</option>
<?php
                while($row4=mysqli_fetch_array($result4)) 
			      {
                  echo'<option value="',html_esc($row4["id_work"]),'">',stripslashes($row4["id_work"]),' - ',stripslashes($row4["wc_desc"]),'</option>';
                  }
				  
				  ?>
</select></div>
