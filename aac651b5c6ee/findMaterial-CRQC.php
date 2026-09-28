<?php
$plant_code = $_GET['plant_code'];
$material_type = $_GET['material_type'];
$model_code = $_GET['model_code'];
$stamp_ind = $_GET['stamp_ind'];
$work_center = $_GET['work_center'];

include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	

$query39 = "SELECT * FROM table_material_itsb WHERE plant_code = '".sql_esc($plant_code)."' AND mat_type = '".sql_esc($material_type)."' AND model_code = '".sql_esc($model_code)."' AND category_mat = '".sql_esc($stamp_ind)."' AND prod_line = '".sql_esc($work_center)."' AND status_BOM = 'Y' ORDER BY id_mat ASC";
$result39 = mysqli_query($dbc,$query39);

?>

   			<div id="mat_div"> 
              <select name="material_no" id="material_no" class="form-control">
              <option value="NULL" placeholder="Select Part Number"> -- Select Part Number --</option>
          
	<?php
  while($row39=mysqli_fetch_array($result39)) 
    {
		
	
    ?>
      <option value="<?php echo html_esc($row39["material_no"]); ?>" > <?php echo html_esc($row39["material_no"]); ?> - <?php echo html_esc($row39["material_desc"]); ?></option>
    
    <?php     }
    
    ?>
</select></div>
   
