<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';


$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));
$fmt_curr_time = (date("H:i:s"));
$pick_curr_time = (date("H:i a"));
$yearSkrg = (date("Y"));

$drun = substr($fmt_curr_date,0,2);
$mrun = substr($fmt_curr_date,3,2);
$yrun = substr($fmt_curr_date,8,2);

$date_run = ($drun.$mrun.$yrun);

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "3")) {
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
	
	
	
$url = "create_dlv_bypdio_serendah.php"; 

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

//CR status (Reject)
$sta9 = "SELECT * from request_status WHERE status_id = '9'";
$sta_res9 = mysqli_query($dbc,$sta9);
$rst_sta9 = mysqli_fetch_array($sta_res9);

//CR status (Pending Approval PPC)
$sta10 = "SELECT * from request_status WHERE status_id = '10'";
$sta_res10 = mysqli_query($dbc,$sta10);
$rst_sta10 = mysqli_fetch_array($sta_res10);

//CR status (QC OK)
$sta11 = "SELECT * from request_status WHERE status_id = '11'";
$sta_res11 = mysqli_query($dbc,$sta11);
$rst_sta11 = mysqli_fetch_array($sta_res11);

//CR status (Resolved)
$sta12 = "SELECT * from request_status WHERE status_id = '12'";
$sta_res12 = mysqli_query($dbc,$sta12);
$rst_sta12 = mysqli_fetch_array($sta_res12);

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

//CR status (Approved QC)
$sta17 = "SELECT * from request_status WHERE status_id = '17'";
$sta_res17 = mysqli_query($dbc,$sta17);
$rst_sta17 = mysqli_fetch_array($sta_res17);

//CR status (Transfer QC)
$sta18 = "SELECT * from request_status WHERE status_id = '18'";
$sta_res18 = mysqli_query($dbc,$sta18);
$rst_sta18 = mysqli_fetch_array($sta_res18);

//CR status (Transfer Posting)
$sta19 = "SELECT * from request_status WHERE status_id = '19'";
$sta_res19 = mysqli_query($dbc,$sta19);
$rst_sta19 = mysqli_fetch_array($sta_res19);

//CR status (Return Posting)
$sta20 = "SELECT * from request_status WHERE status_id = '20'";
$sta_res20 = mysqli_query($dbc,$sta20);
$rst_sta20 = mysqli_fetch_array($sta_res20);

//CR status (Cancel)
$sta21 = "SELECT * from request_status WHERE status_id = '21'";
$sta_res21 = mysqli_query($dbc,$sta21);
$rst_sta21 = mysqli_fetch_array($sta_res21);

//CR status (Close)
$sta22 = "SELECT * from request_status WHERE status_id = '22'";
$sta_res22 = mysqli_query($dbc,$sta22);
$rst_sta22 = mysqli_fetch_array($sta_res22);

//CR status (Transfer GRA)
$sta23 = "SELECT * from request_status WHERE status_id = '23'";
$sta_res23 = mysqli_query($dbc,$sta23);
$rst_sta23 = mysqli_fetch_array($sta_res23);


//CR status (Pending Approval QC)
$sta24 = "SELECT * from request_status WHERE status_id = '24'";
$sta_res24 = mysqli_query($dbc,$sta24);
$rst_sta24 = mysqli_fetch_array($sta_res24);

//CR status (Pending Approval COO)
$sta25 = "SELECT * from request_status WHERE status_id = '25'";
$sta_res25 = mysqli_query($dbc,$sta25);
$rst_sta25 = mysqli_fetch_array($sta_res25);

//CR status (Return GRA)
$sta26 = "SELECT * from request_status WHERE status_id = '26'";
$sta_res26 = mysqli_query($dbc,$sta26);
$rst_sta26 = mysqli_fetch_array($sta_res26);

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);

//CR status (Transfer Material)
$sta28 = "SELECT * from request_status WHERE status_id = '28'";
$sta_res28 = mysqli_query($dbc,$sta28);
$rst_sta28 = mysqli_fetch_array($sta_res28);

//CR status (Pending Approval Exec QC)
$sta29 = "SELECT * from request_status WHERE status_id = '29'";
$sta_res29 = mysqli_query($dbc,$sta29);
$rst_sta29 = mysqli_fetch_array($sta_res29);


//CR status (Return)
$sta30 = "SELECT * from request_status WHERE status_id = '30'";
$sta_res30 = mysqli_query($dbc,$sta30);
$rst_sta30 = mysqli_fetch_array($sta_res30);

//CR status (Return Delivery)
$sta31 = "SELECT * from request_status WHERE status_id = '31'";
$sta_res31 = mysqli_query($dbc,$sta31);
$rst_sta31 = mysqli_fetch_array($sta_res31);

