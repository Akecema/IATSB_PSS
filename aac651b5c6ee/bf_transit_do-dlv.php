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
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
    $url = "bf_transit_do-dlv.php"; 
	
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

//CR status (Transfer Material)
$sta28 = "SELECT * from request_status WHERE status_id = '28'";
$sta_res28 = mysqli_query($dbc,$sta28);
$rst_sta28 = mysqli_fetch_array($sta_res28);	

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
input[value="+ Add Item"]{
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
           <h1><i class="fa fa-truck"></i> Delivery</h1>
          <p>Backflush Transit</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Delivery</li>
          <li class="breadcrumb-item"><a href="bf_transit_do-dlv.php">Backflush Transit</a></li>
        </ul>
      </div> 
        
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Backflush Transit</h3>
            <div class="tile-body">
              <div class="table-responsive">
              
  <?php       
  
    $message_pcode = "";
	$message_psdt = "";
	$message_shift = "";
	$message_model = "";
    $message_qok = "";
	
	
	$query_id = "SELECT count_max FROM run_count_itsb WHERE uid = '135'";
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
	$number3 = $dg; // Length of running no
    $numb3 = sprintf('%07d', $number3);  
	
	
	  
	
	} // end if $result_id		

	
	
	//echo $numb3;
	
	
	
	//-------------------------------------------------------------------
	   if((isset($_POST['submit3'])) && $_POST!=="")  
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
   
  $barcode_ref = $_POST["barcode_ref"];

  
// check for a barcode ref (scan from FG Tag)
if(empty($_POST["barcode_ref"]))
{ 
  $barcode_ref = FALSE;
  $message_bcode = '<span class="badge badge-pill badge-danger"> Please scanning barcode list!</span>';
  
 }else{
	 
  $barcode_ref = TRUE;	 
 }

