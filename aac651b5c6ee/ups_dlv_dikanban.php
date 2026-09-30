<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.7.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
//include '../include/config_mail.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));

                 $drun = substr($fmt_curr_date,0,2);
				 $mrun = substr($fmt_curr_date,3,2);
				 $yrun = substr($fmt_curr_date,8,2);
				 
				 $date_run = ($drun.$mrun.$yrun);

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
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
//--------menu function ------------------------------

$query_function = new PreparedSql("SELECT * FROM function_acc_detail WHERE staff_ID = ?", [$res["staff_ID"]]);
$result_function = db_query($dbc, $query_function);   //run the query.
$data_function = mysqli_fetch_array($result_function);   //how many records are there?  
//----------------------------------------------------	
	
$url = "ups_dlv_dikanban.php"; 


//----------------------------------------------------

//CR status (New)

$sta = "SELECT * from request_status WHERE status_id = '1'";
$sta_res = mysqli_query($dbc,$sta);
$rst_sta = mysqli_fetch_array($sta_res);

//CR status (Released)
$sta2 = "SELECT * from request_status WHERE status_id = '2'";
$sta_res2 = mysqli_query($dbc,$sta2);
$rst_sta2 = mysqli_fetch_array($sta_res2);


//CR status (Approved)
$sta3 = "SELECT * from request_status WHERE status_id = '3'";
$sta_res3 = mysqli_query($dbc,$sta3);
$rst_sta3 = mysqli_fetch_array($sta_res3);

//CR status (Cancelled)
$sta4 = "SELECT * from request_status WHERE status_id = '4'";
$sta_res4 = mysqli_query($dbc,$sta4);
$rst_sta4 = mysqli_fetch_array($sta_res4);

//CR status (Rejected)
$sta5 = "SELECT * from request_status WHERE status_id = '5'";
$sta_res5 = mysqli_query($dbc,$sta5);
$rst_sta5 = mysqli_fetch_array($sta_res5);

//CR status (Draft)
$sta6 = "SELECT * from request_status WHERE status_id = '6'";
$sta_res6 = mysqli_query($dbc,$sta6);
$rst_sta6 = mysqli_fetch_array($sta_res6);

//CR status (In Progress)
$sta7 = "SELECT * from request_status WHERE status_id = '7'";
$sta_res7 = mysqli_query($dbc,$sta7);
$rst_sta7 = mysqli_fetch_array($sta_res7);

//CR status (Pending)
$sta8 = "SELECT * from request_status WHERE status_id = '8'";
$sta_res8 = mysqli_query($dbc,$sta8);
$rst_sta8 = mysqli_fetch_array($sta_res8);

//CR status (Closed)
$sta13 = "SELECT * from request_status WHERE status_id = '13'";
$sta_res13 = mysqli_query($dbc,$sta13);
$rst_sta13 = mysqli_fetch_array($sta_res13);

//CR status (Completed)
$sta14 = "SELECT * from request_status WHERE status_id = '14'";
$sta_res14 = mysqli_query($dbc,$sta14);
$rst_sta14 = mysqli_fetch_array($sta_res14);

//CR status (Deleted)
$sta16 = "SELECT * from request_status WHERE status_id = '16'";
$sta_res16 = mysqli_query($dbc,$sta16);
$rst_sta16 = mysqli_fetch_array($sta_res16);

//CR status (Transfer Posting)
$sta19 = "SELECT * from request_status WHERE status_id = '19'";
$sta_res19 = mysqli_query($dbc,$sta19);
$rst_sta19 = mysqli_fetch_array($sta_res19);

//CR status (Cancel)
$sta21 = "SELECT * from request_status WHERE status_id = '21'";
$sta_res21 = mysqli_query($dbc,$sta21);
$rst_sta21 = mysqli_fetch_array($sta_res21);

//CR status (Close)
$sta22 = "SELECT * from request_status WHERE status_id = '22'";
$sta_res22 = mysqli_query($dbc,$sta22);
$rst_sta22 = mysqli_fetch_array($sta_res22);



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
          <h1><i class="fa fa-truck"></i> Delivery Instruction</h1>
          <p>Upload DI/Kanban</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"> Delivery Instruction</li>
          <li class="breadcrumb-item"><a href="ups_dlv_dikanban.php">Upload DI/Kanban</a></li>
        </ul>
      </div> 
           
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

