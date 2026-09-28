<?php
//error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
error_reporting(0);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
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

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2);
    $res = mysqli_fetch_array($result2);
	
    $url = "detail_comp_reject_prd.php"; 
	
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

//CR status (Pending Approve)
$sta15 = "SELECT * from request_status WHERE status_id = '15'";
$sta_res15 = mysqli_query($dbc,$sta15);
$rst_sta15 = mysqli_fetch_array($sta_res15);

//CR status (Deleted)
$sta16 = "SELECT * from request_status WHERE status_id = '16'";
$sta_res16 = mysqli_query($dbc,$sta16);
$rst_sta16 = mysqli_fetch_array($sta_res16);

//CR status (Transfer Posting)
$sta19 = "SELECT * from request_status WHERE status_id = '19'";
$sta_res19 = mysqli_query($dbc,$sta19);
$rst_sta19 = mysqli_fetch_array($sta_res19);	


//CR status (Pending Approve STM)
$sta32 = "SELECT * from request_status WHERE status_id = '32'";
$sta_res32 = mysqli_query($dbc,$sta32);
$rst_sta32 = mysqli_fetch_array($sta_res32);

//CR status (Pending Approve ASSY)
$sta34 = "SELECT * from request_status WHERE status_id = '34'";
$sta_res34 = mysqli_query($dbc,$sta34);
$rst_sta34 = mysqli_fetch_array($sta_res34);

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
      <!----sort table https://stackoverflow.com/questions/10683712/html-table-sort/51648529---->
   <!-- <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>-->
    <!--  <script src="https://www.w3schools.com/lib/w3.js"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script> 
    
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    
       
    
    
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/plugins/forms/uniform.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/select2.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/inputmask.js"></script>
<script type="text/javascript" src="js/plugins/forms/autosize.js"></script>
<script type="text/javascript" src="js/plugins/forms/inputlimit.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/listbox.js"></script>
<script type="text/javascript" src="js/plugins/forms/multiselect.js"></script>
<script type="text/javascript" src="js/plugins/forms/validate.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/tags.min.js"></script>
    
    
    

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
    
<style>
th {
  cursor: pointer;
 /* background-color: coral;*/
}    
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    max-height: calc(100vh - 200px);
    overflow-y: auto;
}
</style> 
<style>
.pagin {
  display: inline-block;
}

.pagin a {
  color: black;
  float: left;
  padding: 7px 10px;
  text-decoration: none;
  border: 1px solid #ddd;
}

.pagin a.active {
  background-color: #32A478;
  color: white;
  border: 1px solid #32A478;
}

