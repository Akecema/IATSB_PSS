<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "1")) {
header('Location: ../index.php');
exit();
}

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
$url = "material_master_list.php"; 
	?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo html_esc($data_setup["tajuk_sys"]); ?>">
    <title><?php echo html_esc($data_setup["title_desc"]); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../images/favicon.ico">
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
  </head>
  
  <body class="app sidebar-mini">
    <!-- Navbar-->
      <?php   include "top_modal_menu.php";   ?>
    
    
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <?php   include "left_admin_menu.php";   ?>
  
    <main class="app-content">
      <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> Table Maintenance</h1>
          <p>Material Master</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Table Maintenance</li>
          <li class="breadcrumb-item"><a href="material_add_detail.php">Add Material Detail</a></li>
        </ul>
      </div> 
             <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link" href="material_master_list.php">Material Master</a></li>
                <li class="nav-item"><a class="nav-link" href="material_master_list_NA.php">Material Master (Non Active)</a></li>
                <li class="nav-item"><a class="nav-link"  href="material_hdr_upload.php">Material Header Upload</a></li>
                <li class="nav-item"><a class="nav-link"  href="material_detail_upload.php">Material Detail Upload</a></li>
                <li class="nav-item"><a class="nav-link"  href="material_add_hdr.php">Add Material Header</a></li>
                <li class="nav-item"><a class="nav-link active"  data-toggle="tab"href="material_add_detail.php">Add Material Detail</a></li>
            </ul>
      <?php
	  
	  $message_matno = "";
	  $message_matdesc = "";
	  $message_pcode = "";
	  $message_ccd = "";
	  $message_ccdA = "";
	  $message_matbom = "";
	  $message_mtype = "";
	  $message_sta = "";
	  $message_unit = "";
	  $message_consum = "";
	  $message_ccdA = "";
    $message_cvclass = "";
	  
	  
