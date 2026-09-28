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

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
    $url = "prog_trn-posting.php"; 
	
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

//CR status (Deleted)
$sta16 = "SELECT * from request_status WHERE status_id = '16'";
$sta_res16 = mysqli_query($dbc,$sta16);
$rst_sta16 = mysqli_fetch_array($sta_res16);

//CR status (Transfer Posting)
$sta19 = "SELECT * from request_status WHERE status_id = '19'";
$sta_res19 = mysqli_query($dbc,$sta19);
$rst_sta19 = mysqli_fetch_array($sta_res19);	


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
div.dataTables_wrapper {
        width: 1000px;
        margin: 0 auto;
    }
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
</style> 
<style>
.shortenedSelect {
    max-width: 300px;
}

</style>
<style>
input[value="+ Scan Item"]{
  display:none;
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
          <h1><i class="fa fa-truck"></i> Progress</h1>
          <p>Transfer Posting</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Progress</li>
          <li class="breadcrumb-item"><a href="prog_trn-posting.php">Transfer Posting</a></li>
        </ul>
      </div> 
        
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Transfer Posting</h3>
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
	
	$query_id = "SELECT * FROM run_count_itsb WHERE uid = '110'";
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
		 
		 
		 
			 $query_detail_chk = "SELECT * FROM scan_tp_store WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
			 $result_detail_chk = mysqli_query($dbc,$query_detail_chk);
    
			while($data_detail_chk = mysqli_fetch_array($result_detail_chk))
			
			{
				
				if(($data_detail_chk["plant_code"]) != ($_POST["plant_code"]))
				{
					
						  echo "<script>";
						  echo "alert('Wrong batch plant code! Please select correct Plant.');";
						  echo "window.location='prog_trn-posting.php?scan_doc=$number'";
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
		
		
					
		
   
			} //end barcode

if(($barcode_ref) || ($material_type && $plant_code && $material_no && $stamp_ind && $model_code))//everything ok
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


}else
{

list($part1, $part2, $part3, $part4, $part5, $part6, $part7, $part8) = (explode('|', $str, 8));
}

} //end if $str

          	$plant_code = $_POST["plant_code"];
			$model_code = $_POST["model_code"]; 
			$material_type = $_POST["material_type"]; 
			$stamp_ind = $_POST["stamp_ind"];
			$material_no = $_POST["material_no"];

			
  if($_POST["barcode_ref"] != "")
{ 			
				   
  $query_q2 = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ?", [$part1]);
  $result_q2 = db_query($dbc, $query_q2) or die (mysqli_error($dbc));
  $ans3 = mysqli_fetch_array($result_q2);
  
   //---------detail material_type_tbl (material_type) ----
  
  $query_mtype2 = new PreparedSql("SELECT * FROM material_type_tbl WHERE id = ?", [$ans3["mat_type"]]);
  $result_mtype2 = db_query($dbc, $query_mtype2) or die (mysqli_error($dbc));
  $d_mtype2 = mysqli_fetch_array($result_mtype2);
  
  
  //---------detail model_detail_tbl(model_code) ---
  
  $query_mcode2 = new PreparedSql("SELECT * FROM model_detail_tbl WHERE id_model = ?", [$ans3["model_code"]]);
  $result_mcode2 = db_query($dbc, $query_mcode2) or die (mysqli_error($dbc));
  $d_mcode2 = mysqli_fetch_array($result_mcode2);
  
  
  
             $query_detail_chk = "SELECT * FROM scan_tp_store WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
			 $result_detail_chk = mysqli_query($dbc,$query_detail_chk);
    
			while($data_detail_chk = mysqli_fetch_array($result_detail_chk))
			
			{
				
				if(($data_detail_chk["plant_code"]) != ($part2))
				{
					
						  echo "<script>";
						  echo "alert('Wrong batch plant code! Please select correct Plant.');";
						  echo "window.location='prog_trn-posting.php?scan_doc=$number'";
						  echo "</script>";
						  exit(); //quit the script	
					
				} // end if
				
				
			} // end while $data_detail_chk
	     
  
}
  
  $query_q22 = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ?", [$material_no]);
  $result_q22 = db_query($dbc, $query_q22) or die (mysqli_error($dbc));
  $ans22 = mysqli_fetch_array($result_q22);
  
  //---------detail material_type_tbl (material_type) ----
  
  $query_mtype = new PreparedSql("SELECT * FROM material_type_tbl WHERE id = ?", [$material_type]);
  $result_mtype = db_query($dbc, $query_mtype) or die (mysqli_error($dbc));
  $d_mtype = mysqli_fetch_array($result_mtype);
  
  
  //---------detail model_detail_tbl(model_code) ---
  
  $query_mcode = new PreparedSql("SELECT * FROM model_detail_tbl WHERE id_model = ?", [$model_code]);
  $result_mcode = db_query($dbc, $query_mcode) or die (mysqli_error($dbc));
  $d_mcode = mysqli_fetch_array($result_mcode);
  
				   

