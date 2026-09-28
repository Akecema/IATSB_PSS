<?php
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

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	
	
$url = "cat_mat_table.php"; 
	?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo $data_setup["tajuk_sys"]; ?>">
    <title><?php echo $data_setup["title_desc"]; ?></title>
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
          <p>Category</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Table Maintenance</li>
          <li class="breadcrumb-item"><a href="add_cat_mat_table.php">Category</a></li>
        </ul>
      </div>  
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" href="add_cat_mat_table.php" data-toggle="tab">Add Category</a></li>
                <li class="nav-item"><a class="nav-link"  href="cat_mat_table.php">Display Category</a></li>
            </ul>
            
      <?php
	  
	  $message_cat = "";
	  $message_catdesc = "";
	  $message_pcode = "";
	  $message_sta = "";
	  
	  
if (isset($_POST['Submit7'])) 
{ // handle the form.


$message = NULL; // create an empty new variable.
   
$stamp_ind = $_POST['stamp_ind'];
$stamp_desc = $_POST['stamp_desc'];
$plant_code = $_POST['plant_code'];
$status_stamp = $_POST['status_stamp'];
  

// check for a cat_code
if((empty($_POST['stamp_ind'])) || (($_POST['stamp_ind']) == "NULL"))
{ 
	$stamp_ind = FALSE;
	$message_cat = '<span class="badge badge-pill badge-danger">Please enter Category Code!</span>';
}
else
{ 
	$stamp_ind = addslashes($_POST['stamp_ind']);
}


// check for a status
if((empty($_POST['stamp_desc'])) || (($_POST['stamp_desc']) == "NULL"))
{ 
	$stamp_desc = FALSE;
	$message_catdesc = '<span class="badge badge-pill badge-danger">Please enter Category Description</span>';
}
else
{ 
	$stamp_desc = addslashes($_POST['stamp_desc']);
}

// check for status account
if((empty($_POST["status_stamp"])) || ($_POST["status_stamp"] == "NULL"))
{ 
$status_stamp = FALSE;
  $message_sta = '<span class="badge badge-pill badge-danger"> Please select Status Account!</span>';
  }else {
  $status_stamp = addslashes($_POST["status_stamp"]);
  }

// check for plant code
if((empty($_POST["plant_code"])) || ($_POST["plant_code"] == "NULL"))
{ 
  $plant_code = FALSE;
  $message_pcode = '<span class="badge badge-pill badge-danger"> Please select Plant Code!</span>';
  }else{ 
  $plant_code = addslashes($_POST["plant_code"]);
  }

if($stamp_ind && $stamp_desc && $plant_code && $status_stamp) //everything ok
{
	
$stamp_ind = $_POST['stamp_ind'];
$stamp_desc = $_POST['stamp_desc'];
$plant_code = $_POST['plant_code'];
$status_stamp = $_POST['status_stamp'];
	
	//register the user in the db.
	$query_db = "INSERT INTO category_detail(id_cat,stamp_ind,stamp_desc,status_stamp,plant_code) VALUES('','".sql_esc($stamp_ind)."','".sql_esc($stamp_desc)."','".sql_esc($status_stamp)."','".sql_esc($plant_code)."')";
	$result = mysqli_query($dbc,$query_db) or die (mysqli_error($dbc));
	
	if($result)
	{
		echo "<script>";
		echo "alert('Category is successfully created.');";
		echo "window.location='cat_mat_table.php'";
		echo "</script>";
		exit(); //quit the script
	}
	else 
	{
		$message = '<p><strong>Error!</strong> Cannot create Category. </p>';
		mysqli_close($dbc); //close db
	}  
}
//print the message if there is one.
	  

}
?>    
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Category</h3>
            <div class="tile-body">
              <form name="form1" method="post" action="" class="form-horizontal">
                <div class="form-group row">
                  <label class="control-label col-md-3">Category Code : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                  <input name="stamp_ind" type="text" class="form-control" id="stamp_ind" size="20" maxlength="20" value="<?php if(isset($_POST['stamp_ind'])) echo $_POST['stamp_ind']; ?>"  placeholder="Enter Category Code" />
                   <div class="form-control-feedback" ><?php echo $message_cat; ?></div>
                    </div>
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Category Description : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                  <input name="stamp_desc" type="text" class="form-control" id="stamp_desc" size="20" maxlength="20" value="<?php if(isset($_POST['stamp_desc'])) echo $_POST['stamp_desc']; ?>"  placeholder="Enter Category Description"/>
                   <div class="form-control-feedback" ><?php echo $message_catdesc; ?></div>
                    </div>
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Plant : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                    <select name="plant_code" class="form-control">
            <option value="NULL" placeholder="Select Plant"> -- Select Plant -- </option>
          <?php
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM plant_detail WHERE status_plant = "Y"';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
              ?>
         <option value="<?php echo $row27["plant_code"]; ?>" > <?php echo stripslashes($row27["plant_code"]); ?> - <?php echo $row27["plant_desc"]; ?></option>
          <?php
           }  ?>
                            
        </select>
                    
                   <div class="form-control-feedback" ><?php echo $message_pcode; ?></div>
               
                </div></div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Status Account: <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
               <select name="status_stamp" id="status_stamp" class="form-control">
               <option value="NULL"> --- Select --- </option>
                   <?php if($_POST['Submit7'] == true)
						{ ?>
               <option value="Y" <?php if($_POST["status_stamp"] == 'Y') { ?> selected="selected"<?php } ?>>ACTIVE</option>
               <option value="N" <?php if($_POST["status_stamp"] == 'N') { ?> selected="selected"<?php } ?>>INACTIVE</option>
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