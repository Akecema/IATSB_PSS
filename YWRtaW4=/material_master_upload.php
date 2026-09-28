<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

set_time_limit(0);

ini_set('post_max_size', '2M');
ini_set('upload_max_filesize', '2M');

$uploadedStatus = 0;

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
  <meta name="description" content="<?php $data_setup["tajuk_sys"]; ?>">
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
	<?php

function _time_diff($hour_a, $hour_b){
   $y = date('Y-m-d').' ';
   return (int)((strtotime($y.$hour_b) - strtotime($y.$hour_a)) / 60);
}


?>
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
          <li class="breadcrumb-item"><a href="material_master_upload.php">Material Master Upload</a></li>
        </ul>
      </div> 
             <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link" href="material_master_list.php">Material Master</a></li>
                <li class="nav-item"><a class="nav-link" href="material_master_list_NA.php">Material Master (Non Active)</a></li>
                <li class="nav-item"><a class="nav-link active" data-toggle="tab"  href="material_master_upload.php">Material Master Upload</a></li>
                <li class="nav-item"><a class="nav-link"  href="material_component_upload.php">Material Component Upload</a></li>
            </ul>
            
      <?php
	  
	if(isset($_POST["Submit2"]))
{

// create a function for escaping the data.
/*function escape_data ($data) {
global $dbc;   // need the connection.
if(ini_get('magic_quotes_gpc')) {
$data = stripslashes($data);
}
return mysql_real_escape_string($data,$dbc);
}   // end function.

*/
$message = NULL; // create an empty new variable.

			
//-----file attachment detail-------------------

$fileType = $_FILES['fileUpload']['type'];
$fileSize = $_FILES['fileUpload']['size'];
$fileUpload = $_FILES['fileUpload']; 
$allowed = array("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.ms-excel");

//echo $fileSize;
//echo $_FILES["fileUpload"]["name"];

//-----------------------------------
	
	
// check for a upload file
if($_FILES["fileUpload"]["size"] == 0 || empty($_FILES["fileUpload"]["tmp_name"]))
{ 
	$upload = FALSE;
	$message.= '<p> You are required to select UPLOAD FILE!</p>';
}	 
elseif(!in_array($fileType, $allowed)) 
{
	 $upload = FALSE;
	 $message.= '<p> Only EXCEL files are allowed.</p>';

}
elseif(in_array($fileType, $allowed)) 
{
	if($_FILES['fileUpload']['size'] > (2097152))
	{ 
		$upload = FALSE;
		$message .= '<p> File too large. File must be less than 2 megabytes.</p>'; 
	}
  
	$upload = TRUE; 
	$storagename = $_FILES["fileUpload"]["name"];	 
	move_uploaded_file($_FILES["fileUpload"]["tmp_name"], "../BOM_upload/$storagename" );
	$uploadedStatus = 1;

	//insert table upload_mb52

	/*$query_upload = "INSERT INTO upload_mm60(id_upload,file_name,file_size,file_type,date_upload,pic_upload, status_upload) VALUES ('','".$_FILES["fileUpload"]["name"]."', '".$_FILES["fileUpload"]["size"]."', '".$_FILES["fileUpload"]["type"]."',NOW(),'".$data_u["staff_ID"]."','Y')";		
	$result_upload = mysql_query($query_upload) or die (mysql_error());*/
}  
 

if (isset($message))
{ 
	echo '<font color="red" class ="error_entry">', $message, '</font>';
}
	
//if there was an error uploading the file
if ($_FILES["fileUpload"]["error"] > 0) 
{
	echo "Return Code: " . $_FILES["fileUpload"]["error"] . "<br />";
}
else 
{
	if (file_exists($_FILES["fileUpload"]["name"])) 
	{	
		unlink($_FILES["fileUpload"]["name"]);
	}
}
} 
/*else 
{
	echo "No file selected <br />";
} */
	

//}


if($uploadedStatus == 1)
{
	echo "<script>";
	echo "window.location='material_master_uploadProc.php?file=$storagename';";
	echo "</script>";
	exit(); //quit the script  
}

?>   
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Material Master Upload</h3>
            <div class="tile-body">

			<form role="form" action="" method="post" name="form1"  enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" name="MAX_FILE_SIZE" value="2097152">


             <!-- <form name="form1" method="post" action="" class="form-horizontal"> -->

			      <div class="form-group row">
                  <label class="control-label col-md-3">Select material master :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
					<input class="form-control"  type="file" name="fileUpload" id="file">
                    </div>
                  </div>
              <div class="form-group row">
                  <label class="control-label col-md-3"><font color="#FF0000"><b>* Compulsory field</b></font></label>
                    <div class="col-md-8">
                  &nbsp;
                </div>
              </div>
              
                <div class="form-group col-md-8 align-self-end">
               <input name="Submit2" type="submit" id="submit" value="UPLOAD" class="btn btn-primary">
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