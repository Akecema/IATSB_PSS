<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.7.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
//include '../include/config_mail.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "2")) {
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
    $result2 = db_query($dbc, $query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
//--------menu function ------------------------------

$query_function = new PreparedSql("SELECT * FROM function_acc_detail WHERE staff_ID = ?", [$res["staff_ID"]]);
$result_function = db_query($dbc, $query_function);   //run the query.
$data_function = mysqli_fetch_array($result_function);   //how many records are there?  
//----------------------------------------------------	
	
$url = "upload_pps_month-assy.php"; 
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
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    
    
    
    <!-- jQuery library -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->

<!-- Bootstrap library -->
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
-->

    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
    <script language="javascript">
	$('.datepicker').pickadate({
	weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
	showMonthsShort: true
	})
	</script>
  </head>
  
  <body class="app sidebar-mini">
    <!-- Navbar-->
      <?php   include "top_modal_menu.php";   ?>
    
    
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <?php   include "left_prod_menu.php";   ?>
  
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> Production Planning</h1>
          <p>Upload Planning</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"> Production Planning</li>
          <li class="breadcrumb-item"><a href="upload_pps_month-assy.php">Upload Planning</a></li>
        </ul>
      </div> 
              <ul class="nav nav-tabs">
               <?php if($data_function["f_assy_prd"] == 'Y') { ?>  <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="upload_pps_month-assy.php">Assembly Planning </a></li><?php }   ?>
               <?php if($data_function["f_stamp_prd"] == 'Y') { ?> <li class="nav-item"><a class="nav-link" href="upload_pps_month.php">Stamping Planning</a></li><?php }   ?>
               
               
              </ul>
    <?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

?>
           
       <?php
	   
	   $message_pcode = "";
	   $message_file = ""; 
	
// Set the page title and include the HTML header.
//include ('templates/header.inc');

if(isset($_POST['submitCT'])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.


// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}
// create a function for escaping the data.
function escape_data($data) {
global $dbc;   // need the connection.
if (ini_get('magic_quotes_gpc')) {
    $data = stripslashes($data);
	}
	return mysqli_real_escape_string($data,$dbc);
	}   // end function.
$message = NULL; // create an empty new variable.
   
 $fileType = $_FILES['upload']['type'];
 $allowed = array("application/vnd.ms-excel");
 
 
 $upload = $_FILES['upload'];
 $plant_code = $_POST['plant_code'];
 
			 
          //check file name duplicate-----
 
            $query_chk_attach4 = new PreparedSql("SELECT * FROM ftp_pps WHERE file_name = ?", [$_FILES["upload"]["name"]]);
            $result_chk_attach4 = db_query($dbc, $query_chk_attach4);   //run the query.
            $data_chk_attach4 = mysqli_fetch_array($result_chk_attach4);   //how many records are there?   
			 
			 if($data_chk_attach4 >= 1 )
			 {
			   
				echo "<script>";
                echo "alert('File already exist or rename file then upload.');";
                echo "window.location='upload_pps_month-assy.php'";
                echo "</script>";
				exit(); //quit the script
			              		   
			   }
  
// check for a upload file
 if($_FILES['upload']['size'] == 0 || empty($_FILES['upload']['tmp_name']))
  { 
 
  $upload = FALSE;
  $message_file = '<p><font color="#FF0000"><strong>Error!</strong> You are required to select Upload File!</font></p>';
  }	 
 elseif(!in_array($fileType, $allowed)) 
	{
  		$upload = FALSE;
        $message_file = '<p><font color="#FF0000"><strong>Error!</strong> Only IMAGE files are allowed.</font></p>';
	
	} 
	

// check for plant code

	if(($_POST["plant_code"]) == "NULL")
     {
	     $plant_code = FALSE;
		 $message_pcode = '<p><font color="#FF0000"><strong>Error!</strong> You are required to select Plant!</font></p>';
	 }else{
		 $plant_code = TRUE;
	  }
	  
	   if(($_FILES['upload']['type']) != "application/vnd.ms-excel" )
	  { 
	  
	     $upload = FALSE;
	 
			echo "<script>";
            echo "alert('The document could not be moved.  File incorrect ');";
            echo "window.location='upload_pps_month-assy.php'";
            echo "</script>"; 
	  
	  }
	  
  
  if($_FILES['upload']['size'] > 0 && $upload && $plant_code) //everything ok
 {  	
   
  $plant_code = $_POST["plant_code"];
 // $date_plan = $_POST["date1"];
   
	   //Add the record to the database
	   
	    $query = "INSERT INTO ftp_pps(upload_id,id_file,file_name,file_size,file_type,date_plan,user_upload,date_upload,user_update,date_update,comp_code,plant_code) VALUES('','','".sql_esc($_FILES['upload']['name'])."','".sql_esc($_FILES['upload']['size'])."','".sql_esc($_FILES['upload']['type'])."','','".sql_esc($username)."',NOW(),'','','".sql_esc($data_setup["comp_code"])."','".sql_esc($plant_code)."')";
	   $result = mysqli_query($dbc,$query);   
	   
	  
	   if($result) {
	   //create the filename
	     $extension = explode ('.', $_FILES['upload']['name']);
		 $uid = mysqli_insert_id($dbc);  //upload ID
	
		 $filename = $uid .'.'.$extension[1];
		 
		 
		    $query_update2 = "UPDATE ftp_pps SET id_file = '".sql_esc($uid)."' WHERE upload_id = '".sql_esc($uid)."'";
			$result_update2 = mysqli_query($dbc,$query_update2);   
		 
		 
	 if(move_uploaded_file($_FILES['upload']['tmp_name'], "upload_pps/$filename"))  {
		 
		 
		ini_set("display_errors",0);
        require_once "excel_reader2.php"; 
		 
		 
		 set_time_limit(0);


//-----------------upload file into table pps_upload------------------------//
	
	foreach (glob("upload_pps/*.xls") as $filename) 
{ 
   // $date1 = $_GET["date1"];
	//$plant_code = $_GET["plant_code"];
	//$upload_id = $_GET["upload_id"];
	
	$file = $filename;
	
	//echo $file."<br>"; 

    $data = new Spreadsheet_Excel_Reader($file);

             
			//------------------end 2nd upload checking---------------------------
			
//echo "Total Sheets in this xls file: ".count($data->sheets)."<br /><br />";

$html="<table border='1'>";
//for($i=0;$i<count($data->sheets);$i++) // Loop to get all sheets in a file.

for($i=0;$i<= 1;$i++) // Loop to get all sheets in a file.
{	

	if(count($data->sheets[$i]["cells"])>0) // checking sheet not empty
	{
		//echo "Sheet $i:<br /><br />Total rows in sheet $i  ".count($data->sheets[$i]["cells"])."<br />";
		
		
		for($j=3;$j<=count($data->sheets[$i]["cells"]);$j++) // loop used to get each row of the sheet
		{ 
		
			$html.="<tr>";
			for($k=1;$k<=count($data->sheets[$i]["cells"][$j]);$k++) // This loop is created to get data in a table format.
			{
				$html.="<td>";
				$html.=$data->sheets[$i]["cells"][$j][$k];
				$html.="</td>";
				
				
			    $month_plan =  mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][2][5]);
			
			}
			
			$seq_pps1 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][1]);
			$material_no = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][2]);
			$material_desc = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][3]);
			$work_center = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][4]);
			
			$no_t1 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][5]);
			$no_t2 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][6]);
			$no_t3 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][7]);
			$no_t4 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][8]);
			$no_t5 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][9]);
			$no_t6 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][10]);
			$no_t7 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][11]);
			$no_t8 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][12]);
			$no_t9 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][13]);
			$no_t10 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][14]);
			$no_t11 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][15]);
			$no_t12 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][16]);
			$no_t13 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][17]);
			$no_t14 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][18]);
			$no_t15 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][19]);
			$no_t16 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][20]);
			$no_t17 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][21]);
			$no_t18 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][22]);
			$no_t19 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][23]);
			$no_t20 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][24]);
			$no_t21 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][25]);
			$no_t22 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][26]);
			$no_t23 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][27]);
			$no_t24 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][28]);
			$no_t25 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][29]);
			$no_t26 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][30]);
			$no_t27 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][31]);
			$no_t28 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][32]);
			$no_t29 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][33]);
			$no_t30 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][34]);
			$no_t31 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][35]);
			
			//echo $data->sheets[$i]["cells"][$j][2];
				
				
			$html.="</tr>";
			
			//-----insert data to planning-assy_generate
			
			if(($material_no != "") && ($material_no != "0"))
			{
			
			$upload_id = $uid;
			$plant_code = $_POST["plant_code"];
			
			$query_inform = new PreparedSql("SELECT * FROM ftp_pps WHERE upload_id = ?", [$uid]);
			$result_inform = db_query($dbc, $query_inform);
			$data_inform = mysqli_fetch_array($result_inform);
			
			//-----get material detail ------
			$query_mat_info = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ? AND status_BOM = 'Y'", [$material_no]);
			$result_mat_info = db_query($dbc, $query_mat_info);
			$data_mat_info = mysqli_fetch_array($result_mat_info);
			
			//----- checking plant code
			
			if($data_mat_info["plant_code"] != $plant_code)
			 {
				 //------------ delete from ftp_pps ---------------------  
						 
				$query_del_ftp = "DELETE FROM ftp_pps WHERE upload_id = '".sql_esc($uid)."'";
				$result_del_ftp = mysqli_query($dbc,$query_del_ftp); 
				
			   //-------------------------------delete table pps_detail-------------------------------------
				$query_del2_ftp = new PreparedSql("DELETE FROM pps_detail WHERE upload_id = ?", [$uid]);
				$result_del2_ftp =  db_query($dbc, $query_del2_ftp);
		  
			  //------------------------end delete upload table ftp_pps---------------------------------	
				
				//-------------------------------delete table pps_upload-------------------------------------
				$query_del3_ftp = new PreparedSql("DELETE FROM pps_upload WHERE upload_id = ?", [$uid]);
				$result_del3_ftp =  db_query($dbc, $query_del3_ftp);
		  
			  //------------------------end delete upload table pps-upload---------------------------------			
				 
				 //-----------move file or delete----------
				  $extensionV = '.xls';
				  
				  unlink("upload_pps/".$uid.$extensionV); 
			   
				echo "<script>";
                echo "alert('Parts not matched with plant selection. Please try again.');";
                echo "window.location='upload_pps_month-assy.php'";
                echo "</script>";
				exit(); //quit the script
			              		   
			   }
			
			//-----get date plan-------
			
			     $d_plan = substr($month_plan,0,2);
				 $m_plan = substr($month_plan,3,2);
				 $y_plan = substr($month_plan,6,4);
				 
				 $dt_pln = ($y_plan.'-'.$m_plan.'-'.$d_plan);
		
			
			$query_1A = "INSERT INTO plan_assy_generate(id_gen,seq_id,date_start,material_no,material_desc,work_center,no_t1,no_t2,no_t3,no_t4,no_t5,no_t6,no_t7,no_t8,no_t9,no_t10,no_t11,no_t12,no_t13,no_t14,no_t15,no_t16,no_t17,no_t18,no_t19,no_t20,no_t21,no_t22,no_t23,no_t24,no_t25,no_t26,no_t27,no_t28,no_t29,no_t30,no_t31,create_by,date_create,update_by,date_update,status_assy,plant_code,upload_id,file_name,mth_plan,yr_plan) VALUES('','','".sql_esc($dt_pln)."','".sql_esc($material_no)."','".sql_esc($material_desc)."','".sql_esc($data_mat_info["prod_line"])."','".sql_esc($no_t1)."','".sql_esc($no_t2)."','".sql_esc($no_t3)."','".sql_esc($no_t4)."','".sql_esc($no_t5)."','".sql_esc($no_t6)."','".sql_esc($no_t7)."','".sql_esc($no_t8)."','".sql_esc($no_t9)."','".sql_esc($no_t10)."','".sql_esc($no_t11)."','".sql_esc($no_t12)."','".sql_esc($no_t13)."','".sql_esc($no_t14)."','".sql_esc($no_t15)."','".sql_esc($no_t16)."','".sql_esc($no_t17)."','".sql_esc($no_t18)."','".sql_esc($no_t19)."','".sql_esc($no_t20)."','".sql_esc($no_t21)."','".sql_esc($no_t22)."','".sql_esc($no_t23)."','".sql_esc($no_t24)."','".sql_esc($no_t25)."','".sql_esc($no_t26)."','".sql_esc($no_t27)."','".sql_esc($no_t28)."','".sql_esc($no_t29)."','".sql_esc($no_t30)."','".sql_esc($no_t31)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'New','".sql_esc($data_inform["plant_code"])."','".sql_esc($upload_id)."','".sql_esc($data_inform["file_name"])."','".sql_esc($m_plan)."','".sql_esc($y_plan)."')";
		$result_1A = mysqli_query($dbc,$query_1A);
		
					
		 $query_update2_V = "UPDATE ftp_pps SET date_plan = '".sql_esc($dt_pln)."' WHERE id_file = '".sql_esc($upload_id)."'";
		 $result_update2_V = mysqli_query($dbc,$query_update2_V); 
					
					
		$query_inform2 = "SELECT * FROM plan_assy_generate WHERE material_no = '".sql_esc($material_no)."' AND upload_id = '".sql_esc($upload_id)."'";
		$result_inform2 = mysqli_query($dbc,$query_inform2);
	    $data_inform2 = mysqli_fetch_array($result_inform2);
	
	   // while($data_inform2 = mysqli_fetch_array($result_inform2))
		//{
			
		include "split_pps_monthly.php";	
			
			
			
			
			
		//}//end while $data_inform2
		
					
					
			} // end if
			
				
		} // for $j
		
		
	} // if count

}  // for $i