.pagin a:hover:not(.active) {background-color: #ddd;}

.pagin a:first-child {
  border-top-left-radius: 5px;
  border-bottom-left-radius: 5px;
}

.pagin a:last-child {
  border-top-right-radius: 5px;
  border-bottom-right-radius: 5px;
}
div.dataTables_wrapper {
        width: 1300px;
        margin: 0 auto;
    }
</style> 
  
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
          <h1><i class="fa fa-bar-chart"></i> Disposals</h1>
          <p>Component Reject</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Disposals</li>
          <li class="breadcrumb-item"><a href="detail_comp_reject_prd.php">Component Reject</a></li>
        </ul>
      </div> 
        
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Component Reject </h3>
            <div class="tile-body">
              <div class="table-responsive">
              
  <?php       
  
    $message_pcode = "";
	$message_slocf = "";
	$message_sloct = "";
	$message_psdt = "";
	$message_shift = "";
	$message_mat = "";
    $message_ty = "";
	$message_cat = "";
	$message_model = "";
	$message_work = "";
	
	$query_id = "SELECT * FROM run_count_itsb WHERE uid = '133'";
	$result_id = mysqli_query($dbc,$query_id);
	
	
	if ($result_id) 
{
	$nrows = mysqli_num_rows($result_id);
	$row_id = mysqli_fetch_array($result_id);
	
	$dht = 00000; 
	//$dht_OK = "211";
	$dg2 = 0;

  	if($row_id["count_max"] <= 0)
  	{ 
   
    	$lastID = ($row_id["count_max"] + 1);
    	$dg = ($dht + ($lastID));
   }
   else
   {
      $lastID = ($row_id["count_max"] + 1);
      $dg =  $lastID;
	
    }
	$number = $dg; // Length of running no
    $number = sprintf('%07d', $number);  
	
	
	  
	
	} // end if $result_id		

	
	
  
	
	     
        if((isset($_POST["submit3"]))  && $_POST!=="") 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

function escape_data($data) {
global $dbc;   // need the connection.
if (ini_get('magic_quotes_gpc')) {
    $data = stripslashes($data);
	}
	return mysqli_real_escape_string($data,$dbc);
	}   // end function.
$message = NULL; // create an empty new variable.
   
            $barcode_ref = $_POST["barcode_ref"];
           	$plant_code = $_POST["plant_code"];
			$model_code = $_POST["model_code"]; 
			$material_type = $_POST["material_type"]; 
			$stamp_ind = $_POST["stamp_ind"];
			$material_no = $_POST["material_no"];
		    $work_center = $_POST["work_center"];
		
	// check for a barcode ref (scan from FG Tag)
		
			
    if(($_POST["barcode_ref"]) == "")
	 { 	
		  
		   if(($_POST["material_type"]) == "NULL")
     {
	     $material_type = FALSE;
		 $message_ty = '<span class="badge badge-pill badge-danger">Please select Material Type!</span>';
	 }else{
		 $material_type = TRUE;
	  } 
		   
		
			
			
			if(($_POST["plant_code"]) == "NULL")
     {
	     $plant_code = FALSE;
		 $message_pcode = '<span class="badge badge-pill badge-danger">Please select Plant!</span>';
	 }else{
		 
		 
		 
			 $query_detail_chk = "SELECT * FROM scan_prd_creject WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
			 $result_detail_chk = mysqli_query($dbc,$query_detail_chk);
    
			while($data_detail_chk = mysqli_fetch_array($result_detail_chk))
			
			{
				
				if(($data_detail_chk["plant_code"]) != ($_POST["plant_code"]))
				{
					
						  echo "<script>";
						  echo "alert('Wrong batch plant code! Please select correct Plant.');";
						  echo "window.location='detail_comp_reject_prd.php?scan_doc=$number'";
						  echo "</script>";
						  exit(); //quit the script	
					
				}
				
				
				
			}
	     
		      $plant_code = TRUE;	 
		 
	  }
		
		
	 if(($_POST["stamp_ind"]) == "NULL")
     {
	     $stamp_ind = FALSE;
		 $message_cat = '<span class="badge badge-pill badge-danger">Please select Category!</span>';
	 }else{
		 $stamp_ind = TRUE;
	  }
	  
	  
	  if(($_POST["material_no"]) == "NULL")
     {
	     $material_no = FALSE;
		 $message_mat = '<span class="badge badge-pill badge-danger">Please select Part Number!</span>';
	 }else{
		 $material_no = TRUE;
	  }
		
		 if(($_POST["model_code"]) == "NULL")
     {
	     $model_code = FALSE;
		 $message_model = '<span class="badge badge-pill badge-danger">Please select Model!</span>';
	 }else{
		 $model_code = TRUE;
	  }
		
		 if(($_POST["work_center"]) == "NULL")
     {
	     $work_center = FALSE;
		 $message_work = '<span class="badge badge-pill badge-danger">Please select Station!</span>';
	 }else{
		 $work_center = TRUE;
	  }	
					
		
   
			} //end barcode

if(($barcode_ref) || ($material_type && $plant_code && $material_no && $stamp_ind && $model_code && $work_center))//everything ok
{  

//checking delete space semasa scanning

$barcode_ref2 = trim($barcode_ref);
			
 
//split dulu pps ref kpd prod_order, material,uom, plant, sloc, qty
$str = $barcode_ref2;

if($str)
{

if(explode('|', $str, 6))
{

list($part1, $part2, $part3, $part4, $part5, $part6) = (explode('|', $str, 6));
}




} //end if $str
    
  	        $plant_code = $_POST["plant_code"];
			$model_code = $_POST["model_code"]; 
			$material_type = $_POST["material_type"]; 
			$stamp_ind = $_POST["stamp_ind"];
			$material_no = $_POST["material_no"];
		    $work_center = $_POST["work_center"]; 

	   

if($_POST["barcode_ref"] != "")
{ 
//insert to scan_tp_store
//----add for record [status = 'Y' will be generate trans posting running no]

  $query_q2A = "SELECT * FROM mat_master_header WHERE material_no = '".sql_esc($part1)."'";
  $result_q2A = mysqli_query($dbc,$query_q2A) or die (mysqli_error($dbc));
  $ans3A = mysqli_fetch_array($result_q2A);

  $query_q2 = "SELECT * FROM mat_master_detail WHERE material = '".sql_esc($part1)."' AND bom_status = 'Y'";
  $result_q2 = mysqli_query($dbc,$query_q2) or die (mysqli_error($dbc));
  
  while($ans3 = mysqli_fetch_array($result_q2))
  {


  $query_mat_info = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($part1)."' AND status_BOM = 'Y'";
  $result_mat_info = mysqli_query($dbc,$query_mat_info) or die (mysqli_error($dbc));
  $ans_mat_info = mysqli_fetch_array($result_mat_info);
  
  
		   //---------detail material_type_tbl (material_type) ----
		  
		  $query_mtype = "SELECT * FROM material_type_tbl WHERE id = '".sql_esc($ans_mat_info["mat_type"])."'";
		  $result_mtype = mysqli_query($dbc,$query_mtype) or die (mysqli_error($dbc));
		  $d_mtype = mysqli_fetch_array($result_mtype);
  
  
		  //---------detail model_detail_tbl(model_code) ---
		  
		  $query_mcode = "SELECT * FROM model_detail_tbl WHERE id_model = '".sql_esc($ans_mat_info["model_code"])."'";
		  $result_mcode = mysqli_query($dbc,$query_mcode) or die (mysqli_error($dbc));
		  $d_mcode = mysqli_fetch_array($result_mcode);
  

      //----get cost center ----
		  $query_wctr = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($ans_mat_info["prod_line"])."'";
		  $result_wctr = mysqli_query($dbc,$query_wctr);
		  $row_wctr = mysqli_fetch_array($result_wctr);	
		  
		  
		   //-------detail detail(component)

		   $query_mat_info2 = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($ans3["bill_component"])."' AND status_BOM = 'Y'";
		   $result_mat_info2 = mysqli_query($dbc,$query_mat_info2);
		   $ans_mat_info2 = mysqli_fetch_array($result_mat_info2);

$query_db = "INSERT INTO scan_prd_creject(id_scan_dis,scan_doc,barcode_ref,material_no,material_desc,plan_no,doc_no,plant_code,scan_sloc_f,scan_sloc_t,scan_shift,scan_qty,scan_uom,posting_date,scan_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,status,status_dis,gr_doc_no,bill_component,material_desc_c,c_vclass,work_center,cost_center,back_no,kanban_no) VALUES ('','".sql_esc($number)."','".sql_esc($barcode_ref2)."','".sql_esc($part1)."','".strtoupper($ans3A["material_desc"])."','','','".sql_esc($ans_mat_info["plant_code"])."','".sql_esc($ans_mat_info2["sloc"])."','','','".sql_esc($part5)."','".sql_esc($ans_mat_info["BUn"])."','',NOW(),'','".sql_esc($d_mcode["model_code"])."','".sql_esc($d_mtype["mat_type_id"])."','".sql_esc($ans_mat_info["category_mat"])."','','".sql_esc($username)."', NOW(),'N','".sql_esc($rst_sta["status_desc"])."','','".sql_esc($ans3["bill_component"])."','".sql_esc($ans3["material_desc_c"])."','".sql_esc($ans3["comp_vclass"])."','".sql_esc($ans_mat_info["prod_line"])."','".sql_esc($row_wctr["cost_center"])."','".sql_esc($part3)."','".sql_esc($part6)."')";
$result_db = mysqli_query($dbc,$query_db) or die (mysqli_error($dbc));

  }//end while $ans3


}elseif($_POST["barcode_ref"] == "")
{
//insert to scan_tp_store
//----add for record [status = 'Y' will be generate trans posting running no]

 
  $query_q22A = "SELECT * FROM mat_master_header WHERE material_no = '".sql_esc($material_no)."'";
  $result_q22A = mysqli_query($dbc,$query_q22A) or die (mysqli_error($dbc));
  $ans22A = mysqli_fetch_array($result_q22A);

 
  $query_q22 = "SELECT * FROM mat_master_detail WHERE material = '".sql_esc($material_no)."' AND bom_status = 'Y'";
  $result_q22 = mysqli_query($dbc,$query_q22) or die (mysqli_error($dbc));
 
 while($ans22 = mysqli_fetch_array($result_q22))
 {
	 
	    //----get bill component-------
		
		$query_mat_bom = "SELECT * FROM mat_master_detail WHERE id_dtl = '".sql_esc($ans22["id_dtl"])."' AND bill_component = '".sql_esc($ans22["bill_component"])."' AND bom_status = 'Y'";
	    $result_mat_bom = mysqli_query($dbc,$query_mat_bom);
	    $ans_mat_bom = mysqli_fetch_array($result_mat_bom);
		
	 
	     //----get cost center ----
		  $query_wctr2 = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($work_center)."'";
		  $result_wctr2 = mysqli_query($dbc,$query_wctr2);
		  $row_wctr2 = mysqli_fetch_array($result_wctr2);
		  
		  
		    //---------detail material_type_tbl (material_type) ----
		  
		  $query_mtype2 = "SELECT * FROM material_type_tbl WHERE id = '".sql_esc($material_type)."'";
		  $result_mtype2 = mysqli_query($dbc,$query_mtype2) or die (mysqli_error($dbc));
		  $d_mtype2 = mysqli_fetch_array($result_mtype2);
  
  
		  //---------detail model_detail_tbl(model_code) ---
		  
		  $query_mcode2 = "SELECT * FROM model_detail_tbl WHERE id_model = '".sql_esc($model_code)."'";
		  $result_mcode2 = mysqli_query($dbc,$query_mcode2) or die (mysqli_error($dbc));
		  $d_mcode2 = mysqli_fetch_array($result_mcode2);	
		  
		  //--------detail header------

		   $query_mat_info = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($material_no)."' AND status_BOM = 'Y'";
		   $result_mat_info = mysqli_query($dbc,$query_mat_info) or die (mysqli_error($dbc));
		   $ans_mat_info = mysqli_fetch_array($result_mat_info);

		   //-------detail detail(component)

		   $query_mat_info2 = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($ans22["bill_component"])."' AND status_BOM = 'Y'";
		   $result_mat_info2 = mysqli_query($dbc,$query_mat_info2) or die (mysqli_error($dbc));
		   $ans_mat_info2 = mysqli_fetch_array($result_mat_info2);

		    	 

$query_db = "INSERT INTO scan_prd_creject(id_scan_dis,scan_doc,barcode_ref,material_no,material_desc,plan_no,doc_no,plant_code,scan_sloc_f,scan_sloc_t,scan_shift,scan_qty,scan_uom,posting_date,scan_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,status,status_dis,gr_doc_no,bill_component,material_desc_c,c_vclass,work_center,cost_center,back_no,kanban_no) VALUES ('','".sql_esc($number)."','','".sql_esc($material_no)."','".strtoupper($ans22A["material_desc"])."','','','".sql_esc($plant_code)."','".sql_esc($ans_mat_info2["sloc"])."','','','','".sql_esc($ans_mat_bom["comp_unit"])."','',NOW(),'','".sql_esc($d_mcode2["model_code"])."','".sql_esc($d_mtype2["mat_type_id"])."','".sql_esc($stamp_ind)."','','".sql_esc($username)."', NOW(),'N','".sql_esc($rst_sta["status_desc"])."','','".sql_esc($ans22["bill_component"])."','".sql_esc($ans22["material_desc_c"])."','".sql_esc($ans22["comp_vclass"])."','".sql_esc($work_center)."','".sql_esc($row_wctr2["cost_center"])."','".sql_esc($ans_mat_info["back_no"])."','')";
$result_db = mysqli_query($dbc,$query_db) or die (mysqli_error($dbc));

 }//end while loop $ans22

}

  
            if($result_db)
             {
			 
			echo "<script>";
			echo "window.location='detail_comp_reject_prd.php?scan_doc=$number&&barcode_ref=".html_esc($barcode_ref)."&&plant_code=$plant_code&&model_code=$model_code&&material_type=$material_type&&stamp_ind=$stamp_ind&&work_center=$work_center&&material_no=$material_no'";
            echo "</script>";
            exit(); //quit the script
			 
			
             }


	 
}//print the message if there is one.

  
}
?>
   

