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
    $result2 = db_query($dbc, $query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
    $url = "detail_GR_GI-receive.php"; 
	
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

//CR status (Transfer GRA)
$sta23 = "SELECT * from request_status WHERE status_id = '23'";
$sta_res23 = mysqli_query($dbc,$sta23);
$rst_sta23 = mysqli_fetch_array($sta_res23);	

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);	

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
    $(document).ready(function() {
    $('#example').DataTable( {
        "scrollX": true
    } );
} );
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
          <p>Goods Issue Consumable</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Receiving</li>
          <li class="breadcrumb-item"><a href="detail_GR_GI-receive.php">Goods Issue Consumable</a></li>
        </ul>
      </div> 
        
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Goods Issue Consumable</h3>
            <div class="tile-body">
              <div class="table-responsive">
              
  <?php       
  
    $message_pcode = "";
	$message_psdt = "";
	$message_shift = "";
	$message_wrkcenter = "";

	
	$query_id = "SELECT * FROM run_count_itsb WHERE uid = '118'";
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
			$material_no = $_POST["material_no"];
	
	
	// check for a barcode ref (scan from GR Tag)
		
			
    if(($_POST["barcode_ref"]) == "")
	 { 	
		   
	  
			
			
			if(($_POST["plant_code"]) == "NULL")
     {
	     $plant_code = FALSE;
		 $message_pcode = '<span class="badge badge-pill badge-danger">Please select Plant!</span>';
	 }else{
		 
		 
		 
			 $query_detail_chk = "SELECT * FROM sc_gis_con_rcv WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
			 $result_detail_chk = mysqli_query($dbc,$query_detail_chk);
    
			while($data_detail_chk = mysqli_fetch_array($result_detail_chk))
			
			{
				
				if(($data_detail_chk["plant_code"]) != ($_POST["plant_code"]))
				{
					
						  echo "<script>";
						  echo "alert('Wrong batch plant code! Please select correct Plant.');";
						  echo "window.location='detail_GR_GI-receive.php?scan_doc=$number'";
						  echo "</script>";
						  exit(); //quit the script	
					
				}
				
				
							
			}
	     
		      $plant_code = TRUE;	 
		 
	  }
		

		

			} //end barcode

if(($barcode_ref) || ($plant_code))//everything ok
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
} // end if $str


           
           	$plant_code = $_POST["plant_code"];
			$material_no = $_POST["material_no"];

                

			
  if($_POST["barcode_ref"] != "")
{ 			
				   
  $query_q2 = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ?", [$part1]);
  $result_q2 = db_query($dbc, $query_q2) or die (mysqli_error());
  $ans3 = mysqli_fetch_array($result_q2);
  
  //-----get cost center base on work center ------
  $query_cct = new PreparedSql("SELECT * FROM work_center_detail WHERE id_work = ?", [$ans3["prod_line"]]);
  $result_cct = db_query($dbc, $query_cct) or die (mysqli_error());
  $data_cct = mysqli_fetch_array($result_cct);
  
  //------get model code detail -------
  $query_modelA = new PreparedSql("SELECT * FROM model_detail_tbl WHERE id_model = ?", [$ans3["model_code"]]);
  $result_modelA = db_query($dbc, $query_modelA) or die (mysqli_error());
  $data_modelA = mysqli_fetch_array($result_modelA);
  
  
  
             $query_detail_chk = "SELECT * FROM sc_gis_con_rcv WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
			 $result_detail_chk = mysqli_query($dbc,$query_detail_chk);
    
			while($data_detail_chk = mysqli_fetch_array($result_detail_chk))
			
			{
				
				if(($data_detail_chk["plant_code"]) != ($part2))
				{
					
						  echo "<script>";
						  echo "alert('Wrong batch plant code! Please select correct Plant.');";
						  echo "window.location='detail_GR_GI-receive.php?scan_doc=$number'";
						  echo "</script>";
						  exit(); //quit the script	
					
				} // end if
			} // end while $data_detail_chk
	     
  
}
  
  $query_q22 = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ?", [$material_no]);
  $result_q22 = db_query($dbc, $query_q22) or die (mysqli_error());
  $ans22 = mysqli_fetch_array($result_q22);

 
  //------get model code detail -------
  $query_model = new PreparedSql("SELECT * FROM model_detail_tbl WHERE id_model = ?", [$ans22["model_code"]]);
  $result_model = db_query($dbc, $query_model) or die (mysqli_error());
  $data_model = mysqli_fetch_array($result_model);
				   

