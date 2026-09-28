<?php
$vendor_code = $_GET['vendor_code'];
$material_type = $_GET['material_type'];

include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	


$query41 = "SELECT * FROM table_material_itsb WHERE vendor_id = '".sql_esc($vendor_code)."' AND mat_type = '".sql_esc($material_type)."' AND status_foc = 'Y' GROUP BY model_code ORDER BY id_mat ASC";
$result41 =mysqli_query($dbc,$query41);


?>


<div id="model_div">
  <select name="model_code" id="model_code" class="form-control" onChange="getCategory('<?php echo html_esc($vendor_code); ?>','<?php echo html_esc($material_type); ?>',this.value)" >
   <option value="NULL" placeholder="Select Model"> -- Select Model --</option>
<?php
                while($row41=mysqli_fetch_array($result41)) 
			      {
					  
			//--------information model -----------			  
					  
	
	$query_mdl = "SELECT * FROM model_detail_tbl WHERE id_model = '".sql_esc($row41["model_code"])."' AND status_model = 'Y' ORDER BY id_model";
    $result_mdl =mysqli_query($dbc,$query_mdl);				  
	$row_mdl =mysqli_fetch_array($result_mdl);			  
					  		  
					  
					  
					  
					  
					  if($_POST['submit3'] == true){ ?>
                       <!--RETAIN VALUE-->
                       <option value="<?php echo html_esc($row41["model_code"]); ?>" <?php if($row41["model_code"]==$_POST["model_code"]) echo "selected"; ?>> <?php echo stripslashes($row_mdl["model_desc"]); ?></option>
                       <?php }else{ ?>
                       <option value="<?php echo html_esc($row41["model_code"]); ?>" > <?php echo stripslashes($row_mdl["model_desc"]); ?></option>
                       <?php } ?>
	
              <?php    }
				  
				  ?>
</select></div>