//CR status (Pending Approve STM)
$sta32 = "SELECT * from request_status WHERE status_id = '32'";
$sta_res32 = mysqli_query($dbc,$sta32);
$rst_sta32 = mysqli_fetch_array($sta_res32);

//CR status (Cancelled BF)
$sta33 = "SELECT * from request_status WHERE status_id = '33'";
$sta_res33 = mysqli_query($dbc,$sta33);
$rst_sta33 = mysqli_fetch_array($sta_res33);

//CR status (Pending Approve ASSY)
$sta34 = "SELECT * from request_status WHERE status_id = '34'";
$sta_res34 = mysqli_query($dbc,$sta34);
$rst_sta34 = mysqli_fetch_array($sta_res34);

//CR status (Received)
$sta35 = "SELECT * from request_status WHERE status_id = '35'";
$sta_res35 = mysqli_query($dbc,$sta35);
$rst_sta35 = mysqli_fetch_array($sta_res35);

//CR status (Pending Approval HOP)
$sta36 = "SELECT * from request_status WHERE status_id = '36'";
$sta_res36 = mysqli_query($dbc,$sta36);
$rst_sta36 = mysqli_fetch_array($sta_res36);


//CR status (Transfer MRIN)
$sta37 = "SELECT * from request_status WHERE status_id = '37'";
$sta_res37 = mysqli_query($dbc,$sta37);
$rst_sta37 = mysqli_fetch_array($sta_res37);


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
          <h1><i class="fa fa-th-list"></i> Delivery</h1>
          <p>Create Delivery Order - Perodua</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"> Delivery</li>
          <li class="breadcrumb-item"><a href="create_dlv_bypdio_serendah.php">Create New</a></li>
        </ul>
      </div> 
      
              <ul class="nav nav-tabs">
                 <li class="nav-item"><a class="nav-link active" data-toggle="tab"  href="create_dlv_bypdio_serendah.php">Create New </a></li>
                             
              </ul>
                         
       <?php

	   $message_pdio = "";
     $message_pdio2 = "";	
     $message_pdio3 = "";	  

     $query_id = "SELECT * FROM run_count_itsb WHERE uid = '156'";
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
	   }else
	   {
		  $lastID = ($row_id["count_max"] + 1);
		  $dg =  $lastID;
		
		}
		
		$number3A = ($dg); // Length of running no
		$number = sprintf('%07d', $number3A);  
		
		
		} // end if $result_id	

	  
     
     if((isset($_POST["submit3"]))  && $_POST!=="") 
     { // handle the form.
   
         function escape_data($data) {
       global $dbc;   // need the connection.
       if (ini_get('magic_quotes_gpc')) {
         $data = stripslashes($data);
         }
         return mysqli_real_escape_string($data,$dbc);
         }   // end function.
       $message = NULL; // create an empty new variable.		
     
       
      $pps_ref = $_POST["pps_ref"];
      $so_no = $_POST["so_no"];
   
     
       if(($_POST["pps_ref"]) == "")
        {
        $pps_ref = FALSE;
        $message_pdio = '<span class="badge badge-pill badge-danger"> Please scan PDIO!</span>';

      }else{
          
       
   
       $query_po_list = "SELECT * FROM dlv_pdio_generate WHERE pdio_no = '".sql_esc($pps_ref)."'";
       $result_po_list = mysqli_query($dbc,$query_po_list);
       $row_list = mysqli_fetch_array($result_po_list);
      
         
          if($row_list < 0 )
          {
            
          $message_pdio2 = '<span class="badge badge-pill badge-danger"> PDIO Number not exist!</span>';	 
          $pps_ref = FALSE;
            
          }else{
   
              $pps_ref = TRUE;
   
          } 
        
       }
    
         
         
         
     if($pps_ref) //everything ok
      { 
   
    
     $pps_ref = $_POST['pps_ref'];
     $so_no = $_POST["so_no"];
   
   //checking delete space semasa scanning
   //split dulu pps ref kpd prod_order, material,uom, plant, sloc, qty
   $pps_ref2 = trim($pps_ref);
   
   $str = $pps_ref2;
   
   if($str)
   {

   list($partA1, $partA2, $partA3, $partA4, $partA5) = (explode('|', $str, 5)); 
      
  // list($partA1) = (explode('|', $str, 1));
   }
   
  } //end if $str 


      
             $query_po_list = "SELECT * FROM dlv_pdio_generate WHERE pdio_no = '".sql_esc($partA1)."'";
             $result_po_list = mysqli_query($dbc,$query_po_list);
             $row_list = mysqli_fetch_array($result_po_list);
          
         
          if($row_list <= 0 )
          {
            
            $message_po3 = '<span class="badge badge-pill badge-danger"> PDIO Number not exist!</span>';	 
            $pps_ref = FALSE;
            
          } 
   
  
//--------- Checking delivery order whether it has been fully received or not.-----------	 
$tot_gr_qtyB = 0.000;
$tot_rec_qtyA = 0.000;
$tot_grd_qtyA  = 0.000;	


$query_check_Trcv = "SELECT * FROM dlv_ord_all_delivery WHERE pdio_no = '".sql_esc($partA1)."' AND status_DO = '".sql_esc($rst_sta3["status_desc"])."'";
$result_check_Trcv = mysqli_query($dbc,$query_check_Trcv);
  
while($data_check_Trcv = mysqli_fetch_array($result_check_Trcv))
{


$tot_grd_qtyA = $tot_grd_qtyA + $data_check_Trcv["qty_dlv"];

}

//dlv_ord_dikanban_generate
	//--------------Update 7 April 2022-------		 
  $query_check_Prcv = "SELECT * FROM dlv_pdio_generate WHERE pdio_no = '".sql_esc($partA1)."' AND status_pdio = '".sql_esc($rst_sta3["status_desc"])."'";
	$result_check_Prcv = mysqli_query($dbc,$query_check_Prcv);
    
	while($data_check_Prcv = mysqli_fetch_array($result_check_Prcv))
	{
		
		
		$tot_gr_qtyB = $tot_gr_qtyB + $data_check_Prcv["pdio_qty"];
	    
		
	}


//-------k azie kena check semula   edit 13 june ------
if($tot_gr_qtyB != 0.000)
{
 if($tot_grd_qtyA == ($tot_gr_qtyB))
  {
  
      echo "<script>";
      echo "alert('Delivery Order has been fully delivered.');";
      echo "window.location='create_dlv_bypdio_serendah.php'";
      echo "</script>";
      exit(); //quit the script
   
  
    
  }elseif(($tot_grd_qtyA) > $tot_gr_qtyB)
  {
    
     
      echo "<script>";
      echo "alert('Delivery Order has been fully delivered.');";
      echo "window.location='create_dlv_bypdio_serendah.php'";
      echo "</script>";
      exit(); //quit the script  
    
    
  }else{}
 
}
   
   
    mysqli_begin_transaction($dbc);

    try {
      //---get dlv_ord_dikanban_generate //
      $queryGR = "SELECT * FROM dlv_pdio_generate WHERE pdio_no = '".sql_esc($partA1)."' AND status_DO != '".sql_esc($rst_sta14["status_desc"])."' AND plant_code = '3100' ORDER BY id ASC";
      $resultGR = mysqli_query($dbc,$queryGR);
      
      while($rowGR = mysqli_fetch_array($resultGR)) 
      {
        $curr_month = date('m', strtotime($rowGR['dlv_date']));
  
                
        $query_q2 = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($rowGR["material_no"])."' AND plant_code = '3100'";
        $result_q2 = db_query($dbc, $query_q2);
        $ans3 = mysqli_fetch_array($result_q2);
       
        //---------detail material_type_tbl (material_type) ----
        
        $query_mtype2 = new PreparedSql("SELECT * FROM material_type_tbl WHERE id = ?", [$ans3["mat_type"]]);
        $result_mtype2 = db_query($dbc, $query_mtype2) or die (mysqli_error($dbc));
        $d_mtype2 = mysqli_fetch_array($result_mtype2);
        
     
        //---------detail model_detail_tbl(model_code) ---
        
        $query_mcode2 = new PreparedSql("SELECT * FROM model_detail_tbl WHERE id_model = ?", [$ans3["model_code"]]);
        $result_mcode2 = db_query($dbc, $query_mcode2) or die (mysqli_error($dbc));
        $d_mcode2 = mysqli_fetch_array($result_mcode2);
     
     
        //------checking Different Do scanned ----------
        $query_check_scan = "SELECT * FROM upload_perodua_temp WHERE scan_gen = '".sql_esc($number)."' AND pdio_no != '".sql_esc($partA1)."' AND user_post = '".sql_esc($username)."'";
        $result_check_scan = mysqli_query($dbc,$query_check_scan);
        $data_check_scan = mysqli_fetch_array($result_check_scan);
     
        if($data_check_scan <= 0 )
        {
          
            
        }else{
      
          echo "<script>";
          echo "alert('Error! Different Delivery Order Number. ');";
          echo "window.location='create_dlv_bypdio_serendah.php'";
          echo "</script>";
          exit(); //quit the script
      
        } 
        $prod_date_d = date('d', strtotime($rowGR['prod_date'])); // Get the day of prod_date
        $prod_date_m = date('m', strtotime($rowGR['prod_date'])); // Get the day of prod_date
        $prod_date_y = date('Y', strtotime($rowGR['prod_date'])); // Get the day of prod_date
		    $prodDate_final = ($prod_date_y.'-'.$prod_date_m);
        // Check cycle for prod_date
        $cycle = ($prod_date_d >= 1 && $prod_date_d <= 15) ? '1' : '2';
        
        $query_so = "
          SELECT * FROM so_detail_dlv 
          WHERE DATE_FORMAT(doc_date, '%Y-%m') = '".sql_esc($prodDate_final)."' AND
          cust_mat_no = '".sql_esc($rowGR['material_no_cust'])."'  AND status_so = 'New'
          AND (
              (".$cycle." = 1 AND DAY(doc_date) BETWEEN 1 AND 15) OR 
              (".$cycle." = 2 AND DAY(doc_date) BETWEEN 16 AND 31)
          )
        ";
        $result_so_detail = mysqli_query($dbc, $query_so);
        if (mysqli_num_rows($result_so_detail) > 0) {
          $so_upload = mysqli_fetch_array($result_so_detail);

          $query_p2temp = "INSERT INTO upload_perodua_temp(id,upload_id,scan_gen,material_doc_gen,pdio_no,order_no,vendor_name,shop_pt,lshop,ldock,dlv_cat,trip_no,lane_no,prod_date,dlv_date,cycle_no,back_no,material_no,material_desc,total_order_pcs,total_order_box,total_rcv_pcs,total_rcv_box,user_upload,date_upload,status_upload,user_update,date_update,so_no,ship_point,cust_code,id_soi,doc_gen,sold_desc,ship_no,ship_desc,item_no,material_no_soi,material_desc_soi,cust_mat_no,plant_code,qty_order,qty_bal,qty_rec,qty_dlv,unit_soi,matl_group,sales_org,posting_date,posting_time,user_post,date_post,time_post,ref_material_doc,user_cancel,date_cancel,remark_cancel,status_DO) VALUES ('','".sql_esc($rowGR['upload_id'])."','".sql_esc($number)."','','".sql_esc($rowGR['pdio_no'])."','".sql_esc($rowGR['order_no'])."','".sql_esc($rowGR['cust_name'])."','".sql_esc($rowGR['plant_code'])."','','','".sql_esc($rowGR['dlv_category'])."','".sql_esc($rowGR['trip_no'])."','".sql_esc($rowGR['line_no'])."','".sql_esc($rowGR['prod_date'])."','".sql_esc($rowGR['dlv_date'])."','".sql_esc($rowGR['cycle_pdio'])."','".sql_esc($rowGR['back_no'])."','".sql_esc($rowGR['material_no'])."','".sql_esc($rowGR['material_desc'])."','".sql_esc($rowGR['pdio_qty'])."','','','','".sql_esc($username)."',NOW(),'".sql_esc($rst_sta["status_desc"])."','".sql_esc($username)."',NOW(),'','".sql_esc($rowGR['plant_code'])."','".sql_esc($rowGR['cust_code'])."','".sql_esc($rowGR['id'])."','".sql_esc($rowGR['mat_doc'])."','".sql_esc($rowGR['cust_name'])."','".sql_esc($rowGR['cust_code'])."','".sql_esc($rowGR['cust_name'])."','','".sql_esc($rowGR['material_no'])."','".sql_esc($rowGR['material_desc'])."','".sql_esc($ans3['material_cust_no'])."','".sql_esc($rowGR['plant_code'])."','".sql_esc($rowGR['pdio_qty'])."','','','','".sql_esc($rowGR['uom_pdio'])."','".sql_esc($ans3['material_group'])."','3100',NOW(),NOW(),'','','','','','','','".sql_esc($rst_sta["status_desc"])."')";
          $result_p2temp = mysqli_query($dbc,$query_p2temp);
    
          $temp_id = mysqli_insert_id($dbc);  //insert ID
    
          //-----------information insert data--------
          $query_infoup = "SELECT * FROM upload_perodua_temp WHERE id = '".sql_esc($temp_id)."'";
          $result_infoup = mysqli_query($dbc,$query_infoup);
          $row_infoup = mysqli_fetch_array($result_infoup);
    
          $query_upd_ID = "UPDATE upload_perodua_temp SET so_no = '".sql_esc($so_upload['so_no'])."', item_no = '".sql_esc($so_upload['item_no'])."' WHERE id = '".sql_esc($row_infoup['id'])."'";
          $result_upd_ID = mysqli_query($dbc,$query_upd_ID);
    
          $query_p3temp = "INSERT INTO upload_perodua_serendah_temp(id,upload_id,scan_gen,material_doc_gen,pdio_no,
          order_no,vendor_name,shop_pt,lshop,ldock,dlv_cat,trip_no,lane_no,prod_date,dlv_date,cycle_no,back_no,
          material_no,material_desc,total_order_pcs,total_order_box,total_rcv_pcs,total_rcv_box,user_upload,
          date_upload,status_upload,user_update,date_update,so_no,ship_point,cust_code,id_soi,doc_gen,
          sold_desc,ship_no,ship_desc,item_no,material_no_soi,material_desc_soi,cust_mat_no,plant_code,
          qty_order,qty_bal,qty_rec,qty_dlv,unit_soi,matl_group,sales_org,posting_date,posting_time,user_post,
          date_post,time_post,ref_material_doc,user_cancel,date_cancel,remark_cancel,status_DO) 
          VALUES ('','','".sql_esc($number)."','','".sql_esc($rowGR['pdio_no'])."','".sql_esc($rowGR['order_no'])."','".sql_esc($so_upload['ship_desc'])."',
          '".sql_esc($so_upload['ship_point'])."','','','','','','".sql_esc($so_upload['posting_date'])."',
          '".sql_esc($so_upload['posting_date'])."','','','".sql_esc($so_upload['material_no'])."',
          '".sql_esc($so_upload['material_desc'])."','".sql_esc($so_upload["qty_upload"])."','','','',
          '".sql_esc($username)."',NOW(),'".sql_esc($rst_sta["status_desc"])."','".sql_esc($username)."',NOW(),
          '".sql_esc($so_upload['so_no'])."','".sql_esc($so_upload['plant_code'])."','".sql_esc($so_upload['sold_no'])."',
          '".sql_esc($so_upload['id'])."','".sql_esc($so_upload['doc_gen'])."','".sql_esc($so_upload["sold_desc"])."',
          '".sql_esc($so_upload["ship_no"])."','".sql_esc($so_upload["ship_desc"])."','','".sql_esc($so_upload['material_no'])."',
          '".sql_esc($so_upload['material_desc'])."','".sql_esc($so_upload['cust_mat_no'])."','".sql_esc($so_upload['plant_code'])."',
          '".sql_esc($rowGR['pdio_qty'])."','','','','".sql_esc($so_upload["unit_upload"])."','".sql_esc($so_upload["matl_group"])."',
          '".sql_esc($so_upload["sales_org"])."',NOW(),NOW(),'','','','','','','','".sql_esc($rst_sta["status_desc"])."')";
          $result_p3temp = mysqli_query($dbc,$query_p3temp);
        } else {
          throw new Exception("Customer Material Number Not Listed in Sales Order.");
        }
     
      } // while loop
      // If all is good, commit transaction
      mysqli_commit($dbc);
    } catch (Exception $e) {
      // Rollback everything if error happens
      mysqli_rollback($dbc);
  
      // Optionally show error
      echo "<script>";
      echo "alert('".$e->getMessage()."');";
      echo "window.location='create_dlv_bypdio_serendah.php';";
      echo "</script>";
      exit();
    }

    $query_max_aA = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '156'";
    $result_max_aA = mysqli_query($dbc,$query_max_aA);
      
    
    echo "<script>";
    echo "window.location='create_dlv_bypdio_serendahProc2.php?scan_doc=$number&&so_no=$so_no&&pdio_no=$partA1'";
    echo "</script>";
    exit(); //quit the script
        
        
        
       
     
         
  } // end submit
      
	
