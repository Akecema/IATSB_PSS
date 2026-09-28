<?php
    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysql_error());
    $res = mysqli_fetch_array($result2);
	
	$url = "material_master_list.php"; 
	
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
    <meta name="description" content="PSS ITSB Online, Ingress Technologies Sdn. Bhd.,Ingress ">
    <title><?php echo $data_setup["title_desc"]; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
         <div class="modal-dialog" role="document">
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
	
	$id_hdr = $_POST['id_hdr'];//id material
	//$id_dtl = $_POST['id_dtl'];//id component

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
	if (empty($_POST['bom']))
	{ 
		$bom = FALSE;
		$message.= '<p> You are required to enter BOM!</p>';
	}
	else
	{ 
		$bom = addslashes($_POST['bom']);
	}
	

	
	// check for a bom_usage
	if (empty($_POST['bom_usage']))
	{ 
		$bom_usage = FALSE;
		$message.= '<p> You are required to enter BOM Usage!</p>';
	}
	else
	{ 
		$bom_usage = addslashes($_POST['bom_usage']);
	}
	

	
	// check for a standard package
	/*if (empty($_POST['std_package']))
	{ 
		$std_package = FALSE;
		$message.= '<p> You are required to enter Standard Packaging!</p>';
	}
	else
	{ 
		$std_package = escape_data($_POST['std_package']);
	}*/
	
	
	// check for a part side
	if (empty($_POST['part_side']))
	{ 
		$part_side = FALSE;
		$message.= '<p> You are required to enter Part of Side!</p>';
	}
	else
	{ 	
		$part_side = addslashes($_POST['part_side']);
	} 
	
	
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
	$alternative_bom = addslashes($_POST['alternative_bom']);
	$date_create = addslashes($_POST['date1']);
	$date_bom_create = addslashes($_POST['date2']);
	$type_package = addslashes($_POST['type_package']);
	$location_deliver = addslashes($_POST['location_deliver']);
	$station_deliver = addslashes($_POST['station_deliver']);
	$rcv_point = addslashes($_POST['rcv_point']);
	$std_package = addslashes($_POST['std_package']);

	
  
  //---------------------------------------------------------------------------------------
  // material component 
  //----------------------------------------------------------------------------------------

   
