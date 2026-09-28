<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
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
          <p>Material Detail Upload</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Table Maintenance</li>
          <li class="breadcrumb-item"><a href="material_detail_upload.php">Material Detail Upload</a></li>
        </ul>
      </div> 
             <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link" href="material_master_list.php">Material Master</a></li>
                <li class="nav-item"><a class="nav-link" href="material_master_list_NA.php">Material Master (Non Active)</a></li>
                <li class="nav-item"><a class="nav-link" href="material_hdr_upload.php">Material Header Upload</a></li>
                <li class="nav-item"><a class="nav-link active" data-toggle="tab"  href="material_detail_upload.php">Material Detail Upload</a></li>
                <li class="nav-item"><a class="nav-link"  href="material_add_hdr.php">Add Material Header</a></li>
                <li class="nav-item"><a class="nav-link"  href="material_add_detail.php">Add Material Detail</a></li>
            </ul>
            
      <?php
	  
	  $message = "";
	  
	if(isset($_POST["Submit2D"]))
{

$message = NULL; // create an empty new variable.

			
//-----file attachment detail-------------------
 $fileType = $_FILES['uploadD']['type'];
 $allowed = array("application/vnd.ms-excel");
 
  $uploadD = $_FILES['uploadD'];
  
//-----------------------------------
	
// check for a upload file
 if($_FILES['uploadD']['size'] == 0 || empty($_FILES['uploadD']['tmp_name']))
  { 
 
  $uploadD = FALSE;
  $message =  '<span class="badge badge-pill badge-danger">Please select Upload File!</span>';
  
  
  }elseif(!in_array($fileType,$allowed)) 
	{
  		$uploadD = FALSE;
        $message =  '<span class="badge badge-pill badge-danger">Allowed file type in MS Excel (Format file .xls)</span>';
	
	}
	
	
	
   
   
   if($_FILES['uploadD']['size'] > 0 && $uploadD) //everything ok
 {    
   
     $uploadD = $_FILES['uploadD'];
	 $fileType = $_FILES['uploadD']['type'];
     $allowed = array("application/vnd.ms-excel");

	   
	   
	   //Add the record to the database
	 
	   $queryD = "INSERT INTO ftp_detail_material(upload_id,id_file,file_name,file_size,file_type,date_plan,user_upload,date_upload,user_update,date_update,comp_code,plant_code) VALUES('','','".sql_esc($_FILES['uploadD']['name'])."','".sql_esc($_FILES['uploadD']['size'])."','".sql_esc($_FILES['uploadD']['type'])."','','".sql_esc($username)."',NOW(),'','','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_setup["comp_code"])."')";
	   $resultD = mysqli_query($dbc,$queryD);   
	   
	   //  if($resultD) {
	   //create the filename
	   
	   $nm_file2 = $_FILES['uploadD']['name'];
	   
	  // echo $nm_file2;
	   
	     $extension = explode ('.', $_FILES['uploadD']['name']);
		 $uid = mysqli_insert_id($dbc);  //upload ID
	
		 $filename = $uid .'.'.$extension[1];
		 
		    $query_update2 = "UPDATE ftp_detail_material SET id_file = '".sql_esc($uid)."' WHERE upload_id = '".sql_esc($uid)."'";
			$result_update2 = mysqli_query($dbc,$query_update2);   
			
			
		 if(move_uploaded_file($_FILES['uploadD']['tmp_name'], "../BOM_detail_upload/$filename"))  {
	   
		 
		//ini_set("display_errors",0);
        require_once "excel_reader2.php"; 
		 

		 
		 //-----------------upload file into table pps_upload------------------------//
	
	foreach (glob("../BOM_detail_upload/*.xls") as $filename) 
{ 
   
	$file = $filename;
    $data = new Spreadsheet_Excel_Reader($file);

   

$html="<table border='1'>";

for($i=0;$i<= 1;$i++) // Loop to get all sheets in a file.
{	

	 if(count($data->sheets[$i]["cells"]) > 0) // checking sheet not empty
	{
		//echo "Sheet $i:<br /><br />Total rows in sheet $i  ".count($data->sheets[$i]["cells"])."<br />";
		
		
		for($j=2;$j<=count($data->sheets[$i]["cells"]);$j++) // loop used to get each row of the sheet
		{ 
		
			$html.="<tr>";
			for($k=1;$k<=count($data->sheets[$i]["cells"][$j]);$k++) // This loop is created to get data in a table format.
			{
				$html.="<td>";
				$html.=$data->sheets[$i]["cells"][$j][$k];
				$html.="</td>";
				
			  
				

			
			} // end loop k
			
		
			
			$material_no = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][3]);
			$cat_mat = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][4]);
			$bom = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][5]);
			$alternative_bom = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][6]);
			$plant = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][7]);
			$sloc = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][8]);
			$isloc = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][9]);
			$bill_comp = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][10]);
			$bill_comp_desc = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][11]);
			$material_type = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][12]);
			$material_group = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][13]);
			$cat_bom = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][14]);
			$bom_item = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][15]);
			$bom_usage = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][16]);
			$consump = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][17]);	
			$bom_node  = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][18]);	
			$ver_no  = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][19]);	
			$comp_unit = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][20]);	
			$comp_Vclass = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][21]);
			$cvalid_form = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][22]);	
			$cvalid_to = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][23]);
			$status_bom = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][24]);
			
			$html.="</tr>";
	  

	  //-----get date create -------
			
			 /*  $d_crt = substr($cvalid_form,0,2);
				 $m_crt = substr($cvalid_form,3,2);
				 $y_crt = substr($cvalid_form,6,4);
				 
				 $dt_crt = ($y_crt.'-'.$m_crt.'-'.$d_crt);*/
				 
				 
	  
	  $query_ins_upl = "INSERT INTO mat_master_detail_upload(id_dtl,id_hdr,material,bom_category,bom,alternative_bom,valid_from,plant,sloc,isloc,bill_component,matl_group,bom_item_category,bom_item_no,comp_unit,consumption,material_desc_c,material_type,usage_c,date_create_bom,bom_status,date_uploaded,uploaded_by,date_updated,updated_by,cvalid_to,comp_matl_group,cvalid_from,comp_vclass,bom_usage,node_no,ver_no,header_matl_type) VALUES ('','','".sql_esc($material_no)."','".sql_esc($cat_mat)."','".sql_esc($bom)."','".sql_esc($alternative_bom)."','','".sql_esc($plant)."','".sql_esc($sloc)."','".sql_esc($isloc)."','".sql_esc($bill_comp)."','".sql_esc($material_group)."','".sql_esc($cat_bom)."','".sql_esc($bom_item)."','".sql_esc($comp_unit)."','".sql_esc($consump)."','".sql_esc($bill_comp_desc)."','".sql_esc($material_type)."','".sql_esc($bom_usage)."','','".sql_esc($status_bom)."',NOW(),'".sql_esc($username)."','','','".sql_esc($cvalid_to)."','".sql_esc($material_group)."','".sql_esc($cvalid_form)."','".sql_esc($comp_Vclass)."','".sql_esc($bom_usage)."','".sql_esc($bom_node)."','".sql_esc($ver_no)."','".sql_esc($material_type)."')";	 
	  $result_ins_upl = mysqli_query($dbc,$query_ins_upl);
	  
	  //---check duplicate material 	
				
	$query_MsA = new PreparedSql("SELECT * FROM mat_master_header WHERE material_no = ? AND status_BOM = 'Y'", [$material_no]);
	$result_MsA = db_query($dbc, $query_MsA);
    $res_MsA = mysqli_fetch_array($result_MsA);	
	
	
	if($res_MsA > 0)
	{
		
		
		//------checking mat_master_detail ada duplicate bill component
		$query_MsB = "SELECT * FROM mat_master_detail WHERE material = '".sql_esc($material_no)."' AND bill_component = '".sql_esc($bill_comp)."' AND bom_status = 'Y'";
	    $result_MsB = mysqli_query($dbc,$query_MsB);
        $res_MsB = mysqli_fetch_array($result_MsB);	
		
		
		if($res_MsB > 0)
		{
		
		
		
		//update bom status = 'N' for current material 
		$query_upMh = "UPDATE mat_master_detail SET bom_status = 'N' WHERE  material = '".sql_esc($material_no)."' AND bill_component = '".sql_esc($bill_comp)."' AND bom_status = 'Y'";
		$result_upMh = mysqli_query($dbc,$query_upMh);	
		
	
     $query_ins_hdr = "INSERT INTO mat_master_detail(id_dtl,id_hdr,material,bom_category,bom,alternative_bom,valid_from,plant,sloc,isloc,bill_component,matl_group,bom_item_category,bom_item_no,comp_unit,consumption,material_desc_c,material_type,usage_c,date_create_bom,bom_status,date_uploaded,uploaded_by,date_updated,updated_by,cvalid_to,comp_matl_group,cvalid_from,comp_vclass,bom_usage,node_no,ver_no,header_matl_type) VALUES ('','".sql_esc($res_MsA["id_hdr"])."','".sql_esc($material_no)."','".sql_esc($cat_mat)."','".sql_esc($bom)."','".sql_esc($alternative_bom)."','".sql_esc($cvalid_form)."','".sql_esc($plant)."','".sql_esc($sloc)."','".sql_esc($isloc)."','".sql_esc($bill_comp)."','".sql_esc($material_group)."','".sql_esc($cat_bom)."','".sql_esc($bom_item)."','".sql_esc($comp_unit)."','".sql_esc($consump)."','".sql_esc($bill_comp_desc)."','".sql_esc($material_type)."','".sql_esc($bom_usage)."','".sql_esc($res_MsA["date_bom_create"])."','".sql_esc($status_bom)."',NOW(),'".sql_esc($username)."','','','".sql_esc($cvalid_to)."','".sql_esc($material_group)."','".sql_esc($cvalid_form)."','".sql_esc($comp_Vclass)."','".sql_esc($bom_usage)."','".sql_esc($bom_node)."','".sql_esc($ver_no)."','".sql_esc($material_type)."')"; 
	 $result_ins_hdr = mysqli_query($dbc,$query_ins_hdr);
			 
			 
		}else{
			
			
	 $query_ins_hdr = "INSERT INTO mat_master_detail(id_dtl,id_hdr,material,bom_category,bom,alternative_bom,valid_from,plant,sloc,isloc,bill_component,matl_group,bom_item_category,bom_item_no,comp_unit,consumption,material_desc_c,material_type,usage_c,date_create_bom,bom_status,date_uploaded,uploaded_by,date_updated,updated_by,cvalid_to,comp_matl_group,cvalid_from,comp_vclass,bom_usage,node_no,ver_no,header_matl_type) VALUES ('','".sql_esc($res_MsA["id_hdr"])."','".sql_esc($material_no)."','".sql_esc($cat_mat)."','".sql_esc($bom)."','".sql_esc($alternative_bom)."','".sql_esc($cvalid_form)."','".sql_esc($plant)."','".sql_esc($sloc)."','".sql_esc($isloc)."','".sql_esc($bill_comp)."','".sql_esc($material_group)."','".sql_esc($cat_bom)."','".sql_esc($bom_item)."','".sql_esc($comp_unit)."','".sql_esc($consump)."','".sql_esc($bill_comp_desc)."','".sql_esc($material_type)."','".sql_esc($bom_usage)."','".sql_esc($res_MsA["date_bom_create"])."','".sql_esc($status_bom)."',NOW(),'".sql_esc($username)."','','','".sql_esc($cvalid_to)."','".sql_esc($material_group)."','".sql_esc($cvalid_form)."','".sql_esc($comp_Vclass)."','".sql_esc($bom_usage)."','".sql_esc($bom_node)."','".sql_esc($ver_no)."','".sql_esc($material_type)."')"; 
	 $result_ins_hdr = mysqli_query($dbc,$query_ins_hdr);
		
			
			
			
			
		}
			
			
			
	}else{ //end if $res_Ms
	
	        echo "<script>";
            echo "alert('Your submission could not be processed. Please check Material Header');";
            echo "window.location='material_detail_upload.php'";
            echo "</script>";
			
			//echo "material no exist";
	
	
	}
		
		
	   } // end for loop j

   } // end if count

}//end for for i

