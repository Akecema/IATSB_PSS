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

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
$url = "mat_detail_table.php"; 
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
          <p>List Material Upload</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Table Maintenance</li>
          <li class="breadcrumb-item"><a href="upl_mat_detail_table.php">List Material Upload</a></li>
        </ul>
      </div> 
             <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link" href="add_tbl_mat_detail.php">Add Material</a></li>
                <li class="nav-item"><a class="nav-link" href="mat_detail_table.php">Display Material Details</a></li>
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="upl_mat_detail_table.php">List Material Upload</a></li>
            </ul>
            
      <?php
	  
	  $message = "";
	  
	if(isset($_POST["Submit2"]))
{

$message = NULL; // create an empty new variable.

			
//-----file attachment detail-------------------
 $fileType = $_FILES['upload']['type'];
 $allowed = array("application/vnd.ms-excel");
 
  $upload = $_FILES['upload'];
  
//-----------------------------------
	
// check for a upload file
 if($_FILES['upload']['size'] == 0 || empty($_FILES['upload']['tmp_name']))
  { 
 
  $upload = FALSE;
  $message =  '<span class="badge badge-pill badge-danger">Please select Upload File!</span>';
  
  
  }elseif(!in_array($fileType,$allowed)) 
	{
  		$upload = FALSE;
        $message =  '<span class="badge badge-pill badge-danger">Allowed file type in MS Excel (Format file .xls)</span>';
	
	}
	
	
	
   
   
   if($_FILES['upload']['size'] > 0 && $upload) //everything ok
 {    
   
     $upload = $_FILES['upload'];
	 $fileType = $_FILES['upload']['type'];
     $allowed = array("application/vnd.ms-excel");

	   
	   
	   //Add the record to the database
	 
	   $queryD = "INSERT INTO ftp_list_material(upload_id,id_file,file_name,file_size,file_type,date_plan,user_upload,date_upload,user_update,date_update,comp_code,plant_code) VALUES('','','".sql_esc($_FILES['upload']['name'])."','".sql_esc($_FILES['upload']['size'])."','".sql_esc($_FILES['upload']['type'])."','','".sql_esc($username)."',NOW(),'','','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_setup["comp_code"])."')";
	   $resultD = mysqli_query($dbc,$queryD);   
	   
	   //  if($resultD) {
	   //create the filename
	   
	   $nm_file = $_FILES['upload']['name'];
	   
	     $extension = explode ('.', $_FILES['upload']['name']);
		 $uid = mysqli_insert_id($dbc);  //upload ID
	
		 $filename = $uid .'.'.$extension[1];
		 
		    $query_update2 = "UPDATE ftp_list_material SET id_file = '".sql_esc($uid)."' WHERE upload_id = '".sql_esc($uid)."'";
			$result_update2 = mysqli_query($dbc,$query_update2);   
	   
	   	 if(move_uploaded_file($_FILES['upload']['tmp_name'], "../MAT_upload/$filename"))  {
		 
		 
		//ini_set("display_errors",0);
        require_once "excel_reader2.php"; 
		 

		 
		 //-----------------upload file into table pps_upload------------------------//
	
	foreach (glob("../MAT_upload/*.xls") as $filename) 
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
			
		
			
			$material_no = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][2]);
			$material_desc = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][3]);
			$plant = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][4]);
			$material_type = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][5]);
			$work_center = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][6]);	
			$material_group = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][7]);
			$BUn = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][8]);	
			$Vclass = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][9]);	
			$model_code = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][10]);	
			$model_desc = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][11]);
			$cat_transit = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][12]);	
			$std_package = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][13]);
			$type_package = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][14]);
			$part_side = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][15]);	
			$back_no = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][16]);	
			$sloc = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][17]);	
			$size_dim = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][18]);	
			$cust_part_no = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][19]);	
			$cust_part_desc = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][20]);	
			$prod_part_no = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][21]);	
			$vcode = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][22]);	
			$vend_desc = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][23]);	
			$mat_group =  mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][24]);	
			$acc_group = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][25]);
			$pp_log = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][26]);
			$pp_log_desc = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][27]);
			$cust_code = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][28]);	
			$cust_desc = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][29]);	
			$status_bom = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][30]);
			$status_foc = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][31]);
			$status_sp = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][32]);
				
			$html.="</tr>";
			
	 
	 //---Stamp Ind ----- 
	  if($cat_transit == 'A')
	  {
		  $stm_ind = "ASSY";
	  }elseif($cat_transit == 'S')
	  {
	      $stm_ind = "STM";
	  }elseif($cat_transit == 'T')
	  {
		  
		 $stm_ind = "TRN"; 
	  }else{
		  
		  $stm_ind = ""; 
		  
	  }
	  

	  //-----get date create -------
			
			    /* $d_crt = substr($date_create,0,2);
				 $m_crt = substr($date_create,3,2);
				 $y_crt = substr($date_create,6,4);
				 
				 $dt_crt = ($y_crt.'-'.$m_crt.'-'.$d_crt);*/
	  
    //---check duplicate material 	
				
	$query_Ms = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($material_no)."' AND status_BOM = 'Y'";
	$result_Ms = mysqli_query($dbc,$query_Ms)or die(mysqli_error($dbc));
	$res_Ms = mysqli_fetch_array($result_Ms);
	
	
	if($res_Ms > 0)
	{
		//update bom status = 'N' for current material 
		$query_upMh = "UPDATE table_material_itsb SET status_BOM = 'N' WHERE material_no = '".sql_esc($material_no)."' AND status_BOM = 'Y'";
		$result_upMh = mysqli_query($dbc,$query_upMh);	
	
	
	
     $query_ins_hdr = "INSERT INTO table_material_itsb(id_mat,material_no,material_desc,mat_type,plant_code,material_group,BUn,Vclass,model_code,model_desc,category_mat,std_packaging,type_package,part_side,back_no,mat_group,acc_group,prod_line,sloc,cust_part_no,prod_part_no,size_dim,pp_log_no,pp_log_desc,date_create,user_create,status_BOM,date_upload,user_upload,date_update,user_update,vendor_id,vendor_desc,material_cust_no,material_desc_cust,cust_code,cust_name,status_foc,status_sp) VALUES ('','".sql_esc($material_no)."','".sql_esc($material_desc)."','".sql_esc($material_type)."','".sql_esc($plant)."','".sql_esc($material_group)."','".sql_esc($BUn)."','".sql_esc($Vclass)."','".sql_esc($model_code)."','".sql_esc($model_desc)."','".sql_esc($stm_ind)."','".sql_esc($std_package)."','".sql_esc($type_package)."','".sql_esc($part_side)."','".sql_esc($back_no)."','".sql_esc($material_group)."','".sql_esc($acc_group)."','".sql_esc($work_center)."','".sql_esc($sloc)."','".sql_esc($cust_part_no)."','".sql_esc($prod_part_no)."','".sql_esc($size_dim)."','".sql_esc($pp_log_no)."','".sql_esc($pp_log_desc)."',NOW(),'".sql_esc($username)."','".sql_esc($status_bom)."',NOW(),'".sql_esc($username)."','','','".sql_esc($vcode)."','".sql_esc($vend_desc)."','".sql_esc($cust_part_no)."','".sql_esc($cust_part_desc)."','".sql_esc($cust_code)."','".sql_esc($cust_desc)."','".sql_esc($status_foc)."','".sql_esc($status_sp)."')";	 
	 $result_ins_hdr = mysqli_query($dbc,$query_ins_hdr);
			 
			
			
			
	}else{ //end if $res_Ms
	
     $query_ins_hdrN = "INSERT INTO table_material_itsb(id_mat,material_no,material_desc,mat_type,plant_code,material_group,BUn,Vclass,model_code,model_desc,category_mat,std_packaging,type_package,part_side,back_no,mat_group,acc_group,prod_line,sloc,cust_part_no,prod_part_no,size_dim,pp_log_no,pp_log_desc,date_create,user_create,status_BOM,date_upload,user_upload,date_update,user_update,vendor_id,vendor_desc,material_cust_no,material_desc_cust,cust_code,cust_name,status_foc,status_sp) VALUES ('','".sql_esc($material_no)."','".sql_esc($material_desc)."','".sql_esc($material_type)."','".sql_esc($plant)."','".sql_esc($material_group)."','".sql_esc($BUn)."','".sql_esc($Vclass)."','".sql_esc($model_code)."','".sql_esc($model_desc)."','".sql_esc($stm_ind)."','".sql_esc($std_package)."','".sql_esc($type_package)."','".sql_esc($part_side)."','".sql_esc($back_no)."','".sql_esc($material_group)."','".sql_esc($acc_group)."','".sql_esc($work_center)."','".sql_esc($sloc)."','".sql_esc($cust_part_no)."','".sql_esc($prod_part_no)."','".sql_esc($size_dim)."','".sql_esc($pp_log_no)."','".sql_esc($pp_log_desc)."',NOW(),'".sql_esc($username)."','".sql_esc($status_bom)."',NOW(),'".sql_esc($username)."','','','".sql_esc($vcode)."','".sql_esc($vend_desc)."','".sql_esc($cust_part_no)."','".sql_esc($cust_part_desc)."','".sql_esc($cust_code)."','".sql_esc($cust_desc)."','".sql_esc($status_foc)."','".sql_esc($status_sp)."')";	 
	 $result_ins_hdrN = mysqli_query($dbc,$query_ins_hdrN);
	
	}
		
		
	   } // end for loop j

   } // end if count

}//end for for i