if($_POST["barcode_ref"] != "")
{ 
//insert to scan_tp_store
//----add for record [status = 'Y' will be generate trans posting running no]

	if($part8 != "")
	{
	
	$query_db = "INSERT INTO scan_tp_store(id_scan_tp,scan_doc,barcode_ref,material_no,material_desc,plan_no,doc_no,plant_code, scan_sloc_f,scan_sloc_t,scan_shift,scan_qty,scan_uom,posting_date,scan_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create, date_create,status,status_tp,gr_doc_no) VALUES ('','".sql_esc($number)."','".sql_esc($barcode_ref2)."','".sql_esc($part1)."','".strtoupper($ans3["material_desc"])."','".sql_esc($part3)."','".sql_esc($part4)."','".sql_esc($part2)."','".strtoupper($part6)."','','','".sql_esc($part7)."','".strtoupper($part8)."','".sql_esc($part5)."',NOW(),'','".sql_esc($d_mcode2["model_code"])."','".sql_esc($d_mtype2["mat_type_id"])."','".sql_esc($stamp_ind)."','','".sql_esc($username)."', NOW(),'N','".sql_esc($rst_sta["status_desc"])."','".sql_esc($part4)."')";
	$result_db = mysqli_query($dbc,$query_db) or die (mysqli_error($dbc));
	
	}else{
		
	$query_db = "INSERT INTO scan_tp_store(id_scan_tp,scan_doc,barcode_ref,material_no,material_desc,plan_no,doc_no,plant_code,scan_sloc_f,scan_sloc_t,scan_shift,scan_qty,scan_uom,posting_date,scan_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create, date_create,status,status_tp,gr_doc_no) VALUES ('','".sql_esc($number)."','".sql_esc($barcode_ref2)."','".sql_esc($part1)."','".strtoupper($ans3["material_desc"])."','','','".strtoupper($ans3["plant_code"])."','','','','".sql_esc($part5)."','".strtoupper($ans3["BUn"])."','',NOW(),'','".sql_esc($d_mcode2["model_code"])."','".sql_esc($d_mtype2["mat_type_id"])."','".strtoupper($ans3["category_mat"])."','','".sql_esc($username)."', NOW(),'N','".sql_esc($rst_sta["status_desc"])."','')";
	$result_db = mysqli_query($dbc,$query_db) or die (mysqli_error($dbc));	
		
	}

}elseif($_POST["barcode_ref"] == "")
{
//insert to scan_tp_store
//----add for record [status = 'Y' will be generate trans posting running no]

$query_db = "INSERT INTO scan_tp_store(id_scan_tp,scan_doc,barcode_ref,material_no,material_desc,plan_no,doc_no,plant_code, scan_sloc_f,scan_sloc_t,scan_shift,scan_qty,scan_uom,posting_date,scan_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create, date_create,status,status_tp,gr_doc_no) VALUES ('','".sql_esc($number)."','','".sql_esc($material_no)."','".strtoupper($ans22["material_desc"])."','','','".sql_esc($plant_code)."','','','','','".sql_esc($ans22["BUn"])."','',NOW(),'','".sql_esc($d_mcode["model_code"])."','".sql_esc($d_mtype["mat_type_id"])."','".sql_esc($stamp_ind)."','','".sql_esc($username)."', NOW(),'N','".sql_esc($rst_sta["status_desc"])."','')";
$result_db = mysqli_query($dbc,$query_db) or die (mysqli_error($dbc));

}



            if($result_db)
             {
				 
			 
			echo "<script>";
			echo "window.location='prog_trn-posting.php?scan_doc=$number&&barcode_ref=".html_esc($barcode_ref)."&&plant_code=$plant_code&&model_code=$model_code&&material_type=$material_type&&stamp_ind=$stamp_ind&&material_no=$material_no'";
            echo "</script>";
            exit(); //quit the script
			 
			 
			 
			
             }


	 
}//print the message if there is one.

   

}
?>
<?php

