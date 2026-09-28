<?php
    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2);
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
  <meta name="description" content="<?php echo html_esc($data_setup["tajuk_sys"]); ?>">
    <title><?php echo html_esc($data_setup["title_desc"]); ?></title>
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

 
  <div class="modal fade" id="myNoteEdit<?php echo html_esc($row2["id_hdr"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
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
	/*$material_no = $_POST['material_no']; 
	$material_desc = $_POST['material_desc']; 
	$material_type = $_POST['material_type']; 
	$material_group = $_POST['material_group']; 
	$plant = $_POST['plant']; 
	$bom = $_POST['bom']; 
	$alternative_bom = $_POST['alternative_bom'];
	$bom_usage = $_POST['bom_usage']; 
	$std_package = $_POST['std_package']; 
	$part_side = $_POST['part_side'];*/
	$status_BOM = $_POST['status_BOM']; 
	//$BUn = $_POST['BUn'];

	$message = NULL; // create an empty new variable.
	
  
  //---------------------------------------------------------------------------------------
  // material component 
  //----------------------------------------------------------------------------------------

if($_POST['status_BOM'] == 'Y')
{      	
	
	$query_search = "SELECT * FROM mat_master_header WHERE id_hdr = '".sql_esc($row2["id_hdr"])."'";
	$result_search = mysqli_query($dbc,$query_search);   //run the query.
	$num_search = mysqli_num_rows($result_search);   //how many suppliers are there?


	//if($num_search == 1) 
	//{
		//echo $num_search; 
		$row_search = mysqli_fetch_array($result_search);
		
		// update tbl header
		$query_upd = "UPDATE mat_master_header SET status_BOM = '".sql_esc($status_BOM)."', date_updated = NOW(), updated_by = '".sql_esc($username)."' WHERE id_hdr = '".sql_esc($row2["id_hdr"])."'"; 
		$result_upd = mysqli_query($dbc,$query_upd); 
		
	
			
		$query_updQ = "UPDATE table_material_itsb SET status_BOM = '".sql_esc($status_BOM)."', date_update = NOW(), user_update = '".sql_esc($username)."' WHERE material_no = '".sql_esc($row_search["material_no"])."'"; 
		$result_updQ = mysqli_query($dbc,$query_updQ);
		
		
		
		//-------------- for component------------------------------//
		
		$query_searchCP = "SELECT * FROM mat_master_detail WHERE id_hdr = '".sql_esc($row2["id_hdr"])."'";
		$result_searchCP = mysqli_query($dbc,$query_searchCP);   //run the query.
		$num_searchCP = mysqli_num_rows($result_searchCP);   //how many suppliers are there?
		$row_CP = mysqli_fetch_row($result_searchCP);
		$row_CP2 = mysqli_fetch_array($result_searchCP);
		
		//if ada components
		if($num_searchCP  > 0)
		{
			
			$id_dtl = $_POST['id_dtl'];//id component
			$bill_component = $_POST['bill_component'];//id component
			$size = count($_POST["id_dtl"]) + 1;
			$bom_status = $_POST['bom_status'];
			
			$i = 1;
			
			///--------------------------start checking component ---------------------------------------------------  
			// check for a material_desc_c
			
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
			
		
			while ($i < $size) {
			
			$id_dtl = $_POST['id_dtl'];//id component
			$bill_component = $_POST['bill_component'];//id component
			
				
	  		   if($_POST["bom_status"][$i] == 'Y')//if update component status = Y,but header status = N
			 {
				
					//update tbl component
					$query_upd5 = "UPDATE mat_master_detail SET
									 bom_status = '".sql_esc($_POST["bom_status"][$i])."', date_updated = NOW(), updated_by = '".sql_esc($username)."'
										WHERE id_dtl = '".sql_esc($_POST["id_dtl"][$i])."'";
					$result_upd5 = mysqli_query($dbc,$query_upd5);
					
				$query_sel = "SELECT * FROM mat_master_detail WHERE id_dtl = '".sql_esc($_POST["id_dtl"][$i])."'";
				$result_sel = mysqli_query($dbc,$query_sel); 
				$row_sel = mysqli_fetch_array($result_sel);
				
					//update tbl material
					$query_updMT = "UPDATE table_material_itsb SET status_BOM = '".sql_esc($_POST['bom_status'][$i])."', date_update = NOW(), user_update = '".sql_esc($username)."' WHERE id_dtl = '".sql_esc($_POST["id_dtl"][$i])."'";
					$result_updMT = mysqli_query($dbc,$query_updMT);
					
					
				
			      }
			

			$i++;
			} // end while loop

		
		}//end if ada component
	
	
			echo "<script>";
			echo "alert('Material Request successfully update.');";
			echo "window.location='material_master_list_NA.php'";
			echo "</script>"; 
			exit();
		
		
	//}//end if ada header

	  
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
    <td width="69%"><input type="text" id="material_no" name="material_no" readonly value="<?php  echo html_esc($row_mat["material_no"]); ?>" class="form-control"></td>
    </tr>
  <tr>
    <td>Material Description <font color="#FF0000">*</font></td>
    <td width="28">:</td> 
    <td><input type="text" id="material_desc" name="material_desc" value="<?php echo html_esc($row_mat["material_desc"]); ?>" class="form-control" disabled/></td>
    </tr>
  <tr>
    <td>Material Type <font color="#FF0000">*</font></td>
    <td>:</td>
    <td><input type="text" id="material_type" name="material_type" value="<?php echo html_esc($row_mat["material_type"]);  ?>" class="form-control" disabled/>
     </td>
    </tr>
  <tr>
    <td>Material Group</td>
    <td>:</td>
    <td><input type="text" id="material_group" name="material_group"  value="<?php echo html_esc($row_mat["material_group"]);  ?>" class="form-control" disabled/>
     </td>
    </tr>
      <tr>
    <td>Plant <font color="#FF0000">*</font></td>
    <td>:</td>
   <td><input type="text" id="plant" name="plant" value="<?php echo html_esc($row_mat["plant"]);  ?>" class="form-control" disabled/> </td>
    </tr>
     <tr>
    <td>BOM <font color="#FF0000">*</font></td>
    <td>:</td>
   <td><input type="text" id="bom" name="bom" value="<?php echo html_esc($row_mat["bom"]);  ?>" class="form-control" disabled/> </td>
    </tr>
     <tr>
    <td>Alternative BOM</td>
    <td>:</td>
   <td><input type="text" id="alternative_bom" name="alternative_bom" value="<?php echo html_esc($row_mat["alternative_bom"]);  ?>" class="form-control" disabled/> </td>
    </tr>
     <tr>
    <td>BOM Usage</td>
    <td>:</td>
   <td><input type="text" id="bom_usage" name="bom_usage" value="<?php echo html_esc($row_mat["bom_usage"]);  ?>" class="form-control" disabled/> </td>
    </tr>
    <tr>
    <td>UOM</td>
    <td>:</td>
   <td>
   
    <?php		
    echo '<select name="BUn" class="form-control" disabled>
       <option value=""> --Select UOM -- </option>';
  
	  //Retrieve and display the available types
	  $query_unit = 'Select * from uom_con WHERE status_uom = "Y"';
	  $result_unit = mysqli_query($dbc,$query_unit);
  
		 while($row_unit = mysqli_fetch_array($result_unit)) {
		 ?>
				   <!--RETAIN VALUE-->
	   <option value="<?php echo html_esc($row_unit["UOM"]); ?>" <?php if($row_unit["UOM"] == $row_mat["BUn"]) echo "selected"; ?>> <?php echo html_esc($row_unit["UOM"]); ?></option>
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
   <input type="date" name="date1" class="form-control input-xlarge datepicker" value="<?php echo html_esc($row_mat["date_create"]); ?>" disabled >
   </td>
   </tr>
    <tr>
    <td>Date BOM Created </td>
    <td>:</td>
   <td>
   <input type="date" name="date2" class="form-control input-xlarge datepicker" value="<?php echo html_esc($row_mat["date_bom_create"]); ?>" disabled >
   </td>
   </tr>
        <tr>
    <td>Standard Packaging <font color="#FF0000">*</font></td>
    <td>:</td>
   <td><input type="text" id="std_package" name="std_package" value="<?php echo html_esc($row_mat["std_package"]);  ?>" class="form-control" disabled/> </td>
    </tr>
     <tr>
    <td>Type of package</td>
    <td>:</td>
   <td><input type="text" id="type_package" name="type_package" value="<?php echo html_esc($row_mat["type_package"]);  ?>" class="form-control" disabled/> </td>
    </tr>
     <tr>
    <td>Location Deliver</td>
    <td>:</td>
   <td><input type="text" id="location_deliver" name="location_deliver" value="<?php echo html_esc($row_mat["location_deliver"]);  ?>" class="form-control" disabled/> </td>
    </tr>
     <tr>
    <td>Station Deliver</td>
    <td>:</td>
   <td><input type="text" id="station_deliver" name="station_deliver" value="<?php echo html_esc($row_mat["station_deliver"]);  ?>" class="form-control" disabled/> </td>
    </tr>
     <tr>
    <td>Received Point</td>
    <td>:</td>
   <td><input type="text" id="rcv_point" name="rcv_point" value="<?php echo html_esc($row_mat["rcv_point"]);  ?>" class="form-control" disabled/> </td>
    </tr>
     <tr>
    <td>Part of Side <font color="#FF0000">*</font></td>
    <td>:</td>
   <td> <select name="part_side"  class="form-control" disabled>
            <option value="NULL" placeholder="Select Part of Side"> -- Select Part of Side --</option>
            <option value="LH"  <?php if($row_mat["part_side"] == 'LH') echo "selected"; ?>>LH - Left Hand</option>
            <option value="RH" <?php if($row_mat["part_side"] == 'RH') echo "selected"; ?>>RH - Right Hand</option>
            <option value="RH/LH" <?php if($row_mat["part_side"] == 'RH/LH') echo "selected"; ?>>RH/LH - Right Hand/Left Hand</option>
             <option value="LH/RH" <?php if($row_mat["part_side"] == 'LH/RH') echo "selected"; ?>>LH/RH - Left Hand/Right Hand</option>
            </select></td>
    </tr>
 <tr>
    <td>Status <font color="#FF0000">*</font></td>
    <td>:</td>
   <td><select name="status_BOM"  class="form-control">
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
                   <input name="bill_component[<?php echo $i; ?>]" type="text" id="bill_component" size="20" maxlength="8" readonly value="<?php echo html_esc($row_9["bill_component"]);   ?>" class="form-control" />
                 </td>
               </tr>
               <tr>
                 <td>Component Description <font color="#FF0000">*</font></td>
                 <td>:</td>
                 <td>
                   <input name="material_desc_c[<?php echo $i; ?>]" type="text"  class="form-control" id="material_desc_c" size="55" maxlength="100" value="<?php echo html_esc($row_9["material_desc_c"]); ?>" disabled />
                </td>
               </tr>
                        <tr>
                 <td>Material Type <font color="#FF0000">*</font></td>
                 <td>:</td>
                 <td>
         <input name="mat_type_c[<?php echo $i; ?>]" type="text"  class="form-control" id="mat_type_c" size="20" maxlength="20" value="<?php echo html_esc($row_9["material_type"]); ?>" disabled/>
                 </td>
               </tr>
               
               <tr>
                 <td>Material Group</td>
                 <td>:</td>
                 <td><input name="matl_group[<?php echo $i; ?>]" type="text"  class="form-control" id="matl_group" size="20" maxlength="20" value="<?php echo html_esc($row_9["matl_group"]); ?>" disabled/></td>
               </tr>
      
               <tr>
                 <td>Plant <font color="#FF0000">*</font></td>
                 <td>:</td>
                 <td><input name="plant_c[<?php echo $i; ?>]" type="text" class="form-control" id="plant_c" size="20" maxlength="20" value="<?php echo html_esc($row_9["plant"]); ?>" disabled />
               </td>
               </tr>
               <tr>
                 <td>BOM <font color="#FF0000">*</font></td>
                 <td>:</td>
                 <td><input name="bom_c[<?php echo $i; ?>]" type="text" class="form-control" id="bom_c" size="20" maxlength="20" value="<?php echo html_esc($row_9["bom"]); ?>" disabled/>
                </td>
               </tr>
               <tr>
                 <td>Alternative BOM</td>
                 <td>:</td>
                 <td>
         <input name="alternative_bom_c[<?php echo $i; ?>]" type="text"  class="form-control" id="alternative_bom_c" size="20" maxlength="20" value="<?php echo html_esc($row_9["alternative_bom"]); ?>" disabled/>
                 </td>
               </tr>
               <tr>
                 <td>Consumption <font color="#FF0000">*</font></td>
                 <td>:</td>
                 <td>
                   <input name="consumption[<?php echo $i; ?>]" type="text" class="form-control" id="consumption" size="20" maxlength="20" value="<?php echo html_esc($row_9["consumption"]); ?>" disabled/>
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
                 
                   <input name="comp_unit[<?php echo $i; ?>]" type="text" class="form-control" id="comp_unit" size="20" maxlength="20" value="<?php echo html_esc($row_9["comp_unit"]); ?>" disabled/>
                 </td>
               </tr>
                    <tr>
                 <td>SLoc</td>
                 <td>:</td>
                 <td>
                   <input name="sloc[<?php echo $i; ?>]" type="text" class="form-control" id="sloc" size="20" maxlength="20" value="<?php echo html_esc($row_9["sloc"]); ?>" disabled/>
                 </td>
               </tr>
                 <tr>
                 <td>IsLoc</td>
                 <td>:</td>
                 <td>
                   <input name="isloc[<?php echo $i; ?>]" type="text" class="form-control" id="isloc" size="20" maxlength="20" value="<?php echo html_esc($row_9["isloc"]); ?>" disabled/>
                 </td>
               </tr>
               <tr>
                 <td>Valid From</td>
                 <td>:</td>
                 <td>
              <input name="date3[<?php echo $i; ?>]" type="date" class="form-control input-xlarge datepicker" id="date3" size="20" maxlength="20" value="<?php echo html_esc($row_9["valid_from"]); ?>" disabled/>   
                </td>
               </tr>
               <tr>
                 <td>Date BOM Created</td>
                 <td>:</td>
                 <td>
                  <input name="date4[<?php echo $i; ?>]" type="date" class="form-control input-xlarge datepicker" id="date4" size="20" maxlength="20" value="<?php echo html_esc($row_9["date_create_bom"]); ?>" disabled />
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
                 <td> <select name="bom_status[<?php echo $i; ?>]"  class="form-control" required>
                      <option value ="<?php  echo html_esc($row_9["bom_status"]); ?>" ><?php  echo $sts; ?></option>
                      <option value="Y" class="title">Active</option>
                      <option value="N" class="title">Inactive</option>
                      </select></td>
               </tr>
               <tr>
                 <td>&nbsp; <input type="hidden" name="id_dtl[<?php echo $i; ?>]" id="id_dtl" value="<?php echo html_esc($row_9["id_dtl"]); ?>"></td>
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
             <input type="hidden" id="id_hdr" name="id_hdr"  class="form-control" value="<?php echo html_esc($row2["id_hdr"]);  ?>" >  
             <input name="submit9" type="submit" id="submit9" value="UPDATE" class="btn btn-info" onClick="return confirm('Confirm to update?');" >             
			 <button type="button" class="btn btn-success" data-dismiss="modal">CLOSE</button>
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