if($barcode_ref) //everything ok
{  

$barcode_ref = $_POST["barcode_ref"];

//checking delete space semasa scanning

$barcode_ref2 = trim($barcode_ref);
			
 
//split dulu pps ref kpd prod_order, material,uom, plant, sloc, qty
$str = $barcode_ref2;


list($part1, $part2, $part3, $part4, $part5, $part6, $part7, $part8, $part9, $part10) = (explode('|', $str, 10));

// negative limit (since PHP 5.1)
//print_r(explode('|', $str, -1));

  $query_q2 = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($part1)."'";
  $result_q2 = mysqli_query($dbc,$query_q2) or die (mysqli_error());
  $ans3 = mysqli_fetch_array($result_q2);
  
  
  
                 $ddP = substr($part5,0,2);
				 $mmP = substr($part5,2,2);
				 $yyP = substr($part5,4,4);
			
			     $date1_post = ($yyP.'-'.$mmP.'-'.$ddP);

				   

//insert to scan_ret_subcont
//----add for record [status = 'Y' will be generate return posting running no]
$query_db = "INSERT INTO scan_bf_transit_dlv(id_scan_tp,scan_doc,bflush_no_ok,barcode_ref,plant_code,purc_ord_no,doc_gra,sloc_from,sloc_to,material_no,material_desc,scan_qty,scan_uom,dlv_ord_no,scan_date,posting_date,slip_no,user_create,date_create,status,status_bf) VALUES ('','".sql_esc($numb3)."','','".sql_esc($barcode_ref2)."','".sql_esc($part2)."','".sql_esc($part3)."','".sql_esc($part4)."','".sql_esc($part6)."','','".sql_esc($part1)."','".sql_esc($ans3["material_desc"])."','".sql_esc($part7)."','".sql_esc($part8)."','".sql_esc($part10)."','".sql_esc($date1_post)."','','".sql_esc($part9)."','".sql_esc($username)."',NOW(),'N','".sql_esc($rst_sta["status_desc"])."')";
$result_db = mysqli_query($dbc,$query_db) or die (mysqli_error());


 //-----------------------scan qty-----------------------
 
  if(isset($_POST["cancel"])) 
  {
 
    $cancel = $_POST["cancel"]; 
    $how_many = count($cancel); 
	//$scan_qty = $_POST["scan_qty"]; 
	$item_no = $_POST["item_no"]; 
	$sloc_to2 = "";
	   
	   foreach($_POST["cancel"] as $j=>$i) {
	    
		//$amount .= $_POST["scan_qty"][$i];
		$amount2 .= $_POST["item_no"][$i];
		
		//$string = explode("|",($amount));	
		$string2 = explode("|",($amount2));	
	  
			}
		 			
		   for ($i=0; $i<$how_many; $i++) { 
		   			
		
		 
		 /*$query_update_scan = "UPDATE scan_gr_trn_fg_ok SET scan_qty = '".$string[$i]."' WHERE id_scan_tp = '".$cancel[$i]."'";
	     $rst_update_scan = mysqli_query($dbc,$query_update_scan);*/
		   
		   }

      } // end $_POST["cancel"];


	 
}//print the message if there is one.
	  

}

	
	     
 if((isset($_POST["submit3A"]))  && $_POST!=="") 
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
   
            $dateF = $_POST["date1"];
           	$plant_code = $_POST["plant_code"];
			$model_code = $_POST["model_code"];
			$shift_ops = $_POST["shift_ops"];
			$material_no = $_POST["material_no"];
		    $qty_actual = $_POST["qty_actual"];
			
			if(($_POST["plant_code"]) == "NULL")
           {
	        $plant_code = FALSE;
		    $message_pcode = '<span class="badge badge-pill badge-danger">Please select Plant!</span>';
	       }else{
		 
	        $plant_code = TRUE;	 
		 
	        }
		
		
		if(($_POST["shift_ops"]) == "")
     {
	     $shift_ops = FALSE;
		 $message_shift = '<span class="badge badge-pill badge-danger">Please select Shift Posting!</span>';
	 }else{
		 $shift_ops = TRUE;
	  }
	  
	  if(($_POST["model_code"]) == "NULL")
     {
	     $model_code = FALSE;
		 $message_model = '<span class="badge badge-pill badge-danger">Please select Model!</span>';
	 }else{
		 $model_code = TRUE;
	  }
	  
	  
	  
	  	 if(($_POST["qty_actual"]) == "")
				{
				  $qty_actual = FALSE;
				  $message_qok = '<span class="badge badge-pill badge-danger"> You are required to enter quantity!</span>';
				  }else{
				  $qty_actual = TRUE;
				  } 
	

       if($plant_code && $dateF && $shift_ops && $model_code && $qty_actual)//everything ok
       {  

            $dateF = $_POST["date1"];
           	$plant_code = $_POST["plant_code"];
			$model_code = $_POST["model_code"];
			$shift_ops = $_POST["shift_ops"];
			$material_no = $_POST["material_no"];
			$qty_actual = $_POST["qty_actual"];
			//$barcode_gr = $_POST["barcode_gr"];
			

                 $ddF = substr($_POST["date1"],0,2);
				 $mmF = substr($_POST["date1"],3,2);
				 $yyF = substr($_POST["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 


		 //checking delete space semasa scanning
	
	/*$barcode_gr2 = trim($barcode_gr);
				
	 
	//split dulu pps ref kpd prod_order, material,uom, plant, sloc, qty
	$str = $barcode_gr2;
	
	if($str)
	{
	
	if(explode('|', $str, 10))
	{
	list($part1, $part2, $part3, $part4, $part5, $part6, $part7, $part8, $part9, $part10) = (explode('|', $str, 10));	
	
	
	}
	
	} //end if $str*/


   

		   
	   //-------------------generate BF Transit doc no. ---------------
	
	 $query_id2 = "SELECT count_max FROM run_count_itsb WHERE uid = '19'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	if($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 00000; 
	$dht_OK2 = "251";
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
    $number2 = sprintf('%05d', $number2);  
	
    $ref = ($_POST["plant_code"].$dht_OK2.$date_run.($number2));
	  
	
	} // end if $result_id2
	
      
	  
	  
		  $query_q22 = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($material_no)."'";
		  $result_q22 = mysqli_query($dbc,$query_q22) or die (mysqli_error());
		  $ans22 = mysqli_fetch_array($result_q22);
		  
		   //----check material type -----
			
			 $query_mtype = "SELECT * FROM material_type_tbl WHERE id = '".sql_esc($ans22["mat_type"])."'";
             $result_mtype = mysqli_query($dbc,$query_mtype) or die (mysqli_error());
             $d_mtype = mysqli_fetch_array($result_mtype);
		  
		  //-----get cost center base on work center ------
		  $query_cct2 = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($ans22["prod_line"])."'";
		  $result_cct2 = mysqli_query($dbc,$query_cct2) or die (mysqli_error());
		  $data_cct2 = mysqli_fetch_array($result_cct2);
		  
		  
		  //-------model ---------
		  $query_mod = "SELECT * FROM model_detail_tbl WHERE id_model = '".sql_esc($ans22["model_code"])."'";
          $result_mod =mysqli_query($dbc,$query_mod);
		  $data_mod = mysqli_fetch_array($result_mod);
	
	 //-----------shift---------
	
		  
			if($_POST["shift_ops"] == "D/S")
			{
		     
			 $shift_day1 = $_POST["shift_ops"]; 		
				
			}elseif($_POST["shift_ops"] == "N/S")
			{
			 $shift_day2 = $_POST["shift_ops"]; 		  
				  
			}else{
				
			}
		//---------insert data at pps_detail_trn_bf_transit
		
		$query_data2 = "INSERT INTO pps_detail_trn_bf_transit (id,pps_id,ref_id,bflush_no,plan_no,id_scan,upload_id,model_code,month_plan,material_no,material_desc,material_type,qty_plan,qty_actual,qty_balance,qty_NG,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,status,user_upload,date_upload,user_create,date_create,user_update,date_update,user_posting,date_posting,time_posting,ploc,delivery_loc,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,status_ftp_bflush,bflush_no_ref,user_cancel,date_cancel,remark_cancel,plant_code,shift_posting,stamp_ind,barcode_gr,gr_doc_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','','','".sql_esc($ref)."','','".sql_esc($numb3)."','','".sql_esc($data_mod["model_code"])."','".sql_esc($mmF)."','".sql_esc($material_no)."','".sql_esc($ans22["material_desc"])."','".sql_esc($d_mtype["mat_type_id"])."','','".sql_esc($qty_actual)."','','','".sql_esc($rst_sta7["status_desc"])."','".sql_esc($plant_code)."','".sql_esc($ans22["prod_line"])."','".sql_esc($shift_day1)."','".sql_esc($shift_day2)."','".sql_esc($date1_final)."','Y','','','".sql_esc($username)."',NOW(),'','','".sql_esc($username)."','".sql_esc($date1_final)."',NOW(),'".sql_esc($ans22["sloc"])."','','','','','','','','','Y','','','','','".sql_esc($plant_code)."','".sql_esc($shift_ops)."','".sql_esc($d_mtype["mat_type_id"])."','".sql_esc($barcode_gr2)."','".sql_esc($part4)."','','')";
	    $result_data2 = mysqli_query($dbc,$query_data2);
 
 
      
	
	 //-------------------update---------------------
  
      $query_all_info = "SELECT * FROM pps_detail_trn_bf_transit WHERE id = '".mysqli_insert_id($dbc)."'";
	  $result_all_info = mysqli_query($dbc,$query_all_info);
	  $data_all_info = mysqli_fetch_array($result_all_info); 
	  
	
	  
	//-------insert table print_tag_backflush transit [generate print tag] ---------------	
	
	$query_tag = "SELECT * FROM pps_detail_trn_bf_transit WHERE id = '".sql_esc($data_all_info["id"])."'";
    $result_tag = mysqli_query($dbc,$query_tag);

  $no_tg = 1;
  
while($row = mysqli_fetch_array($result_tag))
{
		
	  $dl_qty = (intval($row["qty_actual"]));
	  
	  //----detail standard packaging [ambil dari table mat_master_header]
	  
	   $query_pack = "SELECT std_packaging, type_package, BUn FROM table_material_itsb WHERE material_no = '".sql_esc($row["material_no"])."'";
	   $result_pack = mysqli_query($dbc,$query_pack);
	   $data_pack = mysqli_fetch_array($result_pack);
		
		
		        if(($data_pack["std_packaging"] == "") || ($data_pack["std_packaging"] == "0"))
		        {
		
		        $st_pack = (intval($row["qty_actual"]));
	            }else{
		
                $st_pack = (intval($data_pack["std_packaging"]));
		        }
		 
      $bil_tag = ($dl_qty / $st_pack);
		
     $b =  intval($bil_tag);  // genapkan value yg dibahagikan utk didarabkan 
	// $b = round($bil_tag, 0, PHP_ROUND_HALF_DOWN);  // genapkan value yg dibahagikan utk didarabkan 
	 $last_tag = ($bil_tag - $b);	   // sekiranya masih ada baki utk keluarkn delivery tag yg last
	 
	 
	 $bil_tag2 = ($st_pack * $b);
	 
	 if($dl_qty < ($st_pack))
	 {
	 $bil_tag3 = ($dl_qty);
	 
	 }else{
	 $bil_tag3 =  ($dl_qty - $bil_tag2);  //quantity delivery tag yg last
      }
	// echo "last qty ".$last_tag;
	 
	/* $query_id2 = "SELECT MAX(tag_no) FROM delivery_tagasn";
     $result_id2 = mysql_query($query_id2);
	 $row_id2 = mysql_fetch_row($result_id2);
	 
	 $tag_no = ($row_id[1] + 1);
	 echo $tag_no;   */
	 
	// echo "B  : ".$b;
	  $b =  intval($bil_tag);
	  
	   if($b == 1)
	  {
	  $no_tg = 1;
	  
	  }elseif($last_tag == 0)
	  {
	   $no_tg = $b;
	   
	  }else{
	  
	  $no_tg = ($b + 1);
	  
	  }
	  
	$w = 1;
		   
     for($m=1; $m <= $bil_tag; $m++)
	 { 
	
	 
$query_tag3 = "INSERT INTO print_tag_bf_transit(id_tag,tag_no,id_tran,bflush_no,plan_no,rev_plan_no,material_no, material_desc,tag_qty, shift_tag,tag_uom,ploc,station_loc,model_code,pack_type,pack_no,posting_by,posting_date,posting_time,user_create,date_create,status_tag,status_print,month_plan,year_plan,slip_no,total_slip,plant_cd,status_bf,stamp_ind,material_type)  VALUES('','','".sql_esc($row["id"])."','".sql_esc($row["bflush_no"])."','".sql_esc($row["plan_no"])."','','".sql_esc($row["material_no"])."','".sql_esc($row["material_desc"])."','".sql_esc($st_pack)."','".sql_esc($row["shift_posting"])."','".sql_esc($data_pack["BUn"])."','".sql_esc($row["ploc"])."','".sql_esc($row["work_center"])."','".sql_esc($row["model_code"])."','".sql_esc($data_pack["type_package"])."','".sql_esc($data_pack["std_package"])."','".sql_esc($username)."','".sql_esc($row["date_posting"])."','".sql_esc($row["time_posting"])."','".sql_esc($username)."',NOW(),'N','N','".sql_esc($row["month_plan"])."',NOW(),'".sql_esc($w)."','".sql_esc($no_tg)."','".sql_esc($row["plant_code"])."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($row["stamp_ind"])."','".sql_esc($row["material_type"])."')";
	   $result_tag3 = mysqli_query($dbc,$query_tag3);
	   
	     $tag_no = ($row["bflush_no"].'/'.$w.'/'.$data_pack["std_packaging"].'/'.$no_tg);
		
		 
		 $query_tag3_t = "UPDATE print_tag_bf_transit SET tag_no = '".sql_esc($tag_no)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND bflush_no = '".sql_esc($ref)."'";
	     $result_tag3_t = mysqli_query($dbc,$query_tag3_t);
	   
     $w++; 
	
	 
	 } // end for loop
	 
	  if(($last_tag > 0.000) || ($dl_qty < ($st_pack))){	   // kalau qty lebih kecil drpd std packaging and baki drpd bahagi tag
	 
	 $query_tag2 = "INSERT INTO print_tag_bf_transit(id_tag,tag_no,id_tran,bflush_no,plan_no,rev_plan_no,material_no, material_desc,tag_qty, shift_tag,tag_uom,ploc,station_loc,model_code,pack_type,pack_no,posting_by,posting_date,posting_time,user_create,date_create,status_tag,status_print,month_plan,year_plan,slip_no,total_slip,plant_cd,status_bf,stamp_ind,material_type)  VALUES('','','".sql_esc($row["id"])."','".sql_esc($row["bflush_no"])."','".sql_esc($row["plan_no"])."','','".sql_esc($row["material_no"])."','".sql_esc($row["material_desc"])."','".sql_esc($bil_tag3)."','".sql_esc($row["shift_posting"])."','".sql_esc($data_pack["BUn"])."','".sql_esc($row["ploc"])."','".sql_esc($row["work_center"])."','".sql_esc($row["model_code"])."','".sql_esc($data_pack["type_package"])."','".sql_esc($data_pack["std_package"])."','".sql_esc($username)."','".sql_esc($row["date_posting"])."','".sql_esc($row["time_posting"])."','".sql_esc($username)."',NOW(),'N','N','".sql_esc($row["month_plan"])."',NOW(),'".sql_esc($w)."','".sql_esc($no_tg)."','".sql_esc($row["plant_code"])."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($row["stamp_ind"])."','".sql_esc($row["material_type"])."')"; 
	   $result_tag2 = mysqli_query($dbc,$query_tag2);
	   

       
	     $tag_no2 = ($row["bflush_no"].'/'.$w.'/'.$bil_tag3.'/'.($b + 1));
		 
		 $query_tag2_t = "UPDATE print_tag_bf_transit SET tag_no = '".sql_esc($tag_no2)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND bflush_no = '".sql_esc($ref)."'";
	     $result_tag2_t = mysqli_query($dbc,$query_tag2_t);
	   
	   
	   
	   
		 }// end if
	
	 
	  }// end while loop	
	 	 
	  
	  //--------update status_bf = In Progress --------
	   
	   $query_upd_sta7 = "UPDATE scan_bf_transit_dlv SET status_bf = '".sql_esc($rst_sta7["status_desc"])."' WHERE scan_doc = '".sql_esc($numb3)."'  AND user_create = '".sql_esc($username)."'";
	   $result_upd_sta7 = mysqli_query($dbc,$query_upd_sta7);
	 	       
	   //----checking ftp ftp_bflush_detail_bf_transit-------
  $data_rcv = "";
   

  $query_rcv_ftp = "SELECT *, DATE_FORMAT(date_posting,'%d%m%Y') AS J,  DATE_FORMAT(date_posting,'%Y-%m-%d') AS M, DATE_FORMAT(date_create,'%d%m%Y') AS R2 FROM pps_detail_trn_bf_transit WHERE bflush_no = '".sql_esc($ref)."'";
   $result_rcv_ftp = mysqli_query($dbc,$query_rcv_ftp);
   
   $filen_rcv = "BF".$ref; 
  
   while($data_rcv_ftp = mysqli_fetch_array($result_rcv_ftp))
   
   {
	     $qty_nw = (intval($data_rcv_ftp['qty_actual']));
	   
	     $query_mate = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($data_rcv_ftp["material_no"])."'";
		 $result_mate = mysqli_query($dbc,$query_mate) or die (mysqli_error());
		 $data_mate = mysqli_fetch_array($result_mate);
		  
		  //-------recipient ----------
		 $query_prep = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_rcv_ftp["user_posting"])."'";
		 $result_prep = mysqli_query($dbc,$query_prep) or die (mysqli_error());
		 $data_prep = mysqli_fetch_array($result_prep);
		  
 
$data_rcv .= $data_rcv_ftp['plant_code'].";".$data_rcv_ftp['bflush_no'].";".$data_rcv_ftp['J'].";".$data_rcv_ftp['material_no'].";".$qty_nw.";".$data_mate['BUn'].";131;2360;".$data_prep["user_fullname"]."\r\n";    
 
 
     //----------update table ftp_bflush_detail_bf_transit------------
	 
	   
    $query_rcv_ftp_info = "INSERT INTO ftp_bflush_detail_bf_transit(id,file_name,bflush_no,ref_id,plan_no,material_no,material_desc,qty_ftp,uom,status_ftp,posting_date,posting_time,user_create,date_create,plant_code,stamp_ind) VALUES('','".sql_esc($filen_rcv)."','".sql_esc($data_rcv_ftp["bflush_no"])."','".sql_esc($data_rcv_ftp["id"])."','','".sql_esc($data_rcv_ftp["material_no"])."','".sql_esc($data_rcv_ftp["material_desc"])."','".sql_esc($data_rcv_ftp["qty_actual"])."','".sql_esc($data_mate["BUn"])."','Y','".sql_esc($data_rcv_ftp["date_posting"])."','".sql_esc($data_rcv_ftp["time_posting"])."','".sql_esc($username)."',NOW(),'".sql_esc($data_rcv_ftp["plant_code"])."','".sql_esc($data_rcv_ftp["material_type"])."')"; 
     $rst_rcv_ftp_info = mysqli_query($dbc,$query_rcv_ftp_info);
	 
	
	  
	  } // end while loop

		$file_rcv = "../FromPortal/BF_TRANSIT/".$filen_rcv.".csv";
		file_put_contents($file_rcv,$data_rcv);

   
	   // ---update status 
   
		$query_rcv_ftp2 = "UPDATE pps_detail_trn_bf_transit SET status_ftp = 'Y' WHERE bflush_no = '".sql_esc($ref)."'";
		$rst_query_rcv_ftp2 = mysqli_query($dbc,$query_rcv_ftp2); //or die ("Error in query: $query_ftp"); 
		
				
    //---------------------------------------end ftp -------------------------------------------------   
	   
	 //update count_max----------------------------------------

  
       $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '19'";
	   $result_max_a = mysqli_query($dbc,$query_max_a);
	   
	   $query_max_AA = "UPDATE run_count_itsb SET count_max = '".sql_esc($number3)."', date_updated = NOW() WHERE uid = '135'";
	   $result_max_AA = mysqli_query($dbc,$query_max_AA);
	

   //end update count_max ---------------------------------	
   
    $buid2 = base64_encode($ref);
	  
    echo '<script type="text/javascript">';
	echo "alert('Material Document $ref posted.');";
	echo "window.open('detail_print_tag_bf_transit.php?buid=$buid2','_blank');";
	echo "window.location='bf_transit_do-dlv.php';"; 
	echo "</script>";
	exit(); //quit the script
   
	
	 }//end ifelse "OK"
	/*else{
	   
    echo '<script type="text/javascript">';
	echo "alert('Error! Transaction failed. Please enter field correctly.');";
	echo "window.location='bf_transit_do-dlv.php';"; 
	echo "</script>";
	exit(); //quit the script
	   
	   
   }*/

}// end submit 3



