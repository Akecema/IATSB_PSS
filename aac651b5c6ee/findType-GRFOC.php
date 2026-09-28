<?php

$vendor_code = $_GET['vendor_code'];
include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	


$query68 = "SELECT * FROM table_material_itsb WHERE vendor_id = '".sql_esc($vendor_code)."' AND status_foc = 'Y' GROUP BY vendor_id ORDER BY id_mat ASC";
$result68 =mysqli_query($dbc,$query68);

?>


<!--<select name="frequency" class="form-control m-b-10" onChange="getMeeting('<?php echo $idmtg; ?>','<?php echo $comp_c?>','<?php echo $yr?>',this.value)">
-->
<div id="mtype_div">
  <select name="material_type" id="material_type" class="form-control" onChange="getModel('<?php echo html_esc($vendor_code); ?>',this.value)" >
   <option value="NULL" placeholder="Select Type"> -- Select Type --</option>
<?php
                while($row68=mysqli_fetch_array($result68)) 
			      {
					  
		//--------information material type -----------			  
					  
	
		$query_typ = "SELECT * FROM material_type_tbl WHERE id = '".sql_esc($row68["mat_type"])."' AND status_type = 'Y' GROUP BY id ASC";
		$result_typ =mysqli_query($dbc,$query_typ);				  
		$row_typ =mysqli_fetch_array($result_typ);			  
					  
					  
					  if($_POST['submit3'] == true){ ?>
                       <!--RETAIN VALUE-->
                       <option value="<?php echo html_esc($row68["mat_type"]); ?>" <?php if($row68["mat_type"]==$_POST["material_type"]) echo "selected"; ?>> <?php echo stripslashes($row_typ["mtype_name"]); ?></option>
                       <?php }else{ ?>
                       <option value="<?php echo html_esc($row68["mat_type"]); ?>" > <?php echo stripslashes($row_typ["mtype_name"]); ?></option>
                       <?php } ?>
	
              <?php    }
				  
				  ?>
</select></div>