<?php 
  if(isset($_POST["submit4"]))        
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

			
	
if(isset($_POST['e_tcid']))
{
	
	//$idd = $_POST["idd"]; 			
    $trc_id = $_POST["e_tcid"]; 
    $st = count($trc_id);
	$shift_ops = $_POST["shift_ops"];
	$dateF = $_POST["date1"];
	
	$item_no = $_POST["item_no"];
	$scan_qty = $_POST["scan_qty"];
	$plant_code2 = $_POST["plant_code2"];
	//$sloc_rej = $_POST["sloc_rej"];
	//$work_center = $_POST["work_center"];
	$proc_reject = $_POST["proc_reject"];
	//$type_reject = $_POST["type_reject"];
	//$type_defect = $_POST["type_defect"];
	$remark_dis = $_POST["remark_dis"];
            
	
	//--------checking ------------
	
		 
	  
	  
	      if((($_POST["date1"]) == "00-00-0000") || (($_POST["date1"]) == ""))
     {
	     $dateF = FALSE;
		 $message_psdt = '<span class="badge badge-pill badge-danger"> Please select Posting Date !</span>';
	 }else{
		 $dateF = TRUE;
	  }
		
		
			 if(($_POST["shift_ops"]) == "")
     {
	     $shift_ops = FALSE;
		 $message_shift = '<span class="badge badge-pill badge-danger">Please select Shift!</span>';
	 }else{
		 $shift_ops = TRUE;
	  }
		
		
     
	 if($dateF && $shift_ops)
	 
	 {
						
			
	

//------generate Material Document No. for GR Generate.---------------------------------
	
	 if($_POST["plant_code2"] == '3100')
	{
	
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '29'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	}elseif($_POST["plant_code2"] == '3101')
	{
		
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '78'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
		
	}
	
	if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 00000; 
	$dht_OK2 = "351";
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
    $number2 = sprintf('%03d', $number2);  
	
    $ref3 = (($row_id2["start_ref"]).$dht_OK2.$date_run.($number2));
	  
	
	} // end if $result_id2
	
		//update count_max----------------------------------------
	 
	  if($_POST["plant_code2"] == '3100')
	{
  
       $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '29'";
	   $result_max_a = mysqli_query($dbc,$query_max_a);
	   
	   $query_max_aA = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '133'";
	   $result_max_aA = mysqli_query($dbc,$query_max_aA);

	}elseif($_POST["plant_code2"] == '3101')
	{
	   $query_max_b = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '78'";
	   $result_max_b = mysqli_query($dbc,$query_max_b);
	   
	   $query_max_bB = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '133'";
	   $result_max_bB = mysqli_query($dbc,$query_max_bB);
	 
	}
	

   //end update count_max ---------------------------------	
	
	
	
		$amount = "";
		$amount2 = "";
		$amount3 = "";
		$amount4 = "";
		
		$string = "";
		$string2 = "";
		$string3 = "";
		$string4 = "";
		
	
		$trc_id = $_POST["e_tcid"]; 
		$st = count($trc_id);
	    $idd = $_POST["idd"]; 			
		
		$shift_ops = $_POST["shift_ops"];
	    $dateF = $_POST["date1"];
	
		$item_no = $_POST["item_no"];
		$scan_qty = $_POST["scan_qty"];
		$plant_code2 = $_POST["plant_code2"];
	//	$sloc_rej = $_POST["sloc_rej"];
		//$work_center = $_POST["work_center"];
		$proc_reject = $_POST["proc_reject"];
		//$type_reject = $_POST["type_reject"];
		//$type_defect = $_POST["type_defect"];
		$remark_dis = $_POST["remark_dis"];
		
		
		
	    foreach($_POST["e_tcid"] as $j=>$i) {
		   
		//$azieTest =  (($_POST["sloc_rej"][$i]).';');
	    $amount .= (($_POST["scan_qty"][$i]).';');
		//$amount2 .= $azieTest;
		$amount3 .= (($_POST["item_no"][$i]).';');
	    $amount4 .= (($_POST["remark_dis"][$i]).';');
	
		//$amount6 .= (($_POST["work_center"][$i]).';');
		//$amount7 .= (($_POST["type_reject"][$i]).';');
		$amount8 .= (($_POST["reason_reject"][$i]).';');
		//$amount9 .= (($_POST["type_defect"][$i]).';');
		//$amount10 .= (($_POST["proc_reject"][$i]).';');
				
		//-----checking barcode GR Tag
		
		$string = explode(";",($amount));	
		//$string2 = explode(";",($amount2));	
		$string3 = explode(";",($amount3));	
		$string4 = explode(";",($amount4));	
	
		//$string6 = explode(";",($amount6));
	   // $string7 = explode(";",($amount7));
		$string8 = explode(";",($amount8));
		//$string9 = explode(";",($amount9));
		//$string10 = explode(";",($amount10));
		
	
        }
	
	  $i = "";
	
	
		 for($i=0; $i < count($_POST["e_tcid"]); $i++)
	{		
	
	
	             $ddF = substr($_POST["date1"],0,2);
				 $mmF = substr($_POST["date1"],3,2);
				 $yyF = substr($_POST["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
		
		 //----get cost center ----
		/*  $query_wctr = "SELECT * FROM work_center_detail WHERE id_work = '".$string6[$i]."'";
		  $result_wctr = mysqli_query($dbc,$query_wctr);
		  $row_wctr = mysqli_fetch_array($result_wctr);		 */
				 
				  //add post dropdown
	/*	$proc_rejectY = $_POST["proc_reject"];  
		$type_rejectY = $_POST["type_reject"];
		$type_defectY = $_POST["type_defect"];*/
		
		
       //---update status "yes" for generate tp to store----
	    
		$query_update_scan2 = "UPDATE scan_prd_creject SET scan_qty = '".sql_esc($string[$i])."', status = 'Y', status_dis = '".sql_esc($rst_sta7["status_desc"])."' WHERE id_scan_dis = '".sql_esc($trc_id[$i])."'";
	    $rst_update_scan2 = mysqli_query($dbc,$query_update_scan2); 
		
		 			
	      //----------insert check to table scan_prd_creject-------------
	   
	      $query_po_list = "SELECT * FROM scan_prd_creject WHERE id_scan_dis = '".sql_esc($trc_id[$i])."' AND status_dis = '".sql_esc($rst_sta7["status_desc"])."'";
          $result_po_list = mysqli_query($dbc,$query_po_list);
          $row_po_list = mysqli_fetch_array($result_po_list);
		  
				
			//----checking requestor assy or stamping -------------//
			$query_chk_requestor = "SELECT * FROM function_acc_detail WHERE staff_ID = '".sql_esc($res["staff_ID"])."' AND staff_ID = '".sql_esc($row_po_list["user_create"])."'";
			$result_chk_requestor = mysqli_query($dbc,$query_chk_requestor);
			$row_chk_requestor = mysqli_fetch_array($result_chk_requestor);	
					
  

			  
//------checking ASSY --------

if(($row_chk_requestor["f_assy_prd"] == 'Y') && ($row_po_list["stamp_ind"] == 'ASSY'))
 {

        $query_tag3 = "INSERT INTO prd_creject_detail(id_dis,doc_dis,id_scan_dis,scan_doc,item_no,material_no,material_desc,plan_no,doc_no,plant_code,sloc_from,sloc_to,qty_dis,uom_dis,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_dis,date_generate_dis,time_generate_dis,ref_doc_dis,user_cancel,date_cancel,remark_cancel,status_ftp,status_tran,status_dis,sloc_rej,work_center,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,remark_dis,status_approved1,hod_approved1,date_approved1,remark_approved1,status_approved2,hod_approved2,date_approved2,remark_approved2,status_approved3,hod_approved3,date_approved3,remark_approved3,status_approved4,hod_approved4,date_approved4,remark_approved4,status_approved5,hod_approved5,date_approved5,remark_approved5,status_part,cost_center,barcode_gr,gr_doc_no,bill_component,material_desc_c,c_vclass,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES ('','".sql_esc($ref3)."','".sql_esc($row_po_list["id_scan_dis"])."','".sql_esc($row_po_list["scan_doc"])."','".sql_esc($string3[$i])."','".sql_esc($row_po_list["material_no"])."','".sql_esc($row_po_list["material_desc"])."','".sql_esc($row_po_list["plan_no"])."','".sql_esc($row_po_list["doc_no"])."','".sql_esc($row_po_list["plant_code"])."','".sql_esc($row_po_list["scan_sloc_f"])."','".sql_esc($row_po_list["scan_sloc_t"])."','".sql_esc($string[$i])."','".sql_esc($row_po_list["scan_uom"])."','".sql_esc($date1_final)."','".sql_esc($shift_ops)."','".sql_esc($row_po_list["model_code"])."','".sql_esc($row_po_list["material_type"])."','".sql_esc($row_po_list["stamp_ind"])."','".sql_esc($row_po_list["slip_no"])."','".sql_esc($row_po_list["user_create"])."','".sql_esc($row_po_list["date_create"])."','".sql_esc($username)."',NOW(),NOW(),'','','','','N','Y','".sql_esc($rst_sta34["status_desc"])."','".sql_esc($row_po_list["scan_sloc_f"])."','".sql_esc($row_po_list["work_center"])."','','','','".sql_esc($string8[$i])."','".sql_esc($username)."',NOW(),NOW(),'".sql_esc($string4[$i])."','','','','','','','','','','','','','','','','','','','','','PR','".sql_esc($row_po_list["cost_center"])."','".sql_esc($row_po_list["barcode_ref"])."','".sql_esc($row_po_list["gr_doc_no"])."','".sql_esc($row_po_list["bill_component"])."','".sql_esc($row_po_list["material_desc_c"])."','".sql_esc($row_po_list["c_vclass"])."','".sql_esc($row_po_list["back_no"])."','".sql_esc($row_po_list["kanban_no"])."','','')";
		$result_tag3 = mysqli_query($dbc,$query_tag3);


  }elseif(($row_chk_requestor["f_assy_prd"] == 'Y') && ($row_po_list["stamp_ind"] == 'STM'))
  {

	     $query_tag3 = "INSERT INTO prd_creject_detail(id_dis,doc_dis,id_scan_dis,scan_doc,item_no,material_no,material_desc,plan_no,doc_no,plant_code,sloc_from,sloc_to,qty_dis,uom_dis,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_dis,date_generate_dis,time_generate_dis,ref_doc_dis,user_cancel,date_cancel,remark_cancel,status_ftp,status_tran,status_dis,sloc_rej,work_center,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,remark_dis,status_approved1,hod_approved1,date_approved1,remark_approved1,status_approved2,hod_approved2,date_approved2,remark_approved2,status_approved3,hod_approved3,date_approved3,remark_approved3,status_approved4,hod_approved4,date_approved4,remark_approved4,status_approved5,hod_approved5,date_approved5,remark_approved5,status_part,cost_center,barcode_gr,gr_doc_no,bill_component,material_desc_c,c_vclass,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES ('','".sql_esc($ref3)."','".sql_esc($row_po_list["id_scan_dis"])."','".sql_esc($row_po_list["scan_doc"])."','".sql_esc($string3[$i])."','".sql_esc($row_po_list["material_no"])."','".sql_esc($row_po_list["material_desc"])."','".sql_esc($row_po_list["plan_no"])."','".sql_esc($row_po_list["doc_no"])."','".sql_esc($row_po_list["plant_code"])."','".sql_esc($row_po_list["scan_sloc_f"])."','".sql_esc($row_po_list["scan_sloc_t"])."','".sql_esc($string[$i])."','".sql_esc($row_po_list["scan_uom"])."','".sql_esc($date1_final)."','".sql_esc($shift_ops)."','".sql_esc($row_po_list["model_code"])."','".sql_esc($row_po_list["material_type"])."','".sql_esc($row_po_list["stamp_ind"])."','".sql_esc($row_po_list["slip_no"])."','".sql_esc($row_po_list["user_create"])."','".sql_esc($row_po_list["date_create"])."','".sql_esc($username)."',NOW(),NOW(),'','','','','N','Y','".sql_esc($rst_sta34["status_desc"])."','".sql_esc($row_po_list["scan_sloc_f"])."','".sql_esc($row_po_list["work_center"])."','','','','".sql_esc($string8[$i])."','".sql_esc($username)."',NOW(),NOW(),'".sql_esc($string4[$i])."','','','','','','','','','','','','','','','','','','','','','PR','".sql_esc($row_po_list["cost_center"])."','".sql_esc($row_po_list["barcode_ref"])."','".sql_esc($row_po_list["gr_doc_no"])."','".sql_esc($row_po_list["bill_component"])."','".sql_esc($row_po_list["material_desc_c"])."','".sql_esc($row_po_list["c_vclass"])."','".sql_esc($row_po_list["back_no"])."','".sql_esc($row_po_list["kanban_no"])."','','')";
		 $result_tag3 = mysqli_query($dbc,$query_tag3);


 
 }elseif(($row_chk_requestor["f_stamp_prd"] == 'Y') && ($row_po_list["stamp_ind"] == 'STM'))
 {

	$query_tag3 = "INSERT INTO prd_creject_detail(id_dis,doc_dis,id_scan_dis,scan_doc,item_no,material_no,material_desc,plan_no,doc_no,plant_code,sloc_from,sloc_to,qty_dis,uom_dis,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_dis,date_generate_dis,time_generate_dis,ref_doc_dis,user_cancel,date_cancel,remark_cancel,status_ftp,status_tran,status_dis,sloc_rej,work_center,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,remark_dis,status_approved1,hod_approved1,date_approved1,remark_approved1,status_approved2,hod_approved2,date_approved2,remark_approved2,status_approved3,hod_approved3,date_approved3,remark_approved3,status_approved4,hod_approved4,date_approved4,remark_approved4,status_approved5,hod_approved5,date_approved5,remark_approved5,status_part,cost_center,barcode_gr,gr_doc_no,bill_component,material_desc_c,c_vclass,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES ('','".sql_esc($ref3)."','".sql_esc($row_po_list["id_scan_dis"])."','".sql_esc($row_po_list["scan_doc"])."','".sql_esc($string3[$i])."','".sql_esc($row_po_list["material_no"])."','".sql_esc($row_po_list["material_desc"])."','".sql_esc($row_po_list["plan_no"])."','".sql_esc($row_po_list["doc_no"])."','".sql_esc($row_po_list["plant_code"])."','".sql_esc($row_po_list["scan_sloc_f"])."','".sql_esc($row_po_list["scan_sloc_t"])."','".sql_esc($string[$i])."','".sql_esc($row_po_list["scan_uom"])."','".sql_esc($date1_final)."','".sql_esc($shift_ops)."','".sql_esc($row_po_list["model_code"])."','".sql_esc($row_po_list["material_type"])."','".sql_esc($row_po_list["stamp_ind"])."','".sql_esc($row_po_list["slip_no"])."','".sql_esc($row_po_list["user_create"])."','".sql_esc($row_po_list["date_create"])."','".sql_esc($username)."',NOW(),NOW(),'','','','','N','Y','".sql_esc($rst_sta32["status_desc"])."','".sql_esc($row_po_list["scan_sloc_f"])."','".sql_esc($row_po_list["work_center"])."','','','','".sql_esc($string8[$i])."','".sql_esc($username)."',NOW(),NOW(),'".sql_esc($string4[$i])."','','','','','','','','','','','','','','','','','','','','','PR','".sql_esc($row_po_list["cost_center"])."','".sql_esc($row_po_list["barcode_ref"])."','".sql_esc($row_po_list["gr_doc_no"])."','".sql_esc($row_po_list["bill_component"])."','".sql_esc($row_po_list["material_desc_c"])."','".sql_esc($row_po_list["c_vclass"])."','".sql_esc($row_po_list["back_no"])."','".sql_esc($row_po_list["kanban_no"])."','','')";
	$result_tag3 = mysqli_query($dbc,$query_tag3);	

			
	
	
}elseif(($row_chk_requestor["f_stamp_prd"] == 'Y') && ($row_po_list["stamp_ind"] == 'ASSY')){

			
	 $query_tag3 = "INSERT INTO prd_creject_detail(id_dis,doc_dis,id_scan_dis,scan_doc,item_no,material_no,material_desc,plan_no,doc_no,plant_code,sloc_from,sloc_to,qty_dis,uom_dis,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_dis,date_generate_dis,time_generate_dis,ref_doc_dis,user_cancel,date_cancel,remark_cancel,status_ftp,status_tran,status_dis,sloc_rej,work_center,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,remark_dis,status_approved1,hod_approved1,date_approved1,remark_approved1,status_approved2,hod_approved2,date_approved2,remark_approved2,status_approved3,hod_approved3,date_approved3,remark_approved3,status_approved4,hod_approved4,date_approved4,remark_approved4,status_approved5,hod_approved5,date_approved5,remark_approved5,status_part,cost_center,barcode_gr,gr_doc_no,bill_component,material_desc_c,c_vclass,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES ('','".sql_esc($ref3)."','".sql_esc($row_po_list["id_scan_dis"])."','".sql_esc($row_po_list["scan_doc"])."','".sql_esc($string3[$i])."','".sql_esc($row_po_list["material_no"])."','".sql_esc($row_po_list["material_desc"])."','".sql_esc($row_po_list["plan_no"])."','".sql_esc($row_po_list["doc_no"])."','".sql_esc($row_po_list["plant_code"])."','".sql_esc($row_po_list["scan_sloc_f"])."','".sql_esc($row_po_list["scan_sloc_t"])."','".sql_esc($string[$i])."','".sql_esc($row_po_list["scan_uom"])."','".sql_esc($date1_final)."','".sql_esc($shift_ops)."','".sql_esc($row_po_list["model_code"])."','".sql_esc($row_po_list["material_type"])."','".sql_esc($row_po_list["stamp_ind"])."','".sql_esc($row_po_list["slip_no"])."','".sql_esc($row_po_list["user_create"])."','".sql_esc($row_po_list["date_create"])."','".sql_esc($username)."',NOW(),NOW(),'','','','','N','Y','".sql_esc($rst_sta32["status_desc"])."','".sql_esc($row_po_list["scan_sloc_f"])."','".sql_esc($row_po_list["work_center"])."','','','','".sql_esc($string8[$i])."','".sql_esc($username)."',NOW(),NOW(),'".sql_esc($string4[$i])."','','','','','','','','','','','','','','','','','','','','','PR','".sql_esc($row_po_list["cost_center"])."','".sql_esc($row_po_list["barcode_ref"])."','".sql_esc($row_po_list["gr_doc_no"])."','".sql_esc($row_po_list["bill_component"])."','".sql_esc($row_po_list["material_desc_c"])."','".sql_esc($row_po_list["c_vclass"])."','".sql_esc($row_po_list["back_no"])."','".sql_esc($row_po_list["kanban_no"])."','','')";
	 $result_tag3 = mysqli_query($dbc,$query_tag3);		




	}elseif(($row_chk_requestor["f_stamp_prd"] == 'Y') && ($row_po_list["stamp_ind"] == 'BLK'))
	{
			  			
		
		$query_tag3 = "INSERT INTO prd_creject_detail(id_dis,doc_dis,id_scan_dis,scan_doc,item_no,material_no,material_desc,plan_no,doc_no,plant_code,sloc_from,sloc_to,qty_dis,uom_dis,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_dis,date_generate_dis,time_generate_dis,ref_doc_dis,user_cancel,date_cancel,remark_cancel,status_ftp,status_tran,status_dis,sloc_rej,work_center,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,remark_dis,status_approved1,hod_approved1,date_approved1,remark_approved1,status_approved2,hod_approved2,date_approved2,remark_approved2,status_approved3,hod_approved3,date_approved3,remark_approved3,status_approved4,hod_approved4,date_approved4,remark_approved4,status_approved5,hod_approved5,date_approved5,remark_approved5,status_part,cost_center,barcode_gr,gr_doc_no,bill_component,material_desc_c,c_vclass,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES ('','".sql_esc($ref3)."','".sql_esc($row_po_list["id_scan_dis"])."','".sql_esc($row_po_list["scan_doc"])."','".sql_esc($string3[$i])."','".sql_esc($row_po_list["material_no"])."','".sql_esc($row_po_list["material_desc"])."','".sql_esc($row_po_list["plan_no"])."','".sql_esc($row_po_list["doc_no"])."','".sql_esc($row_po_list["plant_code"])."','".sql_esc($row_po_list["scan_sloc_f"])."','".sql_esc($row_po_list["scan_sloc_t"])."','".sql_esc($string[$i])."','".sql_esc($row_po_list["scan_uom"])."','".sql_esc($date1_final)."','".sql_esc($shift_ops)."','".sql_esc($row_po_list["model_code"])."','".sql_esc($row_po_list["material_type"])."','STM','".sql_esc($row_po_list["slip_no"])."','".sql_esc($row_po_list["user_create"])."','".sql_esc($row_po_list["date_create"])."','".sql_esc($username)."',NOW(),NOW(),'','','','','N','Y','".sql_esc($rst_sta32["status_desc"])."','".sql_esc($row_po_list["scan_sloc_f"])."','".sql_esc($row_po_list["work_center"])."','','','','".sql_esc($string8[$i])."','".sql_esc($username)."',NOW(),NOW(),'".sql_esc($string4[$i])."','','','','','','','','','','','','','','','','','','','','','PR','".sql_esc($row_po_list["cost_center"])."','".sql_esc($row_po_list["barcode_ref"])."','".sql_esc($row_po_list["gr_doc_no"])."','".sql_esc($row_po_list["bill_component"])."','".sql_esc($row_po_list["material_desc_c"])."','".sql_esc($row_po_list["c_vclass"])."','".sql_esc($row_po_list["back_no"])."','".sql_esc($row_po_list["kanban_no"])."','','')";
		$result_tag3 = mysqli_query($dbc,$query_tag3);	

	
	}elseif(($row_chk_requestor["f_assy_prd"] == 'Y') && ($row_po_list["stamp_ind"] == 'BLK'))
	{


        $query_tag3 = "INSERT INTO prd_creject_detail(id_dis,doc_dis,id_scan_dis,scan_doc,item_no,material_no,material_desc,plan_no,doc_no,plant_code,sloc_from,sloc_to,qty_dis,uom_dis,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_dis,date_generate_dis,time_generate_dis,ref_doc_dis,user_cancel,date_cancel,remark_cancel,status_ftp,status_tran,status_dis,sloc_rej,work_center,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,remark_dis,status_approved1,hod_approved1,date_approved1,remark_approved1,status_approved2,hod_approved2,date_approved2,remark_approved2,status_approved3,hod_approved3,date_approved3,remark_approved3,status_approved4,hod_approved4,date_approved4,remark_approved4,status_approved5,hod_approved5,date_approved5,remark_approved5,status_part,cost_center,barcode_gr,gr_doc_no,bill_component,material_desc_c,c_vclass,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES ('','".sql_esc($ref3)."','".sql_esc($row_po_list["id_scan_dis"])."','".sql_esc($row_po_list["scan_doc"])."','".sql_esc($string3[$i])."','".sql_esc($row_po_list["material_no"])."','".sql_esc($row_po_list["material_desc"])."','".sql_esc($row_po_list["plan_no"])."','".sql_esc($row_po_list["doc_no"])."','".sql_esc($row_po_list["plant_code"])."','".sql_esc($row_po_list["scan_sloc_f"])."','".sql_esc($row_po_list["scan_sloc_t"])."','".sql_esc($string[$i])."','".sql_esc($row_po_list["scan_uom"])."','".sql_esc($date1_final)."','".sql_esc($shift_ops)."','".sql_esc($row_po_list["model_code"])."','".sql_esc($row_po_list["material_type"])."','ASSY','".sql_esc($row_po_list["slip_no"])."','".sql_esc($row_po_list["user_create"])."','".sql_esc($row_po_list["date_create"])."','".sql_esc($username)."',NOW(),NOW(),'','','','','N','Y','".sql_esc($rst_sta34["status_desc"])."','".sql_esc($row_po_list["scan_sloc_f"])."','".sql_esc($row_po_list["work_center"])."','','','','".sql_esc($string8[$i])."','".sql_esc($username)."',NOW(),NOW(),'".sql_esc($string4[$i])."','','','','','','','','','','','','','','','','','','','','','PR','".sql_esc($row_po_list["cost_center"])."','".sql_esc($row_po_list["barcode_ref"])."','".sql_esc($row_po_list["gr_doc_no"])."','".sql_esc($row_po_list["bill_component"])."','".sql_esc($row_po_list["material_desc_c"])."','".sql_esc($row_po_list["c_vclass"])."','".sql_esc($row_po_list["back_no"])."','".sql_esc($row_po_list["kanban_no"])."','','')";
		$result_tag3 = mysqli_query($dbc,$query_tag3);	

			
    }else{}
		

	
		}// end for loop
			
		 for($g = 0; $g < count($_POST["idd"]); $g++)  
	    {
		

	    $iddF = $_POST["idd"]; 
		$proc_rejectX = $_POST["proc_reject"];
		$type_rejectX = $_POST["type_reject"];
		$type_defectX = $_POST["type_defect"];
		
				 
		 $query_upd_final = "UPDATE prd_creject_detail SET proc_reject = '".sql_esc($proc_rejectX)."', type_reject = '".sql_esc($type_rejectX[$g])."', type_defect = '".sql_esc($type_defectX[$g])."' WHERE id_scan_dis = '".sql_esc($iddF[$g])."'";
		 $result_upd_final =  mysqli_query($dbc,$query_upd_final);
		 
		 
		 //---------------update at table disposal_detail_prd_all [prod - ppc receiving - ppc delivery - qc - coo ]----------
		
	     $query_chk_info = "SELECT * FROM prd_creject_detail WHERE id_scan_dis = '".sql_esc($iddF[$g])."' AND doc_dis = '".sql_esc($ref3)."'";
		 $result_chk_info =  mysqli_query($dbc,$query_chk_info);
		 $row_chk_info = mysqli_fetch_array($result_chk_info);
	
	if($row_chk_info > 0)
	{
	
		$query_ins_dis = "INSERT INTO disposal_detail_prd_all(id,id_disposal,doc_dis,doc_disposal_no,bflush_hwork,bflush_rework,bflush_pending,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit,comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,reject_source,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_chk_info["id_dis"])."','".sql_esc($row_chk_info["doc_dis"])."','".sql_esc($row_chk_info["item_no"])."','','','','".sql_esc($row_chk_info["doc_no"])."','".sql_esc($row_chk_info["plan_no"])."','".sql_esc($row_chk_info["id_scan_dis"])."','".sql_esc($row_chk_info["bill_component"])."','".sql_esc($row_chk_info["material_desc_c"])."','".sql_esc($row_chk_info["material_type"])."','".sql_esc($row_chk_info["model_code"])."','".sql_esc($row_chk_info["qty_dis"])."','','','','".sql_esc($row_chk_info["qty_dis"])."','','','".sql_esc($row_chk_info["uom_dis"])."','".sql_esc($row_chk_info["plant_code"])."','".sql_esc($row_chk_info["work_center"])."','".sql_esc($row_chk_info["shift_day"])."','".sql_esc($row_chk_info["posting_date"])."','".sql_esc($row_chk_info["user_generate_dis"])."','".sql_esc($row_chk_info["posting_date"])."','".sql_esc($row_chk_info["time_generate_dis"])."','".sql_esc($row_chk_info["status_dis"])."','".sql_esc($row_chk_info["sloc_rej"])."','".sql_esc($row_chk_info["sloc_rej"])."','".sql_esc($row_chk_info["sloc_rej"])."','".sql_esc($row_chk_info["proc_reject"])."','".sql_esc($row_chk_info["type_reject"])."','".sql_esc($row_chk_info["type_defect"])."','".sql_esc($row_chk_info["reason_reject"])."','".sql_esc($row_chk_info["user_reject"])."','".sql_esc($row_chk_info["date_reject"])."','".sql_esc($row_chk_info["time_reject"])."','','','','','','','".sql_esc($row_chk_info["user_create"])."','".sql_esc($row_chk_info["posting_date"])."','".sql_esc($row_chk_info["remark_dis"])."','".sql_esc($row_chk_info["status_part"])."','','','".sql_esc($row_chk_info["status_approved1"])."','".sql_esc($row_chk_info["hod_approved1"])."','".sql_esc($row_chk_info["date_approved1"])."','".sql_esc($row_chk_info["remark_approved1"])."','".sql_esc($row_chk_info["status_approved2"])."','".sql_esc($row_chk_info["hod_approved2"])."','".sql_esc($row_chk_info["date_approved2"])."','".sql_esc($row_chk_info["remark_approved2"])."','".sql_esc($row_chk_info["status_approved3"])."','".sql_esc($row_chk_info["hod_approved3"])."','".sql_esc($row_chk_info["date_approved3"])."','".sql_esc($row_chk_info["remark_approved3"])."','".sql_esc($row_chk_info["status_approved4"])."','".sql_esc($row_chk_info["hod_approved4"])."','".sql_esc($row_chk_info["date_approved4"])."','".sql_esc($row_chk_info["remark_approved4"])."','".sql_esc($row_chk_info["status_approved5"])."','".sql_esc($row_chk_info["hod_approved5"])."','".sql_esc($row_chk_info["date_approved5"])."','".sql_esc($row_chk_info["remark_approved5"])."','".sql_esc($row_chk_info["cost_center"])."','".sql_esc($row_wctr["id_factory"])."','".sql_esc($row_chk_info["ref_doc_dis"])."','".sql_esc($row_chk_info["user_cancel"])."','".sql_esc($row_chk_info["date_cancel"])."','".sql_esc($row_chk_info["remark_cancel"])."','".sql_esc($row_chk_info["plant_code"])."','".sql_esc($row_chk_info["shift_day"])."','".sql_esc($row_chk_info["stamp_ind"])."','CREJ','".sql_esc($row_chk_info["back_no"])."','".sql_esc($row_chk_info["kanban_no"])."','".sql_esc($row_chk_info["SAP_ref_doc"])."','".sql_esc($row_chk_info["SAP_ref_doc_can"])."')";
        $result_ins_dis = mysqli_query($dbc,$query_ins_dis); 

	}
		
	     }	
		
		
				
	
	   // $ref2 = base64_encode($ref3);
	  
	    echo "<script>";
		echo "alert('Material Document $ref3 posted.');";
		echo "window.location='detail_comp_reject_prd.php';"; 
		echo "</script>";
		exit(); //quit the script
		
		
		
	 }//end if 
		
			
    }//end if tick
			
   }// end if
 
