<?php
    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "display_model_table.php"; 
	
//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	

//--------menu function ------------------------------

$query_function = "SELECT * FROM function_acc_detail WHERE staff_ID = '".sql_esc($res["staff_ID"])."'";
$result_function = mysqli_query($dbc,$query_function);   //run the query.
//$data_function = mysqli_fetch_array($result_function);   //how many records are there?  

//----------------------------------------------------

//CR status (New)

$sta = "SELECT * from request_status WHERE status_id = '1'";
$sta_res = mysqli_query($dbc,$sta);
$rst_sta = mysqli_fetch_array($sta_res);

//CR status (Released)
$sta2 = "SELECT * from request_status WHERE status_id = '2'";
$sta_res2 = mysqli_query($dbc,$sta2);
$rst_sta2 = mysqli_fetch_array($sta_res2);


//CR status (Approved)
$sta3 = "SELECT * from request_status WHERE status_id = '3'";
$sta_res3 = mysqli_query($dbc,$sta3);
$rst_sta3 = mysqli_fetch_array($sta_res3);

//CR status (In Progress)
$sta7 = "SELECT * from request_status WHERE status_id = '7'";
$sta_res7 = mysqli_query($dbc,$sta7);
$rst_sta7 = mysqli_fetch_array($sta_res7);

//CR status (Pending)
$sta8 = "SELECT * from request_status WHERE status_id = '8'";
$sta_res8 = mysqli_query($dbc,$sta8);
$rst_sta8 = mysqli_fetch_array($sta_res8);

//CR status (Completed)
$sta14 = "SELECT * from request_status WHERE status_id = '14'";
$sta_res14 = mysqli_query($dbc,$sta14);
$rst_sta14 = mysqli_fetch_array($sta_res14);

//CR status (Deleted)
$sta16 = "SELECT * from request_status WHERE status_id = '16'";
$sta_res16 = mysqli_query($dbc,$sta16);
$rst_sta16 = mysqli_fetch_array($sta_res16);

	?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo $data_setup["tajuk_sys"]; ?>">
    <title><?php echo $data_setup["title_desc"]; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    
    <script>
    (function() {
    'use strict';
    window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
    form.addEventListener('submit', function(event) {
    if (form.checkValidity() === false) {
    event.preventDefault();
    event.stopPropagation();
    }
    form.classList.add('was-validated');
    }, false);
    });
    }, false);
    })();
    
    </script>
	<SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  </head>
  <body class="app sidebar-mini">

<?php
if (isset($_POST['submit9']))
{
$id_model = $_POST['id_model'];
$model_desc = $_POST['model_desc'];
$plant_code = $_POST['plant_code'];
$code_model = $_POST['code_model'];
$status_model = $_POST['status_model'];
$services_part = $_POST['services_part'];
$material_type = $_POST['material_type'];

$message = NULL; // create an empty new variable.

$i = 1;

//------------------------------end function --------------------------------
// check for a model_desc.
if (empty($_POST['model_desc']))
{ 
  $model_desc = FALSE;

  }else
  { $model_desc = addslashes($_POST['model_desc']);
  }
  
// check for a plant code
if (empty($_POST['plant_code'])) 
{ 
  $plant_code = FALSE;
   }
    else
  { $plant_code = addslashes($_POST['plant_code']);
  }


// check for a material type
if (($_POST['material_type']) == "NULL") 
{ 
    $material_type = FALSE;
   }
    else
  {
	$material_type = addslashes($_POST['material_type']);
  }

// check for a status model
if (($_POST['status_model']) == "NULL") 
{ 
    $status_model = FALSE;
   }
    else
  {
	$status_model = addslashes($_POST['status_model']);
  }

  // check for a services part
if (($_POST['services_part']) == "NULL") 
{ 
    $services_part = FALSE;
   }
    else
  {
	$services_part = addslashes($_POST['services_part']);
  }

   
 if($model_desc && $plant_code && $material_type && $status_model && $services_part) //everything ok
{     

	$id_model = $_POST['id_model'];
	$model_desc = $_POST['model_desc'];
	$plant_code = $_POST['plant_code'];
	$code_model = $_POST['code_model'];
	$status_model = $_POST['status_model'];
  $services_part = $_POST['services_part'];
	$material_type = $_POST['material_type'];
	
		  	  $query_search = "SELECT * FROM model_detail_tbl WHERE id_model = '".sql_esc($id_model)."'";
              $result_search = mysqli_query($dbc,$query_search);   //run the query.
              $num_search = mysqli_num_rows($result_search);   //how many suppliers are there?
			  
			  if($num_search == 1) {
			  //echo $num_search; 
			    $row = mysqli_fetch_array($result_search);
				// make the update query
	
		$query_upd = "UPDATE model_detail_tbl SET model_desc = '".sql_esc($model_desc)."', plant_code = '".strtoupper($plant_code)."', material_type = '".sql_esc($material_type)."', status_model = '".sql_esc($status_model)."'  WHERE id_model = '".sql_esc($id_model)."'"; 
		$result_upd = mysqli_query($dbc,$query_upd); 
								
			if($result_upd)
			{
			 echo "<script>";
		     echo "alert('Model is successfully update.');";
			 echo "window.location='display_model_table.php'";
			 echo "</script>"; 
		     exit(); //quit the script
			
							
  } else { echo 'Cannot update record'; 
  }
}
//print the message if there is one.
	  
} 
} 
 ?> 
  <div class="modal fade" id="myNoteEditM<?php echo $row2["id_model"]; ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">   
        <!-- <div class="modal-dialog" style="overflow-y: scroll; max-height:85%;  margin-top: 50px; margin-bottom:50px;" > -->     
         <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Edit Model of Material</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Model of Material</strong>
       </div>
      <?php
	 