if(isset($_POST['submitKanb'])) 
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
 $checkA = $_POST['checkA'];
 
 
 //echo $checkA;
 
   //-------------------generate Delivery Instruction doc no. ---------------
	
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '143'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	if($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 00000; 
	$dht_OK2 = "53";
	$dg2 = 0;

  	if($row_id2["count_max"] <= 0)
  	{ 
   
    	$lastID2 = ($row_id2["count_max"] + 1);
    	$dg2 = ($dht2 + ($lastID2));
   }
   else
   {
      $lastID2 = ($row_id2["count_max"] + 1);
      $dg2 =  $lastID2;
	
    }
	$number2 = $dg2; // Length of running no
    $number2 = sprintf('%07d', $number2);  
	
    $ref = (($row_id2["start_ref"]).$dht_OK2.($number2));
	  
	
	} // end if $result_id2
	
 
 
 
 
			 
          //check file name duplicate-----
 
           /* $query_chk_attach4 = "SELECT * FROM ftp_dikanban WHERE file_name = '".$_FILES["upload"]["name"]."'";
            $result_chk_attach4 = mysqli_query($dbc,$query_chk_attach4);   //run the query.
            $data_chk_attach4 = mysqli_fetch_array($result_chk_attach4);   //how many records are there?   
			 
			 if($data_chk_attach4 >= 1 )
			 {
			   
				echo "<script>";
                echo "alert('File already exist or rename file then upload.');";
                echo "window.location='ups_dlv_dikanban.php'";
                echo "</script>";
				exit(); //quit the script
			              		   
			   }*/
  