if($_POST["barcode_ref"] != "")
{ 
//insert to sc_gis_con_rcv [scan Goods Issue Consumable]
//----add for record [status = 'Y' will be generate trans posting running no]

$query_db = "INSERT INTO sc_gis_con_rcv(id_scan_gis,scan_doc,barcode_ref,material_no,material_desc,plan_no,doc_no,plant_code,scan_sloc,scan_shift,scan_qty,scan_uom,posting_date,scan_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,status,status_gis,dlv_ord_no,work_center,cost_center) VALUES ('','".sql_esc($number)."','".sql_esc($barcode_ref2)."','".sql_esc($part1)."','".sql_esc($ans3["material_desc"])."','".sql_esc($part3)."','".sql_esc($part4)."','".sql_esc($part2)."','".sql_esc($part6)."','','".sql_esc($part7)."','".sql_esc($part8)."','".sql_esc($part5)."',NOW(),'','".sql_esc($data_modelA["model_code"])."','".sql_esc($ans3["category_mat"])."','','','".sql_esc($username)."',NOW(),'N','".sql_esc($rst_sta["status_desc"])."','".sql_esc($part10)."','".sql_esc($ans3["prod_line"])."','".sql_esc($data_cct["cost_center"])."')";
$result_db = mysqli_query($dbc,$query_db) or die (mysqli_error());

}elseif($_POST["barcode_ref"] == "")
{
//insert to scan_tp_store
//----add for record [status = 'Y' will be generate trans posting running no]

$query_db = "INSERT INTO sc_gis_con_rcv(id_scan_gis,scan_doc,barcode_ref,material_no,material_desc,plan_no,doc_no,plant_code,scan_sloc,scan_shift,scan_qty,scan_uom,posting_date,scan_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,status,status_gis,dlv_ord_no,work_center,cost_center) VALUES ('','".sql_esc($number)."','','".sql_esc($material_no)."','".sql_esc($ans22["material_desc"])."','','','".sql_esc($plant_code)."','".sql_esc($ans22["sloc"])."','','','".sql_esc($ans22["BUn"])."','',NOW(),'','".sql_esc($data_model["model_code"])."','".sql_esc($ans22["category_mat"])."','','','".sql_esc($username)."',NOW(),'N','".sql_esc($rst_sta["status_desc"])."','','".sql_esc($work_center)."','')";
$result_db = mysqli_query($dbc,$query_db) or die (mysqli_error());

}



            if($result_db)
             {
			 
			echo "<script>";
			echo "window.location='detail_GR_GI-receive.php?scan_doc=$number&&barcode_ref=".html_esc($barcode_ref)."&&plant_code=$plant_code&&material_no=$material_no'";
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
       //---update by batch----

       $dateF = $_POST["date1"];
	   $shift_ops = $_POST["shift_ops"];
	   $work_center = $_POST["work_center"];
	   
	   
	   //--------------
	   $scan_doc = $number;  
	   $scan_qty = $_POST["scan_qty"]; 
	   $item_no = $_POST["item_no"];
	   $id_gis = $_POST["id_gis"];  
	   $plant_code2 = $_POST["plant_code2"]; 
	   
	   
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
	   
	  if(($_POST["work_center"]) == "NULL")
     {
	     $work_center = FALSE;
		 $message_wrkcenter = '<span class="badge badge-pill badge-danger">Please select Line!</span>';
	 }else{
		 $work_center = TRUE;
	  }
	  
	   
	   foreach($_POST["id_gis"] as $j=>$i) {
		   
	    //echo $_POST["item_no"][$i];  echo "<br>";
	    //echo $_POST["scan_qty"][$i];  echo "<br>";
		
		
	   
	      if(($_POST["scan_qty"][$i]) == "")
	      { 
		     $scan_qty = FALSE;
				
		   }//end if
		  
	     }//for each
	 		

  if($shift_ops && $dateF && $work_center && $scan_qty)
  {
	  
	   $dateF = $_POST["date1"];
	   $shift_ops = $_POST["shift_ops"];
	   $work_center = $_POST["work_center"];
	   
	   
	   
	    //-----get cost center base on work center ------
		  $query_cct2 = new PreparedSql("SELECT * FROM work_center_detail WHERE id_work = ?", [$work_center]);
		  $result_cct2 = db_query($dbc, $query_cct2) or die (mysqli_error());
		  $data_cct2 = mysqli_fetch_array($result_cct2);
		  
	  
	             $ddF = substr($_POST["date1"],0,2);
				 $mmF = substr($_POST["date1"],3,2);
				 $yyF = substr($_POST["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
		   
	   //-------------------generate Goods Issue Consumable (GIS) doc no.---------------
	
	
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '35'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	
	if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 00000; 
	$dht_OK2 = "381";
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
	 

  
       $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '35'";
	   $result_max_a = mysqli_query($dbc,$query_max_a);
	   
	   $query_max_a1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '118'";
	   $result_max_a1 = mysqli_query($dbc,$query_max_a1);

    //end update count_max ---------------------------------	  
	  
		
		$amount = "";
	    $amount3 = "";
		$amount4 = "";
	
	    $how_many = count($id_gis); 
		
		$item_no = $_POST["item_no"]; 
		$scan_qty = $_POST["scan_qty"]; 
		$id_gis = $_POST["id_gis"]; 
	

       foreach($_POST["id_gis"] as $j=>$i) {
		   
	    
	    $amount .= (($_POST["scan_qty"][$i]).';');
		$amount3 .= (($_POST["item_no"][$i]).';');
		$amount4 .= (($_POST["id_gis"][$i]).';');
		
		//-----checking barcode GR Tag
		
		$string = explode(";",($amount));	
		$string3 = explode(";",($amount3));
		$string4 = explode(";",($amount4));
		
		
	
        }
		
	  
		 			
		   for ($i=0; $i<$how_many; $i++) { 
		   
			
			
		//echo $string2[$i]; echo "</br>";
		
		//echo $string3[$i]; echo "</br>";
		
	    $query_update_scan2 = "UPDATE sc_gis_con_rcv SET scan_qty = '".sql_esc($string[$i])."', status_gis = '".sql_esc($rst_sta27["status_desc"])."', posting_date = '".sql_esc($date1_final)."', scan_shift = '".sql_esc($shift_ops)."', shift_day = '".sql_esc($shift_ops)."', work_center = '".sql_esc($work_center)."', cost_center = '".sql_esc($data_cct2["cost_center"])."' WHERE id_scan_gis = '".sql_esc($string4[$i])."'";
	    $rst_update_scan2 = mysqli_query($dbc,$query_update_scan2);
	  
	  			
	
		 $query_dtl_chk2 = "SELECT * FROM sc_gis_con_rcv WHERE id_scan_gis = '".sql_esc($string4[$i])."'";
		 $result_dtl_chk2 = mysqli_query($dbc,$query_dtl_chk2) or die (mysqli_error());
		 $row_info = mysqli_fetch_array($result_dtl_chk2);
		 
		 
		
		//---------insert data at table gis_rcv_detail
		
		  $query_store = "INSERT INTO gis_rcv_detail(id_gis,doc_gis,id_scan_gis,scan_doc,item_no,material_no,material_desc,plan_no,doc_no,plant_code,sloc_from,sloc_to,qty_gis,uom_gis,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_gis,date_generate_gis,ref_doc_gis,user_cancel,date_cancel,status_ftp,status_tran,status_gis,doc_no_return,return_by,date_return,received_by,date_received,dlv_ord_no,work_center,cost_center,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($ref)."','".sql_esc($row_info["id_scan_gis"])."','".sql_esc($number)."','".sql_esc($string3[$i])."','".sql_esc($row_info["material_no"])."','".sql_esc($row_info["material_desc"])."','".sql_esc($row_info["plan_no"])."','".sql_esc($row_info["doc_no"])."','".sql_esc($row_info["plant_code"])."','".sql_esc($row_info["scan_sloc"])."','','".sql_esc($string[$i])."','".sql_esc($row_info["scan_uom"])."','".sql_esc($row_info["posting_date"])."','".sql_esc($row_info["scan_shift"])."','".sql_esc($row_info["model_code"])."','".sql_esc($row_info["material_type"])."','".sql_esc($row_info["stamp_ind"])."','".sql_esc($row_info["slip_no"])."','".sql_esc($row_info["user_create"])."','".sql_esc($row_info["date_create"])."','".sql_esc($username)."', NOW(),'','','','N','Y','".sql_esc($rst_sta27["status_desc"])."','','','','','','".sql_esc($row_info["dlv_ord_no"])."','".sql_esc($row_info["work_center"])."','".sql_esc($row_info["cost_center"])."','','')";          
		  $rst_store = mysqli_query($dbc,$query_store) or die (mysqli_error());
		
	 

		//---update status "yes" for generate GIS PPC----
		
		$query_update_scan = "UPDATE sc_gis_con_rcv SET status = 'Y' WHERE id_scan_gis = '".sql_esc($string4[$i])."'";
	    $rst_update_scan = mysqli_query($dbc,$query_update_scan);
		
	}//end for loop
       
	   //----checking ftp gis_rcv_detail-------
    $data_rcv = "";
   

  $query_rcv_ftp = "SELECT *, DATE_FORMAT(posting_date,'%d%m%Y') AS J, DATE_FORMAT(date_create,'%d%m%Y') AS R2 FROM gis_rcv_detail WHERE doc_gis = '".sql_esc($ref)."'";
   $result_rcv_ftp = mysqli_query($dbc,$query_rcv_ftp);
   
   $filen_rcv = "GI".$ref; 
  
   while($data_rcv_ftp = mysqli_fetch_array($result_rcv_ftp))
   
   {
        //-----prepared by------
		 $query_prep = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$data_rcv_ftp["user_generate_gis"]]);
		 $result_prep = db_query($dbc, $query_prep) or die (mysqli_error());
		 $data_prep = mysqli_fetch_array($result_prep);
		 
		 //----quantity-----
		 $qty_new = (intval($data_rcv_ftp["qty_gis"]));
		 
		 
		 //---get month & year

		 $mon_plan = substr($data_rcv_ftp["posting_date"],5,2);		
		 $tahun_plan = substr($data_rcv_ftp["posting_date"],0,4);
		 


$data_rcv .= $data_rcv_ftp["plant_code"].";".$data_rcv_ftp["doc_gis"].";".$data_rcv_ftp["J"].";".$data_rcv_ftp["material_no"].";".$qty_new.";".$data_rcv_ftp["uom_gis"].";201;".$data_rcv_ftp["sloc_from"].";".$data_rcv_ftp["cost_center"].";".$data_prep["user_fullname"]."\r\n";
 
  
     //----------update table ftp_tp_gis_rcv------------
   
    $query_rcv_ftp_info = "INSERT INTO ftp_tp_gis_rcv(id,file_name,doc_gis,id_gis,plan_no,material_no,material_desc,qty_ftp,uom, plant,shift_day,slip_no,mvt_type,status_ftp,posting_date,posting_time,sloc_from,sloc_to,prepared_by,user_create,date_create,work_center,cost_center) VALUES('','".sql_esc($filen_rcv)."','".sql_esc($ref)."','".sql_esc($data_rcv_ftp["id_gis"])."','".sql_esc($data_rcv_ftp["plan_no"])."','".sql_esc($data_rcv_ftp["material_no"])."','".sql_esc($data_rcv_ftp["material_desc"])."','".sql_esc($data_rcv_ftp["qty_gis"])."','".sql_esc($data_rcv_ftp["uom_gis"])."','".sql_esc($data_rcv_ftp["plant_code"])."','".sql_esc($data_rcv_ftp["shift_day"])."','".sql_esc($data_rcv_ftp["slip_no"])."','201','Y','".sql_esc($data_rcv_ftp["posting_date"])."',NOW(),'".sql_esc($data_rcv_ftp["sloc_from"])."','".sql_esc($data_rcv_ftp["sloc_to"])."','".sql_esc($data_prep["user_fullname"])."','".sql_esc($username)."',NOW(),'".sql_esc($data_rcv_ftp["work_center"])."','".sql_esc($data_rcv_ftp["cost_center"])."')"; 
     $rst_rcv_ftp_info = mysqli_query($dbc,$query_rcv_ftp_info);
	 
	 
	  //----------update table prt_sheet_gis_tag------------
   
    $query_print_tag = "INSERT INTO prt_sheet_gis_tag(id,tag_gen,doc_gis,id_gis,plan_no,material_no,material_desc,qty_gis,uom_gis,sloc_from,sloc_to,plant_code,month_gis,year_gis,posting_date,prepared_by,work_center,cost_center,created_by,date_create,status_tag) VALUES('','".sql_esc($ref)."','".sql_esc($ref)."','".sql_esc($data_rcv_ftp["id_gis"])."','".sql_esc($data_rcv_ftp["plan_no"])."','".sql_esc($data_rcv_ftp["material_no"])."','".sql_esc($data_rcv_ftp["material_desc"])."','".sql_esc($data_rcv_ftp["qty_gis"])."','".sql_esc($data_rcv_ftp["uom_gis"])."','".sql_esc($data_rcv_ftp["sloc_from"])."','".sql_esc($data_rcv_ftp["sloc_to"])."','".sql_esc($data_rcv_ftp["plant_code"])."','".sql_esc($mon_plan)."','".sql_esc($tahun_plan)."','".sql_esc($data_rcv_ftp["posting_date"])."','".sql_esc($data_prep["user_fullname"])."','".sql_esc($data_rcv_ftp["work_center"])."','".sql_esc($data_rcv_ftp["cost_center"])."','".sql_esc($username)."',NOW(),'Y')"; 
     $rst_print_tag = mysqli_query($dbc,$query_print_tag);
	  
	  
	  }

		$file_rcv = "../FromPortal2/GI/".$filen_rcv.".csv";
		file_put_contents($file_rcv,$data_rcv);

   
	   // ---update status 
   
		$query_rcv_ftp2 = "UPDATE gis_rcv_detail SET status_ftp = 'Y' WHERE scan_doc = '".sql_esc($number)."'";
		$rst_query_rcv_ftp2 = mysqli_query($dbc,$query_rcv_ftp2); //or die ("Error in query: $query_ftp"); 
		
				
    //---------------------------------------end ftp -------------------------------------------------   
	   
	   
	
   
   //$ref_GRA = (base64_encode($ref));
   
    echo '<script type="text/javascript">';
	echo "alert('Material Document $ref posted.');";
	echo "window.location='detail_GR_GI-receive.php';"; 
	echo "</script>";
	exit(); //quit the script
      

	
	 }//end ifelse "OK"
	  else{
	   
    echo '<script type="text/javascript">';
	echo "alert('Error! Transaction failed. Please enter field correctly.');";
	echo "window.location='detail_GR_GI-receive.php';"; 
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

   $query_delete_scan = "DELETE FROM sc_gis_con_rcv WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
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
                <th>Barcode : &nbsp;&nbsp;<i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="1.Goods Receipt Tag" data-html="true" data-placement="left"></i></th>
                <th colspan="3">
     <input name="barcode_ref" type="text" id="barcode_ref" maxlength="200" value="<?php if(isset($_POST['barcode_ref'])) echo html_esc($_POST['barcode_ref']); ?>" class="form-control" autofocus/>
               </th>
              </tr>
              <tr>
            <th>Plant :  <font color="#FF0000">*</font></th>
            <td colspan="3">
           <select name="plant_code" class="form-control" onChange="getMaterial(this.value)">
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
            <th>Part No. : </th>
            <td colspan="3">
            <div id="mat_div"> <select name="material_no" id="material_no" class="form-control">
                  <option value="NULL" placeholder="Select Part Number"> -- Select Part Number --</option>
                 </select></div>
                 
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


   
             $query_sql2 = "SELECT *,DATE_FORMAT(posting_date,'%d-%m-%Y') as R FROM sc_gis_con_rcv WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
			 $result_sql2 = mysqli_query($dbc,$query_sql2);
			 $num_1 = mysqli_num_rows($result_sql2);   //how many material are there?
    
		  
		 if ($num_1 > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_1.' record(s).</div>'; 
	   
        
    	?>

                     
           <form action="detail_GR_GI-receive.php?scan_doc=<?php echo (base64_encode($number)); ?>" method="post" name="myform" id="myform">
           
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
              <tr>
                <th>Line : <font color="#FF0000">*</font></th>
                <td colspan="3">
    			 <?php           
                $query41 = "SELECT * FROM work_center_detail  ORDER BY id_work ASC";
				$result41 = mysqli_query($dbc,$query41);

				?> 

              <select name="work_center" id="work_center" class="form-control"  >
               <option value="NULL" placeholder="Select Line"> -- Select Line --</option>
               <?php
                            while($row41=mysqli_fetch_array($result41)) 
                              {
                                ?>
                                   <option value="<?php echo html_esc($row41["id_work"]); ?>" > <?php echo stripslashes($row41["id_work"]),' - ',stripslashes($row41["wc_desc"]); ?></option>
                                 
                
                          <?php    }
                              
                              ?>
            </select>
                
          <div class="form-control-feedback" ><?php echo $message_wrkcenter; ?></div></td>
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
                </tr>
              </thead>    
              <tbody>
           <?php 

   $counter = 1;
   $no4 = 1;
   $sta_out = "";
   
   while($row = mysqli_fetch_array($result_sql2))
   {
	   
	   // $no4 = sprintf('%04d',$no4);
	  
      ?>
                <tr class="item">
                <td width="50"><a href="delete_gis_item.php?scan_doc=<?php echo html_esc($row["scan_doc"]); ?>&&p_id=<?php echo html_esc($row["id_scan_gis"]); ?>&&plant_code=<?php echo html_esc($row["plant_code"]); ?>&&date1=<?php echo html_esc($row["posting_date"]); ?>&&shift_ops=<?php echo html_esc($row["scan_shift"]); ?>&&work_center=<?php echo html_esc($row["work_center"]); ?>&&material_no=<?php echo html_esc($row["material_no"]); ?>" onclick="return confirm('Are you sure you want to delete?')"><img src="../images/delete.png" alt="Remove Item"></a></td>
                <td width="50"><?php echo $no4; ?><input name="id_gis[<?php echo html_esc($row["id_scan_gis"]); ?>]" type="hidden" value="<?php echo html_esc($row["id_scan_gis"]); ?>">
                <input name="item_no[<?php echo html_esc($row["id_scan_gis"]); ?>]" type="hidden" value="<?php echo $no4; ?>"></td>
                <td width="200"><?php echo html_esc($row["material_no"]); ?></td>
                <td width="350"><?php echo html_esc($row["material_desc"]); ?></td>
                <td width="200"> <input name="scan_qty[<?php echo html_esc($row["id_scan_gis"]); ?>]" type="number" min="1" value="<?php if(isset($_POST["scan_qty"])) { echo html_esc($_POST["scan_qty"][($row["id_scan_gis"])]); } ?>" id="scan_qty" class="form-control form-control-sm">
                 </td>
                <td width="100"><?php echo html_esc($row["scan_uom"]); ?>  <input name="plant_code2" type="hidden" value="<?php echo html_esc($row["plant_code"]); ?>"></td> 
               
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
               <input name="submit4" type="submit" id="submit4" value="SUBMIT" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to submit?');" >
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
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
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
	
	/*function getWorkCenter(plant_code) {		
		
		var strURL="findPlant-GI.php?plant_code="+plant_code;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('work_centerdiv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}*/
	
	//var strURL="agd-add00.php?idmtg="+idmtg+"&comp="+comp+"&year="+yr ;
	
	function getMaterial(plant_code) {		
	
		var strURL="findMaterial-GI.php?plant_code="+plant_code;
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