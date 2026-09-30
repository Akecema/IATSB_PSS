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

   $url = "ups_dlv_dikanban.php"; 
	require_once('tcpdf_barcodes_2d.php');
	
	
// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "2")) {
header('Location: ../index.php');
exit();
}
//-----date----
$today = getdate();
$hours = $today['hours']; 
$minutes = $today['minutes'];
$seconds = $today['seconds'];
$month = $today['mon']; 
$mday = $today['mday']; 
$year = $today['year']; 


//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
     include 'apprv_func_list.php';
	
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

//CR status (Pending Approve)
$sta15 = "SELECT * from request_status WHERE status_id = '15'";
$sta_res15 = mysqli_query($dbc,$sta15);
$rst_sta15 = mysqli_fetch_array($sta_res15);

//CR status (Deleted)
$sta16 = "SELECT * from request_status WHERE status_id = '16'";
$sta_res16 = mysqli_query($dbc,$sta16);
$rst_sta16 = mysqli_fetch_array($sta_res16);

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

//CR status (Pending Approval Exec QC)
$sta29 = "SELECT * from request_status WHERE status_id = '29'";
$sta_res29 = mysqli_query($dbc,$sta29);
$rst_sta29 = mysqli_fetch_array($sta_res29);

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
      <script>
function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();

  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('txt').innerHTML =
  "TIME [ETA] :" + h + ":" + m + ":" + s;
  var t = setTimeout(startTime, 500);
}
function checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
}
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
 <style>
	.style7 {	
	font-size: 11px;
	font-weight: bold;
	color: #000000;
	/*font-family: Arial, Helvetica, sans-serif;*/
    }
	.style17 {	
	font-size: 11px;
	color: #000000;
	
    }
	.style18 {	
	font-size: 14px;
	color: #000000; 
	font-family: Arial, Helvetica, sans-serif;
	text-decoration: underline;
    }
	
	</style>
    
    <script type="text/javascript">
	function print_page() {
		var ButtonControl = document.getElementById("btnprint");
		ButtonControl.style.visibility = "hidden";
		window.print();
	}
