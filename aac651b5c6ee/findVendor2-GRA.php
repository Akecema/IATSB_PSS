<?php

$plant_code = $_GET['plant_code'];
include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	


$query41 = "SELECT * FROM vendor_detail WHERE plant_code = '".sql_esc($plant_code)."' ORDER BY vendor_code ASC";
$result41 =mysqli_query($dbc,$query41);

?>


   			<div id="vendordiv">
              <select name="vendor_id" id="vendor_id" class="form-control">
              <option value="NULL" placeholder="Select Vendor"> -- Select Vendor --</option>
    
              
          
	<?php
  while($row41=mysqli_fetch_array($result41)) 
    {
		 if($_POST['Submit22'] == true){ ?>
                       <!--RETAIN VALUE-->
                       <option value="<?php echo html_esc($row41["vendor_code"]); ?>" <?php if($row41["vendor_code"]== $vendor_id) echo "selected"; ?>> <?php echo stripslashes($row41["vendor_code"]),' - ',stripslashes($row41["vendor_name"]); ?></option>
                       <?php } //else{ ?>
	
        
      <option value="<?php echo html_esc($row41["vendor_code"]); ?>" > <?php  echo html_esc($row41["vendor_code"]); ?> - <?php echo html_esc($row41["vendor_name"]); ?></option>
    
    <?php    // }
    
	}
    ?>
</select></div>