?>
<?php

 if(isset($_POST["submit5"])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

//-----------delete all data current screen-------------

   $query_delete_scanA = "DELETE FROM scan_prd_creject WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
   $result_delete_scanA = mysqli_query($dbc,$query_delete_scanA);

//---------end delete ----------------------------------

}//end submit5

?>  

            <form id="form1" method="post" action="" >
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th colspan="3">&nbsp;</th>
            </tr>
             <tr>
                <th>Scan Kanban QR Code : <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="1. Kanban Tag" data-html="true" data-placement="left"></i></th>
                <th colspan="3">
     <input name="barcode_ref" type="text" id="barcode_ref" maxlength="200" value="<?php if(isset($_POST['barcode_ref'])) echo html_esc($_POST['barcode_ref']); ?>" class="form-control" autofocus/>
               </th>
              </tr>
              <tr>
            <th>Plant :  <font color="#FF0000">*</font></th>
            <td colspan="3">
           <select name="plant_code" class="form-control" onChange="getType(this.value)">
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
		     </td>
             </tr>
               <tr>
                <th>Type :<font color="#FF0000">*</font></th>
                <th colspan="3">
              <div id="mtype_div"> 
             <select name="material_type" id="material_type" class="form-control" onChange="getModel(this.value)">
                <option value="NULL" placeholder="Select Type"> -- Select Type -- </option>
                </select><div class="form-control-feedback" ><?php echo $message_ty; ?></div>
              </div>    
         
               </th>
              </tr>
              <tr>
                <th>Model :<font color="#FF0000">*</font></th>
                <th colspan="3">
                
                <div id="model_div">
                <select name="model_code" id="model_code" class="form-control" onChange="getCategory(this.value)">
                  <option value="NULL" placeholder="Select Model"> -- Select Model --</option>
                </select></div>  <div class="form-control-feedback" ><?php echo $message_model; ?></div>
                
              </th>
              </tr>  
            <tr>
            <th>Category : <font color="#FF0000">*</font></th>
            <td colspan="3">
             <div id="catm_div">
                 <select name="stamp_ind" class="form-control" onChange="getWork(this.value)">
                 <option value="NULL" placeholder="Select Category"> -- Select Category -- </option>
                </select></div>
               <div class="form-control-feedback" ><?php echo $message_cat; ?></div> 
		     </td>
             </tr>
            <tr>
            <th>Station : <font color="#FF0000">*</font></th>
            <td colspan="3">
             <div id="work_div">
                 <select name="work_center" class="form-control" onChange="getMaterial(this.value)">
                 <option value="NULL" placeholder="Select Section/Line"> -- Select Section/Line -- </option>
                </select></div>
               <div class="form-control-feedback" ><?php echo $message_work; ?></div> 
		     </td>
             </tr>
             <tr>
            <th>Part No. : <font color="#FF0000">*</font></th>
            <td colspan="3">
            <div id="mat_div"> 
                 <select name="material_no" id="material_no" class="form-control" > 
                  <option value="NULL" placeholder="Select Part Number"> -- Select Part Number --</option>
                 </select></div>
                   <div class="form-control-feedback" ><?php echo $message_mat; ?></div>
		     </td>
             </tr>
              <tr>
                <th><input name="submit3" type="submit" id="submit3" value="+ Add Item" class="btn btn-primary btn-sm"  /></th>
                <th colspan="3">&nbsp;</th>
              </tr>
            
                </table>
            </form>
        
        <?php

     $no = 1;
	 $sloc_to = "";
	 $k = 1;
	 $w = 1;


   
             $query_sql2 = "SELECT *,DATE_FORMAT(posting_date,'%d-%m-%Y') as R FROM scan_prd_creject WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
			 $result_sql2 = mysqli_query($dbc,$query_sql2);
			 $num_1 = mysqli_num_rows($result_sql2);   //how many material are there?
    
		  
		 if ($num_1 > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_1.' record(s).</div>'; 
			 
			 
			 $query_sql2A = "SELECT * FROM scan_prd_creject WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
			 $result_sql2A = mysqli_query($dbc,$query_sql2A);
			 $row_sql2A = mysqli_fetch_array($result_sql2A);
			 
			
    	?>

  
             
      <form action="detail_comp_reject_prd.php?scan_doc=<?php echo (base64_encode($number)); ?>" method="post" name="myform" id="myform"  >
       <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th colspan="3">&nbsp;</th>
            </tr>  
                 <tr>
              <th>Process :  <font color="#FF0000">*</font></th>
              <td colspan="3">
              <select name="proc_reject" id="proc_reject" class="form-control">
                       <option value="NULL" placeholder="Select Process"> -- Select Process --</option>
               
                  <?php
	               $query_proc = "SELECT * FROM proc_reject_detail_prd WHERE id_proc = '1' AND status_proc = 'Y' ORDER BY id_proc ASC";
                   $result_proc = mysqli_query($dbc,$query_proc);
  
                   while($row_proc = mysqli_fetch_array($result_proc)) 
			      {
					  
				   ?>
               
                    <option value="<?php echo html_esc($row_proc["id_proc"]); ?>"<?php if($row_proc["id_proc"] == "1") echo "selected"; ?>>  <?php echo html_esc($row_proc["proc_desc"]); ?></option>
                     
               <?php   
				  
                  }
				?>
              </select>  
              
              
              
               <div class="form-control-feedback" ><?php //echo $message_psdt; ?></div>
              </td>
              </tr>
              
                 <tr>
              <th>Posting Date :  <font color="#FF0000">*</font></th>
              <td colspan="3"><input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php if(isset($_POST['date1'])){ echo html_esc($_POST['date1']); }else{ echo $fmt_curr_date; } ?>" />
               <div class="form-control-feedback" ><?php echo $message_psdt; ?></div>
              </td>
              </tr>
               <tr>
                <th>Shift :  <font color="#FF0000">*</font></th>
                
                <td colspan="2">
                     <div class="form-check">
                   
                        <input class="form-check-input" id="shift_post1" type="radio" name="shift_ops" value="D/S" checked="">Day
                      </div>
                   <div class="form-control-feedback" ><?php echo $message_shift; ?></div>
                    </td>
                <td><div class="form-check">
                        <input class="form-check-input" id="shift_post2" type="radio" name="shift_ops" value="N/S">Night
                    </div><div class="form-control-feedback" ><?php echo $message_shift; ?></div></td> 
              </tr>  
            </table>      
           
           
            
         
               <table class="table table-hover table-bordered" id="example">
               <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>Item.</th>
                    <th>Part Number</th>
                    <th>Part Name</th>
                    <th>Quantity</th>
                    <th>UoM</th>
                    <th>Type of Reject</th>
                    <th>Defectives</th>
                    <th>Reason of Rejection</th>
                    <th>Remark</th>
                    </tr>
              </thead>    
              <tbody>
           <?php 

   $counter = 1;
   $no4 = 1;
   $sta_out = "";
   
   while($row = mysqli_fetch_array($result_sql2))
   {
	   
	    $no4 = sprintf('%04d',$no4);
		
		 
		   if($row["c_vclass"] != "Z202")
		   {
			   ?>
			    <tr>
                <td width="30"><input type="checkbox" id="checkbox" name="e_tcid[]" value="<?php echo html_esc($row["id_scan_dis"]); ?>" class="form-check"></td>
                <td width="30"><?php echo $no4; ?><input name="idd[]" type="hidden" value="<?php echo html_esc($row["id_scan_dis"]); ?>">
                <input name="item_no[<?php echo html_esc($row["id_scan_dis"]); ?>]" type="hidden" value="<?php echo $no4; ?>"></td>
                <td width="100"><?php echo html_esc($row["bill_component"]); ?></td>
                <td width="200"><?php echo html_esc($row["material_desc_c"]); ?></td>
				<td width="100"><?php if($row["scan_uom"] == 'KG'){ ?> <input name="scan_qty[<?php echo html_esc($row["id_scan_dis"]); ?>]" type="number" step="0.001" min="0.001" value="<?php if(isset($_POST["scan_qty"])) { echo html_esc($_POST["scan_qty"][($row["id_scan_dis"])]); }else{ echo html_esc($row["scan_qty"]);  } ?> " id="scan_qty" class="form-control form-control-sm">  <?php }else{ ?><input name="scan_qty[<?php echo html_esc($row["id_scan_dis"]); ?>]" type="number" min="1" value="<?php if(isset($_POST["scan_qty"])) { echo html_esc($_POST["scan_qty"][($row["id_scan_dis"])]); }else{ echo html_esc($row["scan_qty"]);  } ?> " id="scan_qty" class="form-control form-control-sm"><?php } ?>
                 </td>
                <td width="100"><?php echo html_esc($row["scan_uom"]); ?><input name="plant_code2" type="hidden" value="<?php echo html_esc($row["plant_code"]); ?>"></td> 
                
               
             <td width="350">
             
      <select name="type_reject[]" id="type_reject" class="Trejc form-control" >
      <option value="" placeholder="Select Type of Reject"> -- Select Type of Reject --</option>
      <?php
       $query_type = "SELECT * FROM type_reject_detail_prd WHERE id_proc = '1' AND status_type = 'Y' ORDER BY id_type ASC";
       $result_type = mysqli_query($dbc,$query_type);

       while($row_type = mysqli_fetch_array($result_type)) 
       {   
       ?>
       <?php if($_POST["submit4"] == true)  
		         {   ?>
                    <option value="<?php echo html_esc($row_type["id_type"]); ?>"<?php if($row_type["id_type"] == $_POST["type_reject"][($row["id_scan_dis"])]) echo "selected"; ?>>  <?php echo html_esc($row_proc["proc_desc"]); ?></option>
                     
                  <?php
				 }else{
					 
					 ?>
      <option value="<?php echo html_esc($row_type["id_type"]); ?>"> <?php echo html_esc($row_type["type_desc"]); ?></option>
      <?php
				 }//end else
	    
       }
      ?>
  </select>
 
                </td>
                <td width="400">
                  
                      <select name="type_defect[]" class="Tdefc form-control" >
                      	<option value="" placeholder="Select Defective"> -- Select Defective --</option>
                      </select>
                    
                 </td>
                 <td width="400">
              
           <input class="total form-control" id="reason_reject" type="text" name="reason_reject[<?php echo html_esc($row["id_scan_dis"]); ?>]" value="<?php  if(isset($_POST['reason_reject'])){ echo html_esc($_POST["reason_reject"][($row["id_scan_dis"])]); }else{  echo "Out of Standard"; } ?>" >   
           
                </td>
             
                 <td width="400">
                <textarea name="remark_dis[<?php echo html_esc($row["id_scan_dis"]); ?>]" id="remark_dis" rows="2" cols="10" maxlength="250" class="form-control" ><?php if(isset($_POST['remark_dis'])){ echo html_esc($_POST["remark_dis"][($row["id_scan_dis"])]); } ?></textarea>
                </td>
                
            
                 </tr>
			   
			 <?php  
		   }else{
		   
		 
			   ?>
	 
		        <tr bgcolor="#CCCCCC">
                <td width="30">&nbsp;</td>
                <td width="30"><?php echo $no4; ?><!--<input name="idd[<?php echo html_esc($row["id_scan_dis"]); ?>]" type="hidden" value="<?php echo html_esc($row["id_scan_dis"]); ?>">-->
                <input name="item_no[<?php echo html_esc($row["id_scan_dis"]); ?>]" type="hidden" value="<?php echo $no4; ?>"></td>
                <td width="100"><?php echo html_esc($row["bill_component"]); ?></td>
                <td width="200"><?php echo html_esc($row["material_desc_c"]); ?></td>
                <td width="100">&nbsp;</td>
                <td width="100">&nbsp;</td> 
                <td width="350">&nbsp; </td> 
                 <td width="350">&nbsp; </td> 
                 <td width="400">&nbsp; </td> 
                 <td width="400">&nbsp; </td>
                 </tr>
     
            
                 
          <?php 
		  
		  } // end if
		     
		  $no4++;
		  $counter++; // menambah counter
		  $w ++; 
          $k ++;
		     
			  
			  
		  } 
		  
       mysqli_free_result($result_sql2); 		  
		  ?>

</table>  </div> <br><br>
               <!--<input name="submit4" type="submit" id="submit4" value="SUBMIT" class="btn btn-success btn-sm" onclick="return confirm('Are you sure to submit?');" >-->
			   <button type="submit" name="submit4" id="submit4" class="btn btn-success btn-sm">SUBMIT</button>
               <input name="submit5" type="submit" id="submit5" class="btn btn-warning btn-sm" value="CLEAR">
       
<?php  

 }else{
 
?> 

<?php   } ?>


