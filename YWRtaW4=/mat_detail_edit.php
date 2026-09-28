<?php
    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "mat_detail_table.php"; 
	
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
if (isset($_POST['Submit19']))
{

$id_mat = $_POST['id_mat'];
$material_no = $_POST['material_no'];
$material_desc = $_POST['material_desc'];
$mat_type = $_POST['mat_type'];
$material_group = $_POST['material_group'];
$model_code = $_POST['model_code'];
$mat_group = $_POST['mat_group'];
$acc_group = $_POST['acc_group'];
$plant_code = $_POST['plant_code'];
$sloc = $_POST['sloc'];
$Vclass = $_POST['Vclass'];
$cust_part_no = $_POST['cust_part_no'];
$material_desc_cust = $_POST["material_desc_cust"];
$prod_part_no = $_POST['prod_part_no'];
$prod_line = $_POST['prod_line'];
$category_mat = $_POST['category_mat'];
$std_packaging = $_POST['std_packaging'];
$type_package = $_POST['type_package'];
$part_side = $_POST['part_side'];
$back_no = $_POST['back_no'];
$size_dim = $_POST['size_dim'];
$pp_log_no = $_POST['pp_log_no'];
$pp_log_desc = $_POST['pp_log_desc'];
$vendor_id = $_POST['vendor_id'];
$cust_code = $_POST['cust_code'];
$cust_name = $_POST['cust_name'];
$BUn = $_POST['BUn'];
$status_BOM = $_POST['status_BOM'];
$status_foc = $_POST['status_foc'];
$status_sp = $_POST['status_sp'];

$message = NULL; // create an empty new variable.


//------------------------------end function --------------------------------
// check for a material No.
if (empty($_POST['material_no']))
{ $material_no = FALSE;
 
  }else
  { $material_no = addslashes($_POST['material_no']);
  }
  
// check for a material Desc
if (empty($_POST['material_desc']))
{ $material_desc = FALSE;
  
  }
    else
  { $material_desc = addslashes($_POST['material_desc']);
  }
  
// check for a plant code
if ((empty($_POST['plant_code'])) || ($_POST['plant_code']) == "NULL")
{ $plant_code = FALSE;
 
  }
    else
  { $plant_code = addslashes($_POST['plant_code']);
  }

// check for a mat type
if ((empty($_POST['mat_type'])) || ($_POST['mat_type']) == "NULL")
{ $mat_type = FALSE;
 
  }
    else
  { $mat_type = addslashes($_POST['mat_type']);
  }

// check for BUn
if ((empty($_POST['BUn']) || ($_POST['BUn'] == "NULL")))
{ $BUn = FALSE;

  }
  else
  { $BUn = addslashes($_POST['BUn']);
  }

// check for con sstatus
if (empty($_POST['status_BOM']) || ($_POST['status_BOM'] == "NULL"))
{ $status_BOM = FALSE;
 
  }
  else
  { $status_BOM = addslashes($_POST['status_BOM']);
  }
  
  //---------------------------------------------------------------------------------------
  // material component 
  //----------------------------------------------------------------------------------------

   
 if($id_mat && $material_no && $material_desc && $plant_code && $mat_type && $BUn && $status_BOM) //everything ok
{     	

//----vendor detail ----

$query_ven_dtl = "SELECT * FROM vendor_detail WHERE vendor_code = '".sql_esc($vendor_id)."' AND status_acc = 'Y'";
$result_ven_dtl = mysqli_query($dbc,$query_ven_dtl);
$row_ven_dtl = mysqli_fetch_array($result_ven_dtl);

//--- model detail ---
$query_mod_dtl = "SELECT * FROM model_detail_tbl WHERE id_model = '".sql_esc($model_code)."' AND status_model = 'Y'";
$result_mod_dtl = mysqli_query($dbc,$query_mod_dtl);
$row_mod_dtl = mysqli_fetch_array($result_mod_dtl);


		  	  $query_search = "SELECT * FROM table_material_itsb WHERE id_mat = '".sql_esc($id_mat)."'";
              $result_search = mysqli_query($dbc,$query_search);   //run the query.
              $num_search = mysqli_num_rows($result_search);   //how many suppliers are there?
			  
			  if($num_search == 1) {
			  //echo $num_search; 
			    $row = mysqli_fetch_array($result_search);
				// make the update query
				
	
$query_upd = "UPDATE table_material_itsb SET material_desc = '".sql_esc($material_desc)."', mat_type = '".sql_esc($mat_type)."', plant_code = '".sql_esc($plant_code)."', prod_line = '".sql_esc($prod_line)."', Vclass = '".sql_esc($Vclass)."', model_code = '".sql_esc($model_code)."', model_desc = '".sql_esc($row_mod_dtl["model_desc"])."', material_group = '".sql_esc($material_group)."', category_mat = '".sql_esc($category_mat)."', std_packaging = '".sql_esc($std_packaging)."', type_package = '".sql_esc($type_package)."', part_side = '".sql_esc($part_side)."', back_no = '".sql_esc($back_no)."', mat_group = '".sql_esc($mat_group)."', acc_group = '".sql_esc($acc_group)."', BUn = '".sql_esc($BUn)."', sloc = '".sql_esc($sloc)."', cust_part_no = '".sql_esc($cust_part_no)."', material_desc_cust = '".sql_esc($material_desc_cust)."', prod_part_no = '".sql_esc($prod_part_no)."', size_dim = '".sql_esc($size_dim)."', pp_log_no = '".sql_esc($pp_log_no)."', pp_log_desc = '".sql_esc($pp_log_desc)."', date_update = NOW(), user_update = '".sql_esc($username)."', vendor_id = '".sql_esc($vendor_id)."', vendor_desc = '".sql_esc($row_ven_dtl["vendor_name"])."', status_BOM = '".sql_esc($status_BOM)."', material_cust_no = '".sql_esc($cust_part_no)."', status_foc = '".sql_esc($status_foc)."', status_sp = '".sql_esc($status_sp)."', cust_code = '".sql_esc($cust_code)."', cust_name = '".sql_esc($cust_name)."' WHERE id_mat = '".sql_esc($id_mat)."'";$result_upd = mysqli_query($dbc,$query_upd); 
		
		
		$query_upd2 = "UPDATE vendor_detail SET status_foc = '".sql_esc($status_foc)."' WHERE vendor_code = '".sql_esc($row["vendor_id"])."'"; 
		$result_upd2 = mysqli_query($dbc,$query_upd2);
		
								
			if($result_upd)
			{
				
			 echo "<script>";
		     echo "alert('Material is successfully update.');";
		     echo "window.location='mat_detail_table.php'";
	         echo "</script>"; 
		     exit(); //quit the script
			
							
  } else { echo 'Cannot update record'; 
  }
}
//print the message if there is one.
	  
} 

} 
 ?> 
  <div class="modal fade" id="myNoteEdit<?php echo $row2["id_mat"]; ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
         <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Edit Material Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Material Details</strong>
       </div>
      <?php

