<?php
$plant_code = $_GET['plant_code'];
$model_code = $_GET['model_code'];
include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	

$query39 = "SELECT * FROM table_material_itsb WHERE plant_code = '".sql_esc($plant_code)."' AND model_code = '".sql_esc($model_code)."' AND status_BOM = 'Y' ORDER BY id_mat ASC";
$result39 = mysqli_query($dbc,$query39);

?>

   			<div id="mat_div"> 
              <select name="material_no" id="material_no" class="form-control">
              <option value="NULL" placeholder="Select Part Number"> -- Select Part Number --</option>
          
	<?php
  while($row39=mysqli_fetch_array($result39)) 
    {
		
	
    ?>
      <option value="<?php echo $row39["material_no"]; ?>" > <?php echo $row39["material_no"]; ?> - <?php echo $row39["material_desc"]; ?></option>
    
    <?php     }
    
    ?>
</select></div>
   
