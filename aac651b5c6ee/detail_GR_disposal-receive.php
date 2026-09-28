<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
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
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
    $url = "detail_GR_disposal-receive.php"; 
	
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

//CR status (Pending Approval PPC)
$sta10 = "SELECT * from request_status WHERE status_id = '10'";
$sta_res10 = mysqli_query($dbc,$sta10);
$rst_sta10 = mysqli_fetch_array($sta_res10);

//CR status (Closed)
$sta13 = "SELECT * from request_status WHERE status_id = '13'";
$sta_res13 = mysqli_query($dbc,$sta13);
$rst_sta13 = mysqli_fetch_array($sta_res13);

//CR status (Completed)
$sta14 = "SELECT * from request_status WHERE status_id = '14'";
$sta_res14 = mysqli_query($dbc,$sta14);
$rst_sta14 = mysqli_fetch_array($sta_res14);

//CR status (Pending Approval QC)
$sta24 = "SELECT * from request_status WHERE status_id = '24'";
$sta_res24 = mysqli_query($dbc,$sta24);
$rst_sta24 = mysqli_fetch_array($sta_res24);

//CR status (Deleted)
$sta16 = "SELECT * from request_status WHERE status_id = '16'";
$sta_res16 = mysqli_query($dbc,$sta16);
$rst_sta16 = mysqli_fetch_array($sta_res16);

//CR status (Transfer Posting)
$sta19 = "SELECT * from request_status WHERE status_id = '19'";
$sta_res19 = mysqli_query($dbc,$sta19);
$rst_sta19 = mysqli_fetch_array($sta_res19);	