if (isset($_POST['submit'])) 
{ // handle the form.


$material_no = $_POST['material_no'];
$material_desc_c = $_POST['material_desc_c'];
$bill_component = $_POST['bill_component'];
$mat_type = $_POST['mat_type'];
$material_group = $_POST['material_group'];
$plant_code = $_POST['plant_code'];
$sloc = $_POST['sloc'];
$isloc = $_POST['isloc'];
$bom = $_POST['bom'];
$alternative_bom = $_POST['alternative_bom'];
$bom_usage = $_POST['bom_usage'];
$comp_vclass = $_POST['comp_vclass'];
$comsumption = $_POST['comsumption'];
$cbom_usage = $_POST['cbom_usage'];
$bom_cat = $_POST['bom_cat'];
$cbom_cat = $_POST['cbom_cat'];
$bom_item = $_POST['bom_item'];
$bom_node = $_POST['bom_node'];
$ver_no = $_POST['ver_no'];
$date1 = $_POST['date1'];
$date2 = $_POST['date2'];
$BUn = $_POST['BUn'];
$status_BOM = $_POST['status_BOM'];


$message = NULL; // create an empty new variable.


//-------check material no not duplicate------------------

    $query_check_wujud = "SELECT * FROM mat_master_detail WHERE material = '".sql_esc($material_no)."' AND BOM_status = 'Y' AND bill_component = '".sql_esc($bill_component)."' ";
	$result_check_wujud = mysqli_query($dbc,$query_check_wujud);
    $data_check_wujud = mysqli_fetch_array($result_check_wujud);
	
		     if($data_check_wujud["material_no"]  > 0)
				 {
			
				  echo "<script>";
				  echo "alert('ERROR! Material No. is already exist. Please update Status of Material.');";
				  echo "window.location='material_master_list.php'";
				  echo "</script>";
				  exit(); //quit the script
			 
				 }








//------------------------------end function --------------------------------
// check for a material No.
if ((empty($_POST['material_no'])) || ($_POST['material_no'] == "NULL"))
{ 
   $material_no = FALSE;
   $message_matno = '<span class="badge badge-pill badge-danger">Please select Material No.!</span>';
 
  }else
  { $material_no = addslashes($_POST['material_no']);
  }
  
  // check for a Component
if (empty($_POST['bill_component']))
{ 
   $bill_component = FALSE;
   $message_matbom = '<span class="badge badge-pill badge-danger">Please enter Component!</span>';
 
  }else
  { $bill_component = addslashes($_POST['bill_component']);
  }

  
// check for a material Desc
if (empty($_POST['material_desc_c']))
{ 
   $material_desc_c = FALSE;
   $message_matdesc = '<span class="badge badge-pill badge-danger">Please enter Component Description!</span>';
  }
    else
  { $material_desc_c = addslashes($_POST['material_desc_c']);
  }
  
// check for a plant code
if (empty($_POST['plant_code']) || ($_POST['plant_code'] == "NULL"))
{ 
     $plant_code = FALSE;
 	 $message_pcode = '<span class="badge badge-pill badge-danger">Please select Plant!</span>';
  }
    else
  { $plant_code =  addslashes($_POST['plant_code']);
  }


// check for a mat type
if ((empty($_POST['mat_type'])) || ($_POST['mat_type']) == "NULL")
{ 
   $mat_type = FALSE;
   $message_mtype = '<span class="badge badge-pill badge-danger">Please select Material Type!</span>';
 
  }
    else
  { $mat_type = addslashes($_POST['mat_type']);
  }
  
  // check for a sloc
if ((empty($_POST['sloc'])) || ($_POST['sloc']) == "NULL")
{ 
   $sloc = FALSE;
   $message_ccd = '<span class="badge badge-pill badge-danger">Please select SLoc!</span>';
 
  }
    else
  { $sloc = addslashes($_POST['sloc']);
  }
  
  
   // check for a isloc
if ((empty($_POST['isloc'])) || ($_POST['isloc']) == "NULL")
{ 
   $isloc = FALSE;
   $message_ccdA = '<span class="badge badge-pill badge-danger">Please select IsLoc!</span>';
 
  }
    else
  { $isloc = addslashes($_POST['isloc']);
  }


  
   // check for a bon vclass
if ((empty($_POST['comp_vclass'])) || ($_POST['comp_vclass']) == "")
{ 
   $comp_vclass = FALSE;
   $message_cvclass= '<span class="badge badge-pill badge-danger">Please enter BOM Vclass!</span>';
 
  }
    else
  { $comp_vclass = addslashes($_POST['comp_vclass']);
  }
  
  

// check for BUn
if ((empty($_POST['BUn']) || ($_POST['BUn'] == "NULL")))
{ 
 $BUn = FALSE;
 $message_unit = '<span class="badge badge-pill badge-danger">Please select BUn!</span>';

  }
  else
  { $BUn = addslashes($_POST['BUn']);
  }
  
 
  
   //check comsumption
 
if ((empty($_POST['comsumption']) || ($_POST['comsumption'] == "")))
{ 
 $comsumption = FALSE;
 $message_consum = '<span class="badge badge-pill badge-danger">Please enter Comsumption!</span>';

  }
  else
  { $comsumption = addslashes($_POST['comsumption']);
  }  

  
   

// check for con sstatus
if (empty($_POST['status_BOM']) || ($_POST['status_BOM'] == "NULL"))
{ 
  $status_BOM = FALSE;
  $message_sta = '<span class="badge badge-pill badge-danger">Please select Status!</span>';
 
  }
  else
  { $status_BOM = addslashes($_POST['status_BOM']);
  }
  
  //---------------------------------------------------------------------------------------
  // material component 
  //----------------------------------------------------------------------------------------

   
 if($material_no && $material_desc_c && $plant_code && $mat_type && $sloc && $isloc && $BUn && $comsumption && $status_BOM && $comp_vclass) //everything ok
{ 


$material_no = $_POST['material_no'];
$material_desc_c = $_POST['material_desc_c'];
$bill_component = $_POST['bill_component'];
$mat_type = $_POST['mat_type'];
$material_group = $_POST['material_group'];
$plant_code = $_POST['plant_code'];
$sloc = $_POST['sloc'];
$isloc = $_POST['isloc'];
$bom = $_POST['bom'];
$alternative_bom = $_POST['alternative_bom'];
$bom_usage = $_POST['bom_usage'];
$comp_vclass = $_POST['comp_vclass'];
$comsumption = $_POST['comsumption'];
$cbom_usage = $_POST['cbom_usage'];
$bom_cat = $_POST['bom_cat'];
$cbom_cat = $_POST['cbom_cat'];
$bom_item = $_POST['bom_item'];
$bom_node = $_POST['bom_node'];
$ver_no = $_POST['ver_no'];
$date1 = $_POST['date1'];
$date2 = $_POST['date2'];
$BUn = $_POST['BUn'];
$status_BOM = $_POST['status_BOM'];

    	
$query_mat_info = new PreparedSql("SELECT * FROM mat_master_header WHERE material_no = ? AND status_BOM = 'Y'", [$material_no]);
$result_mat_info = db_query($dbc, $query_mat_info);
$row_minfo = mysqli_fetch_array($result_mat_info);


$query_type = "SELECT * FROM material_type_tbl WHERE id = '".sql_esc($mat_type)."' ";
$result_type = mysqli_query($dbc,$query_type);
$row_type = mysqli_fetch_array($result_type);

	

		//----------------insert table_material_itsb-------------------------------	
		
        $query_tmbh_data = "INSERT INTO mat_master_detail(id_dtl,id_hdr,material,bom_category,bom,alternative_bom,valid_from,plant,sloc,isloc,bill_component,matl_group,bom_item_category,bom_item_no,comp_unit,consumption,material_desc_c,material_type,usage_c,date_create_bom,bom_status,date_uploaded,uploaded_by,date_updated,updated_by,cvalid_to,comp_matl_group,cvalid_from,comp_vclass,bom_usage,node_no,ver_no,header_matl_type) VALUES ('','".sql_esc($row_minfo["id_hdr"])."','".sql_esc($row_minfo["material_no"])."','".sql_esc($cbom_cat)."','".sql_esc($bom)."','".sql_esc($alternative_bom)."','".sql_esc($row_minfo["date_bom_create"])."','".sql_esc($plant_code)."','".sql_esc($sloc)."','".sql_esc($isloc)."','".sql_esc($bill_component)."','".sql_esc($material_group)."','".sql_esc($bom_cat)."','".sql_esc($bom_item)."','".sql_esc($BUn)."','".sql_esc($comsumption)."','".sql_esc($material_desc_c)."','".sql_esc($row_type["mat_type_id"])."','".sql_esc($bom_usage)."','".sql_esc($row_minfo["date_bom_create"])."','".sql_esc($status_BOM)."','".sql_esc($row_minfo["date_uploaded"])."','".sql_esc($row_minfo["uploaded_by"])."',NOW(),'".sql_esc($username)."','".sql_esc($date2)."','".sql_esc($row_minfo["material_group"])."','".sql_esc($date1)."','".sql_esc($comp_vclass)."','".sql_esc($cbom_usage)."','".sql_esc($bom_node)."','".sql_esc($ver_no)."','".sql_esc($row_minfo["material_type"])."')";
		$result_tmbh_data = mysqli_query($dbc,$query_tmbh_data); 	
		
								
			if($result_tmbh_data)
			{
				
			 echo "<script>";
		     echo "alert('Material is successfully created.');";
		     echo "window.location='material_master_list.php'";
	         echo "</script>"; 
		     exit(); //quit the script
			
							
  } else { echo 'Cannot create record'; 
  }
}
//print the message if there is one.
	  
} 
 
 

