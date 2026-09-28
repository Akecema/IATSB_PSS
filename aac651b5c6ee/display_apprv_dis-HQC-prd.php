<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
include 'dis_apprv_auth.php'; 

date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));



                 $drun = substr($fmt_curr_date,0,2);
				 $mrun = substr($fmt_curr_date,3,2);
				 $yrun = substr($fmt_curr_date,8,2);
				 
				 $date_run = ($drun.$mrun.$yrun);

set_time_limit(0);

    $url = "dis_approve_qc-tran.php"; 
		
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

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
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

//CR status (Rejected)
$sta5 = "SELECT * from request_status WHERE status_id = '5'";
$sta_res5 = mysqli_query($dbc,$sta5);
$rst_sta5 = mysqli_fetch_array($sta_res5);

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
    <meta name="description" content="<?php echo $data_setup["tajuk_sys"]; ?>">
    <title><?php echo $data_setup["title_desc"]; ?></title>
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
  <body class="app sidebar-mini">
    <!-- Navbar-->
     <?php   include "top_modal_menu.php";   ?>
    
   
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <?php   include "left_prod_menu.php";   ?>
   
    <main class="app-content">
        <div class="app-title">
        <div>
          <h1><i class="fa fa-file-text-o"></i> QC</h1>
          <p>Disposal Approval</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">QC</li>
          <li class="breadcrumb-item"><a href="dis_approve_qc-tran.php">Disposal Approval</a></li>
        </ul>
      </div> 
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
    
      <?php
	        $buid = base64_decode($_GET["buidT"]);
	 
            $dateF = $_GET["date1"];
            $dateT = $_GET["date2"];
			$plant_code = $_GET["plant_code"];
		    $work_center = $_GET["work_center"];
	      
 
  $extension = explode('.', $data_setup["logo_name"]);
  $filename = $data_setup["logo_comp"].'.'.$extension[1];
 

	
	 //-------------- click button "Approved"-----------------------------------------------------------------------------
  if(isset($_POST["apprv_btnPRD"])) 
   { // handle the form.
   
 
   $uid2 = $_POST["uid2"];
   $plant_code = $_POST["plant_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
   $work_center = $_POST["work_center"];
   
   $remark_approved2 = mysqli_real_escape_string($dbc,$_POST["remark_approved2"]);
   
    $sta_out = substr($uid2,4,3);
	
   //--------- Disposal QC detail ------------
	 
	   $query_info5A = "SELECT * FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid2)."' AND status_disposal = '".sql_esc($rst_sta24["status_desc"])."'";
	   $result_info5A = mysqli_query($dbc,$query_info5A);
	  
	  while($data_info5A = mysqli_fetch_array($result_info5A))
	  
	  {
		  
	 // ---------update approval level 2--------------------------
	 
	$query_LevelA = "UPDATE disposal_detail_prd_all SET status_approved2 = '".sql_esc($rst_sta3["status_desc"])."', approved_by2 = '".sql_esc($username)."', date_approved2 = NOW(), remark_approved2 = '".sql_esc($remark_approved2)."', status_disposal = '".sql_esc($rst_sta3["status_desc"])."' WHERE doc_dis = '".sql_esc($uid2)."' AND status_disposal = '".sql_esc($rst_sta24["status_desc"])."'";
	$result_LevelA = mysqli_query($dbc,$query_LevelA);
	
 //-------update status disposal --------------------
	  
	   $query_infoB = "SELECT *, DATE_FORMAT(date_disposal,'%d%m%Y') AS JD FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid2)."' AND id = '".sql_esc($data_info5AA["id"])."' AND status_disposal = '".sql_esc($rst_sta3["status_desc"])."'";
	   $result_infoB = mysqli_query($dbc,$query_infoB);
	   $row_infoB = mysqli_fetch_array($result_infoB);
	  
	 // echo $row_infoB["id_disposal"];
	  
	  
	  if($sta_out == "311")
	  {
		  
	$query_cancelDis = "UPDATE disposal_detail_prd_ng SET status_approved2 = '".sql_esc($rst_sta3["status_desc"])."', approved_by2 = '".sql_esc($username)."', date_approved3 = NOW(), remark_approved2 = '".sql_esc($remark_approved2)."', status_disposal = '".sql_esc($rst_sta3["status_desc"])."' WHERE doc_dis = '".sql_esc($uid2)."'";
	$result_cancelDis = mysqli_query($dbc,$query_cancelDis); 

	  }elseif($sta_out == "321")
	  {
	$query_cancelDis = "UPDATE disposal_detail_prd_pending_confirm SET status_approved2 = '".sql_esc($rst_sta3["status_desc"])."', approved_by2 = '".sql_esc($username)."', date_approved2 = NOW(), remark_approved2 = '".sql_esc($remark_approved2)."', status_disposal = '".sql_esc($rst_sta3["status_desc"])."' WHERE doc_dis = '".sql_esc($uid2)."'";
	$result_cancelDis = mysqli_query($dbc,$query_cancelDis); 
		  
	  }elseif($sta_out == "331")
	  {
		
    $query_cancelDis = "UPDATE disposal_detail_prd_pending_confirm_hwork SET status_approved2 = '".sql_esc($rst_sta3["status_desc"])."', approved_by2 = '".sql_esc($username)."', date_approved2 = NOW(), remark_approved2 = '".sql_esc($remark_approved2)."', status_disposal = '".sql_esc($rst_sta3["status_desc"])."' WHERE doc_dis = '".sql_esc($uid2)."'";
	$result_cancelDis = mysqli_query($dbc,$query_cancelDis);   
		  
	  }elseif($sta_out == "341")
	  {
    $query_cancelDis = "UPDATE disposal_detail_prd_pending_confirm_rework SET status_approved2 = '".sql_esc($rst_sta3["status_desc"])."', approved_by2 = '".sql_esc($username)."', date_approved2 = NOW(), remark_approved2 = '".sql_esc($remark_approved2)."', status_disposal = '".sql_esc($rst_sta3["status_desc"])."' WHERE doc_dis = '".sql_esc($uid2)."'";
	$result_cancelDis = mysqli_query($dbc,$query_cancelDis);     
		  
	  }elseif($sta_out == "351")
	  {
    $query_cancelDis = "UPDATE prd_creject_detail SET status_approved2 = '".sql_esc($rst_sta3["status_desc"])."', hod_approved2 = '".sql_esc($username)."', date_approved2 = NOW(), remark_approved2 = '".sql_esc($remark_approved2)."', status_dis = '".sql_esc($rst_sta3["status_desc"])."' WHERE doc_dis = '".sql_esc($uid2)."'";
	$result_cancelDis = mysqli_query($dbc,$query_cancelDis);     
		  
	  }else{
		  
		  
	  }
   
	  } // end while loop
	  
	   //-------------sent ftp mvt_type 551 to SAP --------
	
	$qry_tftp = mysqli_query($dbc,"SELECT *, DATE_FORMAT(date_posting,'%d%m%Y') AS JD FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid2)."' AND status_disposal = '".sql_esc($rst_sta3["status_desc"])."'");
$data = "";
while($row_tftp = mysqli_fetch_array($qry_tftp)) {
	
	//echo $row_tftp["id"];
	
	
		if($row_tftp["qty_NG"] != "0.000")
	{
		$qty_nw = $row_tftp["qty_NG"];
		
	}elseif($row_tftp["qty_qc"] != "0.000")
	{
		$qty_nw = $row_tftp["qty_qc"];
	}else{
		
		
	}

   //$qty_nw2 = (intval($qty_nw));
   
   //-----Recipient ------
    $query_recipt = "SELECT * FROM user_detail WHERE username = '".sql_esc($row_tftp["user_disposal"])."'";
	$result_recipt = mysqli_query($dbc,$query_recipt);
	$row_recipt = mysqli_fetch_array($result_recipt);
   
	$query_reason = "SELECT * FROM type_defect_detail_prd WHERE id_defect = '".sql_esc($row_tftp["type_defect"])."'";
	   $rst_reason = mysqli_query($dbc,$query_reason);
       $data_reason = mysqli_fetch_array($rst_reason);
  //-----FINISH GOODS (2300)---------
  
  // Disposal Doc No.;Posting Date; Plant; Model; Part No.;Quantity; UoM; Movemwnt Type; SLoc; ID Type Reject; cost center; receiptt
  
  
  if($row_tftp["material_type"] == "Z301")	
  {
	   if($sta_out == "311")
	  {
		  
	  }else{
		  		  
	
  $data .= $row_tftp['doc_dis'].";".$row_tftp['JD'].";".$row_tftp['plant_cd'].";".$row_tftp['model_code'].";".$row_tftp['material_no'].";".$qty_nw.";".$row_tftp['UOM_unit'].";551;".$row_tftp['ploc'].";".$row_tftp['cost_center'].";".$row_tftp["user_disposal"].";".$data_reason["defect_desc"]."\r\n";
  
	  }
  
  }elseif($row_tftp["material_type"] == "Z201")
  {
	   if($sta_out == "311")
	  {
	  
	  }else{
	
	  
	 $data .= $row_tftp['doc_dis'].";".$row_tftp['JD'].";".$row_tftp['plant_cd'].";".$row_tftp['model_code'].";".$row_tftp['material_no'].";".$qty_nw.";".$row_tftp['UOM_unit'].";551;".$row_tftp['ploc'].";".$row_tftp['cost_center'].";".$row_tftp["user_disposal"].";".$data_reason["defect_desc"]."\r\n";
	 
	  }
	  
  }elseif($row_tftp["material_type"] == "Z401")
  {
	 
 
	 $data .= $row_tftp['doc_dis'].";".$row_tftp['JD'].";".$row_tftp['plant_cd'].";".$row_tftp['model_code'].";".$row_tftp['material_no'].";".$qty_nw.";".$row_tftp['UOM_unit'].";551;".$row_tftp['ploc'].";".$row_tftp['cost_center'].";".$row_tftp["user_disposal"].";".$data_reason["defect_desc"]."\r\n";
	  
  }
  else{
	  
	  $data .= $row_tftp['doc_dis'].";".$row_tftp['JD'].";".$row_tftp['plant_cd'].";".$row_tftp['model_code'].";".$row_tftp['material_no'].";".$qty_nw.";".$row_tftp['UOM_unit'].";551;".$row_tftp['ploc'].";".$row_tftp['cost_center'].";".$row_tftp["user_disposal"].";".$data_reason["defect_desc"]."\r\n";
	   
  }
   
}  //while loop
	
	
	  if($sta_out == "311")
	  {
		  
		  
	  }else{
		 
 $filen= "DP".$uid2;
//$csv_filename = $filen."_".date("YmdHis",time());

$file = "../FromPortal2/DP/".$filen.".csv";
//chmod($file, 0777);
file_put_contents($file,$data);
	 
	  }
       

 $qry_all = "SELECT *, DATE_FORMAT(date_posting,'%d%m%Y') AS JD FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid2)."' AND status_disposal = '".sql_esc($rst_sta3["status_desc"])."'";
  $result_all = mysqli_query($dbc,$qry_all);
  
  while($row_all = mysqli_fetch_array($result_all))
   {
  //----------update table ftp_disposal_detail_prd_all------------
  
  
		if($row_all["qty_NG"] != "0.000")
	{
		$qty_nwftp = $row_all["qty_NG"];
		
	}elseif($row_all["qty_qc"] != "0.000")
	{
		$qty_nwftp = $row_all["qty_qc"];
	}else{
		
		
	}

 
   
    $query_ftp_info = "INSERT INTO ftp_disposal_detail_prd_all(id,file_name,doc_dis,id_disposal,bflush_hwork,bflush_rework,bflush_pending,bflush_no,uid,plan_no,material_no,material_desc,qty_ftp,uom,status_ftp,posting_date,posting_time,user_create,date_create,plant_code,stamp_ind,status_part) VALUES('','".sql_esc($filen)."','".sql_esc($row_all['doc_dis'])."','".sql_esc($row_all["id_disposal"])."','".sql_esc($row_all["bflush_hwork"])."','".sql_esc($row_all["bflush_rework"])."','".sql_esc($row_all["bflush_pending"])."','".sql_esc($row_all["bflush_qqc_no"])."','".sql_esc($row_all["uid"])."','".sql_esc($row_all["plan_no"])."','".sql_esc($row_all["material_no"])."','".sql_esc($row_all["material_desc"])."','".sql_esc($qty_nwftp)."','".sql_esc($row_all["UOM_unit"])."','Y','".sql_esc($row_all["date_posting"])."','".sql_esc($row_all["time_posting"])."','".sql_esc($username)."',NOW(),'".sql_esc($row_all["plant_cd"])."','".sql_esc($row_all["stamp_ind"])."','".sql_esc($row_all["status_part"])."')"; 
     $rst_ftp_info = mysqli_query($dbc,$query_ftp_info);
	 
	 
   }// while loop ftp 
	  
	  
	  
       //----- check requestor----------------
	   $query_info_req = "SELECT *, DATE_FORMAT(date_disposal,'%d%m%Y') AS JD FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid2)."' AND status_disposal = '".sql_esc($rst_sta3["status_desc"])."'";
	   $result_info_req = mysqli_query($dbc,$query_info_req);
	   $row_info_req = mysqli_fetch_array($result_info_req);
	   
	   $query_user_req = "SELECT * FROM user_detail WHERE username = '".sql_esc($row_info_req["user_disposal"])."'"; 
	   $result_user_req = mysqli_query($dbc,$query_user_req);
	   $row_user_req = mysqli_fetch_array($result_user_req);
	   
	   
	   $uid2 = $_POST["uid2"];
	   $plant_code = $_POST["plant_code"];
	   $dateF = $_POST["date1"];
	   $dateT = $_POST["date2"];
	   $work_center = $_POST["work_center"];
 

		   echo "<script>";
		   echo "alert('Disposal has been approved.');";
		   echo "window.location='dis_approve_qc-tranProc.php?plant_code=$plant_code&&date1=$dateF&&date2=$dateT&&work_center=$work_center'";
	       echo "</script>"; 
		   exit(); //quit the script
	   
	
	  
	
	

   }// end submit
   
   
    //-------------- click button "Rejected"--------------------------------------------------------------------------------------
  if(isset($_POST["rejt_btnPRD"])) 
  
   { // handle the form.

 
   $uid2 = $_POST["uid2"];
   $plant_code = $_POST["plant_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
  $work_center = $_POST["work_center"];
  
   $remark_approved2 = mysqli_real_escape_string($dbc,$_POST["remark_approved2"]);
   
   $sta_out = substr($uid2,4,3);	
   
   //--------- Disposal QC detail ------------
	 
	   $query_info5AA = "SELECT * FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid2)."' AND status_disposal = '".sql_esc($rst_sta24["status_desc"])."'";
	   $result_info5AA = mysqli_query($dbc,$query_info5AA);
	  
	  while($data_info5AA = mysqli_fetch_array($result_info5AA))
	  
	  {
		  
	 // ---------update approval level 3--------------------------
	 
	$query_LevelAA = "UPDATE disposal_detail_prd_all SET status_approved2 = '".sql_esc($rst_sta5["status_desc"])."', approved_by2 = '".sql_esc($username)."', date_approved2 = NOW(), remark_approved2 = '".sql_esc($remark_approved2)."', status_disposal = '".sql_esc($rst_sta5["status_desc"])."' WHERE doc_dis = '".sql_esc($uid2)."' AND status_disposal = '".sql_esc($rst_sta24["status_desc"])."'";
	$result_LevelAA = mysqli_query($dbc,$query_LevelAA);
	
	
	  //-------update status disposal --------------------
	  
	$query_infoB = "SELECT *, DATE_FORMAT(date_disposal,'%d%m%Y') AS JD FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid2)."' AND id = '".sql_esc($data_info5AA["id"])."' AND status_disposal = '".sql_esc($rst_sta5["status_desc"])."'";
	   $result_infoB = mysqli_query($dbc,$query_infoB);
	   $row_infoB = mysqli_fetch_array($result_infoB);
	  
	 // echo $row_infoB["id_disposal"];
	  //, status_approved = '', approved_by = '', date_approved = '0000-00-00', remark_approved = ''
	  
	  
	  if($sta_out == "311")
	  {
		
	$query_cancelDis1 = "UPDATE disposal_detail_prd_ng SET doc_dis = '', doc_disposal_no = '', status_disposal = '".sql_esc($rst_sta["status_desc"])."', user_update = '".sql_esc($username)."', date_update = NOW(), status_approved = '', approved_by = '', date_approved = '0000-00-00', remark_approved = '' WHERE doc_dis = '".sql_esc($uid2)."'";
	$result_cancelDis1 = mysqli_query($dbc,$query_cancelDis1); 
		  
	  }elseif($sta_out == "321")
	  {
		  
	$query_cancelDis2 = "UPDATE disposal_detail_prd_pending_confirm SET doc_dis = '', doc_disposal_no = '', status_disposal = '".sql_esc($rst_sta["status_desc"])."', user_update = '".sql_esc($username)."', date_update = NOW(), status_approved = '', approved_by = '', date_approved = '0000-00-00', remark_approved = '' WHERE doc_dis = '".sql_esc($uid2)."'";
	$result_cancelDis2 = mysqli_query($dbc,$query_cancelDis2); 
		  
	  }elseif($sta_out == "331")
	  {
		
    $query_cancelDis3 = "UPDATE disposal_detail_prd_pending_confirm_hwork SET doc_dis = '', doc_disposal_no = '', status_disposal = '".sql_esc($rst_sta["status_desc"])."', user_update = '".sql_esc($username)."', date_update = NOW(), status_approved = '', approved_by = '', date_approved = '0000-00-00', remark_approved = '' WHERE doc_dis = '".sql_esc($uid2)."'";
	$result_cancelDis3 = mysqli_query($dbc,$query_cancelDis3); 
		  
	  }elseif($sta_out == "341")
	  {
	
	$query_cancelDis4 = "UPDATE disposal_detail_prd_pending_confirm_rework SET doc_dis = '', doc_disposal_no = '', status_disposal = '".sql_esc($rst_sta["status_desc"])."', user_update = '".sql_esc($username)."', date_update = NOW(), status_approved = '', approved_by = '', date_approved = '0000-00-00', remark_approved = '' WHERE doc_dis = '".sql_esc($uid2)."'";
	$result_cancelDis4 = mysqli_query($dbc,$query_cancelDis4);    
		  
	  }elseif($sta_out == "351")
	  {
    $query_cancelDis = "UPDATE prd_creject_detail SET status_approved2 = '".sql_esc($rst_sta5["status_desc"])."', hod_approved2 = '".sql_esc($username)."', date_approved2 = NOW(), remark_approved2 = '".sql_esc($remark_approved2)."', status_dis = '".sql_esc($rst_sta5["status_desc"])."' WHERE doc_dis = '".sql_esc($uid2)."'";
	$result_cancelDis = mysqli_query($dbc,$query_cancelDis);     
		  
	  }else{
		  
		  
	  }
	
	  }
   
		   echo "<script>";
		   echo "alert('Disposal has been rejected.');";
		   echo "window.location='dis_approve_qc-tranProc.php?plant_code=$plant_code&&date1=$dateF&&date2=$dateT&&work_center=$work_center'";
	       echo "</script>"; 
		   exit(); //quit the script
	

   }// end submit
   
   
   
   
    //-------------- click button "Rejected"--------------------------------------------------------------------------------------
  if(isset($_POST["prt_btnPRD"])) 
  
   { // handle the form.

 
   $uid2 = $_POST["uid2"];
   $plant_code = $_POST["plant_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
   $work_center = $_POST["work_center"];
   
   $remark_approved2 = $_POST["remark_approved2"]; 
   
   $uid2A = base64_encode($uid2);
   
           echo "<script>";
		   echo "window.open('print_dis_approve_qc-tranProc-prd.php?buid=$uid2A','_blank');";
		   echo "window.location='dis_approve_qc-tranProc.php?plant_code=$plant_code&&date1=$dateF&&date2=$dateT&&work_center=$work_center'"; 
		   echo "</script>"; 
		   exit(); //quit the script
   
   
   }
   
	
?>
  
     
      <?php
	 
	 $query_bb = "SELECT *,  DATE_FORMAT(date_posting,'%d-%m-%Y') AS T3, DATE_FORMAT(date_approved,'%d-%m-%Y') AS T9, DATE_FORMAT(date_approved2,'%d-%m-%Y') AS T19, DATE_FORMAT(date_approved3,'%d-%m-%Y') AS T29, DATE_FORMAT(date_approved4,'%d-%m-%Y') AS T39, DATE_FORMAT(date_approved5,'%d-%m-%Y') AS T49  from disposal_detail_prd_all WHERE doc_dis = '".sql_esc($buid)."' GROUP BY doc_dis";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);
	 
	 //---get user prepared by---
	 
	 $query_prepare = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_bb["user_disposal"])."'";
	 $result_prepare = mysqli_query($dbc,$query_prepare);
	 $data_prepare = mysqli_fetch_array($result_prepare);
	 
	  //---get user approved by---
	 
	 $query_appr5 = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_bb["approved_by5"])."'";
	 $result_appr5 = mysqli_query($dbc,$query_appr5);
	 $data_appr5 = mysqli_fetch_array($result_appr5);
	 
	  //---get user approved by---
	 
	 $query_appr = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_bb["approved_by"])."'";
	 $result_appr = mysqli_query($dbc,$query_appr);
	 $data_appr = mysqli_fetch_array($result_appr);
	 
	 //---get user approved2 by---
	 
	 $query_appr2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_bb["approved_by2"])."'";
	 $result_appr2 = mysqli_query($dbc,$query_appr2);
	 $data_appr2 = mysqli_fetch_array($result_appr2);
	 
	  //---get user approved3 by---
	 
	 $query_appr3 = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_bb["approved_by3"])."'";
	 $result_appr3 = mysqli_query($dbc,$query_appr3);
	 $data_appr3 = mysqli_fetch_array($result_appr3);
	 
	 //---get user approved4 by---
	 
	 $query_appr4 = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_bb["approved_by4"])."'";
	 $result_appr4 = mysqli_query($dbc,$query_appr4);
	 $data_appr4 = mysqli_fetch_array($result_appr4);
	 
	 //---get shift-----
	  if($data_bb["shift_posting"] == "D/S")
	  
	  {   $shft_new = "Day";
	  
	  }elseif($data_bb["shift_posting"] == "N/S")
	  {
		  $shft_new = "Night";
		  
	  }else{
		  
		  $shft_new = "None"; 
	  }
	 
	 ?>
        
        <table width="98%" border="0" cellspacing="2" cellpadding="0" class="table-borderless">
  <tr>
    <td><img src="../set_upload/<?php echo $filename; ?>" width="350" height="40"/> </td>     
    <td>&nbsp;</td>
    <td valign="top">&nbsp;<h5><font color="#999999"><b>DISPOSAL FORM</b></font></h5></td>
  </tr>
  <tr>
    <td><div align="left"><b>DEPARTMENT :  </b> PRODUCTION</div></td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Document No. :  </b><?php echo $data_bb["doc_dis"];   ?></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Date :  </b><?php echo $data_bb["T3"];   ?></div></td>  
  
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Shift :  </b><?php echo $shft_new;   ?></div></td>
  </tr>
        </table>
  <br>
 
  <?php
   
   $counterA = 1;
   $noA = 1;
   $sta_out = "";
   
