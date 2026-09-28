<?php
$plant_code = $_GET['plant_code'];
$mat_type = $_GET['mat_type'];

include '../include/config.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	


$query41 = new PreparedSql("SELECT * FROM model_detail_tbl WHERE material_type = ? AND plant_code = ? AND status_model = 'Y' ORDER BY id_model ASC", [$mat_type, $plant_code]);
$result41 =db_query($dbc, $query41);

?>


<div id="model_div">
  <select name="model_code" id="model_code" class="form-control"  >
   <option value="NULL" placeholder="Select Model"> -- Select Model --</option>
<?php
                while($row41=mysqli_fetch_array($result41)) 
			      {
					  if($_POST['submit'] == true){ ?>
                       <!--RETAIN VALUE-->
                       <option value="<?php echo html_esc($row41["id_model"]); ?>" <?php if($row41["id_model"]==$_POST["model_code"]) echo "selected"; ?>><?php echo stripslashes($row41["model_code"]); ?> - <?php echo stripslashes($row41["model_desc"]); ?></option>
                       <?php }else{ ?>
                       <option value="<?php echo html_esc($row41["id_model"]); ?>" > <?php echo stripslashes($row41["model_code"]); ?> - <?php echo stripslashes($row41["model_desc"]); ?></option>
                       <?php } ?>
	
              <?php    }
				  
				  ?>
</select></div>
