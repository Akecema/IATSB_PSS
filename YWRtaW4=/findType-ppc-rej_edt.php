<?php

$id_proc = $_GET['id_proc'];
include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	


$query68 = "SELECT * FROM type_reject_detail_ppc WHERE id_proc = '".sql_esc($id_proc)."' AND status_type = 'Y' ORDER BY id_type ASC";
$result68 =mysqli_query($dbc,$query68);

?>


<div id="mtype_div">
  <select name="id_type" id="id_type" class="form-control" onChange="getDType(this.value)">
   <option value="NULL" placeholder="Select Type"> -- Select Type -- </option>
<?php
                while($row68=mysqli_fetch_array($result68)) 
			      {
					
                      if($_POST['submit9'] == true){ ?>
                       <!--RETAIN VALUE-->
                       <option value="<?php echo html_esc($row68["id_type"]); ?>" <?php if($row68["id_type"]==$_GET["id_type"]) echo "selected"; ?>> <?php echo stripslashes($row68["id_type"]),' - ',stripslashes($row68["type_desc"]); ?></option>
                       <?php }else{ ?>
                       <option value="<?php echo html_esc($row68["id_type"]); ?>" > <?php echo stripslashes($row68["id_type"]),' - ',stripslashes($row68["type_desc"]); ?></option>
                       <?php } ?>          
                    
                    
                      
              <?php    }
				  
				  ?>
</select></div>