// Set the page title and include the HTML header.
//include ('templates/header.inc');

if(isset($_POST['submitCTA'])) 
{ // handle the form.

  require_once('../include/config.php');   //connect to the db.

      
  ini_set("display_errors",0);		 
  set_time_limit(0);

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
   

  $pps_ref = $_POST["pps_ref"];
  $so_no = $_POST["so_no"];
 
 	
  //check so no
 	if(($_POST["so_no"]) == "")
  {
    $so_no = FALSE;
    $message_so = '<span class="badge badge-pill badge-danger"> Please enter Sales Order Number!</span>';
  }else{
    $so_no = TRUE;
  }	
	

  // check for cust code

  if(($_POST["pps_ref"]) == "")
  {
    $pps_ref = FALSE;
    $message_pdio2 = '<span class="badge badge-pill badge-danger"> Please Scan PDIO Code!</span>';
  }else{
    $pps_ref = TRUE;
  }

  if($pps_ref) //everything ok
  {  	
   
    $pps_ref = $_POST["pps_ref"];
    $so_no = $_POST["so_no"];

    $pps_ref2 = trim($pps_ref);
    
    $str = $pps_ref2;
  
    if($str)
    {
      
      list($partA1) = (explode('|', $str, 1));
    }

    //---get dlv_ord_dikanban_generate //
    mysqli_begin_transaction($dbc);

    try {
      $queryGR2 = "SELECT * FROM dlv_pdio_generate WHERE pdio_no = '".sql_esc($partA1)."' AND status_DO != '".sql_esc($rst_sta14["status_desc"])."' ORDER BY id ASC";
      $resultGR2 = mysqli_query($dbc,$queryGR2);
      // var_dump($rst_sta14["status_desc"]);
      // die();
      while($rowGR2 = mysqli_fetch_array($resultGR2)) 
      {

        $curr_month = date('m', strtotime($rowGR2['dlv_date']));
              
        $query_q2 = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ?", [$rowGR2["material_no"]]);
        $result_q2 = db_query($dbc, $query_q2);
        $ans3 = mysqli_fetch_array($result_q2);
      
        //---------detail material_type_tbl (material_type) ----
      
        $query_mtype2 = new PreparedSql("SELECT * FROM material_type_tbl WHERE id = ?", [$ans3["mat_type"]]);
        $result_mtype2 = db_query($dbc, $query_mtype2) or die (mysqli_error($dbc));
        $d_mtype2 = mysqli_fetch_array($result_mtype2);
      

        //---------detail model_detail_tbl(model_code) ---
        
        $query_mcode2 = new PreparedSql("SELECT * FROM model_detail_tbl WHERE id_model = ?", [$ans3["model_code"]]);
        $result_mcode2 = db_query($dbc, $query_mcode2) or die (mysqli_error($dbc));
        $d_mcode2 = mysqli_fetch_array($result_mcode2);


        //------checking Different Do scanned ----------
        $query_check_scan = "SELECT * FROM upload_perodua_temp WHERE scan_doc = '".sql_esc($number)."' AND pdio_no != '".sql_esc($partA1)."' AND so_no != '".sql_esc($so_no)."' AND user_post = '".sql_esc($username)."'";
        $result_check_scan = mysqli_query($dbc,$query_check_scan);
        $data_check_scan = mysqli_fetch_array($result_check_scan);

        if($data_check_scan <= 0 )
        {
          
            
        }else{

          
          echo "<script>";
          echo "alert('Error! Different Delivery Order Number. ');";
          echo "window.location='create_dlv_bypdio_serendah.php'";
          echo "</script>";
          exit(); //quit the script

        } 
      
        //--------- Checking delivery order whether it has been fully received or not.-----------	 
        $tot_gr_qtyB = 0.000;
        $tot_rec_qtyA = 0.000;
        $tot_grd_qtyA  = 0.000;	


        $query_check_Trcv = "SELECT * FROM dlv_ord_all_delivery WHERE pdio_no = '".sql_esc($partA1)."' AND status_DO = '".sql_esc($rst_sta3["status_desc"])."'";
        $result_check_Trcv = mysqli_query($dbc,$query_check_Trcv);
          
        while($data_check_Trcv = mysqli_fetch_array($result_check_Trcv))
        {


          $tot_grd_qtyA = $tot_grd_qtyA + $data_check_Trcv["qty_dlv"];

        }

        //dlv_ord_dikanban_generate
        //--------------Update 7 April 2022-------		 
        $query_check_Prcv = "SELECT * FROM dlv_pdio_generate WHERE pdio_no = '".sql_esc($partA1)."' AND status_pdio = '".sql_esc($rst_sta3["status_desc"])."'";
        $result_check_Prcv = mysqli_query($dbc,$query_check_Prcv);
          
        while($data_check_Prcv = mysqli_fetch_array($result_check_Prcv))
        {
          
          
          $tot_gr_qtyB = $tot_gr_qtyB + $data_check_Prcv["pdio_qty"];
            
          
        }

        //-------k azie kena check semula   edit 13 june ------
        if($tot_gr_qtyB != 0.000)
        {
          if($tot_grd_qtyA == ($tot_gr_qtyB))
          {
      
            echo "<script>";
            echo "alert('Delivery Order has been fully delivered.');";
            echo "window.location='create_dlv_bypdio_serendah.php'";
            echo "</script>";
            exit(); //quit the script
          }
          elseif(($tot_grd_qtyA) > $tot_gr_qtyB)
          {
        
    
            echo "<script>";
            echo "alert('Delivery Order has been fully delivered.');";
            echo "window.location='create_dlv_bypdio_serendah.php'";
            echo "</script>";
            exit(); //quit the script  
          }else{}
    
        }

        $prod_date_d = date('d', strtotime($rowGR2['prod_date'])); // Get the day of prod_date
        $prod_date_m = date('m', strtotime($rowGR2['prod_date'])); // Get the day of prod_date
        $prod_date_y = date('Y', strtotime($rowGR2['prod_date'])); // Get the day of prod_date
        $prodDate_final = ($prod_date_y.'-'.$prod_date_m);
        // Check cycle for prod_date
        $cycle = ($prod_date_d >= 1 && $prod_date_d <= 15) ? '1' : '2';
        
        $query_so = "
          SELECT * FROM so_detail_dlv 
          WHERE DATE_FORMAT(doc_date, '%Y-%m') = '".sql_esc($prodDate_final)."' AND
          cust_mat_no = '".sql_esc($rowGR2['material_no_cust'])."'  AND status_so = 'New'
          AND (
              (".$cycle." = 1 AND DAY(doc_date) BETWEEN 1 AND 15) OR 
              (".$cycle." = 2 AND DAY(doc_date) BETWEEN 16 AND 31)
          )
        ";
        // var_dump($query_so);
        // die();
        $result_so_detail = mysqli_query($dbc, $query_so);
        if (mysqli_num_rows($result_so_detail) > 0) {
          $so_upload = mysqli_fetch_array($result_so_detail);
          //insert to scan_detail table upload_perodua_temp --//
          $query_p2temp2 = "INSERT INTO upload_perodua_temp(id,upload_id,scan_gen,material_doc_gen,pdio_no,order_no,
          vendor_name,shop_pt,lshop,ldock,dlv_cat,trip_no,lane_no,prod_date,dlv_date,cycle_no,back_no,material_no,
          material_desc,total_order_pcs,total_order_box,total_rcv_pcs,total_rcv_box,user_upload,date_upload,
          status_upload,user_update,date_update,so_no,ship_point,cust_code,id_soi,doc_gen,sold_desc,ship_no,
          ship_desc,item_no,material_no_soi,material_desc_soi,cust_mat_no,plant_code,qty_order,qty_bal,qty_rec,
          qty_dlv,unit_soi,matl_group,sales_org,posting_date,posting_time,user_post,date_post,time_post,
          ref_material_doc,user_cancel,date_cancel,remark_cancel,status_DO) 
          VALUES ('','".sql_esc($rowGR2['upload_id'])."','".sql_esc($number)."','','".sql_esc($rowGR2['pdio_no'])."','".sql_esc($rowGR2['order_no'])."',
          '".sql_esc($rowGR['cust_name'])."','".sql_esc($rowGR2['plant_code'])."','','','".sql_esc($rowGR2['dlv_category'])."',
          '".sql_esc($rowGR2['trip_no'])."','".sql_esc($rowGR2['line_no'])."','".sql_esc($rowGR2['prod_date'])."','".sql_esc($rowGR2['dlv_date'])."',
          '".sql_esc($rowGR2['cycle_pdio'])."','".sql_esc($rowGR2['back_no'])."','".sql_esc($rowGR2['material_no'])."',
          '".sql_esc($rowGR2['material_desc'])."','".sql_esc($rowGR2['pdio_qty'])."','','','','".sql_esc($username)."',
          NOW(),'".sql_esc($rst_sta["status_desc"])."','".sql_esc($username)."',NOW(),'".sql_esc($rowGR2['order_no'])."',
          '".sql_esc($rowGR2['plant_code'])."','".sql_esc($rowGR2['cust_code'])."','".sql_esc($rowGR2['id'])."','".sql_esc($rowGR2['mat_doc'])."',
          '".sql_esc($rowGR2['cust_name'])."','".sql_esc($rowGR2['cust_code'])."','".sql_esc($rowGR2['cust_name'])."','',
          '".sql_esc($rowGR2['material_no'])."','".sql_esc($rowGR2['material_desc'])."','".sql_esc($rowGR2['material_no_cust'])."',
          '".sql_esc($rowGR2['plant_code'])."','".sql_esc($rowGR2['pdio_qty'])."','','','','".sql_esc($rowGR2['uom_pdio'])."','',
          '3100',NOW(),NOW(),'','','','','','','','".sql_esc($rst_sta["status_desc"])."')";
          $result_p2temp2 = mysqli_query($dbc,$query_p2temp2);

          $temp_id = mysqli_insert_id($dbc);  //insert ID

          //-----------information insert data--------
          $query_infoup = "SELECT * FROM upload_perodua_temp WHERE id = '".sql_esc($temp_id)."'";
          $result_infoup = mysqli_query($dbc,$query_infoup);
          $row_infoup = mysqli_fetch_array($result_infoup);

          //if($so_no != ''){
          $query_upd_ID = "UPDATE upload_perodua_temp SET so_no = '".sql_esc($so_upload['so_no'])."', item_no = '".sql_esc($so_upload['item_no'])."' WHERE id = '".sql_esc($row_infoup['id'])."'";
          $result_upd_ID = mysqli_query($dbc,$query_upd_ID);
          
          $query_p3temp = "INSERT INTO upload_perodua_serendah_temp(id,upload_id,scan_gen,material_doc_gen,pdio_no,
          order_no,vendor_name,shop_pt,lshop,ldock,dlv_cat,trip_no,lane_no,prod_date,dlv_date,cycle_no,back_no,
          material_no,material_desc,total_order_pcs,total_order_box,total_rcv_pcs,total_rcv_box,user_upload,
          date_upload,status_upload,user_update,date_update,so_no,ship_point,cust_code,id_soi,doc_gen,sold_desc,
          ship_no,ship_desc,item_no,material_no_soi,material_desc_soi,cust_mat_no,plant_code,qty_order,qty_bal,
          qty_rec,qty_dlv,unit_soi,matl_group,sales_org,posting_date,posting_time,user_post,date_post,time_post,
          ref_material_doc,user_cancel,date_cancel,remark_cancel,status_DO) 
          VALUES ('','','".sql_esc($number)."','','".sql_esc($rowGR2['pdio_no'])."','".sql_esc($rowGR2['order_no'])."',
          '".sql_esc($so_upload['ship_desc'])."','".sql_esc($so_upload['ship_point'])."','','','','','',
          '".sql_esc($so_upload['posting_date'])."','".sql_esc($so_upload['posting_date'])."','','',
          '".sql_esc($so_upload['material_no'])."','".sql_esc($so_upload['material_desc'])."',
          '".sql_esc($so_upload["qty_upload"])."','','','','".sql_esc($username)."',NOW(),
          '".sql_esc($rst_sta["status_desc"])."','".sql_esc($username)."',NOW(),'".sql_esc($so_upload['so_no'])."',
          '".sql_esc($so_upload['plant_code'])."','".sql_esc($so_upload['sold_no'])."','".sql_esc($so_upload['id'])."',
          '".sql_esc($so_upload['doc_gen'])."','".sql_esc($so_upload["sold_desc"])."','".sql_esc($so_upload["ship_no"])."',
          '".sql_esc($so_upload["ship_desc"])."','','".sql_esc($so_upload['material_no'])."',
          '".sql_esc($so_upload['material_desc'])."','".sql_esc($so_upload['cust_mat_no'])."',
          '".sql_esc($so_upload['plant_code'])."','".sql_esc($rowGR2['pdio_qty'])."','','','',
          '".sql_esc($so_upload["unit_upload"])."','".sql_esc($so_upload["matl_group"])."',
          '".sql_esc($so_upload["sales_org"])."',NOW(),NOW(),'','','','','','','','".sql_esc($rst_sta["status_desc"])."')";
          $result_p3temp = mysqli_query($dbc,$query_p3temp);
        } else {
          throw new Exception("Customer Material Number Not Listed in Sales Order.");
        }
      } // while loop
      // If all is good, commit transaction
      mysqli_commit($dbc);
    } catch (Exception $e) {
      // Rollback everything if error happens
      mysqli_rollback($dbc);

      // Optionally show error
      echo "<script>";
      echo "alert('".$e->getMessage()."');";
      echo "window.location='create_dlv_bypdio_serendah.php';";
      echo "</script>";
      exit();
    }
    
    $query_max_aA = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '156'";
    $result_max_aA = mysqli_query($dbc,$query_max_aA);

    // create_dlv_bypdio_sgChohProc2.php
    echo "<script>";
    echo "window.location='create_dlv_bypdio_serendahProc2.php?scan_doc=$number&&so_no=$so_no&&pdio_no=$pps_ref'";
    echo "</script>";
    exit(); //quit the script    
			
  }
  mysqli_close($dbc);   // close database conn
} //----------------------end check upload /upload confirm -----------------------------------------------------------------	
 
	  		   
	