//CR status (Transfer GRA)
$sta23 = "SELECT * from request_status WHERE status_id = '23'";
$sta_res23 = mysqli_query($dbc,$sta23);
$rst_sta23 = mysqli_fetch_array($sta_res23);	


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
        width: 1700px;
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
          <h1><i class="fa fa-file-text-o"></i> Receiving</h1>
          <p>Disposal</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Receiving</li>
          <li class="breadcrumb-item"><a href="detail_GR_disposal-receive.php">Disposal</a></li>
        </ul>
      </div> 
        
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Disposal </h3>
            <div class="tile-body">
              <div class="table-responsive">
              
  <?php       
  
    $message_pcode = "";
	$message_psdt = "";
	$message_shift = "";
	$message_mat = "";
	$message_ty = "";

	
	$query_id = "SELECT * FROM run_count_itsb WHERE uid = '124'";
	$result_id = mysqli_query($dbc,$query_id);
	
	
	if ($result_id) 
{
	$nrows = mysqli_num_rows($result_id);
	$row_id = mysqli_fetch_array($result_id);
	
	$dht = 000; 
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
	
		
	// check for a barcode ref (scan from FG Tag)
		
			
    if(($_POST["barcode_ref"]) == "")
	 { 	
		   		
			if(($_POST["plant_code"]) == "NULL")
     {
	     $plant_code = FALSE;
		 $message_pcode = '<span class="badge badge-pill badge-danger">Please select Plant!</span>';
	 }else{
		 
		 
		 
			 $query_detail_chk = "SELECT * FROM sc_gra_disposal_ppcrec WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
			 $result_detail_chk = mysqli_query($dbc,$query_detail_chk);
    
			while($data_detail_chk = mysqli_fetch_array($result_detail_chk))
			
			{
				
				if(($data_detail_chk["plant_code"]) != ($_POST["plant_code"]))
				{
					
						  echo "<script>";
						  echo "alert('Wrong batch plant code! Please select correct Plant.');";
						  echo "window.location='detail_GR_disposal-receive.php?scan_doc=$number'";
						  echo "</script>";
						  exit(); //quit the script	
					
				}
				
			}
	     
		      $plant_code = TRUE;	 
		 
	  }
		
		
	 if(($_POST["material_type"]) == "NULL")
     {
	     $material_type = FALSE;
		 $message_ty = '<span class="badge badge-pill badge-danger">Please select Type!</span>';
	 }else{
		 $material_type = TRUE;
	  }
		  
	  if(($_POST["material_no"]) == "NULL")
     {
	     $material_no = FALSE;
		 $message_mat = '<span class="badge badge-pill badge-danger">Please select Part Number!</span>';
	 }else{
		 $material_no = TRUE;
	  }
	  
	   if(($_POST["stamp_ind"]) == "NULL")
     {
	     $stamp_ind = FALSE;
		 $message_cat = '<span class="badge badge-pill badge-danger">Please select Category!</span>';
	 }else{
		 $stamp_ind = TRUE;
	  }
	  
		 if(($_POST["model_code"]) == "NULL")
     {
	     $model_code = FALSE;
		 $message_model = '<span class="badge badge-pill badge-danger">Please select Model!</span>';
	 }else{
		 $model_code = TRUE;
	  }
		


			} //end barcode

if(($barcode_ref) || ($plant_code && $material_no))//everything ok
{  

//checking delete space semasa scanning

$barcode_ref2 = trim($barcode_ref);
			
 
//split dulu pps ref kpd prod_order, material,uom, plant, sloc, qty
$str = $barcode_ref2;

if($str)
{

if(explode('|', $str, 10))
{
list($part1, $part2, $part3, $part4, $part5, $part6, $part7, $part8, $part9, $part10) = (explode('|', $str, 10));	

}else{

list($part1, $part2, $part3, $part4, $part5, $part6, $part7, $part8) = (explode('|', $str, 8));
}
}// end str

          	$plant_code = $_POST["plant_code"];
			$model_code = $_POST["model_code"]; 
			$material_type = $_POST["material_type"]; 
			$stamp_ind = $_POST["stamp_ind"];
			$material_no = $_POST["material_no"];

			
  if($_POST["barcode_ref"] != "")
{ 			
				   
  $query_q2 = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($part1)."'";
  $result_q2 = mysqli_query($dbc,$query_q2) or die (mysqli_error($dbc));
  $ans3 = mysqli_fetch_array($result_q2);
  
  
  //---------detail material_type_tbl (material_type) ----
  
  $query_mtype2 = "SELECT * FROM material_type_tbl WHERE id = '".sql_esc($ans3["mat_type"])."'";
  $result_mtype2 = mysqli_query($dbc,$query_mtype2) or die (mysqli_error($dbc));
  $d_mtype2 = mysqli_fetch_array($result_mtype2);
  
  
  //---------detail model_detail_tbl(model_code) ---
  
  $query_mcode2 = "SELECT * FROM model_detail_tbl WHERE id_model = '".sql_esc($ans3["model_code"])."'";
  $result_mcode2 = mysqli_query($dbc,$query_mcode2) or die (mysqli_error($dbc));
  $d_mcode2 = mysqli_fetch_array($result_mcode2);
  
  
  
             $query_detail_chk = "SELECT * FROM sc_gra_disposal_ppcrec WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
			 $result_detail_chk = mysqli_query($dbc,$query_detail_chk);
    
			while($data_detail_chk = mysqli_fetch_array($result_detail_chk))
			
			{
				
				if(($data_detail_chk["plant_code"]) != ($part2))
				{
					
						  echo "<script>";
						  echo "alert('Wrong batch plant code! Please select correct Plant.');";
						  echo "window.location='detail_GR_disposal-receive.php?scan_doc=$number'";
						  echo "</script>";
						  exit(); //quit the script	
					
				} // end if
			} // end while $data_detail_chk
	     
  
}
  
  $query_q22 = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($material_no)."'";
  $result_q22 = mysqli_query($dbc,$query_q22) or die (mysqli_error($dbc));
  $ans22 = mysqli_fetch_array($result_q22);
				   
				   
  //---------detail material_type_tbl (material_type) ----
  
  $query_mtype = "SELECT * FROM material_type_tbl WHERE id = '".sql_esc($material_type)."'";
  $result_mtype = mysqli_query($dbc,$query_mtype) or die (mysqli_error($dbc));
  $d_mtype = mysqli_fetch_array($result_mtype);
  
  
  //---------detail model_detail_tbl(model_code) ---
  
  $query_mcode = "SELECT * FROM model_detail_tbl WHERE id_model = '".sql_esc($model_code)."'";
  $result_mcode = mysqli_query($dbc,$query_mcode) or die (mysqli_error($dbc));
  $d_mcode = mysqli_fetch_array($result_mcode);
  

if($_POST["barcode_ref"] != "")
{ 
//insert to sc_gra_disposal_ppcrec
//----add for record [status = 'Y' will be generate trans posting running no]

$query_db = "INSERT INTO sc_gra_disposal_ppcrec(id_scan_dis,scan_doc,barcode_ref,material_no,material_desc,plan_no,doc_no,plant_code,scan_sloc,scan_shift,scan_qty,scan_uom,posting_date,scan_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,status,status_dis) VALUES ('','".sql_esc($number)."','".sql_esc($barcode_ref2)."','".sql_esc($part1)."','".strtoupper($ans3["material_desc"])."','".sql_esc($part3)."','".sql_esc($part4)."','".sql_esc($part2)."','".strtoupper($part6)."','','".sql_esc($part7)."','".strtoupper($part8)."','".sql_esc($part5)."',NOW(),'','".sql_esc($d_mcode2["model_code"])."','".sql_esc($d_mtype2["mat_type_id"])."','".sql_esc($stamp_ind)."','','".sql_esc($username)."', NOW(),'N','".sql_esc($rst_sta["status_desc"])."')";
$result_db = mysqli_query($dbc,$query_db) or die (mysqli_error($dbc));

}elseif($_POST["barcode_ref"] == "")
{
//insert to sc_gra_disposal_ppcrec
//----add for record [status = 'Y' will be generate trans posting running no]

$query_db = "INSERT INTO sc_gra_disposal_ppcrec(id_scan_dis,scan_doc,barcode_ref,material_no,material_desc,plan_no,doc_no,plant_code,scan_sloc,scan_shift,scan_qty,scan_uom,posting_date,scan_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,status,status_dis) VALUES ('','".sql_esc($number)."','','".sql_esc($material_no)."','".strtoupper($ans22["material_desc"])."','','','".sql_esc($plant_code)."','2344','','','".sql_esc($ans22["BUn"])."','',NOW(),'','".sql_esc($d_mcode["model_code"])."','".sql_esc($d_mtype["mat_type_id"])."','".sql_esc($stamp_ind)."','','".sql_esc($username)."', NOW(),'N','".sql_esc($rst_sta["status_desc"])."')";
$result_db = mysqli_query($dbc,$query_db) or die (mysqli_error($dbc));

}



            if($result_db)
             {
			 
			echo "<script>";
			echo "window.location='detail_GR_disposal-receive.php?scan_doc=$number&&barcode_ref=".html_esc($barcode_ref)."&&plant_code=$plant_code&&model_code=$model_code&&material_type=$material_type&&stamp_ind=$stamp_ind&&material_no=$material_no'";
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


      
	   $scan_doc = $number;  
	   $scan_qty = $_POST["scan_qty"]; 
	   $sloc_rej = $_POST["sloc_rej"]; 
	   $item_no = $_POST["item_no"];
	   $id_dis = $_POST["id_dis"];  
	   $plant_code2 = $_POST["plant_code2"]; 
	   $remark_dis = $_POST["remark_dis"];
	   $dateF = $_POST["date1"];
	   $work_center = $_POST["work_center"];
	   $shift_ops = $_POST["shift_ops"];
	   $type_reject = $_POST["type_reject"];
	   $type_defect = $_POST["type_defect"];
	   $reason_reject  = $_POST["reason_reject"];
	   $proc_reject  = $_POST["proc_reject"];
	   
	   
	   
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
		 $message_shift = '<span class="badge badge-pill badge-danger">Please select Shift Posting!</span>';
	 }else{
		 $shift_ops = TRUE;
	  }
	   
	   foreach($_POST["id_dis"] as $j=>$i) {
		   
	     /*echo $_POST["item_no"][$i];  echo "<br>";
	     echo $_POST["scan_qty"][$i];  echo "<br>";
		 echo $_POST["sloc_rej"][$i];  echo "<br>";
		 echo $_POST["work_center"][$i];  echo "<br>";
	     echo $_POST["type_reject"][$i];  echo "<br>";
		 echo $_POST["type_defect"][$i];  echo "<br>";
	     echo $_POST["reason_reject"][$i];  echo "<br>";*/
		
	   
	       if(($_POST["scan_qty"][$i]) == "")
	      { 
		     $scan_qty = FALSE;
		  }else{
		     $scan_qty = TRUE;
	 				
		   }//end if
		   
		   if(($_POST["sloc_rej"][$i]) == "NULL")
	      { 
		     $sloc_rej = FALSE;
				
		   }else{
		     $sloc_rej = TRUE;
	 				
		   }//end if
		   
		   
		    if(($_POST["work_center"][$i]) == "NULL")
	      { 
		     $work_center = FALSE;
				
		   }else{
		     $work_center = TRUE;
	 				
		   }//end if
		   
		    if(($_POST["proc_reject"]) == "NULL")
	       { 
		     $proc_reject = FALSE;
				
		   }else{
		     $proc_reject = TRUE;
	 				
		   }//end if
		   
		  if(($_POST["type_reject"]) == "")
	      { 
		     $type_reject = FALSE;
				
		   }else{
		     $type_reject = TRUE;
	 				
		   }//end if
		   
		   
		  if(($_POST["type_defect"]) == "")
	      { 
		     $type_defect = FALSE;
				
		   }else{
		     $type_defect = TRUE;
	 				
		   }//end if
		   
		  
	     }//for each
	 		

  if($dateF && $shift_ops && $scan_qty && $sloc_rej && $work_center && $proc_reject && $type_reject && $type_defect)
  {
		   
	   //-------------------generate gra QC doc no.---------------
	
	 if($_POST["plant_code2"] == '3100')
	{
	
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '33'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	}elseif($_POST["plant_code2"] == '3101')
	{
		
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '82'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
		
	}
	
	if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 00000; 
	$dht_OK2 = "371";
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
	
    $ref = (($row_id2["start_ref"]).$dht_OK2.$date_run.($number2));
	  
	
	} // end if $result_id2
	
	 //update count_max----------------------------------------
	 
	  if($_POST["plant_code2"] == '3100')
	{
  
       $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '33'";
	   $result_max_a = mysqli_query($dbc,$query_max_a);
	   
	   $query_max_a1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '124'";
	   $result_max_a1 = mysqli_query($dbc,$query_max_a1);

	}elseif($_POST["plant_code2"] == '3101')
	{
	   $query_max_b = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '82'";
	   $result_max_b = mysqli_query($dbc,$query_max_b);
	   
	   $query_max_a1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '124'";
	   $result_max_a1 = mysqli_query($dbc,$query_max_a1);
	}

   //end update count_max ---------------------------------	
		
		$amount = "";
		$amount2 = "";
		$amount3 = "";
		$amount4 = "";
		$amount5 = "";
		$amount6 = "";
		$amount7 = "";
		$amount8 = "";
		$amount9 = "";
		$amount10 = "";
	    $how_many = count($id_dis); 
		
		$item_no = $_POST["item_no"]; 
		$scan_qty = $_POST["scan_qty"]; 
	    $sloc_rej = $_POST["sloc_rej"]; 
		$id_dis = $_POST["id_dis"]; 
		$remark_dis = $_POST["remark_dis"];
		$work_center = $_POST["work_center"];
		$shift_ops = $_POST["shift_ops"];
	   // $type_reject = $_POST["type_reject"];
		//$type_defect = $_POST["type_defect"];
	    $reason_reject  = $_POST["reason_reject"];
		$proc_reject  = $_POST["proc_reject"];
		
		$dateF = $_POST["date1"];
		
		           //----format date---- 
		         $ddF = substr($_POST["date1"],0,2);
				 $mmF = substr($_POST["date1"],3,2);
				 $yyF = substr($_POST["date1"],6,4);
			
			     $date_final = ($yyF.'-'.$mmF.'-'.$ddF);
				
				 
	/* for($i = 0; $i < count($_POST["type_reject"]); $i++)  
	{
		
		
		$type_rejectX = $_POST["type_reject"];
		$type_defectX = $_POST["type_defect"];
		
		 echo "type hhhh :".$type_rejectX[$i]; echo "</br>";
		
		 echo "defect : ".$type_defectX[$i]; echo "</br>";
		
		
		
		$apaFirst = $_POST['achv_ed'];
		$apaScd = $_POST['defect'];
		
		$ch_temp = "INSERT INTO type_reject_test(first,second,third)
						VALUES ('".$apaFirst[$i]."','".$apaScd[$i]."','') ";
						
		$rs_chtemp = mysql_query($ch_temp) or die (mysql_error());
	
	}
		*/		 
				 
				 
		

       foreach($_POST["id_dis"] as $j=>$i) {
		   
		$azieTest =  (($_POST["sloc_rej"][$i]).';');
	    $amount .= (($_POST["scan_qty"][$i]).';');
		$amount2 .= $azieTest;
		$amount3 .= (($_POST["item_no"][$i]).';');
		$amount4 .= (($_POST["id_dis"][$i]).';');
		$amount5 .= (($_POST["remark_dis"][$i]).';');
		$amount6 .= (($_POST["work_center"][$i]).';');
		$amount7 .= (($_POST["type_reject"][$i]).';');
		$amount8 .= (($_POST["reason_reject"][$i]).';');
		$amount9 .= (($_POST["type_defect"][$i]).';');
		$amount10 .= (($_POST["proc_reject"][$i]).';');
		
		//-----checking barcode GR Tag
		
		$string = explode(";",($amount));	
		$string2 = explode(";",($amount2));	
		$string3 = explode(";",($amount3));
		$string4 = explode(";",($amount4));
		$string5 = explode(";",($amount5));
		$string6 = explode(";",($amount6));
		$string7 = explode(";",($amount7));
		$string8 = explode(";",($amount8));
		$string9 = explode(";",($amount9));
		$string10 = explode(";",($amount10));
	
        }
		
		
		
		
	    $i = "";
		 			
		  for ($i=0; $i< $how_many; $i++) { 
		   
		  //  $bar_gr2 = trim($string2[$i],"\t");
			
		
		 //split dulu pps ref kpd prod_order, material,uom, plant, sloc, qty
			//$str_tp = $bar_gr2;
			
			
			
			/*if($str_tp)
			{
			
			
			list($part1, $part2, $part3, $part4, $part5, $part6, $part7, $part8, $part9, $part10) = (explode('|', $str_tp, 10));
		
			}
	*/
		   
		//	echo $part4;  echo "<br>"; 
		/* echo $string[$i]; echo "</br>";
		 echo $string2[$i]; echo "</br>";
		 echo $string3[$i]; echo "</br>";
		 echo $string4[$i]; echo "</br>";
		 echo $string5[$i]; echo "</br>";
		 echo $string6[$i]; echo "</br>";
		 echo $string7[$i]; echo "</br>";
		 echo $string8[$i]; echo "</br>";
		 echo $string9[$i]; echo "</br>";
		 echo $string10[$i]; echo "</br>";
		  */
		 
		 
		 //echo "reason :".$string8[$i]; echo "</br>";
		 
		 //add post dropdown
		$proc_rejectX = $_POST["proc_reject"];  
		$type_rejectX = $_POST["type_reject"];
		$type_defectX = $_POST["type_defect"];

		
		/* echo "type :".$type_rejectX[$i]; echo "</br>";
		
		 echo "defect : ".$type_defectX[$i]; echo "</br>";*/
		 
		
		
		$query_update_scan2 = "UPDATE sc_gra_disposal_ppcrec SET scan_qty = '".sql_esc($string[$i])."',scan_shift = '".sql_esc($shift_ops)."', shift_day = '".sql_esc($shift_ops)."', posting_date = '".sql_esc($date_final)."' WHERE id_scan_dis = '".sql_esc($string4[$i])."'";
	    $rst_update_scan2 = mysqli_query($dbc,$query_update_scan2);
		
		
		 $query_dtl_chk2 = "SELECT * FROM sc_gra_disposal_ppcrec WHERE id_scan_dis = '".sql_esc($string4[$i])."'";
		 $result_dtl_chk2 = mysqli_query($dbc,$query_dtl_chk2);
		 $row_info = mysqli_fetch_array($result_dtl_chk2);
		
	     //----get cost center ----
		  $query_wctr = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($string6[$i])."'";
		  $result_wctr = mysqli_query($dbc,$query_wctr);
		  $row_wctr = mysqli_fetch_array($result_wctr);
		
		//---------insert data at table gra_disposal_ppcrec_detail - status part = 'WS'
		
		  $query_storeD = "INSERT INTO gra_disposal_ppcrec_detail(id_dis,doc_dis,id_scan_dis,scan_doc,item_no,material_no,material_desc,plan_no,doc_no,comp_code,plant_code,sloc_from,sloc_to,qty_dis,uom_dis,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_dis,date_generate_dis,time_generate_dis,ref_doc_dis,user_cancel,date_cancel,remark_cancel,status_ftp,status_tran,status_dis,sloc_rej,work_center,proc_reject,type_reject,type_defect,reason_reject,remark_dis,status_approved1,hod_approved1,date_approved1,remark_approved1,status_approved2,hod_approved2,date_approved2,remark_approved2,status_approved3,hod_approved3,date_approved3,remark_approved3,status_approved4,hod_approved4,date_approved4,remark_approved4,status_part,cost_center,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($ref)."','".sql_esc($row_info["id_scan_dis"])."','".sql_esc($number)."','".sql_esc($string3[$i])."','".sql_esc($row_info["material_no"])."','".sql_esc($row_info["material_desc"])."','".sql_esc($row_info["plan_no"])."','".sql_esc($row_info["doc_no"])."','".sql_esc($row_info["plant_code"])."','".sql_esc($_POST["plant_code2"])."','".sql_esc($row_info["scan_sloc"])."','".sql_esc($string2[$i])."','".sql_esc($string[$i])."','".strtoupper($row_info["scan_uom"])."','".sql_esc($date_final)."','".sql_esc($row_info["scan_shift"])."','".sql_esc($row_info["model_code"])."','".sql_esc($row_info["material_type"])."','".sql_esc($row_info["stamp_ind"])."','".sql_esc($row_info["slip_no"])."','".sql_esc($row_info["user_create"])."','".sql_esc($row_info["date_create"])."','".sql_esc($username)."',NOW(),NOW(),'','','','','N','Y','".sql_esc($rst_sta10["status_desc"])."','".sql_esc($string2[$i])."','".sql_esc($string6[$i])."','".sql_esc($proc_rejectX[$i])."','".sql_esc($type_rejectX[$i])."','".sql_esc($type_defectX[$i])."','".sql_esc($string8[$i])."','".sql_esc($string5[$i])."','','','','','','','','','','','','','','','','','WS','".sql_esc($row_wctr["cost_center"])."','','')";            
		  $rst_storeD = mysqli_query($dbc,$query_storeD);
		

		//---update status "yes" for generate diposal PPC Receiving----
		
		$query_update_scan = "UPDATE sc_gra_disposal_ppcrec SET status = 'Y', status_dis = '".sql_esc($rst_sta10["status_desc"])."' WHERE id_scan_dis = '".sql_esc($string4[$i])."'";
	    $rst_update_scan = mysqli_query($dbc,$query_update_scan);
		
		
		//---------------update at table disposal_detail_prd_all [prod - ppc receiving - ppc delivery - qc - coo ]----------
		
	     $query_chk_info = "SELECT * FROM gra_disposal_ppcrec_detail WHERE id_scan_dis = '".sql_esc($string4[$i])."'";
		 $result_chk_info =  mysqli_query($dbc,$query_chk_info);
		 $row_chk_info = mysqli_fetch_array($result_chk_info);
		 
		
		$query_ins_dis = "INSERT INTO disposal_detail_prd_all(id,id_disposal,doc_dis,doc_disposal_no,bflush_hwork,bflush_rework,bflush_pending,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit,comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,reject_source,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_chk_info["id_dis"])."','".sql_esc($row_chk_info["doc_dis"])."','".sql_esc($row_chk_info["item_no"])."','','','','".sql_esc($row_chk_info["doc_no"])."','".sql_esc($row_chk_info["plan_no"])."','".sql_esc($row_chk_info["id_scan_dis"])."','".sql_esc($row_chk_info["material_no"])."','".sql_esc($row_chk_info["material_desc"])."','".sql_esc($row_chk_info["material_type"])."','".sql_esc($row_chk_info["model_code"])."','".sql_esc($row_info["scan_qty"])."','','','','".sql_esc($row_chk_info["qty_dis"])."','','','".sql_esc($row_chk_info["uom_dis"])."','".sql_esc($row_chk_info["comp_code"])."','".sql_esc($row_chk_info["work_center"])."','".sql_esc($row_chk_info["shift_day"])."','".sql_esc($row_info["scan_date"])."','".sql_esc($row_chk_info["user_generate_dis"])."','".sql_esc($row_chk_info["date_generate_dis"])."','".sql_esc($row_chk_info["time_generate_dis"])."','".sql_esc($row_chk_info["status_dis"])."','".sql_esc($row_chk_info["sloc_rej"])."','".sql_esc($row_chk_info["sloc_rej"])."','".sql_esc($row_chk_info["sloc_rej"])."','".sql_esc($row_chk_info["proc_reject"])."','".sql_esc($row_chk_info["type_reject"])."','".sql_esc($row_chk_info["type_defect"])."','".sql_esc($row_chk_info["reason_reject"])."','".sql_esc($row_chk_info["user_reject"])."','".sql_esc($row_chk_info["date_reject"])."','".sql_esc($row_chk_info["time_reject"])."','','','','','','','".sql_esc($row_chk_info["user_create"])."','".sql_esc($row_chk_info["date_create"])."','".sql_esc($row_chk_info["remark_dis"])."','".sql_esc($row_chk_info["status_part"])."','','','".sql_esc($row_chk_info["status_approved1"])."','".sql_esc($row_chk_info["hod_approved1"])."','".sql_esc($row_chk_info["date_approved1"])."','".sql_esc($row_chk_info["remark_approved1"])."','".sql_esc($row_chk_info["status_approved2"])."','".sql_esc($row_chk_info["hod_approved2"])."','".sql_esc($row_chk_info["date_approved2"])."','".sql_esc($row_chk_info["remark_approved2"])."','".sql_esc($row_chk_info["status_approved3"])."','".sql_esc($row_chk_info["hod_approved3"])."','".sql_esc($row_chk_info["date_approved3"])."','".sql_esc($row_chk_info["remark_approved3"])."','".sql_esc($row_chk_info["status_approved4"])."','".sql_esc($row_chk_info["hod_approved4"])."','".sql_esc($row_chk_info["date_approved4"])."','".sql_esc($row_chk_info["remark_approved4"])."','','','','','".sql_esc($row_chk_info["cost_center"])."','".sql_esc($row_wctr["id_factory"])."','".sql_esc($row_chk_info["ref_doc_dis"])."','".sql_esc($row_chk_info["user_cancel"])."','".sql_esc($row_chk_info["date_cancel"])."','".sql_esc($row_chk_info["remark_cancel"])."','".sql_esc($row_chk_info["plant_code"])."','".sql_esc($row_chk_info["shift_day"])."','".sql_esc($row_info["stamp_ind"])."','','','','".sql_esc($row_chk_info["SAP_ref_doc"])."','".sql_esc($row_chk_info["SAP_ref_doc_can"])."')";
$result_ins_dis = mysqli_query($dbc,$query_ins_dis); 
			
		

		
		
	}//end for loop
     
	   
	   
	   
	
   
  // $ref_GRA = (base64_encode($ref));
   
    echo '<script type="text/javascript">';
	echo "alert('Material Document $ref posted.');";
	echo "window.location='detail_GR_disposal-receive.php';"; 
	echo "</script>";
	exit(); //quit the script

	
	 }//end ifelse "OK"
     else{
	   
    echo '<script type="text/javascript">';
	echo "alert('Error! Transaction failed. Please enter field correctly.');";
	echo "window.location='detail_GR_disposal-receive.php';"; 
	echo "</script>";
	exit(); //quit the script
	   
	   
   }
}// end submit 4