?>      
      <br>
            <form id="form1" method="post" action="" >
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th colspan="3">&nbsp;</th>
            </tr>
            <tr>
                <th>Scan GR Barcode : &nbsp;&nbsp;<i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="1. Goods Receipt Tag" data-html="true" data-placement="left"></i></th>
                <th colspan="3">
                
       <input name="barcode_ref" type="text" id="barcode_ref" maxlength="200" class="form-control" autofocus/>        
      <!-- <input name="barcode_gr" type="text" id="barcode_gr" maxlength="200" value="<?php if(isset($_POST['barcode_gr'])) echo html_esc($_POST['barcode_gr']); ?>" class="form-control" />-->
              
               </th>
              </tr>
             
             
              <tr>
                <th>
                
                <input name="submit3" type="submit" id="submit3" value="+ Add Item" class="button"  />
                <th colspan="3">&nbsp;</th>
              </tr>
            
                </table>
            </form>
        
        
        
        
        
         <?php 
		   //-------------list scan GR---------------------   
		  
             $query_scan_gr2 = "SELECT * FROM scan_bf_transit_dlv WHERE scan_doc = '".sql_esc($numb3)."' AND user_create = '".sql_esc($username)."'";
			 $result_scan_gr2 = mysqli_query($dbc,$query_scan_gr2);
			 $data_scan_gr2 = mysqli_fetch_array($result_scan_gr2);
		  
		  
		  
		     //-------------list scan GR---------------------   
		  
             $query_scan_gr = "SELECT * FROM scan_bf_transit_dlv WHERE scan_doc = '".sql_esc($numb3)."' AND user_create = '".sql_esc($username)."'";
			 $result_scan_gr = mysqli_query($dbc,$query_scan_gr);
			
	 $no3 = 1;
	 
	 
	 if($data_scan_gr2 >= 1)
	 {
	?>   
    
              
    <table width="100%" border="0" cellspacing="2" cellpadding="0" class="table table-dark">
    <tr>
    <td width="50">&nbsp;</td>
    <td width="75">Item</td>
    <td width="150">Part No.</td>
    <td width="220">Description</td>
    <td width="120">GR Doc No.</td>
    <td width="150">Quantity</td>
    <td width="80">UOM</td>
    </tr></table>
     <?php   }  ?>
     
       <table width="100%" cellspacing="2">
    <?php
  while($data_scan_gr = mysqli_fetch_array($result_scan_gr))
  {
	  $no3 = sprintf('%04d',$no3);
	  
	 ?>   <tr>
     <td width="50">
     <div align="center">
     <a href="delete_bf_transit_item.php?scan_doc=<?php echo html_esc($data_scan_gr["scan_doc"]); ?>&&p_id=<?php echo html_esc($data_scan_gr["id_scan_tp"]); ?>" onclick="return confirm('Are you sure you want to delete?')"><img src="../images/delete.png" alt="Remove Item"></a>
      </div> </td>  
    <td width="75"><?php echo $no3; ?> <input name="item_no[<?php echo html_esc($data_scan_gr["id_scan_tp"]); ?>]" type="hidden" value="<?php echo $no; ?>"></td>
    <td width="150"><?php echo html_esc($data_scan_gr["material_no"]);  ?></td>
    <td width="220"><?php echo html_esc($data_scan_gr["material_desc"]);  ?></td>
    <td width="120"><?php echo html_esc($data_scan_gr["doc_gra"]);  ?></td>
    <td width="150"><?php echo html_esc($data_scan_gr["scan_qty"]);  ?></td>
    <td width="80"><?php echo html_esc($data_scan_gr["scan_uom"]);  ?></td>
    </tr>
	<?php   

  $no3++;
 } 
   mysqli_free_result($result_scan_gr);   
