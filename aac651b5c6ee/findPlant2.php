<?php

$comp_code = $_GET['vendor_no'];
include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	


$query41 = "SELECT * FROM plant_detail WHERE comp_code = '".sql_esc($comp_code)."' AND status_plant = 'Y' ORDER BY plant_id ASC";
$result41 =mysqli_query($dbc,$query41);

?>

<div id="work_centerdiv">
  <select name="plant_code" id="plant_code" class="form-control" >
   <option value="NULL" placeholder="Select Plant Code"> -- Select --</option>
<?php
                while($row41=mysqli_fetch_array($result41)) 
			      {
					  if($_POST['submit'] == true){ ?>
                       <!--RETAIN VALUE-->
                       <option value="<?php echo $row41["plant_code"]; ?>" <?php if($row41["plant_code"]==$_POST["plant_code"]) echo "selected"; ?>> <?php echo $row41["plant_desc"]; ?></option>
                       <?php }else{ ?>
                       <option value="<?php echo $row41["plant_code"]; ?>" > <?php echo stripslashes($row41["plant_code"]),' - ',stripslashes($row41["plant_desc"]); ?></option>
                       <?php } ?>
	
              <?php    }
				  
				  ?>
</select></div>
