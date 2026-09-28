<?php
include '../include/config.php';
$qty = $_POST["qty"];

$query4w = "SELECT * FROM type_defect_detail_qqc WHERE id_type = '".sql_esc($qty)."' ORDER BY id_defect ASC";
$result4w = mysqli_query($dbc,$query4w);

?>
  <select name="type_defect[]" id="type_defect" class="total form-control">
<!--   <option value="NULL" placeholder="Select Defective"> -- Select Defective --</option>
-->
<?php

                while($row4w = mysqli_fetch_array($result4w)) 
			      {
					  ?>
<option value="<?php echo $row4w["id_defect"]; ?>"><?php echo $row4w["defect_desc"]; ?></option>
<?php   }  ?>

</select>