$html.="</table>";
//echo $html;


			
//	------ move file to another folder ----------------------------------
			$handle2 = $file;
			$destination = "upload_pps_update/".$file;
			$data = file_get_contents($handle2);

			$handle2 = fopen($destination, "w");
			fwrite($handle2, $data);
			fclose($handle2);
			fclose($handle);
			unlink($file);
			

 //echo "<br />Data Inserted in dababase";

//--------------------------------------------------------------

} // end of foreach filename
			
	        $query_db_pps = "SELECT * FROM pps_upload WHERE status_pps = 'New' AND qty_plan != '0.000'";
			$result_db_pps = mysqli_query($dbc,$query_db_pps);
             
			 while($row_db_pps = mysqli_fetch_array($result_db_pps))
			{
			
			 $Wdesc2 = $row_db_pps["material_no"];
			 
			/*$mon_plan = substr($row_db_pps["month_plan"],5,2);		
			$tahun_plan = substr($row_db_pps["month_plan"],0,4);*/		
			
			 //---- check factory from work center -------// 
			$query_convert = new PreparedSql("SELECT * FROM work_center_detail as SR WHERE SR.id_work = ?", [$row_db_pps["work_center"]]);
			$result_convert = db_query($dbc, $query_convert); 
			$row_convert = mysqli_fetch_array($result_convert);
			
			
			 //----- check material existing in table material ------//
			 
			 $query_chk_mat = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ? AND status_BOM = 'Y'", [$row_db_pps["material_no"]]);
			 $result_chk_mat = db_query($dbc, $query_chk_mat); 
			 $row_chk_mat = mysqli_fetch_array($result_chk_mat);
			 
			 //----check material type -----
			
			 $query_mtype = new PreparedSql("SELECT * FROM material_type_tbl WHERE id = ?", [$row_chk_mat["mat_type"]]);
             $result_mtype = db_query($dbc, $query_mtype) or die (mysqli_error());
             $d_mtype = mysqli_fetch_array($result_mtype);
			 
			   
			   if($row_chk_mat){
				   
				   
				    //---------check shift --------------//
						
				if($row_db_pps["shift_pps1"] != "") 
				{
				
			$query_shift_day1 = "INSERT INTO pps_detail(id,ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,status,user_upload,date_upload,user_create,date_create,user_update,date_update,user_posting,date_posting,user_closed,date_closed,plan_category,id_factory_pps,rev_pps,seq_pps,man_hours,work_hours,plant_code,year_plan,material_type,sloc,remark_closed,type_closed,remark_closed_plan) VALUES('','".sql_esc($row_db_pps["ref_id"])."','','".sql_esc($row_db_pps["upload_id"])."','".sql_esc($row_db_pps["model_code"])."','".sql_esc($row_db_pps["month_plan"])."','".sql_esc($row_db_pps["material_no"])."','".sql_esc($row_db_pps["qty_plan"])."','','New','".sql_esc($row_db_pps["comp_code"])."','".sql_esc($row_db_pps["work_center"])."','D/S','','".sql_esc($row_db_pps["date_plan"])."','Y','".sql_esc($row_db_pps["user_upload"])."','".sql_esc($row_db_pps["date_upload"])."','".sql_esc($row_db_pps["user_create"])."','".sql_esc($row_db_pps["date_create"])."','','','','','','','".sql_esc($row_db_pps["plan_category"])."','".sql_esc($row_convert["id_factory"])."','','".sql_esc($row_db_pps["seq_pps1"])."','','','".sql_esc($row_db_pps["plant_code"])."','".sql_esc($row_db_pps["year_plan"])."','".sql_esc($d_mtype["mat_type_id"])."','".sql_esc($row_chk_mat["sloc"])."','','','')";
		   $result_shift_day1 = mysqli_query($dbc,$query_shift_day1);	
				}
		      
			  if($row_db_pps["shift_pps2"] != "")
				{
				$query_shift_day2 = "INSERT INTO pps_detail(id,ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,status,user_upload,date_upload,user_create,date_create,user_update,date_update,user_posting,date_posting,user_closed,date_closed,plan_category,id_factory_pps,rev_pps,seq_pps,man_hours,work_hours,plant_code,year_plan,material_type,sloc,remark_closed,type_closed,remark_closed_plan) VALUES('','".sql_esc($row_db_pps["ref_id"])."','','".sql_esc($row_db_pps["upload_id"])."','".sql_esc($row_db_pps["model_code"])."','".sql_esc($row_db_pps["month_plan"])."','".sql_esc($row_db_pps["material_no"])."','".sql_esc($row_db_pps["qty_plan"])."','','New','".sql_esc($row_db_pps["comp_code"])."','".sql_esc($row_db_pps["work_center"])."','','N/S','".sql_esc($row_db_pps["date_plan"])."','Y','".sql_esc($row_db_pps["user_upload"])."','".sql_esc($row_db_pps["date_upload"])."','".sql_esc($row_db_pps["user_create"])."','".sql_esc($row_db_pps["date_create"])."','','','','','','','".sql_esc($row_db_pps["plan_category"])."','".sql_esc($row_convert["id_factory"])."','','".sql_esc($row_db_pps["seq_pps2"])."','','','".sql_esc($row_db_pps["plant_code"])."','".sql_esc($row_db_pps["year_plan"])."','".sql_esc($d_mtype["mat_type_id"])."','".sql_esc($row_chk_mat["sloc"])."','','','')";
			$result_shift_day2 = mysqli_query($dbc,$query_shift_day2);		
					
				}
				   
	       
			}else{
				
		
			 $query_mail = "SELECT * FROM login_detail WHERE level_id = '1' AND status = 'AC' ";
			 $result_mail = mysqli_query($dbc,$query_mail);

			 
			 while($row_mail = mysqli_fetch_array($result_mail))
			{
			//Send an email, if desired
				
		   
			$email = $row_mail["user_email"];
			$Uurl = $data_setup['urls_system'];
			
					//------user detail info --------
					
					$query_dtl = new PreparedSql("SELECT * FROM user_detail WHERE staff_ID = ?", [$row_mail["staff_ID"]]);
					$result_dtl = db_query($dbc, $query_dtl);
					$row_dtl = mysqli_fetch_array($result_dtl);
					
					 $Uname = $row_dtl['user_fullname'];
			
			//--------------------------------------------------------
				//body message
				$message = file_get_contents('mat-masterBOM.html'); 
				
				//name
				$message = str_replace('%uname%', $Uname, $message); 
				
				//material desc
				$message = str_replace('%wdesc2%', $Wdesc2, $message); 
				
				//url
				$message = str_replace('%uurl%', $Uurl, $message); 
		
					
				//PHPMailer Object
				$mail = new PHPMailer(); //Argument true in constructor enables exceptions
			
				//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
				$mail->isSMTP();
				$mail->Host       = $data_setup['smtp_account'];              		// Set the SMTP server to send through
				$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
				$mail->Username   = $data_setup['email_account'];         		// SMTP username
				$mail->Password   = $data_setup['passwd'];                // SMTP password
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
				$mail->Port       = $data_setup['port_no'];

				$mail->From = $data_setup['email_account'];
				$mail->FromName = $data_setup['tajuk_sys'];
				
				//To address and name
				$mail->addAddress($email, $row_mail["user_email"]);
				
				//Send HTML or Plain Text email
				$mail->isHTML(true);
			
				$mail->Subject = "PSS Online - Material Master Maintenance";
				$mail->MsgHTML($message);
				
				
				$mail->CharSet="utf-8";
				
				//send the mail
				$mail->send();
			   
				  
			} // end while loop mail	
		
			
		  //-------------------------------delete table ftp_pps-------------------------------------
		    $query_hsekeeping2 = "DELETE FROM ftp_pps WHERE upload_id = '".sql_esc($upload_id)."'";
			$result_hsekeeping2 =  mysqli_query($dbc,$query_hsekeeping2);
	  
		  //------------------------end delete upload table ftp_pps---------------------------------	
		  
		   //-------------------------------delete table pps_detail-------------------------------------
		    $query_hsekeeping3 = new PreparedSql("DELETE FROM pps_detail WHERE upload_id = ?", [$upload_id]);
			$result_hsekeeping3 =  db_query($dbc, $query_hsekeeping3);
	  
		  //------------------------end delete upload table ftp_pps---------------------------------	
			
			//-------------------------------delete table pps_upload-------------------------------------
		    $query_hsekeeping = new PreparedSql("DELETE FROM pps_upload WHERE upload_id = ?", [$upload_id]);
			$result_hsekeeping =  db_query($dbc, $query_hsekeeping);
	  
		  //------------------------end delete upload table pps-upload---------------------------------	
		  
				
			   } //end $row_chk_mat
				
				
		
	
			}// end while loop pps upload
			
			
			
			//----checking have data in pps upload -> proceed to next stage
			$query_db_pps_nxt = "SELECT * FROM pps_upload WHERE status_pps = 'New' and upload_id = '".sql_esc($upload_id)."'";
			$result_db_pps_nxt = mysqli_query($dbc,$query_db_pps_nxt);
			$row_db_pps_nxt = mysqli_fetch_array($result_db_pps_nxt);
	       
		   
		   if($row_db_pps_nxt)
		   {
			   
		  
		   //--------------end transaction upload into table pps_upload------------------------------------//
					
			//----------------- OPEN MODAL ---------------------------//
			/*https://stackoverflow.com/questions/34362470/load-modal-after-form-submit*/
			
			   echo "<script>
				 $(window).load(function(){
					 $('#thankyouModal').modal('show');
				 });
			    </script>";
			
			//-------------------------------delete table pps_upload-------------------------------------
		    $query_hsekeeping_f = new PreparedSql("DELETE FROM pps_upload WHERE upload_id = ?", [$upload_id]);
			$result_hsekeeping_f =  db_query($dbc, $query_hsekeeping_f);
	  
		  //------------------------end delete upload table pps-upload---------------------------------	   
		   
		   }else{
			   
			   
		   //-------------------------------delete table pps_detail-------------------------------------
		    $query_hsekeeping3F = new PreparedSql("DELETE FROM pps_detail WHERE upload_id = ?", [$upload_id]);
			$result_hsekeeping3F =  db_query($dbc, $query_hsekeeping3F);
	  
		  //------------------------end delete upload table ftp_pps---------------------------------	
			
			//-------------------------------delete table pps_upload-------------------------------------
		    $query_hsekeepingF = new PreparedSql("DELETE FROM pps_upload WHERE upload_id = ?", [$upload_id]);
			$result_hsekeepingF =  db_query($dbc, $query_hsekeepingF);
	  
		  //------------------------end delete upload table pps-upload---------------------------------	
		     
			   
			echo "<script>";
		    echo "alert('Error : Please verify the Material No. and update BOM.');";
			echo "window.location='upload_pps_month-assy.php'";
			echo "</script>";	
			exit;        
			   
			   
		   }
	
		 
	
         
           } else {
			
			echo "<script>";
            echo "alert('The document could not be moved.');";
            echo "window.location='upload_pps_month-assy.php'";
            echo "</script>";
			

			   }
			   
			  } else {  //If the query did not run OK
			  
			echo "<script>";
            echo "alert('Your submission could not be processed due to a system error. We apologize for any inconvenience.');";
            echo "window.location='upload_pps_month-assy.php'";
            echo "</script>";
			  
		
				}
				  mysqli_close($dbc);   // close database conn
				
				}
	  
