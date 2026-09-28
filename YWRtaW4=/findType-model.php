<?php

$plant_code = $_GET['plant_code'];
include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	


$query68 = "SELECT * FROM material_type_tbl WHERE plant_code = '".sql_esc($plant_code)."' AND status_type = 'Y' ORDER BY id ASC";
$result68 =mysqli_query($dbc,$query68);

?>


<div id="mtype_div">
  <select name="mat_type" id="mat_type" class="form-control"  >
   <option value="NULL" placeholder="Select Type"> -- Select Type --</option>
<?php
                while($row68=mysqli_fetch_array($result68)) 
			      {
					  if($_POST['Submit12'] == true){ ?>
                       <!--RETAIN VALUE-->
                       <option value="<?php echo $row68["id"]; ?>" <?php if($row68["id"]==$_POST["mat_type"]) echo "selected"; ?>> <?php echo stripslashes($row68["mtype_name"]); ?></option>
                       <?php }else{ ?>
                       <option value="<?php echo $row68["id"]; ?>" > <?php echo stripslashes($row68["mtype_name"]); ?></option>
                       <?php } ?>
	
              <?php    }
				  
				  ?>
</select></div>