$query_display = "SELECT * FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($buid)."' AND status_disposal = '".sql_esc($rst_sta24["status_desc"])."' " .$where_sql." ORDER BY doc_dis ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   ?>
 <form name="frmSearch" id="frmSearch" method="post" action="" class="needs-validation"  novalidate>
 <table width="98%" class="table-bordered">
 <thead bgcolor="#eeeeee">
  <tr>
     <th>No</th>
     <th>Part No.</th>
     <th>Model</th>
     <th>Quantity</th>
     <th>Unit</th>
     <th>Section/Line</th>
     <th>Location</th>
     <th>Process/Section</th>
     <th>Type of Reject</th>
     <th>Defectives</th>
     <th>Reasons</th> 
     <th>Remark</th>
  </tr>
  </thead>
  <tbody>
  <?php
    
   while($row2 = mysqli_fetch_array($result_display))
   {

       //----get proc of reject -----
  
       $query_proc = "SELECT * FROM proc_reject_detail_prd WHERE id_proc = '".sql_esc($row2["proc_reject"])."'";
	   $rst_proc = mysqli_query($dbc,$query_proc);
       $data_proc = mysqli_fetch_array($rst_proc); 
      
 //----get type of reject -----
  
       $query_type = "SELECT * FROM type_reject_detail_prd WHERE id_type = '".sql_esc($row2["type_reject"])."'";
	   $rst_type = mysqli_query($dbc,$query_type);
       $data_type = mysqli_fetch_array($rst_type);
  
  
  //----get reason of defect ------
       $query_reason = "SELECT * FROM type_defect_detail_prd WHERE id_defect = '".sql_esc($row2["type_defect"])."'";
	   $rst_reason = mysqli_query($dbc,$query_reason);
       $data_reason = mysqli_fetch_array($rst_reason);
	   
	   //------- quantity	
	
	if($row2["qty_NG"] != "0.000")
	{
		$qty_new = $row2["qty_NG"];
		
	}elseif($row2["qty_qc"] != "0.000")
	{
		$qty_new = $row2["qty_qc"];
	}else{
		
		
	}
  	   
  
  ?>
   <tr>
    <td><div align="center"><?php echo $noA; ?></div></td>
    <td width="250"><b><?php echo $row2["material_no"]; ?></b><br><?php echo $row2["material_desc"]; ?></td>
    <td><div align="center"><?php echo $row2["model_code"]; ?></div></td>
    <td><div align="center"><?php if( $row2["UOM_unit"] == 'KG') { ?> <?php echo $qty_new; ?> <?php }else{ ?><?php echo intval($qty_new); ?> <?php } ?></div></td>
    <td><?php echo $row2["UOM_unit"]; ?></td>
    <td><div align="center"><?php echo $row2["work_center"]; ?></div></td>
    <td><div align="center"><?php echo $row2["ploc_prod_reject"]; ?></div></td>
    <td><?php echo $data_proc["proc_desc"]; ?></td>
    <td><?php echo $data_type["type_desc"]; ?></td>
    <td><?php echo $data_reason["defect_desc"]; ?></td>
    <td><?php echo $row2["reason_reject"]; ?></td>
    <td width="250"><?php echo $row2["remarks"]; ?></td>  
  </tr>
  
 <?php 
		  
		  $noA++;
		  $counterA++; // menambah counter
		  } 
		  
		  ?>
  </tbody>
