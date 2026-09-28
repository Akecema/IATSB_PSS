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
	
	
	
$url = "add_user.php"; 
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

			<form role="form" action="<?php //echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="form1"  enctype="multipart/form-data" class="form-horizontal">
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
   
   



   <?php
		
   $storagename = $_GET["file"];		
   $storagename2 = "../BOM_upload/$storagename";
  
  //echo $storagename2. "<br>"; 


//---------------------------------------------------------------------------------

set_include_path(get_include_path() . PATH_SEPARATOR . '../classes/');
include 'PHPExcel/IOFactory.php';

// This is the file path to be uploaded.
$inputFileName = $storagename2; 

try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}


$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet

$mesej2 = "";
$mesej3 = "";

//if($i>=0)
for($i=2;$i<=$arrayCount;$i++){

$col1 = trim($allDataInSheet[$i]["A"]);
$col2 = trim($allDataInSheet[$i]["B"]);
$col3 = trim($allDataInSheet[$i]["C"]);
$col4 = trim($allDataInSheet[$i]["D"]);
$col5 = trim($allDataInSheet[$i]["E"]);
$col6 = trim($allDataInSheet[$i]["F"]);
$col7 = trim($allDataInSheet[$i]["G"]);
$col8 = trim($allDataInSheet[$i]["H"]);
$col9 = trim($allDataInSheet[$i]["I"]);
$col10 = trim($allDataInSheet[$i]["J"]);
$col11 = trim($allDataInSheet[$i]["K"]);
$col12 = trim($allDataInSheet[$i]["L"]);
$col13 = trim($allDataInSheet[$i]["M"]);
$col14 = trim($allDataInSheet[$i]["N"]);
$col15 = trim($allDataInSheet[$i]["O"]);
$col16 = trim($allDataInSheet[$i]["P"]);
$col17 = trim($allDataInSheet[$i]["Q"]);
$col18 = trim($allDataInSheet[$i]["R"]);
$col19 = trim($allDataInSheet[$i]["S"]);
$col20 = trim($allDataInSheet[$i]["T"]);
$col21 = trim($allDataInSheet[$i]["U"]);
$col22 = trim($allDataInSheet[$i]["V"]);



//change date format	
$dateArray = explode('.', $col11 );
$dcol11 = $dateArray[2].'-'.$dateArray[1].'-'.$dateArray[0];

$dateArray = explode('.', $col12 );
$dcol12 = $dateArray[2].'-'.$dateArray[1].'-'.$dateArray[0];


//1.INSERT INTO TABLE MAT HEADER
//select duplicate material from header
/*$query_Ms = "SELECT * FROM mat_master_header WHERE material_no = '".$col2."' AND material_type = '".$col4."' AND bom = '".$col8."' AND status_BOM = 'Y'";*/
$query_Ms = new PreparedSql("SELECT * FROM mat_master_header WHERE material_no = ? AND status_BOM = 'Y'", [$col2]);
$result_Ms = db_query($dbc, $query_Ms)or die(mysqli_error($dbc));
$res_Ms = mysqli_fetch_array($result_Ms);


if($res_Ms > 0)
{
	//update bom status = 'N' for current material 
	/*$query_upMh = "UPDATE mat_master_header SET status_BOM = 'N' WHERE material_no = '".$col2."' AND material_type = '".$col4."' AND bom = '".$col8."' AND status_BOM = 'Y'";*/
	$query_upMh = "UPDATE mat_master_header SET status_BOM = 'N' WHERE material_no = '".sql_esc($col2)."' AND status_BOM = 'Y'";
	$result_upMh = mysqli_query($dbc,$query_upMh);	
	
	
	//insert
	$ist_hd = "INSERT INTO mat_master_header(id_hdr,material_no,material_desc,material_type,material_group,plant,bom_usage,bom,alternative_bom,BUn,date_create,date_bom_create,status_BOM,std_package,type_package,location_deliver,station_deliver,rcv_point,part_side,date_uploaded,uploaded_by,date_updated,updated_by)
		VALUES('','".sql_esc($col2)."','".sql_esc($col3)."','".sql_esc($col4)."','".sql_esc($col5)."','".sql_esc($col6)."','".sql_esc($col7)."','".sql_esc($col8)."','".sql_esc($col9)."','".sql_esc($col10)."','".sql_esc($dcol11)."','".sql_esc($dcol12)."','".sql_esc($col13)."','".sql_esc($col14)."','".sql_esc($col15)."','".sql_esc($col16)."','".sql_esc($col17)."','".sql_esc($col18)."','".sql_esc($col19)."',NOW(),'".sql_esc($username)."','','')";
	$result_hd = mysqli_query($dbc,$ist_hd) or die('Error, failed to add into material.');		
	
	
}
else
{
	$ist_hd22 = "INSERT INTO mat_master_header(id_hdr,material_no,material_desc,material_type,material_group,plant,bom_usage,bom,alternative_bom,BUn,date_create,date_bom_create,status_BOM,std_package,type_package,location_deliver,station_deliver,rcv_point,part_side,date_uploaded,uploaded_by,date_updated,updated_by)
					VALUES('','".sql_esc($col2)."','".sql_esc($col3)."','".sql_esc($col4)."','".sql_esc($col5)."','".sql_esc($col6)."','".sql_esc($col7)."','".sql_esc($col8)."','".sql_esc($col9)."','".sql_esc($col10)."','".sql_esc($dcol11)."','".sql_esc($dcol12)."','".sql_esc($col13)."','".sql_esc($col14)."','".sql_esc($col15)."','".sql_esc($col16)."','".sql_esc($col17)."','".sql_esc($col18)."','".sql_esc($col19)."',NOW(),'".sql_esc($username)."','','')";
	$result_hd22 = mysqli_query($dbc,$ist_hd22) or die('Error, failed to add into header material 2.');		
}


//2.INSERT INTO TABLE MAT 
//select duplicate material from table material
/*$query_Mtr = "SELECT * FROM table_material WHERE material_no = '".$col2."' AND mat_type = '".$col4."' AND bom_status = 'Y'";*/
$query_Mtr = "SELECT * FROM table_material WHERE material_no = '".sql_esc($col2)."' AND bom_status = 'Y'";
$result_Mtr = mysqli_query($dbc,$query_Mtr)or die(mysqli_error($dbc));
$res_Mtr = mysqli_fetch_array($result_Mtr);


if($res_Mtr > 0) //if exist
{
	$query_upMtb = "UPDATE table_material SET bom_status = 'N' WHERE material_no = '".sql_esc($col2)."'  ";
	$result_upMtb = mysqli_query($dbc,$query_upMtb);	
	
	if($result_upMtb)
	{
		//insert into table material
		$ist_mt = "INSERT INTO table_material		(id_mat,material_no,material_desc,mat_type,plan_code,BUn,date_create_bom,bom_status,material_group,date_uploaded,uploaded_by,date_updated,updated_by,part_side)
	VALUES('','".sql_esc($col2)."','".sql_esc($col3)."','".sql_esc($col4)."','".sql_esc($col6)."','".sql_esc($col10)."','".sql_esc($dcol11)."','".sql_esc($col13)."','".sql_esc($col5)."',NOW(),'".sql_esc($username)."','','','".sql_esc($col19)."') ";
		$result_mt = mysqli_query($dbc,$ist_mt) or die('Error, failed to add into table material.');	
	}	
	
}
else
{
	//insert into table material
	$ist_mt22 = "INSERT INTO table_material					(id_mat,material_no,material_desc,mat_type,plan_code,BUn,date_create_bom,bom_status,material_group,date_uploaded,uploaded_by,date_updated,updated_by,part_side) VALUES('','".sql_esc($col2)."','".sql_esc($col3)."','".sql_esc($col4)."','".sql_esc($col6)."','".sql_esc($col10)."','".sql_esc($dcol11)."','".sql_esc($col13)."','".sql_esc($col5)."',NOW(),'".sql_esc($username)."','','','".sql_esc($col19)."') ";
	$result_mt22 = mysqli_query($dbc,$ist_mt22) or die('Error, failed to add into table material 2.');	
	
	
	
	
	//3.FOR MAT TYPE='Z310',INSERT INTO TABLE MAT QC
if($col4 == 'Z310')
{
	
	$query_Mtrqc = "SELECT * FROM table_material_qc WHERE material_no = '".sql_esc($col2)."' AND bom_status = 'Y'";
	$result_Mtrqc = mysqli_query($dbc,$query_Mtrqc);
	$res_Mtrqc = mysqli_fetch_array($result_Mtrqc);
	
	
		$query_upMqc = "UPDATE table_material_qc SET bom_status = 'N' WHERE material_no = '".sql_esc($col2)."' ";
		$result_upMqc = mysqli_query($dbc,$query_upMqc);
		
		//insert into table material QC
		$ist_qc = "INSERT INTO table_material_qc				(id_mat,material_no,material_desc,mat_type,plan_code,BUn,date_create_bom,bom_status,material_group,date_uploaded,uploaded_by,date_updated,updated_by,part_side)	VALUES('','".sql_esc($col2)."','".sql_esc($col3)."','".sql_esc($col4)."','".sql_esc($col6)."','".sql_esc($col10)."','".sql_esc($dcol11)."','".sql_esc($col13)."','".sql_esc($col5)."',NOW(),'".sql_esc($username)."','','','".sql_esc($col19)."') ";
		$result_qc = mysqli_query($dbc,$ist_qc) or die('Error, failed to add into table material qc.');		
	
		
} // if $res_MTR



}// end if 


 

}//end for



//echo $arrayCount;
//----------------------kena buat move file to another folder

$handle2 = $storagename2;
$destination = "../BOM_update/BOM_upload/".$storagename;

$data = file_get_contents($handle2);

$handle2 = fopen($destination, "w");
fwrite($handle2, $data);
fclose($handle2);


$mv = move_uploaded_file($storagename2, "../BOM_update/BOM_upload/$storagename");
$un = unlink($storagename2);

if($un)
{
	$mesej2 = "<script language='JavaScript'>alert('Material Master successfully upload.');window.location='material_master_upload.php';</script>";
}

echo $mesej2; echo $mesej3;

//-------------------------------delete table mat_master_header_upload -------------------------------------
/*$query_hsekeeping = "DELETE FROM mat_master_header_upload";
$result_hsekeeping =  mysql_query($query_hsekeeping);
*/

//------------------------end delete upload mat_master_header_upload ---------------------------------						

/*echo "<script>";
echo "alert('Material Master successfully upload.');";
echo "window.location='material_master_upload.php'";
echo "parent.tb_remove(); parent.location.reload(1)";
echo "</script>"; 
exit(); //quit the script
*/
		   
?>


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