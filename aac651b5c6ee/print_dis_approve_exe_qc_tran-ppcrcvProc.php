<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
$Cdate = date ("l, j F Y ");
date_default_timezone_set('Asia/Kuala_Lumpur');
set_time_limit(0);
// include 2D barcode class (search for installation path)
require_once('tcpdf_barcodes_2d.php');

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

$url = "dis_approve_exe_qc-tranProc.php";

$query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
$result2 = db_query($dbc, $query2) or die (mysqli_error());
$res = mysqli_fetch_array($result2);
include 'apprv_func_list.php';
	
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

//----disposal prod
$query_setup2 = "SELECT * FROM sys_setup_disposal WHERE id = '3' AND status_acc = 'Y'";
$rs_setup2 = mysqli_query($dbc,$query_setup2);   //run the query.
$num_setup2 = mysqli_num_rows($rs_setup2);   //how many material are there?
$data_setup2 = mysqli_fetch_array($rs_setup2);

//-----disposal prod assy
$query_setup3 = "SELECT * FROM sys_setup_disposal WHERE id = '1' AND status_acc = 'Y'";
$rs_setup3 = mysqli_query($dbc,$query_setup3);   //run the query.
$num_setup3 = mysqli_num_rows($rs_setup3);   //how many material are there?
$data_setup3 = mysqli_fetch_array($rs_setup3);

//----disposal prod stm
$query_setup4 = "SELECT * FROM sys_setup_disposal WHERE id = '2' AND status_acc = 'Y'";
$rs_setup4 = mysqli_query($dbc,$query_setup4);   //run the query.
$num_setup4 = mysqli_num_rows($rs_setup4);   //how many material are there?
$data_setup4 = mysqli_fetch_array($rs_setup4);

//----disposal qc
$query_setup5 = "SELECT * FROM sys_setup_disposal WHERE id = '5' AND status_acc = 'Y'";
$rs_setup5 = mysqli_query($dbc,$query_setup5);   //run the query.
$num_setup5 = mysqli_num_rows($rs_setup5);   //how many material are there?
$data_setup5 = mysqli_fetch_array($rs_setup5);

//----disposal ppc
$query_setup6 = "SELECT * FROM sys_setup_disposal WHERE id = '4' AND status_acc = 'Y'";
$rs_setup6 = mysqli_query($dbc,$query_setup6);   //run the query.
$num_setup6 = mysqli_num_rows($rs_setup6);   //how many material are there?
$data_setup6 = mysqli_fetch_array($rs_setup6);

//----------------------------------------------------	

$extension = explode ('.', $data_setup["logo_name"]);
$filename = $data_setup["logo_comp"].'.'.$extension[1];

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

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);

//CR status (Pending Approval Exec. QC)
$sta29 = "SELECT * from request_status WHERE status_id = '29'";
$sta_res29 = mysqli_query($dbc,$sta29);
$rst_sta29 = mysqli_fetch_array($sta_res29);

$buid = base64_decode($_GET["buid"]);


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo html_esc($data_setup["tajuk_sys"]); ?> ">
    <title><?php echo html_esc($data_setup["comp_code"]); ?> : Document No <?php echo $buid; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    
     <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
<!--https://stackoverflow.com/questions/3341485/how-to-make-a-html-page-in-a4-paper-size-pages-->
<style>
/*Size : 8.27in and 11.69 inches*/


@media print{
@page{
	size: A4;
	/*margin-top: 1.0cm;*/
	/*padding-top:2.5cm;
	padding-bottom:4.5cm;*/
	margin: 2.0cm 1.5cm 2.5cm 1.5cm ;
}

body {
   display:table;
   table-layout:fixed;
   padding-top:0.5cm;
   padding-bottom:2.5cm;
   height:auto;
}

@page :first {
	/*padding-top:1.5cm;
	padding-bottom:4.5cm;*/
	
	margin: 0.5cm 1.5cm 3.0cm 1.5cm ;

}
.prt-button 
{ 
	display: none; 
	bottom: 20px;
	margin-left: 75px;
	margin-right: 50px;
}
}