if (isset($message))
{ echo '<div class="alert alert-error">', $message, '</div>';
}
}
?>
      
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title"></h3>
            <div class="tile-body">
            
            
              <form name="form1" action="detail_pps_sheet_printing-assy.php?upload_id=<?php echo $upload_id;?>&&plant_code=<?php echo $row_db_pps_nxt['plant_code']; ?>" method="post" class="form-horizontal">
			<div class="modal fade" id="thankyouModal" tabindex="-1" role="dialog">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					  
				  </div>
				  <div class="modal-body">
				  	<h4 class="modal-title">&nbsp;Are you sure?</h4>
                 
	                  <input type="hidden" name="upload_id" value="<?php echo $upload_id; ?>">   
					  <input name="submit3Assy" type="submit" id="submit3Assy" value="PROCEED" class="btn btn-success">
       				  <input name="submit9Assy" type="submit" id="submit9Assy" class="btn btn-warning" value="CANCEL">   
					<!--  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> -->
                      
                          
				  </div>    
				</div>
			  </div>
			</div>
		</form>
			
            
            
            
            
            
            
            <font color="#FF0000"><b>  * Compulsory field</b></font><br>
              <form name="form1" enctype="multipart/form-data" action="upload_pps_month-assy.php" method="post" class="form-horizontal">
        <input type="hidden" name="MAX_FILE_SIZE" value="1024000000000">
                 <div class="form-group row">
                  <label class="control-label col-md-3">Plant :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-4">
                   <select name="plant_code" id="plant_code" class="form-control">
                  <option value="NULL" placeholder="Select Plant"> -- Select Plant --</option>
                  <?php
	               $query19 = "SELECT * FROM plant_detail WHERE status_plant = 'Y' ORDER BY plant_id ASC";
                   $result19 = mysqli_query($dbc,$query19);
  
                   while($row19 = mysqli_fetch_array($result19)) 
			      {
				   ?>
                     <option value="<?php echo $row19["plant_code"]; ?>"> <?php echo $row19["plant_code"]; ?> - <?php echo $row19["plant_desc"]; ?></option>
                
                  <?php
                  }
				?>
              </select>
                     <div class="form-control-feedback" ><?php echo $message_pcode; ?></div>
                </div>
              </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Upload File : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-4">
                    <input name="upload" type="file" class="form-control-file" value="<?php if(isset($_POST['upload'])) echo $_POST['upload']; ?>" maxlength="200" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" /> 
                   <p>File must be less than 5MB.</br>
                     Allowed file type : MS Excel (Format file .xls)</p>
                   <div class="form-control-feedback" ><?php echo $message_file; ?></div>
                    </div>
                </div>
               
              <div class="form-group row">
                  <label class="control-label col-md-3"></label>
                    <div class="col-md-8">
                  &nbsp;
                </div>
              </div>
              
                <div class="form-group col-md-8 align-self-end">
                
            <!--   <button type="button" name="btn_release" id="btn_release" class="btn btn-success btn-sm btn_release">SUBMIT</button>-->
               <input name="submitCT" type="submit" id="submit" value="SUBMIT" class="btn btn-primary">
          
           <!--  <a class="btn btn-info" id="demoSwal" href="#">Sample Alert</a>-->
             
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
    <!-- Data table plugin-->
    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
    
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-notify.min.js"></script>
    <script type="text/javascript" src="js/plugins/sweetalert.min.js"></script>
    <script type="text/javascript">
      $('#demoNotify').click(function(){
      	$.notify({
      		title: "Update Complete : ",
      		message: "Something cool is just updated!",
      		icon: 'fa fa-check' 
      	},{
      		type: "info"
      	});
      });
      $('#demoSwal').click(function(){
      	swal({
      		title: "Are you sure?",
      		text: "You will not be able to recover this imaginary file!",
      		type: "warning",
      		showCancelButton: true,
      		confirmButtonText: "Yes, delete it!",
      		cancelButtonText: "No, cancel plx!",
      		closeOnConfirm: false,
      		closeOnCancel: false
      	}, 
		
		function(isConfirm) {
      		if (isConfirm) {  
      			swal("HEllo", "Your imaginary file has been deleted.", "success");
				//console.log('This was logged in the callback: ' + result);
			    location.href = this.$target.attr('href');
			
				
				
						
      		} else {
      			swal("Cancelled", "Your imaginary file is safe :)", "error");
      		}
      	});
      });
    </script>		
				
     <script type="text/javascript">
     
		  
      $('#PlanDate').datepicker({
	    defaultDate: new Date(),
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
      
	   $('#Plan2Date').datepicker({
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      $('#demoSelect').select2();
    </script>
 <script>
$('.btn_release').on('click',function(){
    $('.modal-body').load('dash_brdprod.php',function(){
        $('#myModal').modal({show:true});
    });
});
</script>
  
  
  
  </body>
</html>