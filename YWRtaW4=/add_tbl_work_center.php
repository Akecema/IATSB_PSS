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
	
$url = "work_center_table.php"; 
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
          <p>Add Work Center</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Table Maintenance</li>
          <li class="breadcrumb-item"><a href="add_tbl_work_center.php">Add Work Center</a></li>
        </ul>
      </div>  
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" href="add_tbl_work_center.php" data-toggle="tab">Add Work Center</a></li>
                <li class="nav-item"><a class="nav-link"  href="work_center_table.php">Display Work Center</a></li>
            </ul>
            
      <?php
	  
	  $message_idwork = "";
	  $message_wcd = "";
	  $message_pcode = "";
	  $message_cc = "";
	  $message_ccd = "";
	  $message_factory = "";
	  $message_dept = "";
	  $message_sta = "";
	  $message_wcdesc2 = "";
	  $message_pcat = "";
	  
	  
if (isset($_POST['submit'])) 
{ // handle the form.

   $message = NULL; // create an empty new variable.
   
   $id_work = $_POST['id_work'];
   $wc_desc = $_POST['wc_desc'];
   $cost_center = $_POST['cost_center'];
   $cc_desc = $_POST['cc_desc'];
   $plant_code = $_POST['plant_code'];
   $id_factory = $_POST['id_factory'];
   $dept_acc = $_POST['dept_acc'];
   $status_wc = $_POST['status_wc'];
   $wc_desc2 = $_POST['wc_desc2'];
   $prod_cat = $_POST['prod_cat'];
  
// check for a id_work
if (empty($_POST['id_work']))
{ $id_work = FALSE;
  $message_idwork = '<span class="badge badge-pill badge-danger">Please enter Work Center !</span>';
  }

// check for a wc_desc.
if (empty($_POST['wc_desc']))
{ $wc_desc = FALSE;
  $message_wcd = '<span class="badge badge-pill badge-danger">Please enter Work Center Description!</span>';
  }else
  { $wc_desc =  addslashes($_POST['wc_desc']);
  }
  
// check for a plant code
if (empty($_POST['plant_code']) || ($_POST['plant_code'] == "NULL"))
{ $plant_code = FALSE;
 	 $message_pcode = '<span class="badge badge-pill badge-danger">Please select Plant!</span>';
  }
    else
  { $plant_code =  addslashes($_POST['plant_code']);
  }

// check for a cost center
if (empty($_POST['cost_center']))
{ $cost_center = FALSE;
  $message_cc = '<span class="badge badge-pill badge-danger">Please enter Cost Center!</span>';
  }
  else
  { $cost_center =  addslashes($_POST['cost_center']);
  }

// check for a cost center Desc
if (empty($_POST['cc_desc']))
{ $cc_desc = FALSE;
  $message_ccd = '<span class="badge badge-pill badge-danger">Please enter Cost Center Description!</span>';
  }
    else
  { $cc_desc =  addslashes($_POST['cc_desc']);
  }

// check for factory
if (empty($_POST['id_factory']) || ($_POST['id_factory'] == "NULL"))
{ $id_factory = FALSE;
  $message_factory = '<span class="badge badge-pill badge-danger">Please select Factory!</span>';
  }
  else
  { $id_factory =  addslashes($_POST['id_factory']);
  }
  
  // check for dept acc
if (empty($_POST['dept_acc']) || ($_POST['dept_acc'] == "NULL"))
{ 
  $dept_acc = FALSE;
  $message_dept = '<span class="badge badge-pill badge-danger">Please select Department Account!</span>';
  }
  else
  { $dept_acc =  addslashes($_POST['dept_acc']);
  }
  
   // check for status
if (empty($_POST['status_wc']) || ($_POST['status_wc'] == "NULL"))
{ 
  $status_wc = FALSE;
  $message_sta = '<span class="badge badge-pill badge-danger">Please select Status Account!</span>';
  }
  else
  { $status_wc =  addslashes($_POST['status_wc']);
  }
 
 
 // check for a Model Desc
if (empty($_POST['wc_desc2']))
{ $wc_desc2 = FALSE;
  $message_wcdesc2 = '<span class="badge badge-pill badge-danger">Please enter Model Description!</span>';
  }
    else
  { $wc_desc2 =  addslashes($_POST['wc_desc2']);
  }
 
 
  
 if($id_work && $wc_desc && $plant_code && $cost_center && $cc_desc && $id_factory && $dept_acc && $status_wc && $wc_desc2) //everything ok
 { 
 
   $id_work = $_POST['id_work'];
   $wc_desc = $_POST['wc_desc'];
   $cost_center = $_POST['cost_center'];
   $cc_desc = $_POST['cc_desc'];
   $plant_code = $_POST['plant_code'];
   $id_factory = $_POST['id_factory'];
   $dept_acc = $_POST['dept_acc']; 
   $status_wc = $_POST['status_wc'];
   $wc_desc2 = $_POST['wc_desc2'];
   $prod_cat = $_POST['prod_cat'];

//register the user in the db.
$query_db = "INSERT INTO work_center_detail(id_work,plant_code,wc_desc,cost_center,cc_desc,id_factory,dept_acc,status_wc,wc_desc2,prod_cat) VALUES('".sql_esc($id_work)."','".sql_esc($plant_code)."','".sql_esc($wc_desc)."','".sql_esc($cost_center)."','".sql_esc($cc_desc)."','".sql_esc($id_factory)."','".sql_esc($dept_acc)."','".sql_esc($status_wc)."','".sql_esc($wc_desc2)."','".sql_esc($prod_cat)."')";
$result = mysqli_query($dbc,$query_db);


             if($result)
             {
echo "<script>";
echo "alert('Work Center is successfully created');";
echo "window.location='work_center_table.php'";
echo "</script>";
			  exit(); //quit the script
             }
             else 
			 {
             $message = '<p><strong>Error!</strong> Work Center is fail to update. </p>';
              mysqli_close($dbc); //close db
             }  
}
//print the message if there is one.
	  
	  
if (isset($message))
{ 
echo '<div class="alert alert-error">', $message, '</div>';
}
}
?>    
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Add Work Center</h3>
            <div class="tile-body">
              <form name="form1" method="post" action="" class="form-horizontal">
                <div class="form-group row">
                  <label class="control-label col-md-3">Work Center :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                 <input name="id_work" type="text" id="id_work" size="20" maxlength="20" value="<?php if(isset($_POST['id_work'])) echo html_esc($_POST['id_work']); ?>" class="form-control" placeholder="Enter Work Center" />      
                    <div class="form-control-feedback" ><?php echo $message_idwork; ?></div>
                    </div>
                   
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Work Center Description : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                  <input name="wc_desc" type="text" class="form-control" id="wc_desc" size="20" maxlength="100" value="<?php if(isset($_POST['wc_desc'])) echo html_esc($_POST['wc_desc']); ?>"  placeholder="Enter Work Center Description" />
                   <div class="form-control-feedback" ><?php echo $message_wcd; ?></div>
                    </div>
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Plant Code : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                      		
           <select name="plant_code" class="form-control">
            <option value="NULL" placeholder="Select Plant"> -- Select Plant -- </option>
          <?php
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM plant_detail WHERE status_plant = "Y"';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
              ?>
         <option value="<?php echo html_esc($row27["plant_code"]); ?>" > <?php echo stripslashes($row27["plant_code"]); ?> - <?php echo html_esc($row27["plant_desc"]); ?></option>
          <?php
           }  ?>
                            
        </select>
                    
                   <div class="form-control-feedback" ><?php echo $message_pcode; ?></div>
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Cost Center :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                     <input name="cost_center" type="text" class="form-control" placeholder="Enter Cost Center"id="cost_center" size="20" maxlength="20" value="<?php if(isset($_POST['cost_center'])) echo html_esc($_POST['cost_center']); ?>" />
                     <div class="form-control-feedback" ><?php echo $message_cc; ?></div>
                </div>
              </div>
               <div class="form-group row">
                  <label class="control-label col-md-3">Cost Center Description : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                <input name="cc_desc" type="text" class="form-control" id="cc_desc" size="55" maxlength="100" value="<?php if(isset($_POST['cc_desc'])) echo html_esc($_POST['cc_desc']); ?>" placeholder="Enter Cost Center Description"/>
                  <div class="form-control-feedback" ><?php echo $message_ccd; ?></div>
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Factory : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
    <?php		
 	      echo ' <select name="id_factory" class="form-control" id="id_factory">
                 <option value="NULL"> --Select-- </option>';
  
                   $query3 = "SELECT * FROM factory_detail_itsb WHERE factory_id = '1' ORDER BY factory_id ASC";
                   $result3 = mysqli_query($dbc,$query3);
  
                   while($row3 = mysqli_fetch_array($result3)) 
			      {
	
	          if($_POST['submit'] == true){ ?>
               <!--RETAIN VALUE-->
               <option value="<?php echo html_esc($row3["factory_id"]); ?>" <?php if($row3["factory_id"]==$_POST["id_factory"]) echo "selected"; ?>> <?php echo html_esc($row3["factory_desc"]); ?></option>
               <?php }else{ ?>
               <option value="<?php echo html_esc($row3["factory_id"]); ?>" > <?php echo stripslashes($row3["factory_desc"]); ?></option>
               <?php } ?>
               <?php
							}
	 
	  	//complete the form
	
	echo '</select>';

	?>
           <div class="form-control-feedback" ><?php echo $message_factory; ?></div>
         </div>  
         </div>
             <div class="form-group row">
                  <label class="control-label col-md-3">Department Account : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
    <?php		
 	      echo ' <select name="dept_acc" class="form-control" id="dept_acc">
                 <option value="NULL"> --Select-- </option>';
  
                   $query4 = "SELECT * FROM level_dept WHERE status_level = 'Y' ORDER BY id_levelD ASC";
                   $result4 = mysqli_query($dbc,$query4);
  
                   while($row4 = mysqli_fetch_array($result4)) 
			      {
	
	          if($_POST['submit'] == true){ ?>
               <!--RETAIN VALUE-->
               <option value="<?php echo html_esc($row4["desc_level"]); ?>" <?php if($row4["id_level"]==$_POST["dept_acc"]) echo "selected"; ?>> <?php echo html_esc($row4["desc_level"]); ?></option>
               <?php }else{ ?>
               <option value="<?php echo html_esc($row4["desc_level"]); ?>" > <?php echo stripslashes($row4["desc_level"]); ?></option>
               <?php } ?>
               <?php
							}
	 
	  	//complete the form
	
	echo '</select>';

	?>
           <div class="form-control-feedback" ><?php echo $message_dept; ?></div>
           </div></div>
           
            <div class="form-group row">
                  <label class="control-label col-md-3">Status Account : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                     <select name="status_wc" id="status_wc" class="form-control">
                   <?php if($_POST['submit'] == true)
						{ ?>
               <option value="Y" <?php if($_POST["status_wc"] == 'Y') { ?> selected="selected"<?php } ?>>ACTIVE</option>
               <option value="N" <?php if($_POST["status_wc"] == 'N') { ?> selected="selected"<?php } ?>>INACTIVE</option>
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
                  <label class="control-label col-md-3">Model Description : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                <input name="wc_desc2" type="text" class="form-control" id="wc_desc2" size="55" maxlength="100" value="<?php if(isset($_POST['wc_desc2'])) echo html_esc($_POST['wc_desc2']); ?>" placeholder="Enter Model Description"/>
                  <div class="form-control-feedback" ><?php echo $message_wcdesc2; ?></div>
                </div>
              </div>
              
                <div class="form-group row">
                  <label class="control-label col-md-3">Category Material : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                     <select name="prod_cat" id="prod_cat" class="form-control">
                   <?php if($_POST['submit'] == true)
						{ ?>
               <option value="A" <?php if($_POST["prod_cat"] == 'A') { ?> selected="selected"<?php } ?>>ASSEMBLY</option>
               <option value="S" <?php if($_POST["prod_cat"] == 'S') { ?> selected="selected"<?php } ?>>STAMPING</option>
               <?php 
						}
						else
						{ ?>
               <option value="A">ASSEMBLY</option>
               <option value="S">STAMPING</option>
               <?php } ?>
                 </select>
                    <div class="form-control-feedback" ><?php echo $message_pcat; ?></div>
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
    <!-- Page specific javascripts-->
  
  </body>
</html>