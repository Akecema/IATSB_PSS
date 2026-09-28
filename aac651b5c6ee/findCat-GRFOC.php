<?php

$vendor_code = $_GET['vendor_code'];
$material_type = $_GET['material_type'];
$model_code = $_GET['model_code'];

include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	


$query42 = "SELECT * FROM table_material_itsb WHERE model_code = '".sql_esc($model_code)."' AND mat_type = '".sql_esc($material_type)."' AND vendor_id = '".sql_esc($vendor_code)."' AND status_foc = 'Y' GROUP BY category_mat";
$result42 =mysqli_query($dbc,$query42);

?>

<div id="catm_div">  
<select name="stamp_ind" id="stamp_ind" class="form-control" onChange="getMaterial('<?php echo html_esc($vendor_code); ?>','<?php echo html_esc($material_type); ?>','<?php echo html_esc($model_code); ?>',this.value)" >
   <option value="NULL" placeholder="Select Category"> -- Select Category --</option>
<?php
                while($row42=mysqli_fetch_array($result42)) 
			      {
					  
    
	$query_cat = "SELECT * FROM category_detail WHERE stamp_ind = '".sql_esc($row42["category_mat"])."' GROUP BY id_cat ORDER BY id_cat ASC";
    $result_cat =mysqli_query($dbc,$query_cat);
    $row_cat =mysqli_fetch_array($result_cat);
					  
					  
					  
					  
					  if($_POST['submit3'] == true){ ?>
                       <!--RETAIN VALUE-->
                       <option value="<?php echo html_esc($row42["category_mat"]); ?>" <?php if($row42["category_mat"]==$_POST["stamp_ind"]) echo "selected"; ?>> <?php echo stripslashes($row_cat["stamp_desc"]); ?></option>
                       <?php }else{ ?>
                       <option value="<?php echo html_esc($row42["category_mat"]); ?>" > <?php echo stripslashes($row_cat["stamp_desc"]); ?></option>
                       <?php } ?>
	
              <?php    }
				  
				  ?>
</select></div>
