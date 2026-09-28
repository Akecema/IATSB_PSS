<?php
$plant_code = $_GET['plant_code'];
$material_type = $_GET['material_type'];
$model_code = $_GET['model_code'];
$stamp_ind = $_GET['stamp_ind'];

include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	

$query59 = "SELECT * FROM table_material_itsb WHERE plant_code = '".sql_esc($plant_code)."' AND mat_type = '".sql_esc($material_type)."' AND model_code = '".sql_esc($model_code)."' AND category_mat = '".sql_esc($stamp_ind)."' AND status_BOM = 'Y' GROUP BY prod_line ORDER BY id_mat ASC";
$result59 = mysqli_query($dbc,$query59);

?>

   			<div id="work_div"> 
              <select name="work_center" id="work_center" class="form-control" onChange="getMaterial('<?php echo $plant_code; ?>','<?php echo $material_type; ?>','<?php echo $model_code; ?>','<?php echo $stamp_ind; ?>',this.value)">
              <option value="NULL" placeholder="Select Section/Line"> -- Select Section/Line --</option>
          
	<?php
  while($row59=mysqli_fetch_array($result59)) 
    {
		
	
    ?>
      <option value="<?php echo $row59["prod_line"]; ?>" > <?php echo $row59["prod_line"]; ?> </option>
    
    <?php     }
    
    ?>
</select></div>
   