@page Section1 {
size:5.8in 8.3in; 
/*margin:.10in .5in .10in .5in; 
mso-header-margin:.10in; 
mso-footer-margin:.10in; 
mso-paper-source:0;*/
}

body
{
	background-color:#FFF;
	
}
 
}
.style4 {
	font-size: 14px;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
}
.style1 {	
	font-size: 16px;
	font-weight: bold;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
}
.style10 {	
	font-size: 10px;
	color: #000000; 
	font-family: Arial, Helvetica, sans-serif;
	padding-bottom: 0.5cm;
}
.style11 {	
	font-family: Arial, Helvetica, sans-serif;
	font-size: 22px;
	color: #000000;
	font-weight: bold;
}
.style7 {	
	font-size: 11px;
	font-weight: bold;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
}
.style8 {	
	font-size: 13px;
	color: #000000; 
	font-family: Arial, Helvetica, sans-serif;
}
.style9 {	
	font-size: 26px;
	font-weight: bold;
	color: #000000; 
	font-family: Arial, Helvetica, sans-serif;
}
.style18 {	
	font-size: 14px;
	color: #000000; 
	font-family: Arial, Helvetica, sans-serif;
	text-decoration: underline;
}
.prt-button 
{ 

	bottom: 20px;
	margin-left: 75px;
	margin-right: 50px;
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

<body class="A4">

<div class=Section1>
<center>

  <?php
  
  $buid = base64_decode($_GET["buid"]);
	 
	 $query_bb = new PreparedSql("SELECT *, DATE_FORMAT(date_posting,'%d-%m-%Y') AS T3, DATE_FORMAT(date_approved,'%d-%m-%Y') AS T9, DATE_FORMAT(date_approved2,'%d-%m-%Y') AS T19, DATE_FORMAT(date_approved3,'%d-%m-%Y') AS T29, DATE_FORMAT(date_approved4,'%d-%m-%Y') AS T39 from disposal_detail_prd_all WHERE doc_dis = ? GROUP BY doc_dis", [$buid]);
	 $rs_bb = db_query($dbc, $query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);
	 
	 //---get user prepared by---
	 
	 $query_prepare = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$data_bb["user_disposal"]]);
	 $result_prepare = db_query($dbc, $query_prepare);
	 $data_prepare = mysqli_fetch_array($result_prepare);
	 
	  //---get user approved by---
	 
	 $query_appr = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$data_bb["approved_by"]]);
	 $result_appr = db_query($dbc, $query_appr);
	 $data_appr = mysqli_fetch_array($result_appr);
	 
	 //---get user approved2 by---
	 
	 $query_appr2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$data_bb["approved_by2"]]);
	 $result_appr2 = db_query($dbc, $query_appr2);
	 $data_appr2 = mysqli_fetch_array($result_appr2);
	 
	  //---get user approved3 by---
	 
	 $query_appr3 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$data_bb["approved_by3"]]);
	 $result_appr3 = db_query($dbc, $query_appr3);
	 $data_appr3 = mysqli_fetch_array($result_appr3);
	 
	 //---get user approved4 by---
	 
	 $query_appr4 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$data_bb["approved_by4"]]);
	 $result_appr4 = db_query($dbc, $query_appr4);
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
       <?php         if($data_bb["status_part"] == "PR") 
		            {   
					
					 $dept_name = "PRODUCTION";  
					
					}elseif($data_bb["status_part"] == "WS") 
		            { 
		             $dept_name = "PPC [RECEIVING]"; 
					
					}elseif($data_bb["status_part"] == "WQ") 
		            { 
		             $dept_name = "PP/LOGISTIC DELIVERY";  
					
		            }elseif($data_bb["status_part"] == "QC") 
		            { 
					  $dept_name = "PPC [QA/QC]";  
					
					}else{
				
					}
		  
		  
		    ?>
         <table width="98%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td height="100" rowspan="2"><img src="../set_upload/<?php echo $filename; ?>" width="350" height="50"/> <br></td>     
    <td rowspan="2">&nbsp;</td>
    <td>&nbsp;<table width="60%"  border="1" cellspacing="2" >
    <tr>
            <td width="18%">Doc. No. </td>
            <td width="2%">:</td>
            <td width="40%">&nbsp;</td>
          </tr>
          <tr>
            <td width="18%">Rev. No.</td>
            <td width="2%">:</td>
            <td width="40%">&nbsp;</td>
          </tr>
     </table>
    
      </td>
  </tr>
  <tr>
    <td>&nbsp;<h5><font color="#999999"><b>DISPOSAL FORM</b></font></h5>
    
    
    </td>
  </tr>
  <tr>
    <td><div align="left"><b>DEPARTMENT :  </b> <?php echo $dept_name;   ?></div></td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Document No. :  </b><?php echo $buid;   ?></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Date :  </b><?php echo html_esc($data_bb["T3"]);   ?></div></td>  
  
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
   
