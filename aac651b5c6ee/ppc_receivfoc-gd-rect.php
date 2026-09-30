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
	
    $url = "ppc_receivfoc-gd-rect.php"; 
	
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
	
	<SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
    <script language="javascript">
document.addEventListener('DOMContentLoaded', function () {
	$('.datepicker').pickadate({
weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
showMonthsShort: true
})
	
});
</script>
<style>
	 div.dataTables_wrapper {
        width: 1200px;
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
          <p>Goods Receipt FOC</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Receiving</li>
          <li class="breadcrumb-item"><a href="ppc_receivfoc-gd-rect.php">Goods Receipt FOC</a></li>
        </ul>
      </div> 
      
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Goods Receipt FOC</h3>
            <div class="tile-body">
              <div class="table-responsive">
               <?php
			   
			   	  $message_vend = "";
	  
	$query_id = "SELECT * FROM run_count_itsb WHERE uid = '147'";
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
	$number2A = $dg; // Length of running no
    $number = sprintf('%07d', $number2A);  
	
	} // end if $result_id		

	
	
  
	
	     
        if((isset($_POST["submit3"]))  && $_POST!=="") 
{ // handle the form.

            $stamp_ind = $_POST["stamp_ind"];
            $category_mat = $_POST["category_mat"];
			$material_no = $_POST["material_no"];
			$vendor_code = $_POST["vendor_code"];			
			$material_type = $_POST['material_type'];
		    $model_code = $_POST['model_code'];
	    
	   if(($_POST["vendor_code"]) == "NULL")
     {
	     $vendor_code = FALSE;
		 $message_vend = '<span class="badge badge-pill badge-danger">Please select vendor!</span>';
	 }else{
		 $vendor_code = TRUE;
	  } 
	  
			
			   
        if($vendor_code)//everything ok
      {  
	        $stamp_ind = $_POST["stamp_ind"];
            $category_mat = $_POST["category_mat"];
			$material_no = $_POST["material_no"];
			$vendor_code = $_POST["vendor_code"];			
			$material_type = $_POST['material_type'];
		    $model_code = $_POST['model_code'];	
			
			
			 //-------Count all results------------------------//
			
				 $where_sql = '';
				 
				 
	
					
						
	       //1. Vendor Code
                if (($vendor_code == "") || ($vendor_code == "NULL")){ 
                    $wheresql_01 = " AND vendor_id = '".sql_esc($vendor_code)."'"; }
                else {
                    $wheresql_01 = " AND vendor_id = '".sql_esc($vendor_code)."'"; }  
					
		   //2. material_type
                if (($material_type == "") || ($material_type == "NULL")){ 
                    $wheresql_02 = " "; }
                else {
                    $wheresql_02 = " AND mat_type = '".sql_esc($material_type)."'"; } 
					
			//3. model_code
                if (($model_code == "") || ($model_code == "NULL")){ 
                    $wheresql_03 = " "; }
                else {
                    $wheresql_03 = " AND model_code = '".sql_esc($model_code)."'"; } 	
					
			 //4. category_mat
                if (($category_mat == "") || ($category_mat == "NULL")){ 
                    $wheresql_04 = " "; }
                else {
                    $wheresql_04 = " AND category_mat = '".sql_esc($category_mat)."'"; } 
					
			  //5. material_no
                if (($material_no == "") || ($material_no == "NULL")){ 
                    $wheresql_05 = " "; }
                else {
                    $wheresql_05 = " AND material_no = '".sql_esc($material_no)."'"; } 	
					
	                              
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;	
	
	//********** END CONDITION **************
			
			
			
			 $query_q2 = "SELECT * FROM table_material_itsb WHERE status_BOM = 'Y' ".$where_sql;
 			 $result_q2 = mysqli_query($dbc,$query_q2);
 
    while($ans3 = mysqli_fetch_array($result_q2))
	{
		
		
		 //---------detail material_type_tbl (material_type) ----
  
  $query_mtype2 = new PreparedSql("SELECT * FROM material_type_tbl WHERE id = ?", [$ans3["mat_type"]]);
  $result_mtype2 = db_query($dbc, $query_mtype2) or die (mysqli_error($dbc));
  $d_mtype2 = mysqli_fetch_array($result_mtype2);
  

  //---------detail model_detail_tbl(model_code) ---
  
  $query_mcode2 = new PreparedSql("SELECT * FROM model_detail_tbl WHERE id_model = ?", [$ans3["model_code"]]);
  $result_mcode2 = db_query($dbc, $query_mcode2) or die (mysqli_error($dbc));
  $d_mcode2 = mysqli_fetch_array($result_mcode2);
		
/*		
  $query_mate = "SELECT * FROM table_material_itsb WHERE material_no = '".$ans3["material_no"]."'";
  $result_mate = mysqli_query($dbc,$query_mate);	
  $row_mate = mysqli_fetch_array($result_mate);	*/	
		

	//insert to scan_detail
$query_db = "INSERT INTO sc_good_receipt_foc_rcv(id_scan,id_DI,id_gen,scan_doc,barcode_ref,material_no,material_desc,po_no,plant_code,material_type,work_center,scan_sloc,scan_shift,kanban_order,qty_dlv,qty_pending,scan_uom,DI_doc,back_no,dlv_ord_no,vc_code,model_cd,std_package,tbox_kanban,status_kanban,user_posting,posting_date,time_posting,scan_date,user_create,date_create,user_update,date_update,status,status_gr) VALUES('','','','".sql_esc($number)."','','".sql_esc($ans3["material_no"])."','".sql_esc($ans3["material_desc"])."','','".sql_esc($ans3["plant_code"])."','".sql_esc($d_mtype2["mat_type_id"])."','".sql_esc($ans3["prod_line"])."','".sql_esc($ans3["sloc"])."','','','','','".sql_esc($ans3["BUn"])."','','".sql_esc($ans3["back_no"])."','','".sql_esc($ans3["vendor_id"])."','".sql_esc($d_mcode2["model_code"])."','".sql_esc($ans3["std_packaging"])."','','','','','',NOW(),'".sql_esc($username)."',NOW(),'','','Y','".sql_esc($rst_sta["status_desc"])."')";
$result_db = mysqli_query($dbc,$query_db);	
		
		
		
	}
	
	
	        echo "<script>";
			echo "window.location='ppc_receivfoc-gd-rect.php?scan_doc=$number&&vendor_code=$vendor_code&&model_code=$model_code&&material_type=$material_type&&stamp_ind=$stamp_ind&&material_no=$material_no'";
            echo "</script>";
            exit(); //quit the script

  			
			
        }
		
		}// end submit
        
   
        
           //-------------------------------------------------------------------------------------------------------------------------
