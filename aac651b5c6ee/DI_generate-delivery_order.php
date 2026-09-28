<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));

$drun = substr($fmt_curr_date, 0, 2);
$mrun = substr($fmt_curr_date, 3, 2);
$yrun = substr($fmt_curr_date, 8, 2);

$date_run = ($drun . $mrun . $yrun);

set_time_limit(0);

$url = "display_inbox-dikanban.php";
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
$rs_setup = mysqli_query($dbc, $query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------

$query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
$result2 = db_query($dbc, $query2) or die(mysqli_error($dbc));
$res = mysqli_fetch_array($result2);

include 'apprv_func_list.php';

//----------------------------------------------------

//CR status (New)

$sta = "SELECT * from request_status WHERE status_id = '1'";
$sta_res = mysqli_query($dbc, $sta);
$rst_sta = mysqli_fetch_array($sta_res);

//CR status (Released)
$sta2 = "SELECT * from request_status WHERE status_id = '2'";
$sta_res2 = mysqli_query($dbc, $sta2);
$rst_sta2 = mysqli_fetch_array($sta_res2);


//CR status (Approved)
$sta3 = "SELECT * from request_status WHERE status_id = '3'";
$sta_res3 = mysqli_query($dbc, $sta3);
$rst_sta3 = mysqli_fetch_array($sta_res3);

//CR status (Cancelled)
$sta4 = "SELECT * from request_status WHERE status_id = '4'";
$sta_res4 = mysqli_query($dbc, $sta4);
$rst_sta4 = mysqli_fetch_array($sta_res4);

//CR status (Rejected)
$sta5 = "SELECT * from request_status WHERE status_id = '5'";
$sta_res5 = mysqli_query($dbc, $sta5);
$rst_sta5 = mysqli_fetch_array($sta_res5);

//CR status (Draft)
$sta6 = "SELECT * from request_status WHERE status_id = '6'";
$sta_res6 = mysqli_query($dbc, $sta6);
$rst_sta6 = mysqli_fetch_array($sta_res6);

//CR status (In Progress)
$sta7 = "SELECT * from request_status WHERE status_id = '7'";
$sta_res7 = mysqli_query($dbc, $sta7);
$rst_sta7 = mysqli_fetch_array($sta_res7);

//CR status (Pending)
$sta8 = "SELECT * from request_status WHERE status_id = '8'";
$sta_res8 = mysqli_query($dbc, $sta8);
$rst_sta8 = mysqli_fetch_array($sta_res8);

//CR status (Pending Approval PPC)
$sta10 = "SELECT * from request_status WHERE status_id = '10'";
$sta_res10 = mysqli_query($dbc, $sta10);
$rst_sta10 = mysqli_fetch_array($sta_res10);

//CR status (Close)
$sta13 = "SELECT * from request_status WHERE status_id = '13'";
$sta_res13 = mysqli_query($dbc, $sta13);
$rst_sta13 = mysqli_fetch_array($sta_res13);

//CR status (Completed)
$sta14 = "SELECT * from request_status WHERE status_id = '14'";
$sta_res14 = mysqli_query($dbc, $sta14);
$rst_sta14 = mysqli_fetch_array($sta_res14);

//CR status (Pending Approve)
$sta15 = "SELECT * from request_status WHERE status_id = '15'";
$sta_res15 = mysqli_query($dbc, $sta15);
$rst_sta15 = mysqli_fetch_array($sta_res15);

//CR status (Deleted)
$sta16 = "SELECT * from request_status WHERE status_id = '16'";
$sta_res16 = mysqli_query($dbc, $sta16);
$rst_sta16 = mysqli_fetch_array($sta_res16);

//CR status (Cancel)
$sta21 = "SELECT * from request_status WHERE status_id = '21'";
$sta_res21 = mysqli_query($dbc, $sta21);
$rst_sta21 = mysqli_fetch_array($sta_res21);

//CR status (Close)
$sta22 = "SELECT * from request_status WHERE status_id = '22'";
$sta_res22 = mysqli_query($dbc, $sta22);
$rst_sta22 = mysqli_fetch_array($sta_res22);

//CR status (Transfer GRA)
$sta23 = "SELECT * from request_status WHERE status_id = '23'";
$sta_res23 = mysqli_query($dbc, $sta23);
$rst_sta23 = mysqli_fetch_array($sta_res23);

//CR status (Pending Approval QC)
$sta24 = "SELECT * from request_status WHERE status_id = '24'";
$sta_res24 = mysqli_query($dbc, $sta24);
$rst_sta24 = mysqli_fetch_array($sta_res24);

//CR status (Pending Approval COO)
$sta25 = "SELECT * from request_status WHERE status_id = '25'";
$sta_res25 = mysqli_query($dbc, $sta25);
$rst_sta25 = mysqli_fetch_array($sta_res25);

//CR status (Pending Approval Exec QC)
$sta29 = "SELECT * from request_status WHERE status_id = '29'";
$sta_res29 = mysqli_query($dbc, $sta29);
$rst_sta29 = mysqli_fetch_array($sta_res29);

//CR status (Pending Approve STM)
$sta32 = "SELECT * from request_status WHERE status_id = '32'";
$sta_res32 = mysqli_query($dbc, $sta32);
$rst_sta32 = mysqli_fetch_array($sta_res32);


//CR status (Pending Approve ASSY)
$sta34 = "SELECT * from request_status WHERE status_id = '34'";
$sta_res34 = mysqli_query($dbc, $sta34);
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>




	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

	<SCRIPT LANGUAGE="JavaScript">
		function logout() {
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
			if (i < 10) {
				i = "0" + i
			}; // add zero in front of numbers < 10
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

		.modal-dialog {
			overflow-y: initial !important
		}

		.modal-body {
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

		.pagin a:hover:not(.active) {
			background-color: #ddd;
		}

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
		input[value="+ Add Item"] {
			display: none;
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
	<?php include "top_modal_menu.php";   ?>


	<!-- Sidebar menu-->
	<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
	<?php include "left_prod_menu.php";   ?>

	<main class="app-content">

		<div class="app-title">
			<div>
				<h1><i class="fa fa-truck"></i> Delivery Instruction</h1>
				<p>Inbox</p>
			</div>
			<ul class="app-breadcrumb breadcrumb">
				<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
				<li class="breadcrumb-item">Delivery Instruction</li>
				<li class="breadcrumb-item"><a href="display_inbox-dikanban.php">Inbox</a></li>
			</ul>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="tile">
					<div class="tile-body">
						<div class="table-responsive">

							<?php
							$buid2 = base64_decode($_GET["buid"]);
							$dateF = $_GET["date1"];
							$dateT = $_GET["date2"];
							$vendor_code = $_GET["vendor_code"];

							//echo $buid;

							$extension = explode('.', $data_setup["logo_name"]);
							$filename = $data_setup["logo_comp"].'.'.$extension[1];



							//-------------- click button "Approved"-----------------------------------------------------------------------------
							if (isset($_POST["apprv_btnDO"])) { // handle the form.

								$uid2 = $_POST["uid2"];
								$dateF = $_POST["date1"];
								$dateT = $_POST["date2"];
								$vendor_code = $_POST["vendor_code"];
								$supp_do = $_POST["supp_do"];

								$date5 = $_POST["date5"];
								//----time-----------------
								$time1 = $_POST["time1"];
								$time2 = $_POST["time2"];

								//-------------------generate Delivery Instruction doc no. ---------------

								$query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '145'";
								$result_id2 = mysqli_query($dbc, $query_id2);

								if ($result_id2) {
									$nrows2 = mysqli_num_rows($result_id2);
									$row_id2 = mysqli_fetch_array($result_id2);

									$dht2 = 0000000;
									$dht_OK2 = "54";
									$dg2 = 0;

									if ($row_id2["count_max"] <= 0) {

										$lastID2 = ($row_id2["count_max"] + 1);
										$dg2 = ($dht2 + ($lastID2));
									} else {
										$lastID2 = ($row_id2["count_max"] + 1);
										$dg2 =  $lastID2;
									}
									$number2 = $dg2; // Length of running no
									$number2 = sprintf('%07d', $number2);

									$ref = ($row_id2["start_ref"].$dht_OK2.($number2));
								} // end if $result_id2

									//update count_max----------------------------------------


									$query_max_aA = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '145'";
									$result_max_aA = mysqli_query($dbc, $query_max_aA);


									//end update count_max ---------------------------------	


								$shif_p = "";

								//----get date delivery -----
								$dd_dlv = substr($date5, 0, 2);
								$mm_dlv = substr($date5, 3, 2);
								$yy_dlv = substr($date5, 6, 4);

								$dtd_dlv = ($yy_dlv.'-'.$mm_dlv.'-'.$dd_dlv);


								$time1A = sprintf('%02d', $time1);
								$time2A = sprintf('%02d', $time2);


								//----time---
								$nw_time = ($time1A.":".$time2A.":00");

								$query_LevelB = "UPDATE dlv_dikanban_generate SET update_by = '".sql_esc($username)."', date_update = NOW(), status_kanban = '".sql_esc($rst_sta7["status_desc"])."', DI_dlv_date = '".sql_esc($dtd_dlv)."', DI_dlv_time = '".sql_esc($nw_time)."', supp_do = '".sql_esc($supp_do)."' WHERE DI_doc = '".sql_esc($uid2)."'";
								$result_LevelB = mysqli_query($dbc, $query_LevelB);



								//--------- Disposal QC detail ------------

								$query_info5A = "SELECT * FROM dlv_dikanban_generate WHERE DI_doc = '".sql_esc($uid2)."'";
								$result_info5A = mysqli_query($dbc, $query_info5A);

								while ($data_info5A = mysqli_fetch_array($result_info5A)) {

									// 12.30 AM

									/* $time1 = substr($data_info5A["time_dlv"],0,2);
				 $time2 = substr($data_info5A["time_dlv"],3,2);
				 $time3 = substr($data_info5A["time_dlv"],6,2);	*/



									//---shift detail ------

									$query_sht = "SELECT * FROM shift_detail WHERE id_shift = '1'";
									$result_sht = mysqli_query($dbc, $query_sht);
									$data_sht = mysqli_fetch_array($result_sht);

									//----shift posting ----

									if (($nw_time >= $data_sht["time_start"]) && ($nw_time <= $data_sht["time_end"])) {

										$shif_p = "D/S";
									} else {

										$shif_p = "N/S";
									}

									$kanban_qty_final = intval($data_info5A["kanban_order"]);

									$query_generate = "INSERT INTO dlv_ord_dikanban_generate(id,id_DI,id_gen,DI_doc,back_no,vc_code,date_issue,po_no,date_dlv,time_dlv,material_no,material_desc,work_center,usage_kanban,std_package,std_ups_package,kanban_order,qty_dlv,qty_pending,tbox_kanban,model_cd,uom_dlv,shift_dlv,user_posting,date_posting,time_posting,create_by,date_create,update_by,date_update,status_kanban,plant_code,upload_id,file_name,mth_plan,yr_plan,status_DO,do_no,user_posting_do,date_posting_do,time_posting_do,ref_DI_doc,user_cancel,date_cancel,remark_cancel,DI_dlv_date,DI_dlv_time,supp_do,supp_part_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($data_info5A["id"])."','".sql_esc($data_info5A["id_gen"])."','".sql_esc($data_info5A["DI_doc"])."','".sql_esc($data_info5A["back_no"])."','".sql_esc($data_info5A["vc_code"])."','".sql_esc($data_info5A["date_issue"])."','".sql_esc($data_info5A["po_no"])."','".sql_esc($data_info5A["date_dlv"])."','".sql_esc($data_info5A["time_dlv"])."','".sql_esc($data_info5A["material_no"])."','".sql_esc($data_info5A["material_desc"])."','".sql_esc($data_info5A["work_center"])."','".sql_esc($data_info5A["usage_kanban"])."','".sql_esc($data_info5A["std_package"])."','".sql_esc($data_info5A["std_ups_package"])."','".sql_esc($kanban_qty_final)."','','','".sql_esc($data_info5A["tbox_kanban"])."','".sql_esc($data_info5A["model_cd"])."','".sql_esc($data_info5A["uom_dlv"])."','".sql_esc($shif_p)."','".sql_esc($username)."',NOW(),NOW(),'".sql_esc($data_info5A["create_by"])."','".sql_esc($data_info5A["date_create"])."','".sql_esc($data_info5A["update_by"])."','".sql_esc($data_info5A["date_update"])."','".sql_esc($data_info5A["status_kanban"])."','".sql_esc($data_info5A["plant_code"])."','".sql_esc($data_info5A["upload_id"])."','".sql_esc($data_info5A["file_name"])."','".sql_esc($data_info5A["mth_plan"])."','".sql_esc($data_info5A["yr_plan"])."','".sql_esc($data_info5A["status_DO"])."','".sql_esc($ref)."','".sql_esc($username)."','".sql_esc($data_info5A["date_dlv"])."','".sql_esc($data_info5A["time_dlv"])."','','','','','".sql_esc($data_info5A["DI_dlv_date"])."','".sql_esc($nw_time)."','".sql_esc($data_info5A["supp_do"])."','".sql_esc($data_info5A["supp_part_no"])."','','')";
									$result_generate = mysqli_query($dbc, $query_generate);
								
								
								} // end while loop


								$amount = "";
								$amount3 = "";
								$amount4 = "";
								$string = "";
								$string3 = "";
								$string4 = "";

								$trc_id = $_POST["e_tcid"];
								$st = count($trc_id);
								$qty_dlv = $_POST["qty_dlv"];
								$std_package = $_POST["std_packageA"];
								$supp_part_no = $_POST["supp_part_no"];
								$idd = $_POST["idd"];

								foreach ($_POST["e_tcid"] as $j => $i) {


									$amount .= (($_POST["qty_dlv"][$i]).';');
									$amount3 .=  (($_POST["std_packageA"][$i]).';');
									$amount4 .=  (($_POST["supp_part_no"][$i]).';');


									//-----checking barcode GR Tag

									$string = explode(";", ($amount));
									$string3 = explode(";", ($amount3));
									$string4 = explode(";", ($amount4));
								}

								$no_tg = "";

								for ($i = 0; $i < count($_POST["e_tcid"]); $i++) {


									//echo $trc_id[$i];  echo "- "; echo $string[$i];echo "<br>"; 

									// ---update dlv_ord_dikanban_generate ----

									$query_update_scan2 = "UPDATE dlv_ord_dikanban_generate SET std_package = '".sql_esc($string3[$i])."', qty_dlv = '".sql_esc($string[$i])."', supp_part_no = '".sql_esc($string4[$i])."' WHERE id_DI = '".sql_esc($trc_id[$i])."' AND DI_doc = '".sql_esc($uid2)."' AND do_no = '".sql_esc($ref)."'";
									$rst_update_scan2 = mysqli_query($dbc, $query_update_scan2);

									$query_all = "SELECT * FROM dlv_ord_dikanban_generate WHERE id_DI = '".sql_esc($trc_id[$i])."' AND DI_doc = '".sql_esc($uid2)."' AND do_no = '".sql_esc($ref)."' ";
									$result_all = mysqli_query($dbc, $query_all);
									$data_all = mysqli_fetch_array($result_all);

									//--------------------------------------------------------------------------------------------------------------------------	

									//-----calculate qty pending & update status DO complete or in progress or new -------
									$query_qty_deli2 = "SELECT * FROM dlv_ord_dikanban_generate WHERE po_no = '".sql_esc($data_all["po_no"])."' AND DI_doc = '".sql_esc($uid2)."' AND material_no = '".sql_esc($data_all["material_no"])."' AND status_kanban != '".sql_esc($rst_sta4["status_desc"])."' AND status_DO != '".sql_esc($rst_sta4["status_desc"])."'";
									$result_qty_deli2 = mysqli_query($dbc, $query_qty_deli2);
									$num_2 = mysqli_num_rows($result_qty_deli2);   //how many material are there? 


									$tot_di_qty2 = 0.000;
									$tot_kanb = 0.000;


									while ($data_qty_deli2 = mysqli_fetch_array($result_qty_deli2)) {

										$tot_di_qty2 = $tot_di_qty2 + $data_qty_deli2["qty_dlv"];
									}

									$tot_kanb = $tot_kanb + $data_all["kanban_order"];
									$pend_qty2 = ($data_all["kanban_order"] - ($tot_di_qty2));


									if ($tot_di_qty2 != 0.000) {

										//----completed -----
										if (($pend_qty2 < 0.000) && ($pend_qty2 != 0.000)) {

											$query_qty_DEL = "DELETE FROM dlv_ord_dikanban_generate WHERE DI_doc = '".sql_esc($uid2)."' AND do_no = '".sql_esc($ref)."'";
											$result_qty_DEL = mysqli_query($dbc, $query_qty_DEL);


											$query_LevelB_DEL = "UPDATE dlv_dikanban_generate SET update_by = '', date_update = '0000-00-00', status_kanban = '".sql_esc($rst_sta["status_desc"])."', DI_dlv_date = '', DI_dlv_time = '', supp_do = '' WHERE DI_doc = '".sql_esc($uid2)."' AND do_no = '".sql_esc($ref)."' ";
											$result_LevelB_DEL = mysqli_query($dbc, $query_LevelB_DEL);

											echo "<script>";
											echo "alert('Insufficient amount.');";
											echo "window.location='display_inbox-dikanban.php'";
											echo "</script>";
											exit(); //quit the script
										}
									}


									//echo "id".$trc_id[$i]; echo "&nbsp;&nbsp;QTY DLV"; echo $tot_di_qty2;   echo "&nbsp;&nbsp;pending Qty :"; echo $pend_qty2; echo "&nbsp;&nbsp;Total Kanban Qty :"; echo $tot_kanb; echo "<br>";

									if ($tot_di_qty2 != 0.000) {

										//----completed -----
										if (($pend_qty2 < 0.000) && ($pend_qty2 != 0.000)) {

											$status_baru_DO = $rst_sta14["status_desc"];
										} elseif ($tot_di_qty2 == $tot_kanb) {

											$status_baru_DO = $rst_sta14["status_desc"];
										} elseif ($tot_di_qty2 > $tot_kanb) {

											$status_baru_DO = $rst_sta14["status_desc"];
										} elseif (($tot_di_qty2 < $tot_kanb) && ($tot_di_qty2 != 0.000)) {

											$status_baru_DO = $rst_sta7["status_desc"];
										} elseif ($tot_di_qty2 == 0.000) {

											$status_baru_DO = $rst_sta["status_desc"];
										} else {
										}
									} else {

										$status_baru_DO = $rst_sta["status_desc"];
									}


									//------------------------------------------------------------------------------------

									$query_upd_sta = "UPDATE dlv_ord_dikanban_generate SET status_DO = '".sql_esc($status_baru_DO)."'  WHERE id_DI = '".sql_esc($trc_id[$i])."' AND DI_doc = '".sql_esc($uid2)."' ";
									$result_upd_sta = mysqli_query($dbc, $query_upd_sta);



									// ---------update dlv_dikanban_upload--------------------------

									$query_LevelA = "UPDATE dlv_dikanban_generate SET status_DO = '".sql_esc($status_baru_DO)."', supp_part_no = '".sql_esc($string4[$i])."' WHERE id = '".sql_esc($trc_id[$i])."' AND DI_doc = '".sql_esc($uid2)."' ";
									$result_LevelA = mysqli_query($dbc, $query_LevelA);


									$query_generate_temp = "INSERT INTO dlv_ord_dikanban_temp(id,id_DI,id_gen,DI_doc,back_no,vc_code,date_issue,po_no,date_dlv,time_dlv,material_no,material_desc,work_center,usage_kanban,std_package,std_ups_package,kanban_order,qty_dlv,qty_pending,tbox_kanban,model_cd,uom_dlv,shift_dlv,user_posting,date_posting,time_posting,create_by,date_create,update_by,date_update,status_kanban,plant_code,upload_id,file_name,mth_plan,yr_plan,status_DO,do_no,user_posting_do,date_posting_do,time_posting_do,ref_DI_doc,user_cancel,date_cancel,remark_cancel,DI_dlv_date,DI_dlv_time,supp_do,supp_part_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($data_all["id"])."','".sql_esc($data_all["id_gen"])."','".sql_esc($data_all["DI_doc"])."','".sql_esc($data_all["back_no"])."','".sql_esc($data_all["vc_code"])."','".sql_esc($data_all["date_issue"])."','".sql_esc($data_all["po_no"])."','".sql_esc($data_all["date_dlv"])."','".sql_esc($data_all["time_dlv"])."','".sql_esc($data_all["material_no"])."','".sql_esc($data_all["material_desc"])."','".sql_esc($data_all["work_center"])."','".sql_esc($data_all["usage_kanban"])."','".sql_esc($data_all["std_package"])."','".sql_esc($data_all["std_ups_package"])."','".sql_esc($data_all["kanban_order"])."','".sql_esc($data_all["qty_dlv"])."','".sql_esc($data_all["qty_pending"])."','".sql_esc($data_all["tbox_kanban"])."','".sql_esc($data_all["model_cd"])."','".sql_esc($data_all["uom_dlv"])."','".sql_esc($data_all["shift_dlv"])."','".sql_esc($data_all["user_posting"])."','".sql_esc($data_all["date_posting"])."','".sql_esc($data_all["time_posting"])."','".sql_esc($data_all["create_by"])."','".sql_esc($data_all["date_create"])."','".sql_esc($data_all["update_by"])."','".sql_esc($data_all["date_update"])."','".sql_esc($data_all["status_kanban"])."','".sql_esc($data_all["plant_code"])."','".sql_esc($data_all["upload_id"])."','".sql_esc($data_all["file_name"])."','".sql_esc($data_all["mth_plan"])."','".sql_esc($data_all["yr_plan"])."','".sql_esc($data_all["status_DO"])."','".sql_esc($data_all["do_no"])."','".sql_esc($data_all["user_posting_do"])."','".sql_esc($data_all["date_posting_do"])."','".sql_esc($data_all["time_posting_do"])."','".sql_esc($data_all["ref_DI_doc"])."','".sql_esc($data_all["user_cancel"])."','".sql_esc($data_all["date_cancel"])."','".sql_esc($data_all["remark_cancel"])."','".sql_esc($data_all["DI_dlv_date"])."','".sql_esc($data_all["DI_dlv_time"])."','". sql_esc($data_all["supp_do"])."','".sql_esc($data_all["supp_part_no"])."','".sql_esc($data_all["SAP_ref_doc"])."','".sql_esc($data_all["SAP_ref_doc_can"])."')";
									$result_generate_temp = mysqli_query($dbc, $query_generate_temp);

									//------------------------------------------------------------------------------------------------------------------------------------	
									//   azie kena repair   9 june                                ------------------------------------------------------------------------
									//------------------------------------------------------------------------------------------------------------------------------------

									//update table print tag DO
									$query_all2 = "SELECT * FROM dlv_ord_dikanban_generate WHERE id_DI = '".sql_esc($trc_id[$i])."' AND do_no = '".sql_esc($ref)."'";
									$result_all2 = mysqli_query($dbc, $query_all2);
									$data_all2 = mysqli_fetch_array($result_all2);

									$dl_qty = (intval($data_all2["qty_dlv"]));


									//---- size dim table_material_itsb --------------
									$query_pack2 = "SELECT std_packaging, type_package, size_dim FROM table_material_itsb WHERE material_no = '".sql_esc($data_all2["material_no"])."'";
									$result_pack2 = mysqli_query($dbc, $query_pack2);
									$data_pack2 = mysqli_fetch_array($result_pack2);

									//----detail standard packaging [ambil dari table mat_master_header]


									$query_pack = "SELECT * FROM dlv_ord_dikanban_generate WHERE id_DI = '".sql_esc($trc_id[$i])."' AND do_no = '".sql_esc($ref)."' AND material_no = '".sql_esc($data_all2["material_no"])."'";
									$result_pack = mysqli_query($dbc, $query_pack);
									$data_pack = mysqli_fetch_array($result_pack);



									if (($data_pack["std_ups_package"] == "") || ($data_pack["std_ups_package"] == "0")) {

										$st_pack = (intval($data_all2["qty_dlv"]));
									} elseif (($data_pack["std_package"] == "") && ($data_pack["std_ups_package"] == "")) {

										$st_pack = (intval($data_all2["qty_dlv"]));
									} else {

										$st_pack = (intval($data_pack["std_package"]));
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

											$query_tag3B = "INSERT INTO print_tag_do_dikanban_ppc(id_tag,tag_no,id_do,do_no,DI_doc,back_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_DO,yr_gr,slip_no,total_slip,date_dlv,time_dlv,supp_do,supp_part_no) VALUES('','','".sql_esc($data_all2["id"])."','".sql_esc($data_all2["do_no"])."','".sql_esc($data_all2["DI_doc"])."','".sql_esc($data_all2["back_no"])."','".sql_esc($data_all2["plant_code"])."','".sql_esc($data_all2["po_no"])."','".sql_esc($data_all2["vc_code"])."','','".sql_esc($data_all2["material_no"])."','".sql_esc($data_all2["material_desc"])."','".sql_esc($data_pack2["size_dim"])."','".sql_esc($data_all2["model_cd"])."','".sql_esc($data_all2["uom_dlv"])."','".sql_esc($st_pack)."','".sql_esc($data_all2["shift_dlv"])."','','','".sql_esc($data_all2["user_posting"])."','".sql_esc($data_all2["date_posting"])."','".sql_esc($data_all2["time_posting"])."','".strtoupper($username)."',NOW(),'Y','N','".sql_esc($data_all2["status_DO"])."',NOW(),'".sql_esc($w)."','2','".sql_esc($data_all2["DI_dlv_date"])."','".sql_esc($data_all2["DI_dlv_time"])."','".sql_esc($data_all2["supp_do"])."','".sql_esc($data_all2["supp_part_no"])."')";
											$result_tag3B = mysqli_query($dbc, $query_tag3B);

											$tag_no3B = ($data_all2["do_no"].'/'.$w.'/'.$data_pack["std_package"].'/'.$no_tg);


											$query_tag3_t = "UPDATE print_tag_do_dikanban_ppc SET tag_no = '".sql_esc($tag_no3B)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND do_no = '".sql_esc($ref)."'";
											$result_tag3_t = mysqli_query($dbc, $query_tag3_t);
										} else {







											$query_tag3B = "INSERT INTO print_tag_do_dikanban_ppc(id_tag,tag_no,id_do,do_no,DI_doc,back_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_DO,yr_gr,slip_no,total_slip,date_dlv,time_dlv,supp_do,supp_part_no) VALUES('','','".sql_esc($data_all2["id"])."','".sql_esc($data_all2["do_no"])."','".sql_esc($data_all2["DI_doc"])."','".sql_esc($data_all2["back_no"])."','".sql_esc($data_all2["plant_code"])."','".sql_esc($data_all2["po_no"])."','".sql_esc($data_all2["vc_code"])."','','".sql_esc($data_all2["material_no"])."','".sql_esc($data_all2["material_desc"])."','".sql_esc($data_pack2["size_dim"])."','".sql_esc($data_all2["model_cd"])."','".sql_esc($data_all2["uom_dlv"])."','".sql_esc($st_pack)."','".sql_esc($data_all2["shift_dlv"])."','','','".sql_esc($data_all2["user_posting"])."','".sql_esc($data_all2["date_posting"])."','".sql_esc($data_all2["time_posting"])."','".strtoupper($username)."',NOW(),'Y','N','".sql_esc($data_all2["status_DO"])."',NOW(),'".sql_esc($w)."','".sql_esc($no_tg)."','".sql_esc($data_all2["DI_dlv_date"])."','".sql_esc($data_all2["DI_dlv_time"])."','".sql_esc($data_all2["supp_do"])."','".sql_esc($data_all2["supp_part_no"])."')";
											$result_tag3B = mysqli_query($dbc, $query_tag3B);

											$tag_no3B = ($data_all2["do_no"].'/'.$w.'/'.$data_pack["std_package"].'/'.$no_tg);


											$query_tag3_t = "UPDATE print_tag_do_dikanban_ppc SET tag_no = '".sql_esc($tag_no3B)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND do_no = '".sql_esc($ref)."'";
											$result_tag3_t = mysqli_query($dbc, $query_tag3_t);
										}

										$w++;
									} // end for loop

									if (($last_tag > 0.000) || ($dl_qty < ($st_pack))) // kalau qty lebih kecil drpd std packaging and baki drpd bahagi tag
									{

										$bil_tag_new = (($dl_qty) / ($st_pack));


										if (($bil_tag_new > '1.000') && ($bil_tag_new < '1.999')) {

											$query_tag2 = "INSERT INTO print_tag_do_dikanban_ppc(id_tag,tag_no,id_do,do_no,DI_doc,back_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_DO,yr_gr,slip_no,total_slip,date_dlv,time_dlv,supp_do,supp_part_no) VALUES('','','".sql_esc($data_all2["id"])."','".sql_esc($data_all2["do_no"])."','".sql_esc($data_all2["DI_doc"])."','".sql_esc($data_all2["back_no"])."','".sql_esc($data_all2["plant_code"])."','".sql_esc($data_all2["po_no"])."','".sql_esc($data_all2["vc_code"])."','','".sql_esc($data_all2["material_no"])."','".sql_esc($data_all2["material_desc"])."','".sql_esc($data_pack2["size_dim"])."','".sql_esc($data_all2["model_cd"])."','".sql_esc($data_all2["uom_dlv"])."','".sql_esc($bil_tag3A)."','".sql_esc($data_all2["shift_dlv"])."','','','".sql_esc($data_all2["user_posting"])."','".sql_esc($data_all2["date_posting"])."','".sql_esc($data_all2["time_posting"])."','".strtoupper($username)."',NOW(),'Y','N','".sql_esc($data_all2["status_DO"])."',NOW(),'".sql_esc($w)."','2','".sql_esc($data_all2["DI_dlv_date"])."','".sql_esc($data_all2["DI_dlv_time"])."','".sql_esc($data_all2["supp_do"])."','".sql_esc($data_all2["supp_part_no"])."')";
											$result_tag2 = mysqli_query($dbc, $query_tag2);


											$tag_no2 = ($data_all2["do_no"].'/'.$w.'/'.$bil_tag3A.'/'.($b + 1));

											$query_tag2_t = "UPDATE print_tag_do_dikanban_ppc SET tag_no = '".sql_esc($tag_no2)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND do_no = '".sql_esc($ref)."'";
											$result_tag2_t = mysqli_query($dbc, $query_tag2_t);
										} else {


											$query_tag2 = "INSERT INTO print_tag_do_dikanban_ppc(id_tag,tag_no,id_do,do_no,DI_doc,back_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_DO,yr_gr,slip_no,total_slip,date_dlv,time_dlv,supp_do,supp_part_no) VALUES('','','".sql_esc($data_all2["id"])."','".sql_esc($data_all2["do_no"])."','".sql_esc($data_all2["DI_doc"])."','".sql_esc($data_all2["back_no"])."','".sql_esc($data_all2["plant_code"])."','".sql_esc($data_all2["po_no"])."','".sql_esc($data_all2["vc_code"])."','','".sql_esc($data_all2["material_no"])."','".sql_esc($data_all2["material_desc"])."','".sql_esc($data_pack2["size_dim"])."','".sql_esc($data_all2["model_cd"])."','".sql_esc($data_all2["uom_dlv"])."','".sql_esc($bil_tag3A)."','".sql_esc($data_all2["shift_dlv"])."','','','".sql_esc($data_all2["user_posting"])."','".sql_esc($data_all2["date_posting"])."','".sql_esc($data_all2["time_posting"])."','".strtoupper($username)."',NOW(),'Y','N','".sql_esc($data_all2["status_DO"])."',NOW(),'".sql_esc($w)."','".sql_esc($no_tg)."','".sql_esc($data_all2["DI_dlv_date"])."','".sql_esc($data_all2["DI_dlv_time"])."','".sql_esc($data_all2["supp_do"])."','".sql_esc($data_all2["supp_part_no"])."')";
											$result_tag2 = mysqli_query($dbc, $query_tag2);


											$tag_no2 = ($data_all2["do_no"].'/'.$w.'/'.$bil_tag3A.'/'.($b + 1));

											$query_tag2_t = "UPDATE print_tag_do_dikanban_ppc SET tag_no = '".sql_esc($tag_no2)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND do_no = '".sql_esc($ref)."'";
											$result_tag2_t = mysqli_query($dbc, $query_tag2_t);
										}
									} // end if





								}  //end forloop



								//------- check status DO[all] = "complete"----------

								$query_gen_kanban = "SELECT * FROM dlv_dikanban_generate WHERE DI_doc = '".sql_esc($uid2)."' AND status_DO != '".sql_esc($rst_sta14["status_desc"])."' ";
								$result_gen_kanban = mysqli_query($dbc, $query_gen_kanban);
								$data_gen_kanban = mysqli_fetch_array($result_gen_kanban);

								if ($data_gen_kanban > 0) {
									
								}else{

									$query_upd = "UPDATE dlv_dikanban_generate SET status_kanban = '".sql_esc($rst_sta13["status_desc"])."' WHERE DI_doc = '".sql_esc($uid2)."' ";
									$result_upd = mysqli_query($dbc, $query_upd);
								}



									//update count_max----------------------------------------

                                  /* 
									$query_max_aA = "UPDATE run_count_itsb SET count_max = '".$number2."', date_updated = NOW() WHERE uid = '145'";
									$result_max_aA = mysqli_query($dbc, $query_max_aA); */
          

									//end update count_max ---------------------------------	
									

								$ref2 = base64_encode($ref);
								$ref3 = base64_encode($uid2);

								echo "<script>";
								echo "alert('Delivery Order No. $ref.');";
								echo "window.open('detail_print_DO-dikanban-tag.php?uid2=$ref2&&uid3=$ref3');";
								echo "window.location='display_inbox-dikanbanProc2.php?vendor_code=$vendor_code&&date1=$dateF&&date2=$dateT'";
								echo "</script>";
								exit(); //quit the script


							} // end submit


							?>


							<?php

							$query_bb = "SELECT *, DATE_FORMAT(date_issue,'%d-%m-%Y') AS T4, DATE_FORMAT(date_dlv,'%d-%m-%Y') AS T3 from dlv_dikanban_generate WHERE DI_doc = '".sql_esc($buid2)."' ";
							$rs_bb = mysqli_query($dbc, $query_bb);   //run the query.
							$data_bb = mysqli_fetch_array($rs_bb);


							//-----get cvendor  ----

							$query_vend = new PreparedSql("SELECT * FROM vendor_detail WHERE vendor_code = ?", [$data_bb["vc_code"]]);
							$result_vend = db_query($dbc, $query_vend) or die(mysqli_error($dbc));
							$data_vend = mysqli_fetch_array($result_vend);

							//-----get model  ----

							$query_model = new PreparedSql("SELECT * FROM model_detail WHERE model_code = ?", [$data_bb["model_cd"]]);
							$result_model = db_query($dbc, $query_model);
							$data_model = mysqli_fetch_array($result_model);

							?>
							<form name="frmSearch" id="frmSearch" method="post" action="" class="needs-validation" novalidate>
								<table width="98%" border="0" cellspacing="2" cellpadding="0" class="table-borderless">
									<tr>
										<td width="56%"><img src="../set_upload/<?php echo $filename; ?>" width="350" height="40" /> </td>
										<td width="1%">&nbsp;</td>
										<td colspan="3" valign="top">&nbsp;<h5>
												<font color="#999999"><b>INGRESS DELIVERY INSTRUCTION ORDER</b></font>
											</h5>
										</td>
									</tr>
									<tr>
										<td rowspan="6">
											<p><b>INGRESS AOI TECHNOLOGIES SDN. BHD. (1346911-U)</b></p>
											Lot 40481, Seksyen 20,<br> Mukim Bandar Serendah,<br>
											Hulu Selangor,<br> 48200 Selangor.<br>
											<p>Tel : 03-6028 3003<br>Fax: 03-6028 3004</p>

										</td>
										<td>&nbsp;</td>

										<td colspan="3">

											<br>
											<table width="98%" border="0" cellspacing="2" cellpadding="0" class="table-borderless">
												<tr>
													<td>&nbsp;</td>
													<td>
														<div align="left"><b>Delivery Instruction No. : </b><?php echo $buid2;   ?></div>
													</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td>
														<div align="left"><b>Purchase Order No. : </b><?php echo html_esc($data_bb["po_no"]);   ?></div>
													</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td>
														<div align="left"><b>Vendor Name : </b><?php echo html_esc($data_vend["vendor_name"]);  ?></div>
													</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td>
														<div align="left"><b>Model : </b><?php echo html_esc($data_bb["model_cd"]);  ?></div>
													</td>
												</tr>
											</table>
											<p>&nbsp;</p>
											<table width="98%" border="0" cellspacing="2" cellpadding="0" class="table-borderless">
												<tr>
													<td width="44%">DI Kanban Date :</td>
													<td colspan="3"><?php echo html_esc($data_bb["T3"]); ?>
													</td>
												</tr>
												<tr>
													<td width="44%">DI Kanban Time :<br> <br></td>
													<td colspan="3"><?php echo html_esc($data_bb["time_dlv"]);  ?> <br> <br>
												</tr>
												<tr>
													<td width="44%">Delivery Date :</td>
													<td colspan="3"> <input class="form-control" id="PSS5Date" type="text" placeholder="Select Date" name="date5" value="<?php if (isset($_POST['date5'])) {
																																												echo html_esc($_POST['date5']);
																																											} else {
																																												echo $fmt_curr_date;
																																											} ?>" required />
													</td>
												</tr>
												<tr>
													<td>Delivery Time [ETD] : </td>
													<td width="30%"><select name="time1" id="time1" class="form-control form-control-sm timepicker" required>
															<?php

															if ($_POST["apprv_btnDO"] == true) {
															?>
																<option value="<?php echo html_esc($_POST["time1"]); ?>"><?php echo sprintf('%02d', $_POST["time1"]);	 ?></option>
															<?php
															} else {


															?>
																<option value="<?php echo sprintf('%02d', date('H'));	 ?>" placeholder="HOURS"><?php echo sprintf('%02d', date('H'));	 ?></option>
															<?php
															}

															for ($i2 = 0; $i2 <= 23; $i2++) : ?>
																<option value="<?= $i2; ?>"> <?php echo sprintf('%02d', $i2); ?></option>
															<?php endfor; ?>
														</select>

													</td>
													<td> : </td>
													<td width="26%"><select name="time2" id="time2" class="form-control form-control-sm" required>
															<?php if ($_POST["apprv_btnDO"] == true) {
															?>
																<option value="<?php echo html_esc($_POST["time2"]); ?>"><?php echo sprintf('%02d', $_POST["time2"]);	 ?></option>
															<?php
															} else {
															?>
																<option value="<?php echo sprintf('%02d', date('i'));	 ?>" placeholder="MINUTES"><?php echo sprintf('%02d', date('i'));	 ?></option>
															<?php
															}
															for ($j = 0; $j <= 59; $j++) : ?>
																<option value="<?= $j; ?>"> <?php echo sprintf('%02d', $j); ?></option>
															<?php endfor; ?>
														</select></td>

												</tr>
												<tr>
													<td>Vendor DO No. :</td>
													<td colspan="3"><input name="supp_do" type="text" id="supp_do" value="<?php if (isset($_POST['supp_do'])) {	echo html_esc($_POST["supp_do"]);	} ?>" class="form-control form-control-sm" required />
													</td>
												</tr>
											</table>

											<p><br>
												<br>
											</p>
										</td>
									</tr>
								</table>
								<br>


								<?php

								$counterA = 1;
								$noA = 1;
								$sta_out = "";

								$query_display = "SELECT * FROM dlv_dikanban_generate WHERE DI_doc = '".sql_esc($buid2)."'  " .$where_sql. " ORDER BY back_no ASC ";
								$result_display = mysqli_query($dbc, $query_display);   //run the query.
								?>


								<table class="table table-hover table-bordered" id="example">
									<thead bgcolor="#eeeeee">
										<tr>
											<th>&nbsp;</th>
											<th>No</th>
											<th>Back No.</th>
											<th>Part No.</th>
											<th>Part Name</th>
											<th>DI/Kanban Quantity</th>
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

										while ($row2 = mysqli_fetch_array($result_display)) {

											//---- calculation quantity delivery -------

											$query_qty_deli = "SELECT * FROM dlv_ord_dikanban_generate WHERE po_no = '".sql_esc($row2["po_no"])."' AND DI_doc = '".sql_esc($row2["DI_doc"])."' AND material_no = '".sql_esc($row2["material_no"])."' AND status_DO != '".sql_esc($rst_sta4["status_desc"])."' AND status_kanban != '".sql_esc($rst_sta4["status_desc"])."'";
											$result_qty_deli = mysqli_query($dbc, $query_qty_deli);
											$num_1 = mysqli_num_rows($result_qty_deli);   //how many material are there? 


											$tot_di_qty = 0.000;


											while ($data_qty_deli = mysqli_fetch_array($result_qty_deli)) {

												$tot_di_qty = $tot_di_qty + $data_qty_deli["qty_dlv"];
											}

											$pend_qty = ($row2["kanban_order"] - ($tot_di_qty));

											$msg = "<span class='badge badge-pill badge-danger'>Insufficient amount!</span>";
										?>
											<tr>

												<td width="30"><input type="checkbox" id="checkbox" name="e_tcid[]" value="<?php echo html_esc($row2["id"]); ?>" class="form-check" onChange="getNotice2('<?php echo html_esc($row2['id']) ?>',event)" checked>

													<div>
														<input type="text" value="true" id="check2[<?php echo html_esc($row2["id"]); ?>]" hidden>
													</div>

												</td>
												<td width="60">
													<div align="center"><?php echo $noA; ?></div>
												</td>
												<td width="150">
													<div align="center"><?php echo html_esc($row2["back_no"]); ?></div>
												</td>
												<td width="200"><?php echo html_esc($row2["material_no"]); ?></td>
												<td width="300"><?php echo html_esc($row2["material_desc"]); ?></td>
												<td width="100">
													<div align="center"><?php echo html_esc($row2["kanban_order"]); ?></div>
												</td>
												<td width="100">
													<div align="center"> <?php echo $tot_di_qty; ?> </div>
												</td>
												<td width="150">
													<input type="text" value="" id="check" hidden>
													<input name="qty_dlv[<?php echo html_esc($row2["id"]); ?>]" id="qty_dlv[<?php echo html_esc($row2["id"]); ?>]" type="number" onChange="getNotice('<?php echo html_esc($row2['id']); ?>',event)" value="<?php if (isset($_POST['qty_dlv'])) {
																																																									echo html_esc($_POST["qty_dlv"][($row2["id"])]);
																																																								} else {
																																																									if ($pend_qty < 0.000) {
																																																										echo "0";
																																																									} else {
																																																										echo intval($pend_qty);
																																																									}
																																																								} ?>" class="form-control form-control-sm" max="<?php echo $pend_qty; ?>" required />
													<?php if (($tot_di_qty) > $row2["kanban_order"]) { ?><div class="form-control-feedback"><?php echo $msg; ?></div><?php } ?>
												</td>
												<td width="150"><input name="std_packageA[<?php echo html_esc($row2["id"]); ?>]" type="text" id="std_packageA" value="<?php if (isset($_POST['std_packageA'])) {
																																								echo html_esc($_POST["std_packageA"][($row2["id"])]);
																																							} else {
																																								echo html_esc($row2["std_package"]);
																																							} ?>" class="form-control form-control-sm" required />
												</td>
												<td width="100">
													<div align="center"><?php echo html_esc($row2["uom_dlv"]); ?></div>
												</td>
												<td width="250"><input name="supp_part_no[<?php echo html_esc($row2["id"]); ?>]" type="text" id="supp_part_no" value="<?php if (isset($_POST['supp_part_no'])) {
																																								echo html_esc($_POST["supp_part_no"][($row2["id"])]);
																																							} else {
																																								echo html_esc($row2["supp_part_no"]);
																																							} ?>" class="form-control form-control-sm" required />
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

									<input name="uid2" type="hidden" value="<?php echo $buid2; ?>">
									<input name="date1" type="hidden" value="<?php echo $dateF; ?>">
									<input name="date2" type="hidden" value="<?php echo $dateT; ?>">
									<input name="vendor_code" type="hidden" value="<?php echo $vendor_code; ?>">

									<input name="apprv_btnDO" id="apprv_btnDO" type="submit" class="btn btn-success btn-sm" value="SUBMIT" onclick="return confirm('Are you sure to submit?');" />
									<input action="action" onclick="window.history.go(-1); return false;" class="btn btn-info btn-sm" type="submit" value="BACK" />

								</div>
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
	<script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="js/plugins/select2.min.js"></script>
	<script type="text/javascript" src="js/plugins/dropzone.js"></script>
	<script language="javascript">
		$(document).ready(function() {
			$('#example').DataTable({
				"scrollX": true,
				"lengthMenu": [
					[-1],
					["All"]
				]
			});
		});
	</script>
	<script type="text/javascript">
		$('#sl').on('click', function() {
			$('#tl').loadingBtn();
			$('#tb').loadingBtn({
				text: "Signing In"
			});
		});

		$('#el').on('click', function() {
			$('#tl').loadingBtnComplete();
			$('#tb').loadingBtnComplete({
				html: "Sign In"
			});
		});

		$('#PSSDate').datepicker({
			defaultDate: new Date(),
			format: "dd-mm-yyyy",
			autoclose: true,
			todayHighlight: true

		});


		$('#PSS2Date').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			todayHighlight: true
		});

		$('#PSS3Date').datepicker({
			defaultDate: new Date(),
			format: "dd-mm-yyyy",
			autoclose: true,
			todayHighlight: true

		});

		$('#PSS5Date').datepicker({
			defaultDate: new Date(),
			format: "dd-mm-yyyy",
			autoclose: true,
			todayHighlight: true

		});

		$('#demoSelect').select2();



		jQuery('#datetimepicker').datetimepicker({
			datepicker: false,
			format: 'H:i'

		});
	</script>
	<script>
		function getNotice(id, e) {

			document.getElementById('apprv_btnDO').disabled = true

			const queryString = window.location.search;
			const urlParams = new URLSearchParams(queryString);

			var buid = urlParams.get('buid');
			var check = $('#check').val()
			var check2 = document.getElementById('check2['+id+']').value

			console.log('check2',check2)


			$.get('checkQuantity.php?buid=' + buid + '&&id=' + id + '&&quant=' + e.target.value, function(data) {


				var result = JSON.parse(data) // convert text to array


				if (result.status == "ERROR") {
					alert('Insufficient amout. Please change the amount before submitting')
					document.getElementById('qty_dlv[' + id + ']').style.borderColor = '#ff0000'
					document.getElementById('qty_dlv[' + id + ']').focus()

					if (!check.includes('|' + id) && check2 == "true") {

						document.getElementById('check').value = check + '|' + id
					}

					console.log('check', document.getElementById('check').value)


				} else if (result.status == "SUCCESS") {
					document.getElementById('qty_dlv[' + id + ']').style.borderColor = '#e0e4e8'

					if (check.includes('|' + id)) {
						var str = document.getElementById('check').value

						var newStr = str.replace('|' + id, '')



						document.getElementById('check').value = newStr

						console.log('check', document.getElementById('check').value)
					}

				}

				if (document.getElementById('check').value == '') {
					document.getElementById('apprv_btnDO').disabled = false

				} else {
					document.getElementById('apprv_btnDO').disabled = true

				}

			})





		}

		function getNotice2(id, e) {
			// console.log("🚀 ~ file: DI_generate-delivery_order.php:1206 ~ getNotice2 ~ e", e.target.checked)

			document.getElementById('apprv_btnDO').disabled = true

			const queryString = window.location.search;
			const urlParams = new URLSearchParams(queryString);

			var buid = urlParams.get('buid');
			var check = $('#check').val()

			const checkbox = e.target.checked

			var value = document.getElementById('qty_dlv[' + id + ']').value
			console.log("🚀 ~ file: DI_generate-delivery_order.php:1211 ~ getNotice2 ~ id", id)
			console.log("🚀 ~ file: DI_generate-delivery_order.php:1211 ~ getNotice2 ~ value", value)

			if (checkbox) {

				document.getElementById('check2[' + id + ']').value = true

				$.get('checkQuantity.php?buid=' + buid + '&&id=' + id + '&&quant=' + value, function(data) {
					// console.log('result',data)

					var result = JSON.parse(data) // convert text to array

					// console.log('result', result)

					if (result.status == "ERROR") {
						alert('Insufficient amout. Please change the amount before submitting')
						document.getElementById('qty_dlv[' + id + ']').style.borderColor = '#ff0000'
						document.getElementById('qty_dlv[' + id + ']').focus()

						// check.append(id)

						// check = parseInt(check) + 1
						if (!check.includes('|' + id)) {

							document.getElementById('check').value = check + '|' + id
						}

					} else if (result.status == "SUCCESS") {
						document.getElementById('qty_dlv[' + id + ']').style.borderColor = '#e0e4e8'

						if (check.includes('|' + id)) {
							var str = document.getElementById('check').value

							var newStr = str.replace('|' + id, '')



							document.getElementById('check').value = newStr

							console.log('check', document.getElementById('check').value)
						}
					}

					if (document.getElementById('check').value == '') {
						document.getElementById('apprv_btnDO').disabled = false

					} else {
						document.getElementById('apprv_btnDO').disabled = true

					}

				})

			} else if (!checkbox) {

				document.getElementById('check2[' + id + ']').value = false


				if (check.includes('|' + id)) {
					var str = document.getElementById('check').value

					var newStr = str.replace('|' + id, '')



					document.getElementById('check').value = newStr

					console.log('check', document.getElementById('check').value)
				}

				if (document.getElementById('check').value == '') {
					document.getElementById('apprv_btnDO').disabled = false

				} else {
					document.getElementById('apprv_btnDO').disabled = true

				}
			}

		}
	</script>

</body>

</html>