$query_modA = "SELECT * FROM model_detail_tbl WHERE id_model = '".sql_esc($row2["id_model"])."'";
$result_modA = mysqli_query($dbc,$query_modA);   //run the query.
$row_modA = mysqli_fetch_array($result_modA);   //how many records are there?
     
   ?>
    <form name="formEdit" method="post" action="" class="needs-validation"  novalidate>
   <table width="100%" cellspacing="5">
   <tr>
    <td width="191">ID Model </td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="id_model" name="id_model" readonly value="<?php  echo $row_modA["id_model"]; ?>" class="form-control"></td>
    </tr>
     <tr>
    <td width="191">Model Code </td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="model_code" name="model_code" readonly value="<?php  echo $row_modA["model_code"]; ?>" class="form-control"></td>
    </tr>
  <tr>
    <td>Model Description <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td><input type="text" id="model_desc" name="model_desc" value="<?php echo $row_modA["model_desc"]; ?>" class="form-control" required /><div class="invalid-feedback">Please enter model description.</div></td>
    </tr>
    <tr>
    <td>Plant Code<font color="#FF0000">*</font></td>
    <td>:</td>
    <td>
      <select name="plant_code" class="form-control" >
                  <option value="NULL" placeholder="Select Plant"> -- Select Plant -- </option>
                  <?php
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM plant_detail WHERE status_plant = "Y"';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
              ?>
                  <option value="<?php echo $row27["plant_code"]; ?>" <?php if($row27["plant_code"] == $row_modA["plant_code"]) echo "selected"; ?>> <?php echo stripslashes($row27["plant_code"]); ?> - <?php echo $row27["plant_desc"]; ?></option>
                  <?php
           }  ?>
                </select>
     <div class="invalid-feedback">Please select plant code of model.</div>
     </td>
    </tr>
     <tr>
    <td>Material Type<font color="#FF0000">*</font></td>
    <td>:</td>
    <td>
      <select name="material_type" class="form-control" >
                  <option value="NULL" placeholder="Select Material Type"> -- Select Material Type -- </option>
                  <?php
          //Retrieve and display the available types
          $query77 = "SELECT * FROM material_type_tbl WHERE status_type = 'Y' AND plant_code = '".sql_esc($row_modA["plant_code"])."'";
          $result77 = mysqli_query($dbc,$query77);
          
              while($row77 = mysqli_fetch_array($result77)) {
        
              ?>
                  <option value="<?php echo $row77["id"]; ?>" <?php if($row77["id"] == $row_modA["material_type"]) echo "selected"; ?>><?php echo $row77["mtype_name"]; ?></option>
                  <?php
           }  ?>
                </select>
     <div class="invalid-feedback">Please select material type.</div>
     </td>
    </tr>
    <tr>
    <td>Status Model <font color="#FF0000">*</font></td>
    <td>:</td>
    <td> 
	            <select name="status_model" id="status_model" class="form-control">
                   <?php if($_POST['submit9'] == true)
						{ ?>
               <option value="Y" <?php if($_POST["status_model"] == 'Y') { ?> selected="selected"<?php } ?>>ACTIVE</option>
               <option value="N" <?php if($_POST["status_model"] == 'N') { ?> selected="selected"<?php } ?>>INACTIVE</option>
               <?php 
						}
						else
						{ ?>
               <option value="Y" <?php if($row_modA["status_model"] == 'Y') { ?> selected="selected"<?php } ?>>ACTIVE</option>
               <option value="N" <?php if($row_modA["status_model"] == 'N') { ?> selected="selected"<?php } ?>>INACTIVE</option>
               <?php } ?>
                 </select>
	 <div class="invalid-feedback">Please select status account.</div>
	</td>
    </tr>
    <tr>
    <td>Services Part <font color="#FF0000">*</font></td>
    <td>:</td>
    <td> 
	            <select name="services_part" id="services_part" class="form-control">
                   <?php if($_POST['submit9'] == true)
						{ ?>
               <option value="Y" <?php if($_POST["services_part"] == 'Y') { ?> selected="selected"<?php } ?>>YES</option>
               <option value="N" <?php if($_POST["services_part"] == 'N') { ?> selected="selected"<?php } ?>>NO</option>
               <?php 
						}
						else
						{ ?>
               <option value="Y" <?php if($row_modA["services_part"] == 'Y') { ?> selected="selected"<?php } ?>>YES</option>
               <option value="N" <?php if($row_modA["services_part"] == 'N') { ?> selected="selected"<?php } ?>>NO</option>
               <?php } ?>
                 </select>
	 <div class="invalid-feedback">Please select services part.</div>
	</td>
    </tr>
    <tr>
    <td><font color="#FF0000"><b>  * Compulsory field</b></font></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
   </table>                         
       </div> <!-- card -->
       </div><!-- /# card -->
       <br />

              
              <div class="modal-footer"> 
             <input type="hidden" id="code_model" name="code_model"  class="form-control" value="<?php echo $row2["id_model"];  ?>" >  
             <input name="submit9" type="submit" id="submit9" value="UPDATE" class="btn btn-info" onClick="return confirm('Confirm to update?');" > 
             <button type="button" class="btn btn-success" data-dismiss="modal">CLOSE</button>
             </div>  
            
    </form>  
                  </div></div>
                  </div>
                  </div>
                  </div>
                  </div>
</body>
</html>