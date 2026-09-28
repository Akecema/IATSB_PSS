<?php
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

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
$url = "con_detail_table.php"; 
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
          <p>Add Consumable Details</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Table Maintenance</li>
          <li class="breadcrumb-item"><a href="add_tbl_con_detail.php">Add Consumable</a></li>
        </ul>
      </div>  
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" href="add_tbl_con_detail.php" data-toggle="tab">Add Consumable</a></li>
                <li class="nav-item"><a class="nav-link"  href="con_detail_table.php">Display Consumable Details</a></li>
            </ul>
            
      <?php
	  
	  $message_mat = "";
	  $message_matdesc = "";
	  $message_p_code = "";
	  $message_cc = "";
	  $message_bun = "";
	  $message_sta = "";
	  
	  
if (isset($_POST['Submit7'])) 
{ // handle the form.


$message = NULL; // create an empty new variable.
   
$material_no = $_POST['material_no'];
$mat_desc = $_POST['mat_desc'];
$cost_center = $_POST['cost_center'];
$plant = $_POST['plant'];
$BUn = $_POST['BUn'];
$con_status = $_POST['con_status'];
  
// check for a material No.
if (empty($_POST['material_no']))
{ $material_no = FALSE;
  $message_mat = '<span class="badge badge-pill badge-danger">Please enter Material No.!</span>';
  }else
  { $material_no = addslashes($_POST['material_no']);
  }
  
// check for a material Desc
if (empty($_POST['mat_desc']))
{ $mat_desc = FALSE;
  $message_matdesc = '<span class="badge badge-pill badge-danger">Please enter Material Description!</span>';
  }
    else
  { $mat_desc = addslashes($_POST['mat_desc']);
  }
  
// check for a plant code
if (empty($_POST['plant']))
{ $plant = FALSE;
  $message_p_code = '<span class="badge badge-pill badge-danger">Please enter Plant!</span>';
  }
    else
  { $plant = addslashes($_POST['plant']);
  }

// check for a cost center
if (empty($_POST['cost_center']))
{ $cost_center = FALSE;
  $message_cc = '<span class="badge badge-pill badge-danger">Please enter Cost Center!</span>';
  }
  else
  { $cost_center = addslashes($_POST['cost_center']);
  }

// check for BUn
if (empty($_POST['BUn']) || ($_POST['BUn'] == "NULL"))
{ $BUn = FALSE;
  $message_bun = '<span class="badge badge-pill badge-danger">Please select BUn!</span>';
  }
  else
  { $BUn = addslashes($_POST['BUn']);
  }

// check for con sstatus
if (empty($_POST['con_status']) || ($_POST['con_status'] == "NULL"))
{ $con_status = FALSE;
  $message_sta = '<span class="badge badge-pill badge-danger">Please select Status!</span>';
  }
  else
  { $con_status = addslashes($_POST['con_status']);
  }

  
  //---------------------------------------------------------------------------------------
  // material component 
  //----------------------------------------------------------------------------------------

   
 if($material_no && $mat_desc && $plant && $cost_center && $BUn && $con_status) //everything ok
 {  

//register the user in the db.
$query_db = "INSERT INTO consumable_detail(id_con,material_no, mat_desc, BUn, cost_center,plant,con_status) VALUES
                                ('','".sql_esc($material_no)."','".strtoupper($mat_desc)."','".sql_esc($BUn)."','".sql_esc($cost_center)."','".sql_esc($plant)."','".sql_esc($con_status)."')";
$result = mysqli_query($dbc,$query_db) or die (mysqli_error($dbc));


             if($result)
             {
echo "<script>";
echo "alert('Consumable is successfully created');";
echo "window.location='con_detail_table.php'";
echo "</script>";
			  exit(); //quit the script
             }
             else 
			 {
             $message = '<p> Cannot create consumable. </p>';
              mysqli_close($dbc); //close db
             }  
}
//print the message if there is one.
	  
	  
if (isset($message))
{ echo '<div class="msg msg-error"><font color="red" class ="error_entry">', $message, '</font></div>';
}
}
?>    
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Add Consumable</h3>
            <div class="tile-body">
              <form name="form1" method="post" action="" class="form-horizontal">
                <div class="form-group row">
                  <label class="control-label col-md-3">Material No. :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                 <input name="material_no" type="text" id="material_no" size="20" maxlength="8" value="<?php if(isset($_POST['material_no'])) echo html_esc($_POST['material_no']); ?>" class="form-control" placeholder="Enter Material No."/>    
                    <div class="form-control-feedback" ><?php echo $message_mat; ?></div>
                    </div>
                   
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Material Description : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                  <input name="mat_desc" type="text" class="form-control" id="mat_desc" size="55" maxlength="100" value="<?php if(isset($_POST['mat_desc'])) echo html_esc($_POST['mat_desc']); ?>"  placeholder="Enter Material Description"/>
                   <div class="form-control-feedback" ><?php echo $message_matdesc; ?></div>
                    </div>
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Plant Code : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                     <input name="plant" type="text"  class="form-control"  id="plant" size="20" maxlength="20" value="<?php if(isset($_POST['plant'])) echo html_esc($_POST['plant']); ?>" placeholder="Enter Plant Code" />
                    <div class="form-control-feedback" ><?php echo $message_p_code; ?></div>
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
                  <label class="control-label col-md-3">BUn : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                <?php		
 	          echo ' <select name="BUn" class="form-control" id="BUn">
                 <option value="NULL"> --Select-- </option>';
  
                   $query7 = "SELECT * FROM uom_con ORDER BY UOM ASC";
                   $result7 = mysqli_query($dbc,$query7);
  
                   while($row7 = mysqli_fetch_array($result7)) 
			      {
	
	           if($_POST['Submit7'] == true){ ?>
               <!--RETAIN VALUE-->
            <option value="<?php echo html_esc($row7["UOM"]); ?>" <?php if($row7["UOM"] == $_POST["BUn"]) { echo "selected"; } ?>> <?php echo html_esc($row7["UOM"]); ?></option> 
               <?php }else{ ?>
               <option value="<?php echo html_esc($row7["UOM"]); ?>"> <?php echo html_esc($row7["UOM"]); ?></option>    
               <?php } 
							}
	 
	          echo '</select>';

	          ?>
                  <div class="form-control-feedback" ><?php echo $message_bun; ?></div>
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Status : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                   <select name="con_status"  class="form-control">
                   <option value="NULL" placeholder="Select Status"> -- Select Status --</option>
                            <?php if($_POST['Submit7'] == true)
						{ ?>
                            <option value="Y" <?php if($_POST["con_status"] == 'Y') { ?> selected="selected"<?php } ?>>Y - Active</option>
                            <option value="N" <?php if($_POST["con_status"] == 'N') { ?> selected="selected"<?php } ?>>N - Inactive</option>
                            <?php 
						}
						else
						{ ?>
                            <option value="Y">Y - Active</option>
                            <option value="N">N - Inactive</option>
                            <?php } ?> 
                   
                    </select>
           <div class="form-control-feedback" ><?php echo $message_sta; ?></div>
              <div class="form-group row">
                  <label class="control-label col-md-3"><font color="#FF0000"><b>* Compulsory field</b></font></label>
                    <div class="col-md-8">
                  &nbsp;
                </div>
              </div>
              
                <div class="form-group col-md-8 align-self-end">
               <input name="Submit7" type="submit" id="submit" value="CREATE" class="btn btn-primary">
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