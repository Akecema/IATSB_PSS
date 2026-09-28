<?php

$plan_category = $_GET['plan_category'];
include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	


//CR status (Released)
$sta2 = "SELECT * from request_status WHERE status_id = '2'";
$sta_res2 = mysqli_query($dbc,$sta2);
$rst_sta2 = mysqli_fetch_array($sta_res2);


$query41 = "SELECT * FROM table_material_itsb WHERE category_mat = '".sql_esc($plan_category)."' AND (Vclass = 'Z201' OR Vclass = 'Z301') AND status_BOM = 'Y' ORDER BY id_mat ASC";
$result41 =mysqli_query($dbc,$query41);

?>

<div id="back_nodiv">
  <select name="material_no" id="material_no" class="form-control"  >
   <option value="NULL" placeholder="Select Part No."> -- Select Part No. --</option>
<?php
                while($row41=mysqli_fetch_array($result41)) 
			      {
					  if($_POST['Submit2'] == true){ ?>
                       <!--RETAIN VALUE-->
                       <option value="<?php echo $row41["material_no"]; ?>" <?php if($row41["material_no"]==$_POST["material_no"]) echo "selected"; ?>>(<?php echo stripslashes($row41["back_no"]); ?>)&nbsp;<?php echo stripslashes($row41["material_no"]); ?> - <?php echo stripslashes($row41["material_desc"]); ?></option>
                       <?php }else{ ?>
                       <option value="<?php echo $row41["material_no"]; ?>" >(<?php echo stripslashes($row41["back_no"]); ?>)&nbsp;<?php echo stripslashes($row41["material_no"]); ?> - <?php echo stripslashes($row41["material_desc"]); ?> </option>
                       <?php } ?>
	
              <?php    }
				  
				  ?>
</select></div>
