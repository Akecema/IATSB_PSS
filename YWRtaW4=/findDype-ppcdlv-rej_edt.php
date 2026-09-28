<?php

$id_proc = $_GET['id_proc'];
$id_type = $_GET['id_type'];

include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	


$queryF = "SELECT * FROM  type_defect_detail_ppcdlv WHERE id_proc = '".sql_esc($id_proc)."' AND id_type = '".sql_esc($id_type)."' AND status_defect = 'Y' ORDER BY id_defect ASC";
$resultF =mysqli_query($dbc,$queryF);

?>


<div id="dtype_div">
  <select name="defect_code" id="defect_code" class="form-control"  >
   <option value="NULL" placeholder="Select Defectives"> -- Select Defectives -- </option>
<?php
                while($rowF = mysqli_fetch_array($resultF)) 
			      {
					
                    
                    if($_POST['submit9'] == true){ ?>
                       <!--RETAIN VALUE-->
                      <option value="<?php echo $rowF["id_defect"]; ?>" <?php if($rowF["id_defect"]==$_GET["id_defect"]) echo "selected"; ?>> <?php echo stripslashes($rowF["id_defect"]),' - ',stripslashes($rowF["defect_desc"]); ?></option>
                       <?php }else{ ?>
                       <option value="<?php echo $rowF["id_defect"]; ?>" > <?php echo stripslashes($rowF["id_defect"]),' - ',stripslashes($rowF["defect_desc"]); ?></option>
                       <?php } ?>
                      
              <?php    }
				  
				  ?>
</select></div>
