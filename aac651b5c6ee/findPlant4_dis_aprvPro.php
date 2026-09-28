<?php

$plant_code = $_GET['plant_code'];
include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	


$query41 = "SELECT * FROM work_center_detail WHERE plant_code = '".sql_esc($plant_code)."' AND dept_acc = 'PRODUCTION' AND status_wc = 'Y'  ORDER BY id_work ASC";
$result41 =mysqli_query($dbc,$query41);

?>

<div id="work_centerdiv">
  <select name="work_center" id="work_center" class="form-control">
   <option value="NULL" placeholder="Select Line"> -- Select Line --</option>
<?php
                while($row41=mysqli_fetch_array($result41)) 
			      {
					  if($_POST['Submit2'] == true){ ?>
                       <!--RETAIN VALUE-->
                       <option value="<?php echo html_esc($row41["id_work"]); ?>" <?php if($row41["id_work"]==$_POST["work_center"]) echo "selected"; ?>> <?php echo stripslashes($row41["id_work"]),' - ',stripslashes($row41["wc_desc"]); ?></option>
                       <?php }else{ ?>
                       <option value="<?php echo html_esc($row41["id_work"]); ?>" > <?php echo stripslashes($row41["id_work"]),' - ',stripslashes($row41["wc_desc"]); ?></option>
                       <?php } ?>
	
              <?php    }
				  
				  ?>
</select></div>
