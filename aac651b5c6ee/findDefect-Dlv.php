
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
      <option value="" placeholder="Select Type of Reject"> -- Select Type of Reject xx--</option>
      <?php
       $query_type = "SELECT * FROM type_reject_detail_ppcdlv  WHERE id_proc = '".sql_esc($pRejc)."' AND status_type = 'Y' ORDER BY id_proc ASC";
       $result_type = mysqli_query($dbc,$query_type);

       while($row_type = mysqli_fetch_array($result_type)) 
       {   
       ?>
      <option value="<?php echo html_esc($row_type["id_type"]); ?>">  <?php echo html_esc($row_type["type_desc"]); ?></option>
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
	
	$sIndcX = "SELECT * FROM type_defect_detail_ppcdlv WHERE id_type = '".sql_esc($tRejc)."' ORDER BY id_defect ASC";
	$rs_IndcX = mysqli_query($dbc,$sIndcX);
	
	while($row_fcatX = mysqli_fetch_assoc($rs_IndcX))
	{ 
	?>
	<option value="<?php echo html_esc($row_fcatX['id_defect']); ?>"><?php echo html_esc($row_fcatX['defect_desc']); ?></option>
	<?php
	}
	?>
	</select>
	
<?php
}
?>