$query_con = "SELECT * FROM table_material_itsb WHERE id_mat = '".sql_esc($row2["id_mat"])."'";
$result_con = mysqli_query($dbc,$query_con);   //run the query.
$row_con = mysqli_fetch_array($result_con);   //how many records are there?
     
   ?> 
   <form name="formEdit" method="post" action="" class="needs-validation"  novalidate>
   <table width="100%" cellspacing="5">
   <tr>
    <td width="191">Material No. <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="material_no" name="material_no" readonly value="<?php  echo $row_con["material_no"]; ?>" class="form-control" required /></td>
    </tr>
  <tr>
    <td>Material Description <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td><input type="text" id="material_desc" name="material_desc" value="<?php echo $row_con["material_desc"]; ?>" class="form-control" required /><div class="invalid-feedback">Please enter material description.</div></td>
    </tr>
  <tr>
    <td>Plant Code <font color="#FF0000">*</font></td>
    <td>:</td>
    <td>  <select name="plant_code" class="form-control" onChange="getType(this.value)">
            <option value="NULL" placeholder="Select Plant"> -- Select Plant -- </option>
                  <?php
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM plant_detail WHERE status_plant = "Y"';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
              ?>
                  <option value="<?php echo $row27["plant_code"]; ?>" <?php if($row_con["plant_code"] == $row27["plant_code"]) echo "selected"; ?>> <?php echo stripslashes($row27["plant_code"]); ?> - <?php echo $row27["plant_desc"]; ?></option>
                  <?php
           }  ?>
                </select>
     <div class="invalid-feedback">Please enter plant code.</div>
     </td>
    </tr>
  <tr>
    <td>Material Type</td>
    <td>:</td>
    <td>
       <div id="mtype_div"> 
             <select name="mat_type" id="mat_type" class="form-control" onChange="getModel(this.value)">
                
                 <?php
	
	$query48 = "SELECT * FROM material_type_tbl WHERE plant_code = '".sql_esc($row_con["plant_code"])."' AND status_type = 'Y' ORDER BY id ASC";
    $result48 =mysqli_query($dbc,$query48);
	
	 while($row48 = mysqli_fetch_array($result48)) 
	  { 
	?>  
          <option value="<?php echo $row48["id"]; ?>" <?php if($row48["id"] == $row_con["mat_type"]) echo "selected"; ?>> <?php echo stripslashes($row48["mtype_name"]); ?></option>
  <?php   }  ?>
  
          </select>
     <!--<div class="form-control-feedback" ><?php echo $message_ty; ?></div>-->
              </div>    
    </td>
    </tr>
  <tr>
    <td>Line</td>
    <td>:</td>
    <td>
    <select name="prod_line" class="form-control">
            <option value="NULL" placeholder="Select Line"> -- Select Line -- </option>
          <?php
          //Retrieve and display the available types
          $query_line = "SELECT * FROM work_center_detail WHERE status_wc = 'Y'";
          $result_line = mysqli_query($dbc,$query_line);
          
              while($row_line = mysqli_fetch_array($result_line)) {
        
              ?>
         <option value="<?php echo $row_line["id_work"]; ?>" <?php if($row_line["id_work"] == $row_con["prod_line"]) echo "selected"; ?>> <?php echo stripslashes($row_line["id_work"]); ?> - <?php echo $row_line["wc_desc"]; ?></option>
          <?php
           }  ?>
                            
        </select>

     </td>
    </tr>
    <tr>
     <td>Material of Group</td>
    <td>:</td>
    <td><input type="text" id="material_group" name="material_group" value="<?php echo $row_con["material_group"];  ?> " class="form-control"/>
     </td>
    </tr>
     <tr>
    <td>BUn <font color="#FF0000">*</font></td>
    <td>:</td>
   <td>
   <?php		
    echo '<select name="BUn" class="form-control" required>
       <option value=""> --Select UOM -- </option>';
  
	  //Retrieve and display the available types
	  $query_unit = 'Select * from uom_con WHERE status_uom = "Y"';
	  $result_unit = mysqli_query($dbc,$query_unit);
  
		 while($row_unit = mysqli_fetch_array($result_unit)) {
		 ?>
				   <!--RETAIN VALUE-->
	   <option value="<?php echo $row_unit["UOM"]; ?>" <?php if($row_unit["UOM"] == $row_con["BUn"]) echo "selected"; ?>> <?php echo $row_unit["UOM"]; ?></option>
				   <?php }
             
	 
	  	//complete the form
	
	echo '</select>';

	?>
     <div class="invalid-feedback">Please select BUn.</div></td>
    </tr>
    <tr>
     <td>VClass</td>
    <td>:</td>
    <td><input type="text" id="Vclass" name="Vclass" value="<?php echo $row_con["Vclass"];  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>Model Code</td>
    <td>:</td>
    <td>
        <div id="model_div">
                <select name="model_code" id="model_code" class="form-control">
                   <?php
	
	$query88 = "SELECT * FROM model_detail_tbl WHERE status_model = 'Y' ORDER BY id_model ASC";
    $result88 =mysqli_query($dbc,$query88);
	
	 while($row88 = mysqli_fetch_array($result88)) 
	  { 
	?>  
          <option value="<?php echo $row88["id_model"]; ?>" <?php if($row_con["model_code"] == $row88["id_model"]) echo "selected"; ?>> <?php echo stripslashes($row88["model_code"]); ?> - <?php echo stripslashes($row88["model_desc"]); ?></option>
  <?php   }  ?>
  
          </select></div> <!-- <div class="form-control-feedback" ><?php echo $message_model; ?></div> -->
   </td>
    </tr>
     <tr>
     <td>Category Material</td>
    <td>:</td>
    <td>
        <select name="category_mat" class="form-control">
            <option value="NULL" placeholder="Select Category Material"> -- Select Category Material -- </option>
          <?php
          //Retrieve and display the available types
          $query_cat = "SELECT * FROM category_detail WHERE plant_code = '".sql_esc($row_con["plant_code"])."' AND status_stamp = 'Y'";
          $result_cat = mysqli_query($dbc,$query_cat);
          
              while($row_cat = mysqli_fetch_array($result_cat)) {
        
              ?>
         <option value="<?php echo $row_cat["stamp_ind"]; ?>" <?php if($row_cat["stamp_ind"] == $row_con["category_mat"]) echo "selected"; ?>> <?php echo stripslashes($row_cat["stamp_ind"]); ?> - <?php echo $row_cat["stamp_desc"]; ?></option>
          <?php
           }  ?>
                            
        </select>
    
    
     </td>
    </tr>
    <tr>
     <td>Standard Package</td>
    <td>:</td>
    <td><input type="text" id="std_packaging" name="std_packaging"  value="<?php echo $row_con["std_packaging"];  ?> " class="form-control"/>
     </td>
    </tr>
    <tr>
     <td>Type Package</td>
    <td>:</td>
    <td><input type="text" id="type_package" name="type_package" value="<?php echo $row_con["type_package"];  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>Part Side</td>
    <td>:</td>
    <td><input type="text" id="part_side" name="part_side" value="<?php echo $row_con["part_side"];  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>Back No.</td>
    <td>:</td>
    <td><input type="text" id="back_no" name="back_no" value="<?php echo $row_con["back_no"];  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>Storage Location</td>
    <td>:</td>
    <td>
      <select name="sloc" class="form-control">
            <option value="NULL" placeholder="Select Sloc"> -- Select Sloc -- </option>
          <?php
          //Retrieve and display the available types
          $query57 = 'SELECT * FROM sloc_tbl WHERE status_sloc = "Y"';
          $result57 = mysqli_query($dbc,$query57);
          
              while($row57 = mysqli_fetch_array($result57)) {
        
              ?>
         <option value="<?php echo $row57["sloc_code"]; ?>" <?php if($row57["sloc_code"] == $row_con["sloc"]) echo "selected"; ?>> <?php echo stripslashes($row57["sloc_code"]); ?> - <?php echo $row57["sloc_desc"]; ?></option>
          <?php
           }  ?>
                            
        </select>
     </td>
    </tr>
    <tr>
     <td>Size Dim</td>
    <td>:</td>
    <td><input type="text" id="size_dim" name="size_dim" value="<?php echo $row_con["size_dim"];  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>Customer Part No.</td>
    <td>:</td>
    <td><input type="text" id="cust_part_no" name="cust_part_no" value="<?php echo $row_con["cust_part_no"];  ?>" class="form-control"/>
     </td>
    </tr>
    <tr>
     <td>Customer Part Name</td>
    <td>:</td>
    <td><input type="text" id="material_desc_cust" name="material_desc_cust" value="<?php echo $row_con["material_desc_cust"];  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>Production Part No.</td>
    <td>:</td>
    <td><input type="text" id="prod_part_no" name="prod_part_no" value="<?php echo $row_con["prod_part_no"];  ?>" class="form-control"/>
     </td>
     <tr>
     <td>Vendor Code</td>
    <td>:</td>
    <td>
      <select name="vendor_id" class="form-control">
            <option value="NULL" placeholder="Select Vendor"> -- Select Vendor -- </option>
          <?php
          //Retrieve and display the available types
          $query_ven = 'SELECT * FROM vendor_detail WHERE status_acc = "Y"';
          $result_ven = mysqli_query($dbc,$query_ven);
          
              while($row_ven = mysqli_fetch_array($result_ven)) {
        
              ?>
         <option value="<?php echo $row_ven["vendor_code"]; ?>" <?php if($row_ven["vendor_code"] == $row_con["vendor_id"]) echo "selected"; ?>> <?php echo stripslashes($row_ven["vendor_code"]); ?> - <?php echo $row_ven["vendor_name"]; ?></option>
          <?php
           }  ?>
                            
        </select>
    
    </td>
    </tr> 
 
     <tr>
     <td>Material Group</td>
    <td>:</td>
    <td><input type="text" id="mat_group" name="mat_group" value="<?php echo $row_con["mat_group"];  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>Account Group</td>
    <td>:</td>
    <td><input type="text" id="acc_group" name="acc_group"  value="<?php echo $row_con["acc_group"];  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>PP Log No.</td>
    <td>:</td>
    <td><input type="text" id="pp_log_no" name="pp_log_no" value="<?php echo $row_con["pp_log_no"];  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>PP Log Description</td>
    <td>:</td>
    <td><input type="text" id="pp_log_desc" name="pp_log_desc" value="<?php echo $row_con["pp_log_desc"];  ?>" class="form-control"/>
     </td>
    </tr> 
    <tr>
     <td>Customer Code</td>
    <td>:</td>
    <td><input type="text" id="cust_code" name="cust_code" value="<?php echo $row_con["cust_code"];  ?>" class="form-control"/>
     </td>
    </tr> 
    <tr>
     <td>Customer Name</td>
    <td>:</td>
    <td><input type="text" id="cust_name" name="cust_name" value="<?php echo $row_con["cust_name"];  ?>" class="form-control"/>
     </td>
    </tr> 
     <tr>
    <td>Status BOM <font color="#FF0000">*</font></td>
    <td>:</td>
    <td> <select name="status_BOM"  class="form-control" required>
      <option value="" placeholder="Select Status"> -- Select Status --</option>
	  <option value="Y" class="title" <?php if($row_con["status_BOM"] == 'Y') echo "selected"; ?>>Y - Active</option>
	  <option value="N" class="title" <?php if($row_con["status_BOM"] == 'N') echo "selected"; ?>>N - Inactive</option>
	  </select>
      <div class="invalid-feedback">Please select status account.</div>
    </td>
    </tr>
    <tr>
    <td>Status FOC </td>
    <td>:</td>
    <td> <select name="status_foc"  class="form-control" required>
      <option value="" placeholder="Select Status"> -- Select Status --</option>
	  <option value="Y" class="title" <?php if($row_con["status_foc"] == 'Y') echo "selected"; ?>>Y - Active</option>
	  <option value="N" class="title" <?php if($row_con["status_foc"] == 'N') echo "selected"; ?>>N - Inactive</option>
	  </select>
     
    </td>
    </tr>
    <tr>
    <td>Status Spare Part </td>
    <td>:</td>
    <td> <select name="status_sp"  class="form-control" required>
      <option value="" placeholder="Select Status"> -- Select Status --</option>
	  <option value="Y" class="title" <?php if($row_con["status_sp"] == 'Y') echo "selected"; ?>>Y - Active</option>
	  <option value="N" class="title" <?php if($row_con["status_sp"] == 'N') echo "selected"; ?>>N - Inactive</option>
	  </select>
     
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
             <input type="hidden" id="id_mat" name="id_mat"  class="form-control" value="<?php echo $row2["id_mat"];  ?>" >  
             <input name="Submit19" type="submit" id="submit9" value="UPDATE" class="btn btn-info" onClick="return confirm('Confirm to update?');" >             
             <button type="button" class="btn btn-success" data-dismiss="modal">CLOSE</button>
             </div>  
            
    </form>  
                  </div></div>
                  </div>
                  </div>
                  </div>
                  </div>  
				  
<script language="javascript" type="text/javascript">

function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }
	
	
		function getType(plant_code) {		
		
		var strURL="findType-TP.php?plant_code="+plant_code;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('mtype_div').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
	//var strURL="agd-add00.php?idmtg="+idmtg+"&comp="+comp+"&year="+yr ;
	
	function getModel(plant_code,mat_type) {		
		
		var strURL="findModel-TP.php?plant_code="+plant_code+"&mat_type="+mat_type;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('model_div').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
	
	
	
	
</script>




                  
                  
</body>
</html>