// check for a upload file
 if($_FILES['upload']['size'] == 0 || empty($_FILES['upload']['tmp_name']))
  { 
 
  $upload = FALSE;
  
            echo "<script>";
            echo "alert('You are required to select Upload File! ');";
            echo "window.location='ups_dlv_dikanban.php'";
            echo "</script>"; 
  
  
  }	 
 elseif(!in_array($fileType, $allowed)) 
	{
  		$upload = FALSE;
		   
		    echo "<script>";
            echo "alert('Only EXCEL files are allowed. ');";
            echo "window.location='ups_dlv_dikanban.php'";
            echo "</script>"; 
		
		
	
	} 
	


	  
	   if(($_FILES['upload']['type']) != "application/vnd.ms-excel" )
	  { 
	  
	     $upload = FALSE;
	 
			echo "<script>";
            echo "alert('The document could not be moved.  File incorrect ');";
            echo "window.location='ups_dlv_dikanban.php'";
            echo "</script>"; 
	  
	  }
	  
  
  if($_FILES['upload']['size'] > 0 && $upload) //everything ok
 {  	
   
  $checkA = $_POST['checkA'];

   
	   //Add the record to the database
	   
	    $query = "INSERT INTO ftp_dikanban(upload_id,id_file,file_name,file_size,file_type,date_plan,user_upload,date_upload,user_update,date_update,comp_code,plant_code) VALUES('','','".sql_esc($_FILES['upload']['name'])."','".sql_esc($_FILES['upload']['size'])."','".sql_esc($_FILES['upload']['type'])."','','".sql_esc($username)."',NOW(),'','','".sql_esc($data_setup["comp_code"])."','3100')";
	   $result = mysqli_query($dbc,$query);   
	   
	  
	   if($result) {
	   //create the filename
	     $extension = explode ('.', $_FILES['upload']['name']);
		 $uid2 = mysqli_insert_id($dbc);  //upload ID
	
		 $filename = $uid2 .'.'.$extension[1];
		 
		 
		    $query_update2 = "UPDATE ftp_dikanban SET id_file = '".sql_esc($uid2)."' WHERE upload_id = '".sql_esc($uid2)."'";
			$result_update2 = mysqli_query($dbc,$query_update2);   
		 
		 
	 if(move_uploaded_file($_FILES['upload']['tmp_name'], "upload_dikanban/$filename"))  {
		 
		 
		ini_set("display_errors",0);
        require_once "excel_reader2.php"; 
		 
		 
		 set_time_limit(0);


//-----------------upload file into table pps_upload------------------------//
	
	foreach (glob("upload_dikanban/*.xls") as $filename) 
{ 
  
	$file = $filename;
	
	//echo $file."<br>"; 

    $data = new Spreadsheet_Excel_Reader($file);

             
			//------------------end 2nd upload checking---------------------------


$html="<table border='1'>";
//for($i=0;$i<count($data->sheets);$i++) // Loop to get all sheets in a file.

for($i=0;$i<= 1;$i++) // Loop to get all sheets in a file.
{	

	if(count($data->sheets[$i]["cells"])>0) // checking sheet not empty
	{
		//echo "Sheet $i:<br /><br />Total rows in sheet $i  ".count($data->sheets[$i]["cells"])."<br />";
		
		
		for($j=30;$j<=count($data->sheets[$i]["cells"]);$j++) // loop used to get each row of the sheet
		{ 
		
			$html.="<tr>";
			for($k=4;$k<=count($data->sheets[$i]["cells"][$j]);$k++) // This loop is created to get data in a table format.
			{
				$html.="<td>";
				$html.=$data->sheets[$i]["cells"][$j][$k];
				$html.="</td>";
				
				
			    $month_plan =  mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][9][20]);
			  
				$vc_code = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][11][4]);
				$po_no = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][10][20]);
				$model_cd = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][24][5]);
				$date_dlv2 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][25][20]);
				$time_dlv2 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][26][20]);
				
				
				
				 //------checking string date betul------------//
         $str = $date_dlv2;
         $st_datedlv2 = strlen($str);

         $str2 = $month_plan;
         $st_monthplan = strlen($str2);
   
   
          if(($st_datedlv2 != '10') || ($st_monthplan != '10'))
         {

          unlink($file);
   
           echo "<script>";
           echo "alert('The document could not be upload.  Date Delivery or Date Issue Problem.');";
           echo "window.location='ups_dlv_dikanban.php'";
           echo "</script>"; 
           exit(); //quit the script
     
   
         } 
				
				
				
			}
			
			
			$material_no = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][5]);
			$material_desc = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][7]);
			$work_center = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][14]);
			$seq_pps1 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][4]);
			$usage_kbn = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][13]);
			
			$kanban_order = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][15]);
			$tbox_kanban = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][16]);
			$std_package = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][14]);
      $rmk_loc = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][21]);
			
			
			//echo $data->sheets[$i]["cells"][$j][2];
				
				
			$html.="</tr>";
			
			//-----insert data to planning-assy_generate
			
			if(($kanban_order != "") && ($kanban_order != "0"))
			{
			
			$upload_id = $uid2;
			$checkA = $_POST['checkA'];
			
			$query_inform = "SELECT * FROM ftp_dikanban WHERE upload_id = '".sql_esc($uid2)."'";
			$result_inform = mysqli_query($dbc,$query_inform);
			$data_inform = mysqli_fetch_array($result_inform);
			
			
			//---- checking vendor code -------
			
			/*$query_chk_vcode = "SELECT * FROM vendor_detail WHERE status_acc = 'Y'";
			$result_chk_vcode = mysqli_query($dbc,$query_chk_vcode);
			$data_chk_vcode = mysqli_fetch_array($result_chk_vcode);
			
			if(($vc_code) == ($data_chk_vcode["vendor_code"]))
			{
				
			}else{
			
			echo "<script>";
            echo "alert('The document could not be moved.  Please check Vendor Profile. ');";
            echo "window.location='ups_dlv_dikanloadban.php'";
            echo "</script>"; 
				
			}*/
			
			 //--------- Disposal QC detail ------------
	 /*
	   $query_info5A = "SELECT * FROM dlv_dikanban_upload WHERE upload_id = '".$uid2."'";
	   $result_info5A = mysqli_query($dbc,$query_info5A);
	  
	  while($data_info5A = mysqli_fetch_array($result_info5A))
	  {
		  
		  
		  
    if($data_info5A["std_package"] == "")
   {
	   
	$var_packA = $data_info5A["std_ups_package"];   
	   
   }elseif($data_info5A["std_package"] != "")
   {
	   
	$var_packA = $data_info5A["std_package"];     
	   
   }else{
	   
	  $var_packA = ""; 
   }

				
			
			'".$data_mat_info["std_packaging"]."'
			*/
			
			
	
			   
			   //-----get material detail ------
			$query_mat_info = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ? AND status_BOM = 'Y'", [$material_no]);
			$result_mat_info = db_query($dbc, $query_mat_info);
			$data_mat_info = mysqli_fetch_array($result_mat_info);
			   
			 //-----get date plan-------
			
			     $d_plan = substr($month_plan,0,2);
				 $m_plan = substr($month_plan,3,2);
				 $y_plan = substr($month_plan,6,4);
				 
				 $dt_pln = ($y_plan.'-'.$m_plan.'-'.$d_plan);  
				 
			  //----get date delivery -----
				 $d_dlv = substr($date_dlv2,0,2);
				 $m_dlv = substr($date_dlv2,3,2);
				 $y_dlv = substr($date_dlv2,6,4);
				 
				 $dt_dlv = ($y_dlv.'-'.$m_dlv.'-'.$d_dlv);  
				 
			//---  test run -------   
			if($_POST['checkA'] == "")
			{
			
		$query_1AD = "INSERT INTO dlv_dikanban_upload(id_gen,back_no,vc_code,date_issue,po_no,date_dlv,time_dlv,material_no,material_desc,work_center,usage_kanban,std_package,std_ups_package,kanban_order,tbox_kanban,model_cd,uom_dlv,create_by,date_create,update_by,date_update,status_kanban,plant_code,upload_id,file_name,mth_plan,yr_plan,remark) VALUES('','".sql_esc($seq_pps1)."','".sql_esc($vc_code)."','".sql_esc($dt_pln)."','".sql_esc($po_no)."','".sql_esc($dt_dlv)."','".sql_esc($time_dlv2)."','".sql_esc($material_no)."','".sql_esc($data_mat_info["material_desc"])."','".sql_esc($data_mat_info["prod_line"])."','".sql_esc($usage_kbn)."','".sql_esc($data_mat_info["std_packaging"])."','".sql_esc($std_package)."','".sql_esc($kanban_order)."','".sql_esc($tbox_kanban)."','".sql_esc($model_cd)."','".sql_esc($data_mat_info["BUn"])."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'".sql_esc($rst_sta["status_desc"])."','".sql_esc($data_inform["plant_code"])."','".sql_esc($upload_id)."','".sql_esc($data_inform["file_name"])."','".sql_esc($m_plan)."','".sql_esc($y_plan)."','".sql_esc($rmk_loc)."')";
		$result_1AD = mysqli_query($dbc,$query_1AD);	 
		
		   //------ kena insert dlv_dikanban_generate $ref -----
		 $last_id = mysqli_insert_id($dbc);
		 

		$query_generate = "INSERT INTO dlv_dikanban_generate(id,id_gen,DI_doc,back_no,vc_code,date_issue,po_no,date_dlv,time_dlv,material_no,material_desc,work_center,usage_kanban,std_package,std_ups_package,kanban_order,qty_dlv,qty_pending,tbox_kanban,model_cd,uom_dlv,shift_dlv,user_posting,date_posting,time_posting,create_by,date_create,update_by,date_update,status_kanban,plant_code,upload_id,file_name,mth_plan,yr_plan,status_DO,do_no,user_posting_do,date_posting_do,time_posting_do,ref_DI_doc,user_cancel,date_cancel,remark_cancel,DI_dlv_date,DI_dlv_time,SAP_ref_doc,SAP_ref_doc_can,remark) VALUES('','".sql_esc($last_id)."','".sql_esc($ref)."','".sql_esc($seq_pps1)."','".sql_esc($vc_code)."','".sql_esc($dt_pln)."','".sql_esc($po_no)."','".sql_esc($dt_dlv)."','".sql_esc($time_dlv2)."','".sql_esc($material_no)."','".sql_esc($data_mat_info["material_desc"])."','".sql_esc($data_mat_info["prod_line"])."','".sql_esc($usage_kbn)."','".sql_esc($std_package)."','".sql_esc($std_package)."','".sql_esc($kanban_order)."','','','".sql_esc($tbox_kanban)."','".sql_esc($model_cd)."','".sql_esc($data_mat_info["BUn"])."','','".sql_esc($username)."',NOW(),NOW(),'".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'".sql_esc($rst_sta["status_desc"])."','".sql_esc($data_inform["plant_code"])."','".sql_esc($upload_id)."','".sql_esc($data_inform["file_name"])."','".sql_esc($m_plan)."','".sql_esc($y_plan)."','".sql_esc($rst_sta["status_desc"])."','','','','','','','','','','','','','".sql_esc($rmk_loc)."')";
		$result_generate = mysqli_query($dbc,$query_generate);
		 
		  //----- doc no generate ---- 

 //-----------------------------------------------------//
  //-----    Print Tag generate after submit 29.03.2023--//
  //-----------------------------------------------------//

  $query_all2 = "SELECT * FROM dlv_dikanban_generate WHERE id = '".mysqli_insert_id($dbc)."' AND status_kanban = '".sql_esc($rst_sta["status_desc"])."'";
  $result_all2 = mysqli_query($dbc,$query_all2);
  $data_all2 = mysqli_fetch_array($result_all2);
  
  $dl_qty = (intval($data_all2["kanban_order"]));
  

  //---- size dim table_material_itsb --------------
  $query_pack2 = "SELECT std_packaging, type_package, size_dim FROM table_material_itsb WHERE material_no = '".sql_esc($data_all2["material_no"])."'";
  $result_pack2 = mysqli_query($dbc,$query_pack2);
  $data_pack2 = mysqli_fetch_array($result_pack2);
  
  //----detail standard packaging [ambil dari table mat_master_header]
  
  $query_pack = "SELECT * FROM dlv_dikanban_generate WHERE id = '".sql_esc($data_all2["id"])."' AND DI_doc = '".sql_esc($ref)."'";
  $result_pack = mysqli_query($dbc,$query_pack);
  $data_pack = mysqli_fetch_array($result_pack);
  
  
  
  if (($data_all2["std_ups_package"] == "")) {
  
      $st_pack = (intval($data_all2["kanban_order"]));

  }elseif (($data_all2["std_package"] == "") && ($data_all2["std_ups_package"] == "")) {
  
      $st_pack = (intval($data_all2["kanban_order"]));

  }else{
  
     $st_pack = $data_all2["std_package"];
    
  }
  

  $no_tg = "";
  
  $bil_tag = (($dl_qty) / ($st_pack));
  
  $b =  intval($bil_tag);  // genapkan value yg dibahagikan utk didarabkan 
 
  // $b = round($bil_tag, 0, PHP_ROUND_HALF_DOWN);  // genapkan value yg dibahagikan utk didarabkan 
  $last_tag = ($bil_tag - $b);	   // sekiranya masih ada baki utk keluarkn delivery tag yg last
  
  $bil_tag2 = ($st_pack * $b);
  
  if ($dl_qty < ($st_pack)) {
      $bil_tag3A = ($dl_qty);
  } else {
      $bil_tag3A =  ($dl_qty - $bil_tag2);  //quantity delivery tag yg last
  }
  
  if ($b == 1) {
      $no_tg = 1;
  } elseif ($last_tag == 0) {
      $no_tg = $b;
  } else {
      $no_tg = ($b + 1);
  }
  
  $w = 1;
  
  for ($m = 1; $m <= $bil_tag; $m++) {
      $bil_tag_newA = (($dl_qty) / ($st_pack));
  
      if (($bil_tag_newA > '1.000') && ($bil_tag_newA < '1.999')) {

  
          $query_tag3B = "INSERT INTO print_tag_do_dikanban(id_tag,tag_no,id_do,do_no,DI_doc,back_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_DO,yr_gr,slip_no,total_slip,date_dlv,time_dlv,supp_do,supp_part_no,rmk_loc) VALUES('','','".sql_esc($data_all2["id"])."','".sql_esc($data_all2["do_no"])."','".sql_esc($data_all2["DI_doc"])."','".sql_esc($data_all2["back_no"])."','".sql_esc($data_all2["plant_code"])."','".sql_esc($data_all2["po_no"])."','".sql_esc($data_all2["vc_code"])."','','".sql_esc($data_all2["material_no"])."','".sql_esc($data_all2["material_desc"])."','".sql_esc($data_pack2["size_dim"])."','".sql_esc($data_all2["model_cd"])."','".sql_esc($data_all2["uom_dlv"])."','".sql_esc($st_pack)."','".sql_esc($data_all2["shift_dlv"])."','','','".sql_esc($data_all2["user_posting"])."','".sql_esc($data_all2["date_posting"])."','".sql_esc($data_all2["time_posting"])."','".strtoupper($username)."',NOW(),'Y','N','".sql_esc($data_all2["status_DO"])."',NOW(),'".sql_esc($w)."','2','".sql_esc($data_all2["date_dlv"])."','".sql_esc($data_all2["time_dlv"])."','".sql_esc($data_all2["supp_do"])."','".sql_esc($data_all2["supp_part_no"])."','".sql_esc($data_all2["remark"])."')";
          $result_tag3B = mysqli_query($dbc,$query_tag3B);
  
          $tag_no3B = ($data_all2["DI_doc"].'/'.$w.'/'.$data_pack["std_package"].'/'.$no_tg);
  
  
          $query_tag3_t = "UPDATE print_tag_do_dikanban SET tag_no = '".sql_esc($tag_no3B)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND DI_doc = '".sql_esc($ref)."'";
          $result_tag3_t = mysqli_query($dbc,$query_tag3_t);
     
        }else{
  
  
          $query_tag3B = "INSERT INTO print_tag_do_dikanban(id_tag,tag_no,id_do,do_no,DI_doc,back_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_DO,yr_gr,slip_no,total_slip,date_dlv,time_dlv,supp_do,supp_part_no,rmk_loc) VALUES('','','".sql_esc($data_all2["id"])."','".sql_esc($data_all2["do_no"])."','".sql_esc($data_all2["DI_doc"])."','".sql_esc($data_all2["back_no"])."','".sql_esc($data_all2["plant_code"])."','".sql_esc($data_all2["po_no"])."','".sql_esc($data_all2["vc_code"])."','','".sql_esc($data_all2["material_no"])."','".sql_esc($data_all2["material_desc"])."','".sql_esc($data_pack2["size_dim"])."','".sql_esc($data_all2["model_cd"])."','".sql_esc($data_all2["uom_dlv"])."','".sql_esc($st_pack)."','".sql_esc($data_all2["shift_dlv"])."','','','".sql_esc($data_all2["user_posting"])."','".sql_esc($data_all2["date_posting"])."','".sql_esc($data_all2["time_posting"])."','".strtoupper($username)."',NOW(),'Y','N','".sql_esc($data_all2["status_DO"])."',NOW(),'".sql_esc($w)."','".sql_esc($no_tg)."','".sql_esc($data_all2["date_dlv"])."','".sql_esc($data_all2["time_dlv"])."','".sql_esc($data_all2["supp_do"])."','".sql_esc($data_all2["supp_part_no"])."','".sql_esc($data_all2["remark"])."')";
          $result_tag3B = mysqli_query($dbc,$query_tag3B);
  
          $tag_no3B = ($data_all2["DI_doc"].'/'.$w.'/'.$data_pack["std_package"].'/'.$no_tg);
  
  
          $query_tag3_t = "UPDATE print_tag_do_dikanban SET tag_no = '".sql_esc($tag_no3B)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND DI_doc = '".sql_esc($ref)."'";
          $result_tag3_t = mysqli_query($dbc,$query_tag3_t);
      }
  
      $w++;
  } // end for loop
  
  if (($last_tag > 0.000) || ($dl_qty < ($st_pack))) // kalau qty lebih kecil drpd std packaging and baki drpd bahagi tag
  {
  
      $bil_tag_new = (($dl_qty) / ($st_pack));
  
  
      if (($bil_tag_new > '1.000') && ($bil_tag_new < '1.999')) {
  
          $query_tag2 = "INSERT INTO print_tag_do_dikanban(id_tag,tag_no,id_do,do_no,DI_doc,back_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_DO,yr_gr,slip_no,total_slip,date_dlv,time_dlv,supp_do,supp_part_no,rmk_loc) VALUES('','','".sql_esc($data_all2["id"])."','".sql_esc($data_all2["do_no"])."','".sql_esc($data_all2["DI_doc"])."','".sql_esc($data_all2["back_no"])."','".sql_esc($data_all2["plant_code"])."','".sql_esc($data_all2["po_no"])."','".sql_esc($data_all2["vc_code"])."','','".sql_esc($data_all2["material_no"])."','".sql_esc($data_all2["material_desc"])."','".sql_esc($data_pack2["size_dim"])."','".sql_esc($data_all2["model_cd"])."','".sql_esc($data_all2["uom_dlv"])."','".sql_esc($bil_tag3A)."','".sql_esc($data_all2["shift_dlv"])."','','','".sql_esc($data_all2["user_posting"])."','".sql_esc($data_all2["date_posting"])."','".sql_esc($data_all2["time_posting"])."','".strtoupper($username)."',NOW(),'Y','N','".sql_esc($data_all2["status_DO"])."',NOW(),'".sql_esc($w)."','2','".sql_esc($data_all2["date_dlv"])."','".sql_esc($data_all2["time_dlv"])."','".sql_esc($data_all2["supp_do"])."','".sql_esc($data_all2["supp_part_no"])."','".sql_esc($data_all2["remark"])."')";
          $result_tag2 = mysqli_query($dbc,$query_tag2);
  
  
          $tag_no2 = ($data_all2["DI_doc"].'/'.$w.'/'.$bil_tag3A.'/'.($b + 1));
  
          $query_tag2_t = "UPDATE print_tag_do_dikanban SET tag_no = '".sql_esc($tag_no2)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND DI_doc = '".sql_esc($ref)."'";
          $result_tag2_t = mysqli_query($dbc,$query_tag2_t);
      } else {
  
  
          $query_tag2 = "INSERT INTO print_tag_do_dikanban(id_tag,tag_no,id_do,do_no,DI_doc,back_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_DO,yr_gr,slip_no,total_slip,date_dlv,time_dlv,supp_do,supp_part_no,rmk_loc) VALUES('','','".sql_esc($data_all2["id"])."','".sql_esc($data_all2["do_no"])."','".sql_esc($data_all2["DI_doc"])."','".sql_esc($data_all2["back_no"])."','".sql_esc($data_all2["plant_code"])."','".sql_esc($data_all2["po_no"])."','".sql_esc($data_all2["vc_code"])."','','".sql_esc($data_all2["material_no"])."','".sql_esc($data_all2["material_desc"])."','".sql_esc($data_pack2["size_dim"])."','".sql_esc($data_all2["model_cd"])."','".sql_esc($data_all2["uom_dlv"])."','".sql_esc($bil_tag3A)."','".sql_esc($data_all2["shift_dlv"])."','','','".sql_esc($data_all2["user_posting"])."','".sql_esc($data_all2["date_posting"])."','".sql_esc($data_all2["time_posting"])."','".strtoupper($username)."',NOW(),'Y','N','".sql_esc($data_all2["status_DO"])."',NOW(),'".sql_esc($w)."','".sql_esc($no_tg)."','".sql_esc($data_all2["date_dlv"])."','".sql_esc($data_all2["time_dlv"])."','".sql_esc($data_all2["supp_do"])."','".sql_esc($data_all2["supp_part_no"])."','".sql_esc($data_all2["remark"])."')";
          $result_tag2 = mysqli_query($dbc,$query_tag2);
  
  
          $tag_no2 = ($data_all2["DI_doc"].'/'.$w.'/'.$bil_tag3A.'/'.($b + 1));
  
          $query_tag2_t = "UPDATE print_tag_do_dikanban SET tag_no = '".sql_esc($tag_no2)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND DI_doc = '".sql_esc($ref)."'";
          $result_tag2_t = mysqli_query($dbc,$query_tag2_t);
      }
  } // end if
  




 





















		   
			}else{
				
	
				
		$query_1AD = "INSERT INTO dlv_dikanban_upload(id_gen,back_no,vc_code,date_issue,po_no,date_dlv,time_dlv,material_no,material_desc,work_center,usage_kanban,std_package,std_ups_package,kanban_order,tbox_kanban,model_cd,uom_dlv,create_by,date_create,update_by,date_update,status_kanban,plant_code,upload_id,file_name,mth_plan,yr_plan,remark) VALUES('','".sql_esc($seq_pps1)."','".sql_esc($vc_code)."','".sql_esc($dt_pln)."','".sql_esc($po_no)."','".sql_esc($dt_dlv)."','".sql_esc($time_dlv2)."','".sql_esc($material_no)."','".sql_esc($data_mat_info["material_desc"])."','".sql_esc($data_mat_info["prod_line"])."','".sql_esc($usage_kbn)."','".sql_esc($data_mat_info["std_packaging"])."','".sql_esc($std_package)."','".sql_esc($kanban_order)."','".sql_esc($tbox_kanban)."','".sql_esc($model_cd)."','".sql_esc($data_mat_info["BUn"])."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'".sql_esc($rst_sta6["status_desc"])."','".sql_esc($data_inform["plant_code"])."','".sql_esc($upload_id)."','".sql_esc($data_inform["file_name"])."','".sql_esc($m_plan)."','".sql_esc($y_plan)."','".sql_esc($rmk_loc)."')";
		$result_1AD = mysqli_query($dbc,$query_1AD);	 		
				
		
		




		
				
			}
	
		
					
		 $query_update2_V = "UPDATE ftp_dikanban SET date_plan = '".sql_esc($dt_pln)."' WHERE id_file = '".sql_esc($upload_id)."'";
		 $result_update2_V = mysqli_query($dbc,$query_update2_V); 
		 
	
	 // ---------update dlv_dikanban_upload--------------------------
	 
	 if($_POST['checkA'] == "")
	{
	 
	$query_LevelA = "UPDATE dlv_dikanban_upload SET status_kanban = '".sql_esc($rst_sta3["status_desc"])."' WHERE upload_id = '".sql_esc($upload_id)."' ";
	$result_LevelA = mysqli_query($dbc,$query_LevelA);
	
	}
				
				
				
					
					
			} // end if
			
				
		} // for $j
		
		
	} // if count

}  // for $i

