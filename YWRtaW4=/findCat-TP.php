<?php

$plant_code = $_GET['plant_code'];
$mat_type = $_GET['mat_type'];
$model_code = $_GET['model_code'];

include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	


$query42 = "SELECT * FROM category_detail WHERE plant_code = '".sql_esc($plant_code)."' AND id_cat != '4' ORDER BY id_cat ASC";
$result42 =mysqli_query($dbc,$query42);

?>

<div id="catm_div">  
<select name="stamp_ind" id="stamp_ind" class="form-control" onChange="getMaterial('<?php echo html_esc($plant_code); ?>','<?php echo html_esc($mat_type); ?>','<?php echo html_esc($model_code); ?>',this.value)" >
   <option value="NULL" placeholder="Select Category"> -- Select Category --</option>
<?php
                while($row42=mysqli_fetch_array($result42)) 
			      {
					  if($_POST['Submit19'] == true){ ?>
                       <!--RETAIN VALUE-->
                       <option value="<?php echo html_esc($row42["stamp_ind"]); ?>" <?php if($row42["stamp_ind"]==$_POST["stamp_ind"]) echo "selected"; ?>> <?php echo stripslashes($row42["stamp_desc"]); ?></option>
                       <?php }else{ ?>
                       <option value="<?php echo html_esc($row42["stamp_ind"]); ?>" > <?php echo stripslashes($row42["stamp_desc"]); ?></option>
                       <?php } ?>
	
              <?php    }
				  
				  ?>
</select></div>