</form>
     
             
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
<!--    <script type="text/javascript">$('#sampleTable').DataTable();</script>--> 
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
    <script type="text/javascript">
          
       $('#PSSDate').datepicker({
		defaultDate: new Date(),
		format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      
	   $('#PSS2Date').datepicker({
		defaultDate: new Date(),   
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      $('#demoSelect').select2();
    </script>
    
      <script language="javascript">
		  $(document).ready(function() {
				$('#example').DataTable( {
					"scrollX": true,
					"lengthMenu": [[ -1], [ "All"]]
				} );
		} );
	  </script>
    
    
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
		
		var strURL="findType-CR.php?plant_code="+plant_code;
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
	
	function getModel(plant_code,material_type) {		
		
		var strURL="findModel-CR.php?plant_code="+plant_code+"&material_type="+material_type;
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
	
	
	
	function getCategory(plant_code,material_type,model_code) {		
		
		var strURL="findCat-CR.php?plant_code="+plant_code+"&material_type="+material_type+"&model_code="+model_code;
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
	
	
	function getWork(plant_code,material_type,model_code,stamp_ind) {		
	
		var strURL="findWork-CR.php?plant_code="+plant_code+"&material_type="+material_type+"&model_code="+model_code+"&stamp_ind="+stamp_ind;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('work_div').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
	
	
	
	
	function getMaterial(plant_code,material_type,model_code,stamp_ind,work_center) {		
	
		var strURL="findMaterial-CR.php?plant_code="+plant_code+"&material_type="+material_type+"&model_code="+model_code+"&stamp_ind="+stamp_ind+"&work_center="+work_center;
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
	}
	
</script>


<!--<script>
$(document).ready(function () { 
    var oTable = $('#example').dataTable({
        stateSave: true
    });

    var allPages = oTable.fnGetNodes();

    $('body').on('click', '#selectAll', function () {
        if ($(this).hasClass('allChecked')) {
            $('input[type="checkbox"]', allPages).prop('checked', false);
        } else {
            $('input[type="checkbox"]', allPages).prop('checked', true);
        }
        $(this).toggleClass('allChecked');
		
    })
	
	
});
</script>-->

<script>
//https://makitweb.com/how-to-autopopulate-dropdown-with-ajax-pdo-and-php/   //
$(document).ready(function() {
	"use strict";

     var oTable = $('#example').dataTable(); 
	 

	//Type of Reject
	/*oTable.$('select[name="proc_reject[]"]',{"page": "all"}).on('change',function () {
	
	var row = $(this).closest("tr");
	var pRejc = row.find(".Pproc").val();

	
	$.post("findDefect-Prd-Creject.php", {
			request: 1, 
			pRejc : pRejc 
		},
		function (data, status) {
			row.find('.Trejc').html(data);
		}
	);
	

	});*/
	
	//Defectiveness
	oTable.$('select[name="type_reject[]"]',{"page": "all"}).on('change',function () {
		
		var row2 = $(this).closest("tr");
		var tRejc = row2.find(".Trejc").val();

		$.post("findDefect-Prd-Creject.php", {
				request: 2, 
				tRejc : tRejc 
			},
			function (data, status) {
				row2.find('.Tdefc').html(data);
			}
		);

	});

	
})();

</script>

<script>
//Submit IPP for approval
//Status changed to submitted
//https://www.youtube.com/watch?v=fGS-Ff3wgXw
//https://stackoverflow.com/questions/29896599/how-can-i-select-all-checkboxes-from-all-the-pages-in-a-jquery-datatable
$(document).on("click", "#submit4", function(event) {  

$('#example').DataTable();  

	if (confirm('Confirm to submit?'))
	{
		var e_tcid = new Array();

		var oTable = $('#example').dataTable();  
		var rowcollection =  oTable.$("#checkbox:checked", {"page": "all"});  
		
		rowcollection.each(function(index,elem) {  
			e_tcid.push($(elem).val());
			
		});    
					

		if(e_tcid.length == 0)
		{
			alert('Please select a component to reject.');
			//location.reload();
		}
	
	}
		
});

</script>

<script>
$(document).ready(function () { 
    /*var oTable2 = $('#examplecp').dataTable({
        stateSave: true
    });*/
	
	var oTable2 = $('#example').dataTable(); 

    var allPages2 = oTable2.fnGetNodes();

    $('body').on('click', '#selectAll', function () {
        if ($(this).hasClass('allChecked')) {
            $('input[type="checkbox"]', allPages2).prop('checked', false);
        } else {
            $('input[type="checkbox"]', allPages2).prop('checked', true);
        }
        $(this).toggleClass('allChecked');
		
    })
	
	
});
</script>

  </body>
</html>