$html.="</table>";

	  
	      
	
	//	------ move file to another folder ----------------------------------
			$handle2 = $file;
			$destination = "../MAT_update/MAT_upload/".$file;
			$data = file_get_contents($handle2);

			$handle2 = fopen($destination, "w");
			fwrite($handle2, $data);
			fclose($handle2);
			unlink($file);
			

		 
} // end foreach
		 
	 	 
		 //-----if move------
		 }else{
			 
			 
			echo "<script>";
            echo "alert('Your submission could not be processed due to a system error. We apologize for any inconvenience.');";
            echo "window.location='upl_mat_detail_table.php'";
            echo "</script>";
			 
	
		 }
	  
            echo "<script>";
            echo "alert('Your submission have been processed.');";
            echo "window.location='upl_mat_detail_table.php'";
            echo "</script>";




} // if upload file > 0

          

}//end if submit





?>   
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">List Material Upload</h3>
            <div class="tile-body">

			            
 <table class="table">
  <tr>    
	<td width="1%">&nbsp;</td> 

    <td width="85%">&nbsp;</td> 
      <td width="7%"><a href="Template List Material.xls" ><img src="../images/template-icon.jpg" width="80" height="80" title="Download Template" /><i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Allowed file type in MS Excel (Format file .xls)" data-html="true" data-placement="left"></i><font size="-1">Template</font></a></td>
     <td width="7%">&nbsp;</td>   
  </tr>
</table> 
          <!--   
              <table class="table">
<tr>    <td width="1%">&nbsp;</td> 

    <td width="85%">&nbsp;</td> 
      <td width="7%"><a href="template_document_LisMat.php" ><img src="../images/template-icon.jpg" width="80" height="80" title="Download Template" /><i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Allowed file type in MS Excel (Format file .xls)" data-html="true" data-placement="left"></i><font size="-1">Template</font></a></td>
     <td width="7%">&nbsp;</td>
   
  </tr>
</table>  -->

		<form name="form1" enctype="multipart/form-data" action="" method="post" class="form-horizontal">
        <input type="hidden" name="MAX_FILE_SIZE" value="1024000000000">

			      <div class="form-group row">
                  <label class="control-label col-md-3">Select File List Material Upload :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-4">
             <input name="upload" type="file" class="form-control" value="<?php if(isset($_POST['upload'])) echo $_POST['upload']; ?>" accept=".xlsx,.xls" /> 
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
               <input name="Submit2" type="submit" id="Submit2" value="UPLOAD" class="btn btn-primary">
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