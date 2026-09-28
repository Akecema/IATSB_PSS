<?php
    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2);
    $res = mysqli_fetch_array($result2);
	
	$url = "material_master_list.php"; 
	
//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
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

 
  <div class="modal fade" id="myNoteEdit<?php echo $row2["id_hdr"]; ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
         <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Edit Material Master</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Material Master</strong>
       </div>

<?php


$query_mat = "SELECT * FROM mat_master_header WHERE id_hdr = '".sql_esc($row2["id_hdr"])."'";
$result_mat = mysqli_query($dbc,$query_mat) ;   //run the query.
$row_mat = mysqli_fetch_array($result_mat);   //how many records are there?


 if (isset($_POST["submit9"]))
{
	
	$id_hdr = $_POST['id_hdr'];
	$material_no = $_POST['material_no']; 
	$material_desc = $_POST['material_desc']; 
	$material_type = $_POST['material_type']; 
	$material_group = $_POST['material_group']; 
    $prod_line = $_POST['prod_line']; 
	$plant = $_POST['plant']; 
	$bom_hdr = $_POST['bom_hdr']; 
	$alternative_bom_hdr = $_POST['alternative_bom_hdr'];
	$bom_usage_hdr = $_POST['bom_usage_hdr']; 
	$model_code = $_POST['model_code']; 
	$category_mat = $_POST['category_mat']; 
	$std_package = $_POST['std_package']; 
	$type_package = $_POST['type_package'];
	$part_side = $_POST['part_side'];
	$prod_part_no = $_POST['prod_part_no']; 
	$status_BOM = $_POST['status_BOM']; 
	$BUn = $_POST['BUn'];
	$Vclass = $_POST['Vclass'];
	$comp_vclass = $_POST['comp_vclass_c'];
	$bom = $_POST['bom_c']; 
	$alternative_bom = $_POST['alternative_bom_c'];
	$usage_c = $_POST['cbom_usage_c']; 
	$bom_item_no = $_POST['bom_item_c']; 
	$bom_usage = $_POST['bom_usage_c']; 
	$consumption = $_POST['consumption_c']; 
	$node_no = $_POST['node_no_c']; 
	$ver_no = $_POST['ver_no_c']; 


	//--------------------function escape data from form ------------------------
	/*function escape_data ($data) {
	global $dbc;   // need the connection.
	if (ini_get('magic_quotes_gpc')) 
	{
		$data = stripslashes($data);
	}
	return mysql_real_escape_string($data,$dbc);
	}   // end function.*/
	$message = NULL; // create an empty new variable.
	
	//count component
	/*$size = count($_POST["id_dtl"]) + 1;
	
	$i = 1;*/
	
	//------------------------------end function --------------------------------
	// check for a material no.
	/*if (empty($_POST['material_no']))
	{ 
		$material_no = FALSE;
		$message.= '<p>You are required to enter Material No.!</p>';
	}*/
	
	
	//CHECKING FOR MAT HEADER
	// check for a material desc
	if (empty($_POST['material_desc']))
	{ 
		$material_desc = FALSE;
		$message.= '<p>You are required to enter Material Description!</p>';
	}
	else
	{ 
		$material_desc = addslashes($_POST['material_desc']);
	}
	
	// check for a material type
	if (empty($_POST['material_type']))
	{ 
		$material_type = FALSE;
		$message.= '<p> You are required to enter Material Type!</p>';
	}
	else
	{ 
		$material_type = addslashes($_POST['material_type']);
	}
	
	// check for a material GROUP
	if (empty($_POST['material_group']))
	{ 
		$material_group = FALSE;
		$message.= '<p> You are required to enter Material Group!</p>';
	}
	else
	{ 
		$material_group = addslashes($_POST['material_group']);
	}
	
	// check for a plant
	if (empty($_POST['plant']))
	{ 
		$plant = FALSE;
		$message.= '<p> You are required to enter Plant!</p>';
	}
	else
	{ 
		$plant = addslashes($_POST['plant']);
	}
	
	// check for a bom
	if (empty($_POST['bom_hdr']))
	{ 
		$bom = FALSE;
		$message.= '<p> You are required to enter BOM!</p>';
	}
	else
	{ 
		$bom = addslashes($_POST['bom_hdr']);
	}
	

	
	// check for a bom_usage
	if (empty($_POST['bom_usage_hdr']))
	{ 
		$bom_usage = FALSE;
		$message.= '<p> You are required to enter BOM Usage!</p>';
	}
	else
	{ 
		$bom_usage = addslashes($_POST['bom_usage_hdr']);
	}
	

	// check for a part side
	/*if (empty($_POST['part_side']))
	{ 
		$part_side = FALSE;
		$message.= '<p> You are required to enter Part of Side!</p>';
	}
	else
	{ 	
		$part_side = addslashes($_POST['part_side']);
	} */
	
	
	//check for status BOM
	if (empty($_POST['status_BOM']))
	{ 
		$status_BOM = FALSE;
		$message.= '<p> You are required to select BOM Status!</p>';
	}
	else
	{ 	
		$status_BOM = addslashes($_POST['status_BOM']);
	}
	
	
	
	// check for a Standard packaging
/*	if (empty($_POST['std_package']))
	{ 
		$std_package = FALSE;
		$message.= '<p> You are required to enter Standard Packaging!</p>';
	}
	else
	{ 
		$std_package = addslashes($_POST['std_package']);
	}*/
	


	/*///--------------------------start checking component ---------------------------------------------------  
	// check for a material_desc_c
	if (empty($_POST['material_desc_c'][$i]))
	{ 
		$material_desc_c = FALSE;
		$message.= '<p> You are required to enter Material Description Component!</p>';
	}
	else
	{ 	
		$material_desc_c = escape_data($_POST['material_desc_c'][$i]);
	}
	
	// check for a mat_type_c
	if (empty($_POST['mat_type_c'][$i]))
	{ 
		$mat_type_c = FALSE;
		$message.= '<p> You are required to enter Material Type Component!</p>';
	}
	else
	{ 
		$mat_type_c = escape_data($_POST['mat_type_c'][$i]);
	}
	
	
	//check for plant_c
	if (empty($_POST['plant_c'][$i]))
	{ 
		$plant_c = FALSE;
		$message.= '<p> You are required to enter Plant of Component!</p>';
	}
	else
	{ 
		$plant_c = escape_data($_POST['plant_c'][$i]);
	}
	
	//check for bom_c
	if (empty($_POST['bom_c'][$i]))
	{ 
		$bom_c = FALSE;
		$message.= '<p> You are required to enter Bill of Material Component!</p>';
	}
	else
	{ 
		$bom_c = escape_data($_POST['bom_c'][$i]);
	}
	
	//check for consumption
	if (empty($_POST['consumption'][$i]))
	{ 
		$consumption = FALSE;
		$message.= '<p> You are required to enter Consumption!</p>';
	}
	else
	{ 
		$consumption = escape_data($_POST['consumption'][$i]);
	}
	
	  //check for bom status
	if (empty($_POST['bom_status'][$i]))
	{ 
		$bom_status = FALSE;
		$message.= '<p> You are required to select BOM Status!</p>';
	}
	else
	{ 
		$bom_status = escape_data($_POST['bom_status'][$i]);
	}*/
   
   
	//escape data for FG   
	$BUn = addslashes($_POST['BUn']);
	$material_group = addslashes($_POST['material_group']);
	$alternative_bom_hdr = addslashes($_POST['alternative_bom_hdr']);
	$date_create = addslashes($_POST['date1']);
	$date_bom_create = addslashes($_POST['date2']);
	$type_package = addslashes($_POST['type_package']);
	$location_deliver = addslashes($_POST['location_deliver']);
	$station_deliver = addslashes($_POST['station_deliver']);
	$rcv_point = addslashes($_POST['rcv_point']);
	$std_package = addslashes($_POST['std_package']);
	$type_package = addslashes($_POST['type_package']);
    $prod_line = addslashes($_POST['prod_line']); 
	$model_code = addslashes($_POST['model_code']); 
	$category_mat = addslashes($_POST['category_mat']); 
	$prod_part_no = addslashes($_POST['prod_part_no']); 
	$Vclass = addslashes($_POST['Vclass']);
	$comp_vclass = $_POST['comp_vclass_c'];
	$bom = $_POST['bom_c']; 
	$alternative_bom2 = $_POST['alternative_bom_c'];
	$usage_c = $_POST['cbom_usage_comp']; 
	$bom_item_no = $_POST['bom_item_c']; 
	$bom_usage = $_POST['bom_usage_c']; 
	$bom_usage_hdr = $_POST['bom_usage_hdr']; 
	$consumption = $_POST['consumption_c']; 
	$node_no = $_POST['node_no_c']; 
	$ver_no = $_POST['ver_no_c']; 
	
  
  //---------------------------------------------------------------------------------------
  // material component 
  //----------------------------------------------------------------------------------------

   
if($material_desc && $material_type && $plant && $bom_hdr && $bom_usage_hdr && $status_BOM) //everything ok
{      	
	
	$query_search = "SELECT * FROM mat_master_header WHERE id_hdr = '".sql_esc($row2["id_hdr"])."'";
	$result_search = mysqli_query($dbc,$query_search);   //run the query.
	$num_search = mysqli_num_rows($result_search);   //how many suppliers are there?

	if($num_search == 1) 
	{
		//echo $num_search; 
		$row_search = mysqli_fetch_array($result_search);
		
		// update tbl header
		$query_upd = "UPDATE mat_master_header SET material_desc = '".sql_esc($material_desc)."', material_type = '".sql_esc($material_type)."', material_group = '".sql_esc($material_group)."', plant = '".sql_esc($plant)."', bom = '".sql_esc($bom_hdr)."', alternative_bom = '".sql_esc($alternative_bom_hdr)."', bom_usage = '".sql_esc($bom_usage_hdr)."', BUn = '".sql_esc($BUn)."', date_create = '".sql_esc($date_create)."', date_bom_create = '".sql_esc($date_bom_create)."', std_package = '".sql_esc($std_package)."',type_package = '".sql_esc($type_package)."', part_side = '".sql_esc($part_side)."', status_BOM = '".sql_esc($status_BOM)."', type_package = '".sql_esc($type_package)."', location_deliver = '".sql_esc($location_deliver)."', station_deliver = '".sql_esc($station_deliver)."', date_updated = NOW(), updated_by='".sql_esc($username)."', model_code = '".sql_esc($model_code)."', prod_part_no = '".sql_esc($prod_part_no)."', work_center = '".sql_esc($prod_line)."', stamp_ind = '".sql_esc($category_mat)."', Vclass = '".sql_esc($Vclass)."' WHERE id_hdr = '".sql_esc($id_hdr)."'"; 
		$result_upd = mysqli_query($dbc,$query_upd); 
		

		
		$query_updQ = "UPDATE table_material_itsb SET material_desc = '".sql_esc($material_desc)."', plant_code = '".sql_esc($plant)."', BUn = '".sql_esc($BUn)."', date_create = '".sql_esc($date_bom_create)."', status_BOM = '".sql_esc($status_BOM)."', material_group = '".sql_esc($material_group)."', date_update = NOW(), user_update = '".sql_esc($username)."', Vclass = '".sql_esc($Vclass)."', category_mat = '".sql_esc($category_mat)."', std_packaging = '".sql_esc($std_package)."', type_package = '".sql_esc($type_package)."' WHERE  material_no = '".sql_esc($row_mat["material_no"])."'"; 
		$result_updQ = mysqli_query($dbc,$query_updQ);
		
		
		

		
		//--------------checking for component---------------------------------//
		// $i = 1;
		//for components
		$query_searchCP = "SELECT * FROM mat_master_detail WHERE id_hdr = '".sql_esc($row2["id_hdr"])."'";
		$result_searchCP = mysqli_query($dbc,$query_searchCP);   //run the query.
		$num_searchCP = mysqli_num_rows($result_searchCP);   //how many suppliers are there?
		$row_CP = mysqli_fetch_array($result_searchCP);
		
		
		//if ada components
		if($num_searchCP  > 0)
		{
			
			$id_dtl = $_POST['id_dtl'];//id component
			$size = count($_POST["id_dtl"]) + 1;
			
			$i = 1;
			
			///--------------------------start checking component ---------------------------------------------------  
			// check for a material_desc_c
			if (empty($_POST['material_desc_c'][$i]))
			{ 
				$material_desc_c = FALSE;
				$message.= '<p> You are required to enter Material Description Component!</p>';
			}
			else
			{ 	
				$material_desc_c = addslashes($_POST['material_desc_c'][$i]);
			}
			
			// check for a mat_type_c
			if (empty($_POST['mat_type_c'][$i]))
			{ 
				$mat_type_c = FALSE;
				$message.= '<p> You are required to enter Material Type Component!</p>';
			}
			else
			{ 
				$mat_type_c = addslashes($_POST['mat_type_c'][$i]);
			}
			
			
			//check for plant_c
			if (empty($_POST['plant_c'][$i]))
			{ 
				$plant_c = FALSE;
				$message.= '<p> You are required to enter Plant of Component!</p>';
			}
			else
			{ 
				$plant_c = addslashes($_POST['plant_c'][$i]);
			}
			
			//check for bom_c
			if (empty($_POST['bom_c'][$i]))
			{ 
				$bom_c = FALSE;
				$message.= '<p> You are required to enter Bill of Material Component!</p>';
			}
			else
			{ 
				$bom_c = addslashes($_POST['bom_c'][$i]);
			}
			
			//check for consumption
			if (empty($_POST['consumption_c'][$i]))
			{ 
				$consumption = FALSE;
				$message.= '<p> You are required to enter Consumption!</p>';
			}
			else
			{ 
				$consumption = addslashes($_POST['consumption_c'][$i]);
			}
			
			  //check for bom status
			if (empty($_POST['bom_status'][$i]))
			{ 
				$bom_status = FALSE;
				$message.= '<p> You are required to select BOM Status!</p>';
			}
			else
			{ 
				$bom_status = addslashes($_POST['bom_status'][$i]);
			}
			
			
			//escape data for component
			$matl_group = addslashes($_POST['matl_group'][$i]);
			$alternative_bom2 = addslashes($_POST['alternative_bom_c'][$i]);
			$comp_unit = addslashes($_POST['comp_unit'][$i]);
			$sloc = addslashes($_POST['sloc'][$i]);
			$isloc = addslashes($_POST['isloc'][$i]);
			$valid_from = addslashes($_POST['date3'][$i]);
			$date_create_bom = addslashes($_POST['date4'][$i]);
	
	
	
			while ($i < $size) {
				
			$sc = "SELECT * FROM mat_master_detail WHERE id_dtl = '".sql_esc($_POST["id_dtl"][$i])."'";
			$rst_sc = mysqli_query($dbc,$sc);   //run the query.
			$result_sc = mysqli_fetch_array($rst_sc);
			$num_sc = mysqli_num_rows($rst_sc);   //how many suppliers are there?
			$row_sc = mysqli_fetch_row($rst_sc);
			
			//echo "billr".$result_sc['bill_component'];
	  
	  		//update tbl component
			$query_upd5 = "UPDATE mat_master_detail SET material_desc_c = '".sql_esc($_POST["material_desc_c"][$i])."',
									 material_type = '".sql_esc($_POST["mat_type_c"][$i])."', 
									 bom_status = '".sql_esc($_POST["bom_status"][$i])."',
									 matl_group = '".sql_esc($_POST["matl_group"][$i])."', 
									 alternative_bom = '".sql_esc($_POST["alternative_bom_c"][$i])."', 
									 consumption = '".sql_esc($_POST["consumption_c"][$i])."', 
									 comp_unit = '".sql_esc($_POST["comp_unit"][$i])."', 
									 plant = '".sql_esc($_POST['plant_c'][$i])."',
									 bom = '".sql_esc($_POST['bom_c'][$i])."',
									 sloc = '".sql_esc($_POST["sloc"][$i])."', 
									 isloc = '".sql_esc($_POST["isloc"][$i])."', 
									 valid_from = '".sql_esc($_POST["date3"][$i])."', 								
									 alternative_bom = '".sql_esc($_POST['alternative_bom_c'][$i])."',
									 bom_usage = '".sql_esc($_POST['bom_usage_c'][$i])."',
									 usage_c = '".sql_esc($_POST['cbom_usage_comp'][$i])."',
									 bom_item_no = '".sql_esc($_POST['bom_item_c'][$i])."',
									 comp_vclass = '".sql_esc($_POST["comp_vclass_c"][$i])."', 
									 consumption = '".sql_esc($_POST['consumption_c'][$i])."', 
									 node_no = '".sql_esc($_POST['node_no_c'][$i])."', 
									 ver_no = '".sql_esc($_POST['ver_no_c'][$i])."', 
									 date_create_bom = '".sql_esc($_POST["date4"][$i])."',
									 bom_item_category = '".sql_esc($_POST["cbom_cat"][$i])."',
									 date_updated = NOW(),
									 updated_by = '".sql_esc($username)."' 
									 WHERE id_dtl = '".sql_esc($_POST["id_dtl"][$i])."'";									 
			$result_upd5 = mysqli_query($dbc,$query_upd5)or die('Error, failed to update tbl master details.');
			
			
		
		
		$query_updQ2 = "UPDATE table_material_itsb SET material_desc = '".sql_esc($_POST["material_desc_c"][$i])."', plant_code = '".sql_esc($_POST['plant_c'][$i])."', BUn = '".sql_esc($_POST["comp_unit"][$i])."', date_create =  '".sql_esc($_POST["date4"][$i])."', status_BOM = '".sql_esc($_POST["bom_status"][$i])."', material_group = '".sql_esc($_POST["matl_group"][$i])."', date_update = NOW(), user_update = '".sql_esc($username)."' WHERE id_dtl = '".sql_esc($_POST["id_dtl"][$i])."'";
		$result_updQ2 = mysqli_query($dbc,$query_updQ2);
		
		
		
				

			$i++;
			} // end while loop
			

		
		}//end if ada component
		
	
				echo "<script>";
				echo "alert('Material Request successfully update.');";
				echo "window.location='material_master_list.php'";
				echo "</script>"; 
				exit();
				

		
	}//end if ada header

	  
} 
//---------------------------function message------------------------------ 
if (isset($message))
{ 
	echo '<div class="msg msg-error"><font color="red" class ="error_entry">', $message, '</font></div>';
}
} 
 ?>



   <form name="formEdit" method="post" action="" class="needs-validation"  novalidate>
   <table width="100%" cellspacing="5" class="table table-borderless">
   <tr>
    <td width="28%">Material No.</td>
    <td width="3%">:</td>
    <td width="69%"><input type="text" id="material_no" name="material_no" readonly value="<?php  echo $row_mat["material_no"]; ?>" class="form-control"></td>
    </tr>
  <tr>
    <td>Material Description <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td><input type="text" id="material_desc" name="material_desc" value="<?php echo $row_mat["material_desc"]; ?>" class="form-control" required /></td>
    </tr>
    <tr>
    <td>Plant <font color="#FF0000">*</font></td>
    <td>:</td>
   <td><input type="text" id="plant" name="plant" value="<?php echo $row_mat["plant"];  ?>" class="form-control" required/> </td>
    </tr>
  <tr>
    <td>Material Type <font color="#FF0000">*</font></td>
    <td>:</td>
    <td><input type="text" id="material_type" name="material_type" value="<?php echo $row_mat["material_type"];  ?>" class="form-control" required />
     </td>
    </tr>
    <tr>
    <td>Material Group</td>
    <td>:</td>
    <td><input type="text" id="material_group" name="material_group"  value="<?php echo $row_mat["material_group"];  ?>" class="form-control" required />
     </td>
    </tr>
     <tr>
    <td>Line</td>
    <td>:</td>
    <td> <select name="prod_line" class="form-control">
            <option value="NULL" placeholder="Select Line"> -- Select Line -- </option>
          <?php
          //Retrieve and display the available types
          $query_line = "SELECT * FROM work_center_detail WHERE status_wc = 'Y'";
          $result_line = mysqli_query($dbc,$query_line);
          
              while($row_line = mysqli_fetch_array($result_line)) {
        
              ?>
         <option value="<?php echo $row_line["id_work"]; ?>" <?php if($row_line["id_work"] == $row_mat["work_center"]) echo "selected"; ?>> <?php echo stripslashes($row_line["id_work"]); ?> - <?php echo $row_line["wc_desc"]; ?></option>
          <?php
           }  ?>
                            
        </select>   
     </td>
    </tr>
    
     <tr>
    <td>BOM <font color="#FF0000">*</font></td>
    <td>:</td>
   <td><input type="text" id="bom_hdr" name="bom_hdr" value="<?php echo $row_mat["bom"];  ?>" class="form-control" required/> </td>
    </tr>
     <tr>
    <td>Alternative BOM</td>
    <td>:</td>
   <td><input type="text" id="alternative_bom_hdr" name="alternative_bom_hdr" value="<?php echo $row_mat["alternative_bom"];  ?>" class="form-control"/> </td>
    </tr>
     <tr>
    <td>BOM Usage</td>
    <td>:</td>
   <td><input type="text" id="bom_usage_hdr" name="bom_usage_hdr" value="<?php echo $row_mat["bom_usage"];  ?>" class="form-control"/> </td>
    </tr>
    <tr>
    <td>BUn</td>
    <td>:</td>
   <td>
   
    <?php		
    echo '<select name="BUn" class="form-control">
       <option value=""> --Select UOM -- </option>';
  
	  //Retrieve and display the available types
	  $query_unit = 'Select * from uom_con WHERE status_uom = "Y"';
	  $result_unit = mysqli_query($dbc,$query_unit);
  
		 while($row_unit = mysqli_fetch_array($result_unit)) {
		 ?>
				   <!--RETAIN VALUE-->
	   <option value="<?php echo $row_unit["UOM"]; ?>" <?php if($row_unit["UOM"] == $row_mat["BUn"]) echo "selected"; ?>> <?php echo $row_unit["UOM"]; ?></option>
				   <?php }
             
	 
	  	//complete the form
	
	echo '</select>';

	?>
   </td></tr>
    <tr>
    <td>Date Created </td>
    <td>:</td>
   <td>
   <!--<input class="form-control" id="demoDate" type="text" placeholder="Select Date" value="<?php //echo $row_mat["date_create"]; ?>">-->
   <input type="date" name="date1" class="form-control input-xlarge datepicker" value="<?php echo $row_mat["date_create"]; ?>"  >
   </td>
   </tr>
    <tr>
    <td>Date BOM Created </td>
    <td>:</td>
   <td>
   <input type="date" name="date2" class="form-control input-xlarge datepicker" value="<?php echo $row_mat["date_bom_create"]; ?>"  >
   </td>
   </tr>
    <tr>
    <td>VClass </td>
    <td>:</td>
   <td>
    <input type="text" id="Vclass" name="Vclass" value="<?php if(isset($_POST['Vclass'])) { echo $_POST['Vclass']; }else{ echo $row_mat["Vclass"];  } ?>" class="form-control"/>
               
   </td>
   </tr>
   <tr>
     <td>Model Code </td>
    <td>:</td>
   <td>
          <div id="model_div">
                <select name="model_code" id="model_code" class="form-control">
                <option value="NULL" placeholder="Select Model"> -- Select Model -- </option>
                   <?php
	
	$query88 = "SELECT * FROM model_detail_tbl WHERE status_model = 'Y' GROUP BY model_code ORDER BY id_model ASC";
    $result88 =mysqli_query($dbc,$query88);
	
	 while($row88 = mysqli_fetch_array($result88)) 
	  { 
	?>  
          <option value="<?php echo $row88["model_code"]; ?>" <?php if($row88["model_code"] == ($row_mat["model_code"])) echo "selected"; ?>> <?php echo stripslashes($row88["model_code"]); ?> - <?php echo stripslashes($row88["model_desc"]); ?></option>
  <?php   }  ?>
  
          </select></div>
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
          $query_cat = "SELECT * FROM category_detail WHERE status_stamp = 'Y'";
          $result_cat = mysqli_query($dbc,$query_cat);
          
              while($row_cat = mysqli_fetch_array($result_cat)) {
        
              ?>
         <option value="<?php echo $row_cat["stamp_ind"]; ?>" <?php if($row_cat["stamp_ind"] == $row_mat["stamp_ind"]) echo "selected"; ?>> <?php echo stripslashes($row_cat["stamp_ind"]); ?> - <?php echo $row_cat["stamp_desc"]; ?></option>
          <?php
           }  ?>
                            
        </select>
               
   </td>
   </tr>
        <tr>
    <td>Standard Packaging </td>
    <td>:</td>
   <td><input type="text" id="std_package" name="std_package" value="<?php echo $row_mat["std_package"];  ?>" class="form-control" /> </td>
    </tr>
     <tr>
    <td>Type of package</td>
    <td>:</td>
   <td><input type="text" id="type_package" name="type_package" value="<?php echo $row_mat["type_package"];  ?>" class="form-control"/> </td>
    </tr>
     <tr>
    <td>Part of Side </td>
    <td>:</td>
   <td> <select name="part_side"  class="form-control" >
            <option value="NULL" placeholder="Select Part of Side"> -- Select Part of Side --</option>
            <option value="LH"  <?php if($row_mat["part_side"] == 'LH') echo "selected"; ?>>LH - Left Hand</option>
            <option value="RH" <?php if($row_mat["part_side"] == 'RH') echo "selected"; ?>>RH - Right Hand</option>
            <option value="RH/LH" <?php if($row_mat["part_side"] == 'RH/LH') echo "selected"; ?>>RH/LH - Right Hand/Left Hand</option>
             <option value="LH/RH" <?php if($row_mat["part_side"] == 'LH/RH') echo "selected"; ?>>LH/RH - Left Hand/Right Hand</option>
            </select></td>
    </tr>
     <tr>
    <td>Location Deliver</td>
    <td>:</td>
   <td><input type="text" id="location_deliver" name="location_deliver" value="<?php echo $row_mat["location_deliver"];  ?>" class="form-control"/> </td>
    </tr>
     <tr>
    <td>Station Deliver</td>
    <td>:</td>
   <td><input type="text" id="station_deliver" name="station_deliver" value="<?php echo $row_mat["station_deliver"];  ?>" class="form-control"/> </td>
    </tr>
     <tr>
    <td>Received Point</td>
    <td>:</td>
   <td><input type="text" id="rcv_point" name="rcv_point" value="<?php echo $row_mat["rcv_point"];  ?>" class="form-control"/> </td>
    </tr>
     <tr>
    <td>Production Part No.</td>
    <td>:</td>
   <td><input type="text" id="prod_part_no" name="prod_part_no" value="<?php echo $row_mat["prod_part_no"];  ?>" class="form-control"/> </td>
    </tr>
 <tr>
    <td>Status BOM<font color="#FF0000">*</font></td>
    <td>:</td>
   <td><select name="status_BOM"  class="form-control" required>
       <option value="NULL" placeholder="Select Status"> -- Select Status --</option>
	   <option value="Y" <?php if($row_mat["status_BOM"] == 'Y') echo "selected"; ?>>Active</option>
	   <option value="N" <?php if($row_mat["status_BOM"] == 'N') echo "selected"; ?>>Inactive</option>
	   </select> </td>
    </tr>
     <tr>
                 <td><font color="#FF0000">* </font>Compulsory field</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
               </tr>
   </table>
   
   <hr>
    <p>&nbsp;</p>
			 <?php
			 
			 $i = 1;
			 
	  $query_component = "SELECT *, DATE_FORMAT(valid_from, '%d-%m-%Y') AS R FROM mat_master_header AS h, mat_master_detail AS s WHERE h.id_hdr = s.id_hdr AND h.id_hdr =  '".sql_esc($row2["id_hdr"])."'";
	   $result_component = mysqli_query($dbc,$query_component);
	   
	  while($row_9 = mysqli_fetch_array($result_component))
			{  
			 ?> 
             
            <h6>Edit Component Detail</h6>

               <table class="table table-borderless">
               <tr>
                 <td width="28%">Component <font color="#FF0000">*</font></td>
                 <td width="3%" height="25">:</td>
                 <td width="69%" height="25">
                   <input name="bill_component[<?php echo $i; ?>]" type="text" id="bill_component" size="20" maxlength="8" readonly value="<?php echo $row_9["bill_component"];   ?>" class="form-control" required />
                 </td>
               </tr>
               <tr>
                 <td>Component Description <font color="#FF0000">*</font></td>
                 <td>:</td>
                 <td>
                   <input name="material_desc_c[<?php echo $i; ?>]" type="text"  class="form-control" id="material_desc_c" size="55" maxlength="100" value="<?php echo $row_9["material_desc_c"]; ?>" required/>
                </td>
               </tr>
                        <tr>
                 <td>Material Type <font color="#FF0000">*</font></td>
                 <td>:</td>
                 <td>
         <input name="mat_type_c[<?php echo $i; ?>]" type="text"  class="form-control" id="mat_type_c" size="20" maxlength="20" value="<?php echo $row_9["material_type"]; ?>" required/>
                 </td>
               </tr>
               
               <tr>
                 <td>Material Group</td>
                 <td>:</td>
                 <td><input name="matl_group[<?php echo $i; ?>]" type="text"  class="form-control" id="matl_group" size="20" maxlength="20" value="<?php echo $row_9["matl_group"]; ?>" /></td>
               </tr>

			   <tr>
                 <td>Category BOM</td>
                 <td>:</td>
                 <td>  
					<select name="cbom_cat[<?php echo $i; ?>]" id="cbom_cat" class="form-control">
                    <option value="NULL" placeholder="Select Category BOM"> -- Select Category BOM -- </option> 
				<?php
				
				$query_cbom2 = "SELECT * FROM bom_cat ORDER BY id ASC";
				$result_cbom2 =mysqli_query($dbc,$query_cbom2);
				
				while($row_cbom2 = mysqli_fetch_array($result_cbom2)) 
				{ 
				?>  

					<option value="<?php echo $row_cbom2["id_code"]; ?>" <?php if($row_cbom2["id_code"] == ($row_9["bom_item_category"])) echo "selected"; ?>> <?php echo stripslashes($row_cbom2["id_code"]); ?> - <?php echo stripslashes($row_cbom2["desc"]); ?></option>
			     <?php   }  ?>
  
                  </select>       



				 </td>
               </tr>
               <tr>
                 <td>Plant <font color="#FF0000">*</font></td>
                 <td>:</td>
                 <td><input name="plant_c[<?php echo $i; ?>]" type="text" class="form-control" id="plant_c" size="20" maxlength="20" value="<?php echo $row_9["plant"]; ?>" required />
               </td>
               </tr>
               <tr>
                 <td>BOM <font color="#FF0000">*</font></td>
                 <td>:</td>
                 <td><input name="bom_c[<?php echo $i; ?>]" type="text" class="form-control" id="bom_c" size="20" maxlength="20" value="<?php echo $row_9["bom"]; ?>" required />
                </td>
               </tr>
               <tr>
                 <td>Alternative BOM</td>
                 <td>:</td>
                 <td>
         <input name="alternative_bom_c[<?php echo $i; ?>]" type="text"  class="form-control" id="alternative_bom_c" size="20" maxlength="20" value="<?php echo $row_9["alternative_bom"]; ?>" />
                 </td>
               </tr>

			   <tr>
                 <td>Item No. BOM</td>
                 <td>:</td>
                 <td>
         <input name="bom_item_c[<?php echo $i; ?>]" type="text"  class="form-control" id="bom_item_c" size="20" maxlength="20" value="<?php echo $row_9["bom_item_no"]; ?>" />
                 </td>
               </tr>

			  
			   <tr>
                 <td>Material Usage <font color="#FF0000">*</font></td>
                 <td>:</td>
                 <td>
                   <input name="bom_usage_c[<?php echo $i; ?>]" type="text" class="form-control" id="bom_usage_c" size="20" maxlength="20" value="<?php echo $row_9["bom_usage"]; ?>" required />
                </td>
               </tr>
			   <tr>
                 <td>BOM Component Usage<font color="#FF0000">*</font></td>
                 <td>:</td>
                 <td>
                   <input name="cbom_usage_comp[<?php echo $i; ?>]" type="number" class="form-control" id="cbom_usage_comp" min="0" value="<?php echo $row_9["usage_c"]; ?>" required />
                </td>
               </tr>
               <tr>
                 <td>Consumption <font color="#FF0000">*</font></td>
                 <td>:</td>
                 <td>
                   <input name="consumption_c[<?php echo $i; ?>]" type="text" class="form-control" id="consumption_c" size="20" maxlength="20" value="<?php echo $row_9["consumption"]; ?>" required />
                </td>
               </tr>
			   <tr>
                 <td>BOM Node </td>
                 <td>:</td>
                 <td>
                   <input name="node_no_c[<?php echo $i; ?>]" type="text" class="form-control" id="node_no_c" size="20" maxlength="20" value="<?php echo $row_9["node_no"]; ?>" required />
                </td>
               </tr>
			   <tr>
                 <td>Ver. No </td>
                 <td>:</td>
                 <td>
                   <input name="ver_no_c[<?php echo $i; ?>]" type="text" class="form-control" id="ver_no_c" size="20" maxlength="20" value="<?php echo $row_9["ver_no"]; ?>" required />
                </td>
               </tr>
			   <tr>
                 <td>Component Vclass <font color="#FF0000">*</font></td>
                 <td>:</td>
                 <td>
                   <input name="comp_vclass_c[<?php echo $i; ?>]" type="text" class="form-control" id="comp_vclass_c" size="20" maxlength="20" value="<?php echo $row_9["comp_vclass"]; ?>" required />
                </td>
               </tr>
               <tr>
                 <td>UoM</td>
                 <td>:</td>
                 <td>
      <!-- <select name="comp_unit[<?php echo $i; ?>]" class="form-control">
       <option value=""> --Select UOM -- </option>  
                   <?php		

	/*  $query_unit2 = 'Select * from uom_con WHERE status_uom = "Y"';
	  $result_unit2 = mysqli_query($dbc,$query_unit2);
  
		 while($row_unit2 = mysqli_fetch_array($result_unit2)) {
		 ?>
				   <!--RETAIN VALUE-->
	   <option value="<?php echo $row_unit2["UOM"][$i]; ?>" <?php if($row_unit2["UOM"] == $row_9["comp_unit"][$i]) echo "selected"; ?>> <?php echo $row_unit["UOM"]; ?></option>
				   <?php }
             
*/
	?>
         </select>      -->  
                 
                   <input name="comp_unit[<?php echo $i; ?>]" type="text" class="form-control" id="comp_unit" size="20" maxlength="20" value="<?php echo $row_9["comp_unit"]; ?>" />
                 </td>
               </tr>
                    <tr>
                 <td>SLoc</td>
                 <td>:</td>
                 <td>
                   <input name="sloc[<?php echo $i; ?>]" type="text" class="form-control" id="sloc" size="20" maxlength="20" value="<?php echo $row_9["sloc"]; ?>" />
                 </td>
               </tr>
                 <tr>
                 <td>IsLoc</td>
                 <td>:</td>
                 <td>
                   <input name="isloc[<?php echo $i; ?>]" type="text" class="form-control" id="isloc" size="20" maxlength="20" value="<?php echo $row_9["isloc"]; ?>" />
                 </td>
               </tr>
               <tr>
                 <td>Valid From</td>
                 <td>:</td>
                 <td>
              <input name="date3[<?php echo $i; ?>]" type="date" class="form-control input-xlarge datepicker" id="date3" size="20" maxlength="20" value="<?php echo $row_9["valid_from"]; ?>" />   
                </td>
               </tr>
               <tr>
                 <td>Date BOM Created</td>
                 <td>:</td>
                 <td>
                  <input name="date4[<?php echo $i; ?>]" type="date" class="form-control input-xlarge datepicker" id="date4" size="20" maxlength="20" value="<?php echo $row_9["date_create_bom"]; ?>" />
               </td>
               </tr>
               <?php
			   
			    if($row_9["bom_status"] == "Y")
			  {
				 $sts = "Active";
				 }
				 else{
				 $sts = "Inactive";
				 }
			   ?>
               <tr>
                 <td>Status BOM <font color="#FF0000">*</font></td>
                 <td>:</td>
                 <td> <select name="bom_status[<?php echo $i; ?>]"  class="form-control">
                      <option value ="<?php  echo $row_9["bom_status"]; ?>" ><?php  echo $sts; ?></option>
                      <option value="Y" class="title">Active</option>
                      <option value="N" class="title">Inactive</option>
                      </select></td>
               </tr>
               <tr>
                 <td>&nbsp; <input type="hidden" name="id_dtl[<?php echo $i; ?>]" id="id_dtl" value="<?php echo $row_9["id_dtl"]; ?>"></td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
               </tr>
                <tr>
                 <td><font color="#FF0000">* </font>Compulsory field</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
               </tr>
            </table>
            
            <?php
			
			
		 $i++;
		 
			 }  ?>




       </div> <!-- card -->
       </div><!-- /# card -->
     

              
              <div class="modal-footer"> 
             <input type="hidden" id="id_hdr" name="id_hdr"  class="form-control" value="<?php echo $row2["id_hdr"];  ?>" >  
             <input name="submit9" type="submit" id="submit9" value="UPDATE" class="btn btn-info" onClick="return confirm('Confirm to update?');" >             <button type="button" class="btn btn-success" data-dismiss="modal">CLOSE</button>
             </div>  
            
    </form>  
                  </div></div>
                  </div>
                  </div>
                  </div>
                  </div>
                  
                  
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
    <script type="text/javascript">
      $('#sl').on('click', function(){
      	$('#tl').loadingBtn();
      	$('#tb').loadingBtn({ text : "Signing In"});
      });
      
      $('#el').on('click', function(){
      	$('#tl').loadingBtnComplete();
      	$('#tb').loadingBtnComplete({ html : "Sign In"});
      });
      
      $('#demoDate').datepicker({
      	format: "dd/mm/yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
      
      $('#demoSelect').select2();
    </script>
</body>
</html>