$html.="</table>";

	  
	      
	
	//	------ move file to another folder ----------------------------------
			$handle3 = $file;
			$destination = "../BOM_detail_update/".$file;
			$data2 = file_get_contents($handle3);

			$handle3 = fopen($destination, "w");
			fwrite($handle3, $data2);
			fclose($handle3);
			unlink($file);
			

		 
} // end foreach
		 
	 	 
		 //-----if move------
		 }else{
			 
			 
			echo "<script>";
            echo "alert('Your submission could not be processed due to a system error. We apologize for any inconvenience.');";
            echo "window.location='material_detail_upload.php'";
            echo "</script>";
			 
	
		 }
	  
            echo "<script>";
            echo "alert('Your submission have been processed.');";
            echo "window.location='material_detail_upload.php'";
            echo "</script>";




} // if upload file > 0

          

}//end if submit





?>   
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Material Detail Upload</h3>
            <div class="tile-body">
            
              <table class="table">
<tr>    <td width="1%">&nbsp;</td> 

    <td width="85%">&nbsp;</td> 
      <td width="7%"><a href="Template BOM Details.xls" ><img src="../images/template-icon.jpg" width="80" height="80" title="Download Template" /><i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Allowed file type in MS Excel (Format file .xls)" data-html="true" data-placement="left"></i><font size="-1">Template</font></a></td>
     <td width="7%">&nbsp;</td>
   
  </tr>
</table> 

		<form name="form1" enctype="multipart/form-data" action="" method="post" class="form-horizontal">
        <input type="hidden" name="MAX_FILE_SIZE" value="1024000000000">

			      <div class="form-group row">
                  <label class="control-label col-md-3">Select File Material Detail Upload :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-4">
             <input name="uploadD" type="file" class="form-control" value="<?php if(isset($_POST['uploadD'])) { echo $_POST['uploadD'];  } ?>" accept=".xls" /> 
              <p><span class="style3">Limit the size of an attachment is 2M.</span> </p>
              <div class="form-control-feedback" ><?php echo $message; ?></div>
                    </div>
                  </div>
              <div class="form-group row">
                  <label class="control-label col-md-3"><font color="#FF0000"><b>* Compulsory field</b></font></label>
                    <div class="col-md-4">
                  &nbsp;
                </div>
              </div>
              
                <div class="form-group col-md-8 align-self-end">
               <input name="Submit2D" type="submit" id="Submit2D" value="UPLOAD" class="btn btn-primary">
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