</script> 
  </head>
  <body class="app sidebar-mini" onload="startTime()">
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
          <li class="breadcrumb-item">Delivery Instruction</li>
          <li class="breadcrumb-item"><a href="ups_dlv_dikanban.php">Upload DI/Kanban</a></li>
        </ul>
      </div> 
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
    
      <?php
	        $buid = base64_decode($_GET["upload_id"]);
			
		//	echo $buid;
 
  $extension = explode('.', $data_setup["logo_name"]);
  $filename = $data_setup["logo_comp"].'.'.$extension[1];
 
  use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;  
	
	
	 //-------------- click button "Approved"-----------------------------------------------------------------------------
  if(isset($_POST["apprv_btnDI"])) 
  
   { // handle the form.
   
    require 'PHPMailer/src/PHPMailer.php';
  	require 'PHPMailer/src/SMTP.php';
	require 'PHPMailer/src/Exception.php';

 
   $uid2 = $_POST["uid2"];
   
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
	
  
	
   //--------- Disposal QC detail ------------
	 
	   $query_info5A = "SELECT * FROM dlv_dikanban_upload WHERE upload_id = '".sql_esc($uid2)."'";
	   $result_info5A = mysqli_query($dbc,$query_info5A);

     $no_tg = "";
	  
	  while($data_info5A = mysqli_fetch_array($result_info5A))
	  {

      //-------shift day---------------//
      $shif_p = "";  

      //----get shift -----
 
     $time1 = substr($data_info5A["time_dlv"],0,2);
     $time2 = substr($data_info5A["time_dlv"],2,2);

      $time1A = sprintf('%02d',$time1);
      $time2A = sprintf('%02d',$time2);


      //----time---
      $nw_time = ($time1A.":".$time2A.":00");


//---shift detail ------

$query_sht = "SELECT * FROM shift_detail WHERE id_shift = '1'";
$result_sht = mysqli_query($dbc,$query_sht);
$data_sht = mysqli_fetch_array($result_sht);

//----shift posting ----

if (($nw_time >= $data_sht["time_start"]) && ($nw_time <= $data_sht["time_end"])) {

$shif_p = "D/S";
} else {

$shif_p = "N/S";
}


		  	    
		$query_generate = "INSERT INTO dlv_dikanban_generate(id,id_gen,DI_doc,back_no,vc_code,date_issue,po_no,date_dlv,time_dlv,material_no,material_desc,work_center,usage_kanban,std_package,std_ups_package,kanban_order,qty_dlv,qty_pending,tbox_kanban,model_cd,uom_dlv,shift_dlv,user_posting,date_posting,time_posting,create_by,date_create,update_by,date_update,status_kanban,plant_code,upload_id,file_name,mth_plan,yr_plan,status_DO,do_no,user_posting_do,date_posting_do,time_posting_do,ref_DI_doc,user_cancel,date_cancel,remark_cancel,SAP_ref_doc,SAP_ref_doc_can,remark) VALUES('','".sql_esc($data_info5A["id_gen"])."','".sql_esc($ref)."','".sql_esc($data_info5A["back_no"])."','".sql_esc($data_info5A["vc_code"])."','".sql_esc($data_info5A["date_issue"])."','".sql_esc($data_info5A["po_no"])."','".sql_esc($data_info5A["date_dlv"])."','".sql_esc($data_info5A["time_dlv"])."','".sql_esc($data_info5A["material_no"])."','".sql_esc($data_info5A["material_desc"])."','".sql_esc($data_info5A["work_center"])."','".sql_esc($data_info5A["usage_kanban"])."','".sql_esc($data_info5A["std_ups_package"])."','".sql_esc($data_info5A["std_ups_package"])."','".sql_esc($data_info5A["kanban_order"])."','','','".sql_esc($data_info5A["tbox_kanban"])."','".sql_esc($data_info5A["model_cd"])."','".sql_esc($data_info5A["uom_dlv"])."','".sql_esc($shif_p)."','".sql_esc($username)."',NOW(),NOW(),'".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'New','".sql_esc($data_info5A["plant_code"])."','".sql_esc($data_info5A["upload_id"])."','".sql_esc($data_info5A["file_name"])."','".sql_esc($data_info5A["mth_plan"])."','".sql_esc($data_info5A["yr_plan"])."','".sql_esc($rst_sta["status_desc"])."','','','','','','','','','','','".sql_esc($data_info5A["remark"])."')";
		$result_generate = mysqli_query($dbc,$query_generate);
		  
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
      } else {
  
  
  
  
  
  
  
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
  





// ---------update dlv_dikanban_upload--------------------------
	 
$query_LevelA = "UPDATE dlv_dikanban_upload SET status_kanban = '".sql_esc($rst_sta3["status_desc"])."' WHERE upload_id = '".sql_esc($uid2)."' ";
$result_LevelA = mysqli_query($dbc,$query_LevelA);







	 
	  } // end while loop
   
      //update count_max----------------------------------------

  
     $query_max_aA = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '143'";
	   $result_max_aA = mysqli_query($dbc,$query_max_aA);
	   
	
      //end update count_max ---------------------------------		
       
      $ref2 = base64_encode($ref);
       
       echo "<script>";
       echo "alert('Delivery Instruction No. $ref.');";
       echo "window.open('detail_print_DIupload-tag.php?buid=$ref2');";
       echo "window.location='ups_dlv_dikanban.php'";
       echo "</script>";
       exit(); //quit the script

	

   }// end submit
   
   
 ?>
  
     
      <?php
	 
	 $query_bb = "SELECT *, DATE_FORMAT(date_issue,'%d-%m-%Y') AS T4, DATE_FORMAT(date_dlv,'%d-%m-%Y') AS T3 from dlv_dikanban_upload WHERE upload_id = '".sql_esc($buid)."' ";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);
	 
	 
	 //-----get cvendor  ----
	 
	 $query_vend = new PreparedSql("SELECT * FROM vendor_detail WHERE vendor_code = ?", [$data_bb["vc_code"]]);
	 $result_vend = db_query($dbc, $query_vend);
	 $data_vend = mysqli_fetch_array($result_vend);
	 
	  //-----get model  ----
	 
	 $query_model = "SELECT * FROM model_detail_tbl WHERE model_code = '".sql_esc($data_bb["model_cd"])."'";
	 $result_model = mysqli_query($dbc,$query_model);
	 $data_model = mysqli_fetch_array($result_model);
	 
	 
	 
	 ?>
        
        <table width="98%" border="0" cellspacing="2" cellpadding="0" class="table-borderless">
  <tr>
    <td><img src="../set_upload/<?php echo $filename; ?>" width="350" height="40"/> </td>     
    <td>&nbsp;</td>
    <td valign="top">&nbsp;<!--<h5><font color="#999999"><b>TEST RUN [DRAFT]</b></font></h5>--></td>
  </tr>
  <tr>
    <td><div align="left"><b>Vendor :  </b> <?php echo html_esc($data_bb["vc_code"]);   ?> - <?php echo html_esc($data_vend["vendor_name"]);  ?></div></td>
    <td>&nbsp;</td>
    <td><div align="left"><b>PO No. :  </b><?php echo html_esc($data_bb["po_no"]);   ?></div></td>
  </tr>
  <tr>
    <td><div align="left"><b>Model : </b><?php echo html_esc($data_bb["model_cd"]);   ?> - <?php echo html_esc($data_model["model_desc"]); ?></div></td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Date Issue :  </b><?php echo html_esc($data_bb["T4"]);   ?></div></td>  
  
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Delivery Date :  </b><?php echo html_esc($data_bb["T3"]);   ?></div></td>  
  
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Time [ETA] :  </b><?php echo html_esc($data_bb["time_dlv"]);   ?></div></td>
  </tr>
        </table>
  <br>
 
  <?php
   
   $counterA = 1;
   $noA = 1;
   $sta_out = "";
   