//if($material_desc && $material_type && $plant && $bom && $bom_usage && $std_package && $part_side && $status_BOM) //everything ok
if($material_desc && $material_type && $plant && $bom && $bom_usage && $part_side && $status_BOM) //everything ok
{      	
	
	$query_search = "SELECT * FROM mat_master_header WHERE id_hdr = '".sql_esc($row2["id_hdr"])."'";
	$result_search = mysqli_query($dbc,$query_search);   //run the query.
	$num_search = mysqli_num_rows($result_search);   //how many suppliers are there?

	if($num_search == 1) 
	{
		//echo $num_search; 
		$row_search = mysqli_fetch_array($result_search);
		
		// update tbl header
		$query_upd = "UPDATE mat_master_header SET material_desc = '".sql_esc($material_desc)."', material_type = '".sql_esc($material_type)."', material_group = '".sql_esc($material_group)."', plant = '".sql_esc($plant)."', bom = '".sql_esc($bom)."', alternative_bom = '".sql_esc($alternative_bom)."', bom_usage = '".sql_esc($bom_usage)."', BUn = '".sql_esc($BUn)."', date_create = '".sql_esc($date_create)."', date_bom_create = '".sql_esc($date_bom_create)."', std_package = '".sql_esc($std_package)."', part_side = '".sql_esc($part_side)."', status_BOM = '".sql_esc($status_BOM)."', type_package = '".sql_esc($type_package)."', location_deliver = '".sql_esc($location_deliver)."', station_deliver = '".sql_esc($station_deliver)."', date_updated = NOW(), updated_by='".sql_esc($username)."' WHERE id_hdr = '".sql_esc($id_hdr)."'"; 
		$result_upd = mysqli_query($dbc,$query_upd); 
		
		//update tbl material
		$query_updM = "UPDATE table_material SET material_desc = '".sql_esc($material_desc)."',mat_type = '".sql_esc($material_type)."', plan_code = '".sql_esc($plant)."', BUn = '".sql_esc($BUn)."', date_create_bom = '".sql_esc($date_bom_create)."', bom_status = '".sql_esc($status_BOM)."',date_updated = NOW(),updated_by = '".sql_esc($username)."' WHERE  material_no = '".sql_esc($row_mat[1])."' ";
		$result_updM = mysqli_query($dbc,$query_updM);
		
		
		if($_POST['material_type'] == 'Z310')
		{
			
			$searchz3 = "SELECT * FROM table_material_qc WHERE material_no = '".sql_esc($row_mat[1])."' ";
			$rst_searchz3 = mysqli_query($dbc,$searchz3);   
			$result_searchz3 = mysqli_fetch_array($rst_searchz3);
			$result_z3 = mysqli_num_rows($rst_searchz3);

			//if($result_searchz3 > 0)
			if($result_z3 == 1)
			{
				//update table material qc
				$query_updQ = "UPDATE table_material_qc SET material_desc = '".sql_esc($material_desc)."',mat_type = '".sql_esc($material_type)."',plan_code = '".sql_esc($plant)."', BUn = '".sql_esc($BUn)."', date_create_bom = '".sql_esc($date_bom_create)."', bom_status = '".sql_esc($status_BOM)."', material_group = '".sql_esc($material_group)."', date_updated = NOW(), updated_by = '".sql_esc($username)."'	WHERE  material_no = '".sql_esc($row_mat[1])."' "; 
				$result_updQ = mysqli_query($dbc,$query_updQ);
			}
			else
			{			
				//insert into table material QC FOR Z310
				$ist_qc = "INSERT INTO table_material_qc
					(id_mat,material_no,material_desc,mat_type,plan_code,BUn,date_create_bom,bom_status,material_group,date_uploaded,uploaded_by)
						VALUES('','".sql_esc($row_mat[1])."','".sql_esc($material_desc)."','".sql_esc($material_type)."','".sql_esc($plant)."','".sql_esc($BUn)."','".sql_esc($date_bom_create)."','".sql_esc($status_BOM)."','".sql_esc($material_group)."',NOW(),'".sql_esc($username)."') ";
							
				$result_qc = mysqli_query($dbc,$ist_qc);	
			}
		}
		
			
		
		
			
		
		//DELETE FROM Z310
		//delete header from table material qc if mat type != Z310 
		if($_POST['material_type'] != 'Z310')
		{
			
			//check if exist
			$searchDz3 = "SELECT * FROM mat_master_header WHERE material_no = '".sql_esc($row_mat[1])."' AND status_BOM = '".sql_esc($_POST['status_BOM'])."'  ";
			$rst_searchDz3 = mysqli_query($dbc,$searchDz3) or die(mysql_error());   
			$result_searchDz3 = mysqli_fetch_array($rst_searchDz3);
		
			if($result_searchDz3 > 0)
			{
				$query_delQ = "DELETE FROM table_material_qc WHERE material_no = '".sql_esc($row_mat[1])."' AND bom_status = '".sql_esc($_POST['status_BOM'])."' "; 
				$result_delQ = mysqli_query($dbc,$query_delQ) or die('Error, failed to delete from table material qc.');	 
			}
				
		}
			
		
		//--------------checking for component---------------------------------//
		// $i = 1;
		//for components
		$query_searchCP = "SELECT * FROM mat_master_detail WHERE id_hdr = '".sql_esc($row2["id_hdr"])."'";
		$result_searchCP = mysqli_query($dbc,$query_searchCP);   //run the query.
		$num_searchCP = mysqli_num_rows($result_searchCP);   //how many suppliers are there?
		$row_CP = mysqli_fetch_row($result_searchCP);
		
		
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
			if (empty($_POST['consumption'][$i]))
			{ 
				$consumption = FALSE;
				$message.= '<p> You are required to enter Consumption!</p>';
			}
			else
			{ 
				$consumption = addslashes($_POST['consumption'][$i]);
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
			$alternative_bom_c = addslashes($_POST['alternative_bom_c'][$i]);
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
									 mat_type = '".sql_esc($_POST["mat_type_c"][$i])."', 
									 bom_status = '".sql_esc($_POST["bom_status"][$i])."',
									 matl_group = '".sql_esc($_POST["matl_group"][$i])."', 
									 alternative_bom = '".sql_esc($_POST["alternative_bom_c"][$i])."', 
									 consumption = '".sql_esc($_POST["consumption"][$i])."', 
									 comp_unit = '".sql_esc($_POST["comp_unit"][$i])."', 
									 plant = '".sql_esc($_POST['plant_c'][$i])."',
									 bom = '".sql_esc($_POST['bom_c'][$i])."',
									 sloc = '".sql_esc($_POST["sloc"][$i])."', 
									 isloc = '".sql_esc($_POST["isloc"][$i])."', 
									 valid_from = '".sql_esc($_POST["date3"][$i])."', 
									 date_create_bom = '".sql_esc($_POST["date4"][$i])."',
									 date_updated = NOW(),
									 updated_by = '".sql_esc($username)."' 
									 WHERE id_dtl = '".sql_esc($_POST["id_dtl"][$i])."'";
									 
			$result_upd5 = mysqli_query($dbc,$query_upd5)or die('Error, failed to update tbl master details.');
			
			
			//update tbl material
			$query_updMT = "UPDATE table_material SET material_desc = '".sql_esc($_POST["material_desc_c"][$i])."',
									mat_type = '".sql_esc($_POST["mat_type_c"][$i])."', 
									plan_code = '".sql_esc($_POST['plant_c'][$i])."',
									BUn =  '".sql_esc($_POST['comp_unit'][$i])."',
									date_create_bom = '".sql_esc($_POST["date4"][$i])."',
									bom_status = '".sql_esc($_POST['bom_status'][$i])."',
									date_updated = NOW(),updated_by = '".sql_esc($username)."'
									WHERE material_no = '".sql_esc($result_sc["bill_component"])."' ";
									
			$result_updMT = mysqli_query($dbc,$query_updMT)or die('Error, failed to update tbl material.');
			
			
			//if header = non active,component = non active
			if( $_POST['status_BOM'] == 'N')
			{
				//upd tbl component
		    $updcp = "UPDATE mat_master_detail SET bom_status = '".sql_esc($_POST['status_BOM'])."' WHERE id_hdr = '".sql_esc($row2["id_hdr"])."'"; 
		    $rst_updcp = mysqli_query($dbc,$updcp) or die(mysql_error()); 

				//upd tbl material
			$updtb = "UPDATE table_material SET bom_status = '".sql_esc($_POST['status_BOM'])."' WHERE material_no = '".sql_esc($result_sc["bill_component"])."'"; 
		    $rst_updtb = mysqli_query($dbc,$updtb) or die(mysql_error());
					
			}
			
			
			//update table material qc
			if($_POST["mat_type_c"][$i] == 'Z310')
			{
				//check if exist
	
				$searchz3C = "SELECT * FROM table_material_qc WHERE material_no = '".sql_esc($result_sc["bill_component"])."' AND bom_status = '".sql_esc($_POST['bom_status'][$i])."'";
				$rst_searchz3C = mysqli_query($dbc,$searchz3C);   
				$result_searchz3C = mysqli_fetch_array($rst_searchz3C);
				
				$obj_searchz3C = mysqli_num_rows($rst_searchz3C);
				$occ = mysqli_fetch_row($rst_searchz3C );
				
				
				/*echo "MT". $result_searchz3C['material_no'];
				echo  "</br>";*/
				
				if($result_searchz3C > 0)
				{
					//update table material qc
					$query_updQC = "UPDATE table_material_qc SET material_desc = '".sql_esc($_POST["material_desc_c"][$i])."',
										mat_type = '".sql_esc($_POST["mat_type_c"][$i])."', 
										plan_code = '".sql_esc($_POST['plant_c'][$i])."',
										BUn =  '".sql_esc($_POST['comp_unit'][$i])."',
										date_create_bom = '".sql_esc($_POST["date4"][$i])."',
										bom_status = '".sql_esc($_POST['bom_status'][$i])."',
										material_group = '".sql_esc($_POST['matl_group'][$i])."',
										date_updated = NOW(),updated_by = '".sql_esc($username)."'
										WHERE material_no = '".sql_esc($result_sc["bill_component"])."'  "; 
					$result_updQC = mysqli_query($dbc,$query_updQC);	 
				}
				else
				{			
					//insert into table material QC FOR Z310
					$ist_qc = "INSERT INTO table_material_qc(id_mat,material_no,material_desc,mat_type,plan_code,BUn,date_create_bom,bom_status,material_group,date_uploaded,uploaded_by)
	VALUES('','".sql_esc($result_sc["bill_component"])."','".sql_esc($_POST["material_desc_c"][$i])."','".sql_esc($_POST["mat_type_c"][$i])."','".sql_esc($_POST['plant_c'][$i])."' ,'".sql_esc($_POST['comp_unit'][$i])."','".sql_esc($_POST["date4"][$i])."','".sql_esc($_POST['bom_status'][$i])."','".sql_esc($_POST['matl_group'][$i])."',NOW(),'".sql_esc($username)."' ) ";
					$result_qc = mysqli_query($dbc,$ist_qc);	
					
				}	
			}//end mat type z310
			
			
			
			//DELETE COMPONENT FROM Z310
			//delete component from table material qc if mat type != Z310 
			if($_POST["mat_type_c"][$i] != 'Z310')
			{
				
				//check if exist
				/*$searchDz3C = "SELECT * FROM mat_master_detail WHERE id_hdr = '".$id_hdr."'  ";
				$rst_searchDz3C = mysql_query($searchDz3C) or die(mysql_error());   
				$searchDz3C = mysql_fetch_array($rst_searchDz3C);*/
				
				$searchzD3C = "SELECT * FROM table_material_qc WHERE material_no = '".sql_esc($result_sc["bill_component"])."'";
				$rst_searchzD3C = mysqli_query($dbc,$searchzD3C);   
				$QsearchzD3C = mysqli_fetch_array($rst_searchzD3C);
				
				
				if($QsearchzD3C > 0)
				{
					$query_delQC = "DELETE FROM table_material_qc WHERE material_no = '".sql_esc($result_sc["bill_component"])."' AND bom_status = '".sql_esc($_POST['bom_status'][$i])."' "; 
					$result_delQC = mysqli_query($dbc,$query_delQC);	 
				}
					
			}
				

			$i++;
			} // end while loop
			

		
		}//end if ada component
		
		
		if($result_upd || $result_updM || $result_upd5 || $result_updMT )
		{
				echo "<script>";
				echo "alert('Material Request successfully update.');";
				echo "parent.tb_remove(); parent.location.reload(1)";
				echo "</script>"; 	
				
				//echo "bb";
		}
		/*elseif()
		{
		}*/
		
	}//end if ada header

	  
} 
//---------------------------function message------------------------------ 
if (isset($message))
{ 
	echo '<div class="msg msg-error"><font color="red" class ="error_entry">', $message, '</font></div>';
}
} 
 ?>



   <form name="form1" method="post" action="" >
   <table width="100%" cellspacing="5">
   <tr>
    <td width="191">Material No.</td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="material_no" name="material_no" readonly value="<?php  echo $row_mat["material_no"]; ?>" class="form-control"></td>
    </tr>
  <tr>
    <td>Material Description</td>
    <td width="28">:</td>
    <td><input type="text" id="material_desc" name="material_desc" value="<?php echo $row_mat["material_desc"]; ?>" class="form-control"/></td>
    </tr>
  <tr>
    <td>Material Type</td>
    <td>:</td>
    <td><input type="text" id="material_type" name="material_type" value="<?php echo $row_mat["material_type"];  ?>" class="form-control"/>
     </td>
    </tr>
  <tr>
    <td>Material Group</td>
    <td>:</td>
    <td><input type="text" id="material_group" name="material_group"  value="<?php echo $row_mat["material_group"];  ?>" class="form-control"/>
     </td>
    </tr>
      <tr>
    <td>Plant</td>
    <td>:</td>
   <td><input type="text" id="plant" name="plant" value="<?php echo $row_mat["plant"];  ?>" class="form-control"/> </td>
    </tr>
     <tr>
    <td>BOM</td>
    <td>:</td>
   <td><input type="text" id="bom" name="bom" value="<?php echo $row_mat["bom"];  ?>" class="form-control"/> </td>
    </tr>
     <tr>
    <td>Alternative BOM</td>
    <td>:</td>
   <td><input type="text" id="alternative_bom" name="alternative_bom" value="<?php echo $row_mat["alternative_bom"];  ?>" class="form-control"/> </td>
    </tr>
     <tr>
    <td>BOM Usage</td>
    <td>:</td>
   <td><input type="text" id="bom_usage" name="bom_usage" value="<?php echo $row_mat["bom_usage"];  ?>" class="form-control"/> </td>
    </tr>
     <tr>
    <td>UOM</td>
    <td>:</td>
   <td>
   
    <?php		
 echo ' <select name="uom" class="form-control">
  <option value=""> --Select UOM -- </option>';
  
  //Retrieve and display the available types
  $query_unit = 'Select * from uom_con WHERE status_uom = "Y"';
  $result_unit = mysqli_query($dbc,$query_unit);
  
     while($row_unit = mysqli_fetch_array($result_unit)) {
	 ?>
               <!--RETAIN VALUE-->
   <option value="<?php echo $row_unit["UOM"]; ?>" <?php if($row_unit["UOM"]==$row_mat["BUn"]) echo "selected"; ?>> <?php echo $row_unit["UOM"]; ?></option>
               <?php }
             
	 
	  	//complete the form
	
	echo '</select>';

	?>
   
   
   
   
   <input type="text" id="BUn" name="BUn" value="<?php echo $row_mat["BUn"];  ?>" class="form-control"/> </td>
    </tr>
     <tr>
    <td>Date Created <font color="#FF0000">*</font></td>
    <td>:</td>
   <td> <?php
    
					 $dt = substr($row_mat[10],8,2);
					 $mt = substr($row_mat[10],5,2);
					 $yr = substr($row_mat[10],0,4);
	 
	                  $myCalendar = new tc_calendar("date1", true, false);
					  $myCalendar->setIcon("../calendar/images/iconCalendar.gif");
					  $myCalendar->setDate($dt,$mt,$yr);
					  $myCalendar->setPath("../calendar/");
					  $myCalendar->setYearInterval(2000, 2030);
					 // $myCalendar->setAlignment('left', 'bottom');
					  $myCalendar->setOnChange("myChanged('test')");
					  $myCalendar->writeScript();
					  
             ?> </td>
    </tr>
     <tr>
    <td>Date BOM Created</td>
    <td>:</td>
   <td><?php
    
					 $dt2 = substr($row_mat[11],8,2);
					 $mt2 = substr($row_mat[11],5,2);
					 $yr2 = substr($row_mat[11],0,4);
	 
	                  $myCalendar = new tc_calendar("date2", true, false);
					  $myCalendar->setIcon("../calendar/images/iconCalendar.gif");
					  $myCalendar->setDate($dt2,$mt2,$yr2);
					  $myCalendar->setPath("../calendar/");
					  $myCalendar->setYearInterval(2000, 2030);
					  $myCalendar->setOnChange("myChanged('test')");
					  $myCalendar->writeScript();
					  
					?> </td>
    </tr>
     <tr>
    <td>Standard Packaging <font color="#FF0000">*</font></td>
    <td>:</td>
   <td><input type="text" id="std_package" name="std_package" value="<?php echo $row_mat["std_package"];  ?>" class="form-control"/> </td>
    </tr>
     <tr>
    <td>Type of package</td>
    <td>:</td>
   <td><input type="text" id="type_package" name="plant" value="<?php echo $row_mat["type_package"];  ?>" class="form-control"/> </td>
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
    <td>Part of Side <font color="#FF0000">*</font></td>
    <td>:</td>
   <td> <select name="part_side"  class="form-control">
            <option value="NULL" placeholder="Select Part of Side"> -- Select Part of Side --</option>
            <option value="LH"  <?php if($row_mat[18] == 'LH') echo "selected"; ?>>LH - Left Hand</option>
            <option value="RH" <?php if($row_mat[18] == 'RH') echo "selected"; ?>>RH - Right Hand</option>
            <option value="RH/LH" <?php if($row_mat[18] == 'RH/LH') echo "selected"; ?>>RH/LH - Right Hand/Left Hand</option>
             <option value="LH/RH" <?php if($row_mat[18] == 'LH/RH') echo "selected"; ?>>LH/RH - Left Hand/Right Hand</option>
            </select></td>
    </tr>
     <tr>
    <td>Status</td>
    <td>:</td>
   <td><select name="status_BOM"  class="form-control">
       <option value="NULL" placeholder="Select Status"> -- Select Status --</option>
	   <option value="Y" <?php if($row_mat[12] == 'Y') echo "selected"; ?>>Y - Active</option>
	   <option value="N" <?php if($row_mat[12] == 'N') echo "selected"; ?>>N - Inactive</option>
	   </select> </td>
    </tr>
     <tr>
    <td>Factory</td>
    <td>:</td>
    <td>
             <select name="id_factory" id="id_factory" class="form-control">
                <option value="NULL" placeholder="Select Factory"> -- Select Factory --</option>
                <?php
	               $query3 = "SELECT * FROM factory_detail GROUP BY factory_desc2 ORDER BY id_fac ASC";
                   $result3 = mysqli_query($dbc,$query3);
  
                   while($row3 = mysqli_fetch_array($result3)) 
			      {
				  
				  
				  ?>
                <option value="<?php echo $row3["factory_desc2"]; ?>" <?php if($row3["factory_desc2"] == $row_mat["id_factory"]) echo "selected"; ?>> <?php echo $row3["factory_desc"]; ?></option>
                <?php
                  }
				?>
              </select>
    
   </td>
    </tr>
   </table>                         
       </div> <!-- card -->
       </div><!-- /# card -->
       <br />

              
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
</body>
</html>