?>
</table>


<br><h6>Fill up Backflush Transit detail : </h6>
     <form id="form2" method="post" action="" >
            <table class="table table-bordered">
            <tr>
              <th width="250">Posting Date :  <font color="#FF0000">*</font></th>
              <td colspan="3"><input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php if(isset($_POST['date1'])){ echo html_esc($_POST['date1']); }else{ echo $fmt_curr_date; } ?>" />
               <div class="form-control-feedback" ><?php echo $message_psdt; ?></div>
              </td>
              </tr>
              <tr>
            <th>Plant :  <font color="#FF0000">*</font></th>
            <td colspan="3">
           <select name="plant_code" class="form-control" onChange="getModelTy(this.value)">
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
                <th>Model : <font color="#FF0000">*</font></th>
                <td colspan="3"><div id="modeldiv">
                <select name="model_code" id="model_code" class="form-control" onChange="getMaterial(this.value)">
                  <option value="NULL" placeholder="Select Model"> -- Select Model --</option>
                </select></div>  <div class="form-control-feedback" ><?php echo $message_model; ?></div></td>
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
            <th>Quantity : </th>
            <td colspan="3">
        <input name="qty_actual" type="number" min="1" value="<?php if(isset($_POST["qty_actual"])) { echo html_esc($_POST["qty_actual"]); } ?>" class="form-control"/><div class="form-control-feedback" ><?php echo $message_qok; ?></div>
		     </td>
             </tr>
             
              <tr>
                <th>
                
               
                <input name="submit3A" type="submit" id="submit3A" value="SUBMIT" class="btn btn-primary btn-sm" onClick="return confirm('Are you sure to submit?');"  /></th>
                <th colspan="3">&nbsp;</th>
              </tr>
            
                </table>
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
	
	function getModelTy(plant_code) {		
		
		var strURL="findType-GRA.php?plant_code="+plant_code;
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
	
	function getMaterial(plant_code,material_type,model_code) {		
	
		var strURL="findMaterial-BFTRN.php?plant_code="+plant_code+"&material_type="+material_type+"&model_code="+model_code;
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
	function getModel(plant_code,material_type) {		
		
		var strURL="findModel-BFTRN.php?plant_code="+plant_code+"&material_type="+material_type;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('modeldiv').innerHTML=req.responseText;						
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