</table>

         <p>&nbsp;</p>
                <div class="modal-body pull-right">
                 <table width="50%" class="table table-bordered">
                   <tr>
                     <th width="10%"><div align="center" class="style7">Prepared by</div></th>
                      <?php if($rowAssy["status_acc"] == "Y") {  ?>
                     <th width="10%"><div align="center" class="style7">Verified by</div></th><?php } ?>
                      <?php if($rowHead["status_acc"] == "Y") {  ?>
                     <th width="10%"><div align="center" class="style7">Verified by</div></th><?php  } ?>
                     <th width="10%"><div align="center" class="style7">Verified by</div></th>
                     <th width="10%"><div align="center" class="style7">Approved by</div></th>
                   </tr>
                     <tr>
                     <td><div align="center" class="style7"><p><b><?php  echo $data_prepare["user_fullname"];   ?></b>
                     <br><?php echo $data_bb["T3"];   ?></p></div></td>
                     <td><div align="center" class="style7"><p><b><?php  if((($data_bb["approved_by5"]) != "") && (($data_bb["status_approved5"]) == $rst_sta3["status_desc"])) { echo $data_appr5["user_fullname"];  }  ?></b>
                     <br><?php if((($data_bb["approved_by5"]) != "") && (($data_bb["status_approved5"]) == $rst_sta3["status_desc"])) {  echo $data_bb["T49"]; } ?></p></div></td> 
                      <?php if($rowHead["status_acc"] == "Y") {  ?>
                      <td><div align="center" class="style7"><p><b><?php  if((($data_bb["approved_by"]) != "") && (($data_bb["status_approved"]) == $rst_sta3["status_desc"])) { echo $data_appr["user_fullname"];  }  ?></b>
                      <br><?php if((($data_bb["approved_by"]) != "") && (($data_bb["status_approved"]) == $rst_sta3["status_desc"])) {  echo $data_bb["T9"]; } ?></p></div></td> 
                     <td><div align="center" class="style7"><p><b><?php  if((($data_bb["approved_by2"]) != "") && (($data_bb["status_approved2"]) == $rst_sta3["status_desc"])) { echo $data_appr2["user_fullname"];  }  ?></b>
                     <br><?php if((($data_bb["approved_by2"]) != "") && (($data_bb["status_approved2"]) == $rst_sta3["status_desc"])) {  echo $data_bb["T19"]; } ?></p></div></td> 
                     <td><div align="center" class="style7"><p><b><?php  if((($data_bb["approved_by3"]) != "") && (($data_bb["status_approved3"]) == $rst_sta3["status_desc"])) { echo $data_appr2["user_fullname"];  }  ?></b>
                     <br><?php if((($data_bb["approved_by3"]) != "") && (($data_bb["status_approved3"]) == $rst_sta3["status_desc"])) {  echo $data_bb["T29"]; } ?></p></div></td>
                     <?php }else{ ?>
                     
                     <td><div align="center" class="style7"><p><b><?php  if((($data_bb["approved_by"]) != "") && (($data_bb["status_approved"]) == $rst_sta3["status_desc"])) { echo $data_appr["user_fullname"];  }  ?></b>
                     <br><?php if((($data_bb["approved_by"]) != "") && (($data_bb["status_approved"]) == $rst_sta3["status_desc"])) {  echo $data_bb["T9"]; } ?></p></div></td> 
                     <td><div align="center" class="style7"><p><b><?php  if((($data_bb["approved_by2"]) != "") && (($data_bb["status_approved2"]) == $rst_sta3["status_desc"])) { echo $data_appr2["user_fullname"];  }  ?></b>
                     <br><?php if((($data_bb["approved_by2"]) != "") && (($data_bb["status_approved2"]) == $rst_sta3["status_desc"])) {  echo $data_bb["T19"]; } ?></p></div></td> 
                   <?php  } ?>
                   </tr>
                   <tr>
                     <td><div align="center" class="style7"><?php echo $rst_apprv["apprv_name"]; ?></div></td>
                      <?php if($rowAssy["status_acc"] == "Y") {  ?>
                     <td><div align="center" class="style7"><?php echo $rst_apprv2["apprv_name"]; ?></div></td><?php } ?>
                     <?php if($rowHead["status_acc"] == "Y") {  ?>
                     <td><div align="center" class="style7"><?php echo $rst_apprv4["apprv_name"]; ?></div></td>
                     <td><div align="center" class="style7"><?php echo $rst_apprv5["apprv_name"]; ?></div></td>
                     <td><div align="center" class="style7"><?php echo $rst_apprv6["apprv_name"]; ?></div></td>
					 <?php }else{ ?>
                     
                     <td><div align="center" class="style7"><?php echo $rst_apprv5["apprv_name"]; ?></div></td>
                     <td><div align="center" class="style7"><?php echo $rst_apprv6["apprv_name"]; ?></div></td>
                     
                     <?php  } ?>                     
                   </tr>
                 </table></div>
             
             <br>
             
              <p>
           
             <table width="98%" border="1" cellspacing="0" cellpadding="1">
                  <tr>
                    <td><table width="98%" class="table-borderless">
                   <tr>
                     <th colspan="4"><div class="style18">COMMENT</div></th>
                   </tr>
                    <tr> 
                     <td width="20%"><div class="style7"><?php echo $rst_apprv4["apprv_name2"]; ?>:</div></td>
                     <td width="25%"><textarea name="remark_approved5" id="remark_approved5" rows="2" cols="30" readonly><?php if(($data_bb["approved_by5"]) != "") {  echo $data_bb["remark_approved5"]; } ?></textarea> </td>
                     <td width="20%">&nbsp;</td>
                     <td width="25%">&nbsp;</td>
                   </tr>
                    <tr> 
                     <td width="20%"><div class="style7"><?php echo $rst_apprv5["apprv_name2"]; ?>:</div></td>
                     <td width="25%">
                     <textarea name="remark_approved" id="remark_approved" rows="2" cols="30" readonly><?php if(($data_bb["approved_by"]) != "") {  echo $data_bb["remark_approved"]; } ?></textarea></td> 
                     <td width="20%"><div class="style7"><?php echo $rst_apprv6["apprv_name2"]; ?>:</div></td>
                     <td width="25%"><textarea name="remark_approved2" id="remark_approved2" rows="2" cols="30" autofocus><?php if(($data_bb["approved_by2"]) != "") {  echo $data_bb["remark_approved2"]; } ?></textarea> 
                     
                   </tr>
                  </table>    </td>
  </tr>
</table>
             </p>
       
                <!--  </div></div> -->
                 <!-- </div> -->
                  
      <div class="modal-footer">
      
       <input name="uid2" type="hidden" value="<?php echo $buid; ?>">    
       <input name="date1" type="hidden" value="<?php echo $dateF; ?>"> 
       <input name="date2" type="hidden" value="<?php echo $dateT; ?>"> 
       <input name="plant_code" type="hidden" value="<?php echo $plant_code; ?>">
       <input name="work_center" type="hidden" value="<?php echo $work_center; ?>">
       
       <input name="apprv_btnPRD" type="submit"  class="btn btn-success btn-sm" value="APPROVE" onclick="return confirm('Are you sure you want to approve the disposal : <?php echo $data_bb["doc_dis"]; ?> ?');"/>
      <input name="rejt_btnPRD" type="submit"  class="btn btn-danger btn-sm" value="REJECT" onclick="return confirm('Are you sure you want to reject the disposal : <?php echo $data_bb["doc_dis"]; ?> ?');" />
   
      <input name="prt_btnPRD" type="submit"  class="btn btn-warning btn-sm" value="PRINT"/>
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
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
   
  </body>
</html>