?>    
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Add Material Detail</h3>
            <div class="tile-body">
              <form name="form1" method="post" action="" class="form-horizontal">
                <div class="form-group row">
                  <label class="control-label col-md-3">Material No. :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                  <select name="material_no" id="material_no" class="form-control">
                <option value="NULL" placeholder="Select Material No."> -- Select Material No. -- </option>
                   <?php
	
	$query_mat = "SELECT * FROM mat_master_header WHERE status_BOM = 'Y' ORDER BY id_hdr ASC";
    $result_mat =mysqli_query($dbc,$query_mat);
	
	 while($row_mat = mysqli_fetch_array($result_mat)) 
	  { 
	?>  
          <option value="<?php echo html_esc($row_mat["material_no"]); ?>" <?php if($row_mat["material_no"] == ($_POST["material_no"])) echo "selected"; ?>> <?php echo stripslashes($row_mat["material_no"]); ?> - <?php echo stripslashes($row_mat["material_desc"]); ?></option>
  <?php   }  ?>
  
          </select>    
      <div class="form-control-feedback" ><?php echo $message_matno; ?></div>
                    </div>
                </div>
                
                
                 <div class="tile">
                 <h5 class="title-title">Add Components </h5> <br>
                
                  <div class="form-group row">
                  <label class="control-label col-md-3">Component : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                  <input type="text" id="bill_component" name="bill_component" value="<?php if(isset($_POST['bill_component'])) echo html_esc($_POST['bill_component']); ?>" class="form-control" placeholder="Enter Component" />
                   <div class="form-control-feedback" ><?php echo $message_matbom; ?></div>
                    </div>
                </div>
                
                
                
                  
                 <div class="form-group row">
                  <label class="control-label col-md-3">Component Description : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
           <input type="text" id="material_desc" name="material_desc_c" value="<?php if(isset($_POST['material_desc_c'])) echo html_esc($_POST['material_desc_c']); ?>" class="form-control" placeholder="Enter Component Description" />
                   <div class="form-control-feedback" ><?php echo $message_matdesc; ?></div>
                    </div>
                </div>
                
                 <div class="form-group row">
                  <label class="control-label col-md-3">Plant : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                      		
          <select name="plant_code" class="form-control" onChange="getType(this.value)">
            <option value="NULL" placeholder="Select Plant"> -- Select Plant -- </option>
                  <?php
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM plant_detail WHERE status_plant = "Y"';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
              ?>
                  <option value="<?php echo html_esc($row27["plant_code"]); ?>" <?php if(($row27["plant_code"]) == ($_POST['plant_code'])) echo "selected"; ?>> <?php echo stripslashes($row27["plant_code"]); ?> - <?php echo html_esc($row27["plant_desc"]); ?></option>
                  <?php
           }  ?>
                </select>
                   <div class="form-control-feedback" ><?php echo $message_pcode; ?></div>
                </div>
              </div>
                 
                 <div class="form-group row">
                  <label class="control-label col-md-3">Material Type :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
              <div id="mtype_div"> 
             <select name="mat_type" id="mat_type" class="form-control" onChange="getModel(this.value)">
             <option value="NULL" placeholder="Select Type"> -- Select Type -- </option>   
                 <?php
	
	$query48 = "SELECT * FROM material_type_tbl WHERE status_type = 'Y' ORDER BY id ASC";
    $result48 =mysqli_query($dbc,$query48);
	
	 while($row48 = mysqli_fetch_array($result48)) 
	  { 
	?>  
          <option value="<?php echo html_esc($row48["id"]); ?>"<?php if(($row48["id"]) == $_POST['mat_type']) echo "selected"; ?> > <?php echo stripslashes($row48["mtype_name"]); ?></option>
  <?php   }  ?>
  
          </select> <div class="form-control-feedback" ><?php echo $message_mtype; ?></div>
              </div>  
             
                </div>
              </div> 
                
                 <div class="form-group row">
               <label class="control-label col-md-3">SAP BOM ID : </label>
               <div class="col-md-8">
               <input type="text" id="bom" name="bom" value="<?php if(isset($_POST['bom'])) echo html_esc($_POST['bom']);  ?> " class="form-control"/>
               </div>  
               </div> 
               <div class="form-group row">
               <label class="control-label col-md-3">Alternative BOM : </label>
               <div class="col-md-8">
               <input type="text" id="alternative_bom" name="alternative_bom" value="<?php if(isset($_POST['alternative_bom'])) echo html_esc($_POST['alternative_bom']);  ?> " class="form-control"/>
               </div>  
               </div> <div class="form-group row">
               <label class="control-label col-md-3">Material Group : </label>
               <div class="col-md-8">
               <input type="text" id="material_group" name="material_group" value="<?php if(isset($_POST['material_group'])) echo html_esc($_POST['material_group']);  ?> " class="form-control"/>
               </div>  
               </div> 
                
   
                <div class="form-group row">
                  <label class="control-label col-md-3">Category BOM : </label>
                    <div class="col-md-8"> 
                <select name="cbom_cat" id="cbom_cat" class="form-control">
                <option value="NULL" placeholder="Select Category BOM"> -- Select Category BOM -- </option>
                   <?php
	
	$query_cbom2 = "SELECT * FROM bom_cat ORDER BY id ASC";
    $result_cbom2 =mysqli_query($dbc,$query_cbom2);
	
	 while($row_cbom2 = mysqli_fetch_array($result_cbom2)) 
	  { 
	?>  
          <option value="<?php echo html_esc($row_cbom2["id_code"]); ?>" <?php if($row_cbom2["id_code"] == ($_POST["cbom_cat"])) echo "selected"; ?>> <?php echo stripslashes($row_cbom2["id_code"]); ?> - <?php echo stripslashes($row_cbom2["desc"]); ?></option>
  <?php   }  ?>
  
          </select>       
                    
               </div></div>  
               
               <div class="form-group row">
               <label class="control-label col-md-3">BOM Item Category : </label>
               <div class="col-md-8">
               <input type="text" id="bom_cat" name="bom_cat" value="<?php if(isset($_POST['bom_cat'])) { echo html_esc($_POST['bom_cat']); }else{ echo 'L';    } ?> " class="form-control"/>
               </div>  
               </div> 
             
              <div class="form-group row">
                  <label class="control-label col-md-3">Item No. BOM : </label>
                    <div class="col-md-8">     
              <input type="text" id="bom_item" name="bom_item" value="<?php if(isset($_POST['bom_item'])) echo html_esc($_POST['bom_item']);  ?>" class="form-control"/>
               </div></div>  
               
               <div class="form-group row">
                  <label class="control-label col-md-3">Material Usage : </label>
                    <div class="col-md-8">     
              <input type="number" id="bom_usage" name="bom_usage" min="1" value="<?php if(isset($_POST['bom_usage'])) echo html_esc($_POST['bom_usage']);  ?>" class="form-control"/>
               </div></div>  

                <div class="form-group row">
                  <label class="control-label col-md-3">BOM Component Usage : </label>
                    <div class="col-md-8">     
              <input type="number" id="cbom_usage" name="cbom_usage" value="<?php if(isset($_POST['cbom_usage'])) echo html_esc($_POST['cbom_usage']);  ?>" class="form-control"/>
               </div></div>  
               
                 
               
                  <div class="form-group row">
                  <label class="control-label col-md-3">Consumption : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
             <input type="text" id="comsumption" name="comsumption" value="<?php if(isset($_POST['comsumption'])) echo html_esc($_POST['comsumption']); ?>" class="form-control"/>
                  <div class="form-control-feedback" ><?php echo $message_consum; ?></div>
                </div>
              </div>
              
               <div class="form-group row">
                  <label class="control-label col-md-3">BOM Node : </label>
                    <div class="col-md-8">
             <input type="number" id="bom_node" name="bom_node" min="1" value="<?php if(isset($_POST['bom_node'])) echo html_esc($_POST['bom_node']); ?>" class="form-control"/>
                
                </div>
              </div>
              
               <div class="form-group row">
                  <label class="control-label col-md-3">Ver. No. : </label>
                    <div class="col-md-8">     
              <input type="number" id="ver_no" name="ver_no"  value="<?php if(isset($_POST['ver_no'])) echo html_esc($_POST['ver_no']);  ?>" class="form-control"/>
               </div></div> 

               <div class="form-group row">
                  <label class="control-label col-md-3">Component VClass : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">     
              <input type="text" id="comp_vclass" name="comp_vclass" value="<?php if(isset($_POST['comp_vclass'])) echo html_esc($_POST['comp_vclass']);  ?>" class="form-control"/>
              <div class="form-control-feedback" ><?php echo $message_cvclass; ?></div>
            </div></div>
                    
             <div class="form-group row">
                  <label class="control-label col-md-3">UOM : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
 <?php		
    echo '<select name="BUn" class="form-control" >
       <option value=""> --Select UOM -- </option>';
  
	  //Retrieve and display the available types
	  $query_unit = 'Select * from uom_con WHERE status_uom = "Y"';
	  $result_unit = mysqli_query($dbc,$query_unit);
  
		 while($row_unit = mysqli_fetch_array($result_unit)) {
		 ?>
				   <!--RETAIN VALUE-->
	   <option value="<?php echo html_esc($row_unit["UOM"]); ?>" <?php if($row_unit["UOM"] == $_POST["BUn"]) echo "selected"; ?>> <?php echo html_esc($row_unit["UOM"]); ?></option>
				   <?php }
             
	 
	  	//complete the form
	
	echo '</select>';

	?>
           <div class="form-control-feedback" ><?php echo $message_unit; ?></div>
           </div></div>
                
                
                 <div class="form-group row">
                  <label class="control-label col-md-3">SLoc : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                    
                     <select name="sloc" class="form-control">
            <option value="NULL" placeholder="Select SLoc"> -- Select SLoc -- </option>
          <?php
          //Retrieve and display the available types
          $query_line = "SELECT * FROM sloc_tbl WHERE status_sloc = 'Y'";
          $result_line = mysqli_query($dbc,$query_line);
          
              while($row_line = mysqli_fetch_array($result_line)) {
        
              ?>
         <option value="<?php echo html_esc($row_line["sloc_code"]); ?>" <?php if($row_line["sloc_code"] == $_POST["sloc"]) echo "selected"; ?>> <?php echo stripslashes($row_line["sloc_code"]); ?> - <?php echo html_esc($row_line["sloc_desc"]); ?></option>
          <?php
           }  ?>
                            
        </select>         
                  <div class="form-control-feedback" ><?php echo $message_ccd; ?></div>
                </div>
              </div>
                
                
                
                
                   <div class="form-group row">
                  <label class="control-label col-md-3">IsLoc : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                    
                     <select name="isloc" class="form-control">
            <option value="NULL" placeholder="Select IsLoc"> -- Select IsLoc -- </option>
          <?php
          //Retrieve and display the available types
          $query_lineA = "SELECT * FROM sloc_tbl WHERE status_sloc = 'Y'";
          $result_lineA = mysqli_query($dbc,$query_lineA);
          
              while($row_lineA = mysqli_fetch_array($result_lineA)) {
        
              ?>
         <option value="<?php echo html_esc($row_lineA["sloc_code"]); ?>" <?php if($row_lineA["sloc_code"] == $_POST["isloc"]) echo "selected"; ?>> <?php echo stripslashes($row_lineA["sloc_code"]); ?> - <?php echo html_esc($row_lineA["sloc_desc"]); ?></option>
          <?php
           }  ?>
                            
        </select>         
                  <div class="form-control-feedback" ><?php echo $message_ccdA; ?></div>
                </div>
              </div>
                
                
                
          <div class="form-group row">
                  <label class="control-label col-md-3">BOM Valid From : </label>
                    <div class="col-md-8">
                <input type="date" name="date1" class="form-control input-xlarge datepicker" value="<?php  if(isset($_POST['date1'])) echo html_esc($_POST['date1']); ?>"  />
        </div></div>
        
        <div class="form-group row">
                  <label class="control-label col-md-3">BOM Valid To : </label>
                    <div class="col-md-8">
                <input type="date" name="date2" class="form-control input-xlarge datepicker" value="<?php  if(isset($_POST['date2'])) echo html_esc($_POST['date2']); ?>" />
        </div></div>  
        
        
        
          <div class="form-group row">
                  <label class="control-label col-md-3">Status BOM : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                     <select name="status_BOM" id="status_BOM" class="form-control">
                       <option value="NULL" placeholder="Select Status"> -- Select Status -- </option>
                   <?php if($_POST['submit'] == true)
						{ ?>
               <option value="Y" <?php if($_POST["status_BOM"] == 'Y') { ?> selected="selected"<?php } ?>>ACTIVE</option>
               <option value="N" <?php if($_POST["status_BOM"] == 'N') { ?> selected="selected"<?php } ?>>INACTIVE</option>
               <?php 
						}
						else
						{ ?>
               <option value="Y">ACTIVE</option>
               <option value="N">INACTIVE</option>
               <?php } ?>
                 </select>
                    <div class="form-control-feedback" ><?php echo $message_sta; ?></div>
                </div>
              </div>
              
              <div class="form-group row">
                  <label class="control-label col-md-3"><font color="#FF0000"><b>* Compulsory field</b></font></label>
                    <div class="col-md-8">
                  &nbsp;
                </div>
              </div>
        
        
          
          
                </div>
                
                
              
                <div class="form-group col-md-8 align-self-end">
               <input name="submit" type="submit" id="submit" value="CREATE" class="btn btn-primary">
               <input name="Reset" type="reset" id="Reset" class="btn btn-warning" value="CLEAR">
                 <!--   <button class="btn btn-primary" type="button" onClick=""><i class="fa fa-fw fa-lg fa-check-circle"></i>Subscribe</button>-->
                </div>
              </form>
            </div>
          </div>
      
         </div>
         </div>
      
          </div>
        </div>
     
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
  
  
  
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
		
		var strURL="findType-MAT.php?plant_code="+plant_code;
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
		
		var strURL="findModel-MAT.php?plant_code="+plant_code+"&mat_type="+mat_type;
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
	
	
	
	/*function getCategory(plant_code,mat_type,model_code) {		
		
		var strURL="findCat-TP.php?plant_code="+plant_code+"&mat_type="+mat_type+"&model_code="+model_code;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('catm_div').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
			}							}				

			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
	
	
	
	function getMaterial(plant_code,mat_type,model_code,stamp_ind) {		
	
		var strURL="findMaterial-TP.php?plant_code="+plant_code+"&mat_type="+mat_type+"&model_code="+model_code+"&stamp_ind="+stamp_ind;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('mat_div').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}*/
	
</script>  <!-- Page specific javascripts-->
  
  </body>
</html>