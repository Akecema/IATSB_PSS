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

   $url = "display_mtndo-dikanban.php"; 
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
    $result2 = db_query($dbc, $query2) or die (mysqli_error());
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
	$('.datepicker').pickadate({
weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
showMonthsShort: true
})
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
          <p>Maintain DO</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Delivery Instruction</li>
          <li class="breadcrumb-item"><a href="display_mtndo-dikanban.php">Maintain DO</a></li>
        </ul>
      </div> 
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
    
      <?php
	        $buid2 = base64_decode($_GET["buid"]);
			$uid2 = base64_decode($_GET["dno"]);
		    $dateF = $_GET["date1"];
			$dateT = $_GET["date2"];
         	$vendor_code = $_GET["vendor_code"]; 
	
 
  $extension = explode('.', $data_setup["logo_name"]);
  $filename = $data_setup["logo_comp"].'.'.$extension[1];
 

	
	 //-------------- click button "UPDATE"-----------------------------------------------------------------------------
  if(isset($_POST["upd_btnDO"])) 
   { // handle the form.
 
   $buid2 = $_POST["buid2"];
   $uid2 = $_POST["uid2"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
   $vendor_code = $_POST["vendor_code"]; 
   $supp_do = $_POST["supp_do"];
   
   
        $amount = "";
		$amount3 = "";
		$string = "";
		$string3 = "";

		$trc_id = $_POST["e_tcid"]; 
		$st = count($trc_id);
		$qty_dlv = $_POST["qty_dlv"];
		$std_package = $_POST["std_packageA"];
		$supp_part_no = $_POST["supp_part_no"];
		
		
		
		//------delete print tag yg lama print_tag_do_dikanban ---

		  
		  $query_del_prt = "DELETE FROM print_tag_do_dikanban WHERE DI_doc = '".sql_esc($buid2)."' AND do_no = '".sql_esc($uid2)."'";
		  $result_del_prt  = mysqli_query($dbc,$query_del_prt) or die (mysqli_error());


	    foreach($_POST["e_tcid"] as $j=>$i) {
		   
	
	    $amount .= (($_POST["qty_dlv"][$i]).';');
	    $amount3 .=  (($_POST["std_packageA"][$i]).';');
		$amount4 .=  (($_POST["supp_part_no"][$i]).';');

				
		//-----checking barcode GR Tag
		
		$string = explode(";",($amount));	
		$string3 = explode(";",($amount3));	
		$string4 = explode(";",($amount4));	
	
	
        }
	
       for($i=0; $i < count($_POST["e_tcid"]); $i++)
	{		
	
	
	 // echo "Quantity   "; echo $string[$i]; echo "- ";  echo $trc_id[$i]; echo "<br>"; 
	//  echo $string3[$i]; echo "- ";  echo $trc_id[$i]; echo "<br>"; 
		
		$query_all = "SELECT * FROM dlv_ord_dikanban_generate WHERE id = '".sql_esc($trc_id[$i])."' AND DI_doc = '".sql_esc($buid2)."' AND do_no = '".sql_esc($uid2)."' ";
		$result_all = mysqli_query($dbc,$query_all);
		$data_all = mysqli_fetch_array($result_all);
	
		//-----calculate qty pending & update status DO complete or in progress or new -------
		 $query_qty_deli2 = "SELECT * FROM dlv_ord_dikanban_generate WHERE po_no = '".sql_esc($data_all["po_no"])."' AND DI_doc = '".sql_esc($buid2)."' AND material_no = '".sql_esc($data_all["material_no"])."' AND status_DO != '".sql_esc($rst_sta4["status_desc"])."'";
		 $result_qty_deli2 = mysqli_query($dbc,$query_qty_deli2);
		 $num_2 = mysqli_num_rows($result_qty_deli2);   //how many material are there? 
		  
	 
	   $tot_di_qty2 = 0.000;
	   $tot_kanb = 0.000;
	   
	   while($data_qty_deli2 = mysqli_fetch_array($result_qty_deli2)) 
	{   
		
		$tot_di_qty2 = $tot_di_qty2 + $data_qty_deli2["qty_dlv"];
	
							
	
	}
	
	$pend_qty2 = ($data_all["kanban_order"] - ($tot_di_qty2));
	$tot_kanb = $tot_kanb + $data_all["kanban_order"];
 
 
  //----completed -----
	  if(($pend_qty2 < 0.000) && ($pend_qty2 != 0.000))
	  {
		
		$status_baru_DO = $rst_sta14["status_desc"];
		  
	  }elseif($tot_di_qty2 == 0.000)
	  {
		  
		 $status_baru_DO = $rst_sta["status_desc"]; 
		 
	  }elseif($tot_di_qty2 == $tot_kanb)
	  {
		  
		 $status_baru_DO = $rst_sta14["status_desc"];
		 
	  }elseif($tot_di_qty2 > $tot_kanb)
	  {
		  
		 $status_baru_DO = $rst_sta14["status_desc"];
		  
	  }elseif(($tot_di_qty2 < $tot_kanb) && ($tot_di_qty2 != 0.000))
	  {
		  	
		 $status_baru_DO = $rst_sta7["status_desc"]; 
		 
	  }else{
		  
	  }
	
	//------------------------------------------------------------------------------------
	
	
	
	
		 //---update Qty & Std Package dlv_ord_dikanban_generate ----
	    
		$query_update_scan2 = "UPDATE dlv_ord_dikanban_generate SET std_package = '".sql_esc($string3[$i])."', qty_dlv = '".sql_esc($string[$i])."', status_DO = '".sql_esc($status_baru_DO)."', supp_part_no = '".sql_esc($string4[$i])."', supp_do = '".sql_esc($supp_do)."' WHERE id = '".sql_esc($trc_id[$i])."' AND DI_doc = '".sql_esc($buid2)."' AND do_no = '".sql_esc($uid2)."'";
	    $rst_update_scan2 = mysqli_query($dbc,$query_update_scan2); 
		
	    //----------Checking kalau dh closed nak open selepas editing status_DO = "Completed"
		
		$query_temp7 = "SELECT * FROM dlv_dikanban_generate WHERE DI_doc = '".sql_esc($buid2)."' AND status_kanban = '".sql_esc($rst_sta13["status_desc"])."'";
		$result_temp7 = mysqli_query($dbc,$query_temp7);
		 
		 while($data_temp7 = mysqli_fetch_array($result_temp7))
		{
	
		
		$query_LevelA7 = "UPDATE dlv_dikanban_generate SET status_kanban = '".sql_esc($rst_sta7["status_desc"])."', supp_do = '".sql_esc($supp_do)."' WHERE DI_doc = '".sql_esc($buid2)."' ";
		$result_LevelA7 = mysqli_query($dbc,$query_LevelA7);			

		
		}
		
		$query_LevelAA7 = "UPDATE dlv_dikanban_generate SET status_DO = '".sql_esc($status_baru_DO).", supp_do = '".sql_esc($supp_do)."' WHERE id = '".sql_esc($data_all["id_DI"])."' AND DI_doc = '".sql_esc($buid2)."' ";
		$result_LevelAA7 = mysqli_query($dbc,$query_LevelAA7);	
		
		
		
		
		
		/*$query_temp7 = "SELECT * FROM dlv_dikanban_generate WHERE DI_doc = '".sql_esc($buid2)."' AND status_DO != '".$rst_sta14["status_desc"]."'";
		$result_temp7 = mysqli_query($dbc,$query_temp7);
		 
		 while($data_temp7 = mysqli_fetch_array($result_temp7))
		{
			
		if($data_temp7 > 0)
			{
		$query_LevelA7 = "UPDATE dlv_dikanban_generate SET status_kanban = '".$rst_sta7["status_desc"]."', status_DO = '".$status_baru_DO."' WHERE id = '".sql_esc($data_all["id_DI"])."' AND DI_doc = '".sql_esc($buid2)."' ";
		$result_LevelA7 = mysqli_query($dbc,$query_LevelA7);	
				
			}else{
				
	    $query_LevelA7 = "UPDATE dlv_dikanban_generate SET status_DO = '".$status_baru_DO."' WHERE id = '".sql_esc($data_all["id_DI"])."' AND DI_doc = '".sql_esc($buid2)."' ";
		$result_LevelA7 = mysqli_query($dbc,$query_LevelA7);		
				
			}
		
		}*/
		// ---------update dlv_dikanban_upload--------------------------
	 
		
		
		//----get info dlv_ord_dikanban_temp---- /
		
		$query_temp = "SELECT * FROM dlv_ord_dikanban_temp WHERE DI_doc = '".sql_esc($buid2)."' AND do_no = '".sql_esc($uid2)."'";
		$result_temp = mysqli_query($dbc,$query_temp);
	  
	    while($data_temp  = mysqli_fetch_array($result_temp))
		{
			if($data_temp > 0)
			{
	   //--------- dlv_ord_dikanban_temp update ------------
		$query_upd_rekod = "UPDATE dlv_ord_dikanban_temp SET std_package = '".sql_esc($string3[$i])."', qty_dlv = '".sql_esc($string[$i])."', supp_part_no = '".sql_esc($string4[$i])."' WHERE DI_doc = '".sql_esc($buid2)."' AND do_no = '".sql_esc($uid2)."'";
		$result_upd_rekod = mysqli_query($dbc,$query_upd_rekod);  
		
			}else{
				
		 $query_generate_temp = "INSERT INTO dlv_ord_dikanban_temp(id,id_DI,id_gen,DI_doc,back_no,vc_code,date_issue,po_no,date_dlv,time_dlv,material_no,material_desc,work_center,usage_kanban,std_package,std_ups_package,kanban_order,qty_dlv,qty_pending,tbox_kanban,model_cd,uom_dlv,shift_dlv,user_posting,date_posting,time_posting,create_by,date_create,update_by,date_update,status_kanban,plant_code,upload_id,file_name,mth_plan,yr_plan,status_DO,do_no,user_posting_do,date_posting_do,time_posting_do,ref_DI_doc,user_cancel,date_cancel,remark_cancel,DI_dlv_date,DI_dlv_time,supp_do,supp_part_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($data_all["id"])."','".sql_esc($data_all["id_gen"])."','".sql_esc($data_all["DI_doc"])."','".sql_esc($data_all["back_no"])."','".sql_esc($data_all["vc_code"])."','".sql_esc($data_all["date_issue"])."','".sql_esc($data_all["po_no"])."','".sql_esc($data_all["date_dlv"])."','".sql_esc($data_all["time_dlv"])."','".sql_esc($data_all["material_no"])."','".sql_esc($data_all["material_desc"])."','".sql_esc($data_all["work_center"])."','".sql_esc($data_all["usage_kanban"])."','".sql_esc($data_all["std_package"])."','".sql_esc($data_all["std_ups_package"])."','".sql_esc($data_all["kanban_order"])."','".sql_esc($data_all["qty_dlv"])."','".sql_esc($data_all["qty_pending"])."','".sql_esc($data_all["tbox_kanban"])."','".sql_esc($data_all["model_cd"])."','".sql_esc($data_all["uom_dlv"])."','".sql_esc($data_all["shift_dlv"])."','".sql_esc($data_all["user_posting"])."','".sql_esc($data_all["date_posting"])."','".sql_esc($data_all["time_posting"])."','".sql_esc($data_all["create_by"])."','".sql_esc($data_all["date_create"])."','".sql_esc($data_all["update_by"])."','".sql_esc($data_all["date_update"])."','".sql_esc($data_all["status_kanban"])."','".sql_esc($data_all["plant_code"])."','".sql_esc($data_all["upload_id"])."','".sql_esc($data_all["file_name"])."','".sql_esc($data_all["mth_plan"])."','".sql_esc($data_all["yr_plan"])."','".sql_esc($data_all["status_DO"])."','".sql_esc($data_all["do_no"])."','".sql_esc($data_all["user_posting_do"])."','".sql_esc($data_all["date_posting_do"])."','".sql_esc($data_all["time_posting_do"])."','".sql_esc($data_all["ref_DI_doc"])."','".sql_esc($data_all["user_cancel"])."','".sql_esc($data_all["date_cancel"])."','".sql_esc($data_all["remark_cancel"])."','".sql_esc($data_all["DI_dlv_date"])."','".sql_esc($data_all["DI_dlv_time"])."','".sql_esc($data_all["supp_do"])."','".sql_esc($data_all["supp_part_no"])."','".sql_esc($data_all["SAP_ref_doc"])."','".sql_esc($data_all["SAP_ref_doc_can"])."')";
		$result_generate_temp = mysqli_query($dbc,$query_generate_temp);		
			}
			
			
		}//end while loop
	
		
		//update table print tag DO
		$query_all2 = "SELECT * FROM dlv_ord_dikanban_generate WHERE id = '".sql_esc($trc_id[$i])."' AND DI_doc = '".sql_esc($buid2)."' AND do_no = '".sql_esc($uid2)."'";
		$result_all2 = mysqli_query($dbc,$query_all2);
		$data_all2 = mysqli_fetch_array($result_all2);
		
		$dl_qty = (intval($data_all2["qty_dlv"]));
		
		if($dl_qty > 0 )
		{
		//---- size dim table_material_itsb --------------
		$query_pack2 = "SELECT std_packaging, type_package, size_dim FROM table_material_itsb WHERE material_no = '".sql_esc($data_all2["material_no"])."'";
		$result_pack2 = mysqli_query($dbc,$query_pack2);
		$data_pack2 = mysqli_fetch_array($result_pack2);

		//----detail standard packaging [ambil dari table mat_master_header]
	
		
		$query_pack = "SELECT * FROM dlv_ord_dikanban_generate WHERE id = '".sql_esc($trc_id[$i])."' AND do_no = '".sql_esc($uid2)."' AND material_no = '".sql_esc($data_all2["material_no"])."'";
		$result_pack = mysqli_query($dbc,$query_pack);
		$data_pack = mysqli_fetch_array($result_pack);
		
		
		
		       if(($data_pack["std_ups_package"] == "") || ($data_pack["std_ups_package"] == "0"))
		        {
		
		        $st_pack = (intval($data_all2["qty_dlv"]));
	            
				}elseif(($data_pack["std_package"] == "") && ($data_pack["std_ups_package"] == ""))
		        {
		
		        $st_pack = (intval($data_all2["qty_dlv"]));
	            
				}else{
		
                $st_pack = (intval($data_pack["std_package"]));
				
		        }
				
		
	    $no_tg = "";
		
	    $bil_tag = (($dl_qty)/($st_pack));
		
		$b =  intval($bil_tag);  // genapkan value yg dibahagikan utk didarabkan 
		// $b = round($bil_tag, 0, PHP_ROUND_HALF_DOWN);  // genapkan value yg dibahagikan utk didarabkan 
		$last_tag = ($bil_tag - $b);	   // sekiranya masih ada baki utk keluarkn delivery tag yg last
		
		$bil_tag2 = ($st_pack * $b);
		
		if($dl_qty < ($st_pack))
		{
			$bil_tag3A = ($dl_qty);
		}else{
			$bil_tag3A =  ($dl_qty - $bil_tag2);  //quantity delivery tag yg last
		}
		
		if($b == 1)
		{
			$no_tg = 1;
		}
		elseif($last_tag == 0)
		{
			$no_tg = $b;
					
		}else
		{
			$no_tg = ($b + 1);
		}
		
		$w = 1;
		   
		for($m=1; $m <= $bil_tag; $m++)
		{ 
			$bil_tag_newA = (($dl_qty)/($st_pack));
           
		    if(($bil_tag_newA > '1.000') && ($bil_tag_newA < '1.999'))
		   {
			   
			$query_tag3B = "INSERT INTO print_tag_do_dikanban(id_tag,tag_no,id_do,do_no,DI_doc,back_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_DO,yr_gr,slip_no,total_slip,date_dlv,time_dlv,supp_do,supp_part_no) VALUES('','','".sql_esc($data_all2["id"])."','".sql_esc($data_all2["do_no"])."','".sql_esc($data_all2["DI_doc"])."','".sql_esc($data_all2["back_no"])."','".sql_esc($data_all2["plant_code"])."','".sql_esc($data_all2["po_no"])."','".sql_esc($data_all2["vc_code"])."','','".sql_esc($data_all2["material_no"])."','".sql_esc($data_all2["material_desc"])."','".sql_esc($data_pack2["size_dim"])."','".sql_esc($data_all2["model_cd"])."','".sql_esc($data_all2["uom_dlv"])."','".sql_esc($st_pack)."','".sql_esc($data_all2["shift_dlv"])."','','','".sql_esc($data_all2["user_posting"])."','".sql_esc($data_all2["date_posting"])."','".sql_esc($data_all2["time_posting"])."','".strtoupper($username)."',NOW(),'Y','N','".sql_esc($data_all2["status_DO"])."',NOW(),'".sql_esc($w)."','2','".sql_esc($data_all2["DI_dlv_date"])."','".sql_esc($data_all2["DI_dlv_time"])."','".sql_esc($data_all2["supp_do"])."','".sql_esc($data_all2["supp_part_no"])."')";
			$result_tag3B = mysqli_query($dbc,$query_tag3B);
			
			$tag_no3B = ($data_all2["do_no"].'/'.$w.'/'.$data_pack["std_package"].'/'.$no_tg);
			
			
			$query_tag3_t = "UPDATE print_tag_do_dikanban SET tag_no = '".sql_esc($tag_no3B)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND do_no = '".sql_esc($uid2)."'";
			$result_tag3_t = mysqli_query($dbc,$query_tag3_t);
			   
			   
		    }else{


		
			$query_tag3B = "INSERT INTO print_tag_do_dikanban(id_tag,tag_no,id_do,do_no,DI_doc,back_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_DO,yr_gr,slip_no,total_slip,date_dlv,time_dlv,supp_do,supp_part_no) VALUES('','','".sql_esc($data_all2["id"])."','".sql_esc($data_all2["do_no"])."','".sql_esc($data_all2["DI_doc"])."','".sql_esc($data_all2["back_no"])."','".sql_esc($data_all2["plant_code"])."','".sql_esc($data_all2["po_no"])."','".sql_esc($data_all2["vc_code"])."','','".sql_esc($data_all2["material_no"])."','".sql_esc($data_all2["material_desc"])."','".sql_esc($data_pack2["size_dim"])."','".sql_esc($data_all2["model_cd"])."','".sql_esc($data_all2["uom_dlv"])."','".sql_esc($st_pack)."','".sql_esc($data_all2["shift_dlv"])."','','','".sql_esc($data_all2["user_posting"])."','".sql_esc($data_all2["date_posting"])."','".sql_esc($data_all2["time_posting"])."','".strtoupper($username)."',NOW(),'Y','N','".sql_esc($data_all2["status_DO"])."',NOW(),'".sql_esc($w)."','".sql_esc($no_tg)."','".sql_esc($data_all2["DI_dlv_date"])."','".sql_esc($data_all2["DI_dlv_time"])."','".sql_esc($data_all2["supp_do"])."','".sql_esc($data_all2["supp_part_no"])."')";
			$result_tag3B = mysqli_query($dbc,$query_tag3B);
			
			$tag_no3B = ($data_all2["do_no"].'/'.$w.'/'.$data_pack["std_package"].'/'.$no_tg);
			
			
			$query_tag3_t = "UPDATE print_tag_do_dikanban SET tag_no = '".sql_esc($tag_no3B)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND do_no = '".sql_esc($uid2)."'";
			$result_tag3_t = mysqli_query($dbc,$query_tag3_t);
			
			
			}
			
			$w++; 
			
		} // end for loop
		
		if(($last_tag > 0.000) || ($dl_qty < ($st_pack)))// kalau qty lebih kecil drpd std packaging and baki drpd bahagi tag
		{	
		
		$bil_tag_new = (($dl_qty)/($st_pack));
		
		
		   if(($bil_tag_new > '1.000') && ($bil_tag_new < '1.999'))
		   {
			  
			$query_tag2 = "INSERT INTO print_tag_do_dikanban(id_tag,tag_no,id_do,do_no,DI_doc,back_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_DO,yr_gr,slip_no,total_slip,date_dlv,time_dlv,supp_do,supp_part_no) VALUES('','','".sql_esc($data_all2["id"])."','".sql_esc($data_all2["do_no"])."','".sql_esc($data_all2["DI_doc"])."','".sql_esc($data_all2["back_no"])."','".sql_esc($data_all2["plant_code"])."','".sql_esc($data_all2["po_no"])."','".sql_esc($data_all2["vc_code"])."','','".sql_esc($data_all2["material_no"])."','".sql_esc($data_all2["material_desc"])."','".sql_esc($data_pack2["size_dim"])."','".sql_esc($data_all2["model_cd"])."','".sql_esc($data_all2["uom_dlv"])."','".sql_esc($bil_tag3A)."','".sql_esc($data_all2["shift_dlv"])."','','','".sql_esc($data_all2["user_posting"])."','".sql_esc($data_all2["date_posting"])."','".sql_esc($data_all2["time_posting"])."','".strtoupper($username)."',NOW(),'Y','N','".sql_esc($data_all2["status_DO"])."',NOW(),'".sql_esc($w)."','2','".sql_esc($data_all2["DI_dlv_date"])."','".sql_esc($data_all2["DI_dlv_time"])."','".sql_esc($data_all2["supp_do"])."','".sql_esc($data_all2["supp_part_no"])."')"; 
			$result_tag2 = mysqli_query($dbc,$query_tag2);
			
			
			$tag_no2 = ($data_all2["do_no"].'/'.$w.'/'.$bil_tag3A.'/'.($b + 1));  
			
			$query_tag2_t = "UPDATE print_tag_do_dikanban SET tag_no = '".sql_esc($tag_no2)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND do_no = '".sql_esc($uid2)."'";
			$result_tag2_t = mysqli_query($dbc,$query_tag2_t); 
			   
			   
		   }else{
			   
		
			$query_tag2 = "INSERT INTO print_tag_do_dikanban(id_tag,tag_no,id_do,do_no,DI_doc,back_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_DO,yr_gr,slip_no,total_slip,date_dlv,time_dlv,supp_do,supp_part_no) VALUES('','','".sql_esc($data_all2["id"])."','".sql_esc($data_all2["do_no"])."','".sql_esc($data_all2["DI_doc"])."','".sql_esc($data_all2["back_no"])."','".sql_esc($data_all2["plant_code"])."','".sql_esc($data_all2["po_no"])."','".sql_esc($data_all2["vc_code"])."','','".sql_esc($data_all2["material_no"])."','".sql_esc($data_all2["material_desc"])."','".sql_esc($data_pack2["size_dim"])."','".sql_esc($data_all2["model_cd"])."','".sql_esc($data_all2["uom_dlv"])."','".sql_esc($bil_tag3A)."','".sql_esc($data_all2["shift_dlv"])."','','','".sql_esc($data_all2["user_posting"])."','".sql_esc($data_all2["date_posting"])."','".sql_esc($data_all2["time_posting"])."','".strtoupper($username)."',NOW(),'Y','N','".sql_esc($data_all2["status_DO"])."',NOW(),'".sql_esc($w)."','".sql_esc($no_tg)."','".sql_esc($data_all2["DI_dlv_date"])."','".sql_esc($data_all2["DI_dlv_time"])."','".sql_esc($data_all2["supp_do"])."','".sql_esc($data_all2["supp_part_no"])."')"; 
			$result_tag2 = mysqli_query($dbc,$query_tag2);
			
			
			$tag_no2 = ($data_all2["do_no"].'/'.$w.'/'.$bil_tag3A.'/'.($b + 1));  
			
			$query_tag2_t = "UPDATE print_tag_do_dikanban SET tag_no = '".sql_esc($tag_no2)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND do_no = '".sql_esc($uid2)."'";
			$result_tag2_t = mysqli_query($dbc,$query_tag2_t);
			
			
		   }
	   
		 }// end if
		
		
		}//end $dl_qty
   
   
	}  //end forloop
	  
		   echo "<script>";
		   echo "alert('Delivery Order $uid2 has been updated.');";
		   echo "window.location='display_mtndo-dikanbanProc2.php?vendor_code=$vendor_code&&date1=$dateF&&date2=$dateT'";
	       echo "</script>"; 
		   exit(); //quit the script
	

   }// end submit
   
   
 ?>
  
     
      <?php
	 
	 $query_bb = "SELECT *, DATE_FORMAT(date_issue,'%d-%m-%Y') AS T4, DATE_FORMAT(DI_dlv_date,'%d-%m-%Y') AS T3 from dlv_ord_dikanban_generate WHERE DI_doc = '".sql_esc($buid2)."'  AND do_no = '".sql_esc($uid2)."'  ";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);
	 
	 
	 //-----get cvendor  ----
	 
	 $query_vend = new PreparedSql("SELECT * FROM vendor_detail WHERE vendor_code = ?", [$data_bb["vc_code"]]);
	 $result_vend = db_query($dbc, $query_vend) or die (mysqli_error());
	 $data_vend = mysqli_fetch_array($result_vend);
	 
	  //-----get model  ----
	 
	 $query_model = new PreparedSql("SELECT * FROM model_detail WHERE model_code = ?", [$data_bb["model_cd"]]);
	 $result_model = db_query($dbc, $query_model);
	 $data_model = mysqli_fetch_array($result_model);
	 
	 ?>
        
   <form name="frmSearch" id="frmSearch" method="post" action="" class="needs-validation"  novalidate>      
   <table width="98%" border="0" cellspacing="2" cellpadding="0" class="table-borderless">
  <tr>
    <td width="56%"><img src="../set_upload/<?php echo $filename; ?>" width="350" height="40"/> </td>     
    <td width="1%">&nbsp;</td>
    <td width="43%" valign="top">&nbsp;<h5><font color="#999999"><b>DELIVERY ORDER</b></font></h5></td>
  </tr>
  <tr>
    <td rowspan="5"><p><b>INGRESS AOI TECHNOLOGIES SDN. BHD. (1346911-U)</b></p>
    Lot 40481, Seksyen 20,<br> Mukim Bandar Serendah,<br>
    Hulu Selangor,<br> 48200 Selangor.<br>
    <p>Tel : 03-6028 3003<br>Fax: 03-6028 3004</p>
    
    </td>
    <td>&nbsp;</td>
    <td>
    <table width="450" >
     <tr>
    <td width="194"><b>Delivery Order No. </b></td>
    <td width="12">:</td>
    <td width="228"><?php echo $uid2;   ?></td>
  </tr>
  <tr>
    <td width="194"><b>Delivery Instruction No. </b></td>
    <td width="12">:</td>
    <td width="228"><?php echo $buid2;   ?></td>
  </tr>
  <tr>
    <td><b>Purchase Order No. </b></td>
    <td>:</td>
    <td><?php echo html_esc($data_bb["po_no"]);   ?></td>
  </tr>
  <tr>
    <td><b>Model </b></td>
    <td>:</td>
    <td><?php echo html_esc($data_bb["model_cd"]);   ?></td>
  </tr>
  <tr>
    <td><b>Vendor Name </b></td>
    <td>:</td>
    <td><?php echo html_esc($data_vend["vendor_name"]);  ?></td>
  </tr>
   <tr>
    <td><b>Vendor DO No. </b></td>
    <td>:</td>
    <td><input name="supp_do" type="text" id="supp_do" value="<?php  if(isset($_POST['supp_do'])){ echo html_esc($_POST["supp_do"]); }else{ echo html_esc($data_bb["supp_do"]);   }?>" class="form-control form-control-sm" required/></td>
  </tr>