$query_display = new PreparedSql("SELECT * FROM disposal_detail_prd_all WHERE doc_dis = ? ORDER BY doc_dis ASC ", [$buid]);
$result_display = db_query($dbc, $query_display);   //run the query.
   ?>
<!-- <form name="frmSearch" id="frmSearch" method="post" action="" class="needs-validation"  novalidate>
--> 
<table width="98%" class="table-bordered" cellpadding="2">
 <thead bgcolor="#eeeeee">
  <tr>
     <th>No</th>
     <th>Part No.</th>
     <th>Model</th>
     <th>Quantity</th>
     <th>Unit</th>
     <th>Section/Line</th>
     <th>Location</th>
     <th>Process of Reject</th>
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

  //----get process of reject -----
  
       $query_proc = new PreparedSql("SELECT * FROM proc_reject_detail_ppc WHERE id_proc = ?", [$row2["proc_reject"]]);
	   $rst_proc = db_query($dbc, $query_proc);
       $data_proc = mysqli_fetch_array($rst_proc);
 
  //----get type of reject -----
  
       $query_type = new PreparedSql("SELECT * FROM type_reject_detail_ppc WHERE id_type = ?", [$row2["type_reject"]]);
	   $rst_type = db_query($dbc, $query_type);
       $data_type = mysqli_fetch_array($rst_type);
  
  
  //----get reason of defect ------
       $query_reason = new PreparedSql("SELECT * FROM type_defect_detail_ppc WHERE id_defect = ?", [$row2["type_defect"]]);
	   $rst_reason = db_query($dbc, $query_reason);
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
    <td width="250"><b><?php echo html_esc($row2["material_no"]); ?></b><br><?php echo html_esc($row2["material_desc"]); ?></td>
    <td><div align="center"><?php echo html_esc($row2["model_code"]); ?></div></td>
    <td><?php echo intval($qty_new); ?></td>
    <td><?php echo html_esc($row2["UOM_unit"]); ?></td>
    <td><div align="center"><?php echo html_esc($row2["work_center"]); ?></div></td>
    <td><div align="center"><?php echo html_esc($row2["ploc_prod_reject"]); ?></div></td>
    <td><?php echo html_esc($data_proc["proc_desc"]); ?></td>
    <td><?php echo html_esc($data_type["type_desc"]); ?></td>
    <td><?php echo html_esc($data_reason["defect_desc"]); ?></td>
    <td><?php echo html_esc($row2["reason_reject"]); ?></td>
    <td width="250"><?php echo html_esc($row2["remarks"]); ?></td>  
  </tr>
  
 <?php 
		  
		  $noA++;
		  $counterA++; // menambah counter
		  } 
		  
		  ?>
  </tbody>
