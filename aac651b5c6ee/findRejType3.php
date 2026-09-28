<?php

$proc_reject =intval($_GET['proc_reject']);
include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	


$query_type = "SELECT * FROM type_reject_detail_prd WHERE id_proc = '".sql_esc($proc_reject)."' AND status_type = 'Y' ORDER BY id_type ASC";
$result_type = mysqli_query($dbc,$query_type);
?>

<div id="rtype_div">
   <select name="type_reject" id="type_reject" class="form-control" onChange="getRejType(this.value)">
  <option value="NULL" placeholder="Select Type of Reject"> -- Select Type of Reject --</option>
<?php
                 while($row_type = mysqli_fetch_array($result_type)) 
			      {
					  
				   ?>
                     <?php if($_POST["con_bfhwork"] == true)  
		         {   ?>
                    <option value="<?php echo $row_type["id_type"]; ?>"<?php if($row_type["id_proc"] == $proc_reject) echo "selected"; ?>> <?php echo $row_type["type_desc"]; ?></option>
                     
                  <?php
				 }else{
				  
				  ?> 
                  <option value="<?php echo $row_type["id_type"]; ?>"> <?php echo $row_type["type_desc"]; ?></option>
                  <?php
				    }  // else
				  
                  }
				?>
</select></div>