</table>
</td>
  </tr>
       </table>
  
   <table width="98%" border="0" cellspacing="2" cellpadding="0" class="table-borderless">
    <tr>
    <td width="56%">&nbsp;</td> 
    <td width="1%">&nbsp;</td>  
    <td width="43%">
    <table width="450" >
      <tr>
        <td width="194"><b>Delivery Date</b></td>
        <td width="12">:</td>
        <td width="228"><?php echo html_esc($data_bb["T3"]);   ?></td>
      </tr>
      <tr>
        <td width="194"><b>Delivery Time [ETD]</b></td>
        <td width="12">:</td>
        <td width="228"><?php echo html_esc($data_bb["DI_dlv_time"]);   ?></td>
      </tr>
    </table>
    </tr>
 
   </table><br>
  <?php
   
   $counterA = 1;
   $noA = 1;
   $sta_out = "";
   
$query_display = "SELECT * FROM dlv_ord_dikanban_generate WHERE DI_doc = '".sql_esc($buid2)."' AND do_no = '".sql_esc($uid2)."' " .$where_sql." ORDER BY back_no ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   ?>

 <table class="table table-hover table-bordered" id="example">
 <thead bgcolor="#eeeeee">
  <tr> 
     <th>No</th>
     <th>Back No.</th>
     <th>Part No.</th>
     <th>Part Name</th>
     <th>DI/Kanban Quantity</th>
     <th>Total Delivered Quantity</th>
     <th>Delivered Quantity</th>
     <th>Outstanding Quantity</th>
     <th>Standard Packaging</th>
     <th>UoM</th>
     <th>Vendor Part No.</th>
  </tr>
  </thead>
  <tbody>
  <?php
   
   
  $pend_qty = 0.000;  
   
   while($row2 = mysqli_fetch_array($result_display))
   {

    //---- calculation quantity delivery -------
	
	 $query_qty_deli = "SELECT * FROM dlv_ord_dikanban_generate WHERE po_no = '".sql_esc($row2["po_no"])."' AND DI_doc = '".sql_esc($buid2)."' AND material_no = '".sql_esc($row2["material_no"])."' AND status_kanban != '".sql_esc($rst_sta4["status_desc"])."' AND status_DO != '".sql_esc($rst_sta4["status_desc"])."'";
	 $result_qty_deli = mysqli_query($dbc,$query_qty_deli);
	 $num_1 = mysqli_num_rows($result_qty_deli);   //how many material are there? 
	  
	 
	   $tot_di_qty = 0.000;
	   
	   
	   while($data_qty_deli = mysqli_fetch_array($result_qty_deli)) 
	{   
		
		$tot_di_qty = $tot_di_qty + $data_qty_deli["qty_dlv"];
							
	
	}
	
	$pend_qty = ($row2["kanban_order"] - ($tot_di_qty));
  ?>
   <tr>
    <td width="60"><div align="center"><?php echo $noA; ?></div><input type="hidden" id="checkbox" name="e_tcid[]" value="<?php echo html_esc($row2["id"]); ?>" class="form-check" checked></td>
    <td width="150"><div align="center"><?php echo html_esc($row2["back_no"]); ?></div></td>
    <td width="200"><?php echo html_esc($row2["material_no"]); ?></td>
    <td width="300"><?php echo html_esc($row2["material_desc"]); ?></td>
    <td width="100"><div align="center"><?php echo html_esc($row2["kanban_order"]); ?></div></td>
    <td width="100"><div align="center"> <?php echo $tot_di_qty; ?>	</div></td> 
     <td width="100"><div align="center">
	 <input name="qty_dlv[<?php echo html_esc($row2["id"]); ?>]" type="text" id="qty_dlv" value="<?php  if(isset($_POST['qty_dlv'])){ echo html_esc($_POST["qty_dlv"][($row2["id"])]); }else{ echo intval($row2["qty_dlv"]); } ?>" class="form-control form-control-sm" required/> 
	 </div></td>
     <td width="100"><div align="center"><?php if($pend_qty > 0.000 ) { echo $pend_qty; }elseif($pend_qty == 0 ) { echo "0"; }else{   echo "(".((-1)*($pend_qty)).")";     }  ?></div> 
    <td width="100"><input name="std_packageA[<?php echo html_esc($row2["id"]); ?>]" type="text" id="std_packageA" value="<?php  if(isset($_POST['std_packageA'])){ echo html_esc($_POST["std_packageA"][($row2["id"])]); }else{ echo html_esc($row2["std_package"]); } ?>" class="form-control form-control-sm" required/> </td> 
    <td width="100"><div align="center"><?php echo html_esc($row2["uom_dlv"]); ?></div></td>
        <td width="250"><input name="supp_part_no[<?php echo html_esc($row2["id"]); ?>]" type="text" id="supp_part_no" value="<?php  if(isset($_POST['supp_part_no'])){ echo html_esc($_POST["supp_part_no"][($row2["id"])]); }else{ echo html_esc($row2["supp_part_no"]); } ?>" class="form-control form-control-sm" required/>
  </td>      

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
       <input name="uid2" type="hidden" value="<?php echo $uid2; ?>">  
       <input name="buid2" type="hidden" value="<?php echo $buid2; ?>">  
       <input name="date1" type="hidden" value="<?php echo $dateF; ?>">  
       <input name="date2" type="hidden" value="<?php echo $dateT; ?>">  
       <input name="vendor_code" type="hidden" value="<?php echo $vendor_code; ?>">    
     
      <input name="upd_btnDO" type="submit"  class="btn btn-warning btn-sm" value="UPDATE" onclick="return confirm('Are you sure to update?');"/>
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
   <!-- <script type="text/javascript">$('#sampleTable').DataTable();</script>-->
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
      <script language="javascript">
		  $(document).ready(function() {
				$('#example').DataTable( {
					"scrollX": true,
					"lengthMenu": [[ -1], [ "All"]]
				} );
		} );
	  </script>
  </body>
</html>