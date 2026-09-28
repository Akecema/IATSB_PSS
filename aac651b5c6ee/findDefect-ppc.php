<?php 
include '../include/config.php';


$request = 0;

if(isset($_POST['request'])){
   $request = $_POST['request'];
}

// Type of Reject
if($request == 1){
   
   $pRejc = $_POST['pRejc'];
   
?>

    <select name="type_reject[]" id="type_reject" class="Trejc form-control" >
      <option value="" placeholder="Select Type of Reject"> -- Select Type of Reject --</option>
      <?php
       $query_type = "SELECT * FROM type_reject_detail_ppc WHERE id_proc = '".sql_esc($pRejc)."' AND status_type = 'Y' ORDER BY id_type ASC";
       $result_type = mysqli_query($dbc,$query_type);

       while($row_type = mysqli_fetch_array($result_type)) 
       {   
       ?>
      <option value="<?php echo $row_type["id_type"]; ?>"> <?php echo $row_type["type_desc"]; ?></option>
      <?php 
       }
      ?>
  </select>
    
<?php
}
?>


<?php

//defectives
if($request == 2){

	$tRejc = $_POST['tRejc'];

?>
	
	<select name="typeDefect[]" class=" form-control">
	<option value="">-- Select Defective --</option>
	<?php
	
	$sIndcX = "SELECT * FROM type_defect_detail_qqc WHERE id_type = '".sql_esc($tRejc)."' ";
	$rs_IndcX = mysqli_query($dbc,$sIndcX);
	
	while($row_fcatX = mysqli_fetch_assoc($rs_IndcX))
	{ 
	?>
	<option value="<?php echo $row_fcatX['id_defect']; ?>"> <?php echo $row_fcatX['defect_desc']; ?></option>
	<?php
	}
	?>
	</select>
	
<?php
}
?>