$message_shift = "";
$message_dlv = "";

if(isset($_POST["submit4T"]))  
{ // handle the form.

	require_once('../include/config.php');   //connect to the db.

	// Check, if username session is NOT set then this page will jump to login page
	if (!isset($_SESSION['username'])) {
	header('Location: ../index.php');
	exit();
	}



	//------generate Material Document No. for GR Generate.------------------

	$query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '148'";
	$result_id2 = mysqli_query($dbc,$query_id2);	



	if ($result_id2) 
	{
		$nrows2 = mysqli_num_rows($result_id2);
		$row_id2 = mysqli_fetch_array($result_id2);
		
		$dht2 = 00000; 
		$dht_OK2 = "151";
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
	 
	 
	$shift_ops = $_POST["shift_ops"];
	$dlv_ord_no = $_POST["dlv_ord_no"]; 
	   	
	if(($_POST["shift_ops"]) == "")
	{
		$shift_ops = FALSE;
		$message_shift = 'Please select Shift Posting!';
	}else{
		$shift_ops = TRUE;
	}
	   
	if(($_POST["dlv_ord_no"]) == "")
	{
		$dlv_ord_no = FALSE;
		$message_dlv = 'Please enter Delivery Order No.!';
	}else{
		$dlv_ord_no = TRUE;
	}
	  
	if($shift_ops && $dlv_ord_no)
	{
 

		if(isset($_POST['e_tcid']))
		{
			

		
			$trc_id = $_POST['e_tcid'];
			$scan_doc = $number;  
			$item_no = $_POST["item_no"];
			$id_scan = $_POST["id_scan"];  
			$plant_code2 = $_POST["plant_code2"];
			$shift_ops = $_POST["shift_ops"];
			$dlv_ord_no = $_POST["dlv_ord_no"];
			$date_posting = $_POST["PSSDate"];
			$std_packageA = $_POST["std_package"];
			$gr_qty = $_POST["gr_qty"];
		
			// echo "<pre>";
			// var_dump($_POST["gr_qty"]);
			// var_dump($_POST["e_tcid"]);
			// echo "</pre>";

			$amountA = [];
			$amountB = [];
			$amountC = [];
			$amountD = [];
		
			for($k=0; $k < count($trc_id); $k++)
			{
				
				$tracking_id = $trc_id[$k]; // Get the tracking ID from e_tcid array

				// Ensure input exists
				if (!isset($_POST["gr_qty"][$tracking_id]) || trim($_POST["gr_qty"][$tracking_id]) === "") {
					continue;
				}
			
				// Convert to float after checking existence
				$gr_qty = (float) $_POST["gr_qty"][$tracking_id];
			
				// Skip iteration if GR Quantity is 0, negative, or null
				if ($gr_qty <= 0.0001) { 
					continue;
				}

				$amountA[$tracking_id] = $_POST["item_no"][$tracking_id];
				$amountB[$tracking_id] = $_POST["id_scan"][$tracking_id];
				$amountC[$tracking_id] = $_POST["gr_qty"][$tracking_id];
				$amountD[$tracking_id] = $_POST["std_package"][$tracking_id];

				// Output in correct order
				// echo '<br/> start' . str_pad($k + 1, 4, "0", STR_PAD_LEFT);
				// echo '<br/>' . $tracking_id;
				// echo '<br/>' . $amountA[$tracking_id];
				// echo '<br/>' . $amountB[$tracking_id];
				// echo '<br/>' . $amountC[$tracking_id];
				// echo '<br/>' . $amountD[$tracking_id];
				// echo '<br/>';
				// if(($_POST["gr_qty"][$k]) == "0")
				// { 
				// 	$gr_qty = FALSE;
					
				// 	echo '<script type="text/javascript">';
				// 	echo "alert('Error! Please enter GR Quantity');";
				// 	echo "window.location='ppc_receivfoc-gd-rect.php?scan_doc=$number';"; 
				// 	echo "</script>";
				// 	exit(); //quit the script
					
				// }//end if
		
				$ddF = substr($_POST["PSSDate"],0,2);
				$mmF = substr($_POST["PSSDate"],3,2);
				$yyF = substr($_POST["PSSDate"],6,4);
				
				$date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				
				/*echo $stringC[$k]; echo "<br>";
				echo $stringD[$k]; echo "<br>";
				echo $trc_id[$k];  echo "<br>";*/
		
				///PO details
				$query_po_list = "SELECT * FROM sc_good_receipt_foc_rcv WHERE id_scan = '".sql_esc($trc_id[$k])."'";
				$result_po_list = mysqli_query($dbc,$query_po_list);
				if (!$result_po_list) {
					die("Query failed: " . mysqli_error($dbc));
				}
				$row_po_list = mysqli_fetch_array($result_po_list);
				///----check material -----
				
				$query_mat_info = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ?", [$row_po_list["material_no"]]);
				$result_mat_info = db_query($dbc, $query_mat_info);
				if (!$result_mat_info) {
					die("Query failed: " . mysqli_error($dbc));
				}
				$row_mat_info = mysqli_fetch_array($result_mat_info);
				
				
				$query_tag3 = "INSERT INTO po_detail_trans_gr_foc(id,id_scan,id_DI,id_gen,scan_doc,doc_gen,back_no,plant_code,purc_ord_no,vendor_id,gr_chg,deleg_gr,item_no,material_no,material_desc,size_gr,model_gr,matl_group,purc_group,material_type,work_center,sloc,doc_date,po_qty,ord_uom,yr_gr,user_create,date_create,user_update,date_update,date_upload,status_po,dlv_ord_no,shift_gr,user_posting,posting_gr,sloc_gr,rec_qty,gr_qty,status_gr,material_doc_gen,date_post,time_post,ref_doc_gen,user_cancel,date_cancel,time_cancel,std_package,tbox_kanban,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($trc_id[$k])."','".sql_esc($row_po_list["id_DI"])."','".sql_esc($row_po_list["id_gen"])."','".sql_esc($row_po_list["scan_doc"])."','".sql_esc($row_po_list["DI_doc"])."','".sql_esc($row_po_list["back_no"])."','".sql_esc($row_po_list["plant_code"])."','".sql_esc($row_po_list["po_no"])."','".sql_esc($row_po_list["vc_code"])."','','','','".sql_esc($row_po_list["material_no"])."','".sql_esc($row_po_list["material_desc"])."','".sql_esc($row_mat_info["size_dim"])."','".sql_esc($row_po_list["model_cd"])."','".sql_esc($row_mat_info["material_group"])."','".sql_esc($row_mat_info["acc_group"])."','".sql_esc($row_po_list["material_type"])."','".sql_esc($row_po_list["work_center"])."','".sql_esc($row_po_list["scan_sloc"])."','".sql_esc($row_po_list["scan_date"])."','".sql_esc($row_po_list["kanban_order"])."','".sql_esc($row_po_list["scan_uom"])."','".sql_esc($yyF)."','".sql_esc($row_po_list["user_create"])."','".sql_esc($row_po_list["date_create"])."','".sql_esc($username)."',NOW(),'','".sql_esc($rst_sta7["status_desc"])."','".sql_esc($dlv_ord_no)."','".sql_esc($shift_ops)."','".sql_esc($username)."','".sql_esc($rst_sta3["status_desc"])."','".sql_esc($row_po_list["scan_sloc"])."','".sql_esc($row_po_list["qty_dlv"])."','','".sql_esc($rst_sta3["status_desc"])."','".sql_esc($ref3)."',NOW(),NOW(),'','','','','','".sql_esc($row_po_list["tbox_kanban"])."','','')";								
				$result_tag3 = mysqli_query($dbc,$query_tag3);

				$upd_chg2 = "UPDATE po_detail_trans_gr_foc SET shift_gr = '".sql_esc($shift_ops)."', posting_gr = '".sql_esc($date1_final)."', item_no = '".sql_esc($amountA[$tracking_id])."', gr_qty = '".sql_esc($amountC[$tracking_id])."', std_package = '".sql_esc($amountD[$tracking_id])."' WHERE id = '".mysqli_insert_id($dbc)."' AND id_scan = '".sql_esc($trc_id[$k])."' AND material_doc_gen = '".sql_esc($ref3)."' ";						
				$rstupd_chg2 = mysqli_query($dbc,$upd_chg2) or die('Error, insert query failed with:' . $upd_chg2);
				if (!$rstupd_chg2) {
					die("Update failed: " . mysqli_error($dbc));
				}
				
				if (mysqli_affected_rows($dbc) == 0) {
					die("Update did not affect any rows.");
				}
				
				
				//update table sc_good_receipt_rcv = In Progress
				$query_releas_v2 = "UPDATE sc_good_receipt_foc_rcv SET status_gr = '".sql_esc($rst_sta7["status_desc"])."', user_update = '".strtoupper($username)."', date_update = NOW() WHERE id_scan = '".sql_esc($trc_id[$k])."'";
				$result_releas_v2 = mysqli_query($dbc,$query_releas_v2);
		
		
				//update table print tag GR
				$query_all = "SELECT * FROM po_detail_trans_gr_foc WHERE id_scan = '".sql_esc($trc_id[$k])."' AND material_doc_gen = '".sql_esc($ref3)."' AND status_gr = '".sql_esc($rst_sta3["status_desc"])."' ";
				$result_all = mysqli_query($dbc,$query_all);
				$data_all = mysqli_fetch_array($result_all);
				
				//$dl_qty = (intval($data_all["gr_qty"]));
				
				$dl_qty = $data_all["gr_qty"];
				

				//----detail standard packaging [ambil dari table mat_master_header]
				$query_pack2 = "SELECT std_packaging, type_package, size_dim FROM table_material_itsb WHERE material_no = '".sql_esc($data_all["material_no"])."'";
				$result_pack2 = mysqli_query($dbc,$query_pack2);
				$data_pack2 = mysqli_fetch_array($result_pack2);
				
				$query_pack = "SELECT * FROM po_detail_trans_gr_foc WHERE id_scan = '".sql_esc($trc_id[$k])."' AND material_no = '".sql_esc($data_all["material_no"])."'";
				$result_pack = mysqli_query($dbc,$query_pack);
				$data_pack = mysqli_fetch_array($result_pack);
			
			
			
				if(empty(trim($data_pack["std_package"])) || trim($data_pack["std_package"]) == "0")
				{
		
					// $st_pack = (intval($data_all["gr_qty"]));
					$st_pack = $data_all["gr_qty"];
					
				}
				else{
		
					//$st_pack = (intval($data_pack["std_package"]));
					$st_pack = $data_pack["std_package"];
				}
			
				// $bil_tag = (($dl_qty)/($st_pack));
				
				// $b =  intval($bil_tag);  // genapkan value yg dibahagikan utk didarabkan 
				// // $b = round($bil_tag, 0, PHP_ROUND_HALF_DOWN);  // genapkan value yg dibahagikan utk didarabkan 
				// $last_tag = ($bil_tag - $b);	   // sekiranya masih ada baki utk keluarkn delivery tag yg last
				
				// $bil_tag2 = ($st_pack * $b);
				
				// if($dl_qty < ($st_pack))
				// {
				// 	$bil_tag3A = ($dl_qty);
				// }else{
				// 	$bil_tag3A =  ($dl_qty - $bil_tag2);  //quantity delivery tag yg last
				// }
				
				// if($b <= 1)
				// {
				$no_tg = 1;
				// }
				// elseif($last_tag == 0)
				// {
				// 	$no_tg = $b;
				// }
				// else
				// {
				// 	$no_tg = ($b + 1);
				// }
				
				$w = 1;
			
				// for($m=1; $m <= $bil_tag; $m++)
				// { 
				
				// 	$bil_tag_newA = (($dl_qty)/($st_pack));
				
				// 	if(($bil_tag_newA > '1.000') && ($bil_tag_newA < '1.999'))
				// 	{
				
						$query_tag3B = "INSERT INTO print_tag_gdfoc_receipt
						(id_tag,tag_no,id_gr,id_scan,material_doc_gen,doc_gen,dlv_ord_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,
						model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,
						status_po,yr_gr,slip_no,total_slip)
						VALUES('','','".sql_esc($data_all["id"])."','".sql_esc($data_all["id_scan"])."','".sql_esc($data_all["material_doc_gen"])."','".sql_esc($data_all["doc_gen"])."',
						'".sql_esc($data_all["dlv_ord_no"])."','".sql_esc($data_all["plant_code"])."','".sql_esc($data_all["purc_ord_no"])."','".sql_esc($data_all["vendor_id"])."',
						'".sql_esc($data_all["item_no"])."','".sql_esc($data_all["material_no"])."','".sql_esc($data_all["material_desc"])."','".sql_esc($data_pack2["size_dim"])."',
						'".sql_esc($data_all["model_gr"])."','".sql_esc($data_all["ord_uom"])."','".sql_esc($dl_qty)."','".sql_esc($data_all["shift_gr"])."','".sql_esc($data_all["sloc"])."',
						'".sql_esc($data_all["sloc_gr"])."','".sql_esc($data_all["user_posting"])."','".sql_esc($data_all["posting_gr"])."','".sql_esc($data_all["time_post"])."',
						'".strtoupper($username)."',NOW(),'N','N','".sql_esc($data_all["status_po"])."',NOW(),'".sql_esc($w)."','".sql_esc($no_tg)."')";

						$result_tag3B = mysqli_query($dbc,$query_tag3B);
						
						$tag_no3B = ($data_all["material_doc_gen"].'/'.$w.'/'.$dl_qty.'/'.$no_tg);
						
						
						$query_tag3_t = "UPDATE print_tag_gdfoc_receipt SET tag_no = '".sql_esc($tag_no3B)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND material_doc_gen = '".sql_esc($ref3)."'";
						$result_tag3_t = mysqli_query($dbc,$query_tag3_t);
					
				
				
				// 	}else{
				
				// 		$query_tag3B = "INSERT INTO print_tag_gdfoc_receipt(id_tag,tag_no,id_gr,id_scan,material_doc_gen,doc_gen,dlv_ord_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_po,yr_gr,slip_no,total_slip) VALUES('','','".$data_all["id"]."','".$data_all["id_scan"]."','".$data_all["material_doc_gen"]."','".$data_all["doc_gen"]."','".$data_all["dlv_ord_no"]."','".$data_all["plant_code"]."','".$data_all["purc_ord_no"]."','".$data_all["vendor_id"]."','".$data_all["item_no"]."','".$data_all["material_no"]."','".$data_all["material_desc"]."','".$data_pack2["size_dim"]."','".$data_all["model_gr"]."','".$data_all["ord_uom"]."','$st_pack','".$data_all["shift_gr"]."','".$data_all["sloc"]."','".$data_all["sloc_gr"]."','".$data_all["user_posting"]."','".$data_all["posting_gr"]."','".$data_all["time_post"]."','".strtoupper($username)."',NOW(),'N','N','".$data_all["status_po"]."',NOW(),'".$w."','".$no_tg."')";
				// 		$result_tag3B = mysqli_query($dbc,$query_tag3B);
						
				// 		$tag_no3B = ($data_all["material_doc_gen"].'/'.$w.'/'.$data_pack["std_package"].'/'.$no_tg);
						
						
				// 		$query_tag3_t = "UPDATE print_tag_gdfoc_receipt SET tag_no = '".$tag_no3B."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND material_doc_gen = '".$ref3."'";
				// 		$result_tag3_t = mysqli_query($dbc,$query_tag3_t);
					
				// 	}
					
					
				// 	$w++; 
					
				// } // end for loop
			
				// if(($last_tag > 0.000) || ($dl_qty < ($st_pack)))// kalau qty lebih kecil drpd std packaging and baki drpd bahagi tag
				// {	 
				// 	$bil_tag_new = (($dl_qty)/($st_pack));
				
				// 	if(($bil_tag_new > '1.000') && ($bil_tag_new < '1.999'))
				// 	{
					
				// 		$query_tag2 = "INSERT INTO print_tag_gdfoc_receipt(id_tag,tag_no,id_gr,id_scan,material_doc_gen,doc_gen,dlv_ord_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_po,yr_gr,slip_no,total_slip) 
				// 					VALUES('','','".$data_all["id"]."','".$data_all["id_scan"]."','".$data_all["material_doc_gen"]."','".$data_all["doc_gen"]."','".$data_all["dlv_ord_no"]."','".$data_all["plant_code"]."','".$data_all["purc_ord_no"]."','".$data_all["vendor_id"]."','".$data_all["item_no"]."','".$data_all["material_no"]."','".$data_all["material_desc"]."','".$data_pack2["size_dim"]."','".$data_all["model_gr"]."','".$data_all["ord_uom"]."','".$bil_tag3A."','".$data_all["shift_gr"]."','".$data_all["sloc"]."','".$data_all["sloc_gr"]."','".$data_all["user_posting"]."','".$data_all["posting_gr"]."','".$data_all["time_post"]."','".strtoupper($username)."',NOW(),'N','N','".$data_all["status_po"]."',NOW(),'".$w."','2')"; 
				// 		$result_tag2 = mysqli_query($dbc,$query_tag2);
						
					
				// 		$tag_no2 = ($data_all["material_doc_gen"].'/'.$w.'/'.$bil_tag3A.'/'.($b + 1));  
					
				// 		$query_tag2_t = "UPDATE print_tag_gdfoc_receipt SET tag_no = '".$tag_no2."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND material_doc_gen = '".$ref3."'";
				// 		$result_tag2_t = mysqli_query($dbc,$query_tag2_t);
					
				// 	}else{
					
			
				// 		$query_tag2 = "INSERT INTO print_tag_gdfoc_receipt(id_tag,tag_no,id_gr,id_scan,material_doc_gen,doc_gen,dlv_ord_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_po,yr_gr,slip_no,total_slip) 
				// 					VALUES('','','".$data_all["id"]."','".$data_all["id_scan"]."','".$data_all["material_doc_gen"]."','".$data_all["doc_gen"]."','".$data_all["dlv_ord_no"]."','".$data_all["plant_code"]."','".$data_all["purc_ord_no"]."','".$data_all["vendor_id"]."','".$data_all["item_no"]."','".$data_all["material_no"]."','".$data_all["material_desc"]."','".$data_pack2["size_dim"]."','".$data_all["model_gr"]."','".$data_all["ord_uom"]."','".$bil_tag3A."','".$data_all["shift_gr"]."','".$data_all["sloc"]."','".$data_all["sloc_gr"]."','".$data_all["user_posting"]."','".$data_all["posting_gr"]."','".$data_all["time_post"]."','".strtoupper($username)."',NOW(),'N','N','".$data_all["status_po"]."',NOW(),'".$w."','".$no_tg."')"; 
				// 		$result_tag2 = mysqli_query($dbc,$query_tag2);
						
						
				// 		$tag_no2 = ($data_all["material_doc_gen"].'/'.$w.'/'.$bil_tag3A.'/'.($b + 1));  
						
				// 		$query_tag2_t = "UPDATE print_tag_gdfoc_receipt SET tag_no = '".$tag_no2."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND material_doc_gen = '".$ref3."'";
				// 		$result_tag2_t = mysqli_query($dbc,$query_tag2_t);
					
				// 	}// end if
			
				// }// end if
			
			
				//--------------update print tag max second ------
				
				$query_all_taging = "SELECT MAX(slip_no) AS GD FROM print_tag_gdfoc_receipt WHERE material_doc_gen = '".sql_esc($ref3)."' GROUP BY material_no";
				$result_all_taging = mysqli_query($dbc,$query_all_taging);
				$data_all_taging = mysqli_fetch_array($result_all_taging);
			
			
				/*if($data_all_taging["GD"] == "2")
				{
					
				$query_max_tag = "UPDATE print_tag_gdfoc_receipt SET total_slip = '2' WHERE material_doc_gen = '".$ref3."'";
				$result_max_tag = mysqli_query($dbc,$query_max_tag);
					
				}else{
					
				}*/
				
				//--------------------check Azie -23 Jun 2021----------------------------------	
				
				//----update tbox kanban new standard package-------
				
				$upd_chg3 = "UPDATE po_detail_trans_gr_foc SET tbox_kanban = '".sql_esc($no_tg)."' WHERE id_scan = '".sql_esc($trc_id[$k])."' AND material_doc_gen = '".sql_esc($ref3)."'";						
				$rstupd_chg3 = mysqli_query($dbc,$upd_chg3);
		
				//-----------------------------------------------------------------------

		
				//generate text file ftp GR				
				$qry = mysqli_query($dbc,"SELECT *, DATE_FORMAT(posting_gr,'%d%m%Y') AS R FROM po_detail_trans_gr_foc WHERE material_doc_gen = '".sql_esc($ref3)."'");
				
				$data = "";
				while($row = mysqli_fetch_array($qry)) 
				{
		
					if($row['gr_qty'] != "0.000")
					{
							
						$qty_nw = (($row['gr_qty']));
						
						$data .= ";".$row['material_doc_gen'].";".$row['dlv_ord_no'].";".$row['R'].";".$row['material_no'].";".$qty_nw.";".$row['ord_uom'].";511;".$row['sloc_gr'].";".$row['user_posting'].";".$row['vendor_id']."\r\n";
						
						
						//----------update table ftp_detail_gd_receipt_cancel------------
					
						$query_rcv_ftp_info = "INSERT INTO ftp_detail_gdfoc_receipt(id_ups,file_name,material_doc_gen,id_gr,doc_gen,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,sloc,sloc_gr,doc_date,po_qty,gr_qty,ord_uom,user_posting,date_posting,time_posting,status_po,status_ftp,mvt_type) VALUES('','','".sql_esc($row["material_doc_gen"])."','".sql_esc($row["id"])."','".sql_esc($row["doc_gen"])."','".sql_esc($row["plant_code"])."','".sql_esc($row["purc_ord_no"])."','".sql_esc($row["vendor_id"])."','".sql_esc($row["item_no"])."','".sql_esc($row["material_no"])."','".sql_esc($row["material_desc"])."','".sql_esc($row["sloc"])."','".sql_esc($row["sloc_gr"])."','".sql_esc($row["doc_date"])."','".sql_esc($row["po_qty"])."','".sql_esc($row["gr_qty"])."','".sql_esc($row["ord_uom"])."','".sql_esc($username)."','".sql_esc($row["date_post"])."','".sql_esc($row["time_post"])."','".sql_esc($row["status_po"])."','Y','511')";      
						$rst_rcv_ftp_info = mysqli_query($dbc,$query_rcv_ftp_info);
		
					}
				}
		
				$filen = "GR".$ref3;
				//$csv_filename = $filen."_".date("YmdHis",time());
				
				$file = "../FromPortal2/GR/".$filen.".csv";
				//chmod($file, 0777);
				file_put_contents($file,$data);
		
		
		
				$query_upd_file = "UPDATE ftp_detail_gdfoc_receipt SET file_name = '".sql_esc($filen)."' WHERE material_doc_gen = '".sql_esc($ref3)."'";
				$result_upd_file = mysqli_query($dbc,$query_upd_file);
			
			} // end forloop
		
		
			///update count_max----------------------------------------
			if($res["plant_code"] == '3100')
			{
				$query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '148'";
				$result_max_a = mysqli_query($dbc,$query_max_a);
				
				$query_max_aA = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '147'";
				$result_max_aA = mysqli_query($dbc,$query_max_aA);
			}
			
			$buid2 = base64_encode($ref3);

			echo "<script>";
			echo "alert('Material Document $ref3 posted.');";
			echo "window.open('detail_print_gdfoc_receipt-ts.php?uid2=$buid2', '_blank');";
			echo "window.location='ppc_receivfoc-gd-rect.php'";
			echo "</script>";
			exit(); //quit the script
		
		
		
		}else{
		
			
			echo '<script type="text/javascript">';
			echo "alert('Error! Transaction failed. Please select item.');";
			echo "window.location='ppc_receivfoc-gd-rect.php?scan_doc=$number';"; 
			echo "</script>";
			exit(); //quit the script
		
		
		
		} 
   
	}else{
		  
		  
		  
		echo '<script type="text/javascript">';
		echo "alert('Error! $message_dlv . $message_shift ');";
		echo "window.location='ppc_receivfoc-gd-rect.php?scan_doc=$number';"; 
		echo "</script>";
		//exit(); //quit the script
 	 
		  
		  
	}




}// end submit 4



if(isset($_POST["submit5T"])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

//-----------delete all data current screen-------------

   $query_delete_scan = "DELETE FROM sc_good_receipt_foc_rcv WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
   $result_delete_scan = mysqli_query($dbc,$query_delete_scan);

//---------end delete ----------------------------------


}

?>  
            <form action="" method="post" name="frmSearch" id="frmSearch">
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%">&nbsp;</th>
            </tr>   
              <tr>
                <th>Vendor : <font color="#FF0000">*</font></th>
                <th>
               		
           <select name="vendor_code" class="form-control" onChange="getType(this.value)">
            <option value="NULL" placeholder="Select Vendor"> -- Select Vendor -- </option>
          <?php
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM vendor_detail WHERE status_foc = "Y"';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
              ?>
         <option value="<?php echo html_esc($row27["vendor_code"]); ?>" > <?php echo stripslashes($row27["vendor_code"]); ?> - <?php echo html_esc($row27["vendor_name"]); ?></option>
          <?php
           }  ?>
                            
        </select><div class="form-control-feedback" ><?php echo $message_vend; ?></div>
                </th>
              </tr>
         <tr>
                <th>Type :</th>
                <th colspan="3">
              <div id="mtype_div"> 
             <select name="material_type" id="material_type" class="form-control" onChange="getModel(this.value)">
                <option value="NULL" placeholder="Select Type"> -- Select Type -- </option>
                </select>
              </div>    
         
               </th>
              </tr>
              <tr>
                <th>Model :</th>
                <th colspan="3">
                
                <div id="model_div">
                <select name="model_code" id="model_code" class="form-control" onChange="getCategory(this.value)">
                  <option value="NULL" placeholder="Select Model"> -- Select Model --</option>
                </select></div>  
                
              </th>
              </tr>  
            <tr>
            <th>Category :</th>
            <td colspan="3">
             <div id="catm_div">
                 <select name="stamp_ind" class="form-control" onChange="getMaterial(this.value)">
                 <option value="NULL" placeholder="Select Category"> -- Select Category -- </option>
                </select></div>
             
		     </td>
             </tr>
            
             <tr>
            <th>Part No. : </th>
            <td colspan="3">
            <div id="mat_div"> 
                 <select name="material_no" id="material_no" class="form-control" > 
                  <option value="NULL" placeholder="Select Part Number"> -- Select Part Number --</option>
                 </select></div>
               
		     </td>
             </tr>      
              
       
             
              <tr>
                <th><input name="submit3" type="submit" id="submit3" value="SEARCH" class="btn btn-primary btn-sm"  /></th>
                <th>&nbsp;</th>
              </tr>
            
                </table>
        </form>
 
      
         <?php

     $no = 1;
	 $sloc_to = "";
	 $k = 1;
	 $w = 1;


   
             $query_sql2 = "SELECT *,DATE_FORMAT(posting_date,'%d-%m-%Y') as R FROM sc_good_receipt_foc_rcv WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
			 $result_sql2 = mysqli_query($dbc,$query_sql2);
			 $num_1 = mysqli_num_rows($result_sql2);   //how many material are there?
    
		  
		 if ($num_1 > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_1.' record(s).</div>'; 
			 
			 			 //---------------------------------------------
	
		$query_vend = "SELECT * FROM sc_good_receipt_foc_rcv WHERE scan_doc = '".sql_esc($number)."' ";
		$result_vend = mysqli_query($dbc,$query_vend);
		$row_vend = mysqli_fetch_array($result_vend);
		
		//-------check vendor detail ----------

				  $query5a = new PreparedSql("SELECT * FROM vendor_detail WHERE vendor_code = ?", [$row_vend["vc_code"]]);
				  $result5a = db_query($dbc, $query5a);
			      $row5a = mysqli_fetch_array($result5a);	 
			 
	   
        
    	?>

  
           <form name="frm-example" id="frm-example" method="post" action="">
           
           <table class="table table-bordered">
            <tr>
                <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
                <th width="69%" colspan="2">&nbsp;</th>
            </tr>
            <tr>
                <th>Delivery Order No. : <font color="#FF0000">*</font></th>
                <td colspan="2">
                <input class="form-control" id="dlv_ord_no" type="text" placeholder="Enter Delivery Order No." name="dlv_ord_no" value="<?php if(isset($_POST['dlv_ord_no'])){ echo html_esc($_POST['dlv_ord_no']); } ?>"  autofocus/> <div class="form-control-feedback" ><?php echo $message_dlv; ?></div> 
            	</td>
            </tr> 
            <tr>
            	<th>Posting Date : </th>
            	<td colspan="2"><input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="PSSDate" value="<?php if(isset($_POST['PSSDate'])){ echo html_esc($_POST['PSSDate']); }else{ echo $fmt_curr_date; } ?>"></td>
            </tr>
            <tr>
                <th>Vendor : </th>
                <th colspan="2"><input class="form-control" id="vendor_id" type="text" name="vendor_id" readonly value="<?php echo html_esc($row_vend["vc_code"]). ' - ' .html_esc($row5a["vendor_name"]); ?>"/></th>
            </tr>
            <tr>
            <th>Shift :</th>
            	<td><div class="form-check"><input class="form-check-input" id="shift_ops" type="radio" name="shift_ops" value="D/S" checked>Day</div><div class="form-control-feedback" ><?php echo $message_shift; ?></div></td>
            	<td><div class="form-check"><input class="form-check-input" id="shift_ops" type="radio" name="shift_ops" value="N/S">Night</div><div class="form-control-feedback" ><?php echo $message_shift; ?></div></td>
            </tr>
            </table>
           
           
           
                <table class="table table-hover table-bordered" id="example">
                <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Item.</th>
                    <th>Part Number</th>
                    <th>Part Name</th>
                    <th>GR Qty</th>
                    <th>UoM</th>
                    <th>Standard Package</th>
                </tr>
              </thead>    
              <tbody>
           <?php 

   $counter = 1;
   $no4 = 1;
   $sta_out = "";
   $gr_qty_new = "0.000";
   
   while($row = mysqli_fetch_array($result_sql2))
   {
	   
	    $no4 = sprintf('%04d',$no4);
		
		 //---get info sc_gra_return_rcv	
		$query_sc_asal = "SELECT * FROM sc_good_receipt_foc_rcv WHERE id_scan = '".sql_esc($row["id_scan"])."'";
		$rs_sc_asal  = mysqli_query($dbc,$query_sc_asal);
	    $data_sc_asal  = mysqli_fetch_array($rs_sc_asal);


		
      ?> 
                   
                <tr> 
                <td width="5%" align="center">
                    <input type="checkbox" id="checkbox" name="e_tcid[]" value="<?php echo html_esc($row["id_scan"]); ?>" class="form-check" checked></td>
                
                <td width="50"><?php echo $no4; ?><input name="id_scan[<?php echo html_esc($row["id_scan"]); ?>]" type="hidden" value="<?php echo html_esc($row["id_scan"]); ?>">
                <input name="item_no[<?php echo html_esc($row["id_scan"]); ?>]" type="hidden" value="<?php echo $no4; ?>"></td>
                <td width="200"><?php echo html_esc($row["material_no"]); ?></td>
                <td width="350"><?php echo html_esc($row["material_desc"]); ?></td>
                
                <td width="200"><input name="gr_qty[<?php echo html_esc($row["id_scan"]); ?>]" id="gr_qty" value="<?php echo $gr_qty_new; ?>" type="number" class="form-control form-control-sm" step="0.001" "></td>
                <td width="80"><?php echo html_esc($row["scan_uom"]); ?></td> 
                <td width="200"><input name="std_package[<?php echo html_esc($row["id_scan"]); ?>]" type="text" value="<?php echo html_esc($row["std_package"]); ?>" id="std_package" class="form-control form-control-sm" readonly> <input name="plant_code2" type="hidden" value="<?php echo html_esc($row["plant_code"]); ?>"> </td>
         
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
               <input name="submit4T" type="submit" id="submit4T" value="SUBMIT" class="btn btn-success btn-sm" onclick="return confirm('Post GR Transaction?');">
               <input name="submit5T" type="submit" id="submit5T" class="btn btn-warning btn-sm" value="CLEAR">
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
   <!-- <script type="text/javascript">$('#sampleTable').DataTable();</script>-->
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
    <script type="text/javascript">
      $('#sl').on('click', function(){
      	$('#tl').loadingBtn();
      	$('#tb').loadingBtn({ text : "Signing In"});
      });
      
      $('#el').on('click', function(){
      	$('#tl').loadingBtnComplete();
      	$('#tb').loadingBtnComplete({ html : "Sign In"});
      });
      
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
	
	
		function getType(vendor_code) {		
		
		var strURL="findType-GRFOC.php?vendor_code="+vendor_code;
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
	
	
	function getModel(vendor_code,material_type) {		
		
		var strURL="findModel-GRFOC.php?vendor_code="+vendor_code+"&material_type="+material_type;
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
	
	
	
	function getCategory(vendor_code,material_type,model_code) {		
		
		var strURL="findCat-GRFOC.php?vendor_code="+vendor_code+"&material_type="+material_type+"&model_code="+model_code;
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
	
	
function getMaterial(vendor_code,material_type,model_code,stamp_ind) {		
	
		var strURL="findMaterial-GRFOC.php?vendor_code="+vendor_code+"&material_type="+material_type+"&model_code="+model_code+"&stamp_ind="+stamp_ind;
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
    /*validate meeting details */
    function addGr(){
    
        var dlv_no = $("#dlv_ord_no").val();
		var pos_dt = $("#PSSDate").val();
		
        if (confirm('Post GR transaction?')){
        
            if(dlv_no == '' )
			{
				alert('Delivery Order No is required.');			
				document.getElementById('dlv_ord_no').focus();
				document.getElementById('dlv_ord_no').style.borderColor = "#D41F3A";
				return false;
			}
			else if(pos_dt == '' )
			{
				alert('Posting Date is required.');
				document.getElementById('PSSDate').focus();
				document.getElementById('PSSDate').style.borderColor = "#D41F3A";
				return false;
			}
			
			var grQty = document.getElementsByName('gr_qty[]');
			//var grSloc = document.getElementsByName('sloc_gr[]');
			 
			for (m = 0; m < grQty.length; m++)
			{
				if (grQty[m].value == '')
				{
					alert('GR quantity is required.');
					grQty[m].focus();
					grQty[m].style.borderColor = "#D41F3A";			 
					return false;
				}
				else if (grQty[m].value != '' && (grQty[m].value <= 0))
				{
					alert('Invalid GR quantity. GR quantity must be greater than 1.');
					grQty[m].focus();
					grQty[m].style.borderColor = "#FF3300";			 
					return false;
				}
				/*else if (grSloc[m].value == '')
				{
					alert('SLoc quantity is required.');
					grSloc[m].focus();
					grSloc[m].style.borderColor = "#D41F3A";			 
					return false;
				}*/
			}
			
			
			
        }
        else
        {
         	return false;
        }	
    }
    </script>  </body>
</html>