?>
      
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Create Delivery Order - Perodua</h3>
            <div class="tile-body">
         
         <form name="form1" action="create_dlv_bypdio_serendah.php" method="post" class="form-horizontal">
                   <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="2">&nbsp;</th>
            </tr>
            <tr>
                <th>Sales Order : </th>
                <th colspan="2">
           <input class="form-control" id="so_no" type="text" placeholder="Enter Sales Order No." name="so_no" value="<?php if(isset($_POST['so_no'])){ echo html_esc($_POST['so_no']); } ?>" />    

            <!-- <div id="result"></div>-->
               </th>
              </tr>
            <tr>
                <th>Scan PDIO : <font color="#FF0000">*</font>&nbsp;&nbsp;<i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="1. PDIO Number" data-html="true" data-placement="left"></i></th>
                <th colspan="2">
          <input name="pps_ref" type="text" id="pps_ref" maxlength="200" value="<?php if(isset($_POST['pps_ref'])) { echo html_esc($_POST['pps_ref']); } ?>" class="form-control" autofocus/>
            
          &nbsp;&nbsp;<small>Eg: PDIO No. </small>
          
            <div class="form-control-feedback" ><?php echo $message_pdio; ?></div><div class="form-control-feedback" ><?php echo $message_pdio2; ?></div><div class="form-control-feedback" ><?php echo $message_pdio3; ?></div>
            <input name="submit3" type="submit" id="submit3" value="+ Add Item" class="button"  />
               </th>
              </tr>  
             
            
           
              <tr>
                <th><input name="submitCTA" type="submit" class="btn btn-info" id="button" value="NEXT" /></th>
                <th colspan="2">&nbsp;</th>
              </tr>
            
                </table>
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
	  
      $('#demoSelect').select2();
    </script>

  
  
  </body>
</html>