</table>
<br><?php if($data_setup6["bil_table"] == "4")
   {  ?>
       <!-- <div align="right">-->
        <table width="98%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td>&nbsp;</td>
    <td width="60%">
               <table width="100%" class="table-bordered" cellpadding="2">
                   <tr bgcolor="#eeeeee">
                     <th width="20%"><div align="center">Prepared by</div></th>
                     <th width="20%"><div align="center">Verified by</div></th>
                     <th width="20%"><div align="center">Verified by</div></th>
                     <th width="20%"><div align="center">Approved by</div></th>
                   </tr>
                    <tr>
                     <td><div align="center"><p><b><?php  echo html_esc($data_prepare["user_fullname"]);   ?></b>
                     <br><?php echo html_esc($data_bb["T3"]);   ?></p></div></td>
                     <td><div align="center"><p><b><?php  if((($data_bb["approved_by"]) != "") && (($data_bb["status_approved"]) == $rst_sta3["status_desc"])){ echo html_esc($data_appr["user_fullname"]);  }  ?></b>
                     <br><?php if((($data_bb["approved_by"]) != "") && (($data_bb["status_approved"]) == $rst_sta3["status_desc"])) {  echo html_esc($data_bb["T9"]); } ?></p></div></td> 
                     <td><div align="center"><p><b><?php  if((($data_bb["approved_by2"]) != "") && (($data_bb["status_approved2"]) == $rst_sta3["status_desc"])) { echo html_esc($data_appr2["user_fullname"]);  }  ?></b>
                     <br><?php if((($data_bb["approved_by2"]) != "") && (($data_bb["status_approved2"]) == $rst_sta3["status_desc"])) {  echo html_esc($data_bb["T19"]); } ?></p></div></td> 
                     <td><div align="center"><p><b><?php  if((($data_bb["approved_by3"]) != "") && (($data_bb["status_approved3"]) == $rst_sta3["status_desc"])) { echo html_esc($data_appr3["user_fullname"]);  }  ?></b>
                     <br><?php if((($data_bb["approved_by3"]) != "") && (($data_bb["status_approved3"]) == $rst_sta3["status_desc"])) {  echo html_esc($data_bb["T29"]); } ?></p></div></td>
                   </tr>
                   <tr>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv["apprv_name"]); ?></div></td>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv2["apprv_name"]); ?></div></td>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv5["apprv_name"]); ?></div></td>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv6["apprv_name"]); ?></div></td>
                   </tr>
                 </table>
    
    </td>
  </tr>
</table><br><table width="98%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td><table width="98%" class="table-borderless">
                   <tr>
                     <th colspan="4"><div class="style18">COMMENT</div></th>
                   </tr>
                    <tr> 
                     <td width="15%"><b><?php echo html_esc($rst_apprv2["apprv_name2"]); ?> :</b></td>
                     <td width="25%"><?php if(($data_bb["approved_by"]) != "") {  echo html_esc($data_bb["remark_approved"]); }else{ ?>
                     _______________________________________________<?php }  ?></td>
                     <td width="15%"><b><?php echo html_esc($rst_apprv6["apprv_name2"]); ?> :</b></td>
                     <td width="25%"><?php if(($data_bb["approved_by3"]) != "") {  echo html_esc($data_bb["remark_approved3"]); }else{ ?>
                     _______________________________________________<?php }  ?>
                     </td>
                   </tr>
                    <tr> 
                     <td width="15%"><b><?php echo html_esc($rst_apprv5["apprv_name2"]); ?> :</b></td>
                     <td width="25%"><?php if(($data_bb["approved_by2"]) != "") {  echo html_esc($data_bb["remark_approved2"]); }else{ ?>
                     _______________________________________________<?php }  ?></td>
                     <td width="15%">&nbsp;</td>
                     <td width="25%">&nbsp;</td>
                   </tr>
                  </table>    </td>
  </tr>
</table><?php }  include "prod-line_dis_aprv_exe_ppcrcv_print.php";  ?>

                    
     

<!--</div>-->


</center>
</div>
<br>
<!--button print-->
<div class="prt-button">
  <button type="button" name="btn_release" id="btn_release" class="btn btn-success btn-sm" onClick="window.print()">Print this Page</button>
</div>

</body>
</html>