if(isset($_POST["submit8"]))
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

		    $sloc_f = $_POST["sloc_f3"];
			
			$query_upd_slocfm = "UPDATE scan_tp_store SET scan_sloc_f = '".sql_esc($_POST["sloc_f3"])."' WHERE scan_doc '".sql_esc($number)."'"; 
			$result_upd_slocfm = mysqli_query($dbc,$query_upd_slocfm);
	
	
}





if(isset($_POST["submit9"]))
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

   $sloc_t = $_POST["sloc_t3"];
		
    $query_upd_sloctm = "UPDATE scan_tp_store SET scan_sloc_t = '".sql_esc($_POST["sloc_t3"])."' WHERE scan_doc '".sql_esc($number)."'"; 
    $result_upd_sloctm = mysqli_query($dbc,$query_upd_sloctm);  
	
	
}





if(isset($_POST["submit4"]))  
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

    //------additional batch save ------
       $dateF = $_POST["date1"];
	   $sloc_ft = $_POST["sloc_f"];
	   $sloc_tt = $_POST["sloc_t"];
	   $shift_ops = $_POST["shift_ops"];
      
	   $scan_doc = $number;  
	   $scan_qty = $_POST["scan_qty"]; 
	   $item_no = $_POST["item_no"];
	   $id_tp = $_POST["id_tp"];  
	   $plant_code2 = $_POST["plant_code2"]; 
	   
	   
	   		
		if(($_POST["shift_ops"]) == "")
     {
	     $shift_ops = FALSE;
		 $message_shift = '<span class="badge badge-pill badge-danger">Please select Shift Posting!</span>';
	 }else{
		 $shift_ops = TRUE;
	  }
	  
	/*   if(($_POST["sloc_f"]) == "NULL")
     {
	     $sloc_f = FALSE;
		 $message_slocf = '<span class="badge badge-pill badge-danger"> Please enter Storage Location From!</span>';
	 }else{
		 $sloc_f = TRUE;
	  }
	  
	   if(($_POST["sloc_t"]) == "NULL")
     {
	     $sloc_t = FALSE;
		 $message_sloct = '<span class="badge badge-pill badge-danger"> Please enter Storage Location To!</span>';
	 }else{
		 $sloc_t = TRUE;
	  }
	  */
		  if((($_POST["date1"]) == "00-00-0000") || (($_POST["date1"]) == ""))
     {
	     $dateF = FALSE;
		 $message_psdt = '<span class="badge badge-pill badge-danger"> Please select Posting Date !</span>';
	 }else{
		 $dateF = TRUE;
	  }
	  
	     
		 if(($sloc_ft) == ($sloc_tt))
	  {
			
		echo "<script>";
		echo "alert('Please select different storage location.');";
		echo "window.location='prog_trn-posting.php?scan_doc=$number'";
		echo "</script>";
		exit(); //quit the script	
			
	  }
	  
	 
	   
	if($shift_ops && $dateF)//everything ok
  {  
   
       $dateF = $_POST["date1"];
	   $sloc_f = $_POST["sloc_f"];
	   $sloc_t = $_POST["sloc_t"];
	   $shift_ops = $_POST["shift_ops"];
	   
	   
	   foreach($_POST["id_tp"] as $j=>$i) {
	
		
	   
	      if(($_POST["scan_qty"][$i]) == "")
	      { 
		     $scan_qty = FALSE;
				
		   }//end if
		
		  
	     }//for each
	 		

  if($scan_qty)
  {
		   
	   //-------------------generate tp to store doc no.---------------
	
	 if($_POST["plant_code2"] == '3100')
	{
	
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '37'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	}elseif($_POST["plant_code2"] == '3101')
	{
		
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '84'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
		
	}
	
	if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 00000; 
	$dht_OK2 = "411";
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
  
       $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '37'";
	   $result_max_a = mysqli_query($dbc,$query_max_a);
	   
	   $query_max_a1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '110'";
	   $result_max_a1 = mysqli_query($dbc,$query_max_a1);

	}elseif($_POST["plant_code2"] == '3101')
	{
	   $query_max_b = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '84'";
	   $result_max_b = mysqli_query($dbc,$query_max_b);
	   
	   $query_max_a1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '110'";
	   $result_max_a1 = mysqli_query($dbc,$query_max_a1);
	}

   //end update count_max ---------------------------------	
	
		$amount = "";
		$amount3 = "";
		$amount4 = "";
	    $how_many = count($id_tp); 
		
		$item_no = $_POST["item_no"]; 
		$scan_qty = $_POST["scan_qty"]; 
	   	$id_tp = $_POST["id_tp"]; 

       foreach($_POST["id_tp"] as $j=>$i) {
		   
	    $amount .= (($_POST["scan_qty"][$i]).';');
		$amount3 .= (($_POST["item_no"][$i]).';');
		$amount4 .= (($_POST["id_tp"][$i]).';');
		
		//-----checking barcode GR Tag
		
		$string = explode(";",($amount));	
		$string3 = explode(";",($amount3));
		$string4 = explode(";",($amount4));
		
	
        }
		
		   for ($i=0; $i<$how_many; $i++) { 
		   
		    //------ get date posting -------
		         $ddF = substr($_POST["date1"],0,2);
				 $mmF = substr($_POST["date1"],3,2);
				 $yyF = substr($_POST["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 
		
		$query_update_scan2 = "UPDATE scan_tp_store SET scan_qty = '".sql_esc($string[$i])."', scan_shift = '".sql_esc($shift_ops)."', scan_sloc_f = '".sql_esc($_POST["sloc_f"])."', scan_sloc_t = '".sql_esc($_POST["sloc_t"])."', shift_day = '".sql_esc($shift_ops)."', posting_date = '".sql_esc($date1_final)."' WHERE id_scan_tp = '".sql_esc($string4[$i])."'";
	    $rst_update_scan2 = mysqli_query($dbc,$query_update_scan2);
		
		
		 $query_dtl_chk2 = "SELECT * FROM scan_tp_store WHERE id_scan_tp = '".sql_esc($string4[$i])."'";
		 $result_dtl_chk2 = mysqli_query($dbc,$query_dtl_chk2) or die (mysqli_error($dbc));
		 $row_info = mysqli_fetch_array($result_dtl_chk2);
		
	
		
		//---------insert data at table tp_store_detail
		
		  $query_store = "INSERT INTO tp_store_detail(id_tp,doc_tp,id_scan_tp,scan_doc,item_no,material_no,material_desc,plan_no,doc_no,plant_code,sloc_from,sloc_to,qty_tp,uom_tp,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_tp,date_generate_tp,ref_doc_tp,user_cancel,date_cancel,status_ftp,status_tran, status_tp,barcode_gr,gr_doc_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($ref)."','".sql_esc($row_info["id_scan_tp"])."','".sql_esc($number)."','".sql_esc($string3[$i])."','".sql_esc($row_info["material_no"])."','".sql_esc($row_info["material_desc"])."','".sql_esc($row_info["plan_no"])."','".sql_esc($row_info["doc_no"])."','".sql_esc($row_info["plant_code"])."','".sql_esc($row_info["scan_sloc_f"])."','".sql_esc($row_info["scan_sloc_t"])."','".sql_esc($string[$i])."','".strtoupper($row_info["scan_uom"])."','".sql_esc($row_info["posting_date"])."','".sql_esc($row_info["scan_shift"])."','".sql_esc($row_info["model_code"])."','".sql_esc($row_info["material_type"])."','".sql_esc($row_info["stamp_ind"])."','".sql_esc($row_info["slip_no"])."','".sql_esc($row_info["user_create"])."','".sql_esc($row_info["date_create"])."','".sql_esc($username)."', NOW(),'','','','N','Y','".sql_esc($rst_sta19["status_desc"])."','".sql_esc($row_info["gr_doc_no"])."','".sql_esc($row_info["gr_doc_no"])."','','')";          
		  $rst_store = mysqli_query($dbc,$query_store) or die (mysqli_error($dbc));
		

		//---update status "yes" for generate tp to store----
		
		$query_update_scan = "UPDATE scan_tp_store SET status = 'Y', status_tp = '".sql_esc($rst_sta19["status_desc"])."' WHERE id_scan_tp = '".sql_esc($string4[$i])."'";
	    $rst_update_scan = mysqli_query($dbc,$query_update_scan);
		
	}//end for loop
       
	   //----checking ftp tp_store_detail-------
    $data_rcv = "";
   

  $query_rcv_ftp = "SELECT *, DATE_FORMAT(posting_date,'%d%m%Y') AS J, DATE_FORMAT(date_create,'%d%m%Y') AS R2 FROM tp_store_detail WHERE doc_tp = '".sql_esc($ref)."'";
   $result_rcv_ftp = mysqli_query($dbc,$query_rcv_ftp);
   
   $filen_rcv = "TP".$ref; 
  
   while($data_rcv_ftp = mysqli_fetch_array($result_rcv_ftp))
   
   {
        //-----prepared by------
		 $query_prep = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$data_rcv_ftp["user_generate_tp"]]);
		 $result_prep = db_query($dbc, $query_prep) or die (mysqli_error($dbc));
		 $data_prep = mysqli_fetch_array($result_prep);
		 
		 //----quantity-----
		 $qty_new = (intval($data_rcv_ftp["qty_tp"]));


$data_rcv .= $data_rcv_ftp["plant_code"].";".$data_rcv_ftp["doc_tp"].";".$data_rcv_ftp["J"].";".$data_rcv_ftp["sloc_from"].";".$data_rcv_ftp["sloc_to"].";".$data_rcv_ftp["material_no"].";".$qty_new.";".$data_rcv_ftp["uom_tp"].";311;".$data_rcv_ftp["user_generate_tp"]."\r\n";
   


  
     //----------update table ftp_qc_received_detail------------
   
    $query_rcv_ftp_info = "INSERT INTO ftp_tp_store(id,file_name,doc_tp,id_tp,plan_no,material_no,material_desc,qty_ftp,uom, plant,shift_day,slip_no,mvt_type,status_ftp,posting_date,posting_time,sloc_from,sloc_to,prepared_by,user_create,date_create) VALUES('','".sql_esc($filen_rcv)."','".sql_esc($ref)."',".sql_esc($data_rcv_ftp["id_tp"]).",'".sql_esc($data_rcv_ftp["plan_no"])."','".sql_esc($data_rcv_ftp["material_no"])."','".sql_esc($data_rcv_ftp["material_desc"])."','".sql_esc($data_rcv_ftp["qty_tp"])."','".sql_esc($data_rcv_ftp["uom_tp"])."','".sql_esc($data_rcv_ftp["plant_code"])."','".sql_esc($data_rcv_ftp["shift_day"])."','".sql_esc($data_rcv_ftp["slip_no"])."','311','Y','".sql_esc($data_rcv_ftp["posting_date"])."',NOW(),'".sql_esc($data_rcv_ftp["sloc_from"])."','".sql_esc($data_rcv_ftp["sloc_to"])."','".sql_esc($data_prep["user_fullname"])."','".sql_esc($username)."',NOW())"; 
     $rst_rcv_ftp_info = mysqli_query($dbc,$query_rcv_ftp_info);
	  
	  
	  }

		$file_rcv = "../FromPortal2/TP/".$filen_rcv.".csv";
		file_put_contents($file_rcv,$data_rcv);

   
	   // ---update status 
   
		$query_rcv_ftp2 = "UPDATE tp_store_detail SET status_ftp = 'Y' WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
		$rst_query_rcv_ftp2 = mysqli_query($dbc,$query_rcv_ftp2); //or die ("Error in query: $query_ftp"); 
		
				
    //---------------------------------------end ftp -------------------------------------------------   
	   
	
	       echo "<script>";
		   echo "alert('Material Document $ref posted.');";
		   echo "window.location='prog_trn-posting.php'";
	       echo "</script>"; 
		   exit(); //quit the script
	
	     }//end ifelse "OK"
		 else{
		   
		echo '<script type="text/javascript">';
		echo "alert('Error! Transaction failed. Please enter field correctly.');";
		echo "window.location='prog_trn-posting.php';"; 
		echo "</script>";
		exit(); //quit the script
		   
		   
	   }
	 
  } // end if ok slocf sloct date_post shift

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

   $query_delete_scan = "DELETE FROM scan_tp_store WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
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
                <th>Barcode : &nbsp;&nbsp;<i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="1.Goods Receipt Tag <br> 2.Panel Slip <br> 3.Handwork Slip <br> 4.Finished Goods Tag <br> 5. Goods Return Advise <br> 6. Kanban Tag" data-html="true" data-placement="left"></i></th>
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


   
             $query_sql2 = "SELECT *,DATE_FORMAT(posting_date,'%d-%m-%Y') as R FROM scan_tp_store WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
			 $result_sql2 = mysqli_query($dbc,$query_sql2);
			 $num_1 = mysqli_num_rows($result_sql2);   //how many material are there?
    
		  
		 if ($num_1 > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_1.' record(s).</div>'; 
			 
			 
			 $query_sql2A = "SELECT * FROM scan_tp_store WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
			 $result_sql2A = mysqli_query($dbc,$query_sql2A);
			 $row_sql2A = mysqli_fetch_array($result_sql2A);
			 
			 //-----check sloc info ----
			 
			 $query_info_loc = "SELECT * FROM sloc_tbl WHERE sloc_code = '".sql_esc($_POST["sloc_f"])."'";
	         $result_info_loc = mysqli_query($dbc,$query_info_loc);
			 $row_info_loc = mysqli_fetch_array($result_info_loc);
			 
			 $query_info_loc2 = "SELECT * FROM sloc_tbl WHERE sloc_code = '".sql_esc($_POST["sloc_t"])."'";
	         $result_info_loc2 = mysqli_query($dbc,$query_info_loc2);
			 $row_info_loc2 = mysqli_fetch_array($result_info_loc2);
        
    	?>
        
          <form id="form7" method="post" action="" >
          <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th colspan="3">&nbsp;</th>
            </tr>  
          <tr>
                <th>Sloc from : <font color="#FF0000">*</font></th>
                <td colspan="3">
 <input class="form-control" id="sloc_f3" type="text" placeholder="Enter Storage Location" name="sloc_f3" value="<?php if(isset($_POST['sloc_f3'])){ echo html_esc($_POST['sloc_f3']); }  ?>" autofocus required/>    
              <div class="form-control-feedback" > <?php echo $message_slocf; ?></div>    
              <input name="submit8" type="submit" id="submit8" value="+ Scan Item" class="button"  />  
               </td>
               </th>
               <tr>
                <th>Sloc to : <font color="#FF0000">*</font></th>
                <td colspan="3">
<input class="form-control" id="sloc_t3" type="text" placeholder="Enter Storage Location" name="sloc_t3" value="<?php if(isset($_POST['sloc_t3'])){ echo html_esc($_POST['sloc_t3']);  }  ?>" autofocus required/>    
                <div class="form-control-feedback" > <?php echo $message_sloct; ?></div>   
              
                <input name="submit9" type="submit" id="submit9" value="+ Scan Item" class="button"  />
                </th>
               </tr> </table>
        </form>
        

      <form action="prog_trn-posting.php?scan_doc=<?php echo $number; ?>" method="post" name="myform" id="myform">
 
         <table class="table table-bordered">
               <tr>
              <th width="31%">Posting Date :  <font color="#FF0000">*</font></th>
              <td colspan="3"><input class="form-control"  id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php if(isset($_POST['date1'])){ echo html_esc($_POST['date1']); }else{ echo $fmt_curr_date; } ?>" />
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
                    <th>&nbsp;</th>
                    <th>Item.</th>
                    <th>Part Number</th>
                    <th>Part Name</th>
                    <th>Quantity</th>
                    <th>UoM</th>
                    <!--<th>Scan GR Tag</th>-->
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
                <td width="60"><div align="center"><a href="delete_tp_item.php?scan_doc=<?php echo html_esc($row["scan_doc"]); ?>&&p_id=<?php echo html_esc($row["id_scan_tp"]); ?>&&barcode_ref=<?php echo html_esc($row["barcode_ref"]); ?>&&sloc_f=<?php echo html_esc($row["scan_sloc_f"]); ?>&&sloc_t=<?php echo html_esc($row["scan_sloc_t"]); ?>&&plant_code=<?php echo html_esc($row["plant_code"]); ?>&&date1=<?php echo html_esc($row["posting_date"]); ?>&&shift_ops=<?php echo html_esc($row["scan_shift"]); ?>&&model_code=<?php $row["model_code"]; ?>&&material_type=<?php echo html_esc($row["material_type"]); ?>&&stamp_ind=<?php echo html_esc($row["stamp_ind"]); ?>&&material_no=<?php echo html_esc($row["material_no"]); ?>" onclick="return confirm('Are you sure you want to delete?')"><img src="../images/delete.png" alt="Remove Item"></a></div></td>
                <td width="60"><?php echo $no4; ?><input name="id_tp[<?php echo html_esc($row["id_scan_tp"]); ?>]" type="hidden" value="<?php echo html_esc($row["id_scan_tp"]); ?>">
                <input name="item_no[<?php echo html_esc($row["id_scan_tp"]); ?>]" type="hidden" value="<?php echo $no4; ?>"></td>
                <td width="150"><?php echo html_esc($row["material_no"]); ?></td>
                <td width="350"><?php echo html_esc($row["material_desc"]); ?></td>
                <td width="150"> <input name="scan_qty[<?php echo html_esc($row["id_scan_tp"]); ?>]" type="number" min="1" value="<?php if(isset($_POST["scan_qty"])) { echo html_esc($_POST["scan_qty"][($row["id_scan_tp"])]); }else{   echo (intval($row["scan_qty"]));  } ?>" id="scan_qty" class="form-control form-control-sm" autofocus required>
                 </td>
                <td width="80"><?php echo html_esc($row["scan_uom"]); ?><input name="plant_code2" type="hidden" value="<?php echo html_esc($row["plant_code"]); ?>"></td> 
                <!--<td width="200">
               <input name="bar_gr[<?php //echo $row["id_scan_tp"]; ?>]" type="text" id="bar_gr" maxlength="200" value="<?php // if(isset($_POST['bar_gr'])){ echo $_POST["bar_gr"][($row["id_scan_tp"])]; } ?>" class="form-control" autofocus required/>
        
                </td>-->
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
</table> <!--
        <div class="form-actions">-->
       
               <input name="submit4" type="submit" id="submit4" value="SUBMIT" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to transfer?');" >
               <input name="submit5" type="submit" id="submit5" class="btn btn-warning btn-sm" value="CLEAR">
               <input class="form-control" id="sloc_f" type="hidden"  name="sloc_f" value="<?php echo html_esc($_POST['sloc_f3']);   ?>" />  
               <input class="form-control" id="sloc_t" type="hidden"  name="sloc_t" value="<?php echo html_esc($_POST['sloc_t3']);   ?>" />     

<?php  

 }else{
 
?> 

<?php   } ?>


</form>
     
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
   <!--  <script type="text/javascript">$('#sampleTable').DataTable();</script>-->
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
     <script language="javascript">
		  $(document).ready(function() {
				$('#example').DataTable( {
					"scrollX": true,
					"lengthMenu": [[ -1], [ "All"]]
				} );
		} );
	  </script>
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
		
		var strURL="findType-TP.php?plant_code="+plant_code;
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
		
		var strURL="findModel-TP.php?plant_code="+plant_code+"&material_type="+material_type;
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
		
		var strURL="findCat-TP.php?plant_code="+plant_code+"&material_type="+material_type+"&model_code="+model_code;
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
	
		var strURL="findMaterial-TP.php?plant_code="+plant_code+"&material_type="+material_type+"&model_code="+model_code+"&stamp_ind="+stamp_ind;
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
  </body>
</html>