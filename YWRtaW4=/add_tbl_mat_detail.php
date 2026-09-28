<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

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
	
$url = "mat_detail_table.php"; 
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
          <h1><i class="fa fa-edit"></i> Table Maintenance</h1>
          <p>Add Material</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Table Maintenance</li>
          <li class="breadcrumb-item"><a href="add_tbl_mat_detail.php">Add Material</a></li>
        </ul>
      </div>  
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" href="add_tbl_mat_detail.php" >Add Material</a></li>
                <li class="nav-item"><a class="nav-link" href="mat_detail_table.php">Display Material Details</a></li>
                <li class="nav-item"><a class="nav-link" href="upl_mat_detail_table.php">List Material Upload</a></li>
            </ul>
            
      <?php
	  
	  $message_matno = "";
	  $message_matdesc = "";
	  $message_pcode = "";
	  $message_cc = "";
	  $message_ccd = "";
	  $message_vclass = "";
	  $message_catmat = "";
	  $message_mtype = "";
	  $message_model = "";
	  $message_sta = "";
	  $message_sloc = "";
	  
	  
if (isset($_POST['submit'])) 
{ // handle the form.


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
{ 
   $material_no = FALSE;
   $message_matno = '<span class="badge badge-pill badge-danger">Please enter Material No.!</span>';
 
  }else
  { $material_no = addslashes($_POST['material_no']);
  }
  
// check for a material Desc
if (empty($_POST['material_desc']))
{ 
   $material_desc = FALSE;
   $message_matdesc = '<span class="badge badge-pill badge-danger">Please enter Material Description!</span>';
  }
    else
  { $material_desc = addslashes($_POST['material_desc']);
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
  
  // check for a prod line
if ((empty($_POST['prod_line'])) || ($_POST['prod_line']) == "NULL")
{ 
   $prod_line = FALSE;
   $message_ccd = '<span class="badge badge-pill badge-danger">Please select Section/Line!</span>';
 
  }
    else
  { $prod_line = addslashes($_POST['prod_line']);
  }
  
  // check for a Vclass
if (empty($_POST['Vclass']))
{ 
   $Vclass = FALSE;
   $message_vclass = '<span class="badge badge-pill badge-danger">Please enter Vclass!</span>';
  }
    else
  { 
  $Vclass = addslashes($_POST['Vclass']);
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
  
  
  
 //check model code
 
if ((empty($_POST['model_code']) || ($_POST['model_code'] == "NULL")))
{ 
 $model_code = FALSE;
 $message_model = '<span class="badge badge-pill badge-danger">Please select Model!</span>';

  }
  else
  { $model_code = addslashes($_POST['model_code']);
  }
  
  
  //check model code
 
if ((empty($_POST['category_mat']) || ($_POST['category_mat'] == "NULL")))
{ 
 $category_mat = FALSE;
 $message_catmat = '<span class="badge badge-pill badge-danger">Please select Category!</span>';

  }
  else
  { $category_mat = addslashes($_POST['category_mat']);
  }  
  
  //check sloc
 
if ((empty($_POST['sloc']) || ($_POST['sloc'] == "NULL")))
{ 
 $sloc = FALSE;
 $message_sloc = '<span class="badge badge-pill badge-danger">Please select Storage Location!</span>';

  }
  else
  { $sloc = addslashes($_POST['sloc']);
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

   
 if($material_no && $material_desc && $plant_code && $mat_type && $prod_line && $Vclass && $sloc && $BUn && $category_mat && $model_code && $status_BOM) //everything ok
{ 


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

//----vendor detail ----

$query_ven_dtl = new PreparedSql("SELECT * FROM vendor_detail WHERE vendor_code = ? AND status_acc = 'Y'", [$vendor_id]);
$result_ven_dtl = db_query($dbc, $query_ven_dtl);
$row_ven_dtl = mysqli_fetch_array($result_ven_dtl);

//--- model detail ---
$query_mod_dtl = "SELECT * FROM model_detail_tbl WHERE id_model = '".sql_esc($model_code)."' AND status_model = 'Y'";
$result_mod_dtl = mysqli_query($dbc,$query_mod_dtl);
$row_mod_dtl = mysqli_fetch_array($result_mod_dtl);




		//----------------insert table_material_itsb-------------------------------	
		
        $query_tmbh_data = "INSERT INTO table_material_itsb(id_mat,material_no,material_desc,mat_type,plant_code,material_group,BUn,Vclass,model_code,model_desc,category_mat,std_packaging,type_package,part_side,back_no,mat_group,acc_group,prod_line,sloc,cust_part_no,prod_part_no,size_dim,pp_log_no,pp_log_desc,date_create,user_create,status_BOM,date_upload,user_upload,date_update,user_update,vendor_id,vendor_desc,material_cust_no,material_desc_cust,cust_code,cust_name,status_foc,status_sp) VALUES ('','".sql_esc($material_no)."','".sql_esc($material_desc)."','".sql_esc($mat_type)."','".sql_esc($plant_code)."','".sql_esc($material_group)."','".sql_esc($BUn)."','".sql_esc($Vclass)."','".sql_esc($model_code)."','".sql_esc($row_mod_dtl["model_desc"])."','".sql_esc($category_mat)."','".sql_esc($std_packaging)."','".sql_esc($type_package)."','".sql_esc($part_side)."','".sql_esc($back_no)."','".sql_esc($mat_group)."','".sql_esc($acc_group)."','".sql_esc($prod_line)."','".sql_esc($sloc)."','".sql_esc($cust_part_no)."','".sql_esc($prod_part_no)."','".sql_esc($size_dim)."','".sql_esc($pp_log_no)."','".sql_esc($pp_log_desc)."',NOW(),'".sql_esc($username)."','".sql_esc($status_BOM)."','0000-00-00','','0000-00-00','','".sql_esc($vendor_id)."','".sql_esc($row_ven_dtl["vendor_name"])."','".sql_esc($cust_part_no)."','".sql_esc($material_desc_cust)."','".sql_esc($cust_code)."','".sql_esc($cust_name)."','".sql_esc($status_foc)."','".sql_esc($status_sp)."')";
		$result_tmbh_data = mysqli_query($dbc,$query_tmbh_data); 	
		
								
			if($result_tmbh_data)
			{
				
			 echo "<script>";
		     echo "alert('Material is successfully created.');";
		     echo "window.location='mat_detail_table.php'";
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
            <h3 class="tile-title">Add Material</h3>
            <div class="tile-body">
              <form name="form1" method="post" action="" class="form-horizontal">
                <div class="form-group row">
                  <label class="control-label col-md-3">Material No. :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                  <input type="text" id="material_no" name="material_no" value="<?php if(isset($_POST['material_no'])) echo html_esc($_POST['material_no']); ?>" class="form-control" placeholder="Enter Material No." />
                    <div class="form-control-feedback" ><?php echo $message_matno; ?></div>
                    </div>
                   
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Material Description : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
           <input type="text" id="material_desc" name="material_desc" value="<?php if(isset($_POST['material_desc'])) echo html_esc($_POST['material_desc']); ?>" class="form-control" placeholder="Enter Material Description" />
                   <div class="form-control-feedback" ><?php echo $message_matdesc; ?></div>
                    </div>
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Plant Code : <font color="#FF0000"><b> *</b></font></label>
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
                  <label class="control-label col-md-3">Line : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                    
                     <select name="prod_line" class="form-control">
            <option value="NULL" placeholder="Select Line"> -- Select Line -- </option>
          <?php
          //Retrieve and display the available types
          $query_line = "SELECT * FROM work_center_detail WHERE status_wc = 'Y'";
          $result_line = mysqli_query($dbc,$query_line);
          
              while($row_line = mysqli_fetch_array($result_line)) {
        
              ?>
         <option value="<?php echo html_esc($row_line["id_work"]); ?>" <?php if($row_line["id_work"] == $_POST["prod_line"]) echo "selected"; ?>> <?php echo stripslashes($row_line["id_work"]); ?> - <?php echo html_esc($row_line["wc_desc"]); ?></option>
          <?php
           }  ?>
                            
        </select>         
                  <div class="form-control-feedback" ><?php echo $message_ccd; ?></div>
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Material of Group : </label>
                    <div class="col-md-8">
   <input type="text" id="material_group" name="material_group" value="<?php if(isset($_POST['material_group'])) echo html_esc($_POST['material_group']);  ?> " class="form-control"/>
         </div>  
         </div>
             <div class="form-group row">
                  <label class="control-label col-md-3">BUn : <font color="#FF0000"><b> *</b></font></label>
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
                  <label class="control-label col-md-3">VClass: <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
             <input type="text" id="Vclass" name="Vclass" value="<?php if(isset($_POST['Vclass'])) echo html_esc($_POST['Vclass']); ?>" class="form-control"/>
                  <div class="form-control-feedback" ><?php echo $message_vclass; ?></div>
                </div>
              </div>
              
                    <div class="form-group row">
                  <label class="control-label col-md-3">Model Code: <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                    
          <div id="model_div">
                <select name="model_code" id="model_code" class="form-control">
                <option value="NULL" placeholder="Select Model"> -- Select Model -- </option>
                   <?php
	
	$query88 = "SELECT * FROM model_detail_tbl WHERE status_model = 'Y' ORDER BY id_model ASC";
    $result88 =mysqli_query($dbc,$query88);
	
	 while($row88 = mysqli_fetch_array($result88)) 
	  { 
	?>  
          <option value="<?php echo html_esc($row88["id_model"]); ?>" <?php if($row88["id_model"] == ($_POST["model_code"])) echo "selected"; ?>> <?php echo stripslashes($row88["model_code"]); ?> - <?php echo stripslashes($row88["model_desc"]); ?></option>
  <?php   }  ?>
  
          </select>  <div class="form-control-feedback" ><?php echo $message_model; ?></div></div>          
                    
                    

                </div>
              </div>
            
            
            
                    <div class="form-group row">
                  <label class="control-label col-md-3">Category Material: <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                    
        <select name="category_mat" class="form-control">
            <option value="NULL" placeholder="Select Category Material"> -- Select Category Material -- </option>
          <?php
          //Retrieve and display the available types
          $query_cat = "SELECT * FROM category_detail WHERE status_stamp = 'Y'";
          $result_cat = mysqli_query($dbc,$query_cat);
          
              while($row_cat = mysqli_fetch_array($result_cat)) {
        
              ?>
         <option value="<?php echo html_esc($row_cat["stamp_ind"]); ?>" <?php if($row_cat["stamp_ind"] == $_POST["category_mat"]) echo "selected"; ?>> <?php echo stripslashes($row_cat["stamp_ind"]); ?> - <?php echo html_esc($row_cat["stamp_desc"]); ?></option>
          <?php
           }  ?>
                            
        </select>  <div class="form-control-feedback" ><?php echo $message_catmat; ?></div>

                </div>
              </div>
               
             <div class="form-group row">
                  <label class="control-label col-md-3">Standard Package : </label>
                    <div class="col-md-8">     
               <input type="text" id="std_packaging" name="std_packaging"  value="<?php if(isset($_POST['std_packaging'])) echo html_esc($_POST['std_packaging']);  ?> " class="form-control"/>
               </div></div>
               
             <div class="form-group row">
                  <label class="control-label col-md-3">Type Package : </label>
                    <div class="col-md-8">     
               <input type="text" id="type_package" name="type_package" value="<?php if(isset($_POST['type_package'])) echo html_esc($_POST['type_package']);  ?>" class="form-control"/>
               </div></div>  
                <div class="form-group row">
                  <label class="control-label col-md-3">Part Side : </label>
                    <div class="col-md-8">     
              <input type="text" id="part_side" name="part_side" value="<?php if(isset($_POST['material_group'])) echo html_esc($_POST['material_group']);  ?><?php echo html_esc($row_con["part_side"]);  ?>" class="form-control"/>
               </div></div>    
               
               
                 <div class="form-group row">
                  <label class="control-label col-md-3">Back No. : </label>
                    <div class="col-md-8">     
            <input type="text" id="back_no" name="back_no" value="<?php if(isset($_POST['material_group'])) echo html_esc($_POST['material_group']);  ?><?php echo html_esc($row_con["back_no"]);  ?>" class="form-control"/>
               </div></div>    
               
                 <div class="form-group row">
                  <label class="control-label col-md-3">Storage Location : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">     
               <select name="sloc" class="form-control">
            <option value="NULL" placeholder="Select Sloc"> -- Select Sloc -- </option>
          <?php
          //Retrieve and display the available types
          $query57 = 'SELECT * FROM sloc_tbl WHERE status_sloc = "Y"';
          $result57 = mysqli_query($dbc,$query57);
          
              while($row57 = mysqli_fetch_array($result57)) {
        
              ?>
         <option value="<?php echo html_esc($row57["sloc_code"]); ?>" <?php if($row57["sloc_code"] == $_POST["sloc"]) echo "selected"; ?>> <?php echo stripslashes($row57["sloc_code"]); ?> - <?php echo html_esc($row57["sloc_desc"]); ?></option>
          <?php
           }  ?>
                            
        </select>  <div class="form-control-feedback" ><?php echo $message_sloc; ?></div>
               </div></div>    
               
               
                 <div class="form-group row">
                  <label class="control-label col-md-3">Size Dim : </label>
                    <div class="col-md-8">     
              <input type="text" id="size_dim" name="size_dim" value="<?php if(isset($_POST['size_dim'])) echo html_esc($_POST['size_dim']);  ?>" class="form-control"/>
               </div></div> 
               
               <div class="form-group row">
                  <label class="control-label col-md-3">Customer Part No. : </label>
                    <div class="col-md-8">     
              <input type="text" id="cust_part_no" name="cust_part_no" value="<?php if(isset($_POST['cust_part_no'])) echo html_esc($_POST['cust_part_no']);  ?>" class="form-control"/>
               </div></div>
                <div class="form-group row">
                  <label class="control-label col-md-3">Customer Part Name : </label>
                    <div class="col-md-8">     
              <input type="text" id="material_desc_cust" name="material_desc_cust" value="<?php if(isset($_POST['material_desc_cust'])) echo html_esc($_POST['material_desc_cust']);  ?>" class="form-control"/>
               </div></div>    
               <div class="form-group row">
                  <label class="control-label col-md-3">Production Part No. : </label>
                    <div class="col-md-8">     
              <input type="text" id="prod_part_no" name="prod_part_no" value="<?php if(isset($_POST['prod_part_no'])) echo html_esc($_POST['prod_part_no']);  ?>" class="form-control"/>
               </div></div>    
               
               <div class="form-group row">
                  <label class="control-label col-md-3">Vendor Code : </label>
                    <div class="col-md-8">
  <select name="vendor_id" class="form-control">
            <option value="NULL" placeholder="Select Vendor"> -- Select Vendor -- </option>
          <?php
          //Retrieve and display the available types
          $query_ven = 'SELECT * FROM vendor_detail WHERE status_acc = "Y"';
          $result_ven = mysqli_query($dbc,$query_ven);
          
              while($row_ven = mysqli_fetch_array($result_ven)) {
        
              ?>
         <option value="<?php echo html_esc($row_ven["vendor_code"]); ?>" <?php if($row_ven["vendor_code"] == $_POST["vendor_id"]) echo "selected"; ?>> <?php echo stripslashes($row_ven["vendor_code"]); ?> - <?php echo html_esc($row_ven["vendor_name"]); ?></option>
          <?php
           }  ?>
                            
        </select>                  
                    
                    
         
               </div></div>       
              
               <div class="form-group row">
                  <label class="control-label col-md-3">Material Group : </label>
                    <div class="col-md-8">     
              <input type="text" id="mat_group" name="mat_group" value="<?php if(isset($_POST['mat_group'])) echo html_esc($_POST['mat_group']);  ?>" class="form-control"/>
               </div></div>    
               
                
                <div class="form-group row">
                  <label class="control-label col-md-3">Account Group : </label>
                    <div class="col-md-8">     
              <input type="text" id="acc_group" name="acc_group" value="<?php if(isset($_POST['acc_group'])) echo html_esc($_POST['acc_group']);  ?>" class="form-control"/>
               </div></div>    
               
               <div class="form-group row">
                  <label class="control-label col-md-3">PP Log No. : </label>
                    <div class="col-md-8">     
              <input type="text" id="pp_log_no" name="pp_log_no" value="<?php if(isset($_POST['pp_log_no'])) echo html_esc($_POST['pp_log_no']);  ?>" class="form-control"/>
               </div></div>    
               
               
               <div class="form-group row">
                  <label class="control-label col-md-3">PP Log Description : </label>
                    <div class="col-md-8">     
              <input type="text" id="pp_log_desc" name="pp_log_desc" value="<?php if(isset($_POST['pp_log_desc'])) echo html_esc($_POST['pp_log_desc']);  ?>" class="form-control"/>
               </div></div>  
                 <div class="form-group row">
                  <label class="control-label col-md-3">Customer Code : </label>
                    <div class="col-md-8">     
              <input type="text" id="cust_code" name="cust_code" value="<?php if(isset($_POST['cust_code'])) echo html_esc($_POST['cust_code']);  ?>" class="form-control"/>
               </div></div>    
                 <div class="form-group row">
                  <label class="control-label col-md-3">Customer Name : </label>
                    <div class="col-md-8">     
              <input type="text" id="cust_name" name="cust_name" value="<?php if(isset($_POST['cust_name'])) echo html_esc($_POST['cust_name']);  ?>" class="form-control"/>
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
                  <label class="control-label col-md-3">Status FOC : </label>
                    <div class="col-md-8">
                     <select name="status_foc" id="status_foc" class="form-control">
                       <option value="NULL" placeholder="Select Status"> -- Select Status -- </option>
                   <?php if($_POST['submit'] == true)
						{ ?>
               <option value="Y" <?php if($_POST["status_foc"] == 'Y') { ?> selected="selected"<?php } ?>>YES</option>
               <option value="N" <?php if($_POST["status_foc"] == 'N') { ?> selected="selected"<?php } ?>>NO</option>
               <?php 
						}
						else
						{ ?>
               <option value="Y">YES</option>
               <option value="N">NO</option>
               <?php } ?>
                 </select>
                  
                </div>
              </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Status Spare Part : </label>
                    <div class="col-md-8">
                     <select name="status_sp" id="status_sp" class="form-control">
                       <option value="NULL" placeholder="Select Status"> -- Select Status -- </option>
                   <?php if($_POST['submit'] == true)
						{ ?>
               <option value="Y" <?php if($_POST["status_sp"] == 'Y') { ?> selected="selected"<?php } ?>>YES</option>
               <option value="N" <?php if($_POST["status_sp"] == 'N') { ?> selected="selected"<?php } ?>>NO</option>
               <?php 
						}
						else
						{ ?>
               <option value="Y">YES</option>
               <option value="N">NO</option>
               <?php } ?>
                 </select>
                  
                </div>
              </div>
              
              <div class="form-group row">
                  <label class="control-label col-md-3"><font color="#FF0000"><b>* Compulsory field</b></font></label>
                    <div class="col-md-8">
                  &nbsp;
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