$html.="</table>";
//echo $html;


			
//	------ move file to another folder ----------------------------------
			$handle2 = $file;
			$destination = "upload_dikanban_upd/".$file;
			$data = file_get_contents($handle2);

			$handle2 = fopen($destination, "w");
			fwrite($handle2, $data);
			fclose($handle2);
			fclose($handle);
			unlink($file);
			

 //echo "<br />Data Inserted in dababase";

//--------------------------------------------------------------

} // end of foreach filename
			
	     
						 //---  test run -------   
							if($_POST['checkA'] == "")
							{
						 
						 
	 //update count_max----------------------------------------

  
       $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '143'";
	     $result_max_a = mysqli_query($dbc,$query_max_a);
	   
	
  //end update count_max ---------------------------------				 
						 
	
 
$ref2 = base64_encode($ref);
 
 echo "<script>";
 echo "alert('Delivery Instruction No. $ref.');";
 echo "window.open('detail_print_DIupload-tag.php?buid=$ref2');";
 echo "window.location='ups_dlv_dikanban.php'";
 echo "</script>";
 exit(); //quit the script
 

							
							}else{
							
							$ups_id = base64_encode($upload_id);
								
							echo "<script>";
							//echo "alert('Draft.');";
							echo "window.location='detail_dlv_dikanban.php?upload_id=$ups_id'";
							echo "</script>";	
								
								
								
							}
	
         
           } else {
			
		      	echo "<script>";
            echo "alert('The document could not be moved.');";
            echo "window.location='ups_dlv_dikanban.php'";
            echo "</script>";
			

			   }
			   
			  } else {  //If the query did not run OK
			  
			      echo "<script>";
            echo "alert('Your submission could not be processed due to a system error. We apologize for any inconvenience.');";
            echo "window.location='ups_dlv_dikanban.php'";
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
            
     
            
            <font color="#FF0000"><b>  * Compulsory field</b></font><br>
              <form name="form1" enctype="multipart/form-data" action="ups_dlv_dikanban.php" method="post" class="form-horizontal">
        <input type="hidden" name="MAX_FILE_SIZE" value="1024000000000">
                
                 <div class="form-group row">
                  <label class="control-label col-md-3">Upload File : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-4">
                    <input name="upload" type="file" class="form-control-file" value="<?php if(isset($_POST['upload'])) echo $_POST['upload']; ?>" maxlength="200" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" /> 
                   <p>File must be less than 5MB.</br>
                     Allowed file type : MS Excel (Format file .xls)</p>
                     <br>
                        <label><input type="checkbox" id="checkA" value="checkA" name="checkA">Test Upload</label>
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
                
               <input name="Reset" type="reset" id="Reset" class="btn btn-warning" value="RESET">
               <input name="submitKanb" type="submit" id="submit" value="SUBMIT" class="btn btn-primary" onClick="return confirm('Are you sure to submit?');" >
          
      
             
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