<?php

/*https://makitweb.com/dynamically-load-content-in-bootstrap-modal-with-ajax/*/

include '../include/config.php';

if(isset($_POST['e_tcid']))
{ 
	$trc_id = $_POST['e_tcid'];

	$n = count($trc_id);
	
	?>
	
	<table class="table-bordered" style="width:1000px">
      <thead>
        <tr>
        <th>No.</th>
        <th>Back No.</th>
        <th>Part Number</th>
        <th>Part Name</th>
        <th>Planned Order No.</th>
        <th>Planned Date</th>  
        <th>Line</th>
        <th>Shift</th>
        <th>Plan Quantity</th>
        </tr>
      </thead>
      <tbody>
      
      
    <?php
	
	$no = 1;
	
	for($i=0; $i<$n; $i++)
	{	

		
		$sql_A = "select * from pps_detail where id = '".sql_esc($trc_id[$i])."' ";
		$result_A = mysqli_query($dbc,$sql_A);
		$row2 = mysqli_fetch_array($result_A);
			
		$id = $row2['id'];
		$emp_name = $row2['material_no'];
		$salary = $row2['comp_code'];
		$gender = $row2['material_no'];
		$city = $row2['date_plan'];
		$email = $row2['plant_code'];
		
		//shift	
		if($row2["shift_pps1"] != "")
		{
			$sta = "D/S";
		}
		elseif($row2["shift_pps2"] != "")
		{
			$sta = "N/S";
		}
		else
		{
			$sta = " ";
		}	
		
		
        
          //----model ---
  
 $query_Mod = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($row2["work_center"])."' AND status_wc = 'Y' ORDER BY id ASC";
 $result_Mod = mysqli_query($dbc,$query_Mod);
 $row_Mod = mysqli_fetch_array($result_Mod);  
 
  if($row_Mod["wc_desc2"] == "")
  {
	  $model_nameC = $row_Mod["id_work"];
  }else{
	  
	 $model_nameC = $row_Mod["wc_desc2"]; 
  }
	
	//----table material info ----------
	
		$query_matC = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($row2["material_no"])."' AND status_BOM = 'Y'";
	    $result_matC = mysqli_query($dbc,$query_matC);
        $row_matC = mysqli_fetch_array($result_matC); 
	 	
        
      ?>  
		
		<tr>
        <td width="2%"><?php echo $no; ?></td>
        <td width="3%"><?php echo  $row2["back_no"]; ?></td>
        <td width="10%"><?php echo $row2["material_no"]; ?></td>
        <td width="10%"><?php echo $row_matC["material_desc"]; ?></td>
        <td width="8%"><font color="#0000CC"><?php echo $row2["plan_no"]; ?></font></td>
        <td width="5%" bgcolor="#E8F6F3">
        <input type="date" name="date_plan[]" class="input-xlarge datepicker" value="<?php echo $row2["date_plan"]; ?>" <?php if(isset($_POST["date_plan"][($row2["id"])])) { echo $_POST["date_plan"][($row2["id"])]; } ?>> 
        </td>
        <td width="8%"><?php echo $model_nameC; ?></td>
        <td width="8%" bgcolor="#E8F6F3">
        <select name="shift_ops2[]" id="shift_ops2" class="form-control">
          <option value="NULL" placeholder="Select Shift"> -- Select Shift --</option>
          <option value="D/S" <?php if($row2["shift_pps1"] == "D/S") { ?> selected="selected"<?php } ?>>D/S</option>
          <option value="N/S" <?php if($row2["shift_pps2"] == "N/S") { ?> selected="selected"<?php } ?>>N/S</option>
        </select>
        </td>
     
        <td width="5%" bgcolor="#E8F6F3" contenteditable="true" onBlur="saveToDatabase(this,'qty_plan','<?php echo $row2["id"]; ?>')" onClick="showEdit(this);"><?php echo $row2["qty_plan"]; ?><?php //echo intval($row2["qty_plan"],0); ?></td>
      
       <input name="tid[]" type="hidden" value="<?php echo $row2["id"]; ?> ">   
       <input name="uid" type="hidden" value="<?php echo $row2["upload_id"]; ?> ">    
       <input name="date1" type="hidden" value="<?php echo $date1_final; ?> "> 
       <input name="date2" type="hidden" value="<?php echo $date2_final; ?> "> 
       <input name="plan_category" type="hidden" value="<?php echo $plan_category; ?>">  
       <input name="material_no" type="hidden" value="<?php echo $material_no; ?>"> 
       <input name="shift_ops" type="hidden" value="<?php echo $shift_ops; ?>"> 
       
      </tr> 
		
	<?php
	$no++;
	}
	?>

	</tbody>
   </table>
      
<?php
}



?>