$query_display = "SELECT * FROM dlv_dikanban_upload WHERE upload_id = '".sql_esc($buid)."' AND (status_kanban = '".sql_esc($rst_sta6["status_desc"])."') " .$where_sql." ORDER BY back_no ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   ?>
 <form name="frmSearch" id="frmSearch" method="post" action="" class="needs-validation"  novalidate>
 <table width="98%" class="table-bordered">
 <thead bgcolor="#eeeeee">
  <tr>
     <th>No</th>
     <th>Back No.</th>
     <th>Part No.</th>
     <th>Part Name</th>
     <th><div align="center">U/C</div></th>
     <th>Standard Packaging</th>
     <th>Kanban Order</th>
     <th><div align="center">Total Box</div></th>
  </tr>
  </thead>
  <tbody>
  <?php
    
   while($row2 = mysqli_fetch_array($result_display))
   {

   if($row2["std_ups_package"] == "")
   {
	   
	$var_pack = $row2["std_package"];    
	   
   }elseif($row2["std_ups_package"] != "")
   {
	   
	$var_pack = $row2["std_ups_package"];     
	   
   }else{
	   
	  $var_pack = ""; 
   }


  
  
  ?>
   <tr>
    <td width="60"><div align="center"><?php echo $noA; ?></div></td>
    <td width="150"><div align="center"><?php echo html_esc($row2["back_no"]); ?></div></td>
    <td width="200"><?php echo html_esc($row2["material_no"]); ?></td>
    <td width="300"><?php echo html_esc($row2["material_desc"]); ?></td>
    <td width="100"><div align="center"><?php echo html_esc($row2["usage_kanban"]); ?></div></td>
    <td width="100"><div align="center"><?php echo $var_pack; ?></div></td>
    <td width="100"><div align="center"><?php echo intval($row2["kanban_order"]); ?></div></td>
    <td width="100"><div align="center"><?php echo html_esc($row2["tbox_kanban"]); ?></div></td>
    </tr>
  
 <?php 
		  
		  $noA++;
		  $counterA++; // menambah counter
		  } 
		  
		  ?>
  </tbody>
</table>

       
       
                <!--  </div></div> -->
                 <!-- </div> -->
                  
    <!--  <div class="modal-footer">-->
     <br>
     <div align="left">
      
       <input name="uid2" type="hidden" value="<?php echo $buid; ?>">    
     
       
       
        <input name="apprv_btnDI" type="submit"  class="btn btn-success btn-sm" value="SUBMIT" onclick="return confirm('Are you sure to submit?');"/>
     
      <input action="action" onclick="window.history.go(-1); return false;" class="btn btn-info btn-sm" type="submit" value="BACK" />
      
     </div> 
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
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
    
  </body>
</html>