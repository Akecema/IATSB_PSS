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

   <select class="total form-control form-control-sm" name="typeRej[]" id="typeRej">
	<option value="" placeholder="Select Type of Reject"> -- Select Type of Reject --</option>
	<?php
	
	$sIndc = "SELECT * FROM type_reject_detail_qqc WHERE id_proc = '".sql_esc($pRejc)."' AND status_type = 'Y' ORDER BY id_type ASC ";
	$rs_Indc = mysqli_query($dbc,$sIndc);
	
	while($row_fcat = mysqli_fetch_assoc($rs_Indc))
	{ 
	?>
	<option value="<?php echo html_esc($row_fcat['id_type']); ?>"> <?php echo html_esc($row_fcat['type_desc']); ?></option>
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
	
	<select name="typeDefect[]" class="totaldf form-control form-control-sm">
	<option value="">-- Select Defective --</option>
	<?php
	
	$sIndcX = "SELECT * FROM type_defect_detail_qqc WHERE id_type = '".sql_esc($tRejc)."' ";
	$rs_IndcX = mysqli_query($dbc,$sIndcX);
	
	while($row_fcatX = mysqli_fetch_assoc($rs_IndcX))
	{ 
	?>
	<option value="<?php echo html_esc($row_fcatX['id_defect']); ?>"> <?php echo html_esc($row_fcatX['defect_desc']); ?></option>
	<?php
	}
	?>
	</select>
	
<?php
}
?>