if(isset($_POST["submit5"])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

//-----------delete all data current screen-------------

   $query_delete_scan = "DELETE FROM sc_gra_disposal_ppcrec WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
   $result_delete_scan = mysqli_query($dbc,$query_delete_scan);

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
                <th>Barcode : &nbsp;&nbsp;<i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="1.Goods Receipt Tag <br> 2.Panel Slip <br> 3.Handwork Slip <br> 4.Finished Goods Tag <br> 5. Goods Return Advise" data-html="true" data-placement="left"></i></th>
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
                 <select name="stamp_ind" class="form-control" onChange="getMaterial(this.value)">
                 <option value="NULL" placeholder="Select Category"> -- Select Category -- </option>
                </select></div>
               <div class="form-control-feedback" ><?php echo $message_cat; ?></div> 
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


   
             $query_sql2 = "SELECT *,DATE_FORMAT(posting_date,'%d-%m-%Y') as R FROM sc_gra_disposal_ppcrec WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
			 $result_sql2 = mysqli_query($dbc,$query_sql2);
			 $num_1 = mysqli_num_rows($result_sql2);   //how many material are there?
    
		  
		 if ($num_1 > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_1.' record(s).</div>'; 
	   
        
    	?>

                     
           <form action="detail_GR_disposal-receive.php?scan_doc=<?php echo (base64_encode($number)); ?>" method="post" name="myform" id="myform">
           
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th colspan="3">&nbsp;</th>
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
           
          
           <br>
           
                <table class="table table-hover table-bordered" id="example">
               <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Item.</th>
                    <th>Part Number</th>
                    <th>Part Name</th>
                    <th>Quantity</th>
                    <th>UoM</th>
                    <th>SLoc</th>
                    <th>Section</th>
                    <th>Process</th>
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
	  
		
      ?>
                <tr>
                <td width="30"><a href="delete_dis_rec_item.php?scan_doc=<?php echo html_esc($row["scan_doc"]); ?>&&p_id=<?php echo html_esc($row["id_scan_dis"]); ?>&&barcode_ref=<?php echo html_esc($row["barcode_ref"]); ?>&&plant_code=<?php echo html_esc($row["plant_code"]); ?>&&shift_ops=<?php echo html_esc($row["scan_shift"]); ?>&&model_code=<?php $row["model_code"]; ?>&&material_type=<?php echo html_esc($row["material_type"]); ?>&&stamp_ind=<?php echo html_esc($row["stamp_ind"]); ?>&&material_no=<?php echo html_esc($row["material_no"]); ?>" onClick="return confirm('Are you sure you want to delete?')"><img src="../images/delete.png" alt="Remove Item"></a></td>
                <td width="30"><?php echo $no4; ?><input name="id_dis[<?php echo html_esc($row["id_scan_dis"]); ?>]" type="hidden" value="<?php echo html_esc($row["id_scan_dis"]); ?>">
                <input name="item_no[<?php echo html_esc($row["id_scan_dis"]); ?>]" type="hidden" value="<?php echo $no4; ?>"></td>
                <td width="80"><?php echo html_esc($row["material_no"]); ?></td>
                <td width="200"><?php echo html_esc($row["material_desc"]); ?></td>
                <td width="300"> <input name="scan_qty[<?php echo html_esc($row["id_scan_dis"]); ?>]" type="number" min="1" value="<?php if(isset($_POST["scan_qty"])) { echo html_esc($_POST["scan_qty"][($row["id_scan_dis"])]); } ?>" id="scan_qty" class="form-control form-control-sm">
                 </td>
                <td width="80"><?php echo html_esc($row["scan_uom"]); ?></td> 
                 <td width="350">
                  <select name="sloc_rej[<?php echo html_esc($row["id_scan_dis"]); ?>]" id="sloc_rej" class="form-control">
                       <option value="NULL" placeholder="Select Storage Location"> -- Select Storage Location --</option>
               
                  <?php
	               $query_sect = "SELECT * FROM sloc_tbl WHERE plant_code = '".sql_esc($row["plant_code"])."' ORDER BY sloc_id ASC";
                   $result_sect = mysqli_query($dbc,$query_sect);
  
                   while($row_sect = mysqli_fetch_array($result_sect)) 
			      {
					  
				   ?>
                     <?php if($_POST["submit4"] == true)  
		         {   ?>
                    <option value="<?php echo html_esc($row_sect["sloc_code"]); ?>"<?php if($row_sect["sloc_code"] == $_POST["sloc_rej"][($row["id_scan_dis"])]) echo "selected"; ?>> <?php echo html_esc($row_sect["sloc_code"]); ?> - <?php echo html_esc($row_sect["sloc_desc"]); ?></option>
                     
                  <?php
				 }else{
				  
				  ?> 
                  <option value="<?php echo html_esc($row_sect["sloc_code"]); ?>"> <?php echo html_esc($row_sect["sloc_code"]); ?> - <?php echo html_esc($row_sect["sloc_desc"]); ?></option>
                  <?php
				    }  // else
				  
                  }
				?>
              </select>      
                 
                 
           
                 
                 </td>
                <td width="350">
                      
                <select name="work_center[<?php echo html_esc($row["id_scan_dis"]); ?>]" id="work_center" class="form-control">
                <option value="NULL" placeholder="Select Section"> -- Select Section --</option>
            <?php
                 $query4 = "SELECT * FROM work_center_detail WHERE plant_code = '".sql_esc($row["plant_code"])."' ORDER BY id_work ASC";
                 $result4 =mysqli_query($dbc,$query4);  
				 
				 while($row4=mysqli_fetch_array($result4)) 
			      {
					  if($_POST['submit4'] == true)
						{ ?>
                       <option value="<?php echo html_esc($row4["id_work"]); ?>" <?php if($row4["id_work"] == $_POST["work_center"][($row["id_scan_dis"])]) {  echo "selected"; } ?> > <?php echo stripslashes($row4["wc_desc"]); ?></option>                    
				<?php	}else{
						?>
					  
                <option value="<?php echo html_esc($row4["id_work"]); ?>"><?php echo stripslashes($row4["wc_desc"]); ?></option>
                <?php
                  }
				  
				  }
				  
				  ?>
					</select>
          

        <input name="plant_code2" type="hidden" value="<?php echo html_esc($row["plant_code"]); ?>">
                </td>
                  <td width="350">
                  <!--<select name="proc_reject[<?php echo html_esc($row["id_scan_dis"]); ?>]" id="proc_reject" class="form-control">-->
                  <select name="proc_reject[]" id="proc_reject" class="Pproc form-control">
                       <option value="NULL" placeholder="Select Process"> -- Select Process --</option>
               
                  <?php
	               $query_proc = "SELECT * FROM proc_reject_detail_ppc WHERE  status_proc = 'Y' ORDER BY id_proc ASC";
                   $result_proc = mysqli_query($dbc,$query_proc);
  
                   while($row_proc = mysqli_fetch_array($result_proc)) 
			      {
					  
				   ?>
                     <?php if($_POST["submit4"] == true)  
		         {   ?>
                    <option value="<?php echo html_esc($row_proc["id_proc"]); ?>"<?php if($row_proc["id_proc"] == $_POST["id_ploc"][($row["id_scan_dis"])]) echo "selected"; ?>>  <?php echo html_esc($row_proc["proc_desc"]); ?></option>
                     
                  <?php
				 }else{
				  
				  ?> 
                  <option value="<?php echo html_esc($row_proc["id_proc"]); ?>"> <?php echo html_esc($row_proc["proc_desc"]); ?></option>
                  <?php
				    }  // else
				  
                  }
				?>
              </select>      
                 </td>
             <td width="350">
             
              <select name="type_reject[]" class="Trejc form-control">
            	<option value="NULL">-- Select Type of Reject --</option>
            </select>
             
             <!--<select name="type_reject[]" id="type_reject" class="qty form-control" >
                  <option value="" placeholder="Select Type of Reject"> -- Select Type of Reject --</option>
                  <?php
	               $query_type = "SELECT * FROM type_reject_detail_ppc WHERE status_type = 'Y' ORDER BY id_type ASC";
                   $result_type = mysqli_query($dbc,$query_type);
  
                   while($row_type = mysqli_fetch_array($result_type)) 
			      {
					  
				   ?>
                   
                  <option value="<?php echo html_esc($row_type["id_type"]); ?>"> <?php echo html_esc($row_type["type_desc"]); ?></option>
                  <?php
				
				  
                  }
				?>
              </select>-->
                </td>
                <td width="400">
                  
                      <select name="type_defect[]" class="Tdefc form-control" >
                      	<option value="NULL" placeholder="Select Defective"> -- Select Defective --</option>
                      </select>
                    
                 </td>
                 <td width="400">
              
           <input class="total form-control" id="reason_reject" type="text" name="reason_reject[<?php echo html_esc($row["id_scan_dis"]); ?>]"  value="<?php  if(isset($_POST['reason_reject'])){ echo html_esc($_POST["reason_reject"][($row["id_scan_dis"])]); }else{  echo "Out of Standard"; } ?>" />  
           
                </td>
             
                 <td width="400">
                <textarea name="remark_dis[<?php echo html_esc($row["id_scan_dis"]); ?>]" id="remark_dis" rows="2" cols="10" maxlength="250" class="form-control" ><?php if(isset($_POST['remark_dis'])){ echo html_esc($_POST["remark_dis"][($row["id_scan_dis"])]); } ?></textarea>
                </td>
                
                </tr>
                 
          <?php 
		  
		  $no4++;
		  $counter++; // menambah counter
		  $w ++; 
          $k ++;

		  } 
		  
       mysqli_free_result($result_sql2); 		  
		  ?>
</tbody>
</table> </div><br><!--
         <div class="form-actions">-->
               <input name="submit4" type="button" id="submit4" value="SUBMIT" class="btn btn-success btn-sm">
               <input name="submit5" type="submit" id="submit5" class="btn btn-warning btn-sm" value="CLEAR">
          <!-- </div>-->
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
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">$('#example').DataTable();</script>
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
		
		var strURL="findType-DIS-rec.php?plant_code="+plant_code;
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
		
		var strURL="findModel-DIS-rec.php?plant_code="+plant_code+"&material_type="+material_type;
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
		
		var strURL="findCat-DIS-rec.php?plant_code="+plant_code+"&material_type="+material_type+"&model_code="+model_code;
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
	
	
	
	
	function getMaterial(plant_code,material_type,model_code,stamp_ind) {		
	
		var strURL="findMaterial-DIS-rec.php?plant_code="+plant_code+"&material_type="+material_type+"&model_code="+model_code+"&stamp_ind="+stamp_ind;
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

<script>
<!--https://makitweb.com/how-to-autopopulate-dropdown-with-ajax-pdo-and-php/-->
$(document).ready(function() {
	"use strict";

	var oTable = $('#example').dataTable(); 
	
	//Type of Reject
	oTable.$('select[name="proc_reject[]"]',{"page": "all"}).on('change',function () {
	
	var row = $(this).closest("tr");
	var pRejc = row.find(".Pproc").val();

	
	$.post("findDefect-Rec.php", {
			request: 1, 
			pRejc : pRejc 
		},
		function (data, status) {
			row.find('.Trejc').html(data);
		}
	);
	

	});
	
	//Defectiveness
	oTable.$('select[name="type_reject[]"]',{"page": "all"}).on('change',function () {
		
		var row2 = $(this).closest("tr");
		var tRejc = row2.find(".Trejc").val();

		$.post("findDefect-Rec.php", {
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
$(document).ready(function() {
  const form = document.querySelector("#myform");
  const submitBtn = document.querySelector("#submit4");

  submitBtn.addEventListener("click", function () {
    let isValid = true;
    let table = $('#example').DataTable();
    let rows = Array.from(table.rows().nodes()); // includes all paginated rows

    rows.forEach(function (row) {
      const proc = row.querySelector("select[name='proc_reject[]']");
      const type = row.querySelector("select[name='type_reject[]']");
      const def = row.querySelector("select[name='type_defect[]']");
      const reason = row.querySelector("input[name^='reason_reject']");

      if (
        !proc?.value || proc.value === "NULL" ||
        !type?.value || type.value === "NULL" ||
        !def?.value || def.value === "NULL" ||
        !reason?.value.trim()
      ) {
        isValid = false;
        row.style.backgroundColor = "#fff3cd";
      } else {
        row.style.backgroundColor = "";
      }
    });

    if (!isValid) {
      alert("Please complete all required fields.");
    } else {
      if (confirm("Are you sure to submit?")) {
        // prevent browser HTML5 validation interference
        form.noValidate = true;
		const hiddenSubmitInput = document.createElement("input");
		hiddenSubmitInput.type = "hidden";
		hiddenSubmitInput.name = "submit4";
		hiddenSubmitInput.value = "1";
		form.appendChild(hiddenSubmitInput);
        // delay submit to allow DOM updates
        setTimeout(() => {
          form.submit();
        }, 0);
      }
    }
  });
});
</script>


  </body>
</html>